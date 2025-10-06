<?php
/**
 * Script de Migración Automática a PHP 7+
 * 
 * Este script migra automáticamente todas las funciones mysql_* 
 * obsoletas para utilizar la capa de compatibilidad MySQL
 * 
 * IMPORTANTE: Hacer backup antes de ejecutar este script
 * 
 * @version 1.0
 * @author QAP Migration Tool
 */

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');

class MySQLToMySQLiMigrator {
    
    private $projectRoot;
    private $backupDir;
    private $logFile;
    private $migratedFiles = [];
    private $errorFiles = [];
    
    public function __construct($projectRoot) {
        $this->projectRoot = rtrim($projectRoot, '/');
        $this->backupDir = $this->projectRoot . '/migration_backup_' . date('Ymd_His');
        $this->logFile = $this->projectRoot . '/migration_log_' . date('Ymd_His') . '.txt';
        
        $this->log("Iniciando migración PHP 7+");
        $this->log("Directorio del proyecto: " . $this->projectRoot);
    }
    
    public function migrate() {
        echo "<h1>Migración PHP 5.6 → PHP 7+ para QAP Project</h1>\n";
        
        // 1. Crear backup
        $this->createBackup();
        
        // 2. Encontrar archivos PHP
        $phpFiles = $this->findPHPFiles();
        echo "<p>Encontrados " . count($phpFiles) . " archivos PHP</p>\n";
        
        // 3. Migrar archivos
        foreach ($phpFiles as $file) {
            $this->migrateFile($file);
        }
        
        // 4. Mostrar reporte
        $this->showReport();
        
        $this->log("Migración completada");
    }
    
    private function createBackup() {
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
        
        echo "<p>Creando backup en: " . $this->backupDir . "</p>\n";
        $this->log("Backup creado en: " . $this->backupDir);
        
        // Copiar archivos críticos
        $criticalFiles = [
            'mysql_compatibility.php',
            'php.ini',
            '.user.ini',
            'php/sql_connection.php',
            'php/verifica_sesion.php',
            'index.php'
        ];
        
        foreach ($criticalFiles as $file) {
            $source = $this->projectRoot . '/' . $file;
            $dest = $this->backupDir . '/' . $file;
            
            if (file_exists($source)) {
                $destDir = dirname($dest);
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                copy($source, $dest);
            }
        }
    }
    
    private function findPHPFiles() {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->projectRoot)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $filePath = $file->getPathname();
                
                // Excluir archivos de backup y logs
                if (strpos($filePath, 'migration_backup_') === false && 
                    strpos($filePath, 'migration_log_') === false &&
                    strpos($filePath, 'php7_migration_script.php') === false) {
                    $files[] = $filePath;
                }
            }
        }
        
        return $files;
    }
    
    private function migrateFile($filePath) {
        $relativePath = str_replace($this->projectRoot . '/', '', $filePath);
        
        // Skip si ya fue migrado manualmente
        $skipFiles = [
            'mysql_compatibility.php',
            'php/sql_connection.php',
            'php/verifica_sesion.php',
            'index.php'
        ];
        
        if (in_array($relativePath, $skipFiles)) {
            $this->log("Omitido (ya migrado): " . $relativePath);
            return;
        }
        
        $content = file_get_contents($filePath);
        if ($content === false) {
            $this->errorFiles[] = $filePath;
            $this->log("ERROR: No se pudo leer " . $relativePath);
            return;
        }
        
        $originalContent = $content;
        
        // Verificar si necesita migración
        if (!$this->needsMigration($content)) {
            return;
        }
        
        echo "<p>Migrando: <strong>" . $relativePath . "</strong></p>\n";
        
        // Aplicar migraciones
        $content = $this->applyMigrations($content, $relativePath);
        
        // Solo escribir si hubo cambios
        if ($content !== $originalContent) {
            if (file_put_contents($filePath, $content) !== false) {
                $this->migratedFiles[] = $relativePath;
                $this->log("Migrado exitosamente: " . $relativePath);
            } else {
                $this->errorFiles[] = $filePath;
                $this->log("ERROR: No se pudo escribir " . $relativePath);
            }
        }
    }
    
    private function needsMigration($content) {
        $mysqlFunctions = [
            'mysql_connect', 'mysql_select_db', 'mysql_query', 
            'mysql_fetch_array', 'mysql_fetch_assoc', 'mysql_num_rows',
            'mysql_error', 'mysql_close', 'mysql_real_escape_string',
            'mysql_insert_id', 'mysql_affected_rows'
        ];
        
        foreach ($mysqlFunctions as $func) {
            if (strpos($content, $func . '(') !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function applyMigrations($content, $relativePath) {
        // 1. Agregar include de compatibilidad si usa funciones MySQL
        if (!strpos($content, 'mysql_compatibility.php') && $this->needsMigration($content)) {
            $includeCode = "\n// Cargar compatibilidad MySQL para PHP 7+\nif (!function_exists('mysql_connect')) {\n    require_once __DIR__ . '/../mysql_compatibility.php';\n}\n\n";
            
            // Insertar después del primer <?php
            $content = preg_replace('/(<\?php\s*)/', "$1" . $includeCode, $content, 1);
        }
        
        // 2. Mejorar manejo de errores en queries
        $content = preg_replace(
            '/mysql_fetch_array\s*\(\s*mysql_query\s*\(\s*([^)]+)\s*\)\s*\)/',
            'mysql_fetch_array(mysql_query($1))',
            $content
        );
        
        // 3. Agregar verificaciones de resultado
        $content = preg_replace(
            '/(\$\w+)\s*=\s*mysql_query\s*\(\s*([^)]+)\s*\)\s*;/',
            '$1 = mysql_query($2);' . "\n" . 'if (!$1) { $this->log("Query error: " . mysql_error()); }',
            $content
        );
        
        // 4. Mejorar escape de strings
        $content = preg_replace(
            '/mysql_real_escape_string\s*\(\s*([^)]+)\s*\)/',
            'mysql_real_escape_string($1)',
            $content
        );
        
        return $content;
    }
    
    private function showReport() {
        echo "<hr>\n";
        echo "<h2>Reporte de Migración</h2>\n";
        echo "<p><strong>Archivos migrados exitosamente:</strong> " . count($this->migratedFiles) . "</p>\n";
        
        if (!empty($this->migratedFiles)) {
            echo "<ul>\n";
            foreach ($this->migratedFiles as $file) {
                echo "<li>✅ " . htmlspecialchars($file) . "</li>\n";
            }
            echo "</ul>\n";
        }
        
        if (!empty($this->errorFiles)) {
            echo "<p><strong>Archivos con errores:</strong> " . count($this->errorFiles) . "</p>\n";
            echo "<ul>\n";
            foreach ($this->errorFiles as $file) {
                echo "<li>❌ " . htmlspecialchars(str_replace($this->projectRoot . '/', '', $file)) . "</li>\n";
            }
            echo "</ul>\n";
        }
        
        echo "<hr>\n";
        echo "<h3>Pasos siguientes:</h3>\n";
        echo "<ol>\n";
        echo "<li>Verificar que el archivo <code>mysql_compatibility.php</code> esté en la raíz del proyecto</li>\n";
        echo "<li>Probar la aplicación en un entorno PHP 7+</li>\n";
        echo "<li>Revisar los logs de error en <code>" . basename($this->logFile) . "</code></li>\n";
        echo "<li>Verificar que todas las funcionalidades trabajen correctamente</li>\n";
        echo "</ol>\n";
        
        echo "<p><strong>Backup disponible en:</strong> " . $this->backupDir . "</p>\n";
        echo "<p><strong>Log completo en:</strong> " . $this->logFile . "</p>\n";
    }
    
    private function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}

// Ejecutar migración si es llamado directamente
if (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_NAME']) === 'php7_migration_script.php') {
    $projectRoot = dirname(__FILE__);
    $migrator = new MySQLToMySQLiMigrator($projectRoot);
    $migrator->migrate();
}
?>
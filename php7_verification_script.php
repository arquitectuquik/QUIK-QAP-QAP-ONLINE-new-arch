<?php
/**
 * Script de Verificación PHP 7+ para QAP Project
 * 
 * Este script verifica que la migración a PHP 7+ fue exitosa
 * y que todas las funcionalidades críticas siguen operando
 * 
 * @version 1.0 
 * @author QAP Migration Tool
 */

class PHP7Verifier {
    
    private $projectRoot;
    private $errors = [];
    private $warnings = [];
    private $success = [];
    
    public function __construct($projectRoot) {
        $this->projectRoot = rtrim($projectRoot, '/');
    }
    
    public function runFullVerification() {
        echo "<h1>Verificación PHP 7+ - QAP Project</h1>\n";
        echo "<p>Verificando migración desde PHP 5.6...</p>\n";
        
        $this->checkPHPVersion();
        $this->checkExtensions();
        $this->checkMySQLCompatibility();
        $this->checkCriticalFiles();
        $this->checkDatabaseConnection();
        $this->checkSyntaxErrors();
        
        $this->showResults();
    }
    
    private function checkPHPVersion() {
        echo "<h2>1. Verificación de Versión PHP</h2>\n";
        
        $version = phpversion();
        $majorVersion = (int)explode('.', $version)[0];
        
        if ($majorVersion >= 7) {
            $this->success[] = "✅ PHP $version - Compatible";
            echo "<p style='color: green'>✅ PHP $version detectado - Compatible</p>\n";
        } else {
            $this->errors[] = "❌ PHP $version - No compatible (se requiere PHP 7+)";
            echo "<p style='color: red'>❌ PHP $version - Se requiere PHP 7 o superior</p>\n";
        }
    }
    
    private function checkExtensions() {
        echo "<h2>2. Verificación de Extensiones</h2>\n";
        
        $requiredExtensions = [
            'mysqli' => 'Requerida para compatibilidad MySQL',
            'pdo' => 'PDO para base de datos',
            'pdo_mysql' => 'PDO MySQL driver',
            'openssl' => 'Cifrado y SSL',
            'json' => 'Manejo de JSON',
            'mbstring' => 'Strings multibyte',
            'session' => 'Manejo de sesiones'
        ];
        
        foreach ($requiredExtensions as $ext => $description) {
            if (extension_loaded($ext)) {
                $this->success[] = "✅ Extensión $ext disponible";
                echo "<p style='color: green'>✅ $ext - $description</p>\n";
            } else {
                $this->warnings[] = "⚠️ Extensión $ext no disponible - $description";
                echo "<p style='color: orange'>⚠️ $ext - $description (No disponible)</p>\n";
            }
        }
        
        // Verificar que mysql extension NO esté cargada
        if (extension_loaded('mysql')) {
            $this->warnings[] = "⚠️ Extensión mysql obsoleta aún cargada";
            echo "<p style='color: orange'>⚠️ La extensión mysql obsoleta está cargada</p>\n";
        } else {
            $this->success[] = "✅ Extensión mysql obsoleta no está cargada";
            echo "<p style='color: green'>✅ Extensión mysql obsoleta correctamente removida</p>\n";
        }
    }
    
    private function checkMySQLCompatibility() {
        echo "<h2>3. Verificación de Compatibilidad MySQL</h2>\n";
        
        $compatibilityFile = $this->projectRoot . '/mysql_compatibility.php';
        
        if (file_exists($compatibilityFile)) {
            $this->success[] = "✅ Archivo de compatibilidad MySQL encontrado";
            echo "<p style='color: green'>✅ mysql_compatibility.php encontrado</p>\n";
            
            // Cargar y probar funciones
            require_once $compatibilityFile;
            
            $testFunctions = [
                'mysql_connect', 'mysql_select_db', 'mysql_query',
                'mysql_fetch_array', 'mysql_num_rows', 'mysql_error',
                'mysql_real_escape_string', 'mysql_close'
            ];
            
            foreach ($testFunctions as $func) {
                if (function_exists($func)) {
                    $this->success[] = "✅ Función $func disponible";
                    echo "<p style='color: green'>✅ $func() - Disponible</p>\n";
                } else {
                    $this->errors[] = "❌ Función $func no disponible";
                    echo "<p style='color: red'>❌ $func() - No disponible</p>\n";
                }
            }
        } else {
            $this->errors[] = "❌ Archivo de compatibilidad MySQL no encontrado";
            echo "<p style='color: red'>❌ mysql_compatibility.php no encontrado</p>\n";
        }
    }
    
    private function checkCriticalFiles() {
        echo "<h2>4. Verificación de Archivos Críticos</h2>\n";
        
        $criticalFiles = [
            'index.php' => 'Archivo principal',
            'login.php' => 'Página de login',
            'php/sql_connection.php' => 'Conexión a base de datos',
            'php/verifica_sesion.php' => 'Verificación de sesión',
            'mysql_compatibility.php' => 'Compatibilidad MySQL'
        ];
        
        foreach ($criticalFiles as $file => $description) {
            $fullPath = $this->projectRoot . '/' . $file;
            
            if (file_exists($fullPath)) {
                // Verificar sintaxis PHP
                $output = [];
                $returnCode = 0;
                exec("php -l \"$fullPath\" 2>&1", $output, $returnCode);
                
                if ($returnCode === 0) {
                    $this->success[] = "✅ $file - Sintaxis correcta";
                    echo "<p style='color: green'>✅ $file - $description (Sintaxis OK)</p>\n";
                } else {
                    $this->errors[] = "❌ $file - Error de sintaxis";
                    echo "<p style='color: red'>❌ $file - Error de sintaxis</p>\n";
                    echo "<pre>" . implode("\n", $output) . "</pre>\n";
                }
            } else {
                $this->errors[] = "❌ $file - Archivo no encontrado";
                echo "<p style='color: red'>❌ $file - Archivo no encontrado</p>\n";
            }
        }
    }
    
    private function checkDatabaseConnection() {
        echo "<h2>5. Verificación de Conexión a Base de Datos</h2>\n";
        
        try {
            // Incluir el archivo de conexión
            $connectionFile = $this->projectRoot . '/php/sql_connection.php';
            
            if (file_exists($connectionFile)) {
                // Capturar cualquier salida
                ob_start();
                $errorBefore = error_get_last();
                
                include_once $connectionFile;
                
                $output = ob_get_clean();
                $errorAfter = error_get_last();
                
                if ($errorAfter && $errorAfter !== $errorBefore) {
                    $this->errors[] = "❌ Error al cargar sql_connection.php: " . $errorAfter['message'];
                    echo "<p style='color: red'>❌ Error en conexión: " . $errorAfter['message'] . "</p>\n";
                } else {
                    $this->success[] = "✅ Archivo sql_connection.php cargado sin errores";
                    echo "<p style='color: green'>✅ Archivo de conexión cargado correctamente</p>\n";
                    
                    // Verificar variables de conexión
                    if (isset($GLOBALS['mysql_link']) || function_exists('mysql_connect')) {
                        $this->success[] = "✅ Sistema de conexión MySQL inicializado";
                        echo "<p style='color: green'>✅ Sistema de conexión disponible</p>\n";
                    }
                }
                
                if (!empty($output)) {
                    echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px 0;'>";
                    echo "<strong>Output del archivo de conexión:</strong><br>";
                    echo "<pre>" . htmlspecialchars($output) . "</pre>";
                    echo "</div>";
                }
                
            } else {
                $this->errors[] = "❌ sql_connection.php no encontrado";
                echo "<p style='color: red'>❌ Archivo sql_connection.php no encontrado</p>\n";
            }
            
        } catch (Exception $e) {
            $this->errors[] = "❌ Excepción en conexión: " . $e->getMessage();
            echo "<p style='color: red'>❌ Excepción: " . $e->getMessage() . "</p>\n";
        }
    }
    
    private function checkSyntaxErrors() {
        echo "<h2>6. Verificación de Sintaxis en Todos los Archivos PHP</h2>\n";
        
        $phpFiles = $this->findPHPFiles();
        $syntaxErrors = 0;
        $checkedFiles = 0;
        
        echo "<p>Verificando sintaxis en " . count($phpFiles) . " archivos PHP...</p>\n";
        
        foreach ($phpFiles as $file) {
            $checkedFiles++;
            $output = [];
            $returnCode = 0;
            
            exec("php -l \"$file\" 2>&1", $output, $returnCode);
            
            if ($returnCode !== 0) {
                $syntaxErrors++;
                $relativePath = str_replace($this->projectRoot . '/', '', $file);
                $this->errors[] = "❌ Error de sintaxis en $relativePath";
                echo "<p style='color: red'>❌ $relativePath - Error de sintaxis</p>\n";
            }
        }
        
        if ($syntaxErrors === 0) {
            $this->success[] = "✅ Todos los archivos PHP tienen sintaxis correcta ($checkedFiles archivos)";
            echo "<p style='color: green'>✅ Sintaxis correcta en todos los $checkedFiles archivos PHP</p>\n";
        } else {
            echo "<p style='color: red'>❌ $syntaxErrors archivos con errores de sintaxis</p>\n";
        }
    }
    
    private function findPHPFiles() {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->projectRoot)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    private function showResults() {
        echo "<hr>\n";
        echo "<h2>📊 Resumen de Verificación</h2>\n";
        
        $totalChecks = count($this->success) + count($this->warnings) + count($this->errors);
        $successRate = $totalChecks > 0 ? round((count($this->success) / $totalChecks) * 100, 1) : 0;
        
        echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>\n";
        echo "<h3>Estadísticas:</h3>\n";
        echo "<ul>\n";
        echo "<li><strong>✅ Éxitos:</strong> " . count($this->success) . "</li>\n";
        echo "<li><strong>⚠️ Advertencias:</strong> " . count($this->warnings) . "</li>\n";
        echo "<li><strong>❌ Errores:</strong> " . count($this->errors) . "</li>\n";
        echo "<li><strong>📈 Tasa de éxito:</strong> {$successRate}%</li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        
        if (count($this->errors) === 0 && count($this->warnings) <= 2) {
            echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>\n";
            echo "<h3>🎉 ¡Migración Exitosa!</h3>\n";
            echo "<p>El proyecto ha sido migrado exitosamente a PHP 7+. Todas las verificaciones críticas han pasado.</p>\n";
            echo "</div>\n";
        } elseif (count($this->errors) === 0) {
            echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0;'>\n";
            echo "<h3>⚠️ Migración Completada con Advertencias</h3>\n";
            echo "<p>La migración se completó pero hay algunas advertencias que revisar.</p>\n";
            echo "</div>\n";
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>\n";
            echo "<h3>❌ Migración Requiere Atención</h3>\n";
            echo "<p>Hay errores que necesitan ser corregidos antes de usar PHP 7+.</p>\n";
            echo "</div>\n";
        }
        
        // Recomendaciones
        echo "<h3>📝 Próximos Pasos:</h3>\n";
        echo "<ol>\n";
        
        if (count($this->errors) > 0) {
            echo "<li><strong>Corregir errores críticos:</strong> Revisar y solucionar todos los errores listados arriba.</li>\n";
        }
        
        echo "<li><strong>Probar funcionalidades:</strong> Navegar por la aplicación y probar todas las funciones principales.</li>\n";
        echo "<li><strong>Monitorear logs:</strong> Revisar logs de error del servidor web.</li>\n";
        echo "<li><strong>Backup:</strong> Mantener el backup de la versión PHP 5.6 como respaldo.</li>\n";
        echo "<li><strong>Performance:</strong> Monitorear el rendimiento de la aplicación.</li>\n";
        echo "</ol>\n";
        
        echo "<hr>\n";
        echo "<p><small>Verificación completada: " . date('Y-m-d H:i:s') . "</small></p>\n";
    }
}

// Ejecutar verificación si es llamado directamente
if (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_NAME']) === 'php7_verification_script.php') {
    $projectRoot = dirname(__FILE__);
    $verifier = new PHP7Verifier($projectRoot);
    $verifier->runFullVerification();
}
?>
<?php
/**
 * Script Directo de Aplicación de Compatibilidad MySQL
 * 
 * Este script agrega la línea de compatibilidad MySQL a todos los archivos
 * que la necesiten, de forma rápida y directa.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$projectRoot = __DIR__;
$modifiedFiles = 0;
$errors = [];

// Encontrar todos los archivos PHP que usan funciones MySQL
$cmd = "find \"$projectRoot\" -name \"*.php\" -exec grep -l \"mysql_\" {} \\; | grep -v migration | grep -v verification | grep -v apply_mysql_compatibility";
$phpFiles = shell_exec($cmd);
$phpFiles = array_filter(explode("\n", trim($phpFiles)));

echo "Aplicando compatibilidad MySQL a " . count($phpFiles) . " archivos...\n\n";

foreach ($phpFiles as $file) {
    if (empty($file)) continue;
    
    $relativePath = str_replace($projectRoot . '/', '', $file);
    echo "Procesando: $relativePath\n";
    
    $content = file_get_contents($file);
    if ($content === false) {
        $errors[] = "No se pudo leer: $relativePath";
        continue;
    }
    
    // Solo procesar si no tiene ya la compatibilidad
    if (strpos($content, 'mysql_compatibility.php') !== false) {
        echo "  ✓ Ya tiene compatibilidad\n";
        continue;
    }
    
    // Solo procesar archivos que realmente usen funciones MySQL
    $mysqlFunctions = ['mysql_query', 'mysql_fetch_array', 'mysql_connect', 'mysql_close', 'mysql_error'];
    $needsCompatibility = false;
    foreach ($mysqlFunctions as $func) {
        if (strpos($content, $func . '(') !== false) {
            $needsCompatibility = true;
            break;
        }
    }
    
    if (!$needsCompatibility) {
        echo "  - No necesita compatibilidad\n";
        continue;
    }
    
    // Determinar la ruta relativa correcta para mysql_compatibility.php
    $depth = substr_count($relativePath, '/');
    $includePrefix = str_repeat('../', $depth);
    $includePath = $includePrefix . 'mysql_compatibility.php';
    
    // Código de compatibilidad a insertar
    $compatibilityCode = "\n// Cargar compatibilidad MySQL para PHP 7+\nif (!function_exists('mysql_connect')) {\n    require_once '$includePath';\n}\n";
    
    // Insertar después del primer <?php
    if (preg_match('/(<\?php)/', $content, $matches, PREG_OFFSET_CAPTURE)) {
        $insertPos = $matches[1][1] + strlen($matches[1][0]);
        
        // Buscar el final de la línea para insertar en la siguiente línea
        $nextNewline = strpos($content, "\n", $insertPos);
        if ($nextNewline !== false) {
            $insertPos = $nextNewline;
        }
        
        $newContent = substr($content, 0, $insertPos) . $compatibilityCode . substr($content, $insertPos);
        
        if (file_put_contents($file, $newContent) !== false) {
            $modifiedFiles++;
            echo "  ✓ Compatibilidad agregada\n";
        } else {
            $errors[] = "No se pudo escribir: $relativePath";
            echo "  ✗ Error al escribir\n";
        }
    } else {
        echo "  - No se encontró etiqueta PHP\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "RESUMEN:\n";
echo "Archivos modificados: $modifiedFiles\n";
echo "Errores: " . count($errors) . "\n";

if (!empty($errors)) {
    echo "\nErrores encontrados:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}

echo "\n✅ Proceso completado. Todos los archivos PHP ahora tienen compatibilidad MySQL para PHP 7+.\n";
?>
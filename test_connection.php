<?php
// Cargar compatibilidad MySQL
if (!function_exists('mysql_connect')) {
    require_once '/usr/local/lib/php/mysql_compatibility.php';
}

// Test MySQL directo
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test MySQL y Reset Contraseña Admin</h1>";

// Configuración
// $db_host = "mysql_qaponline";
// $db_user = "u669796078_panequik_qap";
// $db_pass = "QuikSAS2019*";
// $db_name = "u669796078_panequik_qap";

$db_host = "localhost"; 
$db_user = "quikappspane_qaponline_user";
$db_pass = "qaponline_v1";
$db_name = "quikappspane_qaponline_v2";

echo "<p>Intentando conectar...</p>";

// Probar conexión
$con = mysql_connect($db_host, $db_user, $db_pass);

if (!$con) {
    echo "<p style='color: red;'>ERROR: " . mysql_error() . "</p>";
    die();
}

echo "<p style='color: green;'>✅ Conectado a MySQL</p>";

if (!mysql_select_db($db_name)) {
    echo "<p style='color: red;'>ERROR BD: " . mysql_error() . "</p>";
    die();
}

echo "<p style='color: green;'>✅ Base de datos seleccionada</p>";

// Probar consulta de usuario admin ANTES del reset
echo "<h2>ANTES del reset:</h2>";
$query = "SELECT nombre_usuario, contrasena, estado FROM usuario WHERE nombre_usuario = 'admin'";
$result = mysql_query($query);

if (!$result) {
    echo "<p style='color: red;'>ERROR QUERY: " . mysql_error() . "</p>";
} else {
    if (mysql_num_rows($result) > 0) {
        $user = mysql_fetch_array($result);
        echo "<p style='color: green;'>✅ Usuario admin encontrado:</p>";
        echo "<ul>";
        echo "<li>Usuario: " . $user['nombre_usuario'] . "</li>";
        echo "<li>Password MD5 actual: " . $user['contrasena'] . "</li>";
        echo "<li>Estado: " . $user['estado'] . "</li>";
        echo "</ul>";
        
        $old_hash = $user['contrasena'];
    } else {
        echo "<p style='color: red;'>❌ Usuario admin NO encontrado</p>";
        mysql_close($con);
        die();
    }
}

// RESETEAR CONTRASEÑA
echo "<h2>RESETEANDO CONTRASEÑA:</h2>";
$new_password = "QuikSAS2025#";
$new_hash = md5($new_password);

echo "<p>Nueva contraseña: <strong>$new_password</strong></p>";
echo "<p>Nuevo MD5: <strong>$new_hash</strong></p>";

$update_query = "UPDATE usuario SET contrasena = '$new_hash' WHERE nombre_usuario = 'admin'";
$update_result = mysql_query($update_query);

if (!$update_result) {
    echo "<p style='color: red;'>❌ ERROR AL ACTUALIZAR: " . mysql_error() . "</p>";
} else {
    echo "<p style='color: green;'>✅ Contraseña actualizada exitosamente</p>";
}

// Verificar el cambio DESPUÉS del reset
echo "<h2>DESPUÉS del reset (verificación):</h2>";
$verify_query = "SELECT nombre_usuario, contrasena, estado FROM usuario WHERE nombre_usuario = 'admin'";
$verify_result = mysql_query($verify_query);

if (!$verify_result) {
    echo "<p style='color: red;'>ERROR VERIFICACIÓN: " . mysql_error() . "</p>";
} else {
    if (mysql_num_rows($verify_result) > 0) {
        $verified_user = mysql_fetch_array($verify_result);
        echo "<p style='color: green;'>✅ Verificación exitosa:</p>";
        echo "<ul>";
        echo "<li>Usuario: " . $verified_user['nombre_usuario'] . "</li>";
        echo "<li>Password MD5 nuevo: " . $verified_user['contrasena'] . "</li>";
        echo "<li>Estado: " . $verified_user['estado'] . "</li>";
        echo "</ul>";
        
        // Verificar que el hash coincide
        if ($verified_user['contrasena'] == $new_hash) {
            echo "<p style='color: green; font-weight: bold;'>🎉 ¡ÉXITO! La contraseña se ha actualizado correctamente</p>";
        } else {
            echo "<p style='color: red;'>❌ ERROR: El hash no coincide</p>";
        }
    }
}

// Test de autenticación simulada
echo "<h2>TEST DE AUTENTICACIÓN:</h2>";
$test_password = "QuikSAS2025#";
$test_hash = md5($test_password);

echo "<p>Probando autenticación con:</p>";
echo "<ul>";
echo "<li>Usuario: admin</li>";
echo "<li>Contraseña: $test_password</li>";
echo "<li>MD5 generado: $test_hash</li>";
echo "</ul>";

$auth_query = "SELECT * FROM usuario WHERE nombre_usuario = 'admin' AND contrasena = '$test_hash'";
$auth_result = mysql_query($auth_query);

if (mysql_num_rows($auth_result) > 0) {
    echo "<p style='color: green; font-weight: bold; font-size: 18px;'>🔐 ✅ AUTENTICACIÓN EXITOSA</p>";
    echo "<p style='background: #d4edda; padding: 10px; border-radius: 5px;'>";
    echo "<strong>Credenciales finales:</strong><br>";
    echo "URL: http://localhost:8080/<br>";
    echo "Usuario: <strong>admin</strong><br>";
    echo "Contraseña: <strong>QuikSAS2025#</strong>";
    echo "</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ AUTENTICACIÓN FALLIDA</p>";
}

// Información adicional del sistema
echo "<h2>INFORMACIÓN DEL SISTEMA:</h2>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>MySQL Client Version: " . mysql_get_client_info() . "</li>";
echo "<li>Servidor MySQL: $db_host</li>";
echo "<li>Base de datos: $db_name</li>";
echo "<li>Usuario BD: $db_user</li>";
echo "</ul>";

mysql_close($con);

echo "<hr>";
echo "<p style='color: #666; font-size: 12px;'>Test completado - " . date('Y-m-d H:i:s') . "</p>";
?>
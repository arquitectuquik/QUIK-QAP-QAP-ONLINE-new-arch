<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();

if (!isset($_SESSION["qap_userId"]) || !isset($_SESSION['qap_token'])) {
    header("HTTP/1.1 401 Unauthorized");
    header('Content-Type: text/plain');
    die("Sesión no válida");
}

// Incluir solo lo necesario
include_once "sql_connection.php";
include_once "PHPExcel.php";

// Verificar y reconectar a MySQL si es necesario
function verificarConexionMySQL()
{
    global $con, $host, $user, $pass, $dbname;

    // Verificar si la conexión existe y está activa
    if (!$con || !mysql_ping($con)) {
        // Reconectar
        $con = mysql_connect($host, $user, $pass);
        if (!$con) {
            die("Error: No se puede conectar a MySQL - " . mysql_error());
        }

        if (!mysql_select_db($dbname, $con)) {
            die("Error: No se puede seleccionar la base de datos - " . mysql_error());
        }
    }
    return true;
}

// Verificar conexión antes de cualquier consulta
verificarConexionMySQL();

// Verificar token de sesión
$token_escaped = mysql_real_escape_string($_SESSION['qap_token'], $con);
$qry = "SELECT id_sesion FROM $tbl_sesion WHERE token_sesion = '$token_escaped'";

$result_token = mysql_query($qry, $con);
if (!$result_token) {
    header("HTTP/1.1 401 Unauthorized");
    header('Content-Type: text/plain');
    die("Error verificando sesión: " . mysql_error());
}

if (mysql_num_rows($result_token) == 0) {
    header("HTTP/1.1 401 Unauthorized");
    header('Content-Type: text/plain');
    die("Token de sesión inválido");
}

// Limpiar resultado de verificación
mysql_free_result($result_token);

// Capturar parámetros
$labid = isset($_POST['labid']) ? mysql_real_escape_string($_POST['labid'], $con) : '';
$programid = isset($_POST['programid']) ? mysql_real_escape_string($_POST['programid'], $con) : '';

// Validar parámetros
if (empty($labid) || empty($programid)) {
    header('Content-Type: text/plain');
    die("Parámetros inválidos");
}

// Verificar conexión nuevamente antes de la consulta principal
verificarConexionMySQL();

// Ejecutar consulta principal
$qry = "SELECT DISTINCT 
        laboratorio.no_laboratorio AS No_Lab,
        laboratorio.nombre_laboratorio AS Laboratorio,
        programa.nombre_programa AS Programa,
        analito.nombre_analito AS Analito,
        analizador.nombre_analizador AS Analizador,
        gen_vitros.valor_gen_vitros AS Generación,
        metodologia.nombre_metodologia AS Metodología,
        reactivo.nombre_reactivo AS Reactivo,
        unidad.nombre_unidad AS Unidad,
        material.nombre_material AS Material,
        CASE configuracion_laboratorio_analito.activo
                WHEN 1 THEN 'Sí'
                WHEN 0 THEN 'No'
                ELSE 'Desconocido'
            END AS Activo
    FROM configuracion_laboratorio_analito
    JOIN laboratorio 
        ON configuracion_laboratorio_analito.id_laboratorio = laboratorio.id_laboratorio
    JOIN programa 
        ON configuracion_laboratorio_analito.id_programa = programa.id_programa
    JOIN analito 
        ON configuracion_laboratorio_analito.id_analito = analito.id_analito
    JOIN analizador 
        ON configuracion_laboratorio_analito.id_analizador = analizador.id_analizador
    LEFT JOIN gen_vitros 
        ON configuracion_laboratorio_analito.id_gen_vitros = gen_vitros.id_gen_vitros
    JOIN metodologia 
        ON configuracion_laboratorio_analito.id_metodologia = metodologia.id_metodologia
    JOIN reactivo 
        ON configuracion_laboratorio_analito.id_reactivo = reactivo.id_reactivo
    JOIN unidad 
        ON configuracion_laboratorio_analito.id_unidad = unidad.id_unidad
    JOIN material 
        ON configuracion_laboratorio_analito.id_material = material.id_material
    WHERE configuracion_laboratorio_analito.id_laboratorio = '$labid'
    AND configuracion_laboratorio_analito.id_programa = '$programid'";


$result = mysql_query($qry, $con);

if (!$result) {
    header('Content-Type: text/plain');
    die("Error en consulta: " . mysql_error());
}

if (mysql_num_rows($result) == 0) {
    header('Content-Type: text/plain');
    die("No hay datos para los parámetros especificados");
}

// Obtener TODOS los datos antes de generar el Excel
$datos = array();
$columnas = array();

// Obtener nombres de columnas
$numFields = mysql_num_fields($result);
for ($i = 0; $i < $numFields; $i++) {
    $meta = mysql_fetch_field($result, $i);
    $columnas[] = $meta->name;
}

// Obtener todos los datos
while ($row = mysql_fetch_assoc($result)) {
    $datos[] = $row;
}

// Liberar resultado y cerrar conexión ANTES de generar Excel
mysql_free_result($result);
mysql_close($con);

// Ahora que tenemos todos los datos, generar Excel
$filename = "enrolamiento_" . $labid . "_" . $programid . "_" . date('Ymd') . ".xlsx";

// Configurar headers para Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: public');

// Generar Excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setTitle('Enrolamiento');

// Escribir encabezados
$sheet->fromArray($columnas, null, 'A1');

// Estilo de encabezados
$headerRange = 'A1:' . chr(64 + count($columnas)) . '1';
$sheet->getStyle($headerRange)->getFont()->setBold(true);

// Escribir datos desde el array
$rowIndex = 2;
foreach ($datos as $row) {
    $dataArray = array_values($row);
    $sheet->fromArray($dataArray, null, 'A' . $rowIndex);
    $rowIndex++;
}

// Crear el escritor y enviar
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

// Limpiar memoria
$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);

exit;
?>
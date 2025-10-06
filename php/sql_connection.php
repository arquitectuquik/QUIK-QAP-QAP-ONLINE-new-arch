<?php
// require_once __DIR__."/vars_connection.php";
date_default_timezone_set("America/Bogota");
ini_set('max_execution_time', 300);

// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    $compatibility_paths = [
        __DIR__ . '/../mysql_compatibility.php',
        '/usr/local/lib/php/mysql_compatibility.php',
        dirname(__DIR__) . '/mysql_compatibility.php'
    ];
    
    foreach ($compatibility_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }
    
    // Si aún no existe, mostrar error
    if (!function_exists('mysql_connect')) {
        die('Error: No se pudo cargar la compatibilidad MySQL para PHP 7+');
    }
}

// Configuración para Docker
// $db_host = "127.0.0.1";
// $db_user = "panequik_qap";
// $db_pass = "QuikSAS2019*";
// $db_name = "panequik_qaponline_v4";
// para servidor 
$db_host = "localhost"; 
$db_user = "quikappspane_qaponline_user";
$db_pass = "qaponline_v1";
$db_name = "quikappspane_qaponline_v1";
// $db_host = "localhost";
// $db_user = "root";
// $db_pass = ''; // o tu contraseña si la configuraste
// $db_name = "u669796078_panequik_qap"; // el nombre de la BD que importaste

// Conexión usando compatibilidad MySQL mejorada
// Compatible con PHP 7+ usando mysqli internamente

$con = mysql_connect($db_host, $db_user, $db_pass);

mysqlException(mysql_error(), "01");

// mysqli_select_db($con,$db_name);
mysql_select_db($db_name);

mysqlException(mysql_error($con), "02");

mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
mysql_set_charset("utf8");

mysqlException(mysql_error($con), "03");

//Functions//
function clean($string)
{
	$string = str_replace(array('<', '>', '&', '{', '}', '[', ']', '"', "'"), array(''), $string);
	//$string = trim(preg_replace('/\s+/', '', $string));
	//$string = str_replace(array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ'), array('a','e','i','o','u','A','E','I','O','U','n','N'), $string);
	return $string;
}

function mysqlException($v, $v2)
{
	if ($v) {

		global $con;

		$error = "Se ha encontrado una excepción:\n$v\n\nLugar de origen:\n" . basename($_SERVER['PHP_SELF']) . "\n\nReferencia:\n$v2";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	}
}

function adminRestriction()
{

	global $con;

	if (($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 100) && ($_SESSION["qap_key"] != 101 && $_SESSION["qap_key"] != 102)) {
		echo '<html>';
		echo '<head>';
		echo '<meta charset="utf-8">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<link href="boostrap/css/bootstrap.min.css" rel="stylesheet" media="screen">';
		echo '</head>';
		echo '<body>';
		echo '<div class="col-md-12">';
		echo '<div class="jumbotron" style="margin-top: 5%;">';
		echo '<center>';
		echo '<img src="css/forbidden.png" width="300" height="300" alt="forbidden"></img>';
		echo '<h1>Acceso no autorizado.</h1>';
		echo '</center>';
		echo '</div>';
		echo '</div>';
		echo '</body>';
		echo '</html>';

		mysql_close($con);
		exit;
	}
}

function userRestriction()
{

	global $con;

	if ($_SESSION["qap_key"] != 0 && ($_SESSION["qap_key"] != 103 && $_SESSION["qap_key"] != 104 && $_SESSION["qap_key"] != 125 && $_SESSION["qap_key"] != 126)) {
		echo '<html>';
		echo '<head>';
		echo '<meta charset="utf-8">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<link href="boostrap/css/bootstrap.min.css" rel="stylesheet" media="screen">';
		echo '</head>';
		echo '<body>';
		echo '<div class="col-md-12">';
		echo '<div class="jumbotron" style="margin-top: 5%;">';
		echo '<center>';
		echo '<img src="css/forbidden.png" width="300" height="300" alt="forbidden"></img>';
		echo '<h1>Acceso no autorizado.</h1>';
		echo '</center>';
		echo '</div>';
		echo '</div>';
		echo '</body>';
		echo '</html>';

		mysql_close($con);
		exit;
	}
}

function actionRestriction_0()
{ // Administrador total
	if ($_SESSION["qap_key"] != 0) {

		global $con;

		$error = "x0001 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		adminRestriction();
	}
}
function actionRestriction_100()
{ // Administrador total o coordinador
	if ($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 100) {

		global $con;

		$error = "x0002 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		adminRestriction();
	}
}

function actionRestriction_101()
{
	if (($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 100) && $_SESSION["qap_key"] != 101) {

		global $con;

		$error = "x0003 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		adminRestriction();
	}
}
function actionRestriction_102()
{ // Administrador total, coordinador, generador de informes
	if (($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 100) && ($_SESSION["qap_key"] != 101 && $_SESSION["qap_key"] != 102)) {

		global $con;

		$error = "x0004 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		adminRestriction();
	}
}
function actionRestriction_103()
{ // Administrador total, coordinador, generador de informes, usuario de laboratorio
	if (($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 103)) {

		global $con;

		$error = "x0005 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		userRestriction();
	}
}

function actionRestriction_125()
{ // Solo un usuario patólogo (o patólogo coordinador)
	if ($_SESSION["qap_key"] != 125 && $_SESSION["qap_key"] != 126) {

		global $con;

		$error = "x0006 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		// userRestriction();
	}
}

function actionRestriction_104()
{
	if (($_SESSION["qap_key"] != 0 && $_SESSION["qap_key"] != 103) && $_SESSION["qap_key"] != 104) {

		global $con;

		$error = "x0007 Usted no cuenta con los permisos necesarios para realizar ésta acción.";

		echo '<response code="0">';
		echo $error;
		echo '</response>';
		mysql_close($con);
		exit;
	} else {
		userRestriction();
	}
}

function encryptControl($method, $string, $key)
{

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$key = hash('sha256', $key);

	$iv = substr(hash('sha256', $key), 0, 16);

	switch (strtolower($method)) {
		case 'encrypt':
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
			break;
		case 'decrypt':
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			break;
	}

	return $output;
}

class DiskStatus
{

	const RAW_OUTPUT = true;
	private $diskPath;

	function __construct($diskPath)
	{
		$this->diskPath = $diskPath;
	}

	public function totalSpace($rawOutput = false)
	{

		$diskTotalSpace = @disk_total_space($this->diskPath);

		if ($diskTotalSpace === FALSE) {
			throw new Exception('totalSpace(): Invalid disk path.');
		}

		return $rawOutput ? $diskTotalSpace : $this->addUnits($diskTotalSpace);
	}

	public function freeSpace($rawOutput = false)
	{

		$diskFreeSpace = @disk_free_space($this->diskPath);

		if ($diskFreeSpace === FALSE) {
			throw new Exception('freeSpace(): Invalid disk path.');
		}

		return $rawOutput ? $diskFreeSpace : $this->addUnits($diskFreeSpace);
	}

	public function usedSpace($precision = 1)
	{

		try {
			return round((100 - ($this->freeSpace(self::RAW_OUTPUT) / $this->totalSpace(self::RAW_OUTPUT)) * 100), $precision);
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function getDiskPath()
	{

		return $this->diskPath;
	}

	private function addUnits($bytes)
	{

		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
			$bytes /= 1024;
		}

		return round($bytes, 1) . ' ' . $units[$i];
	}
}

//--//	

//-- vConstants --//

if (isset($_SESSION['qap_userId'])) {
	$logQuery = array(
		"INSERT" => array(),
		"UPDATE" => array(),
		"DELETE" => array()
	);

	$iSum = 0;
	$uSum = 0;
	$dSum = 0;

	$userId = $_SESSION['qap_userId'];
	$serverDateInfo = getdate();
	$logDate = $serverDateInfo['year'] . "-" . $serverDateInfo['mon'] . "-" . $serverDateInfo['mday'];
	$logHour = $serverDateInfo['hours'] . ":" . $serverDateInfo['minutes'] . ":" . $serverDateInfo['seconds'];
}

//--//

//tables//

$tbl_usuario = "usuario";
$tbl_pais = "pais";
$tbl_analizador = "analizador";
$tbl_unidad = "unidad";
$tbl_metodologia = "metodologia";
$tbl_distribuidor = "distribuidor";
$tbl_analito = "analito";
$tbl_tipo_programa = "tipo_programa";
$tbl_programa = "programa";
$tbl_muestra = "muestra";
$tbl_reactivo = "reactivo";
$tbl_ronda = "ronda";
$tbl_ciudad = "ciudad";
$tbl_contador_muestra = "contador_muestra";
$tbl_laboratorio = "laboratorio";
$tbl_catalogo = "catalogo";
$tbl_lote = "lote";
$tbl_usuario_laboratorio = "usuario_laboratorio";
$tbl_unidad_analizador = "unidad_analizador";
$tbl_media_evaluacion_caso_especial = "media_evaluacion_caso_especial";
$tbl_limite_evaluacion = "limite_evaluacion";
$tbl_opcion_limite = "opcion_limite";
$tbl_metodologia_analizador = "metodologia_analizador";
$tbl_muestra_programa = "muestra_programa";
$tbl_programa_laboratorio = "programa_laboratorio";
$tbl_programa_analito = "programa_analito";
$tbl_configuracion_laboratorio_analito = "configuracion_laboratorio_analito";
$tbl_ronda_laboratorio = "ronda_laboratorio";
$tbl_resultado = "resultado";
$tbl_log = "log";
$tbl_sesion = "sesion";
$tbl_temp_pdf = "temp_pdf";
$tbl_contador_informe = "contador_informe";
$tbl_gen_vitros = "gen_vitros";
$tbl_fecha_reporte_muestra = "fecha_reporte_muestra";
$tbl_misc = "misc";
$tbl_valor_metodo_referencia = "valor_metodo_referencia";
$tbl_calculo_limite_evaluacion = "calculo_limite_evaluacion";
$tbl_tipo_estado_reporte = "tipo_estado_reporte";
$tbl_metodo_jctlm = "metodo_jctlm";
$tbl_material_jctlm = "material_jctlm";
$tbl_material = "material";
$tbl_metodo_jctlm_emparejado = "metodo_jctlm_emparejado";
$tbl_material_jctlm_emparejado = "material_jctlm_emparejado";
$tbl_analito_resultado_reporte_cualitativo = "analito_resultado_reporte_cualitativo";
$tbl_configuracion_analito_resultado_reporte_cualitativo = "configuracion_analito_resultado_reporte_cualitativo";
$tbl_unidad_global_analito = "unidad_global_analito";
$tbl_digitacion = "digitacion";
$tbl_digitacion_cuantitativa = "digitacion_cuantitativa";
$tbl_digitacion_cualitativa = "digitacion_cualitativa";

$tbl_programa_pat = "programa_pat";
$tbl_reto = "reto";
$tbl_lote_pat = "lote_pat";
$tbl_referencia = "referencia";
$tbl_caso_clinico = "caso_clinico";
$tbl_grupo = "grupo";
$tbl_pregunta = "pregunta";
$tbl_distractor = "distractor";
$tbl_respuesta_lab = "respuesta_lab";
$tbl_reto_laboratorio = "reto_laboratorio";
$tbl_intento = "intento";
$tbl_imagen_adjunta = "imagen_adjunta";
// $tbl_asignaciones_mesurando = 								"asignaciones_mesurando";
// $tbl_mesurando_resultado_reporte_cualitativo =				"mesurando_resultado_reporte_cualitativo";
$tbl_puntuaciones = "puntuaciones";
$tbl_digitacion_resultados_verdaderos = "digitacion_resultados_verdaderos";
$tbl_digitaciones_uroanalisis = "digitaciones_uroanalisis";
// $tbl_programa_laboratorio_uroanalisis	=					"programa_laboratorio_uroanalisis";
$tbl_comparaciones_internacionales = "comparaciones_internacionales";
$tbl_mesurando_valores = "mesurando_valores";
$tbl_resultados_vav = "resultados_vav";
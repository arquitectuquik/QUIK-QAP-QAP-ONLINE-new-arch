<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

    
    function enviarCorreoCambioAnalito($textoAccion, $id_configuracion){

        date_default_timezone_set("America/Bogota");		
        ini_set('max_execution_time', 300);		
        require_once("../passwordRecovery/php/PHPMailer/PHPMailerAutoload.php");
           
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = false;

        $mail->Port = 587;
        $mail->Host = "stmp.office365.com";
        
        $mail->SMTPAuth = true;                  
        $mail->SMTPSecure = "ssl"; // or tls
        
        $mail->Username = "no-reply@quik.com.co";
        $mail->Password = "Quik2017";
        
        $mail->setFrom('no-reply@quik.com.co', 'QAP Online | Quik S.A.S.');

        $mail->AddAddress("qap@quik.com.co");
        /*
        $qryCoords = "SELECT email_usuario FROM usuario WHERE tipo_usuario = 100";
        $qryArrayCoords = mysql_query($qryCoords);
        mysqlException(mysql_error(),"_01correo");
        while ($qryDataCoords = mysql_fetch_array($qryArrayCoords)) {
            $mail->addAddress($qryDataCoords["email_usuario"]);
        }
        */
        $mail->addBCC("viviana.sanchez@quik.com.co");

        $mail->CharSet =  "utf-8";

        $mail->Subject = "Enrolamiento QAP-LC";
        $mail->IsHTML(true);

        // Obtener nombre de usuario
        $qry = "SELECT nombre_usuario from usuario where id_usuario = '$id_usuario'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_02correo");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_usuario = $qryData["nombre_usuario"];
    
        // Obtener toda la informacion del mensurando configurado
        $qry = "SELECT 
            nombre_programa,
            laboratorio.no_laboratorio,
            laboratorio.nombre_laboratorio,
            nombre_analito,
            nombre_analizador,
            nombre_metodologia,
            nombre_reactivo,
            nombre_unidad,
            valor_gen_vitros,
            nombre_material
        FROM configuracion_laboratorio_analito 
        INNER JOIN programa ON configuracion_laboratorio_analito.id_programa = programa.id_programa 
        INNER JOIN laboratorio ON configuracion_laboratorio_analito.id_laboratorio = laboratorio.id_laboratorio 
        INNER JOIN analito ON configuracion_laboratorio_analito.id_analito = analito.id_analito 
        INNER JOIN analizador ON configuracion_laboratorio_analito.id_analizador = analizador.id_analizador 
        INNER JOIN metodologia ON configuracion_laboratorio_analito.id_metodologia = metodologia.id_metodologia 
        INNER JOIN reactivo ON configuracion_laboratorio_analito.id_reactivo = reactivo.id_reactivo 
        INNER JOIN unidad ON configuracion_laboratorio_analito.id_unidad = unidad.id_unidad 
        INNER JOIN gen_vitros ON configuracion_laboratorio_analito.id_gen_vitros = gen_vitros.id_gen_vitros 
        LEFT JOIN material ON configuracion_laboratorio_analito.id_material = material.id_material
        WHERE configuracion_laboratorio_analito.id_configuracion = $id_configuracion
        ";

        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_103");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_programa = $qryData["nombre_programa"];
        $no_laboratorio = $qryData["no_laboratorio"];
        $nombre_laboratorio = $qryData["nombre_laboratorio"];
        $nombre_analito = $qryData["nombre_analito"];
        $nombre_analizador = $qryData["nombre_analizador"];
        $nombre_metodologia = $qryData["nombre_metodologia"];
        $nombre_reactivo = $qryData["nombre_reactivo"];
        $nombre_unidad = $qryData["nombre_unidad"];
        $valor_gen_vitros = $qryData["valor_gen_vitros"];
        $nombre_material = $qryData["nombre_material"];


        // Obtener el nombre de usuario
        $qry = "SELECT 
            nombre_usuario
        FROM usuario 
        WHERE id_usuario = ".$_SESSION['qap_userId'];

        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_104");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_usuario  = $qryData["nombre_usuario"];

        $fechaAct = Date("Y-m-d h:i:s");
        
        $mail->Body = 
                "<p>Estimado Coordinador de QAP Laboratorio Clínico</p>".
                "<br/>".
                "<br/>".
                "<p>QAP Online informa que el usuario <strong>$nombre_usuario</strong> acaba de realizar una actualización a su enrolamiento, a continuación la información detallada</p>".
                "<br/>".
                "<br/>".
                "<strong>Acción:</strong> $textoAccion</br>".
                "<strong>Hora:</strong> $fechaAct</br>".
                "<strong>Laboratorio:</strong> $no_laboratorio - $nombre_laboratorio</br>".
                "<strong>Programa</strong> $nombre_programa</br>".
                "<br/>".
                "<strong>Mensurando</strong> $nombre_analito</br>".
                "<strong>Analizador</strong> $nombre_analizador</br>".
                "<strong>Metodologia</strong> $nombre_metodologia</br>".
                "<strong>Reactivo</strong> $nombre_reactivo</br>".
                "<strong>Unidad</strong> $nombre_unidad</br>".
                "<strong>Generación vitros</strong> $valor_gen_vitros</br>".
                "<strong>Material</strong> $nombre_material</br>".
                "<br/>".
                "<br/>".
                "<br/>".
                "<p>*** NO RESPONDER - Mensaje Generado Automáticamente ***</p>".
                "<p>Este correo es únicamente informativo y es de uso exclusivo del destinatario(a), puede contener información privilegiada y/o confidencial. 
                    Si no es usted el destinatario(a) deberá borrarlo inmediatamente. Queda notificado que el mal uso, divulgación no autorizada, alteración y/o  
                    modificación malintencionada sobre este mensaje y sus anexos quedan estrictamente prohibidos y pueden ser legalmente sancionados. - 
                    Quik S.A.S.  no asume ninguna responsabilidad por estas circunstancias-</p>";	

        $mail->send();

    }
?>
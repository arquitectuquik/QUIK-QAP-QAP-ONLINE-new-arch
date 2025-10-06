<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

    function enviarCorreoPAT($id_laboratorio,$id_usuario,$id_reto,$fecha_actual){
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

        $mail->AddAddress("qap-pat@quik.com.co");
        /*
        $qryCoords = "SELECT email_usuario FROM usuario WHERE tipo_usuario = 100 and estado = 1";
        $qryArrayCoords = mysql_query($qryCoords);
        mysqlException(mysql_error(),"_01");
        while ($qryDataCoords = mysql_fetch_array($qryArrayCoords)) {
            $mail->addAddress($qryDataCoords["email_usuario"]);
        }
        */
        $mail->addBCC("viviana.sanchez@quik.com.co");

        $mail->CharSet =  "utf-8";

        $mail->Subject = "Reporte de resultados QAP PAT";
        $mail->IsHTML(true);

        // Obtener nombre de usuario
        $qry = "SELECT nombre_usuario from usuario where id_usuario = '$id_usuario'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_usuario = $qryData["nombre_usuario"];
    
        // Obtener nombre de reto
        $qry = "SELECT reto.nombre as nombre_reto, programa_pat.nombre as nombre_programa from reto join programa_pat on programa_pat.id_programa = reto.programa_pat_id_programa where id_reto = '$id_reto'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_reto = $qryData["nombre_reto"];
        $nombre_programa = $qryData["nombre_programa"];
        
        // Obtener nombre de laboratorio
        $qry = "SELECT no_laboratorio, nombre_laboratorio from laboratorio where id_laboratorio = '$id_laboratorio'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_laboratorio = $qryData["no_laboratorio"] . " - ". $qryData["nombre_laboratorio"];

        $mail->Body = 
                "<p>Estimado Coordinador de QAP Patología Anatómica</p>".
                "<br/>".
                "<br/>".
                "<p>QAP Online informa que el usuario <strong>$nombre_usuario</strong> acaba de reportar los casos clínicos de patología anatómica, a continuación la información detallada</p>".
                "<br/>".
                "<br/>".
                "<strong>Laboratorio:</strong> $nombre_laboratorio</br>".
                "<strong>Hora:</strong> $fecha_actual</br>".
                "<strong>Programa:</strong> $nombre_programa</br>".
                "<strong>Reto:</strong> $nombre_reto</br>".
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
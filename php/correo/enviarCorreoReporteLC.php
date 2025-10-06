<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

    
    function enviarCorreoReporteLC($id_laboratorio,$id_ronda, $nombre_archivo, $extencion_archivo){
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
    
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

        $qryCoords = "SELECT email_usuario
                    FROM usuario join usuario_laboratorio on usuario.id_usuario = usuario_laboratorio.id_usuario
                    WHERE tipo_usuario = 103 and usuario_laboratorio.id_laboratorio = $id_laboratorio";
        $qryArrayCoords = mysql_query($qryCoords);
        mysqlException(mysql_error(),"_01correo");
        while ($qryDataUserLab = mysql_fetch_array($qryArrayCoords)) {
            $mail->addAddress($qryDataUserLab["email_usuario"]);
        }
        $mail->addBCC("viviana.sanchez@quik.com.co");

        $mail->CharSet =  "utf-8";

        $mail->Subject = "Carga de reporte QAP-LC";
        $mail->IsHTML(true);

        // Obtener nombre de usuario
        $qry = "SELECT no_laboratorio, nombre_laboratorio from laboratorio where id_laboratorio = '$id_laboratorio'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_02correo");
        $qryData = mysql_fetch_array($qryArray);
        $no_laboratorio = $qryData["no_laboratorio"];
        $nombre_laboratorio = $qryData["nombre_laboratorio"];

        // Obtener nombre de ronda y programa
        $qry = "SELECT programa.nombre_programa, ronda.no_ronda from ronda join programa on programa.id_programa = ronda.id_programa where id_ronda = '$id_ronda'";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_02correo");
        $qryData = mysql_fetch_array($qryArray);
        $nombre_programa = $qryData["nombre_programa"];
        $no_ronda = $qryData["no_ronda"];
        
        $mail->Body = 
                "<p>Estimado usuario de QAP Laboratorio Clínico</p>".
                "<br/>".
                "<br/>".
                "<p>Quik S.A.S. informa que ya se encuentra disponible un nuevo reporte para su laboratorio clínico, recuerde que puede descargarlo en cualquier momento desde la aplicación de software <a href='https://qaponline.quik.com.co/'>QAP Online</a>. A continuación la información detallada:</p>".
                "<br/>".
                "<br/>".
                "<strong>Laboratorio:</strong> $no_laboratorio - $nombre_laboratorio</br>".
                "<strong>Programa</strong> $nombre_programa</br>".
                "<strong>Ronda</strong> $no_ronda</br>".
                "<strong>Nombre del reporte</strong> $nombre_archivo.$extencion_archivo</br>".
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
<?php
    $id_document = $_POST["id"];
    unlink("temp_chart/" . $id_document . ".pdf");
?>
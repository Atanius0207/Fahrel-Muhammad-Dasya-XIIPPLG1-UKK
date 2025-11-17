<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fahrelmuhammaddasya_xiipplg1_inventaris";

    mysqli_report(MYSQLI_REPORT_OFF);

    $conn = @mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn) {
        $error_message = mysqli_connect_error();
        die('<strong>Terjadi Kesalahan Saat Menghubungkan Database: </strong>
            <strong>'. $error_message .'</strong>');
    }
?>
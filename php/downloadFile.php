<?php
    session_start();
    if(!isset($_SESSION['email']) || $_SERVER['REQUEST_METHOD'] != 'GET' || !isset($_GET['fileName']))
        die('Invalid Request');
    include 'functions.php';
    $fileName = $_GET['fileName'];
    $filePath = './../uploads/' . $fileName;
    if(file_exists($filePath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
    }else
        echo 'File Not Found';
?>
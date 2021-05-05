<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']) ||  $_SERVER['REQUEST_METHOD']  != 'POST' || !isset($_POST['fileName']))
        die('Invalid Access');
    $email = $_SESSION['email'];
    $file = $_POST['fileName'];
    $fileName = './../uploads/' . $_POST['fileName'];
    if(file_exists($fileName)){
        $sql = linkDatabase();
        $query = "DELETE FROM uploaded_files WHERE file_name = '{$file}'";
        mysqli_query($sql, $query);
        echo mysqli_error($sql);
        if(mysqli_affected_rows($sql)){
            unlink($fileName);
            echo 'File Deleted';
        }else echo 'Error Deleting File';
        mysqli_close($sql);
    }
    else
        echo 'File does not exist';
?>
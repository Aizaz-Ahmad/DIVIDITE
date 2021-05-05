<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']) || $_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['fileName']))
        die('Invalid Request');
    $fileName = $_POST['fileName'];
    $sql = linkDatabase();
    $query = "UPDATE uploaded_files SET downloads = ((SELECT downloads FROM uploaded_files WHERE file_name = '${fileName}') + 1) WHERE file_name = '{$fileName}'";
    mysqli_query($sql,$query);
    if(!mysqli_error($sql))
        echo 'Yes';
    mysqli_close($sql);
?>
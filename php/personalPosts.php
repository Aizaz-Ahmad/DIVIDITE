<?php
    session_start();
    include 'functions.php';
    require  'class.Post.php';
    if(!isset($_SESSION['email']) || $_SERVER['REQUEST_METHOD'] != 'POST') 
        die('Invalid Access');
    $sql = linkDatabase();
    $query = "SELECT * FROM uploaded_files WHERE uploader_email = '{$_SESSION['email']}'";
    $result = mysqli_query($sql, $query);
    echo mysqli_error($sql);
    $posts = [];
    if(mysqli_num_rows($result)){
    while($row = mysqli_fetch_assoc($result))
        array_push($posts, new Post($row['file_name'], $row['description'],$row['uploader_email'],$row['downloads'],$row['uploaded_Time'],$row['subject'],$row['category'],'0','master'));
    }
    echo json_encode($posts);
    mysqli_close($sql);
?>
<?php
    session_start();
    include 'functions.php';
    require  'class.Post.php';
    if(!isset($_SESSION['email']))
        die('Invalid Access');
    $sql = linkDatabase();
    $query = "SELECT F.*, U.image_uploaded, U.registration_date FROM uploaded_files F, users U WHERE F.uploader_email = U.email  ORDER BY uploaded_Time DESC ";
    $result = mysqli_query($sql, $query);
    $posts = [];
    while($row = mysqli_fetch_assoc($result))
        array_push($posts, new Post($row['file_name'], $row['description'],$row['uploader_email'],$row['downloads'],$row['uploaded_Time'],$row['subject'],$row['category'],$row['image_uploaded'],$row['registration_date']));
    echo json_encode($posts);
?>
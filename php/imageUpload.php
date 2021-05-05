<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']) ||  $_SERVER['REQUEST_METHOD']  != 'POST' || !isset($_FILES['file']))
        die('Invalid Access');
    $file = $_FILES['file'];
    $type = $file['type'];
    $sql = linkDatabase();
    if($type != 'image/jpeg' && $type != 'image/png')
        echo 'Image With this type not allowed, only PNG, JPEG AND JPG are allowed.';
    else if($file['size'] > 200000)
        echo 'Image File is too large. File Size must be less than 2MB';
    else{
        $email = $_SESSION['email'];
        $imageName = strtolower(substr($email,0,10));
        $imageName = $imageName . '.jpg';
        $file['name'] = $imageName;
        if(move_uploaded_file($file['tmp_name'],'./../images/'. basename($file['name']))){
            $query = "UPDATE users SET image_uploaded = '1' WHERE email = '{$email}'";
            mysqli_query($sql, $query);
            echo (mysqli_error($sql) ? 'Error Uploading Image' :'Image Uploaded');
        }
        else
            echo 'Error Uploading Image';
    }
    mysqli_close($sql);
?>
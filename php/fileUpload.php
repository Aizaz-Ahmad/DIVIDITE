<?php
    session_start();
    include 'functions.php';
    require 'class.Post.php';
    if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_FILES['file'])
    || !isset($_POST['fileName']) || !isset($_POST['description']) || !isset($_POST['subject'])
    || !isset($_POST['category'])
    || !$_POST['fileName'] || !$_POST['subject'] || !$_POST['category'])
        die(json_encode('Invalid Access'));
    $file = $_FILES['file'];
    $fileName = $_POST['fileName'];
    if(!validFileName($fileName))
        die(json_encode('Invalid File Name'));
    $fileName = AddExtension($file['type'], $fileName);
    if($fileName == 'File Type Not Allowed')
        die(json_encode($fileName));
    if(file_exists('./../uploads/'.$fileName))
        die(json_encode('File With this Name Already Exists'));
    if($file['size'] > 200000000)
        die(json_encode('File Size Must be at most 200 MB'));
    $description = test_input($_POST['description']);
    $subject = test_input($_POST['subject']);
    $category = test_input($_POST['category']);
    if(!checkSubject($subject))
        die(json_encode('Invalid Subject Selected'));
    if(!is_string($description) || strlen($description) > 100)
        die(json_encode('Description Length should be at most 100 characters'));
    if(!checkCategories($category))
        die(json_encode('Invalid Category'));
    $file['name'] = str_replace("'","",$fileName,);
    $file['name'] = str_replace("&","",$fileName,);
    if(move_uploaded_file($file['tmp_name'], './../uploads/' . basename($file['name']))){
        if(!insert_file_record_to_db($_SESSION['email'], $file['name'],$subject,$category,$description)){
            unlink('./../uploads/' . basename($file['name']));
            die(json_encode('Error Uploading File'));
        }
        echo json_encode(new Post($fileName,$description,$_SESSION['email'],0,date('Y-m-d'),$subject,$category,"0",date('Y-m-d')));
    }
    else
        echo json_encode('Error Uploading File');
?>
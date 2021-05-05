<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']))
        die('Invalid Access');
    if($_SERVER['REQUEST_METHOD'] != 'POST')
        die('Invalid Access');
    $email = $_SESSION['email'];
    $sql = linkDatabase();
    $query = "SELECT verification_code FROM users WHERE email = '{$email}'";
    $result = mysqli_query($sql,$query);
    $code;
    while($row = mysqli_fetch_assoc($result))
        $code = $row['verification_code'];
    if(sendMail($email,$code)){
        echo 'Yes';
    }
    else
        echo 'No';
?>
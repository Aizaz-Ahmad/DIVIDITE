<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']))
        die('Invalid Access');
    if($_SERVER['REQUEST_METHOD'] != 'POST')
        die('Invalid Access');
    $code = test_input($_POST['code']);
    $email = $_SESSION['email'];
    $sql = linkDatabase();
    $query = "SELECT verification_code FROM users WHERE email = '{$email}'";
    $result = mysqli_query($sql, $query);
    $rows = mysqli_num_rows($result);
    $ver_code;
    while($row = mysqli_fetch_assoc($result))
        $ver_code = $row['verification_code'];
    if($ver_code == $code){
        $query = "UPDATE users SET verification_status = '1' WHERE email = '{$email}'";
        mysqli_query($sql, $query);
        echo ('Yes');
    }else
        echo('No');
    mysqli_close($sql);
?>
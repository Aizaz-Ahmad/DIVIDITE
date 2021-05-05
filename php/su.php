<?php
    session_start();
    if(isset($_SESSION['email']) || (isset($_COOKIE['cookie_email']) && isset($_COOKIE['id'])))
        die();
    if($_SERVER['REQUEST_METHOD'] != 'POST')
        die('Invalid Access');
    setcookie("check","ndm");
    if(count($_COOKIE) == 0)
        die('Cookies must be enabled to use this site');
    setcookie("check","", time() - 1035);
    include 'functions.php';
    $email = strtolower(test_input($_POST['email']));
    $password = test_input($_POST['password']);
    $sql;
    if(checkEmail($email) && checkPassword($password)){
        $sql = linkDatabase();
        $verification_code = "";
        do{
            $verification_code = createVerificationCode();
            $query = "SELECT * FROM users WHERE verification_code = '{$verification_code}'";
            $result = mysqli_query($sql, $query);
            $rows = mysqli_num_rows($result);
        }while($rows);
        $query= "INSERT INTO users (email,password,verification_code) VALUES ('{$email}','{$password}','{$verification_code}')";
        mysqli_query($sql,$query);
        if(mysqli_error($sql) && substr(mysqli_error($sql),0,9) == "Duplicate")
            die();
        if(!sendMail($email,$verification_code))
            die('No');
        $_SESSION['email'] = $email;
        echo 'Yes';
    }
    else
        echo 'No';
    mysqli_close($GLOBALS['sql']);
?>
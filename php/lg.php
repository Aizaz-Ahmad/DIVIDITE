<?php
    session_start();
    if(isset($_SESSION['email']) || (isset($_COOKIE['cookie_email']) && isset($_COOKIE['id'])))
        die();
    include 'functions.php';
    if($_SERVER['REQUEST_METHOD'] != 'POST')
        die('Invalid Access');
    $email = strtolower(test_input($_POST['email']));
    $password = test_input($_POST['password']);
    if(checkEmail($email) && checkPassword($password)){
        $sql = linkDatabase();
        $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
        $result = mysqli_query($sql,$query);
        $rows = mysqli_num_rows($result);
        if($rows == 0)
            die('Invalid');
        $_SESSION['email'] = $email;
        setcookie("cookie_email",$email,time() + 1035,"/",".localhost",true,true);
        setcookie("id", mysqli_fetch_assoc($result)['verification_code'],time() + 1035,"/",".localhost",true,true);
        if(count($_COOKIE) == 0)
            die('Cookies must be enabled to use this site');
        echo 'Yes';    
    }
    else
        echo 'No';
?>
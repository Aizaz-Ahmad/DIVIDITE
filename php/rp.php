<?php
    include 'functions.php'; 
    if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['request']))
        die('Invalid Access');
    $request = test_input($_POST['request']);
    if($request == 'sendCode'){
        if(!isset($_POST['email']))
            die('Invalid Access');
        $email = test_input($_POST['email']);
        if(!checkEmail($email))
            die('Invalid Email');
        $sql = linkDatabase();
        $query = "SELECT * FROM users WHERE email ='{$email}'";
        $result = mysqli_query($sql, $query);
        if(!mysqli_num_rows($result)){
            mysqli_close($sql);
            die('Not Registered');
        }
        $query = "SELECT reset_code FROM reset_password WHERE email = '{$email}'";
        $result = mysqli_query($sql, $query);
        if(mysqli_num_rows($result))
            $resetCode = mysqli_fetch_assoc($result)['reset_code'];
        else{
            $resetCode = createResetPasswordCode();
            $query = "INSERT INTO reset_password (reset_code,email) VALUES ('{$resetCode}', '{$email}')";
            mysqli_query($sql, $query);
            if(mysqli_error($sql)){
                mysqli_close($sql);
                die('Error');
            }
        }
        echo sendMail($email,$resetCode,"reset") ? 'Code Sent' : 'Error';
        mysqli_close($sql);
    }
    else if($request == 'resetPassword'){
        if(!isset($_POST['resetCode']) || !isset($_POST['password']) || strlen($_POST['resetCode']) != 10)
            die('Invalid Access');
        $password = test_input($_POST['password']);
        $resetCode = test_input($_POST['resetCode']);
        if(!checkPassword($password))
            die('Invalid Password');
        $sql = linkDatabase();
        $query = "SELECT email FROM reset_password WHERE reset_code = '{$resetCode}'";
        $result = mysqli_query($sql, $query);
        if(mysqli_num_rows($result)){
            $email = mysqli_fetch_assoc($result)['email'];
            $query = "UPDATE users SET password = '{$password}' WHERE email = '{$email}'";
            mysqli_query($sql, $query);
            if(mysqli_error($sql)) 
                echo 'Error, Reseting Password!';
            else{
                $query = "DELETE FROM reset_password WHERE reset_code = '{$resetCode}'";
                mysqli_query($sql, $query);
                echo 'Yes';
            }
        }else
            echo 'Invalid Access';
    }
    else
        echo 'Invalid Access';
?>
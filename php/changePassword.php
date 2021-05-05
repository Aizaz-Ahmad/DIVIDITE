<?php
    session_start();
    include 'functions.php';
    if(!isset($_SESSION['email']) || $_SERVER['REQUEST_METHOD'] != 'POST'
        || !isset($_POST['old']) ||!isset($_POST['new'])
    )
        die('Invalid Try to Access');
    $email = $_SESSION['email'];
    $old = test_input($_POST['old']);
    $new = test_input($_POST['new']);
    if(!checkPassword($new))
        die('Invalid Password');
    $sql = linkDatabase();
    $query = "UPDATE users SET password = '{$new}' WHERE email = '{$email}' AND password = '{$old}'";
    $result = mysqli_query($sql, $query);
    if(mysqli_error($sql))
        echo('Error Changing Password');
    else if(!mysqli_affected_rows($sql))
        echo('Wrong Old Password');
    else
        echo 'Password Changed';
    mysqli_close($sql);
?>
<?php
    include 'functions.php';
    if($_SERVER['REQUEST_METHOD'] != 'POST')
        die('Invalid Access');
    $email = test_input($_POST['email']);
    if(!checkEmail($email))
        die('Invalid');
    $sql = linkDatabase();
    $query = "SELECT * FROM users WHERE email = '{$email}'";
    $result = mysqli_query($sql, $query);
    $rows = mysqli_num_rows($result);
    echo ($rows == 0 ? "Yes" : "No");
?>
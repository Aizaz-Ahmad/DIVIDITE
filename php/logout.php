<?php
    session_start();
    session_destroy();
    setcookie("cookie_email","",time() - 1035,"/",".localhost",true,true);
    setcookie("id", "",time() - 1035,"/",".localhost",true,true);
    header("Location: ./../login.php");
?>
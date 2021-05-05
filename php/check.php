<?php
    setcookie("cookie_check","dnm");
    if(count($_COOKIE) == 0){
        die("<script>alert('Cookie Must be enabled to use this site')</script>");
    }
?>
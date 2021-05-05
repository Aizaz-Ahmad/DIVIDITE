<?php
date_default_timezone_set("Asia/Karachi");
$fileTypes = [
    "application/pdf",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "application/vnd.ms-excel",
    "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
    "application/vnd.openxmlformats-officedocument.presentationml.presentation",
    "application/vnd.ms-powerpoint",
];
$fileExtensions = ["pdf", "docx", "doc", "xlsx", "xls", "pptx", "ppt", "ppsx"];
$categories = ['Book','Hand Written Notes','Slides','Excel Sheets','Past Papers','Labs'];
function linkDatabase(){
    $sql = new mysqli("localhost","root","","dividite");
    if(!$sql)
        die('Connection With Database Failed');
    return $sql;
}
function checkEmail($email){
    if(!is_string($email)) return false;
    if(strlen($email) != 23) return false;
    return preg_match('/[b][isc][tce][f][1][0-9][ma][05][0-9][0-9]@pucit.edu.pk/i',$email);     
}
function checkPassword($password){
    if(!is_string($password)) return false;
    if(strlen($password) < 8) return false;
    return count_chars($password)['32'] == 0;
}
function createVerificationCode(){
    $str = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
    $code = "";
    for($i = 0;$i < 6;$i++)
        $code .= $str[rand(0,strlen($str)) - 1];
    return $code;
}
function createResetPasswordCode(){
    $str = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
    $code = "";
    for($i = 0;$i < 10;$i++)
        $code .= $str[rand(0,strlen($str)) - 1];
    return $code;
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function sendMail($email, $code, $mode = "Verification"){
    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'aizazahamd90@gmail.com';
    $mail->Password = 'jac8kal90';
    $mail->setFrom('aizazahamd90@gmail.com','DIVIDITE');
    $mail->addAddress($email);
    $mail->addReplyTo('aizazahamd90@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = ($mode == 'Verification' ?'DIVIDITE VERIFICATION CODE' : 'DIVIDITE RESET PASSWORD LINK');
    $mail->Body = ($mode == 'Verification' ? "<h1 style='text-align:center;font-family:Calibri;'>
    Thanks For Becoming Part of our Community<h1/>
    <p>
    <span  style='font-weight:bold;font-family:Calibri;'>Your Verification Code is: </span>{$code}</p>":
    "<h1 style='text-align:center;font-family:Calibri;'>
    Reset Password<h1/><p style='font-family:Calibri;'>
    <a href='http://localhost/dividite/resetPassword.php?q=`{$code}`'>Click Here to Reset your Password</a></p>
    <p>This Link will expire After 24 hours and it can be used to reset Password once</p>"
    );
    return $mail->send();
}
function user_confimation(){
    if(isset($_SESSION['email'])){
        $sql = linkDatabase();
        $query = "SELECT * FROM users WHERE email = '{$_SESSION['email']}'";
        $result = mysqli_query($sql,$query);
        $row = mysqli_fetch_assoc($result);
        if(!$row['verification_status'])
          header('Location: ./validate.php');
        return $row;  
    }
    else if(isset($_COOKIE["cookie_email"]) && isset($_COOKIE["id"])){
        $sql = linkDatabase();
        $query = "SELECT * FROM users WHERE email = '{$_COOKIE['cookie_email']}' AND verification_code = '{$_COOKIE['id']}'";
        $result = mysqli_query($sql,$query);
        $row = mysqli_fetch_assoc($result);
        if(!mysqli_num_rows($result) || !$row['verification_status']){
            setcookie("cookie_email","",time() - 1035,"/",".localhost",true,true);
            setcookie("id","",time() - 1035,"/",".localhost",true,true);   
        }
        if(!mysqli_num_rows($result))
            header('Location: ./login.php');
        else if(!$row['verification_status']){
            $_SESSION['email'] = $_COOKIE["cookie_email"];
            header('Location: ./validate.php');
        }
        else{
            $_SESSION['email'] = $_COOKIE["cookie_email"];
            return $row;   
        }
    }
    else
        header('Location: ./login.php');
}
//File Functions 
function validFileName(string $fileName){
    $result = preg_split('/(?!(?:COM[0-9]|CON|LPT[0-9]|NUL|PRN|AUX|com[0-9]|con|lpt[0-9]|nul|prn|aux)|[\s\.])[^\\\:*"?<>|]{1,254}/',$fileName);
    return $result[0] == '' && $result[1] == '';
}
function isValidFileType($fileType){
   return array_search($fileType, $GLOBALS['fileTypes']);
}
function findExtension($fileType){
    $result = isValidFileType($fileType);
    if(is_bool($result) && $result == false)
        return '';
    return $GLOBALS['fileExtensions'][$result];
}
function AddExtension($actualFileType,$newFileName){
    if(findExtension($actualFileType) != '')
        return $newFileName . '.' . findExtension($actualFileType);
    else
        return 'File Type Not Allowed';
}
function checkSubject($subject){
    $subjects = file_get_contents('./../subjects.json');
    $subjects = json_decode($subjects);
    return array_search($subject, $subjects) === false ? false : true;
}
function checkCategories($category){
    return array_search($category, $GLOBALS['categories']) === false ? false : true;
}
function insert_file_record_to_db($email, $fileName, $subject, $category, $description){
    $sql = linkDatabase();
    $query = "INSERT INTO uploaded_files (uploader_email, file_name, description, subject, category) VALUES 
    ('{$email}','{$fileName}','{$description}','{$subject}','{$category}')";
    mysqli_query($sql, $query);
    $error = mysqli_error($sql);
    mysqli_close($sql);
    return !$error;
} 
function add_image_extension($type,$name){
    if($type == 'image/jpeg' || $type == 'image/jpg')
        return $name . '.jpg';
    return $name . '.png';
}
?>
<?php
    session_start();
    include './php/functions.php';
    if(isset($_SESSION['email'])){
        $sql = linkDatabase();
        $query = "SELECT * FROM users WHERE email = '{$_SESSION['email']}'";
        $result = mysqli_query($sql, $query);
        if(mysqli_fetch_assoc($result)['verification_status'])
            header('Location: ./main.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dividite</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="bttn.css">
    <link rel="stylesheet" href="bootstrap-social.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <noscript>Javascript Should be enabled to use this site</noscript>
    <div class="loader">
        <div class="spin-container"> </div>
        <div class="sp">
            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-light shadow-lg border-bottom p-3 sticky-top">
            <a class="navbar-brand ml-4 text-white text-uppercase" href="index.html">Dividite</a>
            <button class="navbar-toggler d-lg-none border-0" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation"><i style="font-size: 30px;" class="fa fa-bars text-white"
                    aria-hidden="true"></i></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <div class="d-flex flex-sm-row flex-column main-links">
                    <a href="#" class="link">Contact Us</a>
                    <a href="#" class="link">About</a>
                </div>
            </div>
        </nav>
        <?php
        if(!isset($_SESSION['email']))
            die("
            <div style='display:flex;flex-direction:column;align-items:center;height:100vh;margin-top:70px;'>
                <h1 class='text-danger'>You Must Log In Or Sign In First To Have Access to this Page</h1>
                <div class='w-100'></div>
                <div class=''>
                <button class='btn btn-primary' onclick='window.location.href=`./signup.html`'>Sign Up</button> 
                <button class='btn btn-danger' onclick='window.location.href=`./login.html`'>Log In</button> 
                </div>
            </div>
        ");
        ?>
        <div class="container-fluid ver-container">
            <div class="row">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5 p-3 p-sm-5 shadow-main rounded-lg">
                    <div class="h4 text-center text-uppercase text-main mb-4 railway font-weight-bold"
                        style="letter-spacing:4px">Verification</div>
                    <p class="text-main small mt-3">Enter 6-Digit Verification Code Sent to Email You Entered</p>
                    <form>
                        <div class="d-flex justify-content-between mt-3 mb-4">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                            <input type="text" class="ver-inp form-control" maxlength="1">
                        </div>

                        <p class="text-danger small error" style="display: none"><i class="material-icons"
                                style="font-size: 17px;">error</i> Must Fill All Input Fields</p>
                        <p class="text-muted small">Please Check your Verification Code in Spam Folder, if not found in
                            Inbox</p>
                        <p class="text-muted small mb-4">Still Not Recieved? <a href="#" id="resend-code">Click</a> to let us send you the
                            code again</p>
                        <button class="btn btn-block bttn-material-flat sign-btn ver-btn">VERIFY</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid footer" id="footer">
            <h1 class="p-5" style="letter-spacing:5px">DIVIDITE</h1>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p class="text-white text-center text-uppercase railway" style="font-size: 20px;">Contact Us</p>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <button type="button" class="btn btn-block btn-social-md btn-fb waves-effect"><i
                                    class="fa fa-facebook pr-1"></i> Facebook</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button type="button" class="btn btn-block btn-gplus waves-effect"><i
                                    class="fa fa-google pr-1"></i> Gmail</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-5 mt-sm-0">
                    <p class="text-white text-center text-uppercase railway" style="font-size: 20px;">Utilities </p>
                    <ul class="text-white">
                        <a href="" class="text-white nav-link">
                            <li>Aggregate Calculator</li>
                        </a>
                        <a href="" class="text-white nav-link">
                            <li>CGPA Calculator</li>
                        </a>
                        <a href="" class="text-white nav-link">
                            <li>Entry Test Helping Material</li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    let inputs = document.querySelectorAll('.ver-inp')
    inputs[0].focus()
    inputs.forEach(ele => {
        ele.onkeyup = (e) => {
            if (ele.value.length == 1) {
                if (ele.nextElementSibling != null && ele.nextElementSibling.value.length != 1)
                    ele.nextElementSibling.focus()
            }
        }
        ele.focusout = () => {
            if (ele.value == '')
                $(ele).css('border-color', 'var(--danger)')
        }
        ele.focusin = () => {
            $(ele).css('border-color', 'var(--main-color)')
        }
    })
    $('.ver-btn').click((e) => {
        e.preventDefault()
        let value = ""
        inputs.forEach(ele => {
            value += ele.value
            if (ele.value == '') {
                $(ele).css('border-color', 'var(--danger)')
                $(ele).addClass('anima')
            }
        })
        if(value.length < 6)
            $('.error').show()
        else if(value.length == 6){
            $.post('php/val.php',{code:value},(data,s)=>{
                console.log(data);
                if(data == 'Yes')
                    window.location.href = './main.php'
                else if(data == 'No')
                    alert('Invalid Verification Code')
            })
        }
    })
    const resendCode = () => {
        $('.loader').show()
        $.post('php/resendCode.php',{},(data,s) => {
            if(data == 'Yes')
                alert('Code has been sent Successfully! Check your Email');
            else if(data == 'No')
                alert('Error Sending Email. Try Again Later');
            $('.loader').hide()
        })
    }
    $("#resend-code").click(()=>{
        resendCode();
    })
</script>

</html>
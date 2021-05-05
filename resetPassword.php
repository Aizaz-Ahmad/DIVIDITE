<?php
  if(!isset($_GET['q']) || strlen($_GET['q']) != 10)
    die('Invalid Access');
  include './php/functions.php';
  $code = test_input($_GET['q']);
  $sql = linkDatabase();
  $query = "SELECT * FROM reset_password WHERE reset_code = '{$code}'";
  $result = mysqli_query($sql, $query);
  if(mysqli_num_rows($result) == 0){
    mysqli_error($sql);
    die('Invalid Access, Link Does Not Exist');
  }
  else{
    $query = "DELETE FROM reset_password WHERE reset_code = '${code}' AND (SYSDATE() - date)/86400 > 24";
    mysqli_query($sql, $query);
    if(mysqli_affected_rows($sql))
      die('Link Has been Expired');
    mysqli_close($sql);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dividite</title>
    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="bttn.css" />
    <link rel="stylesheet" href="bootstrap-social.css" />
    <link rel="stylesheet" href="index.css" />
  </head>

  <body>
    <noscript>Javascript Should be enabled to use this site</noscript>
    <div class="loader">
      <div class="spin-container"></div>
      <div class="sp">
        <div
          class="spinner-border"
          style="width: 3rem; height: 3rem;"
          role="status"
        >
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
    <div id="app" style="display: none;">
      <nav
        class="navbar navbar-expand-sm navbar-light shadow-lg border-bottom p-3 sticky-top"
      >
        <a class="navbar-brand ml-4 text-white text-uppercase" href="index.html"
          >Dividite</a
        >
        <button
          class="navbar-toggler d-lg-none border-0"
          type="button"
          data-toggle="collapse"
          data-target="#collapsibleNavId"
          aria-controls="collapsibleNavId"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i
            style="font-size: 30px;"
            class="fa fa-bars text-white"
            aria-hidden="true"
          ></i>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
          <div class="d-flex flex-sm-row flex-column main-links">
            <a href="main.php" class="float-right link">Home</a>
            <a href="index.html#footer" class="link">Contact Us</a>
            <a href="about.html" class="link">About</a>
            <a href="login.php" class="link d-none d-md-block">log in</a>
          </div>
        </div>
      </nav>
      <div class="container-fluid" style="margin-top: 60px; height: 80vh;">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="form-row">
              <div class="col-12">
                <label for="password">New Password</label>
              </div>
              <div class="col-12">
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="form-control"
                  v-model="password"
                />
              </div>
              <div class="col-12">
                <p class="text-danger small" v-if="!isRequired">
                  <i class="material-icons" style="font-size: 17px;">error</i>
                  Must Enter a Password
                </p>
                <p class="text-danger small" v-else-if="!isCorrect">
                  <i class="material-icons" style="font-size: 17px;">error</i>
                  Must Enter a Valid Password
                </p>
                <p class="text-dark small">
                  Use 8 or more characters with a mix of letters, numbers &
                  symbols(~`!_@#$%^&*)
                </p>
              </div>
              <div class="col-12 mt-2">
                <button
                  @click="resetPassword"
                  class="btn btn-block sign-btn bttn-material-flat"
                >
                  Reset
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid footer" id="footer">
        <h1 class="p-5" style="letter-spacing: 5px;">DIVIDITE</h1>
        <div class="row">
          <div class="col-12 col-sm-6">
            <p
              class="text-white text-center text-uppercase railway"
              style="font-size: 20px;"
            >
              Contact Us
            </p>
            <div class="row">
              <div class="col-12 col-md-6">
                <button
                  type="button"
                  class="btn btn-block btn-social-md btn-fb waves-effect"
                >
                  <i class="fa fa-facebook pr-1"></i> Facebook
                </button>
              </div>
              <div class="col-12 col-md-6">
                <button
                  type="button"
                  class="btn btn-block btn-gplus waves-effect"
                >
                  <i class="fa fa-google pr-1"></i> Gmail
                </button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 mt-5 mt-sm-0">
            <p
              class="text-white text-center text-uppercase railway"
              style="font-size: 20px;"
            >
              Utilities
            </p>
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
    $("#app").show();
    new Vue({
      el: "#app",
      data() {
        return {
          password: "",
          isRequired: true,
          isCorrect: true,
        };
      },
      methods: {
        resetPassword() {
          if (this.password == "") this.isRequired = false;
          else if (this.password.indexOf(" ") > -1 || this.password.length < 8)
            this.isCorrect = false;
          else{
            let code = "<?php echo $_GET['q']?>";
            $.post("php/rp.php",
            {resetCode:code,password:this.password,request:"resetPassword"}
            , (data, s) => {
              if(data == 'Yes')
                window.location.href = 'login.php';
              else
                alert(data);
            })
          }
        },
      },
    });
  </script>
</html>

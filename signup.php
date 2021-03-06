<?php
  session_start();
  if(isset($_SESSION['email']) || (isset($_COOKIE['cookie_email']) && isset($_COOKIE['id'])))
    header('Location: ./main.php');
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
        class="navbar navbar-expand-sm navbar-light shadow-lg border-bottom p-3"
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
            <a href="#footer" class="link">Contact Us</a>
            <a href="about.html" class="link">About</a>
            <a href="login.php" class="link d-none d-md-block">log in</a>
          </div>
        </div>
      </nav>
      <div class="container-fluid mb-5">
        <div class="row justify-content-center" style="margin-top: 60px;">
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <h3
              class="text-center text-main railway font-weight-bold text-uppercase"
            >
              Sign Up to join community
            </h3>
            <form method="POST" spellcheck="false">
              <div class="form-row mt-4">
                <div class="col-12">
                  <label for="">Email</label>
                </div>
                <div class="col-12">
                  <input
                    autocomplete="email"
                    type="email"
                    name="email"
                    valid="true"
                    v-model="email.value"
                    @focusout="checkRequired(email)"
                    @focusin="email.required = true"
                    class="form-control"
                  />
                </div>
                <div class="col-12 mt-1">
                  <p class="text-danger small" v-if="!email.required">
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Must Enter an Email Address
                  </p>
                  <p class="text-danger small" v-else-if="email.isCorrect">
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Must Enter Valid PUCIT Email Address
                  </p>
                  <p class="text-dark small" v-else>
                    Use PUCIT Official Email only
                  </p>
                </div>
              </div>
              <div class="form-row mt-0">
                <div class="col-12">
                  <label for="">Password</label>
                </div>
                <div class="col-12">
                  <div class="input-group">
                    <input
                      type="password"
                      name="password"
                      class="form-control pwd"
                      v-model="password.value"
                      style="border-right: 0px;"
                      @focusout="checkRequired(password)"
                      @focusin="password.required = true"
                      @keyup="checkPassword()"
                      autocomplete="new-password"
                    />
                    <div class="input-group-append">
                      <span
                        v-if="!displayPassword"
                        @click="displayPassword = true"
                        class="input-group-text bg-white"
                        style="border-left: 0px;"
                        ><svg
                          fill="#000000"
                          height="24"
                          viewBox="0 0 24 24"
                          width="24"
                          xmlns="https://www.w3.org/2000/svg"
                          aria-hidden="true"
                          focusable="false"
                        >
                          <path
                            d="M10.58,7.25l1.56,1.56c1.38,0.07,2.47,1.17,2.54,2.54l1.56,1.56C16.4,12.47,16.5,12,16.5,11.5C16.5,9.02,14.48,7,12,7 C11.5,7,11.03,7.1,10.58,7.25z"
                          ></path>
                          <path
                            d="M12,6c3.79,0,7.17,2.13,8.82,5.5c-0.64,1.32-1.56,2.44-2.66,3.33l1.42,1.42c1.51-1.26,2.7-2.89,3.43-4.74 C21.27,7.11,17,4,12,4c-1.4,0-2.73,0.25-3.98,0.7L9.63,6.3C10.4,6.12,11.19,6,12,6z"
                          ></path>
                          <path
                            d="M16.43,15.93l-1.25-1.25l-1.27-1.27l-3.82-3.82L8.82,8.32L7.57,7.07L6.09,5.59L3.31,2.81L1.89,4.22l2.53,2.53 C2.92,8.02,1.73,9.64,1,11.5C2.73,15.89,7,19,12,19c1.4,0,2.73-0.25,3.98-0.7l4.3,4.3l1.41-1.41l-3.78-3.78L16.43,15.93z M11.86,14.19c-1.38-0.07-2.47-1.17-2.54-2.54L11.86,14.19z M12,17c-3.79,0-7.17-2.13-8.82-5.5c0.64-1.32,1.56-2.44,2.66-3.33 l1.91,1.91C7.6,10.53,7.5,11,7.5,11.5c0,2.48,2.02,4.5,4.5,4.5c0.5,0,0.97-0.1,1.42-0.25l0.95,0.95C13.6,16.88,12.81,17,12,17z"
                          ></path></svg
                      ></span>
                      <span
                        v-else
                        @click="displayPassword = false"
                        class="input-group-text bg-white"
                        style="border-left: 0px;"
                        ><svg
                          fill="#000000"
                          height="24"
                          viewBox="0 0 24 24"
                          width="24"
                          xmlns="https://www.w3.org/2000/svg"
                          aria-hidden="true"
                          focusable="false"
                        >
                          <path
                            d="M12,7c-2.48,0-4.5,2.02-4.5,4.5S9.52,16,12,16s4.5-2.02,4.5-4.5S14.48,7,12,7z M12,14.2c-1.49,0-2.7-1.21-2.7-2.7 c0-1.49,1.21-2.7,2.7-2.7s2.7,1.21,2.7,2.7C14.7,12.99,13.49,14.2,12,14.2z"
                          ></path>
                          <path
                            d="M12,4C7,4,2.73,7.11,1,11.5C2.73,15.89,7,19,12,19s9.27-3.11,11-7.5C21.27,7.11,17,4,12,4z M12,17 c-3.79,0-7.17-2.13-8.82-5.5C4.83,8.13,8.21,6,12,6s7.17,2.13,8.82,5.5C19.17,14.87,15.79,17,12,17z"
                          ></path>
                          <path fill="none" d="M0,0h24v24H0V0z"></path></svg
                      ></span>
                    </div>
                  </div>
                </div>
                <div
                  class="col-12 mt-2"
                  v-show="!password.hideProgress && !password.isLengthCorrect"
                >
                  <div class="progress">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :class="progressbar.colorClass"
                      :style="{width:progressbar.width}"
                      style="margin-left: 0px;"
                      aria-valuenow="10"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      {{progressbar.type}}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <p class="text-danger small" v-if="!password.required">
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Must Enter Password
                  </p>
                  <p
                    class="text-danger small"
                    v-else-if="password.containsSpace"
                  >
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Password must not contain spaces
                  </p>
                  <p
                    class="text-danger small"
                    v-else-if="password.isLengthCorrect"
                  >
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Password Length Must be at least 8 characters
                  </p>
                  <p
                    class="text-danger small"
                    v-else-if="password.hasInvalidChar"
                  >
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Password must contain valid characters only
                  </p>
                  <p class="text-dark small" v-else>
                    Use 8 or more characters with a mix of letters, numbers &
                    symbols(~`!_@#$%^&*)
                  </p>
                </div>
              </div>
              <div class="form-row">
                <div class="col-12">
                  <label for="">Confirm Password</label>
                </div>
                <div class="col-12">
                  <div class="input-group">
                    <input
                      type="password"
                      class="form-control pwd"
                      @keyup="isconfirmPassword()"
                      v-model="confirmPassword.value"
                      @focusout="checkRequired(confirmPassword)"
                      @focusin="confirmPassword.required = true"
                      style="border-right: 0px;"
                      autocomplete="new-password"
                    />
                    <div
                      class="input-group-append"
                      v-if="!password.value || !confirmPassword.value"
                    >
                      <div
                        class="bg-white input-group-text"
                        style="border-left: 0px;"
                      ></div>
                    </div>
                    <div class="input-group-append" v-else>
                      <span
                        v-if="confirmPassword.isSameAsPassword"
                        class="input-group-text bg-white"
                        style="border-left: 0px;"
                        ><i class="material-icons text-success font-weight-bold"
                          >&#10004;</i
                        ></span
                      >
                      <span
                        v-else
                        class="input-group-text bg-white"
                        style="border-left: 0px;"
                        ><i class="material-icons text-danger font-weight-bold"
                          >close</i
                        ></span
                      >
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <p class="text-danger small" v-if="!confirmPassword.required">
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Must Enter Confirm Password
                  </p>
                  <p
                    class="text-danger small"
                    v-else-if="confirmPassword.value.length != 0 && !confirmPassword.isSameAsPassword"
                  >
                    <i
                      class="material-icons text-danger"
                      style="font-size: 17px;"
                      >error</i
                    >
                    Not same as Password Above
                  </p>
                </div>
              </div>
              <p class="small mt-1 d-block d-md-none">
                Already Have an Account? <a href="login.php">Log In</a>
              </p>
              <p class="small text-muted mt-2">
                By clicking Sign Up, you agree to our Terms
              </p>
              <div class="form-row">
                <div class="col-12">
                  <button
                    @click="submitForm($event)"
                    name="submit"
                    value="submit"
                    class="btn bttn-material-flat sign-btn btn-block"
                    type="submit"
                  >
                    Sign Up
                  </button>
                </div>
              </div>
            </form>
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
  <script src="./js/su.js"></script>
</html>

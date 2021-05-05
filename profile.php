<?php
    session_start();
    include './php/functions.php';
    $user = user_confimation();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Dividite | <?php echo strtoupper(substr($_SESSION['email'],0,10))?>
    </title>
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
    <div class="loader" style="z-index: 300000;">
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
          <a href="index.php#footer" class="link">Contact Us</a>
          <a href="php/logout.php" class="link">Logout</a>
          <a href="about.html" class="link">About</a>
        </div>
      </div>
    </nav>
    <div class="container-fluid" style="height: calc(100% - 88px);">
      <input
        type="file"
        id="imageFile"
        class="d-none"
        accept=".jpg,.jpeg,.png"
      />
      <div class="row p-1 pt-4 p-sm-5">
        <div class="col-12">
          <div class="row">
            <div class="col-12 col-sm-8 text-center text-sm-left">
              <h1 class="display-3 text-main"><?php echo strtoupper(substr($_SESSION['email'],0,10))?></h1>
              <p><span class="font-weight-bold">Date Joined: </span><?php echo substr($user['registration_date'], 0, 10)?></p>
            </div>
            <div class="col-12 col-sm-4">
              <div class="image-box"></div>
              <p class="text-center small" style="width: 200px;">
                Image must have .jpg,.jpeg,.png extension<br />Image Size must
                be less than 2MB
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 shadow-main" id="posts">
          <h4>My Posts</h4>
          <div class="row">
            <h2 class="text-center" v-if="posts.length == 0">NO POST YET</h2>
            <post v-else v-for="(post,i) in posts" :data="post" :key="i"
              @deletepost = "posts = posts.filter(e => e.fileName != $event)"
            ></post>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script type="text/x-template" id="post">
    <div class="col-12 col-sm-6 col-lg-4 px-sm-4 pb-sm-4 p-xl-4" style="margin:0%;" :title="data.description">
        <div class="row post pt-3">
            <div class="col-3"><img :src="'fileIconSvgs/' + getExtension() + '.svg'" width="40px" height="40px"></div>
            <div class="col-9" :title="data.fileName" style="border-bottom:0.1px solid black"><p class="file-name text-center">{{data.fileName}}</p></div>
            <div class="col-12" :title="data.subject">
                <p class="subject-name"><span class="small font-weight-bold">Subject: </span>&nbsp;&nbsp;{{data.subject}}</p>
            </div>
            <div class="col-12">
                <p class="mb-1 date"><span class="small font-weight-bold">Date Uplaoded: </span>&nbsp;&nbsp;{{data.dateUploaded.substring(0,10)}}</p>
            </div>
            <div class="col-8" :title="data.category">
                <p class="category">
                    <span class="small font-weight-bold">Category: </span>
                    {{data.category}}
                </p>
            </div>
            <div class="col-4">
              <i class="fa fa-trash" title="Delete" @click="deletePost" aria-hidden="true"></i>
            </div>
        </div>
    </div>
  </script>
  <script>
      // posts load
      Vue.component('post', {
        template: '#post',
        props: {
          data: {
            type: Object,
            required: true,
          },
        },
        methods: {
        getExtension() {
              let fileName = this.data.fileName;
              fileName = fileName.split("").reverse().join("");
              let ext = fileName
                .substring(0, fileName.indexOf("."))
                .split("")
                .reverse()
                .join("");
              return ext;
            },
          deletePost(){
            let fileName = this.data.fileName;
            $.post('php/deletePost.php', { fileName: fileName}, (data, s) => {
              if(data == 'File Deleted')
                this.$emit('deletepost',fileName);
              alert(data);
            })
          }
        }
      });
      new Vue({
        el: '.container-fluid',
        mounted() {
          $.post(
            'php/personalPosts.php',{},
            (data, s) => {
              this.posts = data;
            },
            (dataType = 'json')
          );
        },
        data() {
          return {
            posts: [],
          };
        },
    });
      //image upload
      let imageFile = document.getElementById('imageFile');
      let email = '<?php echo $_SESSION['email'];?>'
      email = email.substring(0, email.indexOf('@'))
      let imageBox = document.getElementsByClassName('image-box')[0];
      if('<?php echo $user['image_uploaded']?>' == '1'){
        imageBox.style.backgroundImage = `url(images/${email}.jpg)`;
      }
      imageBox.onclick = () => {
        imageFile.click();
      };
      imageFile.onchange = () => {
        let file = imageFile.files[0];
        if (file.type != 'image/png' && file.type != 'image/jpeg')
          alert(
            'Image With this type not allowed, only PNG, JPEG AND JPG are allowed.'
          );
        else if (file.size > 200000)
          alert('Image File is too large. File Size must be less than 2MB');
        else {
          let form = new FormData();
          form.append('file', file);
          $.ajax({
            url: 'php/imageUpload.php',
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            success(data){
              if(data == 'Image Uploaded'){
                imageBox.style.backgroundImage = `url(images/${email}.jpg)`;
                alert(data + ', Reload to see if it is not changed')
              }else alert(data);
            }
          })
      }
    };
  </script>
</html>

<?php
    session_start();
    include './php/functions.php';
    user_confimation();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dividite | <?php echo strtoupper(substr($_SESSION['email'],0,10))?></title>
    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="bttn.css">
    <link rel="stylesheet" href="bootstrap-social.css">
    <link rel="stylesheet" href="index.css">
    <style>
        label{
            font-weight:bold;
        }
    </style>
</head>
<body>
        <div class="loader" style="z-index:300000;display:block;">
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
        <button title="Show Side Panel" class="btn shadow" id="side-menu-btn"><i class="fa fa-angle-right text-white" aria-hidden="true"></i></button>
        <div id="app">
            <div class="container-fluid bg-main p-3 shadow-lg sticky-top" id="search-container">
                <form action="" spellcheck="false">
                <div class="row">
                    <div class="col-6 col-lg-3 order-lg-0 order-0">
                     <a href="index.html" class="ml-lg-4 text-white navbar-brand">DIVIDITE</a>
                    </div>
                    <div class="col-12 col-lg-7 mt-2 order-lg-1 order-2">
                <input v-model="searchText" type="text" name="search" id="search" class="form-control search-input"  style="display:inline-block" placeholder="Search Users, Books, Notes...">
                <i class="fa fa-search text-white pl-2" aria-hidden="true"></i>
                    </div>
                    <div class="col-6 col-lg-2 order-lg-2 order-1">
                    <div class="dropright">
                    <button id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="bg-main border-0 float-right mt-3 mr-sm-4 mr-md-5"><i class="fa fa-user-circle text-white userIcon" aria-hidden="true" style="font-size:20px;"></i></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="" data-mine="modal">Upload File</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modelId">Change Password</a>
                        <a class="dropdown-item" href="php/logout.php">Logout</a>
                      </div>
                    </div>
                </div>
                </div>
            </form>
            </div>
            <div class="container-fluid position-fixed side-bar-container" style="height: 100vh;">
                <div class="row h-100">
                    <div class="col-12 h-100 shadow">
                        <div class="row h-100">
                            <div class="col-12 col-sm-6 col-md-3 h-100 side-bar">
                    <button data-mine="modal" class="btn bttn-material-flat sign-btn mt-5 ml-3 rounded-lg"><i class="fa fa-plus" aria-hidden="true"></i></button> 
                        <h5 class="h5  ml-3 mt-5 text-main">FILTER <i class="fa fa-filter" aria-hidden="true"></i> </h5>
                        <div class="filter ml-3 mt-2">
                            <div class="form-row font-weight-bold"><div class="col-12"><input type="checkbox" name="filter" value="subject" id="Subject" v-model="checked"><label for="Subject">&nbsp;&nbsp;Subject</label></div></div>
                            <div class="form-row" v-show="checked.find(e => e == 'subject')">
                                <select name="subject-filter" id="subject-filer" class="custom-select form-control" v-model="subjectFilter">
                                    <option v-for= "subject in subjects" :title="subject" :value="subject">{{subject.length <= 25 ? subject : subject.substr(0,25) + '...'}}</option>
                                </select>
                            </div>
                        <div class="form-row  font-weight-bold"><div class="col-12"><input type="checkbox" value="category" id="category" v-model="checked"><label for="category">&nbsp;&nbsp;Category</label></div></div>  
                    <ul class="pl-2" v-show="checked.find(e => e == 'category')">
                        <div class="form-row"><div class="col-12"><input type="radio" value="Book" name="filter" id="Books" v-model="category"><label for="Books">&nbsp;&nbsp;Books</label></div></div>
                        <div class="form-row"><div class="col-12"><input type="radio" value="Hand Written Notes" name="filter" id="notes" v-model="category"><label for="notes">&nbsp;&nbsp;Hand Written Notes</label></div></div>
                        <div class="form-row"><div class="col-12"><input type="radio" value="Slides"  name="filter" id="Slides" v-model="category"><label for="Slides">&nbsp;&nbsp;Slides</label></div></div>
                        <div class="form-row"><div class="col-12"><input type="radio" value="Excel Sheets"  name="filter" id="Excel-Sheets" v-model="category"><label for="Excel-Sheets">&nbsp;&nbsp;Excel Sheets</label></div></div>
                        <div class="form-row"><div class="col-12"><input type="radio" value="Past Papers"  name="filter" id="Past-Papers" v-model="category"><label for="Past-Papers">&nbsp;&nbsp;Past Papers</label></div></div>
                        <div class="form-row"><div class="col-12"><input type="radio" value="Labs"  name="filter" id="Labs" v-model="category"><label for="Labs">&nbsp;&nbsp;Labs</label></div></div>
                    </ul>  
                    <div class="form-row  font-weight-bold"><div class="col-12"><input type="checkbox" value="sort" id="sort" v-model="checked"><label for="sort">&nbsp;&nbsp;Sort By</label></div></div>  
                    <ul class="pl-2" v-show="checked.find(e => e == 'sort')">
                        <div class="form-row"><div class="col-12"><input type="radio" value="download" name="sort" id="download" v-model="sortBy"><label for="download">&nbsp;&nbsp;Most Downloads</label></div></div>
                    </ul> 
                    <div class="form-row font-weight-bold"><div class="col-12"><input type="checkbox" value="date" id="dateT" v-model="checked"><label for="dateT">&nbsp;&nbsp;Date Uploaded</label></div></div>  
                    <div class="form-row" v-show="checked.find(e => e == 'date')"><input type="date" v-model="dateUploaded" id="date" class="form-control"></div>
                        </div>
                        <button title="Hide Side Panel" class="btn shadow" id="side-menu-btn-hide"><i class="fa fa-angle-left text-white" aria-hidden="true"></i></button>   
                        </div>
                        <div class="col-sm-6 col-md-9 side-bar-adjustment"></div>
                    </div>
                    </div>
                 </div>
            </div>
            <div class="container-fluid posts-container">
                <div class="row">
                    <div class="col-3 adjustment" style="display:none"></div>
                    <div class="col-12 shadow-main" id="posts">
                        <div class="row mt-3" id="all-posts-container">
                            <div class="col-12 p-3">
                                <h6 class="ml-2 mb-3">{{!searchText && !category && !subjectFilter ? 'All Posts' : 'Search Results'}}</h6>    
                            </div>
                            <div class="col-12 mt-2" class="all-posts">
                                <div class="row" v-show="category || subjectFilter">
                                    <div class="col-12"><h5>Filtered Content</h5></div>
                                    <div class="col-12" v-show="category"><h6>Category : {{category}}</h6></div>
                                    <div class="col-12" v-show="subjectFilter"><h6>Subject : {{subjectFilter}}</h6></div>
                                </div>
                                <div class="row" v-show="searchedPosts && !searchedPosts.length">
                                    <p class="text-center">NO POST FOUND</p>
                                </div>
                                <div class="row">
                                    <post v-for="(post,i) in searchedPosts" v-show="searchText || checked.length != 0 || i < postsShown" :data="post" :key="i"></post>
                                </div>
                            </div>
                            <div class="col-12 mt-2" v-show="searchedPosts && !searchText && checked.length == 0 && posts.length > 12">
                                <p class="text-center" v-show="postsShown < posts.length"><a href="" @click="increasePostsShown($event)">Show More</a></p>
                                <p class="text-center" v-show="postsShown >= posts.length"><a href="" @click="decreasePostsShown($event)">Show Less</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="mine-modal">
                <div class="mine-modal-content shadow-lg">
                    <div class="container-fluid">
                        <div class="row p-2 border-bottom">
                            <div class="col-12">
                                <i data-close="modal" class="float-right " style="font-size: 30px;">&times;</i>
                            </div>
                        </div>
                        <div class="row p-3 border-bottom">
                            <div class="col-12">
                                <h5 class="modal-title text-center text-main">UPLOAD FILE</h5>
                            </div>
                        </div>
                        <form id="upload-form" enctype="multipart/form-data">
                        <div class="row p-3 file-upload " style="height:50vh">
                            <div class="col-12 rounded file-upload-bg">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <p class="font-weight-bold" id="correct" style="font-size:1rem"><a href="" onclick="chooseFile(event)">Choose a file</a>  or just drap and drop here to upload</p>
                                </div>
                            </div>
                            <div class="col-12 rounded file-uploaded">
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                <i class="fileTypeIcon text-white" style="font-size:3rem;" aria-hidden="true"></i>
                                <p id="file-name" class="text-white mt-3"></p>
                                <button data-remove="file" class="btn btn-danger">REMOVE</button>
                                </div>
                            </div>     
                         <input type="file" name="file" id="file" class="d-none" accept=".doc,.docx,.pdf,.cpp,.pptx,.ppt,.xlsx,.xls">  
                        </form>
                        </div>
                        <div class="row p-3 modal-form" style="height: 50vh;overflow-y: scroll;display:none;">
                            <div class="col-12 col-lg-6">
                            <form action="#">
                                <div class="form-row mb-2">
                                    <div class="col-12 col-lg-6">
                                        <label for="fileName">File Name<span class="text-danger">*</span><span class="font-weight-normal">(File Name must be Self Explaining, No need to add extension)</span></label>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="text" name="" id="fileName" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-lg-6">
                                        <label for="description">Description <span class="font-weight-normal">(Any Important Detail About this File)</span></label>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <textarea id="description" cols="30" rows="5" maxlength="100" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-lg-6 order-0 order-lg-0">
                                        <label for="subject">Subject<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                                        <label for="type">Type<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                                        <select name="" id="subject" class="custom-select">
                                            <option value="" selected disabled>Select Subject</option>
                                            <option v-for="subject in subjects" :value="subject">{{subject}}</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6 order-3 order-lg-3">
                                        <select name="" id="type"  class="custom-select">
                                            <option value="" selected disabled>Select Type</option>
                                            <option v-for="type in types" :value="type">{{type}}</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-12">
                            <button data-next = "modal" class="btn bttn-material-flat sign-btn float-right" style="display:none">NEXT</button>
                            <button data-upload = "modal" class="btn bttn-material-flat sign-btn float-right" style="display:none">UPLOAD</button>
                            <button data-cancel = "modal" class="btn bttn-material-flat sign-btn float-right mr-2" style="display:none">BACK</button>
                            <button data-close="modal" class="btn bttn-material-flat sign-btn float-right mr-2">CLOSE</button>
                        </div>
                    </div>
                </div>
        </div>
        <div class="mine-modal-overlay"></div> 
        <!-- Modal -->
        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Change Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="col-12">
                                            <label for="old-password">Old Password</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="old-password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <label for="new-password">New Password</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="new-password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-change="password">Change</button>
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
            <div class="col-12 mt-2"><div class="uploader-name"><span :id="data.uploaderEmail"
            :data-image="data.userImageUploaded" 
            :data-datejoined="data.userDateJoined">👱&nbsp;&nbsp;{{data.uploaderEmail}}</span></div></div>
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
                <p><i class="fa fa-download" aria-hidden="true" @click="downloadFile"></i>
                <span class="small">{{data.downloads}}</span></p>
            </div>
        </div>
    </div>
</script>
<script src="js/posts.js"></script> 
<script>
    let modelForm = new Vue({
        el : '.mine-modal',
        data(){
            return {
                subjects: subjects,
                types:['Book','Hand Written Notes','Slides','Excel Sheets','Past Papers','Labs']
            }
        }
    })
</script>
<script src="js/fileUploading.js"></script> 
<script>
    $('[data-change="password"]').click(()=>{
        let oldPassword = $('#old-password').val();
        let newPassword = $('#new-password').val();
        if(newPassword.length < 8)
            alert('Password is too short, must be at least 8 characters')
        else if( newPassword.indexOf(' ') > -1)
            alert('Password must not contain space')
        else{
            $('.loader').show();
            $.post('php/changePassword.php',{old:oldPassword, new:newPassword},(data, s) => {
                $('.loader').hide();
                alert(data);
            })
        }
    })
    $("form").submit(e => {e.preventDefault()})
    const uploadButton = () =>{
        if($('#fileName').val() != '' && $('#subject').val() != null && $('#type').val() !=null)
            $('[data-upload="modal"]').show()
        else
            $('[data-upload="modal"]').hide()
    }
    document.getElementById('fileName').onkeyup = uploadButton 
    document.querySelectorAll('#subject,#type').forEach(ele => {ele.onchange = uploadButton})
    if(window.innerWidth < 768) {
        window.onscroll = ()=>{
            if(window.scrollY >= 10)
                $('.navbar-brand,.dropright').css('display','none');
            else if(window.scrollY == 0)
                $('.navbar-brand,.dropright').css('display','block');
            else if(window.scrollY < 10)
                $('.navbar-brand,.dropright').css('display','none');
    }
    }
    $('#side-menu-btn').click(()=>{
        $('#side-menu-btn').hide()
        $('.side-bar').css('display','block')
    })
    $('#side-menu-btn-hide,.side-bar-adjustment').click(()=>{
        $('#side-menu-btn').show()
        $('.side-bar').css('display','none')
    })
    window.onload = window.onresize = () =>{
    $('#side-menu-btn').click(()=>{
        if(window.innerWidth > 768){
        $('#posts').removeClass('col-12').addClass('col-9')
        $('.adjustment').show()
        }
        else
            $('.side-bar-container').css('z-index','11')
    })
    $('#side-menu-btn-hide,.side-bar-adjustment').click(()=>{
        $('#posts').addClass('col-12')
        if(window.innerWidth > 768){
        $('#posts').removeClass('col-9').addClass('col-12')
        $('.adjustment').hide()
        }
        else
          $('.side-bar-container').css('z-index','')
    })
    }
</script>
<script src="js/userinfo.js"></script>
</html>
//file handling code
let uploadData = null;
let allowedFileTypes = [
  'application/pdf',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'application/vnd.ms-excel',
  'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
  'application/vnd.openxmlformats-officedocument.presentationml.presentation',
  'application/vnd.ms-powerpoint',
];
const clearFileData = () => {
  $('#fileName,#description').val('');
  $('#subject,#type').val(null);
};
const GetfileIcon = fileType => {
  let iconsClasses = [
    'fa fa-file-powerpoint-o',
    'fa fa-file-word-o',
    'fa fa-file-pdf-o',
    'fa fa-file-excel-o',
  ];
  if (fileType == allowedFileTypes[0]) return iconsClasses[2];
  if (fileType == allowedFileTypes[1] || fileType == allowedFileTypes[2])
    return iconsClasses[1];
  if (fileType == allowedFileTypes[3] || fileType == allowedFileTypes[4])
    return iconsClasses[3];
  return iconsClasses[0];
};
const removeFileExtension = fileName => {
  fileName = fileName.split('').reverse().join('');
  let ext = fileName
    .substr(fileName.indexOf('.') + 1)
    .split('')
    .reverse()
    .join('');
  return ext;
};
const validFileName = fileName => {
  let result = /(?!(?:COM[0-9]|CON|LPT[0-9]|NUL|PRN|AUX|com[0-9]|con|lpt[0-9]|nul|prn|aux)|[\s\.])[^\\\/:*"?<>|]{1,254}/.exec(
    fileName
  )[0];
  return fileName == result;
};
const chooseFile = e => {
  e.preventDefault();
  $('#file').click();
};
const fileUploading = fileList => {
  if (fileList.length > 1) {
    alert('Only one file can be uploaded at a time');
    return;
  }
  let file = fileList[0];
  if (allowedFileTypes.findIndex(ele => ele == file.type) == -1)
    alert('This File type is not Allowed');
  else if (file.size > 200000000) alert('File Size must be less than 200MB');
  else {
    $('.fileTypeIcon').addClass(GetfileIcon(file.type));
    $('#file-name').html(file.name);
    $('.file-upload-bg').hide();
    $('#fileName').val(removeFileExtension(file.name));
    $('.file-uploaded').show();
    $('[data-next="modal"]').show();
    uploadData = new FormData();
    uploadData.append('file', file);
  }
};
$('[data-next="modal"]').click(() => {
  $('.file-upload').hide();
  $('[data-next="modal"],button[data-close="modal"]').hide();
  $('.modal-form,[data-cancel="modal"]').show();
});
$('[data-cancel="modal"]').click(() => {
  $('.file-upload').show();
  $('[data-next="modal"],button[data-close="modal"]').show();
  $('.modal-form,[data-cancel="modal"],[data-upload="modal"]').hide();
  clearFileData();
});
$('#file').change(() => {
  fileUploading(document.querySelector('#file').files);
});
$('[data-mine="modal"]').click(e => {
  e.preventDefault();
  $('.mine-modal-overlay').fadeIn('fast');
  $('.mine-modal').slideDown('fast');
});
$('[data-close="modal"],.mine-modal-overlay').click(() => {
  $('.mine-modal').slideUp('fast');
  $('.mine-modal-overlay').fadeOut('fast');
});
$('[data-remove="file"]').click(() => {
  $('[data-next="modal"]').hide();
  $('.file-uploaded').hide();
  $('.file-upload-bg').show();
});
$('.file-uploaded')
  .on('drop', e => {
    e.preventDefault();
    alert('Only One File can be Uploaded at a time');
  })
  .on('dragover', e => {
    e.preventDefault();
  });
$('.file-upload-bg')
  .on('dragover', e => {
    e.preventDefault();
    $('.file-upload-bg').css('background-color', 'white');
  })
  .on('dragleave', e => {
    e.preventDefault();
    $('.file-upload-bg').css('background-color', 'rgb(241, 241, 241)');
  })
  .on('drop', ev => {
    ev.preventDefault();
    $('.file-upload-bg').css('background-color', 'rgb(241, 241, 241)');
    if (ev.originalEvent.dataTransfer.items) {
      if (ev.originalEvent.dataTransfer.items.length > 1)
        alert('Only One File can be uploaded at a time.');
      else {
        if (ev.originalEvent.dataTransfer.items[0].kind == 'file')
          fileUploading(
            Array(ev.originalEvent.dataTransfer.items[0].getAsFile())
          );
      }
    } else fileUploading(ev.originalEvent.dataTransfer.files);
  });
class Post {
  constructor(subject, type, date, user, fileName) {
    this.subject = subject;
    this.type = type;
    this.date = date;
    this.user = user;
    this.fileName = fileName;
    this.downloads = 0;
  }
}
$("[data-upload='modal']").click(() => {
  if (uploadData == null) return;
  if (
    $('#fileName').val() == '' ||
    $('#subject').val() == '' ||
    $('#type').val() == ''
  )
    return;
  if (!validFileName($('#fileName').val())) {
    alert('Invalid File Name');
    return;
  }
  uploadData.append('fileName', $('#fileName').val());
  uploadData.append('description', $('#description').val());
  uploadData.append('subject', $('#subject').val());
  uploadData.append('category', $('#type').val());
  $.ajax({
    url: 'php/fileUpload.php',
    type: 'POST',
    data: uploadData,
    cache: false,
    contentType: false,
    processData: false,
    success(data) {
      data = JSON.parse(data);
      $('.loader').show();
      if (
        typeof data == 'object' ||
        data == 'File Type Not Allowed' ||
        data == 'File Size Must be at most 200 MB'
      ) {
        $('[data-cancel="modal"]').click();
        $('[data-remove="file"]').click();
        clearFileData();
      }
      $('.loader').hide();
      if (typeof data == 'object') {
        postsVue.posts.unshift(data);
        $('[data-close="modal"]').click();
        alert('File has been successfully uploaded');
      } else alert(data);
    },
  });
});

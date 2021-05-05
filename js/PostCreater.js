let posts = null;

posts = (function () {
  let posts = null;
  $.post(
    "php/postCreater.php",
    (data, s) => {
      posts = data;
    },
    (dataType = "json")
  );
  return posts;
})();

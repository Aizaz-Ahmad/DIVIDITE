let degrees = [
  'Software Engineering',
  'Information Technology',
  'Computer Science',
];
let i = 0;
const getDegree = abbr => {
  if (abbr == 'SE') return degrees[0];
  else if (abbr == 'IT') return degrees[1];
  return degrees[2];
};
$(document).on('mouseover', '.uploader-name > span', e => {
  if (window.innerWidth < 768) return;
  console.log(++i);
  let user = e.currentTarget;
  let dateJoined = user.dataset.datejoined;
  let userId = user.id.substring(0, 10).toUpperCase();
  let image =
    'images/' +
    (user.dataset.image == '1' ? `${userId.toLowerCase()}` : 'users') +
    '.jpg';
  let degree = getDegree(userId[1] + userId[2]);

  let top = user.getBoundingClientRect().top;
  let left = user.getBoundingClientRect().left;
  let userInfoDiv = document.createElement('div');
  userInfoDiv.classList.add('container-fluid');
  userInfoDiv.classList.add('uploader-info');
  userInfoDiv.innerHTML = `
    <div id="uploader-info-before"></div>
    <div class="row mt-3" style="height:100px;">
        <div class="col-3 h-100">
          <div class="uploader-image m-auto" style="background-image:url(${image})"></div>
        </div>
        <div class="col-9 h-100"><h2 class="m-auto text-main">${userId}</h2></div>
    </div>
    <div class="row">
      <div class="col-12">
        <p  class="mb-1">
          <span class="font-weight-bold">Degree: </span
          >${degree}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p class="mb-1">
          <span class="font-weight-bold">Batch: </span
          >${userId[3] + userId[4] + userId[5]}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p>
          <span class="font-weight-bold">Date Joined: </span
          >${dateJoined}
        </p>
      </div>
    </div>
`;
  userInfoDiv.style.position = 'fixed';
  document.body.insertBefore(
    userInfoDiv,
    document.getElementsByClassName('loader')[0]
  );
  if (left + 400 + 200 > window.innerWidth) {
    userInfoDiv.style.top = `${top + 25}px`;
    userInfoDiv.style.left = `${left - 220}px`;
  } else {
    userInfoDiv.style.top = `${top}px`;
    userInfoDiv.style.left = `${left + 220}px`;
  }
  let height = window.getComputedStyle(userInfoDiv).height;
  height = Number(height.substring(0, height.indexOf('px'))) + top;
  if (height > window.innerHeight) userInfoDiv.style.top = `${top - 212}px`;
});
let handle;
const removeNode = () => {
  clearInterval(handle);
  document.getElementsByClassName('uploader-info')[0].remove();
};
$(document).on('mouseout', '.uploader-name > span', () => {
  // handle = setTimeout(removeNode, 500);
  console.log(--i);
  if (document.getElementsByClassName('uploader-info') == undefined) return;
  document.getElementsByClassName('uploader-info')[0].remove();
});

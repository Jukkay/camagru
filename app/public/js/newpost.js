if (uid == 0) {
    alert('Please, login first.');
    location.href = '/';
    throw new Error('Please, login first.');
}

let gallery = document.getElementById('gallery');
let preview = document.getElementById('preview');
let description = document.getElementById('description');
const urlParameters = window.location.search;
const parameters = new URLSearchParams(urlParameters);
const image = parameters.get('image');

// Fetches user's images to drafts
function getUserImages(uid) {
    if (uid == 0) {
        gallery.innerHTML = '';
        return;
    }
    fetch('/fetcheditor?uid=' + uid)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            gallery.innerHTML = text;
        });
}

// Renders selected image from drafts to preview
function editImage(base) {
    let baseImg = document.getElementById(base).src;
    console.log(baseImg);
    preview.setAttribute('src', baseImg);
    preview.classList.remove('is-hidden');
}

// Delete image
function deleteImage(filename) {
    if (uid == 0 || filename == '') {
        return;
    }
    var formData = new FormData();
    formData.append('img', filename);
    formData.append('uid', uid);
    $request = new Request('/deleteimage', {
        method: 'POST',
        body: formData,
    });
    fetch($request).then(function (response) {
        getUserImages(uid);
    });
}

// Submits image and description to backend

const submitPost = () => {};

// Gallery event listener
gallery.addEventListener('click', function (e) {
    let id = e.target.id;
    let parent = e.target;
    let action = parent.innerHTML;
    if (action == 'Delete') {
        id = id.replace('delete', '');
        parent = 'parent' + id;
        console.log(parent);
        document.getElementById(parent).remove();
        deleteImage(id);
    }
    if (action == 'Edit') {
        id = id.replace('edit', '');
        editImage(id);
    }
});

if (preview.hasAttribute('src')) preview.classList.remove('is-hidden');

// Load user images on startup
getUserImages(uid);

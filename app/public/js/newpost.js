if (uid == 0) {
    alert('Please, login first.');
    location.href = '/';
    throw new Error('Please, login first.');
}

let gallery = document.getElementById('gallery');
let preview = document.getElementById('preview');
let description = document.getElementById('description');
let submit = document.getElementById('submit');
const urlParameters = window.location.search;
const parameters = new URLSearchParams(urlParameters);
let image = parameters.get('image');

// Fetches user's images to drafts
const getUserImages = (uid) => {
    if (uid == 0) {
        gallery.innerHTML = '';
        return;
    }
    fetch('/fetchdrafts?uid=' + uid)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            gallery.innerHTML = text;
        });
};

// Renders selected image from drafts to preview
const editImage = (base) => {
    image = base;
    let baseImg = document.getElementById(base).src;
    preview.setAttribute('src', baseImg);
    preview.classList.remove('is-hidden');
};

// Delete image
const deleteImage = (filename) => {
    if (uid == 0 || filename == '') {
        return;
    }
    var formData = new FormData();
    formData.append('img', filename);
    formData.append('uid', uid);
    $request = new Request('/deletedraft', {
        method: 'POST',
        body: formData,
    });
    fetch($request).then(function (response) {
        getUserImages(uid);
    });
};

// Submits image and description to backend
const submitPost = () => {
    if (uid == 0 || image == '' || description.value == '') {
        console.log('empty input!');
        return;
    }
    var formData = new FormData();
    formData.append('user_id', uid);
    formData.append('image', image);
    formData.append('description', description.value);
    $request = new Request('/savepost', {
        method: 'POST',
        body: formData,
    });
    fetch($request)
        .then(function (response) {
            location.href = '/';
        })
        .catch(function (error) {
            console.log(error);
        });
};

// Gallery event listener
gallery.addEventListener('click', (e) => {
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

submit.addEventListener('click', () => {
    submitPost();
});
if (preview.hasAttribute('src')) preview.classList.remove('is-hidden');

// Load user images on startup
getUserImages(uid);

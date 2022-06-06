let start = document.getElementById('start');
let upload = document.getElementById('upload');
let imageInput = document.getElementById('image-input');
let video = document.getElementById('videoframe');
let overlay = document.getElementById('overlay');
let overlaywrapper = document.getElementById('overlaywrapper');
let canvas = document.getElementById('canvas');
let preview = document.getElementById('preview');
let help1 = document.getElementById('help1');
let help2 = document.getElementById('help2');
let close = document.getElementById('close');
let snapshot = document.getElementById('snapshot');
let save = document.getElementById('save');
let canvasbuttons = document.getElementById('canvasbuttons');
let post = document.getElementById('post');
let photo = document.getElementById('photo');
let gallery = document.getElementById('gallery');
let star = document.getElementById('star');
let removestar = document.getElementById('removestar');
let cat = document.getElementById('cat');
let removecat = document.getElementById('removecat');
let bus = document.getElementById('bus');
let removebus = document.getElementById('removebus');
let frenchie = document.getElementById('frenchie');
let removefrenchie = document.getElementById('removefrenchie');
let mexican = document.getElementById('mexican');
let removemexican = document.getElementById('removemexican');
let width = 1440;
let height = 0;
let stickerData = [];
let sticker;
let stickerWidth;
let stickerCount = 0;
let imageData;
let streaming = false;

// Camera configuration
let constraints = {
    audio: true,
    video: {
        width: {max: 1440},
        height: {max: 1440},
        aspectRatio: {ideal: 1}
    },
};
let mediaDevices = navigator.mediaDevices;

if (user_id == 0) {
    alert('Please, login first.');
    location.href = '/';
    throw new Error('Please, login first.');
}
// Fetches users images to drafts
function getUserImages(user_id) {
    if (user_id == 0) {
        gallery.innerHTML = '';
        return;
    }
    fetch('/fetchdrafts?user_id=' + user_id)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            gallery.innerHTML = text;
        });
}
// Add sticker to overlay
function addSticker(sticker) {
    getStickerData(sticker);
    let stickerImg = new Image();
    stickerImg.onload = onload;
    stickerImg.src = 'assets/stickers/' + sticker;
    stickerImg.setAttribute('id', 'overlay' + sticker);
    stickerImg.setAttribute('draggable', 'true');
    stickerImg.classList.add('overlayitem');
    stickerImg.style.left = '20px';
    stickerImg.style.top = '20px';
    overlaywrapper.appendChild(stickerImg);

    canvasbuttons.classList.remove('is-hidden');
    help1.classList.add('is-hidden');
    if (stickerCount == 0) help2.classList.remove('is-hidden');
    else help2.classList.add('is-hidden');
    stickerCount++;
}

// Remove sticker from overlay
function removeSticker(sticker) {
    let deleteItem = document.getElementById('overlay' + sticker);
    deleteItem.remove();
    stickerData = stickerData.filter((item) => item[1] !== sticker);
}

// Adds sticker's image data to array for backend
function getStickerData(sticker) {
    let context = canvas.getContext('2d');
    let img = document.getElementById(sticker);
    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight;
    context.drawImage(img, 0, 0);
    imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
    stickerData.push([
        imageData,
        sticker,
        '',
        '',
        img.naturalWidth,
        img.naturalHeight,
    ]);
}

// Renders image to preview
function previewImage() {
    let context = canvas.getContext('2d');
    if (!width || !height) {
        // 	clearphoto();
        return;
    }
    canvas.width = width;
    canvas.height = height;
    context.drawImage(video, 0, 0, width, height);
    imageData = canvas.toDataURL();
    preview.setAttribute('src', imageData);
    video.classList.add('is-hidden');
    preview.classList.remove('is-hidden');
    save.removeAttribute('disabled');
    post.classList.remove('is-hidden');
}

// Renders uploaded image to preview
function previewUpload(baseImg) {
    let context = canvas.getContext('2d');
    canvas.width = baseImg.width;
    canvas.height = baseImg.height;
    context.drawImage(baseImg, 0, 0, baseImg.width, baseImg.height);
    imageData = canvas.toDataURL();
    preview.classList.remove('is-hidden');
    video.classList.add('is-hidden');
    preview.setAttribute('src', imageData);
    post.classList.remove('is-hidden');
}

// Renders selected image from drafts to preview
function editImage(base) {
    let context = canvas.getContext('2d');
    let baseImg = document.getElementById(base);
    canvas.width = baseImg.naturalWidth;
    canvas.height = baseImg.naturalHeight;
    context.drawImage(baseImg, 0, 0);
    imageData = canvas.toDataURL();
    preview.setAttribute('src', imageData);
    video.classList.add('is-hidden');
    overlaywrapper.classList.remove('is-hidden');
    snapshot.classList.remove('is-hidden');
    save.classList.remove('is-hidden');
    preview.classList.remove('is-hidden');
    post.classList.remove('is-hidden');
    save.removeAttribute('disabled');
    close.classList.remove('is-hidden');
    help2.classList.add('is-hidden');
}

// Stores sticker location information to stickerdata array
function getStickerLocation() {
    let stickersInOverlay =
        overlaywrapper.getElementsByClassName('overlayitem');
    let i = 0;
    for (sticker of stickersInOverlay) {
        stickerData[i][2] =
            (sticker.style.left.replace('px', '') /
                overlaywrapper.clientWidth) *
            width;
        stickerData[i][3] =
            (sticker.style.top.replace('px', '') /
                overlaywrapper.clientHeight) *
            height;
        i++;
    }
}

// Sends images to backend to be merged and saved
async function saveImage() {
    if (user_id == 0) {
        return;
    }
    imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
    var formData = new FormData();
    formData.append('img', imageData);
    if (stickerData.length > 0) {
        getStickerLocation();
        stickerData.forEach((element) => {
            formData.append('stickers[]', element);
        });
    }
    formData.append('user_id', user_id);
    $request = new Request('/savedraft', {
        method: 'POST',
        body: formData,
    });
    const response = await fetch($request)
        .then((response) => response.text())
        .then((filename) => {
            getUserImages(user_id);
            return filename;
        })
        .catch(function (error) {
            console.log(error);
        });
    return response;
}

// Delete image
function deleteImage(filename) {
    if (user_id == 0 || filename == '') {
        return;
    }
    var formData = new FormData();
    formData.append('img', filename);
    formData.append('user_id', user_id);
    $request = new Request('/deletedraft', {
        method: 'POST',
        body: formData,
    });
    fetch($request).then(function (response) {
        getUserImages(user_id);
    });
}
// Video frame initialization
video.addEventListener(
    'canplay',
    function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);

            if (isNaN(height)) {
                height = width / (4 / 3);
            }
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            overlaywrapper.setAttribute('width', width);
            overlaywrapper.setAttribute('height', height);
            streaming = true;
        }
    },
    false
);

// Event listeners for stickers
star.addEventListener('click', function () {
    star.classList.add('is-hidden');
    removestar.classList.remove('is-hidden');
    addSticker('216.png');
});
cat.addEventListener('click', function () {
    cat.classList.add('is-hidden');
    removecat.classList.remove('is-hidden');
    addSticker('cat-g9264252fd_640.png');
});
bus.addEventListener('click', function () {
    bus.classList.add('is-hidden');
    removebus.classList.remove('is-hidden');
    addSticker('clipart-g4b3e1b4ae_640.png');
});
frenchie.addEventListener('click', function () {
    frenchie.classList.add('is-hidden');
    removefrenchie.classList.remove('is-hidden');
    addSticker('french-bulldog-gc086eb3d9_640.png');
});
mexican.addEventListener('click', function () {
    mexican.classList.add('is-hidden');
    removemexican.classList.remove('is-hidden');
    addSticker('man-gdf72c5265_640.png');
});
removestar.addEventListener('click', function () {
    removestar.classList.add('is-hidden');
    star.classList.remove('is-hidden');
    removeSticker('216.png');
});
removecat.addEventListener('click', function () {
    removecat.classList.add('is-hidden');
    cat.classList.remove('is-hidden');
    removeSticker('cat-g9264252fd_640.png');
});
removebus.addEventListener('click', function () {
    removebus.classList.add('is-hidden');
    bus.classList.remove('is-hidden');
    removeSticker('clipart-g4b3e1b4ae_640.png');
});
removefrenchie.addEventListener('click', function () {
    removefrenchie.classList.add('is-hidden');
    frenchie.classList.remove('is-hidden');
    removeSticker('french-bulldog-gc086eb3d9_640.png');
});
removemexican.addEventListener('click', function () {
    removemexican.classList.add('is-hidden');
    mexican.classList.remove('is-hidden');
    removeSticker('man-gdf72c5265_640.png');
});

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

// Event listeners for buttons
start.addEventListener('click', function () {
    mediaDevices
        .getUserMedia(constraints)
        .then((stream) => {
            video.srcObject = stream;
            video.play();
            preview.classList.add('is-hidden');
            overlaywrapper.classList.remove('is-hidden');
            video.classList.remove('is-hidden');
            help2.classList.add('is-hidden');
            snapshot.removeAttribute('disabled');
            close.removeAttribute('disabled');
            close.classList.remove('is-hidden');
            snapshot.classList.remove('is-hidden');
            save.classList.remove('is-hidden');
        })
        .catch(function (error) {
            console.log(error);
        });
});

upload.addEventListener('click', function () {
    help2.classList.add('is-hidden');
    overlaywrapper.classList.remove('is-hidden');
    save.removeAttribute('disabled');
    save.classList.remove('is-hidden');
    imageInput.click();
});

imageInput.addEventListener('change', function (event) {
    if (event.target.files) {
        let inputImg = event.target.files[0];
        let fileReader = new FileReader();
        fileReader.readAsDataURL(inputImg);
        fileReader.addEventListener('load', function (event) {
            let uploadImg = new Image();
            uploadImg.src = event.target.result;
            uploadImg.addEventListener('load', function (event) {
                previewUpload(uploadImg);
            });
        });
    }
});

close.addEventListener('click', function () {
    let stream = video.srcObject;
    let tracks = stream.getTracks();

    for (let i = 0; i < tracks.length; i++) {
        tracks[i].stop();
    }
    video.srcObject = null;
    // canvasbuttons.classList.remove('is-hidden');
    canvas.removeAttribute('height');
    canvas.removeAttribute('width');
    video.removeAttribute('height');
    video.removeAttribute('width');
});

snapshot.addEventListener('click', function () {
    previewImage();
});

save.addEventListener('click', function () {
    saveImage();
});

post.addEventListener('click', async () => {
    const imageName = await saveImage();
    location.href = `/newpost?image=${imageName}`;
});

// Drag and drop stickers

let mouseDown = false;
let pointer;
let boundX;
let boundY;
let pointerPositionLeft;
let pointerPositionTop;

overlaywrapper.addEventListener('pointerdown', (event) => {
    mouseDown = true;
    if (!event.target.classList.contains('overlayitem')) return;
    pointer = document.getElementById(event.target.id);
    pointer.ondragstart = () => false;
    boundX = event.clientX - pointer.getBoundingClientRect().left;
    boundY = event.clientY - pointer.getBoundingClientRect().top;
});

overlaywrapper.addEventListener('pointermove', (event) => {
    if (!mouseDown || event.offsetX < 1 || event.offsetY < 1) return;
    rightEdge =
        event.clientX -
        overlaywrapper.offsetParent.offsetLeft -
        boundX +
        pointer.offsetWidth;
    bottomEdge =
        event.clientY -
        overlaywrapper.offsetTop -
        boundY +
        pointer.offsetHeight;
    if (
        rightEdge > overlaywrapper.offsetWidth ||
        bottomEdge > overlaywrapper.offsetHeight
    )
        return;
    pointerPositionLeft =
        event.clientX - overlaywrapper.offsetParent.offsetLeft - boundX;
    pointerPositionTop = event.clientY - overlaywrapper.offsetTop - boundY;
    pointer.style.left =
        pointerPositionLeft < 0 ? `0px` : `${pointerPositionLeft}px`;
    pointer.style.top =
        pointerPositionTop < 0 ? `0px` : `${pointerPositionTop}px`;
});

document.addEventListener('pointerup', (event) => {
    mouseDown = false;
});

// Load user images on startup
getUserImages(user_id);

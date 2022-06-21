const start = document.getElementById('start')
const upload = document.getElementById('upload')
const imageInput = document.getElementById('image-input')
const video = document.getElementById('videoframe')
const overlay = document.getElementById('overlay')
const overlaywrapper = document.getElementById('overlaywrapper')
const canvas = document.getElementById('canvas')
const preview = document.getElementById('preview')
const help1 = document.getElementById('help1')
const help2 = document.getElementById('help2')
const close = document.getElementById('close')
const snapshot = document.getElementById('snapshot')
const save = document.getElementById('save')
const canvasbuttons = document.getElementById('canvasbuttons')
const post = document.getElementById('post')
const photo = document.getElementById('photo')
const gallery = document.getElementById('gallery')
const star = document.getElementById('star')
const removestar = document.getElementById('removestar')
const cat = document.getElementById('cat')
const removecat = document.getElementById('removecat')
const bus = document.getElementById('bus')
const removebus = document.getElementById('removebus')
const frenchie = document.getElementById('frenchie')
const removefrenchie = document.getElementById('removefrenchie')
const mexican = document.getElementById('mexican')
const removemexican = document.getElementById('removemexican')
const opacity = document.getElementById('opacity')
const notification = document.getElementById('notification')
const deletebutton = document.getElementById('deletebutton')
const help = document.getElementById('help')
const helpbutton = document.getElementById('helpbutton')
const deletehelp = document.getElementById('deletehelp')
const closehelp = document.getElementById('closehelp')
let notification_closed = false
let width = 1440
let height = 0
let stickerData = []
let sticker
let stickerWidth
let stickerCount = 0
let imageData
let streaming = false

// Camera configuration
const constraints = {
    audio: false,
    video: {
        width: { max: 1440 },
        height: { max: 1440 },
        aspectRatio: { ideal: 1 },
    },
}
let mediaDevices = navigator.mediaDevices

if (user_id == 0) {
    alert('Please, login first.')
    location.href = '/'
}
// Fetches users images to drafts
const getUserImages = (user_id) => {
    if (user_id == 0) {
        gallery.innerHTML = ''
        return
    }
    fetch('/fetchdrafts?user_id=' + user_id)
        .then((response) => {
            return response.text()
        })
        .then((text) => {
            gallery.innerHTML = text
        })
}
// Add sticker to overlay
const addSticker = (sticker) => {
    getStickerData(sticker)
    let stickerImg = new Image()
    stickerImg.onload = onload
    stickerImg.src = 'assets/stickers/' + sticker
    stickerImg.setAttribute('id', 'overlay' + sticker)
    stickerImg.setAttribute('draggable', 'true')
    stickerImg.classList.add('overlayitem')
    stickerImg.classList.add('is-clickable')
    stickerImg.style.left = '20px'
    stickerImg.style.top = '20px'
    stickerImg.style.width = '200px'
    overlaywrapper.appendChild(stickerImg)
    canvasbuttons.classList.remove('is-hidden')
    gallery.classList.remove('is-hidden')
    help1.classList.add('is-hidden')
    if (stickerCount == 0) help2.classList.remove('is-hidden')
    else help2.classList.add('is-hidden')
    stickerCount++
}

// Remove sticker from overlay
const removeSticker = (sticker) => {
    let deleteItem = document.getElementById('overlay' + sticker)
    deleteItem.remove()
    stickerData = stickerData.filter((item) => item[1] !== sticker)
}

// Adds sticker's image data to array for backend
const getStickerData = (sticker) => {
    let context = canvas.getContext('2d')
    let img = document.getElementById(sticker)
    canvas.width = img.naturalWidth
    canvas.height = img.naturalHeight
    context.drawImage(img, 0, 0)
    imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '')
    stickerData.push([imageData, sticker, '', '', width, height, ''])
}

// Renders image to preview
const previewImage = () => {
    let context = canvas.getContext('2d')
    if (!width || !height) return
    canvas.width = width
    canvas.height = height
    context.drawImage(video, 0, 0, width, height)
    imageData = canvas.toDataURL()
    preview.setAttribute('src', imageData)
    video.classList.add('is-hidden')
    preview.classList.remove('is-hidden')
    save.removeAttribute('disabled')
    post.classList.remove('is-hidden')
}

// Renders uploaded image to preview
const previewUpload = (baseImg) => {
    let context = canvas.getContext('2d')
    canvas.width = baseImg.width
    canvas.height = baseImg.height
    width = baseImg.width
    height = baseImg.height
    context.drawImage(baseImg, 0, 0, baseImg.width, baseImg.height)
    imageData = canvas.toDataURL()
    preview.classList.remove('is-hidden')
    video.classList.add('is-hidden')
    preview.setAttribute('src', imageData)
    post.classList.remove('is-hidden')
    opacity.classList.remove('is-hidden')
    if (!notification_closed) notification.classList.remove('is-hidden')
}

// Renders selected image from drafts to preview
const editImage = (base) => {
    let context = canvas.getContext('2d')
    canvas.width = base.naturalWidth
    canvas.height = base.naturalHeight
    width = base.naturalWidth
    height = base.naturalHeight
    context.drawImage(base, 0, 0, width, height)
    imageData = canvas.toDataURL()
    preview.setAttribute('src', imageData)
    video.classList.add('is-hidden')
    overlaywrapper.classList.remove('is-hidden')
    snapshot.classList.remove('is-hidden')
    save.classList.remove('is-hidden')
    preview.classList.remove('is-hidden')
    post.classList.remove('is-hidden')
    save.removeAttribute('disabled')
    close.classList.remove('is-hidden')
    opacity.classList.remove('is-hidden')
    help2.classList.add('is-hidden')
    if (!notification_closed) notification.classList.remove('is-hidden')
}

// Stores sticker location information to stickerdata array
const getStickerLocation = () => {
    let stickersInOverlay = overlaywrapper.getElementsByClassName('overlayitem')
    let i = 0
    for (sticker of stickersInOverlay) {
        const sticker_width =
            (sticker.clientWidth / overlaywrapper.clientWidth) * width
        const sticker_height =
            (sticker.clientHeight / overlaywrapper.clientHeight) * height
        stickerData[i][2] =
            (sticker.style.left.replace('px', '') /
                overlaywrapper.clientWidth) *
            width
        stickerData[i][3] =
            (sticker.style.top.replace('px', '') /
                overlaywrapper.clientHeight) *
            height
        stickerData[i][4] = sticker_width
        stickerData[i][5] = sticker_height
        stickerData[i][6] = opacity.value
        i++
    }
}

// Sends images to backend to be merged and saved
const saveImage = async () => {
    if (user_id == 0) return
    imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '')
    var formData = new FormData()
    formData.append('img', imageData)
    if (stickerData.length > 0) {
        getStickerLocation()
        stickerData.forEach((element) => {
            formData.append('stickers[]', element)
        })
    }
    formData.append('user_id', user_id)
    $request = new Request('/savedraft', {
        method: 'POST',
        body: formData,
    })
    const response = await fetch($request)
        .then((response) => response.text())
        .then((filename) => {
            return filename
        })
        .catch(function (error) {
            console.log(error)
        })
    return response
}

// Delete image
const deleteImage = (filename) => {
    if (user_id == 0 || filename == '') return
    var formData = new FormData()
    formData.append('img', filename)
    formData.append('user_id', user_id)
    $request = new Request('/deletedraft', {
        method: 'POST',
        body: formData,
    })
    fetch($request).then(() => {
        getUserImages(user_id)
    })
}

// Video frame initialization
video.addEventListener(
    'canplay',
    () => {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width)

            if (isNaN(height)) {
                height = width / (4 / 3)
            }
            video.setAttribute('width', width)
            video.setAttribute('height', height)
            canvas.setAttribute('width', width)
            canvas.setAttribute('height', height)
            overlaywrapper.setAttribute('width', width)
            overlaywrapper.setAttribute('height', height)
            streaming = true
        }
    },
    false
)

// Event listeners for stickers
star.addEventListener('click', () => {
    star.classList.add('is-hidden')
    removestar.classList.remove('is-hidden')
    addSticker('216.png')
})
cat.addEventListener('click', () => {
    cat.classList.add('is-hidden')
    removecat.classList.remove('is-hidden')
    addSticker('cat-g9264252fd_640.png')
})
bus.addEventListener('click', () => {
    bus.classList.add('is-hidden')
    removebus.classList.remove('is-hidden')
    addSticker('clipart-g4b3e1b4ae_640.png')
})
frenchie.addEventListener('click', () => {
    frenchie.classList.add('is-hidden')
    removefrenchie.classList.remove('is-hidden')
    addSticker('french-bulldog-gc086eb3d9_640.png')
})
mexican.addEventListener('click', () => {
    mexican.classList.add('is-hidden')
    removemexican.classList.remove('is-hidden')
    addSticker('man-gdf72c5265_640.png')
})
removestar.addEventListener('click', () => {
    removestar.classList.add('is-hidden')
    star.classList.remove('is-hidden')
    removeSticker('216.png')
})
removecat.addEventListener('click', () => {
    removecat.classList.add('is-hidden')
    cat.classList.remove('is-hidden')
    removeSticker('cat-g9264252fd_640.png')
})
removebus.addEventListener('click', () => {
    removebus.classList.add('is-hidden')
    bus.classList.remove('is-hidden')
    removeSticker('clipart-g4b3e1b4ae_640.png')
})
removefrenchie.addEventListener('click', () => {
    removefrenchie.classList.add('is-hidden')
    frenchie.classList.remove('is-hidden')
    removeSticker('french-bulldog-gc086eb3d9_640.png')
})
removemexican.addEventListener('click', () => {
    removemexican.classList.add('is-hidden')
    mexican.classList.remove('is-hidden')
    removeSticker('man-gdf72c5265_640.png')
})

// Gallery event listener
gallery.addEventListener('click', (e) => {
    let id = e.target.id
    let parent = e.target
    let action = parent.innerHTML
    if (action == 'Delete') {
        id = id.replace('delete', '')
        parent = 'parent' + id
        document.getElementById(parent).remove()
        deleteImage(id)
    }
    if (action == 'Edit') {
        id = id.replace('edit', '')
        let base = document.getElementById(id)
        editImage(base)
    }
})

// Event listeners for buttons
start.addEventListener('click', () => {
    mediaDevices
        .getUserMedia(constraints)
        .then((stream) => {
            video.srcObject = stream
            video.play()
            preview.classList.add('is-hidden')
            overlaywrapper.classList.remove('is-hidden')
            video.classList.remove('is-hidden')
            help2.classList.add('is-hidden')
            snapshot.removeAttribute('disabled')
            close.removeAttribute('disabled')
            close.classList.remove('is-hidden')
            snapshot.classList.remove('is-hidden')
            save.classList.remove('is-hidden')
            opacity.classList.remove('is-hidden')
            if (!notification_closed) notification.classList.remove('is-hidden')
        })
        .catch(function (error) {
            console.log(error)
        })
})

upload.addEventListener('click', () => {
    help2.classList.add('is-hidden')
    overlaywrapper.classList.remove('is-hidden')
    save.removeAttribute('disabled')
    save.classList.remove('is-hidden')
    imageInput.click()
})

imageInput.addEventListener('change', (event) => {
    if (event.target.files) {
        let inputImg = event.target.files[0]
        let fileReader = new FileReader()
        fileReader.readAsDataURL(inputImg)
        fileReader.addEventListener('load', (event) => {
            let uploadImg = new Image()
            uploadImg.src = event.target.result
            uploadImg.addEventListener('load', () => {
                previewUpload(uploadImg)
            })
        })
    }
})

close.addEventListener('click', () => {
    let stream = video.srcObject
    let tracks = stream.getTracks()

    for (let i = 0; i < tracks.length; i++) {
        tracks[i].stop()
    }
    video.srcObject = null
})

snapshot.addEventListener('click', () => {
    previewImage()
})

save.addEventListener('click', async () => {
    await saveImage()
    getUserImages(user_id)
})

post.addEventListener('click', async () => {
    const imageName = await saveImage()
    location.href = `/newpost?image=${imageName}`
})

opacity.addEventListener('change', (event) => {
    const stickers = document.getElementsByClassName('overlayitem')
    for (let item of stickers) {
        item.style.opacity = event.target.value / 100
    }
})

deletebutton.addEventListener('click', () => {
    notification.classList.add('is-hidden')
    notification_closed = true
})

helpbutton.addEventListener('click', () => {
    help.classList.remove('is-hidden')
})

// Help modal

helpbutton.addEventListener('click', () => {
    help.classList.add('is-active')
})

closehelp.addEventListener('click', () => {
    help.classList.remove('is-active')
})

deletehelp.addEventListener('click', () => {
    help.classList.remove('is-active')
})

// Drag and drop stickers

let mouseDown = false
let pointer
let boundX
let boundY
let pointerPositionLeft
let pointerPositionTop

overlaywrapper.addEventListener('pointerdown', (event) => {
    mouseDown = true
    if (!event.target.classList.contains('overlayitem')) return
    pointer = document.getElementById(event.target.id)
    pointer.ondragstart = () => false
    boundX = event.clientX - pointer.getBoundingClientRect().left
    boundY = event.clientY - pointer.getBoundingClientRect().top
})

overlaywrapper.addEventListener('pointermove', (event) => {
    if (
        !mouseDown ||
        event.offsetX < 1 ||
        event.offsetY < 1 ||
        pointer == undefined
    )
        return
    rightEdge =
        event.clientX -
        overlaywrapper.getBoundingClientRect().left -
        boundX +
        pointer.offsetWidth
    bottomEdge =
        event.clientY -
        overlaywrapper.getBoundingClientRect().top -
        boundY +
        pointer.offsetHeight
    if (
        rightEdge > overlaywrapper.offsetWidth ||
        bottomEdge > overlaywrapper.offsetHeight
    )
        return
    pointerPositionLeft =
        event.clientX - overlaywrapper.getBoundingClientRect().left - boundX
    pointerPositionTop =
        event.clientY - overlaywrapper.getBoundingClientRect().top - boundY
    pointer.style.left =
        pointerPositionLeft < 0 ? `0px` : `${pointerPositionLeft}px`
    pointer.style.top =
        pointerPositionTop < 0 ? `0px` : `${pointerPositionTop}px`
})

document.addEventListener('pointerup', (event) => {
    mouseDown = false
})

// Sticker resize

let sticker_resize
let mouse_over = false

overlaywrapper.addEventListener('mouseover', (event) => {
    if (!event.target.classList.contains('overlayitem')) return
    sticker_resize = document.getElementById(event.target.id)
    mouse_over = true
    sticker_resize.addEventListener(
        'mouseleave',
        () => {
            mouse_over = false
        },
        { once: true }
    )
    window.addEventListener('keydown', (event) => {
        if (!mouse_over) return
        event.preventDefault()
        if (event.key == 'ArrowUp') {
            const new_width = sticker_resize.clientWidth + 5
            rightEdge = sticker_resize.offsetLeft + new_width
            bottomEdge =
                sticker_resize.offsetTop + sticker_resize.clientHeight + 5
            if (
                rightEdge > overlaywrapper.offsetWidth ||
                bottomEdge > overlaywrapper.offsetHeight
            )
                return
            sticker_resize.style.width = `${new_width}px`
        }
        if (event.key == 'ArrowDown') {
            const new_width = sticker_resize.clientWidth - 5
            if (new_width < 10) return
            sticker_resize.style.width = `${new_width}px`
        }
    })
})
// Load user images on startup
getUserImages(user_id)

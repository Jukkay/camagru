if (user_id == 0) {
    alert('Please, login first.')
    location.href = '/'
}

const gallery = document.getElementById('gallery')
const preview = document.getElementById('preview')
const description = document.getElementById('description')
const submit = document.getElementById('submit')
const invalid = document.getElementById('invalid')
const no_image = document.getElementById('noimage')
const urlParameters = window.location.search
const parameters = new URLSearchParams(urlParameters)
let image = parameters.get('image')

// Fetches user's images to drafts
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

// Renders selected image from drafts to preview
const editImage = (base) => {
    image = base
    const baseImg = document.getElementById(base).src
    preview.setAttribute('src', baseImg)
    preview.classList.remove('is-hidden')
}

// Delete image
const deleteImage = (filename) => {
    if (user_id == 0 || filename == '') {
        return
    }
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

// Submits image and description to backend
const submitPost = async () => {
    if (user_id == 0) return
    if (!preview.hasAttribute('src')) {
        invalid.classList.add('is-hidden')
        no_image.classList.remove('is-hidden')
        return
    }
    if (description.value.length < 1 || description.value.length > 4096) {
        no_image.classList.add('is-hidden')
        invalid.classList.remove('is-hidden')
        return
    }
    var formData = new FormData()
    formData.append('user_id', user_id)
    formData.append('image', image)
    formData.append('description', description.value.trim())
    request = new Request('/savepost', {
        method: 'POST',
        body: formData,
    })
    fetch(request)
        .then(() => {
            location.href = '/'
        })
        .catch((error) => {
            console.log(error)
        })
}

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
        editImage(id)
    }
})

submit.addEventListener('click', (event) => {
    event.preventDefault()
    submitPost()
})

if (preview.hasAttribute('src')) preview.classList.remove('is-hidden')

// Load user images on startup
getUserImages(user_id)

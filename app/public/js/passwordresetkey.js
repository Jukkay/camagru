const form = document.getElementById('resetform')
const username = document.getElementById('username')
const email = document.getElementById('email')

form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const formData = new FormData()
    formData.append('username', username.value)
    formData.append('email', email.value)
    request = new Request('/resetkey', {
        method: 'POST',
        body: formData,
    })
    fetch(request)
        .then(() => {
            location.href = '/resetconfirm'
        })
        .catch((error) => {
            console.log(error)
        })
})

const form = document.getElementById('emailresetform');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const nomatch = document.getElementById('nomatch');
const invalidkey = document.getElementById('invalidkey');

form.addEventListener('submit', async (e) => {
	e.preventDefault();
    if (password.value !== password2.value) {
        nomatch.classList.remove('is-hidden');
        password2.classList.add('is-danger');
        return;
    }
	const formData = new FormData();
	formData.append('password', password.value);
    formData.append('password_reset_key', password_reset_key);
    request = new Request('/processpasswordreset', {
        method: 'POST',
        body: formData,
    });
    let response = await fetch(request)
	.catch(function (error) {
		console.log(error);
	});
    let message = await response.text()
	.catch(function (error) {
		console.log(error);
	});
	if (message == 'invalid_key') {
		invalidkey.classList.remove('is-hidden');
		password.classList.remove('is-danger');
        password2.classList.remove('is-danger');
		nomatch.classList.add('is-hidden');
		return;
	}
	if (message == 'ok') {
		location.href = '/logout';
		return;
	}
});

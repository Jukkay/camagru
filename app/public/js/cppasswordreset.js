const form = document.getElementById('resetform');
const oldpassword = document.getElementById('oldpassword');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const nomatch = document.getElementById('nomatch');
const invalidpassword = document.getElementById('invalidpassword');

if (user_id == 0) {
	location.href = '/';
}

form.addEventListener('submit', async (e) => {
	e.preventDefault();
    if (password.value !== password2.value) {
        nomatch.classList.remove('is-hidden');
        password2.classList.add('is-danger');
        return;
    }
	console.log('passwords match');
	const formData = new FormData();
	formData.append('user_id', user_id);
    formData.append('oldpassword', oldpassword.value);
	formData.append('password', password.value);
    request = new Request('/processpassword', {
        method: 'POST',
        body: formData,
    });
	console.log('request created');
    let response = await fetch(request)
	.catch(function (error) {
		console.log(error);
	});
	console.log('fetch complete');
    let message = await response.text()
	.catch(function (error) {
		console.log(error);
	});
	console.log('response text complete');
	console.log(message);
	if (message == 'invalid_password') {
		invalidpassword.classList.remove('is-hidden');
		oldpassword.classList.add('is-danger');
		password.classList.remove('is-danger');
        password2.classList.remove('is-danger');
		nomatch.classList.add('is-hidden');
		return;
	}
	if (message == 'ok') {
		location.href = '/login';
		return;
	}
});

// form elements
const form = document.getElementById('login');
const username = document.getElementById('username');
const password = document.getElementById('password');

// Error response elements
const invaliduser = document.getElementById('invaliduser');
const invalidpassword = document.getElementById('invalidpassword');
const notvalidated = document.getElementById('notvalidated');

form.addEventListener('submit', async (e) => {
	e.preventDefault();
	const formData = new FormData();
	formData.append('username', username.value);
	formData.append('password', password.value);
	const request = new Request('/process_login', {
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
	console.log(message);
	if (message == 'invalidparameters') {
		return;
	}
	if (message == 'invaliduser') {
		invaliduser.classList.remove('is-hidden');
		username.classList.add('is-danger');
		password.classList.remove('is-danger');
		invalidpassword.classList.add('is-hidden');
		notvalidated.classList.add('is-hidden');
		return;
	}
	if (message == 'notvalidated') {
		notvalidated.classList.remove('is-hidden');
		username.classList.add('is-danger');
		password.classList.remove('is-danger');
		invalidpassword.classList.add('is-hidden');
		invaliduser.classList.add('is-hidden');
		return;
	}
	if (message == 'invalidpassword') {
		password.classList.add('is-danger');
		invalidpassword.classList.remove('is-hidden');
		username.classList.remove('is-danger');
		invaliduser.classList.add('is-hidden');
		notvalidated.classList.add('is-hidden');
		return;
	}
	if (message == 'ok') {
		location.href = '/';
		return;
	}
});

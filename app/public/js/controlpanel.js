const userinfo = document.getElementById('userconfiguration');
let image_input;
let upload;

const getUserConfiguration = () => {
	fetch(`/getuserconfiguration?user_id=${user_id}`)
		.then(function (response) {
			return response.text();
		})
		.then(function (text) {
			userinfo.innerHTML = text;
			image_input = document.getElementById('image-input');
			upload = document.getElementById('upload');
			upload.addEventListener('click', () => {
				image_input.click();
			});
			image_input.addEventListener('change', save_image);
		})
}

const save_image = (event) => {
	if (event.target.files) {
        let inputImg = event.target.files[0];
        let fileReader = new FileReader();
        fileReader.readAsDataURL(inputImg);
        fileReader.addEventListener('load', function (event) {
			let formData = new FormData();
			formData.append('user_id', user_id);
			formData.append('img', event.target.result);
			request = new Request('/saveprofilepicture', {
				method: 'POST',
				body: formData,
			});
			fetch(request)
			.then(function (response) {
				getUserConfiguration();
			})
        });
    }
}

getUserConfiguration();



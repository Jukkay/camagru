<script>

	document.addEventListener('DOMContentLoaded', function () {
		let start = document.getElementById('start');
		let upload = document.getElementById('upload');
		let imageInput = document.getElementById('image-input');
		let video = document.getElementById('videoframe');
		let canvas = document.getElementById('canvas');
		let preview = document.getElementById('preview');
		let help1 = document.getElementById('help1');
		let help2 = document.getElementById('help2');
		let close = document.getElementById('close');
		let snapshot = document.getElementById('snapshot');
		let addstickers = document.getElementById('addstickers');
		let save = document.getElementById('save');
		let canvasbuttons = document.getElementById('canvasbuttons');
		let photo = document.getElementById('photo');
		let gallery = document.getElementById('gallery');
		let star = document.getElementById('star');
		let cat = document.getElementById('cat');
		let bus = document.getElementById('bus');
		let frenchie = document.getElementById('frenchie');
		let mexican = document.getElementById('mexican');
		let width = 1920;
        let height = 0;
		let stickers = [];
		let imageData;
        var streaming = false;
		let uid = <?php if(isset($_SESSION['uid']))
							echo $_SESSION['uid'];
						else
							echo '0'?>;

		// Camera configuration
		let constraints = { audio: true,
							video:	{
									width: { ideal: 1920 },
                            		height: { ideal: 1080 }
									}};
		let mediaDevices = navigator.mediaDevices;
		// Clears canvas
		// function clearphoto() {
		// 	let context = canvas.getContext('2d');
		// 	context.fillStyle = "#AAA";
		// 	context.fillRect(0, 0, canvas.width, canvas.height);
		// 	let imageData = canvas.toDataURL();
		// 	photo.setAttribute('src', imageData);
		// }
		// Downloads users saved images

		if (uid == 0) {
			alert('Please, login first.');
			location.href = '/';
			return;
		}
		function getUserImages(uid) {
			if(uid == 0) {
				gallery.innerHTML = "";
				return;
			}
			fetch('/fetcheditor?uid=' + uid)
			.then(function(response) {
				return response.text();
			})
			.then(function(text) {
				gallery.innerHTML = text;
			});
		}
		// Add stickers to preview
		function addStickers(context) {
			if (stickers.length == 0)
				return;
			stickers.forEach(function(sticker) {
				let stickerImg = new Image();
				stickerImg.onload = onload;
				stickerImg.src = 'assets/stickers/' + sticker;
				context.globalAlpha = 1; // can be used to change opacity
				context.drawImage(stickerImg, 0, 0);
			})
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
			addStickers(context);
			imageData = canvas.toDataURL();

			preview.setAttribute('src', imageData);
			video.classList.add('is-hidden');
			preview.classList.remove('is-hidden');
		}

		function previewUpload(baseImg) {
			let context = canvas.getContext('2d');
			console.log(baseImg);
			canvas.width = baseImg.width;
			canvas.height = baseImg.height;
			context.drawImage(baseImg, 0, 0);
			addStickers(context);
			imageData = canvas.toDataURL();
			console.log(imageData);
			preview.classList.remove('is-hidden');
			video.classList.add('is-hidden');
			preview.setAttribute('src', imageData);
			// canvasbuttons.classList.add('is-hidden');
		}
		function editImage(base) {
			let context = canvas.getContext('2d');

			let baseImg = document.getElementById(base);
			canvas.width = baseImg.naturalWidth;
			canvas.height = baseImg.naturalHeight;
			context.drawImage(baseImg, 0, 0);
			addStickers(context);
			imageData = canvas.toDataURL();

			preview.setAttribute('src', imageData);
			video.classList.add('is-hidden');
			preview.classList.remove('is-hidden');
			// canvasbuttons.classList.add('is-hidden');
		}
		// Sends images to backend to be merged and saved
		function saveImage() {
			if(uid == 0) {
				return;
			}
			imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
			var formData = new FormData();
			formData.append('img', imageData);
			formData.append('stickers', stickers);
			formData.append('uid', uid);
			$request = new Request(
				'/saveimage', {
				method: 'POST',
				body: formData
			});
			fetch($request)
				.then(function(response) {
					getUserImages(uid);
				});
		}

		// Delete image
		function deleteImage(filename) {
			if(uid == 0 || filename == '') {
				return;
			}
			var formData = new FormData();
			formData.append('img', filename);
			formData.append('uid', uid);
			$request = new Request(
				'/deleteimage', {
				method: 'POST',
				body: formData
			});
			fetch($request)
				.then(function(response) {
					getUserImages(uid);
				});
		}
		// Video frame initialization
		video.addEventListener('canplay', function(ev) {
			if(!streaming) {
				height = video.videoHeight / (video.videoWidth / width);

				if(isNaN(height)) {
					height = width / (4 / 3);
				}
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		// Event listeners for stickers
		star.addEventListener('click', function () {
			stickers.push('216.png');
			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			help1.classList.add('is-hidden');
			help2.classList.remove('is-hidden');
			canvasbuttons.classList.remove('is-hidden');
		});
		cat.addEventListener('click', function () {
			stickers.push('cat-g9264252fd_640.png');
			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			help1.classList.add('is-hidden');
			help2.classList.remove('is-hidden');
			canvasbuttons.classList.remove('is-hidden');
		});
		bus.addEventListener('click', function () {
			stickers.push('clipart-g4b3e1b4ae_640.png');
			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			help1.classList.add('is-hidden');
			help2.classList.remove('is-hidden');
			canvasbuttons.classList.remove('is-hidden');
		});
		frenchie.addEventListener('click', function () {
			stickers.push('french-bulldog-gc086eb3d9_640.png');
			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			help1.classList.add('is-hidden');
			help2.classList.remove('is-hidden');
			canvasbuttons.classList.remove('is-hidden');
		});
		mexican.addEventListener('click', function () {
			stickers.push('man-gdf72c5265_640.png');
			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			help1.classList.add('is-hidden');
			help2.classList.remove('is-hidden');
			canvasbuttons.classList.remove('is-hidden');
		});

		// Gallery event listener

		gallery.addEventListener('click', function (e) {
			let parent = e.target;
			let action = parent.innerHTML;
			parent = parent.parentNode.parentNode.parentNode;
			let img = parent.getElementsByTagName('img');
			img = img[0].getAttribute('src');
			img = img.substring(img.indexOf('=') + 1);
			if (action == 'Delete') {
				parent.remove();
				deleteImage(img);
			}
			if (action == 'Edit') {
				editImage(img);
			}
		})

		// Event listeners for buttons
		start.addEventListener('click', function () {
			mediaDevices.getUserMedia(constraints)
			.then((stream) => {
				video.srcObject = stream;
				video.play();
				help2.classList.add('is-hidden');
				snapshot.removeAttribute('disabled');
			})
			.catch(function (error) {
				console.log(err);
			});
		});

		upload.addEventListener('click', function () {
			help2.classList.add('is-hidden');
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
					})
				});
			}
		});

		close.addEventListener('click', function () {
			let stream = video.srcObject;
			let tracks = stream.getTracks();

			for(let i = 0; i < tracks.length; i++) {
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

		getUserImages(uid);

	});
</script>
<div class="columns">
	<div class="column is-three-quarters">
		<video id="videoframe" autoplay>Video stream not available. Please, click "Start Webcam" below.</video>
		<img id="preview" alt="Image preview" class="is-hidden">
		<canvas id="canvas" class="is-hidden"></canvas>
		<p id="help1" class="title has-text-centered mb-6">1.  Select one or more stickers below</p>
		<p id="help2" class="title has-text-centered mb-6 is-hidden">2.  Start webcam, upload a file, or select one of your drafts</p>
		<div class="pb-6 has-text-centered is-hidden" id="canvasbuttons">

			<button class="button" id="start">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    					<path fill="currentColor" d="M12,2A7,7 0 0,1 19,9A7,7 0 0,1 12,16A7,7 0 0,1 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9A5,5 0 0,0 12,14A5,5 0 0,0 17,9A5,5 0 0,0 12,4M12,6A3,3 0 0,1 15,9A3,3 0 0,1 12,12A3,3 0 0,1 9,9A3,3 0 0,1 12,6M6,22A2,2 0 0,1 4,20C4,19.62 4.1,19.27 4.29,18.97L6.11,15.81C7.69,17.17 9.75,18 12,18C14.25,18 16.31,17.17 17.89,15.81L19.71,18.97C19.9,19.27 20,19.62 20,20A2,2 0 0,1 18,22H6Z" />
					</svg>
				</span>
				<span>Start webcam</span>
			</button>
			<button class="button" id="close">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    					<path fill="currentColor" d="M12 6C13.66 6 15 7.34 15 9C15 9.78 14.7 10.5 14.21 11L10 6.79C10.5 6.3 11.22 6 12 6M12 4C14.76 4 17 6.24 17 9C17 10.33 16.47 11.53 15.62 12.42L17.04 13.84C18.25 12.59 19 10.88 19 9C19 5.13 15.87 2 12 2C10.12 2 8.41 2.75 7.16 3.96L8.58 5.38C9.47 4.53 10.67 4 12 4M22.11 21.46L20.84 22.73L19.46 21.35C19.1 21.75 18.58 22 18 22H6C4.89 22 4 21.11 4 20C4 19.62 4.1 19.27 4.29 18.97L6.11 15.81C7.69 17.17 9.75 18 12 18C13.21 18 14.37 17.75 15.43 17.32L13.85 15.74C13.26 15.91 12.64 16 12 16C8.13 16 5 12.87 5 9C5 8.36 5.09 7.74 5.26 7.15L1.11 3L2.39 1.73L22.11 21.46M12.1 14L7 8.9C7 8.93 7 8.97 7 9C7 11.76 9.24 14 12 14C12.03 14 12.07 14 12.1 14Z" />
					</svg>
				</span>
				<span>Close Webcam</span>
			</button>
			<input type="file" id="image-input" accept="image/png" hidden>
  			<button class="button" id="upload">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
   						<path fill="currentColor" d="M22 8V13.81C21.39 13.46 20.72 13.22 20 13.09V8H4V18H13.09C13.04 18.33 13 18.66 13 19C13 19.34 13.04 19.67 13.09 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.89 4 4 4H10L12 6H20C21.1 6 22 6.89 22 8M16 18H18V22H20V18H22L19 15L16 18Z" />
					</svg>
				</span>
				<span>Upload picture</span>
			</button>
		</div>
		<h2 class="subtitle">Select stickers:</h2>
		<div class="columns" style="width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;">
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/216.png">
				</figure>
				<div class="buttons is-centered">
					<button id="star" class="button is-primary is-small mt-3">Select</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/cat-g9264252fd_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="cat" class="button is-primary is-small mt-3">Select</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/clipart-g4b3e1b4ae_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="bus" class="button is-primary is-small mt-3">Select</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/french-bulldog-gc086eb3d9_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="frenchie" class="button is-primary is-small mt-3">Select</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/man-gdf72c5265_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="mexican" class="button is-primary is-small mt-3">Select</button>
				</div>
			</div>
		</div>
		<div class="field is-grouped">
			<p class="control">
				<button class="button" id="addstickers" disabled>Add selected stickers</button>
			</p>
			<p class="control">
				<button class="button" id="snapshot" disabled>Take picture</button>
			</p>
			<p class="control">
				<button class="button" id="save" disabled>Save picture</button>
			</p>
			<p class="control">
				<button class="button" id="record">Record video</button>
			</p>
			<p class="control">
				<button class="button" id="stop">Stop recording</button>
			</p>
		</div>
	</div>
	<div class="column" id="gallery">
	</div>
</div>

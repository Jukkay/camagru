<script>

	document.addEventListener('DOMContentLoaded', function () {
		let start = document.getElementById('start');
		let video = document.getElementById('videoframe');
		let canvas = document.getElementById('canvas');
		let preview = document.getElementById('preview');
		let close = document.getElementById('close');
		let snapshot = document.getElementById('snapshot');
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
		let sticker;
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
			let stickerImg = new Image();
			stickerImg.onload = onload;
			stickerImg.src = 'assets/stickers/' + sticker;
			context.globalAlpha = 1; // can be used to change opacity
			context.drawImage(stickerImg, 0, 0);
			imageData = canvas.toDataURL();

			preview.setAttribute('src', imageData);
			video.classList.add('is-hidden');
			preview.classList.remove('is-hidden');
		}

		function editImage(base) {
			let context = canvas.getContext('2d');

			let baseImg = document.getElementById(base);
			canvas.width = baseImg.naturalWidth;
			canvas.height = baseImg.naturalHeight;
			context.drawImage(baseImg, 0, 0);

			if (typeof sticker != "undefined" && sticker != null) {
				let stickerImg = new Image();
				stickerImg.onload = onload;
				stickerImg.src = 'assets/stickers/' + sticker;
				context.globalAlpha = 1; // can be used to change opacity
				context.drawImage(stickerImg, 0, 0);
			}
			imageData = canvas.toDataURL();

			preview.setAttribute('src', imageData);
			video.classList.add('is-hidden');
			preview.classList.remove('is-hidden');
			canvasbuttons.classList.add('is-hidden');
		}
		// Sends images to backend to be merged and saved
		function saveImage() {
			if(uid == 0) {
				return;
			}
			imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
			var formData = new FormData();
			formData.append('img', imageData);
			formData.append('sticker', sticker);
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
				canvasbuttons.classList.add('is-hidden');
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		// Event listeners for stickers
		star.addEventListener('click', function () {
			sticker = '216.png';
			snapshot.removeAttribute('disabled');
		});
		cat.addEventListener('click', function () {
			sticker = 'cat-g9264252fd_640.png';
			snapshot.removeAttribute('disabled');
		});
		bus.addEventListener('click', function () {
			sticker = 'clipart-g4b3e1b4ae_640.png';
			snapshot.removeAttribute('disabled');
		});
		frenchie.addEventListener('click', function () {
			sticker = 'french-bulldog-gc086eb3d9_640.png';
			snapshot.removeAttribute('disabled');
		});
		mexican.addEventListener('click', function () {
			sticker = 'man-gdf72c5265_640.png';
			snapshot.removeAttribute('disabled');
		});

		// Gallery event listener

		gallery.addEventListener('click', function (e) {
			let parent = e.target;
			let action = parent.innerHTML;
			parent = parent.parentNode.parentNode.parentNode;
			// remove element here?
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
				canvasbuttons.classList.add('is-hidden');
			})
			.catch(function (error) {
				console.log(err);
			});
		});

		close.addEventListener('click', function () {
			let stream = video.srcObject;
			let tracks = stream.getTracks();

			for(let i = 0; i < tracks.length; i++) {
				tracks[i].stop();
			}
			video.srcObject = null;
			canvasbuttons.classList.remove('is-hidden');
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
		<div class="pb-6 mb-6" id="canvasbuttons">
			<p class="has-text-centered block">
			<button class="button is-large" id="start">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    					<path fill="currentColor" d="M12,2A7,7 0 0,1 19,9A7,7 0 0,1 12,16A7,7 0 0,1 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9A5,5 0 0,0 12,14A5,5 0 0,0 17,9A5,5 0 0,0 12,4M12,6A3,3 0 0,1 15,9A3,3 0 0,1 12,12A3,3 0 0,1 9,9A3,3 0 0,1 12,6M6,22A2,2 0 0,1 4,20C4,19.62 4.1,19.27 4.29,18.97L6.11,15.81C7.69,17.17 9.75,18 12,18C14.25,18 16.31,17.17 17.89,15.81L19.71,18.97C19.9,19.27 20,19.62 20,20A2,2 0 0,1 18,22H6Z" />
					</svg>
				</span>
				<span>Start webcam</span>
			</button>
			</p>
			<p class="has-text-centered block">
  			<button class="button is-large">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
   						<path fill="currentColor" d="M22 8V13.81C21.39 13.46 20.72 13.22 20 13.09V8H4V18H13.09C13.04 18.33 13 18.66 13 19C13 19.34 13.04 19.67 13.09 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.89 4 4 4H10L12 6H20C21.1 6 22 6.89 22 8M16 18H18V22H20V18H22L19 15L16 18Z" />
					</svg>
				</span>
				<span>Upload picture</span>
			</button>
			</p>
		</div>
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
				<button class="button" id="close">Close Webcam</button>
			</p>
			<p class="control">
				<button class="button" id="snapshot" disabled>Take picture</button>
			</p>
			<p class="control">
				<button class="button" id="save">Save picture</button>
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

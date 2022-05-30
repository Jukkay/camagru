<script>

	document.addEventListener('DOMContentLoaded', function () {
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
		let width = 1920;
        let height = 0;
		let stickerData = [];
		let sticker;
		let stickerWidth;
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
		// Add sticker to overlay
		function addSticker(sticker) {
			getStickerData(sticker);
			let stickerImg = new Image();
			stickerImg.onload = onload;
			stickerImg.src = 'assets/stickers/' + sticker;
			stickerImg.setAttribute('id', 'overlay' + sticker);
			stickerImg.setAttribute('draggable', 'true');
			stickerImg.classList.add('overlayitem');
			stickerImg.style.position = 'absolute';
			if (stickerData.length * 50 + 200 > canvas.width)
				stickerImg.style.left = '20px';
			else
				stickerImg.style.left =  stickerData.length * 50 + 'px';
			stickerImg.style.top = '20px';
			overlaywrapper.appendChild(stickerImg);

			snapshot.removeAttribute('disabled');
			save.removeAttribute('disabled');
			canvasbuttons.classList.remove('is-hidden');
			help1.classList.add('is-hidden');
			if (stickerData.length == 1)
				help2.classList.remove('is-hidden');
			else
				help2.classList.add('is-hidden');
		}
		// Remove sticker from overlay
		function removeSticker(sticker) {

			let deleteItem = document.getElementById('overlay' + sticker);
			deleteItem.remove();
			stickerData = stickerData.filter((item) => item[1] !== sticker);
			console.log(stickerData);


		}
		// Adds sticker's image data to array for backend
		function getStickerData(sticker) {
			let context = canvas.getContext('2d');
			let img = document.getElementById(sticker);
			canvas.width = img.naturalWidth;
			canvas.height = img.naturalHeight;
			context.drawImage(img, 0, 0);
			imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
			stickerData.push([imageData, sticker]);
		}
		// Draw stickers to canvas
		// function mergeStickers(context) {
		// 	if (stickers.length == 0)
		// 		return;
		// 	stickers.forEach(function(sticker) {
		// 		let stickerImg = new Image();
		// 		stickerImg.onload = onload;
		// 		stickerImg.src = 'assets/stickers/' + sticker;
		// 		context.globalAlpha = 1; // can be used to change opacity
		// 		context.drawImage(stickerImg, 0, 0);
		// 	})
		// 	// empty array and overlay
		// 	stickers.length = 0;
		// 	overlaywrapper.innerHTML = '';

		// }

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
			preview.classList.remove('is-hidden');
		}
		// Sends images to backend to be merged and saved
		function saveImage() {
			if(uid == 0) {
				return;
			}
			imageData = canvas.toDataURL().replace(/^data:image\/png;base64,/, '');
			var formData = new FormData();
			formData.append('img', imageData);
			stickerData.forEach(element => {
				console.log(element[0]);
				console.log(element[1]);
				formData.append('stickers[]', element);
			});
			formData.append('uid', uid);
			$request = new Request(
				'/saveimage', {
				method: 'POST',
				body: formData
			});
			fetch($request)
				.then(function(response) {
					getUserImages(uid);
				})
				.catch(function(error) {
					console.log(error);
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
				overlaywrapper.setAttribute('width', width);
				overlaywrapper.setAttribute('height', height);
				streaming = true;
			}
		}, false);

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
				preview.classList.add('is-hidden');
				snapshot.removeAttribute('disabled');
				overlaywrapper.classList.remove('is-hidden');
				video.classList.remove('is-hidden');
			})
			.catch(function (error) {
				console.log(error);
			});
		});

		upload.addEventListener('click', function () {
			help2.classList.add('is-hidden');
			overlaywrapper.classList.remove('is-hidden');
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

		// Drag and drop stickers

		let mouseDown = false;
		let pointer;
		let boundX;
		let boundY;
		let pointerPositionLeft;
		let pointerPositionTop;

		overlaywrapper.addEventListener('pointerdown', event => {
			mouseDown = true;
			if (!event.target.classList.contains('overlayitem'))
				return;
			pointer = document.getElementById(event.target.id);
			pointer.ondragstart = () => false ;
			boundX = event.clientX - pointer.getBoundingClientRect().left;
			boundY = event.clientY - pointer.getBoundingClientRect().top;
		});

		overlaywrapper.addEventListener('pointermove', event => {
			console.log(event.offsetX)
			if (!mouseDown || event.offsetX < 1 || event.offsetY < 1)
				return;
			rightEdge = event.clientX - overlaywrapper.offsetParent.offsetLeft - boundX + pointer.offsetWidth;
			bottomEdge = event.clientY - overlaywrapper.offsetTop - boundY + pointer.offsetHeight;
			if (rightEdge > overlaywrapper.offsetWidth || bottomEdge > overlaywrapper.offsetHeight)
				return;
			pointerPositionLeft = event.clientX - overlaywrapper.offsetParent.offsetLeft - boundX;
			pointerPositionTop = event.clientY - overlaywrapper.offsetTop - boundY;
			pointer.style.left = pointerPositionLeft < 0 ? `0px` : `${pointerPositionLeft}px`;
			pointer.style.top = pointerPositionTop < 0 ? `0px` : `${pointerPositionTop}px`;
		});

		document.addEventListener('pointerup', event => {
				mouseDown = false;
		});


		getUserImages(uid);

	});
</script>
<style type="text/css">

	.overlaywrapper {
		position: relative;
		overflow: hidden;
		touch-action: none;
		width: 100%;
		height: 100%;
	}
	.overlayitem {
		position: absolute;
		width: 200px;
	}
	/* .overlay .topleft {
		position: absolute;
		top: 20px;
		left: 20px;
	}
	.overlay .topright {
		top: 20px;
		right: 20px;
	}
	.overlay .bottomright {
		bottom: 20px;
		right: 20px;
	}
	.overlay .bottonleft {
		bottom: 20px;
		left: 20px;
	}
	.overlay .bottonleft {
		bottom: 200px;
		left: 20px;
	} */

</style>
<div class="columns">
	<div class="column is-three-quarters">
		<div id="overlay">
			<div id="overlaywrapper" class="overlaywrapper is-hidden">
				<video id="videoframe" autoplay>Video stream not available. Please, click "Start Webcam" below.</video>
			</div>
			<img id="preview" alt="Image preview" class="is-hidden">
		</div>
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
			<button class="button" id="snapshot">
				<span class="icon is-small">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    					<path fill="currentColor" d="M13.73,15L9.83,21.76C10.53,21.91 11.25,22 12,22C14.4,22 16.6,21.15 18.32,19.75L14.66,13.4M2.46,15C3.38,17.92 5.61,20.26 8.45,21.34L12.12,15M8.54,12L4.64,5.25C3,7 2,9.39 2,12C2,12.68 2.07,13.35 2.2,14H9.69M21.8,10H14.31L14.6,10.5L19.36,18.75C21,16.97 22,14.6 22,12C22,11.31 21.93,10.64 21.8,10M21.54,9C20.62,6.07 18.39,3.74 15.55,2.66L11.88,9M9.4,10.5L14.17,2.24C13.47,2.09 12.75,2 12,2C9.6,2 7.4,2.84 5.68,4.25L9.34,10.6L9.4,10.5Z" />
					</svg>
				</span>
				<span>Capture picture</span>
			</button>
		</div>
		<h2 class="subtitle">Select stickers:</h2>
		<div class="columns" style="width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;">
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/216.png" id="216.png">
				</figure>
				<div class="buttons is-centered">
					<button id="star" class="button is-primary is-small mt-3">Select</button>
					<button id="removestar" class="button is-danger is-small mt-3 is-hidden">Remove</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/cat-g9264252fd_640.png" id="cat-g9264252fd_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="cat" class="button is-primary is-small mt-3">Select</button>
					<button id="removecat" class="button is-danger is-small mt-3 is-hidden">Remove</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/clipart-g4b3e1b4ae_640.png" id="clipart-g4b3e1b4ae_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="bus" class="button is-primary is-small mt-3">Select</button>
					<button id="removebus" class="button is-danger is-small mt-3 is-hidden">Remove</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/french-bulldog-gc086eb3d9_640.png" id="french-bulldog-gc086eb3d9_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="frenchie" class="button is-primary is-small mt-3">Select</button>
					<button id="removefrenchie" class="button is-danger is-small mt-3 is-hidden">Remove</button>
				</div>
			</div>
			<div class="column">
				<figure class="image is-128x128">
					<img src="assets/stickers/man-gdf72c5265_640.png" id="man-gdf72c5265_640.png">
				</figure>
				<div class="buttons is-centered">
					<button id="mexican" class="button is-primary is-small mt-3">Select</button>
					<button id="removemexican" class="button is-danger is-small mt-3 is-hidden">Remove</button>
				</div>
			</div>
		</div>
		<div class="field is-grouped">
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

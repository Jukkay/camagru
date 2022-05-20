<script>
	document.addEventListener('DOMContentLoaded', function () {
		let start = document.getElementById('start');
		let video = document.getElementById('videoframe');
		let close = document.getElementById('close');
		let snapshot = document.getElementById('snapshot');
		let canvas = document.getElementById('canvas');
		let photo = document.getElementById('photo');
		let gallery = document.getElementById('gallery');
		let star = document.getElementById('star');
		let cat = document.getElementById('cat');
		let bus = document.getElementById('bus');
		let frenchie = document.getElementById('frenchie');
		let mexican = document.getElementById('mexican');
		let width = 1280;
        let height = 0;
		let sticker;
		let imageData;
        var streaming = false;
		let uid = <?php echo $_SESSION['uid'];?>;
		let constraints = { audio: true, video: { width: 1280, height: 720 } };
		let mediaDevices = navigator.mediaDevices;

		function clearphoto() {
			let context = canvas.getContext('2d');
			context.fillStyle = "#AAA";
			context.fillRect(0, 0, canvas.width, canvas.height);
			let imageData = canvas.toDataURL('image/png');
			photo.setAttribute('src', imageData);
		}

		function getUserImages(uid) {
			if(uid == "") {
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
		function saveImage(imageData, uid, sticker) {
			if(uid == "" || imageData === undefined) {
				return;
			}
			var formData = new FormData();
			formData.append('img', imageData);
			formData.append('uid', uid);
			formData.append('sticker', sticker);
			$request = new Request(
				'/saveimage', {
				method: 'POST',
				body: formData
			});
			fetch($request)
				.then(function(response) {
					// console.log(response);
					getUserImages(uid);
				});
		}
		start.addEventListener('click', function () {
			mediaDevices.getUserMedia(constraints)
			.then((stream) => {
				video.srcObject = stream;
				video.play();
			})
			.catch(function (error) {
				console.log(err);
			});
		});

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
		star.addEventListener('click', function () {
			sticker = 1;
			snapshot.removeAttribute('disabled');
		});
		cat.addEventListener('click', function () {
			sticker = 2;
			snapshot.removeAttribute('disabled');
		});
		bus.addEventListener('click', function () {
			sticker = 3;
			snapshot.removeAttribute('disabled');
		});
		frenchie.addEventListener('click', function () {
			sticker = 4;
			snapshot.removeAttribute('disabled');
		});
		mexican.addEventListener('click', function () {
			sticker = 5;
			snapshot.removeAttribute('disabled');
		});
		close.addEventListener('click', function () {
			let stream = video.srcObject;
			let tracks = stream.getTracks();

			for(let i = 0; i < tracks.length; i++) {
				tracks[i].stop();
			}
			video.srcObject = null;
		});

		snapshot.addEventListener('click', function () {
			let context = canvas.getContext('2d');
			if (width && height) {
				canvas.width = width;
				canvas.height = height;
				context.drawImage(video, 0, 0, width, height);
				imageData = canvas.toDataURL('image/png');
				saveImage(imageData, uid, sticker);
			}
			else
				clearphoto();

		});

		getUserImages(uid);

	});
</script>
<div class="columns">
	<div class="column is-three-quarters">
		<video id="videoframe" autoplay>Video stream not available. Please, click "Start Webcam" below.</video>
		<canvas id="canvas" class="is-hidden"></canvas>
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
				<button class="button" id="start">Start Webcam</button>
			</p>
			<p class="control">
				<button class="button" id="close">Close Webcam</button>
			</p>
			<p class="control">
				<button class="button" id="snapshot" disabled>Take picture</button>
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

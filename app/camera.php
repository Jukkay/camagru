<script src="js/camera.js" defer></script>
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
</style>
<section class="section">
	<div class="columns">
		<div class="column is-three-quarters">
			<div id="overlay">
				<div id="overlaywrapper" class="overlaywrapper is-hidden">
					<video id="videoframe" autoplay>Video stream not available. Please, click "Start Webcam" below.</video>
					<img id="preview" alt="Image preview" class="is-hidden">
				</div>
			</div>
			<canvas id="canvas" class="is-hidden"></canvas>
			<section class="section" id="help1">
				<p class="title has-text-centered mb-6">1. Select one or more stickers below</p>
			</section>
			<section class="section is-hidden" id="help2">
				<p class="title has-text-centered mb-6">2. Start webcam, upload a file, or select one of your drafts</p>
			</section>
			<div class="notification is-primary is-hidden" id="notification">
				<button class="delete" id="deletebutton"></button>
				<strong>Usage</strong></br>
				Drag to move stickers.</br>Resize stickers by hovering your mouse on a sticker and using arrow up/down keys.
			</div>
			<div class="pb-3 has-text-centered is-hidden" id="canvasbuttons">

				<button class="button" id="start">
					<span class="icon is-small">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
							<path fill="currentColor" d="M12,2A7,7 0 0,1 19,9A7,7 0 0,1 12,16A7,7 0 0,1 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9A5,5 0 0,0 12,14A5,5 0 0,0 17,9A5,5 0 0,0 12,4M12,6A3,3 0 0,1 15,9A3,3 0 0,1 12,12A3,3 0 0,1 9,9A3,3 0 0,1 12,6M6,22A2,2 0 0,1 4,20C4,19.62 4.1,19.27 4.29,18.97L6.11,15.81C7.69,17.17 9.75,18 12,18C14.25,18 16.31,17.17 17.89,15.81L19.71,18.97C19.9,19.27 20,19.62 20,20A2,2 0 0,1 18,22H6Z" />
						</svg>
					</span>
					<span>Start webcam</span>
				</button>
				<button class="button is-hidden" id="close" disabled>
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
				<button class="button is-hidden" id="snapshot" disabled>
					<span class="icon is-small">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
							<path fill="currentColor" d="M13.73,15L9.83,21.76C10.53,21.91 11.25,22 12,22C14.4,22 16.6,21.15 18.32,19.75L14.66,13.4M2.46,15C3.38,17.92 5.61,20.26 8.45,21.34L12.12,15M8.54,12L4.64,5.25C3,7 2,9.39 2,12C2,12.68 2.07,13.35 2.2,14H9.69M21.8,10H14.31L14.6,10.5L19.36,18.75C21,16.97 22,14.6 22,12C22,11.31 21.93,10.64 21.8,10M21.54,9C20.62,6.07 18.39,3.74 15.55,2.66L11.88,9M9.4,10.5L14.17,2.24C13.47,2.09 12.75,2 12,2C9.6,2 7.4,2.84 5.68,4.25L9.34,10.6L9.4,10.5Z" />
						</svg>
					</span>
					<span>Capture picture</span>
				</button>
				<button class="button is-hidden" id="save" disabled>
					<span class="icon is-small">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
							<path fill="currentColor" d="M17 3H5C3.89 3 3 3.9 3 5V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V7L17 3M19 19H5V5H16.17L19 7.83V19M12 12C10.34 12 9 13.34 9 15S10.34 18 12 18 15 16.66 15 15 13.66 12 12 12M6 6H15V10H6V6Z" />
						</svg>
					</span>
					<span>Save</span>
				</button>
				<button class="button is-primary is-hidden" id="post">
					<span class="icon is-small">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
							<path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" />
						</svg>
					</span>
					<span>New post</span>
				</button>
				<button class="button" id="helpbutton">
					<span class="icon is-small">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
							<path fill="currentColor" d="M11,18H13V16H11V18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6A4,4 0 0,0 8,10H10A2,2 0 0,1 12,8A2,2 0 0,1 14,10C14,12 11,11.75 11,15H13C13,12.75 16,12.5 16,10A4,4 0 0,0 12,6Z" />
						</svg>
					</span>
					<span>Help</span>
				</button>
			</div>
			<div class="block has-text-centered is-hidden" id="opacity">
				<p>Sticker opacity:</p>
				<input type="range" min="1" max="100" value="100" class="slider" id="opacity">
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
		</div>
		<div class="modal" id="help">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Help</p>
					<button class="delete" aria-label="close" id="deletehelp"></button>
				</header>
				<section class="modal-card-body">
					<p>
						This app lets you take and edit pictures with your webcam. You can snap a new picture with your webcam or edit existing image by uploading it. If you have drafts saved in Camagru, you can edit them by clicking edit button below the image you want to edit.
					</p>
					</br>
					<p>
						Stickers can be added to picture by selecting them from the sticker menu. Clicking remove on the sticker in the sticker menu removes the sticker from the picture.
					</p>
					</br>
					<p>
						You can save your image by clicking the Save button, or submit it directly by clicking the New post button. Saved images will appear in the drafts gallery and posted images in your image feed.
					</p>
				</section>
				<footer class="modal-card-foot">
					<button class="button" id="closehelp">Close</button>
				</footer>
			</div>
		</div>
		<div class="column is-hidden" id="gallery">
		</div>
	</div>
</section>
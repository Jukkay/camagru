const loadingIndicator = document.getElementById('loading');
const feed = document.getElementById('feed');
const postsOnPage = 5;
let pageNumber = 0;

const getPosts = () => {

	fetch(`/fetchfeed?uid=${uid}&limit=${postsOnPage}&page=${pageNumber}`)
	.then(function(response) {
		return response.text();
	})
	.then(function(text) {
		feed.innerHTML = feed.innerHTML + text;
		pageNumber++;
		hideLoadingIndicator();
	});
}

const hideLoadingIndicator = () => {

	loadingIndicator.classList.add('is-hidden');
}
const showLoadingIndicator = () => {

	loadingIndicator.classList.remove('is-hidden');
}

const likePost = (post) => {
	console.log(post);
}
const goToComment = (post) => {
	let target = post.getElementsByClassName('button')[0];
	target = target.previousElementSibling;
	target.focus();

}
const commentPost = (post) => {
	console.log(post);
}
const showComments = (post) => {
	console.log(post);
}
window.addEventListener('scroll', () => {
	if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
			showLoadingIndicator();
			getPosts();
	}
});

getPosts();

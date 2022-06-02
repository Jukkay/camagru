const loadingIndicator = document.getElementById('loading');
const feed = document.getElementById('feed');
const postsOnPage = 5;
let pageNumber = 0;

const getPosts = () => {
    fetch(`/fetchfeed?uid=${uid}&limit=${postsOnPage}&page=${pageNumber}`)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            feed.innerHTML = feed.innerHTML + text;
            pageNumber++;
            hideLoadingIndicator();
        });
};

const hideLoadingIndicator = () => {
    loadingIndicator.classList.add('is-hidden');
};
const showLoadingIndicator = () => {
    loadingIndicator.classList.remove('is-hidden');
};

const likePost = (post) => {
	if (uid == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    console.log(post);
};
const goToComment = (post) => {
	if (uid == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    let target = post.getElementsByClassName('button')[0];
    target = target.previousElementSibling;
    target.focus();
};

const showComments = (post) => {
    const post_id = post.id.replace('show_comments', '');
	fetch(`/getcomments?post_id=${post_id}`)
	.then(function (response) {
		return response.text();
	})
	.then(function (text) {
		post.innerHTML = text;
	});
}

const refreshComments = (post) => {
	const post_id = post.id.replace('post', '');
	const comment_block = document.getElementById('show_comments' + post_id);
	fetch(`/getcomments?post_id=${post_id}`)
	.then(function (response) {
		return response.text();
	})
	.then(function (text) {
		comment_block.innerHTML = text;
	});
};

const commentPost = (post) => {
	if (uid == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = post.id.replace('post', '');
    const user_id = uid;
    const comment = post.querySelector('input').value;
    let formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('user_id', user_id);
    formData.append('comment', comment);
    request = new Request('/savecomment', {
        method: 'POST',
        body: formData,
    });
    fetch(request)
        .then(function (response) {
            post.querySelector('input').value = '';
        })
		.then(function (response) {
            refreshComments(post);
        })
        .catch(function (error) {
            console.log(error);
        });
};

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        showLoadingIndicator();
        getPosts();
    }
});

getPosts();

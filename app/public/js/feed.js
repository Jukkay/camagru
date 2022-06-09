const loadingIndicator = document.getElementById('loading');
const feed = document.getElementById('feed');
const postsOnPage = 5;
let pageNumber = 0;

const getPosts = () => {
    const nomore = document.getElementById('nomore');
    if (nomore != null)
        return;
    fetch(`/fetchfeed?user_id=${user_id}&limit=${postsOnPage}&page=${pageNumber}`)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            feed.innerHTML = feed.innerHTML + text;
            pageNumber++;
            if (pageNumber > 1)
                return;
            feed.addEventListener('click', (event) => {
                if (event.target.classList.contains('like-icon')) {
                    like(event.target);
                }
                if (event.target.classList.contains('unlike-icon')) {
                    unlike(event.target);
                }
                if (event.target.classList.contains('comment-icon')) {
                    const post = event.target;
                    goToComment(post);
                }
                if (event.target.classList.contains('comment-button')) {
                    const post = event.target;
                    commentPost(post);
                }
                if (event.target.classList.contains('show-comments')) {
                    const post = event.target;
                    showComments(post);
                }
                if (event.target.classList.contains('delete-post')) {
                    const post = event.target;
                    deletePost(post);
                }
            });
        });
};

const like = async (target) => {
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = target.getAttribute("data-id");
    const like_icon = target;
    const unlike_icon = like_icon.nextElementSibling;
    unlike_icon.classList.remove('is-hidden');
    like_icon.classList.add('is-hidden');

    let formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('user_id', user_id);
    request = new Request('/likepost', {
        method: 'POST',
        body: formData,
    });
    fetch(request)
        .catch(function (error) {
            console.log(error);
        });
};

const unlike = async (target) => {
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = target.getAttribute("data-id");
    const unlike_icon = target;
    const like_icon = unlike_icon.previousElementSibling;
    unlike_icon.classList.add('is-hidden');
    like_icon.classList.remove('is-hidden');

    let formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('user_id', user_id);
    request = new Request('/unlikepost', {
        method: 'POST',
        body: formData,
    });
    fetch(request)
        .catch(function (error) {
            console.log(error);
        });
};

const goToComment = (post) => {
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = post.getAttribute("data-id");
    post = post.parentNode;
    let target = post.getElementsByClassName('button')[0];
    target = target.previousElementSibling;
    target.focus();
};

const showComments = (post) => {
    const post_id = post.getAttribute("data-id");
    post = post.parentNode;
	fetch(`/getcomments?post_id=${post_id}`)
	.then(function (response) {
		return response.text();
	})
	.then(function (text) {
        post.innerHTML = '';
		post.innerHTML = text;
	});
}

const refreshComments = (post) => {
	const post_id = post.getAttribute("data-id");
	const comment_block = document.getElementById(`comment-block${post_id}`);
	fetch(`/getcomments?post_id=${post_id}`)
	.then(function (response) {
		return response.text();
	})
	.then(function (text) {
        comment_block.innerHTML = '';
		comment_block.innerHTML = text;
	});
};

const commentPost = (post) => {
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = post.getAttribute("data-id");
    const comment = post.previousElementSibling.value;
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
            post.previousElementSibling.value = '';
        })
		.then(function (response) {
            refreshComments(post);
        })
        .catch(function (error) {
            console.log(error);
        });
};

const deletePost = (post) => {
    if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = post.getAttribute("data-id");
    const post_element = document.querySelector(`[data-id="post${post_id}"]`);
    const image_file = post_element.getElementsByTagName('img')[1].id;
    let formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('user_id', user_id);
    formData.append('image_file', image_file);
    request = new Request('/deletepost', {
        method: 'POST',
        body: formData,
    });
    fetch(request)
        .then(function (response) {
            post_element.remove();
        })
        .catch(function (error) {
            console.log(error);
        });
}
getPosts();

window.addEventListener('scroll', async () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        getPosts();
    }
});


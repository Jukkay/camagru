const userinfo = document.getElementById('userinfo');
const userimages = document.getElementById('userimages');
const loadingIndicator = document.getElementById('loading');
const postsOnPage = 5;
let pageNumber = 0;

const getUserInfo = () => {
	fetch(`/getuserinfo?username=${username}`)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            userinfo.innerHTML = text;
        });
}

const getPosts = () => {
    fetch(`/getuserimages?user_id=${user_id}&username=${username}&limit=${postsOnPage}&page=${pageNumber}`)
        .then(function (response) {
            return response.text();
        })
        .then(function (text) {
            userimages.innerHTML = userimages.innerHTML + text;
            pageNumber++;
            hideLoadingIndicator();
            userimages.addEventListener('click', (event) => {
                if (event.target.classList.contains('like-icon')) {
                    const data_id = event.target.getAttribute("data-id");
                    toggleLike(data_id);
                }
            });
        });
};

const hideLoadingIndicator = () => {
    loadingIndicator.classList.add('is-hidden');
};
const showLoadingIndicator = () => {
    loadingIndicator.classList.remove('is-hidden');
};

const toggleLike = async (data_id) => {
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    let post_id;
    if (data_id.includes('unlike')) {
        post_id = data_id.replace('unlike', '');
        const unlike_icon = document.querySelector(`[data-id="${data_id}"]`);
        const like_icon = unlike_icon.previousElementSibling;
        unlike_icon.classList.add('is-hidden');
        like_icon.classList.remove('is-hidden');
    }
    else {
        post_id = data_id.replace('like', '');
        const like_icon = document.querySelector(`[data-id="${data_id}"]`);
        const unlike_icon = like_icon.nextElementSibling;
        unlike_icon.classList.remove('is-hidden');
        like_icon.classList.add('is-hidden');
    }
    let formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('user_id', user_id);
    request = new Request('/togglelike', {
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
	if (user_id == 0) {
		alert('Please, login first.');
		location.href = '/';
		throw new Error('Please, login first.');
	}
    const post_id = post.id.replace('post', '');
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

getUserInfo();
getPosts();
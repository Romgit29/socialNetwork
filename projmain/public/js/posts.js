function posts(){
    let postBlocks = document.querySelectorAll('.singlePostBlock');
    for(let postBlock of postBlocks) {
        if(postBlock.getAttribute('liked') == true) postBlock.querySelector('.likeButton').style.background = 'red';
        setLikeButtonOnclick(postBlock)
        setRepostButtonLogic(postBlock)
        setAddReplyButtonOnclick(postBlock);
        if(postBlock.querySelector('.editButton')) setEditButtonOnclick(postBlock);
        if(postBlock.querySelector('.deleteButton')) setDeleteButtonOnclick(postBlock);
    }

    function setLikeButtonOnclick(postBlock) {
        let likeButton = postBlock.querySelector('.likeButton');
        likeButton.onclick = async () => {
            let postLikeForm = postBlock.querySelector(".likeForm");
            let postLiked = postBlock.getAttribute('liked');
            if(!likeButton.getAttribute('user_is_authorized')) window.location = postLikeForm.getAttribute('domain') + '/login';
            let action;
            let color;
            let newPostLiked;
            let method;
            if(postLiked == 0) {
                action = 'like';
                color = 'red';
                newPostLiked = 1;
                method = 'POST';
            } else {
                action = 'unlike';
                color = '#36393e';
                newPostLiked = 0;
                method = 'DELETE';
            }
            let url = postLikeForm.getAttribute('domain') + '/posts/' + postBlock.getAttribute('postId') + '/' + action;
            let formData = new FormData(postLikeForm);
            formData.append('_method', method);
            let response = await fetch(url, {
                method: 'POST',
                body: formData
            })
            if(response.status == 200) {
                let data = await response.json();
                let likesCountDiv = likeButton.querySelector(".likesCount");
                let likesCount = data[0].data.likes_count;
                likesCountDiv.innerHTML = likesCount;
                likeButton.style.background = color;
                postBlock.setAttribute('liked', newPostLiked);
            } else {
                toastr.error('Internal server error');
            }
        }
    }

    function setRepostButtonLogic(postBlock) {
        let repostButton = postBlock.querySelector('.repostButton');
        let repostModalWrap = document.getElementById('repostModalWrap');
        let repostModalForm = document.getElementById('repostModalForm');

        repostButton.onclick = () => {
            repostModalWrap.style.display = 'block';
            repostModalForm.setAttribute('action', repostModalForm.getAttribute('domain') + '/posts/' + postBlock.getAttribute('postId') + '/repost');
        }
    }

    function setAddReplyButtonOnclick(postBlock) {
        let discardReplyAddingButton = postBlock.querySelector('.discardReplyAddingButton');
        let postReplyAddBlock = postBlock.querySelector('.addReplyBlock');
        let addReplyButton = postBlock.querySelector('.addReplyButton');
        addReplyButton.onclick = function(){
            postReplyAddBlock.style.display = 'block';
            addReplyButton.style.display = 'none';
        };
        discardReplyAddingButton.onclick = function(){
            postReplyAddBlock.style.display = 'none';
            addReplyButton.style.display = 'block';
        };
    }

    function setEditButtonOnclick(postBlock) {
        let editButton = postBlock.querySelector('.editButton');
        let discardButton = postBlock.querySelector('.discardButton');
        let mainText = postBlock.querySelector('.mainText');
        let textArea = postBlock.querySelector('.editTextArea');
        let originalText = postBlock.querySelector('.mainText .text');
        
        let postEditForm = postBlock.querySelector('.postEditForm');
        editButton.onclick = function() {
            textArea.style.display = 'block';
            textArea.innerHTML = originalText.innerHTML;
            mainText.style.display = 'none';
            editButton.style.display = 'none';
            postEditForm.style.display = 'block';
        }
        discardButton.onclick = function() {
            mainText.style.display = 'block';
            editButton.style.display = 'block';
            postEditForm.style.display = 'none';
            textArea.style.display = 'none';
        }
    }

    function setDeleteButtonOnclick(postBlock) {
        let deleteModalWrap = document.getElementById('deleteModalWrap');
        let deleteModalText = document.getElementById('deleteModalText');
        let deleteModalApplyButton = document.getElementById('deleteModalApplyButton');
        let postDeleteButton = postBlock.querySelector('.deleteButton');
        postDeleteButton.onclick = function() {
            deleteModalText.innerHTML = 'Are you sure you want to delete this post?';
            deleteModalApplyButton.onclick = function() {
                postBlock.querySelector('.deleteForm').submit();
            };
            deleteModalWrap.style.display = 'block';
        }
    }
}
posts();
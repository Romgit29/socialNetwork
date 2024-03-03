function replies(){
    let postReplyBlocks = document.querySelectorAll('.postReply');
    for(let postReplyBlock of postReplyBlocks) {
        if(postReplyBlock.getAttribute('liked') == true) postReplyBlock.querySelector('.likeButton').style.background = 'red';
        setLikeButtonOnclick(postReplyBlock)
        setRepostButtonLogic(postReplyBlock)
        setAddReplyButtonOnclick(postReplyBlock);
        if(postReplyBlock.querySelector('.editButton')) setEditButtonOnclick(postReplyBlock);
        if(postReplyBlock.querySelector('.deleteButton')) setDeleteButtonOnclick(postReplyBlock);
    }

    function setLikeButtonOnclick(postReplyBlock) {
        let likeButton = postReplyBlock.querySelector('.likeButton');
        likeButton.onclick = async () => {
            let postLikeForm = postReplyBlock.querySelector(".likeForm");
            let postLiked = postReplyBlock.getAttribute('liked');
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
            let url = postLikeForm.getAttribute('domain') + '/postReplies/' + postReplyBlock.getAttribute('postReplyId') + '/' + action;
            let formData = new FormData(postLikeForm);
            formData.append('_method', method);
            let response = await fetch(url, {
                method: 'POST',
                body: formData
            })
            if(response.status == 200) {
                likeButton.style.background = color;
                postReplyBlock.setAttribute('liked', newPostLiked);
            } else {
                toastr.error('Internal server error');
            }
        }
    }

    function setRepostButtonLogic(postReplyBlock) {
        let repostButton = postReplyBlock.querySelector('.repostButton');
        let repostModalWrap = document.getElementById('repostModalWrap');
        let repostModalForm = document.getElementById('repostModalForm');
        repostButton.onclick = () => {
            repostModalWrap.style.display = 'block';
            repostModalForm.setAttribute('action', repostModalForm.getAttribute('domain') + '/postReplies/' + postReplyBlock.getAttribute('postReplyId') + '/repost');
        }
    }

    function setAddReplyButtonOnclick(postReplyBlock) {
        let discardReplyAddingButton = postReplyBlock.querySelector('.discardReplyAddingButton');
        let postReplyAddBlock = postReplyBlock.querySelector('.addReplyBlock');
        let addReplyButton = postReplyBlock.querySelector('.addReplyButton');
        addReplyButton.onclick = function() {
            postReplyAddBlock.style.display = 'block';
            addReplyButton.style.display = 'none';
        };
        discardReplyAddingButton.onclick = function(){
            postReplyAddBlock.style.display = 'none';
            addReplyButton.style.display = 'block';
        };
    }

    function setEditButtonOnclick(postReplyBlock) {
        let editButton = postReplyBlock.querySelector('.editButton');
        let discardButton = postReplyBlock.querySelector('.discardButton');
        let textArea = postReplyBlock.querySelector('.editTextArea');
        let originalText = postReplyBlock.querySelector('.mainText .text');
        let editBlock = postReplyBlock.querySelector('.replyEditForm');
        let replyContent = postReplyBlock.querySelector('.replyContent');
        editButton.onclick = function() {
            textArea.innerHTML = originalText.innerHTML;
            editButton.style.display = 'none';
            replyContent.style.display = 'none';
            textArea.style.display = 'block';
            editBlock.style.display = 'block';
        }
        discardButton.onclick = function() {
            editBlock.style.display = 'none';
            textArea.style.display = 'none';
            replyContent.style.display = 'block';
            editButton.style.display = 'block';
        }
    }

    function setDeleteButtonOnclick(postReplyBlock) {
        let deleteModalWrap = document.getElementById('deleteModalWrap');
        let deleteModalText = document.getElementById('deleteModalText');
        let deleteModalApplyButton = document.getElementById('deleteModalApplyButton');
        let postDeleteButton = postReplyBlock.querySelector('.deleteButton');
        postDeleteButton.onclick = function() {
            deleteModalText.innerHTML = 'Are you sure you want to delete this reply?';
            deleteModalApplyButton.onclick = function() {
                postReplyBlock.querySelector('.deleteForm').submit();
            };
            deleteModalWrap.style.display = 'block';
        }
    }
}
replies();
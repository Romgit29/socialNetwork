function postRepliesEdit(){
    let postReplyEditButtons = document.querySelectorAll('.btnPostReplyEdit');
    
    for(let i=0;i<postReplyEditButtons.length;i++){
        let postKey = postReplyEditButtons[i].getAttribute("postKey");
        let replyKey = postReplyEditButtons[i].getAttribute("replyKey");

        let originalPostReplyText = document.getElementById('postReplyText_' + postKey + '_' + replyKey);
        let postReplyEditTextArea = document.getElementById('postReplyEditTextArea_' + postKey + '_' + replyKey);
        let postReplyLikeButton = document.getElementById('postReplyLikeButton_' + postKey + '_' + replyKey);
        let postReplyRepostButton = document.getElementById('postReplyRepostButton_' + postKey + '_' + replyKey);
        let btnReplyShow = document.getElementById('btnReplyShow_' + postKey + '_' + replyKey);
        let btnPostReplyEdit = document.getElementById('btnPostReplyEdit_' + postKey + '_' + replyKey);
        let postReplyEditApplyButton = document.getElementById('postReplyEditApplyButton_' + postKey + '_' + replyKey);
        let postReplyEditDiscardButton = document.getElementById('postReplyEditDiscardButton_' + postKey + '_' + replyKey);
        let postReplyDeleteButton = document.getElementById('postReplyDeleteButton_' + postKey + '_' + replyKey);
        let postReplyEditTextInput = document.getElementById('postReplyEditText_' + postKey + '_' + replyKey);
        
        postReplyEditButtons[i].onclick = function() {
            postReplyEditTextArea.style.display = 'block';
            postReplyEditTextArea.value = originalPostReplyText.innerText;
            postReplyEditTextArea.style.height = (originalPostReplyText.offsetHeight) + "px";
            originalPostReplyText.style.display = 'none';

            postReplyLikeButton.style.display = 'none';
            btnPostReplyEdit.style.display = 'none';
            postReplyRepostButton.style.display = 'none';
            btnReplyShow.style.display = 'none';
            postReplyDeleteButton.style.display = 'none';
            
            postReplyEditDiscardButton.style.display = 'block';
            postReplyEditApplyButton.style.display = 'block';

            // postReplyEditTextArea.style.height = 0;
            // postReplyEditTextArea.style.height = (postReplyEditTextArea.scrollHeight) + "px";
            // postReplyEditTextArea.addEventListener("input", onTextareaInput, false);
        }

        postReplyEditDiscardButton.onclick = function() {
            postReplyEditTextArea.style.display = 'none';
            postReplyEditTextArea.value = '';
            originalPostReplyText.style.display = 'block';

            postReplyLikeButton.style.display = 'block';
            btnPostReplyEdit.style.display = 'block';
            postReplyRepostButton.style.display = 'block';
            btnReplyShow.style.display = 'block';
            postReplyDeleteButton.style.display = 'block';
            
            postReplyEditApplyButton.style.display = 'none'; 
            postReplyEditDiscardButton.style.display = 'none';
        }

        postReplyEditApplyButton.onclick = function() {
            postReplyEditTextInput.value = postReplyEditTextArea.value;
        }
    }

    // function onTextareaInput() {
    //     this.style.height = 0;
    //     this.style.height = (this.scrollHeight) + "px";
    // }
}
postRepliesEdit();
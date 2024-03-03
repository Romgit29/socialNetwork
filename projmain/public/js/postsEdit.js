// function postsEdit(){
//     let postEditButtons = document.querySelectorAll('.btnPostEdit');
    
//     for(let i=0;i<postEditButtons.length;i++){
//         let originalPostText = document.getElementById('postText_' + i);
//         let postEditTextArea = document.getElementById('postEditTextArea_' + i);
//         let postLikeButton = document.getElementById('postLikeButton_' + i);
//         let postRepostButton = document.getElementById('postRepostButton_' + i);
//         let btnReplyShow = document.getElementById('btnReplyShow_' + i);
//         let btnPostEdit = document.getElementById('btnPostEdit_' + i);
//         let postEditApplyButton = document.getElementById('postEditApplyButton_' + i);
//         let postEditDiscardButton = document.getElementById('postEditDiscardButton_' + i);
//         let postDeleteButton = document.getElementById('postDeleteButton_' + i);
//         let postEditTextInput = document.getElementById('postEditText_' + i);
        
//         postEditButtons[i].onclick = function() {
//             postEditTextArea.style.display = 'block';
//             postEditTextArea.value = originalPostText.innerText;
//             originalPostText.style.display = 'none';
//             postLikeButton.style.display = 'none';
//             btnPostEdit.style.display = 'none';
//             postRepostButton.style.display = 'none';
//             btnReplyShow.style.display = 'none';
//             postDeleteButton.style.display = 'none';
//             postEditApplyButton.style.display = 'block';
//             postEditDiscardButton.style.display = 'block';
//         }

//         postEditDiscardButton.onclick = function() {
//             postEditTextArea.style.display = 'none';
//             postEditTextArea.value = '';
//             originalPostText.style.display = 'block';
//             postLikeButton.style.display = 'block';
//             btnPostEdit.style.display = 'block';
//             postRepostButton.style.display = 'block';
//             btnReplyShow.style.display = 'block';
//             postDeleteButton.style.display = 'block';
//             postEditApplyButton.style.display = 'none'; 
//             postEditDiscardButton.style.display = 'none';
//         }

//         postEditApplyButton.onclick = function() {
//             postEditTextInput.value = postEditTextArea.value;
//         }
//     }
// }
// postsEdit();
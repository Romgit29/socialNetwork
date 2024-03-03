import {showFullButtonLogic} from './showFullButtonLogic.js';
import {postLikeOnclick} from './postLikeOnclick.js';
import {setRepostsOnclick} from './setRepostsOnclick.js';

function posts(){
    let postReplyButtons = document.querySelectorAll('.btnReplyShow');

    for(let i=0; i<postReplyButtons.length; i++){
        let elem = postReplyButtons[i];
        elem.onclick = function(){
            let postKey = '';
            let replyKey = '';
            let isPostreply = elem.getAttribute('isPostreply');
            let postIdDB = elem.getAttribute('postIdDB');
            let split = elem.id.split('_');

            postKey = split[1];
            if(isPostreply) {
                replyKey = split[2]; 
            }

            for(let postReplyButton of postReplyButtons){
                let subPostKey = '';
                let subReplyKey = '';
                let subIsPostreply = postReplyButton.getAttribute('isPostreply');
                let subSplit = postReplyButton.id.split('_');

                subPostKey = subSplit[1];
                if(subIsPostreply) {
                    subReplyKey = subSplit[2];
                }

                if(!subIsPostreply) {
                    document.getElementById('btnReplyShow_' + subPostKey).style.display = "block";
                    document.getElementById('postReplyForm_' + subPostKey).innerHTML = '';
                }
                else {
                    document.getElementById('btnReplyShow_' + subPostKey + '_' + subReplyKey).style.display = "block";
                    document.getElementById('postReplyForm_' + subPostKey + '_' + subReplyKey).innerHTML = '';
                }
            }
            
            if(!isPostreply) {
                let replyForm = document.getElementById('postReplyForm_' + postKey);
                let closeButtonId = 'closeButton_' + postKey;
                let replyform = `
                <div>
                    <textarea name='text' class='textareaGeneral' id='postReplyForm' form="postReplyAddForm"></textarea>
                </div>
                <input type='hidden' name='post_id' value='${postIdDB}' form="postReplyAddForm">
                <div class='defaultMarginTop'>
                    <div class="btn btn-primary btn-sm defaultButton" id="addReplyButton" type="submit" form="postReplyAddForm">Send</div>
                    <div class='btn btn-danger btn-sm defaultButton' id='${closeButtonId}' on style='margin-left: 5px;' type="submit" form="myform">Close</div>
                </div>`
                
                replyForm.innerHTML = replyform;
                document.getElementById(closeButtonId).onclick = function() {
                    replyForm.innerHTML = '';
                    if(document.getElementById("postEditTextArea_" + postKey).style.display !== 'block') elem.style.display = "block";
                }
                document.getElementById("addReplyButton").onclick = function() {
                    document.getElementById('postReplyAddForm').submit();
                }
            }
            else {
                let replyForm = document.getElementById('postReplyForm_'+ postKey + '_' + replyKey);
                let closeButtonId = 'closeButton_' + postKey + '_' + replyKey;
                let replyform = `
                <div class='defaultMarginTop'>
                    <textarea name="text" class='textareaGeneral' id='postReplyForm'></textarea>
                </div>
                <input type='hidden' id='replyPostId' name='post_id' value='${postIdDB}'>
                <div class='defaultMarginTop'>
                    <div class="btn btn-primary btn-sm defaultButton" id="addReplyButton" type="submit" form="postReplyAddForm" style='width:100px; margin-top:3px;'>Send</div>
                    <div class='btn btn-danger btn-sm defaultButton' id='${closeButtonId}' on style='width:100px; margin-left:5px; margin-top:3px;' type="submit" form="myform">Close</div>
                </div>`
                
                replyForm.innerHTML = replyform;
                document.getElementById(closeButtonId).onclick = function() {
                    replyForm.innerHTML = '';
                    if(document.getElementById("postReplyEditTextArea_" + postKey + "_" + replyKey).style.display !== 'block') elem.style.display = "block";
                }
                document.getElementById("addReplyButton").onclick = function() {
                    let form = document.getElementById('postReplyAddForm');
                    let input = document.getElementById('replyPostId');
                    let text = document.getElementById('postReplyForm');
                    form.appendChild(input);
                    form.appendChild(text);
                    document.getElementById('postReplyAddForm').submit();
                }
            }

            elem.style.display = "none";
        };
    }

    let deleteModalWrap = document.getElementById('deleteModalWrap');
    let deleteModalText = document.getElementById('deleteModalText');
    let deleteModalApplyButton = document.getElementById('deleteModalApplyButton');

    let postDeleteButtons = document.querySelectorAll('.postDeleteButton');
    for(let i=0; i<postDeleteButtons.length; i++){
        let elem = postDeleteButtons[i];
        elem.onclick = function() {
            deleteModalText.innerHTML = 'Are you sure you want to delete this post?';
            deleteModalApplyButton.onclick = function() {
                document.getElementById('postDeleteForm_' + elem.getAttribute('postKey')).submit();
            };
            deleteModalWrap.style.display = 'block';
        }
    }

    let postDeleteReplyButtons = document.querySelectorAll('.postReplyDeleteButton');
    for(let i=0; i<postDeleteReplyButtons.length; i++){
        let elem = postDeleteReplyButtons[i];
        elem.onclick = function() {
            deleteModalText.innerHTML = 'Are you sure you want to delete this reply?';
            deleteModalApplyButton.onclick = function() {
                document.getElementById('postReplyDeleteForm_' + elem.getAttribute('postKey') + '_' + elem.getAttribute('replyKey')).submit();
            };
            deleteModalWrap.style.display = 'block';
        }
    }

    let postShowFullButtons = document.querySelectorAll('.postShowFullButton');
    for(let i=0; i < postShowFullButtons.length; i++){
        let elem = postShowFullButtons[i];
        let postKey = elem.getAttribute('postKey');
        let postTextWrap = document.getElementById('postTextWrap_' + postKey);
        let postText = document.getElementById('postText_' + postKey);
        showFullButtonLogic(postText, postTextWrap, elem);
    }

    let postReplyShowFullButtons = document.querySelectorAll('.postReplyShowFullButton');
    for(let i=0; i < postReplyShowFullButtons.length; i++){
        let elem = postReplyShowFullButtons[i];
        let postKey = elem.getAttribute('postKey');
        let replyKey = elem.getAttribute('replyKey');
        let replyTextWrap = document.getElementById('postReplyText_' + postKey + '_' + replyKey);
        let replyText = document.getElementById('postReplyTextWraped_' + postKey + '_' + replyKey);
        showFullButtonLogic(replyText, replyTextWrap, elem);
    }

    let postRepostShowFullButtons = document.querySelectorAll('.repostShowFullButton');
    for(let i=0; i < postRepostShowFullButtons.length; i++){
        let elem = postRepostShowFullButtons[i];
        let postKey = elem.getAttribute('postKey');
        let repostTextWrap = document.getElementById('repostTextWrap_' + postKey);
        let repostText = document.getElementById('repostText_' + postKey);
        showFullButtonLogic(repostText, repostTextWrap, elem);
    }

    let postLikeButtons = document.querySelectorAll('.postLikeButton');

    for(let i=0; i < postLikeButtons.length; i++){
        let elem = postLikeButtons[i];
        let isLiked = elem.getAttribute('postLiked');
        if(isLiked == 1) elem.style.background = 'red';
        postLikeOnclick(elem);
    }
    setRepostsOnclick();
}
posts();
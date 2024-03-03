export function setRepostsOnclick(){
    let postRepostButtons = document.querySelectorAll('.postRepostButton');
    let postReplyRepostButtons = document.querySelectorAll('.postReplyRepostButton');
    let repostModalWrap = document.getElementById('repostModalWrap');
    let repostModalForm = document.getElementById('repostModalForm');
    let repostModalFormType = document.getElementById('repostModalFormType');
    let repostableType = '';

    for(let repostButton of postRepostButtons) {
        repostButton.onclick = () => {
            repostModalWrap.style.display = 'block';
            repostModalFormType.value = 'post';
            repostableType = 'posts';

            repostModalForm.setAttribute('action', repostModalForm.getAttribute('domain') + '/' + repostableType + '/' + repostButton.getAttribute('repostableId') + '/repost')
        }
    }

    for(let repostButton of postReplyRepostButtons) {
        repostButton.onclick = () => {
            repostModalWrap.style.display = 'block';
            repostModalFormType.value = 'reply';
            repostableType = 'postReplies';

            repostModalForm.setAttribute('action', repostModalForm.getAttribute('domain') + '/' + repostableType + '/' + repostButton.getAttribute('repostableId') + '/repost')
        }
    }
}
function showFullButtonLogic() {
    let corpedTextBlocks = document.querySelectorAll('.corpedTextBlock');
    for(let corpedTextBlock of corpedTextBlocks) {
        let text = corpedTextBlock.querySelector('.text');
        let textWrap = corpedTextBlock.querySelector('.textTurncationBlock');
        let showFullButton = corpedTextBlock.querySelector('.showFullButton');
        if(text.offsetHeight > 115) showFullButton.style.display = 'block';
            showFullButton.onclick = function() {
            textWrap.style.maxHeight = 'none';
            showFullButton.style.display = 'none';
        }
    }
}
showFullButtonLogic();
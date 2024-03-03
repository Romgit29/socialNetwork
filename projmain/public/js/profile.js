function profile() {
    toastr.options.progressBar = true;
    const originalProfilePicSrc = document.getElementById('profilePic').src;
    let editProfileButton = document.getElementById('editProfile');
    let name = document.getElementById('profileData_name');
    let status = document.querySelector('#profileData_status .text');
    let applyEdit = document.getElementById('applyEdit');
    let discardEdit = document.getElementById('discardEdit');
    let corpSquare = document.getElementById('corpSquare');
    let smallCircles = document.getElementsByClassName('cornerCircle');
    let ppCorpModalArea = document.getElementById('picCorpModal_corpArea');
    let ppCorpModal = document.getElementById('picCorpModal');
    let ppCorpSave = document.getElementById('picCorpModal_saveButton');
    let ppCorpClose = document.getElementById('picCorpModal_closeButton');
    let ppCorpImg = null;
    let originalName = name.innerHTML;
    let originalStatus = status.innerHTML;
    let profilePic = document.getElementById("profilePic");
    let imageUploadButtons = document.getElementById("imageUploadButtons");
    let ppInput = document.getElementById('ppInput');
    let ppCorped = document.getElementById('ppCorped');
    let editProfileForm = document.getElementById("editProfileForm");
    let deleteProfilePicButton = document.getElementById("deleteProfilePicButton");
    let deleteProfilePicInput = document.getElementById("deleteProfilePicInput");
    let defaultStoragePath = document.getElementById("defaultStoragePath");

    function cropImage() {
        let canvasCorpingArea = document.createElement('canvas');
        let ctx = canvasCorpingArea.getContext('2d');
        canvasCorpingArea.width = 498;
        canvasCorpingArea.height = 498;
        ctx.drawImage(ppCorpImg, ppCorpImg.offsetLeft, ppCorpImg.offsetTop, ppCorpImg.offsetWidth, ppCorpImg.offsetHeight);
        
        let canvasSquaredImage = document.createElement('canvas');
        ctx = canvasSquaredImage.getContext('2d');
        canvasSquaredImage.width = 150;
        canvasSquaredImage.height = 150;
        ctx.drawImage(canvasCorpingArea, corpSquare.offsetLeft, corpSquare.offsetTop, corpSquare.offsetWidth, corpSquare.offsetHeight, 0, 0, 150, 150);

        profilePic.src = canvasSquaredImage.toDataURL();
        
        fetch(profilePic.src)
        .then(res => res.blob())
        .then(blob => {
            let file = new File([blob], 'profilePicThumbnail.jpeg', blob);
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            ppCorped.files = dataTransfer.files;
        });
        ppCorpModal.style.display = 'none';
    }

    ppCorpClose.onclick = function(){
        ppCorpModal.style.display = 'none';
    }

    deleteProfilePicButton.onclick = function(){
        deleteProfilePicInput.value = 1;
        profilePic.src = defaultStoragePath.innerHTML + '/img_static/defaultpp.jpg'
        clearFileInput(ppInput);
        clearFileInput(ppCorped);
    }

    discardEdit.onclick = function(){
        profilePic.src = originalProfilePicSrc;
        name.innerHTML = originalName;
        status.innerHTML = originalStatus;
        if(editProfileButton) editProfileButton.style.display = 'block';
        applyEdit.style.display = 'none';
        discardEdit.style.display = 'none';
        imageUploadButtons.style.display = 'none';
        editProfileForm.reset();
    }

    ppCorpSave.onclick = function(){
        let left = corpSquare.offsetLeft;
        let top = corpSquare.offsetTop;

        if(ppCorpImg.offsetLeft < 0) {
            left = left - ppCorpImg.offsetLeft;
        } else if (ppCorpImg.offsetLeft > 0) {
            left = left + ppCorpImg.offsetLeft;
        }

        if(ppCorpImg.offsetTop < 0) {
            top = top - ppCorpImg.offsetTop;
        } else if (ppCorpImg.offsetTop > 0) {
            top = top + ppCorpImg.offsetTop;
        }

        cropImage(left, top, corpSquare.offsetWidth, corpSquare.offsetHeight);
    }
    
    if(editProfileButton) {
        editProfileButton.onclick = function(){
            name.innerHTML = `<textarea form="editProfileForm" id='nameTextarea' style='resize: none; width: 100%; height:${name.offsetHeight + 3}px;' name='name' form='editProfileForm'>${name.innerHTML}</textarea>`
            status.innerHTML = `<textarea form="editProfileForm" id='statusTextarea' style='word-break: break-all; resize: none; width: 100%; height: 115px; max-height: 115px; min-height: 115px; margin-top:5px; position: relative; z-index: 1;' name='status' form='editProfileForm'>${status.innerText}</textarea>`
            imageUploadButtons.style.display = 'flex';
    
            ppInput.onchange= function(){
                if(this.files.length == 0) return;
                let file = this.files[0];
                
                let fileReader = new FileReader();
    
                fileReader.onloadend = function(e) {
                    let arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                    let header = "";
                    let type = "";
                    for(let i = 0; i < arr.length; i++) {
                        header = header + arr[i].toString(16);
                    }
                    switch (header) {
                        case "89504e47":
                            type = "image/png";
                            break;
                        case "ffd8ffe0":
                        case "ffd8ffe1":
                        case "ffd8ffe2":
                        case "ffd8ffe3":
                        case "ffd8ffe8":
                            type = "image/jpeg";
                            break;
                        default:
                            type = "something else";
                            break;
                    }
                    if(type == "something else") {
                        toastr.error('Inappropriate file type');
                        return;
                    }
                    let img = new Image();
                    let objectUrl = URL.createObjectURL(file);
                    img.src = objectUrl;
                    img.onload = function () {
                        if(img.height < 150 || img.width < 150) {
                            toastr.error('Image height and with must be greater than 150px');
                            URL.revokeObjectURL(objectUrl);    
                            return;
                        }
                        corpSquare.style.width = '150px';
                        corpSquare.style.height = corpSquare.style.width;
                        corpSquare.style.left = '174px'
                        corpSquare.style.top = '174px'
                        ppCorpModal.style.display = 'flex';
                        ppCorpImg = document.createElement('img');
                        ppCorpImg.src = objectUrl;
                        document.getElementById('picCorpModal_img').innerHTML = '';
                        ppCorpImg.style.minWidth = '150px';
                        ppCorpImg.style.maxWidth = '498px';
                        ppCorpImg.style.minHeight = '150px';
                        ppCorpImg.style.position = 'absolute';
                        document.getElementById('picCorpModal_img').append(ppCorpImg);
                        ppCorpImg = document.querySelector('#picCorpModal_img img');
                        if(ppCorpImg.offsetHeight > 498) ppCorpImg.style.top = -(ppCorpImg.offsetHeight / 2) + 248 + "px";
                        else ppCorpImg.style.top = 248 - ppCorpImg.offsetHeight / 2 + "px";
                        if(ppCorpImg.offsetWidth > 498) ppCorpImg.style.left = -(ppCorpImg.offsetWidth / 2) + 248 + "px";
                        else ppCorpImg.style.left = 248 - ppCorpImg.offsetWidth / 2 + "px";
                        imgScale(ppCorpModalArea);
                        dragElement(corpSquare, 'cornerCircle');
                        for(let element of smallCircles) {
                            element.onmousedown = ()=>{if (e.which === 1 || e.button === 0) corpSquare.style.cursor = 'grabbing'}
                            scaleSquare(element); 
                        }
                        imgGrab(ppCorpImg);
                        URL.revokeObjectURL(objectUrl);
                    };
                };
                fileReader.readAsArrayBuffer(file);
            }
            applyEdit.style.display='inline-block';
            discardEdit.style.display='inline-block';
            editProfileButton.style.display='none';
        }
    }

    corpSquare.onmousedown = function(){if (e.which === 1 || e.button === 0) corpSquare.style.cursor = 'grabbing'}

    function dragElement(elmnt, notDragable=null) {
        let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        elmnt.onmousedown = dragMouseDown;
        
        function dragMouseDown(e) {
            if (e.which !== 1 || e.button !== 0) return;
            e = e || window.event;
            e.preventDefault();
            document.onmouseleave = ()=>{corpSquare.style.cursor = 'grab'};
            corpSquare.style.cursor = 'grabbing'
            document.body.style.cursor = 'grabbing';
            if(notDragable) {
            if(e.target.className != notDragable) {
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                document.onmousemove = elementDrag;
            }
            } else {
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
            }
        }
        
        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;

            if(corpSquare.offsetTop >= ppCorpImg.offsetTop 
            && corpSquare.offsetLeft >= ppCorpImg.offsetLeft 
            && corpSquare.offsetLeft + corpSquare.offsetWidth <= ppCorpImg.offsetLeft + ppCorpImg.offsetWidth 
            && corpSquare.offsetTop + corpSquare.offsetHeight <= ppCorpImg.offsetTop + ppCorpImg.offsetHeight 
            && corpSquare.offsetTop >= 0 
            && corpSquare.offsetLeft >= 0 
            && corpSquare.offsetLeft + corpSquare.offsetWidth <= ppCorpModalArea.offsetLeft + ppCorpModalArea.offsetWidth 
            && corpSquare.offsetTop + corpSquare.offsetHeight <= ppCorpModalArea.offsetTop + ppCorpModalArea.offsetHeight) 
            {
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            } else {
            if(corpSquare.offsetTop < ppCorpImg.offsetTop) corpSquare.style.top = `${ppCorpImg.offsetTop}px`;
            if(corpSquare.offsetTop < 0) corpSquare.style.top = "0px";
            if(corpSquare.offsetLeft < ppCorpImg.offsetLeft ) corpSquare.style.left = `${ppCorpImg.offsetLeft}px`;
            if(corpSquare.offsetLeft < 0 ) corpSquare.style.left = "0px";
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > ppCorpImg.offsetLeft + ppCorpImg.offsetWidth) corpSquare.style.left = `${ppCorpImg.offsetLeft + ppCorpImg.offsetWidth - corpSquare.offsetWidth}px`;
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > 498) corpSquare.style.left = `${498 - corpSquare.offsetWidth}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > ppCorpImg.offsetTop + ppCorpImg.offsetHeight) corpSquare.style.top = `${ppCorpImg.offsetTop + ppCorpImg.offsetHeight - corpSquare.offsetHeight}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > 499) corpSquare.style.top = `${499 - corpSquare.offsetHeight}px`;
            }
        }
        
        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
            corpSquare.style.cursor = 'grab';
            document.body.style.cursor = 'default';
            
            if(corpSquare.offsetTop < ppCorpImg.offsetTop) corpSquare.style.top = `${ppCorpImg.offsetTop}px`;
            if(corpSquare.offsetTop < 0) corpSquare.style.top = "0px";
            if(corpSquare.offsetLeft < ppCorpImg.offsetLeft ) corpSquare.style.left = `${ppCorpImg.offsetLeft}px`;
            if(corpSquare.offsetLeft < 0 ) corpSquare.style.left = "0px";
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > ppCorpImg.offsetLeft + ppCorpImg.offsetWidth) corpSquare.style.left = `${ppCorpImg.offsetLeft + ppCorpImg.offsetWidth - corpSquare.offsetWidth}px`;
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > 498) corpSquare.style.left = `${498 - corpSquare.offsetWidth}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > ppCorpImg.offsetTop + ppCorpImg.offsetHeight) corpSquare.style.top = `${ppCorpImg.offsetTop + ppCorpImg.offsetHeight - corpSquare.offsetHeight}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > 498) corpSquare.style.top = `${498 - corpSquare.offsetHeight}px`;
        }
    }
    
    var posStartX;
    var posStartY;
    var scaleSquareTarget

    function scaleSquare (element) {
        element.onmousedown = function(e) {
            if (e.which !== 1 || e.button !== 0) return;
            e.preventDefault();
            element.style.cursor = 'grabbing'
            posStartX = e.clientX;
            posStartY = e.clientY;
            scaleSquareTarget = e.target.id
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            document.onmouseup = closeDragElement;
            let pos1 = posStartX - e.clientX;
            let pos2 = posStartY - e.clientY;
            posStartX = e.clientX;
            posStartY = e.clientY;
            if(
                corpSquare.offsetTop >= ppCorpImg.offsetTop 
                && corpSquare.offsetLeft >= ppCorpImg.offsetLeft 
                && corpSquare.offsetLeft + corpSquare.offsetWidth <= ppCorpImg.offsetLeft + ppCorpImg.offsetWidth 
                && corpSquare.offsetTop + corpSquare.offsetHeight <= ppCorpImg.offsetTop + ppCorpImg.offsetHeight 
                && corpSquare.offsetTop >= 0 
                && corpSquare.offsetLeft >= 0 
                && corpSquare.offsetLeft + corpSquare.offsetWidth <= ppCorpModalArea.offsetLeft + ppCorpModalArea.offsetWidth 
                && corpSquare.offsetTop + corpSquare.offsetHeight <= ppCorpModalArea.offsetTop + ppCorpModalArea.offsetHeight
                ) 
                {
                if(scaleSquareTarget == 'picCorpModal_corpSquare_circleBottomRight') corpSquare.style.height = `${corpSquare.offsetHeight - pos1 - pos2}px`;
                if(scaleSquareTarget == 'picCorpModal_corpSquare_circleBottomLeft') corpSquare.style.height = `${corpSquare.offsetHeight + pos1 - pos2}px`;
                if(scaleSquareTarget == 'picCorpModal_corpSquare_circleTopLeft') corpSquare.style.height = `${corpSquare.offsetHeight + pos1 + pos2}px`;
                if(scaleSquareTarget == 'picCorpModal_corpSquare_circleTopRight') corpSquare.style.height = `${corpSquare.offsetHeight - pos1 + pos2}px`;
                corpSquare.style.width = corpSquare.style.height;
            }
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
            element.style.cursor = 'grab';
            corpSquare.style.cursor = 'grab';
            document.body.style.cursor = 'default'
            if(corpSquare.offsetHeight < 150) corpSquare.style.height = corpSquare.style.width = '150px'
            if(corpSquare.offsetHeight > ppCorpImg.offsetHeight) corpSquare.style.height = `${ppCorpImg.offsetHeight}px`
            if(corpSquare.offsetHeight > 498) corpSquare.style.height = `498px`
            corpSquare.style.width = corpSquare.style.height;
            if(corpSquare.offsetTop < ppCorpImg.offsetTop) corpSquare.style.top = `${ppCorpImg.offsetTop}px`;
            if(corpSquare.offsetTop < 0) corpSquare.style.top = "0px";
            if(corpSquare.offsetLeft < ppCorpImg.offsetLeft ) corpSquare.style.left = `${ppCorpImg.offsetLeft}px`;
            if(corpSquare.offsetLeft < 0 ) corpSquare.style.left = "0px";
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > ppCorpImg.offsetLeft + ppCorpImg.offsetWidth) {
                corpSquare.style.width = corpSquare.style.height = `${ppCorpImg.offsetWidth}px`;
                corpSquare.style.left = `${ppCorpImg.offsetLeft + ppCorpImg.offsetWidth - corpSquare.offsetWidth}px`;
            }
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > 498) {
                if(corpSquare.offsetWidth > 498) corpSquare.style.width = '498px'
                corpSquare.style.left = `${498 - corpSquare.offsetWidth}px`;
            }
            if(corpSquare.offsetTop + corpSquare.offsetHeight > ppCorpImg.offsetTop + ppCorpImg.offsetHeight) corpSquare.style.top = `${ppCorpImg.offsetTop + ppCorpImg.offsetHeight - corpSquare.offsetHeight}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > 498) {
                if(corpSquare.offsetHeight > 498) corpSquare.style.height = '498px'
                corpSquare.style.top = `${498 - corpSquare.offsetHeight}px`;
            }
        }
    }

    function imgScale(element) {
        element.onwheel = function (e) {
            e.preventDefault();
            if(e.wheelDelta > 0) {
                if(ppCorpImg.offsetWidth + 50 <= window.screen.width && ppCorpImg.offsetHeight + 50 <= window.screen.height) {
                    let oldWidth = ppCorpImg.offsetWidth;
                    ppCorpImg.style['max-width'] = oldWidth + 30 + "px";
                    if(ppCorpImg.naturalWidth < ppCorpImg.offsetWidth) {
                        ppCorpImg.style.left = (ppCorpImg.offsetLeft - 15) + "px";
                    }
                }
            };
            if(e.wheelDelta < 0) {
                if(ppCorpImg.offsetHeight > 150 && ppCorpImg.offsetWidth > 150) {
                    let oldWidth = ppCorpImg.offsetWidth;
                    ppCorpImg.style['max-width'] = oldWidth - 30 + "px";
                }
            };
            if(ppCorpImg.offsetHeight > 498) ppCorpImg.style.top = -(ppCorpImg.offsetHeight / 2) + 248 + "px";
            else ppCorpImg.style.top = 248 - ppCorpImg.offsetHeight / 2 + "px";
            if(ppCorpImg.offsetWidth > 498) ppCorpImg.style.left = -(ppCorpImg.offsetWidth / 2) + 248 + "px";
            else ppCorpImg.style.left = 248 - ppCorpImg.offsetWidth / 2 + "px";
            if(corpSquare.offsetHeight < 150) corpSquare.style.height = corpSquare.style.width = '150px'
            if(corpSquare.offsetHeight > ppCorpImg.offsetHeight) corpSquare.style.height = `${ppCorpImg.offsetHeight}px`
            corpSquare.style.width = corpSquare.style.height;
            if(corpSquare.offsetTop < ppCorpImg.offsetTop) corpSquare.style.top = `${ppCorpImg.offsetTop}px`;
            if(corpSquare.offsetTop < 0) corpSquare.style.top = "0px";
            if(corpSquare.offsetLeft < ppCorpImg.offsetLeft ) corpSquare.style.left = `${ppCorpImg.offsetLeft}px`;
            if(corpSquare.offsetLeft < 0 ) corpSquare.style.left = "0px";
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > ppCorpImg.offsetLeft + ppCorpImg.offsetWidth) {
                corpSquare.style.width = corpSquare.style.height = `${ppCorpImg.offsetWidth}px`;
                corpSquare.style.left = `${ppCorpImg.offsetLeft + ppCorpImg.offsetWidth - corpSquare.offsetWidth}px`;
            }
            if(corpSquare.offsetLeft + corpSquare.offsetWidth > 498) corpSquare.style.left = `${498 - corpSquare.offsetWidth}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > ppCorpImg.offsetTop + ppCorpImg.offsetHeight) corpSquare.style.top = `${ppCorpImg.offsetTop + ppCorpImg.offsetHeight - corpSquare.offsetHeight}px`;
            if(corpSquare.offsetTop + corpSquare.offsetHeight > 498) corpSquare.style.top = `${498 - corpSquare.offsetHeight}px`;
        }
    }

    function imgGrab(element) {
        element.onmousedown = function(e) {
            if (e.which !== 1 || e.button !== 0) return;
            let pos3 = e.clientX;
            let pos4 = e.clientY;
            e.preventDefault();
            element.onmouseup = closeDragElement;
            document.onmousemove = function(e) {
                e = e || window.event;
                e.preventDefault();
                document.onmouseup = closeDragElement;
                element.style.cursor = 'grabbing'
                document.body.style.cursor = 'grabbing';

                let pos1 = pos3 - e.clientX;
                let pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // pos2 вниз - вверх + 
                // offsetTop вниз + вверх -
                if((ppCorpImg.offsetLeft <= 0 && ppCorpImg.offsetLeft + ppCorpImg.offsetWidth >= 498) && pos1 > 0) element.style.left = (element.offsetLeft - pos1) + "px"
                if(ppCorpImg.offsetLeft + ppCorpImg.offsetWidth < 498 && ppCorpImg.offsetLeft < 0) element.style.left = (498 - ppCorpImg.offsetWidth) + "px"
                if((ppCorpImg.offsetLeft <= 0 && ppCorpImg.offsetLeft + ppCorpImg.offsetWidth >= 498) && pos1 < 0) element.style.left = (element.offsetLeft - pos1) + "px"
                if(ppCorpImg.offsetLeft + ppCorpImg.offsetWidth > 498 && ppCorpImg.offsetLeft > 0) element.style.left = "0px"
                // вниз, pos2 -
                if(ppCorpImg.offsetTop + ppCorpImg.offsetHeight >= 498 && ppCorpImg.offsetTop <= 0 && pos2 < 0) element.style.top = (element.offsetTop - pos2) + "px"
                if(ppCorpImg.offsetTop > 0 && ppCorpImg.offsetTop + ppCorpImg.offsetHeight > 498 && pos2 < 0) element.style.top = "0px"
                // вверх, pos2 +
                if(ppCorpImg.offsetTop + ppCorpImg.offsetHeight >= 498 && ppCorpImg.offsetTop <= 0 && pos2 > 0) element.style.top = (element.offsetTop - pos2) + "px"
                if(ppCorpImg.offsetTop < 0 && ppCorpImg.offsetTop + ppCorpImg.offsetHeight < 498 && pos2 > 0) element.style.top = (498 - element.offsetHeight) + "px"
            }
        }

        function closeDragElement() {
            element.style.cursor = 'default'
            document.body.style.cursor = 'default';
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }

    function clearFileInput(ctrl) {
        try {
            ctrl.value = null;
        } catch(ex) { }
        if (ctrl.value) {
            ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
        }
    }
}
profile();

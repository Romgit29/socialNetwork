<div class="confirmationModalWrap" id='deleteModalWrap'>
    <div class='confirmationModal' id='deleteModal' style='display: flex;'>
        <div style='display: flex; flex-direction: column; justify-content: space-evenly; height: 100%;'>
            <div id='deleteModalText' style="font-size: 17px;"></div>
            <div style='display: flex; width:100%; justify-content: space-around;'>
                <button id='deleteModalApplyButton' type='submit' class="btn btn-primary btn-sm" style='width:80px;'>Yes</button>
                <button id='deleteModalCancelButton' class="btn btn-danger btn-sm" style='width:80px;' onclick='hideDeletionModal()'>No</button>
                <script type="text/javascript" defer>
                    function hideDeletionModal() {
                        document.getElementById('deleteModalWrap').style.display = 'none';
                    };
                </script>
            </div>
        </div>
    </div>
</div>
<div id="repostModalWrap" class='confirmationModalWrap' style='display: none;'>
    <div class='confirmationModal' id='repostModal' style='display: flex;'>
        <div style='display: flex; flex-direction: column; height: 100%;'>
            <div>Your message</div>
            <textarea form='repostModalForm' id='repostModalRepostText' name='text' style='width: 420px; height: 80px; margin-top: 12px; resize: none;'></textarea>
            <div style='display: flex; width:100%; justify-content: space-around; margin-top: 15px;'>
                <form method='POST' id='repostModalForm' name='repostModalForm' domain="{{env('APP_URL')}}">
                    @method('post')
                    @csrf
                    <input type='hidden' id="repostModalFormType" name='repostableType'>
                    <button type='submit' id='repostModalApplyButton' class="btn btn-primary btn-sm" style='width:80px;'>Repost</button>
                </form>
                <button id='repostModalCancelButton' class="btn btn-danger btn-sm" style='width:80px;' onclick='hideRepostModal()'>Discard</button>
                <script type="text/javascript" defer>
                    function hideRepostModal() {
                        document.getElementById('repostModalWrap').style.display = 'none';
                        document.getElementById('repostModalRepostText').value = '';
                    };
                </script>
            </div>
        </div>
    </div>
</div>
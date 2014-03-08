</div>
</div>
<a class="fancybox" href="#popup" id="popup-trigger"></a>
<div style="display: none">
    <div id="popup"></div>
</div>
<div id="dialog-confirm" class="hide" title="Are you sure?">
    The item will be permanently removed from database.
</div>
<input type="hidden" id="dialog_confirm_url" value="">
<div id="validation-block"
     style="position: absolute; visibility: hidden; opacity: 1; top: 0; left: 0">
    <table cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
            <td class="tl"></td>
            <td class="t"></td>
            <td class="tr"></td>
        </tr>
        <tr>
            <td class="l"></td>
            <td class="c">
                <div class="err pull-left"></div>
                <a class="close-btn" onclick="validation.closeErrorInfo()"></a></td>
            <td class="r"></td>
        </tr>
        <tr>
            <td class="bl"></td>
            <td class="b"></td>
            <td class="br"></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    fancyBox.bind();
    $("#dialog-confirm").dialog({
        autoOpen:false,
        resizable:false,
        height:140,
        modal:true,
        buttons:{
            "Delete":function () {
                $(this).dialog("close");
                $.fancybox.showActivity();
                $.ajax({
                    type: 'GET',
                    datatype:'JSON',
                    url: $('#dialog_confirm_url').val(),
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        validation.showMessage(data, true);
                        //tabs.reload();
                    },
                    complete: function(jxhr, status) {
                        $.fancybox.hideActivity();
                    }
                });
            },
            Cancel:function () {
                $(this).dialog("close");
            }
        }
    });
    function deleteConfirmation(e){
        console.log(e);
        var url = $(e).parents('a').attr('href');
        url = url.slice(1);
        $('#dialog_confirm_url').val(url);
        $("#dialog-confirm").dialog('open');
    }
</script>
</body>
</html>
<?php
if (!isset($menu) || !is_array($menu)) {
    $menu = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Shringar</title>

    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap-responsive.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/ui-lightness/jquery-ui-1.8.19.custom.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/fancybox/jquery.fancybox-1.3.4.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/jstree/themes/default/style.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/style.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/print.css'); ?>" media="print"/>
    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.7.2.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?php echo base_url('resources/js/jquery-ui-1.8.19.custom.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.fancybox-1.3.4.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.cookie.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-barcode-2.0.2.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.jstree.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-ui-timepicker-addon.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/config.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/application.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/shortcut.js'); ?>"></script>
</head>
<body>
<div class="notification-block"></div>
<div id="confirmation-dialog" class="hide">
</div>
<div class="container-fluid">
    <!-- @Header -->
    <div class="header-wrapper">
        <span class="pull-left logo">
            Shringar
        </span>
        <span class="pull-right" style="width: 68em">
            <ul class="menu hide">
                <li><a href="<?php echo site_url('invoice'); ?>">Billing</a></li>
                <li><a href="<?php echo site_url('purchases'); ?>">Purchases</a></li>
                <li><a href="<?php echo site_url('inventory'); ?>">Inventory</a></li>
                <li><a href="<?php echo site_url('rent'); ?>">RENT</a></li>
                <li class="search_purch">
                    <input type="text" name="search" value="" class="search_input"/>
                    <input type="image" src="<?php echo base_url('resources/img/search-invoice.png'); ?>"
                           class="search_btn"/>
                </li>
                <li class="menu_logout"><a href="<?php echo site_url("login/user_logout"); ?>">Logout</a></li>
            </ul>
            <ul class="menu">
                <?php
                $subMenu = array();
                //$flag = 0;
                foreach ($menu as $v) {
                    /*if($flag === 0) {
                        $subMenu = $v['children'];
                    }*/
                    $flag = 1;
                    $class_css = $v['selected'] == 1 ? 'menu-selected' : '';
                    if ($v['selected'] == 1) {
                        $subMenu = !isset($v['children']) || !is_array($v['children']) ? array() : $v['children'];
                    }
                    echo '<li><a href="' . site_url($v['url']) . '" class="' . $class_css . '">' . $v['title'] . '</a></li>';
                }
                ?>
                <li class="search_purch">
                    <input type="text" name="search" value="" class="search_input"/>
                    <input type="image" src="<?php echo base_url('resources/img/search-invoice.png'); ?>"
                           class="search_btn"/>
                </li>
                <li class="menu_logout"><a href="<?php echo site_url("login/user_logout"); ?>">Logout</a></li>
            </ul>
        </span>
    </div>
    <!-- @Content -->
    <div class="content">
        <div class="content-wrapper ui-tabs">
            <ul class="ui-tabs-nav content-tabs">
                <?php
                foreach ($subMenu as $v) {
                    $class_css = $v['selected'] == 1 ? 'ui-tabs-selected' : '';
                    if ($v['selected'] == 1) {
                        $contentMenu = !isset($v['children']) || !is_array($v['children']) ? array() : $v['children'];
                    }
                    echo '<li class="ui-state-default '. $class_css . '"><a href="' . site_url($v['url']) . '" ><span class="span_img ' . $v['class_css'] . '"></span>' . $v['title'] . '</a></li>';
                }
                ?>
            </ul>
            <div class="content-main ui-tabs-panel">
                <?php echo $output; ?>
            </div>
        </div>
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
                    type:'GET',
                    datatype:'JSON',
                    url:$('#dialog_confirm_url').val(),
                    success:function (data) {
                        data = jQuery.parseJSON(data);
                        validation.showMessage(data, true);
                        //tabs.reload();
                    },
                    complete:function (jxhr, status) {
                        $.fancybox.hideActivity();
                    }
                });
            },
            Cancel:function () {
                $(this).dialog("close");
            }
        }
    });
    function deleteConfirmation(e) {
        console.log(e);
        var url = $(e).parents('a').attr('href');
        url = url.slice(1);
        $('#dialog_confirm_url').val(url);
        $("#dialog-confirm").dialog('open');
    }
</script>
</body>
</html>
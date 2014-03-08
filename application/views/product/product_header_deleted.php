<?php
$status = isset($status) ? $status : 0;
$message = isset($msg) ? $msg : '';
?>
<script type="text/javascript">

    <?php
        echo "setTimeout('$.fancybox.close();";
    if($status == 1) {
        echo 'notification.push( { message: "'.$message.'", alertType: "success"} );';
        echo 'tabs.reload();';
    } else {
        echo 'notification.push( { message: '.$message.', alertType: "error", messageType: "sticky"} );';
    }
    echo "', 500)";
    ?>
</script>
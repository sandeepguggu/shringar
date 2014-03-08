<?php
$print_state = isset($print) ? $print : 0;

$id = isset($output['id']) ? $output['id'] : '';
$name = isset($output['name']) ? $output['name'] : '';
?>
<div class="content-header">
    <h3><?php echo $name; ?></h3>
    <span class="pull-right">&nbsp;&nbsp;</span>
    <a href="#<?php echo site_url('classification/delete_class?ajax=1&id='.$id); ?>" class="btn btn-danger action-btn pull-right" >
        <i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>
    </a>
    <span class="pull-right">&nbsp;&nbsp;</span>
    <a href="<?php echo site_url('classification/edit_class?ajax=1&id='.$id); ?>" class="btn btn-primary action-btn fancybox pull-right">
        <i class="icon-pencil icon-white"></i>
    </a>
</div>

<div class="content-subject">
    <table class="table table-bordered table-description">
        <tr>
            <th>Attribute</th>
            <th>Level</th>
        </tr>
        <?php
        if (!isset($output['attributes']) || !is_array($output['attributes']) || count($output['attributes']) < 1) {
            log_message('error', '#62, product_header.php error');
            $output['attributes'] = array();
        }
        log_message('error', print_r($output['attributes'], 1));
        foreach ($output['attributes'] as $attribute) {
            $attribute_name = ucfirst($attribute['name']);
            $attribute_level = ucfirst($attribute['level']);
            echo '<tr>';
            echo '<td>' . $attribute_name . ':</td>';
            echo '<td>' . $attribute_level . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>
    <script type="text/javascript">
        fancyBox.bind();
    </script>
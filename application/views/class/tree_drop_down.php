<option value="0">ROOT</option>
<?php
$class_id = isset($class_id) ? $class_id : 0;
function buildTree($branch, $pad, $class_id = 0)
{
    if($class_id == $branch['id']) {
        $html = '<option  value="' . $branch['id'] . '" style="padding-left: ' . $pad . 'px" selected>' . $branch['name'] . '</option> ';
    } else {
        $html = '<option value="' . $branch['id'] . '" style="padding-left: ' . $pad . 'px">' . $branch['name'] . '</option>';
    }

    if (isset($branch['sub']) && is_array($branch['sub']) && count($branch['sub']) > 0) {
        foreach ($branch['sub'] as $b) {
            $html .= buildTree($b, $pad + 10, $class_id);
        }
    }
    return $html;
}

foreach ($tree as $branch) {
    echo buildTree($branch, 5, $class_id);
}
?>
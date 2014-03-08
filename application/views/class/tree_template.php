<?php
$display_root = isset($display_root) ? $display_root : 0;
?>
<?php if ($display_root == 0) : ?>
<ul>
    <li id="0">
        <a href="#">Categories</a>
    <?php endif; ?>
    <ul>
        <?php
        function buildTree($branch)
        {
            $stock = isset($branch['stock']) ? $branch['stock'] : null;
            $html = '<li id="' . $branch['id'] . '">';
            $html .= '<a href="'.site_url('inventory/stock/'.$branch['id']).'">' . $branch['name'] . '</a>';
            if(! is_null($stock)) {
                $html .= '<a id="stock_count" class="no-image" href="#2"> (' . $stock . ')</a>';
            }
            if (isset($branch['sub']) && is_array($branch['sub']) && count($branch['sub']) > 0) {
                $html .= '<ul>';
                foreach ($branch['sub'] as $b) {
                    $html .= buildTree($b);
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
            return $html;
        }
        foreach ($tree as $branch) {
            echo buildTree($branch);
        }
        ?>
    </ul>
<?php if ($display_root != 0) : ?>
    </li>
</ul>
<?php endif; ?>
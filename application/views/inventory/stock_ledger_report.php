<div style="overflow: auto; width:100%;">
    <table class="table table-bordered">
        <tr>
            <th>INV-NO</th>
            <th>DATE</th>
            <th>PARTY</th>
            <th>ITEM NAME</th>
            <th>QTY</th>
            <th>RATE</th>
            <?php foreach ($tax as $t) { ?>
            <th>SALES <?php echo $t['vat_percentage']?>%</th>
            <th>VAT <?php echo $t['vat_percentage'] ?>%</th>
            <?php } ?>
            <th>INVOICE VALUE</th>
        </tr>

        <?php
        foreach ($report as $rep) {
        $items = $rep['items'];
        foreach ($items as $item) {
            ?>
            <tr>
                <td><?php echo $rep['id']?></td>
                <td><?php echo substr($rep['created_at'], 0, 10)?></td>
                <td><?php echo $rep['fname'] . ' ' . $rep['lname']?></td>
                <td><?php echo $item['name'] ?></td>
                <td><?php echo $item['quantity'] ?></td>
                <td><?php echo $item['price']?></td>
                <?php
                foreach ($tax as $ta) { ?>
                <td><?php if ($ta['vat_percentage'] == $item['vat_percent']) {
                    echo $item['final_amount'];
                } else {
                    echo "";
                }?></td>
                <td><?php if ($ta['vat_percentage'] == $item['vat_percent']) {
                    echo $item['vat'];
                } else {
                    echo "";
                }?></td>
                <?php }?>
                <td><?php echo $rep['final_amount']?></td>
            </tr>
            <?php } ?>
        <?php }?>
    </table>
</div>
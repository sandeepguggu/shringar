<br/>
<br/><table class="table table-striped table-bordered" style="width: 25%;">
    <tr>
        <th>Total Rent Amount</th>
        <td><?php echo $report[0]['rent'];?></td>
    </tr>
    <tr>
        <th>Total Negotiated Amount</th>
        <td><?php echo $report[0]['negotiatedAmt'];?></td>
    </tr>
</table>
<br/>
<br/><table class="table table-striped table-bordered" style="width: 25%;">
    <tr>
        <th>Component</th>
        <th>Quantity</th>
    </tr>
    <?php
    foreach ($report[1] as $item) {
    ?>
    <tr>
        <td><?echo $item['name'];?></td>
        <td><?php echo $item['cnt'];?></td>
    </tr>
    <?php
    }
    ?>
</table>
<?php if (!empty($report)) { ?>
<table class="bordered-table zebra-striped" width="100%">
    <tr>
        <th>SNo.</th>
        <th>Name</th>
        <th>Type</th>
        <th>Installment</th>
        <th>Amount</th>
        <th>Cash</th>
        <th>Card</th>
        <th>Paid on</th>
        <th>Due on</th>
        <th>Accumulated</th>
    </tr>
    <?php
    $cnt = 1;
    foreach ($report as $rep) {
        ?>
        <tr>
            <td><?php echo $cnt; ?></td>
            <td><?php echo $rep['fname'] . " " . $rep['lname']?></td>
            <td><?php echo $rep['scheme_name']?></td>
            <td><?php echo $rep['installments_paid'] ?></td>
            <td><?php echo $rep['amount'] ?> </td>
            <td><?php echo $rep['by_cash'] ?></td>
            <td><?php echo $rep['by_card'] ?></td>
            <td><?php echo $rep['last_paid_date'] ?></td>
            <td><?php echo $rep['next_payment_date'] ?></td>
            <td><?php echo $rep['accumulated_amount'] ?></td>
        </tr>
        <?php $cnt++;
    } ?>
</table>
<?php } else {
    echo "No Records Found";
}
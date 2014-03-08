

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($bookings)){?>

    <table class="table table-striped table-bordered">
        <th>Booking Id</th>
        <th>Customer Name</th>
        <th>Delivery Date</th>
        <th>Rent Amount</th>
        <th>Deposit</th>
        <th>View</th>
<?php
    foreach($bookings as $item){
?>
    <tr>
        <td><?php echo $item['id'];?></td>
        <td><?php echo $item['fname']." ".$item['lname'];?></td>
        <td><?php echo $item['delivery_date'];?></td>
        <td><?php echo $item['total_rent'];?></td>
        <td><?php echo $item['deposit'];?></td>        
        <td><a href="viewBill?id=<?php echo $item['id'];?>&ordertype=<?php echo $ordertype;?>" class="fancybox">View</a></td>
    </tr>
<?php
    }
}
?>

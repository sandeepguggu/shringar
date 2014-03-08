
 
<div class="content-subject">    
    <div class="pull-left span5">
        <table class="table table-bordered table-description">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>TOTAL AMOUNT</th>
                <th>BRAND</th>
                <th>CLASS</th>                
            </tr>
            <?php foreach ($output as $i=>$record) : ?>
            <tr>
                <?php
                $max_qty = $record['quantity'] - $record['returned_qty'];    
                if($max_qty > 0) {  
                ?>          
                <td><?php echo $record['id']; ?></td>
                <td><?php echo $record['name']; ?></td>
                <td><?php echo $record['amount']; ?></td>
                <td><?php echo $record['class']; ?></td>
                <td><?php echo $record['brand']; ?></td>
                <?php } ?>
            </tr>
            <?php endforeach; ?>        
        </table;    </div>
</div>
<div class="content-subject">    
    <div class="">
        <span style="display:block; margin-bottom:20px;">Last 20 Bills:</span>
        <table class="table table-bordered table-description">
            <tr>
                <th>ID</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>CUSTOMER NAME</th>
                <th>PHONE</th>                
                <th>ACTION</th>
            </tr>

            <?php foreach ($data as $i=>$record) : ?>
            <tr>
                <td><?php echo $record['id']; ?></td>
                <td><?php echo $record['final_amount']; ?></td>
                <td><?php echo $record['status']; ?></td>
                <td><?php echo $record['c_name']; ?></td>
                <td><?php echo $record['c_phone']; ?></td>
                <td><a href="<?php echo site_url('/invoice/print_invoice/' . $record['id']); ?>" class="btn btn-success action-btn">
                        <i class=" icon-info-sign icon-white"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>        
        </table>
    </div>
</div>
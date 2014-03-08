
 
<div class="content-subject">    
    <div class="pull-left span5">
        <?php count($output); ?>
       <table class="table table-striped" width="100%">
        <tr>
            <th>BILL NO / REF NO</th>
            <th>NAME</th>
            <th>TOTAL SALES</th>
            <th>BRAND</th>       
            <th>CLASS</th>
            <?php foreach($vat_percentages as $vat) :?>
                  <th>GROSS SALES @ <?php echo $vat?></th>
                  <th>VAT @ <?php echo $vat?></th>
            <?php endforeach; ?>            
        </tr>
        <?php foreach($output as $key => $record): ?>
            <tr>
            <?php foreach($record as $value): ?>
                <td><?php echo $value; ?></td>
            <?php endforeach; ?>                
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>
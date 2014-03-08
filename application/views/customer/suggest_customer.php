<table class="my-table" style="width: 99%">
    <tr>
        <td class="meta-head">Name:</td>
        <td><?php echo $fname . ' ' . $lname; ?></td>
        <td class="meta-head">Mobile:</td>
        <td><?php echo $phone; ?></td>
    </tr>
    <tr>
        <td class="meta-head">Address:</td>
        <td colspan="3"><?php echo $building.', '.$street .', '.$area; ?></td>
    </tr>
</table>
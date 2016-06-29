<div class="row">
    <div class="col-lg-12" >
        <a href="<?php echo site_url('User/addBonus'); ?>" class="btn btn-primary pull-right">Add</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Brand Name</th>
                    <th>Bonus Ratio</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (isset($response) && !empty($response)) {
                    foreach ($response as $row) :
                        ?><tr>  
                            
                            
                            <td data-title="Sr"><?php echo $count++; ?></td>
                            <td data-title="State"><?php echo $row['product_name']; ?></td>
                            <td data-title="Region"><?php echo $row['bonus_ratio']; ?></td>
                            <td data-title="Doctor Name"><?php echo $row['start_date']; ?></td>  
                            <td data-title="MSL Code"><?php echo $row['end_date']; ?> </td> 
                              <td> <a class="fa fa-pencil btn-success btn-xs" onclick="window.location = '<?php echo site_url('User/editBonus?id='.$row['bonus_id']); ?>';"></a>
                         
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
        if (isset($total_pages)) {
            for ($i = 1; $i <= $total_pages; $i++) {
                if (isset($page) && $page == $i) {
                    echo '<a href="' . site_url('User/Bonus/' . $i) . '" name="page" class="btn btn-sm btn-primary" >' . $i . '</a>';
                } else {
                    echo '<a href="' . site_url('User/Bonus/' . $i) . '" name="page" class="btn btn-sm " >' . $i . '</a>';
                }
            }
        }
        ?>
    </div>
</div>
<script>
    function deletedoc(url) {
        var r = confirm("Are you sure you want to delete");
        if (r == true)
        {
            window.location = url;

        }
        else
        {
            return false;
        }
    }

</script>
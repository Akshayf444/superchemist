<div class="row">
    <div class="col-lg-12" >
        <a href="<?php echo site_url('User/addBrand'); ?>" class="btn btn-primary pull-right">Add</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Brand Name</th>
                    <th>Form</th>
                    <th>MRP</th>
                    <th>Packing</th>
                    <th>Strength</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (isset($response) && !empty($response)) {
                    foreach ($response as $row) :
                        ?><tr>  
                            <td data-title="Sr"><?php echo $count++; ?></td>
                            <td data-title="State"><?php echo $row['name']; ?></td>
                            <td data-title="Region"><?php echo $row['form']; ?></td>
                            <td data-title="Doctor Name"><?php echo $row['mrp']; ?></td>  
                            <td data-title="MSL Code"><?php echo $row['packing']; ?> </td> 
                            <td data-title="Address"><?php echo $row['strength']; ?></td>  
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
                    echo '<a href="' . site_url('User/brandList/' . $i) . '" name="page" class="btn btn-sm btn-primary" >' . $i . '</a>';
                } else {
                    echo '<a href="' . site_url('User/brandList/' . $i) . '" name="page" class="btn btn-sm " >' . $i . '</a>';
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
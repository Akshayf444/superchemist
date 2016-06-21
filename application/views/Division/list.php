<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo site_url('User/addDivision'); ?>" class="btn btn-primary">Add</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Division Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (!empty($response)) {
                    foreach ($response as $row) :
                        ?><tr>  
                            <td data-title="Sr"><?php echo $count++; ?></td>
                            <td data-title="State"><?php echo $row->name; ?></td>
                            <td data-title="Region"><?php echo $row->contact_person; ?></td>
                            <td data-title="Doctor Name"><?php echo $row->email; ?></td>  
                            <td data-title="MSL Code"><?php echo $row->company_name; ?> </td> 
                            <td data-title="Address"></td>  
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
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
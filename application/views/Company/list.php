<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo site_url('User/addCompany'); ?>" class="btn btn-primary pull-right">Add</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Company</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Pincode</th>
                    <th>Contact Person</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Password</th>
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
                            <td data-title="Company Name"><?php echo $row->company_name; ?></td>
                            <td data-title="Address"><?php echo $row->address; ?> </td> 
                            <td data-title="City"><?php echo $row->city; ?> </td> 
                            <td data-title="Pincode"><?php echo $row->pin_code; ?> </td> 
                            <td data-title="Contact Person"><?php echo $row->contact_person_name; ?></td>
                            <td data-title="Mobile"><?php echo $row->mobile; ?> </td>
                            <td data-title="Email"><?php echo $row->email; ?></td> 
                            <td data-title="Password"><?php echo $row->password; ?> </td>


                            <td data-title="Action">
                                <a class="fa fa-trash btn-danger btn-xs" onclick=" deletedoc('<?php echo site_url('User/delete_company?id=') . $row->company_id; ?>');"></a> 
                                <a class="fa fa-pencil btn-success btn-xs" onclick="window.location = '<?php echo site_url('User/editCompany/' . $row->company_id); ?>';"></a>
                            </td>
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
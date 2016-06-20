<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Address</th>

                    <?php if ($this->session->userdata('Designation') == 'TM') { ?>
                        <th>Action</th> <?php } ?>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (!empty($institute)) {
                    foreach ($institute as $row) :
                        ?><tr>  
                            <td data-title="Sr"><?php echo $count++; ?></td>
                            <td data-title="Name"><?php echo $row->name; ?></td>
                            <td data-title="City"><?php echo $row->city; ?></td>
                            <td data-title="State"><?php echo $row->state; ?></td>  
                            <td data-title="Address"><?php echo $row->address; ?> </td> 

                            <td>  
                                <?php if ($this->session->userdata('Designation') == 'TM') { ?>
<<<<<<< HEAD
                                    <a class="fa fa-trash-o btn-danger btn-xs" class=""  onclick="deletedoc('<?php //echo site_url('User/youngdoc_del?id=') . $row->DoctorId;  ?>')"></a> 
=======
                                    <a class="fa fa-trash-o btn-danger btn-xs" class=""  onclick="deletedoc('<?php echo site_url('User/deleteinstitute/' . $row->inst_id); ?>')"></a> 
>>>>>>> 222de80eb3e312f76db8cd720466b67b52acb116
                                    <a class="fa fa-pencil btn-success btn-xs" onclick="window.location = '<?php echo site_url('User/editinstitute/' . $row->inst_id); ?>';"></a>                               
                                <?php } ?>
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
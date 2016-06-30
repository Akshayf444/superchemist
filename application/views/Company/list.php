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
                                <button type="button"  data-toggle="modal" data-target="#myModal" data-id="<?php echo $row->company_id; ?>" class="btn-success btn-xs dialog"><i class="fa fa-upload "></i></button>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Image Upload</h4>
            </div> 
            <?php
            $attribute = array('enctype' => 'multipart/form-data', 'name' => 'form1', 'id' => 'form1');
            echo form_open('User/UploadImage', $attribute);
            ?>
            <div class="modal-body">
                <h5 style="color: red">Image Size Should Be less than 90 KB</h5>

                <div class="form_group">
                    Choose your file: <br /> 
                    <input name="file" type="file" id="file" class="form-control" />
                    <input type="hidden" name="company_id" id="company_id" value="0">
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="save"  name="submit" class="btn btn-primary">Save</button>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".dialog", function () {
        var myBookId = $(this).data('id');
        //alert(myBookId);
        $(".modal-body #company_id").val(myBookId);
    });

    var _URL = window.URL || window.webkitURL;

    $("#file").change(function (e) {
        var file, img;

        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {

            };
            img.onerror = function () {
                alert("not a valid file: " + file.type);
            };
            img.src = _URL.createObjectURL(file);


        }

    });
</script>
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
<div class="row">
    <div class="col-lg-12">
        <input type="button"   class="btn btn-primary pull-right " value="Image Upload" data-toggle="modal" data-target="#myModal1">
    </div>
</div>
<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Image</th>

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
                            <td data-title="Image"><img src="<?php echo base_url() . $row->image_path; ?>" height="50px" width="50px"></td>
                            <td data-title="Action">
                                <a class="btn btn-danger "  onclick="window.location = '<?php // echo site_url('User/inactive_image/' . $row->image_id); ?>';" >Inactive</a> 
                                <a class=" btn  btn-success " onclick="window.location = '<?php // echo site_url('User/active_image/' . $row->image_id); ?>';">Active</a>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Image Upload</h4>
            </div> 
            <?php
            $attribute = array('enctype' => 'multipart/form-data', 'name' => 'form1', 'id' => 'form1');
            echo form_open('User/image_add', $attribute);
            ?>
            <div class="modal-body">
                <input type="hidden" name="hide" id="csv1" class="form-control" />

                <div class="form_group">
                    Choose your file: <br /> 
                    <input name="file" type="file" id="csv" class="form-control" />


                </div>



                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit"  name="submit" class="btn btn-primary">Save</button>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#date").datepicker();
    $("#date1").datepicker();
</script>
<div class="row">
    <div class="col-lg-12">
        <input type="button"   class="btn btn-primary pull-right " value="Image Upload" data-toggle="modal" data-target="#myModal1">
    </div>
</div> <br>
<div class="row">
    <?php
    if (!empty($response)) {
        foreach ($response as $row) :
            ?>
            <div class="col-xs-8 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img src="<?php echo base_url(). $row->image_path; ?>" height="260px" width="250px">
                    <div class="caption">

                        <p>   <?php if ($row->status == 1) { ?>
                                Active

                            <?php } else { ?>
                                InActive
                            <?php } ?></p>
                        <p>  <?php if ($row->status == 1) { ?>
                            <?php } else { ?>
                                <a class=" btn  btn-success " onclick="window.location = '<?php echo site_url('User/active_image?id=' . $row->image_id); ?>';">Active</a>
                            <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
    }
    ?></p>

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
                <h5 style="color: red">Image Size Should Be less than 90 KB</h5>

                <div class="form_group">
                    Choose your file: <br /> 
                    <input name="file" type="file" id="file" class="form-control" />
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
    $("#date").datepicker();
    $("#date1").datepicker();

    var _URL = window.URL || window.webkitURL;

    $("#file").change(function (e) {
        var file, img;

        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                if (this.width != 485 || this.height != 512) {
                    alert("Image Dimension Should Be 480 X 512");
                    $("#save").attr('type', 'button');
                } else {
                    $("#save").attr('type', 'submit');
                }

            };
            img.onerror = function () {
                alert("not a valid file: " + file.type);
            };
            img.src = _URL.createObjectURL(file);

        }

    });
</script>
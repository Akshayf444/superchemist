<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo site_url('User/addCompany'); ?>" class="btn btn-primary pull-right">Add</a>
    </div>
</div><br/>
<style>
    .image-box{
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <?php
    if (!empty($response)) {
        foreach ($response as $row) :
            ?>
            <div class="col-xs-8 col-sm-6 col-md-3 image-box" style="height: 150px;">
                <div class="col-xs-12" align="center" style="height: 110px;border: 1px solid #cccccc;padding-top: 5px" >
                    <?php
                    if ($row->logo == null || $row->logo == '') {
                        echo '<h2 style="padding-top : 15px">' . $row->company_name . '</h2>';
                    } else {
                        ?>
                        <img height="100" width="140px" src="<?php echo 'http://instacom.in/superchem/images/' . $row->logo; ?>"  >
                    <?php } ?>

                </div>
                <div class="col-xs-12" style="border-top: 1px solid #cccccc;background:#cccccc ;height: 40px;padding-top: 4px">
                    <p>
                        <button type="button"  data-toggle="modal" data-target="#myModal" data-id="<?php echo $row->company_id; ?>" class="btn-success btn-xs dialog"><i class="fa fa-upload "></i></button>
                        <a class="fa fa-pencil btn-success btn-xs" onclick="window.location = '<?php echo site_url('User/editCompany/' . $row->company_id); ?>';"></a>
                        <span class="badge label-danger pull-right"><?php
                            $condition[] = "cm.company_id = '" . $row->company_id . "'";
                            $count = $this->Bonus->countBonus2(array(), $condition);
                            echo $count->bonusCount;
                            unset($condition);
                            ?> &nbsp Offers
                        </span>
                    </p>
                </div>

            </div>
            <?php
        endforeach;
    }
    ?>


<!--                                <a class="fa fa-trash btn-danger btn-xs" onclick=" deletedoc('<?php // echo site_url('User/delete_company?id=') . $row->company_id;                 ?>');"></a> 
                         
                         
    -->

</div>  
<div class="row">
    <div class="col-lg-12">
        <?php
        if (isset($total_pages)) {
            for ($i = 1; $i <= $total_pages; $i++) {
                if (isset($page) && $page == $i) {
                    echo '<a href="' . site_url('User/CompanyList/' . $i) . '" name="page" class="btn btn-sm btn-primary" >' . $i . '</a>';
                } else {
                    echo '<a href="' . site_url('User/CompanyList/' . $i) . '" name="page" class="btn btn-sm " >' . $i . '</a>';
                }
            }
        }
        ?>
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
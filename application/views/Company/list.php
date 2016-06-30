<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo site_url('User/addCompany'); ?>" class="btn btn-primary pull-right">Add</a>
    </div>
</div>

                      <div class="row">
                         
    <?php
    if (!empty($response)) {
        foreach ($response as $row) :
            ?>
                           <?php // $filename= asset_url(). 'images/' . $row->logo; ?>
            <div class="col-xs-8 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <?php if($row->logo==null || $row->logo==''){
                        echo $row->company_name;
                    }
                    else{ ?>
                     
                    <img src="<?php echo base_url(). 'images/' . $row->logo; ?>" height="260px" width="250px">
                    <?php } ?>
                    <div class="caption" style="border-top: 1px solid ">
                        
                        <p> <?php 
                         $condition[] = "company_id = '" . $row->company_id . "'";
                        $count=$this->Bonus->countBonus2($condition);
                       echo $count->bonusCount?> &nbsp Offer
                       </p>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
    }
    
    ?>

       
<!--                                <a class="fa fa-trash btn-danger btn-xs" onclick=" deletedoc('<?php // echo site_url('User/delete_company?id=') . $row->company_id; ?>');"></a> 
                                <a class="fa fa-pencil btn-success btn-xs" onclick="window.location = '<?php // echo site_url('User/editCompany/' . $row->company_id); ?>';"></a>
                                <button type="button"  data-toggle="modal" data-target="#myModal" data-id="<?php // echo $row->company_id; ?>" class="btn-success btn-xs dialog"><i class="fa fa-upload "></i></button>
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
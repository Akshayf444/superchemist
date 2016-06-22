<style>
    .content-wrapper{
        min-height: 775px;
    }    
</style>
<?php
$attribute = array('id' => 'valid');
echo form_open('User/addBrand', $attribute);
?> 
<?php for($i=1;$i<=10;$i++){ ?>
<div class="row" >
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            Brand Name
            <input type="text" class="form-control" value="" name="name[]" placeholder="Brand Name" />
        </div>
        </div>
         <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            Form
            <select class="form-control" name="form[]">
                <option>Select Form</option>
                <?php echo $form; ?>
            </select> 
        </div>
         </div>
              <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            MRP
            <input type="text" class="form-control" value="" name="mrp[]" placeholder="MRP "/> </div></div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            Packing
            <input type="text" class="form-control" value="" name="packing[]" placeholder="Packing"/> </div>
            </div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            Company
            <select name="company[]" class="chosen-select">
                <option>Select Company</option>
                <?php echo $company; ?>
            </select>
        </div>	    </div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <div class="form-group">
            Strength
            <input type="text"  class="form-control" name="strength[]" required="" placeholder="Strength" >
        </div>
             </div>
<?php

}
?>
        <button class="btn btn-block btn-success " type="submit">SAVE</button>
    </div>
</div>
</form>


<script src="<?php echo asset_url() ?>js/formValidation.min.js" type="text/javascript"></script>
<script src="<?php echo asset_url() ?>js/bootstrap.min.js" type="text/javascript"></script>

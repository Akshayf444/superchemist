<style>
    .content-wrapper{
        min-height: 775px;
    }    
</style>
<?php
$attribute = array('id' => 'valid');
echo form_open('User/editinstitute/' . $institute->inst_id, $attribute);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Institute Name
            <input type="text" class="form-control" value="<?php echo $institute->name; ?>" name="name" placeholder="Institute Name" />
        </div>
        <div class="form-group">
            City
            <input type="text" class="form-control" value="<?php echo $institute->city; ?>" name="city" placeholder="City" /><input type="hidden" name="inst_id" value="<?php echo $institute->inst_id; ?>"> </div>

        <div class="form-group">
            State
            <select  class="form-control" name="state" >
                <option value="">Select State</option>
                <?php echo $state; ?>
            </select> 
        </div>
        <div class="form-group">
            Address
            <textarea class="form-control" name="address" placeholder="Address"><?php echo $institute->address; ?></textarea></div>

        <button class="btn btn-block btn-success " type="submit">UPDATE</button>
    </div>
</div>
</form>
<script>
    $(function () {
        $("#date1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $("#date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });</script>

<script src="<?php echo asset_url() ?>js/formValidation.min.js" type="text/javascript"></script>
<script src="<?php echo asset_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
<script>
    $('document').ready(function () {
        $('#valid').formValidation({
            icon: {
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The Institute  is required'
                        }
                    }
                }

            }

        });
    });
</script>


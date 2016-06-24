<link href="<?php echo asset_url(); ?>css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo asset_url(); ?>js/bootstrap-multiselect.js" type="text/javascript"></script>
<?php
$attribute = array('id' => 'valid');
echo form_open('User/addBonus', $attribute);
?>
<div class="row" >
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">        
        <div class="row">
            <?php if ($this->type == 2) { ?>
                <input type="hidden" name="company_id" value="<?php echo $this->company_id; ?>">
            <?php } else { ?>
                <div class="col-lg-4">
                    <label>Company</label>
                    <select name="company_id" <?php echo $disable; ?> class="chosen-select"> 
                        <option value="">Select Company</option>
                        <?php echo $company; ?>
                    </select>
                </div>
            <?php } ?>
        </div><br/>
        <table class="table table-bordered">
            <tr>
                <th>Brand Name</th>
                <th>Ratio</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Shown State</th>
            </tr>
            <?php for ($i = 0; $i < 5; $i++) { ?>
                <tr>
                    <td><input type="text" class="form-control brandname" value="" name="brand_name[]" placeholder=" Brand Name "/></td>
                    <td><input type="text" class="form-control" value="" name="bonus_ratio[]" placeholder=" Bonus Ratio "/><input type="hidden" class="rate" value="" name="brand_id[]"></td>
                    <td><input type="text" autocomplete="off" class="form-control datepicker" value="" name="start_date[]" placeholder=" Start Date "/></td>
                    <td><input type="text" autocomplete="off"  class="form-control datepicker" value="<?php echo '31-03-' . (date('Y') + 1) ?>" name="end_date[]" placeholder=" End Date "/></td>
                    <td><select name="state<?php echo $i; ?>[]" multiple class="form-control multiselect"><?php echo $state; ?></select></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <button class="btn btn-block btn-success " type="submit">SAVE</button>
    </div>
</div>
</form>
<script>
    $("document").ready(function () {
        $('.multiselect').multiselect({
            numberDisplayed: 1,
            enableFiltering: true,
            includeSelectAllOption: true
        });

        $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
    });

    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _renderMenu: function (ul, items) {
            var self = this,
                    currentCategory = "";
            $.each(items, function (index, item) {
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                self._renderItemData(ul, item);
            });
        }
    });

    $(document).on("keydown.autocomplete", '.brandname', function () {
        //var medicine = $(this).val();
        var $this = $(this);
        var company_id = <?php echo $this->type == 2 ? $this->company_id : ''; ?>;
        $this.addClass('loading');
        $(".brandname").catcomplete({
            delay: 1000,
            minLength: 3,
            //source: data,
            source: function (request, response) {
                var medicine = $this.val();
                $.ajax({
                    url: "<?php echo site_url('Api/getBonusBrandList'); ?>",
                    type: 'GET',
                    data: {
                        company_id: company_id,
                        brand_name: medicine
                    },
                    success: function (data) {
                        $this.removeClass('loading');
                        response(data);
                    },
                    error: function (data) {
                        $this.removeClass('loading');
                        alert('Details Not Found');

                    }
                });
            },
            select: function (event, ui) {
                var $this = $(this);
                $this.closest('tr').find('.rate').val(ui.item.id);
            }

        });


    });
</script>
<style>
    .content-wrapper{
        min-height: 775px;
    }
    .form-control{
        padding: 1px 3px;
        height: 26px;
        font-size: 12px;
        border-radius: 1px;
    }
    .btn-default{
        padding: 1px 3px;
        height: 26px;
        font-size: 12px;
        background-color: #FFFFFF;
    }
    .chosen-container-single .chosen-single {
        padding: 1px 3px;
        height: 26px;
        line-height: 22px;
        font-size: 12px;
    }

    .chosen-container .chosen-results li {
        padding: 2px 3px;
    }
    .chosen-container-single .chosen-single div b {
        background: no-repeat 0 2px;
    }
</style>
<?php
$attribute = array('id' => 'valid');
echo form_open('User/addBrand', $attribute);
?> 
<table class="table table-bordered">
    <tr>
        <th style="width: 20%">Brand Name</th>
        <th>Strength</th>
        <th style="width: 28%">Composition</th>
        <th>Form</th>
        <th style="width: 7%">MRP</th>
        <th style="width: 5%">Packing</th>
        <th>Division</th>
    </tr>
    <?php for ($i = 1; $i <= 10; $i++) { ?>
        <tr>
            <td>
                <input type="text"  class="form-control" value="" name="name[]" placeholder="Brand Name" />
            </td>
            <td>
                <input type="number" style="width: 45%"  class="btn btn-default" name="strength[]"  placeholder="Strength" >
                <select name="unit[]" class="btn btn-default">
                    <option value="mg">mg</option>
                    <option value="g">g</option>
                    <option value="%">%</option>
                </select>
            </td>
            <td><input type="text" class="form-control composition" name="composition[]"  placeholder="composition" ><input type="hidden" class="generic_id" value="0" name="generic_id[]"><input type="hidden" class="is_combination" value="0" name="is_combination[]"></td>
            <td>
                <select class="chosen-select" name="form[]">
                    <option>Select Form</option>
                    <?php echo $form; ?>
                </select> 
            </td>
            <td>
                <input type="text" class="form-control" value="" name="mrp[]" placeholder="MRP "/>
            </td>
            <td>
                <input type="text" class="form-control" value="" name="packing[]" placeholder="Packing"/>
            </td>
            <?php if ($this->type == 1) { ?>
                <td>
                    <select name="company[]" class="chosen-select">
                        <option>Select Company</option>
                        <?php echo $company; ?>
                    </select>
                </td>
            <?php } else { ?>
            <input type="hidden" name="company[]" value="<?php echo $this->company_id; ?>">

        <?php } ?>
        <td>
            <select name="division[]" class="form-control">
                <option value="">Select Division</option>
                <?php echo $division; ?>
            </select>
        </td>
    </tr>
    <?php
}
?>
</table>
<button class="btn btn-block btn-success " type="submit">SAVE</button>
</form>

<script src="<?php echo asset_url() ?>js/formValidation.min.js" type="text/javascript"></script>
<script src="<?php echo asset_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
<script>
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

    $(document).on("keydown.autocomplete", '.composition', function () {
        //var medicine = $(this).val();
        var $this = $(this);
        var company_id = <?php echo $this->type == 2 ? $this->company_id : ''; ?>;
        $this.addClass('loading');
        $this.closest('tr').find('.generic_id').val('0');
        $(".composition").catcomplete({
            delay: 1000,
            minLength: 3,
            //source: data,
            source: function (request, response) {
                var medicine = $this.val();
                $.ajax({
                    url: "<?php echo site_url('Api/getComposition'); ?>",
                    type: 'GET',
                    data: {
                        company_id: company_id,
                        composition: medicine
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
                $this.closest('tr').find('.generic_id').val(ui.item.id);
                $this.closest('tr').find('.is_combination').val(ui.item.is_combination);
            }

        });

    });
</script>
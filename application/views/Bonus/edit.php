<link href="<?php echo asset_url(); ?>css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo asset_url(); ?>js/bootstrap-multiselect.js" type="text/javascript"></script>
<?php
$attribute = array('id' => 'valid');
echo form_open('User/editBonus', $attribute);
?>
<div class="row" >
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">        
        <input type="hidden" class="rate" value="<?php echo $row['brand_id'] ?>" id="brand" name="brand_id">
        <input type="hidden" class="form-control" value=" <?php echo $row['id']; ?>"  name="id" >

        <div class="form-group">
            <label>Brand Name</label>  <input type="text" class="form-control brandname" readonly="" value=" <?php echo $row['brand_name']; ?>" name="brand_name" placeholder=" Brand Name "/>
        </div>
        <div class="form-group">  <label>Brand Ratio</label>     <input type="text" class="form-control" value="<?php echo $row['bonus_ratio']; ?>" name="bonus_ratio" placeholder=" Bonus Ratio "/>

        </div>
        <div class="form-group">  <label>Start Date</label>     <input type="text" readonly="" class="form-control" value="<?php echo $row['start_date']; ?>" name="start_date" placeholder=" Bonus Ratio "/>

        </div>
        <div class="form-group">  <label>End Date</label>     <input type="text" class="form-control" readonly="" value="<?php echo $row['end_date']; ?>" name="end_date" placeholder=" Bonus Ratio "/>

        </div>
        <div class="form-group"> <label> State</label>   <select name="state1[]" multiple id="1" class="form-control state multiselect">

                <?php
                $states2 = explode(',', $row['states']);

                foreach ($state as $states1) {
                    ?>


                    <option value="<?php echo $states1->id ?>" <?php
                    if (in_array($states1->id, $states2)) {
                        echo 'selected';
                    }
                    ?>><?php
                                echo $states1->state;
                                ?> </option>     <?php }
                            ?>
            </select>
        </div>

        <div class="form-group">  <button class="btn btn-success " type="submit">Update</button>
        </div>
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
                $("#brand").val(ui.item.id);
            }

        });


    });
</script>
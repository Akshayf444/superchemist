<?php
$attribute = array('id' => 'valid');
echo form_open('User/update_brand?id=' . $rows['id'], $attribute);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Name
            <input type="hidden" class="form-control" value="<?php echo $rows['id'] ?>" name="id"  />
            <input type="text" class="form-control" value="<?php echo $rows['name'] ?>" name="name" placeholder="Name" />
        </div>
        <div class="form-group">
            Form
                       <select name="form" class="form-control">
                <option value="">Select Form</option>

                <?php echo $form; ?>
            </select>
         
        <div class="form-group">
            MRP
            <input type="text" class="form-control" value="<?php echo $rows['mrp']; ?>" name="mrp" placeholder="MRP"/> </div>
        <div class="form-group">
            Company
            <select name="company_id" class="form-control">
                <option value="">Select Company</option>

                <?php echo $company; ?>
            </select>
        </div>
             <div class="form-group">
                 Composition
                 <input type="text" class="form-control composition" value="<?php echo $rows['composition']; ?>" name="composition"  placeholder="composition" >
                 <input type="hidden" class="generic_id" id="gen_id" value="<?php echo $rows['generic_id']; ?>" name="generic_id">
                 <input type="hidden" class="is_combination" value="<?php echo $rows['is_Combination'] ?>"id="comb_id" name="is_combination">
            </div>
        <div class="form-group">
            Packing
            <input type="text" class="form-control" value="<?php echo $rows['packing']; ?>" name="packing"placeholder="Packing "/> </div>
            <div class="form-group">
            Division
            <select name="division" class="form-control">
                <option value="">Select Division</option>
                <?php echo $division; ?>
            </select>
         </div>
        <div class="form-group">
            Strength
            <div class="row">
            
            
            <div class="col-lg-2">
            <input type="text" class="form-control" value="<?php echo $rows['strength']; ?>" name="strength" placeholder="Strength"/>
            </div>
           <div class="col-lg-2">
          <select name="unit" class="btn btn-default">
              <option>Select Option</option>
              
               
                    <option value="mg"<?php if($rows['unit']== 'mg'){  echo 'selected' ;}?>> mg </option>
                    <option value="g"<?php if($rows['unit']== 'g'){  echo 'selected' ;}?>> g </option>
                    <option value="%"<?php if($rows['unit']== '%'){  echo 'selected' ;}?>> % </option>
                </select>
            </div>
            </div>
       
        </div>
        
         
        
        <div class="form-group">
            <button class="btn btn-block btn-success " type="submit">UPDATE</button>
        </div>
    </div>
</form>
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
               $('#gen_id').val(ui.item.id);
                $('#comb_id').val(ui.item.is_combination);
            }

        });

    });
</script>
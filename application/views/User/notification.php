<style>
    .audience{
        text-align: center;
        padding: 20px;
        font-weight: bold;
        border-bottom: 2px solid #00c0ef;
    }

</style>
<div class="row">
    <div class="col-xs-6" style="border-right: 2px solid #00c0ef">
        <?php echo form_open('User/notification'); ?>
        <div class="form-group">
            <label>Select State</label>
            <select class="chosen-select" id="state" multiple name="state[]" >
                <?php echo $state; ?>
            </select> 
        </div>
        <div class="form-group">
            <label>User Type </label>
            <select class="form-control" name="user_type" id="user_type">
                <option value="1">Chemist</option>
                <option value="2">Distributor</option>
                <option value="1,2">Both</option>
            </select>
        </div>
        <div class="form-group">
            <label>Message </label>
            <textarea class="form-control" rows="10" name="message"></textarea>
        </div>
        <div class="form-group">
            SMS <input type="checkbox" name="sms">
<!--            Email <input type="checkbox" name="email">-->
            Notification <input type="checkbox" name="notification">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save">
        </div>
        </form>
    </div>
    <div class="col-xs-6">        
        <div class="audience">
            <h2>Target Audience</h2>
            <h1 id="audiance"></h1>
        </div>
        <div class="" align="center">
            <h3>Your Account Balance</h3>
            <dl class="dl-horizontal">
                <dt>SMS</dt>
                <dd> : <?php echo $smscount ?></dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Notification</dt>
                <dd> : <?php echo $notificationcount ?></dd>
            </dl>
        </div>
    </div>
</div>
<script>
    $('document').ready(function () {

        calculateAudiance('none');

        $("#state").change(function () {
            var option = $("#user_type").val();
            calculateAudiance(option);

        });

        $("#user_type").change(function () {
            var option = $(this).val();
            calculateAudiance(option);
        });

        function calculateAudiance(option, selector) {
            var audiance = 0;
            if (option == '1') {
                $("#state option:selected").each(function () {
                    audiance += parseInt($(this).attr('data-count1'));
                });
            } else if (option == '2') {
                $("#state option:selected").each(function () {
                    audiance += parseInt($(this).attr('data-count2'));
                });
            } else {
                $("#state option:selected").each(function () {
                    audiance += parseInt($(this).attr('data-count1')) + parseInt($(this).attr('data-count2'));
                });
            }
            $("#audiance").html(audiance);
        }
    });
</script>
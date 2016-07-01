<style>
    .audience{
        text-align: center;
        padding: 20px;
        font-weight: bold;
        border-bottom: 2px solid #FFC107;
    }

</style>
<div class="row">
    <div class="col-xs-6" style="border-right: 2px solid #FFC107">
        <?php echo form_open('User/notification'); ?>
        <div class="form-group">
            <label>Select State</label>
            <select class="chosen-select" multiple name="state" >
                <?php echo $state; ?>
            </select> 
        </div>
        <div class="form-group">
            <label>User Type </label>
            <select class="form-control">
                <option value="1">Chemist</option>
                <option value="2">Distributor</option>
                <option value="Both">Both</option>
            </select>
        </div>
        <div class="form-group">
            <label>Message </label>
            <textarea class="form-control" rows="10" name="message"></textarea>
        </div>
        <div class="form-group">
            SMS <input type="checkbox" name="sms">
            Email <input type="checkbox" name="email">
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
            <h1>85654</h1>
        </div>
        <div class="" align="center">
            <h3>Your Account Balance</h3>
            <dl class="dl-horizontal">
                <dt>SMS</dt>
                <dd> : 2000</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Email</dt>
                <dd> : 2000</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Notification</dt>
                <dd> : 2000</dd>
            </dl>
        </div>
    </div>
</div>
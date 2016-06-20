<?php if ($this->session->userdata('Designation') == 'TM') { ?>
    <div class="row">
        <div class="col-xs-6">
            <a href="<?php echo site_url('User/addDoctor'); ?>" class="btn btn-warning">Add Young Doctor</a>
        </div>
        <div class="col-xs-6">
            <a href="<?php echo site_url('User/addpgDoctor'); ?>" class="btn btn-info pull-right">Add PG Doctor</a>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div style="padding-top: 5px" class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel-body  bg-green" >
            <div class="col-xs-3">
                <i class="fa fa-5x fa-user-md"></i>
            </div>
            <div class="col-xs-9" align="right">
                <h2 style="margin-top: 0px"><b><?php echo $dashboardstatus->ydoctor; ?></b></h2>
                <h4 style="margin-top: 0px">Total Young Doctor</h4>   

            </div><!-- /.info-box -->
        </div>
        <div class="panel-footer" style="background-color: #fff">
            <a href="<?php echo site_url('User/view_doctor'); ?>" ><b>View Detail</b> <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
    <div style="padding-top: 5px" class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel-body bg-red" >
            <div class="col-xs-3">
                <i class="fa fa-5x fa-user-md"></i>
            </div>
            <div class="col-xs-9 " align="right">        
                <h2 style="margin-top: 0px"><b><?php echo $dashboardstatus->pgdoctor; ?></b></h2>
                <h4 style="margin-top: 0px">Total Pg Doctor</h4>
            </div><!-- /.info-box -->
        </div>
        <div class="panel-footer" style="background-color: #fff">
            <a href="<?php echo site_url('User/view_pgdoctor'); ?>" ><b>View Detail</b> <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</div>
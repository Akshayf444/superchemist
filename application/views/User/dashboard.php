<div class="row">
    <div style="padding-top: 5px" class="col-md-3 col-sm-6 col-xs-12">
        <div class="panel-body  bg-green" >
            <div class="col-xs-3">
                <i class="fa fa-4x fa-tags"></i>
            </div>
            <div class="col-xs-9" align="right">
                <h2 style="margin-top: 0px"><b><?php echo $brandcount; ?></b></h2>
                <h4 style="margin-top: 0px">Brands</h4>   

            </div><!-- /.info-box -->
        </div>
    </div>
    <div style="padding-top: 5px" class="col-md-3 col-sm-6 col-xs-12">
        <div class="panel-body bg-red" >
            <div class="col-xs-3">
                <i class="fa fa-4x  fa-gift"></i>
            </div>
            <div class="col-xs-9 " align="right">        
                <h2 style="margin-top: 0px"><b><?php echo $bonuscount; ?></b></h2>
                <h4 style="margin-top: 0px">Active Bonus</h4>
            </div><!-- /.info-box -->
        </div>
    </div>
    <div style="padding-top: 5px" class="col-md-3 col-sm-6 col-xs-12">
        <div class="panel-body  bg-blue" >
            <div class="col-xs-3">
                <i class="fa  fa-4x fa-building-o"></i>
            </div>
            <div class="col-xs-9" align="right">
                <h2 style="margin-top: 0px"><b><?php echo $this->type == 1 ? $countCompany : $divisioncount; ?></b></h2>
                <h4 style="margin-top: 0px"><?php echo $this->type == 1 ? 'Companies' : 'Divisions'; ?></h4>   
            </div><!-- /.info-box -->
        </div>
    </div>
    <div style="padding-top: 5px" class="col-md-3 col-sm-6 col-xs-12">
        <div class="panel-body bg-maroon" >
            <div class="col-xs-3">
                <i class="fa fa-4x fa-line-chart"></i>
            </div>
            <div class="col-xs-9 " align="right">        
                <h2 style="margin-top: 0px"><b><?php echo $ctr; ?></b></h2>
                <h4 style="margin-top: 0px">CTR</h4>
            </div><!-- /.info-box -->
        </div>
    </div>
</div>
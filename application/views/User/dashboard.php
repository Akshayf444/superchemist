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
<br/>
<div class="row">
    <div class="col-xs-6" >
        <div class=" box box-success">
            <div class="box-header with-border"><h3 class="box-title">Bonus Offer Trend</h3></div>
            <div class="box-body" id="container2">
            </div>
        </div>
    </div>
</div>
<script>
    $('document').ready(function () {
        $('#container2').highcharts({
            chart: {
                type: 'xy'
            },
            title: {
                text: '',
                x: -20 //center
            },
            xAxis: {
                categories: <?php echo json_encode($companies) ?>,
                crosshair: true
            },
            yAxis: {
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },  
            credits: {
                enabled: false,
                text: 'Techvertica.com',
                href: 'http://www.techvertica.com'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0,
                floating:true
            },
            series: [{
                    type: 'column',
                    name: 'Bonus Offer',
                    data: <?php echo json_encode($bonus, JSON_NUMERIC_CHECK) ?>
                }]
        });
    });
</script>
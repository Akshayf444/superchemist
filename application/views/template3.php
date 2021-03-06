<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo asset_url() ?>dashboard/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
<!--        <link href="<?php echo asset_url() ?>dashboard/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
         jvectormap 
        <link href="<?php echo asset_url() ?>dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />-->

        <!-- Theme style -->
        <link href="<?php echo asset_url() ?>dashboard/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo asset_url() ?>dashboard/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo asset_url() ?>dashboard/plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <link href="<?php echo asset_url() ?>css/jQuery-ui.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo asset_url() ?>js/jQuery-ui.js"></script>
        <script src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo asset_url() ?>js/excellentexport.min.js" type="text/javascript"></script>
        <link href="<?php echo asset_url(); ?>css/chosen.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo asset_url(); ?>js/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo asset_url(); ?>js/chosen.proto.js" type="text/javascript"></script>
        <link href="<?php echo asset_url(); ?>css/responsiveTable.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo asset_url(); ?>js/highcharts.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>
            .loading{
                background: url(<?php echo asset_url(); ?>images/38-1.gif) right;
                background-repeat: no-repeat;
            }
        </style>
    </head>
    <body class="skin-blue">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">
                <a href="<?php echo site_url('User/dashboard'); ?>" class="logo" style="background-color: #fff;"><b><img src="<?php echo asset_url() ?>images/youngdoctor.png"  style="height: 45%"></b></a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->

                                <?php $CI = & get_instance(); ?>
                                <p style="padding-top: 10px;color: #FFFFFF" ><span class=""><?php echo isset($CI->full_name) ? $CI->full_name . "&nbsp" : ''; ?></span>
                                    <a class="text-aqua" href="<?php echo site_url('User/logout'); ?>">
                                        <span style="font-size: 20px" class="fa fa-power-off">  </span>
                                    </a>
                                </p>

                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="<?php echo site_url('User/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="<?php echo site_url('User/Division'); ?>"><i class="fa fa-dashboard"></i> Division</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('User/brandList'); ?>"><i class="fa fa-dashboard"></i> Brand List</a>
                        </li>
                        <?php if ($this->type == 1) { ?>
                            <li>
                                <a href="<?php echo site_url('User/CompanyList'); ?>"><i class="fa fa-dashboard"></i> Company</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('User/notification'); ?>"><i class="fa fa-dashboard"></i>Notification</a>
                            </li>

                            <li>
                                <a href="<?php //echo site_url('User/brandList');                  ?>"><i class="fa fa-dashboard"></i> Settings</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo site_url('User/Bonus'); ?>"><i class="fa fa-dashboard"></i> Bonus Offer</a>
                        </li>               
                        <?php if ($this->type == 2) { ?>
                            <li>
                                <a href="<?php echo site_url('User/Image_list'); ?>"><i class="fa fa-file-image-o"></i>Brand Image</a>
                            </li>
                        <?php } ?>                            


                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>   

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper"  style="  background-color: white;" >
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo isset($page_title) ? $page_title : ''; ?>
                        <small></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php
                    echo $this->session->userdata('message') ? $this->session->userdata('message') : '';
                    $this->session->unset_userdata('message');
                    ?>
                    <?php $this->load->view($content, $view_data); ?>
                </section>
            </div>
        </div>
        <script src="<?php echo asset_url() ?>dashboard/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src='<?php echo asset_url() ?>js/jquery.bootstrap-growl.min.js' type='text/javascript'></script>
        <!-- AdminLTE App -->
        <script src="<?php echo asset_url() ?>dashboard/dist/js/app.min.js" type="text/javascript"></script>
        <script src="<?php echo asset_url() ?>js/datepicker.js" type="text/javascript"></script>
        <script>
            $('document').ready(function () {
                var oTable = $('#datatable').dataTable({
                    "bPaginate": false,
                    "bInfo": false,
                    "info": false,
                });

                var config = {
                    '.chosen-select': {},
                    '.chosen-select-deselect': {allow_single_deselect: true},
                    '.chosen-select-no-single': {disable_search_threshold: 10},
                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                    '.chosen-select-width': {width: "95%"}
                }
                for (var selector in config) {
                    $(selector).chosen(config[selector]);
                }

            });
        </script>
    </body>
</html>
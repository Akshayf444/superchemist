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
        <script type="text/javascript">
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
        </script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

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
                                <p style="padding-top: 10px;color: #FFFFFF" ><span class=""><?php echo isset($CI->Full_Name) ? $CI->Full_Name . "&nbsp" : ''; ?></span>
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
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-md"></i> <span>Young Doctor</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <?php
                                if ($this->session->userdata('Designation') == 'TM') {
                                    echo '<li><a href="' . site_url('User/addDoctor') . '"><i class="fa fa-circle-o"></i> Add Doctor</a></li>';
                                }
                                ?>

                                <li class=""><a href="<?php echo site_url('User/view_doctor'); ?>"><i class="fa fa-circle-o"></i>  View Doctor</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-md"></i> <span>PG Doctor</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <?php
                                if ($this->session->userdata('Designation') == 'TM') {
                                    echo '<li><a href="' . site_url('User/addpgDoctor') . '"><i class="fa fa-circle-o"></i> Add Doctor</a></li>';
                                }
                                ?>
                                <li class=""><a href="<?php echo site_url('User/view_pgdoctor'); ?>"><i class="fa fa-circle-o"></i>  View Doctor</a></li>
                            </ul>
                        </li>
                        <?php if ($this->session->userdata('Designation') == 'TM') { ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-institution"></i> <span>Institute</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu" style="display: none;">
                                    <li><a href="<?php echo site_url('User/addinstitute'); ?>"><i class="fa fa-circle-o"></i> Add Institute</a></li>
                                    <li class=""><a href="<?php echo site_url('User/viewinstitute'); ?>"><i class="fa fa-circle-o"></i>  View Institute</a></li>
                                </ul>
                            </li>
                        <?php }
                        ?>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>   

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" >
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
            <script src="<?php echo asset_url() ?>dashboard/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src='<?php echo asset_url() ?>js/jquery.bootstrap-growl.min.js' type='text/javascript'></script>
            <!-- AdminLTE App -->
            <script src="<?php echo asset_url() ?>dashboard/dist/js/app.min.js" type="text/javascript"></script>
    </body>
</html>
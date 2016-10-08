<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SYSCMS <?php echo isset($title) ? ' | ' . $title : null; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="<?php echo media_url('ico/favicon.jpg'); ?>" type="image/x-icon">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap.min.css">
        <!-- Jquery UI -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/jquery-ui.theme.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/_all-skins.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/dataTables.bootstrap.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap3-wysihtml5.min.css">
        <!-- Notyfy JS - Notification -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/jquery.notyfy.css">
        <!-- Select2 multi select -->
        <link rel="stylesheet" href="<?php echo media_url() ?>/css/select2.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>S</b>YS</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Sys</b>CMS</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo media_url() ?>/img/photo.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo ucfirst($this->session->userdata('ufullname')); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo media_url() ?>/img/photo.jpg" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo ucfirst($this->session->userdata('ufullname')); ?> - <?php echo ucfirst($this->session->userdata('urolename')); ?>
                                            <small><?php echo $this->session->userdata('uemail'); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo site_url('admin/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo site_url('admin/auth/logout?location=' . htmlspecialchars($_SERVER['REQUEST_URI'])) ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <?php $this->load->view('admin/sidebar'); ?>

            <!-- Content Wrapper. Contains page content -->
            <?php isset($main) ? $this->load->view($main) : null; ?>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; 2016 - Sistem Informasi Pelaporan Pelanggaran Pengelolaan Lingkungan Hidup.</strong> All rights
                reserved.
            </footer>

        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
        <script src="<?php echo media_url() ?>/js/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo media_url() ?>/js/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo media_url() ?>/js/bootstrap.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo media_url() ?>/js/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo media_url() ?>/js/app.min.js"></script>
        <!-- Notyfy JS -->
        <script src="<?php echo media_url() ?>/js/jquery.notyfy.js"></script>
        <!-- Select2 multi select -->
        <script src="<?php echo media_url() ?>/js/select2.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo media_url() ?>/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo media_url() ?>/js/dataTables.bootstrap.min.js"></script>


        <script type="text/javascript">
                    $(document).ready(function () {
                        $(".autocomplete").select2();
                    });
        </script>


        <script>
            //Initiation dataTable
            $(function () {
                $('.table-init').DataTable({
                    "aaSorting": [],
                    "oLanguage": {
                        "sSearch": "Pencarian :"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [-1]
                        } //disables sorting for last column
                    ],
                    "sPaginationType": "full_numbers",
                });
            });

            //Initiation datepicker
            $(function () {
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '-55:+10',
                    dateFormat: "yy-mm-dd",
                });
            });
        </script>

        <?php if ($this->session->flashdata('success')) { ?>
            <script>
                $(function () {
                    notyfy({
                        layout: 'top',
                        type: 'success',
                        showEffect: function (bar) {
                            bar.animate({height: 'toggle'}, 500, 'swing');
                        },
                        hideEffect: function (bar) {
                            bar.animate({height: 'toggle'}, 500, 'swing');
                        },
                        timeout: 3000,
                        text: '<?php echo $this->session->flashdata('success') ?>'
                    });
                });
            </script>
        <?php } ?>
    </body>
</html>

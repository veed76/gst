<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo DESCRIPTION; ?>">
        <meta name="author" content="<?php echo AUTHOR; ?>">

        <link rel="shortcut icon" href="<?php echo ASSETURL; ?>images/main_favicon.ico">

        <title><?php echo (isset($title) && $title != '') ? $title : WEBSITE_NAME; ?></title>

        <?php
        $controller = $this->router->fetch_class();

        switch ($controller) {
            case "gst" || "company":
                ?>
                <!-- DataTables -->
                <link href="<?php echo THEMEURL; ?>plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
                <link href="<?php echo THEMEURL; ?>plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
                <link href="<?php echo THEMEURL; ?>plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
                <link href="<?php echo THEMEURL; ?>plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
                <!--Form Wizard-->
                <link  href="<?php echo THEMEURL; ?>plugins/jquery.steps/demo/css/jquery.steps.css" rel="stylesheet" type="text/css" />                
                <link href="<?php echo THEMEURL; ?>plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
                <link href="<?php echo THEMEURL; ?>plugins/footable/css/footable.core.css" rel="stylesheet">
                <link href="<?php echo THEMEURL; ?>plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />

                <!-- date pickert -->
                <link href="<?php echo THEMEURL; ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
                <link href="<?php echo THEMEURL; ?>plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

                <!-- Sweet Alert -->
                <link href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css" rel="stylesheet" />
                <?php
                break;
        }
        ?>


        <!--Morris Chart CSS -->
        <link  href="<?php echo THEMEURL; ?>plugins/morris/morris.css" rel="stylesheet">
        <link href="<?php echo THEMEURL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL; ?>css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL; ?>css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL; ?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL; ?>css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETURL; ?>css/gst-custom.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL; ?>css/responsive.css" rel="stylesheet" type="text/css" />


        <!-- jQuery  -->

        <script src="<?php echo THEMEURL; ?>js/jquery.min.js"></script> 
        <script src="<?php echo THEMEURL; ?>js/modernizr.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script>
            google.load("elements", "1", {
                packages: "transliteration"
            });
        </script>
    </head>


<body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?php echo ADMINURL."user" ?>" class="logo">
                            <span><?php echo WEBSITE_NAME; ?></span>
                        </a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                          <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo ASSETURL . '/images/user.png'; ?>" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                       <li><a href="<?php echo ADMINURL . 'setting/' ?>"><i class="fa fa-cog"></i> Settings </a></li>
                                        <li><a href="<?php echo ADMINURL . 'admin/logout/' ?>"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->
            <?php
            $this->load->view(ADMINVIEW."common/nav");
            ?>
            <div class="content-page">
                <div class="content">
                    <div class="container">
<!DOCTYPE html5>
<html>
    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo DESCRIPTION; ?>">
        <meta name="author" content="<?php echo AUTHOR; ?>">

        <link rel="shortcut icon" href="<?php echo THEMEURL;?>images/favicon_1.ico">

        <title><?php echo (isset($title) && $title != '') ? $title : WEBSITE_NAME; ?></title>

        <link href="<?php echo THEMEURL;?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL;?>css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL;?>css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL;?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL;?>css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo THEMEURL;?>css/responsive.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading"> 
                    <h3 class="text-center"><strong class="text-custom"><?php //echo WEBSITE_NAME; ?> Sign Up</strong> </h3>
                </div> 
                <div class="panel-body">
                 <?php 
                        $attr= array(
                            "class" => "form-horizontal m-t-20",
                            "id" => $html_form_id,
                            "method" => "post"
                        );
                        echo form_open($html_action,$attr);
                        if(isset($error)){
                            echo '<div class="form-group ">
                                <div class="col-xs-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        '.$error.'
                                    </div>
                                </div>
                            </div>';
                        }
                    ?>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" required="" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" pattern="[a-zA-Z]+" name="firstname" required="" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" checked="checked">
                                    <label for="checkbox-signup">I accept <a href="#">Terms and Conditions</a></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" name="signup" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>

                     <?php echo form_close(); ?>
                </div>   
            </div> 
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>Already have an account? <a href="<?php echo base_url().'login' ?>" class="text-primary m-l-5"><b>Login</b></a></p>
                        
                    </div>
            </div>                             
        </div>
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?php echo THEMEURL;?>js/jquery.min.js"></script>
        <script src="<?php echo THEMEURL;?>js/bootstrap.min.js"></script>
        <script src="<?php echo THEMEURL;?>js/detect.js"></script>
        <script src="<?php echo THEMEURL;?>js/fastclick.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.slimscroll.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.blockUI.js"></script>
        <script src="<?php echo THEMEURL;?>js/waves.js"></script>
        <script src="<?php echo THEMEURL;?>js/wow.min.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.nicescroll.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.core.js"></script>
        <script src="<?php echo THEMEURL;?>js/jquery.app.js"></script>	
        <script type="text/javascript" src="<?php echo THEMEURL; ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/parsleyjs/dist/parsley.min.js" type="text/javascript" ></script>

        <script type="text/javascript">
        var html_form_id = '<?php echo $html_form_id ?>';
            $('#'+html_form_id).parsley();
        </script>
	</body>
</html>
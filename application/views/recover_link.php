<!DOCTYPE html>
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
                    <h3 class="text-center"><strong class="text-custom"><?php //echo WEBSITE_NAME; ?> Change Password</strong> </h3>
                </div> 
                <div class="panel-body">
                    <?php 
                        $attr= array(
                            "class" => "form-horizontal m-t-20",
                            "id" => $html_form_id,
                            "method" => "post",
                            "onsubmit" => "return validateForm()",
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
                        }elseif(isset($success)){
                            echo '<div class="form-group ">
                                <div class="col-xs-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        '.$success.'
                                    </div>';
                                    $base_url = base_url().'login';
                                    echo"<a href='$base_url' class='btn btn-pink btn-block text-uppercase waves-effect waves-light'><b>Login</b></a></div>
                            </div>";
                        }else
                        {
                    ?>
                        <div class="form-group">
                         <font id="msg_err"></font>
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="new" placeholder="New Password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="confirm" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Change</button>
                            </div>
                        </div>

                    <?php } echo form_close(); ?>
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


            function validateForm() {
                var conf_val = $("input[name=confirm]").val();
                var new_val = $("input[name=new]").val();
                if (new_val != conf_val) {
                    $("#msg_err").html('<div class="alert alert-danger alert-dismissible" role="alert"> New and Confirm Password Are Not Same...! </div>');
                    return false;
                }

            }
        var html_form_id = '<?php echo $html_form_id ?>';
            $('#'+html_form_id).parsley();
        </script>
	</body>
</html>
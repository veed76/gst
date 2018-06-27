<!-- Page-Title -->
<div class="row">
        <div class="col-sm-12">
                <h4 class="page-title">Settings</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li class="active">
                            Settings
                    </li>
                </ol>
        </div>
</div>

<!-- New Employee Form -->
 <?php
    $action_invoice=base_url()."setting/invoice";
    $action_tags=base_url()."setting/tags";
    $action_password=base_url()."setting/changepassword";
    $invoice = unserialize($invoice["setting_value_2"]);
?>
<div class="row">
    <div class="col-lg-12"> 
    <?php
        if (validation_errors() != '') {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">' . validation_errors() . '</div>';
        }else if(isset($error)){
                echo '<div class="alert alert-danger alert-dismissible" role="alert">'.$error.'</div>';
        }else if(isset($success)){
            echo '<div class="alert alert-success alert-dismissible" role="alert">'.$success.'</div>';
        }
    ?>
        <ul class="nav nav-tabs navtab-bg nav-justified"> 
            <li class="active"> 
                <a href="#home1" data-toggle="tab" aria-expanded="true"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Invoice</span> 
                </a> 
            </li> 
            <li class=""> 
                <a href="#profile1" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-user"></i></span> 
                    <span class="hidden-xs">Dealer Tags</span> 
                </a> 
            </li> 
           <!-- <li class=""> 
                <a href="#messages1" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
                    <span class="hidden-xs">Messages</span> 
                </a> 
            </li> -->
            <li class=""> 
                <a href="#settings1" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                    <span class="hidden-xs">Settings</span> 
                </a> 
            </li> 
        </ul> 
        <div class="tab-content"> 
            <div class="tab-pane active" id="home1"> 
                <form action="<?php echo $action_invoice ?>" class="form-horizontal m-t-20"  method="post"  accept-charset="utf-8">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-offset-2 col-md-2 col-lg-2 control-label text-align-left"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Set Invoice *</font></font></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?= $invoice[0] ?>" name="invoice_str" required="" placeholder="Set Label">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="<?= $invoice[1] ?>" name="invoice_digit" required="" placeholder="Set Digit">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                    Save
                            </font></font></button>
                            <button type="reset" class="btn btn-default m-l-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                    clean
                            </font></font></button>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Set Gold Price *</font></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?= $invoice[setting_value_2] ?>" name="invoice" required="" placeholder="Set Invoice">
                        </div>
                    </div> -->
                    
                    <div class="form-group">
                       <label class="col-xs-12 col-md-offset-2 col-sm-6 col-md-6 col-lg-6 control-label text-align-left"><font>Invoice Number Is: <font class="label label-table label-success"><?= $invoice[0].$invoice[1]; ?></font></font></label>
                    </div>
                </form>
            </div> 
            <div class="tab-pane dealer_tag_listing" id="profile1"> 
                
                    <form action="<?php echo $action_tags ?>" class="form-horizontal m-t-20"  method="post" accept-charset="utf-8">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tags *</font></font></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control " name="tag" required="" placeholder="Dealer Tag">
                            </div>
                    
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        Add
                                </font></font></button>
                                <button type="reset" class="btn btn-default m-l-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        clean
                                </font></font></button>
                            </div>
                        </div>
                    </form> 
                    <div>
                        <div class="card-box table-responsive">
                         <table id="datatable-dealer-tag" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead class="th_cls">
                                    <tr>
                                        <th>Dealer Tags</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($tags as $val)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $val["setting_value_1"]; ?></td>
                                            <td style="width:10%">
                                            <!--<a href="javascript::" class="table-action-btn edit" title="Edit" data-source="<?php echo $val["setting_uuid"]; ?>"><i class="md md-edit"></i></a> -->
                                                <a href="javascript::" class="table-action-btn remove" title="Delete" data-source="<?php echo $val["setting_uuid"]; ?>"><i class="md md-close"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <hr/>
            </div> 
            <div class="tab-pane" id="settings1"> 
             
                <h4 class="m-t-0 header-title"><b>Change Password</b></h4>
                <hr>
                <font id="msg_err"></font>
                
                <form action="<?php echo $action_password ?>" class="form-horizontal m-t-20"  method="post" onsubmit="return validateForm();">
                   
                                        
                    <div class="form-group row ">
                        <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label">Old Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="old" required="" placeholder="Old Password">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label">New Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" required name="new" placeholder="New Password">
                        </div>
                    </div>

                     <div class="form-group row ">
                        <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2  control-label">Confirm Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" required name="confirm" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9 m-t-15">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                            <button type="reset" class="btn btn-default m-l-5">
                                Clean
                            </button>
                        </div>
                    </div>
                </form>
            </div> 
        </div> 
    </div>
</div>

<!-- End row -->
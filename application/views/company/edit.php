<!-- Page-Title -->
<script src="http://iamrohit.in/lab/js/location.js"></script>
<div class="row">
        <div class="col-sm-12">
                <h4 class="page-title">New Company</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li>
                            <a href="<?php echo base_url(); ?>company">Register</a>
                    </li>
                    <li class="active">
                         New
                    </li>
                </ol>
        </div>
</div>

<!-- New Employee Form -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <?php
                if(validation_errors() != ''){
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">'.validation_errors().'</div>';
                }
                $attr= array(
                    "class" => "form-horizontal m-t-20",
                    "id" => $html_form_id,
                    "method" => "post",
                    "novalidate" =>""
                );
                //$date_reg=nice_date($company_data['company_registrationdt'],"d/m/Y");
                $date_reg=date("d-m-Y",strtotime($company_data['company_registrationdt']));
                echo form_open_multipart($html_action,$attr);
            ?>
            <div class="form-group clearfix">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left" for="profile">Profile</label>
                <div class="col-sm-3">
                    <input type="file" class="filestyle" name="profile" value="<?php echo $company_data['company_profileurl'] ?>" data-iconname="fa fa-cloud-upload">
                </div>                            
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Name*</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="company_name" value="<?php echo $company_data[company_name] ?>" required="" placeholder="Company Name">
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Jurication Name*</label>
                <div class="col-sm-6 ">
                    <input type="text" class="form-control" name="sole_proprietor" required="" value="<?php echo $company_data[company_name_entity] ?>" placeholder="Jurication Name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Address*</label>
                <div class="col-sm-6">
                    <textarea  class="form-control" name="address" data-parsley-id="1" required placeholder="Address"><?php echo $company_data[company_address] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Pincode*</label>
                <div class="col-sm-6">
                    <input parsley-trigger="change" type="text" name="pincode" value="<?php echo $company_data[company_pincode] ?>" required maxlength="6" class="form-control"  placeholder="Pincode" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Registration Date*</label>
                <div class="col-sm-4 ">
                <div class="input-group">
                    <input type="text" class="form-control" value="<?php echo $date_reg; ?>" name="reg_date" placeholder="dd/mm/yyyy" required="" id="datepicker-autoclose">
                    <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Mobile*</label>
                <div class="col-sm-6">
                    <input parsley-trigger="change" type="text" name="mobile" value="<?php echo $company_data[company_mobile] ?>" required pattern="/(7|8|9)\d{9}/" maxlength="10" class="form-control"  placeholder="Mobile Number" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Phone</label>
                <div class="col-sm-6">
                    <input parsley-trigger="change" type="text" name="phone" pattern="/(7|8|9)\d{9}/" maxlength="10" class="form-control"  placeholder="Phone Number" />
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">E-Mail*</label>
                <div class="col-sm-6">
                        <input type="email" data-parsley-id="3" required="" value="<?php echo $company_data[company_email] ?>" class="form-control" name="email"  parsley-trigger="change" placeholder="E-mail" />
                </div>
            </div>

            <div class="form-group">
            <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left"> State / City*</label>
                <div class="col-sm-6">
                    <select class="form-control select2" name="state" required placeholder="State">
                        <option value="select" disabled selected >City / State</option>
                        <?php
                            foreach($cities as $key => $val)
                            {
                                $selected= ($company_data['company_city'] == $val[city_id])?'selected':'';
                                echo "<option value='$val[city_id]-$val[state_code]' $selected >$val[city_name] - $val[city_state]</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">PAN Number </label>
                <div class="col-sm-6">
                    <input  type="text" name="pan" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" value="<?php echo $company_data[company_pan] ?>"  maxlength="10" class="form-control"  placeholder="Enter PAN Number" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Gstin*</label>
                <div class="col-sm-6">
                    <input data-parsley-type="alphanum" type="text" name="gstin" required data-parsley-id="48"  pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" maxlength="15" value="<?php echo $company_data[company_gstin] ?>" class="form-control"  placeholder="Enter Gstin" />
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-9 m-t-15">
                    <button type="submit" class="btn btn-primary">
                            Update
                    </button>
                    <button type="reset" class="btn btn-default m-l-5">
                            Clean
                    </button>
                </div>
            </div>
            <?php  form_close(); ?>
        </div>
    </div>
</div>
<!-- End row -->
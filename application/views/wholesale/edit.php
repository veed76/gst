<!-- Page-Title -->
<div class="row">
        <div class="col-sm-12">
                <h4 class="page-title">New Wholesale Bill</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li>
                            <a href="<?php echo base_url(); ?>wholesale">Sales</a>
                    </li>
                    <li class="active">
                         Generate Bill
                    </li>
                </ol>
        </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <?php

                if(validation_errors() != ''){
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">'.validation_errors().'</div>';
                }
                $attr= array(
                    "class" => "form-horizontal m-t-20",
                    "id" => $html_form_id."abc",
                    "method" => "post",
                    "novalidate" =>""
                );
                $date_reg=date("d-m-Y",strtotime($wholesale_data['wholesale_generatedt']));
                echo form_open_multipart($html_action,$attr);
            ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Invoice Number*</label>
                <div class="col-sm-6">
                    <input parsley-trigger="change" type="text" name="invoice" required  maxlength="" class="form-control"  placeholder="Invoice Number" value="<?php echo $wholesale_data[wholesale_invoice_number] ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Date*</label>
                <div class="col-sm-4 ">
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?php echo $date_reg ?>" name="reg_date" placeholder="dd/mm/yyyy" required="" id="datepicker-autoclose">
                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left"> Company *</label>
                    <div class="col-sm-6">
                        <select class="form-control select2" name="company" required placeholder="">
                            <option disabled selected >Select Company</option>
                            <?php
                                foreach($company_data as $key => $val)
                                {
                                    $selected = ($wholesale_data["wholesale_company_uuid"]== $val['company_uuid'])?"selected":"";
                                    echo "<option $selected value='$val[company_uuid]'>$val[company_name]</option>";
                                }
                            ?>
                        </select>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left" id="company-idd" data-source="<?= $gold_price ?>"> Customer *</label>
                    <div class="col-sm-6">
                        <select class="form-control select2" name="customer_code" required>
                        <option disabled selected >Select Customer</option>
                            <?php

                               foreach($customer as $key => $val)
                                {
                                    $selected = ($wholesale_data["wholesale_customer_uuid"]== $val['customer_uuid'])?"selected":"";
                                    echo "<option value='$val[customer_uuid]' $selected>$val[customer_firstname] - $val[customer_gstin_number]</option>";
                                }
                            ?>           
                        </select>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Deal</label>
                    <div class="col-sm-6">
                        <select class="form-control select2" name="deal" >
                            <option disabled selected >Select Deal</option>
                            <?php
                                foreach($tags as $key => $val)
                                {
                                     $selected = ($wholesale_data["wholesale_dealer_tag"]== $val['setting_uuid'])?"selected":"";
                                    echo "<option $selected value='$val[setting_uuid]'>$val[setting_value_1]</option>";
                                }
                            ?>
                        </select>
                    </div>
            </div>
           <!--  <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Name*</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" value="<?php echo $wholesale_data[wholesale_name] ?>" name="name" required="" placeholder="Name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Address*</label>
                <div class="col-sm-6">
                    <textarea  class="form-control" name="address" data-parsley-id="1" required placeholder="Address"><?php echo $wholesale_data['wholesale_address'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Mobile*</label>
                <div class="col-sm-6">
                    <input parsley-trigger="change" type="text" name="mobile" value="<?php echo $wholesale_data[wholesale_mobile_no] ?>" required pattern="/(7|8|9)\d{9}/" maxlength="10" class="form-control"  placeholder="Mobile Number" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left"> State *</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="state" required placeholder="State">
                            <option disabled selected >Select State</option>
                            <?php
                                foreach($state as $key => $val)
                                {
                                     $selected = ($wholesale_data["wholesale_state_code"]== $val['state_code'])?"selected":"";
                                    echo "<option  $selected value='$val[state_code]'>$val[state_code] - $val[state_name]</option>";
                                }
                            ?>
                        </select>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">Gstin*</label>
                <div class="col-sm-6">
                    <input  type="text" name="gstin" required  pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" value="<?php echo $wholesale_data[wholesale_gst_number] ?>" maxlength="15" class="form-control"  placeholder="ex : 22AAAAA0000A1Z5" />
                </div>
            </div>-->


            <div class="form-group">
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left">CGST*</label>
                <div class="col-sm-2">
                    <input  type="text" name="cgst" value="<?php echo $wholesale_data[wholesale_cgst] ?>" required pattern="^[1-9]\d*(\.\d+)?$" maxlength="4" class="form-control"  placeholder="Enter CGST" />
                </div>
                <label class="col-xs-12 col-sm-6 col-md-2 col-lg-2 control-label text-align-left"  align="center">SGST*</label>
                <div class="col-sm-2">
                    <input  type="text" name="sgst" required value="<?php echo $wholesale_data[wholesale_sgst] ?>" maxlength="4" pattern="^[1-9]\d*(\.\d+)?$"  class="form-control"  placeholder="Enter SGST" />
                </div>
                <label class="col-xs-12 col-sm-6 col-md-1 col-lg-1 control-label text-align-left">IGST</label>
                <div class="col-sm-2">
                    <input  type="text" name="igst"  pattern="^[1-9]\d*(\.\d+)?$" value="<?php echo $wholesale_data[wholesale_igst] ?>" maxlength="4" class="form-control"  placeholder="Enter IGST" />
                </div>
            </div>
            <hr>
            
            <?php

                for($i=0;$i<=5;$i++)
                {
                    $val=$description_data[$i];
                    $hsn = (trim($val['description_hsn_code']))?$val['description_hsn_code']:7113;
            ?>
                <div class="form-group">
                    <div class="col-sm-6">
                        <textarea  class="form-control" name="bill[<?php echo $i ?>][description]"  placeholder="Description"><?php echo $val['description_particular'] ?></textarea>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" value="<?php echo $hsn ?>" name="bill[<?php echo $i ?>][hsn]" class="form-control"  placeholder="HSN Code" >
                         <input type="hidden" value="<?php echo $val['description_uuid'] ?>" name="bill[<?php echo $i ?>][uuid]" class="form-control"  >
                    </div>
                    <div class="col-sm-2">
                        <input type="text" value="<?php echo $val['description_weight'] ?>" pattern="/^-?[0-9]+(.[0-9]{1,2})?$/" name="bill[<?php echo $i ?>][weight]" class="form-control"  placeholder="Weight" >
                    </div>
                    <div class="col-sm-2">
                        <input type="text" value="<?php echo $val['description_rate'] ?>" name="bill[<?php echo $i ?>][rate]" class="form-control" pattern="^[1-9]\d*(\.\d+)?$"  placeholder="Rate" >
                    </div>
                </div>
            <?php  } ?>
            
            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-9 m-t-15">
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
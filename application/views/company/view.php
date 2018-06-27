
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-10">
        <h4 class="page-title">Company Profile</h4>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url() . 'company/'; ?>">Company</a>
            </li>
            <li class="active">
                View
            </li>
        </ol>
    </div>
</div>

<!-- Employee Details -->
<?php
$img_url = NODP;
if (isset($company_data["company_profileurl"]) && $company_data["company_profileurl"] != '') {
    $img_url = ASSETURL . 'company_data/' . $company_data["company_profileurl"];
} else {
    $img_url = ASSETURL . 'images/no-image.png';
}

/* $last_date =date("Y-m-d");
  if(isset($employee["emp_resign_date"]) && trim($employee["emp_resign_date"]) != '' && $employee["emp_resign_date"] != '0000-00-00'){
  $last_date = $employee['emp_resign_date'];
  }
  $date_diff = px_date_diff($employee['emp_join_date'],$last_date); */
?>
<div class="row">
    <div class="col-sm-5 col-md-4 col-lg-3">
        <div class="profile-detail card-box">
            <div>
                <img src="<?php echo $img_url; ?>" class="img-circle" alt="profile-image" style="height: 200px;width: 200px;object-fit: cover;">

                <ul class="list-inline status-list m-t-20">
                    
                </ul>

                <a href="<?php echo base_url() . 'company/edit/' . $company_data['company_uuid'] . '/' ?>" class="btn btn-pink btn-custom btn-rounded waves-effect waves-light">EDIT</a>

                <hr>
                <h4 class="text-uppercase font-600">About Owner</h4>

                <div class="text-left">
                    <p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15"><?php echo $user_data["user_firstname"] . ' ' . $user_data["user_lastname"]; ?></span></p>

                    <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15">+91 <?php echo $user_data["user_mobile"]; ?></span></p>

                    <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $user_data["user_email"]; ?></span></p>

                    <p class="text-muted font-13"><strong>Location :</strong> <span class="m-l-15">INDIA</span></p>
                </div>

            </div>

        </div>
    </div>


    <div class="col-lg-9">
        <ul class="nav nav-tabs tabs">
            <li class="active tab">
                <a href="#personalinfo" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Company Info</span> 
                </a> 
            </li> 
             <!--<li class="tab"> 
                <a href="#examinfo" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-user"></i></span> 
                    <span class="hidden-xs">Exam Info</span> 
                </a> 
            </li> 
            <li class="tab"> 
                <a href="#leaveinfo" data-toggle="tab" aria-expanded="true"> 
                    <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
                    <span class="hidden-xs">Progress Report</span> 
                </a> 
            </li> -->
        </ul> 
        <div class="tab-content"> 
            <div class="tab-pane active" id="personalinfo">                 
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Company Name</th>
                                <td><?php echo $company_data["company_name"]; ?></td>
                            </tr>
                            <tr>
                                <th>Jurician Name</th>
                                <td colspan="3"><?php echo $company_data["company_name_entity"]; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td colspan="3"><?php echo $company_data["company_mobile"]; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td colspan="3"><?php echo $company_data["company_email"]; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td colspan="3"><?php echo $company_data["company_address"];; ?></td>
                            </tr>
                            <tr>
                                <th>Pincode</th>
                                <td colspan="3"><?php echo $company_data["company_pincode"]; ?></td>
                            </tr>
                            <tr>
                                <th>Registration Date</th>
                                <td colspan="3"><?php echo $company_data["company_registrationdt"]; ?></td>
                            </tr>
                            <tr>
                                <th>State / City</th>
                                <td colspan="3"><?php echo $cities["city_state"]." - ".$cities["city_name"] ; ?></td>
                            </tr>
                            <tr>
                                <th>Pan Number</th>
                                <td colspan="3"><?php echo $company_data["company_pan"]; ?></td>
                            </tr>
                            <tr>
                                <th>Gstin Number</th>
                                <td><?php echo $company_data["company_gstin"]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
            <!--<div class="tab-pane" id="examinfo">
                <p><?php
//                    echo "<pre>";
//                    print_r($std_result_data);
                    ?>
                <table id="datatable-exam-result" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1"  style="width: 118px;">
                                Exam date
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1" style="width: 124px;">
                                Attendents
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1" style="width: 124px;">
                                Subject
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1" style="width: 124px;">
                                Chapter
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1"  style="width: 118px;">
                                Obtain Marks
                            </th>

                            <th class="sorting_asc" tabindex="0" aria-controls="datatable-exam-result" rowspan="1" colspan="1" style="width: 124px;">
                                Total Marks
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $table = "Result";
                        $orderby = "result_id";
                        foreach ($std_exam_data as $val) {
                            $where = array(
                                "std_id" => $student["std_id"],
                                "exam_id" => $val['exam_id']
                            );
                            $std_result_data = $this->common_px_mdl->get_orderby($table, $orderby, $where);
                            $obt_marks = ( $std_result_data ) ? $std_result_data[0]['result_added_marks'] : 0;

                            if ($std_result_data && ($obt_marks != "")) {
                                if ($obt_marks == "AB" || $obt_marks == "ab") {
                                    $obt_marks = "AB";
                                    $abs = "Absent";
                                } else {
                                    $abs = ($obt_marks == 0) ? "Absent" : "Present";
                                  
                                }
                                $color = ($obt_marks == 0) ? "#ec383e" : "";
                                ?>
                                <tr role="row" class="odd" >
                                    <td><?php echo $val['exam_date']; ?></td>
                                    <td style='background-color:<?php echo $color; ?>;color:#000;'><?php echo $abs; ?>
                                    </td> 
                                    <td><?php echo $val['exam_subject']; ?></td>
                                    <td><?php echo $val['exam_chapter']; ?></td>

                                    <td><?php echo $obt_marks; ?></td>    

                                    <td><?php echo $val['exam_total_marks']; ?></td>
                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
                </p> 
            </div> -->
            <div class="tab-pane" id="leaveinfo">
                <p>

                </p> 
            </div> 
        </div> 
    </div>

</div>

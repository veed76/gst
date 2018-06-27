<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="col-md-10">
            <h4 class="page-title">Companies</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'company'; ?>">companies</a>
                </li>
                <li class="active">
                    List
                </li>
            </ol>
        </div>
    </div>
</div>

<!-- Employee list -->
<div class="row company_listing">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="row margin_bottom_cls">
                <div class="col-md-2">
                    <button class="form-control btn btn-primary waves-effect waves-light remove" value="1"  disabled><i class="fa fa-trash-o "></i> Remove </button>
                </div>
                
                <div class="col-md-2 col-md-offset-8" align="right">
                    <a class="btn btn-primary" href="<?php echo base_url() . 'company/new_add'; ?>"><i class="fa fa-plus "></i> Add Company </a>
                </div>
                <div class="col-md-12"></div>
            </div>
            <table id="company_table_data" class="table table-striped table-bordered table-actions-bar student_data_tbl">
                <thead class="th_cls">
                    <tr>
                        <th style="width: 1px;">
                            Select
                            <div class="checkbox"><input id="select_all_chk_box" type="checkbox"/><label for="select_all_chk_box"></label></div>

                        </th>
                        <th>Company Name</th>
                       <!-- <th>Branch Name</th>
                        <th>Sole Proprietor</th> -->
                        <th>Pan Number</th>
                       <!-- <th>State / City</th> -->
                        <th>Mobile</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!--   -->
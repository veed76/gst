<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale extends CI_Controller {
	function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('logged_in') !=TRUE) {
            redirect('/login','refresh');
        }
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
    }
	public function index() {
            $data = array();
            $data['active'] = array("sales","wholesale");
            $this->load->view("common/header", $data);
            $this->load->view("wholesale/list");
            $this->load->view("common/footer", $data);
    }
    public function new_edit_common()
    {
        $user_uuid = $this->session->user_uuid;
        $table = "customer";
        $where =array(
            "customer_user_uuid"=>$user_uuid,
            "customer_status"=>"active"
        );
        $customer=$this->common_px_mdl->get($table,$where);

        $table = "company";
        $where =array(
            "company_user_uuid"=>$user_uuid,
        );
        $company_data=$this->common_px_mdl->get($table,$where);

        $table = "setting";
        $where = array(
            "setting_user_uuid" => $user_uuid,
            //"setting_type" => "dealer_tag"
        );
        $tags=$this->common_px_mdl->get($table,$where);
        $return_data["customer"]=$customer;
        $return_data["company_data"]=$company_data;
        $return_data["tags"]=$tags;
        return $return_data;
    }
    public function new_add() {
            $data = array();
            $data=$this->new_edit_common();
            $data['active'] = array("sales","wholesale");
            $data["html_form_id"]="new_wholesale_form";
            $data["html_action"]=base_url()."wholesale/new_add";

            $user_uuid = $this->session->user_uuid;

            /*$sql = "select wholesale_id from gst_wholesale_bill where wholesale_user_uuid = '$user_uuid' order by wholesale_id desc limit 0,1";
            $last_data=$this->common_px_mdl->query($sql)[0]['wholesale_id'];*/
            $flg=0;
            $flg2=0;
            
            foreach($data['tags'] as $key => $val)
            {
                if($val["setting_type"]=="invoice" && $flg==0)
                {
                    $inv = unserialize($val["setting_value_2"]);
                    $settin_invoice_uuid = $val["setting_uuid"];
                    $data['invoice_pat']=trim($inv[0]).trim($inv[1]);
                    $flg=1;
                    break;
                }
                /*else if($val["setting_type"]=="today_gold_price" && $flg2==0)
                {
                    $data['gold_price']=trim($val["setting_value_1"]);
                    $flg2=1;
                }
                else if($flg2==1 && $flg==1)
                        break;*/
            }
            $data['gold_price'] = 28800;

            $this->load->helper("form");
            $this->load->library("form_validation");

            //Set rules
            $this->form_validation->set_rules("invoice", "Invoive", "required");
            $this->form_validation->set_rules("reg_date", "Date", "required");
            $this->form_validation->set_rules("company", "Company", "required");
           // $this->form_validation->set_rules("gstin", "Gstin Number", "required");
            $this->form_validation->set_rules("customer_code", "Customer", "required");

            if ($this->form_validation->run() == FALSE) {
                //load page
                $this->load->view("common/header", $data);
                $this->load->view("wholesale/new_add",$data);
                $this->load->view("common/footer",$data);
            } else {

                //load

                $this->load->helper('string');
                $uuid = $this->uuid->v4();
                //Personal
               
                $comp_name = trim($this->input->post("company"));
                $invoice = trim($this->input->post("invoice"));
               /*$address = ucfirst(trim($this->input->post("address")));
                $mobile = ucfirst(trim($this->input->post("mobile")));
                $name = ucfirst(trim($this->input->post("name")));*/
                $customer_uuid = trim($this->input->post("customer_code"));
                $dealer_tag = trim($this->input->post("deal"));
                $registrationdt = $this->input->post("reg_date");
                $registrationdt = date("Y-m-d",strtotime($registrationdt));
                /*$state_code = trim($this->input->post("state"));
                $gstin = trim($this->input->post("gstin"));*/
                $cgst = trim($this->input->post("cgst"));
                $sgst = trim($this->input->post("sgst"));
                $igst = trim($this->input->post("igst"));

                
                $add_data_db = array();
                $table_field_prefix = "wholesale_";

                $add_data_db[$table_field_prefix."uuid"] = $uuid;
               /*$add_data_db[$table_field_prefix."name"] = $name;
                $add_data_db[$table_field_prefix."address"] = $address;
                $add_data_db[$table_field_prefix."mobile_no"] = $mobile;*/
                $add_data_db[$table_field_prefix."company_uuid"] = $comp_name;
                $add_data_db[$table_field_prefix."invoice_number"] = $invoice;
                /*$add_data_db[$table_field_prefix."state_code"] = $state_code;
                $add_data_db[$table_field_prefix."gst_number"] = $gstin;*/
                $add_data_db[$table_field_prefix."generatedt"] = $registrationdt;
                $add_data_db[$table_field_prefix."cgst"] = $cgst;
                $add_data_db[$table_field_prefix."sgst"] = $sgst;
                $add_data_db[$table_field_prefix."igst"] = $igst;
                $add_data_db[$table_field_prefix."dealer_tag"] = $dealer_tag;
                $add_data_db[$table_field_prefix."customer_uuid"] = $customer_uuid;
                $add_data_db[$table_field_prefix."user_uuid"] = $user_uuid;

                $table = "wholesale_bill";
                //p($add_data_db);
                $last_id=$this->common_px_mdl->insert($table, $add_data_db);
                if($last_id)
                {
                    $inv[1] = $inv[1] + 1;
                    $where = array(
                        "setting_uuid" => $settin_invoice_uuid
                    );
                    //p($inv);die;
                    $serialize=serialize($inv);
                    $data_setting["setting_value_2"]=$serialize;
                    $this->common_px_mdl->update("setting",$data_setting,$where);
                    $bills = $this->input->post("bill");
                    foreach($bills as $key => $val)
                    {
                        if($val['rate'] && $val['weight'])
                        {
                            $bill_uuid = $this->uuid->v4();
                            $add_data_db = array();
                            $table_field_prefix = "description_";
                            $add_data_db[$table_field_prefix."uuid"] = $bill_uuid;
                            $add_data_db[$table_field_prefix."wholesale_uuid"] = $uuid;
                            $add_data_db[$table_field_prefix."particular"] = ucfirst(trim($val['description']));
                            $add_data_db[$table_field_prefix."hsn_code"] = trim($val['hsn']);
                            $add_data_db[$table_field_prefix."weight"] = trim($val['weight']);
                            $add_data_db[$table_field_prefix."rate"] = trim($val['rate']);
                            $table = "bill_description";
                            $last_id=$this->common_px_mdl->insert($table, $add_data_db); 
                        }

                    }

                }
                redirect(base_url() . 'wholesale','refresh');
            }
    }
    public function edit($id) {
        $data = array();
        $data=$this->new_edit_common();

        $data['active'] = array("sales","wholesale");
        $data["html_form_id"]="edit_wholesale_form";
        $data["html_action"]=base_url()."wholesale/edit/".$id;

        $table = "wholesale_bill";
        $where =array(
            "wholesale_uuid"=>$id,
        );
        $data["wholesale_data"]=$this->common_px_mdl->get($table,$where)[0];
        
        $table = "bill_description";
        $where =array(
            "description_wholesale_uuid"=>$id,
        );
        $data["description_data"]=$this->common_px_mdl->get($table,$where);

        
        //Set rules
        $this->form_validation->set_rules("invoice", "Invoive", "required");
        $this->form_validation->set_rules("reg_date", "Date", "required");
        $this->form_validation->set_rules("company", "Company", "required");
        //$this->form_validation->set_rules("gstin", "Gstin Number", "required");
        $this->form_validation->set_rules("customer_code", "Customer", "required");

        if ($this->form_validation->run() == FALSE) {
            //load page
            $this->load->view("common/header", $data);
            $this->load->view("wholesale/edit",$data);
            $this->load->view("common/footer",$data);
        } else {
            $this->load->helper('string');

            $comp_name = trim($this->input->post("company"));
            $invoice = trim($this->input->post("invoice"));
            /*$address = ucfirst(trim($this->input->post("address")));
            $mobile = ucfirst(trim($this->input->post("mobile")));
            $name = ucfirst(trim($this->input->post("name")));*/
            $customer_uuid = trim($this->input->post("customer_code"));
            $dealer_tag = trim($this->input->post("deal"));
            $registrationdt = $this->input->post("reg_date");
            $registrationdt = date("Y-m-d",strtotime($registrationdt));
            /*$state_code = trim($this->input->post("state"));
            $gstin = trim($this->input->post("gstin"));*/
            $cgst = trim($this->input->post("cgst"));
            $sgst = trim($this->input->post("sgst"));
            $igst = trim($this->input->post("igst"));

            $add_data_db = array();
            $table_field_prefix = "wholesale_";

            //$add_data_db[$table_field_prefix."uuid"] = $uuid;
            /*$add_data_db[$table_field_prefix."name"] = $name;
            $add_data_db[$table_field_prefix."address"] = $address;
            $add_data_db[$table_field_prefix."mobile_no"] = $mobile;*/
            
            $add_data_db[$table_field_prefix."customer_uuid"] = $customer_uuid;
            $add_data_db[$table_field_prefix."company_uuid"] = $comp_name;
            $add_data_db[$table_field_prefix."invoice_number"] = $invoice;
            /*$add_data_db[$table_field_prefix."state_code"] = $state_code;
            $add_data_db[$table_field_prefix."gst_number"] = $gstin;*/
            $add_data_db[$table_field_prefix."generatedt"] = $registrationdt;
            $add_data_db[$table_field_prefix."cgst"] = $cgst;
            $add_data_db[$table_field_prefix."sgst"] = $sgst;
            $add_data_db[$table_field_prefix."igst"] = $igst;
            $add_data_db[$table_field_prefix."dealer_tag"] = $dealer_tag;

            $table = "wholesale_bill";
            $where = array(
                $table_field_prefix."uuid" => $id
            );
            $this->common_px_mdl->update($table, $add_data_db,$where);

            $bills = $this->input->post("bill");

            $table = "bill_description";
            $table_field_prefix = "description_";
            $where = array(
                $table_field_prefix."wholesale_uuid" => $id
            );
            $this->common_px_mdl->delete($table, $where);
            foreach($bills as $key => $val)
            {
                if($val['rate'] && $val['weight'])
                {
                    $bill_uuid = $this->uuid->v4();
                    $add_data_db = array();

                    $add_data_db[$table_field_prefix."particular"] = ucfirst(trim($val['description']));
                    $add_data_db[$table_field_prefix."hsn_code"] = trim($val['hsn']);
                    $add_data_db[$table_field_prefix."weight"] = trim($val['weight']);
                    $add_data_db[$table_field_prefix."rate"] = trim($val['rate']);
                    
                    /*if(!empty(trim($val['uuid'])))
                    {
                        $where = array(
                            $table_field_prefix."uuid" => trim($val['uuid'])
                        );
                        $this->common_px_mdl->update($table, $add_data_db,$where);
                    }else
                    {*/
                        $add_data_db[$table_field_prefix."uuid"] = $bill_uuid;
                        $add_data_db[$table_field_prefix."wholesale_uuid"] = $id;
                        $last_id=$this->common_px_mdl->insert($table, $add_data_db);
                    //}
                }

            }
            redirect(base_url() . '/wholesale','refresh');    
        }
    }
    public function remove(){
        $uuid = $this->input->post("code");
        $group = $this->input->post("group");
        $table_field_prefix = "wholesale_";
        $table = "wholesale_bill";
        if ($uuid != '' && $group == 0) {

            $add_data_db=[];
            $add_data_db[$table_field_prefix."status"] = 0;
            $where = array(
                $table_field_prefix."uuid" => $uuid
            );
            $this->common_px_mdl->update($table, $add_data_db,$where);
        } else if ($uuid != '' && $group == 1) {
            //$where = $uuid;
            $field = $table_field_prefix."uuid";

            $updateData = array();
            foreach($uuid as $key=>$value) {
             $updateData[] = array($field=>$value, $table_field_prefix."status"=>0);
            }
            $this->common_px_mdl->update_multiple($table, $updateData,$field);
        }
    }

    public function view_common($data_wholesale)
    {


        $table_field_prefix = "wholesale_";
        $table = "customer";
        $where = array(
            "customer_uuid" => $data_wholesale[$table_field_prefix."customer_uuid"]
        );
        $data["customer"]=$this->common_px_mdl->get($table,$where)[0];

        $table = "state";
        $where = array(
            "state_code" => $data["customer"]["customer_state"]
        );
        $data["state"]=$this->common_px_mdl->get($table,$where)[0]; 

        $table = "company";
        $where =array(
            "company_uuid"=>$data_wholesale[$table_field_prefix."company_uuid"],
        );
        $data["company_data"]=$this->common_px_mdl->get($table,$where)[0];

        $table = "setting";
        $where = array(
            "setting_user_uuid" => $this->session->user_uuid,
            "setting_type" => "dealer_tag",
            "setting_uuid" => $data_wholesale[$table_field_prefix."dealer_tag"],
        );
        $data['tags']=$this->common_px_mdl->get($table,$where)[0];

        $table = "bill_description";
        $where =array(
            "description_wholesale_uuid"=>$data_wholesale[$table_field_prefix."uuid"],
        );
        $data["description_data"]=$this->common_px_mdl->get($table,$where);
        
        return $data;
    } 
    //Edit employee page
    public function view($id) {
        $data = array();
        $data['active'] = array("sales","wholesale");
        
        $table = "wholesale_bill";
        $table_field_prefix = "wholesale_";
        $where = array(
            $table_field_prefix."uuid" => $id
        );

        $data_wholesale = $this->common_px_mdl->get($table, $where)[0];
        $data=$this->view_common($data_wholesale);
        $data["wholesale_data"]=$data_wholesale;

        $this->form_validation->set_rules("print_value", "name", "required");

        if ($this->form_validation->run() == FALSE) {
            $data["html_form_id"]="pdf_wholesale_form";
            $data["html_action"]=base_url()."wholesale/view/".$id;

            $this->load->view("common/header", $data);
            $this->load->view("wholesale/view", $data);
            $this->load->view("common/footer",$data);
        }else{
            $data["print_value"] = $this->input->post("print_value");
            $this->load->library("Pdf");
            //$this->load->view("common/header", $data);
            $this->load->view("wholesale/pdf", $data);
            //$this->load->view("common/footer",$data);
        }        

        
    }
    public function json() {

        $table = $this->db->dbprefix('wholesale_bill');
        $primaryKey = 'wholesale_uuid';
        $get = $_POST;
        $table_field_prefix = "wholesale_";

        $columns = array(
            array('db' => '`w`.`wholesale_uuid`', 'dt' =>  0 , 'field' => 'wholesale_uuid'),
            array('db' => '`w`.`wholesale_invoice_number`', 'dt' =>  1 , 'field' => 'wholesale_invoice_number'),
            array('db' => '`w`.`wholesale_generatedt`', 'dt' =>  2 , 'field' => 'wholesale_generatedt', 'formatter' => function( $d, $row ) {
                    return date('d-m-Y', strtotime($d));
                }),
            array('db' => '`c`.`company_name`', 'dt' =>  3 , 'field' => 'company_name'),
            array('db' => '`cust`.`customer_firstname`', 'dt' =>  4 , 'field' => 'customer_firstname'),
        );

        $sql_details = array(
            'user' => DBUSER,
            'pass' => DBPASSWD,
            'db' => DBNAME,
            'host' => HOST
        );
        

        $joinQuery = "FROM `gst_wholesale_bill` AS `w` INNER JOIN `gst_company` AS `c` ON `c`.`company_uuid` = `w`.`wholesale_company_uuid` INNER JOIN `gst_customer` AS `cust` ON w.wholesale_customer_uuid = cust.customer_uuid";
        $user_uuid = $this->session->user_uuid;
        $extraWhere = "`c`.`company_user_uuid` = '$user_uuid' and `w`.`wholesale_status` = 1 order by w.wholesale_id desc";
       // $extraWhere=NULL;
        $this->load->library('ssp');
        $groupBy = NULL;
        $having = NULL;
       
        echo json_encode(SSP::simple($get, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having ));
    }
}

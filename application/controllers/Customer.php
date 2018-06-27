<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
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
            $data['active'] = array("customer");
            $this->load->view("common/header", $data);
            $this->load->view("customer/list");
            $this->load->view("common/footer", $data);
    }
    public function new_add() {

            $data = array();
            $data['active'] = array("customer");
            $data["html_form_id"]="new_customer_form";
            $data["html_action"]=base_url()."customer/new_add";

            $table = "cities";
            $data["cities"]=$this->common_px_mdl->get($table);

            $this->load->helper("form");
            $this->load->library("form_validation");

            //Set rules
            $this->form_validation->set_rules("customer_fname", "First Name", "required");
            //$this->form_validation->set_rules("customer_mname", "Middle Name", "required");
            $this->form_validation->set_rules("customer_lname", "Last Name", "required");

            $this->form_validation->set_rules("gstin", "Gstin Number", "required");

            if ($this->form_validation->run() == FALSE) {
                //load page
                $this->load->view("common/header", $data);
                $this->load->view("customer/new_add",$data);
                $this->load->view("common/footer",$data);
            } else {

                $this->load->helper('string');
                $comp_uuid = $this->uuid->v4();
                //Personal
                $profile_url = "";
                $comp_fname = ucfirst(trim($this->input->post("customer_fname")));
                $comp_mname = ucfirst(trim($this->input->post("customer_mname")));
                $comp_lname = ucfirst(trim($this->input->post("customer_lname")));

                $address = ucfirst(trim($this->input->post("address")));
                $pincode = trim($this->input->post("pincode"));

                $mobile = trim($this->input->post("mobile"));
                $email = trim($this->input->post("email"));

                $state_city = trim($this->input->post("state"));
                $state = explode("-", $state_city)[1];
                $city = explode("-", $state_city)[0];
                $gstin = trim($this->input->post("gstin"));
                $pan = trim($this->input->post("pan"));

                $add_data_db = array();
                $table_field_prefix = "customer_";
                //upload profile
                $path = './assets/customer_data/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                //upload img
                $config['upload_path'] = './assets/customer_data/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|wmv';
                $config['max_size'] = 1000000;
                $this->load->library('upload', $config);
                if (isset($_FILES['profile'])) {
                    if ($this->upload->do_upload('profile')) {
                        $data = $this->upload->data();
                        $profile_url = $data['file_name'];
                        $add_data_db[$table_field_prefix."profileurl"] = $profile_url;
                    }
                }

                $add_data_db[$table_field_prefix."uuid"] = $comp_uuid;
                $add_data_db[$table_field_prefix."firstname"] = $comp_fname;
                $add_data_db[$table_field_prefix."middlename"] = $comp_mname;
                $add_data_db[$table_field_prefix."lastname"] = $comp_lname;
                $add_data_db[$table_field_prefix."address"] = $address;
                $add_data_db[$table_field_prefix."pincode"] = $pincode;
                $add_data_db[$table_field_prefix."email"] = $email;
                $add_data_db[$table_field_prefix."mobile"] = $mobile;
                $add_data_db[$table_field_prefix."state"] = $state;
                $add_data_db[$table_field_prefix."city"] = $city;
                $add_data_db[$table_field_prefix."gstin_number"] = $gstin;
                $add_data_db[$table_field_prefix."pan_number"] = $pan;
                $add_data_db[$table_field_prefix."user_uuid"] = $this->session->user_uuid;

                $table = "customer";
                //p($add_data_db);
                $this->common_px_mdl->insert($table, $add_data_db);
                redirect(base_url() . 'customer','refresh');
            }
    }
    public function edit($id) {
        $data = array();
        $data['active'] = array("customer");
        $data["html_form_id"]="edit_customer_form";
        $data["html_action"]=base_url()."customer/edit/".$id;
        $table = "customer";
        $table_field_prefix = "customer_";
        $where = array(
            $table_field_prefix.'uuid' => $id
        );
        $data["customer_data"]=$this->common_px_mdl->get($table, $where)[0];
        $table = "cities";
        $data["cities"]=$this->common_px_mdl->get($table);

        $this->form_validation->set_rules("customer_fname", "First Name", "required");
        //$this->form_validation->set_rules("customer_mname", "Middle Name", "required");
        $this->form_validation->set_rules("customer_lname", "Last Name", "required");

        $this->form_validation->set_rules("gstin", "Gstin Number", "required");

        if ($this->form_validation->run() == FALSE) {
            //load page
            $this->load->view("common/header", $data);
            $this->load->view("customer/edit",$data);
            $this->load->view("common/footer",$data);
        } else {
            $this->load->helper('string');
            //$comp_uuid = $this->uuid->v4();
            //Personal
            $profile_url = "";
			$comp_fname = ucfirst(trim($this->input->post("customer_fname")));
			$comp_mname = ucfirst(trim($this->input->post("customer_mname")));
			$comp_lname = ucfirst(trim($this->input->post("customer_lname")));
            $address = ucfirst(trim($this->input->post("address")));
            $pincode = trim($this->input->post("pincode"));
            $mobile = trim($this->input->post("mobile"));
            $email = trim($this->input->post("email"));
            $state_city = trim($this->input->post("state"));
            $state = explode("-", $state_city)[1];
            $city = explode("-", $state_city)[0];
            $gstin = trim($this->input->post("gstin"));
            $pan = trim($this->input->post("pan"));

            $add_data_db = array();
            $table_field_prefix = "customer_";
            //upload profile
            if (isset($_FILES['profile']) && isset($_FILES['profile']['tmp_name']))
            {
                $path = './assets/customer_data/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                //upload img
                $config['upload_path'] = './assets/customer_data/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|wmv';
                $config['max_size'] = 1000000;
                $this->load->library('upload', $config);
                if (isset($_FILES['profile'])) {
                    if ($this->upload->do_upload('profile')) {
                        $data = $this->upload->data();
                        $profile_url = $data['file_name'];
                        $add_data_db[$table_field_prefix."profileurl"] = $profile_url;
                    }
                }
            }
            
            $add_data_db[$table_field_prefix."firstname"] = $comp_fname;
            $add_data_db[$table_field_prefix."middlename"] = $comp_mname;
            $add_data_db[$table_field_prefix."lastname"] = $comp_lname;
            $add_data_db[$table_field_prefix."address"] = $address;
            $add_data_db[$table_field_prefix."pincode"] = $pincode;
            $add_data_db[$table_field_prefix."email"] = $email;
            $add_data_db[$table_field_prefix."mobile"] = $mobile;
            $add_data_db[$table_field_prefix."state"] = $state;
            $add_data_db[$table_field_prefix."city"] = $city;
            $add_data_db[$table_field_prefix."gstin_number"] = $gstin;
            $add_data_db[$table_field_prefix."pan_number"] = $pan;

            $table = "customer";
            //p($add_data_db);
            $where = array(
                $table_field_prefix."uuid" => $id
            );
            $this->common_px_mdl->update($table, $add_data_db,$where);
            redirect(base_url() . '/customer','refresh');    
        }
    }
    public function remove()
    {

        $uuid = $this->input->post("code");
        $group = $this->input->post("group");
        $table_field_prefix = "customer_";
        $table = "customer";
        if ($uuid != '' && $group == 0) {
            $where = array(
                $table_field_prefix."uuid" => $uuid
            );

            $add_data_db=[];
            $add_data_db[$table_field_prefix."status"] = "deactive";
        
            $this->common_px_mdl->update($table, $add_data_db,$where);
        } else if ($uuid != '' && $group == 1) {
            $field = $table_field_prefix."uuid";
            $updateData = array();
            foreach($uuid as $key=>$value) {
             $updateData[] = array($field=>$value, $table_field_prefix."status"=>"deactive");
            }
            //p($updateData);die;
            $this->common_px_mdl->update_multiple($table, $updateData,$field);
        }
    }
        //Edit employee page
    public function view($id) {
            $data = array();
            $data['active'] = array("customer");
            $table = "customer";
            $table_field_prefix = "customer_";
            $where = array(
                $table_field_prefix."uuid" => $id
            );
            $data["customer_data"] = $this->common_px_mdl->get($table, $where)[0];

            $table = "registration";
            $where = array(
                "user_uuid" => $data["customer_data"]["customer_user_uuid"]
            );
            $data["user_data"] = $this->common_px_mdl->get($table, $where)[0];

            $table = "cities";
            $where = array(
                "city_id" => $data["customer_data"]["customer_city"]
            );
            $data["cities"]=$this->common_px_mdl->get($table,$where)[0];
            $this->load->view("common/header", $data);
            $this->load->view("customer/view", $data);
            $this->load->view("common/footer",$data);
    }
    public function json() {

        $table = $this->db->dbprefix('customer');
        $primaryKey = 'customer_uuid';
        $get = $_GET;
        $table_field_prefix = "customer_";

        $columns = array(
            
            array('db' => $table_field_prefix.'uuid', 'dt' => $table_field_prefix.'uuid'),
            array('db' => $table_field_prefix.'profileurl', 'dt' => $table_field_prefix.'profileurl'),
            array('db' => $table_field_prefix.'firstname', 'dt' => $table_field_prefix.'firstname'),
            array('db' => $table_field_prefix.'email', 'dt' => $table_field_prefix.'email'),
            array('db' => $table_field_prefix.'gstin_number', 'dt' => $table_field_prefix.'gstin_number')
        );

        $sql_details = array(
            'user' => DBUSER,
            'pass' => DBPASSWD,
            'db' => DBNAME,
            'host' => HOST
        );
        
        $user_uuid=$this->session->user_uuid;
        $extraWhere = "`customer_user_uuid` = '$user_uuid' and customer_status = 'active' order by customer_createdt desc";
       // $extraWhere=NULL;
        $this->load->library('ssp');
        $joinQuery=$groupBy = NULL;
        $having = NULL;
       
        echo json_encode(SSP::simple($get, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having ));
    }
}

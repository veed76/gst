<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
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
            $data['active'] = array("company");
            $this->load->view("common/header", $data);
            $this->load->view("company/list");
            $this->load->view("common/footer", $data);
    }
    public function new_add() {

            $data = array();
            $data['active'] = array("company");
            $data["html_form_id"]="new_company_form";
            $data["html_action"]=base_url()."company/new_add";

            $table = "cities";
            $data["cities"]=$this->common_px_mdl->get($table);

            $this->load->helper("form");
            $this->load->library("form_validation");

            //Set rules
            $this->form_validation->set_rules("company_name", "Company Name", "required");
            $this->form_validation->set_rules("sole_proprietor", "Jurication Name", "required");
            $this->form_validation->set_rules("email", "E-mail", "required");
            $this->form_validation->set_rules("gstin", "Gstin Number", "required");

            if ($this->form_validation->run() == FALSE) {
                //load page
                $this->load->view("common/header", $data);
                $this->load->view("company/new_add",$data);
                $this->load->view("common/footer",$data);
            } else {

                //load

                $this->load->helper('string');
                $comp_uuid = $this->uuid->v4();
                //Personal
                $profile_url = "";
                $comp_name = ucfirst(trim($this->input->post("company_name")));
                //$branch_name = trim($this->input->post("branch_name"));
                $sole_proprietor = ucfirst(trim($this->input->post("sole_proprietor")));
                $address = ucfirst(trim($this->input->post("address")));
                $pincode = trim($this->input->post("pincode"));
                //$phone = trim($this->input->post("phone"));
                $mobile = trim($this->input->post("mobile"));
                $email = trim($this->input->post("email"));
                $registrationdt = $this->input->post("reg_date");
                $registrationdt = date("Y-m-d", strtotime($registrationdt));
                $state_city = trim($this->input->post("state"));
                $state = explode("-", $state_city)[1];
                $city = explode("-", $state_city)[0];
                //$city = trim($this->input->post("city"));
                $gstin = trim($this->input->post("gstin"));
                $pan = trim($this->input->post("pan"));

                $add_data_db = array();
                $table_field_prefix = "company_";
                //upload profile
                $path = './assets/company_data/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                //upload img
                $config['upload_path'] = './assets/company_data/';
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
                $add_data_db[$table_field_prefix."name"] = $comp_name;
                $add_data_db[$table_field_prefix."address"] = $address;
                $add_data_db[$table_field_prefix."pincode"] = $pincode;
                $add_data_db[$table_field_prefix."email"] = $email;
                //$add_data_db[$table_field_prefix."phone"] = $phone;
                $add_data_db[$table_field_prefix."mobile"] = $mobile;
                $add_data_db[$table_field_prefix."state"] = $state;
                $add_data_db[$table_field_prefix."city"] = $city;
                $add_data_db[$table_field_prefix."gstin"] = $gstin;
                $add_data_db[$table_field_prefix."registrationdt"] = $registrationdt;
                $add_data_db[$table_field_prefix."pan"] = $pan;
                $add_data_db[$table_field_prefix."name_entity"] = $sole_proprietor;
                //$add_data_db[$table_field_prefix."branch_name"] = $branch_name;
                $add_data_db[$table_field_prefix."user_uuid"] = $this->session->user_uuid;

                $table = "company";
                //p($add_data_db);
                $this->common_px_mdl->insert($table, $add_data_db);
                redirect(base_url() . '/company','refresh');
            }
    }
    public function edit($id) {
        $data = array();
        $data['active'] = array("company");
        $data["html_form_id"]="edit_company_form";
        $data["html_action"]=base_url()."company/edit/".$id;
        $table = "company";
        $table_field_prefix = "company_";
        $where = array(
            $table_field_prefix.'uuid' => $id
        );
        $data["company_data"]=$this->common_px_mdl->get($table, $where)[0];
        $table = "cities";
        $data["cities"]=$this->common_px_mdl->get($table);

        $this->form_validation->set_rules("company_name", "Company Name", "required");
        $this->form_validation->set_rules("sole_proprietor", "Jurication Name", "required");
        $this->form_validation->set_rules("email", "E-mail", "required");
        $this->form_validation->set_rules("gstin", "Gstin Number", "required");

        if ($this->form_validation->run() == FALSE) {
            //load page
            $this->load->view("common/header", $data);
            $this->load->view("company/edit",$data);
            $this->load->view("common/footer",$data);
        } else {
            $this->load->helper('string');
            //$comp_uuid = $this->uuid->v4();
            //Personal
            $profile_url = "";
            $comp_name = ucfirst(trim($this->input->post("company_name")));
            //$branch_name = trim($this->input->post("branch_name"));
            $sole_proprietor = ucfirst(trim($this->input->post("sole_proprietor")));
            $address = ucfirst(trim($this->input->post("address")));
            $pincode = trim($this->input->post("pincode"));
            //$phone = trim($this->input->post("phone"));
            $mobile = trim($this->input->post("mobile"));
            $email = trim($this->input->post("email"));
            $registrationdt = $this->input->post("reg_date");
            $registrationdt = date("Y-m-d", strtotime($registrationdt));

            $state_city = trim($this->input->post("state"));
            $state = explode("-", $state_city)[1];
            $city = explode("-", $state_city)[0];
            //$city = trim($this->input->post("city"));
            $gstin = trim($this->input->post("gstin"));
            $pan = trim($this->input->post("pan"));

            $add_data_db = array();
            $table_field_prefix = "company_";
            //upload profile
            if (isset($_FILES['profile']) && isset($_FILES['profile']['tmp_name']))
            {
                $path = './assets/company_data/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                //upload img
                $config['upload_path'] = './assets/company_data/';
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

            //$add_data_db[$table_field_prefix."uuid"] = $comp_uuid;
            $add_data_db[$table_field_prefix."name"] = $comp_name;
            $add_data_db[$table_field_prefix."address"] = $address;
            $add_data_db[$table_field_prefix."pincode"] = $pincode;
            $add_data_db[$table_field_prefix."email"] = $email;
            //$add_data_db[$table_field_prefix."phone"] = $phone;
            $add_data_db[$table_field_prefix."mobile"] = $mobile;
            $add_data_db[$table_field_prefix."state"] = $state;
            $add_data_db[$table_field_prefix."city"] = $city;
            $add_data_db[$table_field_prefix."gstin"] = $gstin;
            $add_data_db[$table_field_prefix."registrationdt"] = $registrationdt;
            $add_data_db[$table_field_prefix."pan"] = $pan;
            $add_data_db[$table_field_prefix."name_entity"] = $sole_proprietor;
            //$add_data_db[$table_field_prefix."branch_name"] = $branch_name;
            //$add_data_db[$table_field_prefix."user_uuid"] = $this->session->user_uuid;

            $table = "company";
            //p($add_data_db);
            $where = array(
                $table_field_prefix."uuid" => $id
            );
            $this->common_px_mdl->update($table, $add_data_db,$where);
            redirect(base_url() . '/company','refresh');    
        }
    }
    public function remove()
    {
        $uuid = $this->input->post("code");
        $group = $this->input->post("group");
        $table_field_prefix = "company_";
        $table = "company";
        if ($uuid != '' && $group == 0) {
            $where = array(
                $table_field_prefix."uuid" => $uuid
            );
            $this->common_px_mdl->delete($table, $where);
        } else if ($uuid != '' && $group == 1) {
            $where = $uuid;
            $field = $table_field_prefix."uuid";
            $this->common_px_mdl->delete_multiple($table, $where, $field);
        }
    }
        //Edit employee page
    public function view($id) {
            $data = array();
            $data['active'] = array("company");
            $table = "company";
            $table_field_prefix = "company_";
            $where = array(
                $table_field_prefix."uuid" => $id
            );
            $data["company_data"] = $this->common_px_mdl->get($table, $where)[0];

            $table = "registration";
            $where = array(
                "user_uuid" => $data["company_data"]["company_user_uuid"]
            );
            $data["user_data"] = $this->common_px_mdl->get($table, $where)[0];

            $table = "cities";
            $where = array(
                "city_id" => $data["company_data"]["company_city"]
            );
            $data["cities"]=$this->common_px_mdl->get($table,$where)[0];
            $this->load->view("common/header", $data);
            $this->load->view("company/view", $data);
            $this->load->view("common/footer",$data);
    }
    public function json() {

        $table = $this->db->dbprefix('company');
        $primaryKey = 'company_uuid';
        $get = $_GET;
        $table_field_prefix = "company_";

        $columns = array(
            
            array('db' => $table_field_prefix.'uuid', 'dt' => $table_field_prefix.'uuid'),
            array('db' => $table_field_prefix.'name', 'dt' => $table_field_prefix.'name'),
            /*array('db' => $table_field_prefix.'branch_name', 'dt' => $table_field_prefix.'branch_name'),
            array('db' => $table_field_prefix.'name_entity', 'dt' => $table_field_prefix.'name_entity'),*/
            array('db' => $table_field_prefix.'pan', 'dt' => $table_field_prefix.'pan'),
            array('db' => $table_field_prefix.'mobile', 'dt' => $table_field_prefix.'mobile'),
            array('db' => $table_field_prefix.'state', 'dt' => $table_field_prefix.'state'),
            array(
                'db' => $table_field_prefix.'registrationdt',
                'dt' => $table_field_prefix.'registrationdt',
                'formatter' => function( $d, $row ) {
                    return date('d-m-Y', strtotime($d));
                }
            ),
            array('db' => $table_field_prefix.'city', 'dt' => $table_field_prefix.'city')
        );

        $sql_details = array(
            'user' => DBUSER,
            'pass' => DBPASSWD,
            'db' => DBNAME,
            'host' => HOST
        );
        
        $user_uuid=$this->session->user_uuid;
        $extraWhere = "`company_user_uuid` = '$user_uuid' order by company_createdt desc";
       // $extraWhere=NULL;
        $this->load->library('ssp');
        $joinQuery=$groupBy = NULL;
        $having = NULL;
       
        echo json_encode(SSP::simple($get, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having ));
    }
}

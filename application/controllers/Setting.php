<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('logged_in') !=TRUE) {
            redirect('/login','refresh');
        }
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
    }
	public function index() 
    {
            $data = $this->all_common_table();
            $this->load->view("common/header", $data);
            $this->load->view("setting/setting",$data);
            $this->load->view("common/footer", $data);
    }

    public function all_common_table()
    {
        $data = array();
            $table = "setting";
            $table_field_prefix = "setting_";
            $where = array(
                $table_field_prefix."user_uuid" => $this->session->user_uuid,
                $table_field_prefix."type" => "invoice"
            );
            $data['invoice']=$this->common_px_mdl->get($table,$where)[0];

            $where = array(
                $table_field_prefix."user_uuid" => $this->session->user_uuid,
                $table_field_prefix."type" => "dealer_tag"
            );
            $data['tags']=$this->common_px_mdl->get($table,$where);
            return $data;
    }
    public function invoice() {
        //Set rules
        $this->form_validation->set_rules("invoice_str", "Invoice", "required");
        $this->form_validation->set_rules("invoice_digit", "Invoice", "required");

        $data = $this->all_common_table();
        if ($this->form_validation->run() == FALSE) {
            //load page
        } else {
            $table_field_prefix = "setting_";
            $this->load->helper('string');
            $table = "setting";
            $where = array(
                $table_field_prefix."user_uuid" => $this->session->user_uuid,
                $table_field_prefix."type" => "invoice"
            );
            $invoice[] = trim($this->input->post("invoice_str"));
            $invoice[] = trim($this->input->post("invoice_digit"));
            $add_data_db = array();
            $invoice_val = serialize($invoice);
            //p($this->common_px_mdl->get($table,$where));die;
            if($this->common_px_mdl->get($table,$where))
            {
                //echo $invoice;die;
                $add_data_db[$table_field_prefix."value_2"] = $invoice_val;
                $this->common_px_mdl->update($table, $add_data_db,$where);
            }
            else
            {
                $uuid = $this->uuid->v4();
                $add_data_db[$table_field_prefix."uuid"] = $uuid;
                $add_data_db[$table_field_prefix."value_1"] = $invoice_val;
                $add_data_db[$table_field_prefix."value_2"] = $invoice_val;
                $add_data_db[$table_field_prefix."type"] = "invoice";
                $add_data_db[$table_field_prefix."user_uuid"] = $this->session->user_uuid;
                $this->common_px_mdl->insert($table, $add_data_db);
            }
            $data = $this->all_common_table();
            $data['success'] = 'Invoice Successfully Update.';
            //redirect(base_url() . 'setting','refresh');
        }
        $this->load->view("common/header", $data);
        $this->load->view("setting/setting",$data);
        $this->load->view("common/footer",$data);
    }
    public function tags() {
        //Set rules
        $this->form_validation->set_rules("tag", "Dealer Tag", "required");
        $data = $this->all_common_table();
        if ($this->form_validation->run() == FALSE) {
            //load page
        } else {
            $table_field_prefix = "setting_";
            $this->load->helper('string');
            $table = "setting";
            
            $tag = trim($this->input->post("tag"));
            $add_data_db = array();
            
            $uuid = $this->uuid->v4();
            $add_data_db[$table_field_prefix."uuid"] = $uuid;
            $add_data_db[$table_field_prefix."value_1"] = $tag;

            $add_data_db[$table_field_prefix."type"] = "dealer_tag";
            $add_data_db[$table_field_prefix."user_uuid"] = $this->session->user_uuid;
            $this->common_px_mdl->insert($table, $add_data_db);
            $data = $this->all_common_table();
            $data['success'] = 'Tag Successfully Add.';
            //redirect(base_url() . 'setting','refresh');
        }
        $this->load->view("common/header", $data);
        $this->load->view("setting/setting",$data);
        $this->load->view("common/footer",$data);
    }
    public function changepassword() 
    {
        $this->form_validation->set_rules("old", "Old Password", "required");
        $data = $this->all_common_table();
        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view("common/header",$data);
            $this->load->view("setting/setting", $data);
            $this->load->view("common/footer",$data);
        } else {
            $data = array();
            $old = $this->input->post("old");
            $old = md5(trim($old));
            $new = $this->input->post("new");
            $new = md5(trim($new));
            $confirm = $this->input->post("confirm");

            $table_field_prefix = "user_";
            $table = "registration";
            $where = array(
                $table_field_prefix."uuid" => $this->session->user_uuid,
                $table_field_prefix."password" => $old
            );

            if ($this->common_px_mdl->check_data($table, $where)) {
                if (!empty($confirm)) {
                    $data[$table_field_prefix."password"] = $new;
                    $where = array(
                        $table_field_prefix."uuid" => $this->session->user_uuid
                    );
                    if($this->common_px_mdl->update($table, $data, $where))
                        $data['success'] = 'Password Successfully Change.';
                }
            } else {
                $data['error'] = 'Please enter valid Old Password.';
            }
            $this->load->view("common/header",$data);
            $this->load->view("setting/setting", $data);
            $this->load->view("common/footer",$data);
        }
    }

    public function remove()
    {
        $uuid = $this->input->post("code");
        $group = $this->input->post("group");
        $table_field_prefix = "setting_";
        $table = "setting";
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
}

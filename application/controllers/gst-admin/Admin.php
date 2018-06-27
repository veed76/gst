<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
    }
	public function index() {
        if ($this->session->has_userdata('logged_in')) {
            redirect(ADMINURL.'user');
        }
        else
        {
            redirect('/adminLogin','refresh');
        }
    }
     public function login() {
        if ($this->session->has_userdata('logged_in')) {
            redirect(ADMINURL.'user');
        } else {
            $data["html_form_id"]="login_form";
            $data["html_action"]="adminLogin";

            //check validation
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('passwd', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view(ADMINVIEW.'login', $data);
            } else {
                $table = "registration";
                $where = array(
                    "user_email" => trim($this->input->post('email')),
                    "user_password" => md5(trim($this->input->post('passwd'))),
                    "user_status" => 0
                );

                if ($this->common_px_mdl->check_data($table, $where)) {
                    
                    $user_data = $this->common_px_mdl->get($table,$where);
                    $uuid = $user_data[0]["user_uuid"];
                    $session_data = array(
                        'logged_in' => TRUE,
                        'user_uuid' => $uuid
                    );
                    $this->session->set_userdata($session_data);
                    redirect(ADMINURL.'user');
                } else {
                    $data['error'] = 'Please enter valid Email-Id or Password.';
                    $this->load->view(ADMINVIEW.'login', $data);
                }
            }
        }
    }
    public function logout() {
        if ($this->session->has_userdata('logged_in')) {
            $this->session->unset_userdata('user_uuid');
            $this->session->unset_userdata('logged_in');
            redirect('/adminLogin');
        } else {
            redirect('/');
        }
    }
}

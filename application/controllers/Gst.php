<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
    }
    public function index() {

        if ($this->session->has_userdata('logged_in')) {
            redirect('/company');
        }
        else
        {
            redirect('/login','refresh');
        }
    }
    public function login() {
        if ($this->session->has_userdata('logged_in')) {
            redirect('/');
        } else {
            $data["html_form_id"]="login_form";
            $data["html_action"]=base_url()."login";

            //check validation
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('passwd', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login', $data);
            } else {
                $table = "registration";
                $where = array(
                    "user_email" => trim($this->input->post('email')),
                    "user_password" => md5(trim($this->input->post('passwd')))
                );

                if ($this->common_px_mdl->check_data($table, $where)) {
                    
                    $user_data = $this->common_px_mdl->get($table,$where);
                    $uuid = $user_data[0]["user_uuid"];
                    $session_data = array(
                        'logged_in' => TRUE,
                        'user_uuid' => $uuid
                    );

                    $this->session->set_userdata($session_data);
                    redirect('/company');
                } else {
                    $data['error'] = 'Please enter valid Email-Id or Password.';
                    //login form
                    $this->load->view('login', $data);
                }
            }
        }
    }
    public function signup() {
        if ($this->session->has_userdata('logged_in')) {
            redirect('/');
        } else {
            $data["html_form_id"]="signup_form";
            $data["html_action"]=base_url()."signup";
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == FALSE){
                $this->load->view('signup',$data);
            } else {
                $password = md5(trim($this->input->post('password')));
                $email = trim($this->input->post('email'));
                $firstname = trim($this->input->post('firstname'));
                $table = "registration";
                $uuid = $this->uuid->v4();
                $where = array(
                    "user_email" => $email,
                );
                if ($this->common_px_mdl->check_data($table, $where)) {
                    $data['error'] = 'This Email-Id Already Registered...!';
                    $this->load->view('signup', $data);
                }else
                {
                    $data_insert = array(
                        "user_email" => $email,
                        "user_password" => $password,
                        "user_firstname" => $firstname,
                        "user_uuid" => $uuid,
                    );
                    if($this->common_px_mdl->insert($table,$data_insert))
                    {
                        $session_data = array(
                            'logged_in' => TRUE,
                            'user_uuid' => $uuid
                        );
                        $this->session->set_userdata($session_data);
                        redirect('/company');
                    }

                }
            }
        }
    }
    public function recoverPassword() {
        if ($this->session->has_userdata('logged_in')) {
            redirect('/');
        } else 
        {
            $data=array();
            $data["html_form_id"]="recover_form";
            $data["html_action"]=base_url()."recoverPassword";
            $this->form_validation->set_rules('email', 'Email', 'required');

            if ($this->form_validation->run() == FALSE){
            } else {

                $email = trim($this->input->post('email'));
                $table = "registration";
                $where = array(
                    "user_email" => $email,
                );
                $check=$this->common_px_mdl->check_data($table, $where);
            
                if ($check) {
                    $data_update=array();
                    $uuid = $this->uuid->v4();
                    $data_update["user_forgot_password"] = $uuid;

                    if($this->common_px_mdl->update($table,$data_update,$where))
                    {

                        $subject = "Forget Password";
                        $link = BASEURL."recoverLink/".$uuid;
                        $name = $check[0]["user_firstname"];
                        $sms = $this->emailtemplate($name,$link);
                        if($this->sendmail($email,$sms,$subject))
                            $data['success'] = 'Please Check Your Email.';
                    }
                }else
                {
                     $data['error'] = 'Sorry Email-Id Not Exists...!';
                }
            }
            $this->load->view('recover_password',$data);;
        }
    }
    public function sendmail($email,$sms,$subject)
    {
        //error_reporting(-1);
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: chitaliyamanan@gmail.com' . "\r\n";
$mail = mail($email,$subject,$sms,$headers);
/*
        $this->load->library("Phpmailerlib");

        $mail = new PHPMailer;

        $mail->isSMTP();

        $mail->SMTPDebug = 4;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "vishalgohil323@gmail.com";

        //Password to use for SMTP authentication
        $mail->Password = "jesu@76veed";

        //Set who the message is to be sent from
        $mail->setFrom('officialgohil@gmail.com', 'GstBill');

        //Set an alternative reply-to address
        $mail->addReplyTo('officialgohil@gmail.com', 'GstBill');

        //Set who the message is to be sent to
        $mail->addAddress($email, 'GstBill');

        //Set the subject line
        $mail->Subject = $subject;

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $message=$sms;
        $mail->msgHTML($message, dirname(__FILE__));

        //Replace the plain text body with one created manually
        $mail->AltBody = 'GstBill';

        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if ($mail->send()) */
        if ($mail) 
        {

            return true;
        } 
        else
        {
            return false;
        }
    }
    ///4d9ab46d-b1a7-4a7c-95f5-b5287faa0bad
    public function recoverLink($reset_uuid)
    {
        if ($this->session->has_userdata('logged_in') || empty($reset_uuid)) {
            redirect('/');
        } else 
        {
            $table = "registration";
            $where = array(
                "user_forgot_password" => $reset_uuid,
            );
            if ($this->common_px_mdl->check_data($table, $where)) {
                $data=array();
                $data["html_form_id"]="recover_link_form";
                $data["html_action"]=base_url()."recoverLink/".$reset_uuid;
                $this->form_validation->set_rules('new', 'New Password', 'required');
                $this->form_validation->set_rules('confirm', 'Confirm Password', 'required');

                if ($this->form_validation->run() == FALSE){
                } 
                else {
                    $new = md5(trim($this->input->post('new')));

                    $data_update=array();
                    $data_update["user_forgot_password"] = "";
                    $data_update["user_password"] = $new;
                    $this->common_px_mdl->update($table,$data_update,$where);
                    $data['success'] = 'Password Successfully Change';
                }
                $this->load->view('recover_link',$data);
            }
            else
                redirect('/');
        }
    }
    public function logout() {
        if ($this->session->has_userdata('logged_in')) {
            $this->session->unset_userdata('user_uuid');
            $this->session->unset_userdata('logged_in');
            redirect('/login/');
        } else {
            redirect('/');
        }
    }

    public function emailtemplate($name,$link)
    {
        $html = <<<EOF
        <html>
<head>
<title>Set up a new password </title>
</head>

<body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6">
    <style type="text/css">
        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            line-height: 1.4;
            background-color: #F2F4F6;
            color: #74787E;
            -webkit-text-size-adjust: none;
        }
        
        @media only screen and (max-width: 600px) {
            .email-body_inner {
                width: 100% !important;
            }
            .email-footer {
                width: 100% !important;
            }
        }
        
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
    <span class="preheader" style="box-sizing: border-box; display: none !important; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; mso-hide: all; opacity: 0; overflow: hidden; visibility: hidden;">Use this link to reset your password. The link is only valid for 24 hours.</span>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">

        <tr>
            <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">
                    <tr>
                        <td class="content-cell" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                            <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Hi $name,</h1>
                            <p style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">You recently requested to reset your password . Use the button below to reset it.
                                <strong style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">This password reset is only valid for the next 24 hours.</strong>
                            </p>
                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
                                <tr>
                                    <td align="center" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
                                            <tr>
                                                <td align="center" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                    <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
                                                        <tr>
                                                            <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                                <a href="$link" class="button button--green" target="_blank" style="-webkit-text-size-adjust: none; background: #22BC66; border-color: #22bc66; border-radius: 3px; border-style: solid; border-width: 10px 18px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); box-sizing: border-box; color: #FFF; display: inline-block; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; text-decoration: none;">Reset your password</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
EOF;
return $html;
    }
}

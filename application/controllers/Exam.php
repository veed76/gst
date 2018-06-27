<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends CI_Controller {

    //List employee
    public function index() {
        if ($this->session->has_userdata('logged_in')) {
            $arr = array();
            $arr['active'] = array("exam", "exam_all");
            $this->load->view("common/header", $arr);
            $this->load->view("exam/list");
            $this->load->view("common/footer");
        } else {
            redirect('/login');
        }
    }

    //Edit employee page
    public function edit($exam_id) {
        if ($this->session->has_userdata('logged_in')) {
            $arr = array();
            $arr['active'] = array("exam", "exam_edit");

            $this->load->helper("form");
            $this->load->library("form_validation");

            //Set rules
            $this->form_validation->set_rules("exam_date", "Date", "required");
            $this->form_validation->set_rules("standard", "Standard", "required");
            $this->form_validation->set_rules("faculty", "Faculty", "required");
            $this->form_validation->set_rules("total_marks", "Total Marks", "required");
            $this->form_validation->set_rules("subjects", "Subject", "required");

            $data = array();

            $table = "Exam";
            $where = array(
                "exam_id" => $exam_id
            );


            if ($this->form_validation->run() == FALSE) {
                $exam = $this->common_px_mdl->get($table, $where);
                $data["exam"] = $exam[0];
                $table = "Subject";
                $subject_data = $this->common_px_mdl->get($table);
                $data['subject'] = $subject_data;
                //load page
                $this->load->view("common/header", $arr);
                $this->load->view("exam/edit", $data);
                $this->load->view("common/footer");
            } else {
                $exam_date = $this->input->post("exam_date");
                $exam_date = date("Y-m-d", strtotime($exam_date));

                $standard = $this->input->post("standard");
                $faculty = $this->input->post("faculty");
                $total_marks = $this->input->post("total_marks");
                $status = $this->input->post("status");
                $subject = $this->input->post("subjects");
                $chapter = $this->input->post("chapter");



                //exam Data array
                $std_data = array();
                $std_data["exam_standard"] = $standard;
                $std_data["exam_total_marks"] = $total_marks;
                $std_data["exam_date"] = $exam_date;
                $std_data["exam_faculty"] = $faculty;
                $std_data["exam_status"] = $status;
                $std_data["exam_subject"] = $subject;
                $std_data["exam_chapter"] = $chapter;

                $this->common_px_mdl->update($table, $std_data, $where);

                redirect(base_url() . 'exam/');
            }
        } else {
            redirect('/');
        }
    }

    // Add Result
    public function add_result($exam_id) {

        if ($this->session->has_userdata('logged_in')) {
            $arr = array();
            $arr['active'] = array("exam", "exam_all");

            $this->load->helper("form");
            $this->load->library("form_validation");

            $this->form_validation->set_rules("total_marks", "Total Marks", "required");
            $data = array();
            $table = "Exam";
            $where = array(
                "exam_id" => $exam_id,
            );
            $exam = $this->common_px_mdl->get($table, $where);
            $table = "Student";
            $where = array(
                "std_standard" => $exam[0]["exam_standard"],
                "std_faculty" => $exam[0]["exam_faculty"]
            );
            $data["student"] = $this->common_px_mdl->get($table, $where);
            $data["exam"] = $exam[0];
            if ($this->form_validation->run() == FALSE) {
                //load page
                $this->load->view("common/header", $arr);
                $this->load->view("exam/add_result", $data);
                $this->load->view("common/footer");
            } else {
                //load
                $this->load->helper('string');

                $exam_total_mark = $exam[0]["exam_total_marks"];
                //Personal

                $success = "";
                $added_marks = $this->input->post("mark");
                $stud_id = $this->input->post("stud_id");

                $table_result = "Result";

                $i = 0;
                $flag_declare = 0;

                $absd = array("ab", "AB", "Ab");

                foreach ($stud_id as $val) {

                    if (in_array($added_marks[$i], $absd) || empty($added_marks[$i]) || (is_numeric($added_marks[$i]) && $added_marks[$i] <= $exam_total_mark)) {
                        $where = array(
                            "std_id" => $val,
                            "exam_id" => $exam_id
                        );
                        $std_result_data = $this->common_px_mdl->get($table_result, $where);

                        if ($std_result_data) {
                            $where_result = array(
                                "result_id" => $std_result_data[0]['result_id'],
                            );
                            $result_up_data = array();
                            $result_up_data["result_added_marks"] = $added_marks[$i];
                            $success = $this->common_px_mdl->update($table_result, $result_up_data, $where_result);
                            $flag_declare++;
                        } else {

                            if (in_array($added_marks[$i], $absd) || $added_marks[$i] <= $exam_total_mark) {
                                $result_id = $this->uuid->v4();
                                $std_data = array();
                                $std_data["exam_id"] = $exam_id;
                                $std_data["result_id"] = $result_id;
                                $std_data["std_id"] = $val;
                                $std_data["result_added_marks"] = $added_marks[$i];
                                $table = "Result";
                                $success = $this->common_px_mdl->insert($table, $std_data);
                                $flag_declare++;
                            }
                        }
                    }
                    $i++;
                }

                $table_result = "Result";
                $where_result = array(
                    "result_added_marks" => ""
                );
                $this->common_px_mdl->delete($table_result, $where_result);

                $where_result = array();
                $where_result = array(
                    "exam_id" => $exam_id
                );
                $std_result_data = $this->common_px_mdl->get($table_result, $where_result);

                $res_count = count($std_result_data);

                if ($success || $res_count >= 0) {
                    $table_exam = "Exam";
                    $where_exam = array(
                        "exam_id" => $exam_id
                    );

                    $exam_data = array();
                    $exam_data["exam_num_result"] = $res_count;
                    $exam_data["exam_result_declare"] = "not_declare";
                    $this->common_px_mdl->update($table_exam, $exam_data, $where_exam);
                }
                redirect(base_url() . 'exam/');
            }
        } else {
            redirect('/');
        }
    }

    //Remove Employee
    function remove() {
        $exam_code = trim($this->input->post("code"));
        if ($exam_code != '') {
            $table = "Exam";
            $where = array(
                "exam_id" => $exam_code
            );
            $this->common_px_mdl->delete($table, $where);
        }
    }

    //Get All data
    public function json() {

        $table = $this->db->dbprefix('Exam');
        $primaryKey = 'exam_id';
        $get = $_GET;

        $columns = array(
            array(
                'db' => 'exam_date',
                'dt' => "exam_date",
                'formatter' => function( $d, $row ) {
                    return date('d-m-Y', strtotime($d));
                }
            ),
            array('db' => 'exam_id', 'dt' => "exam_id"),
            array('db' => 'exam_standard', 'dt' => "exam_standard"),
            array('db' => 'exam_faculty', 'dt' => "exam_faculty"),
            array('db' => 'exam_total_marks', 'dt' => "exam_total_marks"),
            array('db' => 'exam_subject', 'dt' => "exam_subject"),
            array('db' => 'exam_chapter', 'dt' => "exam_chapter"),
            array('db' => 'exam_num_result', 'dt' => "exam_num_result"),
            array('db' => 'exam_result_declare', 'dt' => "exam_result_declare"),
        );
        //
        $sql_details = array(
            'user' => DBUSER,
            'pass' => DBPASSWD,
            'db' => DBNAME,
            'host' => HOST
        );
        $this->load->library('ssp');
        $table_setting = "Setting";
        $std_data_setting = $this->common_px_mdl->get($table_setting);
        $df_year = $std_data_setting[0]["default_year"];
        $to_year = $std_data_setting[0]["to_year"];

        $where = "YEAR(exam_date) = $df_year or YEAR(exam_date) = $to_year order by exam_date desc";
        //SELECT * FROM `School_Exam` WHERE YEAR(exam_create_dt) = 2016
        $data = $this->ssp->complex($get, $sql_details, $table, $primaryKey, $columns, $where);

        echo json_encode($data);
    }

    public function exams_add() {

        if ($this->session->has_userdata('logged_in')) {
            $arr = array();
            $arr['active'] = array("exam", "exam_add");

            $this->load->helper("form");
            $this->load->library("form_validation");

            //Set rules
            $this->form_validation->set_rules("exam_date", "Date", "required");
            $this->form_validation->set_rules("standard", "Standard", "required");
            $this->form_validation->set_rules("faculty", "Faculty", "required");
            $this->form_validation->set_rules("total_marks", "Total Marks", "required");
            $this->form_validation->set_rules("chapter", "Chapter", "required");
            $this->form_validation->set_rules("subjects", "Subject", "required");

            $data = array();
            $table = "Subject";
            $subject_data = $this->common_px_mdl->get($table);

            $data["subject"] = $subject_data;
            if ($this->form_validation->run() == FALSE) {
                //load page
                $this->load->view("common/header", $arr);
                $this->load->view("exam/exams", $data);
                $this->load->view("common/footer");
            } else {
                //load
                $this->load->helper('string');

                $exam_id = $this->uuid->v4();
                //Personal
                $exam_date = $this->input->post("exam_date");
                $exam_date = date("Y-m-d", strtotime($exam_date));

                $standard = $this->input->post("standard");
                $faculty = $this->input->post("faculty");
                $total_marks = $this->input->post("total_marks");


                $subject = $this->input->post("subjects");
                $chapter = $this->input->post("chapter");
                $exam_id = $this->uuid->v4();

                //Exam Data array
                $std_data = array();
                $std_data["exam_id"] = $exam_id;
                $std_data["exam_standard"] = $standard;
                $std_data["exam_total_marks"] = $total_marks;

                $std_data["exam_date"] = $exam_date;

                $std_data["exam_faculty"] = $faculty;

                $std_data["exam_subject"] = $subject;
                $std_data["exam_chapter"] = $chapter;


                $table = "Exam";
                $this->common_px_mdl->insert($table, $std_data);

                redirect(base_url() . 'exam/exams_add');
            }
        } else {
            redirect('/');
        }
    }

    // send sms
    public function declare_result_sendmsg() {
        $exam_id = $this->input->post("code");

        $table_exam = "Exam";
        $where_exam = array(
            "exam_id" => $exam_id
        );
        $exam_data = $this->common_px_mdl->get($table_exam, $where_exam);

        $db_std_id = "";
        $count = count($exam_data);
        $data_json = array();
        if ($count >= 1) {

            $faculty = $exam_data[0]['exam_faculty'];
            $standard = $exam_data[0]['exam_standard'];
            $get = 'select * from ' . $this->db->dbprefix("Student") . " where std_faculty = '$faculty' and std_standard = '$standard'";
            $data = $this->common_px_mdl->query($get);
            $success = 0;
            foreach ($data as $stud_data) {
                if (strlen($stud_data['std_phone']) == 10) {

                    $table = "Result";
                    $where = array(
                        "exam_id" => $exam_id,
                        "std_id" => $stud_data['std_id']
                    );
                    $result_data = $this->common_px_mdl->get($table, $where);

                    if ($result_data) {
                        $ddt = date("d/m/Y", strtotime($exam_data[0]['exam_date']));
                        $subject = trim($exam_data[0]['exam_subject']);
                        $chapter = trim($exam_data[0]['exam_chapter']);
                        $total_marks = trim($exam_data[0]['exam_total_marks']);
                        $stud_name = trim($stud_data['std_firstname']);
                        $marks = trim($result_data[0]['result_added_marks']);
                        $standard = trim($stud_data['std_standard']);
                        if (is_numeric($marks)) {
                   $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળકને $ddt ના $subject વિષયના chapter : $chapter માં $total_marks માંથી $marks માર્ક્સ મેળવેલ છે.";
                            $this->common_px_mdl->send_message($stud_data['std_phone'], trim($message));
                            //echo $message ;die;
                            $success = 1;
                        } elseif ($marks == "AB" || $marks == "ab" || $mark == "Ab") {
                            $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળક $ddt ની પરીક્ષામાં ગેરહાજર હતો.";
                            $this->common_px_mdl->send_message($stud_data['std_phone'], trim($message));
                            $success = 1;
                        }
                    }
                }
            }
            if ($success == 1) {
                $exam_data = array();
                $exam_data["exam_result_declare"] = "declared";
                $this->common_px_mdl->update($table_exam, $exam_data, $where_exam);
                $data_json["message"] = "success";
            }
        } else {
            $data_json["message"] = "not_fount";
        }
        echo json_encode($data_json);
    }

    public function declare_single_result_sendmsg() {

        $exam_id = $this->input->post("exam_id");
        $mark = $this->input->post("mark");
        $stud_id = $this->input->post("stud_id");
        $total_mark_single = $this->input->post("total_mark_single");

        $table_exam = "Exam";
        $where_exam = array(
            "exam_id" => $exam_id
        );
        $exam_data = $this->common_px_mdl->get($table_exam, $where_exam);

        $table = "Result";
        $where = array(
            "exam_id" => $exam_id,
            "std_id" => $stud_id
        );
        $data = $this->common_px_mdl->get($table, $where);

        $count = count($data);
        $data_json = array();

        $get = 'select * from ' . $this->db->dbprefix("Student") . " where  std_id = '$stud_id' ";
        $stud_data = $this->common_px_mdl->query($get);

        $ddt = date("d/m/Y", strtotime($exam_data[0]['exam_date']));

        $standard = trim($stud_data[0]['std_standard']);
        $subject = trim($exam_data[0]['exam_subject']);
        $chapter = trim($exam_data[0]['exam_chapter']);

        $success = 0;
        if ($count >= 1) {
            if (strlen($stud_data[0]['std_phone']) == 10) {


                $total_marks = trim($exam_data[0]['exam_total_marks']);
                $stud_name = trim($stud_data[0]['std_firstname']);

                $marks = trim($data[0]['result_added_marks']);
                if (is_numeric($mark)) {
                    $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળકને $ddt ના $subject વિષયના chapter : $chapter માં $total_marks માંથી $mark માર્ક્સ મેળવેલ છે.";
                    $success = 1;
                } elseif ($mark == "AB" || $mark == "ab" || $mark == "Ab") {
                    $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળક $ddt ની પરીક્ષામાં ગેરહાજર હતો.";
                    $success = 1;
                }
            } else {
                $data_json["message"] = "msg_not_send";
            }
        } else {
            if (strlen($stud_data[0]['std_phone']) == 10) {
                if ($mark == "AB" || $mark == "ab" || $mark == "Ab") {
                    $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળક $ddt ની પરીક્ષામાં ગેરહાજર હતો.";
                    $success = 1;
                } elseif (is_numeric($mark) && $mark <= $total_mark_single) {
                    
                    $message = "ધોરણ $standard માં અભ્યાસ કરતા આપના બાળકને $ddt ના $subject વિષયના chapter : $chapter માં $total_mark_single માંથી $mark માર્ક્સ મેળવેલ છે.";
                    $success = 1;
                }
            }
        }

        if ($success == 1) {
            $this->common_px_mdl->send_message($stud_data[0]['std_phone'], trim($message));
            $data_json["message"] = "msg_send";
        } else
            $data_json["message"] = "msg_not_send";
        echo json_encode($data_json);
    }

}

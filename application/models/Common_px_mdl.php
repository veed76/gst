<?php

class Common_px_mdl extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->library("curl");
    }

    /* ---------- new ------------------ */

    //insert data
    public function insert($table, $data, $insert = 0) {
        if (!empty($data)) {
            $this->db->insert($this->db->dbprefix($table), $data);
            if ($insert == 1) {
                return $this->db->insert_id();
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    //Update Data
    public function update($table, $data, $where) {
        if (!empty($data)) {
            $this->db->update($this->db->dbprefix($table), $data, $where);
            return true;
        } else {
            return false;
        }
    }

    public function update_multiple($table, $data, $field) {
        if (!empty($data)) {
            $this->db->update_batch($this->db->dbprefix($table), $data, $field);
            return true;
        } else {
            return false;
        }
    }

    //Remove Data
    public function delete($table, $where) {
        if (!empty($where)) {
            $this->db->delete($this->db->dbprefix($table), $where);
            return true;
        } else {
            return false;
        }
    }

    //Remove multiple Data
    public function delete_multiple($table, $where_data, $field) {
        if (!empty($where_data)) {
            $this->db->where_in($field, $where_data)->delete($this->db->dbprefix($table));
            return true;
        } else {
            return false;
        }
    }

    //Get Data
    public function get($table, $where = array()) {
        if (!empty($where)) {
            $result = $this->db->get_where($this->db->dbprefix($table), $where);
            return $result->result_array();
        } else {
            $result = $this->db->get($this->db->dbprefix($table));
            return $result->result_array();
        }
    }

    public function get_multiple($table, $where_data, $field) {
        if (!empty($where)) {
            $result = $this->db->where_in($field, $where_data)->$this->db->dbprefix($table);
            return $result->result_array();
        }
    }

    public function get_orderby($table, $order_field, $where = array()) {
        if (!empty($where)) {
            $result = $this->db->order_by($order_field, 'DESC')->get_where($this->db->dbprefix($table), $where);
            return $result->result_array();
        } else {
            $result = $this->db->order_by($order_field, 'DESC')->get($this->db->dbprefix($table));
            return $result->result_array();
        }
    }

    //Check Data
    public function check_data($table, $where) {
        if (!empty($where)) {
            $result = $this->db->get_where($this->db->dbprefix($table), $where);
            return $result->result_array();
            if ($result->num_rows() > 0) {
                return true;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    //Count Data
    public function count_data($table, $where = array()) {
        if (!empty($where)) {
            $result = $this->db->get_where($this->db->dbprefix($table), $where);
            return $result->num_rows();
        } else {
            $result = $this->db->get($this->db->dbprefix($table));
            return $result->num_rows();
        }
    }

    //Run Direct query
    public function query($sql, $no_return = 0) {
        $result = $this->db->query($sql);
        if ($no_return == 0) {
            return $result->result_array();
        }
    }

    /* ---------- end ------------------ */

    //Send message
    public function send_message_telerival($to, $message) {
        $par = array(
            "content" => $message,
            "to_number" => "+91" . trim(strval($to), "+91")
        );
        $url = "https://api.telerivet.com/v1/projects/PJbf8a6019657c5709/messages/send";
        $data_string = json_encode($par);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_USERPWD, "7esjgasl5nmiq9aEnNfvN0zWzP7kT5lb:");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        if (ENVIRONMENT == 'development') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function send_message($phone,$msg) {
        
        //$msg=trim("ર શાળા fopen");
        $sender_id="RAMKAB";
        $user="9824659108";
        $pass="485bac9";
        $msg=trim($msg);
        $msg=str_replace(" ","+",$msg);
        $url = "http://sms.dealsms.co/api/sendmsg.php?user=$user&pass=$pass&sender=".$sender_id."&phone=".$phone."&text=".$msg."&priority=ndnd&stype=normal";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }

}
?>


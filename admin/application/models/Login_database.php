<?php

Class Login_database extends CI_Model {
    // Insert registration data in database
    public function register_user($data) {
      //  echo "<pre>";
      //  print_r($data);die;
    // Query to check whether username already exist or not
        $array = array('username' => $data['username']);
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($array);
        $query=$this->db->get();
      //  echo $this->db->last_query();
        if ($query->num_rows() == 0) {
    // Query to insert data in database
            $this->db->insert('users', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    // Read data using username and password
    public function login($data) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $query= $this->db->query($sql, array($data['username']));
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>
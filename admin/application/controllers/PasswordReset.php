<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PasswordReset extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load form helper library
        $this->load->helper('form');
        // Load form validation library
        $this->load->library('form_validation');
        // Load session library
        $this->load->library('session');
        // Load database
        $this->load->database();
       // $this->load->model('login_database');
    }
    public function index()
    {
        $success=true;
        $data=array();
        $msg="";
        if($_POST){
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules("password", "Password", 'trim|required|matches[conf_password]');
            $this->form_validation->set_rules("conf_password", "Confirm Password", 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg=validation_errors();
                $success=false;
            } else {
                $logged_id= $this->session->userdata('is_logged_id');
                $sql = "SELECT * FROM users WHERE id = ?";
                $query= $this->db->query($sql, $logged_id);
                    $result= $query->result();
                    if ($result) {
                        if (password_verify($this->input->post('old_password'), $result[0]->password))
                        {
                            $data = array(
                                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT, array('cost' => 10)),
                            );
                            $this->db->where('id',$logged_id);
                            $this->db->update('users', $data);
                            $msg=  'Password Changed Successfully !';
                            $success=true;

                        }
                        else
                        {
                            $msg=  'Wrong Old Password !';
                            $success=false;

                        }
                    }

            }
            unset ($_POST);
        }
        $data=array('msg'=>$msg);
        $this->load->view('header');
        $this->load->view('common/reset-password',$data);
        $this->load->view('footer');

    }
}

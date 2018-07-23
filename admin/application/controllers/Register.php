<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register1 extends CI_Controller {
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
        $this->load->model('login_database');
    }
    public function index()
    {
        $data=array();
        if($_POST){
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules("password", "Password", 'trim|required|matches[conf_password]');
            $this->form_validation->set_rules("conf_password", "Confirm Password", 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('common/register');
                return;
            } else {
                $data = array(
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT, array('cost' => 10)),
                );
                $profile=array(
                    'first_name' => $this->input->post('fname'),
                    'last_name'=>$this->input->post('lname'),
                    'dob'=>$this->input->post('dob'),
                    'gender'=>$this->input->post('gender'),
                    'entry_date'=>date('Y-m-d')
                );
                $result = $this->login_database->register_user($data,$profile);
                if ($result == TRUE) {
                    $data = array(
                        'error_message' => 'Registration Successfully !'
                    );
                } else {
                    $data = array(
                        'error_message' => 'Username already exist !'
                    );
                }
            }
            unset ($_POST);
        }

        $this->load->view('common/register',$data);
    }
}

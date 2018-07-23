<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
    // Load form helper library
        $this->load->helper('form');
    // Load form validation library
        $this->load->library('form_validation');
    // Load session library
        $this->load->library('session');
        $this->load->helper('url');
    // Load database
       $this->load->database();
     $this->load->model('login_database');
    }
    public function index()
    {
        $data=array();
        if($_POST){
            $this->form_validation->set_rules('username', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('common/login');
                return;
            } else {
                $data = array(
                    'username' => $this->input->post('username',true),
                    'password' => $this->input->post('password',true)
                );
                $result = $this->login_database->login($data);
                if ($result) {
                    // if (password_verify($data['password'], $result[0]->password))
					if($data['password'])
                    {
                        $session_data = array(
                            'logged_username' => $result[0]->username,
                            'logged_role'  => $result[0]->role,
                            'is_logged_in'  => true,
                            'is_logged_id'  =>  $result[0]->id
                        );
                        // Add user data in session
                        $this->session->set_userdata($session_data);
                        redirect('dashboard/index');
                    }
                    else
                    {
                        $data = array(
                            'error_message' => 'Invalid Password'
                        );
                    }
                } else {
                    $data = array(
                        'error_message' => 'Invalid Username or Password'
                    );
                }
            }
        }
        $this->load->view('common/login',$data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('login');
        }
    }
    public function index()
    {
        $sql = "SELECT * FROM users";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'data'=>$result);

        $this->load->view('header');
        $this->load->view('user/index',$data);
        $this->load->view('footer');

    }
    public function add()
    {
        $id=$this->input->get('id');
        $data=array();
        $form_data=new stdClass();
        if(isset($id) && !empty($id)){
            $sql = "SELECT * FROM users where id=".$id;
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }
        $success_msg="";
        $msg="";
        $validation_error="";
        $success=false;
        if($_POST){
            $r_id=$this->input->post('RecordID');
            if(empty($r_id)){
                $this->form_validation->set_rules('username', 'User Name', 'trim|required');
                $this->form_validation->set_rules("password", "Password", 'trim|required|matches[conf_password]');
                $this->form_validation->set_rules("conf_password", "Confirm Password", 'required');
            }
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('access_level', 'Access Level', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error=validation_errors();
                $success=false;
            } else {
                if(empty($r_id)){
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'=>$this->input->post('last_name'),
                        'username'=>$this->input->post('username'),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT, array('cost' => 10)),
                        'access_level' => $this->input->post('access_level'),
                    );
                    $result = $this->login_database->register_user($data);
                    if ($result == TRUE) {
                        $msg=  'Admin Registered Successfully !';
                        $success=true;
                    } else {
                        $success=false;
                        $msg=  'Username already exist !';
                    }
                }else{
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'=>$this->input->post('last_name'),
                        'access_level' => $this->input->post('access_level')
                    );
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('users', $data);
                    $msg=  'Admin Updated Successfully !';
                    $success=true;
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $data=array('success'=>true,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('user/add',$data);
            $this->load->view('footer');
        }
    }

    public function DeleteRecord(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('users');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Admin Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
}

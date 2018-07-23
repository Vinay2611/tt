<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {
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
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('login');
        }
    }
    public function index()
    {
        $sql = "SELECT * FROM content_page";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'data'=>$result);
        $this->load->view('header');
        $this->load->view('content/index',$data);
        $this->load->view('footer');
    }
    public function add()
    {
        $id=$this->input->get('id');
        $data=array();
        $form_data=new stdClass();
        if(isset($id) && !empty($id)){
            $sql = "SELECT * FROM content_page where id=".$id;
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }
        $success_msg="";
        $msg="";
        $validation_error="";
        $success=false;
        if($_POST){
            $r_id=$this->input->post('RecordID');
            $this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
            $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
            $this->form_validation->set_rules('active', 'Active', 'trim|required');
            $this->form_validation->set_rules('editordata', 'Page Text', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $validation_error=validation_errors();
                $success=false;
            } else {
                $data = array(
                    'page_name' => $this->input->post('page_name'),
                    'page_title' => $this->input->post('page_title'),
                    'active'=>$this->input->post('active'),
                    'page_text'=>$this->input->post('editordata')
                );

                if(empty($r_id)){
                    $this->db->insert('content_page', $data);
                    if ($this->db->affected_rows() > 0) {
                        $msg=  'Content Page Added Successfully !';
                        $success=true;
                    }else{
                        $msg=  'Please try again !';
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('content_page', $data);
                    $msg=  'Content Page Updated Successfully !';
                    $success=true;
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $data=array('success'=>true,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('content/add',$data);
            $this->load->view('footer');
        }
    }

    public function DeleteRecord(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('content_page');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Content Page Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
}

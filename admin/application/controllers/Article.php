<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {
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
        $sql = "SELECT * FROM article";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'data'=>$result);
        $this->load->view('header');
        $this->load->view('article/index',$data);
        $this->load->view('footer');
    }
    public function add()
    {
        $id=$this->input->get('id');
        $data=array();
        $form_data=new stdClass();
        if(isset($id) && !empty($id)){
            $sql = "SELECT * FROM article where id=".$id;
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }
        $success_msg="";
        $msg="";
        $validation_error="";
        $success=false;
        if($_POST){
            $r_id=$this->input->post('RecordID');
            $this->form_validation->set_rules('article_title', 'Article Title', 'trim|required');
            $this->form_validation->set_rules('article_date', 'Article Date', 'trim|required');
            $this->form_validation->set_rules('visible_in_front', 'Visible In Front', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $validation_error=validation_errors();
                $success=false;
            } else {
                $data = array(
                    'article_title' => $this->input->post('article_title'),
                    'article_date'=>$this->input->post('article_date'),
                    'visible_in_front'=>$this->input->post('visible_in_front'),
                    'article_text' => $this->input->post('editordata')
                );

                if(empty($r_id)){

                    $this->db->insert('article', $data);
                    if ($this->db->affected_rows() > 0) {
                        $msg=  'Article Added Successfully !';
                        $success=true;
                    }else{
                        $msg=  'Please try again !';
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('article', $data);
                    $msg=  'Article Updated Successfully !';
                    $success=true;
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $data=array('success'=>true,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('article/add',$data);
            $this->load->view('footer');
        }
    }

    public function DeleteRecord(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('article');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Article Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
}

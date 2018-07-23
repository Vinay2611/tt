<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
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
        $sql = "SELECT * FROM product";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'data'=>$result);
        $this->load->view('header');
        $this->load->view('product/index',$data);
        $this->load->view('footer');
    }
    public function add()
    {
        $id=$this->input->get('id');
        $data=array();
        $form_data=new stdClass();
        if(isset($id) && !empty($id)){
            $sql = "SELECT * FROM product where id=".$id;
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }
        $success_msg="";
        $msg="";
        $validation_error="";
        $success=false;
        if($_POST){
            $r_id=$this->input->post('RecordID');
            $this->form_validation->set_rules('product_title', 'Product Title', 'trim|required');
            $this->form_validation->set_rules('test_credits', 'Test Credits', 'trim|required');
            $this->form_validation->set_rules('free_credits', 'Free Credits', 'trim|required');
            $this->form_validation->set_rules('printed_certificates', 'Printed Certificates', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error=validation_errors();
                $success=false;
            } else {
                $data = array(
                    'product_title' => $this->input->post('product_title'),
                    'test_credits'=>$this->input->post('test_credits'),
                    'free_credits'=>$this->input->post('free_credits'),
                    'printed_certificates' => $this->input->post('printed_certificates'),
                    'price'=>$this->input->post('price'),
                    'upgrade_to'=>$this->input->post('upgrade_to'),
                    'upgrade_text'=>$this->input->post('editordata')
                );

                if(empty($r_id)){

                    $this->db->insert('product', $data);
                    if ($this->db->affected_rows() > 0) {
                        $msg=  'Product Added Successfully !';
                        $success=true;
                    }else{
                        $msg=  'Please try again !';
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('product', $data);
                    $msg=  'Product Updated Successfully !';
                    $success=true;
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $data=array('success'=>true,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('product/add',$data);
            $this->load->view('footer');
        }
    }

    public function DeleteRecord(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('product');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Product Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
}

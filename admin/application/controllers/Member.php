<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
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
        $sql = "SELECT * FROM member";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'data'=>$result);

        $this->load->view('header');
        $this->load->view('member/index',$data);
        $this->load->view('footer');

    }
    public function add()
    {
        $id=$this->input->get('id');
        $data=array();
        $form_data=new stdClass();
        if(isset($id) && !empty($id)){
            $sql = "SELECT * FROM member where id=".$id;
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
                $this->form_validation->set_rules("password", "Password", 'trim|required|matches[conf_password]');
                $this->form_validation->set_rules("conf_password", "Confirm Password", 'required');
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error=validation_errors();
                $success=false;
            } else {
                if(empty($r_id)){
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'=>$this->input->post('last_name'),
                        'email'=>$this->input->post('email'),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT, array('cost' => 10)),
                        'account_type' => $this->input->post('account_type'),
                        'created_on'=>date('Y-m-d H:i:s'),
                        'credits_remaining'=>0,
                        'certificates_remaining'=>0
                    );

                    $this->db->insert('member', $data);
                    if ($this->db->affected_rows() > 0) {
                        $msg=  'Member Registered Successfully !';
                        $success=true;
                    }else{
                        $msg=  'Please try again !';
                        $success=false;
                    }
                }else{
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'=>$this->input->post('last_name'),
                        'email'=>$this->input->post('email'),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT, array('cost' => 10)),
                        'account_type' => $this->input->post('account_type')
                    );
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('member', $data);
                    $msg=  'Member Updated Successfully !';
                    $success=true;
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $data=array('success'=>true,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('member/add',$data);
            $this->load->view('footer');
        }
    }

    public function DeleteRecord(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('member');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Member Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function addcredit()
    {
        $success_msg="";
        $msg="";
        $validation_error="";
        $success=false;

        if($_POST){
            $member_id=$this->input->post('RecordID');
            $credits=$this->input->post('credits');
            if(isset($member_id) && !empty($member_id)){
                $sql = "SELECT * FROM member where id=".$member_id;
                $query = $this->db->query($sql);
                if($query->num_rows()>0){
                    $form_data=$query->row();
                    $credits_remaining=intval($form_data->credits_remaining);
                    $new_credit=intval($credits)+$credits_remaining;
                    $data = array(
                        'credits_remaining' => $new_credit
                    );
                    $data2 = array(
                        'member_id' => $member_id,
                        'date'=>date('Y-m-d H:i:s'),
                        'narration'=>'Free Credits granted by admin : '.$credits ,
                        'credits'=>$credits
                    );

                    $this->db->insert('creditflow', $data2);

                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('member', $data);
                    $msg=  'Credit Updated Successfully !';
                    $success=true;
                }else{
                    $msg="Member Not Found for this id!";
                    $validation_error="";
                    $success=false;
                }
            }else{
                $msg="Member Not Found for this id!";
                $validation_error="";
                $success=false;
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'validation_msg'=>$validation_error);
            echo json_encode($data);die;
        }else{
            $id=$this->input->get('id');
            $sql = "SELECT * FROM member where id=".$id;
            $query = $this->db->query($sql);
            $form_data=$query->row();
            $c_balance=$form_data->credits_remaining;

            $sql2 = "SELECT * FROM creditflow where member_id='$id' order by `date` desc";
            $query2 = $this->db->query($sql2);
            $result2=$query2->result_array();
            $data=array('member_id'=>$id,'credit_balance'=>$c_balance,'data'=>$result2);
            if($id && !empty($id)){
            }else{
                $data=array();
            }
            $this->load->view('header');
            $this->load->view('member/addcredit',$data);
            $this->load->view('footer');
        }
    }
}

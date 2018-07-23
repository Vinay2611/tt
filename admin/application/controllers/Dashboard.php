<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->view('header');
        $this->load->view('index');
        $this->load->view('footer');
    }
}

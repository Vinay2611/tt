<?php

class Ckeditor extends CI_Controller {

    // extends CI_Controller for CI 2.x users

    public $data 	= 	array();

    public function __construct() {

        //parent::Controller();
        parent::__construct();

		$this->load->helper('ckeditor');


		//Ckeditor's configuration
		$this->data['ckeditor'] = array(

            //ID of the textarea that will be replaced
            'id' 	=> 	'content',
            'path'	=>	'plugins/ckeditor',

            //Optionnal values
            'config' => array(
                'toolbar' 	=> 	"Full", 	//Using the Full toolbar
                'width' 	=> 	"550px",	//Setting a custom width
                'height' 	=> 	'100px',	//Setting a custom height

            ),

            //Replacing styles from the "Styles tool"
            'styles' => array(

                //Creating a new style named "style 1"
                'style 1' => array (
                    'name' 		=> 	'Blue Title',
                    'element' 	=> 	'h2',
                    'styles' => array(
                        'color' 	=> 	'Blue',
                        'font-weight' 	=> 	'bold'
                    )
                ),

                //Creating a new style named "style 2"
                'style 2' => array (
                    'name' 	=> 	'Red Title',
                    'element' 	=> 	'h2',
                    'styles' => array(
                        'color' 		=> 	'Red',
                        'font-weight' 		=> 	'bold',
                        'text-decoration'	=> 	'underline'
                    )
                )
            )
        );

	}

    public function index() {

        $this->load->view('ckeditor', $this->data);

    }

    public function browse(){
        $this->load->view('common/browse');
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/emilia-server/index.php";
         if($this->session->userdata('level')!='member'){ 
        	redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('member/v_welcome');
    }

    public function add_device()
    {
        $this->load->view('member/v_add_device');
    }

    public function edit_device()
    {
        $this->load->view('member/v_edit_device');
    }

    public function oc_device()
    {
        $this->load->view('member/v_oc_device');
    }
}

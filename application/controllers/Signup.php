<?php
Class Signup extends CI_Controller{
    
    var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/emilia-server/index.php";
        if($this->session->userdata('email')){
            $level=$this->session->userdata('level');
            redirect($level.'/welcome/');
        }
    }

    function index() {
        $this->load->view('v_signup');
    }

    function proses() {                
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[4]|max_length[50]');
        $dob=$this->input->post('dob_year')."-".$this->input->post('dob_month')."-".$this->input->post('dob_day');
        if ($this->form_validation->run() == FALSE){
            $this->load->view('v_signup');
        }else{
            $params = array('email'=>  $this->input->post('email'));
            $data['user'] = json_decode($this->curl->simple_get($this->API.'/user',$params)); 
            if ($data['user']) {
                $this->session->set_flashdata('peringatan','Email telah digunakan, masukan id lain!');
                $this->load->view('v_signup');
            }else{
                $data = array(
                    'email'     =>  $this->input->post('email'),
                    'name'      =>  $this->input->post('name'),
                    'password'  =>  md5($this->input->post('password')),
                    'dob'       =>  $dob,
                    'action'    =>  'insert',
                    'level'     =>  0);
                    $insert =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10)); 
                    if($insert)
                    {
                        $this->session->set_flashdata('hasil','Insert Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Insert Data Gagal');
                    }
                    $this->load->view('v_signup');
            }
        } 
    }
}
?>
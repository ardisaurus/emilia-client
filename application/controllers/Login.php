<?php
Class Login extends CI_Controller{
    
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
        $this->load->view('v_login');
    }
    
    function proses() {        
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('v_login',$data);
            }else{
                $data = array(
                    'email'     =>  $this->input->post('email'),
                    'password'  =>  md5($this->input->post('password')),
                    'action'       =>  'auth');
                $respond = json_decode($this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                if(isset($respond[0]->status)){
                    if($respond[0]->status=="success"){
                        $params = array('email'=>  $this->input->post('email'));
                        $data = json_decode($this->curl->simple_get($this->API.'/user',$params)); 
                        $active=$data[0]->active;
                        if ($active==1) {
                            $this->session->set_userdata('email',$data[0]->email);
                            if ($data[0]->level==1) {
                                $level="admin";
                            }else{
                                $level="member";
                            }                            
                            $this->session->set_userdata('level',$level);
                            redirect($level.'/welcome/');
                        }else{
                            $this->session->set_flashdata('peringatan','Akun nonaktif!');
                        }   
                    }else{
                        $this->session->set_flashdata('peringatan','Kombinasi password dan username salah!');
                    }
                }else{
                    $this->session->set_flashdata('peringatan','Login Gagal');
                }
                redirect('login');
            }                
    }
    
    function forgotpassword() { 
        $this->load->view('v_forgot_password');
    }

    
    function forgotpasswordproses() {        
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('v_forgot_password',$data);
            }else{
                $data = array(
                    'email'     =>  $this->input->post('email'),
                    'action'       =>  'password');
                $respond = json_decode($this->curl->simple_post($this->API.'/reset', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                if($respond[0]->status=="success"){
                    $this->session->set_flashdata('peringatan','Periksa email anda untuk mendapatkan password baru!');
                	redirect('login');
                }else{
                    $this->session->set_flashdata('peringatan','Reset Gagal');
                	redirect('login/forgotpassword');
                }
            }                
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/emilia-server/index.php";
         if($this->session->userdata('level')!='admin'){ 
        	redirect('login');
        }
    }

	public function index() {
        $params = array('email'=>  $this->session->userdata('email'));
        $respond = json_decode($this->curl->simple_get($this->API.'/user',$params));
        $data['user'] = $respond->result;
        $this->load->view('admin/v_setting', $data);
	}

    function edit_email() {
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/setting');                     
        }else{
            $params = array('email'=>  $this->input->post('email'));
            $respond = json_decode($this->curl->simple_get($this->API.'/user',$params));
            $data['user'] = $respond->result;
            if ($data['user']) {
                $this->session->set_flashdata('peringatan','Email telah digunakan, masukan id lain!');
                redirect('admin/setting');
            }else{
                $data = array(  'email' => $this->session->userdata('email'), 
                                'new_email' => $this->input->post('email'),
                                'action' => "update", 
                                'part' => "email");
                    $update =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10));
                    $this->session->set_userdata('email', $this->input->post('email'));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                    redirect('admin/setting');
            }    
        }        
    }

    function edit_name() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[4]|max_length[50]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/setting');                      
        }else{
            $data = array(  'email' => $this->session->userdata('email'), 
                            'name' => $this->input->post('name'),
                            'action' => "update", 
                            'part' => "name");
            $update =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10));
            if($update){
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('admin/setting');                 
        }        
    }

    function edit_password() {
        $this->form_validation->set_rules('old_password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/setting');                      
        }else{
            $data_auth = array(
                    'email'     =>  $this->session->userdata('email'),
                    'password'  =>  md5($this->input->post('old_password')),
                    'action'    =>  'auth');
            $request = json_decode($this->curl->simple_post($this->API.'/user', $data_auth, array(CURLOPT_BUFFERSIZE => 10))); 
            $respond = $request->result;
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(  
                                'email' => $this->session->userdata('email'), 
                                'password' => md5($this->input->post('password')), 
                                'action' => "update", 
                                'part' => "password");
                    $update =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                }else{
                    $this->session->set_flashdata('peringatan','Kombinasi password dan username salah!');
                }
            }else{
                $this->session->set_flashdata('peringatan','Update Gagal');
            }
            redirect('admin/setting');           
        }        
    }

    function edit_dob() {        
        $dob=$this->input->post('dob_year')."-".$this->input->post('dob_month')."-".$this->input->post('dob_day');
        $data = array(  'email' => $this->session->userdata('email'), 
                        'dob' => $dob,
                        'action' => "update", 
                        'part' => "dob");
        $update =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10));
        if($update){
            $this->session->set_flashdata('hasil','Update Data Berhasil');
        }else{
            $this->session->set_flashdata('hasil','Update Data Gagal');
        }
        redirect('admin/setting');    
    }

    function delete() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/setting');                      
        }else{
            $respond = json_decode($this->curl->simple_get($this->API.'/user'));
            $data['all_user'] = $respond->result;
            $admin=0;
            foreach ($data['all_user'] as $n) {
                if ($n->level=="1") {
                    $admin++;
                }
            }
            if ($admin>1) {
                $data_auth = array(
                    'email'     =>  $this->session->userdata('email'),
                    'password'  =>  md5($this->input->post('password')),
                    'action'    =>  'auth');
                $request = json_decode($this->curl->simple_post($this->API.'/user', $data_auth, array(CURLOPT_BUFFERSIZE => 10)));
                $respond = $request->result; 
                if(isset($respond[0]->status)){
                    if($respond[0]->status=="success"){
                        $data = array('email' => $this->session->userdata('email'),
                                      'action' => "delete");
                        $delete =  $this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10));
                        if($delete){
                            $this->session->set_flashdata('hasil','Hapus Data Berhasil');
                            redirect("admin/setting/logout");
                        }else{
                            $this->session->set_flashdata('hasil','Hapus Data Gagal');
                        }
                        redirect('admin/setting');
                    }else{
                        $this->session->set_flashdata('peringatan','Kombinasi password dan username salah!');
                    }
                }else{
                    $this->session->set_flashdata('peringatan','Koneksi Gagal');
                }
                redirect('admin/setting');
            }else{
                $this->session->set_flashdata('peringatan',"Akun admin kurang dari 2!");
                redirect('admin/setting');
            }                             
        }        
    }

    function logout() {
        $this->session->unset_userdata('email');        
        $this->session->unset_userdata('level');
        redirect('login');
    }
}
?>
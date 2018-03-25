<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {

	var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/emilia-server/index.php";
         if($this->session->userdata('level')!='member'){ 
        	redirect('login');
        }
    }

    public function index() {
        $params = array('email'=> $this->session->userdata('email'));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_device_list', $data);
    }

    public function add_device() {
        $this->load->view('member/v_add_device');
    }

    public function process_add_device() {
        $this->form_validation->set_rules('dvc_id', 'Id Device', 'trim|required');
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/add_device');
        }else{
            $data = array(
                    'dvc_id'     =>  $this->input->post('dvc_id'),
                    'action'    =>  'id_check');
                $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                if(isset($respond[0]->status))
                {
                    if($respond[0]->status=="success")
                    {
                        $data = array(
                                'dvc_id'        =>  $this->input->post('dvc_id'),
                                'dvc_password'  =>  md5($this->input->post('dvc_password')),
                                'action'        =>  'auth');
                        $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                        if(isset($respond[0]->status)){
                            if($respond[0]->status=="success"){
                                $data = array(
                                    'own_dvc_id'    =>  $this->input->post('dvc_id'),
                                    'own_email'     =>  $this->session->userdata('email'),
                                    'action'        =>  'insert');
                                $insert =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                                if($insert){
                                    $this->session->set_flashdata('hasil','Insert Data Berhasil');
                                }else{
                                    $this->session->set_flashdata('hasil','Insert Data Gagal');
                                }
                                redirect('member/device/add_device');
                            }else{
                                $this->session->set_flashdata('peringatan','Kombinasi Salah');
                                redirect('member/device/add_device');
                            }
                        }else{
                            $this->session->set_flashdata('peringatan',"Kombinasi Salah!");
                            redirect('member/device/add_device');
                        }
                    }else{
                        $this->session->set_flashdata('peringatan','Id device tidak ditemukan');
                        redirect('member/device/add_device');
                    }
                }else{
                    $this->session->set_flashdata('peringatan','Id device tidak ditemukan');
                    redirect('member/device/add_device');
                }
        } 
    }

    public function edit_device() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_edit_device', $data);
    }

    function process_edit_name() {
        $this->form_validation->set_rules('dvc_name', 'Name', 'trim|required|min_length[4]|max_length[50]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/edit_device');                      
        }else{
            $data = array(  'dvc_id' => $this->input->post('dvc_id'), 
                            'dvc_name' => $this->input->post('dvc_name'),
                            'action' => "update", 
                            'part' => "name");
            $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('member/device/edit_device'); 
        }        
    }

    function process_delete() {
        if ($this->uri->segment(4)==$this->input->post('dvc_id')) {
            $data = array(  'dvc_id' => $this->input->post('dvc_id'),
                            'action' => "delete");
            $delete =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('member/device');
        }
        $this->session->set_flashdata('peringatan',"ID Salah!");
        redirect('member/device/edit_device/'.$this->input->post('dvc_id'));
    }

    public function process_edit_password() {
        $this->form_validation->set_rules('old_password', 'Old password', 'trim|required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password', 'New password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Confirm password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/edit_device/'.$this->input->post('dvc_id'));
        }else{
            $data = array(  'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password'  =>  md5($this->input->post('old_password')),
                            'action'        =>  'auth');
            $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(
                            'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password'  =>  md5($this->input->post('dvc_password')),
                            'part'          =>  'password',
                            'action'        =>  'update');
                    $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                    redirect('member/device/edit_device/'.$data['dvc_id']);
                }else{
                    $this->session->set_flashdata('peringatan','Password salah');
                    redirect('member/device/edit_device/'.$data['dvc_id']);
                }
            }else{
                $this->session->set_flashdata('peringatan',"Password Salah!");
                redirect('member/device/edit_device/'.$data['dvc_id']);
            }
        }
    }

    public function open_device() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_open_device', $data);
    }

    public function process_open_device() {
        $this->form_validation->set_rules('dvc_id', 'Id Device', 'trim|required');
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/open_device/'.$this->input->post('dvc_id'));
        }else{
            $data = array(  'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'auth');
            $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(
                            'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'unlock');
                    $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                    redirect('member/device');
                }else{
                    $this->session->set_flashdata('peringatan','Kombinasi salah');
                    redirect('member/device/open_device/'.$data['dvc_id']);
                }
            }else{
                $this->session->set_flashdata('peringatan',"Kombinasi Salah!");
                redirect('member/device/open_device/'.$data['dvc_id']);
            }
        }
    }

    public function close_device() {
        $data = array(
                        'dvc_id'        =>  $this->uri->segment(4),
                        'action'        =>  'unlock');
        $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
        if($update){
            $this->session->set_flashdata('hasil','Update Data Berhasil');
        }else{
            $this->session->set_flashdata('hasil','Update Data Gagal');
        }
        redirect('member/device');
    }
}
?>
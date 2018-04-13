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

// =========================== Primary Access
    // Primary access device list : Primary Access
    public function index() {
        $params = array('email'=> $this->session->userdata('email'));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_device_list', $data);
    }

    // Open add device form : Primary Access
    public function add_device() {
        $this->load->view('member/v_add_device');
    }

    // Add new device form : Primary Access
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

    // Open Edit form : Primary Access
    public function edit_device() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));

        $data2 = array(  'dvc_id'        =>  $this->uri->segment(4),
                         'action'        =>  'sc_check');
        $data['sckey'] = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data2, array(CURLOPT_BUFFERSIZE => 10)));

        $this->load->view('member/v_edit_device', $data);
    }

    // Open Forgot password form : Primary Access
    public function forgot_password() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_forgot_password_device', $data);
    }

    public function process_forgot_password() {
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password', 'New password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Confirm password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/forgot_password/'.$this->input->post('dvc_id'));
        }else{
            $data = array(  'email'        =>  $this->session->userdata('email'),
                            'password'      =>  md5($this->input->post('password')),
                            'action'        =>  'auth');
            $respond = json_decode($this->curl->simple_post($this->API.'/user', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(
                            'email'         =>  $this->session->userdata('email'),
                            'dvc_id'        =>  $this->input->post('dvc_id'),
                            'password'      =>  md5($this->input->post('password')),
                            'dvc_password'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'forgot_password');
                    $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                    redirect('member/device/forgot_password/'.$data['dvc_id']);
                }else{
                    $this->session->set_flashdata('peringatan','Password salah');
                    redirect('member/device/forgot_password/'.$data['dvc_id']);
                }
            }else{
                $this->session->set_flashdata('peringatan',"Password Salah!");
                redirect('member/device/forgot_password/'.$data['dvc_id']);
            }
        }
    }

    // Edit name process : Primary Access
    function process_edit_name() {
        $this->form_validation->set_rules('dvc_name', 'Name', 'trim|required|min_length[4]|max_length[50]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/edit_device/'.$this->input->post('dvc_id'));                      
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
            redirect('member/device/edit_device/'.$this->input->post('dvc_id')); 
        }        
    }

   // Edit Pessword process : Primary Access
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

   // Open add secondary key form : Primary Access
    public function add_sckey() {
        $data = array(  'dvc_id'        =>  $this->uri->segment(4),
                         'action'        =>  'sc_check');
        $sckey = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10)));
        if ($sckey[0]->status!='success') {
            $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
            $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
            $this->load->view('member/v_add_sckey', $data);
        }else{
            redirect('member/device/edit_device/'.$this->input->post('dvc_id'));
        }
    }

   // Add Secondary Pessword process : Primary Access
    public function process_add_password_sc() {
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
                            'dvc_password_sc'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'insert_sc_key');
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

   // Edit Secondary Pessword process : Primary Access
    public function process_edit_password_sc() {
        $this->form_validation->set_rules('old_password', 'Old password', 'trim|required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password', 'New password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Confirm password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/edit_device/'.$this->input->post('dvc_id'));
        }else{
            $data = array(  'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password_sc'  =>  md5($this->input->post('old_password')),
                            'action'        =>  'auth_sc');
            $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(
                            'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password_sc'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'insert_sc_key');
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

   // Remove Secondary Pessword process : Primary Access
    function remove_sckey() {
        $dvc_id=$this->uri->segment(4);
        $data = array(  'dvc_id' => $dvc_id,
                        'action' => "delete_sc_key");
        $delete =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
        if($delete)
        {
            $this->session->set_flashdata('hasil','Update Data Berhasil');
        }else{
            $this->session->set_flashdata('hasil','Update Data Gagal');
        }            
        redirect('member/device/edit_device/'.$dvc_id);
    }

   // Remove device process : Primary Access
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
        }else{
            $this->session->set_flashdata('peringatan',"ID Salah!");
            redirect('member/device/edit_device/'.$this->input->post('dvc_id'));
        }
    }

   // Open unlock device Form : Primary Access
    public function open_device() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4));
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_open_device', $data);
    }

   // Unlock device process : Primary Access
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
                            'email'=> $this->session->userdata('email'),
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

   // Open history list : Primary Access
    public function history() {
        $params = array('dvc_id'=> $this->uri->segment(4));
        $data['history'] = json_decode($this->curl->simple_get($this->API.'/accesshistory', $params));
        $this->load->view('member/v_history', $data);
    }

// =========================== Primary Access End 

    // Close device : Both Access
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

// =========================== Secondary Access

    // Secondary access device list : Secondary Access
    public function secondary() {
        $params = array('email'=> $this->session->userdata('email'), 'level'=> 1);
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_device_list_sc', $data);
    }

    // Add new secondary device : Secondary Access
    public function add_device_sc() {
        $this->load->view('member/v_add_device_sc');
    }

    // Process add secondary device : Secondary Access
    public function process_add_device_sc() {
        $this->form_validation->set_rules('dvc_id', 'Id Device', 'trim|required');
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/add_device_sc');
        }else{
            $data = array(
                    'dvc_id'     =>  $this->input->post('dvc_id'),
                    'action'    =>  'id_check_sc');
                $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                if(isset($respond[0]->status))
                {
                    if($respond[0]->status=="success")
                    {
                        $data = array(
                                'dvc_id'        =>  $this->input->post('dvc_id'),
                                'dvc_password_sc'  =>  md5($this->input->post('dvc_password')),
                                'action'        =>  'auth_sc');
                        $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
                        if(isset($respond[0]->status)){
                            if($respond[0]->status=="success"){
                                $data = array(
                                    'own_dvc_id'    =>  $this->input->post('dvc_id'),
                                    'own_email'     =>  $this->session->userdata('email'),
                                    'action'        =>  'insert_sc');
                                $insert =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                                if($insert){
                                    $this->session->set_flashdata('hasil','Insert Data Berhasil');
                                }else{
                                    $this->session->set_flashdata('hasil','Insert Data Gagal');
                                }
                                redirect('member/device/add_device_sc');
                            }else{
                                $this->session->set_flashdata('peringatan','Kombinasi Salah');
                                redirect('member/device/add_device_sc');
                            }
                        }else{
                            $this->session->set_flashdata('peringatan',"Kombinasi Salah!");
                            redirect('member/device/add_device_sc');
                        }
                    }else{
                        $this->session->set_flashdata('peringatan','Id device tidak ditemukan');
                        redirect('member/device/add_device_sc');
                    }
                }else{
                    $this->session->set_flashdata('peringatan','Id device tidak ditemukan');
                    redirect('member/device/add_device_sc');
                }
        } 
    }

    // Process Delete secondary device : Secondary Access
    function process_delete_sc() {
            $data = array(  'dvc_id' => $this->uri->segment(4),
                            'email'=> $this->session->userdata('email'),
                            'action' => "delete_sc");
            $delete =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('member/device/secondary');
    }


    // Open unlock secondary device form : Secondary Access
    public function open_device_sc() {
        $params = array('email'=> $this->session->userdata('email'), 'dvc_id'=> $this->uri->segment(4), 'level'=> 1);
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/memberdeviceman', $params));
        $this->load->view('member/v_open_device_sc', $data);
    }


    // Process unlock secondary device : Secondary Access
    public function process_open_device_sc() {
        $this->form_validation->set_rules('dvc_id', 'Id Device', 'trim|required');
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('member/device/open_device/'.$this->input->post('dvc_id'));
        }else{
            $data = array(  'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password_sc'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'auth_sc');
            $respond = json_decode($this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if(isset($respond[0]->status)){
                if($respond[0]->status=="success"){
                    $data = array(
                            'email'=> $this->session->userdata('email'),
                            'dvc_id'        =>  $this->input->post('dvc_id'),
                            'dvc_password_sc'  =>  md5($this->input->post('dvc_password')),
                            'action'        =>  'unlock_sc');
                    $update =  $this->curl->simple_post($this->API.'/memberdeviceman', $data, array(CURLOPT_BUFFERSIZE => 10));
                    if($update){
                        $this->session->set_flashdata('hasil','Update Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Update Data Gagal');
                    }
                    redirect('member/device/secondary');
                }else{
                    $this->session->set_flashdata('peringatan','Kombinasi salah');
                    redirect('member/device/open_device_sc/'.$data['dvc_id']);
                }
            }else{
                $this->session->set_flashdata('peringatan',"Kombinasi Salah!");
                redirect('member/device/open_device_sc/'.$data['dvc_id']);
            }
        }
    }

// ==================== Secondary Access End
}
?>
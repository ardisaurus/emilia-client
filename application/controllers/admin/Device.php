<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {

	var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/emilia-server/index.php";
         if($this->session->userdata('level')!='admin'){ 
        	redirect('login');
        }
    }

    public function index() {
        $respond = json_decode($this->curl->simple_get($this->API.'/admindeviceman'));
        $data['device'] = $respond->result;
        $this->load->view('admin/v_device_unreg', $data);
    }

    public function registered() {
        $params = array('ownership'=> 1);
        $respond = json_decode($this->curl->simple_get($this->API.'/admindeviceman', $params));
        $data['device'] = $respond->result;
        $this->load->view('admin/v_device_reg', $data);
    }

    public function add_device() {
        $nugen = json_decode($this->curl->simple_get($this->API.'/nugen'));
        $respond = $nugen->result;
        $data['dvc_id'] = $respond[0]->dvc_id;
        $this->load->view('admin/v_add_device', $data);
    }

    public function process_add() {   
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Konfirmasi Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/device/add_device');
        }else{
            $params = array('dvc_id'=>  $this->input->post('dvc_id'));
            $respond = json_decode($this->curl->simple_get($this->API.'/admindeviceman',$params)); 
            $data['dvc'] = $respond->result;
            if ($data['dvc']) {
                $this->session->set_flashdata('peringatan','Device Id telah digunakan, masukan id lain!');
                redirect('admin/device/add_device');
            }else{
                $data = array(
                    'dvc_id'        =>  $this->input->post('dvc_id'),
                    'dvc_password'  =>  md5($this->input->post('dvc_password')),
                    'action'        =>  'insert');
                    $insert =  $this->curl->simple_post($this->API.'/admindeviceman', $data, array(CURLOPT_BUFFERSIZE => 10)); 
                    if($insert)
                    {
                        $this->session->set_flashdata('hasil','Insert Data Berhasil');
                    }else{
                        $this->session->set_flashdata('hasil','Insert Data Gagal');
                    }
                redirect('admin/device/add_device');
            }
        } 
    }

    public function reset_password() {
        $data['dvc_id']=$this->uri->segment(4);
        $this->load->view('admin/v_reset_password', $data);
    }

    public function process_reset_password() {   
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Konfirmasi Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/device/reset_password');
        }else{
            $data = array(
                    'dvc_id'        =>  $this->input->post('dvc_id'),
                    'dvc_password'  =>  md5($this->input->post('dvc_password')),
                    'action'        =>  'reset_password');
            $update =  $this->curl->simple_post($this->API.'/admindeviceman', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($update){
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('admin/device/reset_password');
        } 
    }
}
?>
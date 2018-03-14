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

    public function index()
    {
        $data['device'] = json_decode($this->curl->simple_get($this->API.'/device'));
        $this->load->view('admin/v_device', $data);
    }

    public function add_device()
    {
        $this->load->view('admin/v_add_device');
    }

    public function process_add()
    {   
        $this->form_validation->set_rules('dvc_id','Device ID','required|trim|alpha_dash|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('dvc_password', 'Password', 'trim|required|matches[dvc_password2]|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('dvc_password2', 'Konfirmasi Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('peringatan', validation_errors());
            redirect('admin/device/add_device');
        }else{
            $params = array('dvc_id'=>  $this->input->post('dvc_id'));
            $data['user'] = json_decode($this->curl->simple_get($this->API.'/device',$params)); 
            if ($data['user']) {
                $this->session->set_flashdata('peringatan','Device Id telah digunakan, masukan id lain!');
                redirect('admin/device/add_device');
            }else{
                $data = array(
                    'dvc_id'        =>  $this->input->post('dvc_id'),
                    'dvc_password'  =>  md5($this->input->post('dvc_password')),
                    'action'        =>  'insert');
                    $insert =  $this->curl->simple_post($this->API.'/device', $data, array(CURLOPT_BUFFERSIZE => 10)); 
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

    public function detail_device()
    {
        $this->load->view('admin/v_detail_device');
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of New Members
 *
 * @author Adiw.io
 */
class New_member extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('Modul');
        $this->load->model('Mglobals');
    }
    
    public function index() {
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['email'] = $session_data['email'];
            $data['akses'] = $session_data['akses'];
            $data['nama'] = $session_data['nama'];
            // $data['kategori'] = $this->Mglobals->getAll("kategori");
            
            $this->load->view('head', $data);
            $this->load->view('menu');
            $this->load->view('new-member/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from userconfig where email = '".$this->input->post('email')."';")->jml;
            if($cek > 0){
                $status = "Data sudah ada";
            }else{
                $data = array(
                    'id' => $this->modul->autokode1('L','id','userconfig','2','8'),
                    'email' => $this->input->post('email'),
                    'nama' => $this->input->post('nama'),
                    'akses' => $this->input->post('status'),
                    'password' => $this->input->post('password')
                );
                $simpan = $this->Mglobals->add("userconfig",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Adiw.io
 */
class Login extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('Modul');
        $this->load->model('Mglobals');
    }
    
    public function index() {
        $this->load->view('login');
    }
    
    public function ajax_login() {
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM userconfig where email = '".$email."' and password = '".$pass."';")->jml;
        if($jml > 0){
            // $data = $this->Mglobals->getAllQR("SELECT iduserconfig, nama, golongan FROM userconfig where iduserconfig = '".$email."' and pass = '".$pass."';");
            $data = $this->Mglobals->getAllQR("SELECT email, nama, akses FROM userconfig where email = '".$email."';");
            $sess_array = array(
                'email' => $data->email,
                'akses' => $data->akses,
                'nama' => $data->nama
            );
            $this->session->set_userdata('logged_in', $sess_array);
            $status = "ok";
        }else{
            $status = "Maaf, anda tidak berhak mengakses";
        }
        echo json_encode(array("status" => $status));
    }
}

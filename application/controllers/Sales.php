<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Barang
 *
 * @author Adiw.io
 */
class Sales extends CI_Controller{
    
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
            $this->load->view('sales/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("sales");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->nama_sales;
                $val[] = $row->alamat;
                $val[] = $row->kode_kota;
                $val[] = $row->no_tlp;
                // $val[] = $this->Mglobals->getAllQR("SELECT nama_kategori FROM kategori where idkategori = '".$row->idkategori."';")->nama_kategori;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->kode_sales."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->kode_sales."'".','."'".$row->nama_sales."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from sales where nama_sales = '".$this->input->post('nama_sales')."';")->jml;
            if($cek > 0){
                $status = "Data sudah ada";
            }else{
                $data = array(
                    'kode_sales' => $this->modul->autokode1('SA','kode_sales','sales','3','7'),
                    'nama_sales' => $this->input->post('nama_sales'),
                    'alamat' => $this->input->post('alamat'),
                    'kode_kota' => $this->input->post('kode_kota'),
          
                    'no_tlp' => $this->input->post('no_tlp')
   
                );
                $simpan = $this->Mglobals->add("sales",$data);
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
    
    public function ganti(){
        if($this->session->userdata('logged_in')){
            $kondisi['kode_sales'] = $this->uri->segment(3);
            $data = $this->Mglobals->get_by_id("sales", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged_in')){
            $data = array(
                    'nama_sales' => $this->input->post('nama_sales'),
                    'alamat' => $this->input->post('alamat'),
                    'kode_kota' => $this->input->post('kode_kota'),
                    'no_tlp' => $this->input->post('no_tlp')
            );
            $condition['kode_sales'] = $this->input->post('id');
            $update = $this->Mglobals->update("sales",$data, $condition);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->session->userdata('logged_in')){
            $kondisi['kode_sales'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("sales",$kondisi);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}

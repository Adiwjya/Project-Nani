<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaksi Pembelian
 *
 * @author Adiw.io
 */
class Pembelian extends CI_Controller{
    
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
                     
            
            $this->load->view('head', $data);
            $this->load->view('menu');
            $this->load->view('pembelian/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("pembelian");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->idpb;
                $val[] = $row->tanggal;
                $val[] = $row->alamat;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$this->modul->enkrip_url($row->idpb)."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idpb."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function detail() {
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['email'] = $session_data['email'];
            $data['akses'] = $session_data['akses'];
            $data['nama'] = $session_data['nama'];   
            $data['kotaq'] = $this->Mglobals->getAll("kota");
            $data['wilayahq'] = $this->Mglobals->getAll("wilayah");
            
            $data['satts'] = 1;


            $kode_enkrip = $this->uri->segment(3);
            if(strlen($kode_enkrip) > 0){
                $kode_dekrip = $this->modul->dekrip_url($kode_enkrip);
                $jml_kode = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM pembelian where idpb = '".$kode_dekrip."';")->jml;
                if($jml_kode > 0){
                    $data['kode'] = $kode_dekrip;
                    $data['tanggal'] = $this->Mglobals->getAllQR("SELECT tanggal FROM pembelian where idpb = '".$kode_dekrip."';")->tanggal;
                    $data['kota'] = $this->Mglobals->getAllQR("SELECT a.nama FROM kota a join pembelian b where a.kode_kota=b.kota and b.idpb = '".$kode_dekrip."';")->nama;
                    $data['wilayah'] = $this->Mglobals->getAllQR("SELECT a.nama FROM wilayah a join pembelian b where a.kode_wilayah=b.wilayah and b.idpb = '".$kode_dekrip."';")->nama;
                    $data['alamat'] = $this->Mglobals->getAllQR("SELECT alamat FROM pembelian where idpb = '".$kode_dekrip."';")->alamat;
                    $data['keterangan'] = $this->Mglobals->getAllQR("SELECT keterangan FROM pembelian where idpb = '".$kode_dekrip."';")->keterangan;
                    $data['subtotal'] = $this->Mglobals->getAllQR("SELECT subtotal FROM pembelian where idpb = '".$kode_dekrip."';")->subtotal;
                }else{
                    $this->modul->halaman('pembelian');
                }
            }else{
                $data['kode'] = $this->modul->autokode1('M','idpb','pembelian','2','7');
                $data['tanggal'] = $this->modul->TanggalWaktu();
                $data['kota'] = "";
                $data['wilayah'] = "";
                $data['alamat'] = "";
                $data['keterangan'] = "";
                $data['subtotal'] = "";
            }
            
            $this->load->view('head', $data);
            $this->load->view('menu');
            $this->load->view('pembelian/detail');
            $this->load->view('footer');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from pembelian where idpb = '".$this->input->post('idpb')."';")->jml;
            if($cek > 0){
                $status = $this->simpandetail();
            }else{
                $status = $this->simpanhead_detail();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpanhead_detail() {
        $data = array(
            'idpb' => $this->input->post('idpb'),
            'tanggal' => $this->input->post('tanggal'),
            'kota' => $this->input->post('kota'),
            'wilayah' => $this->input->post('wilayah'),
            'keterangan' => $this->input->post('keterangan'),
            'alamat' => $this->input->post('alamat'),
            'subtotal' => $this->input->post('subtotal'),
        );
        $simpan = $this->Mglobals->add("pembelian",$data);
        if($simpan == 1){
            $data_detail = array(
                'idpb_detail' => $this->modul->autokode1('D','idpb_detail','pembelian_detail','2','8'),
                'kode_barang' => $this->input->post('kode_barang'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'idpb' => $this->input->post('idpb')
            );
            $simpan1 = $this->Mglobals->add("pembelian_detail",$data_detail);
            if($simpan1 == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function simpandetail() {
        // cek apa data yang sama sebelumnya
        $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM pembelian_detail where kode_barang = '".$this->input->post('kode_barang')."' and idpb = '".$this->input->post('idpb')."';")->jml;
        if($jml > 0){
            $jml_sebelumnya = $this->Mglobals->getAllQR("SELECT jumlah FROM pembelian_detail where kode_barang = '".$this->input->post('kode_barang')."' and idpb = '".$this->input->post('idpb')."';")->jumlah;
            $jml_skrng = $jml_sebelumnya + $this->input->post('jumlah');
            
            $data_detail = array(
                'jumlah' => $jml_skrng
            );
            $kond['kode_barang'] = $this->input->post('kode_barang');
            $kond['idpb'] = $this->input->post('idpb');
            $simpan1 = $this->Mglobals->update("pembelian_detail",$data_detail, $kond);
            if($simpan1 == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            
        }else{
            $data_detail = array(
                'idpb_detail' => $this->modul->autokode1('D','idpb_detail','pembelian_detail','2','8'),
                'kode_barang' => $this->input->post('kode_barang'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'idpb' => $this->input->post('idpb')
            );
            $simpan1 = $this->Mglobals->add("pembelian_detail",$data_detail);
            if($simpan1 == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }
        return $status;
    }
    
    public function ganti(){
        if($this->session->userdata('logged_in')){
            $kodedetail = $this->uri->segment(3);
            $data = $this->Mglobals->getAllQR("SELECT a.idpb_detail, a.kode_barang, b.nama, b.merk, a.harga, a.jumlah FROM pembelian_detail a, barang b where a.kode_barang = b.idbarang and  a.idpb_detail = '".$kodedetail."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged_in')){
            $data = array(
                'kode_barang' => $this->input->post('kode_barang'),
                'jumlah' => $this->input->post('jumlah')
            );
            $condition['idpb_detail'] = $this->input->post('idpb_detail');
            $update = $this->Mglobals->update("pembelian_detail",$data, $condition);
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
            $kondisi['idpb'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("pembelian",$kondisi);
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
    
    public function ajax_barang() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAllQ("select * from barang;");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Pilih" onclick="pilih('."'".$row->idbarang."'".','."'".$row->nama."'".','."'".$row->satuan."'".','."'".$row->saldo_awal."'".')"><i class="ft-check"></i> Pilih</a>'
                        . '</div>';
                $val[] = $row->nama;
                $val[] = $row->satuan;
                $val[] = $row->saldo_awal;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_detail() {
        if($this->session->userdata('logged_in')){
            $kode = $this->uri->segment(3);
            $data = array();
            $list = $this->Mglobals->getAllQ("SELECT * FROM pembelian_detail where idpb = '".$kode."';");
            foreach ($list->result() as $row) {
                $val = array();
                // data barang
                $barang = $this->Mglobals->getAllQR("select nama, merk, satuan from barang where idbarang = '".$row->kode_barang."';");
                $val[] = $barang->nama;
                $val[] = $barang->merk;
                $val[] = $barang->satuan;
                $val[] = $row->harga;
                // $val[] = $this->Mglobals->getAllQR("select nama_kategori from kategori where idkategori = '".$barang->idkategori."';")->nama_kategori;
                $val[] = $row->jumlah;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->idpb_detail."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idpb_detail."'".', '."'".$barang->nama."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapusdetail() {
        if($this->session->userdata('logged_in')){
            $kondisi['idpb_detail'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("pembelian_detail",$kondisi);
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

    public function hitung(){

        if($this->session->userdata('logged_in')){
            $kode = $this->uri->segment(3);
            $subtotal = 0;
            $total = 0;
            $list = $this->Mglobals->getAllQ("SELECT * from pembelian_detail where idpb = '".$kode."';");
            foreach ($list->result() as $row) {

                $total = $row->harga * $row ->jumlah;
                $subtotal = $subtotal + $total;

            }

            $data = array(
                'subtotal' => $subtotal
            );
            $condition['idpj'] = $kode;
            $update = $this->Mglobals->update("penjualan",$data, $condition);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            
            echo json_encode(array("status" => $subtotal));
        }else{
            $this->modul->halaman('login');
        }

    }


}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaksi Penjualan
 *
 * @author Adiw.io
 */
class Penjualan extends CI_Controller{
    
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
            $this->load->view('penjualan/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("penjualan");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->idpj;
                $val[] = $row->tanggal;
                $val[] = $row->customer;
                $val[] = $row->kota;
                $val[] = $row->wilayah;
                $val[] = $row->alamat;
                $str = '<table class="table table-hover mb-0 ps-container ps-theme-default">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Ukuran</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>';
                $list1 = $this->Mglobals->getAllQ("SELECT * FROM penjualan_detail where idpj = '".$row->idpj."';");
                foreach ($list1->result() as $row1) {
                    $barang = $this->Mglobals->getAllQR("select nama from barang where idbarang = '".$row1->kode_barang."';");
                    $str .= '<tr>';
                    $str .= '<td>'.$barang->nama.'</td>';
                    $str .= '<td>'.$row1->harga.'</td>';
                    $str .= '<td>'.$row1->jumlah.'</td>';
                    $str .= '</tr>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$this->modul->enkrip_url($row->idpj)."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idpj."'".')"><i class="ft-delete"></i> Delete</a>'
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

            $kode_enkrip = $this->uri->segment(3);
            if(strlen($kode_enkrip) > 0){
                $kode_dekrip = $this->modul->dekrip_url($kode_enkrip);
                $jml_kode = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM penjualan where idpj = '".$kode_dekrip."';")->jml;
                if($jml_kode > 0){
                    $data['kode'] = $kode_dekrip;
                    $data['tanggal'] = $this->Mglobals->getAllQR("SELECT tanggal FROM penjualan where idpj = '".$kode_dekrip."';")->tanggal;
                    $data['sales'] = $this->Mglobals->getAllQR("SELECT sales FROM penjualan where idpj = '".$kode_dekrip."';")->sales;
                    $data['kota'] = $this->Mglobals->getAllQR("SELECT kota FROM penjualan where idpj = '".$kode_dekrip."';")->kota;
                    $data['wilayah'] = $this->Mglobals->getAllQR("SELECT wilayah FROM penjualan where idpj = '".$kode_dekrip."';")->wilayah;
                    $data['alamat'] = $this->Mglobals->getAllQR("SELECT alamat FROM penjualan where idpj = '".$kode_dekrip."';")->alamat;
                    $data['customer'] = $this->Mglobals->getAllQR("SELECT customer FROM penjualan where idpj = '".$kode_dekrip."';")->customer;
                    $data['subtotal'] = $this->Mglobals->getAllQR("SELECT subtotal FROM penjualan where idpj = '".$kode_dekrip."';")->subtotal;
                }else{
                    $this->modul->halaman('penjualan');
                }
            }else{
                $data['kode'] = $this->modul->autokode1('U','idpj','penjualan','2','7');
                $data['tanggal'] = $this->modul->TanggalWaktu();
                $data['sales'] = "";
                $data['kota'] = "";
                $data['wilayah'] = "";
                $data['alamat'] = "";
                $data['customer'] = "";
                $data['subtotal'] = "";
            }
            
            $this->load->view('head', $data);
            $this->load->view('menu');
            $this->load->view('penjualan/detail');
            $this->load->view('footer');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from penjualan where idpj = '".$this->input->post('idpj')."';")->jml;
            $jml = $this->Mglobals->getAllQR("select jumlah from pembelian_detail where kode_barang = '".$this->input->post('kode_barang')."';")->jumlah;
            if($cek > 0){
                
                if($jml >= $this->input->post('jumlah')){
                    $status = $this->simpandetil();
                }else{
                    $status = "Jumlah melebihi Stok yang tersedia";
                }
            }else{
                if($jml >= $this->input->post('jumlah')){
                    $status = $this->simpanhead_detil();
                }else{
                    $status = "Jumlah melebihi Stok yang tersedia";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpanhead_detil() {
        $data = array(
            'idpj' => $this->input->post('idpj'),
            'tanggal' => $this->input->post('tanggal'),
            'sales' => $this->input->post('sales'),
            'kota' => $this->input->post('kota'),
            'wilayah' => $this->input->post('wilayah'),
            'customer' => $this->input->post('customer'),
            'alamat' => $this->input->post('alamat'),
            'subtotal' => $this->input->post('subtotal')
        );
        $simpan = $this->Mglobals->add("penjualan",$data);
        if($simpan == 1){
            $data_detil = array(
                'idpj_detail' => $this->modul->autokode1('D','idpj_detail','penjualan_detail','2','8'),
                'kode_barang' => $this->input->post('kode_barang'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'idpj' => $this->input->post('idpj')
            );
            $simpan1 = $this->Mglobals->add("penjualan_detail",$data_detil);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }    
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function simpandetil() {
        $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM penjualan_detail where kode_barang = '".$this->input->post('kode_barang')."' and idpj = '".$this->input->post('idpj')."';")->jml;
        if($jml > 0){
            $jmllama = $this->Mglobals->getAllQR("SELECT jumlah FROM penjualan_detail where kode_barang = '".$this->input->post('kode_barang')."' and idpj = '".$this->input->post('idpj')."';")->jumlah;
            $jmlbaru = $jmllama + $this->input->post('jumlah');
            
            $data_detil = array(
                'jumlah' => $jmlbaru
            );
            $kond['kode_barang'] = $this->input->post('kode_barang');
            $kond['idpj'] = $this->input->post('idpj');
            $simpan1 = $this->Mglobals->update("penjualan_detail",$data_detil, $kond);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }else{
            $data_detil = array(
                'idpj_detail' => $this->modul->autokode1('D','idpj_detail','penjualan_detail','2','8'),
                'kode_barang' => $this->input->post('kode_barang'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'idpj' => $this->input->post('idpj')
            );
            $simpan1 = $this->Mglobals->add("penjualan_detail",$data_detil);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }
        
        return $status;
    }
    
    public function ganti(){
        if($this->session->userdata('logged_in')){
            $kodedetail = $this->uri->segment(3);
            $data = $this->Mglobals->getAllQR("SELECT a.idpj_detail, a.kode_barang, b.nama, b.merk, a.harga, a.jumlah FROM penjualan_detail a, barang b where a.kode_barang = b.idbarang and  a.idpj_detail = '".$kodedetail."';");
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
            $condition['idpj_detail'] = $this->input->post('idpj_detail');
            $update = $this->Mglobals->update("penjualan_detail",$data, $condition);
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
            $kondisi['idpj'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("penjualan",$kondisi);
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
            $list = $this->Mglobals->getAllQ("SELECT * FROM penjualan_detail where idpj = '".$kode."';");
            foreach ($list->result() as $row) {
                $val = array();
                // data barang
                $barang = $this->Mglobals->getAllQR("select nama, merk, satuan from barang where idbarang = '".$row->kode_barang."';");
                $val[] = $barang->nama;
                $val[] = $barang->merk;
                $val[] = $barang->satuan;
                $val[] = $row->harga;
                $val[] = $row->jumlah;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->idpj_detail."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idpj_detail."'".', '."'".$barang->nama."'".')"><i class="ft-delete"></i> Delete</a>'
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
            $kondisi['idpj_detail'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("penjualan_detail",$kondisi);
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
    
    public function getStok() {
        if($this->session->userdata('logged_in')){
            $kode = $this->uri->segment(3);
            
            $masuk = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as masuk FROM pembelian_detail where kode_barang = '".$kode."';")->masuk;
            $keluar = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as keluar FROM penjualan_detail where kode_barang = '".$kode."';")->keluar;
            
            $stok = $masuk - $keluar;
            
            echo json_encode(array("status" => $stok));
        }else{
            $this->modul->halaman('login');
        }
    }
}

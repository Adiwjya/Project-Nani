<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    var tbbarang;

    
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>customer/ajax_list_detail_pembayaran/<?php echo $kode; ?>"
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true 
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    

    
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaksi Penjualan</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Kode</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" name="kode" id="kode" value="<?php echo $kode; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Kota</label>
                                                <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" name="kode" id="kode" value="<?php echo $kota; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Wilayah</label>
                                                <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" name="kode" id="kode" value="<?php echo $wilayah; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Alamat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" readonly="" placeholder="Alamat" name="alamat" id="alamat" value="<?php echo $alamat; ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Tanggal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" placeholder="Tanggal" readonly="" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Customer</label>
                                                <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" name="kode" id="kode" value="<?php echo $customer; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Sales</label>
                                                <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" name="kode" id="kode" value="<?php echo $sales; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Subtotal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" placeholder="Subtotal" readonly="" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                </div>
                                <div class="clearfix"></div><br>
                                <div class="table-responsive">
                                    <table id="tb" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Merk</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-6 col-xs-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Kode Barang Masuk" readonly="" value="<?php echo $subtotal; ?>">
                                </div>

                                <div class="row" style="padding:10pt">
                                    <div class="col-2"> <input type="text" class="form-control" placeholder="Discount barang" readonly="" id="diskon" value="<?php echo $diskon; ?>" onkeyup="hitungdc()"> </div> %
                                    <div class="col-2"> <input type="text" class="form-control" placeholder="PPN" id="ppn" readonly="" value="<?php echo $ppn; ?>" onkeyup="hitungdc()"> </div>%

                                </div>
                                
                                <div class="col-md-6 col-xs-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Sub Total" readonly="" id="totala" value="<?php echo $total_akhir; ?>">
                                </div>
                                
                                <div class="col-md-6 col-xs-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Bayar" readonly="" id="bayar" value="<?php echo $jumlah_bayar; ?>" onkeyup="kembalian()">  
                                    <input type="text" class="form-control" placeholder="Kembalian" readonly="" value="<?php echo $kembalian; ?>" id="kembali">
                                </div>

                              
                        </div>
                    </div>
                </div>
            </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

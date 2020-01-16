<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    var tbbarang;

    function hitungdc(){
        var total = document.getElementById('subtotal').value;
        var diskon = document.getElementById('diskon').value;
        var ppn = document.getElementById('ppn').value;

        diskon = diskon/100;
        ppn = ppn/100;

        var a = total - (total*diskon);
        var b = a + (a*ppn);

        document.getElementById('totala').value = b;
    }

    function kembalian(){
        var sbtotal = document.getElementById('totala').value;
        var bayar = document.getElementById('bayar').value;

        var c = bayar - sbtotal;

        document.getElementById('kembali').value = c;

    }
    
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>penjualan/ajax_list_detail_pembayaran/<?php echo $kode; ?>"
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
    
    function add(){
        save_method = 'add';
        //
        $('[name="nama_barang"]').val("");
        $('[name="merk"]').val("");
        $('[name="harga"]').val("");
        $('[name="jumlah"]').val("");
        $('[name="stok"]').val("");
                
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Barang Keluar'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 

            var url;
            url = "<?php echo base_url(); ?>penjualan/ajax_bayar";
            
            

            // ajax adding data to database
            var kode_trans = document.getElementById('kode').value;
            
            var tanggal = document.getElementById('tanggal').value;
            
            var sales = document.getElementById('sales').value;
           
            var kota = document.getElementById('kota').value;
            
            var wilayah = document.getElementById('wilayah').value;
            
            var subtotal = document.getElementById('subtotal').value;
            
            var customer = document.getElementById('customer').value;
        
            var alamat = document.getElementById('alamat').value;
           
            var diskon = document.getElementById('diskon').value;
           
            var ppn = document.getElementById('ppn').value;
           
            var total_akhir = document.getElementById('totala').value;
           
            var kembalian = document.getElementById('kembali').value;
            
            var jumlah_bayar = document.getElementById('bayar').value;
            // alert("wme=weheheh");
            
            // ajax adding data to database
            var form_data = new FormData();
            form_data.append('idpj', kode_trans);
            form_data.append('tanggal', tanggal);
            form_data.append('sales', sales);
            form_data.append('kota', kota);
            form_data.append('wilayah', wilayah);
            form_data.append('customer', customer);
 
            form_data.append('alamat', alamat);
            form_data.append('subtotal', subtotal);
            
            form_data.append('diskon', diskon);
            form_data.append('ppn', ppn);
            form_data.append('total_akhir', total_akhir);
            form_data.append('kembalian', kembalian);
            form_data.append('jumlah_bayar', jumlah_bayar);


            

            

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);

                    $.ajax({
                            url : "<?php echo base_url(); ?>penjualan/hitung/" + kode_trans,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data){
                                $('[name="subtotal"]').val(data.status);
                                
                            },
                            error: function (jqXHR, textStatus, errorThrown){
                                alert('Error get data');
                            }
                     });


                    reload();

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 

                    $('#modal_form').modal('hide');

                },error: function (response) {
                    alert(response.status);
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        
       
    }
    
    function hapus(id, nama){
        if(confirm("Apakah anda yakin menghapus barang " + nama + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>penjualan/hapusdetail/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    alert(data.status);
                    reload();
                },error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function ganti(id){
        save_method = 'update';
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Barang Masuk'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>penjualan/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.idpj_detail);
                $('[name="kode_barang"]').val(data.kode_barang);
                $('[name="nama_barang"]').val(data.nama);
                $('[name="merk"]').val(data.merk);
                $('[name="harga"]').val(data.harga);
                $('[name="jumlah"]').val(data.jumlah);

                $.ajax({
                    url : "<?php echo base_url(); ?>penjualan/getStok/" + data.kode_barang,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data){
                        $('[name="stok"]').val(data.status);
                    },error: function (jqXHR, textStatus, errorThrown){
                        alert('Error get data stok');
                    }
                });

            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }
    
    function showbarang(){
        $('#modal_barang').modal('show'); // show bootstrap modal
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>penjualan/ajax_barang",
            retrieve:true
        });
        tbbarang.destroy();
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>penjualan/ajax_barang",
            retrieve:true
        });
    }
    
    function pilih(kode, nama, merk, harga){
        $('[name="kode_barang"]').val(kode);
        $('[name="nama_barang"]').val(nama);
        $('[name="merk"]').val(merk);
        $('[name="harga"]').val(harga);
        
        $.ajax({
            url : "<?php echo base_url(); ?>penjualan/getStok/" + kode,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="stok"]').val(data.status);
            },error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data stok');
            }
        });

        $('#modal_barang').modal('hide');
    }

    function lunas(id){
        $.ajax({
                url : "<?php echo base_url(); ?>penjualan/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    window.location.href = "<?php echo base_url(); ?>penjualan";
                },error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
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
                                                <select class="form-control" id="kota" name="kota">
                                                    <?php
                                                    foreach ($kotaq->result() as $row) {

                                                        if ($row->nama == $kota) {
                                                            ?>
                                                            <option value="<?php echo $row->kode_kota; ?>" selected><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?php echo $row->kode_kota; ?>"><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Wilayah</label>
                                                <div class="col-sm-10">
                                                <select class="form-control" id="wilayah" name="wilayah">
                                                    <?php
                                                    foreach ($wilayahq->result() as $row) {

                                                        if ($row->nama == $wilayah) {
                                                            ?>
                                                            <option value="<?php echo $row->kode_wilayah; ?>" selected><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?php echo $row->kode_wilayah; ?>"><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Alamat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" placeholder="Alamat" name="alamat" id="alamat" value="<?php echo $alamat; ?>" >
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
                                                <select class="form-control" id="customer" name="customer">
                                                    <?php
                                                    foreach ($customerq->result() as $row) {

                                                        if ($row->nama == $customer) {
                                                            ?>
                                                            <option value="<?php echo $row->kode_customer; ?>" selected><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?php echo $row->kode_customer; ?>"><?php echo $row->nama; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="text-align: right;">Sales</label>
                                                <div class="col-sm-10">
                                                <select class="form-control" id="sales" name="sales">
                                                    <?php
                                                    foreach ($salesq->result() as $row) {

                                                        if ($row->nama_sales == $sales) {
                                                            ?>
                                                            <option value="<?php echo $row->kode_sales; ?>" selected><?php echo $row->nama_sales; ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?php echo $row->kode_sales; ?>"><?php echo $row->nama_sales; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
                                    <input type="text" class="form-control" placeholder="Kode Barang Masuk" value="<?php echo $subtotal; ?>">
                                </div>

                                <div class="row" style="padding:10pt">
                                    <div class="col-2"> <input type="text" class="form-control" placeholder="Discount barang" id="diskon" value="<?php echo $diskon; ?>" onkeyup="hitungdc()"> </div> %
                                    <div class="col-2"> <input type="text" class="form-control" placeholder="PPN" id="ppn" value="<?php echo $ppn; ?>" onkeyup="hitungdc()"> </div>%

                                </div>
                                
                                <div class="col-md-6 col-xs-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Sub Total" id="totala" value="<?php echo $total_akhir; ?>">
                                </div>
                                
                                <div class="col-md-6 col-xs-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Bayar" id="bayar" value="<?php echo $jumlah_bayar; ?>" onkeyup="kembalian()">  
                                    <input type="text" class="form-control" placeholder="Kembalian" value="<?php echo $kembalian; ?>" id="kembali">
                                </div>

                                <button type="button" class="btn btn-primary" onclick="save();">SIMPAN</button>
                                <button type="button" class="btn btn-success" onclick="lunas('<?php echo $kode; ?>');" >LUNAS</button>
                        </div>
                    </div>
                </div>
            </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

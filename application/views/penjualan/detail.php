<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    var tbbarang;
    
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>penjualan/ajax_list_detail/<?php echo $kode; ?>"
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
        var jumlah = document.getElementById('jumlah').value;
        var kode_barang = document.getElementById('kode_barang').value;
        
        if(kode_barang === ''){
            alert("Kode barang tidak boleh kosong");
        }else if(jumlah === ''){
            alert("Jumlah tidak boleh kosong");
        }else{
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 

            var url;
            if(save_method === 'add') {
                url = "<?php echo base_url(); ?>penjualan/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>penjualan/ajax_edit";
            }
            
            // ajax adding data to database
            var kode_trans = document.getElementById('kode').value;
            var tanggal = document.getElementById('tanggal').value;
            var sales = document.getElementById('sales').value;
            var kota = document.getElementById('kota').value;
            var wilayah = document.getElementById('wilayah').value;
            var subtotal = document.getElementById('subtotal').value;
            var customer = document.getElementById('customer').value;
            var alamat = document.getElementById('alamat').value;

            var kode_barang = document.getElementById('kode_barang').value;
            var jumlah = document.getElementById('jumlah').value;
            var harga = document.getElementById('harga').value;
            var kode_detail = document.getElementById('kode_detail').value;
            
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
            
            form_data.append('kode_barang', kode_barang);
            form_data.append('jumlah', jumlah);
            form_data.append('harga', harga);
            form_data.append('idpj_detail', kode_detail);

            

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
                $('[name="id"]').val(data.idpb_detail);
                $('[name="kode_barang"]').val(data.kode_barang);
                $('[name="nama_barang"]').val(data.nama);
                $('[name="merk"]').val(data.merk);
                $('[name="harga"]').val(data.harga);
                $('[name="jumlah"]').val(data.jumlah);
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
                                    <button class="btn btn-md btn-primary" onclick="add();"><i class="ft-plus"></i> Barang</button>
                                    <button class="btn btn-md btn-default" onclick="reload();"><i class="ft-repeat"></i> Reload</button>
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
                                                <th style="text-align: center;">Aksi</th>
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
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" name="id" id="kode_detail">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Nama Barang</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="hidden" name="kode_barang" id="kode_barang">
                                <input type="text" class="form-control" placeholder="Nama Barang" name="nama_barang" readonly="">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="showbarang()">...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Merk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="merk" placeholder="merk" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="harga"name="harga" placeholder="harga" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Stok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" onkeypress="return hanyaAngka(event,false);" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<!-- Modal list barang -->
<div class="modal fade" id="modal_barang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="table-responsive">
                        <table id="tbbarang" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Aksi</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Harga</th>
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
<!-- modal -->
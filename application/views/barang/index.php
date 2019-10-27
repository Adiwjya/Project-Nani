<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>barang/ajax_list"
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Barang'); // Set Title to Bootstrap modal title
    }

    function add2(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form_kat').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Kategori'); // Set Title to Bootstrap modal title
    }

    function save() {
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url;
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>barang/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>barang/ajax_edit";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                alert(data.status);
                $('#modal_form').modal('hide');
                reload();

                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function save2(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        var url;
        if(save_method === 'add') {
            url = "<?php echo base_url(); ?>kategori/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>kategori/ajax_edit";
        }
        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form2').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                alert(data.status);
                $('#modal_form_kat').modal('hide');
                reload2();
                    
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
                
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus " + nama + " ?")) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo base_url(); ?>barang/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    alert(data.status);
                    reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function hapus_kat(id, nama){
        if(confirm("Apakah anda yakin menghapus " + nama + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>kategori/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    alert(data.status);
                    reload2();
                },error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Barang'); // Set title to Bootstrap modal title

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url(); ?>barang/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.idbarang);
                $('[name="nama_barang"]').val(data.nama);
                $('[name="kategori"]').val(data.kategori);
                $('[name="satuan"]').val(data.satuan);
                $('[name="merk"]').val(data.merk);
                $('[name="saldo_awal"]').val(data.saldo_awal);
                $('[name="saldo_akhir"]').val(data.saldo_akhir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function ganti_kat(id){
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form_kat').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Kategori'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>kategori/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="id_kat"]').val(data.kode_kategori );
                $('[name="nama_kat"]').val(data.nama);
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }


    function showkategori(){
        $('#modal_barang').modal('show'); // show bootstrap modal
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barang/ajax_kategori",
            retrieve:true
        });
        tbbarang.destroy();
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barang/ajax_kategori",
            retrieve:true
        });
    }

    function reload2() {
        tbbarang.ajax.reload(null, false); //reload datatable ajax
    }
    
    function pilih(kode, nama, ukuran, nama_kategori){
        $('[name="kode_kategori"]').val(kode_kategori);
        $('[name="nama"]').val(nama);
        
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
    <div class="content">
    <div class="container-fluid">
    <button class="btn btn-md btn-primary" onclick="showkategori();"> Kategori</button>
    </div>
    </div>
    <!-- Main content -->
    <div class="content" style="margin-top : 20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Master Barang</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <button class="btn btn-md btn-primary" onclick="add();"> Tambah Barang</button>
                                    <button class="btn btn-md btn-default" onclick="reload();"> Reload</button>
                                    
                                </div>
                                <div class="clearfix"></div><br>
                                <div class="table-responsive">
                                    <table id="tb" class="table table-hover mb-0 ps-container ps-theme-default">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Satuan</th>
                                                <th>Merk</th>
                                                <th>Saldo Awal</th>
                                                <th>Saldo Akhir</th>
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
            <!-- /.row -->
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
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="kategori" placeholder="kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="satuan" placeholder="Satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Merk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="merk" placeholder="Merk">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Saldo_awal</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="saldo_awal" placeholder="Saldo Awal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Saldo_akhir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="saldo_akhir" placeholder="Saldo Akhir">
                        </div>
                    </div>
                </form>
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
                <h5>Data kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <button class="btn btn-md btn-primary" onclick="add2();"> Tambah Kategori</button>
                    <button class="btn btn-md btn-default" onclick="reload();"> Reload</button>
                </div>
                    <div class="table-responsive">
                        <table id="tbbarang" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
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
<!-- modal -->

<!-- Modal -->
<div class="modal fade" id="modal_form_kat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="form2" class="form-horizontal">
                    <input type="text" name="id_kat">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Nama Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_kat" placeholder="Nama Kategori">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save2();">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
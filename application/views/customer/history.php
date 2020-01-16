<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    
    $(document).ready(function() {
       
        
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true 
        });
    });
    

    
    function add(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Customer'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        var url;
        if(save_method === 'add') {
            url = "<?php echo base_url(); ?>customer/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>customer/ajax_edit";
        }
        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                alert(data.status);
                $('#modal_form').modal('hide');
                reload();
                    
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
    
    function hapus(id){
        if(confirm("Apakah anda yakin menghapus history ini  ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>customer/hapus_history/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    alert(data.status);
                    window.location.reload()
                },error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function ganti(id){
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Customer'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>customer/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.kode_customer);
                $('[name="nama_customer"]').val(data.nama);
                $('[name="alamat"]').val(data.alamat);
                $('[name="kode_kota"]').val(data.kode_kota);
                $('[name="kode_wilayah"]').val(data.kode_wilayah);
                $('[name="no_tlp"]').val(data.no_tlp);
                $('[name="no_fax"]').val(data.no_fax);
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }

    function detail(id){
        window.location.href = "<?php echo base_url(); ?>customer/history_detail/" + id;
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

                <?php 
                     foreach ($history->result() as $row) {        
                ?>
                

                <div class="col-xl-4 col-lg-4 col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">History &nbsp;&nbsp;|&nbsp;&nbsp; <?php echo $row->idl; ?> &nbsp;&nbsp;|&nbsp;&nbsp;  <?php echo $row->tanggal; ?> </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="row"> 
                                <div class="col-4"><button class=" form-control btn btn-md btn-success " onclick="print();"> Print </button></div>
                                <div class="col-4"><button class="form-control btn btn-md btn-primary " onclick="detail('<?php echo $row->idl; ?>');"> Detail </button></div>
                                <div class="col-4"><button class="form-control btn btn-md btn-danger " onclick="hapus('<?php echo $row->idl; ?>');"> Hapus</button></div>
                                    
                                </div>
                                   
                                   
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                     }
                ?>

                
            </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



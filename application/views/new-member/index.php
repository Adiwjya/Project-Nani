<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    
    $(document).ready(function() {
        // table = $('#tb').DataTable( {
        //     ajax: "<?php echo base_url(); ?>barang/ajax_list"
        // });
        
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
        $('#form')[0].reset(); // reset form on modals
        save();
    }
    
    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        var url;

            url = "<?php echo base_url(); ?>new_member/ajax_add";

        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                alert(data.status);
                alert("Gunakan Email anda untuk melakukan Login");
                reset_form();
                    
                $('#btnSave').text('Create Account'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
                
                $('#btnSave').text('Create Account'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }
    
    function reset_form(){
        $('[name="email"]').val("");
        $('[name="nama"]').val("");
        $('[name="status"]').val("");
        $('[name="password"]').val("123");
    }
    
</script>

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
      <div class="card card-info">
            <div class="card-header">
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Status</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="status" placeholder="Masukkan Status">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="123" placeholder="Masukkan Password">
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="button" id="btnSave" onclick="save();" class="btn btn-info">Create Account</button>
            </div>
            <!-- /.card-footer -->
            
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
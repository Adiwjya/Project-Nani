<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Nama Toko | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>app-assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>app-assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.12.3.js"></script>
    <script type="text/javascript">
        
        function back(){
            window.history.back();
        }
        
        function hanyaAngka(e, decimal) {
            var key;
            var keychar;
            if (window.event) {
                key = window.event.keyCode;
            } else if (e) {
                key = e.which;
            } else {
                return true;
            }
            keychar = String.fromCharCode(key);
            if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                return true;
            } else if ((("0123456789").indexOf(keychar) > -1)) {
                return true;
            } else if (decimal && (keychar == ".")) {
                return true;
            } else {
                return false;
            }
        }
        
        function batas_angka(input, max) {
            if (input.value < 0){ input.value = 0;}
            if (input.value > parseInt(max)) {input.value = parseInt(max);}
        }
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="info">
          <a href="#" class="nav-link"><?php echo $akses; ?></a>
        </div>
      </li>
    </ul>

    <!-- Right navbar links -->
  </nav>
  <!-- /.navbar -->

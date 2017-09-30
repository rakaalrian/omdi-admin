<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=base_url()?>assets/dist/css/sb-admin-2.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="<?=base_url()?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<?php
  if ($this->session->userdata('omdi-isLogin')) {
?>
<!-- MetisMenu CSS -->
<link href="<?=base_url()?>assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=base_url()?>assets/dist/css/admin-omdi.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="<?=base_url()?>assets/vendor/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- Magnific CSS -->
<link rel="stylesheet" href="<?=base_url('assets/vendor/magnific/magnific-popup.css')?>">
<!-- Cropit CSS -->
<link rel="stylesheet" href="<?=base_url()?>assets/vendor/cropit/cropit.css">
<!-- Summernote CSS -->
<link rel="stylesheet" href="<?=base_url()?>assets/vendor/summernote/summernote.css">
<!-- jQuery-ui CSS -->
<link rel="stylesheet" href="<?=base_url()?>assets/vendor/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendor/jquery-timepicker/jquery.timepicker.min.css">
<?php
  }
?>

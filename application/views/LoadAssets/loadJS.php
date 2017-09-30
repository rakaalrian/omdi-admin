<!-- jQuery -->
<script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/vendor/jquery/jquery-2.1.4.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?=base_url()?>assets/vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=base_url()?>assets/dist/js/sb-admin-2.js"></script>

<?php
  if ($this->session->userdata('omdi-isLogin')) {
?>
<!-- DataTables JavaScript -->
<script src="<?=base_url()?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/vendor/datatables/js/dataTables.bootstrap.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=base_url()?>assets/dist/js/datatables-lang.js"></script>
<!-- jQuery-ui JavaScript -->
<script src="<?=base_url()?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets/vendor/jquery-ui/datepicker-id.js"></script>
<script src="<?=base_url()?>assets/vendor/jquery-timepicker/jquery.timepicker.min.js"></script>
<!-- Chart JS -->
<script src="<?=base_url()?>assets/vendor/chartjs/chart.min.js"></script>
<!-- Cropper JS -->
<script src="<?=base_url()?>assets/vendor/cropit/jquery.cropit.js"></script>
<!-- Summernote JS -->
<script src="<?=base_url()?>assets/vendor/summernote/summernote.min.js"></script>
<script src="<?=base_url()?>assets/vendor/summernote/lang/summernote-id-ID.js"></script>
<!-- Magnific JS -->
<script src="<?=base_url('assets/vendor/magnific/jquery.magnific-popup.min.js')?>"></script>
<?php
  }
?>

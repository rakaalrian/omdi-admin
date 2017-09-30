<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=base_url('assets/images/logo-omdi.ico')?>">
    <title>Admin OMDI</title>
  </head>
  <?php $this->load->view('LoadAssets/loadCSS'); ?>
  <body>
    <?php
      if ($this->session->userdata('omdi-isLogin')) {
        $this->load->view('Menu/topBar');
        $this->load->view('Menu/sideBar');
      }
    ?>

<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <div class="row">
      <div class="col-lg-4 col-lg-offset-4 ">
          <div class="login-panel panel panel-default">
              <div class="panel-heading text-center">
                  <img width="50" src="<?=base_url('assets/images/logo-omdi.png')?>"/>
                  <h4><b>Admin OMDI</b></h4>
              </div>
              <div class="panel-body">
                <div id="alert_login">

                </div>
                <!-- <form action="<?=site_url('Login/login')?>" id="formLogin" name="formLogin" method="post"> -->
                <form action="javascript:masuk()" id="formLogin" name="formLogin" method="post" autocomplete="off">
                  <div class="form-group">
                      <input class="form-control" placeholder="Nama Pengguna" id="username" name="username" type="text">
                      <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                      <input class="form-control" placeholder="Kata Sandi" id="password" name="password" type="password" value="">
                      <span class="help-block"></span>
                  </div>
                  <!-- <button type="button" class="btn btn-lg btn-primary btn-block" onclick="masuk()">Masuk</button> -->
                  <input type="submit" class="btn pull-right btn-primary" name="" id="btnMasuk" value="Masuk">
                  <!-- <input type="submit" name="" value="masuk"> -->
                </form>
              </div>
              <!-- <div class="panel-footer">
                  <button class="btn btn-info btn-sm btn-block" onclick="showModal('Lupa Kata Sandi','formLogin')">Lupa Kata Sandi?</button>
              </div> -->
          </div>
      </div>
  </div>
</div>
<?php $this->load->view('LoadAssets/loadJS'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#username').focus();
    $("input").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });
  });
  function alertDanger(div,message){
    $(div).html('<div id="isialert" class="alert alert-danger">\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>'+message+'</div>').fadeIn(100);
  }
  // function alertSuccess(div,message){
  //   $(div).html('<div id="isialert" class="alert alert-success">\
  //   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>'+message+'</div>').fadeIn(100);
  // }
  function loadingSuccess(div){
    $(div).html('<div class="progress progress-striped active">\
      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">\
      </div>\
    </div>');
  }
  function masuk(){
    loadingSuccess("#alert_login");
    $('#btnMasuk').val('Konfirmasi..');
    $("#btnMasuk").attr("disabled",true);
    $.ajax({
      url:"<?=site_url('login/login')?>",
      type: "POST",
      data: $('#formLogin').serialize(),
      dataType:"JSON",
      success:function(data){
        $("#alert_login").html('');
        $("button").attr("disabled",false);
        if (data.valid) {
          if (data.masuk===true) {
            window.location.href = "<?=site_url()?>";
          }else {
            var div = "#alert_login";
            var message = "Kombinasi Nama Pengguna dan Kata Sandi Tidak Ditemukan";
            $('#username').focus();
            alertDanger(div,message);
          }
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('[name="'+data.namafield[i]+'"]').next().text(data.texterror[i]);
          }
        }
        $('#btnMasuk').val('Masuk');
        $("#btnMasuk").attr("disabled",false);
      },
      error: function (data)
      {
        alert(data);
      }
    })
  }
</script>

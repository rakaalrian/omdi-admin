<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h4 class="page-header"><b><?=$judul?></b></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-primary">
              <div class="panel-body">
                <!-- <form action="<?=site_url('PK/validasi')?>" method="POST" autocomplete="off"> -->
                <form id="form1" class="" autocomplete="off" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="gambar" class="btn btn-default">Pilih Gambar</label><span id="namagambar" class="text-muted small"></span>
                    <!-- Ukuran berkas maksimal 500 KB.</span> -->
                    <input id="gambar" style="display:none;" type="file" name="gambar">
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="pk" id="pk" placeholder="Program Keahlian" value="">
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <input type="text" class="form-control" name="singkatan" placeholder="Singkatan" value="">
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <textarea name="deskripsi" id="summernote" class="form-control"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <input type="hidden" name="id" value="">
                  <button type="button" id="btnModal" class="btn btn-primary pull-right" onclick="simpan()">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php $this->load->view('bottomhtml.php'); ?>
<script type="text/javascript">
var pk_id = '<?=$this->uri->segment(3, 0);?>'
  $(document).ready(function(){
    $("#pk").focus()
    $("input").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    })
    $("#gambar").change(function(){
      var val = $(this).val().replace("C:\\fakepath\\","")
      // if (val=="") {
      //   $("#namagambar").text(' Ukuran berkas maksimal 500 KB.')
      // }else {
      //   $("#namagambar").text(' ' + val)
      // }
      $("#namagambar").text(' ' + val)
      // console.log(val);
    })
    $('#summernote').summernote({
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['paragraph']],
        ['misc',['fullscreen']]
      ],
      disableDragAndDrop: true,
      height: 200,                 // set editor height
      minHeight: 200,             // set minimum height of editor
      maxHeight: 500,             // set maximum height of editor
      lang: 'id-ID',
      placeholder: 'Deskripsi Logo',
      callbacks: {
        onBlur: function() {
          $('.note-editor').removeClass('has-error')
          $(this).parent().removeClass('has-error')
          $('.note-editor').next().empty()
        }
      }
    })

    if (pk_id>0) {
      ubah()
    }
  })

  function ubah(){
    $.ajax({
      url : "<?php echo site_url('pk/pk/')?>" + pk_id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        console.log(data);
        $('[name="pk"]').val(data.nama)
        $('[name="singkatan"]').val(data.singkatan)
        $('[name="id"]').val(data.pk_id)
        $("#namagambar").text(' ' + data.logo)
        $("#summernote").summernote("code", data.deskripsi)
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
  }
  function simpan(){
    $('#btnModal').text('Menyimpan..');
    $('#btnModal').attr('disabled',true);
    var data = new FormData($("#form1")[0]);
    $.ajax({
      url:"<?=site_url('pk/validasi')?>",
      type: "POST",
      data: data,
      // async : false, bikin loading menyimpan ga muncul
      cache : false,
      contentType : false,
      processData : false,
      dataType:"JSON",
      success:function(data){
        if (data.valid) {
          window.location.href = "<?=site_url('pk')?>";
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            if ($('[name="'+data.namafield[i]+'"]').prop('type') == 'textarea') {
              $('.note-editor').addClass('has-error')
              $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error')
              $('.note-editor').next().text(data.texterror[i])
            }else {
              $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error')
              $('[name="'+data.namafield[i]+'"]').next().text(data.texterror[i])
            }
          }
          $('#btnModal').text('Simpan');
          $('#btnModal').attr('disabled',false);
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error adding / update data');
      }
    })
  }
</script>

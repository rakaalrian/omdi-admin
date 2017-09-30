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
            <form id="form1" class="" autocomplete="off" enctype="multipart/form-data">
              <div class="form-group ">
                <label for="gambar" class="btn btn-default">Pilih Gambar</label><span id="namagambar" class="text-muted small"></span>
                <!-- Ukuran berkas maksimal 500 KB.</span> -->
                <input id="gambar" style="display:none;" type="file" name="gambar">
                <span class="help-block"></span>
              </div>
              <div class="form-group ">
                <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Berita" value="">
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <textarea name="konten" id="summernote" class="form-control"></textarea>
                <span class="help-block"></span>
                <font size="1px" class="text-danger">Catatan : Tulislah berita yang bermanfaat, bukan hoax, dan tidak mengandung unsur SARAP (Suku, Agama, RAs, Politik).</font>
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
var berita_id = '<?=$this->uri->segment(3, 0);?>'
  $(document).ready(function(){
    $("#judul").focus()
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
        // ['fontsize', ['fontsize']],
        ['color', ['color']],
        // ['para', ['paragraph']],
        ['misc',['fullscreen']]
      ],
      disableDragAndDrop: true,
      height: 260,                 // set editor height
      minHeight: 260,             // set minimum height of editor
      maxHeight: 500,             // set maximum height of editor
      // lang: 'id-ID',
      placeholder: 'Konten Berita',
      callbacks: {
        onBlur: function() {
          $('.note-editor').removeClass('has-error')
          $(this).parent().removeClass('has-error')
          $(".note-editor").next().empty()
        }
      }
    })

    if (berita_id>0) {
      ubah()
    }
  })

  function ubah(){
    $.ajax({
      url : "<?php echo site_url('berita/Berita/')?>" + berita_id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        // console.log(data)
        $('[name="id"]').val(data.berita_id)
        $('[name="judul"]').val(data.judul)
        $("#namagambar").text(' ' + data.image)
        $("#summernote").summernote("code", data.konten)
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
      url:"<?=site_url('berita/validasi')?>",
      type: "POST",
      data : data,
      // async : false, bikin loading menyimpan ga muncul
      cache : false,
      contentType : false,
      processData : false,
      dataType:"JSON",
      success:function(data){
        if (data.valid) {
          window.location.href = "<?=site_url('berita')?>";
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
        }
        $('#btnModal').text('Simpan');
        $('#btnModal').attr('disabled',false);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error adding / update data');
      }
    })
  }
</script>

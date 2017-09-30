<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <style media="screen">
  .cropit-preview {
    width: 300px;
    height: 300px;
    margin: 5px auto;
  }
  .zoom-group{
    width: 300px;
    margin: auto;
  }
  </style>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h4 class="page-header"><b><?=$judul?></b></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="panel panel-primary">
          <div class="panel-body">
            <form id="form1" class="" autocomplete="off">
              <div class="form-group">
                <div class="image-editor">
                  <input type="file" name="image" class="cropit-image-input">
                  <button type="button" class="btn btn-success btn-sm" onclick="pilihgambar()">Pilih Gambar</button>
                  <div class="cropit-preview"></div>
                  <div class="image-size-label">
                    Potong Gambar
                  </div>
                  <input type="range" class="cropit-image-zoom-input">
                  <input type="hidden" name="image-data" class="hidden-image-data" />
                  <span class="help-block"></span>
                </div>
              </div>
              <input type="hidden" name="id" value="">
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="panel panel-primary">
          <div class="panel-body">
            <form id="form2" class="" autocomplete="off">
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Berita" value="">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group">
                <textarea name="konten" id="summernote" class="form-control"></textarea>
                <span class="help-block"></span>
                <font size="1px">Catatan : Tulislah berita yang bermanfaat, bukan hoax, dan tidak mengandung unsur SARAP (Suku, Agama, RAs, Politik)</font>
              </div>
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
      var type = $(this).prop("type");
      if (type !== 'file') {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      }
    })
    $("select").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    })
    $(".cropit-image-input").change(function(){
      $(".hidden-image-data").parent().removeClass('has-error')
      $(".hidden-image-data").next().empty()
      $(".image-size-label").show()
      $(".cropit-image-zoom-input").show()
      $(".cropit-preview-image").attr('width',false)
    })
    $(".cropit-image-input").click(function(){
      $('.image-editor').cropit('reenable');
    })

    $('.image-editor').cropit({
      minZoom : 'fit',
      maxZoom : 2.5,
      exportZoom : 2,
      smallImage : 'allow'
    });
    $(".image-size-label").hide()
    $(".cropit-image-zoom-input").hide()

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
  function pilihgambar(){
    $('.cropit-image-input').click();
  }
  function input(){
    var image = $("[name='image']").val()
    if (image!=="") {
      var imageData = $('.image-editor').cropit('export')
    }else {
      var imageData = null
    }
    $('.hidden-image-data').val(imageData)
  }
  function ubah(){
    $.ajax({
      url : "<?php echo site_url('berita/Berita/')?>" + berita_id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        console.log(data)
        $('[name="id"]').val(data.berita_id)
        $('[name="judul"]').val(data.judul)
        $(".cropit-preview-image").attr('src', '<?=$this->omdi->imgpath().'berita/'?>'+data.image).attr('width','100%')
        $("#summernote").summernote("code", data.konten)
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
  }
  function simpan(){
    input()
    $('#btnModal').text('Menyimpan..');
    $('#btnModal').attr('disabled',true);
    $.ajax({
      url:"<?=site_url('berita/validasi')?>",
      type: "POST",
      data: $('form').serialize(),
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

<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
      <style media="screen">
      .cropit-preview {
        width: 250px;
        height: 250px;
        margin: 5px auto;
      }
      .zoom-group{
        width: 250px;
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
          <div class="col-lg-5">
            <div class="panel panel-primary">
              <div class="panel-body">
                <!-- <form action="<?=site_url('PK/validasi')?>" method="POST" autocomplete="off"> -->
                <form id="form1" class="" autocomplete="off">
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control" name="pk" id="pk" placeholder="Program Keahlian" value="">
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <input type="text" class="form-control" name="singkatan" placeholder="Singkatan" value="">
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="image-editor">
                      <input type="file" name="image" class="cropit-image-input">
                      <button type="button" class="btn btn-success btn-sm" onclick="pilihgambar()">Pilih Gambar</button>
                      <div class="cropit-preview"></div>
                      <div class="zoom-group">
                        <div class="image-size-label">
                          Potong Gambar
                        </div>
                        <input type="range" id="zoom" class="cropit-image-zoom-input">
                      </div>
                      <input type="hidden" name="image-data" class="hidden-image-data" />
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <input type="hidden" name="id" value="">
                  <!-- <button type="button" name="button" onclick="input()">input</button>
                  <input type="submit" name="" value="submit"> -->
                  <!-- <div class="">
                    <button type="button" id="btnModal" class="btn btn-primary pull-right" onclick="simpan()">Simpan</button>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="panel panel-primary">
              <div class="panel-body">
                <!-- <form action="<?=site_url('PK/validasi')?>" method="POST" autocomplete="off"> -->
                <form id="form2" class="" autocomplete="off">
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <textarea name="deskripsi" id="summernote" class="form-control"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="">
                    <button type="button" id="btnModal" class="btn btn-primary pull-right" onclick="simpan()">Simpan</button>
                  </div>
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
      var type = $(this).prop("type");
      if (type !== 'file') {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      }
    });
    $("select").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });
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
      url : "<?php echo site_url('pk/pk/')?>" + pk_id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        console.log(data);
        $('[name="pk"]').val(data.nama)
        $('[name="singkatan"]').val(data.singkatan)
        $('[name="id"]').val(data.pk_id)
        $(".cropit-preview-image").attr('src', '<?=$this->omdi->imgpath().'pk/'?>'+data.logo).attr('width','100%')
        $("#summernote").summernote("code", data.deskripsi)
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
      url:"<?=site_url('pk/validasi')?>",
      type: "POST",
      data: $('form').serialize(),
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

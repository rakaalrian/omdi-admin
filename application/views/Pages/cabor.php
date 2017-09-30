<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <style media="screen">
  .cropit-preview {
    width: 365px;
    height: 150px;
    margin: 5px auto;
  }
  .zoom-group{
    width: 365px;
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
      <div class="col-lg-12">
        <button type="button" class="btn btn-primary" onclick="modalTambah()" name="button"><i class="fa fa-plus fa-fw"></i>Tambah</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tableCabor">
              <thead>
                <tr>
                  <th class="text-center" width="5%">NO</th>
                  <th class="text-center">CABANG OLAHRAGA</th>
                  <th class="text-center">LATAR BELAKANG</th>
                  <th class="text-center">AKSI</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content col-md-8 col-md-offset-2">
        <div class="modal-header">
          <div class="row">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 id="modal-title"></h4>
          </div>
        </div>
        <div class="modal-body">
          <!-- <form id="modalForm" name="modalForm" method="POST" autocomplete="off"> -->
          <!-- <form action="<?=site_url('Cabor/validasi')?>" id="modalForm" name="modalForm" method="POST" autocomplete="off"> -->
          <form action="javascript:simpan()" id="modalForm" name="modalForm" method="POST" autocomplete="off">
            <div class="form-group row">
              <input type="text" class="form-control" name="cabor" id="cabor" placeholder="Cabang Olahraga" value="">
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
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
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <button type="button" id="btnModal" class="btn btn-primary" onclick="simpan()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content col-md-7 col-md-offset-3">
        <div class="modal-header">
          <label class="modal-title">Apakah anda yakin ingin menghapus ?</label>
          <br>
          <br>
          <div class="text-right">
            <button type="button" class="btn btn-success btn-sm" name="hapus" id="btnHapus" onclick="hapus()">Ya</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true">Tidak</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('bottomhtml.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $("input").change(function(){
      var type = $(this).prop("type");
      if (type !== 'file') {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      }
    });
    $("textarea").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
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
      $(".cropit-preview").children().children().attr('width',false);
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

    tableCabor = $('#tableCabor').DataTable({
        language: language(),
        scrollY:'50vh',
        scrollCollapse: true,
        scrollX: true,
        ordering:false,
        processing: true,
        serverside: true,
        createdRow: function( row, data, dataIndex ) {
            $( row ).find("td:eq(0),td:eq(2),td:eq(3)").attr('class', 'text-center');
          },
        ajax: "<?=site_url('cabor/table')?>",
        drawCallback: function() {
          $('.imglink').magnificPopup({
            type: 'image',
            gallery: {
              enabled: true,
              navigateByImgClick: true,
              preload: [0,1], // Will preload 0 - before current, and 1 after the current image
            },
            image: {
              titleSrc: 'title'
            }
          })
        },
        columnDefs: [
          {
            targets: [ -1 ], //last column
            orderable: false, //set not orderable
          },
        ],
    })
    $('#modal').on('shown.bs.modal', function() {
      $('#cabor').focus()
    })
    $('#modal').on('hidden.bs.modal', function() {
      resetForm('modalForm')
    })
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
  function resetForm(formId){
    document.getElementById(formId).reset()
    $("#"+formId+" [name='cabor'],[name='imagedata']").parent().removeClass('has-error')
    $("#"+formId+" [name='cabor'],[name='imagedata']").next().empty()
    $("#"+formId+" [name='id']").val(null)
    $(".cropit-preview-image").attr('src', null)
    $(".cropit-preview-image").attr('style', 'transform-origin: left top 0px; will-change: transform;')
    $(".cropit-preview").removeClass('cropit-image-loaded');

    $(".image-size-label").hide()
    $(".cropit-image-zoom-input").hide()

    $('.image-editor').cropit('disable');
  }
  function reload_table(){
    tableCabor.ajax.reload(null,false);
  }
  function modalTambah(){
    $('#modal-title').text('Tambah Cabang Olahraga')
    $('#modal').modal('show')
  }
  function modalUbah(id){
    $.ajax({
      url : "<?php echo site_url('cabor/cabor/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#modal-title').text('Ubah Cabang Olahraga')
        $('#modal').modal('show')

        $('[name="id"]').val(data.cabor_id);
        $('[name="cabor"]').val(data.nama);
        $(".cropit-preview").children().children().attr('src', '<?=$this->omdi->imgpath().'cabor/'?>'+data.background).attr('width','100%')

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
  }
  var idHapus;
  function modalHapus(id){
    idHapus = id;
    $('#modalHapus').modal('show');
    $("#btnHapus").focus();
  }
  function hapus(){
    $('#btnHapus').text('Menghapus..');
    $('#btnHapus').attr('disabled',true);
    $.ajax({
      url : "<?php echo site_url('cabor/delete/')?>" + idHapus,
      type: "POST",
      success: function(data)
        {
          $('#modalHapus').modal('hide');
          reload_table();
          $('#btnHapus').text('Ya');
          $('#btnHapus').attr('disabled',false);
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
      url:"<?=site_url('cabor/validasi')?>",
      type: "POST",
      data: $('#modalForm').serialize(),
      dataType:"JSON",
      success:function(data){
        if (data.valid) {
          $('#modal').modal('hide');
          reload_table();
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error');
            $('[name="'+data.namafield[i]+'"]').next().text(data.texterror[i]);
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

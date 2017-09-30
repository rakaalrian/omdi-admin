<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h4 class="page-header"><b><?=$judul?></b></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="panel-group" id="accordion">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <b class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >
                  <u>Informasi Jadwal</u>
                </a>
              </b>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
              <div class="panel-body table-responsive">
                <table class="table">
                  <tr>
                    <th>Cabang Olahraga</th>
                    <td>:</td>
                    <td id="cabor"></td>
                    <th>Tanggal</th>
                    <td>:</td>
                    <td id="tgl"></td>
                  </tr>
                  <tr>
                    <th id="hbabak"></th>
                    <td>:</td>
                    <td id="babak"></td>
                    <th>Pukul</th>
                    <td>:</td>
                    <td id="pkl"></td>
                  </tr>
                  <tr>
                    <th>Lokasi</th>
                    <td>:</td>
                    <td id="lokasi"></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <button type="button" class="btn btn-primary" onclick="modalTambah()" id="tambah" name="button"><i class="fa fa-plus fa-fw"></i>Tambah</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tableDetail">
              <thead>
                <tr>
                  <th class="text-center" width="5%">NO</th>
                  <th class="text-center">PROGRAM KEAHLIAN</th>
                  <th class="text-center">POIN</th>
                  <th class="text-center">DESKRIPSI</th>
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
  <div class="modal fade" id="modalTambah" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content col-md-10 col-md-offset-1">
        <div class="modal-header">
          <div class="row">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
        </div>
        <div class="modal-body form">
          <form id="tform" action="javascript:simpan()" autocomplete="off">
            <div class="form-group row">
              <select class="pk form-control" name="pk[]" multiple size="15" >
                <!-- <option value="">Program Keahlian</option> -->
              </select>
              <span class="help-block"></span>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="from-group row">
            <button type="button" id="btnModal" class="btn btn-primary" onclick="simpannew()">Simpan</button>
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
            <h4 class="modal-title"></h4>
          </div>
        </div>
        <div class="modal-body form">
          <form id="dform" action="javascript:simpan()" autocomplete="off">
            <div class="form-group row">
              <select class="pk form-control" name="pk">
                <option value="">Program Keahlian</option>
              </select>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <input type="number" class="form-control" name="poin" value="0">
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <select class="form-control" name="satuan">
                <option value="">Satuan</option>
                <option value="Detik">Detik</option>
                <option value="Menit">Menit</option>
                <option value="Meter">Meter</option>
              </select>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <textarea class="form-control" name="deskripsi" cols="10"></textarea>
              <span class="help-block"></span>
            </div>
            <input type="hidden" id="id" name="id" value="">
          </form>
        </div>
        <div class="modal-footer">
          <div class="from-group row">
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
var jadwal_id = '<?=$this->uri->segment(3, 0);?>'
  $(document).ready(function(){
    tableDetail = $('#tableDetail').DataTable({
        language: language(),
        scrollY:'50vh',
        scrollCollapse: true,
        scrollX: true,
        ordering:false,
        processing: true,
        serverside: true,
        createdRow: function( row, data, dataIndex ) {
          $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(4)').attr('class', 'text-center')
        },
        ajax: "<?=site_url('jadwal/tabledetail/')?>"+jadwal_id,
        columnDefs: [
          {
            targets: [ -1 ], //last column
            orderable: false, //set not orderable
          },
        ],
    })
    //======
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
    })
    $("textarea").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    })
    //==========
    getOptions()
    getInfo()
    //=============
    $.datepicker.setDefaults($.datepicker.regional['id']);
    var tgl = $("#tgl").datepicker({
      changeMonth: true,
      changeYear: true,
      showAnim:"slideDown"
    })
    var wkt = $('#wkt').timepicker({
      dropdown: false,
      timeFormat: 'H:mm'
    })
    //=========
    $('#modalTambah').on('shown.bs.modal', function() {
      $('.pk').focus()
    })
    $('#modalTambah').on('hidden.bs.modal', function() {
      resetForm('tform')
    })
    $('#modal').on('shown.bs.modal', function() {
      $('.pk').focus()
    })
    $('#modal').on('hidden.bs.modal', function() {
      resetForm('dform')
    })
    //======
  })
  //DOCUMENT READY
  function getOptions(){
    $.getJSON("<?=site_url('pk/pks')?>", function(result) {
      var option = $(".pk");
      $.each(result, function(item) {
        option.append($("<option />").val(this.pk_id).html(this.nama+' ('+this.singkatan+')'))
      })
    })
  }
  function getInfo(){
    $.getJSON("<?=site_url('jadwal/infojadwal/')?>"+jadwal_id, function(result) {
      var cabor = result.cnama;
      if (/renang/.test(cabor.toLocaleLowerCase())) {
        $("#hbabak").html('Sub Renang')
      }else if (/atletik/.test(cabor.toLocaleLowerCase())) {
        $("#hbabak").html('Sub Atletik')
      }else {
        $("#hbabak").html('Babak')
      }
      $("#cabor").html(result.cnama)
      $("#babak").html(result.babak)
      $("#lokasi").html(result.lnama)
      var date = new Date(result.waktu).toLocaleString(['id'],{weekday: "short",month:'short',day:'numeric',year:'numeric'})
      var time = new Date(result.waktu).toLocaleString(['id'],{hour:'2-digit',minute:'2-digit'})
      time = time.replace(".",":")
      $("#tgl").html(date)
      $("#pkl").html(time+" WIB")
    })
  }
  function reload_table(){
    tableDetail.ajax.reload(null,false);
  }
  function resetForm(formId){
    document.getElementById(formId).reset()
    $("#"+formId+" input,select,textarea").parent().removeClass('has-error')
    $("#"+formId+" input,select,textarea").next().empty()
    $("#"+formId+" [type='hidden']").val(null)
  }
  function modalTambah(){
    $('.modal-title').text('Tambah Detail Peserta')
    $('#modalTambah').modal('show')
  }
  function modalUbah(id){
    $.ajax({
      url : "<?php echo site_url('jadwal/detailjadwal/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('.modal-title').text('Ubah Detail Peserta')
        $('#modal').modal('show')
        $('[name="id"]').val(data.jadwal_detail_id)
        $('[name="pk"]').val(data.pk_id)
        $('[name="poin"]').val(data.poin)
        $('[name="satuan"]').val(data.satuan)
        $('[name="deskripsi"]').val(data.deskripsi)
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
      url : "<?php echo site_url('jadwal/deleteDetail/')?>" + idHapus,
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
  function simpannew(){
    $('#btnModal').text('Menyimpan..');
    $('#btnModal').attr('disabled',true);
    $.ajax({
      url:"<?=site_url('jadwal/validasiDetail')?>",
      type: "POST",
      data: $('#tform').serialize()+'&jadwal_id='+jadwal_id,
      dataType:"JSON",
      success:function(data){
        // console.log(data);
        if (data.valid) {
          $('#modalTambah').modal('hide');
          reload_table();
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error')
            $('[name="'+data.namafield[i]+'"]').next().text(data.texterror[i])
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
  function simpan(){
    $('#btnModal').text('Menyimpan..');
    $('#btnModal').attr('disabled',true);
    $.ajax({
      url:"<?=site_url('jadwal/validasiDetail')?>",
      type: "POST",
      data: $('#dform').serialize()+'&jadwal_id='+jadwal_id,
      dataType:"JSON",
      success:function(data){
        // console.log(data);
        if (data.valid) {
          $('#modal').modal('hide');
          reload_table();
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            $('[name="'+data.namafield[i]+'"]').parent().addClass('has-error')
            $('[name="'+data.namafield[i]+'"]').next().text(data.texterror[i])
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

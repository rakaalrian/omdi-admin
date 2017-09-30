<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h4 class="page-header"><b><?=$judul?></b></h4>
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
            <table width="100%" class="table table-striped table-bordered table-hover" id="tableJadwal">
              <thead>
                <tr>
                  <th class="text-center" width="5%">NO</th>
                  <th class="text-center">CABOR</th>
                  <th class="text-center">BABAK</th>
                  <th class="text-center">LOKASI</th>
                  <th class="text-center">WAKTU</th>
                  <th class="text-center">STATUS</th>
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
        <div class="modal-body form">
          <form id="jform" action="javascript:simpan()" autocomplete="off">
            <div class="form-group row">
              <select class="form-control" id="cabor" name="cabor" onchange="getBabak()">
                <option value="">Cabang Olahraga</option>
              </select>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <select class="form-control" id="babak" name="babak">
                <option value="">Babak</option>
              </select>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <select class="form-control" id="lokasi" name="lokasi">
                <option value="">Lokasi</option>
              </select>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <input class="form-control" type="text" placeholder="Tanggal" id="tgl" name="tgl" value="" readonly>
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <input class="form-control" type="text" placeholder="Waktu (format 24 jam)" id="wkt" name="wkt" value="">
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
  <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content col-md-7 col-md-offset-3">
            <div class="modal-header">
              <label class="modal-title" id="title-status"></label>
              <br>
              <br>
              <div class="text-right">
                <button type="button" class="btn btn-success btn-sm" name="hapus" id="btnStatus" onclick="ubahStatus()">Ya</button>
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
    tableJadwal = $('#tableJadwal').DataTable({
        language: language(),
        scrollY:'50vh',
        scrollCollapse: true,
        scrollX: true,
        ordering:false,
        processing: true,
        serverside: true,
        createdRow: function( row, data, dataIndex ) {
          $(row).attr('class', 'text-center')
          var date = new Date(data['4']).toLocaleString(['id'],{weekday: "short",month:'short',day:'numeric',year:'numeric'})
          var time = new Date(data['4']).toLocaleString(['id'],{hour:'2-digit',minute:'2-digit'})
          time = time.replace(".",":")
          $(row).find('td:eq(4)').text(date+' | '+time+' WIB')
        },
        ajax: "<?=site_url('jadwal/table')?>",
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
    //==========
    getOptions()
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
    $('#modal').on('shown.bs.modal', function() {
      $('#cabor').focus()
    })
    $('#modal').on('hidden.bs.modal', function() {
      resetForm('jform')
    })
    //======
  })
  //DOCUMENT READY
  function getBabak(){
    var cabor = $("#cabor option:selected").text();
    if (/renang/.test(cabor.toLocaleLowerCase())) {
      $("#babak").html('<option value="">Sub Renang</option>')
      $("#babak").append($("<option />").val("Gaya Dada").text("Gaya Dada"))
      $("#babak").append($("<option />").val("Gaya Kupu-kupu").text("Gaya Kupu-kupu"))
      $("#babak").append($("<option />").val("Gaya Punggung").text("Gaya Punggung"))
      $("#babak").append($("<option />").val("Gaya Bebas").text("Gaya Bebas"))
    }else if (/atletik/.test(cabor.toLocaleLowerCase())) {
      $("#babak").html('<option value="">Sub Atletik</option>')
      $("#babak").append($("<option />").val("Estafet").text("Estafet"))
      $("#babak").append($("<option />").val("Lompat Jauh").text("Lompat Jauh"))
      $("#babak").append($("<option />").val("Marathon").text("Marathon"))
      $("#babak").append($("<option />").val("Sprint 100 Meter").text("Sprint 100 Meter"))
    }else {
      $("#babak").html('<option value="">Babak</option>')
      $("#babak").append($("<option />").val("Penyisihan").text("Penyisihan"))
      $("#babak").append($("<option />").val("Perdelapan Besar").text("Perdelapan Besar"))
      $("#babak").append($("<option />").val("Perempat Besar").text("Perempat Besar"))
      $("#babak").append($("<option />").val("Semi Final").text("Semi Final"))
      $("#babak").append($("<option />").val("Final").text("Final"))
    }
  }
  function getOptions(){
    $.getJSON("<?=site_url('cabor/cabors')?>", function(result) {
      var option = $("#cabor");
      $.each(result, function(item) {
        option.append($("<option />").val(this.cabor_id).text(this.nama))
      })
    })
    $.getJSON("<?=site_url('lokasi/lokasis')?>", function(result) {
      var option = $("#lokasi");
      $.each(result, function(item) {
        option.append($("<option />").val(this.lokasi_id).text(this.nama))
      })
    })
  }
  function reload_table(){
    tableJadwal.ajax.reload(null,false);
  }
  function resetForm(formId){
    document.getElementById(formId).reset();
    $("#"+formId+" input,select").parent().removeClass('has-error');
    $("#"+formId+" input,select").next().empty();
    $("#"+formId+" [type='hidden']").val(null)
  }
  function modalTambah(){
    $('#modal-title').text('Tambah Jadwal')
    $('#modal').modal('show')
  }
  function modalUbah(id){
    $.ajax({
      url : "<?php echo site_url('jadwal/jadwal/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#modal-title').text('Ubah Jadwal')
        $('#modal').modal('show')

        $('[name="id"]').val(data.jadwal_id)
        $('[name="cabor"]').val(data.cabor_id)
        getBabak()
        $('[name="babak"]').val(data.babak)
        $('[name="lokasi"]').val(data.lokasi_id)
        var tgl = data.waktu.slice(0,10)
        var wkt = data.waktu.slice(11,16)
        $('[name="tgl"]').val(tgl)
        $('[name="wkt"]').val(wkt)

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
      url : "<?php echo site_url('jadwal/delete/')?>" + idHapus,
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
  var idStatus, status;
  function modalStatus(id,sts){
    idStatus = id
    status = sts
    $('#modalStatus').modal('show')
    if (sts==1) {
      $('#title-status').html('Pertandingan ini <u>sudah</u> selesai?')
    }else {
      $('#title-status').html('Pertandingan ini <u>belum</u> selesai?')
    }
  }
  function ubahStatus(){
    $('#btnStatus').text('Menyimpan..');
    $('#btnStatus').attr('disabled',true);
    $.ajax({
      url : "<?php echo site_url('jadwal/status/')?>"+idStatus+'/'+status,
      type: "POST",
      success: function()
        {
          $('#modalStatus').modal('hide');
          reload_table();
          $('#btnStatus').text('Ya');
          $('#btnStatus').attr('disabled',false);
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
    $.ajax({
      url:"<?=site_url('jadwal/validasi')?>",
      type: "POST",
      data: $('form').serialize(),
      dataType:"JSON",
      success:function(data){
        // console.log(data);
        if (data.valid) {
          $('#modal').modal('hide');
          reload_table();
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            if (data.namafield[i]!=='tgl') {
              $('[name="'+data.namafield[i]+'"]').focus();
            }
            if (data.namafield[0]=='tgl') {
              $('[name="'+data.namafield[i]+'"]').focus();
            }
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

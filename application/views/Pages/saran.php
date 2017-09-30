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
        <div class="panel panel-primary">
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="tableSaran">
              <thead>
                <tr>
                  <th class="text-center" width="5%">NO</th>
                  <!-- <th class="text-center" width="20%">Email</th> -->
                  <th class="text-center" width="50%">KRITIK & SARAN</th>
                  <th class="text-center" width="20%">WAKTU</th>
                  <th class="text-center" width="10%">AKSI</th>
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
  <div class="modal fade" id="modal">
    <div class="modal-dialog">
      <div class="modal-content col-md-10 col-md-offset-1">
        <div class="modal-header">
          <div class="row">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 id="modal-title">Kritik & Saran</h4>
          </div>
        </div>
        <div class="modal-body" id="modal-body">
          <div class="row text-justify">

          </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" id="btnModal" class="btn btn-primary" onclick="simpan()">Simpan</button>
        </div> -->
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
    tableSaran = $('#tableSaran').DataTable({
      language: language(),
      scrollY:'50vh',
      scrollCollapse: true,
      scrollX: true,
      ordering:false,
      processing: true,
      serverside: true,
      createdRow: function( row, data, dataIndex ) {
          $( row ).find("td:eq(0),td:eq(2),td:eq(3)").attr('class', 'text-center');
          var date = new Date(data['2']).toLocaleString(['id'],{weekday: "short",month:'short',day:'numeric',year:'numeric'})
          var time = new Date(data['2']).toLocaleString(['id'],{hour:'2-digit',minute:'2-digit'})
          time = time.replace(".",":")
          $(row).find('td:eq(2)').text(date+' | '+time+' WIB')
      },
      ajax: "<?=site_url('saran/table')?>",
      columnDefs: [
        {
          targets: [ -1 ], //last column
          orderable: false, //set not orderable
        },
      ],
    })
  })
  function reload_table(){
    tableSaran.ajax.reload(null,false);
  }
  function modalDetail(id){
    $.ajax({
      url : "<?php echo site_url('saran/saran/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        // $('#modal-title').text(data.email)
        $('#modal-body').children().text(data.saran)
        $('#modal').modal('show')
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
      url : "<?php echo site_url('saran/delete/')?>" + idHapus,
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
</script>

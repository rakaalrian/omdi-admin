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
        <a href="<?=site_url('pk/tambah')?>" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i>Tambah</a>
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
                  <th class="text-center" width="20%">PROGRAM KEAHLIAN</th>
                  <th class="text-center" width="20%">LOGO</th>
                  <th class="text-center" width="50%">FILOSOFI LOGO</th>
                  <th class="text-center" width="5%">AKSI</th>
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
    tableCabor = $('#tableCabor').DataTable({
        language: language(),
        scrollY:'50vh',
        scrollCollapse: true,
        scrollX: true,
        ordering:false,
        processing: true,
        serverside: true,
        createdRow: function( row, data, dataIndex ) {
            $( row ).find("td:eq(0),td:eq(2),td:eq(4)").attr('class', 'text-center');
        },
        ajax: "<?=site_url('pk/table')?>",
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
  })
  function reload_table(){
    tableCabor.ajax.reload(null,false);
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
      url : "<?php echo site_url('pk/delete/')?>" + idHapus,
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

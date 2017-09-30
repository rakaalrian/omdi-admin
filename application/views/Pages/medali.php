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
            <table width="100%" class="table table-striped table-bordered table-hover" id="tableMedali">
              <thead>
                <tr>
                  <th class="text-center" width="5%">NO</th>
                  <th class="text-center" width="5%">PERINGKAT</th>
                  <th class="text-center">PROGRAM KEAHLIAN</th>
                  <th class="text-center">EMAS</th>
                  <th class="text-center">PERAK</th>
                  <th class="text-center">PERUNGGU</th>
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
          <form id="mform" action="javascript:simpan()" autocomplete="off">
            <div class="form-group row">
              <label for="emas">Emas</label>
              <input type="number" class="form-control" name="emas" id="emas" value="0" min="0" placeholder="Emas">
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <label for="perak">Perak</label>
              <input type="number" class="form-control" name="perak" value="0" min="0" placeholder="Perak">
              <span class="help-block"></span>
            </div>
            <div class="form-group row">
              <label for="perunggu">Perunggu</label>
              <input type="number" class="form-control" name="perunggu" value="0" min="0" placeholder="Perunggu">
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
</div>
<?php $this->load->view('bottomhtml.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    tableMedali = $('#tableMedali').DataTable({
        language: language(),
        scrollY:'50vh',
        scrollCollapse: true,
        scrollX: true,
        ordering:false,
        processing: true,
        serverside: true,
        createdRow: function( row, data, dataIndex ) {
          $(row).find('td:eq(0),td:eq(1),td:eq(3),td:eq(4),td:eq(5),td:eq(6)').attr('class', 'text-center')
        },
        ajax: "<?=site_url('medali/table')?>",
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
    })
    //=========
    $('#modal').on('shown.bs.modal', function() {
      $('#emas').focus()
    })
    $('#modal').on('hidden.bs.modal', function() {
      resetForm('mform')
    })
    //======
  })
  //DOCUMENT READY
  function reload_table(){
    tableMedali.ajax.reload(null,false);
  }
  function resetForm(formId){
    document.getElementById(formId).reset()
    $("#"+formId+" input,select,textarea").parent().removeClass('has-error')
    $("#"+formId+" input,select,textarea").next().empty()
    $("#"+formId+" [type='hidden']").val(null)
  }
  function modalUbah(id){
    $.ajax({
      url : "<?php echo site_url('medali/medali/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#modal-title').text(data.nama+' ('+data.singkatan+')')
        $('#modal').modal('show')
        $('[name="emas"]').val(data.emas)
        $('[name="perak"]').val(data.perak)
        $('[name="perunggu"]').val(data.perunggu)
        $('[name="id"]').val(data.medali_id)
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
      url:"<?=site_url('medali/validasi')?>",
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

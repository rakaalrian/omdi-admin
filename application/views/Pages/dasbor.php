<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h4 class="page-header"><b><?=$judul?></b></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
          <a href="<?=site_url('jadwal')?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-warning fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="countBelum"></div>
                        <div>Jadwal Belum Terlaksana</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left">Lihat Detail</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
          <a href="<?=site_url('jadwal')?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="countSudah"></div>
                        <div>Jadwal Sudah Terlaksana</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left">Lihat Detail</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-default">
          <a href="<?=site_url('saran')?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="countSaran"></div>
                        <div>Kritik & Saran</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">Lihat Detail</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel-group">
          <div class="panel panel-primary">
            <a data-toggle="collapse" href="#collapseOne" style="">
              <div class="panel-heading panel-title">
                  <b>Peringkat</b>
              </div>
            </a>
            <div id="collapseOne" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="text-center">

                </div>
                <canvas id="chartPeringkat" style=""></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('bottomhtml.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    countJadwal()
    countSaran()
    setInterval(countSaran,10000*60)
    chartPeringkat()
  })
  function chartPeringkat(){
    $.getJSON("<?=site_url('dasbor/chartPeringkat')?>")
    .done(function(data) {
      var pk = []
      var perunggu = []
      var perak = []
      var emas = []

      var len = data.length;
      // console.log(len);
      for(var i=0;i<len;i++){
        pk.push(data[i].pk);
        perunggu.push(data[i].perunggu);
        perak.push(data[i].perak);
        emas.push(data[i].emas);
      }
      if (len>0) {
        var data = {
          labels : pk,
          datasets : [
            {
              label : 'Perunggu ',
              data : perunggu,
              backgroundColor : '#c37d39'
            },{
              label : 'Perak ',
              data : perak,
              backgroundColor : '#d4cece'
            },{
              label : 'Emas ',
              data : emas,
              backgroundColor : '#e8c03f'
            }
          ]
        }
        var options = {
          scales: {
            xAxes: [{
              ticks: {
                userCallback: function(label, index, labels) {
                  if (Math.floor(label) === label) {
                    return label;
                  }
                }
              },
              stacked: true,
              scaleLabel: {
                display: true,
                labelString: 'PEROLEHAN MEDALI',
                fontColor: '#185999',
                fontStyle: 'bold',
                fontSize: '16'
              }
            }],
            yAxes: [{
              stacked: true,
              scaleLabel: {
                display: true,
                labelString: 'PERINGKAT',
                fontColor: '#185999',
                fontStyle: 'bold',
                fontSize: '16'
              },
              maxBarThickness: 40,
              // categoryPercentage: 1,
              // barPercentage: 1,
            }]
          },
          maintainAspectRatio: false,
          // responsive: true,
        }

        var height = 160
        if (len>1) {
          height += 50*(len-1)
        }
        $('#chartPeringkat').parent().css('height',height+'px')

        var ctx2 = document.getElementById("chartPeringkat");
        var chartPeringkat = new Chart(ctx2, {
          type : 'horizontalBar',
          data : data,
          options : options
        })
      }else {
        $('#chartPeringkat').attr('height','0')
        $('#chartPeringkat').prev().html('<b>Data Tidak Ditemukan</b>')
      }
    })
    .fail(function( jqxhr, textStatus, error ) {
      var err = textStatus + ", " + error;
      console.log( "Request Failed: " + err );
    });
  }
  function countJadwal(){
    $.getJSON("<?=site_url('dasbor/countJadwal')?>")
    .done(function(data){
      $("#countBelum").text(data.belum)
      $("#countSudah").text(data.sudah)
    })
    .fail(function( jqxhr, textStatus, error ) {
      var err = textStatus + ", " + error;
      console.log( "Request Failed: " + err );
    });
  }
  function countSaran(){
    $.getJSON("<?=site_url('dasbor/countSaran')?>")
    .done(function(data){
      $("#countSaran").text(data)
      console.log(data);
    })
    .fail(function( jqxhr, textStatus, error ) {
      var err = textStatus + ", " + error;
      console.log( "Request Failed: " + err );
    });
  }
</script>

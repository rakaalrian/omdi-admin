<?php $this->load->view('tophtml.php'); ?>
<div id="wrapper">
  <style media="screen">
  #map {
    width: 100%;
    height: 400px;
    margin: 0 auto;
    background-color: grey;
  }
  .controls {
    margin-top: 10px;
    /*border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;*/
    height: 32px;
    /*outline: none;*/
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  }

  #pac-input {
    /*background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;*/
    width: 300px;
  }

  #pac-input:focus {
    /*border-color: #4d90fe;*/
  }

  .pac-container {
    font-family: Roboto;
  }

  #type-selector {
    color: #fff;
    background-color: #4d90fe;
    padding: 5px 11px 0px 11px;
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
        <div class="panel panel-primary">
          <div class="panel-body">
            <form class="" action="javascript:simpan()">
              <div class="form-group">
                <input type="text" class="form-control" name="lokasi" id="lokasi" value="" placeholder="Nama Lokasi">
                <span class="help-block"></span>
              </div>
              <input type="hidden" name="lat" id="lat" value="">
              <input type="hidden" name="lng" id="lng" value="">
              <input type="hidden" name="id" id="id" value="">
              <div class="">
                <input id="pac-input" class="controls form-control" type="text" placeholder="Cari Tempat">
                <div id="map"></div>
                <span class="help-block"></span>
              </div>
              <div class="form-group text-right">
                <button type="button" id="btnModal" class="btn btn-primary" onclick="simpan()">Simpan</button>
                <span class="help-block"></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('bottomhtml.php'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjIIVIJHB4f7ozYRHQeibuOxgV25JEVs4&signed_in=true&libraries=places"></script>
<script type="text/javascript">
var lokasi_id = '<?=$this->uri->segment(3, 0);?>'
  $(document).ready(function(){
    $("#pk").focus()
    $("input").change(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    })
    $("#map").click(function(){
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    })
    if (lokasi_id>0) {
      ubah()
    }
  })
  //DOCUMENT READY
  google.maps.event.addDomListener(window, 'load', initMap)
  function initMap(){
    var lat, lng
    var myLatLng, choosen, map

    if (lokasi_id>0) {
      var lat = Number($('#lat').val())
      var lng = Number($('#lng').val())
      myLatLng = {lat: lat, lng: lng}
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: myLatLng
      })
      getmarker(lat,lng)
    }else {
      myLatLng = {lat: -6.597576, lng:106.7956653}
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: myLatLng
      })
    }

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();
      if (places.length == 0) {
        return;
      }
      markers = [];
      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      // console.log(places[0].geometry.location.lat(),places[0].geometry.location.lng(),'atas');
      getmarker(places[0].geometry.location.lat(), places[0].geometry.location.lng())
      if (places[0].geometry.viewport) {
        bounds.union(places[0].geometry.viewport);
      } else {
        bounds.extend(places[0].geometry.location);
      }
      map.fitBounds(bounds);
    })

    map.addListener("click", function(event) {
      lat = event.latLng.lat();
      lng = event.latLng.lng();
      // console.log(lat,lng)
      getmarker(lat,lng)
    })

    function getmarker(lat, lng){
      clear()
      $('#lat').val(lat)
      $('#lng').val(lng)
      choosen = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
      })
      choosen.addListener("drag", function(event){
        lat = event.latLng.lat();
        lng = event.latLng.lng();
        $('#lat').val(lat)
        $('#lng').val(lng)
      })
      choosen.addListener("dblclick", function(event){
        clear()
        $('#lat').val(null)
        $('#lng').val(null)
      })
    }
    function clear(){
      if(choosen){
        choosen.setMap(null);
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
      }
      markers = []
      marker = ''
      choosen = ''
    }
  }
  function ubah(){
    // console.log('ubah');
    $.ajax({
      url : "<?php echo site_url('lokasi/lokasi/')?>" + lokasi_id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('[name="lokasi"]').val(data.nama)
        $('[name="id"]').val(data.lokasi_id)
        $('[name="lat"]').val(data.lat)
        $('[name="lng"]').val(data.lng)
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
      url:"<?=site_url('lokasi/validasi')?>",
      type: "POST",
      data: $('form').serialize(),
      dataType:"JSON",
      success:function(data){
        if (data.valid) {
          window.location.href = "<?=site_url('lokasi')?>";
        }else{
          for (var i = data.namafield.length; i >= 0; i--)
          {
            $('[name="'+data.namafield[i]+'"]').focus();
            if (data.namafield[i]=='lng') {
              $('#map').parent().addClass('has-error')
              $('#map').next().text('Lokasi Peta Wajib Dipilih')
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

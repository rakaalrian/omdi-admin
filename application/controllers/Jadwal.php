<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('JadwalModel');
    $this->load->model('DetailModel');
  }
  private $judul = '<i class="fa fa-table fa-fw"></i> Jadwal Pertandingan';
  public function index(){
    $data['judul']=$this->judul;
    $this->load->view('Pages/jadwal',$data);
  }
  public function table(){
    $jadwals = $this->JadwalModel->getJadwals('*,c.nama as cnama, l.nama as lnama',false,false,'status,waktu');
    $data = array();
    $no = 0;
    foreach ($jadwals as $jadwal) {
      $no++;
      $status = $jadwal->status;
      if ($status) {
        $status = '<button class="btn btn-success btn-sm" onclick="modalStatus('.$jadwal->jadwal_id.',0)">Selesai</button>';
      }else {
        $status = '<button class="btn btn-warning btn-sm" onclick="modalStatus('.$jadwal->jadwal_id.',1)">Belum</button>';
      }
      $actions = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="'.site_url('jadwal/detail/'.$jadwal->jadwal_id).'"><i class="fa fa-eye fa-fw"></i>Detail</a></li>
          <li><a onclick="modalUbah('.$jadwal->jadwal_id.')"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
          <li><a onclick="modalHapus('.$jadwal->jadwal_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
        </ul>
      </div>';
      $row = array();
      $row[] = $no;
      $row[] = $jadwal->cnama;
      $row[] = $jadwal->babak;
      $row[] = $jadwal->lnama;
      $row[] = $jadwal->waktu;
      $row[] = $status;
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function jadwal($id=false){
    if ($id) {
      $data = $this->JadwalModel->getJadwal('j.*',array('jadwal_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function validasi(){
    $this->omdi->set_my_message();

    $this->form_validation->set_rules('cabor', 'Cabang Olahraga', 'trim|required');
    $this->form_validation->set_rules('babak', 'Bidang ini', 'trim|required');
    $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
    $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');
    // $this->form_validation->set_rules('wkt', 'Waktu', 'trim|required|regex_match[/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/]');
    $this->form_validation->set_rules('wkt', 'Waktu', array('trim','required','regex_match[/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/]'));
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('cabor')) {
        $data['namafield'][]='cabor';
        $data['texterror'][]=form_error('cabor');
      }
      if (form_error('babak')) {
        $data['namafield'][]='babak';
        $data['texterror'][]=form_error('babak');
      }
      if (form_error('lokasi')) {
        $data['namafield'][]='lokasi';
        $data['texterror'][]=form_error('lokasi');
      }
      if (form_error('tgl')) {
        $data['namafield'][]='tgl';
        $data['texterror'][]=form_error('tgl');
      }
      if (form_error('wkt')) {
        $data['namafield'][]='wkt';
        $data['texterror'][]=form_error('wkt');
      }
    }else {
      if ($this->input->post('id')==null) {
        $this->insert();
      }else {
        $this->update();
      }
    }
    echo json_encode($data);
  }
  public function insert(){
    $tgl = date('Y-m-d',strtotime($this->input->post('tgl')));
    $wkt = $this->input->post('wkt');
    $datajadwal = array(
      'cabor_id' => $this->input->post('cabor'),
      'babak' => $this->input->post('babak'),
      'lokasi_id' => $this->input->post('lokasi'),
      'waktu' => $tgl.' '.$wkt.':00',
      'status' => '0'
    );
    $this->JadwalModel->insertJadwal($datajadwal);
  }
  public function update(){
    $tgl = date('Y-m-d',strtotime($this->input->post('tgl')));
    $wkt = $this->input->post('wkt');
    $datajadwal = array(
      'cabor_id' => $this->input->post('cabor'),
      'babak' => $this->input->post('babak'),
      'lokasi_id' => $this->input->post('lokasi'),
      'waktu' => $tgl.' '.$wkt.':00'
    );
    $this->JadwalModel->updateJadwal($datajadwal,array('jadwal_id'=>$this->input->post('id')));
  }
  public function delete($id=false){
    if ($id) {
      $this->JadwalModel->deleteJadwal(array('jadwal_id'=>$id));
    }else {
      echo "Pilih id";
    }
  }
  public function status($id=false, $sts=false){
    if ($id!=null && $sts!=null) {
      $this->JadwalModel->updateJadwal(array('status'=>$sts),array('jadwal_id'=>$id));
    }else {
      echo "Pilih id";
    }
  }

  //==============Detail
  public function detail($id=false){
    if ($id) {
      $jadwal = $this->JadwalModel->getJadwal('jadwal_id',array('jadwal_id'=>$id));
      if (isset($jadwal)) {
        $data['judul']='<a href="'.site_url('jadwal').'">'.$this->judul.'</a> / <i class="fa fa-eye fa-fw"></i> / '.$id;
        $this->load->view('Pages/detail',$data);
      }else {
        redirect('jadwal');
      }
    }else {
      redirect('jadwal');
    }
  }
  public function tabledetail($id){
    if ($id) {
      $jdetails = $this->DetailModel->getDetails('nama,singkatan,d.*',array('jadwal_id'=>$id),false,'poin,jadwal_detail_id',false);
      $data = array();
      $no = 0;
      foreach ($jdetails as $jdetail) {
        $no++;
        $actions = '<div class="btn-group btn-table">
          <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            Aksi
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a onclick="modalUbah('.$jdetail->jadwal_detail_id.')"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
            <li><a onclick="modalHapus('.$jdetail->jadwal_detail_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
          </ul>
        </div>';
        $row = array();
        $row[] = $no;
        $row[] = $jdetail->nama.' ('.$jdetail->singkatan.')';
        $row[] = $jdetail->poin;
        $row[] = substr($jdetail->deskripsi,0,50).'...';
        $row[] = $actions;
        $data[] = $row;
      }
      $output = array(
        "data" => $data,
      );
      echo json_encode($output);
    }else {
      echo "Pilih id";
    }
  }
  public function detailjadwal($id=false){
    if ($id) {
      $data = $this->DetailModel->getDetail('*',array('jadwal_detail_id'=>$id));
      $exploded = explode(' ',$data->poin);
      $poin = $exploded[0];
      if (isset($exploded[1])) {
        $satuan = $exploded[1];
      }else {
        $satuan = "";
      }
      $data = array(
        "jadwal_detail_id" => $data->jadwal_detail_id,
        "jadwal_id" => $data->jadwal_id,
        "pk_id" => $data->pk_id,
        "poin" => $poin,
        "satuan" => $satuan,
      );
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function infojadwal($id=false){
    if ($id) {
      $data = $this->JadwalModel->getJadwal('c.nama as cnama, babak, l.nama as lnama, waktu',array('jadwal_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function validasiDetail(){
    $this->omdi->set_my_message();

    if ($this->input->post('id')==null) {
      $this->form_validation->set_rules('pk', 'Program Keahlian', 'callback_multiple_select');
      $pkfield = "pk[]";
    }else {
      $this->form_validation->set_rules('pk', 'Program Keahlian', 'trim|required|callback_valid_pk['.$this->input->post('jadwal_id').','.$this->input->post('id').']');
      $this->form_validation->set_rules('poin', 'Poin', 'trim|required|greater_than_equal_to');
      $pkfield = "pk";
    }
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|max_length[255]');
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('pk')) {
        $data['namafield'][]=$pkfield;
        $data['texterror'][]=form_error('pk');
      }
      if (form_error('poin')) {
        $data['namafield'][]='poin';
        $data['texterror'][]=form_error('poin');
      }
      if (form_error('deskripsi')) {
        $data['namafield'][]='deskripsi';
        $data['texterror'][]=form_error('deskripsi');
      }
    }else {
      if ($this->input->post('id')==null) {
        $this->insertDetail($this->input->post('pk'));
      }else {
        $this->updateDetail();
      }
    }
    echo json_encode($data);
  }
  public function valid_pk($str,$param){
    $param = explode(",",$param);
    $jid = $param[0];
    $did = $param[1];
    $pk = $this->DetailModel->getDetail('jadwal_detail_id',array('pk_id'=>$str,'jadwal_id'=>$jid));
    if (!isset($pk->jadwal_detail_id)) {
      return true;
    }else {
      if (!empty($did)) {
        $lama = $this->DetailModel->getDetail('pk_id',array('jadwal_detail_id'=>$did));
        if ($lama->pk_id==$str) {
          return true;
        }else {
          $this->form_validation->set_message('valid_pk','{field} sudah ada');
          return false;
        }
      }else {
        $this->form_validation->set_message('valid_pk','{field} sudah ada');
        return false;
      }
    }
  }
  public function multiple_select(){
    $pks = $this->input->post('pk');
    if(empty($pks)){
      $this->form_validation->set_message('multiple_select','{field} harus dipilih minimal 1');
      return false;
    }else {
      return true;
    }
  }
  public function insertDetail($pks){
    $jadwal_id = $this->input->post('jadwal_id');
    foreach ($pks as $pk) {
      $cekpk = $this->DetailModel->getDetail('jadwal_detail_id',array('pk_id'=>$pk,'jadwal_id'=>$jadwal_id));
      // echo $pk.'<br>';
      if (!isset($cekpk->jadwal_detail_id)) {
        $datadetail = array(
          'pk_id' => $pk,
          'jadwal_id' => $jadwal_id,
          'poin' => '0',
          'deskripsi' => ''
        );
        $this->DetailModel->insertDetail($datadetail);
      }
    }
  }
  public function updateDetail(){
    if ($this->input->post('satuan')!=="") {
      $poin = $this->input->post('poin').' '.$this->input->post('satuan');
    }else {
      $poin = $this->input->post('poin');
    }
    $datadetail = array(
      'pk_id' => $this->input->post('pk'),
      'poin' => $poin,
      'deskripsi' => $this->input->post('deskripsi')
    );
    $this->DetailModel->updateDetail($datadetail,array('jadwal_detail_id'=>$this->input->post('id')));
  }
  public function deleteDetail($id=false){
    if ($id) {
      $this->DetailModel->deleteDetail(array('jadwal_detail_id'=>$id));
    }else {
      echo "Pilih id";
    }
  }
}

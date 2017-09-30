<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('LokasiModel');
  }
  private $judul = '<i class="fa fa-map-marker fa-fw"></i> Lokasi';
  public function index(){
    $data['judul'] = $this->judul;
    $this->load->view('Pages/Lokasi/lokasi',$data);
  }
  public function table(){
    $lokasis = $this->LokasiModel->getLokasis('*',false,false,'nama');
    $data = array();
    $no = 0;
    foreach ($lokasis as $lokasi) {
      $no++;
      $actions = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="'.site_url('lokasi/ubah/'.$lokasi->lokasi_id).'"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
          <li><a onclick="modalHapus('.$lokasi->lokasi_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
        </ul>
      </div>';
      $map = '
        <button class="btn btn-info btn-sm" onclick="modalMap('.$lokasi->lat.','.$lokasi->lng.',\''.$lokasi->nama.'\')">Lihat Peta</button>
      ';
      $row = array();
      $row[] = $no;
      $row[] = $lokasi->nama;
      $row[] = $map;
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function lokasi($id=false){
    if ($id) {
      $data = $this->LokasiModel->getLokasi('*',array('lokasi_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function lokasis(){
    $data = $this->LokasiModel->getLokasis('lokasi_id,nama',false,false,'nama');
    echo json_encode($data);
  }
  public function validasi(){
    $this->omdi->set_my_message();

    $this->form_validation->set_rules('lokasi', 'Nama Lokasi', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('lng', 'Lokasi Peta', 'trim|required');
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('lokasi')) {
        $data['namafield'][]='lokasi';
        $data['texterror'][]=form_error('lokasi');
      }
      if (form_error('lng')) {
        $data['namafield'][]='lng';
        $data['texterror'][]=form_error('lng');
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
    $datalokasi = array(
      "nama" => ucwords($this->input->post('lokasi')),
      "lat" => $this->input->post('lat'),
      "lng" => $this->input->post('lng')
    );
    $this->LokasiModel->insertLokasi($datalokasi);
  }
  public function update(){
    $datalokasi = array(
      "nama" => ucwords($this->input->post('lokasi')),
      "lat" => $this->input->post('lat'),
      "lng" => $this->input->post('lng')
    );
    $this->LokasiModel->updateLokasi($datalokasi,array('lokasi_id'=>$this->input->post('id')));
  }
  public function delete($id=false){
    if ($id) {
      $this->LokasiModel->deleteLokasi(array('lokasi_id'=>$id));
    }
    else {
      echo "Pilih id";
    }
  }
  public function tambah(){
    $data['judul']= '<a href="'.site_url('lokasi').'">'.$this->judul.'</a> / <i class="fa fa-plus fa-fw"></i>';
    $this->load->view('Pages/Lokasi/tambah',$data);
  }
  public function ubah($id=false){
    if ($id) {
      $lokasi = $this->LokasiModel->getLokasi('lokasi_id',array('lokasi_id'=>$id));
      if (isset($lokasi)) {
        $data['judul']= '<a href="'.site_url('lokasi').'">'.$this->judul.'</a> / <i class="fa fa-pencil fa-fw"></i> / '.$lokasi->lokasi_id;
        $this->load->view('Pages/Lokasi/tambah',$data);
      }else {
        redirect('lokasi');
      }
    }
    else {
      redirect('lokasi');
    }
  }
}

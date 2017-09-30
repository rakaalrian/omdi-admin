<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pk extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('PKModel');
  }
  private $judul = '<i class="fa fa-flag fa-fw"></i> Program Keahlian';
  public function index(){
    $data['judul'] = $this->judul;
    $this->load->view('Pages/PK/pk',$data);
  }
  public function table(){
    $PKs = $this->PKModel->getPKs('*',false,false);
    $data = array();
    $no = 0;
    $imgPath = $this->omdi->imgpath().'pk/';
    foreach ($PKs as $PK) {
      $no++;
      $img = '<a title="'.$PK->nama.' ('.$PK->singkatan.')'.'" class="imglink" href="'.$imgPath.$PK->logo.'"><img width="100px" src="'.$imgPath.$PK->logo.'"></a>';
      $actions = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="'.site_url('pk/ubah/'.$PK->pk_id).'"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
          <li><a onclick="modalHapus('.$PK->pk_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
        </ul>
      </div>';
      $row = array();
      $row[] = $no;
      $row[] = $PK->nama.' ('.$PK->singkatan.')';
      $row[] = $img;
      $row[] = substr($PK->deskripsi,0,100).'...';
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function PK($id=false){
    if ($id) {
      $data = $this->PKModel->getPK('*',array('pk_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function PKs(){
    $data = $this->PKModel->getPKs('pk_id,nama,singkatan');
    echo json_encode($data);
  }
  public function validasi(){
    $this->omdi->set_my_message();

    if ($this->input->post('id')==null) {
      $this->form_validation->set_rules('pk', 'Program Keahlian', 'trim|required|max_length[255]|is_unique[pk.nama]');
      $this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required|max_length[255]|is_unique[pk.singkatan]');
      $this->form_validation->set_rules('deskripsi', 'Deskripsi Logo', 'trim|required|is_unique[pk.deskripsi]');
      $this->form_validation->set_rules('image-data', 'Gambar', 'trim|required');
    }else {
      $old = $this->PKModel->getPK('nama,singkatan,deskripsi',array('pk_id'=>$this->input->post('id')));
      if (ucwords($this->input->post('pk'))==$old->nama) {
        $this->form_validation->set_rules('pk', 'Program Keahlian', 'trim|required|max_length[255]');
      }else {
        $this->form_validation->set_rules('pk', 'Program Keahlian', 'trim|required|max_length[255]|is_unique[pk.nama]');
      }
      if (strtoupper($this->input->post('singkatan'))==$old->singkatan) {
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required|max_length[255]');
      }else {
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required|max_length[255]|is_unique[pk.singkatan]');
      }
      if ($this->input->post('deskripsi')===$old->deskripsi) {
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Logo', 'trim|required');
      }else {
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Logo', 'trim|required|is_unique[pk.deskripsi]');
      }
    }
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('pk')) {
        $data['namafield'][]='pk';
        $data['texterror'][]=form_error('pk');
      }
      if (form_error('singkatan')) {
        $data['namafield'][]='singkatan';
        $data['texterror'][]=form_error('singkatan');
      }
      if (form_error('image-data')) {
        $data['namafield'][]='image-data';
        $data['texterror'][]=form_error('image-data');
      }
      if (form_error('deskripsi')) {
        $data['namafield'][]='deskripsi';
        $data['texterror'][]=form_error('deskripsi');
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
  public function gambar($id=false){
    $image = $this->input->post('image-data');
    if ($image!=null) {
      $pk = str_replace(" ","",$this->input->post('singkatan'));
      $exploded = explode(',',$image);
      $decoded = base64_decode($exploded[1]);
      $fileName = $pk.'-'.random_string('alnum', 4).'.png';
      $imgPath = $this->omdi->upimgpath().'pk/';
      $path = $imgPath.$fileName;
      if ($id) {
        $oldpic = $this->PKModel->getPK('logo',array('pk_id'=>$id))->logo;
        unlink($imgPath.$oldpic);
      }
      file_put_contents($path,$decoded);
    }else {
      $fileName = $this->PKModel->getPK('logo',array('pk_id'=>$id))->logo;
    }

    return $fileName;
  }
  public function insert(){
    $datapk = array(
      "nama" => ucwords($this->input->post('pk')),
      "singkatan" => strtoupper($this->input->post('singkatan')),
      "logo" => $this->gambar(),
      "deskripsi" => $this->input->post('deskripsi')
    );
    $this->PKModel->insertPK($datapk);
  }
  public function update(){
    $logo = $this->gambar($this->input->post('id'));
    $datapk = array(
      "nama" => ucwords($this->input->post('pk')),
      "singkatan" => strtoupper($this->input->post('singkatan')),
      "logo" => $logo,
      "deskripsi" => $this->input->post('deskripsi')
    );
    $this->PKModel->updatePK($datapk,array('pk_id'=>$this->input->post('id')));
  }
  public function delete($id=false){
    if ($id) {
      $logo = $this->PKModel->getPK('logo',array('pk_id'=>$id))->logo;
      $imgPath = $this->omdi->upimgpath().'pk/';
      unlink($imgPath.$logo);
      $this->PKModel->deletePK(array('pk_id'=>$id));
    }
    else {
      echo "Pilih id";
    }
  }
  public function tambah(){
    $data['judul']= '<a href="'.site_url('pk').'">'.$this->judul.'</a> / <i class="fa fa-plus fa-fw"></i>';
    $this->load->view('Pages/PK/tambah',$data);
  }
  public function ubah($id=false){
    if ($id) {
      $PK = $this->PKModel->getPK('pk_id,singkatan',array('pk_id'=>$id));
      if (isset($PK)) {
        $data['judul']= '<a href="'.site_url('pk').'">'.$this->judul.'</a> / <i class="fa fa-pencil fa-fw"></i> / '.$PK->singkatan;
        $this->load->view('Pages/PK/tambah',$data);
      }else {
        redirect('pk');
      }
    }
    else {
      redirect('pk');
    }
  }
}

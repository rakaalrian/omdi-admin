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
      $img = '<a title="'.$PK->nama.' ('.$PK->singkatan.')'.'" class="imglink" href="'.$imgPath.$PK->logo.'"><img height="100px" src="'.$imgPath.$PK->logo.'"></a>';
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
      $row[] = substr($PK->deskripsi,0,300).'...';
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
      $upload = $this->upload();
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
      if (!empty($_FILES['gambar']['name'])) {
        $upload = $this->upload();
      }else {
        $upload['status'] = true;
      }
    }
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE || $upload['status']==false)
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
      if (!$upload['status']) {
        $data['namafield'][]='gambar';
        $data['texterror'][]=$upload['msg'];
      }
    }else {
      if ($this->input->post('id')==null) {
        $this->insert($upload['msg']);
      }else {
        if (!empty($_FILES['gambar']['name'])) {
          $imgPath = $this->omdi->upimgpath().'pk/';
          $oldpic = $this->PKModel->getPK('logo',array('pk_id'=>$this->input->post('id')))->logo;
          unlink($imgPath.$oldpic);
          $this->update($upload['msg']);
        }else {
          $this->update();
        }
      }
    }
    echo json_encode($data);
  }
  public function insert($fileName){
    $datapk = array(
      "nama" => ucwords($this->input->post('pk')),
      "singkatan" => strtoupper($this->input->post('singkatan')),
      "logo" => $fileName,
      "deskripsi" => $this->input->post('deskripsi')
    );
    $this->PKModel->insertPK($datapk);
  }
  public function update($fileName=false){
    if ($fileName) {
      $datapk = array(
        "nama" => ucwords($this->input->post('pk')),
        "singkatan" => strtoupper($this->input->post('singkatan')),
        "logo" => $fileName,
        "deskripsi" => $this->input->post('deskripsi')
      );
    }else {
      $datapk = array(
        "nama" => ucwords($this->input->post('pk')),
        "singkatan" => strtoupper($this->input->post('singkatan')),
        "deskripsi" => $this->input->post('deskripsi')
      );
    }
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
  public function upload(){
    $imgPath = $this->omdi->upimgpath().'pk/';
    $name = str_replace(" ","",strtoupper($this->input->post('singkatan')));

    $fileext = pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION);
    $fileName = $name.'-'.random_string('alnum', 4).'.'.$fileext;

    $file = 'gambar';

    $squareimage = false;
    $maxSize = 500;
    $byte = 1048.576;
    $size = $byte*$maxSize;

    try {
      if (!isset($_FILES[$file]['error']) || is_array($_FILES[$file]['error'])){
          throw new RuntimeException('Invalid parameters.');
      }
      // Check $_FILES['upfile']['error'] value.
      switch ($_FILES[$file]['error']) {
          case UPLOAD_ERR_OK:
              break;
          case UPLOAD_ERR_NO_FILE:
              throw new RuntimeException('Berkas belum dipilih.');
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
              throw new RuntimeException('Ukuran berkas maksimal '.$maxSize.' KB.');
          default:
              throw new RuntimeException('Unknown errors.');
      }
      // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
      // Check MIME Type by yourself.
      $type = array('image/png');
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      if (false === $ext = array_search($finfo->file($_FILES[$file]['tmp_name']), $type,true)){
        throw new RuntimeException('Berkas berekstensi \''.$fileext.'\' tidak diperbolehkan.');
      }
      // You should also check filesize here.
      if ($_FILES[$file]['size'] > $size) {
          throw new RuntimeException('Ukuran berkas maksimal '.$maxSize.' KB.');
      }
      // Dimensi gambar
      $image_info = getimagesize($_FILES[$file]["tmp_name"]);
      $image_width = $image_info[0];
      $image_height = $image_info[1];
      $minWidth = $image_width; // bila perlu ganti dengan ukuran yg diinginkan
      $minHeight = $image_height; // bila perlu ganti dengan ukuran yg diinginkan
      $maxWidth = $image_width; // bila perlu ganti dengan ukuran yg diinginkan
      $maxHeight = $image_height; // bila perlu ganti dengan ukuran yg diinginkan
      if ($image_width != $image_height && $squareimage) {
        throw new RuntimeException('Lebar dan tinggi berkas harus sesuai.');
      }
      if ($image_width < $minWidth) {
        throw new RuntimeException('Lebar berkas minimal '.$minWidth.'px.');
      }
      if ($image_height < $minHeight) {
        throw new RuntimeException('Tinggi berkas minimal '.$minHeight.'px.');
      }
      if ($image_width > $maxWidth) {
        throw new RuntimeException('Lebar berkas maksimal '.$maxWidth.'px.');
      }
      if ($image_height > $maxHeight) {
        throw new RuntimeException('Tinggi berkas maksimal '.$maxHeight.'px.');
      }
      // You should name it uniquely.
      // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
      // On this example, obtain safe unique name from its binary data.
      if (!move_uploaded_file($_FILES[$file]['tmp_name'],$imgPath.$fileName)) {
          throw new RuntimeException('Failed to move uploaded file.');
      }

      return array('status'=>true,'msg'=>$fileName);

    } catch (RuntimeException $e) {
      // return $e->getMessage();
      return array('status'=>false,'msg'=>$e->getMessage());
    }
  }
}

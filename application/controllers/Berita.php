<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('BeritaModel');
  }
  private $judul = '<i class="fa fa-bullhorn fa-fw"></i> Berita';
  public function index(){
    $data['judul'] = $this->judul;
    $this->load->view('Pages/Berita/berita',$data);
  }
  public function table(){
    $Beritas = $this->BeritaModel->getBeritas('*',false,false);
    $data = array();
    $no = 0;
    $imgPath = $this->omdi->imgpath().'berita/';
    foreach ($Beritas as $Berita) {
      $no++;
      $img = '<a title="'.substr($Berita->judul,0,50).'..." class="imglink" href="'.$imgPath.$Berita->image.'"><img width="200px" src="'.$imgPath.$Berita->image.'"></a>';
      $Berita->berita_id = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="'.site_url('berita/ubah/'.$Berita->berita_id).'"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
          <li><a onclick="modalHapus('.$Berita->berita_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
        </ul>
      </div>';
      $row = array();
      $row[] = $no;
      $row[] = substr($Berita->judul,0,200).'...';
      $row[] = $img;
      $row[] = $Berita->berita_id;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function berita($id=false){
    if ($id) {
      $data = $this->BeritaModel->getBerita('*',array('berita_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function validasi(){
    $this->omdi->set_my_message();
    $this->form_validation->set_rules('judul', 'Judul Berita', 'trim|required|min_length[5]|max_length[255]');
    $this->form_validation->set_rules('konten', 'Konten Berita', 'trim|required|min_length[100]');

    if ($this->input->post('id')==null) {
      $upload = $this->upload();
    }else {
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
      if (form_error('judul')) {
        $data['namafield'][]='judul';
        $data['texterror'][]=form_error('judul');
      }
      if (form_error('konten')) {
        $data['namafield'][]='konten';
        $data['texterror'][]=form_error('konten');
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
          $imgPath = $this->omdi->upimgpath().'berita/';
          $oldpic = $this->BeritaModel->getBerita('image',array('berita_id'=>$this->input->post('id')))->image;
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
    $databerita = array(
      "judul" => $this->input->post('judul'),
      "konten" => $this->input->post('konten'),
      "image" => $fileName
    );
    $this->BeritaModel->insertBerita($databerita);
  }
  public function update($fileName=false){
    if ($fileName) {
      $databerita = array(
        "judul" => $this->input->post('judul'),
        "konten" => $this->input->post('konten'),
        "image" => $fileName
      );
    }else {
      $databerita = array(
        "judul" => $this->input->post('judul'),
        "konten" => $this->input->post('konten')
      );
    }
    $this->BeritaModel->updateBerita($databerita,array('berita_id'=>$this->input->post('id')));
  }
  public function delete($id=false){
    if ($id) {
      $image = $this->BeritaModel->getBerita('image',array('berita_id'=>$id))->image;
      $imgPath = $this->omdi->upimgpath().'berita/';
      unlink($imgPath.$image);
      $this->BeritaModel->deleteBerita(array('berita_id'=>$id));
    }
    else {
      echo "Pilih id";
    }
  }
  public function tambah(){
    $data['judul']= '<a href="'.site_url('berita').'">'.$this->judul.'</a> / <i class="fa fa-plus fa-fw"></i>';
    $this->load->view('Pages/Berita/tambah',$data);
  }
  public function ubah($id=false){
    if ($id) {
      $berita = $this->BeritaModel->getBerita('berita_id',array('berita_id'=>$id));
      if (isset($berita)) {
        $data['judul']= '<a href="'.site_url('berita').'">'.$this->judul.'</a> / <i class="fa fa-pencil fa-fw"></i> / '.$id;
        $this->load->view('Pages/Berita/tambah',$data);
      }else {
        redirect('berita');
      }
    }
    else {
      redirect('berita');
    }
  }
  public function upload(){
    $judul = str_replace(".","",$this->input->post('judul'));
    $judul = str_replace(" ","",$this->input->post('judul'));
    $judul = substr($judul,0,20);
    $fileext = pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION);

    $file = 'gambar';
    $imgPath = $this->omdi->upimgpath().'berita/';
    $fileName = $judul.'-'.random_string('alnum', 4).'.'.$fileext;

    $squareimage = false;
    $maxSize = 500;

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
      $type = array('image/jpeg','image/png');
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      if (false === $ext = array_search($finfo->file($_FILES[$file]['tmp_name']), $type,true)){
        throw new RuntimeException('Berkas berekstensi \''.$fileext.'\' tidak diperbolehkan.');
      }
      // You should also check filesize here.
      $size = 1048.576*$maxSize;
      if ($_FILES[$file]['size'] > $size) {
          throw new RuntimeException('Ukuran berkas maksimal '.$maxSize.' KB.');
      }
      // Dimensi gambar
      $image_info = getimagesize($_FILES[$file]["tmp_name"]);
      $image_width = $image_info[0];
      $image_height = $image_info[1];
      $minWidth = 720;//$image_width; // bila perlu ganti dengan ukuran yg diinginkan
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

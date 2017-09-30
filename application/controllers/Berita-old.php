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
      $img = '<a title="'.substr($Berita->judul,0,50).'..." class="imglink" href="'.$imgPath.$Berita->image.'"><img width="150px" src="'.$imgPath.$Berita->image.'"></a>';
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

    if ($this->input->post('id')==null) {
      $this->form_validation->set_rules('judul', 'Judul Berita', 'trim|required|min_length[5]|max_length[255]');
      $this->form_validation->set_rules('konten', 'Konten Berita', 'trim|required|min_length[100]');
      $this->form_validation->set_rules('image-data', 'Gambar', 'trim|required');
    }else {
      $this->form_validation->set_rules('judul', 'Judul Berita', 'trim|required|min_length[5]');
      $this->form_validation->set_rules('konten', 'Konten Berita', 'trim|required|min_length[100]');
    }
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
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
      if (form_error('image-data')) {
        $data['namafield'][]='image-data';
        $data['texterror'][]=form_error('image-data');
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
      $judul = str_replace(".","",$this->input->post('judul'));
      $judul = str_replace(" ","",$this->input->post('judul'));
      $judul = substr($judul,0,20);
      $exploded = explode(',',$image);
      $decoded = base64_decode($exploded[1]);
      $fileName = $judul.'-'.random_string('alnum', 4).'.jpg';
      $imgPath = $this->omdi->upimgpath().'berita/';
      $path = $imgPath.$fileName;

      file_put_contents($path,$decoded);

      if ($id) {
        $oldpic = $this->BeritaModel->getBerita('image',array('berita_id'=>$id))->image;
        unlink($imgPath.$oldpic);
      }
    }else {
      $fileName = $this->BeritaModel->getBerita('image',array('berita_id'=>$id))->image;
    }

    return $fileName;
  }
  public function insert(){
    $databerita = array(
      "judul" => $this->input->post('judul'),
      "konten" => $this->input->post('konten'),
      "image" => $this->gambar()
    );
    $this->BeritaModel->insertBerita($databerita);
  }
  public function update(){
    $logo = $this->gambar($this->input->post('id'));
    $databerita = array(
      "judul" => $this->input->post('judul'),
      "konten" => $this->input->post('konten'),
      "image" => $logo
    );
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
  // public function upload_file(){
  //   if (!empty($_FILES)) {
  //     $imgPath = $this->omdi->upimgpath().'berita/';
  //     $config['upload_path'] = $imgPath;
  //     $config['allowed_types'] = 'jpeg|jpg|png';
  //     $this->load->library('upload',$config);
  //     if ( ! $this->upload->do_upload('image')) {
  //       echo "Failed to upload file(s)";
  //     }else {
  //       echo "uploaded";
  //     }
  //   }else {
  //     echo "empty";
  //   }
  // }
}

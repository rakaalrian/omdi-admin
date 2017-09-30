<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabor extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    if (!$this->session->userdata('omdi-dev')) {
      if (!$this->uri->segment(2)=='cabors') {
        redirect(base_url());
      }
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('CaborModel');
  }
  public function index(){
    $data['judul']='<i class="fa fa-dribbble fa-fw"></i> Cabang Olahraga';
    $this->load->view('Pages/cabor',$data);
  }
  public function table(){
    $cabors = $this->CaborModel->getCabors('*',false,false,'nama');
    $data = array();
    $no = 0;
    $imgPath = $this->omdi->imgpath().'cabor/';
    foreach ($cabors as $cabor) {
      $no++;
      $img = '<a title="'.$cabor->nama.'" class="imglink" href="'.$imgPath.$cabor->background.'"><img width="200px" src="'.$imgPath.$cabor->background.'"></a>';
      $actions = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a onclick="modalUbah('.$cabor->cabor_id.')"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>
          <li><a onclick="modalHapus('.$cabor->cabor_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>
        </ul>
      </div>';
      $row = array();
      $row[] = $no;
      $row[] = $cabor->nama;
      $row[] = $img;
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function cabor($id=false){
    if ($id) {
      $data = $this->CaborModel->getCabor('*',array('cabor_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function cabors(){
    $data = $this->CaborModel->getCabors('cabor_id,nama',false,false,'nama');
    echo json_encode($data);
  }
  public function validasi(){
    $this->omdi->set_my_message();
    $this->form_validation->set_rules('cabor', 'Cabang Olahraga', 'trim|required|max_length[255]');
    if ($this->input->post('id')==null) {
      $this->form_validation->set_rules('image-data', 'Gambar', 'trim|required');
    }
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
      $cabor = str_replace(" ","",$this->input->post('cabor'));
      $exploded = explode(',',$image);
      $decoded = base64_decode($exploded[1]);
      $fileName = $cabor.'-'.random_string('alnum', 4).'.png';
      $imgPath = $this->omdi->upimgpath().'cabor/';
      $path = $imgPath.$fileName;
      if ($id) {
        $oldpic = $this->CaborModel->getCabor('background',array('cabor_id'=>$id))->background;
        unlink($imgPath.$oldpic);
      }
      file_put_contents($path,$decoded);
    }else {
      $fileName = $this->CaborModel->getCabor('background',array('cabor_id'=>$id))->background;
    }

    return $fileName;
  }
  public function insert(){
    $datacabor = array(
      "nama" => ucwords($this->input->post('cabor')),
      "background" => $this->gambar()
    );
    $this->CaborModel->insertCabor($datacabor);
  }
  public function update(){
    $background = $this->gambar($this->input->post('id'));
    $datacabor = array(
      "nama" => ucwords($this->input->post('cabor')),
      "background" => $background
    );
    $this->CaborModel->updateCabor($datacabor,array('cabor_id'=>$this->input->post('id')));
  }
  public function delete($id=false){
    if ($id) {
      $background = $this->CaborModel->getCabor('background',array('cabor_id'=>$id))->background;
      $imgPath = $this->omdi->upimgpath().'cabor/';
      unlink($imgPath.$background);
      $this->CaborModel->deleteCabor(array('cabor_id'=>$id));
    }else {
      echo "Pilih id";
    }
  }
}

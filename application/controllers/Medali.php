<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medali extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('MedaliModel');
  }
  private $judul = '<i class="fi fi-medal fi-fw"></i> Medali';
  public function index(){
    $data['judul']=$this->judul;
    $this->load->view('Pages/medali',$data);
  }
  public function table(){
    // $medalis = $this->MedaliModel->getMedalis('m.*,p.nama,p.singkatan,(m.emas+m.perak+m.perunggu) as total',false,false,'total',false);
    $medalis = $this->MedaliModel->getMedalis('m.*,p.nama,p.singkatan',false,false,'emas,perak,perunggu',false);
    $data = array();
    $no = 0;
    $pringkat = 0;
    $emas = 0;
    $perak = 0;
    $perunggu = 0;
    foreach ($medalis as $medali) {
      $no++;
      if ($medali->emas!=$emas || $medali->perak!=$perak || $medali->perunggu!=$perunggu) {
        $emas = $medali->emas;
        $perak = $medali->perak;
        $perunggu = $medali->perunggu;
        $pringkat++;
      }

      if ($emas+$perak+$perunggu==0) {
        $pringkat = '-';
      }
      $actions = '<a onclick="modalUbah('.$medali->medali_id.')" class="btn btn-sm btn-primary"><i class="fa fa-pencil fa-fw"></i>Ubah</a></li>';
      $row = array();
      $row[] = $no;
      $row[] = $pringkat;
      $row[] = $medali->nama.' ('.$medali->singkatan.')';
      $row[] = $medali->emas;
      $row[] = $medali->perak;
      $row[] = $medali->perunggu;
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function medali($id=false){
    if ($id) {
      $data = $this->MedaliModel->getMedali('m.*,p.nama,p.singkatan',array('medali_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function validasi(){
    $this->omdi->set_my_message();

    $this->form_validation->set_rules('emas', 'Emas', 'trim|required|greater_than_equal_to[0]');
    $this->form_validation->set_rules('perak', 'Perak', 'trim|required|greater_than_equal_to[0]');
    $this->form_validation->set_rules('perunggu', 'Perunggu', 'trim|required|greater_than_equal_to[0]');
    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('emas')) {
        $data['namafield'][]='emas';
        $data['texterror'][]=form_error('emas');
      }
      if (form_error('perak')) {
        $data['namafield'][]='perak';
        $data['texterror'][]=form_error('perak');
      }
      if (form_error('perunggu')) {
        $data['namafield'][]='perunggu';
        $data['texterror'][]=form_error('perunggu');
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
  public function update(){
    $datamedali = array(
      'emas' => $this->input->post('emas'),
      'perak' => $this->input->post('perak'),
      'perunggu' => $this->input->post('perunggu')
    );
    $this->MedaliModel->updateMedali($datamedali,array('medali_id'=>$this->input->post('id')));
  }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saran extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper(array('form', 'file', 'string'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
    $this->load->model('SaranModel');
  }
  private $judul = '<i class="fa fa-comments fa-fw"></i> Kritik & Saran';
  public function index(){
    $data['judul'] = $this->judul;
    $this->load->view('Pages/saran',$data);
  }
  public function table(){
    $sarans = $this->SaranModel->getSarans('*',false,false,'saran_id',false);
    $data = array();
    $no = 0;
    foreach ($sarans as $saran) {
      $no++;
      $actions = '<div class="btn-group btn-table">
        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          Aksi
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a onclick="modalDetail('.$saran->saran_id.')"><i class="fa fa-eye fa-fw"></i>Detail</a></li>
          <!--<li><a onclick="modalHapus('.$saran->saran_id.')"><i class="fa fa-trash-o fa-fw"></i>Hapus</a></li>-->
        </ul>
      </div>';
      $actions = '<a onclick="modalDetail('.$saran->saran_id.')" class="btn btn-sm btn-primary"><i class="fa fa-eye fa-fw"></i>Detail</a></li>';
      $row = array();
      $row[] = $no;
      // $row[] = $saran->email;
      $row[] = substr($saran->saran,0,200).'...';
      $row[] = $saran->waktu;
      $row[] = $actions;
      $data[] = $row;
    }
    $output = array(
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function saran($id=false){
    if ($id) {
      $data = $this->SaranModel->getSaran('*',array('saran_id'=>$id));
      echo json_encode($data);
    }else {
      echo "Pilih id";
    }
  }
  public function delete($id=false){
    if ($id) {
      $this->SaranModel->deleteSaran(array('saran_id'=>$id));
    }else {
      echo "Pilih id";
    }
  }
}

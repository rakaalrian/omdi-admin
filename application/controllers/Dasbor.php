<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
    date_default_timezone_set('Asia/Jakarta');
  }

	public function index()
	{
    $data['judul']='<i class="fa fa-bar-chart-o fa-fw"></i> Dasbor';
    // $this->load->view('home/home',$data);
    $this->load->view('Pages/dasbor',$data);
    // $this->load->view('home/dasbor',$data);
	}
  function chartPeringkat(){
    $data = array();
    $this->load->model('MedaliModel');
    $peringkats = $this->MedaliModel->getMedalis('m.*,p.nama,p.singkatan',false,false,'emas,perak,perunggu',false);
    $i = 0;
    $pringkat = 0;
    $emas = 0;
    $perak = 0;
    $perunggu = 0;
    foreach ($peringkats as $peringkat) {
      if ($peringkat->emas!=$emas || $peringkat->perak!=$perak || $peringkat->perunggu!=$perunggu) {
        $emas = $peringkat->emas;
        $perak = $peringkat->perak;
        $perunggu = $peringkat->perunggu;
        $pringkat++;
      }
      if ($emas+$perak+$perunggu>0) {
        $data[] = array(
          // 'i' => $i,
          'pk' => $pringkat.' '.$peringkat->singkatan,
          'perunggu' => $peringkat->perunggu,
          'perak' => $peringkat->perak,
          'emas' => $peringkat->emas,
        );
        $i++;
      }
    }
    echo json_encode($data);
  }
  function countJadwal(){
    $this->load->model('JadwalModel');
    $belum = count($this->JadwalModel->getJadwals('jadwal_id','status=0'));
    $sudah = count($this->JadwalModel->getJadwals('jadwal_id','status=1'));
    $data = array(
      'sudah'=>$sudah,
      'belum'=>$belum,
    );
    echo json_encode($data);
  }
  function countSaran(){
    $this->load->model('SaranModel');
    $saran = count($this->SaranModel->getSarans('saran_id'));
    echo $saran;
  }
}

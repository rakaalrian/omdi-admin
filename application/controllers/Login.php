<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if ($this->session->userdata('omdi-isLogin')) {
      redirect(base_url());
    }

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('omdi');
  }

	public function index()
	{
    $this->load->view('Auth/login');
	}
  public function login(){
    $this->omdi->set_my_message();

    $this->form_validation->set_rules('username', 'Nama pengguna', 'trim|required|alpha_numeric|max_length[100]');
    $this->form_validation->set_rules('password', 'Kata sandi', 'trim|required|alpha_numeric|max_length[100]');

    $data = array();
    $data['valid']=TRUE;

    if ($this->form_validation->run() == FALSE)
    {
      $data['namafield']=array();
      $data['texterror']=array();
      $data['valid']=FALSE;
      if (form_error('username')) {
        $data['namafield'][]='username';
        $data['texterror'][]=form_error('username');
      }
      if (form_error('password')) {
        $data['namafield'][]='password';
        $data['texterror'][]=form_error('password');
      }
    }

    //verifikasi
    $data['masuk']=FALSE;
    $username = $this->input->post('username');
    $password = md5($this->input->post('password'));

    // $this->load->model('AdminModel');
    // $verifLogin = $this->AdminModel->getAdmin('username',array('username'=>$username,'password'=>$password));

		if (($username==='devomdi' || $username==='adminomdi') && $password=='e97051d5e38af2328523f6716cb83d7d') {
      // $admin = $this->AdminModel->getAdmin('*',array('username'=>$username));
      $dev = false;
      if ($username==='devomdi') {
        $dev = true;
      }
      $data['masuk']=TRUE;
      $session = array('omdi-isLogin' => TRUE, 'omdi-username' => $username, 'omdi-dev' => $dev);//$admin->username, 'omdi-email' => $admin->email);
      $this->session->set_userdata($session);
		}
    echo json_encode($data);
  }
}

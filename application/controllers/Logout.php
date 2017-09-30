<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if (!$this->session->userdata('omdi-isLogin')) {
      redirect('login');
    }
  }

	public function index()
	{
    $session = array('omdi-isLogin','omdi-username');//,'omdi-email');
    $this->session->unset_userdata($session);
    redirect('login');
	}
}

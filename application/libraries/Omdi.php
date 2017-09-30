<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Omdi {
  private $ci;
  public function __construct(){
    $this->ci =& get_instance();
    date_default_timezone_set('Asia/Jakarta');
  }
  public function imgpath(){
    return "http://".$_SERVER['HTTP_HOST']."/AdminOmdi/images/";
    // return "http://".$_SERVER['HTTP_HOST']."/images/";
  }
  public function upimgpath(){
    return "../images/";
  }
  public function set_my_message(){
    // $message = array(
    //             'required' => '{field} Wajib Diisi',
    //             'numeric' => '{field} Harus Berupa Angka',
    //             'alpha' => '{field} Harus Berupa Huruf',
    //             'alpha_numeric' => '{field} Harus Berupa Angka atau Huruf',
    //             'alpha_numeric_spaces' => '{field} Harus Berupa Angka, Huruf, atau Spasi',
    //             'valid_email' => 'Format {field} Salah',
    //             'max_length' => '{field} Maksimal {param} Karakter',
    //             'min_length' => '{field} Minimal {param} Karakter',
    //             'exact_length' => '{field} Harus Berisi {param} Karakter',
    //             'is_unique' => '{field} Sudah Ada',
    //             'matches' => '{field} Tidak Sesuai',
    //             'regex_match' => 'Format {field} Salah',
    //             'greater_than_equal_to' => 'Nilai {field} Minimal {param}',
    //           );
    // $this->ci->form_validation->set_message($message);
    $this->ci->form_validation->set_error_delimiters('', '');
  }
}

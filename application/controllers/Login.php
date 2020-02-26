<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Manila');
		$this->load->model("Main_model");
        // if(isset($this->session->userdata()))
        // {
        //     redirect(base_url('Dashboard'));
        // }
        //   else
        // {
        //     redirect(base_url('Login'));
        // }
    }
	
	public function index()
	{
        $this->load->view('template/template');
    
  }

  public function login_user()
  {
    $username = clean_data(post('username'));
    $password = clean_data(post('password'));
    $query = $this->Main_model->login($username,$password);

    echo json_encode($query);
  }

    public function logout()  
  {  
    session_destroy();
    $this->session->unset_userdata('username','role','id','full_name');  
    redirect(base_url() . 'Login');  
  } 

}

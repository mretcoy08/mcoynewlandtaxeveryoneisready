<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fourowfour extends CI_Controller {

	public function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Manila');
		
        if(isset($this->session->id))
        {
            $this->load->model("Main_model");
        }
          else
        {
            redirect(base_url('Login'));
        }
    }
    
    public function index(){
        $this->load->view("errors/error_404");
    }


}

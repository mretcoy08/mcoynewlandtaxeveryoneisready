<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_controller extends CI_Controller {

	// public function __construct() {
    //     parent::__construct();
	// 	date_default_timezone_set('Asia/Manila');
		
    //     if(isset($this->session->id))
    //     {
    //         $this->load->model("Main_model");
    //     }
    //       else
    //     {
    //         redirect(base_url('Login'));
    //     }
    // }
	
	
	public function profile_name()
	{	
        $data = [
            'name' => $this->session->userdata('fullname'),
            'role' => $this->session->userdata('role'),
        ];
        echo json_encode($data);
    }

    
    

}

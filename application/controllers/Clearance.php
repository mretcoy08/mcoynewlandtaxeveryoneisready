<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clearance extends CI_Controller {

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

	
	public function index()
	{
		$this->load->view('template/template');
	}

	public function clearance_table()
	{

		$where = [
			"print" => 1,
		];
		$columns = array( 
			0 =>'first_name', 
			1 =>'barangay',
			2 =>'pin_barangay',
			3 =>'tax_dec_no',
			4 => 'id',
		);
			$limit = $this->input->post('length');
			$start = $this->input->post('start');
			$order = $columns[$this->input->post('order')[0]['column']];
			$dir = $this->input->post('order')[0]['dir'];
			$search = $this->input->post('search')['value']; 

			//DATATABLE VARIABLES
			$where = [
				"print" => 1,
				
			];
			//END OF DATATABLE VARIABLES

			$totalData = $this->Main_model->all_post_clearance_count($where);

			$totalFiltered = $totalData; 

			if(empty($this->input->post('search')['value']))
			{            
			$posts = $this->Main_model->all_post_clearance($limit,$start,$order,$dir,$where);
			}
			else {
			$posts =  $this->Main_model->all_post_clearance_search($limit,$start,$search,$order,$dir,$where);
			$totalFiltered = $this->Main_model->all_post_clearance_search_count($search,$where);
			}
			$data = array();
			if(!empty($posts))
			{
				foreach ($posts as $post)
				{
					$nestedData['owner'] = $post->full_name;
					$nestedData['pin'] = $post->pin;
					$nestedData['tax_dec_no'] = $post->tax_dec_no;
					$nestedData['action'] = "<button class = 'btn btn-primary btn-sm' onclick= 'clearance(".$post->tax_id.")'><i class = 'fa fa-print'></i></button>";
					
					$data[] = $nestedData;
				}
			}

			$json_data = array(
				"draw"            => intval($this->input->post('draw')),  
				"recordsTotal"    => intval($totalData),  
				"recordsFiltered" => intval($totalFiltered), 
				"data"            => $data   
				);
				
			echo json_encode($json_data); 
	}

	public function verifyClearance()
	{
		$getData = [
			"or_number" => clean_data(post("or_num")),
			"request" => clean_data(post("request")),
			"purpose" => clean_data(post("purpose")),
			"tax_idd" => clean_data(post("tax_idd"))
		];

		
		$where = [
			"or_number" => $getData["or_number"],
			"tax_order.id" => $getData["tax_idd"],
		];

		$query = $this->Main_model->clearanceVerification($where);

		if($query->num_rows()>0){
			echo json_encode("success");
		}
		else
		{
			echo json_encode("error");
		}
		
	}	
	public function viewClearance()
	{
		$getData = [
			"or_number" => clean_data(post("or_num")),
			"request" => clean_data(post("request")),
			"purpose" => clean_data(post("purpose")),
			"tax_idd" => clean_data(post("tax_idd"))
		];
		$clearancePaymentData;
		$clearanceLandData;
		$clearanceOwnerData;

		
		$where = [
			"tax_order.id" => $getData["tax_idd"],
		];

		$query = $this->Main_model->clearanceVerification($where);
		$getClearance;
		if($query->num_rows()){
			foreach($query->result() as $k)
			{
				$getData["or_number"] = $k->or_number;
				$getData["or_date"] = $k->or_date;
				$getData["payment"] = $k->payment;
				$getData["mode_of_payment"] = $k->mode_of_payment;
			}

			if($getData["mode_of_payment"] == "Compromise")
			{
				$clearancePaymentData = $this->Main_model->clearanceCompromise($where);
			}
			else{
				$clearancePaymentData = $this->Main_model->clearancePayment($where);
			}

			$clearanceLandData = $this->Main_model->clearanceLandData($where);
			$clearanceOwnerData = $this->Main_model->clearanceOwnerData($where);

			

		}
		$data = [
			"ownerData" => $clearanceOwnerData->result(),
			"landData" => $clearanceLandData->result(),
			"paymentData" => $clearancePaymentData->result(),
			"purposeData" => $getData,
		];

		
		// echo json_encode($data);	
		$this->load->view("pages/clearanceshow", $data);

	}


	public function clearance_print()
	{
		$getData = [
			"or_number" => clean_data(post("or_num")),
			"request" => clean_data(post("request")),
			"purpose" => clean_data(post("purpose")),
			"tax_idd" => clean_data(post("tax_idd"))
		];
		$clearancePaymentData;
		$clearanceLandData;
		$clearanceOwnerData;

		
		$where = [
			"tax_order.id" => $getData["tax_idd"],
		];

		$query = $this->Main_model->clearanceVerification($where);
		$getClearance;
		if($query->num_rows()){
			foreach($query->result() as $k)
			{
				$getData["or_number"] = $k->or_number;
				$getData["or_date"] = $k->or_date;
				$getData["payment"] = $k->payment;
				$getData["mode_of_payment"] = $k->mode_of_payment;
			}

			if($getData["mode_of_payment"] == "Compromise")
			{
				$clearancePaymentData = $this->Main_model->clearanceCompromise($where);
			}
			else{
				$clearancePaymentData = $this->Main_model->clearancePayment($where);
			}

			$clearanceLandData = $this->Main_model->clearanceLandData($where);
			$clearanceOwnerData = $this->Main_model->clearanceOwnerData($where);

			

		}
		$data = [
			"ownerData" => $clearanceOwnerData->result(),
			"landData" => $clearanceLandData->result(),
			"paymentData" => $clearancePaymentData->result(),
			"purposeData" => $getData,
		];

		
		// echo json_encode($data);	
		$this->load->view("pages/clearanceprint", $data);

	}

	public function clearance_clear()
	{
		
	}
}

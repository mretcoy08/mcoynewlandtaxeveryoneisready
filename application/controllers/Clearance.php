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
					$nestedData['action'] = "<button class = 'btn btn-primary btn-sm' onclick= 'clearance(".$post->id.")'><i class = 'fa fa-print'></i></button>";
					
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
			"land_id" => $getData["tax_idd"],
		];

		$query = $this->Main_model->select("tax_clearance_payment", "*", $where);

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
		$landData = [];
		$clearanceData = [];
		$ownerData = [];

		
		$where = [
			"or_number" => $getData["or_number"],
			"land_id" => $getData["tax_idd"],
		];

		$query = $this->Main_model->select("tax_clearance_payment", "*", $where);
		$getClearance;
		if($query->num_rows()){
			foreach($query->result() as $k)
			{
				$clearanceData["or_number"] = $k->or_number;
				$clearanceData["or_date"] = $k->or_date;
				$clearanceData["payment"] = $k->payment;
			}

			$whereData1 = [
				"land.id" => $where["land_id"]
			];
			$getClearance = $this->Main_model->getClearance($whereData1);
			foreach($getClearance->result() as $k)
			{
				$landData["pin"] = $k->pin;
				$landData["tax_dec_no"] = $k->tax_dec_no;
				$landData["barangay"] = $k->barangay;
				$landData["assessed_value"] = $k->assessed_value;
				$landData["or_number"] = $k->or_number;
				$landData["or_date"] = $k->or_date;
				$landData["payment"] = $k->due_total;
				$landData["due_basic"] = $k->due_basic;
				$landData["due_sef"] = $k->due_sef;
			}
			

		}
		$data = [
			"landData" => $landData,
			"clearanceData" => $clearanceData,
			"purposeData" => $getData,
		];

		
		echo json_encode($data);
		$this->load->view("pages/clearanceshow", $data);

	}
}

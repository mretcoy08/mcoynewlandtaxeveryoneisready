<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compromise extends CI_Controller {


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

	public function compromise_cash()
	{
		// action('HomeController@getIndex', $params);

		$orData = [
			"or_number" => clean_data(post("or_number")),
			 "or_date" => clean_data(post("or_date")),
		];

		$queryORID = $this->Main_model->insertWithId("or_pool",$orData);

		$getData = [
			 "payor_name" => ucwords(clean_data(post("first_name")))." ".ucwords(clean_data(post("middle_name"))).' '.ucwords(clean_data(post("last_name"))),
			 "or_pool_id" => $queryORID,
			 "cash_rec" => saveMoney(clean_data(post("cash_rec"))),
			 "check_rec" => saveMoney(clean_data(post("check_rec"))),
			 "total_rec" => saveMoney(clean_data(post("total_rec"))),
			 "due_total" => saveMoney(clean_data(post("due_total"))),
			 "tax_year" => clean_data(post("tax_year")),
			 "payment_status" => "PAID",
		];
		$where = [
			"id" => clean_data(post("payment_id")),
		];

		$query = $this->Main_model->update("compromise",$getData,$where);

		$getId = $this->Main_model->select("compromise","tax_order_id",$where);
		$whereTaxId = [];
		foreach($getId->result() as $k)
		{
			$whereTaxId = [
				"id" => $k->tax_order_id,
			];
			 
		}
		
		$updateData = [	
			"balance" => Floatval(saveMoney(clean_data(post("balance")))) - Floatval(saveMoney(clean_data(post("due_total")))),
		];
		$query = $this->Main_model->update("tax_order",$updateData,$whereTaxId);

		$updateStatus = [
			"payment_status" => "PAID"
		];
		$where = [
			"balance" => 0,
		];
		$checkPaid = $this->Main_model->update("tax_order",$updateStatus,$where);

		$getlandId = $this->Main_model->select("tax_order", "land_id",$whereTaxId);
		$land_id;
		foreach($getlandId->result() as $k)
		{
			$land_id = $k->land_id;
		}

		$table = "land";
		$updateData = [
			"last_payment_assessed" => $getData["tax_year"],
		];
		$where = [
			"id" => $land_id,
		];
		$query = $this->Main_model->update($table,$updateData,$where);


		echo json_encode($where);
    }

    public function compromise_check()
	{
		$data_bank = $this->input->post('ch');

		$query = $this->Main_model->insert("check_payment",$data_bank);

		echo json_encode($data_bank);
	}
    

	public function compromise_payment()
	{
		$whereGetPayment = [
			"tax_order_id" => clean_data(post("id")),	
		]; 

		$nestedData = [];
		$data = [];
		$penalty = 0;
		$discount = 0;
		$getPaymentQuery = $this->Main_model->getCompromise($whereGetPayment);

		foreach($getPaymentQuery as $k)
		{	
			$nestedData["due_basic"] = $k->due_basic;
			$nestedData["id"] = $k->id;
		}

		$paymentInfoQuery = $this->Main_model->getCompromiseInfo($nestedData["id"]);

		foreach($paymentInfoQuery as $k)
		{
			$nestedData["mode_of_payment"]  = $k->mode_of_payment;
			$nestedData["due_basic"]  = $k->due_basic;
			$nestedData["due_sef"]  = $k->due_sef;
			$nestedData["due_total"]  = $k->due_total;
			$nestedData["tax_year"]  = $k->tax_year;
			$nestedData["payment_no"]  = $k->payment_no;
			$nestedData["land_id"]  = $k->land_id;
			$nestedData["payment_id"]  = $k->id;
            $nestedData["balance"]  = $k->balance;
		}

	   

		$ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

		$data = [
			"payment" =>$nestedData,
			"landAndOwner" => $ownerAndLandQuery,
		];

		echo json_encode($data);
	}
	

	public function compromise_history()
	{
		$getWhereHistory = [
			"tax_order.id" => clean_data(post("id")),
		];
		$pinQuery = $this->Main_model->getPin($getWhereHistory);
		$pin;
		foreach($pinQuery->result() as $k)
		{
			$pin = $k->pin;
		}

		$where = [
			"compromise.payment_status" => "PAID",
	
		];
		$taxOrder = $this->Main_model->getTaxOrder($pin);
		$payment = $this->Main_model->getCompromiseHistory($pin,$where);

		$owner = $this->Main_model->getLandAndOwner($pin);

		$data = [
			"payment" => $payment->result(),
			"owner" => $owner->result(),
			"tax_order" => $taxOrder->result(),
			"admin" => $this->session->userdata("role"),
		];
		echo json_encode($data);


	}

	public function view_OR()
	{
		$where = [
			"compromise.id" => clean_data(post("id")),
		];

		  
		$orData = $this->Main_model->getOrCompromise($where);
		$data['orData'] = $orData->result();

		echo json_encode($data);
		$this->load->view('pages/viewReceipt',$data);
	}

	public function print_OR()
	{
		$where = [
			"compromise.id" => clean_data(post("id")),
		];

		  
		$orData = $this->Main_model->getOrCompromise($where);
		$data['orData'] = $orData->result();

		echo json_encode($data);
		$this->load->view('pages/printReceipt',$data);
	}


	public function compromise_table()
	{
		

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

			//END OF DATATABLE VARIABLES

			$totalData = $this->Main_model->all_post_compromise_count();

			$totalFiltered = $totalData; 

			if(empty($this->input->post('search')['value']))
			{            
			$posts = $this->Main_model->all_post_compromise($limit,$start,$order,$dir);
			}
			else {
			$posts =  $this->Main_model->all_post_compromise_search($limit,$start,$search,$order,$dir);
			$totalFiltered = $this->Main_model->all_post_compromise_search_count($search);
			}
			$data = array();
			if(!empty($posts))
			{
			foreach ($posts as $post)
			{
			$nestedData['owner'] = $post->full_name;
			$nestedData['location'] = $post->barangay;
			$nestedData['pin'] = $post->pin;
			$nestedData['tax_dec_no'] = $post->tax_dec_no;
			$nestedData["year_assessed"] = $post->year_assessed;
			if($post->payment_status == "PENDING")
			{
				$nestedData['action'] = "<button class = ' btn btn-success btn-sm' onclick= 'compromise(".$post->id.")' data-toggle='tooltip' title='TAX PAYMENT'><i class='fa fa-money-bill-alt'></i></button>
				<button class = ' btn btn-warning btn-sm payment' onclick='compromise_history(\"".$post->id."\")'data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button>";
				
			}
			else{
				if($post->year_of_effectivity >= date("Y")){
					$nestedData['action'] = "<button class = ' btn btn-warning btn-sm payment' onclick='payment_history(\"".$post->id."\")' data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button>
				<button class = ' btn btn-primary btn-sm' onclick= 'clearance(".$post->id.")' data-toggle='tooltip' title='CLEARANCE PAYMENT'><i class='fa fa-money-bill-alt'></i></button>";
				}
				else{
					$nestedData['action'] = "<button class = ' btn btn-warning btn-sm payment' onclick='payment_history(\"".$post->id."\")' data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button>";
				}
				
			}
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


}

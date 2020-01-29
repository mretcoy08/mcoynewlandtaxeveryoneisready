<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {


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

	public function payment_cash()
	{
		$payment_method = clean_data(post("payment_method"));
	
		// action('HomeController@getIndex', $params);
		$orData = [
			"or_number" => clean_data(post("or_number")),
			 "or_date" => clean_data(post("or_date")),
		];

		$query = $this->Main_model->insertWithId("or_pool",$orData);


		$getData = [
			 "payor_name" => ucwords(clean_data(post("first_name")))." ".ucwords(clean_data(post("middle_name"))).' '.ucwords(clean_data(post("last_name"))),
			 "cash_rec" => saveMoney(clean_data(post("cash_rec"))),
			 "check_rec" => saveMoney(clean_data(post("check_rec"))),
			 "total_rec" => saveMoney(clean_data(post("total_rec"))),
			 "due_total" => saveMoney(clean_data(post("due_total"))),
			 "due_penalty" => saveMoney(clean_data(post("due_penalty"))),
			 "due_discount" => saveMoney(clean_data(post("due_discount"))),
			 "tax_year" => clean_data(post("tax_year")),
			 "payment_status" => "PAID",
			 "or_pool_id" => $query,
		];
		$where = [
			"id" => clean_data(post("payment_id")),
		];

		$query = $this->Main_model->update("payment",$getData,$where);

		$getId = $this->Main_model->select("payment","tax_order_id",$where);
		$whereTaxId = [];
		foreach($getId->result() as $k)
		{
			$whereTaxId = [
				"id" => $k->tax_order_id,
			];
			 
		}
		
		$updateData = [	
			"balance" => Floatval(saveMoney(clean_data(post("balance")))) - Floatval(saveMoney(clean_data(post("due_total")))) - Floatval(saveMoney(clean_data(post("due_penalty")))) + Floatval(saveMoney(clean_data(post("due_discount")))),
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


		echo json_encode($payment_method);
	}

	public function payment_check()
	{
		$data_bank = $this->input->post('ch');

		$query = $this->Main_model->insert("check_payment",$data_bank);

		echo json_encode($data_bank);
	}

	public function payment_history()
	{
		$where = [
			"tax_order.id" => clean_data(post("id")),
		];
		$pinQuery = $this->Main_model->getPin($where);
		$pin;
		foreach($pinQuery->result() as $k)
		{
			$pin = $k->pin;
		}
		
		$where = [
			"payment.payment_status" => "PAID",
		];
		$payment = $this->Main_model->getPaymentHistory($pin,$where);

		$owner = $this->Main_model->getLandAndOwner($pin);

		$data = [
			"payment" => $payment->result(),
			"owner" => $owner->result(),
			"admin" => $this->session->userdata("role"),
		];
		echo json_encode($data);

		
	}

	public function check_or()
	{
		$where = [
			"or_number" => clean_data(post("or_no")),
		];
		$query = $this->Main_model->check_or("payment","*",$where);

		echo json_encode($query->num_rows());
	}

	public function cancelOR_verification()
	{
		$where = [
			"password" => post("password"),
		];
		$query = $this->Main_model->select("user","role",$where);
		$role = "";
		if($query->num_rows()>0){
			foreach($query->result() as $k)
			{
				$role = $k->role;
			}
		}
		$data = "";
		if($role)
		{
			if($role == "Admin" || $role == "Superadmin")
			{
				$data = "Success";
			}
			else{
				$data = "Error";
			}
		}
		echo json_encode($data);
	}

	public function cancelOR()
	{
		$where = [
			"or_number" => clean_data(post("or_number")),
		];
		$update = [
			"payment_status" => "CANCEL",
		];
		$query = $this->Main_model->select("payment","*",$where);
		$this->Main_model->update("payment",$update,$where);
		$cancelData = [];
		foreach($query->result() as $k)
		{
			$cancelData = [
				"due_basic" => $k->due_basic,
				"due_sef" => $k->due_sef,
				"payment_no" => $k->payment_no,
				"due_date" => $k->due_date,
				"tax_order_id" => $k->tax_order_id,
				"tax_year" => $k->tax_year,
				"payment_status" => "PENDING",
			];
		}
		$whereTO = [
			"id" => $cancelData["tax_order_id"],
		];
		$query = $this->Main_model->select("tax_order","balance",$whereTO);
		$balance;
		foreach($query->result() as $k)
		{
			$balance = $k->balance;
		}
		$this->Main_model->insert("payment",$cancelData);
		$sumBalance = (Floatval($cancelData["due_basic"]) + Floatval($cancelData["due_sef"])) + Floatval($balance);
		$updateData = [
			"balance" => $sumBalance,
			"payment_status" => "PENDING",
		];
		$whereData = [
			"id" => $cancelData["tax_order_id"],
		];
		$this->Main_model->update("tax_order",$updateData,$whereData);
	

		echo json_encode($updateData);

	}

	public function getLandId()
	{
		$where = [
			"id" => clean_data(post("tax_id"))
		];
		$query = $this->Main_model->select("tax_order","land_id",$where);
		$id;
		foreach($query->result() as $k){
			$id = $k->land_id;
		}

		echo json_encode($id);
	}	

	public function clearance_payment()
	{
		$data = [
			"land_id" => clean_data(post("land_id")),
			"or_number" => clean_data(post("clearance_ornumber")),
			"or_date" =>  date("m/d/Y"),
			"payment" =>  saveMoney(clean_data(post("clearance_fee"))),
			"print" => 1
		];

		$query = $this->Main_model->insert("tax_clearance_payment",$data);

		echo json_encode($data);
	}
	public function clearance_check_or()
	{
		$where = [
			"or_number" => clean_data(post("or_no")),
		];
		$query = $this->Main_model->check_or("tax_clearance_payment","*",$where);

		echo json_encode($query->num_rows());
	}


	public function payment_compute()
	{

		//CHANGE PAYMENT METHOD
		//COMPROMISE..
		$whereGetPayment = [
			"tax_order_id" => clean_data(post("id")),	
		]; 
		$nestedData = [];
		$data = [];
		$penalty = 0;
		$discount = 0;
		$getPaymentQuery = $this->Main_model->getPayment($whereGetPayment);
	
		foreach($getPaymentQuery as $k)
		{	
			$nestedData["start_date"] = $k->start_date;
			$nestedData["due_date"] = $k->due_date;
			$nestedData["due_basic"] = $k->due_basic;
			$nestedData["id"] = $k->id;
		}

		$whereIdPayment = [
			"id" => $nestedData["id"],
		];

		$getDueDate =explode("/", $nestedData["due_date"]);
		$getStartDate =explode("/", $nestedData["start_date"]);
		$dmonth = $getDueDate[0];
		$smonth = $getStartDate[0];

	

		 if ($smonth <= date("m") && $dmonth >= date("m")){
			$updateData = [
				"due_penalty" => $penalty,
				"due_discount" => $discount,
				"due_total" => ($nestedData["due_basic"] * 2) + $penalty - $discount,
			];
		   $query = $this->Main_model->update("payment",$updateData,$whereIdPayment);
		}
		if ($dmonth < date("m")){
			$diff = monthDiff($getDueDate[0],$getDueDate[2]);
			$penalty = penalty($nestedData["due_basic"],2,$diff);
			$updateData = [
				"due_penalty" => $penalty,
				"due_discount" => $discount,
				"due_total" => ($nestedData["due_basic"] * 2) + $penalty - $discount,
			];
			$query = $this->Main_model->update("payment",$updateData,$whereIdPayment);
		 }
		if ($smonth > date("m"))
		 {
			$discount = discount($nestedData["due_basic"]);
			$updateData = [
				"due_penalty" => $penalty,
				"due_discount" => $discount*(-1),
				"due_total" => ($nestedData["due_basic"] * 2) + $penalty - ($discount * -1),
			];
			$query = $this->Main_model->update("payment",$updateData,$whereIdPayment);
		 }
		 
		
		 $paymentInfoQuery = $this->Main_model->getPaymentInfo($nestedData["id"]);

		 foreach($paymentInfoQuery as $k)
		 {
			 $nestedData["mode_of_payment"]  = $k->mode_of_payment;
			 $nestedData["due_basic"]  = $k->due_basic;
			 $nestedData["due_sef"]  = $k->due_sef;
			 $nestedData["due_penalty"]  = $k->due_penalty;
			 $nestedData["due_discount"]  = $k->due_discount;
			 $nestedData["due_total"]  = $k->due_total;
			 $nestedData["tax_year"]  = $k->tax_year;
			 $nestedData["payment_no"]  = $k->payment_no;
			 $nestedData["land_id"]  = $k->land_id;
			 $nestedData["payment_id"]  = $k->paymentid;
			 $nestedData["balance"]  = $k->balance;
		 }

		

		 $ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

		 $data = [
			 "payment" =>$nestedData,
			 "landAndOwner" => $ownerAndLandQuery,
		 ];

		// $table = "land";
		// $updateData = [
		// 	"last_payment_assessed" => date("Y"),
		// ];
		// $where = [
		// 	"id" => $getData["id"],
		// ];
		// $query = $this->Main_model->update($table,$updateData,$where);

		echo json_encode($data);
	}

	public function compromise_compute()
	{
		$whereGetPayment = [
			"tax_order_id" => clean_data(post("id")),	
		]; 

		$nestedData = [];
		$data = [];
		$penalty = 0;
		$discount = 0;
		$getPaymentQuery = $this->Main_model->getPayment($whereGetPayment);

		foreach($getPaymentQuery as $k)
		{	
			$nestedData["start_date"] = $k->start_date;
			$nestedData["due_date"] = $k->due_date;
			$nestedData["due_basic"] = $k->due_basic;
			$nestedData["id"] = $k->id;
		}

		$paymentInfoQuery = $this->Main_model->getCompromiseInfo($nestedData["id"]);

		foreach($paymentInfoQuery as $k)
		{
			$nestedData["mode_of_payment"]  = $k->mode_of_payment;
			$nestedData["due_basic"]  = $k->due_basic;
			$nestedData["due_sef"]  = $k->due_sef;
			$nestedData["due_penalty"]  = $k->due_penalty;
			$nestedData["due_discount"]  = $k->due_discount;
			$nestedData["due_total"]  = $k->due_total;
			$nestedData["total_payment"]  = $k->total_payment;
			$nestedData["tax_year"]  = $k->tax_year;
			$nestedData["payment_no"]  = $k->payment_no;
			$nestedData["land_id"]  = $k->land_id;
			$nestedData["payment_id"]  = $k->paymentid;
			$nestedData["balance"]  = $k->balance;
			
		}

	   

		$ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

		$data = [
			"payment" =>$nestedData,
			"landAndOwner" => $ownerAndLandQuery,
		];

		echo json_encode($data);
	}

	public function getPayment_method()
	{
		$where = [
			"id" => clean_data(post("id")),
		];

		$query = $this->Main_model->select("tax_order","*",$where);

		$nestedData = [];
		foreach($query->result() as $k)
		{
			$nestedData["basic"] = $k->basic;
			$nestedData["sef"] = $k->sef;
			$nestedData["penalty"] = $k->penalty;
			$nestedData["discount"] = $k->discount;
			$nestedData["total"] = $k->total;
			$nestedData["balance"] = $k->balance;
			$nestedData["mode_of_payment"] = $k->mode_of_payment;
			$nestedData["land_id"] = $k->land_id;

		}

		echo json_encode($nestedData);

	}

	public function mop_compute()
	{
		$where = [
			"id" => clean_data(post("id")),
		];

		$query = $this->Main_model->select("land","assessed_value",$where);
		$data = "";
		foreach($query->result() as $k)
		{
			$data = $k->assessed_value;
		}

		echo json_encode($data);
	}

	public function payment_table()
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

			$totalData = $this->Main_model->all_post_payment_count();

			$totalFiltered = $totalData; 

			if(empty($this->input->post('search')['value']))
			{            
			$posts = $this->Main_model->all_post_payment($limit,$start,$order,$dir);
			}
			else {
			$posts =  $this->Main_model->all_post_payment_search($limit,$start,$search,$order,$dir);
			$totalFiltered = $this->Main_model->all_post_payment_search_count($search);
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
				$nestedData['action'] = "<button class = ' btn btn-success btn-sm' onclick= 'payment(".$post->id.")' data-toggle='tooltip' title='TAX PAYMENT'><i class='fa fa-money-bill-alt'></i></button>
				<button class = ' btn btn-warning btn-sm payment' onclick='payment_history(\"".$post->id."\")'data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button> 
				<button class = ' btn btn-danger btn-sm payment' onclick='payment_method(\"".$post->id."\")'data-toggle='tooltip' title='CHANGE MODE OF PAYMENT'>  <i class='fa fa-handshake'></i></button> ";
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

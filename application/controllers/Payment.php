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
			 "or_date" => date("Y-m-d"),
		];

		$queryORID = $this->Main_model->insertWithId("or_pool",$orData);


		$getData = [
			 "payor_name" => clean_data(post("payor_name")),
			 "cash_rec" => saveMoney(clean_data(post("cash_rec"))),
			 "check_rec" => saveMoney(clean_data(post("check_rec"))),
			 "total_rec" => saveMoney(clean_data(post("total_rec"))),
			 "due_total" => saveMoney(clean_data(post("due_total"))),
			 "due_penalty" => saveMoney(clean_data(post("due_penalty"))),
			 "due_discount" => saveMoney(clean_data(post("due_discount"))),
			 "tax_year" => clean_data(post("tax_year")),
			 "payment_status" => "PAID",
			 "or_pool_id" => $queryORID,
		];
		$where = [
			"id" => clean_data(post("payment_id")),
		];

		$balance = saveMoney(clean_data(post("balance")));
		$due_total = saveMoney(clean_data(post("due_total")));
		$due_penalty = saveMoney(clean_data(post("due_penalty")));
		$due_discount = saveMoney(clean_data(post("due_discount")));

		$sagot = Floatval($balance) - Floatval($due_total) + Floatval($due_penalty) - Floatval($due_discount);
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
			"balance" => $sagot,
		];
		$query = $this->Main_model->update("tax_order",$updateData,$whereTaxId);

		$updateStatus = [
			"payment_status" => "PAID"
		];
		$where = [
			"balance" => 0,
		];
		$checkPaid = $this->Main_model->update("tax_order",$updateStatus,$where);

		// $getlandId = $this->Main_model->select("tax_order", "land_id",$whereTaxId);
		// $land_id;
		// foreach($getlandId->result() as $k)
		// {
		// 	$land_id = $k->land_id;
		// }

		// $table = "land";
		// $updateData = [
		// 	"last_payment_assessed" => $getData["tax_year"],
		// ];
		// $where = [
		// 	"id" => $land_id,
		// ];
		// $query = $this->Main_model->update($table,$updateData,$where);


		echo json_encode($balance." ".$due_discount." ".$due_penalty." ".$due_total." ".$sagot);
	}

	public function view_OR()
	{
    $taxData = clean_data(post("taxData"));
		$where = [
			"payment.id" => clean_data(post("id")),
		];

    if($taxData == "Land")
    {
      $orData = $this->Main_model->getOrPayment($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/viewReceipt',$data);
    }
    else if($taxData == "Building")
    {
      $orData = $this->Main_model->getOrPaymentBuilding($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/viewReceipt',$data);
    }
	
	}

	public function print_OR()
	{
    $taxData = clean_data(post("taxData"));
		$where = [
			"payment.id" => clean_data(post("id")),
		];

    if($taxData == "Land")
    {
      $orData = $this->Main_model->getOrPayment($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/printReceipt',$data);
    }
    else if($taxData == "Building")
    {
      $orData = $this->Main_model->getOrPaymentBuilding($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/printReceipt',$data);
    }
	}


	public function payment_check()
	{
		$data_bank = $this->input->post('ch');

		$query = $this->Main_model->insert("check_payment",$data_bank);

		echo json_encode($data_bank);
	}

	public function payment_history()
	{
    $taxData = clean_data(post("taxData"));
    
		$where = [
			"tax_order.id" => clean_data(post("id")),
		];
		$pinQuery = $this->Main_model->select("tax_order","building_id,land_id",$where);
    $building_id;
    $land_id;
		foreach($pinQuery->result() as $k)
		{
      $building_id = $k->building_id;
      $land_id = $k->land_id;
		}
		
		$where = [
			"payment.payment_status" => "PAID",
		];

    $data = [];
    if($taxData == "Land")
    {
      $taxOrder = $this->Main_model->getTaxOrderLand($land_id);
      $payment = $this->Main_model->getPaymentHistoryLand($land_id,$where);
      $owner = $this->Main_model->getLandAndOwner($land_id);
      $data = [
        "payment" => $payment->result(),
        "owner" => $owner->result(),
        "tax_order" => $taxOrder->result(),
        "admin" => $this->session->userdata("role"),
      ];
      
      echo json_encode($data);
    }
    else if($taxData == "Building")
    {
      $taxOrder = $this->Main_model->getTaxOrderBuilding($building_id);
      $payment = $this->Main_model->getPaymentHistoryBuilding($building_id,$where);
      $owner = $this->Main_model->getBuildingAndOwner($building_id);
      $data = [
        "payment" => $payment->result(),
        "owner" => $owner->result(),
        "tax_order" => $taxOrder->result(),
        "admin" => $this->session->userdata("role"),
      ];
      
      echo json_encode($data);
    }
	

		
	}

	public function check_or()
	{
		$where = [
			"or_number" => clean_data(post("or_no")),
		];
		$query = $this->Main_model->check_or("or_pool","*",$where);

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
		$cancelData = [];
		$where = [
			"or_number" => clean_data(post("or_number")),
		];
		$query = $this->Main_model->getCancelORPayment($where);
		foreach($query as $k)
		{
			$cancelData = [
				"due_basic" => $k->due_basic,
				"due_sef" => $k->due_sef,
				"payment_no" => $k->payment_no,
				"due_date" => $k->due_date,
				"start_date" => $k->start_date,
				"tax_order_id" => $k->tax_order_id,
				"payment_id" => $k->id,
				"tax_year" => $k->tax_year,
			];
		}
		$update = [
			"payment_status" => "CANCEL",
		];
		
		$cancelWhere = [
			"id" => $cancelData["payment_id"],
		];
		$this->Main_model->update("payment",$update,$cancelWhere);
		
	
		$whereTO = [
			"id" => $cancelData["tax_order_id"],
		];
		$query = $this->Main_model->select("tax_order","balance",$whereTO);
		$balance;
		foreach($query->result() as $k)
		{
			$balance = $k->balance;
		}
		$newData = [
			"due_basic" => $cancelData["due_basic"],
			"due_sef" => $cancelData["due_sef"],
			"payment_no" => $cancelData["payment_no"],
			"due_date" => $cancelData["due_date"],
			"start_date" => $cancelData["start_date"],
			"tax_order_id" => $cancelData["tax_order_id"],
			"tax_year" => $cancelData["tax_year"],
		];
		$this->Main_model->insert("payment",$newData);
		$sumBalance = (Floatval($cancelData["due_basic"]) + Floatval($cancelData["due_sef"]));
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

		$orData = [
			"or_number" => clean_data(post("clearance_ornumber")),
			 "or_date" => date("Y-m-d"),
			
		];

		$queryORID = $this->Main_model->insertWithId("or_pool",$orData);
		$data = [
			"land_id" => clean_data(post("land_id")),
			"or_pool_id" => $queryORID,
			"payor_name" => clean_data(post("payor_name")),
			"payment" =>  saveMoney(clean_data(post("clearance_fee"))),
			"print" => 1
		];

		$query = $this->Main_model->insert("tax_clearance_payment",$data);

		echo json_encode($queryORID);
	}

	public function clearance_rview()
	{
		$where = [
			"or_pool.id" => clean_data(post("or_id")),
		];

		$query = $this->Main_model->getClearanceOr($where);

		$data = [
			"clearance_or" => $query->result(),
		];

		echo json_encode($data);
		
		$this->load->view('pages/clearance_rec',$data);

	}

	public function clearance_rprint()
	{
		$where = [
			"or_pool.id" => clean_data(post("id")),
		];

		$query = $this->Main_model->getClearanceOr($where);

		$data = [
			"clearance_or" => $query->result(),
		];

		echo json_encode($data);
		
		$this->load->view('pages/clearance_rec2',$data);
	}
	

	public function payment_compute()
	{
    
    $taxData = clean_data(post("taxData"));
		
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
				"due_penalty" => $penalty * 2,
				"due_discount" => $discount,
				"due_total" => ($nestedData["due_basic"] * 2) + ($penalty *2)- $discount,
			];
			$query = $this->Main_model->update("payment",$updateData,$whereIdPayment);
		 }
		if ($smonth > date("m"))
		 {
			$discount = discount($nestedData["due_basic"]);
			$updateData = [
				"due_penalty" => $penalty,
				"due_discount" => $discount*(-2) ,
				"due_total" => ($nestedData["due_basic"] * 2) + $penalty - ($discount * -2),
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
       $nestedData["building_id"]  = $k->building_id;
			 $nestedData["balance"]  = $k->balance;
		 }

     
     if($taxData == "Land")
     {
      $ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

      $data = [
        "payment" =>$nestedData,
        "landAndOwner" => $ownerAndLandQuery,
      ];
     }
     else if($taxData == "Building")
     {  
      $ownerAndLandQuery = $this->Main_model->getOwnerAndBuildingInfo($nestedData["building_id"]);

      $data = [
        "payment" =>$nestedData,
        "landAndOwner" => $ownerAndLandQuery,
      ];
     }

		

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
			"land.id" => clean_data(post("id")),
		];

		$data =[];
		
		$querytax = $this->Main_model->selecttax($where);
		foreach($querytax->result() as $k)
		{
			$data["assessed_value"]= $k->assessed_value;
			$data["basic"] = $k->basic;
			$data["penalty"] = $k->penalty;
			$data["discount"] = $k->discount;
		}

		echo json_encode($data);
	}

	public function change_payment_method()
	{
		$getData =[
			"tax_order_id" => clean_data(post("tax_order_id")),
			"mode_of_payment" => clean_data(post("mode_of_payment")),
			"mop1" => saveMoney(clean_data(post("mop1"))),
			"mop2" => saveMoney(clean_data(post("mop2"))),
		];

		$where = [
			"id" => $getData["tax_order_id"],
		];
		$update = [
			"mode_of_payment" => $getData["mode_of_payment"],
		];

		$this->Main_model->update("tax_order",$update,$where);

		$query = $this->Main_model->select("tax_order","total,balance,id,year_assessed",$where);
		$total;
		$balanace;
		$id;
		$year;
		foreach($query->result() as $k)
		{
			$total = $k->total;
			$balance = $k->balance;
			$id = $k->id;
			$year = $k->year_assessed;
		}
		$updatewhere = [
			"tax_order_id" => $getData["tax_order_id"],
			"tax_year" => $year,
		];
		$updatedata = [
			"payment_status" => "MODE OF PAYMENT CHANGE"
		];
		$this->Main_model->updateStatus($updatedata,$updatewhere);

		$data = "";
		$yearnow = date("Y");
		$startDateSemi = array("1/1/".$yearnow,"7/1/".$yearnow);
		$dueDateSemi = array("6/30/".$yearnow,"12/31/".$yearnow);
		$startDateQuarterly = array("1/1/".$yearnow,"4/1/".$yearnow,"7/1/".$yearnow,"10/1/".$yearnow);
		$dueDateQuarterly = array("3/31/".$yearnow,"6/30/".$yearnow,"9/30/".$yearnow,"12/31/".$yearnow);
		$startDateCompromise = array("1/1/".$yearnow,"2/1/".$yearnow,"3/1/".$yearnow,"4/1/".$yearnow,"5/1/".$yearnow,"6/1/".$yearnow,"7/1/".$yearnow,"8/1/".$yearnow,"9/1/".$yearnow,"10/1/".$yearnow,"11/1/".$yearnow,"12/1/".$yearnow);
		$dueDateCompromise = array("1/31/".$yearnow,"2/29/".$yearnow,"3/31/".$yearnow,"4/30/".$yearnow,"5/31/".$yearnow,"6/30/".$yearnow,"7/31/".$yearnow,"8/31/".$yearnow,"9/30/".$yearnow,"10/31/".$yearnow,"11/30/".$yearnow,"12/31/".$yearnow);
		if($total == $balance)
		{
			$first_payment = array($getData["mop1"]);
			switch($getData["mode_of_payment"])
			{
				case "Semi Annually" : 

					for($i=0;$i<2;$i++){
						$insertData = [
							"start_date" => $startDateSemi[$i],
							"due_date" => $dueDateSemi[$i],
							"due_basic" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"due_sef" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"tax_year" => date("Y"),
							"payment_no" => $i+1,
							"tax_order_id" => $getData["tax_order_id"],
						];
	
						$this->Main_model->insert("payment",$insertData);
					}
					
				break;
				case "Quarterly" : 

					for($i=0;$i<4;$i++){
						$insertData = [
							"start_date" => $startDateQuarterly[$i],
							"due_date" => $dueDateQuarterly[$i],
							"due_basic" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"due_sef" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"tax_year" => date("Y"),
							"payment_no" => $i+1,
							"tax_order_id" => $getData["tax_order_id"],
						];
						$this->Main_model->insert("payment",$insertData);
					}
				break;	
				case "Compromise" :
					$number_of_payment = clean_data(post("number_of_payment"));
					for($i=0;$i<$number_of_payment;$i++){
						$insertData = [
							
							"due_basic" => Floatval($first_payment[0])/2,
							"due_sef" => Floatval($first_payment[0])/2,
							"due_total" => $first_payment[0],
							"tax_year" => date("Y"),
							"payment_no" => $i+1,
							"tax_order_id" => $getData["tax_order_id"],
						];
						$this->Main_model->insert("compromise",$insertData);
					}
				break;
				
			}
		}
		else{
			
			switch($getData["mode_of_payment"])
			{

				case "Quarterly" : 
					for($i=0;$i<2;$i++){
						$insertData = [
							"start_date" => $startDateSemi[$i],
							"due_date" => $dueDateSemi[$i],
							"due_basic" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"due_sef" => $first_payment[$i] == NULL? Floatval($getData["mop2"]) / 2 : Floatval($getData["mop1"]) / 2,
							"tax_year" => date("Y"),
							"payment_no" => $i+1,
							"tax_order_id" => $getData["tax_order_id"],
						];
						$this->Main_model->insert("payment",$insertData);
					}
				break;	
				case "Compromise" :

					$number_of_payment = clean_data(post("number_of_payment"));
					for($i=0;$i<$number_of_payment;$i++){
						$insertData = [
							
							"due_basic" => Floatval($first_payment[0])/2,
							"due_sef" => Floatval($first_payment[0])/2,
							"due_total" => $first_payment[0],
							"tax_year" => date("Y"),
							"payment_no" => $i+1,
							"tax_order_id" => $getData["tax_order_id"],
						];
						$this->Main_model->insert("compromise",$insertData);
					}
				break;
				
			}
		}




		echo json_encode($data);
	}

	public function payment_table()
	{
		
    $taxData = clean_data(post("searchType"));
    $search = clean_data(post("search"));

		$columns = array( 
			0 =>'first_name', 
			1 =>'barangay',
			2 =>'pin_barangay',
			3 =>'tax_dec_no',
			4 => 'id',
		);
			$limit = $this->input->post('length');
			$start = $this->input->post('start');
			// $order = $columns[$this->input->post('order')[0]['column']];
			$dir = $this->input->post('order')[0]['dir'];
			// $search = $this->input->post('search')['value']; 

			//DATATABLE VARIABLES
      
			//END OF DATATABLE VARIABLES
      if($taxData == "Land")
      {
        $totalData = $this->Main_model->all_post_paymentland_count($search);

        $totalFiltered = $totalData; 
  
                 
        $posts = $this->Main_model->all_post_paymentland($limit,$start,$dir,$search);

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
      else if($taxData == "Building")
      {
        $totalData = $this->Main_model->all_post_paymentbuilding_count($search);

        $totalFiltered = $totalData; 
  
                 
        $posts = $this->Main_model->all_post_paymentbuilding($limit,$start,$dir,$search);

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


}
?>

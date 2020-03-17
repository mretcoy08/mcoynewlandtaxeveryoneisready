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
			 "or_date" => date("Y-m-d"),
		];

		$queryORID = $this->Main_model->insertWithId("or_pool",$orData);

		$getData = [
			 "payor_name" => clean_data(post("payor_name")),
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
		
		$updateData1 = [	
			"balance" => Floatval(saveMoney(clean_data(post("balance")))) - Floatval(saveMoney(clean_data(post("due_total")))),
		];
		$query = $this->Main_model->update("tax_order",$updateData1,$whereTaxId);

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


		echo json_encode($updateData1);
    }

    public function compromise_check()
	{
		$data_bank = $this->input->post('ch');

		$query = $this->Main_model->insert("check_payment",$data_bank);

		echo json_encode($data_bank);
	}
    

	public function compromise_payment()
	{

    $taxData = clean_data(post("taxData"));

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
      $nestedData["building_id"]  = $k->building_id;
			$nestedData["payment_id"]  = $k->id;
      $nestedData["balance"]  = $k->balance;
		}

	   
    if($taxData == "Land")
    {
      $ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

      $data = [
        "payment" =>$nestedData,
        "landAndOwner" => $ownerAndLandQuery,
      ];
  
      echo json_encode($data);
    }
    else if($taxData == "Building")
    {
      $ownerAndLandQuery = $this->Main_model->getOwnerAndBuildingInfo($nestedData["building_id"]);

      $data = [
        "payment" =>$nestedData,
        "landAndOwner" => $ownerAndLandQuery,
      ];
  
      echo json_encode($data);
    }
		// $ownerAndLandQuery = $this->Main_model->getOwnerAndLandInfo($nestedData["land_id"]);

		// $data = [
		// 	"payment" =>$nestedData,
		// 	"landAndOwner" => $ownerAndLandQuery,
		// ];

		// echo json_encode($data);
	}
	

	public function compromise_history()
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


		// $where = [
		// 	"compromise.payment_status" => "PAID",
	
		// ];
		// $taxOrder = $this->Main_model->getTaxOrder($pin);
		// $payment = $this->Main_model->getCompromiseHistory($pin,$where);

		// $owner = $this->Main_model->getLandAndOwner($pin);

		// $data = [
		// 	"payment" => $payment->result(),
		// 	"owner" => $owner->result(),
		// 	"tax_order" => $taxOrder->result(),
		// 	"admin" => $this->session->userdata("role"),
		// ];
    // echo json_encode($data);
    

    $where = [
			"compromise.payment_status" => "PAID",
		];

    $data = [];
    if($taxData == "Land")
    {
      $taxOrder = $this->Main_model->getTaxOrderLand($land_id);
      $payment = $this->Main_model->getCompromiseHistoryLand($land_id,$where);
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
      $payment = $this->Main_model->getCompromiseHistoryBuilding($building_id,$where);
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

	public function view_OR()
	{

    $taxData = clean_data(post("taxData"));
		$where = [
			"compromise.id" => clean_data(post("id")),
		];

    if($taxData == "Land")
    {
      $orData = $this->Main_model->getOrCompromise($where);
      $data['orData'] = $orData->result();

      echo json_encode($data);
      $this->load->view('pages/viewReceipt',$data);
    }
    else if($taxData == "Building")
    {
      $orData = $this->Main_model->getOrCompromiseBuilding($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/viewReceipt',$data);
    }
		  
		
	}

	public function print_OR()
	{
    $taxData = clean_data(post("taxData"));
		$where = [
			"compromise.id" => clean_data(post("id")),
		];

    if($taxData == "Land")
    {
      $orData = $this->Main_model->getOrCompromise($where);
      $data['orData'] = $orData->result();

      echo json_encode($data);
      $this->load->view('pages/printReceipt',$data);
    }
    else if($taxData == "Building")
    {
      $orData = $this->Main_model->getOrCompromiseBuilding($where);
      $data['orData'] = $orData->result();
  
      echo json_encode($data);
      $this->load->view('pages/printReceipt',$data);
    }
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
		$query = $this->Main_model->getCancelORComrpomise($where);
		foreach($query as $k)
		{
			$cancelData = [
				"due_basic" => $k->due_basic,
				"due_sef" => $k->due_sef,
				"payment_no" => $k->payment_no,
				"tax_order_id" => $k->tax_order_id,
				"compromise_id" => $k->id,
				"tax_year" => $k->tax_year,
			];
		}
		$update = [
			"payment_status" => "CANCEL",
		];
		
		$cancelWhere = [
			"id" => $cancelData["compromise_id"],
		];
		$this->Main_model->update("compromise",$update,$cancelWhere);
		
	
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
      "due_total" => $cancelData["due_basic"] * 2,
			"payment_no" => $cancelData["payment_no"],
			"tax_order_id" => $cancelData["tax_order_id"],
			"tax_year" => $cancelData["tax_year"],
		];
		$this->Main_model->insert("compromise",$newData);
		$sumBalance = (Floatval($cancelData["due_basic"]) + Floatval($cancelData["due_sef"])) +Floatval($balance);
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


	public function compromise_table()
	{
    
    
    $search = clean_data(post(""));
    $searchType = clean_data(post("searchType"));

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
		

			//DATATABLE VARIABLES

			//END OF DATATABLE VARIABLES
      if($searchType == "Land")
      {
        $totalData = $this->Main_model->all_post_compromise_land_count($search);

        $totalFiltered = $totalData; 
  
        if(empty($this->input->post('search')['value']))
        {            
        $posts = $this->Main_model->all_post_compromise_land($limit,$start,$order,$dir,$search);
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
      else if($searchType == "Building")
      {
        $totalData = $this->Main_model->all_post_compromise_building_count($search);

        $totalFiltered = $totalData; 
  
        if(empty($this->input->post('search')['value']))
        {            
        $posts = $this->Main_model->all_post_compromise_building($limit,$start,$order,$dir,$search);
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
            $nestedData['action'] = "<button class = ' btn btn-warning btn-sm payment' onclick='compromise_history(\"".$post->id."\")' data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button>
          <button class = ' btn btn-primary btn-sm' onclick= 'clearance(".$post->id.")' data-toggle='tooltip' title='CLEARANCE PAYMENT'><i class='fa fa-money-bill-alt'></i></button>";
          }
          else{
            $nestedData['action'] = "<button class = ' btn btn-warning btn-sm payment' onclick='compromise_history(\"".$post->id."\")' data-toggle='tooltip' title='PAYMENT HISTORY'>  <i class='fa fa-history'></i></button>";
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
			
			// else {
			// $posts =  $this->Main_model->all_post_compromise_search($limit,$start,$search,$order,$dir);
			// $totalFiltered = $this->Main_model->all_post_compromise_search_count($search);
			// }
		
	}


}

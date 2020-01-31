<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_order_assessment extends CI_Controller {

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

	public function assessment()
	{
	
		$where = [
			'id' => clean_data(post('id'))
		];
		$where_owner = [
			'land_id' => clean_data(post('id')),
		];
        $table1 = "land";
        $table2 = "land_owner";

        $select1 = "CONCAT(pin_city, '-', pin_district, '-', pin_barangay, '-',pin_section, '-', pin_parcel) as pin, tax_dec_no, barangay, assessed_value, land_status, id, last_paid_assessed";
        $select2 = "CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name";
        
        $query1 = $this->Main_model->select($table1,$select1,$where);
        $query2 = $this->Main_model->select($table2,$select2,$where_owner);
        $data = [];
        foreach($query1->result() as $k){
            $data['pin'] = $k->pin;
            $data['location'] = $k->barangay;
            $data['arp_no'] = $k->tax_dec_no;
            $data['land_faas_id'] = $k->id;
            $data['assessed_value'] = $k->assessed_value;
            $data['status_of_tax'] = $k->land_status;
			// $data['assess_effectivity'] = $k->year_assessed;
			$data['last_paid_assessed'] = $k->last_paid_assessed;
        }

       $data['full_name'] = $query2->result();
        echo json_encode($data);
	}
	public function assessment_table()
	{

		$assessment_search = clean_data(post("assessment_search"));

		$columns = array( 
			0 =>'first_name', 
			1 =>'barangay',
			2 =>'pin_barangay',
			3 =>'tax_dec_no',
			4 =>'id',

		);
			$limit = $this->input->post('length');
			$start = $this->input->post('start');
			$order = $columns[$this->input->post('order')[0]['column']];
			$dir = $this->input->post('order')[0]['dir'];
			$search = $this->input->post('search')['value']; 

			//DATATABLE VARIABLES

			//END OF DATATABLE VARIABLES

			$totalData = $this->Main_model->all_post_count_toa($assessment_search);

			$totalFiltered = $totalData; 

			if(empty($this->input->post('search')['value']))
			{            
			$posts = $this->Main_model->all_post_toa($limit,$start,$order,$dir,$assessment_search);
			}
			else {
			$posts =  $this->Main_model->post_search_toa($limit,$start,$search,$order,$dir,$assessment_search);
			$totalFiltered = $this->Main_model->post_search_count_toa($search,$assessment_search);
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
			$nestedData['action'] = "<button class = ' btn btn-success btn-sm blah' onclick= 'assesst(".$post->id.")'><i class='fa fa-edit'></i></button>";

			$data[] = $nestedData;
			}
			}

			$json_data = array(
				"draw"            => intval($this->input->post('draw')),  
				"recordsTotal"    => intval($totalData),  
				"recordsFiltered" => intval($totalFiltered), 
				"data"            => $data, 
				"test" => $assessment_search
				);
				
			echo json_encode($json_data); 
			}

	public function print_taxOrder(){

		
		
				$getData = [
					"id" => clean_data(post("id")),
					"mode_of_payment" => clean_data(post("mode_of_payment")),
					"year_of_effectivity" => clean_data(post("year_of_effectivity")),
					"last_paid_year" => clean_data(post("last_paid_year")),
					"assessed_value" => saveMoney(clean_data(post("assessed_value"))),
					"basic_fee" => saveMoney(clean_data(post("basic_fee"))),
					"total_fee" => saveMoney(clean_data(post("total_fee"))),
					"mop1" => saveMoney(clean_data(post("mop1"))),
					"mop2" => saveMoney(clean_data(post("mop2"))),
					"mop3" => saveMoney(clean_data(post("mop3"))),
					"mop4" => saveMoney(clean_data(post("mop4"))),
					"total_basic" => saveMoney(clean_data(post("basic_total"))),
					"total_penalty" => saveMoney(clean_data(post("penalty_total"))),
					"total_discount" => saveMoney(clean_data(post("discount_total"))),
					"number_of_payment" => clean_data(post("number_of_payment")),
					"down_payment" => saveMoney(clean_data(post("down_payment"))),
				];
				$checkWhere = [
					"land_id" => $getData["id"],
					"year_assessed" => date("Y"),
				];
				$checkQuery = $this->Main_model->select("tax_order","*",$checkWhere);
				$data = "";
				if($checkQuery->num_rows() > 0)
				{
					$data = "MERON NA!";
				}
				else{
						$basic1 = $getData["mop1"];
						$basic2 = $getData["mop2"];
						$basic3 = $getData["mop3"];
						$basic4 = $getData["mop4"];
						
					
						
						
						
						$insertData = [
							"basic" => $getData["total_basic"],
							"sef" =>  $getData["total_basic"],
							"penalty" =>  $getData["total_penalty"],
							"discount" =>  Floatval($getData["total_discount"]) *(-1),
							"total" => $getData["total_fee"],
							"balance" => $getData["total_fee"],
							"mode_of_payment" => $getData["mode_of_payment"],
							"year_assessed" => date("Y"),
							"year_of_effectivity" => $getData["year_of_effectivity"],
							"payment_status" => "PENDING",
							"land_id" => $getData["id"]
						];
						
						
						$query = $this->Main_model->insertWithId("tax_order",$insertData);

						
						$yearnow = date("Y");
						$startDateSemi = array("1/1/".$yearnow,"7/1/".$yearnow);
						$dueDateSemi = array("6/30/".$yearnow,"12/31/".$yearnow);
						$startDateQuarterly = array("1/1/".$yearnow,"4/1/".$yearnow,"7/1/".$yearnow,"10/1/".$yearnow);
						$dueDateQuarterly = array("3/31/".$yearnow,"6/30/".$yearnow,"9/30/".$yearnow,"12/31/".$yearnow);
						$divPayment = array($basic1,$basic2,$basic3,$basic4);
						$startDateCompromise = array("1/1/".$yearnow,"2/1/".$yearnow,"3/1/".$yearnow,"4/1/".$yearnow,"5/1/".$yearnow,"6/1/".$yearnow,"7/1/".$yearnow,"8/1/".$yearnow,"9/1/".$yearnow,"10/1/".$yearnow,"11/1/".$yearnow,"12/1/".$yearnow);
						$dueDateCompromise = array("1/31/".$yearnow,"2/29/".$yearnow,"3/31/".$yearnow,"4/30/".$yearnow,"5/31/".$yearnow,"6/30/".$yearnow,"7/31/".$yearnow,"8/31/".$yearnow,"9/30/".$yearnow,"10/31/".$yearnow,"11/30/".$yearnow,"12/31/".$yearnow);
						
						$counts = 0;
						$insertData = [];
						switch($getData['mode_of_payment'])
						{
							case "Annually":
								$insertData = [
									"start_date" => "1/1/".$yearNow,
									"due_date" => "3/31/".$yearNow,
									"due_basic" => $getData["basic_fee"],
									"due_sef" => $getData["basic_fee"],
									"tax_year" => $yearnow,
									"payment_no" => "1",
									"tax_order_id" => $query,
										];
								$query2 = $this->Main_model->insert("payment",$insertData);
							break;
							case "Semi Annually":
							for($i=0;$i<2;$i++)
							{
								$insertData = [
									"start_date" => $startDateSemi[$i],
									"due_date" => $dueDateSemi[$i],
									"due_basic" => $divPayment[$i]/2,
									"due_sef" => $divPayment[$i]/2,
									"tax_year" =>  $yearnow,
									"payment_no" => $i+1,
									"tax_order_id" => $query,
								];
								$query2 = $this->Main_model->insert("payment",$insertData);
							}
							break;
							case "Quarterly":
								for($i=0;$i<4;$i++)
							{
								$insertData = [
									"start_date" => $startDateQuarterly[$i],
									"due_date" => $dueDateQuarterly[$i],
									"due_basic" =>  $divPayment[$i]/2,
									"due_sef" => $divPayment[$i]/2,
									"tax_year" =>  $yearnow,
									"payment_no" => $i+1,
									"tax_order_id" => $query,
								];
								$query2 = $this->Main_model->insert("payment",$insertData);
							}
							break;

							case "Compromise": 
								// $dm = date("m");
								// $dm = Intval($dm) + Intval($getData["number_of_payment"]);
								// $dmonth = ((Intval(date("m"))) + Intval($getData{"number_of_payment"}));
								// $dyear = 0;
								// if($dmonth > 12)
								// {	$pyear = (Intval(date("m")) + Intval($getData{"number_of_payment"})) % 12;
								// 	$dyear = (Intval($getData["number_of_payment"]) / 12) + Intval(date("Y")) + $pyear;
								// 	$dmonth = ((Intval(date("m"))) + (Intval($getData{"number_of_payment"}) % 12));
								// }
								// else{
								// 	$dmonth = ((Intval(date("m"))) + Intval($getData{"number_of_payment"}));
								// 	$pyear = 0;
								// 	$dyear = (Intval($getData["number_of_payment"]) / 12) + Intval(date("Y")) + $pyear;
								// }
								
								
								// $insertDataPayment = [
									
								// 	// "due_basic" => $basic1/2,
								// 	// "due_sef" => $basic1/2,
								// 	"due_discount" => 0,
								// 	"due_penalty" => 0,
								// 	// "due_total" => $basic1,
								// 	"tax_year"  =>  $getData["year_of_effectivity"],
								// 	"payment_no" => $i+1,
								// 	"tax_order_id" => $query,
								// ];
								$payment = array($getData["down_payment"]);
								for($i=0;$i<=$getData["number_of_payment"];$i++)
								{

									$insertData = [

										"due_basic" => ($payment[$i] == NULL) ? Floatval($basic1)/2 : Floatval($payment[$i]) /2 ,
										"due_sef" => ($payment[$i] == NULL) ? Floatval($basic1)/2 : Floatval($payment[$i]) /2 ,
										"due_total" =>   ($payment[$i] == NULL) ? Floatval($basic1) : Floatval($payment[$i])  ,
										"tax_year"  =>  $yearnow,
										"payment_no" => $i+1,
										"tax_order_id" => $query,
									];
									$query2 = $this->Main_model->insert("compromise",$insertData);
								}
							break;
						}
				}

				
				
			
					echo json_encode($insertData);
				
			}

			



			public function compute(){
		
				$id = clean_data(post("id"));
				$mode_of_payment = clean_data(post("mode_of_payment"));
				$year_of_effectivity = clean_data(post("year_of_effectivity"));
				
				$data =[];
				$getOwnerLocation = $this->Main_model->getOwnerLocation($id);
				$nestedData = [];
				$basic = [];
				$year = [];
				$assessed_value = [];
				$penalty = [];
				$total = [];
				$checkData = [];
				// $upbasic = [];
				// $upyear = [];
				// $upassessed_value = [];
				// $uppenalty = [];
				// $uptotal = [];
				foreach($getOwnerLocation as $k)
				{
					$nestedData['full_name'] = $k->full_name;
					$nestedData['barangay'] = $k->barangay;
					$nestedData['tax_dec_no'] = $k->tax_dec_no;
		
				}
				$data['ownerLocation'] = $nestedData;
				$queryGetLastPayment = $this->Main_model->getLastPayment($id);
				$queryGetYearLastPayment = $this->Main_model->getYearLastPayment($id);
				foreach($queryGetYearLastPayment as $k){
						$checkData = [
							"last_paid_assessed" => $k->last_paid_assessed,
							"assessed_value" => $k->assessed_value,
							"land_status"=> $k->land_status
						];
					}
				// PAYMENT
				if($queryGetLastPayment == "noPayment"){
					$data['check'] = "penaltyWithOutBalanceInQSA";
					
					
					
					//IF MAY UTANG
					if(Date("Y") - $checkData['last_paid_assessed'] > 1)
					{
					
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"]+1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
							$data["test"][]=$diff;
						}

						
							
						}
					
					//ELSE WLANG UTANG
					else{
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							$data['check'] = "penaltyWithOutBalance";
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"] +1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
						}
					}	
					
					
		
					
				}//ELSE OF PAYMENT
				else{
					$data['check'] = "penaltyWithBalanceInQSA";
					$counter = 0;
					foreach($queryGetLastPayment as $k)
					{
						$nestedData['payment_no'] = $k->payment_no;
						$nestedData['mode_of_payment'] = $k->mode_of_payment;
						$nestedData['tax_year'] = $k->tax_year;
						$nestedData['due_basic'] = $k->due_basic;
						$nestedData['id'] = $k->id;
						$data[] = $nestedData;
					}
		
					switch($nestedData['mode_of_payment'])
					{
						case "Annually":
							$data['checkPaymentNo'] = "eks";
							for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity;$nestedData['tax_year']++)
							{
								$basic[$counter] = $nestedData["due_basic"];
								$year[$counter] = $nestedData["tax_year"];
								$assessed_value[$counter] = $nestedData["due_basic"] / 0.01;
								$diff = monthDiff(1,$year[$counter]);
								$penalty[$counter] = 0;
								$total[$counter] = 0;
								if($diff >= 0)
								{
									$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								else{
									$penalty[$counter]= discount($checkData["assessed_value"]*.01);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								$data["basic"][] = $basic;
								$data["year"][] = $year;
								$data["assessed_value"][] = $assessed_value;
								$data["penalty"][] = $penalty;
								$data["total"][] = $total;
							}
						break;

						case "Semi Annually":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*2;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
								case 2:
										$data['checkPaymentNo'] = "semicheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(12,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*2;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
										}
										$data["payno"] =$nestedData['payment_no'];
								break;
							}
						break;
						case "Quarterly":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*4;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
							
								case 2:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(6,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										
								
								case 3:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[101] = $nestedData["due_basic"];
										$upyear[101] = $nestedData["tax_year"];
										$upassessed_value[101] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(9,$upyear[101]);
										$uppenalty[101]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[101] = $upbasic[101] + $uppenalty[101];
										
									
								
								case 4:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[102] = $nestedData["due_basic"];
										$upyear[102] = $nestedData["tax_year"];
										$upassessed_value[102] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(12,$upyear[102]);
										$uppenalty[102]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[102] = $upbasic[102] + $uppenalty[102];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										
										// if($nestedData['tax_year'] == 2019)
										// {
										
										// }	// $nestedData['tax_year'] = $nestedData['tax_year'] -1;

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*4;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
											
										}
										$data["payno"] =$nestedData['payment_no'];
								
							}
		
						break;
		
					}
		
				}
				echo json_encode($data);
				// return $this->load->view('pages/taxorder_print',$data);
			}

			public function viewprint(){
		
				$id = clean_data(post("id"));
				$mode_of_payment = clean_data(post("mode_of_payment"));
				$year_of_effectivity = clean_data(post("year_of_effectivity"));
				
				$data =[];
				$getOwnerLocation = $this->Main_model->getOwnerLocation($id);
				$nestedData = [];
				$basic = [];
				$year = [];
				$assessed_value = [];
				$penalty = [];
				$total = [];
				$checkData = [];
				// $upbasic = [];
				// $upyear = [];
				// $upassessed_value = [];
				// $uppenalty = [];
				// $uptotal = [];
				foreach($getOwnerLocation as $k)
				{
					$nestedData['full_name'] = $k->full_name;
					$nestedData['barangay'] = $k->barangay;
					$nestedData['tax_dec_no'] = $k->tax_dec_no;
		
				}
				$data['ownerLocation'] = $nestedData;
				$queryGetLastPayment = $this->Main_model->getLastPayment($id);
				$queryGetYearLastPayment = $this->Main_model->getYearLastPayment($id);
				foreach($queryGetYearLastPayment as $k){
						$checkData = [
							"last_paid_assessed" => $k->last_paid_assessed,
							"assessed_value" => $k->assessed_value,
							"land_status"=> $k->land_status
						];
					}
				// PAYMENT
				if($queryGetLastPayment == "noPayment"){
					$data['check'] = "penaltyWithOutBalanceInQSA";
					
					
					
					//IF MAY UTANG
					if(Date("Y") - $checkData['last_paid_assessed'] > 1)
					{
					
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"]+1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
							$data["test"][]=$diff;
						}

						
							
						}
					
					//ELSE WLANG UTANG
					else{
						
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							$data['check'] = "penaltyWithOutBalance";
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"] +1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
						}
					}	
					
					
		
					
				}//ELSE OF PAYMENT
				else{
					$data['check'] = "penaltyWithBalanceInQSA";
					$counter = 0;
					foreach($queryGetLastPayment as $k)
					{
						$nestedData['payment_no'] = $k->payment_no;
						$nestedData['mode_of_payment'] = $k->mode_of_payment;
						$nestedData['tax_year'] = $k->tax_year;
						$nestedData['due_basic'] = $k->due_basic;
						$nestedData['id'] = $k->id;
						$data[] = $nestedData;
					}
		
					switch($nestedData['mode_of_payment'])
					{
						case "Annually":
							$data['checkPaymentNo'] = "eks";
							for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity;$nestedData['tax_year']++)
							{
								$basic[$counter] = $nestedData["due_basic"];
								$year[$counter] = $nestedData["tax_year"];
								$assessed_value[$counter] = $nestedData["due_basic"] / 0.01;
								$diff = monthDiff(1,$year[$counter]);
								$penalty[$counter] = 0;
								$total[$counter] = 0;
								if($diff >= 0)
								{
									$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								else{
									$penalty[$counter]= discount($checkData["assessed_value"]*.01);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								$data["basic"][] = $basic;
								$data["year"][] = $year;
								$data["assessed_value"][] = $assessed_value;
								$data["penalty"][] = $penalty;
								$data["total"][] = $total;
							}
						break;

						case "Semi Annually":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*2;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
								case 2:
										$data['checkPaymentNo'] = "semicheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(12,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*2;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
										}
										$data["payno"] =$nestedData['payment_no'];
								break;
							}
						break;
						case "Quarterly":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*4;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
							
								case 2:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(6,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										
								
								case 3:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[101] = $nestedData["due_basic"];
										$upyear[101] = $nestedData["tax_year"];
										$upassessed_value[101] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(9,$upyear[101]);
										$uppenalty[101]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[101] = $upbasic[101] + $uppenalty[101];
										
									
								
								case 4:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[102] = $nestedData["due_basic"];
										$upyear[102] = $nestedData["tax_year"];
										$upassessed_value[102] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(12,$upyear[102]);
										$uppenalty[102]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[102] = $upbasic[102] + $uppenalty[102];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										
										// if($nestedData['tax_year'] == 2019)
										// {
										
										// }	// $nestedData['tax_year'] = $nestedData['tax_year'] -1;

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*4;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
											
										}
										$data["payno"] =$nestedData['payment_no'];
								
							}
		
						break;
		
					}
		
				}
				echo json_encode($data);
				return $this->load->view('pages/taxorder_view',$data);
			}
		
		

			public function printTO(){
		
				$id = clean_data(post("id"));
				$mode_of_payment = clean_data(post("mode_of_payment"));
				$year_of_effectivity = clean_data(post("year_of_effectivity"));
				
				$data =[];
				$getOwnerLocation = $this->Main_model->getOwnerLocation($id);
				$nestedData = [];
				$basic = [];
				$year = [];
				$assessed_value = [];
				$penalty = [];
				$total = [];
				$checkData = [];
				// $upbasic = [];
				// $upyear = [];
				// $upassessed_value = [];
				// $uppenalty = [];
				// $uptotal = [];
				foreach($getOwnerLocation as $k)
				{
					$nestedData['full_name'] = $k->full_name;
					$nestedData['barangay'] = $k->barangay;
					$nestedData['tax_dec_no'] = $k->tax_dec_no;
		
				}
				$data['ownerLocation'] = $nestedData;
				$queryGetLastPayment = $this->Main_model->getLastPayment($id);
				$queryGetYearLastPayment = $this->Main_model->getYearLastPayment($id);
				foreach($queryGetYearLastPayment as $k){
						$checkData = [
							"last_paid_assessed" => $k->last_paid_assessed,
							"assessed_value" => $k->assessed_value,
							"land_status"=> $k->land_status
						];
					}
				// PAYMENT
				if($queryGetLastPayment == "noPayment"){
					$data['check'] = "penaltyWithOutBalanceInQSA";
					
					
					
					//IF MAY UTANG
					if(Date("Y") - $checkData['last_paid_assessed'] > 1)
					{
						$data['check'] = "roblox";
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"]+1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
							$data["test"][]=$diff;
						}

						
							
						}
					
					//ELSE WLANG UTANG
					else{
						$counter = 0;
						for($checkData["last_paid_assessed"];$checkData["last_paid_assessed"]<=$year_of_effectivity-1;$checkData["last_paid_assessed"]++)
						{
							$data['check'] = "asd";
							$data['check'] = "penaltyWithOutBalance";
							$basic[$counter] = $checkData["assessed_value"] * 0.01;
							$year[$counter] = $checkData["last_paid_assessed"] +1;
							$assessed_value[$counter] = $checkData["assessed_value"];
							$diff = monthDiff(1,$year[$counter]);
							$penalty[$counter] = 0;
							$total[$counter] = 0;
							if($diff >= 0)
							{
								$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							else{
								$penalty[$counter]= discount($checkData["assessed_value"]*.01);
								$total[$counter] = $basic[$counter] + $penalty[$counter];
							}
							$data["basic"][] = $basic;
							$data["year"][] = $year;
							$data["assessed_value"][] = $assessed_value;
							$data["penalty"][] = $penalty;
							$data["total"][] = $total;
						}
					}	
					
					
		
					
				}//ELSE OF PAYMENT
				else{
					$data['check'] = "penaltyWithBalanceInQSA";
					$counter = 0;
					foreach($queryGetLastPayment as $k)
					{
						$nestedData['payment_no'] = $k->payment_no;
						$nestedData['mode_of_payment'] = $k->mode_of_payment;
						$nestedData['tax_year'] = $k->tax_year;
						$nestedData['due_basic'] = $k->due_basic;
						$nestedData['id'] = $k->id;
						$data[] = $nestedData;
					}
		
					switch($nestedData['mode_of_payment'])
					{
						case "Annually":
							$data['checkPaymentNo'] = "eks";
							for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity;$nestedData['tax_year']++)
							{
								$basic[$counter] = $nestedData["due_basic"];
								$year[$counter] = $nestedData["tax_year"];
								$assessed_value[$counter] = $nestedData["due_basic"] / 0.01;
								$diff = monthDiff(1,$year[$counter]);
								$penalty[$counter] = 0;
								$total[$counter] = 0;
								if($diff >= 0)
								{
									$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								else{
									$penalty[$counter]= discount($checkData["assessed_value"]*.01);
									$total[$counter] = $basic[$counter] + $penalty[$counter];
								}
								$data["basic"][] = $basic;
								$data["year"][] = $year;
								$data["assessed_value"][] = $assessed_value;
								$data["penalty"][] = $penalty;
								$data["total"][] = $total;
							}
						break;

						case "Semi Annually":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*2;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
								case 2:
										$data['checkPaymentNo'] = "semicheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*2) / 0.01;
										$diff = monthDiff(12,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*2;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*2) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
										}
										$data["payno"] =$nestedData['payment_no'];
								break;
							}
						break;
						case "Quarterly":
							switch($nestedData['payment_no']){
								case 1:
									$data['checkPaymentNo'] = "eks";
									for($nestedData['tax_year'];$nestedData['tax_year']<$year_of_effectivity+1;$nestedData['tax_year']++)
									{
										$basic[$counter] = $nestedData["due_basic"]*4;
										$year[$counter] = $nestedData["tax_year"];
										$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(1,$year[$counter]);
										$penalty[$counter] = 0;
										$total[$counter] = 0;
										if($diff >= 0)
										{
											$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										else{
											$penalty[$counter]= discount($checkData["assessed_value"]*.01);
											$total[$counter] = $basic[$counter] + $penalty[$counter];
										}
										$data["basic"][] = $basic;
										$data["year"][] = $year;
										$data["assessed_value"][] = $assessed_value;
										$data["penalty"][] = $penalty;
										$data["total"][] = $total;
									}
								break;
							
								case 2:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[100] = $nestedData["due_basic"];
										$upyear[100] = $nestedData["tax_year"];
										$upassessed_value[100] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(6,$upyear[100]);
										$uppenalty[100]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[100] = $upbasic[100] + $uppenalty[100];
										
								
								case 3:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[101] = $nestedData["due_basic"];
										$upyear[101] = $nestedData["tax_year"];
										$upassessed_value[101] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(9,$upyear[101]);
										$uppenalty[101]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[101] = $upbasic[101] + $uppenalty[101];
										
									
								
								case 4:
									$data['checkPaymentNo'] = "quartercheck";
									
										$upbasic[102] = $nestedData["due_basic"];
										$upyear[102] = $nestedData["tax_year"];
										$upassessed_value[102] = ($nestedData["due_basic"]*4) / 0.01;
										$diff = monthDiff(12,$upyear[102]);
										$uppenalty[102]= penalty($nestedData["due_basic"],2,$diff);
										$uptotal[102] = $upbasic[102] + $uppenalty[102];
										$data["upbasic"][] = $upbasic;
										$data["upyear"][] = $upyear;
										$data["upassessed_value"][] = $upassessed_value;
										$data["uppenalty"][] = $uppenalty;
										$data["uptotal"][] = $uptotal;
										
										// if($nestedData['tax_year'] == 2019)
										// {
										
										// }	// $nestedData['tax_year'] = $nestedData['tax_year'] -1;

										for($nestedData['tax_year']+1;$nestedData['tax_year']+1<$year_of_effectivity+1;$nestedData['tax_year']++)
										{
											$basic[$counter] = $nestedData["due_basic"]*4;
											$year[$counter] = $nestedData["tax_year"]+1;
											$assessed_value[$counter] = ($nestedData["due_basic"]*4) / 0.01;
											$diff = monthDiff(1,$year[$counter]);
											$penalty[$counter] = 0;
											$total[$counter] = 0;
											if($diff >= 0)
											{
												$penalty[$counter]= penalty($checkData["assessed_value"]*.01,2,$diff);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											else{
												$penalty[$counter]= discount($checkData["assessed_value"]*.01);
												$total[$counter] = $basic[$counter] + $penalty[$counter];
											}
											$data["basic"][] = $basic;
											$data["year"][] = $year;
											$data["assessed_value"][] = $assessed_value;
											$data["penalty"][] = $penalty;
											$data["total"][] = $total;
											
										}
										$data["payno"] =$nestedData['payment_no'];
								
							}
		
						break;
		
					}
		
				}
				echo json_encode($data);
				return $this->load->view('pages/taxorder_print',$data);
			}
		
			
			
}



?>


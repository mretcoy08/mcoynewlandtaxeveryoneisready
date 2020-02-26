<?php
class Main_model extends CI_Model{



// 	public function __construct()
// {
//     parent::__construct();
//     $this->dbrptas = $this->load->database('rptas', TRUE);



// }

	public function login($username,$password)
	{	
		$query = $this->db->select('password')
						->from('user')
						->where('username =', $username)
						->get();
			$data = [];
			$userData = [];
			$password = $password;
		if($query->num_rows()>0){
			$testpassword;
			foreach($query->result() as $k){
				$testPassword = $k->password;
			}
			if($testPassword == $password){
				$query = $this->db->select('*')
								->from('user')
								->where('username =',$username)
								->where('password =', $password)
								->get();
				if($query->num_rows()>0){
					foreach($query->result() as $k)
					{
						$userData['fullname'] = $k->first_name." ".$k->middle_name." ".$k->last_name;
						$userData['role'] = $k->role;
						$userData['username'] = $k->username;
						$userData['id'] = $k->id;
					}

					$this->session->set_userdata($userData);
					$userData['flag'] = 1;
					return $userData;
				}
			}
			else{
				$userData ['msg'] = "passwordError";
				return $userData;
			}
		}
		else{
			$userData ['msg'] = "usernameError";
			return $userData;
		}
	}
//END OF LOGIN

//INSERT
	public function insert($table,$data)
	{
		$query = $this->db->insert($table,$data);
		
		if($query){
			return 'success';
		}
		
	}

	public function insertWithId($table,$data)
	{
		$query = $this->db->insert($table,$data);
		$last_id = $this->db->insert_id();
		
		return $last_id;
		
	}
//END OF INSERT

	
//SELECT
	public function select($table,$select,$where)
	{
		$this->db->select($select)
						->from($table);
						if($where)
						{
							$this->db->where($where);
						}
		$query = $this->db->get();
		return $query;
	}

	public function clearanceVerification($where)
	{
		$query = $this->db->select("tax_order.mode_of_payment, or_number, or_date, payment")
						->from("or_pool")
						->join("tax_clearance_payment tcp", "tcp.or_pool_id = or_pool.id", "inner")
						->join("land", "land.id = tcp.land_id", "inner")
						->join("tax_order", "land.id = tax_order.land_id", "inner")
						->where($where)
						->get();

		return $query;
	}

	public function clearancePayment($where){
		$query = $this->db->select("*")
							->from("payment")
							->join("or_pool","payment.or_pool_id = or_pool.id","inner")
							->join("tax_order", "tax_order.id = payment.tax_order_id", "inner")
							->where($where)
							->order_by("payment.id", "DESC")
							->limit(1)
							->get();
		return $query;			
	}

	public function clearanceCompromise($where)
	{
		$query = $this->db->select("*")
						->from("compromise")
						->join("or_pool", "compromise.or_pool_id = or_pool.id", "inner")
						->join("tax_order", "tax_order.id = compromise.tax_order_id", "inner")
						->where($where)
						->order_by("compromise.id", "DESC")
						->limit(1)
						->get();
		return $query;
	}

	public function clearanceLandData($where)
	{
		$query = $this->db->select("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, barangay, assessed_value")
							->from("land")
							->join("tax_order","tax_order.land_id = land.id","inner")
							->where($where)
							->get();
			return $query;
	}
	public function clearanceOwnerData($where)
	{
		$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name")
						->from("land_owner")
						->join("land", "land_owner.land_id = land.id", "inner")
						->join("tax_order", "tax_order.land_id = land.id", "inner")
						->where($where)
						->get();
		return $query;
	}

	public function getBarangayAndSubdivision($where)
	{
		$query = $this->db->select("*")
						->from("barangay")
						->join("subdivisions","subdivisions.location_barangay_id = barangay.location_barangay_id", "inner")
						->where($where)
						->get();
		return $query;
	}

	public function getBarangay($where)
	{
		$query = $this->db->select("*")
						->from("barangay")
						->where($where)
						->get();
		return $query;
	}

	public function getOwnerLocation($where)
	{
		$query = $this->db->select("barangay,CONCAT(first_name,' ',middle_name,' ',last_name) as full_name,tax_dec_no")
				->from("land")
				->join("land_owner", "land_owner.land_id = land.id", "inner")
				->where("land.id",$where)
				->limit(1)
				->get();

		return $query->result();
	}

	public function getLastPayment($id)
	{
		$query = $this->db->select("payment.id, payment_no, due_basic,tax_year,tax_order.mode_of_payment")
							->from("payment")
							->join("tax_order","tax_order.id = payment.tax_order_id","inner")
							->where("tax_order.land_id",$id)
							->where("payment.payment_status", "PENDING")
							->order_by("payment.id", "DESC")
							->limit(1)
							->get();
		
		if($query->num_rows())
		{
			return $query->result();
		}	
		else{
			return "noPayment";
		}			
	}

	public function getYearLastPayment($id)
	{
		$query = $this->db->select("last_paid_assessed,assessed_value,land_status")
						->from("land")
						->where("land.id", $id)
						->order_by("id","DESC")
						->limit(1)
						->get();
		return $query->result();
	}

	public function getPayment($where)
	{
		$query = $this->db->select("due_date,due_basic,id,start_date")
						->from("payment")
						->where($where)
						->where("payment_status", null)
						->where("tax_year >=", date("Y"))
						->or_where("payment_status", "PENDING")
						->order_by("payment_no", "ASC")
						->limit(1)
						->get();
						return $query->result();
	}

	public function getCompromise($where)
	{
		$query = $this->db->select("due_basic,id")
						->from("compromise")
						->where($where)
						->where("payment_status", null)
						->where("tax_year >=", date("Y"))
						->or_where("payment_status", "PENDING")
						->order_by("payment_no", "ASC")
						->limit(1)
						->get();
						return $query->result();
	}

	public function getPaymentInfo($where)
	{
		$query = $this->db->select("payment.id as paymentid,mode_of_payment,due_basic,due_sef,due_penalty,due_discount,due_total,tax_year,payment_no,tax_order.land_id,tax_order.balance")
						->from("payment")
						->join("tax_order", "tax_order.id = payment.tax_order_id", "inner")
						->where("payment.id",$where)
						// ->where("payment_status", null)
						// ->or_where("payment_status", "PENDING")
						->get();

		return $query->result();
	}

	public function getOwnerAndLandInfo($where)
	{
		$query = $this->db->select("barangay,CONCAT(first_name,' ',middle_name,' ',last_name) as full_name,tax_dec_no,assessed_value,CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin")
				->from("land")
				->join("land_owner", "land.id = land_owner.land_id", "inner")
				->where("land.id",$where)
				->get();

		return $query->result();
	}

	public function getCompromiseInfo($where)
	{
		$query = $this->db->select("compromise.id as id,mode_of_payment,due_basic,due_sef,due_total,tax_year,payment_no,balance,tax_order.land_id")
							->from("compromise")
							->join("tax_order", "tax_order.id = compromise.tax_order_id", "inner")
							->where("compromise.id",$where)
							->get();

		return $query->result();
	}

	public function getPin($where)
	{
		$query = $this->db->select("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)  as pin")
							->from("tax_order")
							->join("land", "land.id = tax_order.land_id", "inner")
							->where($where)
							->get();
		return $query;
	}

	public function getPaymentHistory($pin,$where)
	{
		$query = $this->db->select("payor_name, or_number, or_date, due_date, due_basic, due_sef, due_penalty, due_discount, due_total, tax_year, total_rec, payment_no, payment.payment_status,cash_rec,check_rec,total_rec")
							->from("land")
							->join("tax_order","tax_order.land_id = land.id", "inner")
							->join("payment", "payment.tax_order_id = tax_order.id", "inner")
							->join("or_pool", "or_pool.id = payment.or_pool_id", "inner")
							->where("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$pin)
							->where($where)
							->order_by("payment.id", "DESC")
							->get();
		return $query;
	}

	public function getCompromiseHistory($pin,$where)
	{
		$query = $this->db->select("payor_name, or_number, or_date, due_basic, due_sef, due_total, tax_year, total_rec, payment_no, compromise.payment_status,cash_rec,check_rec,total_rec")
							->from("land")
							->join("tax_order","tax_order.land_id = land.id", "inner")
							->join("compromise", "compromise.tax_order_id = tax_order.id", "inner")
							->join("or_pool", "or_pool.id = compromise.or_pool_id", "inner")
							->where("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$pin)
							->where($where)
							->order_by("compromise.id", "DESC")
							->get();
		return $query;
	}

	public function selecttax($where)
	{
		$query = $this->db->select("*")
						->from("tax_order")
						->join("land", "land.id = tax_order.land_id", "inner")
						->where($where)
						->order_by("tax_order.id","DESC")
						->limit(1)
						->get();
		return $query;

	}

	// public function getTaxOrderAndLastPayment($where){
	// 	$query = $this->db->select("*")
	// 						->from("tax_order")
	// 						->join("payment", "payment.tax_order_id = tax_order.id", "inner")
	// 						->where($where)
	// 						->order_by("payment.id", "DESC")
	// 						->limit(1)
	// 						->get();
	// 	return $query;
	// }

	public function getTaxOrder($pin)
	{
		$query = $this->db->select("basic, sef, penalty, discount, total, balance, mode_of_payment,year_assessed,tax_year_start, tax_year_end")
							->from("land")
							->join("tax_order","tax_order.land_id = land.id", "inner")
							->where("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$pin)
							->order_by("tax_order.id", "DESC")
							->limit(1)
							->get();
		return $query;
	}

	public function getLandAndOwner($pin)
	{
		$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)  as pin, tax_dec_no, barangay, assessed_value, class, land_status")
							->from("land")
							->join("land_owner", "land.id = land_owner.land_id", "inner")
							->where("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$pin)
							->get();
		return $query;
	}

	public function getLandAndOwnerClearance($where)
	{
		$query = $this->db->select("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, barangay, assessed_value, or_pool.or_number,payment.due_total, payment.due_basic, payment.due_sef, or_pool.or_date, payment.or_number, payment.or_date")
							->from("land")
							->join("tax_clearance_payment", "tax_clearance_payment.land_id = land.id", "inner")
							->join("or_pool", "or_pool.id = tax_clearance_payment.or_pool_id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->join("payment", "payment.tax_order_id = tax_order.id", "inner")
							->order_by("payment.id", "DESC")
							->limit(1)
							->where($where)
							->get();
		return $query;
	}

	public function getPaymentClearance()
	{
		$query = $this->db->select("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, barangay, assessed_value, or_pool.or_number,payment.due_total, payment.due_basic, payment.due_sef, or_pool.or_date, payment.or_number, payment.or_date")
							->from("land")
							->join("tax_clearance_payment", "tax_clearance_payment.land_id = land.id", "inner")
							->join("or_pool", "or_pool.id = tax_clearance_payment.or_pool_id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->join("payment", "payment.tax_order_id = tax_order.id", "inner")
							->order_by("payment.id", "DESC")
							->limit(1)
							->where($where)
							->get();
		return $query;
	}


	public function getOrPayment($where)
	{
		$query = $this->db->select("payor_name, barangay, tax_dec_no, basic, penalty, total, or_date, mode_of_payment, due_basic, payment_no, due_penalty, due_date, due_total, CONCAT(lo.first_name,' ',lo.middle_name,' ',lo.last_name) as ofull_name")
						->from("payment")
						->join("or_pool", "or_pool.id = payment.or_pool_id", "inner")
						->join("tax_order", "tax_order.id = payment.tax_order_id", "inner")
						->join("land", "land.id = tax_order.land_id", "inner")
						->join("land_owner lo", "lo.land_id = land.id", "inner")
						->where($where)
						->get();
		return $query;
	}

	public function getOrCompromise($where)
	{
		$query = $this->db->select("payor_name, barangay, tax_dec_no, basic, penalty, total, or_date, mode_of_payment, due_basic, payment_no, due_total, CONCAT(lo.first_name,' ',lo.middle_name,' ',lo.last_name) as ofull_name")
						->from("compromise")
						->join("or_pool", "or_pool.id = compromise.or_pool_id", "inner")
						->join("tax_order", "tax_order.id = compromise.tax_order_id", "inner")
						->join("land", "land.id = tax_order.land_id", "inner")
						->join("land_owner lo", "lo.land_id = land.id", "inner")
						->where($where)
						->get();
		return $query;
	}

	public function getClearanceOr($where)
	{
		$query = $this->db->select("payor_name,payment")
						->from("or_pool")
						->join("tax_clearance_payment as tcp", "or_pool.id = tcp.or_pool_id", "inner")
						->where($where)
						->get();
		return $query;
	}

	public function getCancelORPayment($where)
	{
		$query = $this->db->select("start_date,due_date,due_basic,due_sef,tax_year, payment_no, tax_order_id,payment.id as id")
						->from("or_pool")
						->join("payment", "payment.or_pool_id = or_pool.id", "inner")
						->where($where)
						->get();

		return $query->result();
	}

	public function getCancelORComrpomise($where)
	{
		$query =$this->db->select("due_basic, due_sef, due_total, tax_year, payment_no, tax_order_id, compromise.id")
						->from("or_pool")
						->join("compromise", "compromise.or_pool_id = or_pool.id", "inner")
						->where($where)
						->get();

		return $query->result();
	}
	

//END OF SELECT

	public function check_or($table,$select,$where)
	{
		$query = $this->db->select($select)
						->from($table)
						->where($where)
						->get();
		return $query;
	}


//UPDATE
	public function update($table,$data,$where)
	{
		$query = $this->db->where($where)
						->update($table,$data);

		if($query){
			return $query;
		}
	}

	public function updateStatus($data,$where)
	{
		$query = $this->db->where("payment_status", "PENDING")
						->or_where("payment_status", NULL)
						->where($where)
						->update("payment",$data);

		if($query){
			return $query;
		}
	}
//END OF UPDATE

	

//DATATABLES WITHOUT JOIN

function all_post_count($table,$data,$where)
    {   
       $this->db->select($data)
				->from($table);
					if($where)
					{
						$this->db->where($where);
					}
		$query = 	$this->db->get();
    
        return $query->num_rows();  

    }
    
    function all_post($limit,$start,$col,$dir,$table,$data,$where)
    {   
        $this->db->select($data)
				->from($table);
					if($where)
					{
						$this->db->where($where);
					}
		$query = $this->db->limit($limit,$start)
                ->order_by($col,$dir)
				->get();
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function post_search($limit,$start,$search,$col,$dir,$table,$data,$where,$like,$orLike)
    {
    	$this->db->select($data)
				->from($table);
					if($where)
					{
						$this->db->where($where);
					}
			$query =$this->db->like($like)
				->order_by($col,$dir)
				->or_like($orLike)
				->get();

       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function post_search_count($search,$table,$data,$where,$like,$orLike)
    {	
    	$this->db->select($data)
				->from($table);
					if($where)
						{
							$this->db->where($where);
						}
		$query = $this->db->like($like)
				->or_like($orLike)
				->get();
       
    
        return $query->num_rows();
	}

//END OF DATATABLE WITHOUT JOIN

// DATA TABLE OF LAND AND OWNERS
	function post_search_landowners($limit,$start,$search,$col,$dir,$table,$data)
	{
		$query =$this->db->select($data)
				->from($table)
				->order_by($col,$dir)
				->like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$search)
				->or_like("tax_dec_no",$search)
				->or_like("class",$search)
				->or_like("assessed_value",$search)
				->or_like("land_status",$search)
				->get();

	
		if($query->num_rows()>0)
		{
			return $query->result();  
		}
		else
		{
			return null;
		}
	}

	function post_search_count_landowners($search,$table,$data)
	{	
		$query = $this->db->select($data)
				->from($table)
				->like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)",$search)
				->or_like("tax_dec_no",$search)
				->or_like("class",$search)
				->or_like("assessed_value",$search)
				->or_like("land_status",$search)
				->get();
	

		return $query->num_rows();
	}
// END OF DATA TABLE OF LAND AND OWNERS



		//DATA TABLES FOR TAX ORDER ASSESSMENT
		function all_post_count_toa($assessment_search)
		{   
			$yearDate = date("Y");
		$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, barangay, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no,land.id")
					->from("land")
					->join("land_owner","land_owner.land_id = land.id", "inner")
					->where("last_payment_assessed <",$yearDate)
					->or_where("last_payment_assessed", null)
					->like("CONCAT(first_name,' ',middle_name,' ',last_name,' ',pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel,' ',tax_dec_no)",$assessment_search)
					
					->get();
			return $query->num_rows();  

		}

		function all_post_toa($limit,$start,$col,$dir,$assessment_search)
		{   
			$yearDate = date("Y");
			$query =$this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, barangay, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id")
			->from("land")
			->join("land_owner","land_owner.land_id = land.id", "inner")
			->where("last_payment_assessed <",$yearDate)
			->or_where("last_payment_assessed", null)
			->like("CONCAT(first_name,' ',middle_name,' ',last_name,' ',pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel,' ',tax_dec_no)",$assessment_search)
			->get();	
			if($query->num_rows()>0)
			{
				return $query->result(); 
			}
			else
			{
				return null;
			}
			
		}
		// function post_search_toa($limit,$start,$search,$col,$dir,$assessment_search)
		// {
		// 	$yearDate = date("Y");
		// 	$query =$this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, barangay, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id")
		// 	->from("land")
		// 	->join("land_owner","land_owner.land_id = land.id", "inner")
		// 	// ->like("CONCAT(first_name,' ',middle_name,' ',last_name) =", $search)
		// 	// ->like("tax_dec_no",$assessment_search)
		// 	// ->or_like("barangay", $search)
		// 	// ->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) = ", $search)
		// 	// ->or_like("tax_dec_no =", $search)
		// 	// ->order_by($col,$dir)
		// 	// ->where("last_payment_assessed <",$yearDate)
		// 	// ->or_where("last_payment_assessed", null)
		// 	->get();

		
		// 	if($query->num_rows()>0)
		// 	{
		// 		return $query->result();  
		// 	}
		// 	else
		// 	{
		// 		return null;
		// 	}
		// }

		// function post_search_count_toa($search,$assessment_search)
		// {	
		// 	$yearDate = date("Y");
		// 	$query =$this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, barangay, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id")
		// 	->from("land")
		// 	->join("land_owner","land_owner.land_id = land.id", "inner")
		// 	->join("land_owner","land_owner.land_id = land.id", "inner")
		// 	// ->like("CONCAT(first_name,' ',middle_name,' ',last_name) =", $search)
		// 	// ->like("tax_dec_no",$assessment_search)
		// 	// ->or_like("barangay", $search)
		// 	// ->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) = ", $search)
		// 	// ->or_like("tax_dec_no =", $search)
		// 	// ->where("last_payment_assessed <",$yearDate)
		// 	// ->or_where("last_payment_assessed", null)
		// 	// ->order_by($col,$dir)
		// 	->get();

		// 	return $query->num_rows();
		// }

		// END OF DATA TABLES FOR TAX ORDER ASSESSMENT

		// PAYMENT TABLE
		function all_post_payment_count()
		{  
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no, payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("tax_order")
							->join("land","tax_order.land_id = land.id","inner")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->where("mode_of_payment !=", "Compromise")
							->get();

			return $query->num_rows();  

		}

		function all_post_payment($limit,$start,$col,$dir)
		{   
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("tax_order")
							->join("land","tax_order.land_id = land.id","inner")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->where("mode_of_payment !=", "Compromise")
							->order_by("tax_order.id", "DESC")
							->get();	
			
			if($query->num_rows()>0)
			{
				return $query->result(); 
			}
			else
			{
				return null;
			}
			
		}

		function all_post_payment_search($limit,$start,$search,$col,$dir)
		{

			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("land")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->join("tax_order","tax_order.land_id = land.id","inner")
							->like("CONCAT(first_name,' ',middle_name,' ',last_name)", $search)
							->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)", $search)
							->or_like("tax_dec_no", $search)
							->or_like("barangay", $search)
							->order_by("tax_order.id", "DESC")
							->where("mode_of_payment !=", "Compromise")
							->get();	
		
			if($query->num_rows()>0)
			{
				return $query->result();  
			}
			else
			{
				return null;
			}
		}

		function all_post_payment_search_count($search)
		{	
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("land")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->join("tax_order","tax_order.land_id = land.id","inner")
							->like("CONCAT(first_name,' ',middle_name,' ',last_name)", $search)
							->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)", $search)
							->or_like("tax_dec_no", $search)
							->or_like("barangay", $search)
							->order_by("tax_order.id", "DESC")
							->where("mode_of_payment !=", "Compromise")
							->get();	

			return $query->num_rows();
		}
		//END OF PAYMENT TABLE

		// COMPROMISE TABLE
		function all_post_compromise_count()
		{  
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no, payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("tax_order")
							->join("land","tax_order.land_id = land.id","inner")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->where("mode_of_payment", "Compromise")
							->get();

			return $query->num_rows();  

		}

		function all_post_compromise($limit,$start,$col,$dir)
		{   
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("tax_order")
							->join("land","tax_order.land_id = land.id","inner")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->where("mode_of_payment", "Compromise")
							->order_by("tax_order.id", "DESC")
							->get();	
			
			if($query->num_rows()>0)
			{
				return $query->result(); 
			}
			else
			{
				return null;
			}
			
		}

		function all_post_compromise_search($limit,$start,$search,$col,$dir)
		{

			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("land")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->join("tax_order","tax_order.land_id = land.id","inner")
							->like("CONCAT(first_name,' ',middle_name,' ',last_name)", $search)
							->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)", $search)
							->or_like("tax_dec_no", $search)
							->or_like("barangay", $search)
							->order_by("tax_order.id", "DESC")
							->where("mode_of_payment", "Compromise")
							->get();	
		
			if($query->num_rows()>0)
			{
				return $query->result();  
			}
			else
			{
				return null;
			}
		}

		function all_post_compromise_search_count($search)
		{	
			$yearDate = date("Y");
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, barangay, tax_order.id, tax_dec_no,payment_status, mode_of_payment, year_assessed, year_of_effectivity")
							->from("land")
							->join("land_owner","land_owner.land_id = land.id","inner")
							->join("tax_order","tax_order.land_id = land.id","inner")
							->like("CONCAT(first_name,' ',middle_name,' ',last_name)", $search)
							->or_like("CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel)", $search)
							->or_like("tax_dec_no", $search)
							->or_like("barangay", $search)
							->order_by("tax_order.id", "DESC")
							->where("mode_of_payment", "Compromise")
							->get();	

			return $query->num_rows();
		}
		//END OF COMPROMISE TABLE

		



		// CLEARANCE TABLE
		function all_post_clearance_count($where)
		{  
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id, tax_order.id as tax_id")
							->from("land")
							->join("tax_clearance_payment", "land.id = tax_clearance_payment.land_id", "inner")
							->join("land_owner", "land_owner.land_id = land.id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->where($where)
							->get();
			return $query->num_rows();  

		}

		function all_post_clearance($limit,$start,$col,$dir,$where)
		{   
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id, tax_order.id as tax_id")
							->from("land")
							->join("tax_clearance_payment", "land.id = tax_clearance_payment.land_id", "inner")
							->join("land_owner", "land_owner.land_id = land.id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->where($where)
							->get();	
			
			if($query->num_rows()>0)
			{
				return $query->result(); 
			}
			else
			{
				return null;
			}
			
		}

		function all_post_clearance_search($limit,$start,$search,$col,$dir,$where)
		{
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id,tax_order.id as tax_id")
							->from("land")
							->join("tax_clearance_payment", "land.id = tax_clearance_payment.land_id", "inner")
							->join("land_owner", "land_owner.land_id = land.id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->where($where)
							->get();
		
			if($query->num_rows()>0)
			{
				return $query->result();  
			}
			else
			{
				return null;
			}
		}

		function all_post_clearance_search_count($search,$where)
		{	
			$query = $this->db->select("CONCAT(first_name,' ',middle_name,' ',last_name) as full_name, CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, land.id, tax_order.id as tax_id")
							->from("land")
							->join("tax_clearance_payment", "land.id = tax_clearance_payment.land_id", "inner")
							->join("land_owner", "land_owner.land_id = land.id", "inner")
							->join("tax_order", "tax_order.land_id = land.id", "inner")
							->where($where)
							->get();	

			return $query->num_rows();
		}
		//END OF CLEARANCE TABLE
}
?>
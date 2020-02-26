<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Land_and_owners extends CI_Controller {

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

	public function insert()
	{
		$data = [
			"pin_city" => clean_data(post("pin_city")),
			"pin_district" => clean_data(post("pin_district")),
			"pin_barangay" => clean_data(post("pin_barangay")),
			"pin_section" => clean_data(post("pin_section")),
			"pin_parcel" => clean_data(post("pin_parcel")),

			"tax_dec_no" => clean_data(post("tax_dec_no")),
			"lot_no" => clean_data(post("lot_no")),
			"block_no" => clean_data(post("block_no")),
			"street" => clean_data(post("street")),
			"barangay" => clean_data(post("barangay")),
			"subdivision" => clean_data(post("subdivision")),
			"city" => clean_data(post("city")),
			"province" => clean_data(post("province")),

			"class" => clean_data(post("class")),
			"sub_class" => clean_data(post("sub_class")),
			"last_paid_assessed" => clean_data(post("last_year_paid")),
			"assessed_value" => saveMoney(clean_data(post("assessed_value"))),
			"land_status" => clean_data(post("land_status")),
		];
		

		$query = $this->Main_model->insertWithId("land",$data);

		echo json_encode($query);
	}

	public function insert_owners()
	{
		$data = $this->input->post('ol');

		$query = $this->Main_model->insert("land_owner",$data);
		echo json_encode($query);
	}

	public function getBarangayAndSubdivision()
	{
		$where = [
			"barangay_code" => clean_data(post("brgycode")),
		];

		$query_barangay = $this->Main_model->getBarangay($where);
		$query_subdivision = $this->Main_model->getBarangayAndSubdivision($where);

		$data = [
			"barangay" => $query_barangay->result(),
			"subdivision" => $query_subdivision->result()
		];
		
		echo json_encode($data);
	}

	public function subdivision_class()
	{
		$where = [
			"location_subdivision_id" => clean_data(post("subdivision")),
		];

		$query = $this->Main_model->select("subdivisions","*",$where);

		$data = [
			"subdivision" => $query->result(),
		];

		echo json_encode($data);
	}

	public function getland()
	{
		$where = [
			"" => clean_data(post("id")),
		];
		$query = $this->Main_model->select("land","*",$where);

		echo json_encode($query->result());
	}

	public function getowner()
	{
		$where = [
			"land_id" => clean_data(post("id")),
		];
		$query = $this->Main_model->select("land_owner","first_name,middle_name,last_name",$where);

		echo json_encode($query->result());
	}

	public function update_land()
	{
		$data = [
			"pin_city" => clean_data(post("pin_city")),
			"pin_district" => clean_data(post("pin_district")),
			"pin_barangay" => clean_data(post("pin_barangay")),
			"pin_section" => clean_data(post("pin_section")),
			"pin_parcel" => clean_data(post("pin_parcel")),

			"tax_dec_no" => clean_data(post("tax_dec_no")),
			"lot_no" => clean_data(post("lot_no")),
			"block_no" => clean_data(post("block_no")),
			"street" => clean_data(post("street")),
			"subdivision" => clean_data(post("subdivision")),
			"city" => clean_data(post("city")),
			"province" => clean_data(post("province")),

			"class" => clean_data(post("class")),
			"sub_class" => clean_data(post("sub_class")),
			"assessed_value" => clean_data(post("assessed_value")),
			"land_status" => clean_data(post("land_status")),
		];

		$where = [
			"id" => clean_data(post("idd")),
		];

		$query = $this->Main_model->update("land",$data,$where);

		echo json_encode($query);
	}

	

	public function show_land()
	{
		
		$columns = array( 
                            0 =>'pin', 
                            1 =>'tax_dec_no',
							2 =>'class',
							3 =>'assessed_value',
							4 =>'land_status',
							5 =>'id'
                        );
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value']; 

        //DATATABLE VARIABLES
            $table = "land";
            $data = "CONCAT(pin_city,'-',pin_district,'-',pin_barangay,'-',pin_section,'-',pin_parcel) as pin, tax_dec_no, class, assessed_value,land_status,id";
            $where = "";
            // $like = [
            //     "username" => $search,
            // ];
            // $orLike = [
            //     "first_name" => $search,
            //     "middle_name" => $search,
            //     "last_name" => $search,
            //     "contact_number" => $search
            // ];
        //END OF DATATABLE VARIABLES
  
        $totalData = $this->Main_model->all_post_count($table,$data,$where);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Main_model->all_post($limit,$start,$order,$dir,$table,$data,$where);
        }
        else {
            $posts =  $this->Main_model->post_search_landowners($limit,$start,$search,$order,$dir,$table,$data);
            $totalFiltered = $this->Main_model->post_search_count_landowners($search,$table,$data);
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['pin'] = $post->pin;
				$nestedData['tax_dec_no'] = $post->tax_dec_no;
				$nestedData['class'] = $post->class;
				$nestedData['assessed_value'] = showMoney($post->assessed_value);
				$nestedData['land_status'] = $post->land_status;
				$nestedData['action'] = "<button class = ' btn btn-success btn-sm' onclick= 'updbtn(".$post->id.")'>  <i class='fa fa-edit'></i></button>";
                
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

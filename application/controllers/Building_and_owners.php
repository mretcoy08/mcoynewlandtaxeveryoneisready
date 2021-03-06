<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building_and_owners extends CI_Controller {

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
        $this->load->view("template/template.php");
  }
  
  public function insert()
  {
     $data = [
        "building_pin" => clean_data(post("building_no")),
        "assessed_value" => saveMoney(clean_data(post("building_assessed_value"))),
        "land_id" => clean_data(post("land_id")),
        "tax_dec_no" => clean_data(post("tax_dec_no")),
        "last_paid_assessed" => clean_data(post("last_year_paid")),

     ];

     $query = $this->Main_model->insertWithId("building",$data);

		echo json_encode($query);
  }

  public function insert_owners()
	{
		$data = $this->input->post('ol');
		$query = $this->Main_model->insert("building_owner",$data);
		echo json_encode($query);
	}
	

	public function getland()
	{
		$pin = explode("-",post("land_pin"))	;

		$where = [
			"pin_city" =>$pin[0],
			"pin_district" =>$pin[1],
			"pin_barangay" =>$pin[2],
			"pin_section" =>$pin[3],
			"pin_parcel" =>$pin[4],
		];

		$query = $this->Main_model->select("land","*",$where);

		echo json_encode($query->result());
	}

	public function getSubdivision()
	{
		$where = [
			"location_subdivision_id" => clean_data(post("subd")),
		];

		$query = $this->Main_model->select("subdivisions", "subdivision_name", $where);
		

		
		
		echo json_encode($query->result());
  }
  

    
}
?>
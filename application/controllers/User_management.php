<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends CI_Controller {

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
        $this->load->view("template/template");	
    }

    public function add_user()
	{
		
		$data = [
			'first_name' => ucwords(clean_data(post('first_name'))),
			'middle_name' => ucwords(clean_data(post('middle_name'))),
			'last_name' => ucwords(clean_data(post('last_name'))),
			'contact_number' => clean_data(post('contact_number')),
			'username' => clean_data(post('username')),
			'password' =>post('password'),
            'role' => clean_data(post('role')),
            'suffix_name' => clean_data(post('suffix_name')),
		];
		$query = $this->Main_model->insert('user',$data);

		$data = [
			"user" => $this->session->userdata('username'),
			"action" => "Add",
			"what" => "User ".$data['username'],
		];
		$query = $this->Main_model->insert('audit_trail',$data);

		echo json_encode($query);
	}
	public function update_user()
	{
		$data = [
			'first_name' => ucwords(clean_data(post('first_name'))),
			'middle_name' => ucwords(clean_data(post('middle_name'))),
			'last_name' => ucwords(clean_data(post('last_name'))),
			'contact_number' => clean_data(post('contact_number')),
			'username' => clean_data(post('username')),
			'password' => post('password'),
			
		];
		$where = [
			'id' => clean_data(post('userid'))
		];
		$query = $this->Main_model->update('user',$data,$where);

		$data = [
			"user" => $this->session->userdata('username'),
			"action" => "Update",
			"what" => "User ".$data['username'],
		];
		$query = $this->Main_model->insert('audit_trail',$data);
		echo json_encode($query);
    }
    
	public function select_user()
	{
		$data = [
			'id' => clean_data(post('id'))
		];
		$query = $this->Main_model->select('user','*',$data);
		$qdata =[];
		foreach($query->result() as $k)
		{
			$qdata['first_name'] = $k->first_name;
			$qdata['middle_name'] = $k->middle_name;
			$qdata['last_name'] = $k->last_name;
			$qdata['username'] = $k->username;
			$qdata['password'] = $k->password;
			$qdata['contact_number'] = $k->contact_number;
			$qdata['id'] = $k->id;
		}
		echo json_encode($qdata);
	}
	public function check_username(){
		$data = [
			'username' =>clean_data(post('username'))
		];
		$query = $this->Main_model->select_one('user','username',$data);
		$msg = "";
		if($query)
		{
			$msg = "meron";
		}
		
		echo json_encode($msg);
    }
    
	
	public function show_users()
	{
		
		$columns = array( 
                            0 =>'id', 
                            1 =>'first_name',
							2 =>'contact_number',
							3 =>'id'
                        );
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value']; 

        //DATATABLE VARIABLES
            $table = "user";
            $data = "*";
            $where = "";
            $like = [
                "username" => $search,
            ];
            $orLike = [
                "first_name" => $search,
                "middle_name" => $search,
                "last_name" => $search,
                "contact_number" => $search
            ];
        //END OF DATATABLE VARIABLES
  
        $totalData = $this->Main_model->all_post_count($table,$data,$where);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Main_model->all_post($limit,$start,$order,$dir,$table,$data,$where);
        }
        else {
            $posts =  $this->Main_model->post_search($limit,$start,$search,$order,$dir,$table,$data,$where,$like,$orLike);
            $totalFiltered = $this->Main_model->post_search_count($search,$table,$data,$where,$like,$orLike);
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['username'] = $post->username;
				$nestedData['first_name'] = $post->first_name ." ". $post->middle_name ." ". $post->last_name;
				$nestedData['contact_number'] = $post->contact_number;
                $nestedData['action'] = "<button class = ' btn btn-success btn-sm updbtn' id = '".$post->id."'>  <i class='fa fa-edit'></i></button> ";
                
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

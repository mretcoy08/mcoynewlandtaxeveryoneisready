<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_trail extends CI_Controller {

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

    public function sort()
    {
        $where_user = "";
        $query_user = $this->Main_model->select("user","username",$where_user);

        $where_action = "";
        $query_action = $this->Main_model->select("audit_trail","DISTINCT(action) as action",$where_action);

        // $where_module = "";
        // $query_module = $this->Main_model->select("module","page_module",$where_module);
    
        $data = [
            "user" => $query_user->result(),
            "action" => $query_action->result(),
        ];
        
        echo json_encode($data);
    }
    
    public function show_logs()
	{

        
		
		$columns = array( 
                            0 =>"user", 
                            1 =>"action",
							2 =>"what",
							3 =>"created_at"
                        );
                        
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value']; 

        //DATATABLE VARIABLES
            $table = "audit_trail";
            $where = [];
            $data = "user, action, what, DATE_FORMAT(created_at, '%Y-%d-%m') as created_at, module";
            if(clean_data(post("user"))){
                $where['user'] = clean_data(post("user"));
            }
            if(clean_data(post("action"))){
                $where['action'] = clean_data(post("action"));
            }
            if(clean_data(post("module"))){
                $where['module'] = clean_data(post("module"));
            }
            if(clean_data(post("date"))){
                $where['created_at'] = clean_data(post("date"));
            }
            $like = [
                "user" => $search,
            ];
            $orLike = [
                "action" => $search,
                "what" => $search,
                "created_at" => $search,
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
                $nestedData['user'] = $post->user;
				$nestedData['action'] = $post->action;
                $nestedData['what'] = $post->what;
                $nestedData['module'] = $post->module;
                $nestedData['date'] = $post->created_at;
                
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

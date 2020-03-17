<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_database extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Manila');
		if(isset($this->session->id))
		{
			$this->load->model("Main_model");
		}
		else
		{
			redirect(base_url('Dashboard'));
		}
	}
	

	public function index()
	{
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		$file_name = time().'.gz';
		write_file(FCPATH .'/backup/'.$file_name, $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($file_name, $backup);
		redirect(base_url('Dashboard'));
	}
} -->

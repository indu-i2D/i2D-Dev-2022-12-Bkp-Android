<?php

class Page extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		ob_start();
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->library('parser');		
		$this->load->helper(array('form','url'));
		$this->load->library('session');
		$this->load->library('email');
		$this->load->model('User_model');
		$this->load->model('Page_model');
		$this->load->model('Nonprofit_model');
		date_default_timezone_set("America/New_York");
	}

	public function index()
	{
		if (!$this->session->userdata('admin'))
		{			
			$data['title']="Admin Login";
			$this->load->view('user/login', $data);
		}
		else {
			redirect(base_url()."page/view");
		}
	}
	
	public function view()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			
			$data['title']="Pages";
			$data['users'] = $this->Page_model->getPageList();
			$this->load->view('common/header', $data);
			$this->load->view('page/page_list', $data);
			$this->load->view('common/footer');
			
		}
	}

	public function edit(){
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else 
	    {
	    	if($_POST)
	    	{
	    		$id = $this->uri->segment(3);
	    	    $modify_at = date('Y-m-d H:i:s');
	    	    $description = $_POST['content'];
	    	    $update_data = array(
				       DB_prefix.'DESCRIPTION' => $description,
				       DB_prefix.'MODIFY_AT'   => $modify_at
				);
			    $this->db->where(DB_prefix.'ID', $id);
			    $this->db->update(DB_prefix."pages", $update_data); 
			    $this->session->set_flashdata('message', 'Data has been updated');
				redirect(base_url()."page/view");
	    	}
	    	else
	    	{
	    		$data['title']="Edit Page";
    			$id = $this->uri->segment(3);
    			$data['pages'] = $this->Page_model->getPageData($id);
    			$this->load->view('common/header', $data);
    			$this->load->view('page/edit', $data);
    			$this->load->view('common/footer');
	    	}
	    }
	}

	public function add()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			if($_POST)
	    	{
	    	    $created_at = date('Y-m-d H:i:s');
	    	    $modify_at = date('Y-m-d H:i:s');
	    	    $description = $_POST['content'];
	    	    $title = $_POST['title'];
	    	    $query = $this->db->query("SELECT * from ".DB_prefix."pages WHERE ".DB_prefix."TITLE = '".$title."'");
                $result = $query->result();
                if($query->num_rows() == 0)
                {
                	$check3 = 'true';
                }
                else
                {
                	$finalresult .= '<p style="color: red;">Already Exist Page '.$title.'</p>';
                	$check3 = 'false';
                }

	    	    $insert_data = array(
						DB_prefix.'TITLE'  => $title,
						DB_prefix.'DESCRIPTION'   => $description,
						DB_prefix.'MODIFY_AT'   => $modify_at,
						DB_prefix.'CREATED_AT'    => $created_at
				);
				if($check3 == true)
				{
					$this->db->insert(DB_prefix."pages", $insert_data);
				}
				if(empty($finalresult))
				 {
				 	$this->session->set_flashdata('message', 'Data has been added');
				 }
				 else
				 {
				 	$this->session->set_flashdata('message', $finalresult);
				 }
				 redirect(base_url()."page/view");

	    	}
	    	else
	    	{
	    		$data['title']="Add Page";
				$this->load->view('common/header', $data);
				$this->load->view('page/add', $data);
				$this->load->view('common/footer');
	    	}	
		}
	}

	
}
?>
<?php

class User extends CI_Controller {

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
			redirect(base_url()."user/dashboard");
		}
	}
	
	public function logincheck()
	{
		$username	=	$this->input->post('username');
		$password	=	md5($this->input->post('password'));
		$data		=	$this->User_model->logincheck($username,$password);
		if(empty($data))
		{
			$this->session->set_flashdata('login_message', 'Username or Password details are incorrect. Please try again!');
			redirect(base_url());
		}
		else
		{
			
			$newdata 		= array(
				   'user_id'  => $data[DB_prefix.'USER_ID'],
				   'username'  => $data[DB_prefix.'USERNAME'],
				   'User_type'     => 'admin',
				   'name'     => $data[DB_prefix.'NAME'],
				   'admin' => TRUE
				);			
			$this->session->set_userdata($newdata);
			redirect(base_url()."user/dashboard");
		}		
	}	
	
	public function dashboard()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			
			$data['title']="Dashboard";
			$data['user_count'] = count($this->User_model->getUserList());
			$data['admin_user_count'] = count($this->User_model->getAdminUserList());
			$data['non_profit_count'] = count($this->Nonprofit_model->dashboardgetNonProfitList());
			$data['payment_count'] = count($this->User_model->getPaymentList());
			$data['category_count'] = count($this->User_model->getCategoryList());
		
			$this->load->view('common/header', $data);
			$this->load->view('user/dashboard', $data);
			$this->load->view('common/footer');
			
		}
	}
	
	public function view()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			
			$data['title']="Users";
			$data['users'] = $this->User_model->getUserList();
			$this->load->view('common/header', $data);
			$this->load->view('user/user_list', $data);
			$this->load->view('common/footer');
			
		}
	}

	public function payment_list()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			
			$data['title']="Payment List";
			$data['payment'] = $this->User_model->getPaymentList();
			$this->load->view('common/header', $data);
			$this->load->view('user/payment_list', $data);
			$this->load->view('common/footer');
			
		}
	}
	
	public function admin_users()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			
			$data['title']="Admin Users";
			$data['users'] = $this->User_model->getAdminUserList();
			$this->load->view('common/header', $data);
			$this->load->view('user/admin_users', $data);
			$this->load->view('common/footer');
			
		}
	}

	public function check_email_exists(){
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else
	    {
	    	$email = $_POST['email'];
	    	$query = $this->db->select(DB_prefix.'EMAIL')
                   ->where(DB_prefix.'EMAIL', $email)
                   ->get(DB_prefix.'users');
            if( $query->num_rows() > 0 ){
                     echo json_encode(FALSE);
            } else {
               echo json_encode(TRUE);
            }
            exit;
	    }
	}

	public function delete()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else 
	    {
    		$user_id = $this->uri->segment(3);

		    $this->db->where(DB_prefix.'ID', $user_id);
		    $this->db->delete(DB_prefix."users"); 
		    $this->session->set_flashdata('message', 'Data has been deleted');
			redirect(base_url()."user/view");

	    }

    }

    public function add()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else 
	    {
	    	if($_POST)
	    	{
	    	    $created_at = date('Y-m-d H:i:s');
	    	    $password	=	md5($_POST['password']);
	    	    if($_POST['type'] == 'business')
	    	    {
	    	    	$business_name = (!empty($_POST['business_name'])) ? $_POST['business_name'] : $_POST['name'];
	    	    }
	    	    else
	    	    {
	    	    	$business_name = '';
	    	    }

	    	    if(!empty($_POST['gender'])) {
	    	    	$gender = $_POST['gender'];
	    	    }
	    	    else
	    	    {
	    	    	$gender = 'O';
	    	    }
	    		$insert_data = array(
						DB_prefix.'NAME'  => $_POST['name'],
						DB_prefix.'EMAIL'   => $_POST['email'],
						DB_prefix.'COUNTRY'   => $_POST['country'],
						DB_prefix.'PASSWORD'   => $password,
						DB_prefix.'GENDER'    => $gender,
						DB_prefix.'PHONE_NUMBER'  => $_POST['phone'],
						DB_prefix.'COUNTRY'  => 'US',
						DB_prefix.'TERMS'   => $_POST['termsconditions'],
						DB_prefix.'REGISTERING_AS'   => $_POST['type'],
						DB_prefix.'BUSINESS_NAME'   =>$business_name,
						DB_prefix.'CREATED_AT'    => $created_at
				    );
			    $this->db->insert(DB_prefix."users", $insert_data);
		    	$id = $this->db->insert_id();
		   		$charity_id = "U".sprintf('%05d', $id);
			    $update_data = array(
			       DB_prefix.'USERID' => $charity_id,
			       DB_prefix.'STATUS' => 'A'
			    );
			    $this->db->where(DB_prefix.'ID', $id);
			    $this->db->update(DB_prefix."users", $update_data);

			    $this->session->set_flashdata('message', 'User data has been inserted');
				redirect(base_url()."user/view");
	    	}
	    	else
	    	{
			    $data['title']="Add User Data";
    		    $data['countries'] = $this->User_model->getCountryList();
    			$this->load->view('common/header', $data);
    			$this->load->view('user/add', $data);
    			$this->load->view('common/footer');
	    	}
	    }

    }

	public function edit()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else 
	    {
	    	if($_POST)
	    	{
	    		$user_id = $this->uri->segment(3);
	    		 if($_POST['status'] == 'business')
	    	    {
	    	    	$business_name = (!empty($_POST['business_name'])) ? $_POST['business_name'] : $_POST['name'];
	    	    }
	    	    else
	    	    {
	    	    	$business_name = '';
	    	    }
	    	    $business_name = (!empty($_POST['business_name'])) ? $_POST['business_name'] :'';
	    		$update_data = array(
				       DB_prefix.'NAME' => $_POST['name'],
				       DB_prefix.'COUNTRY'   => $_POST['country'],
				       DB_prefix.'PHONE_NUMBER' =>  $_POST['phone'],
				       DB_prefix.'GENDER' => $_POST['gender'],
				       DB_prefix.'TERMS' => $_POST['termsconditions'],
				       DB_prefix.'BUSINESS_NAME'   =>$business_name
				);
			    $this->db->where(DB_prefix.'ID', $user_id);
			    $this->db->update(DB_prefix."users", $update_data); 
			    $this->session->set_flashdata('message', 'Data has been updated');
				redirect(base_url()."user/view");
	    	}
	    	else
	    	{
			    $data['title']="Edit User Data";
    			$user_id = $this->uri->segment(3);
    			$data['users'] = $this->User_model->getUserData($user_id);
    		    $data['countries'] = $this->User_model->getCountryList();
    			$this->load->view('common/header', $data);
    			$this->load->view('user/edit', $data);
    			$this->load->view('common/footer');
	    	}
	    }

    }
	
	public function change_password()
	{
		if (!$this->session->userdata('admin'))
		{			
			$this->load->view('user/login');
		}
		else {
			if(!empty($_POST)) {
				$data = $this->User_model->changePassword($_POST);
				if($data){
					$this->session->set_flashdata('message', 'Password has been changed successfully');
					redirect(base_url()."user/change_password");
				}
				else {
					$this->session->set_flashdata('error', 'Old password is incorrect');
					redirect(base_url()."user/change_password");
				}				
			}
			else {
				$data['title']="Change Password";
				$this->load->view('common/header', $data);
				$this->load->view('user/change_password', $data);
				$this->load->view('common/footer');
			}
		}
	}
	
	public function logout()
	{
		$this->session->userdata = array();
		$this->session->sess_destroy();
		$this->session->set_flashdata('message', 'You have successfully logged out');
		redirect(base_url());
	}


	public function import()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect(base_url());
		}
		else
		{

			if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"]))
			{
				$this->load->library("excel");
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				$finalresult = '';
				foreach($object->getWorksheetIterator() as $worksheet)
				{
				  $highestRow = $worksheet->getHighestRow().'.  ';
				  $highestColumn = $worksheet->getHighestColumn();
				  for($row=2; $row<=$highestRow; $row++)
				  {
				  	$check = $check1 = $check2 = $check3 = '';
				  	$obj_insData = addslashes($object->getActiveSheet()->getCell('A' . $row)->getCalculatedValue());
				  	
				  	if (empty($object->getActiveSheet()->getCell('A' . $row)->getCalculatedValue()) ) {
                       continue;
                    } else {
				    $i2D_D_NAME = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
				    $i2D_D_EMAIL = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
				    $i2D_D_GENDER = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
				    $i2D_D_PHONE = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
				    $i2D_D_COUNTRY = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
				 
				    $i2D_D_REGISTERING_AS = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());

				    if($i2D_D_REGISTERING_AS == 'business')
				    {
				   	    $value = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
				   	    $i2D_D_BUSINESS_NAME =(!empty($value))? $value :$i2D_D_NAME;
				    }
				    else
				    {
				    	$i2D_D_BUSINESS_NAME = '';
				    }
				    
				    $created_at = date('Y-m-d H:i:s');
				    $i2D_D_password = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());

				    if(!empty($i2D_D_password))
				    {
				    	$password = $i2D_D_password;
				    }
				    else
				    {
				    	$password = 'i2D@1234';
				    }

				    if(strlen($i2D_D_GENDER) == 1)
                    {
                        $i2D_D_GENDERdata = $i2D_D_GENDER;
                    	$check = 'true';
                    }
                    else
                    {
                    	$i2D_D_GENDERdata = 'O';
                    }

                    if(filter_var($i2D_D_EMAIL, FILTER_VALIDATE_EMAIL))
                    {
                    	$check1 = 'true';
                    }
                    else
                    {
                    	$finalresult .= '<p style="color: red;">Invalid Email '.$i2D_D_EMAIL.'</p>';
                    	$check1 = 'false';
                    }
                    
                    if(!empty($i2D_D_COUNTRY))
                    {
                    	$querycountry = $this->db->query("SELECT * from ".DB_prefix."countries_lists WHERE ".DB_prefix."SORTNAME = '".$i2D_D_COUNTRY."' OR ".DB_prefix."NAME = '".$i2D_D_COUNTRY."'");

                    	if($querycountry->num_rows() == 0)
                    	{
                    		$i2D_D_COUNTRYDATA = 'US';
                    		$check2 = 'true';
                    	}
                    	else
                    	{
                    		$resultcountry = $querycountry->result();
                    		$i2D_D_COUNTRYDATA = $resultcountry[0]->i2D_D_SORTNAME;
                    		$check2 = 'true';
                    	}
                    }
                    else
                    {
                    	$i2D_D_COUNTRYDATA = 'US';
                    	$check2 = 'true';
                    }
                    
                   
                    $query = $this->db->query("SELECT * from ".DB_prefix."users WHERE ".DB_prefix."EMAIL = '".$i2D_D_EMAIL."'");
                    $result = $query->result();

                    if($query->num_rows() == 0)
                    {
                    	$check3 = 'true';
                    }
                    else
                    {
                    	$finalresult .= '<p style="color: red;">Already Exists Email Account '.$i2D_D_EMAIL.'</p>';
                    	$check3 = 'false';
                    }
				    $insert_data = array(
						DB_prefix.'NAME'  => $i2D_D_NAME,
						DB_prefix.'EMAIL'   => $i2D_D_EMAIL,
						DB_prefix.'GENDER'    => $i2D_D_GENDER,
						DB_prefix.'PHONE_NUMBER'  => $i2D_D_PHONE,
						DB_prefix.'COUNTRY'   => $i2D_D_COUNTRYDATA,
						DB_prefix.'REGISTERING_AS'   => $i2D_D_REGISTERING_AS,
						DB_prefix.'BUSINESS_NAME'   => $i2D_D_BUSINESS_NAME,
						DB_prefix.'LOGIN_TYPE'   => 'In-App',
						DB_prefix.'TERMS' => 'Yes',
						DB_prefix.'PASSWORD'   => MD5($password),
						DB_prefix.'CREATED_AT'    => $created_at
				    );

				    if($check == 'true' && $check1 == 'true' && $check2 == 'true' && $check3 == 'true')
				    {
				   		$this->db->insert(DB_prefix."users", $insert_data);
				    	$id = $this->db->insert_id();
				   		$charity_id = "U".sprintf('%05d', $id);
					    $update_data = array(
					       DB_prefix.'USERID' => $charity_id,
					       DB_prefix.'STATUS' => 'A'
					    );
					    $this->db->where(DB_prefix.'ID', $id);
					    $this->db->update(DB_prefix."users", $update_data);
				    }
				    }
				   
				  }
				 }

				 if(empty($finalresult))
				 {
				 	$this->session->set_flashdata('message', 'Data has been imported');
				 }
				 else
				 {
				 	$this->session->set_flashdata('message', $finalresult);
				 }
				 redirect(base_url()."user/view");
				} 
			else {
				$data['title']="Users";
			
				$this->load->view('common/header', $data);
				$this->load->view('user/import', $data);
				$this->load->view('common/footer');
			}

		}
		
	}
}
?>
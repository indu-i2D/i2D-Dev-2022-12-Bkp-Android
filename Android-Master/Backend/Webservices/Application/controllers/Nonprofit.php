<?php

class Nonprofit extends CI_Controller {

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
		$this->load->model('Nonprofit_model');

		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone

	}


	public function category_list(){
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else
	    {
	        $data['title']="Category List";
	        $data['maincategorys'] = $this->Nonprofit_model->newCategoryList1();
			$data['maincategory'] = $this->Nonprofit_model->getCategoryList();
			$this->load->view('common/header', $data);
			$this->load->view('non_profit/category_list', $data);
			$this->load->view('common/footer');
	    }
	}

	
	public function check_category_exists(){
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else
	    {
	    	$ein = $_POST['ein'];
	    	$query = $this->db->select(DB_prefix.'EIN')
                   ->where(DB_prefix.'EIN', $ein)
                   ->get(DB_prefix.'Category');
            if( $query->num_rows() > 0 ){
                     echo json_encode(FALSE);
            } else {
               echo json_encode(TRUE);
            }
            exit;
	    }
	}

	public function check_ein_exists(){
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else
	    {
	    	$ein = $_POST['ein'];
	    	$query = $this->db->select(DB_prefix.'EIN')
                   ->where(DB_prefix.'EIN', $ein)
                   ->get(DB_prefix.'nonprofits');
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
		    $this->db->delete(DB_prefix."nonprofits");
		    $this->session->set_flashdata('message', 'Data has been deleted');
			redirect(base_url()."nonprofit/view");

	    }

    }


	    public function getdata()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {
			$draw = $_POST['draw'];
			$start = $_POST['start'];
			$length = $_POST['length'];
			$columnIndex = $_POST['order'][0]['column'];
			$columnName = $_POST['columns'][$columnIndex]['data'];
			$columnSortOrder = $_POST['order'][0]['dir'];
			$searchValue = $_POST['search']['value'];
			$data = $this->Nonprofit_model->getNonProfitList_final($draw, $start, $length, $columnIndex, $columnName, $columnSortOrder, $searchValue);
			echo $data;
		}
	}


	public function view()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {

			$data['title']="Non Profit List";
			//$data['non_profit_list'] = $this->Nonprofit_model->getNonProfitList_final($_POST);
			$this->load->view('common/setheader', $data);
			$this->load->view('non_profit/view', $data);
			$this->load->view('common/setfooter');

		}
	}

	public function add()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect(base_url());
		}
		else
		{
			if(isset($_POST['justAnInputBox1'])){
				  $data = $this->Nonprofit_model->updateCommonNonProfit($_POST);
			    $this->session->set_flashdata('message', 'Data has been inserted');
					redirect(base_url()."nonprofit/view");
			}
			else
			{
				$data['title']="Add Non Profit Data";
				$data['countries'] = $this->Nonprofit_model->getCountryList();
				$data['categories'] = $this->Nonprofit_model->getCategoryList();
				//$data['commoncategorylist'] = $this->Nonprofit_model->getCommonCategoryList();
				$this->load->view('common/header', $data);
				$this->load->view('non_profit/add', $data);
				$this->load->view('common/footer');
			}

		}
    }


    /*public function checkmulticategory(){
    	if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else
		{
			if(isset($_POST['categoryid']) && isset($_POST['subcategoryid'])){
				$data = $this->Nonprofit_model->getMultiChildCategoryList($_POST['categoryid'], $_POST['subcategoryid']);
				$finaldata = array('data' => $data);
				echo json_encode($finaldata); exit;
			}
			else
			{
				$data ='';
				return $data;
			}
		}
    }

    public function checkcategory(){
    	if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else
		{
			if(isset($_POST['categoryid'])){
				$data = $this->Nonprofit_model->getMultiSubCategoryList($_POST['categoryid']);
				$finaldata = array('data' => $data);
				echo json_encode($finaldata); exit;
			}
			else
			{
				$data ='';
				return $data;
			}


		}
    }  */


    public function add_category()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {
			$data['title']="Add Category";
			if($_POST){
				$code = strtoupper($_POST['code']);
				$subcode = strtoupper($_POST['subcode']);
				$childcode = strtoupper($_POST['childcode']);
				if(!empty($code) && $subcode==''  && $childcode == '')
				{
					$maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."'");
	                if($maincategory->num_rows() == 0)
	                {
						$insert_data = array(
						       DB_prefix.'CATEGORY_NAME' => $_POST['name'],
						       DB_prefix.'CATEGORY_CODE'   => $code,
						       DB_prefix.'CATEGORY_DESCIPTION' =>  $_POST['description'],
						       DB_prefix.'ACTIVE' => $_POST['status']
						);
					    $this->db->insert("i2D_D_Category", $insert_data);
					    $this->session->set_flashdata('message', 'Data has been inserted');
							redirect(base_url()."nonprofit/category_list");
				    }
				    else
				    {
				    	$this->session->set_flashdata('error', 'NTEE Category Already Exists');
						redirect(base_url()."nonprofit/add_category");
				    }
				}
				else if(!empty($code) && (!empty($subcode) || $subcode == '0') && $childcode=='')
				{
					$maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."'");
					if($maincategory->num_rows() != 0)
	                {
	                	$maincategorynew = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$_POST['subcode']."'");
	                	if($maincategorynew->num_rows() == 0)
	                    {
							$insert_data = array(
							       DB_prefix.'CATEGORY_NAME' => $_POST['name'],
							       DB_prefix.'CATEGORY_CODE'   => $code,
							       DB_prefix.'SUB_CATEGORY_CODE'   => $subcode,
							       DB_prefix.'CATEGORY_DESCIPTION' =>  $_POST['description'],
							       DB_prefix.'ACTIVE' => $_POST['status']
							);
						    $this->db->insert("i2D_D_Category", $insert_data);
						    $this->session->set_flashdata('message', 'Data has been inserted');
								redirect(base_url()."nonprofit/category_list");
					    }
					    else
					    {
					    	$this->session->set_flashdata('error', 'NTEE Sub-Type1 Already Exists');
							redirect(base_url()."nonprofit/add_category");
					    }
				    }
				    else
				    {
				    	$this->session->set_flashdata('error', 'NTEE Category its not there');
						redirect(base_url()."nonprofit/add_category");
				    }
				}
				else if(!empty($code) && (!empty($subcode) || $subcode == '0') && (!empty($childcode) || $childcode == '0'))
				{
					$maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."'");
					if($maincategory->num_rows() != 0)
	                {
	                	$maincategorynew = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$_POST['subcode']."'");
	                	if($maincategorynew->num_rows() != 0)
	                    {
	                    	$maincategorynew1 = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$_POST['code']."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$_POST['subcode']."' AND ".DB_prefix."CHILD_CATEGORY_CODE = '".$_POST['childcode']."'");
	                    	if($maincategorynew1->num_rows() == 0)
	                        {
								$insert_data = array(
								       DB_prefix.'CATEGORY_NAME' => $_POST['name'],
								       DB_prefix.'CATEGORY_CODE'   => $code,
								       DB_prefix.'SUB_CATEGORY_CODE'   => $subcode,
								       DB_prefix.'CHILD_CATEGORY_CODE'   => $childcode,
								       DB_prefix.'CATEGORY_DESCIPTION' =>  $_POST['description'],
								       DB_prefix.'ACTIVE' => $_POST['status']
								);
							    $this->db->insert("i2D_D_Category", $insert_data);
							    $this->session->set_flashdata('message', 'Data has been inserted');
									redirect(base_url()."nonprofit/category_list");
							}
							else
							{
								$this->session->set_flashdata('error', 'NTEE Sub-Type2 Already Exists');
								redirect(base_url()."nonprofit/add_category");
							}
					    }
					    else
					    {
					    	$this->session->set_flashdata('error', 'NTEE Sub-Type1 its not there');
							redirect(base_url()."nonprofit/add_category");
					    }
				    }
				    else
				    {
				    	$this->session->set_flashdata('error', 'NTEE Category its not there');
						redirect(base_url()."nonprofit/add_category");
				    }
				}

			}
			else {
			    $data['title']="Add Category";
    			$this->load->view('common/header', $data);
    			$this->load->view('non_profit/add_category', $data);
    			$this->load->view('common/footer');
			}
		}
	}

    public function edit_category()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {
			$category_id = $this->uri->segment(3);
			$data['title']="Edit Category";
			if($_POST){
				$update_data = array(
				       DB_prefix.'CATEGORY_NAME' => $_POST['name'],
				       DB_prefix.'CATEGORY_CODE'   => $_POST['code'],
				       DB_prefix.'CATEGORY_DESCIPTION' =>  $_POST['description'],
				       DB_prefix.'ACTIVE' => $_POST['status']
				);
			    $this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
			    $this->db->update(DB_prefix."Category", $update_data);
			    $this->session->set_flashdata('message', 'Data has been updated');
					redirect(base_url()."nonprofit/category_list");
			}
			else {
			    $data['title']="Edit Category";
    			$data['category'] = $this->Nonprofit_model->getMainCategory($category_id);
    			$this->load->view('common/header', $data);
    			$this->load->view('non_profit/edit_category', $data);
    			$this->load->view('common/footer');
			}
		}
	}

    

	public function delete_category()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {

			//error_reporting(0);
			$category_id = $this->uri->segment(3);
			$query = $this->db->query("SELECT ".DB_prefix."CATEGORY_CODE as category,".DB_prefix."SUB_CATEGORY_CODE as subcategory,".DB_prefix."CHILD_CATEGORY_CODE as childcategory  from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_ID = ".$category_id);
			// $this->db->select(DB_prefix."CATEGORY_CODE as category,".DB_prefix."SUB_CATEGORY_CODE as subcategory,"..DB_prefix."CHILD_CATEGORY_CODE as childcategory");
		 //    $this->db->from(DB_prefix.'Category');
		 //    $this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
		    
         
            $row = $query->result();
            $category_code = $subgory_code = $child_code = '';
            if($query->num_rows() == 1)
            {
            	foreach($row as $key => $value)
            	{
  
            		$category_code = (!empty($value->category)) ? $value->category : '';
                    $subgory_code = (!empty($value->subcategory) || $value->subcategory == '0') ? $value->subcategory : '';
                    $child_code = (!empty($value->childcategory)) ? $value->childcategory : '';		
            	}
            }
          
           

            if($child_code != '' && $subgory_code != '' && $category_code != '')
            {

               $this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
		       $this->db->delete(DB_prefix."Category");
		       $success = 'Data has been deleted';
            }
            else if($child_code == '' && $subgory_code != '' && $category_code != '')
            {


            	$maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category_code."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$subgory_code."'");
                if($maincategory->num_rows() == 1)
                {
                   $this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
			       $this->db->delete(DB_prefix."Category");
			       $success = 'Data has been deleted';

                }
                else
                {
                	$error = 'Category not removed. Child data exists.';
                }
            }
              else if($child_code == '' && $subgory_code == '' && $category_code != '')
            {
            	$maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category_code."'");
                if($maincategory->num_rows() == 1)
                {
                   $this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
			       $this->db->delete(DB_prefix."Category");
			       $success = 'Data has been deleted';
                }
                else
                {
                	$error ='Category not removed. Child data exists.';	
            
                }
            }
   

            if(!empty($error))
            {
            	$this->session->set_flashdata('error', $error);	
            }

            if(!empty($success))
            {
            	  $this->session->set_flashdata('message', $success);	
            }
            redirect(base_url().'nonprofit/category_list');
		
		}
	}



	public function edit()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {

			$data['title']="Edit Non Profit Data";
			if(isset($_POST['id'])){
			    $data = $this->Nonprofit_model->updateNonProfit($_POST);
			    $this->session->set_flashdata('message', 'Data has been updated');
					redirect(base_url()."nonprofit/view");
			}
			else {
			    $data['title']="Edit Non Profit Data";
    			$charity_id = $this->uri->segment(3);
    			$data['non_profit'] = $this->Nonprofit_model->getNonProfitDetails($charity_id);
    			$data['countries'] = $this->Nonprofit_model->getCountryList();
    			$data['categories'] = $this->Nonprofit_model->getCategoryList();
    			$data['sub_categories'] = $this->Nonprofit_model->getSubCategoryList($data['non_profit'][DB_prefix.'CATEGORY_CODE']);
    			$data['child_categories'] = $this->Nonprofit_model->getChildCategoryList($data['non_profit'][DB_prefix.'SUB_CATEGORY_CODE']);
    		  //  $data['commoncategorylist'] = $this->Nonprofit_model->getCommonCategoryList();
    			$this->load->view('common/header', $data);
    			$this->load->view('non_profit/edit', $data);
    			$this->load->view('common/footer');
			}
		}
	}

	public function getSubCategoryList(){
		$category_id = $_POST['category_id'];
		$maincategory = $this->db->query("SELECT ".DB_prefix."NTEE_1_ID AS ID, ".DB_prefix."NTEE_1_CODE AS code,".DB_prefix."NTEE_1_NAME AS Name from ".DB_prefix."NTEE_1 WHERE ".DB_prefix."CATEGORY_ID = ".$category_id);
        echo json_encode($maincategory->result());

	}

	public function view_details()
	{
		if (!$this->session->userdata('admin'))
		{
			$this->load->view('user/login');
		}
		else {
			$data['title']="Non Profit Data";
			$charity_id = $this->uri->segment(3);
			$data['non_profit'] = $this->Nonprofit_model->getNonProfitDetails($charity_id);
			$data['country'] = $this->Nonprofit_model->getCountry($data['non_profit'][DB_prefix.'COUNTRY_CODE']);
			$data['category'] = $this->Nonprofit_model->getCategory($data['non_profit'][DB_prefix.'CATEGORY_CODE']);
			//$data['sub_category'] = $this->Nonprofit_model->getSubCategory($data['non_profit'][DB_prefix.'SUB_CATEGORY_CODE']);
			//$data['child_category'] = $this->Nonprofit_model->getChildCategory($data['non_profit'][DB_prefix.'CHILD_CATEGORY_CODE']);
			$this->load->view('common/header', $data);
			$this->load->view('non_profit/view_details', $data);
			$this->load->view('common/footer');
		}
	}

	public function import()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect(base_url());
		}
		else {
			$finalresult = '';

				if(isset($_FILES["file"]["name"]))
				{
				$this->load->library("excel");
                
				 echo $path = $_FILES["file"]["tmp_name"];
				 $object = PHPExcel_IOFactory::load($path,$encode = 'utf-8');
				 foreach($object->getWorksheetIterator() as $worksheet)
				 {
				  $highestRow = $worksheet->getHighestRow();
				  $highestColumn = $worksheet->getHighestColumn();

				  for($row=2; $row <= $highestRow; $row++)
				  {
				   $i2D_D_EIN = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
				   $i2D_D_NAME = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());

				   $i2D_D_ICO = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
				   $i2D_D_STREET = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
				   $i2D_D_CITY = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
				   $i2D_D_STATE = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
				   $i2D_D_ZIP = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
				   $i2D_D_GROUP = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
				   $i2D_D_SUBSECTION = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
				   $i2D_D_AFFILIATION = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
				   $i2D_D_CLASSIFICATION = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
				   $i2D_D_RULING = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
				   $i2D_D_DEDUCTIBILITY = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
				   $i2D_D_FOUNDATION = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
				   $i2D_D_ACTIVITY = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
				   $i2D_D_ORGANIZATION = trim($worksheet->getCellByColumnAndRow(15, $row)->getValue());
				   $i2D_D_STATUS = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
				   $i2D_D_TAX_PERIOD = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
				   $i2D_D_ASSET_CD = trim($worksheet->getCellByColumnAndRow(18, $row)->getValue());
				   $i2D_D_INCOME_CD = trim($worksheet->getCellByColumnAndRow(19, $row)->getValue());
				   $i2D_D_FILING_REQ_CD = trim($worksheet->getCellByColumnAndRow(20, $row)->getValue());
                   $i2D_D_PF_FILING_REQ_CD = trim($worksheet->getCellByColumnAndRow(21, $row)->getValue());
				   $i2D_D_ACCT_PD = trim($worksheet->getCellByColumnAndRow(22, $row)->getValue());
				   $i2D_D_ASSET_AMT = trim($worksheet->getCellByColumnAndRow(23, $row)->getValue());
				   $i2D_D_INCOME_AMT = trim($worksheet->getCellByColumnAndRow(24, $row)->getValue());
				   $i2D_D_REVENUE_AMT = trim($worksheet->getCellByColumnAndRow(25, $row)->getValue());
				   $i2D_D_NTEE_CD = trim($worksheet->getCellByColumnAndRow(26, $row)->getValue());
				   $i2D_D_SORT_NAME = trim($worksheet->getCellByColumnAndRow(27, $row)->getValue());
				   $i2D_D_BRANCH_NM = trim($worksheet->getCellByColumnAndRow(28, $row)->getValue());
				   $i2D_D_12D_NTEE_DERV_CD = trim($worksheet->getCellByColumnAndRow(29, $row)->getValue());
                   
                   $i2D_D_ACTIVITY_check = strlen($i2D_D_ACTIVITY);
                   if($i2D_D_ACTIVITY_check < 9)
                   {
                   	   $i2_act = sprintf('%09s', $i2D_D_ACTIVITY);
                   	   $act1 = sprintf('%03s', substr($i2_act, 0, 3));
				       $act2  =sprintf('%03s', substr($i2_act, 3, 3));
				       $act3 = sprintf('%03s', substr($i2_act, 6, 3));
                   }
                   else
                   {
                       $i2_act =$i2D_D_ACTIVITY;
                   	   $act1 = sprintf('%03s', substr($i2_act, 0, 3));
				       $act2  =sprintf('%03s', substr($i2_act, 3, 3));
				       $act3 = sprintf('%03s', substr($i2_act, 6, 3));
                   }

				   
				   $activity_check_array = array('001', '002', '003', '004', '005', '006', '007', '008', '029');
				   $activity_pass1 = $this->activityData($act1, $activity_check_array);
				   $activity_pass2 = $this->activityData($act2, $activity_check_array);
				   $activity_pass3 = $this->activityData($act3, $activity_check_array); 

				   $rule1 = $this->subsectionwithclassification($i2D_D_SUBSECTION, $i2D_D_CLASSIFICATION);
				   $rule2 = (($act1 == '003' || $act2 == '003' && $act3 == '003') && $i2D_D_FOUNDATION == '10' && stristr($i2D_D_CLASSIFICATION, '7') == true) ? 'false' : 'true';
				   $rule3 = (($activity_pass1 == 'true' || $activity_pass2 == 'true' || $activity_pass3 == 'true' ) && $i2D_D_FOUNDATION == '10') ? 'false' : 'true';
                   if (empty($object->getActiveSheet()->getCell('A' . $row)->getCalculatedValue()) ) {
                       continue;
                   } else {
  
                   $checkcategory = substr($i2D_D_NTEE_CD, 0, 1);
                   if(strlen($i2D_D_EIN) < 9)
                   {
                   	   $i2D_D_EIN = sprintf('%09s', $i2D_D_EIN);
                   }

                   $strlenein = strlen($i2D_D_EIN);

                   if(!empty($i2D_D_EIN) && is_numeric($i2D_D_EIN) && $strlenein <= 9 && !empty($i2D_D_NAME) && isset($i2D_D_SORT_NAME ) && $checkcategory != 'X' &&(stristr($i2D_D_REVENUE_AMT,'-') != TRUE  && $i2D_D_REVENUE_AMT >= 50000) && $rule1 == 'true' && $rule2 == 'true' && $rule3 == 'true')
                   {


                    $strcount = strlen($i2D_D_NTEE_CD);
			        if($strcount == 1)
			        {
			           $maincategory1 = substr($i2D_D_NTEE_CD, 0, 1);
			           $query = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$maincategory1."'");
			            if($query->num_rows() == 0)
			            {
			                $i2D_D_CATEGORY_CODE = 'Z';
			                $i2D_D_SUB_CATEGORY_CODE ='';
			                $i2D_D_CHILD_CATEGORY_CODE = '';
			            } else {
			                $result = $query->row_array();
			                $categoryid = $result[DB_prefix."CATEGORY_ID"];
			                $i2D_D_CATEGORY_CODE = $result[DB_prefix."CATEGORY_CODE"];
			                $subquery = $this->db->query("SELECT GROUP_CONCAT(".DB_prefix."SUB_CATEGORY_CODE SEPARATOR ',') AS subcategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_ID=".$categoryid);
			                $subresult = $subquery->result();
			                $childquery = $this->db->query("SELECT GROUP_CONCAT(".DB_prefix."CHILD_CATEGORY_CODE SEPARATOR ',') AS chicategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_ID=".$categoryid);
			                $childresult = $childquery->result();

			                $i2D_D_SUB_CATEGORY_CODE = $subresult[0]->subcategory_code;
			                $i2D_D_CHILD_CATEGORY_CODE = $childresult[0]->chicategory_code;
			            }
			        }
			        else if($strcount == 2)
			        {
			            $maincategory1 = substr($i2D_D_NTEE_CD, 0, 1);
			            $subcategory1 = substr($i2D_D_NTEE_CD, 1, 1);
			            $query1 = $this->db->query("SELECT ".DB_prefix."SUB_CATEGORY_CODE  AS subcategory_code, ".DB_prefix."CATEGORY_CODE AS category_code from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$maincategory1."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$subcategory1."' GROUP BY ".DB_prefix."CATEGORY_CODE");
			             if($query1->num_rows() == 0)
			            {
			                $i2D_D_CATEGORY_CODE = 'Z';
			                $i2D_D_SUB_CATEGORY_CODE ='';
			                $i2D_D_CHILD_CATEGORY_CODE = '';
			            } else {
			                $result1 = $query1->row_array();
			                $i2D_D_CATEGORY_CODE = $result1['category_code'];
			                $i2D_D_SUB_CATEGORY_CODE = $result1['subcategory_code'];
			                $query2 = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(".DB_prefix."CHILD_CATEGORY_CODE) SEPARATOR ',') AS chicategory_code from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$maincategory1."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$subcategory1."' AND ".DB_prefix."CHILD_CATEGORY_CODE !='' GROUP BY ".DB_prefix."CATEGORY_CODE");
			                if($query2->num_rows() == 0)
			                {
			                    $i2D_D_CHILD_CATEGORY_CODE = '';
			                }
			                else
			                {
			                     $result3 = $query2->row_array();
			                    $i2D_D_CHILD_CATEGORY_CODE = $result3['chicategory_code'];
			                }
			            }
			        }
			        else if( $strcount == 3)
			         {
			         	$maincategory1 = substr($i2D_D_NTEE_CD, 0, 1);
			            $maincategory2 = substr($i2D_D_NTEE_CD, 1, 1);
			            $newdata = substr($i2D_D_NTEE_CD, 2, 1);
			            $i2D_D_CATEGORY_CODE = $maincategory1;
			            $i2D_D_SUB_CATEGORY_CODE =  $maincategory2;
			            $i2D_D_CHILD_CATEGORY_CODE =$newdata;
			          

			        }
			        else if($strcount == 4)
			        {
			           
			            $maincategory1 = substr($i2D_D_NTEE_CD, 0, 1);
			            $maincategory2 = substr($i2D_D_NTEE_CD, 1, 1);
			            $newdata = substr($i2D_D_NTEE_CD, 2, 2);
			            $i2D_D_CATEGORY_CODE = $maincategory1;
			            $i2D_D_SUB_CATEGORY_CODE =  $maincategory2;
			            $i2D_D_CHILD_CATEGORY_CODE =$newdata;
			        }
			        else
			        {

			            $i2D_D_CATEGORY_CODE = 'Z';
			            $i2D_D_SUB_CATEGORY_CODE = '';
			            $i2D_D_CHILD_CATEGORY_CODE = '';
			        }

				   $newntee_cd = $i2D_D_CATEGORY_CODE.''.$i2D_D_SUB_CATEGORY_CODE.''.$i2D_D_CHILD_CATEGORY_CODE;
				   if(stristr($newntee_cd , 'Z') == TRUE)
				   {
				   		$ntee_cd =  $i2D_D_NTEE_CD;
				   }
				   else
				   {
				   		$ntee_cd = $i2D_D_NTEE_CD;
				   }


				   $insert_data = array(
					DB_prefix.'EIN'  => $i2D_D_EIN,
					DB_prefix.'NAME'   => $i2D_D_NAME,
					DB_prefix.'ICO'  => $i2D_D_ICO,
					DB_prefix.'STREET'    => $i2D_D_STREET,
					DB_prefix.'CITY'  => $i2D_D_CITY,
					DB_prefix.'STATE'  => $i2D_D_STATE,
					DB_prefix.'ZIP'   => $i2D_D_ZIP,
					DB_prefix.'CATEGORY_CODE'  => $i2D_D_CATEGORY_CODE,
					DB_prefix.'COUNTRY_CODE'    => "US",
					DB_prefix.'SUB_CATEGORY_CODE'   => $i2D_D_SUB_CATEGORY_CODE,
					DB_prefix.'CHILD_CATEGORY_CODE'    => $i2D_D_CHILD_CATEGORY_CODE,
					DB_prefix.'GROUP'  => $i2D_D_GROUP,
					DB_prefix.'SUBSECTION'   => $i2D_D_SUBSECTION,
					DB_prefix.'AFFILIATION'    => $i2D_D_AFFILIATION,
					DB_prefix.'CLASSIFICATION'  => $i2D_D_CLASSIFICATION,
					DB_prefix.'RULING'   => $i2D_D_RULING,
					DB_prefix.'DEDUCTIBILITY'    => $i2D_D_DEDUCTIBILITY,
					DB_prefix.'FOUNDATION'    => $i2D_D_FOUNDATION,
					DB_prefix.'ACTIVITY'  => $i2D_D_ACTIVITY,
					DB_prefix.'ORGANIZATION'  => $i2D_D_ORGANIZATION,
					DB_prefix.'STATUS'   => $i2D_D_STATUS,
					DB_prefix.'TAX_PERIOD'    => $i2D_D_TAX_PERIOD,
					DB_prefix.'ASSET_CD'  => $i2D_D_ASSET_CD,
					DB_prefix.'INCOME_CD'   => $i2D_D_INCOME_CD,
					DB_prefix.'FILING_REQ_CD'    => $i2D_D_FILING_REQ_CD,
					DB_prefix.'PF_FILING_REQ_CD'    => $i2D_D_PF_FILING_REQ_CD,
					DB_prefix.'ACCT_PD'  => $i2D_D_ACCT_PD,
					DB_prefix.'ASSET_AMT'  => $i2D_D_ASSET_AMT,
					DB_prefix.'INCOME_AMT'  => $i2D_D_INCOME_AMT,
					DB_prefix.'INCOME_SYMBOL'  => '',
					DB_prefix.'REVENUE_AMT'   => $i2D_D_REVENUE_AMT,
					DB_prefix.'NTEE_CD'    => trim($ntee_cd),
					DB_prefix.'SORT_NAME'  => $i2D_D_SORT_NAME,
					DB_prefix.'BRANCH_NM'   => $i2D_D_BRANCH_NM,
					DB_prefix.'NTEE_DERV_CD'    => $i2D_D_12D_NTEE_DERV_CD
				   );

				 $eincheck = $this->db->query("SELECT * FROM ".DB_prefix."nonprofits  WHERE ".DB_prefix."EIN=".$i2D_D_EIN);


				   if(!empty($i2D_D_EIN) && $eincheck->num_rows() == 0 && !empty($newntee_cd))
				   {

				    $this->db->insert(DB_prefix."nonprofits", $insert_data);
				    $id = $this->db->insert_id();
				    $dataupdated = 'Data has been uploaded successfully';
				    $charity_id = "C".sprintf('%05d', $id);
	                $branch_cd = $i2D_D_STATE.sprintf('%05d', $id);
				    $EO_ID_FULL = $i2D_D_EIN.''.$i2D_D_STATE.''.$i2D_D_ZIP.''.$branch_cd;
				    $act1 = sprintf('%03s', substr($i2D_D_ACTIVITY, 0, 3));
				    $act2  =sprintf('%03s', substr($i2D_D_ACTIVITY, 3, 3));
				    $act3 = sprintf('%03s', substr($i2D_D_ACTIVITY, 6, 3));
				    $update_data = array(
				       DB_prefix.'CHARITYID' => $charity_id,
				       DB_prefix.'ACT_CD1' => $act1,
				       DB_prefix.'ACT_CD2' => $act2,
				       DB_prefix.'ACT_CD3' => $act3,
                       DB_prefix.'BRANCH_CD' => $branch_cd,
				       DB_prefix.'EO_ID_FULL' => $EO_ID_FULL
				    );
				    $this->db->where(DB_prefix.'ID', $id);
				    $this->db->update(DB_prefix."nonprofits", $update_data);
				    $this->updateAddress($id, $i2D_D_STREET,$i2D_D_CITY, $i2D_D_STATE,$i2D_D_ZIP);
            
				     if(stristr($i2D_D_INCOME_AMT,'-') == TRUE)
				     {
				     	$amount_replace = str_replace('-','', $i2D_D_INCOME_AMT);
				     	$update_data = array(
				                                DB_prefix.'INCOME_SYMBOL' => '-',
				                                DB_prefix.'INCOME_AMT'  => $amount_replace
				                             );
				        $this->db->where(DB_prefix.'ID', $id);
				     }

				    }
				    else
				    {
				    	$resultmain = $eincheck->row_array();
                        $id = $resultmain[DB_prefix.'ID'];
				    	$this->db->where(DB_prefix.'ID', $id);
				        $this->db->update(DB_prefix."nonprofits", $insert_data);
				        $charity_id = "C".sprintf('%05d', $id);
		                $branch_cd = $i2D_D_STATE.sprintf('%05d', $id);
					    $EO_ID_FULL = $i2D_D_EIN.''.$i2D_D_STATE.''.$i2D_D_ZIP.''.$branch_cd;
					    $act1 = sprintf('%03s', substr($i2D_D_ACTIVITY, 0, 3));
					    $act2  =sprintf('%03s', substr($i2D_D_ACTIVITY, 3, 3));
					    $act3 = sprintf('%03s', substr($i2D_D_ACTIVITY, 6, 3));
					    $update_data = array(
					       DB_prefix.'CHARITYID' => $charity_id,
					       DB_prefix.'ACT_CD1' => $act1,
					       DB_prefix.'ACT_CD2' => $act2,
					       DB_prefix.'ACT_CD3' => $act3,
	                       DB_prefix.'BRANCH_CD' => $branch_cd,
					       DB_prefix.'EO_ID_FULL' => $EO_ID_FULL
					    );

					    $dataupdated = 'Data has been uploaded successfully';
					    $this->db->where(DB_prefix.'ID', $id);
					    $this->db->update(DB_prefix."nonprofits", $update_data);
                        $this->updateAddress($id, $i2D_D_STREET,$i2D_D_CITY,$i2D_D_STATE,$i2D_D_ZIP);

					    if(stristr($i2D_D_INCOME_AMT,'-') == TRUE)
					    {
					     	$amount_replace = str_replace('-','', $i2D_D_INCOME_AMT);
					     	$update_data = array(
					                                DB_prefix.'INCOME_SYMBOL' => '-',
					                                DB_prefix.'INCOME_AMT'  => $amount_replace
					                             );
					        $this->db->where(DB_prefix.'ID', $id);
					    }
					    $finalresult .= '<p>EIN '.$i2D_D_EIN.' - Record Updated</p>';
                    	$check3 = 'false';
				    }

				   }
				   else
				   {
				   	   $strccount = strlen($i2D_D_EIN);
				   	   $checkcategory = substr($i2D_D_NTEE_CD, 0, 1);
				   	   if($strccount >= 10)
				   	   {
				   	   	   $finalresult .= '<p style="color: red;">Invalid EIN Number '.$i2D_D_EIN.'</p>';
				   	   }
				   	    if(!is_numeric($i2D_D_EIN))
				   	   {
				   	   	   $finalresult .= '<p style="color: red;">Invalid EIN Number '.$i2D_D_EIN.'</p>';
				   	   }

				   	   if(empty($i2D_D_NAME))
				   	   {
				   	   	  $finalresult .= '<p style="color: red;">Name should be empty '.$i2D_D_NAME.'</p>';
				   	   }
				   	   if(stristr($i2D_D_INCOME_AMT,'-') == TRUE)
				   	   {
				   	   	  // $finalresult .= '<p style="color: red;">Invalid income amount - '.$i2D_D_INCOME_AMT.' - '.$i2D_D_EIN.'</p>';
				   	   }

				   	   if(stristr($i2D_D_INCOME_AMT,'-') != TRUE  && $i2D_D_INCOME_AMT <= 49999)
				   	   {
				   	   	   //$finalresult .= '<p style="color: red;">Income amount should be less than 50000 - '.$i2D_D_INCOME_AMT.' - '.$i2D_D_EIN.'</p>';
				   	   }

				   	    if(stristr($i2D_D_CLASSIFICATION, '7') == true ) 
				   	    {
				   	    	 //$finalresult .= '<p style="color: red;">Classification code '.$i2D_D_CLASSIFICATION.' is not accepted - '.$i2D_D_EIN.'</p>';
				   	    }
				   	    if($i2D_D_FOUNDATION == '10')
				   	    {
				   	    	 //$finalresult .= '<p style="color: red;">Foundation code '.$i2D_D_FOUNDATION.' is not accepted - '.$i2D_D_EIN.'</p>';
				   	    }
				   	   // if($checkcategory != 'X')
				   	   // {
				   	   // 	    $finalresult .= '<p style="color: red;">Invalid NTEE CD - '.$i2D_D_NTEE_CD.' - '.$i2D_D_EIN.'</p>';
				   	   // }
				   }
				 }

				  }
				 }
                  
                 if(!empty($dataupdated))
                 {
                 	 $this->session->set_flashdata('message', $dataupdated);
                 }
				 if(!empty($finalresult))
				 {
				 	 $this->session->set_flashdata('error', $finalresult);
				 }

			     redirect(base_url()."nonprofit/view");
				}

			//}
			else {
				$data['title']="Import Non Profit Data";
				$this->load->view('common/header', $data);
				$this->load->view('non_profit/import', $data);
				$this->load->view('common/footer');
			}
		}
	}
    

    public function updateAddress($id, $street, $city, $state, $zip)
    {

    	/*if(empty($state))
    	{
    		$address = $street.','.$city;
    	}
    	else
    	{
    		$address = $street.','.$city.','.$state.','.$zip;
    	}  */
    	if($zip == '00000-0000')
    	{
    	$address = $street.','.$city;
        $address = str_replace(" ","%20",$address);
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyCXQhv_qRtIS_sgVskOOsiB-HpF8BxFm_I";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$result = json_decode($result, 1);
		if (count($result['results']) > 0) {
			foreach ($result['results'][0]['address_components'] as $key => $value1) {
				$address_type = $value1['types'][0];
				if($address_type == "country")
				{
					$country_code = $value1['short_name'];
					$latlon = $result['results'][0]['geometry']['location'];
					$update_data = array(
						DB_prefix."COUNTRY_CODE" => $country_code,
						DB_prefix."LATITUDE" => $latlon['lat'],
						DB_prefix."LONGITUDE" => $latlon['lng']
					);
					$this->db->where(DB_prefix.'ID',$id);
					$this->db->update(DB_prefix.'nonprofits',$update_data);
				}
				if($address_type == "administrative_area_level_1" && empty($state))
				{
					$statecode = $value1['short_name'];
					$update_data = array(
						DB_prefix."STATE" => $statecode
					);
					$this->db->where(DB_prefix.'ID',$id);
					$this->db->update(DB_prefix.'nonprofits',$update_data);
				}  
			}
		} 	
    	}

		
    }

	public function category_import()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect(base_url());
		}
		else {

			if(isset($_FILES["file"]["name"]))
			{
				$this->load->library("excel");
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					for($row=2; $row<=$highestRow; $row++)
					{
						$category_code = ucfirst(strtolower(trim($worksheet->getCellByColumnAndRow(0, $row)->getValue())));
						$sub_category_code = ucfirst(strtolower($worksheet->getCellByColumnAndRow(1, $row)->getValue()));

						$child_category_code = ucfirst(strtolower(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue())));
						$category = ucfirst(strtolower(trim($worksheet->getCellByColumnAndRow(3, $row)->getValue())));
						$description = ucfirst(strtolower(trim($worksheet->getCellByColumnAndRow(4, $row)->getValue())));


						if(!empty($category_code) && $category_code != 'X' && $sub_category_code=='' && $child_category_code=='')
						{
							$testcount = strlen($category_code);

							if($testcount == 1)
							{
								if(preg_match('/[a-zA-Z]/', $category_code))
								{

									$query = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category_code."'");
	                            $result = $query->row_array();

	                            if($query->num_rows() == 0)
	                            {
	                            	$insert_data = array(
										'i2D_D_CATEGORY_CODE'  => trim($category_code),
										'i2D_D_SUB_CATEGORY_CODE'=> trim($sub_category_code),
										'i2D_D_CHILD_CATEGORY_CODE' => trim($child_category_code),
										'i2D_D_CATEGORY_NAME'   => trim($category),
										'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
										'i2D_D_ACTIVE' => 'Yes'
									);
									$this->db->insert("i2D_D_Category", $insert_data);
									$category_id = $this->db->insert_id();
	                            }
	                            else
	                            {
	                            	$category_id = $result[DB_prefix."CATEGORY_ID"];

							    	$insert_data = array(
												'i2D_D_CATEGORY_NAME'   => trim($category),
												'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
												'i2D_D_ACTIVE' => 'Yes'
											);
							    	$this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
	        						$this->db->update(DB_prefix."Category", $insert_data);
	                            }
								}
								else
								{
									// $this->session->set_flashdata('error', 'NTEE category code is allowed only letters');
								}

							}
							else
							{
								 //$this->session->set_flashdata('error', 'NTEE category code is allowed only one character');
							}
						}
						else if(!empty($category_code) && $category_code != 'X' && (!empty($sub_category_code) || $sub_category_code == '0') && $child_category_code == '')
						{
							$testcount = strlen($category_code);
							$testcount1 = strlen($sub_category_code);
							if($testcount == 1 && $testcount1 == 1 && preg_match('/[a-zA-Z]/', $category_code) && preg_match('/[a-zA-Z0-9]/', $sub_category_code))
							{

									$query = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category_code."' AND  ".DB_prefix."SUB_CATEGORY_CODE = '".$sub_category_code."'");
                            $result = $query->row_array();

                            if($query->num_rows() == 0)
                            {
                            	$insert_data = array(
									'i2D_D_CATEGORY_CODE'  => trim($category_code),
									'i2D_D_SUB_CATEGORY_CODE'=> trim($sub_category_code),
									'i2D_D_CHILD_CATEGORY_CODE' => trim($child_category_code),
									'i2D_D_CATEGORY_NAME'   => trim($category),
									'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
									'i2D_D_ACTIVE' => 'Yes'
								);
								$this->db->insert("i2D_D_Category", $insert_data);
								$category_id = $this->db->insert_id();
                            }
                            else
                            {
                            	$category_id = $result[DB_prefix."CATEGORY_ID"];

						    	$insert_data = array(
											'i2D_D_CATEGORY_NAME'   => trim($category),
											'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
											'i2D_D_ACTIVE' => 'Yes'
										);
						    	$this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
        						$this->db->update(DB_prefix."Category", $insert_data);
                            }
							}

						}

					    else if(!empty($category_code) && $category_code != 'X' && (!empty($sub_category_code) || $sub_category_code =='0') && (!empty($child_category_code) || $child_category_code == '0'))
						{
							$testcount = strlen($category_code);
							$testcount1 = strlen($sub_category_code);
							$testcount2 = strlen($child_category_code);
				            $testchar1 = substr($child_category_code, 0, 1);
				            $testchar2 = substr($child_category_code, 1, 1);
							if($testcount == 1 && $testcount1 == 1 && preg_match('/[a-zA-Z]/', $category_code) && preg_match('/[a-zA-Z0-9]+/', $sub_category_code) && $testcount2 == 1 || $testcount2 == 2 && preg_match('/[a-zA-Z0-9]/', $testchar1) && preg_match('/[a-zA-Z0-9]/', $testchar2))
							{
								$query = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category_code."' AND  ".DB_prefix."SUB_CATEGORY_CODE = '".$sub_category_code."' AND  ".DB_prefix."CHILD_CATEGORY_CODE = '".$child_category_code."'");
                            $result = $query->row_array();

                            if($query->num_rows() == 0)
                            {
                            	$insert_data = array(
									'i2D_D_CATEGORY_CODE'  => trim($category_code),
									'i2D_D_SUB_CATEGORY_CODE'=> trim($sub_category_code),
									'i2D_D_CHILD_CATEGORY_CODE' => trim($child_category_code),
									'i2D_D_CATEGORY_NAME'   => trim($category),
									'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
									'i2D_D_ACTIVE' => 'Yes'
								);
								$this->db->insert("i2D_D_Category", $insert_data);
								$category_id = $this->db->insert_id();
                            }
                            else
                            {
                            	$category_id = $result[DB_prefix."CATEGORY_ID"];

						    	$insert_data = array(
											'i2D_D_CATEGORY_NAME'   => trim($category),
											'i2D_D_CATEGORY_DESCIPTION'    => trim($description),
											'i2D_D_ACTIVE' => 'Yes'
										);
						    	$this->db->where(DB_prefix.'CATEGORY_ID', $category_id);
        						$this->db->update(DB_prefix."Category", $insert_data);
                            }
							}

						}


					}
				}
			 $this->session->set_flashdata('message', 'Data has been updated');
				redirect(base_url()."nonprofit/category_list");
			} else {
				$data['title']="Category Import Data";
				$this->load->view('common/header', $data);
				$this->load->view('non_profit/category_import', $data);
				$this->load->view('common/footer');
			}
		}
	}

	public function activityData($num, $data)
	{
		if(in_array($num, $data))
		{
			$check = 'true';
		}
		else
		{
			$check = 'false';	
		}
		return $check;
	}

	public function subsectionwithclassification($subsection, $classification)
	{
        $data = ($subsection == '3' && stristr($classification, '7') == 'true') ? 'false' : 'true';
		return $data;
	}


}
?>
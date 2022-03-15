<?php
/* Patients Model Created by David */

class Webservice_model extends CI_Model{
	private $json;
	private $Getjson;
    function __construct()
    {
        $this->load->database();
        $this->load->library("braintree_lib");
		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone
    }

	/* Login */
	public function countryList($details)
	{
		$this->db->select(DB_prefix.'SORTNAME as sortname, '.DB_prefix.'NAME as name');
		$query = $this->db->get(DB_prefix.'countries_lists');
		$data = $query->result_array();
		if($data) {
			$data = array('status'=>1, 'message'=>'Records Found', 'data'=> $data);
		}
		else {
			$data = array('status'=>0, 'message'=>'Data not found', 'data'=>'');
		}
		return $data;
	}

	/* Login */
	public function login($details)
	{
		$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'REGISTERING_AS as type,'.DB_prefix.'BUSINESS_NAME as business_name,'.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country, '.DB_prefix.'STATUS as status, '.DB_prefix.'PHOTO as photo, '.DB_prefix.'TERMS as terms');
		$this->db->where(DB_prefix.'EMAIL', $details['email']);
		$this->db->where(DB_prefix.'PASSWORD', md5($details['password']));
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if($data) {

			$tokenvalue = openssl_random_pseudo_bytes(16);
			$token = bin2hex($tokenvalue);
			$update_data = array(
				DB_prefix."token" => $token,
				DB_prefix.'login_type' => 'Login form'
			);
			$this->db->where(DB_prefix.'id',$data['user_id']);
			$this->db->update(DB_prefix.'users',$update_data);

			$data['token'] = $token;

			if(strpos($data['photo'],"loads/profile") && $data['photo']!="")
			{
				$data['photo'] = base_url().$data['photo'];
			}

			$data = array('status'=>1, 'message'=>'Login Successfully', 'data'=> $data);
		}
		else {
			$data = array('status'=>0, 'message'=>'Invalid Email ID or Password', 'data'=> NULL);
		}
		return $data;
	}

	/* Login */
	public function register($details)
	{
		
		$this->db->select(DB_prefix.'id as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country, '.DB_prefix.'STATUS as status');
		$this->db->where(DB_prefix.'EMAIL', $details['email']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if($data<=0) {

			if($details['type'] == 'business')
			{
				$newname = (!empty($details['business_name'])) ? $details['business_name'] : $details['name'];
			}
			else
			{
				$newname = '';
			}

			$phone = (!empty($details['phone'])) ? $details['phone'] : '';
			$gender = (!empty($details['gender'])) ? $details['gender'] : '';
			$insert_data = array(
				DB_prefix.'NAME' => $details['name'],
				DB_prefix.'EMAIL' => $details['email'],
				DB_prefix.'REGISTERING_AS' => $details['type'],
				DB_prefix.'BUSINESS_NAME' => $newname,
				DB_prefix.'PASSWORD' => md5($details['password']),
				DB_prefix.'PHONE_NUMBER' => $phone,
				DB_prefix.'GENDER' => $details['gender'],
				DB_prefix.'COUNTRY' => $details['country'],
				DB_prefix.'STATUS' => 'A',
				DB_prefix.'TERMS' => $details['terms'],
				DB_prefix.'CREATED_AT' => date("Y-m-d H:i:s"),
				DB_prefix.'LOGIN_TYPE' => 'Login form'
			);
			$this->db->insert(DB_prefix."users", $insert_data);
			$id = $this->db->insert_id();
			$charity_id = "U".sprintf('%05d', $id);
		    $update_data = array(
		       DB_prefix.'USERID' => $charity_id
		    );
		    $this->db->where(DB_prefix.'ID', $id);
		    $this->db->update(DB_prefix."users", $update_data);
			if($id){

				$tokenvalue = openssl_random_pseudo_bytes(16);
				$token = bin2hex($tokenvalue);
				$update_data = array(
					DB_prefix."TOKEN" => $token
				);
				$this->db->where(DB_prefix.'ID',$id);
				$this->db->update(DB_prefix.'users',$update_data);

				$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'REGISTERING_AS as type,'.DB_prefix.'BUSINESS_NAME as business_name,'.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country, '.DB_prefix.'PHOTO as photo,, '.DB_prefix.'TERMS as terms');
				$this->db->where(DB_prefix.'EMAIL', $details['email']);
				$query = $this->db->get(DB_prefix.'users');
				$data = $query->row_array();
				$data['token'] = $token;

				if(strpos($data['photo'],"loads/profile") && $data['photo']!="")
				{
					$data['photo'] = base_url().$data['photo'];
				}

				$data = array('status'=>1, 'message'=>'Registered Successfully', 'data'=> $data);
			}
			else {
				$data = array('status'=>1, 'message'=>'Oops Something Went Wrong', 'data'=> NULL);
			}
		}
		else {
			$data = array('status'=>0, 'message'=>'Email ID already exists', 'data'=> NULL);
		}
		return $data;
	}

	/* Login */
	public function socialLogin($details)
	{
		$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country, '.DB_prefix.'STATUS as status, '.DB_prefix.'PHOTO as photo');
		$this->db->where(DB_prefix.'EMAIL', $details['email']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if($data) {

			$tokenvalue = openssl_random_pseudo_bytes(16);
			$token = bin2hex($tokenvalue);
			$update_data = array(
				DB_prefix.'NAME' => $details['name'],
				DB_prefix.'PHOTO' => $details['photo'],
				DB_prefix."TOKEN" => $token,
				DB_prefix.'LOGIN_TYPE' => $details['login_type']
			);
			$this->db->where(DB_prefix.'ID',$data['user_id']);
			$this->db->update(DB_prefix.'users',$update_data);

			$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'REGISTERING_AS as type,'.DB_prefix.'BUSINESS_NAME as business_name,'.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country,'.DB_prefix.'PHOTO as photo,'.DB_prefix.'TERMS as terms');
			$this->db->where(DB_prefix.'EMAIL', $details['email']);
			$query = $this->db->get(DB_prefix.'users');
			$data = $query->row_array();

			$data['token'] = $token;

			if(strpos($data['photo'],"loads/profile") && $data['photo']!="")
			{
				$data['photo'] = base_url().$data['photo'];
			}

			$data = array('status'=>1, 'message'=>'Login Successfully', 'data'=> $data);
		}
		else {

			$tokenvalue = openssl_random_pseudo_bytes(16);
			$token = bin2hex($tokenvalue);

			$insert_data = array(
				DB_prefix.'NAME' => $details['name'],
				DB_prefix.'EMAIL' => $details['email'],
				DB_prefix.'PHOTO' => $details['photo'],
				DB_prefix.'STATUS' => 'A',
				DB_prefix."TERMS" => 'No',
				DB_prefix.'CREATED_AT' => date("Y-m-d H:i:s"),
				DB_prefix."TOKEN" => $token,
				DB_prefix.'LOGIN_TYPE' => $details['login_type']
			);
			$this->db->insert(DB_prefix."users", $insert_data);
			$id = $this->db->insert_id();
            $charity_id = "U".sprintf('%05d', $id);
		    $update_data = array(
		       DB_prefix.'USERID' => $charity_id
		    );
		    $this->db->where(DB_prefix.'ID', $id);
		    $this->db->update(DB_prefix."users", $update_data);
			$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country,'.DB_prefix.'PHOTO as photo,'.DB_prefix.'TERMS as terms');
				$this->db->where(DB_prefix.'EMAIL', $details['email']);
			$query = $this->db->get(DB_prefix.'users');
			$data = $query->row_array();
			$data['token'] = $token;

			if(strpos($data['photo'],"loads/profile") && $data['photo']!="")
			{
				$data['photo'] = base_url().$data['photo'];
			}

			$data['type'] = '';
			$data['business_name'] = '';
			$data = array('status'=>1, 'message'=>'Register Successfully', 'data'=> $data);
		}
		return $data;
	}

	/* Login */
	public function updateProfile($details)
	{
		if($details['photo']!="")
		{
			$folder_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/profile/';

			$photo = $details['photo'];
			$photo_file = strtotime('now').'.png';
			$photo_path = "uploads/profile/".$photo_file;
			$photo_image = base64_to_png($photo, $folder_path."/".$photo_file);
		}
		else {
			$photo_image = "";
		}

		$update_data = array(

			DB_prefix.'NAME' => $details['name'],
			DB_prefix.'EMAIL' => $details['email'],
			DB_prefix.'PHONE_NUMBER' => $details['phone'],
			DB_prefix.'TERMS' => $details['terms'],
			DB_prefix.'GENDER' => $details['gender'],
			DB_prefix.'COUNTRY' => $details['country']
		);
		if($details['photo']!="")
		{
			$update_data[DB_prefix.'PHOTO'] = $photo_path;
		}

		if($details['type'] != "")
		{
			$update_data[DB_prefix.'REGISTERING_AS'] = $details['type'];
		}
		if($details['business_name'] != "")
		{
			if($details['type'] == "business")
			{
				$newname = (!empty($details['business_name'])) ? $details['business_name'] : $details['name'];
				$update_data[DB_prefix.'BUSINESS_NAME'] = $newname;
			}

		}
		$this->db->where(DB_prefix.'ID',$details['user_id']);
		$this->db->update(DB_prefix.'users',$update_data);
		$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name, '.DB_prefix.'EMAIL as email, '.DB_prefix.'REGISTERING_AS as type,'.DB_prefix.'BUSINESS_NAME as business_name,'.DB_prefix.'PHONE_NUMBER as phone_number, '.DB_prefix.'GENDER as gender, '.DB_prefix.'COUNTRY as country, '.DB_prefix.'PHOTO as photo, '.DB_prefix.'TOKEN as token, '.DB_prefix.'TERMS as terms');
		$this->db->where(DB_prefix.'ID',$details['user_id']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if(strpos($data['photo'],"loads/profile") && $data['photo']!="")
		{
			$data['photo'] = base_url().$data['photo'];
		}
		$data = array('status'=>1, 'message'=>'Profile has been updated', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $data);
		return $data;
	}
    

    public function new_transaction($details)
	{
		//$token = $this->braintree_lib->create_client_token();
		//$result =$this->braintree_lib->transaction_find($details['transaction_id']);
		$clientToken = Braintree_ClientToken::generate();
		$result = Braintree_Transaction::sale([
		  'amount' =>$details['amount'],
		  'paymentMethodNonce' => $details['transaction_id'],
		  'options' => [
		    'submitForSettlement' => True
		  ]
		]);
		 
		echo json_encode($result);
		//$result = Braintree_Transaction::find($details['transaction_id']);
		//echo "<pre>"; print_r($result); echo "</pre>";
		exit;
		$insert_data = array(
			DB_prefix.'CHARITY_ID' => $details['charity_id'],
			DB_prefix.'USER_ID' => $details['user_id'],
			DB_prefix.'CHARITY_NAME' => $details['charity_name'],
			DB_prefix.'TRANSACTION_ID' => $details['transaction_id'],
			DB_prefix.'AMOUNT' => $details['amount'],
			DB_prefix.'STATUS' => $details['status'],
			DB_prefix.'CREATED_AT' => date('Y-m-d H:i:s')
		);
		$this->db->insert(DB_prefix."payments_data", $insert_data);
		$id = $this->db->insert_id();
		$this->notification_list($id, $details['user_id'],$details['charity_name'], $details['amount']);

		$this->db->where(DB_prefix.'ID',$id);
		$query = $this->db->get(DB_prefix.'payments_data');
		$data = $query->row_array();

		$data = array('status'=>1, 'message'=>'success', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $data);
		return $data;
	}

	public function braintree_trans($amount, $transaction_id)
	{
		$result = Braintree_Transaction::sale([
		  'amount' =>$amount,
		  'paymentMethodNonce' => $transaction_id,
		  'options' => [
		    'submitForSettlement' => True
		  ]
		]);
		return $result;
	}
    public function braintree_client_token($details)
	{
		$clientToken = Braintree_ClientToken::generate();
		return $clientToken;
	}
    
    public function transaction_list($details)
	{
		$this->db->select(DB_prefix.'USER_ID as user_id,'.DB_prefix.'CHARITY_NAME as charity_name,'.DB_prefix.'PAYMENT_TYPE as payment_type,'.DB_prefix.'AMOUNT as amount, '.DB_prefix.'CREATED_AT as date');
		$this->db->where(DB_prefix.'USER_ID',$details['user_id']);
		$this->db->order_by(DB_prefix.'ID', 'DESC');
		$query = $this->db->get(DB_prefix.'payments_data');
		$datas = $query->result_array();
		if($datas) {
			$newdatas = array();
			for($i=0; $i<count($datas); $i++)
		    {
		    	$newdata['user_id'] = $datas[$i]['user_id'];
		    	$newdata['charity_name'] = $datas[$i]['charity_name'];
		    	$newdata['payment_type'] = $datas[$i]['payment_type'];
		    	$newdata['amount'] = '$'.$datas[$i]['amount'];
		    	$newdata['date'] = date('F j, Y, g:i a', strtotime($datas[$i]['date']));
                $newdatas[] = $newdata;
		    }
			$data = array('status'=>1, 'message'=>'Records Found', 'data'=> $newdatas);
		}
		else {
			$data = array('status'=>0, 'message'=>'Data not found', 'data'=>'');
		}
		return $data;
	}

	/* Transaction */
	public function transaction($details)
	{
		//$clientToken = Braintree_ClientToken::generate();
		$result = $this->braintree_trans($details['amount'], $details['transaction_id']);
		if($result->success) {
		$insert_data = array(
			DB_prefix.'CHARITY_ID' => $details['charity_id'],
			DB_prefix.'USER_ID' => $details['user_id'],
			DB_prefix.'CHARITY_NAME' => $details['charity_name'],
			DB_prefix.'TRANSACTION_ID' => $details['transaction_id'],
			DB_prefix.'AMOUNT' => $details['amount'],
			DB_prefix.'PAYMENT_TYPE' => $details['payment_type'],
			DB_prefix.'STATUS' => $details['status'],
			DB_prefix.'CREATED_AT' => date('Y-m-d H:i:s')
		);
		$this->db->insert(DB_prefix."payments_data", $insert_data);
		$id = $this->db->insert_id();
		$this->notification_list($id, $details['user_id'],$details['charity_name'], $details['amount']);

		$this->db->where(DB_prefix.'ID',$id);
		$query = $this->db->get(DB_prefix.'payments_data');
		$data = $query->row_array();

		$data = array('status'=>1, 'message'=>'success', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $data);
	    } else {
	    	$data = array('status'=>1, 'message'=> $result->message, 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $result);
	    }
		return $data;
	}

	/* Login */
	public function changePassword($details)
	{

	    $this->db->select(DB_prefix.'ID as user_id');
		$this->db->where(DB_prefix.'ID',$details['user_id']);
		$this->db->where(DB_prefix.'PASSWORD',md5($details['old_password']));
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if(count($data)>0){

    		$update_data = array(
    			DB_prefix.'PASSWORD' => md5($details['new_password']),
    		);
    		$this->db->where(DB_prefix.'ID',$details['user_id']);
    		$this->db->update(DB_prefix.'users',$update_data);
    		$data = array('status'=>1, 'message'=>'Password has been changed', 'token_status'=>1, 'token_message'=>'Valid token');
		}
		else {
		    $data = array('status'=>0, 'message'=>'Your old password is incorrect', 'token_status'=>1, 'token_message'=>'Valid token');
		}
		return $data;
	}

	/* Forgot Password */
	public function forgotPassword($details)
	{
		$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'NAME as name');
		$this->db->where(DB_prefix.'EMAIL', $details['email']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if($data) {
		    $otp = rand(1000,9999);
		    //$otp = 1234;
			$update_data = array(
				DB_prefix."OTP" => $otp,
				DB_prefix.'OTP_EXPIRY_DATE' => date("Y-m-d H:i:s", strtotime("+30 minutes"))
			);
			$this->db->where(DB_prefix.'id',$data['user_id']);
			$this->db->update(DB_prefix.'users',$update_data);



			$to = $details['email'];
            $subject = "i2Donate - OTP";
            $message ='<html><table style="background: #e5c4dc; font-size: 16px; font-weight: 500; padding: 30px 0;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                        <tr>
                            <td>
                                <table style="width: 80%; background: #fff; padding: 20px; margin: 20px auto 20px auto; border-top-left-radius: 4px; border-top-right-radius: 4px;" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="margin: 15px auto;" align="center"><img style="width: 100px; margin-bottom: 20px;" src="'.base_url().'skins/images/icon/idonatelogo.png" /></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <p><strong>Dear '.$data['name'].',</strong></p>
                                                    <p><strong> Your OTP number is '.$otp.'</strong></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <p style="margin: 10px 0px 5px 0px;">Thanks &amp; regards,</p>
                                                    <p style="margin: 0px 0px 5px 0px;"><strong>i2-donate</strong></p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table></html>';
           /* $message = "
            <html>
            <head>
            <title>i2Donate - OTP</title>
            </head>
            <body>
            <p>Please find your OTP below</p>
            <p>OTP : ".$otp."</p>
            </body>
            </html>
            ";  */

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <noreply@i2-donate.com>' . "\r\n";
            //$headers .= 'Cc: myboss@example.com' . "\r\n";

            mail($to,$subject,$message,$headers);


			$data = array('status'=>1, 'message'=>'One Time Password for change password is '.$otp, 'data'=> $data);
		}
		else {
			$data = array('status'=>0, 'message'=>'You are not register with this Email ID', 'data'=> NULL);
		}
		return $data;
	}

	/* Verify OTP */
	public function verifyOTP($details)
	{
		$this->db->select(DB_prefix.'ID as user_id, '.DB_prefix.'OTP as otp, '.DB_prefix.'OTP_EXPIRY_DATE as otp_expiry_date');
		$this->db->where(DB_prefix.'ID', $details['user_id']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if($data) {
		    if(strtotime($data['otp_expiry_date'])<strtotime(date("Y-m-d H:i:s")))
		    {
			    $data = array('status'=>0, 'message'=>'OTP Expired', 'data'=> array());
		    }
		    else if($data['otp']!=$details['otp'])
		    {
		        $data = array('status'=>0, 'message'=>'Invalid OTP', 'data'=> array());
		    }
		    else {
		        $data = array('status'=>1, 'message'=>'Valid OTP', 'data'=> array('user_id' => $data['user_id']));
		    }
		}
		else {
			$data = array('status'=>0, 'message'=>'Invalid User ID', 'data'=>array());
		}
		return $data;
	}

	/* Login */
	public function updatePassword($details)
	{

	    $this->db->select(DB_prefix.'ID as user_id');
		$this->db->where(DB_prefix.'ID',$details['user_id']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
		if(count($data)>0){

    		$update_data = array(
    			DB_prefix.'PASSWORD' => md5($details['password']),
    		);
    		$this->db->where(DB_prefix.'ID',$details['user_id']);
    		$this->db->update(DB_prefix.'users',$update_data);
    		$data = array('status'=>1, 'message'=>'Password has been changed', 'data'=> array('user_id' => $data['user_id']));
		}
		else {
		    $data = array('status'=>0, 'message'=>'Invalid USer ID', 'data'=> array());
		}
		return $data;
	}

	/* Login */
	public function categories($details)
	{
		$this->db->select(DB_prefix.'CATEGORY_ID as category_id, '.DB_prefix.'CATEGORY_CODE as category_code, '.DB_prefix.'CATEGORY_NAME as category_name');
		$this->db->where(DB_prefix.'ACTIVE', 'Yes');
		$this->db->where(DB_prefix.'CATEGORY_CODE !=', 'X');
		$where_sub_category_null = '('.DB_prefix.'SUB_CATEGORY_CODE IS NULL OR '.DB_prefix.'SUB_CATEGORY_CODE = "")';
		$where_child_category_null = '('.DB_prefix.'CHILD_CATEGORY_CODE IS NULL OR '.DB_prefix.'CHILD_CATEGORY_CODE = "")';
		$this->db->where($where_sub_category_null);
		$this->db->where($where_child_category_null);
		$query = $this->db->group_by(DB_prefix.'CATEGORY_CODE')->get(DB_prefix.'Category');
		$category = $query->result_array();

		$data = $category;

		for($i=0; $i<count($category); $i++)
		{
			$this->db->select(DB_prefix.'CATEGORY_ID as sub_category_id, '.DB_prefix.'SUB_CATEGORY_CODE as sub_category_code, '.DB_prefix.'CATEGORY_NAME as sub_category_name');
			$this->db->where(DB_prefix.'CATEGORY_CODE', $category[$i]['category_code']);
			$this->db->where(DB_prefix.'ACTIVE', 'Yes');

			$where_sub_category_not_null = '('.DB_prefix.'SUB_CATEGORY_CODE IS NOT NULL AND '.DB_prefix.'SUB_CATEGORY_CODE != "")';
			$this->db->where($where_sub_category_not_null);

			$where_child_category_null = '('.DB_prefix.'CHILD_CATEGORY_CODE IS NULL OR '.DB_prefix.'CHILD_CATEGORY_CODE = "")';
			$this->db->where($where_child_category_null);

			$query = $this->db->get(DB_prefix.'Category');
			$sub_category = $query->result_array();

			$data[$i]['subcategory'] = $sub_category;

			for($j=0; $j<count($sub_category); $j++)
			{
				$this->db->select(DB_prefix.'CATEGORY_ID as child_category_id, '.DB_prefix.'CHILD_CATEGORY_CODE as child_category_code, '.DB_prefix.'CATEGORY_NAME as child_category_name');
				$this->db->where(DB_prefix.'CATEGORY_CODE', $category[$i]['category_code']);
				$this->db->where(DB_prefix.'SUB_CATEGORY_CODE', $sub_category[$j]['sub_category_code']);
				$this->db->where(DB_prefix.'ACTIVE', 'Yes');

				$where_sub_category_not_null = '('.DB_prefix.'SUB_CATEGORY_CODE IS NOT NULL AND '.DB_prefix.'SUB_CATEGORY_CODE != "")';
				$where_child_category_not_null = '('.DB_prefix.'CHILD_CATEGORY_CODE IS NOT NULL AND '.DB_prefix.'CHILD_CATEGORY_CODE != "")';
				$this->db->where($where_sub_category_not_null);
				$this->db->where($where_child_category_not_null);

				$query = $this->db->get(DB_prefix.'Category');
				$child_category = $query->result_array();

				$data[$i]['subcategory'][$j]['child_category'] = $child_category;
			}

		}

		$data = array('status'=>1, 'message'=>'Records Found', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $data);
		return $data;
	}


	public function searchList($search){
		$where = "";
		$field = ",'0' as distance";
		if($search['search'])
		{
			$where.= DB_prefix."NAME LIKE '%".$search['search']."%' OR ";
			$where.= DB_prefix."SORT_NAME LIKE '%".$search['search']."%'";
		}

		if($where=="")
		{
			$where = "1";
		}

		$query = $this->db->query("SELECT ".DB_prefix."ID as id, ".DB_prefix."NAME as name, ".DB_prefix."DESCRIPTION as description, ".DB_prefix."STREET as street, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."COUNTRY_CODE as country, ".DB_prefix."LOGO as logo, ".DB_prefix."BANNER as banner, ".DB_prefix."LATITUDE as latitude, ".DB_prefix."TAX_DEDUCTIBLE as taxdeductible, ".DB_prefix."INCOME_AMT as amt,".DB_prefix."LONGITUDE as longitude ".$field." FROM ".DB_prefix."nonprofits where ".$where);

		//echo $this->db->last_query(); exit;
		$data = $query->result_array();
		for($i=0; $i<count($data); $i++)
		{

			$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."'");
			$like_data = $like_count->row();

			$data[$i]['like_count'] = $like_data->count;

			$country_query = $this->db->query("select ".DB_prefix."NAME as name from ".DB_prefix."countries_lists where ".DB_prefix."SORTNAME='".$data[$i]['country']."'");
			$country = $country_query->row();

			$data[$i]['country'] = $country->name;

			// if($search['user_id']!="") {
			// 	$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."' and ".DB_prefix."USER_ID = '".$search['user_id']."'");
			// 	$like_data = $like_count->row();

			// 	if($like_data->count>0){
			// 		$data[$i]['liked'] = "yes";
			// 	}
			// 	else {
			// 		$data[$i]['liked'] = "no";
			// 	}

			// }
			// else {
			// 	$data[$i]['liked'] = "no";
			// }

			// if($search['user_id']!="") {
			// 	$follow_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."following where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."' and ".DB_prefix."USER_ID = '".$search['user_id']."'");
			// 	$follow_data = $follow_count->row();

			// 	if($follow_data->count>0){
			// 		$data[$i]['followed'] = "yes";
			// 	}
			// 	else {
			// 		$data[$i]['followed'] = "no";
			// 	}

			// }
			// else {
			// 	$data[$i]['followed'] = "no";
			// }

			if($data[$i]['logo']!=""){
				$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
			}
			if($data[$i]['banner']!=""){
				$data[$i]['banner'] = base_url().'uploads/images/'.$data[$i]['banner'];
			}
		}
		if($data)
		{
			$data = array('status'=>1, 'message'=>'Records Found', 'data'=> $data);
		}
		else
		{
			$data = array('status'=>0, 'message'=>'No Records Found', 'data'=> array());
		}
		return $data;

	}

	/* Login */
	public function charityList($details)
	{
	
		$where = "";
		$field = ",'0' as distance";

		//$exempt = (empty($details['exempt'])) ? "0" : $details['exempt'];
		$income_from = (empty($details['income_from'])) ? 0 : $details['income_from'];

        if($details['deductible'] == '1')
		{
			$where.= DB_prefix."DEDUCTIBILITY='0' OR ";
			$where.= DB_prefix."DEDUCTIBILITY='1' OR ";
			$where.= DB_prefix."DEDUCTIBILITY='4' and ";
		}
		if($details['deductible'] == '2' || $details['deductible'] == '0')
		{
			$where.= DB_prefix."DEDUCTIBILITY='2' and ";
		}

		$where.= DB_prefix."INCOME_AMT >=".$income_from." and ";
	    if($details['income_to'])
		{
			$where.= DB_prefix."INCOME_AMT <=".$details['income_to']." and ";
		}

		
		$city = '';

        if($details['latitude']!="" && $details['longitude']!="")
        {
        	$datas = $this->getCountryState($details['latitude'], $details['longitude']);
            // print_r($datas);
            // exit;
           

            if($datas['country_code'] != 'US' && $datas['country_code'] != 'AS' && $datas['country_code'] != 'FM' && $datas['country_code'] != 'GM' && $datas['country_code'] != 'MH') 
            {
            	if($datas['country_code'])
			    {
				   $where.= DB_prefix."COUNTRY_CODE='".$datas['country_code']."' and ";
			    } 			    

			    $where.= DB_prefix."ZIP='00000-0000' and ";
			     $city = (!empty($datas['city'])) ? $datas['city'] : '';
			     /*if($datas['state_code'] && strlen($datas['state_code']) == 2)
			    {
			    	
				  $where.= DB_prefix."STATE='".$datas['state_code']."' and ";
			    }  */

			    // if($datas['country_code']  && $datas['country_code'] == 'US')
			    // {
				   // $where.= DB_prefix."COUNTRY_CODE='".$datas['country_code']."' and ";
				   // $where.= DB_prefix."ZIP='000000' and ";
			    // }
	       	 
            }
            else
            {
       //      	if($datas['country_code'] )
			    // {

				   // $where.= DB_prefix."COUNTRY_CODE='".$datas['country_code']."' and ";
			    // }
	            $where.= DB_prefix."COUNTRY_CODE='US' and ";
	            $where.= DB_prefix."ZIP !='00000-0000' and ";
	            /*$where.= DB_prefix."COUNTRY_CODE='AS' OR ";
			    $where.= DB_prefix."COUNTRY_CODE='FM' OR ";
			 	$where.= DB_prefix."COUNTRY_CODE='GM' OR ";
				$where.= DB_prefix."COUNTRY_CODE='MH' OR ";
				$where.= DB_prefix."COUNTRY_CODE='MP' OR ";
				$where.= DB_prefix."COUNTRY_CODE='PW' OR ";
				$where.= DB_prefix."COUNTRY_CODE='VI' OR ";  */
			    //$where.= DB_prefix."COUNTRY_CODE='PR' and ";
			    //if($datas['state_code'] && $datas['country_code'] == 'US' && $details['latitude']!="37.09024" && $details['longitude']!="-95.712891" )
			    if($datas['state_code'] && strlen($datas['state_code']) == 2)
			    {
			    	 $city = (!empty($datas['city'])) ? $datas['city'] : '';
				  $where.= DB_prefix."STATE='".$datas['state_code']."' and ";
			    }
            }
        	
        }
        else
        {
          if($details['country_code'] && $details['country_code'] == 'INT')
		  {

			// $where.= DB_prefix."COUNTRY_CODE!='US' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='AS' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='FM' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='GM' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='MH' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='MP' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='PW' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='VI' and ";
			// $where.= DB_prefix."COUNTRY_CODE!='PR' and ";
			$where.= DB_prefix."ZIP='00000-0000' and ";
		  }

		  if($details['country_code'] && $details['country_code'] == 'US')
		  {
			$where.= DB_prefix."COUNTRY_CODE='US' and ";
			$where.= DB_prefix."ZIP !='00000-0000' and ";
			/*$where.= DB_prefix."COUNTRY_CODE='AS' OR ";
			$where.= DB_prefix."COUNTRY_CODE='FM' OR ";
			$where.= DB_prefix."COUNTRY_CODE='GM' OR ";
			$where.= DB_prefix."COUNTRY_CODE='MH' OR ";
			$where.= DB_prefix."COUNTRY_CODE='MP' OR ";
			$where.= DB_prefix."COUNTRY_CODE='PW' OR ";
			$where.= DB_prefix."COUNTRY_CODE='VI' OR "; */
			//$where.= DB_prefix."COUNTRY_CODE='PR' and ";
		  }

		
        }
		
		if($details['category_code'])
		{
			$where.= DB_prefix."CATEGORY_CODE IN ('" . implode("', '", $details['category_code']) . "') and ";
		}

		if($details['sub_category_code'])
		{
			$where.= DB_prefix."SUB_CATEGORY_CODE IN ('" .implode("', '", $details['sub_category_code']) . "') and ";
		}

		if($details['child_category_code'])
		{
		    array_push($details['child_category_code'], '');
			$where.= DB_prefix."CHILD_CATEGORY_CODE IN ('" . implode("', '", $details['child_category_code']) . "') and ";
		}

		if($details['name'] != '')
		{	
			$where.= DB_prefix."NAME LIKE '%".$details['name']."%' OR ";
			$where.= DB_prefix."SORT_NAME LIKE '%".$details['name']."%'";

		}else {
			$where= substr($where,0,-4);
		}

		if($where=="")
		{
			$where = "1";
		}
		$asc_order ='';
        if(!empty($city) && $details['country_code'] == 'US')
	    {
            $where.= " AND ".DB_prefix."CITY LIKE '%".$city."%'";
            //$asc_order = " ORDER BY FIELD(".DB_prefix."CITY, '$city') DESC";
	    }
	    if(!empty($city) && $details['country_code'] == 'INT')
	    {
            $where.= " OR ".DB_prefix."CITY LIKE '%".$city."%'";
            //$asc_order = " ORDER BY FIELD(".DB_prefix."CITY, '$city') DESC";
	    }
        $asc_order1 = " ORDER BY ".DB_prefix."NAME ASC";
	    $page = (!empty($details['page'])) ? ((int) $details['page'] - 1) : (1 - 1);
	    
	    $assignpage = ($page == 0) ? 0 : ($page * 100);
	    $limit = " LIMIT ".$assignpage.", 100";

	 //    if($details['name'] != '')
		// {
		//    $naee = $details['name'];
	 //       $asc_order = " ORDER BY FIELD(".DB_prefix."NAME, '$naee') DESC";
		// }
	

	//MAX(CASE WHEN c.meta_key = 'country' THEN (select ".DB_prefix."NAME FROM iactscon_2018_countries_lists where sortname=meta_value) END) AS country,

	    if($details['user_id'] =="") {
	    	$commonuserid = 0;
			$query = $this->db->query("SELECT ".DB_prefix."ID as id, ".DB_prefix."NAME as name,".DB_prefix."STREET as street, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."COUNTRY_CODE as country,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=".DB_prefix."ID) as like_count, (select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=".DB_prefix."ID AND ".DB_prefix."USER_ID = '".$commonuserid."') as liked, (select count(".DB_prefix."ID) FROM ".DB_prefix."following where ".DB_prefix."CHARITY_ID=".DB_prefix."ID AND ".DB_prefix."USER_ID = '".$commonuserid."') as followed, ".DB_prefix."LOGO as logo, ".DB_prefix."TAX_DEDUCTIBLE as taxdeductible, ".DB_prefix."INCOME_AMT as amt FROM ".DB_prefix."nonprofits where ".$where.$asc_order.$asc_order1.$limit);

	    } else {
	    	$query = $this->db->query("SELECT ".DB_prefix."ID as id, ".DB_prefix."NAME as name, ".DB_prefix."STREET as street, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."COUNTRY_CODE as country,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id) as like_count, (select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as liked, (select count(".DB_prefix."ID) FROM ".DB_prefix."following where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as followed,".DB_prefix."LOGO as logo, ".DB_prefix."TAX_DEDUCTIBLE as taxdeductible, ".DB_prefix."INCOME_AMT as amt FROM ".DB_prefix."nonprofits where ".$where.$asc_order.$asc_order1.$limit);
	    } 

	    // echo $this->db->last_query();
	    // exit;

       
		$data = $query->result_array();
		for($i=0; $i<count($data); $i++)
		{
			//$data[$i]['like_count'] = $data[$i]['firstcount'];
			//$data[$i]['country'] = $data[$i]['countryname'];

			/*if($details['user_id']!="") {
				$like_data = count($data[$i]['liked']);
				if($like_data != '0'){
					$data[$i]['liked'] = "yes";
				}
				else {
					$data[$i]['liked'] = "no";
				}

			}
			else {
				$data[$i]['liked'] = "no";
			}

			if($details['user_id']!="") {
				$following_count = count($data[$i]['followed']);
				if($following_count > 0){
					$data[$i]['followed'] = "yes";
				}
				else {
					$data[$i]['followed'] = "no";
				}

			}
			else {
				$data[$i]['followed'] = "no";
			} */

			if($data[$i]['logo']!=""){
				$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
			}
			else
			{
				$data[$i]['logo'] = base_url().'uploads/images/defaultlogo.png';
			}
			/*if($data[$i]['banner']!=""){
				$data[$i]['banner'] = base_url().'uploads/images/'.$data[$i]['banner'];
			} */
		}
		if($data)
		{

			$data = array('status'=>1, 'message'=>'Records Found', 'data'=> $data);
		}
		else {
			$data = array('status'=>0, 'message'=>'No Records Found', 'data'=> array());
		}
		return $data;
	}

	public function charityLikeDislike($data)
    {

		if($data['status']==1) {
			$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data['charity_id']."' and ".DB_prefix."USER_ID = '".$data['user_id']."'");
			$like_data = $like_count->row();
			if($like_data->count==0) {
				$insert_data = array(
					DB_prefix."USER_ID" => $data['user_id'],
					DB_prefix."CHARITY_ID" => $data['charity_id'],
					DB_prefix."CREATED_AT" => date("Y-m-d H:i:s")
				);
				$this->db->insert(DB_prefix."charity_likes", $insert_data);
				$id=$this->db->insert_id();
			}
			else {
				$id = true;
			}
		}
		else {

			$this -> db -> where(DB_prefix."USER_ID", $data['user_id']);
			$this -> db -> where(DB_prefix."CHARITY_ID", $data['charity_id']);
			$this->db->delete(DB_prefix."charity_likes");
			$id = $this->db->affected_rows();
		}



		$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data['charity_id']."'");
		$like_data = $like_count->row();
		$data = array();
		$data["like_count"] = $like_data->count;

		if($id)
		{
			$data = array('status'=>1, 'message'=>'Data has been saved successfully', 'token_status'=>1, 'token_message'=>'Valid token', 'data' => $data);
		}
		else {
			$data = array('status'=>0, 'message'=>'Data not saved', 'token_status'=>1, 'token_message'=>'Valid token', 'data' => $data);
		}
		return $data;
    }

	public function charityFollowing($data)
    {

		if($data['status']==1) {
			$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."following where ".DB_prefix."CHARITY_ID='".$data['charity_id']."' and ".DB_prefix."USER_ID = '".$data['user_id']."'");
			$like_data = $like_count->row();
			if($like_data->count==0) {
				$insert_data = array(
					DB_prefix."USER_ID" => $data['user_id'],
					DB_prefix."CHARITY_ID" => $data['charity_id'],
					DB_prefix."CREATED_AT" => date("Y-m-d H:i:s")
				);
				$this->db->insert(DB_prefix."following", $insert_data);
				$id=$this->db->insert_id();
			}
			else {
				$id = true;
			}
		}
		else {

			$this -> db -> where(DB_prefix."USER_ID", $data['user_id']);
			$this -> db -> where(DB_prefix."CHARITY_ID", $data['charity_id']);
			$this->db->delete(DB_prefix."following");
			$id = $this->db->affected_rows();
		}


		if($id)
		{
			$data = array('status'=>1, 'message'=>'Data has been saved successfully', 'token_status'=>1, 'token_message'=>'Valid token');
		}
		else {
			$data = array('status'=>0, 'message'=>'Data not saved', 'token_status'=>1, 'token_message'=>'Valid token');
		}
		return $data;
    }

	/* Login */
	public function likesAndFollowings($details)
	{

		$query = $this->db->query("SELECT b.".DB_prefix."ID as id, b.".DB_prefix."NAME as name,  b.".DB_prefix."STREET as street, b.".DB_prefix."CITY as city, b.".DB_prefix."STATE as state, b.".DB_prefix."ZIP as zip_code, b.".DB_prefix."COUNTRY_CODE as country, b.".DB_prefix."LOGO as logo,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id) as like_count,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as liked, (select count(".DB_prefix."ID) FROM ".DB_prefix."following where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as followed FROM ".DB_prefix."charity_likes a LEFT JOIN ".DB_prefix."nonprofits b ON a.".DB_prefix."CHARITY_ID = b.".DB_prefix."ID where a.".DB_prefix."USER_ID = '". $details['user_id']."'");
		 $data = $query->result_array();

		for($i=0; $i<count($data); $i++)
		{

			if(!empty($data[$i]['logo']) AND $data[$i]['logo']!=""){
				$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
			}
			else {
				//$data[$i]['logo'] = base_url().'uploads/images/nonprofits-default.png';
				$data[$i]['logo'] = '';
			}
			/*if($data[$i]['banner']!=""){
				$data[$i]['banner'] = base_url().'uploads/images/'.$data[$i]['banner'];
			} */
		}

		$result = array();
		$result['like_count'] = count($data);
		$result['like_charity_list'] = $data;

		$query = $this->db->query("SELECT b.".DB_prefix."ID as id, b.".DB_prefix."NAME as name, b.".DB_prefix."STREET as street, b.".DB_prefix."CITY as city, b.".DB_prefix."STATE as state, b.".DB_prefix."ZIP as zip_code, b.".DB_prefix."COUNTRY_CODE as country, b.".DB_prefix."LOGO as logo, (select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id) as like_count,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as liked, (select count(".DB_prefix."ID) FROM ".DB_prefix."following where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as followed  FROM ".DB_prefix."following a LEFT JOIN ".DB_prefix."nonprofits b ON a.".DB_prefix."CHARITY_ID = b.".DB_prefix."ID where a.".DB_prefix."USER_ID = '". $details['user_id']."'");
		$data = $query->result_array();

		for($i=0; $i<count($data); $i++)
		{

		
			if(!empty($data[$i]['logo']) AND $data[$i]['logo']!=""){
				$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
			}
			else {
				$data[$i]['logo'] = '';
				//$data[$i]['logo'] = base_url().'uploads/images/nonprofits-default.png';
			}
		}
		$result['following_count'] = count($data);
		$result['following_charity_list'] = $data;

		/** VELMURUGAN **/

		$query = $this->db->query("SELECT b.".DB_prefix."ID as id, a.".DB_prefix."ID as payment_data_id, b.".DB_prefix."NAME as name, b.".DB_prefix."STREET as street, b.".DB_prefix."CITY as city, b.".DB_prefix."STATE as state, b.".DB_prefix."ZIP as zip_code, b.".DB_prefix."COUNTRY_CODE as country, b.".DB_prefix."LOGO as logo, (select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id) as like_count,(select count(".DB_prefix."ID) FROM ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as liked, (select count(".DB_prefix."ID) FROM ".DB_prefix."following where ".DB_prefix."CHARITY_ID=id AND ".DB_prefix."USER_ID = ".$details['user_id'].") as followed  FROM ".DB_prefix."payments_data a INNER JOIN ".DB_prefix."nonprofits b ON a.".DB_prefix."CHARITY_ID = b.".DB_prefix."ID where a.".DB_prefix."USER_ID = '". $details['user_id']."' GROUP BY b.".DB_prefix."ID");
		$data = $query->result_array();

		for($i=0; $i<count($data); $i++)
		{

			/* $like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."'");
			$like_data = $like_count->row();

			$data[$i]['like_count'] = $like_data->count;

			$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."'"); */


			$payment_history_query = $this->db->query("SELECT ".DB_prefix."AMOUNT as amount,DATE_FORMAT(".DB_prefix."CREATED_AT,'%d/%m/%Y %h:%i %p') as donate_date  FROM ".DB_prefix."payments_data a  where a.".DB_prefix."USER_ID = '". $details['user_id']."' AND a.".DB_prefix."CHARITY_ID = ".$data[$i]['id']);

			$data[$i]['history'] = $payment_history_query->result_array();
			$data[$i]['history_count'] = count($data[$i]['history']);

			if(!empty($data[$i]['logo']) AND $data[$i]['logo']!=""){
				$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
			}
			else {
				$data[$i]['logo'] = '';
				//$data[$i]['logo'] = base_url().'uploads/images/nonprofits-default.png';
			}

		}
		$result['payment_history_list'] = $data;

		$query = $this->db->query("SELECT b.".DB_prefix."ID as id, b.".DB_prefix."NAME as name, b.".DB_prefix."DESCRIPTION as description, b.".DB_prefix."STREET as street, b.".DB_prefix."CITY as city, b.".DB_prefix."STATE as state, b.".DB_prefix."ZIP as zip_code, b.".DB_prefix."COUNTRY_CODE as country, b.".DB_prefix."LOGO as logo, b.".DB_prefix."BANNER as banner, b.".DB_prefix."LATITUDE as latitude, b.".DB_prefix."LONGITUDE as longitude  FROM ".DB_prefix."payments_data a INNER JOIN ".DB_prefix."nonprofits b ON a.".DB_prefix."CHARITY_ID = b.".DB_prefix."ID where a.".DB_prefix."USER_ID = '". $details['user_id']."'");
		$data = $query->result_array();
		$result['payment_count'] = count($data);
		/** VELMURUGAN **/

		if($result)
		{
			$data = array('status'=>1, 'message'=>'Records Found', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> $result);
		}
		else {
			$data = array('status'=>0, 'message'=>'No Records Found', 'token_status'=>1, 'token_message'=>'Valid token', 'data'=> array());
		}
		return $data;
	}


	/** VELMURUGAN **/

	/** CATEGORY AND SUBCATEGORY LIST **/

	public function category_subcategory_list($details)
	{
		$query = "";
		$list = "";

		if(!empty($details['sub_category_code']) AND !empty($details['category_code'])) /** CHILD CATEGORY **/
		{
			$this->db->select(DB_prefix.'CHILD_CATEGORY_CODE as child_category_code, '.DB_prefix.'CATEGORY_ID as id,'.DB_prefix.'CATEGORY_NAME as child_category_name');
			$this->db->where(DB_prefix.'CATEGORY_CODE',$details['category_code']);
			$this->db->where(DB_prefix.'SUB_CATEGORY_CODE',$details['sub_category_code']);
			$where = DB_prefix.'CHILD_CATEGORY_CODE != "" AND '.DB_prefix.'CHILD_CATEGORY_CODE IS NOT NULL';
			$this->db->where($where);
			$query = $this->db->group_by(DB_prefix.'CHILD_CATEGORY_CODE')->order_by(DB_prefix.'CHILD_CATEGORY_CODE','ASC')->get(DB_prefix.'Category');
		}
		else if(!empty($details['category_code'])) /** SUB CATEGORY **/
		{
			$this->db->select(DB_prefix.'SUB_CATEGORY_CODE as sub_category_code, '.DB_prefix.'CATEGORY_ID as id,'.DB_prefix.'CATEGORY_NAME  as sub_category_name');
			$this->db->where(DB_prefix.'CATEGORY_CODE',$details['category_code']);
			$where = DB_prefix.'SUB_CATEGORY_CODE != "" AND '.DB_prefix.'SUB_CATEGORY_CODE IS NOT NULL';
			$this->db->where($where);
			$query = $this->db->group_by(DB_prefix.'SUB_CATEGORY_CODE')->order_by(DB_prefix.'SUB_CATEGORY_CODE','ASC')->get(DB_prefix.'Category');
		}
		else /** CATEGORY **/
		{
			$this->db->select(DB_prefix.'CATEGORY_CODE as category_code, '.DB_prefix.'CATEGORY_ID as id,'.DB_prefix.'CATEGORY_NAME as category_name');
			$query = $this->db->group_by(DB_prefix.'CATEGORY_CODE')->order_by(DB_prefix.'CATEGORY_CODE','ASC')->get(DB_prefix.'Category');
		}


		$list = $query->result_array();
		return $this->return_success_failure($list);
	}

	/** CATEGORY AND SUBCATEGORY LIST **/

	/** NON PROFIT SEARCH **/

	public function non_profit_search_list($details)
	{


		$query = "";
		$list = "";
		$where = "";
		$field = ",'0' as distance";
		$select_fields = DB_prefix.'NAME as name,'.DB_prefix."ID as id, ".DB_prefix."NAME as name, ".DB_prefix."DESCRIPTION as description, ".DB_prefix."STREET as street, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."COUNTRY_CODE as country, ".DB_prefix."LOGO as logo, ".DB_prefix."BANNER as banner, ".DB_prefix."LATITUDE as latitude, ".DB_prefix."TAX_DEDUCTIBLE as taxdeductible, ".DB_prefix."INCOME_AMT as amt,".DB_prefix."LONGITUDE as longitude ".$field;

		$income_from = (empty($details['income_from'])) ? 0 : $details['income_from'];
		if(!empty($details['deductible']) OR $details['deductible'] == '0')
		{
			$where.= DB_prefix."DEDUCTIBILITY='".$details['deductible']."' AND ";
		}

		$where.= DB_prefix."INCOME_AMT >= ".$income_from;
	    if(!empty($details['income_to']))
		{
			$where.= " AND ".DB_prefix."INCOME_AMT <=".$details['income_to'];
		}

		//$where.= DB_prefix."NAME LIKE '%".$details['name']."%' OR ";

		if(!empty($details['name']))
		{
			$where.= " AND (".DB_prefix."NAME LIKE '%".$details['name']."%'";
			$where.= " OR ".DB_prefix."SORT_NAME LIKE '%".$details['name']."%')";
		}
		// echo "<pre>";print_r($where);die;

		if(!empty($details['country_code']))
		{
			$where.= " AND ".DB_prefix."COUNTRY_CODE='".$details['country_code']."'";
		}else {
			$where.= " AND ".DB_prefix."COUNTRY_CODE!='US'";
		}
		$order_by = DB_prefix."CHILD_CATEGORY_CODE";
		if(!empty($details['latitude']!="") && !empty($details['longitude']!="") && !empty($details['name'] != ''))
		{
			$where.= " AND ( 6371 * ACOS( COS( RADIANS(".$details['latitude']." ) ) * COS( RADIANS( ".DB_prefix."LATITUDE ) ) * COS( RADIANS( ".DB_prefix."LONGITUDE ) - RADIANS(".$details['longitude']."  ) ) + SIN( RADIANS(".$details['latitude']." ) ) * SIN( RADIANS( ".DB_prefix."LATITUDE ) ) ) ) <=10";
			// $where.= " AND ".DB_prefix."NAME LIKE '%".$details['name']."%'  ";
			// $where.= "OR ".DB_prefix."SORT_NAME LIKE '%".$details['name']."%'";
			$field = ",( 6371 * ACOS( COS( RADIANS(".$details['latitude']." ) ) * COS( RADIANS( ".DB_prefix."LATITUDE ) ) * COS( RADIANS( ".DB_prefix."LONGITUDE ) - RADIANS(".$details['longitude']."  ) ) + SIN( RADIANS(".$details['latitude']." ) ) * SIN( RADIANS( ".DB_prefix."LATITUDE ) ) ) ) AS distance";
			$order_by = "distance";
	    }
		else if(!empty($details['latitude']=="") && !empty($details['longitude']=="") && !empty($details['name'] != ''))
		{
			// $where.= " AND ".DB_prefix."NAME LIKE '%".$details['name']."%'";
			// $where.= " AND ".DB_prefix."SORT_NAME LIKE '%".$details['name']."%'";
			$order_by = "distance";
		}
		else if(!empty($details['latitude']!="") && !empty($details['longitude']!="") && !empty($details['name'] == ''))
		{
			$where.= " and  ( 6371 * ACOS( COS( RADIANS(".$details['latitude']." ) ) * COS( RADIANS( ".DB_prefix."LATITUDE ) ) * COS( RADIANS( ".DB_prefix."LONGITUDE ) - RADIANS(".$details['longitude']."  ) ) + SIN( RADIANS(".$details['latitude']." ) ) * SIN( RADIANS( ".DB_prefix."LATITUDE ) ) ) ) <=10 ";
			$order_by = "distance";
			//$where.= 'order by distance ASC';
		}
		else
		{
			// $where= substr($where,0,-4);
			//$where.= " order by ".DB_prefix."CHILD_CATEGORY_CODE ASC";
			// ->order_by(DB_prefix.'CHILD_CATEGORY_CODE','ASC')
		}

		if(empty($where)){
			$where = "1";
		}

		$this->db->select(DB_prefix.'CATEGORY_CODE as category_code, '.DB_prefix.'ID as id');

		//$this->db->where(DB_prefix.'CATEGORY_CODE IN ("'.implode(", ", $details['category_code']).'")');
		$temp_query = $this->db->get(DB_prefix.'nonprofits');

		$temp = $temp_query->result_array();

		$category_temp_array = $this->common($temp, $details['category_code'], 'category_code');
		if(!empty($category_temp_array)) {



		if(!empty($details['child_category_code']) AND !empty($details['sub_category_code']) AND !empty($details['category_code'])) /** CHILD CATEGORY **/
		{
			if(!empty($category_temp_array))
			{
				$this->db->select(DB_prefix.'SUB_CATEGORY_CODE as sub_category_code, '.DB_prefix.'ID as id');
				$this->db->where_in(DB_prefix.'ID',$category_temp_array);
				$temp_query = $this->db->get(DB_prefix.'nonprofits');

				$temp = $temp_query->result_array();
 
				$sub_temp_array = $this->common($temp, $details['sub_category_code'], 'sub_category_code');


				if(!empty($sub_temp_array))
				{
					$this->db->select(DB_prefix.'CHILD_CATEGORY_CODE as CHILD_CATEGORY_CODE, '.DB_prefix.'ID as id');
					$this->db->where_in(DB_prefix.'ID',$sub_temp_array);
					$temp_query = $this->db->get(DB_prefix.'nonprofits');

					$temp = $temp_query->result_array();

					$temp_array = $this->common($temp, $details['child_category_code'], 'CHILD_CATEGORY_CODE');

					if(!empty($temp_array))
					{
						$this->db->select($select_fields);
						$this->db->where($where);
						$this->db->where_in(DB_prefix.'ID',$temp_array);

						$query = $this->db->order_by($order_by,'ASC')->get(DB_prefix.'nonprofits');
						$list = $query->result_array();
					}
				}
			}
		}
		else if(!empty($details['category_code']) AND !empty($details['sub_category_code'])) /** SUB CATEGORY **/
		{
			$this->db->select(DB_prefix.'SUB_CATEGORY_CODE as sub_category_code, '.DB_prefix.'ID as id');
			$this->db->where_in(DB_prefix.'ID',$category_temp_array);
			$temp_query = $this->db->get(DB_prefix.'nonprofits');
			$temp = $temp_query->result_array();

			$sub_temp_array = $this->common($temp, $details['sub_category_code'], 'sub_category_code');

			if(!empty($sub_temp_array))
			{
				$this->db->select($select_fields);

				$this->db->where($where);
				$this->db->where_in(DB_prefix.'ID',$sub_temp_array);
				$query = $this->db->order_by($order_by,'ASC')->get(DB_prefix.'nonprofits');
				$list = $query->result_array();
			}
		}
		else if(!empty($details['category_code'])) /** SUB CATEGORY **/
		{

			$this->db->select($select_fields);
			$this->db->where_in(DB_prefix.'ID',$category_temp_array);
			$this->db->where($where);
			$query = $this->db->group_by(DB_prefix.'CATEGORY_CODE')->order_by($order_by,'ASC')->get(DB_prefix.'nonprofits');
			$list = $query->result_array();
		}
		else
		{
			$this->db->select($select_fields);
			$this->db->where($where);
			$query = $this->db->order_by($order_by,'ASC')->get(DB_prefix.'nonprofits');

			$list = $query->result_array();
		}
	}else
	{

		//echo "<pre>";print_r($where);die;
		$this->db->select($select_fields);
		$this->db->where($where);
		$query = $this->db->order_by($order_by,'ASC')->get(DB_prefix.'nonprofits');
		//->order_by(DB_prefix.'CATEGORY_CODE','ASC')
		$list = $query->result_array();
	}

		$data = $list;
		if(!empty($data))
		{
			for($i=0; $i< count($data); $i++)
			{

				$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."'");
				$like_data = $like_count->row();

				$data[$i]['like_count'] = $like_data->count;

				$country_query = $this->db->query("select ".DB_prefix."NAME as name from ".DB_prefix."countries_lists where ".DB_prefix."SORTNAME='".$data[$i]['country']."'");
				$country = $country_query->row();
				$country_name = "";
				if(!empty($data[$i]['country'])) {
					$data[$i]['country'] = $country->name;
				}


				if(!empty($details['user_id'])) {
					$like_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."charity_likes where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."' and ".DB_prefix."USER_ID = '".$details['user_id']."'");
					$like_data = $like_count->row();

					if($like_data->count>0){
						$data[$i]['liked'] = "yes";
					}
					else {
						$data[$i]['liked'] = "no";
					}

				}
				else {
					$data[$i]['liked'] = "no";
				}

				if(!empty($details['user_id'])) {
					$follow_count = $this->db->query("select count(".DB_prefix."ID) as count from ".DB_prefix."following where ".DB_prefix."CHARITY_ID='".$data[$i]['id']."' and ".DB_prefix."USER_ID = '".$details['user_id']."'");
					$follow_data = $follow_count->row();

					if($follow_data->count>0){
						$data[$i]['followed'] = "yes";
					}
					else {
						$data[$i]['followed'] = "no";
					}

				}
				else {
					$data[$i]['followed'] = "no";
				}

				// if($data[$i]['logo']!=""){
				// 	$data[$i]['logo'] = base_url().'uploads/images/'.$data[$i]['logo'];
				// }

				$logo_file_name = "nonprofits-default.png";


				if(!empty($data[$i]['logo']) AND $data[$i]['logo']!="") {
					$logo_file_name = $data[$i]['logo'];
				}
				$data[$i]['logo'] = base_url().'uploads/images/'.$logo_file_name;

				if($data[$i]['banner']!=""){
					$data[$i]['banner'] = base_url().'uploads/images/'.$data[$i]['banner'];
				}
			}
		}

		return $this->return_success_failure($data);
	}

	/** NON PROFIT SEARCH **/


	/** PAYMENT LIST **/

	public function payment_list($details)
	{
		$this->db->query('SELECT * FROM '.DB_prefix.'payments_data');

		return $this->db->result_array();
	}

	/** PAYMENT LIST **/

	/** SPLIT ID AND ASSIGN ID TO ARRAY **/

	public function common($temp, $code, $field_name)
	{
		$temp_array = [];
		foreach ($temp as $key => $value)
		{
			$id = explode(",",$value[$field_name]);
			foreach ($id as $key => $value1)
			{
				for ($i=0; $i < count($code); $i++) {
					if(strtolower($value1) == strtolower($code[$i]))
					{
						$temp_array[] = $value['id'];
					}
				}
			}
		}
		return $temp_array;
	}

	/** SPLIT ID AND ASSIGN ID TO ARRAY **/

	/** RETURN SUCCES OR FAILURE DATA **/

	public function return_success_failure($list)
	{
		return array('status'=>(!empty($list) ? 1 : 0), 'message'=>'Data '.(!empty($list) ? '' : 'not ').'found', 'data'=> (!empty($list) ? $list : ''));
	}

	/** RETURN SUCCES OR FAILURE DATA **/

	/** COMMON FUNCTION **/


	public function update_lat_lon()
	{
		$this->db->select(DB_prefix.'ID, '.DB_prefix.'ZIP, '.DB_prefix.'CITY, '.DB_prefix.'STREET');
		$zip = '00000-0000';
		$this->db->where(DB_prefix.'ZIP' , $zip);
		$this->db->where(DB_prefix.'COUNTRY_CODE' , 'CA');
		$query = $this->db->get(DB_prefix.'nonprofits');
		$data = $query->result_array();
		foreach ($data as $key => $value) {
			
				$address = $value[DB_prefix.'STREET'].','.$value[DB_prefix.'CITY'];
			/*}
			else
			{
				$address = $value[DB_prefix.'STREET'].','.$value[DB_prefix.'CITY'].','.$value[DB_prefix.'ZIP'];
			} */
			

			$address = str_replace(" ","%20",$address);
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyCXQhv_qRtIS_sgVskOOsiB-HpF8BxFm_I";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));

			$result = curl_exec($ch);

			$result = json_decode($result, 1);
            echo "<pre>"; print_r($result); echo "</pre>";
            exit;

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
						$this->db->where(DB_prefix.'ID',$value[DB_prefix.'ID']);
						$this->db->update(DB_prefix.'nonprofits',$update_data);
					}
				}
			}

		}

		return "";

	} 

	/** VELMURUGAN **/

    /* Update Device ID */
	public function device_update($details)
	{
		$notification = ($details['enable_notification'] == 1 ) ? '1' : '0';
		$this->db->select(DB_prefix.'ID as user_id');
		$this->db->where(DB_prefix.'ID', $details['user_id']);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
        if($data) {
			$update_data = array(
				DB_prefix."DEVICEID" =>  $details['device_id'],
				DB_prefix."ENABLE_NOTIFICATION" =>  $notification
			);
			$this->db->where(DB_prefix.'id',$data['user_id']);
			$this->db->update(DB_prefix.'users',$update_data);
			$newdata = array(
				              'user_id' => $details['user_id'], 
				              'enable_notification' => (int) $notification,
				              'device_id' => $details['device_id']
				          );
			$data = array('status'=>1, 'message'=>'Device ID Updated', 'data'=> $newdata);
		}
		else {
			$data = array('status'=>0, 'message'=>'Device ID is not updated', 'data'=>array());
		}
		return $data;
	}

	public function notification_list($id, $user_id,$charity_name, $amount)
	{
        $this->db->select(DB_prefix.'ID as user_id,'.DB_prefix.'DEVICEID as device_id,'.DB_prefix.'ENABLE_NOTIFICATION as enable,'.DB_prefix.'NAME as name');
		$this->db->where(DB_prefix.'ID', $user_id);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row_array();
        // echo "<pre>"; print_r($data); echo "</pre>";
        // exit;

		if($data)
		{
	
			if(!empty($data['device_id']) && $data['enable'] == 1)
			{
				$api_key = 'AAAAIQgeeYs:APA91bGY7KY0pZxjHeVw_drVfe50BagytPMp5dIRDKK-DrnofG4T-xA7WYUiygBDA5UvzkwY5L-CKTrcdEo6DwTdb6Hj5QBlssvktOFtE4FYMD8eavShFG6-wJeq74za3NLrmKWtJy9y';
				$registrationIds = $data['device_id']; 
				$message = 'Dear '.$data['name'].', Thank you for the donation to '.$charity_name.' for the sum of '.$amount.'.';
				$insert_data = array(
				                      DB_prefix.'USER_ID' => $user_id,
				                      DB_prefix.'TITLE' => 'Payment Successful',
				                      DB_prefix.'MESSAGE' => $message,
				                      DB_prefix.'CREATED_AT' => date("Y-m-d H:i:s")
			                        );
			    $this->db->insert(DB_prefix."notification", $insert_data);
                $msg = array(
                              'body'  => $message,
                              'title' => 'Payment Successful',
                           //   'icon'  => 'myicon',/*Default Icon*/
                           //   'sound' => 'mySound'/*Default sound*/
                            );
                $fields = array(
                    'to'    => $registrationIds,
                    'notification'  => $msg
                  );
   
                $headers = array(
                    'Authorization: key=' . $api_key,
                    'Content-Type: application/json'
                  );
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                curl_close( $ch );
                //echo $result;
			}
		}
	}

	public function notification($details)
	{
        $this->db->select(DB_prefix.'USER_ID as user_id,'.DB_prefix.'TITLE as title,'.DB_prefix.'MESSAGE as message,'.DB_prefix.'CREATED_AT as date');
		$this->db->where(DB_prefix.'USER_ID', $details['user_id']);
		$this->db->order_by(DB_prefix.'ID', 'DESC');
		$query = $this->db->get(DB_prefix.'notification');
		$data = $query->result();
        if($data) {
		
			$data = array('status'=>1, 'message'=>'Success', 'data'=> $data);
		}
		else {
			$data = array('status'=>1, 'message'=>'No data');
		}
		return $data;
	}


	public function getCountryState($lat, $long)
	{
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&key=AIzaSyCXQhv_qRtIS_sgVskOOsiB-HpF8BxFm_I&sensor=false';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
		$result = curl_exec($ch);
		$result = json_decode($result, 1);

		$data = [];
		if(count($result['results']) > 0) {
			foreach ($result['results'][0]['address_components'] as $key => $value1) {
				$address_type = $value1['types'][0];
				if($address_type == "country")
				{
					$data['country_code'] = $value1['short_name'];
				}
				if($address_type == "administrative_area_level_1")
				{
					$data['state_code'] = $value1['short_name'];
				
				} 
				if($address_type == "locality")
				{
					$data['city'] = $value1['short_name'];
				
				}  

		    }
		}

		return $data;
	}
}
?>
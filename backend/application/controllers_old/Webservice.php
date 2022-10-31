<?php
/* Webservice controller Created by David */
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Webservice extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Webservice_model','webservice'); // Load Webservice Model
		$this->load->model('Token_model','token'); // Load Token Model
		$this->load->helper(array('form', 'url', 'my')); // Load form and URL Helper
		$this->load->library(array('session')); // Load Session Library
		if($_POST){
			$this->Getjson = $_POST;
		}
		else {
		$this->json = file_get_contents('php://input');
		$this->Getjson = json_decode($this->json, true);
		}
	}

	/* Add or Update Webservice */
	/*public function index_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->updateWebservice($this->Getjson);
		}
		$this->set_response($result);
	}*/

	public function country_list_post()
	{
		$result = $this->webservice->countryList($this->Getjson);
		$this->set_response($result);
	}

	public function login_post()
	{
		$result = $this->webservice->login($this->Getjson);
		$this->set_response($result);
	}

	public function register_post()
	{
		$result = $this->webservice->register($this->Getjson);
		$this->set_response($result);
	}

	public function register1_post()
	{
		$result = $this->webservice->register($this->Getjson);
		$this->set_response($result);
	}

	public function social_login_post()
	{
		$result = $this->webservice->socialLogin($this->Getjson);
		$this->set_response($result);
	}

	public function update_profile_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->updateProfile($this->Getjson);
		}
		$this->set_response($result);
	}

	public function change_password_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->changePassword($this->Getjson);
		}
		$this->set_response($result);
	}

    public function transaction_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->transaction($this->Getjson);
		}
		$this->set_response($result);
	}

	public function forgot_password_post()
	{
		$result = $this->webservice->forgotPassword($this->Getjson);
		$this->set_response($result);
	}

	public function verify_otp_post()
	{
		$result = $this->webservice->verifyOTP($this->Getjson);
		$this->set_response($result);
	}

	public function update_password_post()
	{
		$result = $this->webservice->updatePassword($this->Getjson);
		$this->set_response($result);
	}

	public function categories_post()
	{
		// $result = $this->token->checkToken($this->Getjson);
		// if($result['token_status']!=0){
			$result = $this->webservice->categories($this->Getjson);
		// }
		$this->set_response($result);
	}

	public function charity_list_post()
	{
		//non_profit_search_list
		$result = $this->webservice->charityList($this->Getjson);
		//$result = $this->webservice->non_profit_search_list($this->Getjson);
		$this->set_response($result);
	}

	public function charity_like_dislike_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->charityLikeDislike($this->Getjson);
		}
		$this->set_response($result);
	}

	public function charity_following_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->charityFollowing($this->Getjson);
		}
		$this->set_response($result);
	}

	public function likes_and_followings_post()
	{
		$result = $this->token->checkToken($this->Getjson);
		if($result['token_status']!=0){
			$result = $this->webservice->likesAndFollowings($this->Getjson);
		}
		$this->set_response($result);
	}
	public function searchname_post(){
		$result = $this->webservice->searchList($this->Getjson);
		$this->set_response($result);
	}


	/** VELMURUGAN **/

	/** CATEGORY AND SUBCATEGORY LIST **/

	public function category_post()
	{
			$result = $this->webservice->category_subcategory_list($this->Getjson);
			$this->set_response($result);
	}

	/** CATEGORY AND SUBCATEGORY LIST **/

	/** NON PROFIT SERACH **/

	public function non_profit_search_post()
	{
			$result = $this->webservice->non_profit_search_list($this->Getjson);
			$this->set_response($result);
	}

	/** NON PROFIT SERACH **/



	public function update_lat_lon_post()
	{
		$result = $this->webservice->update_lat_lon($this->Getjson);
		$this->set_response($result);
	}

	/** VELMURUGAN **/

	/* Notification */
	public function device_update_post()
	{
		$result = $this->webservice->device_update($this->Getjson);
		$this->set_response($result);
	}

	public function notification_post()
	{
		$result = $this->webservice->notification($this->Getjson);
		$this->set_response($result);
	}

	public function country_search_post()
	{
		$result = $this->webservice->country_search($this->Getjson);
		$this->set_response($result);
	}

}

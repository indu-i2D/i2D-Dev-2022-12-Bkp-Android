<?php
/* Token Model Created by David */

class Token_model extends CI_Model{
    function __construct()
    {
        $this->load->database();
		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone		
    }
	
	/* Check Client Token */
	public function checkToken($details)
	{
		$this->db->select("count(".DB_prefix."ID) as count");
		$this->db->where(DB_prefix."ID", $details['user_id']);
		$this->db->where(DB_prefix."token", $details["token"]);
		$query = $this->db->get(DB_prefix.'users');
		$data = $query->row();
		if($data->count>0)
		{
			$data = array('token_status'=>1, 'token_message'=>'Valid token');
		}
		else {
			$data = array('status'=>0, 'message'=>'No Records Found', 'token_status'=>0, 'token_message'=>'Invalid token', 'data'=>array());
		}
		return $data;
	}
}
?>
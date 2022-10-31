<?php
class User_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone	
    }
    public function logincheck($username, $password)
    {				
		$query = $this->db->query("select ".DB_prefix."USER_ID, ".DB_prefix."USERNAME, ".DB_prefix."NAME from ".DB_prefix."admin_users where ".DB_prefix."USERNAME = '".$username."' and ".DB_prefix."PASSWORD = '".$password."' and ".DB_prefix."ACTIVE = 'Yes' limit 0,1");
		if($query -> num_rows() > 0)
		{
			$data = $query->row_array();
            
			$update_data = array(
				DB_prefix.'LAST_LOGIN' => date("Y-m-d H:i:s")
			);
			$this->db->where(DB_prefix.'USER_ID', $data[DB_prefix.'USER_ID']);
			$this->db->update(DB_prefix.'admin_users', $update_data);			
			return $data;
		}
		else
		{
			return false;
		}
    }
    
    public function changePassword($data)
    {
        
        $query = $this->db->query("SELECT ".DB_prefix."USER_ID FROM ".DB_prefix."admin_users WHERE ".DB_prefix."USER_ID = '".$data['user_id']."' and ".DB_prefix."PASSWORD = '".md5($data['old_password'])."'");
        $admin_data = $query->row_array();
        
        if(count($admin_data)>0){        
            $update_data = array(
                DB_prefix.'PASSWORD' => md5($data['password'])
            );
            $this->db->where(DB_prefix.'USER_ID', $data['user_id']);
            $this->db->update(DB_prefix.'admin_users', $update_data);			
            return true;
        }
        else {
            return false;
        }
    }
    
    public function getUserList()
    {				
		$query = $this->db->query("SELECT ".DB_prefix."ID as user_id, ".DB_prefix."NAME as name, ".DB_prefix."EMAIL as email, ".DB_prefix."PHONE_NUMBER as phone_number, (select c.".DB_prefix."NAME from ".DB_prefix."countries_lists c where c.".DB_prefix."SORTNAME = u.".DB_prefix."COUNTRY) as country, ".DB_prefix."STATUS as status, ".DB_prefix."GENDER as gender, ".DB_prefix."CREATED_AT as created_at, ".DB_prefix."LOGIN_TYPE as login_type, ".DB_prefix."REGISTERING_AS as user_type, ".DB_prefix."BUSINESS_NAME as business_name, ".DB_prefix."TERMS as terms from ".DB_prefix."users u");
        return $query->result_array();
    }
    
    /* Category Count */
     public function getCategoryList()
    {               
        $query = $this->db->query("SELECT * from ".DB_prefix."Category");
        return $query->result_array();
    }

     public function getPaymentList()
    {
        // $this->db->select(".DB_prefix."payments_data.*,".DB_prefix."users.".DB_prefix."NAME, ".DB_prefix."users.".DB_prefix."EMAIL);
        // //$this->db->select('firstTable.*, secondTable.*');
        // $this->db->from(".DB_prefix."payments_data);
        // $this->db->join(".DB_prefix."users, ".DB_prefix."payments_data.USER_ID = ".DB_prefix."users.ID);
        // $query = $this->db->get();        
        $query = $this->db->query("SELECT ".DB_prefix."payments_data.*,".DB_prefix."nonprofits.".DB_prefix."EIN,".DB_prefix."nonprofits.".DB_prefix."NAME AS cname from ".DB_prefix."payments_data  INNER JOIN ".DB_prefix."nonprofits  ON ".DB_prefix."payments_data.".DB_prefix."CHARITY_ID = ".DB_prefix."nonprofits.".DB_prefix."ID ORDER BY ".DB_prefix."payments_data.".DB_prefix."ID DESC");
        return $query->result_array();
    }
    
    public function getAdminUserList()
    {				
		$query = $this->db->query("SELECT ".DB_prefix."USER_ID as user_id, ".DB_prefix."NAME as name, ".DB_prefix."USERNAME as username, ".DB_prefix."ACTIVE as active, ".DB_prefix."LAST_LOGIN as last_login from ".DB_prefix."admin_users");
        return $query->result_array();
    }
    public function getUserData($data){
        $query = $this->db->query("SELECT * from ".DB_prefix."users WHERE ".DB_prefix."ID = '".$data."'");
        return $query->row_array();
    }
    public function getCountryList()
    {               
        $query = $this->db->query("SELECT * from ".DB_prefix."countries_lists");
        return $query->result_array();
    }
}
?>
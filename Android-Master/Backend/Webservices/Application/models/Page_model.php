<?php
class Page_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone	
    }
    
    public function getPageList()
    {				
		$query = $this->db->query("SELECT ".DB_prefix."ID as id, ".DB_prefix."TITLE as title, ".DB_prefix."DESCRIPTION as description,".DB_prefix."MODIFY_AT as modify_at,".DB_prefix."CREATED_AT as created_at from ".DB_prefix."pages u");
        return $query->result_array();
    }
    public function getPageData($data){
        $query = $this->db->query("SELECT * from ".DB_prefix."pages WHERE ".DB_prefix."ID = '".$data."'");
        return $query->row_array();
    }
    
}
?>
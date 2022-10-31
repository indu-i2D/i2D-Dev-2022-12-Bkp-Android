<?php
class Nonprofit_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
		date_default_timezone_set("Asia/Kolkata"); // Set Default Time Zone
    }

    public function dashboardgetNonProfitList()
    {
        $query = $this->db->query("SELECT ".DB_prefix."CHARITYID as charity_id, ".DB_prefix."NAME as name, ".DB_prefix."DESCRIPTION as description, ".DB_prefix."STREET as street, (select c.".DB_prefix."NAME from ".DB_prefix."countries_lists c where c.".DB_prefix."SORTNAME = n.".DB_prefix."COUNTRY_CODE) as country, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."INCOME_AMT as income, ".DB_prefix."SORT_NAME as sort_name, (select GROUP_CONCAT(ca.".DB_prefix."CATEGORY_NAME SEPARATOR ',')  from ".DB_prefix."Category ca WHERE FIND_IN_SET(ca.".DB_prefix."CATEGORY_CODE, n.".DB_prefix."CATEGORY_CODE)   GROUP BY n.".DB_prefix."CATEGORY_CODE) as category from ".DB_prefix."nonprofits n");
       // echo $this->db->last_query();
        //exit;
        return $query->result();
    }
    public function getNonProfitList_final($draw, $start, $length, $columnIndex, $columnName, $columnSortOrder, $searchValue)
    {
        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " and (".DB_prefix."NTEE_CD like '%".$searchValue."%' or ".DB_prefix."CHARITYID like '%".$searchValue."%' or ".DB_prefix."NAME like '%".$searchValue."%' or  ".DB_prefix."SORT_NAME like '%".$searchValue."%' or ".DB_prefix."STREET like '%".$searchValue."%' or ".DB_prefix."CITY like '%".$searchValue."%' or ".DB_prefix."ZIP like '%".$searchValue."%' or ".DB_prefix."COUNTRY_CODE like '%".$searchValue."%' or ".DB_prefix."STATE like '%".$searchValue."%') ";
        }
        ## Total number of records without filtering
        $sel = $this->db->query("SELECT * FROM ".DB_prefix."nonprofits");
        $totalRecords = $sel->num_rows();
        $sel1 =$this->db->query("SELECT * FROM ".DB_prefix."nonprofits WHERE 1 ".$searchQuery);
        $totalRecordwithFilter = $sel1->num_rows();
        $limit = " limit ".$start.", ".$length;
        $query = $this->db->query("SELECT ".DB_prefix."ID as id,".DB_prefix."NTEE_CD as code,".DB_prefix."CHARITYID as charity_id,".DB_prefix."EIN as ein, ".DB_prefix."NAME as name,".DB_prefix."SORT_NAME as sort_name,CONCAT_WS(', ',i2D_D_STREET,i2D_D_CITY, i2D_D_ZIP,i2D_D_STATE,i2D_D_COUNTRY_CODE) as address from ".DB_prefix."nonprofits n WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder."".$limit);

        $data = $query->result_array();
        $newdata = array();
        foreach($data as $k => $v)
        {
            $sdata['id'] = $v['id'];
            $sdata['code'] = $v['code'];
            $sdata['charity_id'] = $v['charity_id'];
            $sdata['ein'] = $v['ein'];
            $sdata['name'] = $v['name'];
            $sdata['sort_name'] = $v['sort_name'];
            $sdata['address'] = $v['address'];
            $sdata['url'] = '<a href="'.base_url().'nonprofit/edit/'.$v['charity_id'].'" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="'.base_url().'nonprofit/delete/'.$v['id'].'" title="Delete" class="deleteusers">Delete</a>&nbsp;||&nbsp;<a href="'.base_url().'nonprofit/view_details/'.$v['charity_id'].'" title="View">View</a>';
            $newdata[] = $sdata;
        }
        
        $response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $newdata
);
        return json_encode($response);
    }
    /* View Nonprofit Data */

    /* View Nonprofit Data */
    public function getNonProfitList_final_old()
    {
        /*$query = $this->db->query("SELECT ".DB_prefix."ID as id,".DB_prefix."NTEE_CD as code,".DB_prefix."CHARITYID as charity_id,".DB_prefix."EIN as ein, ".DB_prefix."NAME as name,".DB_prefix."STREET as street, (select c.".DB_prefix."NAME from ".DB_prefix."countries_lists c where c.".DB_prefix."SORTNAME = n.".DB_prefix."COUNTRY_CODE) as country, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."INCOME_AMT as income, ".DB_prefix."SORT_NAME as sort_name from ".DB_prefix."nonprofits n");  */


        $query = $this->db->query("SELECT ".DB_prefix."ID as id,".DB_prefix."NTEE_CD as code,".DB_prefix."CHARITYID as charity_id,".DB_prefix."EIN as ein, ".DB_prefix."NAME as name,".DB_prefix."SORT_NAME as sort_name,CONCAT_WS('',i2D_D_STREET,i2D_D_CITY, i2D_D_ZIP,i2D_D_STATE,i2D_D_COUNTRY_CODE) as address from ".DB_prefix."nonprofits n");
   

        return $query->result_array();
    }
    /* View Nonprofit Data */

    public function getNonProfitList()
    {
		$query = $this->db->query("SELECT ".DB_prefix."ID as id,".DB_prefix."NTEE_CD as code,".DB_prefix."CHARITYID as charity_id,".DB_prefix."EIN as ein, ".DB_prefix."NAME as name, ".DB_prefix."DESCRIPTION as description, ".DB_prefix."STREET as street, (select c.".DB_prefix."NAME from ".DB_prefix."countries_lists c where c.".DB_prefix."SORTNAME = n.".DB_prefix."COUNTRY_CODE) as country, ".DB_prefix."CITY as city, ".DB_prefix."STATE as state, ".DB_prefix."ZIP as zip_code, ".DB_prefix."INCOME_AMT as income, ".DB_prefix."SORT_NAME as sort_name, (select GROUP_CONCAT(ca.".DB_prefix."CATEGORY_NAME SEPARATOR ',')  from ".DB_prefix."Category ca WHERE FIND_IN_SET(ca.".DB_prefix."CATEGORY_CODE, n.".DB_prefix."CATEGORY_CODE)   GROUP BY n.".DB_prefix."CATEGORY_CODE) as category from ".DB_prefix."nonprofits n");

        return $query->result_array();
    }

    
     public function getCountryList()
    {
		$query = $this->db->query("SELECT * from ".DB_prefix."countries_lists");
        return $query->result_array();
    }

    public function newCategoryList1()
    {
        $categorytable = DB_prefix.'Category';
        $subcategorytable = DB_prefix.'NTEE_1';
        $this->db->select('*');
        $this->db->from(DB_prefix.'Category');
        $this->db->order_by(DB_prefix.'CATEGORY_CODE ASC');
        $this->db->order_by(DB_prefix.'SUB_CATEGORY_CODE ASC');
        $this->db->order_by(DB_prefix.'CHILD_CATEGORY_CODE ASC');
        $query = $this->db->get();
        //echo "<pre>"; print_r($query->result()); echo "</pre>";
        // $this->db->select('*');
        // $this->db->from(".DB_prefix."Category a);
        // $this->db->join('Category b', 'b.cat_id=a.cat_id', 'left');
        // $this->db->join('Soundtrack c', 'c.album_id=a.album_id', 'left');
        // $this->db->where('c.album_id',$id);
        // $this->db->order_by('c.track_title','asc');
        // $query = $this->db->get();
        /*$query = $this->db->query("SELECT * from ".DB_prefix."Category"); */
        return $query->result_array();
    }
     
     public function getCategoryList()
    {
		$query = $this->db->query("SELECT * from ".DB_prefix."Category");
        return $query->result_array();
    }
    public function updateCommonNonProfit($post){

        $maincategory = $post['justAnInputBox2'];
        $i2D_D_NTEE_CD =  $post['ntee_cd'];
        $strcount = strlen($i2D_D_NTEE_CD);

        $i2D_D_FOUNDATION = $post['foundation'];
        $i2D_D_CLASSIFICATION = $post['classification'];
        $i2D_D_ACTIVITY = $post['activity'];
        $act1 = sprintf('%03s', substr($i2D_D_ACTIVITY, 0, 3));
        $act2  =sprintf('%03s', substr($i2D_D_ACTIVITY, 3, 3));
        $act3 = sprintf('%03s', substr($i2D_D_ACTIVITY, 6, 3));

        $activity_check_array = array('001', '002', '003', '004', '005', '006', '007', '008', '029');
        $activity_pass1 = $this->activityData($act1, $activity_check_array);
        $activity_pass2 = $this->activityData($act2, $activity_check_array);
        $activity_pass3 = $this->activityData($act3, $activity_check_array); 
        $i2D_D_NTEE_CD =  $post['ntee_cd'];
        $strcount = strlen($i2D_D_NTEE_CD);
        $checkcategory = substr($i2D_D_NTEE_CD, 0, 1);
         if( $checkcategory != 'X' && ($activity_pass1 == 'true' && $activity_pass2 == 'true' && $activity_pass3 == 'true' && $i2D_D_FOUNDATION != '10')  && ($activity_pass1 == 'true' && $activity_pass2 == 'true' && $activity_pass3 == 'true' && $i2D_D_FOUNDATION != '10' && stristr($i2D_D_CLASSIFICATION, '7') != true ))
        {
 
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
                $subquery = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(".DB_prefix."SUB_CATEGORY_CODE) SEPARATOR ',') AS subcategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$i2D_D_CATEGORY_CODE."' AND ".DB_prefix."SUB_CATEGORY_CODE !='' GROUP BY ".DB_prefix."CATEGORY_CODE");
                $subresult = $subquery->result();
                $childquery = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(".DB_prefix."CHILD_CATEGORY_CODE) SEPARATOR ',') AS chicategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$i2D_D_CATEGORY_CODE."' AND ".DB_prefix."SUB_CATEGORY_CODE !='' AND ".DB_prefix."CHILD_CATEGORY_CODE !='' GROUP BY ".DB_prefix."CATEGORY_CODE");
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
            $maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$maincategory1."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$maincategory2."' AND ".DB_prefix."CHILD_CATEGORY_CODE = '".$newdata."'");
            if($maincategory->num_rows() == 0)
            {

                $i2D_D_CATEGORY_CODE = 'Z';
                $i2D_D_SUB_CATEGORY_CODE ='';
                $i2D_D_CHILD_CATEGORY_CODE = '';
            }
            else
            {

                $mainresult = $maincategory->row_array();
                $i2D_D_CATEGORY_CODE = $mainresult[DB_prefix."CATEGORY_CODE"];
                $i2D_D_SUB_CATEGORY_CODE = $mainresult[DB_prefix."SUB_CATEGORY_CODE"];
                $i2D_D_CHILD_CATEGORY_CODE = $mainresult[DB_prefix."CHILD_CATEGORY_CODE"];

            }


        }
        else if($strcount == 4)
        {
            $maincategory1 = substr($i2D_D_NTEE_CD, 0, 1);
            $maincategory2 = substr($i2D_D_NTEE_CD, 1, 1);
            $newdata = substr($i2D_D_NTEE_CD, 2, 2);
            $maincategory = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$maincategory1."' AND ".DB_prefix."SUB_CATEGORY_CODE = '".$maincategory2."' AND ".DB_prefix."CHILD_CATEGORY_CODE = '".$newdata."'");
            if($maincategory->num_rows() == 0)
            {

                $i2D_D_CATEGORY_CODE = 'Z';
                $i2D_D_SUB_CATEGORY_CODE ='';
                $i2D_D_CHILD_CATEGORY_CODE = '';
            }
            else
            {
                $mainresult = $maincategory->row_array();
                $i2D_D_CATEGORY_CODE = $mainresult[DB_prefix."CATEGORY_CODE"];
                $i2D_D_SUB_CATEGORY_CODE = $mainresult[DB_prefix."SUB_CATEGORY_CODE"];
                $i2D_D_CHILD_CATEGORY_CODE = $mainresult[DB_prefix."CHILD_CATEGORY_CODE"];
            }
        }
        else
        {

            $i2D_D_CATEGORY_CODE = 'Z';
            $i2D_D_SUB_CATEGORY_CODE = '';
            $i2D_D_CHILD_CATEGORY_CODE = '';
        }

        /** VELMURUGAN **/

        $config['upload_path']          = './uploads/images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);
        // if(!empty($_POST['logo_file'])){
        $logo_file_path = "";
        if ( ! $this->upload->do_upload('logo_file'))
           {

           }
           else
           {
                $data = array('upload_data' => $this->upload->data());
                $logo_file_path = $data['upload_data']['client_name'];

           }

          /** VELMURUGAN **/

         $update_data = array(
            DB_prefix.'EIN'  => $post['ein'],
            DB_prefix.'NAME'   => $post['name'],
            DB_prefix.'DESCRIPTION'    => $post['description'],
            DB_prefix.'ICO'  => $post['ico'],
            DB_prefix.'LOGO'=>$logo_file_path,  /** VELMURUGAN **/
            //DB_prefix.'LOGO'   => $i2D_D_LOGO,
            //DB_prefix.'BANNER'    => $i2D_D_BANNER,
            DB_prefix.'STREET'    => $post['street'],
            DB_prefix.'CITY'  => $post['city'],
            DB_prefix.'STATE'  => $post['state'],
            DB_prefix.'ZIP'   => $post['zip_code'],
            DB_prefix.'COUNTRY_CODE'    => "US",
            DB_prefix.'CATEGORY_CODE'  => $i2D_D_CATEGORY_CODE,
            DB_prefix.'SUB_CATEGORY_CODE'   => $i2D_D_SUB_CATEGORY_CODE,
            DB_prefix.'CHILD_CATEGORY_CODE'    => $i2D_D_CHILD_CATEGORY_CODE,
            //DB_prefix.'LATITUDE'    => $i2D_D_LATITUDE,
            //DB_prefix.'LONGITUDE'  => $i2D_D_LONGITUDE,
            DB_prefix.'GROUP'  => $post['group'],
            DB_prefix.'SUBSECTION'   => $post['sub_section'],
            DB_prefix.'AFFILIATION'    => $post['affiliation'],
            DB_prefix.'CLASSIFICATION'  => $post['classification'],
            DB_prefix.'RULING'   => $post['ruling'],
            DB_prefix.'DEDUCTIBILITY'    => $post['deductibility'],
            DB_prefix.'FOUNDATION'    => $post['foundation'],
            DB_prefix.'ACTIVITY'  => $post['activity'],
            DB_prefix.'ORGANIZATION'  => $post['organization'],
            DB_prefix.'STATUS'   => $post['status'],
            DB_prefix.'TAX_PERIOD'    => $post['tax_period'],
            // DB_prefix.'TAX_DEDUCTIBLE'    => $post['tax_exempt'],
            DB_prefix.'ASSET_CD'  => $post['asset_cd'],
            DB_prefix.'INCOME_CD'   => $post['income_cd'],
            DB_prefix.'FILING_REQ_CD'    => $post['filing_req_cd'],
            DB_prefix.'PF_FILING_REQ_CD'    => $post['pf_filing_req_cd'],
            DB_prefix.'ACCT_PD'  => $post['acct_pd'],
            DB_prefix.'ASSET_AMT'  => $post['asset_amount'],
            DB_prefix.'INCOME_AMT'  => $post['income_amount'],
            DB_prefix.'REVENUE_AMT'   => $post['revenue_amount'],
            DB_prefix.'NTEE_CD'    => $post['ntee_cd'],
            DB_prefix.'SORT_NAME'  => $post['sort_name']
           );



        $this->db->insert(DB_prefix."nonprofits", $update_data);
        $id = $this->db->insert_id();
        $charity_id = "C".sprintf('%05d', $id);
        $branch_cd = $post['state'].sprintf('%05d', $id);
        $EO_ID_FULL = $post['ein'].''.$post['state'].''.$post['zip_code'].''.$branch_cd;
        $update_data1 = array(
           DB_prefix.'CHARITYID' => $charity_id,
           DB_prefix.'ACT_CD1' => substr($post['activity'], 0, 3),
           DB_prefix.'ACT_CD2' => substr($post['activity'], 3, 3),
           DB_prefix.'ACT_CD3' => substr($post['activity'], 6, 3),
           DB_prefix.'BRANCH_CD' => $branch_cd,
           DB_prefix.'EO_ID_FULL' => $EO_ID_FULL
        );
        $this->db->where(DB_prefix.'ID', $id);
        $this->db->update(DB_prefix."nonprofits", $update_data1);

    }
    }


     


    /* public function getMultiSubCategoryList($category)
    {
        $splitnumber = '';
		$splittedNumbers = explode(",", $category);
		$numbers = "'" . implode("', '", $splittedNumbers) ."'";
        $category_query = $this->db->query("SELECT ".DB_prefix."CATEGORY_ID as category_id FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE IN (".$numbers.")");
        $category_data = $category_query->result_array();
        // echo "<pre>"; print_r($category_data); echo "</pre>";

        $where = '';
        if(count($category_data) != 0)
        {
        	foreach($category_data as $k => $v)
        	{
               $where .=$v['category_id'].',';
        	}
        }
        $where = substr($where, 0, -1);
        $splittedNumbers1 = explode(",", $where);
		$numbers1 = "'" . implode("', '", $splittedNumbers1) ."'";

		$query = $this->db->query("SELECT * from ".DB_prefix."NTEE_1 WHERE ".DB_prefix."CATEGORY_ID IN (".$numbers1.")");
        return $query->result_array();
    }

    public function getMultiChildCategoryList($category, $subcategory)
    {
        $splitnumber = '';
        $splittedNumbers = explode(",", $category);
        $numbers = "'" . implode("', '", $splittedNumbers) ."'";
        $category_query = $this->db->query("SELECT ".DB_prefix."CATEGORY_ID as category_id FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE IN (".$numbers.")");
        $category_data = $category_query->result_array();
        // echo "<pre>"; print_r($category_data); echo "</pre>";

        $where = '';
        if(count($category_data) != 0)
        {
            foreach($category_data as $k => $v)
            {
               $where .=$v['category_id'].',';
            }
        }
        $where = substr($where, 0, -1);
        $splittedNumbers1 = explode(",", $where);
        $numbers1 = "'" . implode("', '", $splittedNumbers1) ."'";


        $splitnumberss = '';
        $splittedNumberss = explode(",", $splitnumberss);
        $numberss = "'" . implode("', '", $splittedNumberss) ."'";
        $category_query1 = $this->db->query("SELECT ".DB_prefix."NTEE_1_ID as category_id FROM ".DB_prefix."NTEE_1 WHERE ".DB_prefix."NTEE_1_CODE IN (".$numberss.")");
        $category_data1 = $category_query1->result_array();
        // echo "<pre>"; print_r($category_data); echo "</pre>";

        $where1 = '';
        if(count($category_data1) != 0)
        {
            foreach($category_data1 as $k => $v)
            {
               $where1 .=$v['category_id'].',';
            }
        }
        $where1 = substr($where1, 0, -1);
        $splittedNumberss1 = explode(",", $where1);
        $numberss1 = "'" . implode("', '", $splittedNumberss1) ."'";
    	echo "<pre>"; print_r($numbers1); print_r($numberss1); echo "</pre>";
    	exit;
    }  */

    public function getNonProfitDetails($charity_id)
    {
		$query = $this->db->query("SELECT * from ".DB_prefix."nonprofits n WHERE n.".DB_prefix."CHARITYID = '".$charity_id."'");
        return $query->row_array();
    }

   
    public function getCountry($country)
    {
		$query = $this->db->query("SELECT ".DB_prefix."NAME as country from ".DB_prefix."countries_lists WHERE ".DB_prefix."SORTNAME = '".$country."'");
        return $query->row_array();
    }

    public function getMainCategory($category)
    {
        $query = $this->db->query("SELECT * from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_ID= ".$category);
        return $query->row_array();
    }


    public function getCategory($category)
    {
		$query = $this->db->query("SELECT ".DB_prefix."CATEGORY_NAME as category from ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$category."'");
        return $query->row_array();
    }


   
    
    public function updateNonProfit($post)
    {
        /** VELMURUGAN **/


        $config['upload_path']          = './uploads/images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);
        // if(!empty($_POST['logo_file'])){
        $logo_file_path = "";
        if ( ! $this->upload->do_upload('logo_file'))
           {

           }
           else
           {
                $data = array('upload_data' => $this->upload->data());
                $logo_file_path = $data['upload_data']['client_name'];

           }
       // }

       /** VELMURUGAN **/

        // echo "<pre>";print_r($post);die;
        $maincategory = $post['justAnInputBox2'];
        $i2D_D_FOUNDATION = $post['foundation'];
        $i2D_D_CLASSIFICATION = $post['classification'];
        $i2D_D_ACTIVITY = $post['activity'];
        $act1 = sprintf('%03s', substr($i2D_D_ACTIVITY, 0, 3));
        $act2  =sprintf('%03s', substr($i2D_D_ACTIVITY, 3, 3));
        $act3 = sprintf('%03s', substr($i2D_D_ACTIVITY, 6, 3));

        $activity_check_array = array('001', '002', '003', '004', '005', '006', '007', '008', '029');
        $activity_pass1 = $this->activityData($act1, $activity_check_array);
        $activity_pass2 = $this->activityData($act2, $activity_check_array);
        $activity_pass3 = $this->activityData($act3, $activity_check_array); 
        $i2D_D_NTEE_CD =  $post['ntee_cd'];
        $strcount = strlen($i2D_D_NTEE_CD);
        $checkcategory = substr($i2D_D_NTEE_CD, 0, 1);
         if( $checkcategory != 'X' && ($activity_pass1 == 'true' && $activity_pass2 == 'true' && $activity_pass3 == 'true' && $i2D_D_FOUNDATION != '10')  && ($activity_pass1 == 'true' && $activity_pass2 == 'true' && $activity_pass3 == 'true' && $i2D_D_FOUNDATION != '10' && stristr($i2D_D_CLASSIFICATION, '7') != true ))
        {
 
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
                $subquery = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(".DB_prefix."SUB_CATEGORY_CODE) SEPARATOR ',') AS subcategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$i2D_D_CATEGORY_CODE."' AND ".DB_prefix."SUB_CATEGORY_CODE !='' GROUP BY ".DB_prefix."CATEGORY_CODE");
                $subresult = $subquery->result();
                $childquery = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(".DB_prefix."CHILD_CATEGORY_CODE) SEPARATOR ',') AS chicategory_code FROM ".DB_prefix."Category WHERE ".DB_prefix."CATEGORY_CODE = '".$i2D_D_CATEGORY_CODE."' AND ".DB_prefix."SUB_CATEGORY_CODE !='' AND ".DB_prefix."CHILD_CATEGORY_CODE !='' GROUP BY ".DB_prefix."CATEGORY_CODE");
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



        $update_data = array(
			DB_prefix.'EIN'  => $post['ein'],
			DB_prefix.'NAME'   => $post['name'],
			DB_prefix.'DESCRIPTION'    => $post['description'],
			DB_prefix.'ICO'  => $post['ico'],
            //DB_prefix.'LOGO'   => $logo_file_path,
			//DB_prefix.'LOGO'   => $i2D_D_LOGO,
			//DB_prefix.'BANNER'    => $i2D_D_BANNER,
			DB_prefix.'STREET'    => $post['street'],
			DB_prefix.'CITY'  => $post['city'],
			DB_prefix.'STATE'  => $post['state'],
			DB_prefix.'ZIP'   => $post['zip_code'],
			DB_prefix.'CATEGORY_CODE'  => $i2D_D_CATEGORY_CODE,
			DB_prefix.'SUB_CATEGORY_CODE'   => $i2D_D_SUB_CATEGORY_CODE,
			DB_prefix.'CHILD_CATEGORY_CODE'    => $i2D_D_CHILD_CATEGORY_CODE,
			//DB_prefix.'LATITUDE'    => $i2D_D_LATITUDE,
			//DB_prefix.'LONGITUDE'  => $i2D_D_LONGITUDE,
			DB_prefix.'GROUP'  => $post['group'],
			DB_prefix.'SUBSECTION'   => $post['sub_section'],
			DB_prefix.'AFFILIATION'    => $post['affiliation'],
			DB_prefix.'CLASSIFICATION'  => $post['classification'],
			DB_prefix.'RULING'   => $post['ruling'],
			DB_prefix.'DEDUCTIBILITY'    => $post['deductibility'],
			DB_prefix.'FOUNDATION'    => $post['foundation'],
			DB_prefix.'ACTIVITY'  => $post['activity'],
			DB_prefix.'ORGANIZATION'  => $post['organization'],
			DB_prefix.'STATUS'   => $post['status'],
			DB_prefix.'TAX_PERIOD'    => $post['tax_period'],
			// DB_prefix.'TAX_DEDUCTIBLE'    => $post['tax_exempt'],
			DB_prefix.'ASSET_CD'  => $post['asset_cd'],
			DB_prefix.'INCOME_CD'   => $post['income_cd'],
			DB_prefix.'FILING_REQ_CD'    => $post['filing_req_cd'],
			DB_prefix.'PF_FILING_REQ_CD'    => $post['pf_filing_req_cd'],
			DB_prefix.'ACCT_PD'  => $post['acct_pd'],
			DB_prefix.'ASSET_AMT'  => $post['asset_amount'],
			DB_prefix.'INCOME_AMT'  => $post['income_amount'],
			DB_prefix.'REVENUE_AMT'   => $post['revenue_amount'],
			DB_prefix.'NTEE_CD'    => $post['ntee_cd'],
			DB_prefix.'SORT_NAME'  => $post['sort_name']
		   );
           /** VELMURUGAN **/

           if(!empty($logo_file_path))
           {
               $update_data[DB_prefix.'LOGO'] = $logo_file_path;
           }

           /** VELMURUGAN **/

		    $this->db->where(DB_prefix.'ID', $post['id']);
            $this->db->update(DB_prefix."nonprofits", $update_data);
            $branch_cd = $post['state'].sprintf('%05d', $post['id']);
            $EO_ID_FULL = $post['ein'].''.$post['state'].''.$post['zip_code'].''.$branch_cd;
            $update_data1 = array(
               DB_prefix.'ACT_CD1' => substr($post['activity'], 0, 3),
               DB_prefix.'ACT_CD2' => substr($post['activity'], 3, 3),
               DB_prefix.'ACT_CD3' => substr($post['activity'], 6, 3),
               DB_prefix.'BRANCH_CD' => $branch_cd,
               DB_prefix.'EO_ID_FULL' => $EO_ID_FULL
            );
            $this->db->where(DB_prefix.'ID', $post['id']);
            $this->db->update(DB_prefix."nonprofits", $update_data1);


        }


    }


    public function get_category()
    {
        $query = $this->db->query("SELECT * from ".DB_prefix."Category");
        return $query->result_array();
    }
    public function activityData($num, $data)
    {
        if(!in_array($num, $data))
        {
            $check = 'true';
        }
        else
        {
            $check = 'false';   
        }
        return $check;
    }
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utilities {

    function __construct()
    {
        $this->CI =& get_instance();
    }
    
	//Generates standard dropdown menu
    function get_dropdown($key, $value, $from,$extra = NULL)
	{
	   //Get CodeIgniter instances
	   //$CI =& get_instance();
       
       $data = array();

       //Qualifications
       //if($from == 'exp_cd_employees')
       //		$this->CI->db->where('is_manager','1');
       
       
       //Prepare query
       $this->CI->db->select($key.','.$value);
       $this->CI->db->where('status','active');
       $this->CI->db->order_by($value,'asc');
       
       if($extra != NULL && $from == 'exp_cd_products')
       {
       		$this->CI->db->where('is_saleable',$extra);
       }
		
       //if($extra!=NULL && $from=='exp_cd_products')
       //{
       //		$this->CI->db-where('is_saleable',$extra);
       //}
       
       //Retreive data from database
       $array_keys_values = $this->CI->db->get($from);
       
       //Creating Assosiative Array
       foreach ($array_keys_values->result() as $row)
        {
            $data[$row->$key]= $row->$value;
        }
        
        return $data;
    }
    
    //Creates a dropdown of Cities using postal code keys
    function get_postalcodes()
    {
    	$key = 'id';
    	$value = 'name';
    	
    	//Generating Querry
    	$this->CI->db->select('p.id,c.name');
    	$this->CI->db->from('exp_cd_postalcode AS p');
    	$this->CI->db->join('exp_cd_cities AS c', 'c.id = p.city_fk');
    	$this->CI->db->order_by('c.name','asc');
    	
    	$array_keys_values = $this->CI->db->get();
    	
    	//Creating Assosiative Array
       foreach ($array_keys_values->result() as $row)
        {
            $data[$row->$key]= $row->$value;
        }
        
        return $data;
    }
    
	function get_employees()
    {
    	$key = 'id';
    	$value1 = 'lname';
    	$value2 = 'fname';
    	
    	//Generating Querry
    	$this->CI->db->select('e.id,e.fname,e.lname');
    	$this->CI->db->from('exp_cd_employees AS e');
    	//$this->CI->db->join('exp_cd_cities AS c', 'c.id = p.city_fk');
    	$this->CI->db->order_by('e.lname','asc');
    	$this->CI->db->where('status','active');
    	
    	$array_keys_values = $this->CI->db->get();
    	
    	//Creating Assosiative Array
       foreach ($array_keys_values->result() as $row)
        {
            $data[$row->$key]= $row->$value1 . ' ' . $row->$value2;
        }
        
        return $data;
    }
    
	function add_blank_option($options, $blank_option = '') 
	{
	    if (is_array($options) && is_string($blank_option))
	    {
	       if (empty($blank_option))
	       {
	          $blank_option = array( NULL => '--');
	       }
	       else
	       {
	          $blank_option = array( NULL => $blank_option);
	       }
	       $options = $blank_option + $options;
	       return $options;
	    }
	    else
	    {
	       show_error("Wrong options array passed");
	    }
	}
    
	function get_order_status()
    {
    	$key = 'id';
    	$value = 'ostatus';
    	
    	//Generating Querry
    	$this->CI->db->select('id,ostatus');
    	$this->CI->db->from('exp_cd_order_status');
    	$this->CI->db->order_by('ostatus','asc');
    	
    	$array_keys_values = $this->CI->db->get();
    	
    	//Creating Assosiative Array
       foreach ($array_keys_values->result() as $row)
        {
            $data[$row->$key]= $row->$value;
        }
        
        return $data;
    }
    
	function total_active_records($table, $extra = NULL)
	{
		/*
		 * Returns the total number of active records
		 * from a given table
		 * */
		$this->CI->db->where('status','active');
		
		//Returing Orders based on Supplied OrderStatusFK in the $extra paramenter
		if(isset($extra) && $table=='exp_cd_orders')
			$this->CI->db->where('ostatus_fk', $extra);
			
		//Returing Products based on Supplied Is_Saleable in the $extra paramenter
		if(isset($extra) && $table=='exp_cd_products')
			$this->CI->db->where('is_saleable', $extra);
		//Returing Uncomplete Job Orders based on Supplied DATEOFCOMPLETION in the $extra paramenter
		if($extra == 'uncompleted' && $table=='exp_cd_job_orders')
			$this->CI->db->where('datecompleted',NULL);
			
		$this->CI->db->from($table);
		$total = $this->CI->db->count_all_results();
		
		return $total;
	}
	
	function get_boms()
    {	
    	$key = 'id';
    	$value = 'prodname';
    	
    	//Generating Querry
    	$this->CI->db->select('b.id,p.prodname');
    	$this->CI->db->from('exp_cd_bom AS b');
    	$this->CI->db->join('exp_cd_products AS p', 'p.id = b.prodname_fk');
    	$this->CI->db->order_by('p.prodname','asc');
    	$this->CI->db->where('b.status','active');
    	
    	$array_keys_values = $this->CI->db->get();
    	
    	//Creating Assosiative Array
       foreach ($array_keys_values->result() as $row)
        {
            $data[$row->$key]= $row->$value;
        }
        
        return $data;
    }
}


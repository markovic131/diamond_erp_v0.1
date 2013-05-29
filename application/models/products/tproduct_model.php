<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tproduct_model extends CI_Model {
	
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select()
	{
		//Selects and returns all records from table
		$this->db->select('id,ptname');
		$this->db->where('status !=','deleted');
		$query = $this->db->get('exp_cd_product_type');
		return $query->result();
	}
	
	function insert ($name)
	{
		
		$this->db->set('ptname',$name);
		$this->db->insert('exp_cd_product_type');
		
		return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['ptname']))
			$this->db->set('ptname',$data['ptname']);
			
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update('exp_cd_product_type');
		
		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		//Updates the status to 'deleted'
		$data['status'] = 'deleted';
		$this->db->where('id',$id);
		$this->db->update('exp_cd_product_type',$data); 
		
	}
}
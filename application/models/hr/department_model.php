<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_model extends CI_Model {
	
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select()
	{
		
		//Selects and returns all records from table
		$this->db->select('id,department');
		$this->db->where('status','active');
		$query = $this->db->get('exp_cd_departments');
		if(!$query)
			return false;
		else 
			return $query->result();
	}
	
	function insert ($name)
	{
		
		$this->db->set('department',$name);
		$this->db->insert('exp_cd_departments');
		
		return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['department']))
			$this->db->set('department',$data['department']);
			
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update('exp_cd_departments');
		
		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		//Updates the status to 'deleted'
		$data['status'] = 'deleted';
		$this->db->where('id',$id);
		$this->db->update('exp_cd_departments',$data); 
		
		return $this->db->affected_rows();
	}
}
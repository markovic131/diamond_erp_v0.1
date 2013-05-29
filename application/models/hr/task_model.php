<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Task_model extends CI_Model {
	
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		
		//Selects and returns all records from table
		$this->db->select('t.id,t.taskname,t.rate_per_unit,t.rate_per_unit_bonus,t.dateofentry,
						t.uname_fk,t.status,t.description,t.base_unit,u.uname');
		$this->db->from('exp_cd_tasks AS t');
		$this->db->join('exp_cd_uom AS u','u.id = t.uname_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
			$this->db->where('t.id',$options['id']);

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('t.status','active');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert ($data = array())
	{
		// Inserts the whole data array into the database table
		$this->db->insert('exp_cd_tasks',$data);
		
		return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['taskname']))
			$this->db->set('taskname',$data['taskname']);
		if(isset($data['uname_fk']))
			$this->db->set('uname_fk',$data['uname_fk']);
		if(isset($data['base_unit']))
			$this->db->set('base_unit',$data['base_unit']);
		if(isset($data['rate_per_unit']))
			$this->db->set('rate_per_unit',$data['rate_per_unit']);
		if(isset($data['rate_per_unit_bonus']))
			$this->db->set('rate_per_unit_bonus',$data['rate_per_unit_bonus']);
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
		if(isset($data['status']))
			$this->db->set('status',$data['status']);
			
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update('exp_cd_tasks');
		
		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		//Updates the status to 'deleted'
		$data['status'] = 'deleted';
		$this->db->where('id',$id);
		$this->db->update('exp_cd_tasks',$data);

		return $this->db->affected_rows();
		
	}
	
	function dropdown($options = array())
	{
		//Query
		$this->db->select('t.id,t.taskname,u.uname');
		$this->db->from('exp_cd_tasks AS t');
		$this->db->join('exp_cd_uom AS u','u.id = t.uname_fk','LEFT');
		$this->db->where('t.status','active');	
		
		$query = $this->db->get();
		return $query->result();
	}
	
}
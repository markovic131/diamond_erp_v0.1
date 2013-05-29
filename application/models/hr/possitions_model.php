<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Possitions_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_possitions';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		
		//Selects and returns all records from table
		$this->db->select('p.id,p.possition,p.base_salary,p.bonus * 100 bonus,p.dateofentry,
							p.requirements,d.department,p.dept_fk,p.commision * 100 commision,p.status,p.description');
		$this->db->from('exp_cd_possitions AS p');
		$this->db->join('exp_cd_departments AS d','d.id = p.dept_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
			$this->db->where('p.id',$options['id']);

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('p.status','active');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert ($data = array())
	{
		if(isset($data['bonus']))
			$data['bonus'] = $data['bonus']/100;
		if(isset($data['commision']))
			$data['commision'] = $data['commision']/100;
			
		// Inserts the whole data array into the database table
		$this->db->insert($this->table,$data);
		
		return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['possition']))
			$this->db->set('possition',$data['possition']);
		if(isset($data['dept_fk']))
			$this->db->set('dept_fk',$data['dept_fk']);
		if(isset($data['base_salary']))
			$this->db->set('base_salary',$data['base_salary']);
		if(isset($data['commision']))
			$this->db->set('commision',$data['commision']/100);
		if(isset($data['bonus']))
			$this->db->set('bonus',$data['bonus']/100);
		if(isset($data['requirements']))
			$this->db->set('requirements',$data['requirements']);
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
		if(isset($data['status']))
			$this->db->set('status',$data['status']);
		
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		//Updates the status to 'deleted'
		$data['status'] = 'deleted';
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);

		return $this->db->affected_rows();	
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Uom_model extends CI_Model {
	
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select()
	{
		
		//Selects and returns all records from table
		$this->db->select('id,uname,description');
		$this->db->where('status !=','deleted');
		$query = $this->db->get('exp_cd_uom');
		return $query->result();
	}
	
	function insert ($data = array())
	{
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
		
		
		$this->db->set('uname',$data['uname']);
		$this->db->insert('exp_cd_uom');
		
		return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['uname']))
			$this->db->set('uname',$data['uname']);
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
			
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update('exp_cd_uom');
		
		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		//Updates the status to 'deleted'
		$data['status'] = 'deleted';
		$this->db->where('id',$id);
		$this->db->update('exp_cd_uom',$data); 
		
	}	
}
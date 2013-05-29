<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Boms_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_bom';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		
		//Selects and returns all records from table
		$this->db->select('b.id,b.prodname_fk,b.quantity,b.description,b.status,b.code, 
							DATE_FORMAT(b.dateofentry,"%d/%m/%Y") as dateofentry,
							p.prodname,pc.pcname,u.uname ',FALSE);
		$this->db->from('exp_cd_bom AS b');
		$this->db->join('exp_cd_products AS p','p.id = b.prodname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('b.id',$options['id']);
			$this->db->limit(1);
		}
		
		if (isset($options['prodname_fk']))
		{
			$this->db->where('b.prodname_fk',$options['prodname_fk']);
			$this->db->limit(1);
		}

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('b.status','active');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert ($data = array())
	{			
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
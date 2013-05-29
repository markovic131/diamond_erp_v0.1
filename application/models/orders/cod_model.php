<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cod_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_order_details';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		//Selects and returns all records from table
		$this->db->select('o.id,o.order_fk,o.quantity,o.delivered_quantity,returned_quantity,
							o.prodname_fk,p.prodname,pc.pcname,u.uname');
		$this->db->from('exp_cd_order_details AS o');
		$this->db->join('exp_cd_products AS p','p.id = o.prodname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
			$this->db->where('o.order_fk',$options['id']);

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
		
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('o.status','active');
		
		if(isset($options['order_fk']) && isset($options['prodname_fk']))
		{ 
			$this->db->where_in('o.order_fk',$options['order_fk']);
			$this->db->where_in('o.prodname_fk',$options['prodname_fk']);
		}

		$query = $this->db->get();
		return $query->result();
	}
	
	function insert ($data = array())
	{		
		// Inserts the whole data array into the database table
		$this->db->insert($this->table,$data);
		
		//return $this->db->insert_id();
	}
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['quantity']))
			$this->db->set('quantity',$data['quantity']);
		
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function check_duplicate($options = array())
	{
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where_in('order_fk',$options['order_fk']);
		$this->db->where_in('prodname_fk',$options['prodname_fk']);
		$this->db->where_in('quantity !=',NULL);
		$this->db->where('status','active');
		$query = $this->db->get();
		return $query->result();
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
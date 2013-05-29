<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Co_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_orders';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array(),$limit=NULL,$offset=NULL)
	{
		
		//Selects and returns all records from table
		$this->db->select('o.id,o.partner_fk,o.distributor_fk,o.approved_by,o.ostatus_fk,
							DATE_FORMAT(o.dateofentry,"%Y-%m-%d") as dateofentry,
							o.desiredshipping,o.dateshipped,o.status,o.comments,
							p.company,e.fname,e.lname,os.ostatus',FALSE);
		$this->db->from('exp_cd_orders AS o');
		$this->db->join('exp_cd_partners AS p','p.id = o.partner_fk','LEFT');
		$this->db->join('exp_cd_employees AS e','e.id = o.distributor_fk','LEFT');
		$this->db->join('exp_cd_order_status AS os','os.id = o.ostatus_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('o.id',$options['id']);
			$this->db->limit(1);
		}
		
		//Filter Qualifications
		if(isset($options['partner_fk']) && $options['partner_fk'] != '')
			$this->db->where_in('o.partner_fk',$options['partner_fk']);
		if(isset($options['ostatus_fk']) && $options['ostatus_fk'] != '')
			$this->db->where_in('o.ostatus_fk',$options['ostatus_fk']);

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
		else
			$this->db->order_by('o.dateofentry','desc');
			
		//Pagination Limit and Offset
		$this->db->limit($limit , $offset);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('o.status','active');
		
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
		if(isset($data['partner_fk']) && $data['partner_fk'] !='')
			$this->db->set('partner_fk',$data['partner_fk']);
		if(isset($data['desiredshipping']) && $data['desiredshipping'] !='')
			$this->db->set('desiredshipping',$data['desiredshipping']);
		if(isset($data['dateshipped']))
			$this->db->set('dateshipped',$data['dateshipped']);
		if(isset($data['ostatus_fk']) && $data['ostatus_fk'] !='')
			$this->db->set('ostatus_fk',$data['ostatus_fk']);
		if(isset($data['comments']) && $data['comments'] !='')
			$this->db->set('comments',$data['comments']);

		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function set_status($data = array())
	{
		//Sets the Order Status
		$this->db->set('ostatus_fk',$data['ostatus_fk']);
		
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
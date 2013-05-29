<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inventory_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_inventory';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array(),$limit=NULL,$offset=NULL)
	{
		
		//Selects and returns all records from table
		$this->db->select('i.id,i.price,i.quantity,i.dateofexpiration,i.status,
							i.prodname_fk,i.partner_fk,i.received_by,i.comments,
							DATE_FORMAT(i.dateofentry,"%Y-%m-%d") as dateofentry,i.dateoforder,i.dateofexpiration,
							p.prodname,pc.pcname,u.uname,t.company,p.code,e.fname,e.lname
						',FALSE);
		$this->db->from('exp_cd_inventory AS i');
		$this->db->join('exp_cd_products AS p','p.id = i.prodname_fk','LEFT');
		$this->db->join('exp_cd_partners AS t','t.id = i.partner_fk','LEFT');
		$this->db->join('exp_cd_employees AS e','e.id = i.received_by','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');

		
		//Filter Qualifications
		if(isset($options['prodname_fk']) && $options['prodname_fk'] != '')
			$this->db->where_in('i.prodname_fk',$options['prodname_fk']);
		if(isset($options['partner_fk']) && $options['partner_fk'] != '')
			$this->db->where_in('i.partner_fk',$options['partner_fk']);
		if(isset($options['pcname_fk']) && $options['pcname_fk'] != '')
			$this->db->where_in('p.pcname_fk',$options['pcname_fk']);
			
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('i.id',$options['id']);
			$this->db->limit(1);
		}
		
		//Sort and Direction
		if (!isset($options['sory_by']) && !isset($options['sort_direction']))
			$this->db->order_by('i.dateofentry','desc');
		else
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
			
		//Pagination Limit and Offset
		$this->db->limit($limit , $offset);
		
		//Retreives only the RECEIVED GOODS records, unless otherwise set	
		if(!isset($options['is_use'])) 
			$this->db->where('i.is_use',0);
			
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('i.status','active');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function levels()
	{
		$data = array();
		//Selects and returns all records from table
		$this->db->select('i.id,p.prodname,pc.pcname,u.uname,p.alert_quantity');
		
		$this->db->select_sum('i.quantity');
		$this->db->select_max('i.dateofentry');
		$this->db->select_avg('i.price');
		$this->db->select_max('i.price','maxprice');
		$this->db->from('exp_cd_inventory AS i');
		$this->db->join('exp_cd_products AS p','p.id = i.prodname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');
		$this->db->group_by('i.prodname_fk');
		$this->db->order_by('p.pcname_fk','desc');
		
		//Retreives only the Goods stored into the inventory
		$this->db->where('i.status','active');
		
		//Retreives only the ACTIVE records, unless otherwise set	
		$this->db->where('i.status','active');
		
		//Retreives onyl ACTIVE products
		$this->db->where('p.status','active');

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
		if(isset($data['prodname_fk']))
			$this->db->set('prodname_fk',$data['prodname_fk']);
		if(isset($data['quantity']))
			$this->db->set('quantity',$data['quantity']);
		if(isset($data['partner_fk']))
			$this->db->set('partner_fk',$data['partner_fk']);
		if(isset($data['dateofexpiration']))
			$this->db->set('dateofexpiration',$data['dateofexpiration']);
		if(isset($data['dateoforder']))
			$this->db->set('dateoforder',$data['dateoforder']);
		if(isset($data['price']))
			$this->db->set('price',$data['price']);
		if(isset($data['comments']))
			$this->db->set('comments',$data['comments']);
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
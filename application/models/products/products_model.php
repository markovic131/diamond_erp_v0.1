<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_products';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		//Query
		$this->db->select('p.id,p.prodname,p.base_unit,p.retail_price,p.alert_quantity, p.description,p.code,p.dateofentry,
						   p.ptname_fk,p.pcname_fk,p.wname_fk,p.uname_fk, p.commision, p.is_saleable, p.status,
						   u.uname,pc.pcname,pt.ptname,w.wname');
		$this->db->from('exp_cd_products AS p');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_product_type AS pt','pt.id = p.ptname_fk','LEFT');
		$this->db->join('exp_cd_warehouses AS w','w.id = p.wname_fk','LEFT');
		
		//Filter Qualifications
		if(isset($options['ptname_fk']) && $options['ptname_fk'] != '')
			$this->db->where_in('p.ptname_fk',$options['ptname_fk']);
		if(isset($options['wname_fk']) && $options['wname_fk'] != '')
			$this->db->where_in('p.wname_fk',$options['wname_fk']);
		if(isset($options['pcname_fk']) && $options['pcname_fk'] != '')
			$this->db->where_in('p.pcname_fk',$options['pcname_fk']);
		
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('p.id',$options['id']);
			$this->db->limit(1);
		}

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
		// Inserts the whole data array into the database table
		$this->db->insert($this->table,$data);
		
		return $this->db->insert_id();
	}
	
	function update ($data = array())
	{	

		//Qualifications
		if(isset($data['prodname']))
			$this->db->set('prodname',$data['prodname']);
		if(isset($data['code']))
			$this->db->set('code',$data['code']);
		if(isset($data['base_unit']))
			$this->db->set('base_unit',$data['base_unit']);
		if(isset($data['retail_price']))
			$this->db->set('retail_price',$data['retail_price']);
		if(isset($data['alert_quantity']))
			$this->db->set('alert_quantity',$data['alert_quantity']);
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
		if(isset($data['commision']))
			$this->db->set('commision',$data['commision']);
		if(isset($data['ptname_fk']))
			$this->db->set('ptname_fk',$data['ptname_fk']);
		if(isset($data['pcname_fk']))
			$this->db->set('pcname_fk',$data['pcname_fk']);
		if(isset($data['uname_fk']))
			$this->db->set('uname_fk',$data['uname_fk']);
		if(isset($data['wname_fk']))
			$this->db->set('wname_fk',$data['wname_fk']);
		if(isset($data['is_saleable']))
			$this->db->set('is_saleable',$data['is_saleable']);
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
	
	function get_products($saleable)
	{
		if($saleable == 'yes')
			$saleable = 1;
		else
			$saleable = 0;
			
		//Query
		$this->db->select('p.id,p.prodname,p.code,u.uname,pc.pcname');
		$this->db->from('exp_cd_products AS p');
		$this->db->join('exp_cd_uom AS u','u.id = p.uname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->where('p.status','active');	
		
		$this->db->where('p.is_saleable',$saleable);

		$query = $this->db->get();
		return $query->result();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partners_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_partners';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array())
	{
		
		//Selects and returns all records from table
		$this->db->select('p.id,p.company,p.code,p.contperson,p.phone1,p.status,
							p.partner_type_fk,p.ugroup_fk,p.postalcode_fk,
							p.mobile,p.address,p.phone2,p.fax,p.email,
							p.bank,p.account_no,p.tax_no,p.dateofentry,
							p.username,p.web,
							pt.ptype,u.ugroup,c.name,pc.postalcode');
		$this->db->from('exp_cd_partners AS p');
		$this->db->join('exp_cd_partner_type AS pt','pt.id = p.partner_type_fk','LEFT');
		$this->db->join('exp_cd_user_groups AS u','u.id = p.ugroup_fk','LEFT');
		$this->db->join('exp_cd_postalcode AS pc','pc.id = p.postalcode_fk','LEFT');
		$this->db->join('exp_cd_cities AS c','c.id = pc.city_fk','LEFT');
		
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('p.id',$options['id']);
			$this->db->limit(1);
		}
			
		if (isset($options['partner_type_fk']))
			$this->db->where('p.partner_type_fk',$options['partner_type_fk']);

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
	
	function update($data = array())
	{
		//Qualifications
		if(isset($data['company']))
			$this->db->set('company',$data['company']);
		if(isset($data['contperson']))
			$this->db->set('contperson',$data['contperson']);
		if(isset($data['phone1']))
			$this->db->set('phone1',$data['phone1']);
		if(isset($data['phone2']))
			$this->db->set('phone2',$data['phone2']);
		if(isset($data['mobile']))
			$this->db->set('mobile',$data['mobile']);
		if(isset($data['address']))
			$this->db->set('address',$data['address']);
		if(isset($data['fax']))
			$this->db->set('fax',$data['fax']);
		if(isset($data['email']))
			$this->db->set('email',$data['email']);
		if(isset($data['bank']))
			$this->db->set('bank',$data['bank']);
		if(isset($data['account_no']))
			$this->db->set('account_no',$data['account_no']);
		if(isset($data['tax_no']))
			$this->db->set('tax_no',$data['tax_no']);
		if(isset($data['username']))
			$this->db->set('username',$data['username']);
		if(isset($data['password']))
			$this->db->set('password',$data['password']);
		if(isset($data['web']))
			$this->db->set('web',$data['web']);
		if(isset($data['postalcode_fk']))
			$this->db->set('postalcode_fk',$data['postalcode_fk']);
		if(isset($data['partner_type_fk']))
			$this->db->set('partner_type_fk',$data['partner_type_fk']);
		if(isset($data['ugroup_fk']))
			$this->db->set('ugroup_fk',$data['ugroup_fk']);
		if(isset($data['status']))
			$this->db->set('status',$data['status']);
		if(isset($data['code']))
			$this->db->set('code',$data['code']);
		if(isset($data['password']))
			$this->db->set('password',$data['password']);
			
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Employees_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_employees';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array(),$limit=NULL,$offset=NULL)
	{
		//Selects and returns all records from table
		$this->db->select('e.id,e.fname,e.lname,e.comp_mobile,e.code,e.email,e.status,e.dateofbirth,
							e.ssn,e.gender,e.mstatus,e.address,e.postcode_fk,e.mobile,e.phone,e.bank,
							e.account_no,e.poss_fk,e.manager_fk,e.ugroup_fk,e.username,e.hire_date,
							e.note,p.possition,u.ugroup,c.name,pc.postalcode,d.department');
		$this->db->from('exp_cd_employees AS e');
		$this->db->join('exp_cd_possitions AS p','p.id = e.poss_fk','LEFT');
		$this->db->join('exp_cd_departments AS d','d.id = p.dept_fk','LEFT');
		$this->db->join('exp_cd_user_groups AS u','u.id = e.ugroup_fk','LEFT');
		$this->db->join('exp_cd_postalcode AS pc','pc.id = e.postcode_fk','LEFT');
		$this->db->join('exp_cd_cities AS c','c.id = pc.city_fk','LEFT');
		
		//Filter Qualifications
		if(isset($options['poss_fk']) && $options['poss_fk'] != '')
			$this->db->where_in('e.poss_fk',$options['poss_fk']);
		if(isset($options['ugroup_fk']) && $options['ugroup_fk'] != '')
			$this->db->where_in('e.ugroup_fk',$options['ugroup_fk']);

		
		//Qualifications
		if (isset($options['id']))
		{
			$this->db->where('e.id',$options['id']);
			$this->db->limit(1);
		}

		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
			
		//Pagination Limit and Offset
		$this->db->limit($limit , $offset);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(!isset($options['status'])) 
			$this->db->where('e.status','active');
		
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
		if(isset($data['fname']))
			$this->db->set('fname',$data['fname']);
		if(isset($data['lname']))
			$this->db->set('lname',$data['lname']);
		if(isset($data['code']))
			$this->db->set('code',$data['code']);
		if(isset($data['email']))
			$this->db->set('email',$data['email']);
		if(isset($data['dateofbirth']))
			$this->db->set('dateofbirth',$data['dateofbirth']);
		if(isset($data['ssn']))
			$this->db->set('ssn',$data['ssn']);
		if(isset($data['gender']))
			$this->db->set('gender',$data['gender']);
		if(isset($data['mstatus']))
			$this->db->set('mstatus',$data['mstatus']);
		if(isset($data['address']))
			$this->db->set('address',$data['address']);	
		if(isset($data['postcode_fk']))
			$this->db->set('postcode_fk',$data['postcode_fk']);
		if(isset($data['mobile']))
			$this->db->set('mobile',$data['mobile']);	
		if(isset($data['comp_mobile']))
			$this->db->set('comp_mobile',$data['comp_mobile']);	
		if(isset($data['phone']))
			$this->db->set('phone',$data['phone']);
		if(isset($data['bank']))
			$this->db->set('bank',$data['bank']);
		if(isset($data['account_no']))
			$this->db->set('account_no',$data['account_no']);	
		if(isset($data['poss_fk']))
			$this->db->set('poss_fk',$data['poss_fk']);
		if(isset($data['manager_fk']))
			$this->db->set('manager_fk',$data['manager_fk']);
		if(isset($data['ugroup_fk']))
			$this->db->set('ugroup_fk',$data['ugroup_fk']);
		if(isset($data['username']))
			$this->db->set('username',$data['username']);
		if(isset($data['password']))
			$this->db->set('password',$data['password']);
		if(isset($data['note']))
			$this->db->set('note',$data['note']);
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
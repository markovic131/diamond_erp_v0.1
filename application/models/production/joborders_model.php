<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Joborders_model extends CI_Model {
	
	//Database table of the Model
	var $table = 'exp_cd_job_orders';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function select($options = array(),$limit=NULL,$offset=NULL)
	{
		
		//Selects and returns all records from table
		$this->db->select('j.id,j.prodname_fk,j.assigned_quantity,j.final_quantity,j.defect_quantity,j.shift,
						   j.description,j.status,j.task_fk,j.assigned_by,j.assigned_to,j.is_completed,j.jstatus_fk,
						   j.datedue,j.datecompleted,DATE_FORMAT(j.dateofentry,"%Y-%m-%d") as dateofentry,
						   p.prodname,p.code,pc.pcname,t.taskname,e.fname,e.lname,u.uname,p.uname_fk,t.taskname,
						   js.jstatus',FALSE);
		$this->db->from('exp_cd_job_orders AS j');
		$this->db->join('exp_cd_products AS p','p.id = j.prodname_fk','LEFT');
		$this->db->join('exp_cd_product_category AS pc','pc.id = p.pcname_fk','LEFT');
		$this->db->join('exp_cd_tasks AS t','t.id = j.task_fk','LEFT');
		$this->db->join('exp_cd_employees AS e','e.id = j.assigned_to','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = t.uname_fk','LEFT');
		$this->db->join('exp_cd_job_order_status AS js','js.id = j.jstatus_fk','LEFT');
		
		//Single records qualification
		if (isset($options['id']))
		{
			$this->db->where('j.id',$options['id']);
			$this->db->limit(1);
		}
		
		//Filter Qualifications
		if(isset($options['task_fk']) && $options['task_fk'] != '')
			$this->db->where_in('j.task_fk',$options['task_fk']);
		if(isset($options['prodname_fk']) && $options['prodname_fk'] != '')
			$this->db->where_in('j.prodname_fk',$options['prodname_fk']);
		if(isset($options['assigned_to']) && $options['assigned_to'] != '')
			$this->db->where_in('j.assigned_to',$options['assigned_to']);
		if(isset($options['jstatus_fk']) && $options['jstatus_fk'] != '')
			$this->db->where_in('j.jstatus_fk',$options['jstatus_fk']);
			
		//Sort
		if (isset($options['sory_by']) && isset($options['sort_direction']))
			$this->db->order_by($options['sort_by'],$options['sort_direction']);
		else
			$this->db->order_by('j.dateofentry','desc');
		
		//Pagination Limit and Offset
		$this->db->limit($limit , $offset);
			
		//Retreives only the ACTIVE records, unless otherwise set	
		if(isset($options['status']) && $options['status'] != '') 
			$this->db->where('j.status',$options['status']);
		else 
			$this->db->where('j.status','active');
		
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
		if(isset($data['assigned_to']) && ($data['assigned_to'])!='')
			$this->db->set('assigned_to',$data['assigned_to']);
		if(isset($data['shift']) && ($data['shift'])!='')
			$this->db->set('shift',$data['shift']);
		if(isset($data['prodname_fk']) && ($data['prodname_fk'])!='')
			$this->db->set('prodname_fk',$data['prodname_fk']);
		if(isset($data['task_fk']) && ($data['task_fk'])!='')
			$this->db->set('task_fk',$data['task_fk']);
		if(isset($data['assigned_quantity']) && ($data['assigned_quantity'])!='')
			$this->db->set('assigned_quantity',$data['assigned_quantity']);
		if(isset($data['datedue']) && ($data['datedue'])!='')
			$this->db->set('datedue',$data['datedue']);
		if(isset($data['datecompleted']) && ($data['datecompleted'])!='')
			$this->db->set('datecompleted',$data['datecompleted']);
		if(isset($data['description']))
			$this->db->set('description',$data['description']);
		if(isset($data['status']))
			$this->db->set('status',$data['status']);
		if(isset($data['final_quantity']) && ($data['final_quantity'])!='')
			$this->db->set('final_quantity',$data['final_quantity']);
		if(isset($data['defect_quantity']) && ($data['defect_quantity'])!='')
			$this->db->set('defect_quantity',$data['defect_quantity']);
		if(isset($data['is_completed']) && ($data['is_completed'])!='')
			$this->db->set('is_completed',$data['is_completed']);
		if(isset($data['jstatus_fk']) && ($data['jstatus_fk'])!='')
			$this->db->set('jstatus_fk',$data['jstatus_fk']);
		
		//This ID
		$this->db->where('id',$data['id']);
		
		//Updating
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function set_status($data = array())
	{
		//Sets the Order Status
		$this->db->set('jstatus_fk',$data['jstatus_fk']);
		
		//Sets the field IS_COMPLETED
		if($data['jstatus_fk'] == 1)
		{
			$this->db->set('is_completed',1);
			$this->db->set('datecompleted',mdate('%Y-%m-%d'));
		}
		else
		{
			$this->db->set('is_completed',0);
			$this->db->set('datecompleted',NULL);
		}
		
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
	
	function payroll($options=array())
	{
		$this->db->select('jo.id,jo.final_quantity,
							jo.assigned_to,
							,t.taskname,t.rate_per_unit,e.fname,e.lname,
							u.uname
							');
		
		$this->db->select_sum('jo.final_quantity');
		
		$this->db->from('exp_cd_job_orders as jo');
		$this->db->join('exp_cd_tasks AS t','t.id = jo.task_fk','LEFT');
		$this->db->join('exp_cd_employees AS e','e.id = jo.assigned_to','LEFT');
		$this->db->join('exp_cd_uom AS u','u.id = t.uname_fk','LEFT');
		
		$this->db->where('jo.assigned_to',$options['assigned_to']);
		$this->db->where('jo.dateofentry >=',$options['datefrom']);
		$this->db->where('jo.dateofentry <=',$options['dateto']);
		$this->db->where('jo.status','active');
		$this->db->where('jo.is_completed',1);
		
		$this->db->group_by('jo.assigned_to');
		$this->db->group_by('jo.task_fk');
		
		$query = $this->db->get();
		return $query->result();
	}
	
}
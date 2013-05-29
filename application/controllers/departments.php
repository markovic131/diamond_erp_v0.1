<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('hr/Department_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Departments';
		
		//Heading
		$data['heading'] = 'Departments';
		
		//View
		$data['content']= 'hr/department_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
    
	function insert()
	{
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('department','department name','trim|required');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			//Successful validation
			$success = $this->Department_model->insert($this->input->post('department'));
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added');
                redirect('departments');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('departments');
			}	
		}
		echo json_encode($data);			
	}
	
	function edit()
	{
		$name = $_POST['department'];
	
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('department','product category name','trim|required');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['department'] = $name;
					
			//Successful validation
			$success = $this->Department_model->update($data);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly updated');
				redirect('departments');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('departments');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		if($success = $this->Department_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted');
			redirect('departments');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('departments');
		}	
	}
	
	function grid()
	{
		$var['grid'] = $this->Department_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->department);
	            $i++;
             }  
             
      	//header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
}
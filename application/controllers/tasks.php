<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('hr/Task_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Tasks';
		
		//Heading
		$data['heading'] = 'Tasks';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'hr/tasks_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
		
		//Retreive data from Model
		$data['results'] = $this->Task_model->select();
		
		//Display
		$this->load->view('template',$data);
		
	}
    
	function insert()
	{
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('taskname','task name','trim|required');
		$this->form_validation->set_rules('rate_per_unit','unit rate','trim|required|numeric');
		$this->form_validation->set_rules('rate_per_unit_bonus','unit rate bonus','trim|numeric');
		$this->form_validation->set_rules('base_unit','base unit','trim|required|numeric');
		$this->form_validation->set_rules('uname_fk','UOM','trim|required|numeric');
		$this->form_validation->set_rules('description','description','trim|xss_clean');
		
		///Check if form has been submited
		if ($this->form_validation->run())
		{
			//Successful validation
			$success = $this->Task_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('tasks');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('tasks');
			}	
		}	
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['uoms'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'uname','exp_cd_uom'));
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Task';
		
		//Heading
		$data['heading'] = 'Create New Task';
		
		//View
		$data['content']= 'hr/new_task_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
    
	function edit()
	{
		$id = $this->uri->segment(3,0);
		//Retreives ONE product from the database
		$data['task'] = $this->Task_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		if(!$data['task']) redirect('tasks');
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST ubmit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			$this->load->library('form_validation');
	
			//Defining Validation Rules
			$this->form_validation->set_rules('taskname','task name','trim|required');
			$this->form_validation->set_rules('rate_per_unit','unit rate','trim|required|numeric');
			$this->form_validation->set_rules('rate_per_unit_bonus','unit rate bonus','trim|numeric');
			$this->form_validation->set_rules('base_unit','base unit','trim|required|numeric');
			$this->form_validation->set_rules('description','description','trim|xss_clean');
				
			if ($this->form_validation->run())
				{
					//Adds what Id to be updated
					$_POST['id'] = $id;
					//Successful validation
					$success = $this->Task_model->update($_POST);
					
					if($success)
					{
						$this->session->set_flashdata('flash','Record successfuly updated!');
						redirect('tasks');
					}
					else
					{
						$this->session->set_flashdata('flash','Database error');
						redirect('tasks');
					}	
				}
		}
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['uoms'] = $this->utilities->get_dropdown('id', 'uname','exp_cd_uom');
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Edit Task';
		
		//Heading
		$data['heading'] = 'Edit Task';
		
		//View
		$data['content']= 'hr/edit_task_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Task_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Tasks';
		
		//Heading
		$data['heading'] = 'Task';
		
		//View
		$data['content']= 'hr/task_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
    
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Task_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('tasks');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('tasks');
		}
	}
	
	function dropdown()
	{
		$data = $this->Task_model->dropdown();
		
		header('Content-Type: application/json',true); 
		echo json_encode($data);
	}
	
}
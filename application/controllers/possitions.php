<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Possitions extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('hr/Possitions_model');
	}
	
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Possitions';
		
		//Heading
		$data['heading'] = 'Possitions';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'hr/possitions_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
		
		//Retreive data from Model
		$data['results'] = $this->Possitions_model->select();
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		//Load formvalidation library
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('possition','possition name','trim|required');
		$this->form_validation->set_rules('dept_fk','department','required');
		$this->form_validation->set_rules('base_salary','base salary','trim|numeric');
		$this->form_validation->set_rules('bonus','bonus','trim|numeric');
		$this->form_validation->set_rules('commision','commision','trim|numeric');
		$this->form_validation->set_rules('requirements','requirements','trim');
		$this->form_validation->set_rules('description','description','trim');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			//Successful validation
			$success = $this->Possitions_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('possitions');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error.');
				redirect('possitions');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['departments'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'department','exp_cd_departments'));
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Possition';
		
		//Heading
		$data['heading'] = 'Create New Possition';
		
		//View
		$data['content']= 'hr/new_possition_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
		
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
		//Retreives ONE product from the database
		$data['possition'] = $this->Possitions_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		if(!$data['possition']) redirect('possition');
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST ubmit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Load formvalidation library
			$this->load->library('form_validation');
			
			//Defining Validation Rules
			$this->form_validation->set_rules('possition','possition name','trim|required');
			$this->form_validation->set_rules('base_salary','base salary','trim|numeric');
			$this->form_validation->set_rules('bonus','bonus','trim|numeric');
			$this->form_validation->set_rules('commision','commision','trim|numeric');
			$this->form_validation->set_rules('requirements','requirements','trim');
			$this->form_validation->set_rules('description','description','trim');
			
			//Check if form has been submited
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				//Successful validation
				$success = $this->Possitions_model->update($_POST);
				
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('possitions');
				}
				else
				{
					$this->session->set_flashdata('flash','Database error');
					redirect('possitions');
				}	
			}
		}
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['departments'] = $this->utilities->get_dropdown('id', 'department','exp_cd_departments');
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Edit Possition';
		
		//Heading
		$data['heading'] = 'Edit Possition';
		
		//View
		$data['content']= 'hr/edit_possition_view';
		
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
		$data['master'] = $this->Possitions_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Possitions';
		
		//Heading
		$data['heading'] = 'Possition';
		
		//View
		$data['content']= 'hr/possition_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}

	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Possitions_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('possitions');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('possitions');
		}	
	}
	
}
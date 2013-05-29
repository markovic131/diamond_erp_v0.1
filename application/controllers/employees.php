<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('hr/Employees_model');		
	}
	
	function index()
	{	
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Employees';
		
		//Heading
		$data['heading'] = 'Employees';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'hr/employees_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';	
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['possitions'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'possition','exp_cd_possitions'));	
		$data['ugroups'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ugroup','exp_cd_user_groups'));
		
		//Pagination
		$offset =  $this->uri->segment(3,0);
		
		$config['base_url'] = site_url('employees/index');
		$config['total_rows'] = count($this->Employees_model->select($_POST));
		$config['per_page'] = 15;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		//AA - Present the Products from the database
		$data['results'] = $this->Employees_model->select($_POST, $config['per_page'],$offset);
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		//Load Validation Library
		$this->load->library('form_validation');
		
		if(isset($_POST['password']) && trim($_POST['password'] == ''))
			unset($_POST['password']);
		
	
		//Defining Validation Rules
		$this->form_validation->set_rules('fname','first name','trim|required');
		$this->form_validation->set_rules('lname','last name','trim|required');
		$this->form_validation->set_rules('code','code','trim|max_lenth[5]|required');
		$this->form_validation->set_rules('ssn','SSN','trim|required|exact_length[13]|numeric');
		$this->form_validation->set_rules('dateofbirth','date of birth','trim|required');
		$this->form_validation->set_rules('username','username','min_length[6]|max_lenth[12]');
		$this->form_validation->set_rules('password','password','min_length[6]');
		$this->form_validation->set_rules('email','email','trim|valid_email');
		$this->form_validation->set_rules('phone','phone','trim|numeric');
		$this->form_validation->set_rules('mobile','mobile','trim|numeric');
		$this->form_validation->set_rules('comp_mobile','company mobile','trim|numeric');
		$this->form_validation->set_rules('bank','bank','trim');
		$this->form_validation->set_rules('account_no','account number','trim|numeric');
		$this->form_validation->set_rules('address','address','trim');
		$this->form_validation->set_rules('note','note','trim');
		$this->form_validation->set_rules('poss_fk','possition','trim|required');
		
		//Check if form has passed validation
		if ($this->form_validation->run())
		{
			//Hash the password
			$_POST['password'] = sha1($_POST['password']);
			
			//Successful insertion
			$success = $this->Employees_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('employees');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('employees');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['possitions'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'possition','exp_cd_possitions'));	
		$data['postalcodes'] = $this->utilities->add_blank_option($this->utilities->get_postalcodes());	
		$data['managers'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'fname','exp_cd_employees'));
		$data['ugroups'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ugroup','exp_cd_user_groups'));		
		
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Create New Employee';
		
		//Heading
		$data['heading'] = 'Create New Employee';
		
		//View
		$data['content'] = 'hr/new_employee_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
		//Retreives ONE product from the database
		$data['employee'] = $this->Employees_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		//if(!$data['employee']) redirect('employees');
		
		//Proccesses the form with the new updated data
		if(isset($_POST['submit']))
		{
			//Unsets the POST submit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//If the password has not been changed, unsets the password variable
			if(isset($_POST['password']) && $_POST['password'] == '')
				unset($_POST['password']);
			
			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('fname','first name','trim|required');
			$this->form_validation->set_rules('lname','last name','trim|required');
			$this->form_validation->set_rules('code','code','trim|max_lenth[5]');
			$this->form_validation->set_rules('ssn','SSN','trim|required|exact_length[13]|numeric');
			$this->form_validation->set_rules('dateofbirth','date of birth','trim');
			$this->form_validation->set_rules('username','username','min_length[6]|max_lenth[12]');
			$this->form_validation->set_rules('password','password','min_length[6]');
			$this->form_validation->set_rules('email','email','trim|valid_email');
			$this->form_validation->set_rules('phone','phone','trim|numeric');
			$this->form_validation->set_rules('mobile','mobile','trim|numeric');
			$this->form_validation->set_rules('comp_mobile','company mobile','trim|numeric');
			$this->form_validation->set_rules('bank','bank','trim');
			$this->form_validation->set_rules('account_no','account number','trim|numeric');
			$this->form_validation->set_rules('address','address','trim');
			$this->form_validation->set_rules('note','note','trim');
			
			
			//Check if updated form has passed validation
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				
				//Hashes the new password
				if(isset($_POST['password']))
					$_POST['password'] = sha1($_POST['password']);
				
				//If Successfull, runs Model function
				$success = $this->Employees_model->update($_POST);
				
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('employees');
				}
				else
				{
					$this->session->set_flashdata('flash','Database error');
					redirect('employees');
				}	
			}
			
		}
	
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['possitions'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'possition','exp_cd_possitions'));	
		$data['postalcodes'] = $this->utilities->add_blank_option($this->utilities->get_postalcodes());	
		$data['managers'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'fname','exp_cd_employees'));
		$data['ugroups'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ugroup','exp_cd_user_groups'));		
		
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Edit Employee';
		
		//Heading
		$data['heading'] = 'Edit Employee';
		
		//View
		$data['content'] = 'hr/edit_employee_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
		
		//Display
		$this->load->view('template', $data);
	}
	
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Employees_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Employees';
		
		//Heading
		$data['heading'] = 'Employee';
		
		//View
		$data['content']= 'hr/employee_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		if($this->Employees_model->delete($this->uri->segment(3,0)))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('employees');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('employees');
		}			
	}
	
	function payroll()
	{	
		//PayRoll Functions runs, if Submitted
		if(isset($_POST['submit']))
		{
			//Loading Models
			$this->load->model('production/Joborders_model');
			$this->load->model('hr/Task_model');
			
			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('employee','first name','trim|required');
			$this->form_validation->set_rules('datefrom','date from','trim|required');
			$this->form_validation->set_rules('dateto','date to','trim|required');
			
			
			if($this->form_validation->run())
			{
				$data['results'] = $this->Joborders_model->payroll(array(
								'assigned_to' => $_POST['employee'],
								'datefrom' => $_POST['datefrom'],
								'dateto' => $_POST['dateto']
								));
				
				$data['datefrom'] = $_POST['datefrom'];	
				$data['dateto'] = $_POST['dateto'];
				$date['submited'] = TRUE;
			}		
		}
		
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Payroll';
		
		//Heading
		$data['heading'] = 'Payroll';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'hr/payroll_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/hr_nav_view';	
		
		// Load Utility library
		$this->load->library('utilities');
		
		$data['employees'] = $this->utilities->add_blank_option($this->utilities->get_employees());
		
		//Display
		$this->load->view('template', $data);
	}
}
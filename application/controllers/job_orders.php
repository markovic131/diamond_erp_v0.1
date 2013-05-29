<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_orders extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('production/Joborders_model');
    }
	
	function index()
	{
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Job Orders';
		
		//Heading
		$data['heading'] = 'Job Orders';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/production_nav_view';
		
		//View
		$data['content']= 'production/job_orders_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['employees'] = $this->utilities->add_blank_option($this->utilities->get_employees());
		$data['tasks'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','taskname','exp_cd_tasks'));
		$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','prodname','exp_cd_products','yes'));
		$data['jostatus'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','jstatus','exp_cd_job_order_status'));
		
		//Pagination
		$offset =  $this->uri->segment(3,0);
		
		$config['base_url'] = site_url('job_orders/index');
		$config['total_rows'] = count($this->Joborders_model->select($_POST));
		$config['per_page'] = 15;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links(); 
		
		//Retreive data from Model
		$data['results'] = $this->Joborders_model->select($_POST, $config['per_page'],$offset);

		//Display
		$this->load->view('template',$data);	
			
	}

	function insert()
	{
		//Load formvalidation library
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('assigned_to','employee','trim|required');
		$this->form_validation->set_rules('assigned_by','assigned by','trim');
		$this->form_validation->set_rules('shift','shift','trim');
		$this->form_validation->set_rules('prodname_fk','product','trim');
		$this->form_validation->set_rules('task_fk','task','trim|required');
		$this->form_validation->set_rules('assigned_quantity','assigned quantity','greater_than[0]|required');
		$this->form_validation->set_rules('datedue','due date','trim|required');
		$this->form_validation->set_rules('description','description','trim');
		
		//If selected products, BOM is required as well
		//if(isset($_POST['prodname_fk']))
		//	$this->form_validation->set_rules('bom_fk','BOM','trim|required');

		//Check if form has been submited
		if ($this->form_validation->run())
		{	
			//Saves BOM_FK and unsets it from POST
			if(isset($_POST['bom_fk']))
			{
				$bom = $_POST['bom_fk'];
				unset($_POST['bom_fk']);
			}

			//Successful validation insets into the DB
			if($this->Joborders_model->insert($_POST))
			{
				if(isset($bom))	
					$this->_inventory_use($bom,$_POST['assigned_quantity']);
				
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('job_orders');
			}
			else
			{
				$this->session->set_flashdata('flash','No records affected!');
				redirect('job_orders');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['employees'] = $this->utilities->add_blank_option($this->utilities->get_employees());
		$data['boms'] = $this->utilities->add_blank_option($this->utilities->get_boms());
				
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Job Order';
		
		//Heading
		$data['heading'] = 'Create New Job Order';
		
		//View
		$data['content']= 'production/new_job_order_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/production_nav_view';
				
		//Display
		$this->load->view('template',$data);
		
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
		//Retreives ONE product from the database
		$data['job_order'] = $this->Joborders_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		if(!$data['job_order']) redirect('job_orders');
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST ubmit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Checks if the fields are set, and are empty. Then, sets them to NULL
			//if(isset($_POST['datedue']) && $_POST['datedue'] == '')
			//	$_POST['datedue'] = NULL;
	
			//Load formvalidation library
			$this->load->library('form_validation');
			
			//Defining Validation Rules
			$this->form_validation->set_rules('assigned_to','employee','trim|required');
			$this->form_validation->set_rules('shift','shift','trim');
			$this->form_validation->set_rules('prodname_fk','product','trim');
			$this->form_validation->set_rules('task_fk','task','trim|required');
			$this->form_validation->set_rules('assigned_quantity','assigned quantity','greater_than[0]|required');
			$this->form_validation->set_rules('datedue','due date','trim|required');
			$this->form_validation->set_rules('description','description','trim');
			
			//Check if form has been submited
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				//Successful validation
				$success = $this->Joborders_model->update($_POST);
				
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('job_orders');
				}
				else
				{
					$this->session->set_flashdata('flash','No records affected!');
					redirect('job_orders');
				}	
			}
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['employees'] = $this->utilities->add_blank_option($this->utilities->get_employees());
		//$data['tasks'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','taskname','exp_cd_tasks'));
		$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','prodname','exp_cd_products','yes'));
		$data['jstatus'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','jstatus','exp_cd_job_order_status'));
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Edit Job Order';
		
		//Heading
		$data['heading'] = 'Edit Job Order';
		
		//View
		$data['content']= 'production/edit_job_order_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/production_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	//AJAX - Changes the Job Order status
	function set_status()
	{
		$data['id'] = json_decode($_POST['id']);
		$data['jstatus_fk'] = json_decode($_POST['jstatus_fk']);
		
		if($this->Joborders_model->set_status($data))
		{
			echo json_encode(array('success'=>TRUE,'message'=>'Status successfuly updated!'));
			exit;
		}
		else
		{
			echo json_encode(array('success'=>FALSE,'message'=>'Error while updating!'));
			exit;
		}
	}
	
	//AJAX - Edits the Final Qty of a Job Order
	function edit_final_qty()
	{
		$data['id'] = json_decode($_POST['id']);
		$data['final_quantity'] = json_decode($_POST['final_quantity']);
		$data['datecompleted'] = mdate('%Y-%m-%d');
		$data['is_completed'] = 1;
		$data['jstatus_fk'] = 1;
		
		if($this->Joborders_model->update($data))
		{
			echo json_encode($data['final_quantity']);
			exit;
		}
		else
		{
			echo json_encode('Error while updating!');
			exit;
		}
		
	}
	
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Joborders_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Job Orders';
		
		//Heading
		$data['heading'] = 'Job Order';
		
		//View
		$data['content']= 'production/job_order_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/production_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Joborders_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('job_orders');
		}
		else
		{
			$this->session->set_flashdata('flash','No records affected!');
			redirect('job_orders');
		}
	}
	
	function _inventory_use($bom,$quantity)
	{
		//Loading Models
		$this->load->model('production/Bomdetails_model');
		$this->load->model('procurement/Inventory_model');

		if($bom)
		{
			$bom_components = $this->Bomdetails_model->select(array('id'=>$bom));
								
			foreach ($bom_components as $component)
			{
				$options = array(
					'prodname_fk'=>$component->prodname_fk,
					'quantity' => (($component->quantity*$quantity)*-1),
					'status' => 'active',
					'received_by' => $this->session->userdata('userid'),
					'is_use' => 1
				);			
				$this->Inventory_model->insert($options);
			}
		}
				
	
	}	
	

}
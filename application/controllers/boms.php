<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Boms extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('production/Boms_model');
		$this->load->model('production/Bomdetails_model');
	}
	
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Bill of Materials';
		
		//Heading
		$data['heading'] = 'Bill of Materials';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'production/boms_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/master_nav_view';
		
		//Retreive data from Model
		$data['results'] = $this->Boms_model->select();
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		//Load formvalidation library
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('prodname_fk','product','trim|required');
		$this->form_validation->set_rules('quantity','quantity','trim|required');
		$this->form_validation->set_rules('description','description','trim');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			//Inserts Master details
			$master = array('prodname_fk'=>$_POST['prodname_fk'],
						  'quantity'=>$_POST['quantity']);
			$bom_fk = $this->Boms_model->insert($master);
			
			if($bom_fk)
			{
				//Decode the JSON object int Ass.array and loop through detail records
				foreach (json_decode($_POST['components'],TRUE) as $detail)
				{
					//Inserts all Detail records into the database
					$this->Bomdetails_model->insert(array(
							'bom_fk'=>$bom_fk,
							'prodname_fk'=>$detail['id'],
							'quantity'=>$detail['quantity']));	
				}
				$this->session->set_flashdata('flash','Record successfuly added');
				echo json_encode(array('success'=>TRUE));
				exit;
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				echo json_encode(array('success'=>FALSE));
				exit;	
			}	
		}
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Bill of Materials';
		
		//Heading
		$data['heading'] = 'Create New Bill of Materials';
		
		//View
		$data['content']= 'production/new_bom_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);	
	}
	
	function edit()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Boms_model->select($options);
		
		//If there is nothing, redirects
		if(!$data['master']) redirect('boms');

		//Retreives data from DETAIL Model
		$data['details'] = $this->Bomdetails_model->select($options);
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST submit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('prodname_fk','product','trim|required');
			$this->form_validation->set_rules('quantity','quantity','trim|required');
			$this->form_validation->set_rules('description','description','trim');
			
			
			//Check if updated form has passed validation
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $options['id'];
				//If Successfull, runs Model function
				$success = $this->Boms_model->update($_POST);
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('orders');
				}
				else
				{
					$this->session->set_flashdata('flash','No records affected!');
					redirect('orders');
				}	
			}
			
		}
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . " - Bill of Materials";
		
		//Heading
		$data['heading'] = "Edit Bill of Materials";
		
		//View
		$data['content']= 'production/edit_bom_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['partners'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		$data['order_status'] = $this->utilities->add_blank_option($this->utilities->get_order_status());
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
				
		//Display
		$this->load->view('template',$data);
		
		
	}
	
	//AJAX - Removes Products from a Bom
	function remove_product()
	{
		if($this->Bomdetails_model->delete(json_decode($_POST['id'])))
		{
			echo json_encode(array('success'=>TRUE,'message'=>'Component successfuly removed!'));
			exit;
		}
		else
		{
			echo json_encode(array('success'=>FALSE,'message'=>'Error while removing!'));
			exit;
		}
		
	}
	
	//AJAX - Edits the Quantity of Products from a Bom
	function edit_qty()
	{
		$data['id'] = json_decode($_POST['id']);
		$data['quantity'] = json_decode($_POST['quantity']);
		
		if($this->Bomdetails_model->update($data))
		{
			echo json_encode($data['quantity']);
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
		$data['master'] = $this->Boms_model->select($options);

		//Retreives data from DETAIL Model
		$data['details'] = $this->Bomdetails_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Bill of Materials';
		
		//Heading
		$data['heading'] = 'Bill of Materials';
		
		//View
		$data['content']= 'production/bom_view';
		
		//Module Navigation
		$data['modnav'] ='includes/modnav/master_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Boms_model->delete($id))
		{
			//$this->session->set_flashdata('flash','Record successfuly deleted');
			redirect('boms');
		}
		else
		{
			//$this->session->set_flashdata('flash','No records affected!');
			redirect('boms');
		}
	}
	
}
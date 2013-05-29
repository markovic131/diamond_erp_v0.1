<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('procurement/Inventory_model');
        
    }
	
	function index()
	{	
        //Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Inventory Levels';
		
		//Heading
		$data['heading'] = 'Inventory Levels';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'procurement/inventory_levels_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/procurement_nav_view';
		
		//Retreive data from Model
		$data['results'] = $this->Inventory_model->levels();
		
		//Display
		$this->load->view('template',$data);
	}
	
	function goods_receipts()
	{
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Goods Receipts';
		
		//Heading
		$data['heading'] = 'Goods Receipts';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'procurement/goods_receipts_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/procurement_nav_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id','prodname','exp_cd_products','no'));
		$data['vendors'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		$data['categories'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'pcname','exp_cd_product_category'));
		
		//Pagination
		$offset =  $this->uri->segment(3,0);
		
		$config['base_url'] = site_url('inventory/goods_receipts');
		$config['total_rows'] = count($this->Inventory_model->select($_POST));
		$config['per_page'] = 15;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links(); 
		
		//Retreive data from Model
		$data['results'] = $this->Inventory_model->select($_POST, $config['per_page'],$offset);
		
		//Display
		$this->load->view('template',$data);
	}
	
	function insert()
	{
		//Load formvalidation library
		$this->load->library('form_validation');
		
		//Checks if the fields are set, and are empty. Then, sets them to NULL
		if(isset($_POST['dateoforder']) && trim($_POST['dateoforder'] == ''))
			$_POST['dateoforder'] = NULL;
				
		if(isset($_POST['dateofexpiration']) && trim($_POST['dateofexpiration'] == ''))
			$_POST['dateofexpiration'] = NULL;
		
		//Defining Validation Rules
		$this->form_validation->set_rules('partner_fk','vendor','trim|required');
		$this->form_validation->set_rules('prodname_fk','product','trim|required');
		$this->form_validation->set_rules('quantity','quantity','greater_than[0]|required');
		$this->form_validation->set_rules('price','price','trim|numeric');
		$this->form_validation->set_rules('dateoforder','date of order','trim');
		$this->form_validation->set_rules('dateofexpiration','date of expiration','trim');
		$this->form_validation->set_rules('comment','comment','trim');


		
		//Check if form has been submited
		if ($this->form_validation->run())
		{				
			//Successful validation
			$success = $this->Inventory_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('inventory/goods_receipts');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('inventory/goods_receipts');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		//$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'prodname','exp_cd_products'));
		$data['vendors'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Goods Receipt';
		
		//Heading
		$data['heading'] = 'Create New Goods Receipt';
		
		//View
		$data['content']= 'procurement/new_goods_receipt_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/procurement_nav_view';
				
		//Display
		$this->load->view('template',$data);
		
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
		//Retreives ONE product from the database
		$data['goods_receipt'] = $this->Inventory_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		if(!$data['goods_receipt']) redirect('inventory/goods_receipts');
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST ubmit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Checks if the fields are set, and are empty. Then, sets them to NULL
			if($_POST['dateoforder'] == '')
				$_POST['dateoforder'] = NULL;
					
			if($_POST['dateofexpiration'] == '')
				$_POST['dateofexpiration'] = NULL;
				
			//print_r($_POST);
			//die();
	
			//Load formvalidation library
			$this->load->library('form_validation');
			
			//Defining Validation Rules
			$this->form_validation->set_rules('partner_fk','vendor','trim|required');
			$this->form_validation->set_rules('prodname_fk','product','trim|required');
			$this->form_validation->set_rules('quantity','quantity','greater_than[0]|required');
			$this->form_validation->set_rules('price','price','trim|numeric');
			$this->form_validation->set_rules('dateoforder','date of order','trim');
			$this->form_validation->set_rules('dateofexpiration','date of expiration','trim');
			$this->form_validation->set_rules('comment','comment','trim');
			
			//Check if form has been submited
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				//Successful validation
				$success = $this->Inventory_model->update($_POST);
				
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('inventory/goods_receipts');
				}
				else
				{
					$this->session->set_flashdata('flash','Database error');
					redirect('inventory/goods_receipts');
				}	
			}
		}
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		//$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'prodname','exp_cd_products'));
		$data['vendors'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Edit Goods Receipt';
		
		//Heading
		$data['heading'] = 'Edit Goods Receipt';
		
		//View
		$data['content']= 'procurement/edit_goods_receipt_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/procurement_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Inventory_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Goods Receipts';
		
		//Heading
		$data['heading'] = 'Goods Receipt';
		
		//View
		$data['content']= 'procurement/goods_receipt_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/procurement_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Inventory_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('inventory/goods_receipts');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('inventory/goods_receipts');
		}
	}
	
}
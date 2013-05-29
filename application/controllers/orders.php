<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('orders/Co_model');
		$this->load->model('orders/Cod_model');
	}
	
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . " - Customer's Orders";
		
		//Heading
		$data['heading'] = "Customer's Orders";
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'orders/orders_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['order_status'] = $this->utilities->add_blank_option($this->utilities->get_order_status());
		$data['customers'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));

		//Pagination
		$offset =  $this->uri->segment(3,0);
		
		$config['base_url'] = site_url('orders/index');
		$config['total_rows'] = count($this->Co_model->select($_POST));
		$config['per_page'] = 15;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		//Retreive data from Model
		$data['results'] = $this->Co_model->select($_POST, $config['per_page'],$offset);
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		
		//Load formvalidation library
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('partner_fk','partner','trim|required');
		$this->form_validation->set_rules('desiredshipping','desired shipping','trim|required');
		$this->form_validation->set_rules('comments','comments','trim');
		$this->form_validation->set_rules('ostatus_fk','order status','trim');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			//Inserts Master details
			$master = array('comments'=>$_POST['comments'],
						  	'desiredshipping'=>$_POST['desiredshipping'],
						 	'partner_fk'=>$_POST['partner_fk'],
							'ostatus_fk'=>$_POST['ostatus_fk']);
			$order_fk = $this->Co_model->insert($master);
			
			if($order_fk)
			{
				//Decode the JSON object int Ass.array and loop through detail records
				foreach (json_decode($_POST['components'],TRUE) as $detail)
				{
					//Inserts all Detail records into the database
					$this->Cod_model->insert(array(
							'order_fk'=>$order_fk,
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
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['customers'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		$data['order_status'] = $this->utilities->add_blank_option($this->utilities->get_order_status());
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . " - Create Customer's Order";
		
		//Heading
		$data['heading'] = "Create Customer's Order";
		
		//View
		$data['content']= 'orders/new_order_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
		
		//Display
		$this->load->view('template',$data);	
	}
	
	function edit()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Co_model->select($options);
		
		//If there is nothing, redirects
		if(!$data['master']) redirect('orders');

		//Retreives data from DETAIL Model
		$data['details'] = $this->Cod_model->select($options);
		
		if(isset($_POST['submit']))
		{
			//Unsets the POST submit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('partner_fk','partner','trim|required');
			$this->form_validation->set_rules('desiredshipping','desired shipping','trim|required');
			$this->form_validation->set_rules('dateshipped','date shipped','trim');
			$this->form_validation->set_rules('comments','comments','trim');
			$this->form_validation->set_rules('ostatus_fk','order status','trim');
			
			
			//Check if updated form has passed validation
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $options['id'];
				//If Successfull, runs Model function
				$success = $this->Co_model->update($_POST);
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
		$data['title'] = $this->config->item('erp_title') . " - Customer's Orders";
		
		//Heading
		$data['heading'] = "Edit Customer's Order";
		
		//View
		$data['content']= 'orders/edit_order_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		//Generate dropdown menu data
		$data['partners'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'company','exp_cd_partners'));
		$data['order_status'] = $this->utilities->add_blank_option($this->utilities->get_order_status());
		$data['products'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'prodname','exp_cd_products',1));
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
				
		//Display
		$this->load->view('template',$data);
		
	}
	
	//AJAX - Adds New Product in Order Details
	function add_product()
	{
		$data['order_fk'] = json_decode($_POST['order_fk']);
		$data['prodname_fk'] = json_decode($_POST['prodname_fk']);
		$data['quantity'] = json_decode($_POST['quantity']);
		
		$cod_exist = $this->Cod_model->check_duplicate(
						array('order_fk'=>$data['order_fk'],
							  'prodname_fk'=>$data['prodname_fk']));
		if(!$cod_exist)
		{
			$this->Cod_model->insert($data);
			echo json_encode(array('success'=>TRUE,'message'=>'Product successfuly added!'));
			header('Content-Type: application/json',true);    
			exit;

		}
		else
		{
			echo json_encode(array('success'=>FALSE,'message'=>'Product already exists! Edit quantity.'));
			header('Content-Type: application/json',true);    
			exit;
		}

	}
	
	//AJAX - Changes the order status
	function set_status()
	{
		$data['id'] = json_decode($_POST['id']);
		$data['ostatus_fk'] = json_decode($_POST['ostatus_fk']);
		
		if($this->Co_model->set_status($data))
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
	
	//AJAX - Removes Products from an Order
	function remove_product()
	{
		if($this->Cod_model->delete(json_decode($_POST['id'])))
		{
			echo json_encode(array('success'=>TRUE,'message'=>'Product successfuly removed!'));
			exit;
		}
		else
		{
			echo json_encode(array('success'=>FALSE,'message'=>'Error while removing!'));
			exit;
		}
		
	}
	
	//AJAX - Edits the Quantity of Products from an Order
	function edit_qty()
	{
		$data['id'] = json_decode($_POST['id']);
		$data['quantity'] = json_decode($_POST['quantity']);
		
		if($this->Cod_model->update($data))
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
		$data['master'] = $this->Co_model->select($options);

		//Retreives data from DETAIL Model
		$data['details'] = $this->Cod_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . " - Customer's Orders";
		
		//Heading
		$data['heading'] = "Customer's Order";
		
		//View
		$data['content']= 'orders/order_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success = $this->Co_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted');
			redirect('orders');
		}
		else
		{
			$this->session->set_flashdata('flash','No records affected!');
			redirect('orders');
		}
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distribution extends CI_Controller {
	
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
		$data['title'] = $this->config->item('erp_title') . " - Distribution";
		
		//Heading
		$data['heading'] = "Pending Orders";
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'orders/orders_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/distribution_nav_view';
		
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

	}
	function edit()
	{
		
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
		if($success = $this->Boms_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted');
			redirect('boms');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('boms');
		}
	}
	
}
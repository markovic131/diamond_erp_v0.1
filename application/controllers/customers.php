<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('partners/Partners_model');	
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Customers';
		
		//Heading
		$data['heading'] = 'Customers';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'partners/customers_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
		
		//Retreives data from the database
		$data['results'] = $this->Partners_model->select(array('partner_type_fk'=>1));
		
		//Display
		$this->load->view('template',$data);
	}
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Partners_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Partners';
		
		//Heading
		$data['heading'] = 'Partner';
		
		//View
		$data['content']= 'partners/partner_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/orders_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	
}
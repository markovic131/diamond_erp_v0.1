<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
			
		//Load Models
		$this->load->model('orders/Co_model');
		$this->load->model('production/Joborders_model');
		
		// Load Utility library
		$this->load->library('utilities');
	}

	function index()
	{	
		//Dashboard Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Dashboard';
		
		//Dashboard Default Content
		$data['content'] ='dashboard/dashboard_view';
		
		//Overview Variables
		$data['total_orders'] =$this->utilities->total_active_records('exp_cd_orders');
		$data['waiting_approval'] =$this->utilities->total_active_records('exp_cd_orders',4);
		$data['total_partners'] =$this->utilities->total_active_records('exp_cd_partners');
		$data['total_jo'] =$this->utilities->total_active_records('exp_cd_job_orders');
		$data['total_emp'] =$this->utilities->total_active_records('exp_cd_employees');
		$data['total_prod'] =$this->utilities->total_active_records('exp_cd_products',1);
		$data['uncomplete_jo'] =$this->utilities->total_active_records('exp_cd_job_orders','uncompleted');
		
		//Dashboard Elements - Order and Job Orders
		$data['results'] = $this->Co_model->select($_POST, 10,NULL);
		$data['results2'] = $this->Joborders_model->select($_POST, 8,NULL);

		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/dash_nav_view';
		
		$this->load->view('template',$data);
	}
	
}

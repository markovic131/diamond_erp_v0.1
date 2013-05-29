<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		
	}

	function index()
	{
		//Authentication Check
		//if(($this->session->userdata('logged_in')==TRUE))
		//	redirect('dashboard');
		
		//Page Title
		$data['title'] = $this->config->item('erp_title');
		
		$this->load->view('login_view',$data);
	}
	
	function login()
	{
		if(($this->input->post('username') == 'root') && ($this->input->post('password') == 'marko'))
		{
			$data = array(
                   'username'  => 'root',
                   'name'     => 'Marko Aleksic',
				   'userid' => '2',
                   'logged_in' => TRUE
               );

			$this->session->set_userdata($data);
			
			redirect ('dashboard');
		}
		else
		{
			$this->index();
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouses extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('warehouses/Warehouses_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Warehouses';
		
		//Heading
		$data['heading'] = 'Warehouses';
		
		//View
		$data['content']= 'warehouses/warehouses_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
	}
	
	function insert()
	{
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('wname','warehouse name','trim|required');
		
		//Check if Validation passed
		if ($this->form_validation->run())
		{
			$success = $this->Warehouses_model->insert($this->input->post('wname'));
			
			if($success)
			{
				//$this->session->set_flashdata('flashconfirm','Warehouse successfuly added.');
				$data['success'] = $success;
				//redirect('warehouses');
			}
			else
			{
				//$this->session->set_flashdata('flasherror','Database error.');
				$data['success'] = false;
				//redirect('warehouses');
			}
		}
		echo json_encode($data);	
	}
	
	function edit()
	{
		$wname = $_POST['wname'];
	
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('wname','warehouse name','trim|required');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['wname'] = $wname;
					
			//Successful validation
			$success = $this->Warehouses_model->update($data);
			
			if($success)
			{
				$this->session->set_flashdata('flashconfirm','Warehouse successfuly updated.');
				redirect('warehouses');
			}
			else
			{
				$this->session->set_flashdata('flasherror','Database error.');
				redirect('warehouses');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		$this->Warehouses_model->delete($id);
		redirect('warehouses');
		
	}
	
	function grid()
	{
		$var['grid'] = $this->Warehouses_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->wname);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner_type extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('partners/Partnertype_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Partner Types';
		
		//Heading
		$data['heading'] = 'Partner Types';
		
		//View
		$data['content']= 'partners/partnertype_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);	
	}
	
	function insert()
	{
		$this->load->library('form_validation');
		
		$name = $this->input->post('ptype');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('ptype','partner type','trim|required');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			$success = $this->Partnertype_model->insert($name);
			
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
		$ptname = $_POST['ptype'];
	
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('ptype','partner type','trim|required');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['ptype'] = $ptname;
					
			//Successful validation
			$success = $this->Partnertype_model->update($data);
			
			if($success)
			{
				$this->session->set_flashdata('flashconfirm','Warehouse successfuly updated.');
				redirect('partner_type');
			}
			else
			{
				$this->session->set_flashdata('flasherror','Database error.');
				redirect('partner_type');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		$this->Partnertype_model->delete($id);
		redirect('partner_type');
		
	}
	function grid()
	{
		$var['grid'] = $this->Partnertype_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->ptype);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uom extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('uom/Uom_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Units of Measure';
		
		//Heading
		$data['heading'] = 'Units of Measure';
		
		//View
		$data['content']= 'uom/uom_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		$this->load->library('form_validation');

		//Defining Validation Rules
		$this->form_validation->set_rules('uname','unit name','trim|required');
		$this->form_validation->set_rules('description','description','trim');
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			$success = $this->Uom_model->insert($_POST);
			
			if($success)
			{
				//$this->session->set_flashdata('flashconfirm','Unit of Measure successfuly added.');
				$data['success'] = $success;
				//redirect('uom');
			}
			else
			{
				//$this->session->set_flashdata('flasherror','Database error.');
				$data['success'] = false;
				//redirect('uom');
			}
		}	
		
		
	}
	
	function edit()
	{
		$uname = $_POST['uname'];
		$description = $_POST['description'];
		
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('uname','unit name','trim|required');
		$this->form_validation->set_rules('description','description','trim');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['uname'] = $uname;
			$data['description'] = $description;
					
			//Successful validation
			$success = $this->Uom_model->update($data);
			
			if($success)
			{
				//$this->session->set_flashdata('flashconfirm','Unit of Measure successfuly added.');
				$data['success'] = $success;
				//redirect('uom');
			}
			else
			{
				//$this->session->set_flashdata('flasherror','Database error.');
				$data['success'] = false;
				//redirect('uom');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		$this->Uom_model->delete($id);
		redirect('uom');
		
	}
	
	function grid()
	{
		$var['grid'] = $this->Uom_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->uname,$row->description);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
	
}
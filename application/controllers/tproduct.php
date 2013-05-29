<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tproduct extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('products/Tproduct_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Product Types';
		
		//Heading
		$data['heading'] = 'Product Type';
		
		//View
		$data['content']= 'products/tproduct_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);		
	}
	
	function insert()
	{
		$this->load->library('form_validation');

		//Defining Validation Rules
		$this->form_validation->set_rules('ptname','product type name','trim|required');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			$success = $this->Tproduct_model->insert($this->input->post('ptname'));
			
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
		$name = $_POST['ptname'];
	
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('ptname','product type name','trim|required');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['ptname'] = $name;
					
			//Successful validation
			$success = $this->Tproduct_model->update($data);
			
			if($success)
			{
				$this->session->set_flashdata('flashconfirm','Warehouse successfuly updated.');
				redirect('tproduct');
			}
			else
			{
				$this->session->set_flashdata('flasherror','Database error.');
				redirect('tproduct');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		$this->Tproduct_model->delete($id);
		redirect('tproduct');
		
	}
	
	function grid()
	{
		$var['grid'] = $this->Tproduct_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->ptname);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
	
}
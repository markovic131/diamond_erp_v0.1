<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cproduct extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('products/Cproduct_model');
	}
    
	function index()
	{	
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Product Categories';
		
		//Heading
		$data['heading'] = 'Product Category';
		
		//View
		$data['content']= 'products/cproduct_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		$this->load->library('form_validation');
		
		//Defining Validation Rules
		$this->form_validation->set_rules('pcname','product category name','trim|required');
		
		//Check if form has been submited
		if ($this->form_validation->run())
		{
			$success = $this->Cproduct_model->insert($this->input->post('pcname'));
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added');
				redirect('warehouses');
			}
			else
			{
                $this->session->set_flashdata('flash','Database error');
				redirect('warehouses');
			}
		}
		echo json_encode($data);
	}
	
	function edit()
	{
		$name = $_POST['pcname'];
	
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('pcname','product category name','trim|required');
				
		if ($this->form_validation->run())
		{
			//Adds what Id to be updated
			$data['id'] = $_POST['id'];
			$data['pcname'] = $name;
					
			//Successful validation
			$success = $this->Cproduct_model->update($data);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly updated');
				redirect('cproduct');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error.');
				redirect('cproduct');
			}	
		}
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		//$id = $this->uri->segment(3,0);
		
		//JQGrid AJAX post
		$id = $_POST['id'];
		
		$this->Cproduct_model->delete($id);
		redirect('cproduct');
		
	}
	
	function grid()
	{
		$var['grid'] = $this->Cproduct_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->pcname);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Authentication Check
		if(!($this->session->userdata('logged_in')))
			redirect('auth');
		
		//Load Models
		$this->load->model('products/Products_model');	
	}

	function index()
	{	
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Products';
		
		//Heading
		$data['heading'] = 'Products';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'products/products_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['warehouses'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'wname','exp_cd_warehouses'));
		$data['types'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ptname','exp_cd_product_type')); 
		$data['categories'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'pcname','exp_cd_product_category')); 	
		
		//AA - Present the Products from the database
		$data['results'] = $this->Products_model->select($_POST);
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		//Load Validation Library
		$this->load->library('form_validation');
	
		//Defining Validation Rules
		$this->form_validation->set_rules('prodname','name','trim|required');
		$this->form_validation->set_rules('code','code','trim|max_length[5]');
		$this->form_validation->set_rules('base_unit','base unit','trim|numeric');
		$this->form_validation->set_rules('retail_price','retail price','trim|numeric');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('alert_quantity','alert quantity','trim|numeric');
		$this->form_validation->set_rules('commision','commision','trim|numeric');
		$this->form_validation->set_rules('code','code','trim');
		
		//Check if form has passed validation
		if ($this->form_validation->run())
		{
			//Successful validation
			$success = $this->Products_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('products');
			}
			else
			{
				$this->session->set_flashdata('flash','No records affected!');
				redirect('products');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['warehouses'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'wname','exp_cd_warehouses'));
		$data['product_types'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ptname','exp_cd_product_type')); 
		$data['product_cates'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'pcname','exp_cd_product_category')); 
		$data['uoms'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'uname','exp_cd_uom'));  		
		
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Create New Product';
		
		//Heading
		$data['heading'] = 'Create New Product';
		
		//View
		$data['content'] = 'products/new_product_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
	
		//Retreives ONE product from the database
		$data['product'] = $this->Products_model->select(array('id'=> $id));
		
		
		//If there is nothing, redirects
		if(!$data['product']) redirect('products');
		
		//Proccesses the form with the new updated data
		if(isset($_POST['submit']))
		{
			//Unsets the POST submit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('prodname','name','trim|required');
			$this->form_validation->set_rules('code','code','trim|min_length[3]|max_length[5]');
			$this->form_validation->set_rules('base_unit','base unit','trim|numeric');
			$this->form_validation->set_rules('retail_price','retail price','trim|numeric');
			$this->form_validation->set_rules('description','description','trim');
			$this->form_validation->set_rules('alert_quantity','alert quantity','trim|numeric');
			$this->form_validation->set_rules('commision','commision','trim|numeric');
			
			
			//Check if updated form has passed validation
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				//If Successfull, runs Model function
				$success = $this->Products_model->update($_POST);
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('products');
				}
				else
				{
					$this->session->set_flashdata('flash','No records affected!');
					redirect('products');
				}	
			}
			
		}
	
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['warehouses'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'wname','exp_cd_warehouses'));
		$data['product_types'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ptname','exp_cd_product_type')); 
		$data['product_cates'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'pcname','exp_cd_product_category')); 
		$data['uoms'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'uname','exp_cd_uom'));  
		
		//Page Title
		$data['title'] =  $this->config->item('erp_title') . ' - Edit Product';
		
		//Heading
		$data['heading'] = 'Edit Product';
		
		//View
		$data['content'] = 'products/edit_product_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template', $data);
	}
	
	function view()
	{
		//Gets the ID of the selected entry from the URL
		$options['id'] = $this->uri->segment(3,0);
		
		//Retreives data from MASTER Model
		$data['master'] = $this->Products_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Products';
		
		//Heading
		$data['heading'] = 'Product';
		
		//View
		$data['content']= 'products/product_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success =$this->Products_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('products');
		}
		else
		{
			$this->session->set_flashdata('flash','No records affected!');
			redirect('products');
		}
	}
	
	function grid()
	{
		$var['grid'] = $this->Products_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->id,$row->code,$row->prodname,$row->ptname,$row->pcname,
	            								  $row->wname,$row->base_unit,$row->uname,$row->retail_price,$row->alert_quantity);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
	
	function dropdown()
	{
		$option = $this->uri->segment(3,0);
		
		$data = $this->Products_model->get_products($option);
		
		header('Content-Type: application/json',true); 
		echo json_encode($data);
	}
		

}
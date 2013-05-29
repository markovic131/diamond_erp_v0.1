<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends CI_Controller {
	
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
		$data['title'] = $this->config->item('erp_title') . ' - Partners';
		
		//Heading
		$data['heading'] = 'Partners';
		
		//Flash Data
		$data['flashes'] = 'includes/flashes';
		
		//View
		$data['content']= 'partners/partners_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//AA - Present the Products from the database
		$data['results'] = $this->Partners_model->select();
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function insert()
	{
		//Load Validation Library
		$this->load->library('form_validation');
		
		if(isset($_POST['password']) && $_POST['password'] == '')
			unset($_POST['password']);
		
		//Defining Validation Rules
		$this->form_validation->set_rules('company','company','trim|required');
		$this->form_validation->set_rules('contperson','contact person','trim|required');
		$this->form_validation->set_rules('code','code','trim|required|max_lenth[6]');
		$this->form_validation->set_rules('partner_type_fk','partner type','trim|required');
		$this->form_validation->set_rules('ugroup_fk','user group','trim|required');
		$this->form_validation->set_rules('username','username','min_length[6]|max_lenth[12]');
		$this->form_validation->set_rules('password','password','min_length[6]');
		$this->form_validation->set_rules('email','email','trim|valid_email');
		$this->form_validation->set_rules('web','web','trim|valid_website');
		$this->form_validation->set_rules('phone','phone','trim|numeric');
		$this->form_validation->set_rules('phone2','phone 2','trim|numeric');
		$this->form_validation->set_rules('mobile','mobile','trim|numeric');
		$this->form_validation->set_rules('fax','fax','trim|numeric');
		$this->form_validation->set_rules('bank','bank','trim');
		$this->form_validation->set_rules('account_no','account number','trim|numeric');
		$this->form_validation->set_rules('address','address','trim');
		
		//Check if form has passed validation
		if ($this->form_validation->run())
		{
			if(isset($_POST['password']))
					$_POST['password'] = sha1($_POST['password']);
			
			//Returns TRUE(id) if insertion successfull
			$success = $this->Partners_model->insert($_POST);
			
			if($success)
			{
				$this->session->set_flashdata('flash','Record successfuly added!');
				redirect('partners');
			}
			else
			{
				$this->session->set_flashdata('flash','Database error');
				redirect('partners');
			}	
		}
		
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['partners'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ptype','exp_cd_partner_type'));	
		$data['postalcodes'] = $this->utilities->add_blank_option($this->utilities->get_postalcodes());	
		$data['ugroups'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ugroup','exp_cd_user_groups'));		
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Create New Partner';
		
		//Heading
		$data['heading'] = 'Create New Partner';
		
		//View
		$data['content'] = 'partners/new_partner_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
		
		//Display
		$this->load->view('template',$data);
		
	}
	
	function edit()
	{
		$id = $this->uri->segment(3,0);
		
		//Retreives ONE product from the database
		$data['partner'] = $this->Partners_model->select(array('id'=> $id));
		
		//If there is nothing, redirects
		if(!$data['partner']) redirect('partners');
		
		//Proccesses the form with the new updated data
		if(isset($_POST['submit']))
		{
			//Unsets the POST submit, so I doesnt get inserted into the db
			unset($_POST['submit']);
			
			//If the password has not been changed, unsets the password variable
			if(isset($_POST['password']) && $_POST['password'] == '')
				unset($_POST['password']);

			//Load Validation Library
			$this->load->library('form_validation');
		
			//Defining Validation Rules
			$this->form_validation->set_rules('company','company','trim|required');
			$this->form_validation->set_rules('contperson','contact person','trim|required');
			$this->form_validation->set_rules('code','code','trim|required|max_lenth[6]');
			$this->form_validation->set_rules('partner_type_fk','partner type','trim|required');
			$this->form_validation->set_rules('ugroup_fk','user group','trim|required');
			$this->form_validation->set_rules('username','username','min_length[6]|max_lenth[12]');
			$this->form_validation->set_rules('password','password','min_length[6]');
			$this->form_validation->set_rules('email','email','trim|valid_email');
			$this->form_validation->set_rules('web','web','trim|valid_website');
			$this->form_validation->set_rules('phone','phone','trim|numeric');
			$this->form_validation->set_rules('phone2','phone 2','trim|numeric');
			$this->form_validation->set_rules('mobile','mobile','trim|numeric');
			$this->form_validation->set_rules('fax','fax','trim|numeric');
			$this->form_validation->set_rules('bank','bank','trim');
			$this->form_validation->set_rules('account_no','account number','trim|numeric');
			$this->form_validation->set_rules('address','address','trim');
			
			
			//Check if updated form has passed validation
			if ($this->form_validation->run())
			{
				//Adds what Id to be updated
				$_POST['id'] = $id;
				
				//Hashes the new password
				if(isset($_POST['password']))
					$_POST['password'] = sha1($_POST['password']);
		
				//If Successfull, runs Model function
				$success = $this->Partners_model->update($_POST);
				
				if($success)
				{
					$this->session->set_flashdata('flash','Record successfuly updated!');
					redirect('partners');
				}
				else
				{
					$this->session->set_flashdata('flash','Database error');
					redirect('partners');
				}	
			}
			
		}
	
		// Load Utility library
		$this->load->library('utilities');
		
		// Generating dropdown menu's
		$data['partners'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ptype','exp_cd_partner_type'));	
		$data['postalcodes'] = $this->utilities->add_blank_option($this->utilities->get_postalcodes());	
		$data['ugroups'] = $this->utilities->add_blank_option($this->utilities->get_dropdown('id', 'ugroup','exp_cd_user_groups'));		
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Edit Partner';
		
		//Heading
		$data['heading'] = 'Edit Partner';
		
		//View
		$data['content'] = 'partners/edit_partner_view';
		
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
		$data['master'] = $this->Partners_model->select($options);
		
		//Page Title
		$data['title'] = $this->config->item('erp_title') . ' - Partners';
		
		//Heading
		$data['heading'] = 'Partner';
		
		//View
		$data['content']= 'partners/partner_view';
		
		//Module Navigation
		$data['modnav'] = 'includes/modnav/master_nav_view';
				
		//Display
		$this->load->view('template',$data);
	}
	
	function delete()
	{
		//Takes the ID (third segment) of the URL, delets the corresponding db entry
		$id = $this->uri->segment(3,0);
		if($success =$this->Partners_model->delete($id))
		{
			$this->session->set_flashdata('flash','Record successfuly deleted!');
			redirect('partners');
		}
		else
		{
			$this->session->set_flashdata('flash','Database error');
			redirect('partners');
		}	
	}
	
	function grid()
	{
		$var['grid'] = $this->Partners_model->select();
             $i = 0;
             foreach($var['grid'] as $row) 
             {
	            $responce->rows[$i]['id']=$row->id;
	            $responce->rows[$i]['cell']=array($row->code,$row->company,$row->ptype,$row->contperson);
	            $i++;
             }  
             
      	header('Content-Type: application/json',true);    
      	echo json_encode($responce);
	}
}
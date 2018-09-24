<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('supplier_model','supplier_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['supplier']=$this->supplier_model->get_data_list();
		
		if (empty($data['supplier']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('supplier/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('name','Supplier Name','required');
		$this->form_validation->set_rules('phone','Contact','trim');
		$this->form_validation->set_rules('contact_person','Contact Person','trim');
		$this->form_validation->set_rules('fax','Fax','trim');
		$this->form_validation->set_rules('email','Email','trim');
		$this->form_validation->set_rules('credit_term','Credit Term','trim');
		$this->form_validation->set_rules('address','Address','trim');
		$this->form_validation->set_rules('city','City','trim');
		$this->form_validation->set_rules('state','State','trim');
		$this->form_validation->set_rules('country','Country','trim');
		$this->form_validation->set_rules('postalcode','Postcode','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('supplier/management/'.$id);
		$data['link_back']=anchor('supplier/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_supplier']=$this->supplier_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$supplier=array(
					'name'=>$this->input->post('name'),
					'phone'=>$this->input->post('phone'),
					'contact_person'=>$this->input->post('contact_person'),
					'fax'=>$this->input->post('fax'),
					'email'=>$this->input->post('email'),
					'credit_term'=>$this->input->post('credit_term'),
					'address'=>$this->input->post('address'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'country'=>$this->input->post('country'),
					'postalcode'=>$this->input->post('postalcode'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->supplier_model->update($edit_id,$supplier);
			//$this->output->enable_profiler(1);
			redirect('supplier/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['supplier']=$this->supplier_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('supplier/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$supplier=array(
						'name'=>$this->input->post('name'),
						'phone'=>$this->input->post('phone'),
						'contact_person'=>$this->input->post('contact_person'),
						'fax'=>$this->input->post('fax'),
						'email'=>$this->input->post('email'),
						'credit_term'=>$this->input->post('credit_term'),
						'address'=>$this->input->post('address'),
						'city'=>$this->input->post('city'),
						'state'=>$this->input->post('state'),
						'country'=>$this->input->post('country'),
						'postalcode'=>$this->input->post('postalcode'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->supplier_model->insert($supplier);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('supplier/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete supplier
		$this->supplier_model->delete($id);
		redirect('supplier/'.$page);
	}
}

/* End of file supplier.php */
/* Location: ./application/controllers/supplier.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('business_model','business_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['business']=$this->business_model->get_data_list();
		
		if (empty($data['business']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('business/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('name','Business Name','required');
		$this->form_validation->set_rules('description','Description','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('business/management/'.$id);
		$data['link_back']=anchor('business/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_business']=$this->business_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$business=array(
					'name'=>$this->input->post('name'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->business_model->update($edit_id,$business);
			//$this->output->enable_profiler(1);
			redirect('business/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['business']=$this->business_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('business/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$business=array(
						'name'=>$this->input->post('name'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->business_model->insert($business);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('business/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete business
		$this->business_model->delete($id);
		redirect('business/'.$page);
	}
}

/* End of file business.php */
/* Location: ./application/controllers/business.php */
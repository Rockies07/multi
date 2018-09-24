<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('country_model','country_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['country']=$this->country_model->get_data_list();
		
		if (empty($data['country']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('country/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('country','Country Name','required');
		$this->form_validation->set_rules('nationality','Nationality','required');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('country/management/'.$id);
		$data['link_back']=anchor('country/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_country']=$this->country_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$country=array(
					'country'=>$this->input->post('country'),
					'nationality'=>$this->input->post('nationality'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->country_model->update($edit_id,$country);
			//$this->output->enable_profiler(1);
			redirect('country/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['country']=$this->country_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('country/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$country=array(
						'country'=>$this->input->post('country'),
						'nationality'=>$this->input->post('nationality'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->country_model->insert($country);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('country/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete country
		$this->country_model->delete($id);
		redirect('country/'.$page);
	}
}

/* End of file country.php */
/* Location: ./application/controllers/country.php */
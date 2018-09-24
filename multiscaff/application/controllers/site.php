<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('site_model','site_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['site']=$this->site_model->get_data_list();
		
		if (empty($data['site']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('site/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('project','Project','required');
		$this->form_validation->set_rules('name','Site Name','required');
		$this->form_validation->set_rules('type','Type','required');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('code','Code','trim');
		$this->form_validation->set_rules('hourly_rate','Hourly Rate','trim');
		$this->form_validation->set_rules('ot_normal_rate','OT 1.5','trim');
		$this->form_validation->set_rules('ot_sunday_rate','OT 2.0','trim');
		$this->form_validation->set_rules('spv_hourly_rate','Hourly Rate(Spv)','trim');
		$this->form_validation->set_rules('spv_ot_normal_rate','OT 1.5(Spv)','trim');
		$this->form_validation->set_rules('spv_ot_sunday_rate','OT 2.0(Spv)','trim');
		$this->form_validation->set_rules('unit_rate','Unit Rate','trim');
		$this->form_validation->set_rules('spv_payment','Spv. Payment','trim');
		$this->form_validation->set_rules('e_percentage','E Percentage','trim');
		$this->form_validation->set_rules('d_percentage','D Percentage','trim');
		$this->form_validation->set_rules('description','Description','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('site/management/'.$id);
		$data['link_back']=anchor('site/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		if($id!="0")
		{
			$data['edit_site']=$this->site_model->get_by_id($id);
			$data['edit_site_project']=$this->project_model->get_by_id($this->site_model->get_by_id($id)->project_id);
		}
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$site=array(
					'project_id'=>$this->input->post('project'),
					'name'=>$this->input->post('name'),
					'code'=>$this->input->post('code'),
					'type'=>$this->input->post('type'),
					'status'=>$this->input->post('status'),
					'hourly_rate'=>$this->input->post('hourly_rate'),
					'ot_normal_rate'=>$this->input->post('ot_normal_rate'),
					'ot_sunday_rate'=>$this->input->post('ot_sunday_rate'),
					'spv_hourly_rate'=>$this->input->post('spv_hourly_rate'),
					'spv_ot_normal_rate'=>$this->input->post('spv_ot_normal_rate'),
					'spv_ot_sunday_rate'=>$this->input->post('spv_ot_sunday_rate'),
					'spv_payment'=>$this->input->post('spv_payment'),
					'unit_rate'=>$this->input->post('unit_rate'),
					'e_percentage'=>$this->input->post('e_percentage'),
					'd_percentage'=>$this->input->post('d_percentage'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->site_model->update($edit_id,$site);
			//$this->output->enable_profiler(1);
			redirect('site/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['site']=$this->site_model->get_data_list();
				$data['project']=$this->project_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('site/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$site=array(
						'project_id'=>$this->input->post('project'),
						'name'=>$this->input->post('name'),
						'code'=>$this->input->post('code'),
						'type'=>$this->input->post('type'),
						'status'=>$this->input->post('status'),
						'hourly_rate'=>$this->input->post('hourly_rate'),
						'ot_normal_rate'=>$this->input->post('ot_normal_rate'),
						'ot_sunday_rate'=>$this->input->post('ot_sunday_rate'),
						'spv_hourly_rate'=>$this->input->post('spv_hourly_rate'),
						'spv_ot_normal_rate'=>$this->input->post('spv_ot_normal_rate'),
						'spv_ot_sunday_rate'=>$this->input->post('spv_ot_sunday_rate'),
						'spv_payment'=>$this->input->post('spv_payment'),
						'unit_rate'=>$this->input->post('unit_rate'),
						'e_percentage'=>$this->input->post('e_percentage'),
						'd_percentage'=>$this->input->post('d_percentage'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->site_model->insert($site);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('site/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete site
		$this->site_model->delete($id);
		redirect('site/'.$page);
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */
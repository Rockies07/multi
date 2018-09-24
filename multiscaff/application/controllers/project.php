<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('project_model','project_model',TRUE);
		$this->load->model('business_model','business_model',TRUE);
		$this->load->model('client_model','client_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['project']=$this->project_model->get_data_list();
		
		if (empty($data['project']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('project/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('business','Business','required');
		$this->form_validation->set_rules('client','Client','required');
		$this->form_validation->set_rules('name','Project Name','required');
		$this->form_validation->set_rules('contract_value','Contract Value','numeric');
		$this->form_validation->set_rules('deadline','Deadline','trim');
		$this->form_validation->set_rules('description','Description','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('project/management/'.$id);
		$data['link_back']=anchor('project/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		if($id!="0")
		{
			$data['edit_project']=$this->project_model->get_by_id($id);
			$data['edit_project_business']=$this->business_model->get_by_id($this->project_model->get_by_id($id)->business_id);
			$data['edit_project_client']=$this->client_model->get_by_id($this->project_model->get_by_id($id)->client_id);
		}
		$edit_id=$this->input->post('edit_id');

		$date_str=$this->input->post('deadline');
		$date_arr=explode("/",$date_str);
		$deadline=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		
		if($edit_id>"0")
		{
			//if update from existing data
			$project=array(
					'business_id'=>$this->input->post('business'),
					'client_id'=>$this->input->post('client'),
					'name'=>$this->input->post('name'),
					'deadline'=>$deadline,
					'contract_value'=>$this->input->post('contract_value'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->project_model->update($edit_id,$project);
			//$this->output->enable_profiler(1);
			redirect('project/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['project']=$this->project_model->get_data_list();
				$data['business']=$this->business_model->get_data_list();
				$data['client']=$this->client_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('project/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$date_str=$this->input->post('deadline');
				$date_arr=explode("/",$date_str);
				$deadline=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
				

				$project=array(
						'business_id'=>$this->input->post('business'),
						'client_id'=>$this->input->post('client'),
						'name'=>$this->input->post('name'),
						'deadline'=>$deadline,
						'contract_value'=>$this->input->post('contract_value'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->project_model->insert($project);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('project/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete project
		$this->project_model->delete($id);
		redirect('project/'.$page);
	}
}

/* End of file project.php */
/* Location: ./application/controllers/project.php */
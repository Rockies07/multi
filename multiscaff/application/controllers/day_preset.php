<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Day_preset extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('day_preset_model','day_preset_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['day_preset']=$this->day_preset_model->get_data_list();
		
		if (empty($data['day_preset']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('day_preset/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('date','Date','required');
		$this->form_validation->set_rules('description','Description','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('day_preset/management/'.$id);
		$data['link_back']=anchor('day_preset/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_day_preset']=$this->day_preset_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		$date_str=$this->input->post('date');
		$date_arr=explode("/",$date_str);
		$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		
		if($edit_id>"0")
		{
			//if update from existing data
			$day_preset=array(
					'date'=>$date,
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->day_preset_model->update($edit_id,$day_preset);
			//$this->output->enable_profiler(1);
			redirect('day_preset/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['day_preset']=$this->day_preset_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('day_preset/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$day_preset=array(
						'date'=>$date,
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->day_preset_model->insert($day_preset);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('day_preset/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete day_preset
		$this->day_preset_model->delete($id);
		redirect('day_preset/'.$page);
	}
}

/* End of file day_preset.php */
/* Location: ./application/controllers/day_preset.php */
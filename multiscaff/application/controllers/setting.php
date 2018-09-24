<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('setting_model','setting_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['setting']=$this->setting_model->get_data_list();
		
		if (empty($data['setting']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('setting/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('site_name','Site Name','required');
		$this->form_validation->set_rules('sys_name','System Name','required');
		$this->form_validation->set_rules('sys_motto','System Motto','trim');
		$this->form_validation->set_rules('ot_weekday','OT Weekday','required|numeric');
		$this->form_validation->set_rules('ot_sunday','OT Sunday','required|numeric');
		$this->form_validation->set_rules('meal_min_hour','Meal min. Hour','required|numeric');
		$this->form_validation->set_rules('meal_fee','Meal Fee','required|numeric');
		$this->form_validation->set_rules('ns_fee','Night Shift Fee','required|numeric');
		$this->form_validation->set_rules('ns_spv_fee','Night Shift Fee(Spv)','required|numeric');
		$this->form_validation->set_rules('hl_cut_fee','Home Leave Fee','required|numeric');
		$this->form_validation->set_rules('standby_fee','Standby Fee','required|numeric');
		$this->form_validation->set_rules('mc_fee','MC Fee','required|numeric');
		$this->form_validation->set_rules('course_fee','Course Fee','required|numeric');
		$this->form_validation->set_rules('absent_fee','Absent Fee','required|numeric');
		$this->form_validation->set_rules('decimal_digit','Decimal Digit','numeric');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('setting/management/'.$id);
		$data['link_back']=anchor('setting/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_setting']=$this->setting_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			$site_name=$this->input->post('site_name');
			$sys_name=$this->input->post('sys_name');
			$sys_motto=$this->input->post('sys_motto');
			//if update from existing data
			$setting=array(
					'site_name'=>$site_name,
					'sys_name'=>$sys_name,
					'sys_motto'=>$sys_motto,
					'ot_weekday'=>$this->input->post('ot_weekday'),
					'ot_sunday'=>$this->input->post('ot_sunday'),
					'meal_min_hour'=>$this->input->post('meal_min_hour'),
					'meal_fee'=>$this->input->post('meal_fee'),
					'ns_fee'=>$this->input->post('ns_fee'),
					'ns_spv_fee'=>$this->input->post('ns_spv_fee'),
					'hl_cut_fee'=>$this->input->post('hl_cut_fee'),
					'standby_fee'=>$this->input->post('standby_fee'),
					'mc_fee'=>$this->input->post('mc_fee'),
					'course_fee'=>$this->input->post('course_fee'),
					'absent_fee'=>$this->input->post('absent_fee'),
					'expiry_limit'=>$this->input->post('expiry_limit'),
					'prefix_code'=>$this->input->post('prefix_code'),
					'middle_code'=>$this->input->post('middle_code'),
					'suffix_code'=>$this->input->post('suffix_code'),
					'decimal_digit'=>$this->input->post('decimal_digit'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->setting_model->update($edit_id,$setting);

			$this->session->set_userdata('site_name', $site_name);
			$this->session->set_userdata('sys_name', $sys_name);
			$this->session->set_userdata('sys_motto', $sys_motto);
			//$this->output->enable_profiler(1);
			redirect('setting/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();

			$get_setting=$this->setting_model->get_by_id(1);
				
			if($this->form_validation->run() === FALSE)
			{
				$data['setting']=$this->setting_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('setting/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$setting=array(
						'site_name'=>$this->input->post('site_name'),
						'sys_name'=>$this->input->post('sys_name'),
						'sys_motto'=>$this->input->post('sys_motto'),
						'ot_weekday'=>$this->input->post('ot_weekday'),
						'ot_sunday'=>$this->input->post('ot_sunday'),
						'meal_min_hour'=>$this->input->post('meal_min_hour'),
						'meal_fee'=>$this->input->post('meal_fee'),
						'ns_fee'=>$this->input->post('ns_fee'),
						'ns_spv_fee'=>$this->input->post('ns_spv_fee'),
						'hl_cut_fee'=>$this->input->post('hl_cut_fee'),
						'standby_fee'=>$this->input->post('standby_fee'),
						'mc_fee'=>$this->input->post('mc_fee'),
						'course_fee'=>$this->input->post('course_fee'),
						'absent_fee'=>$this->input->post('absent_fee'),
						'expiry_limit'=>$this->input->post('expiry_limit'),
						'prefix_code'=>$this->input->post('prefix_code'),
						'middle_code'=>$this->input->post('middle_code'),
						'suffix_code'=>$this->input->post('suffix_code'),
						'decimal_digit'=>$this->input->post('decimal_digit'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->setting_model->insert($setting);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('setting/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete setting
		$this->setting_model->delete($id);
		redirect('setting/'.$page);
	}
}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */
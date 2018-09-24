<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthly_expenses extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('monthly_expenses_model','monthly_expenses_model',TRUE);
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['monthly_expenses']=$this->monthly_expenses_model->get_data_list();
		
		if (empty($data['monthly_expenses']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('monthly_expenses/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('month','Month','required');
		$this->form_validation->set_rules('year','Year','required');
		$this->form_validation->set_rules('levy','Levy','required|numeric');
		$this->form_validation->set_rules('dormitory','Dormitory','required|numeric');
		$this->form_validation->set_rules('transportation','Transportation','required|numeric');
		$this->form_validation->set_rules('administration','Administration','required|numeric');
		$this->form_validation->set_rules('operation','Operation','required|numeric');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('monthly_expenses/management/'.$id);
		$data['link_back']=anchor('monthly_expenses/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_monthly_expenses']=$this->monthly_expenses_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$monthly_expenses=array(
					'month'=>$this->input->post('month'),
					'year'=>$this->input->post('year'),
					'levy'=>$this->input->post('levy'),
					'dormitory'=>$this->input->post('dormitory'),
					'transportation'=>$this->input->post('transportation'),
					'administration'=>$this->input->post('administration'),
					'operation'=>$this->input->post('operation'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->monthly_expenses_model->update($edit_id,$monthly_expenses);

			$month=(int)$this->input->post('month');
			$this->transaction_employee_model->update_daily_expenses_all($month);

			//$this->output->enable_profiler(1);
			redirect('monthly_expenses/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['monthly_expenses']=$this->monthly_expenses_model->get_data_list();
				$data['project']=$this->project_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('monthly_expenses/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$monthly_expenses=array(
						'month'=>$this->input->post('month'),
						'year'=>$this->input->post('year'),
						'levy'=>$this->input->post('levy'),
						'dormitory'=>$this->input->post('dormitory'),
						'transportation'=>$this->input->post('transportation'),
						'administration'=>$this->input->post('administration'),
						'operation'=>$this->input->post('operation'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->monthly_expenses_model->insert($monthly_expenses);

				$month=(int)$this->input->post('month');
				$this->transaction_employee_model->update_daily_expenses_all($month);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('monthly_expenses/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete monthly_expenses
		$this->monthly_expenses_model->delete($id);
		redirect('monthly_expenses/'.$page);
	}
}

/* End of file monthly_expenses.php */
/* Location: ./application/controllers/monthly_expenses.php */
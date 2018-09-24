<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('employee_model','employee_model',TRUE);
		$this->load->model('subgroup_model','subgroup_model',TRUE);
		$this->load->model('country_model','country_model',TRUE);
		$this->load->model('home_leave_model','home_leave_model',TRUE);
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['employee']=$this->employee_model->get_data_list();
		
		if (empty($data['employee']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('employee/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('nts','NTS No.','required');
		$this->form_validation->set_rules('name','Employee Name','required');
		$this->form_validation->set_rules('position','Position','required');
		$this->form_validation->set_rules('daily_rate','Daily Rate','required|numeric');
		$this->form_validation->set_rules('levy','Levy','required|numeric');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('nationality','Nationality','trim');
		$this->form_validation->set_rules('date_of_birth','Date Of Birth','trim');
		$this->form_validation->set_rules('email','Email','trim');
		$this->form_validation->set_rules('local_contact','Local Contact','trim');
		$this->form_validation->set_rules('hm_contact','HM Contact','trim');
		$this->form_validation->set_rules('local_address','Local Address','trim');
		$this->form_validation->set_rules('referral','Referral','trim');
		$this->form_validation->set_rules('fin_no','Fin No.','trim');
		$this->form_validation->set_rules('wp_no','WP No.','trim');
		$this->form_validation->set_rules('wp_application_date','WP Application Date','trim');
		$this->form_validation->set_rules('wp_issued_date','WP Issued Date','trim');
		$this->form_validation->set_rules('wp_exp_date','WP Exp. Date','trim');
		$this->form_validation->set_rules('ap_application_date','AP Application Date','trim');
		$this->form_validation->set_rules('ap_exp_date','AP Exp. Date','trim');
		$this->form_validation->set_rules('passport','Passport','trim');
		$this->form_validation->set_rules('passport_exp_date','Passport Exp. Date','trim');
		$this->form_validation->set_rules('start_work_date','Start Work Date','trim');
		$this->form_validation->set_rules('end_work_date','End Work Date','trim');
		$this->form_validation->set_rules('prev_work_exp_year','Prev. Work Exp Year','numeric');
		$this->form_validation->set_rules('prev_work_exp_month','Prev. Work Exp Month','numeric');
		$this->form_validation->set_rules('prev_work_exp_day','Prev. Work Exp Day','numeric');
		$this->form_validation->set_rules('mses_no','MSES No.','trim');
		$this->form_validation->set_rules('msec_no','MSEC No.','trim');
		$this->form_validation->set_rules('wahs_no','WAHS No.','trim');
		$this->form_validation->set_rules('wahw_no','WAHW No.','trim');
		$this->form_validation->set_rules('bcss_no','BCSS No.','trim');
		$this->form_validation->set_rules('csoc_no','CSOC No.','trim');
		$this->form_validation->set_rules('csoc_exp_date','CSOC Exp. Date','trim');
		$this->form_validation->set_rules('core_trade_type','Core Trade Type','trim');
		$this->form_validation->set_rules('core_trade_course','Core Trade Course','trim');
		$this->form_validation->set_rules('core_register_no','Core Register No.','trim');
		$this->form_validation->set_rules('core_exp_date','Core Exp. Date','trim');
		$this->form_validation->set_rules('multi_skill_1','1st SEC','trim');
		$this->form_validation->set_rules('multi_skill_2','2nc SEC','trim');
		$this->form_validation->set_rules('multi_skill_register_no','Multi Skill Register No.','trim');
		$this->form_validation->set_rules('multi_skill_exp_date','Multi Skill Exp. Date','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('employee/management/'.$id);
		$data['link_back']=anchor('employee/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_employee']=$this->employee_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		$daily_rate=$this->input->post('daily_rate');
		$hourly_rate=$daily_rate/8;
		
		if($edit_id>"0")
		{
			$date_str=$this->input->post('date_of_birth');
			$date_arr=explode("/",$date_str);
			$date_of_birth=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_exp_date');
			$date_arr=explode("/",$date_str);
			$wp_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('ap_exp_date');
			$date_arr=explode("/",$date_str);
			$ap_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('start_work_date');
			$date_arr=explode("/",$date_str);
			$start_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_application_date');
			$date_arr=explode("/",$date_str);
			$wp_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_issued_date');
			$date_arr=explode("/",$date_str);
			$wp_issued_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('ap_application_date');
			$date_arr=explode("/",$date_str);
			$ap_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('passport_exp_date');
			$date_arr=explode("/",$date_str);
			$passport_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('csoc_exp_date');
			$date_arr=explode("/",$date_str);
			$csoc_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('core_exp_date');
			$date_arr=explode("/",$date_str);
			$core_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('multi_skill_exp_date');
			$date_arr=explode("/",$date_str);
			$multi_skill_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$status=$this->input->post('status');
			if($status=="Cancel Permit" || $status=="Resign" || $status=="Terminated" || $status=="Transfer")
			{
				$date_str=$this->input->post('end_work_date');
				$date_arr=explode("/",$date_str);
				$end_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
			}
			else
			{
				$end_work_date="2099-12-31";
			}
			//if update from existing data
			$employee=array(
					'nts'=>$this->input->post('nts'),
					'name'=>$this->input->post('name'),
					'position'=>$this->input->post('position'),
					'nationality'=>$this->input->post('nationality'),
					'date_of_birth'=>$date_of_birth,
					'local_contact'=>$this->input->post('local_contact'),
					'hm_contact'=>$this->input->post('hm_contact'),
					'local_address'=>$this->input->post('local_address'),
					'email'=>$this->input->post('email'),
					'referral'=>$this->input->post('referral'),
					'daily_rate'=>$daily_rate,
					'hourly_rate'=>$hourly_rate,
					'levy'=>$this->input->post('levy'),
					'status'=>$status,
					'start_work_date'=>$start_work_date,
					'end_work_date'=>$end_work_date,
					'prev_work_exp_year'=>$this->input->post('prev_work_exp_year'),
					'prev_work_exp_month'=>$this->input->post('prev_work_exp_month'),
					'prev_work_exp_day'=>$this->input->post('prev_work_exp_day'),
					'fin_no'=>$this->input->post('fin_no'),
					'wp_no'=>$this->input->post('wp_no'),
					'wp_application_date'=>$wp_application_date,
					'wp_issued_date'=>$wp_issued_date,
					'wp_exp_date'=>$wp_exp_date,
					'ap_application_date'=>$ap_application_date,
					'ap_exp_date'=>$ap_exp_date,
					'passport'=>$this->input->post('passport'),
					'passport_exp_date'=>$passport_exp_date,
					'mses_no'=>$this->input->post('mses_no'),
					'msec_no'=>$this->input->post('msec_no'),
					'wahs_no'=>$this->input->post('wahs_no'),
					'wahw_no'=>$this->input->post('wahw_no'),
					'bcss_no'=>$this->input->post('bcss_no'),
					'csoc_no'=>$this->input->post('csoc_no'),
					'csoc_exp_date'=>$csoc_exp_date,
					'core_trade_type'=>$this->input->post('core_trade_type'),
					'core_trade_course'=>$this->input->post('core_trade_course'),
					'core_register_no'=>$this->input->post('core_register_no'),
					'core_exp_date'=>$core_exp_date,
					'multi_skill_1'=>$this->input->post('multi_skill_1'),
					'multi_skill_2'=>$this->input->post('multi_skill_2'),
					'multi_skill_register_no'=>$this->input->post('multi_skill_register_no'),
					'multi_skill_exp_date'=>$multi_skill_exp_date,
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->employee_model->update($edit_id,$employee);
			//$this->output->enable_profiler(1);
			redirect('employee/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			//$this->_set_rules();
				
			$filter_nationality=$this->input->post('filter_nationality');
			$filter_work_exp=$this->input->post('filter_work_exp');
			$filter_other=$this->input->post('filter_other');
			$filter_have=$this->input->post('filter_have');

			$data['expiry_limit']=$this->setting_model->get_by_id('1')->expiry_limit;
			$data['employee']=$this->employee_model->get_data_list('Active','1',$filter_nationality,$filter_work_exp,$filter_have,$filter_other);
			$data['country']=$this->country_model->get_data_list();
			$data['filter_nationality']=$filter_nationality;
			$data['filter_work_exp']=$filter_work_exp;
			$data['filter_other']=$filter_other;
			$data['filter_have']=$filter_have;
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('employee/index',$data);
			$this->load->view('template/footer');
		}
	}

	function add($id=0)
	{
		$data['action']=site_url('employee/add/'.$id);
		$data['link_back']=anchor('employee/add/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_employee']=$this->employee_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		$daily_rate=$this->input->post('daily_rate');
		$hourly_rate=$daily_rate/8;
		
		if($edit_id>"0")
		{
			$date_str=$this->input->post('date_of_birth');
			$date_arr=explode("/",$date_str);
			$date_of_birth=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_exp_date');
			$date_arr=explode("/",$date_str);
			$wp_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('ap_exp_date');
			$date_arr=explode("/",$date_str);
			$ap_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('start_work_date');
			$date_arr=explode("/",$date_str);
			$start_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_application_date');
			$date_arr=explode("/",$date_str);
			$wp_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('wp_issued_date');
			$date_arr=explode("/",$date_str);
			$wp_issued_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('ap_application_date');
			$date_arr=explode("/",$date_str);
			$ap_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('passport_exp_date');
			$date_arr=explode("/",$date_str);
			$passport_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('csoc_exp_date');
			$date_arr=explode("/",$date_str);
			$csoc_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('core_exp_date');
			$date_arr=explode("/",$date_str);
			$core_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$date_str=$this->input->post('multi_skill_exp_date');
			$date_arr=explode("/",$date_str);
			$multi_skill_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$status=$this->input->post('status');
			if($status=="Cancel Permit" || $status=="Resign" || $status=="Terminated" || $status=="Transfer")
			{
				$date_str=$this->input->post('end_work_date');
				$date_arr=explode("/",$date_str);
				$end_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
			}
			else
			{
				$end_work_date="2099-12-31";
			}
			//if update from existing data
			$nts=$this->input->post('nts');
			$employee=array(
					'nts'=>$this->input->post('nts'),
					'name'=>$this->input->post('name'),
					'position'=>$this->input->post('position'),
					'nationality'=>$this->input->post('nationality'),
					'date_of_birth'=>$date_of_birth,
					'local_contact'=>$this->input->post('local_contact'),
					'hm_contact'=>$this->input->post('hm_contact'),
					'local_address'=>$this->input->post('local_address'),
					'email'=>$this->input->post('email'),
					'referral'=>$this->input->post('referral'),
					'daily_rate'=>$daily_rate,
					'hourly_rate'=>$hourly_rate,
					'levy'=>$this->input->post('levy'),
					'status'=>$status,
					'start_work_date'=>$start_work_date,
					'end_work_date'=>$end_work_date,
					'prev_work_exp_year'=>$this->input->post('prev_work_exp_year'),
					'prev_work_exp_month'=>$this->input->post('prev_work_exp_month'),
					'prev_work_exp_day'=>$this->input->post('prev_work_exp_day'),
					'fin_no'=>$this->input->post('fin_no'),
					'wp_no'=>$this->input->post('wp_no'),
					'wp_application_date'=>$wp_application_date,
					'wp_issued_date'=>$wp_issued_date,
					'wp_exp_date'=>$wp_exp_date,
					'ap_application_date'=>$ap_application_date,
					'ap_exp_date'=>$ap_exp_date,
					'passport'=>$this->input->post('passport'),
					'passport_exp_date'=>$passport_exp_date,
					'mses_no'=>$this->input->post('mses_no'),
					'msec_no'=>$this->input->post('msec_no'),
					'wahs_no'=>$this->input->post('wahs_no'),
					'wahw_no'=>$this->input->post('wahw_no'),
					'bcss_no'=>$this->input->post('bcss_no'),
					'csoc_no'=>$this->input->post('csoc_no'),
					'csoc_exp_date'=>$csoc_exp_date,
					'core_trade_type'=>$this->input->post('core_trade_type'),
					'core_trade_course'=>$this->input->post('core_trade_course'),
					'core_register_no'=>$this->input->post('core_register_no'),
					'core_exp_date'=>$core_exp_date,
					'multi_skill_1'=>$this->input->post('multi_skill_1'),
					'multi_skill_2'=>$this->input->post('multi_skill_2'),
					'multi_skill_register_no'=>$this->input->post('multi_skill_register_no'),
					'multi_skill_exp_date'=>$multi_skill_exp_date,
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->employee_model->update($edit_id,$employee);
			//$this->output->enable_profiler(1);
			redirect('employee/detail/'.$nts);
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$data['country']=$this->country_model->get_data_list();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('employee/add',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$date_str=$this->input->post('date_of_birth');
				$date_arr=explode("/",$date_str);
				$date_of_birth=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('wp_exp_date');
				$date_arr=explode("/",$date_str);
				$wp_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('ap_exp_date');
				$date_arr=explode("/",$date_str);
				$ap_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('start_work_date');
				$date_arr=explode("/",$date_str);
				$start_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('wp_application_date');
				$date_arr=explode("/",$date_str);
				$wp_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('wp_issued_date');
				$date_arr=explode("/",$date_str);
				$wp_issued_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('ap_application_date');
				$date_arr=explode("/",$date_str);
				$ap_application_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('passport_exp_date');
				$date_arr=explode("/",$date_str);
				$passport_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('csoc_exp_date');
				$date_arr=explode("/",$date_str);
				$csoc_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('core_exp_date');
				$date_arr=explode("/",$date_str);
				$core_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$date_str=$this->input->post('multi_skill_exp_date');
				$date_arr=explode("/",$date_str);
				$multi_skill_exp_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$status=$this->input->post('status');
				if($status=="Cancel Permit" || $status=="Resign" || $status=="Terminated" || $status=="Transfer")
				{
					$date_str=$this->input->post('end_work_date');
					$date_arr=explode("/",$date_str);
					$end_work_date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
				}
				else
				{
					$end_work_date="2099-12-31";
				}

				$nts=$this->input->post('nts');

				$employee=array(
						'nts'=>$this->input->post('nts'),
						'name'=>$this->input->post('name'),
						'position'=>$this->input->post('position'),
						'nationality'=>$this->input->post('nationality'),
						'date_of_birth'=>$date_of_birth,
						'local_contact'=>$this->input->post('local_contact'),
						'hm_contact'=>$this->input->post('hm_contact'),
						'local_address'=>$this->input->post('local_address'),
						'email'=>$this->input->post('email'),
						'referral'=>$this->input->post('referral'),
						'daily_rate'=>$daily_rate,
						'hourly_rate'=>$hourly_rate,
						'levy'=>$this->input->post('levy'),
						'status'=>$status,
						'start_work_date'=>$start_work_date,
						'end_work_date'=>$end_work_date,
						'prev_work_exp_year'=>$this->input->post('prev_work_exp_year'),
						'prev_work_exp_month'=>$this->input->post('prev_work_exp_month'),
						'prev_work_exp_day'=>$this->input->post('prev_work_exp_day'),
						'fin_no'=>$this->input->post('fin_no'),
						'wp_no'=>$this->input->post('wp_no'),
						'wp_application_date'=>$wp_application_date,
						'wp_issued_date'=>$wp_issued_date,
						'wp_exp_date'=>$wp_exp_date,
						'ap_application_date'=>$ap_application_date,
						'ap_exp_date'=>$ap_exp_date,
						'passport'=>$this->input->post('passport'),
						'passport_exp_date'=>$passport_exp_date,
						'mses_no'=>$this->input->post('mses_no'),
						'msec_no'=>$this->input->post('msec_no'),
						'wahs_no'=>$this->input->post('wahs_no'),
						'wahw_no'=>$this->input->post('wahw_no'),
						'bcss_no'=>$this->input->post('bcss_no'),
						'csoc_no'=>$this->input->post('csoc_no'),
						'csoc_exp_date'=>$csoc_exp_date,
						'core_trade_type'=>$this->input->post('core_trade_type'),
						'core_trade_course'=>$this->input->post('core_trade_course'),
						'core_register_no'=>$this->input->post('core_register_no'),
						'core_exp_date'=>$core_exp_date,
						'multi_skill_1'=>$this->input->post('multi_skill_1'),
						'multi_skill_2'=>$this->input->post('multi_skill_2'),
						'multi_skill_register_no'=>$this->input->post('multi_skill_register_no'),
						'multi_skill_exp_date'=>$multi_skill_exp_date,
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->employee_model->insert($employee);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('employee/detail/'.$nts);
			}
		}
	}

	function detail($nts="")
	{
		$data['action']=site_url('employee/detail/'.$nts);
		$data['link_back']=anchor('employee/detail/'.$nts, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		$data['employee']=$this->employee_model->get_employee_by_value('nts',$nts);
		$data['home_leave']=$this->home_leave_model->get_by_value($nts);
		$year=date('Y');
		$data['mc_detail']=$this->transaction_employee_model->get_mc_list($nts,$year);
		
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('employee/detail',$data);
		$this->load->view('template/footer');
	}

	function get_list($status,$match)
	{
		$data['action']=site_url('employee/management/'.$id);
		$data['link_back']=anchor('employee/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		$this->_set_rules();
			
		if($this->form_validation->run() === FALSE)
		{
			$data['employee']=$this->employee_model->get_data_list($status,$match);

			if((($status!="Active")&&($match=="1"))||(($status=="Active")&&($match=="0")))
			{
				$is_active=0;
			}
			else
			{
				$is_active=1;
			}
			
			$data['expiry_limit']=$this->setting_model->get_by_id('1')->expiry_limit;
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['is_active']=$is_active;
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('employee/list_data',$data);
			$this->load->view('template/footer');
		}
	}

	function group($id=0)
	{
		$data['action']=site_url('employee/group/'.$id);
		$data['link_back']=anchor('employee/group/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		//set common properties
		//$this->output->enable_profiler(1);
		//$this->_set_rules();
			
		if(!$this->input->get_post('nts_1'))
		{
			$data['group']=$this->subgroup_model->get_data_list();
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('employee/group',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data
			$assign=$this->input->post('assign');
			for($i=1;$i<=10;$i++)
			{
				if(($assign=='1')&&($i==1))
				{
					$pos="1";
				}
				else
				{
					$pos="2";
				}
				$nts=$this->input->post('nts_'.$i);
				if($nts!="")
				{
					$leader=$this->input->post('group_leader');
					$group=array(
						'nts'=>$nts,
						'leader'=>$leader,
						'pos'=>$pos,
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
					);
						
					$id=$this->subgroup_model->insert($group);
				}
			}
				
			//set form input nama ="id"
			$this->validation->id=$id;
				
			redirect('employee/group/0');
		}
	}
	
	function delete($id,$page)
	{
		//delete employee
		$this->employee_model->delete($id);
		redirect('employee/'.$page);
	}

	function delete_group($id,$page)
	{
		//delete employee
		$this->subgroup_model->delete($id);
		redirect('employee/'.$page);
	}
}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_employee extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('site_model','site_model',TRUE);
		$this->load->model('employee_model','employee_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
		$this->load->model('day_preset_model','day_preset_model',TRUE);
		$this->load->model('home_leave_model','home_leave_model',TRUE);
	}

	function get_site_list_by_value($value)
	{
		echo(json_encode($this->site_model->get_site_list_by_value($value,'Closed')));
		echo(exit());
	}
	 
	function index()
	{
		// Write to $content
		$data['transaction_employee']=$this->transaction_employee_model->get_data_list();
		
		if (empty($data['transaction_employee']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('transaction_employee/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		//$this->form_validation->set_rules('site','Site','required');
		$this->form_validation->set_rules('date','Date','required');
	}
	
	function get_employee_by_nts(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->employee_model->get_employee_list_by_value($q,'nts');
		}
	}
	
	function management()
	{
		$data['action']=site_url('transaction_employee/management');
		$data['link_back']=anchor('transaction_employee/management', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$edit_id=$this->input->post("edit_id");
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');
		$project=$this->input->post('project');
		$site=$this->input->post('site');
		if($project!="")
		{
			$get_project_detail=$this->project_model->get_by_id($project);
			$project_name=$get_project_detail->name;
		}
		else
		{
			$project_name="";
		}
		
		if($site!="")
		{
			$get_site_detail=$this->site_model->get_by_id($site);
			$site_name=$get_site_detail->name;
		}
		else
		{
			$site_name="";
		}
		$data['transaction_employee']=$this->transaction_employee_model->get_data_list($date_from,$date_to,$project,$site);
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$data['site']=$this->site_model->get_data_list(0,'Closed');
		$data['project']=$this->project_model->get_data_list();
		$data['filter_date_from']=$date_from;
		$data['filter_date_to']=$date_to;
		$data['filter_project']=$project;
		$data['filter_project_name']=$project_name;
		$data['filter_site']=$site;
		$data['filter_site_name']=$site_name;
		$data['edit_id']=$id;

		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('transaction_employee/management',$data);
		$this->load->view('template/footer');
	}
	
	function add()
	{
		$data['action']=site_url('transaction_employee/add');
		
		$data['notification']="";
		//set common properties
		//$this->output->enable_profiler(1);
		$this->_set_rules();
				
		if($this->form_validation->run() === FALSE)
		{
			$data['transaction_employee']=$this->transaction_employee_model->get_data_list();
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list(1,'Closed');

			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_employee/index',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data
			$site=$this->input->post('site');
			$get_site_detail=$this->site_model->get_by_id($site);
			$project_id=$get_site_detail->project_id;
			$get_setting=$this->setting_model->get_by_id('1');

			$date_str=$this->input->post('date');
			$date_arr=explode("/",$date_str);
			$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

			$ph=$this->day_preset_model->is_holiday($date);
			$is_weekend=0;
			$time = mktime(0, 0, 0, date('m',strtotime($date)), date('d',strtotime($date)), date('Y',strtotime($date)));
			$weekday = date('w', $time);
			if (($weekday == 0)||($ph))
			{
				$is_weekend=1;
				$meal_min_hour=8+($get_setting->meal_min_hour);
			}
			else
			{
				$is_weekend=0;
				$meal_min_hour=$get_setting->meal_min_hour;
			}
			
			for($i=1;$i<=60;$i++)
			{
				$nts=$this->input->post('nts_'.$i);
				if($nts!="")
				{	
					$get_employee_detail=$this->employee_model->get_employee_by_value('nts',$nts);
					$position=$get_employee_detail->position;
					$hourly_rate=$get_employee_detail->hourly_rate;
					$ot_multiple=$this->setting_model->get_multiple_rate($date,$ph);
					$ot_rate=$hourly_rate*$ot_multiple;
					
					$work_hour=$this->input->post('work_hour_'.$i);
					$ot_hour=$this->input->post('ot_hour_'.$i);
					$total_hour=$work_hour+$ot_hour;

					$normal_salary=$hourly_rate*$work_hour;
					$ot_salary=$ot_rate*$ot_hour;
					
					$is_ns=$this->input->post('ns_'.$i); //night shift
					$add_shift=$this->input->post('add_shift_'.$i);
					
					if($ot_hour>=$meal_min_hour)
					{
						$meal_fee=$get_setting->meal_fee;
					}
					else
					{
						$meal_fee=0;
					}

					if($is_ns)
					{
						if($position=="Supervisor")
						{
							$ns_fee=$get_setting->ns_spv_fee;
						}
						else
						{
							$ns_fee=$get_setting->ns_fee;
						}
					}
					else
					{
						$ns_fee=0;
					}

					if($is_weekend)
					{
						if($position=="Supervisor")
						{
							$ot_site_rate=$get_site_detail->spv_ot_sunday_rate;
							$site_rate=$get_site_detail->spv_hourly_rate;
						}
						else
						{
							$ot_site_rate=$get_site_detail->ot_sunday_rate;
							$site_rate=$get_site_detail->hourly_rate;
						}
					}
					else
					{
						if($position=="Supervisor")
						{
							$ot_site_rate=$get_site_detail->spv_ot_normal_rate;
							$site_rate=$get_site_detail->spv_hourly_rate;
						}
						else
						{
							$ot_site_rate=$get_site_detail->ot_normal_rate;
							$site_rate=$get_site_detail->hourly_rate;
						}
					}

					$transaction_employee=array(
							'date'=>$date,
							'project_id'=>$project_id,
							'site_id'=>$site,
							'nts'=>$nts,
							'position'=>$position,
							'hourly_rate'=>$hourly_rate,
							'ot_rate'=>$ot_rate,
							'work_hour'=>$work_hour,
							'ot_hour'=>$ot_hour,
							'normal_salary'=>$normal_salary,
							'ot_salary'=>$ot_salary,
							'meal_fee'=>$meal_fee,
							'ns_fee'=>$ns_fee,
							'add_shift'=>$add_shift,
							'site_rate'=>$site_rate,
							'ot_site_rate'=>$ot_site_rate,
							'createdate'=>date('Y-m-d H:i:s',now()),
							'createby'=>$this->access->get_username(),
							'updateby'=>$this->access->get_username(),
							'updatedate'=>date('Y-m-d H:i:s',now())
					);

					$id=$this->transaction_employee_model->insert($transaction_employee);

					if($add_shift)
					{
						$get_total_ot_hour=$this->transaction_employee_model->check_total_ot($nts,$date)->total_ot;

						if($get_total_ot_hour>=$meal_min_hour)
						{
							$meal_fee=$get_setting->meal_fee;
							$this->transaction_employee_model->update_meal_fee($nts,$date,$meal_fee);
						}
					}

					if($site=='1')
					{
						$home_leave=array(
								'nts'=>$nts,
								'start_hl_date'=>$date,
								'end_hl_date'=>$date,
								'createdate'=>date('Y-m-d H:i:s',now()),
								'createby'=>$this->access->get_username(),
								'updateby'=>$this->access->get_username(),
								'updatedate'=>date('Y-m-d H:i:s',now())
						);
						$this->home_leave_model->insert($home_leave);
					}
				}
			}
			$this->transaction_employee_model->update_daily_expenses($date);
			$this->transaction_employee_model->update_absent($date);
					
				//set form input nama ="id"
			$this->validation->id=$id;
					
			redirect('transaction_employee/add');
		}
	}

	function configuration()
	{
		$data['action']=site_url('transaction_employee/configuration');
		
		$data['notification']="";
		//set common properties
		//$this->output->enable_profiler(1);
		$nts_salary=$this->input->post('nts_salary');
		$site=$this->input->post('site');
		$current_site=$this->input->post('current_site');
		$target_site=$this->input->post('target_site');

		if($nts_salary=="" && $site=="" && $current_site=="")
		{
			$data['transaction_employee']=$this->transaction_employee_model->get_data_list();
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list(1,'Closed');

			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_employee/configuration',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data	
			if($nts_salary!="")
			{
				$daily_rate=$this->input->post('daily_rate');
				$date_str=$this->input->post('date_salary');
				$date_arr=explode("/",$date_str);
				$date_salary=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$hourly_rate=$daily_rate/8;

				$get_employee_detail=$this->employee_model->get_employee_by_value('nts',$nts_salary);
				$id=$get_employee_detail->id;

				$employee=array(
					'daily_rate'=>$daily_rate,
					'hourly_rate'=>$hourly_rate,
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$this->employee_model->update($id,$employee);

				$this->transaction_employee_model->update_salary_by_date($nts_salary,$date_salary,$hourly_rate);
			}

			if($site!="")
			{
				$date_str=$this->input->post('date_site_from');
				$date_arr=explode("/",$date_str);
				$date_site_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
				$date_str=$this->input->post('date_site_to');
				$date_arr=explode("/",$date_str);
				$date_site_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$get_site_detail=$this->site_model->get_by_id($site);

				$this->transaction_employee_model->update_site_date($site,$date_site_from,$date_site_to);
			}

			if(($current_site!="")&&($target_site!=""))
			{
				$date_str=$this->input->post('date_site');
				$date_arr=explode("/",$date_str);
				$date_site=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				$get_current_site_detail=$this->site_model->get_by_id($current_site);
				$get_target_site_detail=$this->site_model->get_by_id($target_site);

				$this->transaction_employee_model->update_site_to_site($current_site,$target_site,$date_site);
			}
					
			//set form input nama ="id"
			$this->validation->id=$id;
					
			redirect('transaction_employee/configuration');
		}
	}
	
	function delete($id,$page)
	{
		//delete transaction_employee
		$date=$this->transaction_employee_model->get_by_id($id)->date;
		
		$this->transaction_employee_model->delete($id);

		$this->transaction_employee_model->update_daily_expenses($date);
		$this->transaction_employee_model->update_absent($date);

		redirect('transaction_employee/'.$page);
	}
}

/* End of file transaction_employee.php */
/* Location: ./application/controllers/transaction_employee.php */
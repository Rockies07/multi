<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_unit extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('transaction_unit_model','transaction_unit_model',TRUE);
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('site_model','site_model',TRUE);
		$this->load->model('employee_model','employee_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('subgroup_model','subgroup_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['transaction_unit']=$this->transaction_unit_model->get_data_list();
		
		if (empty($data['transaction_unit']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('transaction_unit/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('site','Site','required');
		$this->form_validation->set_rules('date','Date','required');
		$this->form_validation->set_rules('amount','Amount','required');
		$this->form_validation->set_rules('group','Group','required');
	}
	
	function get_employee_by_nts(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->employee_model->get_employee_list_by_value($q,'nts');
		}
	}
	
	function management($id=0)
	{
		$data['action']=site_url('transaction_unit/management');
		$data['link_back']=anchor('transaction_unit/management', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$edit_id=$this->input->post("edit_id");
		//set common properties
		//$this->output->enable_profiler(1);
		if($edit_id==0)
		{
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
			$data['transaction_unit']=$this->transaction_unit_model->get_data_list($date_from,$date_to,$project,$site);
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
			$this->load->view('transaction_unit/management',$data);
			$this->load->view('template/footer');
		}
		else
		{
			$get_transaction_detail=$this->transaction_unit_model->get_by_id($edit_id);
			$hourly_rate=$get_transaction_detail->hourly_rate;
			$ot_rate=$get_transaction_detail->ot_rate;
			$work_hour=$this->input->post('work_hour');
			$ot_hour=$this->input->post('ot_hour');

			$normal_salary=$hourly_rate*$work_hour;
			$ot_salary=$ot_rate*$ot_hour;

			$get_setting=$this->setting_model->get_by_id('1');
			$meal_min_hour=$get_setting->meal_min_hour;

			if($ot_hour>=$meal_min_hour)
			{
				$meal_fee=$get_setting->meal_fee;
			}
			else
			{
				$meal_fee=0;
			}

			$is_ns=$this->input->post('ns'); //night shift
			if($is_ns)
			{
				$ns_fee=$get_setting->ns_fee;
			}
			else
			{
				$ns_fee=0;
			}
			$transaction_unit=array(
				'work_hour'=>$work_hour,
				'ot_hour'=>$ot_hour,
				'normal_salary'=>$normal_salary,
				'ot_salary'=>$ot_salary,
				'meal_fee'=>$meal_fee,
				'ns_fee'=>$ns_fee,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
			);
							
			$this->transaction_unit_model->update($edit_id,$transaction_unit);
			
			$data['transaction_unit']=$this->transaction_unit_model->get_data_list($date_from,$date_to,$project,$site);
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
			$this->load->view('transaction_unit/management',$data);
			$this->load->view('template/footer');
		}
	}
	
	function add()
	{
		$data['action']=site_url('transaction_unit/add');
		
		$data['notification']="";
		//set common properties
		//$this->output->enable_profiler(1);
		$this->_set_rules();
				
		if($this->form_validation->run() === FALSE)
		{
			$data['transaction_unit']=$this->transaction_unit_model->get_data_list();
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list_by_type("Unit","Closed");
			$data['group']=$this->subgroup_model->get_leader_list();
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_unit/index',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data
			$site=$this->input->post('site');
			$get_site_detail=$this->site_model->get_by_id($site);
			$site_rate=$get_site_detail->hourly_rate;
			$project_id=$get_site_detail->project_id;
			
			$date_str=$this->input->post('date');
			$date_arr=explode("/",$date_str);
			$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
			
			$amount=$this->input->post('amount');
			$group=$this->input->post('group');

			$get_member_group=$this->subgroup_model->get_employee_on_group($group);
			$get_setting=$this->setting_model->get_by_id('1');
			$ph=$this->input->post('ph');
			$date_str=$this->input->post('date');
			$date_arr=explode("/",$date_str);
			$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
			$time = mktime(0, 0, 0, date('m',strtotime($date)), date('d',strtotime($date)), date('Y',strtotime($date)));
			$weekday = date('w', $time);
			if (($weekday == 0)||($ph))
			{
				$ot_site_rate=$get_site_detail->ot_sunday_rate;
				$meal_min_hour=8+($get_setting->meal_min_hour);
			}
			else
			{
				$ot_site_rate=$get_site_detail->ot_normal_rate;
				$meal_min_hour=$get_setting->meal_min_hour;
			}

			foreach($get_member_group as $row)
			{
				$nts=$row['nts'];
				$get_employee_detail=$this->employee_model->get_employee_by_value('nts',$nts);
				$position=$get_employee_detail->position;
				$hourly_rate=$get_employee_detail->hourly_rate;
				$ot_multiple=$this->setting_model->get_multiple_rate($date,$ph);
				$ot_rate=$hourly_rate*$ot_multiple;
				
				$work_hour=$this->input->post('work_hour');
				$ot_hour=$this->input->post('ot_hour');
				$total_hour=$work_hour+$ot_hour;

				$normal_salary=$hourly_rate*$work_hour;
				$ot_salary=$ot_rate*$ot_hour;
				
				$is_ns=$this->input->post('ns'); //night shift
				
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
						'site_rate'=>$site_rate,
						'ot_site_rate'=>$ot_site_rate,
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
						
				$id=$this->transaction_employee_model->insert($transaction_employee);
			}
			$this->transaction_employee_model->update_daily_expenses($date);

			$location=$this->input->post('location');
			if($amount!="")
			{	
				$transaction_unit=array(
						'date'=>$date,
						'project_id'=>$project_id,
						'site_id'=>$site,
						'group'=>$group,
						'location'=>$location,
						'amount'=>$amount,
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
						
				$id=$this->transaction_unit_model->insert($transaction_unit);
			}
			
				//set form input nama ="id"
			$this->validation->id=$id;
					
			redirect('transaction_unit/add');
		}
	}
	
	function delete($id,$page)
	{
		//delete transaction_unit
		$this->transaction_unit_model->delete($id);
		redirect('transaction_unit/'.$page);
	}
}

/* End of file transaction_unit.php */
/* Location: ./application/controllers/transaction_unit.php */
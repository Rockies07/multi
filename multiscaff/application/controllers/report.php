<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('transaction_unit_model','transaction_unit_model',TRUE);
		$this->load->model('site_model','site_model',TRUE);
		$this->load->model('employee_model','employee_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
		$this->load->model('monthly_expenses_model','monthly_expenses_model',TRUE);
	}

	function get_site_list_by_value($value)
	{
		echo(json_encode($this->site_model->get_site_list_by_value($value)));
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
		$this->load->view('report/daily',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('site','Site','required');
		$this->form_validation->set_rules('date','Date','required');
	}
	
	function get_employee_by_nts(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->employee_model->get_employee_list_by_value($q,'nts');
		}
	}

	function period()
	{
		$data['action']=site_url('report/period');
		$data['link_back']=anchor('report/period', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_filter_from=$this->input->post('date_filter_from');
		$date_filter_to=$this->input->post('date_filter_to');
		
		$monthly_expenses=$this->monthly_expenses_model->get_monthly_expenses_by_date($date_filter_from);
		
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

		$total_no_of_men_supply=$this->transaction_employee_model->get_transaction_total($date_filter_from,"","",$date_filter_to)->total_no_of_men;
		$total_no_of_men_unit=$this->transaction_unit_model->get_transaction_total($date_filter_from,"","",$date_filter_to)->total_no_of_men;
		$total_strength=$this->employee_model->get_employee_count_by_date($date_filter_to);

		$data['report_daily_supply']=$this->transaction_employee_model->get_report_list($date_filter_from,$project,$site,$date_filter_to);
		$data['report_daily_unit']=$this->transaction_unit_model->get_report_list($date_filter_from,$project,$site,$date_filter_to);
		$data['report_daily_total_supply']=$this->transaction_employee_model->get_transaction_total($date_filter_from,$project,$site,$date_filter_to);
		$data['report_daily_total_unit']=$this->transaction_unit_model->get_transaction_total($date_filter_from,$project,$site,$date_filter_to);
		$data['report_position']=$this->transaction_employee_model->get_worker_position_list($date_filter_from,$project,$site,$date_filter_to);

		$data['total_no_of_men']=$total_no_of_men_supply+$total_no_of_men_unit;
		$data['total_employee_count']=$this->employee_model->get_employee_count();
		$data['report_absent']=$this->transaction_employee_model->get_absent_list($date_filter_from,$date_filter_to);
		$data['total_absent']=$this->transaction_employee_model->get_total_absent($date_filter_from,$date_filter_to);
		$data['total_strength']=$total_strength;
		$data['get_setting']=$this->setting_model->get_by_id('1');
		$data['site']=$this->site_model->get_data_list(0);
		$data['project']=$this->project_model->get_data_list();
		$data['monthly_expenses']=$monthly_expenses;
		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['filter_project']=$project;
		$data['filter_project_name']=$project_name;
		$data['filter_site']=$site;
		$data['filter_site_name']=$site_name;
		$data['erector_number']=$this->transaction_employee_model->get_count_by_position("Erector",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['safety_number']=$this->transaction_employee_model->get_count_by_position("Safety",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['driver_number']=$this->transaction_employee_model->get_count_by_position("Driver",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['storeman_number']=$this->transaction_employee_model->get_count_by_position("Storeman",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['supervisor_number']=$this->transaction_employee_model->get_count_by_position("Supervisor",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/period',$data);
		$this->load->view('template/footer');
	}

	function project()
	{
		$data['action']=site_url('report/project');
		$data['link_back']=anchor('report/project', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_filter_from=$this->input->post('date_filter_from');
		$date_filter_to=$this->input->post('date_filter_to');

		$data['project_report']=$this->transaction_employee_model->get_by_project($date_filter_from,$project,$site,$date_filter_to);

		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/project',$data);
		$this->load->view('template/footer');
	}

	function site($project_id,$date_filter_from,$date_filter_to)
	{
		$data['action']=site_url('report/site');
		$data['link_back']=anchor('report/project');
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		/*
		if(isset($this->input->post('date_filter_from')))
		{
			$date_filter_from=$this->input->post('date_filter_from');
		}

		if(isset($this->input->post('date_filter_to')))
		{
			$date_filter_to=$this->input->post('date_filter_to');
		}
		*/

		$data['site_report']=$this->transaction_employee_model->get_by_site($date_filter_from,$project_id,$site,$date_filter_to);

		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/site',$data);
		$this->load->view('template/footer');
	}

	function site_detail($site_id,$date_filter_from,$date_filter_to)
	{
		$data['action']=site_url('report/site');
		$data['link_back']=anchor('report/project');
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_arr=explode("-",$date_filter_from);
		$date_filter_from=$date_arr[1]."/".$date_arr[2]."/".$date_arr[0];

		$date_arr=explode("-",$date_filter_to);
		$date_filter_to=$date_arr[1]."/".$date_arr[2]."/".$date_arr[0];

		$data['site_detail']=$this->transaction_employee_model->get_monthly_groupby_date($date_filter_from,$project,$site_id,$date_filter_to);
		$data['project_site_name']=$this->site_model->get_by_id($site_id)->name;
		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/site_detail',$data);
		$this->load->view('template/footer');
	}

	function man_count_detail($site_id,$page,$date_filter_from,$date_filter_to)
	{
		$data['action']=site_url('report/man_count_detail');
		$data['link_back']=anchor('report/man_count_summary');
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		$get_site_detail=$this->site_model->get_by_id($site_id);
		$data['project_site_name']=$get_site_detail->name;
		$site_type=$get_site_detail->type;
		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');

		switch($page)
		{
			case 'all' : $data['man_count_detail']=$this->employee_model->get_data_list_by_date($date_filter_from); 
						 $this->load->view('report/position',$data);
						 break;
			case 'driver' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_position('Driver',$date_filter_from); 
						 $data['position']='Driver';
						 $this->load->view('report/position',$data);
						 break;
			case 'storeman' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_position('Storeman',$date_filter_from); 
						 $data['position']='Storeman';
						 $this->load->view('report/position',$data);
						 break;
			case 'supervisor' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_position('Supervisor',$date_filter_from); 
						 $data['position']='Supervisor';
						 $this->load->view('report/position',$data);
						 break;
			case 'site' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_site($site_id,$site_type,$date_filter_from); 
						 $this->load->view('report/site_employee',$data);
						 break;
			case 'project' : $project_id=$get_site_detail->project_id;
							 $data['project_site_name']=$this->project_model->get_by_id($project_id)->name;
							 $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_project($project_id,$date_filter_from); 
						     $this->load->view('report/site_employee',$data);
						     break;
			case 'absent' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_site($site_id,$site_type,$date_filter_from);
						 $this->load->view('report/site_employee',$data);
						 break;
			case 'nojob' : $data['man_count_detail']=$this->transaction_employee_model->get_employee_absent($date_filter_from); 
						 $data['position']='No Job';
						 $this->load->view('report/position',$data);
						 break;
			default : $data['man_count_detail']=$this->transaction_employee_model->get_employee_list_by_site($site_id,$date_filter_from,$date_filter_to); 
						 $this->load->view('report/site_employee',$data);
						 break;
		}
		
		$this->load->view('template/footer');
	}

	function monthly()
	{
		$data['action']=site_url('report/monthly');
		$data['link_back']=anchor('report/monthly', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_filter_month=$this->input->post('date_filter_month');
		$date_filter_year=$this->input->post('date_filter_year');
		$date_filter_from=$date_filter_month."/01/".$date_filter_year;
		$date_filter_to=date('m/t/Y',strtotime($date_filter_from));
		
		$monthly_expenses=$this->monthly_expenses_model->get_monthly_expenses_by_date($date_filter);
		$total_no_of_men_supply=$this->transaction_employee_model->get_transaction_total($date_filter_from,"","",$date_filter_to)->total_no_of_men;
		$total_no_of_men_unit=$this->transaction_unit_model->get_transaction_total($date_filter_from,"","",$date_filter_to)->total_no_of_men;
		
		$data['report_monthly_supply']=$this->transaction_employee_model->get_report_list($date_filter_from,$project,$site,$date_filter_to);
		$data['report_monthly_unit']=$this->transaction_unit_model->get_report_list($date_filter_from,$project,$site,$date_filter_to);
		$data['report_monthly_total_supply']=$this->transaction_employee_model->get_transaction_total($date_filter_from,$project,$site,$date_filter_to);
		$data['report_monthly_total_unit']=$this->transaction_unit_model->get_transaction_total($date_filter_from,$project,$site,$date_filter_to);
		$data['report_position']=$this->transaction_employee_model->get_worker_position_list($date_filter_from,$project,$site,$date_filter_to);
		$data['total_no_of_men']=$total_no_of_men_supply+$total_no_of_men_unit;
		$data['total_employee_count']=$this->employee_model->get_employee_count();
		$data['report_absent']=$this->transaction_employee_model->get_absent_list($date_filter_from,$date_filter_to);
		$data['get_setting']=$this->setting_model->get_by_id('1');
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$data['site']=$this->site_model->get_data_list(0);
		$data['project']=$this->project_model->get_data_list();
		$data['monthly_expenses']=$monthly_expenses;
		$data['filter_date_month']=$date_filter_month;
		$data['filter_date_year']=$date_filter_year;
		$data['filter_project']=$project;
		$data['filter_project_name']=$project_name;
		$data['filter_site']=$site;
		$data['filter_site_name']=$site_name;
		$data['erector_number']=$this->transaction_employee_model->get_count_by_position("Erector",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['driver_number']=$this->transaction_employee_model->get_count_by_position("Driver",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['storeman_number']=$this->transaction_employee_model->get_count_by_position("Storeman",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$data['supervisor_number']=$this->transaction_employee_model->get_count_by_position("Supervisor",$date_filter_from,$project,$site,$date_filter_to)->total_no_of_men;
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/monthly',$data);
		$this->load->view('template/footer');
	}

	function monthly_by_date()
	{
		$data['action']=site_url('report/monthly_by_date');
		$data['link_back']=anchor('report/monthly_by_date', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_filter_month=$this->input->post('date_filter_month');
		$date_filter_year=$this->input->post('date_filter_year');
		$date_filter_from=$date_filter_month."/01/".$date_filter_year;
		$date_filter_to=date('m/t/Y',strtotime($date_filter_from));
		
		$data['monthly_detail']=$this->transaction_employee_model->get_monthly_groupby_date($date_filter_from,$project,$site,$date_filter_to);
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$data['filter_date_month']=$date_filter_month;
		$data['filter_date_year']=$date_filter_year;
		
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/monthly_by_date',$data);
		$this->load->view('template/footer');
	}

	function man_count_summary()
	{
		$data['action']=site_url('report/man_count_summary');
		$data['link_back']=anchor('report/man_count_summary', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_filter_from=$this->input->post('date_filter_from');
		$date_filter_to=$this->input->post('date_filter_to');

		$data['man_count_report']=$this->transaction_employee_model->get_man_count_summary($date_filter_from,$project,$site,$date_filter_to);
		//print_r($data);

		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/man_count_summary',$data);
		$this->load->view('template/footer');
	}

	function man_count_summary_detail($date_filter_from,$date_filter_to,$project)
	{
		$data['action']=site_url('report/man_count_summary_detail');
		$data['link_back']=anchor('report/man_count_summary', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$filter_date_from=$this->input->post('date_filter_from');
		$filter_date_to=$this->input->post('date_filter_to');
		$filter_project=$this->input->post('project');

		if($filter_date_from!="")
		{
			$date_arr=explode("/",$filter_date_from);
			$date_filter_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}

		if($filter_date_to!="")
		{
			$date_arr=explode("/",$filter_date_to);
			$date_filter_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}

		if($filter_project!="")
		{
			$project=$filter_project;
		}

		$data['man_count_report']=$this->transaction_employee_model->get_man_count_summary_detail($date_filter_from,$project,$site,$date_filter_to);
		//print_r($data);

		$data['filter_date_from']=$date_filter_from;
		$data['filter_date_to']=$date_filter_to;
		$data['project']=$project;
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/man_count_summary_detail',$data);
		$this->load->view('template/footer');
	}

	function collection()
	{
		$data['action']=site_url('report/collection');
		$data['link_back']=anchor('report/collection', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/collection',$data);
		$this->load->view('template/footer');
	}
	
	function delete($id,$page)
	{
		//delete transaction_employee
		$this->transaction_employee_model->delete($id);
		redirect('transaction_employee/'.$page);
	}

	function employee_activity()
	{
		$data['action']=site_url('report/employee_activity');
		$data['link_back']=anchor('report/employee_activity', 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$edit_id=$this->input->post("edit_id");
		//set common properties
		//$this->output->enable_profiler(1);
		
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');
		$project=$this->input->post('project');
		$site=$this->input->post('site');
		$nts=$this->input->post('nts');
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
		$data['transaction_employee']=$this->transaction_employee_model->get_employee_activity($date_from,$date_to,$project,$site,$nts);
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
		$data['filter_nts']=$nts;
		$data['filter_site_name']=$site_name;
		$data['meal_allowance']=$this->transaction_employee_model->calc_meal_allowance($date_from,$date_to,$project,$site,$nts);

		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('report/employee_activity',$data);
		$this->load->view('template/footer');
	}
}

/* End of file transaction_employee.php */
/* Location: ./application/controllers/transaction_employee.php */
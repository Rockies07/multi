<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utility extends User_Access_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('employee_model','employee_model',TRUE);
		$this->load->model('subgroup_model','subgroup_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('home_leave_model','home_leave_model',TRUE);
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('transaction_journal_model','transaction_journal_model',TRUE);
		$this->load->model('schedule_model','schedule_model',TRUE);
		$this->load->model('repayment_model','repayment_model',TRUE);
	}
	 
	function get_employee_detail($nts,$transaction_date)
	{	
		$nts=rawurldecode($nts);
		$transaction_date=rawurldecode($transaction_date);
		$name="";
		$position="";
		$hourly_rate="0.00";
		$ot_rate="0.00";
	
		$get_setting=$this->setting_model->get_by_id('1');
		$get_user_data=$this->employee_model->get_employee_by_value('nts',$nts);
		$name=$get_user_data->name;
		$position=$get_user_data->position;
		$hourly_rate=$get_user_data->hourly_rate;
		
		$time = mktime(0, 0, 0, date('m',strtotime($transaction_date)), date('d',strtotime($transaction_date)), date('Y',strtotime($transaction_date)));
		$weekday = date('w', $time);
		if ($weekday == 0)
		{
			$ot_multiple=$get_setting->ot_sunday;
		}
		else
		{
			$ot_multiple=$get_setting->ot_weekday;
		}
		
		$ot_rate=$hourly_rate*$ot_multiple;
		
		$data['name']=$name;
		$data['position']=$position;
		$data['hourly_rate']=$hourly_rate;
		$data['ot_rate']=$ot_rate;

		if($name=="")
		{
			$data['error']=1;
		}
		else
		{
			$data['error']=0;
		}
		echo json_encode($data);
    	exit();
	}

	function get_employee_check_hours($nts,$transaction_date)
	{	
		$nts=rawurldecode($nts);
		$transaction_date=rawurldecode($transaction_date);
	
		$get_user_data=$this->transaction_employee_model->get_employee_by_value($nts,$transaction_date);
		$get_hour=$get_user_data->work_hour;

		if($get_hour>=8)
		{
			$data['error']=1;
			$data['work_hour']=$get_hour;
		}
		else
		{
			$data['error']=0;
		}
		echo json_encode($data);
    	exit();
	}
	
 	function get_exist_group($nts)
	{	
		$nts=rawurldecode($nts);
	
		$get_user_data=$this->subgroup_model->get_employee_by_value('nts',$nts);

		if($get_user_data->nts!="")
		{
			$data['error']=1;
		}
		else
		{
			$data['error']=0;
		}
		echo json_encode($data);
    	exit();
	}

	function update_supply_transaction($id,$work_hour,$ot_hour,$ns)
	{
		$id=rawurldecode($id);
		$work_hour=rawurldecode($work_hour);
		$ot_hour=rawurldecode($ot_hour);
		$ns=rawurldecode($ns);

		$get_transaction_detail=$this->transaction_employee_model->get_by_id($id);
		$hourly_rate=$get_transaction_detail->hourly_rate;
		$ot_rate=$get_transaction_detail->ot_rate;
		$position=$get_transaction_detail->position;
		$date=$get_transaction_detail->date;

		$normal_salary=$hourly_rate*$work_hour;
		$ot_salary=$ot_rate*$ot_hour;

		$time = mktime(0, 0, 0, date('m',strtotime($date)), date('d',strtotime($date)), date('Y',strtotime($date)));
		$weekday = date('w', $time);

		$get_setting=$this->setting_model->get_by_id('1');
		if (($weekday == 0)||($ph))
		{
			$meal_min_hour=8+($get_setting->meal_min_hour);
		}
		else
		{
			$meal_min_hour=$get_setting->meal_min_hour;
		}

		if($ot_hour>=$meal_min_hour)
		{
			$meal_fee=$get_setting->meal_fee;
		}
		else
		{
			$meal_fee=0;
		}

		$is_ns=$ns; //night shift
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
			'work_hour'=>$work_hour,
			'ot_hour'=>$ot_hour,
			'normal_salary'=>$normal_salary,
			'ot_salary'=>$ot_salary,
			'meal_fee'=>$meal_fee,
			'ns_fee'=>$ns_fee,
			'updateby'=>$this->access->get_username(),
			'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->transaction_employee_model->update($id,$transaction_employee);

		$data['result']=1;
		$data['normal_salary']="$".number_format($normal_salary,2);
		$data['ot_salary']="$".number_format($ot_salary,2);
		$data['meal_fee']="$".number_format($meal_fee,2);
		$data['ns_fee']="$".number_format($ns_fee,2);
		echo json_encode($data);
		exit();
	}

	function save_reinstate($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$nts=$string_data_arr[0];

		$start_work_date=$string_data_arr[1];

		$prev_work_exp_year=$string_data_arr[2];
		$prev_work_exp_month=$string_data_arr[3];
		$prev_work_exp_day=$string_data_arr[4];
		$wp_no=$string_data_arr[5];
		$fin_no=$string_data_arr[6];

		$wp_application_date=$string_data_arr[7];
		$wp_issued_date=$string_data_arr[8];
		$wp_exp_date=$string_data_arr[9];
		
		$get_user_data=$this->employee_model->get_employee_by_value('nts',$nts);
		$id=$get_user_data->id;

		$employee=array(
			'status'=>'Active',
			'start_work_date'=>$start_work_date,
			'prev_work_exp_year'=>$prev_work_exp_year,
			'prev_work_exp_month'=>$prev_work_exp_month,
			'prev_work_exp_day'=>$prev_work_exp_day,
			'wp_no'=>$wp_no,
			'fin_no'=>$fin_no,
			'wp_application_date'=>$wp_application_date,
			'wp_issued_date'=>$wp_issued_date,
			'wp_exp_date'=>$wp_exp_date,
			'updateby'=>$this->access->get_username(),
			'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->employee_model->update($id,$employee);

		$data['result']=1;
		$data['id']=$id;
		$data['nts']=$nts;
		$data['start_work_date']=$start_work_date;
		$data['prev_work_date_year']=$prev_work_date_year;
		$data['prev_work_date_month']=$prev_work_date_month;
		$data['prev_work_date_day']=$prev_work_date_day;
		$data['wp_no']=$wp_no;
		$data['fin_no']=$fin_no;
		$data['wp_application_date']=$wp_application_date;
		$data['wp_issued_date']=$wp_issued_date;
		$data['wp_exp_date']=$wp_exp_date;
		$data['string_data']=$string_data;
		echo json_encode($data);
		exit();
	}

	function save_home_leave($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$nts=$string_data_arr[0];

		$start_hl_date=$string_data_arr[1];

		$end_hl_date=$string_data_arr[2];
		
		$get_user_data=$this->employee_model->get_employee_by_value('nts',$nts);
		$id=$get_user_data->id;
		$position=$get_user_data->position;

		$home_leave=array(
			'nts'=>$nts,
			'start_hl_date'=>$start_hl_date,
			'end_hl_date'=>$end_hl_date,
			'createdate'=>date('Y-m-d H:i:s',now()),
			'createby'=>$this->access->get_username(),
			'updateby'=>$this->access->get_username(),
			'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->home_leave_model->insert($home_leave);

		$date_start=$start_hl_date;
		while (strtotime($date_start)<=strtotime($end_hl_date)) 
		{
			$transaction_employee=array(
					'date'=>$date_start,
					'project_id'=>'1',
					'site_id'=>'1',
					'nts'=>$nts,
					'position'=>$position,
					'levy'=>'0.00000',
					'dormitory'=>'0.00000',
					'transportation'=>'0.00000',
					'administration'=>'0.00000',
					'operation'=>'0.00000',
					'createdate'=>date('Y-m-d H:i:s',now()),
					'createby'=>$this->access->get_username(),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
					
			$id=$this->transaction_employee_model->insert($transaction_employee);

			$this->transaction_employee_model->update_daily_expenses($date_start);

			$date_start=date('Y-m-d', strtotime($date_start.' + 1 day'));
		}

		$data['result']=1;
		$data['date_start']=$date_start;

		echo json_encode($data);
		exit();
	}

	function update_home_leave($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$nts=$string_data_arr[1];

		$start_hl_date=$string_data_arr[2];
		$end_hl_date=$string_data_arr[3];

		$home_leave_detail=$this->home_leave_model->get_by_id($id);
		$prev_start_hl_date=$home_leave_detail->start_hl_date;
		$prev_end_hl_date=$home_leave_detail->end_hl_date;
		$createdate=$home_leave_detail->createdate;
		$createby=$home_leave_detail->createby;
		
		$get_user_data=$this->employee_model->get_employee_by_value('nts',$nts);
		$position=$get_user_data->position;

		$home_leave=array(
			'nts'=>$nts,
			'start_hl_date'=>$start_hl_date,
			'end_hl_date'=>$end_hl_date,
			'updateby'=>$this->access->get_username(),
			'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->home_leave_model->update($id,$home_leave);

		$this->transaction_employee_model->delete_home_leave($nts,$prev_start_hl_date,$prev_end_hl_date);

		$date_start=$start_hl_date;
		while (strtotime($date_start)<=strtotime($end_hl_date)) 
		{
			$transaction_employee=array(
					'date'=>$date_start,
					'project_id'=>'1',
					'site_id'=>'1',
					'nts'=>$nts,
					'position'=>$position,
					'levy'=>'0.00000',
					'dormitory'=>'0.00000',
					'transportation'=>'0.00000',
					'administration'=>'0.00000',
					'operation'=>'0.00000',
					'createdate'=>$createdate,
					'createby'=>$createby,
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
					
			$id=$this->transaction_employee_model->insert($transaction_employee);

			$this->transaction_employee_model->update_daily_expenses($date_start);

			$date_start=date('Y-m-d', strtotime($date_start.' + 1 day'));
		}

		$data['result']=1;
		$data['date_start']=$date_start;

		echo json_encode($data);
		exit();
	}

	function update_statement($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$site=$string_data_arr[1];
		$amount=$string_data_arr[2];
		$date=$string_data_arr[3];
		$cheque=$string_data_arr[4];
		$payer_payee=$string_data_arr[5];
		$ledger=$string_data_arr[6];
		$gst=$string_data_arr[8];
		$account=$string_data_arr[9];
		$type=$string_data_arr[10];
		$project_id=$string_data_arr[7];
		$description=$string_data_arr[11];
		$description=str_replace("xyz","/",$description);

		if($type=="Expenses")
		{
			$type="Expenses";
			$amount=$amount*-1;
		}
		else
		{
			$type="Deposit";
		}

		if($gst)
		{
			$amount_gst=$amount-($amount*7/100);
		}
		else
		{
			$amount_gst=$amount;
		}

		$transaction_journal=array(
				'project_id'=>$project_id,
				'site_id'=>$site,
				'date'=>$date,
				'amount'=>$amount,
				'amount_gst'=>$amount_gst,
				'account_id'=>$account,
				'ledger_id'=>$ledger,
				'cheque'=>$cheque,
				'payer_payee'=>$payer_payee,
				'gst'=>$gst,
				'description'=>$description,
				'type'=>$type,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->transaction_journal_model->update($id,$transaction_journal);

		$data['result']=1;

		echo json_encode($data);
		exit();
	}

	function update_repayment($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$date=$string_data_arr[1];
		$principal=$string_data_arr[2];
		$other_fee=$string_data_arr[3];
		$account=$string_data_arr[4];
		$receipt=$string_data_arr[5];
		$remark=$string_data_arr[6];
		$remark=str_replace("xyz","/",$remark);

		$repayment=array(
				'repayment_date'=>$date,
				'principal'=>$principal,
				'other_fee'=>$other_fee,
				'account_id'=>$account,
				'receipt'=>$receipt,
				'remark'=>$remark,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->repayment_model->update($id,$repayment);

		$data['result']=1;

		echo json_encode($data);
		exit();
	}

	function update_calendar_drag($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$day=$string_data_arr[1];

		$get_schedule_detail=$this->schedule_model->get_by_id($id);

		foreach ($get_schedule_detail as $schedule_item) 
		{
			$get_start=$schedule_item->start;
			$get_ref=$schedule_item->ref;
			$get_end=$schedule_item->end;

			$current_start=date('Y-m-d H:i:s',strtotime($day." days", strtotime($get_start)));
			
			if($get_end!="0000-00-00 00:00:00")
			{
				$current_end=date('Y-m-d H:i:s',strtotime($day." days", strtotime($get_end)));
			}
			else
			{
				$current_end="0000-00-00";
			}

			$schedule=array(
				'start'=>$current_start,
				'end'=>$current_end,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
			);

			$this->schedule_model->update_by_ref($get_ref,$schedule);
		}
		
		$data['result']=1;
		$data['start']=$get_ref;

		echo json_encode($data);
		exit();
	}

	function update_calendar_resize($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$sec=$string_data_arr[1];

		$get_schedule_detail=$this->schedule_model->get_by_id($id);

		foreach ($get_schedule_detail as $schedule_item) 
		{
			$get_ref=$schedule_item->ref;
			$get_end=$schedule_item->end;

			$end_in_sec=strtotime($get_end);
			$new_end=$end_in_sec+$sec;
			
			if($get_end!="0000-00-00 00:00:00")
			{
				$current_end=date('Y-m-d H:i:s',$new_end);
			}
			else
			{
				$current_end="0000-00-00";
			}

			$schedule=array(
				'end'=>$current_end,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
			);

			$this->schedule_model->update_by_ref($get_ref,$schedule);
		}
		
		$data['result']=1;
		$data['start']=$current_end;

		echo json_encode($data);
		exit();
	}
}



/* End of file utility.php */
/* Location: ./application/controllers/utility.php */
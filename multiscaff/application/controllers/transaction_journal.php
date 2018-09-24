<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_journal extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('transaction_journal_model','transaction_journal_model',TRUE);
		$this->load->model('transaction_employee_model','transaction_employee_model',TRUE);
		$this->load->model('site_model','site_model',TRUE);
		$this->load->model('ledger_model','ledger_model',TRUE);
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('account_model','account_model',TRUE);
		$this->load->model('project_model','project_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['transaction_journal']=$this->transaction_journal_model->get_data_list();
		
		if (empty($data['transaction_journal']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('transaction_journal/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('site','Site','required');
	}
	
	function get_site_list_by_value($value)
	{
		echo(json_encode($this->site_model->get_site_list_by_value($value,'Closed')));
		echo(exit());
	}
	
	function journal_statement($id=0)
	{
		$data['action']=site_url('transaction_journal/journal_statement');
		$data['link_back']=anchor('transaction_journal/journal_statement', 'Back', array('class'=>'back'));
		
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
			$data['transaction_journal']=$this->transaction_journal_model->get_data_list($date_from,$date_to,$project,$site);
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['project']=$this->project_model->get_data_list();
			$data['site']=$this->site_model->get_data_list(1,'Closed');
			$data['account']=$this->account_model->get_data_list();
			$data['ledger']=$this->ledger_model->get_data_list();
			$data['filter_date_from']=$date_from;
			$data['filter_date_to']=$date_to;
			$data['filter_project']=$project;
			$data['filter_project_name']=$project_name;
			$data['filter_site']=$site;
			$data['filter_site_name']=$site_name;
			$data['edit_id']=$id;

			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_journal/statement',$data);
			$this->load->view('template/footer');
		}
		else
		{
			$get_transaction_detail=$this->transaction_journal_model->get_by_id($edit_id);
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
			$transaction_journal=array(
				'work_hour'=>$work_hour,
				'ot_hour'=>$ot_hour,
				'normal_salary'=>$normal_salary,
				'ot_salary'=>$ot_salary,
				'meal_fee'=>$meal_fee,
				'ns_fee'=>$ns_fee,
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
			);
							
			$this->transaction_journal_model->update($edit_id,$transaction_journal);
			
			$data['transaction_journal']=$this->transaction_journal_model->get_data_list($date_from,$date_to,$project,$site);
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list(1,'Closed');
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
			$this->load->view('transaction_journal/detail',$data);
			$this->load->view('template/footer');
		}
	}

	function account_summary()
	{
		$data['action']=site_url('transaction_journal/account_summary');
		$data['link_back']=anchor('transaction_journal/account_summary', 'Back', array('class'=>'back'));
		
		$data['notification']="";
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
		$data['account_summary']=$this->transaction_journal_model->get_account_summary($date_from,$date_to,$project,$site);
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$data['project']=$this->project_model->get_data_list();
		$data['site']=$this->site_model->get_data_list(1,'Closed');
		$data['filter_date_from']=$date_from;
		$data['filter_date_to']=$date_to;
		$data['filter_project']=$project;
		$data['filter_project_name']=$project_name;
		$data['filter_site']=$site;
		$data['filter_site_name']=$site_name;

		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('transaction_journal/account_summary',$data);
		$this->load->view('template/footer');
	}
	
	function add_expenses()
	{
		$data['action']=site_url('transaction_journal/add_expenses');
		
		$data['notification']="";
		//set common properties
		//$this->output->enable_profiler(1);
		$this->_set_rules();
				
		if($this->form_validation->run() === FALSE)
		{
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list(1,'Closed');
			$data['account']=$this->account_model->get_data_list();
			$data['ledger']=$this->ledger_model->get_data_list();
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_journal/index_expenses',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data
			$site=$this->input->post('site');
			$get_site_detail=$this->site_model->get_by_id($site);
			$project_id=$get_site_detail->project_id;

			for($i=1;$i<=30;$i++)
			{
				$amount=$this->input->post('amount_'.$i);
				if($amount>0)
				{
					$date_str=$this->input->post('date_'.$i);
					$date_arr=explode("/",$date_str);
					$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

					$amount=$amount*-1;
					$account=$this->input->post('account_'.$i);
					$ledger=$this->input->post('ledger_'.$i);
					$cheque=$this->input->post('cheque_'.$i);
					$payer_payee=$this->input->post('payer_payee_'.$i);
					$gst=$this->input->post('gst_'.$i);
					if($gst)
					{
						$amount_gst=$amount-($amount*7/100);
					}
					else
					{
						$amount_gst=$amount;
					}

					$description=$this->input->post('description_'.$i);

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
							'type'=>"Expenses",
							'createdate'=>date('Y-m-d H:i:s',now()),
							'createby'=>$this->access->get_username(),
							'updateby'=>$this->access->get_username(),
							'updatedate'=>date('Y-m-d H:i:s',now())
					);
							
					$id=$this->transaction_journal_model->insert($transaction_journal);
				}
			}
					
				//set form input nama ="id"
			$this->validation->id=$id;
					
			redirect('transaction_journal/add_expenses');
		}
	}

	function add_deposit()
	{
		$data['action']=site_url('transaction_journal/add_deposit');
		
		$data['notification']="";
		//set common properties
		//$this->output->enable_profiler(1);
		$this->_set_rules();
				
		if($this->form_validation->run() === FALSE)
		{
			$data['title']=$this->access->get_site_name();
			$data['site_name']=$this->access->get_sys_name();	
			$data['quote']=$this->access->get_sys_motto();
			$data['site']=$this->site_model->get_data_list(1,'Closed');
			$data['account']=$this->account_model->get_data_list();
			$data['ledger']=$this->ledger_model->get_data_list();
			$this->load->view('template/header',$data);
			$this->load->view('template/sidelink');
			$this->load->view('transaction_journal/index_deposit',$data);
			$this->load->view('template/footer');
		}
		else
		{
			//save data
			$site=$this->input->post('site');
			$get_site_detail=$this->site_model->get_by_id($site);
			$project_id=$get_site_detail->project_id;

			for($i=1;$i<=30;$i++)
			{
				$amount=$this->input->post('amount_'.$i);
				if($amount>0)
				{
					$date_str=$this->input->post('date_'.$i);
					$date_arr=explode("/",$date_str);
					$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

					$account=$this->input->post('account_'.$i);
					$ledger=$this->input->post('ledger_'.$i);
					$cheque=$this->input->post('cheque_'.$i);
					$payer_payee=$this->input->post('payer_payee_'.$i);
					$gst='0';
					if($gst)
					{
						$amount_gst=$amount-($amount*7/100);
					}
					else
					{
						$amount_gst=$amount;
					}

					$description=$this->input->post('description_'.$i);

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
							'type'=>"Deposit",
							'createdate'=>date('Y-m-d H:i:s',now()),
							'createby'=>$this->access->get_username(),
							'updateby'=>$this->access->get_username(),
							'updatedate'=>date('Y-m-d H:i:s',now())
					);
							
					$id=$this->transaction_journal_model->insert($transaction_journal);
				}
			}
					
				//set form input nama ="id"
			$this->validation->id=$id;
					
			redirect('transaction_journal/add_deposit');
		}
	}
	
	function delete($id,$page)
	{
		//delete transaction_journal
		$this->transaction_journal_model->delete($id);
		redirect('transaction_journal/'.$page);
	}
}

/* End of file transaction_journal.php */
/* Location: ./application/controllers/transaction_journal.php */
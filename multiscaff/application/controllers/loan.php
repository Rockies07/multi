<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('loan_model','loan_model',TRUE);
		$this->load->model('account_model','account_model',TRUE);
		$this->load->model('repayment_model','repayment_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['loan']=$this->loan_model->get_data_list();
		
		if (empty($data['loan']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('loan/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('borrower_code','Borrower Code','trim');
		$this->form_validation->set_rules('borrower_name','Name','required');
		$this->form_validation->set_rules('borrower_contact','Contact','required');
		$this->form_validation->set_rules('borrower_hm_contact','Hm Contact','trim');
		$this->form_validation->set_rules('borrower_address','Address','required');
		$this->form_validation->set_rules('borrower_description','Description','trim');
		$this->form_validation->set_rules('loan_no','Loan No.','required');
		$this->form_validation->set_rules('date','Loan Date','required');
		$this->form_validation->set_rules('amount','Loan Amount','required|numeric');
		$this->form_validation->set_rules('remark','Remark','trim');
		$this->form_validation->set_rules('loan_no','Loan No.','trim');
		$this->form_validation->set_rules('account_id','Account ID','trim');
		$this->form_validation->set_rules('term','Term','trim');
		$this->form_validation->set_rules('package','Package','trim');
	}
	
	function add($id=0)
	{
		$data['action']=site_url('loan/add/'.$id);
		$data['link_back']=anchor('loan/add/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;

		if($id!="0")
		{
			$data['edit_loan']=$this->loan_model->get_by_id($id);
		}

		$edit_id=$this->input->post('edit_id');
		
		$date_str=$this->input->post('date');
		$date_arr=explode("/",$date_str);
		$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		
		if($edit_id>"0")
		{
			$amount=$this->input->post('amount');
			$term=$this->input->post('term');
			//if update from existing data
			$loan=array(
					'borrower_code'=>$this->input->post('borrower_code'),
					'borrower_name'=>$this->input->post('borrower_name'),
					'borrower_contact'=>$this->input->post('borrower_contact'),
					'borrower_hm_contact'=>$this->input->post('borrower_hm_contact'),
					'borrower_address'=>$this->input->post('borrower_address'),
					'borrower_description'=>$this->input->post('borrower_description'),
					'date'=>$date,
					'account_id'=>$this->input->post('account_id'),
					'amount'=>$amount,
					'loan_no'=>$this->input->post('loan_no'),
					'remark'=>$this->input->post('remark'),
					'package'=>$this->input->post('package'),
					'term'=>$term,
					'balance'=>$amount,
					'createdate'=>date('Y-m-d H:i:s',now()),
					'createby'=>$this->access->get_username(),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->loan_model->update($edit_id,$loan);
			//$this->output->enable_profiler(1);
			redirect('loan/detail/'.$edit_id);
		}
		else
		{
			$this->_set_rules();
			
			if($this->form_validation->run() === FALSE)
			{
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$data['account']=$this->account_model->get_data_list();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('loan/add',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$date_str=$this->input->post('deadline');
				$date_arr=explode("/",$date_str);
				$deadline=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
				$amount=$this->input->post('amount');
				$term=$this->input->post('term');

				$loan=array(
						'borrower_code'=>$this->input->post('borrower_code'),
						'borrower_name'=>$this->input->post('borrower_name'),
						'borrower_contact'=>$this->input->post('borrower_contact'),
						'borrower_hm_contact'=>$this->input->post('borrower_hm_contact'),
						'borrower_address'=>$this->input->post('borrower_address'),
						'borrower_description'=>$this->input->post('borrower_description'),
						'date'=>$date,
						'account_id'=>$this->input->post('account_id'),
						'amount'=>$amount,
						'loan_no'=>$this->input->post('loan_no'),
						'remark'=>$this->input->post('remark'),
						'package'=>$this->input->post('package'),
						'term'=>$term,
						'balance'=>$amount,
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);

				$id=$this->loan_model->insert($loan);

				if($term=="Open")
				{
					$term=1;
				}
				$principal=$amount/$term;

				$repayment=array(
						'loan_id'=>$id,
						'repayment_date'=>date('Y-m-d',now()),
						'account_id'=>$this->input->post('account_id'),
						'principal'=>$principal,
						'other_fee'=>'0.00',
						'receipt'=>'',
						'remark'=>$this->input->post('remark'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$idr=$this->repayment_model->insert($repayment);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('loan/detail/'.$id);
			}
		}
		//set common properties
		//$this->output->enable_profiler(1);
	}

	function payment($loan_id)
	{
		$data['action']=site_url('loan/payment/'.$id);
		$data['link_back']=anchor('loan/payment/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";

		$date_str=$this->input->post('repayment_date');
		$date_arr=explode("/",$date_str);
		$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		
		//set common properties
		//$this->output->enable_profiler(1);
		
		$repayment_id=$this->input->post('repayment_id');
		$repayment=array(
				'loan_id'=>$loan_id,
				'repayment_date'=>$date,
				'account_id'=>$this->input->post('account_id'),
				'principal'=>$this->input->post('principal'),
				'other_fee'=>$this->input->post('other_fee'),
				'remark'=>$this->input->post('remark'),
				'status'=>'1',
				'receipt'=>$this->input->post('receipt'),
				'createdate'=>date('Y-m-d H:i:s',now()),
				'createby'=>$this->access->get_username(),
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
		$id=$this->repayment_model->update($repayment_id,$repayment);

		$amount=$this->input->post('amount');
		$term=$this->input->post('term');
		if($term=="Open")
		{
			$term=1;
		}
		$principal=$amount/$term;

		$repayment=array(
				'loan_id'=>$loan_id,
				'repayment_date'=>date('Y-m-d',now()),
				'account_id'=>$this->input->post('account_id'),
				'principal'=>$principal,
				'other_fee'=>'0',
				'status'=>'0',
				'receipt'=>'',
				'createdate'=>date('Y-m-d H:i:s',now()),
				'createby'=>$this->access->get_username(),
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);

		$id=$this->repayment_model->insert($repayment);
					
		//set form input nama ="id"
		$this->validation->id=$id;
			
		redirect('loan/detail/'.$loan_id);
	}

	function detail($id="")
	{
		$data['action']=site_url('loan/payment/'.$id);
		$data['link_back']=anchor('loan/detail/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		
		$data['loan']=$this->loan_model->get_by_id($id);
		$data['repayment']=$this->repayment_model->get_by_loan_id($id);
		$data['account']=$this->account_model->get_data_list();
		
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('loan/detail',$data);
		$this->load->view('template/footer');
	}
	
	function delete($id,$page)
	{
		//delete loan
		$this->loan_model->delete($id);
		redirect('loan/'.$page);
	}

	function delete_repayment($id,$loan_id)
	{
		//delete loan
		$get_repayment_count=$this->repayment_model->get_repayment_count($loan_id);
		if($get_repayment_count<=1)
		{
			$get_loan_detail=$this->loan_model->get_by_id($loan_id);

			$amount=$get_loan_detail->amount;
			$term==$get_loan_detail->term;
			if($term=="Open")
			{
				$term=1;
			}
			$principal=$amount/$term;
			$account_id=$get_loan_detail->account_id;

			$repayment=array(
				'loan_id'=>$loan_id,
				'repayment_date'=>date('Y-m-d',now()),
				'account_id'=>$account_id,
				'principal'=>$principal,
				'other_fee'=>'0.00',
				'receipt'=>'',
				'createdate'=>date('Y-m-d H:i:s',now()),
				'createby'=>$this->access->get_username(),
				'updateby'=>$this->access->get_username(),
				'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$idr=$this->repayment_model->insert($repayment);
		}

		$this->repayment_model->delete($id);
		redirect('loan/detail/'.$loan_id);
	}
}

/* End of file loan.php */
/* Location: ./application/controllers/loan.php */
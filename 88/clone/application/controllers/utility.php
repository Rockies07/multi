<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utility extends User_Access_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ic_model','ic_model',TRUE);
		$this->load->model('client_model','client_model',TRUE);
		$this->load->model('address_model','address_model',TRUE);
		$this->load->model('repayment_model','repayment_model',TRUE);
		$this->load->model('loan_model','loan_model',TRUE);
		$this->load->model('transaction_journal_model','transaction_journal_model',TRUE);
	}
	 
	function get_ic_type_detail($value)
	{	
		$value=rawurldecode($value);
	
		$get_detail=$this->ic_model->get_detail_by_value($value);

		$count=count($get_detail);

		$data['count']=$count;
		$data['result']=$get_detail;

		echo json_encode($data);
    	exit();
	}

	function get_ic_type()
	{	
		$get_detail=$this->ic_model->get_foreiger_doc();

		$count=count($get_detail);

		$data['count']=$count;
		$data['result']=$get_detail;

		echo json_encode($data);
    	exit();
	}

	function get_client_detail($doc_no)
	{	
		$get_detail=$this->client_model->get_by_id($doc_no);

		$data['client']=$get_detail;

		echo json_encode($data);
    	exit();
	}

	function get_address($value)
	{	
		$value=rawurldecode($value);
	
		$get_detail=$this->address_model->get_data_list($value);

		$count=count($get_detail);

		$data['count']=$count;
		$data['result']=$get_detail;

		echo json_encode($data);
    	exit();
	}

	function get_address_walkup($value)
	{	
		$value=rawurldecode($value);
	
		$get_detail=$this->address_model->get_buildingnumber_walkup($value);

		$count=count($get_detail);

		$data['count']=$count;
		$data['result']=$get_detail;

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
		$interest=$string_data_arr[3];
		$other_permit=$string_data_arr[4];
		$account=$string_data_arr[5];
		$receipt=$string_data_arr[6];
		$remark=$string_data_arr[7];
		$remark=str_replace("xyz","/",$remark);
		$loanid=$string_data_arr[8];


		$repayment=array(
				'actualrepaydate'=>$date,
				'principal'=>$principal,
				'interest'=>$interest,
				'other_permit'=>$other_permit,
				'account_id'=>$account,
				'receiptno'=>$receipt,
				'remark'=>$remark,
				'updatedby'=>$this->access->get_user_id(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->repayment_model->update($id,$repayment);
		$this->repayment_model->update_balance($loanid);

		$get_client_detail=$this->loan_model->get_client_particular($loanid);
		$get_doc_no=$get_client_detail->doc_no;
		$get_name=$get_client_detail->name;
		$payer_payee=$get_doc_no." - ".$get_name;
		$transaction_journal=array(
				'date'=>$date,
				'amount'=>$principal,
				'account_id'=>$account,
				'invoice_no'=>$receipt,
				'cheque'=>$receipt,
				'description'=>$remark,
				'updatedby'=>$this->access->get_user_id(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
		$journal_id=$this->transaction_journal_model->update_by_trans_id_type($id,$transaction_journal,'2');

		$transaction_journal=array(
				'date'=>$date,
				'amount'=>$interest,
				'account_id'=>$account,
				'invoice_no'=>$receipt,
				'cheque'=>$receipt,
				'description'=>$remark,
				'updatedby'=>$this->access->get_user_id(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
		$journal_id=$this->transaction_journal_model->update_by_trans_id_type($id,$transaction_journal,'63');

		$transaction_journal=array(
				'date'=>$date,
				'amount'=>$other_permit,
				'account_id'=>$account,
				'invoice_no'=>$receipt,
				'cheque'=>$receipt,
				'description'=>$remark,
				'updatedby'=>$this->access->get_user_id(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
		$journal_id=$this->transaction_journal_model->update_by_trans_id_type($id,$transaction_journal,'65');

		$data['result']=1;

		echo json_encode($data);
		exit();
	}

	function update_statement($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("---",$string_data);

		$id=$string_data_arr[0];
		$amount=$string_data_arr[1];
		$date=$string_data_arr[2];
		$cheque=$string_data_arr[3];
		$payer_payee=$string_data_arr[4];
		$ledger=$string_data_arr[5];
		$description=$string_data_arr[6];
		$description=str_replace("xyz","/",$description);
		$account=$string_data_arr[7];
		$type=$string_data_arr[8];
		$invoice_no=$string_data_arr[9];

		if($type=="Expenses")
		{
			$type="Expenses";
			$amount=$amount*-1;
		}
		else
		{
			$type="Deposit";
		}

		$transaction_journal=array(
				'date'=>$date,
				'invoice_no'=>$invoice_no,
				'amount'=>$amount,
				'account_id'=>$account,
				'ledger_id'=>$ledger,
				'cheque'=>$cheque,
				'payer_payee'=>$payer_payee,
				'description'=>$description,
				'type'=>$type,
				'updatedby'=>$this->access->get_user_id(),
				'updatedate'=>date('Y-m-d H:i:s',now())
		);
						
		$this->transaction_journal_model->update($id,$transaction_journal);

		$data['result']=1;

		echo json_encode($data);
		exit();
	}
}



/* End of file utility.php */
/* Location: ./application/controllers/utility.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends User_Access_Controller 
{
	public $user;
	
	/**
	 * Constructor
	 */
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('setting_model');
		$this->CI->load->model('loan_model');
		$this->CI->load->model('repayment_model');
		$this->CI->load->model('transaction_journal_model');

		$this->setting_model =& $this->CI->setting_model;
		$this->loan_model =& $this->CI->loan_model;
		$this->repayment_model =& $this->CI->repayment_model;
		$this->transaction_journal_model =& $this->CI->transaction_journal_model;
	}
	
	/**
	 * Check User Login
	 */
	function set_number($value)
	{
		if($value>0)
		{
			$result = "<font color='blue'>$value</font>";
		}
		else
		{
			$result = "<font color='red'>$value</font>";
		}
		return $result;
	}

	function get_interest_per_term($loanamount,$interest,$is_amt,$term,$package)
	{
		$setting_content=$this->setting_model->get_setting_by_id('mdm_company_setting_content',$this->CI->session->userdata('company'));
		$dec_rounding=$setting_content->dec_rounding;

		switch($package)
		{
			case 'Monthly': $divider=12; break;
			case 'B/Weekly': $divider=26; break;
			case 'Weekly': $divider=52; break;
			case 'Daily': $divider=365; break;
			default: $divider=12; break;
		}

		if($is_amt)
		{
			if($term>0)
			{
				$result=$interest/$term;
			}
			else
			{
				$result=$interest;
			}
		}
		else
		{
			$result=$loanamount*$interest/$divider/100;
		}

		$dec_divider=1;
		for($i=1;$i<=$dec_rounding;$i++)
		{
			$dec_divider=$dec_divider*10;
		}

		$result=floor($result*$dec_divider)/$dec_divider;

		return $result;
	}

	function get_interest_total($loanamount,$interest,$is_amt,$term,$package)
	{
		$setting_content=$this->setting_model->get_setting_by_id('mdm_company_setting_content',$this->CI->session->userdata('company'));
		$dec_rounding=$setting_content->dec_rounding;

		switch($package)
		{
			case 'Monthly': $divider=12; break;
			case 'B/Weekly': $divider=26; break;
			case 'Weekly': $divider=52; break;
			case 'Daily': $divider=365; break;
			default: $divider=12; break;
		}

		if($term<=0)
		{
			$term=1;
		}

		if($is_amt)
		{
			$result=$interest;
		}
		else
		{
			$result=$loanamount*$interest/$divider/100*$term;
		}

		$dec_divider=1;
		for($i=1;$i<=$dec_rounding;$i++)
		{
			$dec_divider=$dec_divider*10;
		}

		$result=floor($result*$dec_divider)/$dec_divider;

		return $result;
	}

	function get_principal($loanamount,$term)
	{
		if($term>0)
		{
			$get_principal=$loanamount/$term;
		}
		else
		{
			$get_principal=$loanamount;
		}

		return $get_principal;
	}

	function get_repay_amount($loanamount,$interest,$is_amt,$term,$package)
	{
		$get_interest=$this->get_interest_per_term($loanamount,$interest,$is_amt,$term,$package);

		$get_principal=$this->get_principal($loanamount,$term);

		$repay_amt=$get_interest+$get_principal;

		return $repay_amt;
	}

	function get_last_receiptno()
	{
		$setting_numbering=$this->setting_model->get_setting_by_id('mdm_company_setting_numbering',$this->CI->session->userdata('company'));

		$get_receiptno_prefix=$setting_numbering->receiptno_prefix;
		$get_receiptno_suffix=$setting_numbering->receiptno_suffix;
		$get_receiptno_width=$setting_numbering->receiptno_width;
		$get_receiptno_start=$setting_numbering->receiptno_start;
		$get_last_receiptno=$this->repayment_model->get_last_receiptno()->receiptno;
		
		$get_last_receiptno_arr=explode($get_receiptno_prefix, $get_last_receiptno);
		if($get_last_receiptno_arr[1]!="")
		{
			$get_last_receiptno_arr=explode($get_receiptno_suffix, $get_last_receiptno_arr[1]);
			$get_count=$get_last_receiptno_arr[0];
			$get_count++;

			$get_last_receiptno=$get_receiptno_prefix."".sprintf("%0$get_receiptno_width"."d","$get_count")."".$get_receiptno_suffix;
		}
		else
		{
			$get_last_receiptno=$get_receiptno_prefix."".sprintf("%0$get_receiptno_width"."d","$get_receiptno_start")."".$get_receiptno_suffix;
		}

		return $get_last_receiptno;
	}

	function get_last_loanno()
	{
		$setting_numbering=$this->setting_model->get_setting_by_id('mdm_company_setting_numbering',$this->CI->session->userdata('company'));
		
		$get_loanno_prefix=$setting_numbering->loanno_prefix;
		$get_loanno_suffix=$setting_numbering->loanno_suffix;
		$get_loanno_width=$setting_numbering->loanno_width;
		$get_loanno_start=$setting_numbering->loanno_start;
		$get_last_loan_no=$this->loan_model->get_last_loan_no()->loanno;
		
		$get_last_loan_no_arr=explode($get_loanno_prefix, $get_last_loan_no);
		if($get_last_loan_no_arr[1]!="")
		{
			$get_last_loan_no_arr=explode($get_loanno_suffix, $get_last_loan_no_arr[1]);
			$get_count=$get_last_loan_no_arr[0];
			$get_count++;

			$get_last_loan_no=$get_loanno_prefix."".sprintf("%0$get_loanno_width"."d","$get_count")."".$get_loanno_suffix;
		}
		else
		{
			$get_last_loan_no=$get_loanno_prefix."".sprintf("%0$get_loanno_width"."d","$get_loanno_start")."".$get_loanno_suffix;
		}

		return $get_last_loan_no;
	}

	function get_last_invoice_no()
	{
		$setting_numbering=$this->setting_model->get_setting_by_id('mdm_company_setting_numbering',$this->CI->session->userdata('company'));
		
		$get_accno_prefix=$setting_numbering->accno_prefix;
		$get_accno_suffix=$setting_numbering->accno_suffix;
		$get_accno_width=$setting_numbering->accno_width;
		$get_accno_start=$setting_numbering->accno_start;
		$get_last_invoice_no=$this->transaction_journal_model->get_last_invoice_no($get_accno_prefix)->invoice_no;
		
		$get_last_invoice_no_arr=explode($get_accno_prefix, $get_last_invoice_no);
		if($get_last_invoice_no_arr[1]!="")
		{
			$get_last_invoice_no_arr=explode($get_accno_suffix, $get_last_invoice_no_arr[1]);
			$get_count=$get_last_invoice_no_arr[0];
			$get_count++;

			$get_last_invoice_no=$get_accno_prefix."".sprintf("%0$get_accno_width"."d","$get_count")."".$get_accno_suffix;
		}
		else
		{
			$get_last_invoice_no=$get_accno_prefix."".sprintf("%0$get_accno_width"."d","$get_accno_start")."".$get_accno_suffix;
		}

		return $get_last_invoice_no;
	}

	function get_next_payment_date($loan_id,$package="",$get_last_payment_date="")
	{	
		if($package=="")
		{
			$get_loan_detail=$this->loan_model->get_by_id($loan_id);
			$package=$get_loan_detail->package;
			$last_payment_date=$this->repayment_model->get_last_payment_date($loan_id)->repaydate;
		}
		else
		{
			$last_payment_date=$get_last_payment_date;
		}

		switch($package)
		{
			case "Monthly":$add_date="+1 month";break;
			case "B/Weekly":$add_date="+15 day";break;
			case "Weekly":$add_date="+7 day";break;
			case "Daily":$add_date="+1 day";break;
			default:$add_date="+1 month";break;
		}

		$next_payment_date = strtotime($add_date, strtotime($last_payment_date));

		return $next_payment_date;
	}
}

/* End of file access.php */
/* Location: ./application/libraries/access.php */
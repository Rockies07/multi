<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends User_Access_Controller 
{
	private $limit=30;
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('transaction_model','transaction_model',TRUE);
	}
	 
	function index()
	{	
		$data['customer']=$this->customer_model->get_customer_list();

		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('transaction/index',$data);
		$this->load->view('template/footer');
	}


	function update_pm_clr_single($string_data)
	{
		$string_data=rawurldecode($string_data);
		$string_data_arr=explode("XXX",$string_data);
		
		$type=$string_data_arr[0];
		$method=$string_data_arr[1];
		$ref=$string_data_arr[2];
		$value=$string_data_arr[3];
		$amount=$string_data_arr[4];
		$total_due=$string_data_arr[5];
		$total_outstanding=$string_data_arr[6];
		$grand_total=$string_data_arr[7];
		$memberid=$string_data_arr[8];

		if($method=='payment')
		{
			$table_name='bmdatabase_payment';
		}
		else
		{
			$table_name='bmdatabase_wlplaceout';
		}

		if($type=='clr')
		{
			$transaction=array(
				'clr'=>$value
			);
		}
		else
		{
			$transaction=array(
				'pm'=>$value
			);

			if($value=='1')
			{
				$amt_due=$total_due+$amount;
				$amt_outstanding=$total_outstanding-$amount;
				$test="$total_due-$amount $total_outstanding+$amount";
			}
			else
			{
				$amt_due=$total_due-$amount;
				$amt_outstanding=$total_outstanding+$amount;
				$test="$total_due+$amount $total_outstanding-$amount";
			}

			$total=$amt_due+$amt_outstanding;

			$member_total=array(
				'total'=>$total,
				'outstanding'=>$amt_outstanding,
				'amountdue'=>$amt_due,
			);

			$this->transaction_model->update_member_total($memberid,$member_total);
		}

		$this->transaction_model->update($table_name,$ref,$transaction);

		$data['result']="$type $method $ref $value $test";

		echo json_encode($data);
		exit();
	}

	function update_all_pm_clr($type,$memberid,$value)
	{
		if($type=='clr')
		{
			$transaction=array(
				'clr'=>$value
			);
		}
		else
		{
			$transaction=array(
				'pm'=>$value
			);

			$get_total_payment=$this->transaction_model->get_sum_payment('bmdatabase_payment',$memberid)->amount;
			$get_total_placeout=$this->transaction_model->get_sum_payment('bmdatabase_wlplaceout',$memberid)->amount;
			$grand_total=$get_total_placeout+$get_total_payment;

			if($value=='1')
			{
				$total_outstanding=$grand_total;
				$total_amount_due=0-$grand_total;
			}
			else
			{
				$total_outstanding=0-$grand_total;
				$total_amount_due=$grand_total;
			}

			$member_total=array(
				'total'=>$grand_total,
				'outstanding'=>$total_outstanding,
				'amountdue'=>$total_amount_due,
			);

			$this->transaction_model->update_member_total($memberid,$member_total);
		}

		$this->transaction_model->update_by_member('bmdatabase_wlplaceout',$memberid,$transaction);
		$this->transaction_model->update_by_member('bmdatabase_payment',$memberid,$transaction);

		$data['result']="$type $memberid";

		echo json_encode($data);
		exit();
	}
}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */
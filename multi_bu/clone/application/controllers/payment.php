<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends User_Access_Controller 
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
		$this->load->model('member_model','member_model',TRUE);
		$this->load->model('transaction_model','transaction_model',TRUE);
	}
	 
	function index()
	{	
		$memberid=$this->input->post('memberid_1');
		if(isset($memberid))
		{
			$date=$this->input->post('date');

			for($i=1;$i<=60;$i++)
			{
				$memberid=$this->input->post('memberid_'.$i);
				$amount=$this->input->post('amount_'.$i);
				$remark=$this->input->post('remark_'.$i);
				$date_str=$this->input->post('date');
				$date_arr=explode("/",$date_str);
				$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

				if($memberid!="")
				{	

					$payment=array(
							'bmdate'=>$date,
							'memberid'=>strtoupper($memberid),
							'amount'=>$amount,
							'cpyaccount'=>'C-NOTE',
							'remark'=>$remark,
							'currencycode'=>'SGD',
							'type'=>'TRS',
							'entriesby'=>'CLONE',
							'entriesdate'=>date('Y-m-d h:i:s')
					);

					$id=$this->transaction_model->insert('bmdatabase_payment',$payment);

					$get_total_detail=$this->member_model->get_page_total($memberid);
					$total=$get_total_detail->total;
					$outstanding=$get_total_detail->outstanding;

					$member_total=array(
							'total'=>$total+$amount,
							'outstanding'=>$outstanding+$amount
					);

					$this->transaction_model->update_member_total($memberid,$member_total);
				}
			}
		}

		$data['member']=$this->member_model->get_member_report();
		$data['title'] = $this->access->get_site_name();
		$data['sys_name'] = $this->access->get_sys_name();
		$data['quote'] = $this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink',$data);
		$this->load->view('payment/index',$data);
		$this->load->view('template/footer');
	}

}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_profitloss extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
		$this->load->model('m_accounts','',TRUE);

	}

	function index()
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$userdata = $this->m_accounts->getinfo($session_data['uid']);
			$drawdate = $this->m_system->getpastdraw(300);
			if($this->input->post('fromdate') > $this->input->post('todate'))
			{
				$todate = $this->input->post('fromdate');
				$fromdate = $this->input->post('todate');
			}
			else
			{
				$fromdate = $this->input->post('fromdate');
				$todate = $this->input->post('todate');
			}

			$downline_data = $this->m_accounts->getdownlinedata_man();

			$drawcount = $this->m_system->get_draw_count($fromdate,$todate);
			
			$attributes = array(
						  'width'      => '1366',
						  'height'     => '768',
						  'scrollbars' => 'yes',
						  'status'     => 'no',
						  'resizable'  => 'yes',
						  'screenx'    => '0',
						  'screeny'    => '0'
						);

			$header_data = array(
				'sitename' => $serverdata['sitename'],
				'uid' => $session_data['uid'],
				'bigvalue' => $serverdata['bigprice'],
				'smallvalue' => $serverdata['smallprice'],
				'closetime' => $serverdata['closetime'],
				'userdata' => $userdata,
				'drawdate' => $drawdate,
				'downline_data' => $downline_data,
			);

			$this->session->set_userdata('side_page', '3');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_plreport_man'); 

		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
	
	
	function view($uid = 'null',$fromdate = 'null',$todate ='null')
	{
		$this->load->helper(array('form'));
		$attributes = array(
					  'width'      => '1366',
					  'height'     => '768',
					  'scrollbars' => 'yes',
					  'status'     => 'no',
					  'resizable'  => 'yes',
					  'screenx'    => '0',
					  'screeny'    => '0'
					);

		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$userdata = $this->m_accounts->getinfo($session_data['uid']);
			$drawdate = $this->m_system->getpastdraw(300);
			if($this->input->post('view'))
			{
				if($this->input->post('fromdate') > $this->input->post('todate'))
				{
					$todate = $this->input->post('fromdate');
					$fromdate = $this->input->post('todate');
				}
				else
				{
					$fromdate = $this->input->post('fromdate');
					$todate = $this->input->post('todate');
				}
			}

			if($this->input->post('uid'))
			{
				$uid = $this->input->post('uid');
			}
			
			if($uid == '#')
			{
				echo '<script type="text/javascript">alert("Please select downline!");</script>';
				redirect('c_profitloss', 'refresh');
			}
			
			$drawcount = $this->m_system->get_draw_count($fromdate,$todate);
			
			$uid_data = $this->m_accounts->getinfo2($uid);

			if(strlen($uid) == 3) //master calculation
				{
					$report_data = $this->m_system->get_report_man($todate,$fromdate,$uid);
					$report_share_downline = $this->m_system->get_share_downline_man($todate,$fromdate,$uid);
					$report_downline_total = $this->m_system->get_downline_total_man($todate,$fromdate,$uid);
					$downline_report_array = $this->m_system->get_downline_report_man($todate,$fromdate,$uid);
					
					$master_payable_nett = $report_data['total_strike'] - $report_data['total_ticket'] - $report_data['own_intake_tax'];
					
					$master_share = $report_data['share_po_amt'] + $report_data['share_co_amt'];
					$master_nett = $master_payable_nett + $master_share ;

					$downline_payable_nett = ($report_downline_total['total_strike'] - $report_downline_total['total_intake_strike']) - ($report_downline_total['total_po_ticket'] - $report_downline_total['total_intake_ticket']  - $report_downline_total['total_tax']);

					$downline_share = $report_downline_total['total_share_po'] + $report_downline_total['total_share_co'];
					$downline_nett = $downline_payable_nett + $downline_share;

					$po_wl = $master_nett - $downline_nett;

					$header_data = array(
							'sitename' => $serverdata['sitename'],
							'uid' => $uid,
							'bigvalue' => $serverdata['bigprice'],
							'smallvalue' => $serverdata['smallprice'],
							'closetime' => $serverdata['closetime'],
							'userdata' => $userdata,
							'drawdate' => $drawdate,
							'todate' => $todate,
							'fromdate' => $fromdate,
							'report_data' => $report_data,
							'master_payable_nett' => $master_payable_nett,
							'downline_payable_nett' => $downline_payable_nett,
							'master_nett' => $master_nett,
							'downline_nett' => $downline_nett,
							'po_wl' => $po_wl,
							'report_share_downline' => $report_share_downline,
							'report_downline_total' => $report_downline_total,
							'downline_report_array' => $downline_report_array,
							'drawcount' => $drawcount,
							'attributes' => $attributes,						
						);
						
				}

			if(strlen($uid) == 2) //master calculation
			{

				$report_data = $this->m_system->get_report($todate,$fromdate,$uid);
				$report_share_downline = $this->m_system->get_share_downline($todate,$fromdate,$uid);
				$report_downline_total = $this->m_system->get_downline_total($todate,$fromdate,$uid);
				$downline_report_array = $this->m_system->get_downline_report($todate,$fromdate,$uid);
				
				$master_payable_nett = ($report_data['total_meb_strike'] - ($report_data['total_own_strike'] + $report_data['total_downline_strike']) - $report_data['total_po_ticket'] + $report_data['total_intake_ticket'] - $report_data['total_intake_tax']);

				$downline_payable_nett =  ($report_data['total_meb_strike'] - $report_data['total_downline_strike']) - ($report_data['downline_total_po_ticket'] - $report_data['total_downline_intake_ticket'] + $report_data['total_downline_intake_tax']);

				
				$master_share = $report_data['share_co_amt'] + $report_data['share_po_amt'];
				$master_nett = $master_payable_nett + $master_share ;
				
				$downline_share = $report_share_downline['share_co'] + $report_share_downline['share_mas'] + $report_share_downline['share_po'];
				$downline_nett = $downline_payable_nett + $downline_share;

				$po_wl = $master_nett - $downline_nett;

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $uid,
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'userdata' => $userdata,
						'drawdate' => $drawdate,
						'todate' => $todate,
						'fromdate' => $fromdate,
						'drawcount' => $drawcount,	
						'report_data' => $report_data,
						'master_payable_nett' => $master_payable_nett,
						'downline_payable_nett' => $downline_payable_nett,
						'master_nett' => $master_nett,
						'downline_nett' => $downline_nett,
						'po_wl' => $po_wl,
						'report_share_downline' => $report_share_downline,
						'report_downline_total' => $report_downline_total,
						'downline_report_array' => $downline_report_array,
						'attributes' => $attributes,
					);
			}
			if(strlen($uid) == 4) //group calculation
			{
				$report_data = $this->m_system->get_report($todate,$fromdate,$uid);
				$report_share_downline = $this->m_system->get_share_downline($todate,$fromdate,$uid);
				$report_downline_total = $this->m_system->get_downline_total($todate,$fromdate,$uid);
				$downline_report_array = $this->m_system->get_downline_report($todate,$fromdate,$uid);
				
				$master_payable_nett = ($report_data['total_meb_strike'] - ($report_data['total_own_strike'] + $report_data['total_downline_strike']) - $report_data['total_po_ticket'] + $report_data['total_intake_ticket']);

				$downline_payable_nett =  ($report_data['total_meb_strike'] - $report_data['total_downline_strike']) - ($report_data['downline_total_po_ticket'] - $report_data['total_downline_intake_ticket']);


				$master_share = $report_data['share_co_amt'] + $report_data['share_po_amt'] + $report_data['share_mas_amt'];
				$master_nett = $master_payable_nett + $master_share - $report_data['total_intake_tax'];
				
				$downline_share = $report_share_downline['share_co'] + $report_share_downline['share_mas'] + $report_share_downline['share_agg'];
				$downline_nett = $downline_payable_nett + $downline_share - $report_data['total_downline_intake_tax'];

				$po_wl = $master_nett - $downline_nett;



				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $uid,
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'userdata' => $userdata,
						'todate' => $todate,
						'fromdate' => $fromdate,
						'drawdate' => $drawdate,
						'drawcount' => $drawcount,	
						'report_data' => $report_data,
						'master_payable_nett' => $master_payable_nett,
						'downline_payable_nett' => $downline_payable_nett,
						'master_nett' => $master_nett,
						'downline_nett' => $downline_nett,
						'po_wl' => $po_wl,
						'report_share_downline' => $report_share_downline,
						'report_downline_total' => $report_downline_total,
						'downline_report_array' => $downline_report_array,
						'attributes' => $attributes,
					);
			}
			if(strlen($uid) == 6) // agent calculation
			{
				$report_data = $this->m_system->get_report($todate,$fromdate,$uid);
				$report_downline_total = $this->m_system->get_downline_total($todate,$fromdate,$uid);
				$downline_report_array = $this->m_system->get_downline_report($todate,$fromdate,$uid);
				
				$master_payable_nett = ($report_data['total_meb_strike'] - ($report_data['total_own_strike']) - $report_data['total_po_ticket'] + $report_data['total_own_intake_ticket']);

				$master_share = $report_data['share_co_amt'] + $report_data['share_agg_amt'] + $report_data['share_mas_amt'];
				$master_nett = $master_payable_nett + $master_share - $report_data['total_own_intake_tax'];
				
				$downline_payable_nett = $report_data['downline_total_po_ticket'] - $report_data['total_meb_strike'];
				
				$agt_intake_wl = $report_data['total_own_intake_ticket'] - $report_data['total_own_strike'] - $report_data['total_own_intake_tax'];
				
				$po_wl = $downline_payable_nett + $master_nett;


				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $uid,
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'userdata' => $userdata,
						'drawdate' => $drawdate,
						'drawcount' => $drawcount,	
						'todate' => $todate,
						'fromdate' => $fromdate,
						'report_data' => $report_data,
						'master_payable_nett' => $master_payable_nett,
						'downline_payable_nett' => $downline_payable_nett,
						'master_nett' => $master_nett,
						'downline_report_array' => $downline_report_array,
						'report_downline_total' => $report_downline_total,
						'po_wl' => $po_wl,
						'attributes' => $attributes,
					);				
			}
		

			$this->session->set_userdata('side_page', '3');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');

			switch(strlen($uid))
			{
				case 3: $this->load->view('v_plreport_man_view'); 
						break;				
				case 2: $this->load->view('v_plreport_mas_view'); 
						break;
				case 4: $this->load->view('v_plreport_agg_view'); 
						break;
				case 6: $this->load->view('v_plreport_agt_view'); 
						break;
			}
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
}

?>


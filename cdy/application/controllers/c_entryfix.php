<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_entryfix extends CI_Controller 
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

		$timenow = date('H:i:s');
		$tdatenow = date('Y-m-d');
		$entrytime = date('Y-m-d H:i:s');
		
		
		switch(date("l"))
		{

			case "Wednesday":	if ($timenow >= "14:29:00" && $timenow <= "19:00:00")
			{
				echo '<script type="text/javascript">alert("FIX Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
				redirect('c_profile', 'refresh');
				break;
			}
			case "Saturday"	:	if ($timenow >= "14:29:00" && $timenow <= "19:00:00")
			{
				echo '<script type="text/javascript">alert("FIX Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
				redirect('c_profile', 'refresh');
				break;
			}
			case "Sunday"	:	if ($timenow >= "14:29:00" && $timenow <= "19:00:00")
			{
				echo '<script type="text/javascript">alert("FIX Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
				redirect('c_profile', 'refresh');
				break;
			}		
		}		
		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$userdata = $this->m_accounts->getinfo($session_data['uid']);
			$downlinedata = 0;
			$pagedata = 0;

			$downlinedata = $this->m_accounts->get_all_mas();

			$timenow = date('H:i:s');
			$timeonehour = date("H:i:s", strtotime ($serverdata['closetime']) + 55 * 60);
			$tdatenow = date('Y-m-d');
			$entrytime = date('Y-m-d H:i:s');


			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
					'downlinedata' => $downlinedata,
					'serverdata' => $serverdata,
					'pagedata' => $pagedata,
				);
		
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_fixentry'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function getmemberpage($uid)
	{
		if($this->session->userdata('userinfo'))
		{
			header('Content-Type: application/x-json; charset=utf-8');
			$meb_page = $this->m_accounts->getfixpage($uid);
			echo(json_encode($meb_page));
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function getfixpagedata($meb_id,$pageref)
	{
		if($this->session->userdata('userinfo'))
		{
			//header('Content-Type: application/x-json; charset=utf-8');
			//echo base64_decode($pageref);

			$fixpage_data = $this->m_accounts->getfixpagedata($meb_id,base64_decode($pageref));
			echo(json_encode($fixpage_data));
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function delfixpagedata($meb_id,$pageref)
	{
		if($this->session->userdata('userinfo'))
		{
			//header('Content-Type: application/x-json; charset=utf-8');
			$this->m_accounts->delfixpagedata($meb_id,base64_decode($pageref));
			//echo(json_encode($fixpage_data));
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}

	}


}

?>


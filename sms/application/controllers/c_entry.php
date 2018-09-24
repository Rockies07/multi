<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_entry extends CI_Controller 
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
			$server_data = $this->m_system->settings_server();
			$userdata = $this->m_accounts->getinfo($session_data['uid']);
			$downlinedata = 0;
			if(strlen($session_data['uid']) < 8)
			{
				$downlinedata = $this->m_accounts->getdownlinedata($session_data['uid']);
			}
			$timenow = date('H:i:s');
			$timeonehour = date("H:i:s", strtotime ($server_data['closetime']) + 55 * 60);
			$tdatenow = date('Y-m-d');
			$entrytime = date('Y-m-d H:i:s');


			switch(date("l"))
			{
				case "Monday"	:	$defaultday = '3';
									break;
				case "Tuesday"	:	$defaultday = '3';
									break;
				case "Wednesday":	if ($timenow >= $server_data['closetime'] and $timenow <= $timeonehour)
									{
										echo '<script type="text/javascript">alert("Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
										redirect('c_profile', 'refresh');
										break;
									}
									if ($timenow >= $timeonehour)
									{
										$defaultday = '2';
										$tdatenow = date('Y-m-d', strtotime('+ 1 day'));
										break;
									}
									$defaultday = '3';
									break;
				case "Thursday"	:	$defaultday = '2';
									break;
				case "Friday"	:	$defaultday = '2';
									break;
				case "Saturday"	:	if ($timenow >= $server_data['closetime'] and $timenow <= $timeonehour)
									{
										echo '<script type="text/javascript">alert("Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
										redirect('c_profile', 'refresh');
										break;
									}
									if ($timenow >= $timeonehour)
									{
										$defaultday = '7';
										$tdatenow = date('Y-m-d', strtotime('+ 1 day'));
										break;
									}
									$defaultday = '2';
									break;
				case "Sunday"	:	if ($timenow >= $server_data['closetime'] and $timenow <= $timeonehour)
									{
										echo '<script type="text/javascript">alert("Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
										redirect('c_profile', 'refresh');
										break;
									}
									if ($timenow >= $timeonehour)
									{
										$defaultday = '3';
										$tdatenow = date('Y-m-d', strtotime('+ 1 day'));
										break;
									}
									$defaultday = '7';
									break;
									
			}
			
			// Set next 3 drawdate
			$drawdate = $this->m_system->getdraw($tdatenow);

			$header_data = array(
					'sitename' => $server_data['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $server_data['bigprice'],
					'smallvalue' => $server_data['smallprice'],
					'closetime' => $server_data['closetime'],
					'downlinedata' => $downlinedata,
					'userdata' => $userdata,
					'drawdate' => $drawdate,
					'defaultday' => $defaultday,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_entry'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function getmemberdata($uid)
	{
		if($this->session->userdata('userinfo'))
		{
			//header('Content-Type: application/x-json; charset=utf-8');
			echo(json_encode($this->m_accounts->getmebdata($uid)));
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}

	}

	function getmemberbal($uid)
	{
		if($this->session->userdata('userinfo'))
		{
			header('Content-Type: application/x-json; charset=utf-8');
			$meb_bal = $this->m_accounts->getinfo($uid);
			echo(json_encode($meb_bal['balance']));
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}

	}

}

?>


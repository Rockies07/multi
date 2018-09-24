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

	function entry($meb_id = "null")
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$server_data = $this->m_system->settings_server();
			
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
										break;
									}
									$defaultday = '7';
									break;
									
			}

			if($meb_id == "null")
			{
				$downlinedata = $this->m_accounts->get_all_mas();
				$header_data = array(
						'sitename' => $server_data['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $server_data['bigprice'],
						'smallvalue' => $server_data['smallprice'],
						'closetime' => $server_data['closetime'],
						'downlinedata' => $downlinedata,
						'defaultday' => $defaultday,
					);
				$this->load->view('v_entry',$header_data); // default view after login is profile
			}
			else
			{
				$userdata = $this->m_accounts->getinfo($meb_id);
				if ($userdata['meb_id'] == "")
				{
					echo '<script type="text/javascript">alert("This account is currently closed!");</script>';
				}
				else
				{
					$header_data = array(
							'sitename' => $server_data['sitename'],
							'uid' => $session_data['uid'],
							'bigvalue' => $server_data['bigprice'],
							'smallvalue' => $server_data['smallprice'],
							'closetime' => $server_data['closetime'],
							'uid' => $meb_id,
							'userdata' => $userdata,
							'defaultday' => $defaultday,
						);
					$this->load->view('v_entry_meb',$header_data); // default view after login is profile
				}
			}
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


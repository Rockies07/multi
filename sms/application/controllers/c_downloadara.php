<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_downloadara extends CI_Controller 
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
			$drawdate = $this->m_system->gettransdraw(15);
			if($this->input->post('draw'))
			{
				$today = $this->input->post('draw');
				$bookie_array = $this->m_system->getbookieintake($today);

				$header_data = array(
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $drawdate,
						'today' => $today,
						'bookie_array' => $bookie_array,
					);
			}
			else
			{
				$header_data = array(
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $drawdate,
					);

			}

			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_downloadara'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function downloadara($drawdate, $bok_id)
	{
		$this->load->helper('download');

		$td = $drawdate;
		$arr = explode ("-", $td);
		$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
		$t = date('D',$stamp);
		if (strcmp($t, 'Wed') == 0 ){$araday = 3;}
		if (strcmp($t, 'Sat') == 0 ){$araday = 6;}
		if (strcmp($t, 'Sun') == 0 ){$araday = 7;}
		else
		{
			echo '<script type="text/javascript">alert("Unable to get drawdate");</script>';
		}
		$aradata_array = $this->m_system->getaradata($drawdate, $bok_id);
		foreach($aradata_array as $ara)
		{
			//7+0052+   0+ 10+b1*001|y
			if (!isset($datafile))
			{
				$datafile = str_pad($araday,1)."+".$ara['number']."+".str_pad($ara['amt_big'],4," ",STR_PAD_LEFT)."+".str_pad($ara['amt_small'],3," ", STR_PAD_LEFT)."+".$ara['bok_id']."*001|y\n";
			}
			else
			{
				$datafile .= str_pad($araday,1)."+".$ara['number']."+".str_pad($ara['amt_big'],4," ",STR_PAD_LEFT)."+".str_pad($ara['amt_small'],3," ", STR_PAD_LEFT)."+".$ara['bok_id']."*001|y\n";
			}
		}
		$name = $bok_id.'.ara';

		//echo $datafile;
		force_download($name, $datafile); 

		//echo '<script type="text/javascript">alert("Download function");</script>';
		//force_download($bookie_data['bok_id'], 'data');
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_posummary extends CI_Controller 
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
			$drawdate = $this->m_system->gettransdraw(15);
			$downline_data = $this->m_accounts->getdownlinedata($session_data['uid']);
			
			$attributes = array(
						  'width'      => '615',
						  'height'     => '570',
						  'scrollbars' => 'yes',
						  'status'     => 'no',
						  'resizable'  => 'no',
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
			$this->load->view('v_posummary'); // default view after login is profile
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
					  'width'      => '1024',
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
			$drawdate = $this->m_system->getpastdraw(15);
			
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
				redirect('c_posummary', 'refresh');
			}
						
			$drawcount = $this->m_system->get_draw_count($fromdate,$todate);
			
			$uid_data = $this->m_accounts->secure_getinfo_po($uid, $session_data['uid']);
			
			if(!isset($uid_data))
			{
				echo '<script type="text/javascript">alert("Unable to view other downline!");</script>';
				//redirect('c_login', 'refresh');
			}



			if(strlen($uid) < 8)
			{
				$downline_array = $this->m_accounts->get_downline_with_trans($uid, $fromdate, $todate);
				$downline_type = $this->m_accounts->getdownlinetype($uid);
				$placeout_data = $this->m_accounts->getmyplaceouttotal($fromdate,$todate,$uid);
				$myintake_data = $this->m_accounts->getmyintaketotal($fromdate,$todate,$uid);
			}
			else
			{
				$downline_array = array();
				$downline_array[] = $userdata;
			}
			
			$downline_podata = array();
			$downline_podata['totalbig'] = 0;
			$downline_podata['totalibig'] = 0;
			$downline_podata['totalsmall'] = 0;
			$downline_podata['totalismall'] = 0;
			$downline_podata['totalstrike'] = 0;
			$downline_podata['totaldisc'] = 0;
			$downline_podata['totalamount'] = 0;
			
			$downline_indata = array();
			$downline_indata['totalbig'] = 0;
			$downline_indata['totalsmall'] = 0;
			$downline_indata['totalintax'] = 0;
			$downline_indata['totalamount'] = 0;
			
			
			foreach($downline_array as $downlinedata) // calculate downline po - individual tax
			{
				if(strlen($uid) < 8)
				{
					$downplaceout_array = $this->m_accounts->getmyplaceouttotal($fromdate,$todate,$downlinedata[$downline_type]);
				}
				else
				{
					$downplaceout_array = $this->m_accounts->getmyplaceouttotal($fromdate,$todate,$uid);
				}
				
				$downpoamount = (($downplaceout_array['amt_big'] + $downplaceout_array['amt_ibig']) * $serverdata['bigprice']) + (($downplaceout_array['amt_small'] + $downplaceout_array['amt_ismall']) * $serverdata['smallprice']);
				$amountdisc = $downplaceout_array['com_amount'];
				
				$downline_podata['totalbig'] = $downline_podata['totalbig'] + $downplaceout_array['amt_big'];
				$downline_podata['totalibig'] = $downline_podata['totalibig'] + $downplaceout_array['amt_ibig'];
				$downline_podata['totalsmall'] = $downline_podata['totalsmall'] + $downplaceout_array['amt_small'];
				$downline_podata['totalismall'] = $downline_podata['totalismall'] + $downplaceout_array['amt_ismall'];
				$downline_podata['totalstrike'] = $downline_podata['totalstrike'] + $downplaceout_array['strike'];
				$downline_podata['totaldisc'] = $downline_podata['totaldisc'] + $amountdisc;
				$downline_podata['totalamount'] = $downline_podata['totalamount'] + $downpoamount;
				
			}
			
			if(strlen($uid) < 8)
			{
				$downline_indata = $this->m_accounts->getdownintaketotal($fromdate,$todate,$uid);
			}
			
			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $uid,
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
					'drawdate' => $drawdate,
					'fromdate' => $fromdate,
					'todate' => $todate,
					'downline_array' => $downline_array,
					'downline_type' => $downline_type,
					'placeout_data' => $placeout_data,
					'downline_podata' => $downline_podata,
					'myintake_data' => $myintake_data,
					'downline_indata' => $downline_indata,
					'attributes' => $attributes,
				);				


			switch(strlen($uid))
			{
				case 6	:	$view_page = "v_posummary_agt_view";
							break;
				default	:	$view_page = "v_posummary_view";
							break;
			}
			
			$this->session->set_userdata('side_page', '3');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');			
			$this->load->view($view_page);
			
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
}

?>


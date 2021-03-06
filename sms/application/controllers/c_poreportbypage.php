<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_poreportbypage extends CI_Controller 
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
			
			if($this->input->post('view'))
			{
				$downline_array = 0;
				$downline_type = 0;
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
				if(strlen($session_data['uid']) < 8)
				{
					$downline_array = $this->m_accounts->getdownline($session_data['uid']);
					$downline_type = $this->m_accounts->getdownlinetype($session_data['uid']);
				}
				else
				{
					$downline_array = array();
					$downline_array[] = $userdata;
					//print_r($downline_array);
				}
				$attributes = array(
							  'width'      => '915',
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
						'drawdate' => $drawdate,
						'userdata' => $userdata,
						'downline_array' => $downline_array,
						'fromdate' => $fromdate,
						'todate' => $todate,
						'downline_type' => $downline_type,
						'attributes' => $attributes,
					);
			}

			else
			{
				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $drawdate,
						'userdata' => $userdata,
					);
			}

			$this->session->set_userdata('side_page', '3');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_reportbypage'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


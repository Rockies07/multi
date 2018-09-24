<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_payoutco extends CI_Controller 
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

			if($this->input->post('Payout'))
			{
				echo '<script type="text/javascript">confirm("Ready to Payout?");</script>';
			}

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
			$this->load->view('v_payoutco'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function getstatus($today)
	{
		if($this->session->userdata('userinfo'))
		{
			$log_array = $this->m_system->getstatus($today);
			$this->output->set_header('refresh:3; url='.site_url('c_payoutco/getstatus/'.$today));  
			$output_string = '';
			foreach ($log_array as $row)
			{
				echo $row['log'];
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


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_companypl extends CI_Controller 
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
		$this->load->library('form_validation');

		if($this->session->userdata('userinfo'))
		{
			$this->session->set_userdata('side_page', '4');

			if($_POST)
			{
				$session_data = $this->session->userdata('userinfo');
				$serverdata = $this->m_system->settings_server();
				$userdata = $this->m_accounts->getinfo($session_data['uid']);
				$drawdate = $this->m_system->getpastdraw(15);
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
								
				$drawcount = $this->m_system->get_draw_count($fromdate,$todate);
				
				$coy_pl_array = $this->m_system->get_coy_report($fromdate,$todate);
				$coy_pl_sum = $this->m_system->get_coy_sum_report($fromdate,$todate);
				$bok_pl_array = $this->m_system->get_bok_report($fromdate,$todate);
				$bok_pl_sum = $this->m_system->get_bok_sum_report($fromdate,$todate);

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'userdata' => $userdata,
						'drawdate' => $drawdate,
						'drawcount' => $drawcount,
						'coy_pl_array' => $coy_pl_array,
						'bok_pl_array' => $bok_pl_array,
						'coy_pl_sum' => $coy_pl_sum,
						'bok_pl_sum' => $bok_pl_sum,
						'exp' => $serverdata['exp'],
						'session_uid' => $session_data['uid'],
					);
				$this->load->view('v_header',$header_data);
				$this->load->view('v_sidelinks');
				$this->load->view('v_companypl'); 
			}
			else
			{
				$session_data = $this->session->userdata('userinfo');
				$serverdata = $this->m_system->settings_server();
				$userdata = $this->m_accounts->getinfo($session_data['uid']);
				$drawdate = $this->m_system->getpastdraw(15);

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'userdata' => $userdata,
						'drawdate' => $drawdate,
					);
				$this->load->view('v_header',$header_data);
				$this->load->view('v_sidelinks');
				$this->load->view('v_companypl'); // default view after login is profile
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


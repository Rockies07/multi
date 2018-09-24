<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_results extends CI_Controller 
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
			$date = $this->m_system->getpastdraw(15);

			if($this->input->post())
			{
				$drawdate = $this->input->post('fromdate');	

				$first_array = $this->m_system->get_results($drawdate,'1');
				$second_array = $this->m_system->get_results($drawdate,'2');
				$third_array = $this->m_system->get_results($drawdate,'3');
				$starts_array = $this->m_system->get_results($drawdate,'a');
				$cons_array = $this->m_system->get_results($drawdate,'b');

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $date,
						'selectdate' => $drawdate,
						'first_array' => $first_array,
						'second_array' => $second_array,
						'third_array' => $third_array,
						'starts_array' => $starts_array,
						'cons_array' => $cons_array,
						'userdata' => $userdata,
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
						'drawdate' => $date,
						'userdata' => $userdata,
					);
			}

			$this->session->set_userdata('side_page', '2');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_results'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


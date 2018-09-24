<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_addresults extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
	}

	function index()
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$drawdate = $this->m_system->gettransdraw(15);

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'closetime' => $serverdata['closetime'],
					'drawdate' => $drawdate,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_addresults'); // default view after login is profile

			if($this->input->post('Save'))
			{
				$today = $this->input->post('draw');
				$results_data = array();

				for($x=1; $x <= 10; $x++)
				{
					$results_data[] = array(
						'prizetype' => 'b',
						'number' => $this->input->post('cons'.$x),
						'drawdate' => $today,);
				}
				for($x=1; $x <= 10; $x++)
				{
					$results_data[] = array(
						'prizetype' => 'a',
						'number' => $this->input->post('start'.$x),
						'drawdate' => $today,);
				}
					$results_data[] = array(
						'prizetype' => '3',
						'number' => $this->input->post('pos3'),
						'drawdate' => $today,);

					$results_data[] = array(
						'prizetype' => '2',
						'number' => $this->input->post('pos2'),
						'drawdate' => $today,);

					$results_data[] = array(
						'prizetype' => '1',
						'number' => $this->input->post('pos1'),
						'drawdate' => $today,);

				//print_r($results_data);
				$this->m_system->insertresults($results_data);
				echo '<script type="text/javascript">alert("Results Saved!");</script>';
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


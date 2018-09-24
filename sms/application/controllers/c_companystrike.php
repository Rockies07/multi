<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_companystrike extends CI_Controller 
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
			$results_array = array();

			if($this->input->post())
			{
				$drawdate = $this->input->post('fromdate');

				$number_array = $this->m_system->get_results($drawdate,'1');
				foreach($number_array as $number_data)
				{
					$meb_strike_array = $this->m_system->get_results_details_meb($drawdate,$number_data['number'],'1');
					$coy_strike_array = $this->m_system->get_results_details_coy($drawdate,$number_data['number'],'1');
					$bok_strike_array = $this->m_system->get_results_details_bok($drawdate,$number_data['number'],'1');
					
					$results_array[] = array(
						'prizetype' => 'First',
						'number' => $meb_strike_array['number'],
						'member_big' => $meb_strike_array['member_big'],
						'member_small' => $meb_strike_array['member_small'],
						'member_strike' => $meb_strike_array['member_strike'],
						'company_big' => $coy_strike_array['company_big'],
						'company_small' => $coy_strike_array['company_small'],
						'company_strike' => $coy_strike_array['company_strike'],
						'bookie_big' => $bok_strike_array['bookie_big'],
						'bookie_small' => $bok_strike_array['bookie_small'],
						'bookie_strike' => $bok_strike_array['bookie_strike'],
						'other_big' => $meb_strike_array['other_big'],
						'other_small' => $meb_strike_array['other_small'],
						'other_strike' => $meb_strike_array['other_strike'],
					);
				}

				$number_array = $this->m_system->get_results($drawdate,'2');
				foreach($number_array as $number_data)
				{
					$meb_strike_array = $this->m_system->get_results_details_meb($drawdate,$number_data['number'],'2');
					$coy_strike_array = $this->m_system->get_results_details_coy($drawdate,$number_data['number'],'2');
					$bok_strike_array = $this->m_system->get_results_details_bok($drawdate,$number_data['number'],'2');
					
					$results_array[] = array(
						'prizetype' => 'Second',
						'number' => $meb_strike_array['number'],
						'member_big' => $meb_strike_array['member_big'],
						'member_small' => $meb_strike_array['member_small'],
						'member_strike' => $meb_strike_array['member_strike'],
						'company_big' => $coy_strike_array['company_big'],
						'company_small' => $coy_strike_array['company_small'],
						'company_strike' => $coy_strike_array['company_strike'],
						'bookie_big' => $bok_strike_array['bookie_big'],
						'bookie_small' => $bok_strike_array['bookie_small'],
						'bookie_strike' => $bok_strike_array['bookie_strike'],
						'other_big' => $meb_strike_array['other_big'],
						'other_small' => $meb_strike_array['other_small'],
						'other_strike' => $meb_strike_array['other_strike'],
					);
				}
				
				$number_array = $this->m_system->get_results($drawdate,'3');
				foreach($number_array as $number_data)
				{
					$meb_strike_array = $this->m_system->get_results_details_meb($drawdate,$number_data['number'],'3');
					$coy_strike_array = $this->m_system->get_results_details_coy($drawdate,$number_data['number'],'3');
					$bok_strike_array = $this->m_system->get_results_details_bok($drawdate,$number_data['number'],'3');
					
					$results_array[] = array(
						'prizetype' => 'Third',
						'number' => $meb_strike_array['number'],
						'member_big' => $meb_strike_array['member_big'],
						'member_small' => $meb_strike_array['member_small'],
						'member_strike' => $meb_strike_array['member_strike'],
						'company_big' => $coy_strike_array['company_big'],
						'company_small' => $coy_strike_array['company_small'],
						'company_strike' => $coy_strike_array['company_strike'],
						'bookie_big' => $bok_strike_array['bookie_big'],
						'bookie_small' => $bok_strike_array['bookie_small'],
						'bookie_strike' => $bok_strike_array['bookie_strike'],
						'other_big' => $meb_strike_array['other_big'],
						'other_small' => $meb_strike_array['other_small'],
						'other_strike' => $meb_strike_array['other_strike'],
					);
				}

				$number_array = $this->m_system->get_results($drawdate,'a');
				foreach($number_array as $number_data)
				{
					$meb_strike_array = $this->m_system->get_results_details_meb($drawdate,$number_data['number'],'a');
					$coy_strike_array = $this->m_system->get_results_details_coy($drawdate,$number_data['number'],'a');
					$bok_strike_array = $this->m_system->get_results_details_bok($drawdate,$number_data['number'],'a');
					
					$results_array[] = array(
						'prizetype' => 'Starters',
						'number' => $meb_strike_array['number'],
						'member_big' => $meb_strike_array['member_big'],
						'member_small' => $meb_strike_array['member_small'],
						'member_strike' => $meb_strike_array['member_strike'],
						'company_big' => $coy_strike_array['company_big'],
						'company_small' => $coy_strike_array['company_small'],
						'company_strike' => $coy_strike_array['company_strike'],
						'bookie_big' => $bok_strike_array['bookie_big'],
						'bookie_small' => $bok_strike_array['bookie_small'],
						'bookie_strike' => $bok_strike_array['bookie_strike'],
						'other_big' => $meb_strike_array['other_big'],
						'other_small' => $meb_strike_array['other_small'],
						'other_strike' => $meb_strike_array['other_strike'],
					);
				}
				
				$number_array = $this->m_system->get_results($drawdate,'b');
				foreach($number_array as $number_data)
				{
					$meb_strike_array = $this->m_system->get_results_details_meb($drawdate,$number_data['number'],'b');
					$coy_strike_array = $this->m_system->get_results_details_coy($drawdate,$number_data['number'],'b');
					$bok_strike_array = $this->m_system->get_results_details_bok($drawdate,$number_data['number'],'b');
					
					$results_array[] = array(
						'prizetype' => 'Cons',
						'number' => $meb_strike_array['number'],
						'member_big' => $meb_strike_array['member_big'],
						'member_small' => $meb_strike_array['member_small'],
						'member_strike' => $meb_strike_array['member_strike'],
						'company_big' => $coy_strike_array['company_big'],
						'company_small' => $coy_strike_array['company_small'],
						'company_strike' => $coy_strike_array['company_strike'],
						'bookie_big' => $bok_strike_array['bookie_big'],
						'bookie_small' => $bok_strike_array['bookie_small'],
						'bookie_strike' => $bok_strike_array['bookie_strike'],
						'other_big' => $meb_strike_array['other_big'],
						'other_small' => $meb_strike_array['other_small'],
						'other_strike' => $meb_strike_array['other_strike'],
					);
				}

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $date,
						'selectdate' => $drawdate,
						'userdata' => $userdata,
						'results_array' => $results_array,
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

			$this->session->set_userdata('side_page', '4');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_companystrike'); 


		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


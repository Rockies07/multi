<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_smsincoming extends CI_Controller 
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
			if($this->input->post())
			{
				$checklist_array = $this->input->post('check_list');
				foreach($checklist_array as $checklist_data)
				{
					$this->m_accounts->assign_sms($session_data['uid'], $checklist_data);
				}
				
			}
			$sms_array = $this->m_accounts->get_smsincoming();
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
					'closetime' => $serverdata['closetime'],
					'sms_array' => $sms_array,
					'attributes' => $attributes,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_smsincoming'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


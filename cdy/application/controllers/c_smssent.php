<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_smssent extends CI_Controller 
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
		
		$attributes2 = array(
			'width'      => '840',
			'height'     => '568',
			'scrollbars' => 'yes',
			'status'     => 'no',
			'resizable'  => 'no',
			'screenx'    => '0',
			'screeny'    => '0'
		);
		
		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$sms_date = $this->m_system->get_sms_date();
			
			if($this->input->post('delete'))
			{
				$checklist_array = $this->input->post('check_list');
				foreach($checklist_array as $checklist_data)
				{
					$this->m_accounts->assign_smstrash($checklist_data);
				}				
			}
			
			$filter_id=$this->input->post('filter_id');
			$filter_date=$this->input->post('filter_date');
			$filter_date_arr=explode(" ",$filter_date);
			$str_filter_date=$filter_date_arr[0];
			
			$sms_array = $this->m_accounts->get_smssent($filter_id,$str_filter_date);
			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'closetime' => $serverdata['closetime'],
					'sms_array' => $sms_array,
					'sms_date' => $sms_date,
					'filter_id' => $filter_id,
					'attributes2' => $attributes2,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_smssent'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


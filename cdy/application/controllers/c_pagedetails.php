<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_pagedetails extends CI_Controller 
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

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
				);

			//$this->load->view('v_pagedetails',$header_data); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function view($ref,$drawdate)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$tablecount = $this->m_accounts->getbetrecords_table($ref,$drawdate);
			$betdata = $this->m_accounts->getbetrecords_ref($ref,$drawdate);
			$pagearray = $this->m_accounts->getpagedetails($ref,$drawdate);
			$header_data = array(
					'betdata' => $betdata,
					'pagearray' => $pagearray,
					'tablecount' => $tablecount,
				);
			
			$this->load->view('v_pagedetails',$header_data); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


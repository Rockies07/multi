<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_Home extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);

	}

	function index()
	{
		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			//$data['uid'] = $session_data['uid'];
			//$data['account_type'] = $session_data['account_type'];
			//$data['account_db'] = $session_data['account_db'];

			$header_data = array(
				   'bigvalue' => $serverdata['bigvalue'],
				   'smallvalue' => $serverdata['smallvalue'],
				   'sitename' => $serverdata['sitename'],
				   'uid' => $session_data['uid'],
			  );
			$sidelink_data = array(
				   'closetime' => $serverdata['closetime'],
			  );

			switch(strlen($header_data['uid']))
			{
				case 2: $data["usertype"] = "master";
						$this->load->view('header_master',$header_data);
						$this->load->view('side_master',$sidelink_data);
						break;
				case 4: $data["usertype"] = "agentgrp";
						$this->load->view('header_agentgrp');
						$this->load->view('side_agentgrp');
						break;
				case 6: $data["usertype"] = "agent";
						$this->load->view('header_agent');
						$this->load->view('side_agent');
						break;
				case 8: $data["usertype"] = "member";
						$this->load->view('header_member');
						$this->load->view('side_member');
						break;
			}

			$this->load->view('table');
		}
		else
		{
			//If no session, redirect to login page
			redirect('v_login', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('v_login', 'refresh');
	}

}

?>


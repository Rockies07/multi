<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_companystake extends CI_Controller 
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
		$this->load->helper('download');
		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$drawdate = $this->m_system->get_generate_draw(15);
			//$this->output->enable_profiler(TRUE);

			if($this->input->post())
			{
				$today = $this->input->post('fromdate');
				$system_intake_data = $this->m_system->get_intake_details($today,'admin');
				$bookie_intake_data = $this->m_system->get_intake_details($today,'bookie');
				$master_po_data = $this->m_system->get_intake_details($today,'master');

				$header_data = array(
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'closetime' => $serverdata['closetime'],
						'system_intake_data' => $system_intake_data,
						'bookie_intake_data' => $bookie_intake_data,
						'master_po_data' => $master_po_data,
						'drawdate' => $drawdate,
						'today' => $today,
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
					);
			}
			$this->session->set_userdata('side_page', '4');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_companystake'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
	function download($type,$drawdate)
	{
		$this->load->helper('download');
		switch($type)
		{
			case 'sys_in'	: 	$file = "sys_in.ara";
								break;
			case 'sys_out'	:	$file = "sys_out.ara";
								break;
			case 'mas_out'	:	$file = "mas_out.ara";
								break;			
			default			:	die('Error');
		}
		$data = file_get_contents("/tmp/".$drawdate.$file); // Read the file's contents		
		force_download($file, $data);
	}
}

?>


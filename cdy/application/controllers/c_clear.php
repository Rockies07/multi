<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_clear extends CI_Controller 
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

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'closetime' => $serverdata['closetime'],
					'drawdate' => $drawdate,

				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_clear'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
	
	function clear()
	{
		if($this->input->post())
		{
			$drawdate = $this->input->post('draw');

			switch($this->input->post('clr'))
			{
				case 'Clear Payout':	$this->m_system->delete_table('pl_meb',$drawdate);
										$this->m_system->delete_table('pl_agt',$drawdate);
										$this->m_system->delete_table('pl_agg',$drawdate);
										$this->m_system->delete_table('pl_mas',$drawdate);
										$this->m_system->delete_table('pl_man',$drawdate);
										$this->m_system->delete_table('pl_coy',$drawdate);
										$this->m_system->delete_table('pl_bok',$drawdate);
										$this->m_system->delete_table('strike_users',$drawdate);
										$this->m_system->delete_table('strike_company',$drawdate);
										$this->m_system->delete_table('strike_bookie',$drawdate);
										echo '<script type="text/javascript">alert("'.$drawdate.' Payout Cleared!");</script>';
										break;
				case 'Clear Results':	$this->m_system->delete_table('results',$drawdate);
										echo '<script type="text/javascript">alert("'.$drawdate.' Results Cleared!");</script>';
										break;
				case 'Clear Gen ARA':	$this->m_system->delete_table('admin_intake',$drawdate);
										$this->m_system->delete_table('admin_intake_detail',$drawdate);
										$this->m_system->delete_table('admin_intake_temp',$drawdate);
										$this->m_system->delete_table('bookie_intake',$drawdate);
										$this->m_system->delete_table('bookie_intake_detail',$drawdate);
										$this->m_system->delete_table('bookie_intake_pool',$drawdate);
										$this->m_system->delete_table('master_po_detail',$drawdate);
										echo '<script type="text/javascript">alert("'.$drawdate.' Generate Cleared!");</script>';
										break;
				case 'Clear PO Return':	$this->m_system->delete_table('po_returns_bok',$drawdate);
										$this->m_system->delete_table('po_returns_man',$drawdate);
										$this->m_system->delete_table('po_returns_mas',$drawdate);
										$this->m_system->delete_table('po_returns_agg',$drawdate);
										echo '<script type="text/javascript">alert("'.$drawdate.' PO_Return Cleared!");</script>';
										break;
				default:				echo '<script type="text/javascript">alert("Error!");</script>';
			}

			redirect('c_clear', 'refresh');
		}
		else
		{
			echo "no direct script access!";
		}

	}
}

?>


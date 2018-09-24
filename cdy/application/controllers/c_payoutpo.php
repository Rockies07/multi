<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_payoutpo extends CI_Controller 
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
			if($this->input->post('draw'))
			{
				$today = $this->input->post('draw');
				$bookie_pl_array = $this->m_system->get_bookie_pl($today);

				$header_data = array(
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $drawdate,
						'today' => $today,
						'bookie_pl_array' => $bookie_pl_array,
					);
			}
			else
			{
				$header_data = array(
						'bigvalue' => $serverdata['bigprice'],
						'smallvalue' => $serverdata['smallprice'],
						'sitename' => $serverdata['sitename'],
						'uid' => $session_data['uid'],
						'closetime' => $serverdata['closetime'],
						'drawdate' => $drawdate,
					);

			}

			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_payoutpo'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function calculate_po()
	{
		if($this->input->post('Save'))
		{
			//$this->load->view('v_showpost');
			$total_po_amt = 0;

			for ($x = 1 ; $x < $this->input->post('count') ; $x++)
			{
				$amt = $this->input->post('amt'.$x);
				$bok_id = $this->input->post('bookieid'.$x);
				$drawdate = $this->input->post('draw');

				//$this->m_system->update_bookie_po($amt,$bok_id,$drawdate); // update bookie P.O return
				$total_po_amt = $total_po_amt + $amt;
			}

			//update manager po_return
			$manager_array = $this->m_system->get_all_users('users_man');
			foreach ($manager_array as $man_data)
			{

				$po_perc_data = $this->m_system->get_all_po_perc('users_man', $this->input->post('draw'), $man_data['man_id']);   // get po percentage
				if($po_perc_data['ticket_perc'] > 0 && $po_perc_data['share_po_perc'] > 0)
				{
					$po_return100 = $total_po_amt * ($po_perc_data['ticket_perc'] / 100);
					$po_return = $po_return100 * ($po_perc_data['share_po_perc'] / 100);
					$this->m_system->update_po('users_man', $po_return100, $po_return, $man_data['man_id'], $this->input->post('draw')); // update Manager P.O return
				}
			}
			
			//update master po_return
			$master_array = $this->m_system->get_all_users('users_mas');
			foreach ($master_array as $mas_data)
			{
				$upline_po_amt = $this->m_system->get_all_po_amt('users_man', $this->input->post('draw'), $mas_data['man_id']); // get upline po amt
				$po_perc_data = $this->m_system->get_all_po_perc('users_mas', $this->input->post('draw'), $mas_data['mas_id']);   // get po percentage
				if($po_perc_data['ticket_perc'] > 0 && $po_perc_data['share_po_perc'] > 0)
				{
					$po_return100 = $upline_po_amt * ($po_perc_data['ticket_perc'] / 100);
					$po_return = $po_return100 * ($po_perc_data['share_po_perc'] / 100);
					$this->m_system->update_po('users_mas', $po_return100, $po_return, $mas_data['mas_id'], $this->input->post('draw')); // update Manager P.O return
				}
			}
			
			//update group po_return
			$group_array = $this->m_system->get_all_users('users_agg');
			foreach ($group_array as $group_data)
			{
				$upline_po_amt = $this->m_system->get_all_po_amt('users_mas', $this->input->post('draw'), $group_data['mas_id']); // get upline po amt
				$po_perc_data = $this->m_system->get_all_po_perc('users_agg', $this->input->post('draw'), $group_data['agg_id']);   // get po percentage
				if($po_perc_data['ticket_perc'] > 0 && $po_perc_data['share_po_perc'] > 0)
				{
					$po_return100 = $upline_po_amt * ($po_perc_data['ticket_perc'] / 100);
					$po_return = $po_return100 * ($po_perc_data['share_po_perc'] / 100);
					$this->m_system->update_po('users_agg', $po_return100, $po_return, $group_data['agg_id'], $this->input->post('draw')); // update Manager P.O return
				}
			}

		}
		else
		{
			redirect('c_payoutpo', 'refresh');
		}
	}
}

?>


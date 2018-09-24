<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class sys_payout extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
		$this->load->model('m_accounts','',TRUE);
	}
	function calculate($date)
	{
		//Update Strike
		//Add PL for all levels
		$strike_users = array();
		$strike_company = array();
		$strike_bookie = array();
		$pl_bok = array();
		$pl_coy = array();
		$pl_man = array();
		$pl_mas = array();
		$pl_agg = array();
		$pl_agt = array();
		$pl_meb = array();
		
		$server_data = $this->m_system->settings_server();
		$results_array = $this->m_system->getresults($date);
		foreach ($results_array as $results_data)
		{
			//echo $results_data['number'].' '.$results_data['prizetype'].'<br>';			
			switch($results_data['prizetype'])
			{
				case '1':	$prize_type = '1';
							$payout_big = 4000;
							$payout_small = 3000;
							break;
				case '2':	$prize_type = '2';
							$payout_big = 2000;
							$payout_small = 2000;
							break;
				case '3':	$prize_type = '3';
							$payout_big = 1000;
							$payout_small = 1000;
							break;
				case 'a':	$prize_type = 'a';
							$payout_big = 500;
							$payout_small = 0;
							break;
				case 'b':	$prize_type = 'b';
							$payout_big = 150;
							$payout_small = 0;
							break;
			}

			$trans_array = $this->m_system->get_trans_number($date,$results_data['number']);

			foreach ($trans_array as $trans_data)
			{
				$strike_meb = ($trans_data['amt_big'] * $payout_big) + ($trans_data['amt_small'] * $payout_small);
				$strike_agt = ($trans_data['agt_intake_big'] * $payout_big) + ($trans_data['agt_intake_small'] * $payout_small);
				$strike_agg = ($trans_data['agg_intake_big'] * $payout_big) + ($trans_data['agg_intake_small'] * $payout_small);
				$strike_mas = ($trans_data['mas_intake_big'] * $payout_big) + ($trans_data['mas_intake_small'] * $payout_small);
				$masdata = $this->m_accounts->getinfo($trans_data['mas_id']);

				$strike_users[] = array(
					'drawdate' => $date,
					'number' => $results_data['number'],
					'amt_big' => $trans_data['amt_big'],
					'amt_small' => $trans_data['amt_small'],
					'prizetype' => $prize_type,
					'cmd' => $trans_data['cmd'],
					'meb_id' => $trans_data['meb_id'],
					'agt_id' => $trans_data['agt_id'],
					'agg_id' => $trans_data['agg_id'],
					'mas_id' => $trans_data['mas_id'],
					'man_id' => $masdata['man_id'],
					'agt_intake_big' => $trans_data['agt_intake_big'],
					'agt_intake_small' => $trans_data['agt_intake_small'],
					'agg_intake_big' => $trans_data['agg_intake_big'],
					'agg_intake_small' => $trans_data['agg_intake_small'],
					'mas_intake_big' => $trans_data['mas_intake_big'],
					'mas_intake_small' => $trans_data['mas_intake_small'],
					'meb_strike' => $strike_meb,
					'agt_strike' => $strike_agt,
					'agg_strike' => $strike_agg,
					'mas_strike' => $strike_mas,
					'ref' => $trans_data['ref'], );	
				
				//$this->m_system->update_strike($strike_meb,$trans_data['ref'],$date); // update bet_records strike
			}
			
			
			$admin_array = $this->m_system->get_admin_number($date,$results_data['number']);
			foreach ($admin_array as $admin_data)
			{
				$strike_amt = ($admin_data['amt_big'] * $payout_big) + ($admin_data['amt_small'] * $payout_small);
			
				$strike_company[] = array(
					'drawdate' => $date,
					'number' => $results_data['number'],
					'amt_big' => $admin_data['amt_big'],
					'amt_small' => $admin_data['amt_small'],
					'prizetype' => $prize_type,
					'coy_strike' => $strike_amt,
					 );			
			}

			$bookie_array = $this->m_system->get_bookie_number($date,$results_data['number']);
			foreach ($bookie_array as $bookie_data)
			{
				$strike_amt = ($bookie_data['amt_big'] * $payout_big) + ($bookie_data['amt_small'] * $payout_small);
			
				$strike_bookie[] = array(
					'drawdate' => $date,
					'bok_id' => $bookie_data['bok_id'],
					'number' => $results_data['number'],
					'amt_big' => $bookie_data['amt_big'],
					'amt_small' => $bookie_data['amt_small'],
					'prizetype' => $prize_type,
					'bok_strike' => $strike_amt,
					 );			
			}

		}// end of results loop

		//$this->m_system->insert_users_strike($strike_users); // insert user strike
		//$this->m_system->insert_admin_strike($strike_company); // insert admin strike
		//$this->m_system->insert_bookie_strike($strike_bookie); // insert bookie strike
		
		// calculate bookie ticket/strike
		$bookie_array = $this->m_system->get_all_users('users_bok');
		foreach ($bookie_array as $bookie_data)
		{

			$total_bookie_ticket = $this->m_system->get_bookie_ticket_detail($date, $bookie_data['bok_id']);   // already deducted po_comm of bookie setting
			$total_bookie_strike = $this->m_system->get_bookie_strike_detail($date, $bookie_data['bok_id']);

			$pl_bok[] = array(
				'drawdate' => $date,
				'bok_id' => $bookie_data['bok_id'],
				'total_ticket' => $total_bookie_ticket,
				'total_strike' => $total_bookie_strike,
				'po_return' => '',
				);
		}
		$this->m_system->insert_pl_bok($pl_bok); // insert bookie p/l

		// calculate master ticket/strike/sms/misc and %

		$total_co_ticket = $this->m_system->get_total_ticket($date); 
		$total_co_ticket = $total_co_ticket * (1 - ($server_data['placeout_comm']/100));

		$total_co_strike = $this->m_system->get_co_strike($date);
		$total_bookie_ticket = $this->m_system->get_bookie_ticket($date);   // already deducted po_comm of bookie setting
		$total_bookie_strike = $this->m_system->get_bookie_strike($date);
		$system_exp = $this->m_system->settings_server();

		$companywl = ($total_co_ticket - $total_co_strike - $total_bookie_ticket - $system_exp['exp']) + $total_bookie_strike;

		$master_array = $this->m_system->get_all_users('users_mas');
		foreach ($master_array as $master_data)
		{
			$master_share_co100 = 0;
			$master_share_co = 0;
			$total_strike = 0;
			$sms_charges = 0;
			$ticket_perc = 0;
			$total_intake_tax = 0;

			$ticket_data = $this->m_system->get_uid_ticket($date,$master_data['mas_id']); // get master ticket and tax info
			$strike_data = $this->m_system->get_uid_strike($date,$master_data['mas_id']); // all strike sum
			$sms_charges = $this->m_system->get_uid_sms($date,$master_data['mas_id']); // all sms charges
						
			$ticket_perc = ($ticket_data['own_po_amount'] / $total_co_ticket) * 100; // ticket % for this master in company

			$total_intake_tax = $ticket_data['own_tax_amount'] + $ticket_data['downline_tax_amount'];
			$total_strike = $strike_data['total_strike_amount'] - $strike_data['own_intake_strike'] - $strike_data['downline_intake_strike'];
			
			if($ticket_perc > 0)
			{
				$master_share_co100 = $companywl * ($ticket_perc / 100);
				$master_share_co = $master_share_co100 * ($master_data['share_co'] / 100);
			}
			else
			{
				$master_share_co100 = 0;
				$master_share_co = 0;
			}

			$pl_coy[] = array(
				'drawdate' => $date,
				'mas_id' => $master_data['mas_id'],
				'man_id' => $master_data['man_id'],
				'total_ticket' => $ticket_data['own_po_amount'],
				'total_strike' => $total_strike,
				'ticket_perc' => $ticket_perc,
				'intake_tax' => $total_intake_tax,
				'sms_charges' => $sms_charges['sms_charges'],
				'share_co_perc' => $master_data['share_co'],
				'share_co_amt' => $master_share_co,
				'share_co_amt100' => $master_share_co100,
				'share_po_perc' => $master_data['share_po'],
				'share_po_amt' => '',
				'share_po_amt100' => '',
				);

			$pl_mas[] = array(
				'drawdate' => $date,
				'man_id' => $master_data['man_id'],
				'mas_id' => $master_data['mas_id'],
				'placeout_comm' => $ticket_data['placeout_comm'],
				'intake_tax' => $ticket_data['intake_tax'],
				'total_po_big' => $ticket_data['total_po_big'],
				'total_po_small' => $ticket_data['total_po_small'],
				'total_intake_big' => $ticket_data['total_intake_big'],
				'total_intake_small' => $ticket_data['total_intake_small'],
				'ticket_perc' => $ticket_perc,
				'total_po_ticket' => $ticket_data['total_ticket_amount'],
				'downline_total_po_ticket' => $ticket_data['downline_po_amount'],
				'total_meb_strike' => $strike_data['total_strike_amount'],
				'total_own_strike' => $strike_data['own_intake_strike'],
				'total_downline_strike' => $strike_data['downline_intake_strike'],
				'total_intake_ticket' => $ticket_data['total_intake_amount'],
				'total_own_intake_ticket' => $ticket_data['own_intake_amount'],
				'total_downline_intake_ticket' => $ticket_data['downline_intake_amount'],
				'total_intake_tax' => $ticket_data['total_tax_amount'],
				'total_own_intake_tax' => $ticket_data['own_tax_amount'],
				'total_downline_intake_tax' => $ticket_data['downline_tax_amount'],
				'share_co_perc' => $master_data['share_co'],
				'share_co_amt' => $master_share_co,
				'share_co_amt100' => $master_share_co100,
				'share_po_perc' => $master_data['share_po'],
				'share_po_amt' => '',
				'share_po_amt100' => '',
				'sms_charges' => $sms_charges['sms_charges'],
				'expenses' => 0,
				);
		}
		$this->m_system->insert_pl_coy($pl_coy); // insert company p/l
		$this->m_system->insert_pl_mas($pl_mas); // insert master p/l
		//print_r($pl_mas);


		// calculate Manager ticket/strike
		$manager_array = $this->m_system->get_all_users('users_man');
		foreach ($manager_array as $man_data)
		{

			$ticket_data = $this->m_system->get_manager_ticket_detail($date, $man_data['man_id']);   // already deducted po_comm of bookie setting
			$own_intake_tax = ($ticket_data['downline_intake_ticket'] * ($man_data['intake_tax']/100));

			$pl_man[] = array(
				'drawdate' => $date,
				'man_id' => $man_data['man_id'],
				'total_ticket' => $ticket_data['ticket_amt'],
				'total_strike' => $ticket_data['strike_amt'],
				'downline_intake_ticket' => $ticket_data['downline_intake_ticket'],
				'downline_intake_tax' => $ticket_data['downline_intake_tax'],
				'own_intake_tax' => $own_intake_tax,
				'ticket_perc' => $ticket_data['ticket_perc'],
				'share_po_perc' => $man_data['share_po'],
				'share_po_amt' => '',
				'share_po_amt100' => '',
				);
		}
		$this->m_system->insert_pl_man($pl_man); // insert manager p/l
		//print_r($manager_array);

		// calculate group ticket/strike/sms/misc and %
		
		$group_array = $this->m_system->get_all_users('users_agg');
		foreach ($group_array as $group_data)
		{
			$agg_share_co100 = 0;
			$agg_share_co = 0;
			$agg_share_mas100 = 0;
			$agg_share_mas = 0;
			$ticket_perc = 0;


			$master_total_ticket = $this->m_system->get_total_ticket($date,$group_data['mas_id']);
			$ticket_data = $this->m_system->get_uid_ticket($date,$group_data['agg_id']); // get group intake and tax info
			$strike_data = $this->m_system->get_uid_strike($date,$group_data['agg_id']); // all strike sum
			$master_coin_amt = $this->m_system->get_mas_coin($date,$group_data['mas_id']); // get master co/intake win loss

			$ticket_perc = ($ticket_data['own_po_amount_wo_comm'] / $master_total_ticket) * 100; // ticket % for this group in master
			$total_strike = $strike_data['total_strike_amount'] - $strike_data['own_intake_strike'] - $strike_data['downline_intake_strike'];
			
			
			if($ticket_perc > 0)
			{
				$agg_share_co100 = $master_coin_amt['shareco_pl'] * ($ticket_perc / 100);
				$agg_share_co = $agg_share_co100 * ($group_data['share_co'] / 100);
				$agg_share_mas100 = $master_coin_amt['intake_pl'] * ($ticket_perc / 100);
				$agg_share_mas = $agg_share_mas100 * ($group_data['share_mas'] / 100);
			}
			else
			{
				$agg_share_co100 = 0;
				$agg_share_co = 0;
				$agg_share_mas100 = 0;
				$agg_share_mas = 0;
			}

			$pl_agg[] = array(
				'drawdate' => $date,
				'mas_id' => $group_data['mas_id'],
				'agg_id' => $group_data['agg_id'],
				'placeout_comm' => $ticket_data['placeout_comm'],
				'intake_tax' => $ticket_data['intake_tax'],
				'total_po_big' => $ticket_data['total_po_big'],
				'total_po_small' => $ticket_data['total_po_small'],
				'total_intake_big' => $ticket_data['total_intake_big'],
				'total_intake_small' => $ticket_data['total_intake_small'],
				'ticket_perc' => $ticket_perc,
				'total_po_ticket' => $ticket_data['total_ticket_amount'],
				'downline_total_po_ticket' => $ticket_data['downline_po_amount'],
				'total_meb_strike' => $strike_data['total_strike_amount'],
				'total_own_strike' => $strike_data['own_intake_strike'],
				'total_downline_strike' => $strike_data['downline_intake_strike'],
				'total_intake_ticket' => $ticket_data['total_intake_amount'],
				'total_own_intake_ticket' => $ticket_data['own_intake_amount'],
				'total_downline_intake_ticket' => $ticket_data['downline_intake_amount'],
				'total_intake_tax' => $ticket_data['total_tax_amount'],
				'total_own_intake_tax' => $ticket_data['own_tax_amount'],
				'total_downline_intake_tax' => $ticket_data['downline_tax_amount'],
				'share_co_perc' => $group_data['share_co'],
				'share_co_amt' => $agg_share_co,
				'share_co_amt100' => $agg_share_co100,
				'share_po_perc' => $group_data['share_po'],
				'share_po_amt' => '',
				'share_po_amt100' => '',
				'share_mas_perc' => $group_data['share_mas'],
				'share_mas_amt' => $agg_share_mas,
				'share_mas_amt100' => $agg_share_mas100,
				);
		}
		$this->m_system->insert_pl_agg($pl_agg); // insert agg p/l
		//print_r($pl_agg);


		// calculate agent ticket/strike/sms/misc and %

		$agent_array = $this->m_system->get_all_users('users_agt');
		foreach ($agent_array as $agent_data)
		{
			$agt_share_co100 = 0;
			$agt_share_co = 0;
			$agt_share_mas100 = 0;
			$agt_share_mas = 0;
			$agt_share_agg100 = 0;
			$agt_share_agg = 0;
			$ticket_perc = 0;
			$agg_share_agg100 = 0;
			$agg_share_agg = 0;


			$group_total_ticket = $this->m_system->get_total_ticket($date,$agent_data['agg_id']);
			$ticket_data = $this->m_system->get_uid_ticket($date,$agent_data['agt_id']); // get agent intake and tax info
			$strike_data = $this->m_system->get_uid_strike($date,$agent_data['agt_id']); // all strike sum
			$group_coin_amt = $this->m_system->get_agg_coin($date,$agent_data['agg_id']); // get group co/intake win loss

			$ticket_perc = ($ticket_data['own_po_amount_wo_comm'] / $group_total_ticket) * 100; // ticket % for this group in master
			$total_strike = $strike_data['total_strike_amount'] - $strike_data['own_intake_strike'];
			
			if($ticket_perc > 0)
			{
				$agt_share_co100 = $group_coin_amt['shareco_pl'] * ($ticket_perc / 100);
				$agt_share_co = $agt_share_co100 * ($agent_data['share_co'] / 100);

				$agt_share_mas100 = $group_coin_amt['mas_intake_pl'] * ($ticket_perc / 100);
				$agt_share_mas = $agt_share_mas100 * ($agent_data['share_mas'] / 100);

				$agt_share_agg100 = $group_coin_amt['agg_intake_pl'] * ($ticket_perc / 100);
				$agt_share_agg = $agt_share_agg100 * ($agent_data['share_agg'] / 100);
			}
			else
			{
				$agg_share_co100 = 0;
				$agg_share_co = 0;
				$agg_share_mas100 = 0;
				$agg_share_mas = 0;
				$agg_share_agg100 = 0;
				$agg_share_agg = 0;
			}

			$pl_agt[] = array(
				'drawdate' => $date,
				'mas_id' => $agent_data['mas_id'],
				'agg_id' => $agent_data['agg_id'],
				'agt_id' => $agent_data['agt_id'],
				'placeout_comm' => $ticket_data['placeout_comm'],
				'intake_tax' => $ticket_data['intake_tax'],
				'total_po_big' => $ticket_data['total_po_big'],
				'total_po_small' => $ticket_data['total_po_small'],
				'total_intake_big' => $ticket_data['total_intake_big'],
				'total_intake_small' => $ticket_data['total_intake_small'],
				'ticket_perc' => $ticket_perc,
				'total_po_ticket' => $ticket_data['total_ticket_amount'],
				'downline_total_po_ticket' => $ticket_data['downline_po_amount'],
				'total_meb_strike' => $strike_data['total_strike_amount'],
				'total_own_strike' => $strike_data['own_intake_strike'],
				'total_own_intake_ticket' => $ticket_data['own_intake_amount'],
				'total_own_intake_tax' => $ticket_data['own_tax_amount'],
				'share_co_perc' => $agent_data['share_co'],
				'share_co_amt' => $agt_share_co,
				'share_co_amt100' => $agt_share_co100,
				'share_agg_perc' => $agent_data['share_agg'],
				'share_agg_amt' => $agt_share_agg,
				'share_agg_amt100' => $agt_share_agg100,
				'share_mas_perc' => $agent_data['share_mas'],
				'share_mas_amt' => $agt_share_mas,
				'share_mas_amt100' => $agt_share_mas100,
				);
		}
		//print_r($pl_agt);
		$this->m_system->insert_pl_agt($pl_agt); // insert agt p/l

		// calculate Member ticket/strike
		$member_array = $this->m_system->get_all_users('users_meb');
		foreach ($member_array as $meb_data)
		{
			$ticket_data = $this->m_system->get_uid_ticket($date, $meb_data['meb_id']);   
			$strike_data = $this->m_system->get_uid_strike($date,$meb_data['meb_id']); // all strike sum
			$own_intake_tax = ($ticket_data['downline_intake_ticket'] * ($meb_data['intake_tax']/100));

			$pl_meb[] = array(
				'drawdate' => $date,
				'mas_id' => $meb_data['mas_id'],
				'agg_id' => $meb_data['agg_id'],
				'agt_id' => $meb_data['agt_id'],
				'meb_id' => $meb_data['meb_id'],
				'placeout_comm' => $ticket_data['placeout_comm'],
				'total_po_big' => $ticket_data['total_po_big'],
				'total_po_small' => $ticket_data['total_po_small'],
				'total_ticket' => $ticket_data['total_ticket_amount'],
				'total_strike' => $strike_data['total_strike_amount'],
				);
		}
		$this->m_system->insert_pl_meb($pl_meb); // insert member p/l

	}// end of function calculate
}
?>
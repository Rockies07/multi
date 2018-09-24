<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_genara extends CI_Controller 
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
		//$this->output->enable_profiler(TRUE); // benchmarking


		if($this->session->userdata('userinfo'))
		{
			$today = $this->input->post('draw');

			if($this->input->post('submiteat'))
			{
				//Generate ARA
				$insertsys_pool_temp = array();
				$insertbookie_pool = array();

				$eatbig = $this->input->post('eatbig');
				$eatsmall = $this->input->post('eatsmall');
				$today = $this->input->post('draw');
				$bookie_array = $this->m_system->getbookie();
				$poolnumber = $this->m_system->getadminpool($today);
				foreach($poolnumber as $number)
				{
					//echo $number['number'];
					//echo $number['amt_big'];
					//echo $number['amt_small'];

					$intake = $this->m_system->admindividefunc($eatbig, $eatsmall, '0.00', '0.00', $number['amt_big'], $number['amt_small']);
					print_r($intake);
					$insertsys_pool_temp[] = array(
						'drawdate' => $today,
						'number' => $number['number'],
						'amt_big' => $intake[0],
						'amt_small' => $intake[2]
						);
					//print_r($intake);
					if($intake[1]>0 || $intake[3]>0)
					{
						$bkinbig = 0;
						$bkinsmall = 0;
						foreach($bookie_array as $bookie_data)
						{
							$beforebig = $intake[1];
							$beforesmall = $intake[3];

							if($bookie_data['intake_big'] < $beforebig)
							{
								$bkinbig = $bookie_data['intake_big'];
								$beforebig = $beforebig - $bookie_data['intake_big'];
							}
							if($bookie_data['intake_small'] < $beforesmall)
							{
								$bkinsmall = $bookie_data['intake_small'];
								$beforesmall = $beforesmall - $bookie_data['intake_small'];
							}
							else
							{
								$bkinsmall = $beforesmall;
								$bkinbig = $beforebig;
								$beforesmall = 0;
								$beforebig = 0;
							}
							if($bkinbig > 0 || $bkinsmall > 0)
							{

								$insertbookie_pool[] = array(
									'drawdate' => $today,
									'bok_id' => $bookie_data['bok_id'],
									'number' => $number['number'],
									'amt_big' => $bkinbig,
									'amt_small' => $bkinsmall,
									);
							}

							$intake[1] = $intake[1] - $bkinbig;
							$intake[3] = $intake[3] - $bkinsmall;
						}
					}
				}

				$this->m_system->insertadmintemp($insertsys_pool_temp);
				if (sizeof($insertbookie_pool) > 0) 
				{
					//print_r($insertbookie_pool);	
					$this->m_system->insertbookietemp($insertbookie_pool);
				}


			}

			if($this->input->post('saveintake'))
			{
				//Save intake
				$today = $this->input->post('draw');

				
				// save current admin intake temp to intake
				$this->m_system->insert_system_intake($today);
				
				// divide bookie intake by piority based on temp
				$this->m_system->insert_bookie_intake($today);

				//--------- Admin intake summary calculation --------------

				$admin_intake = $this->m_system->get_admin_intake_total($today);

				$detaildata = array(
							   'drawdate' => $today,
							   'set_big' => $this->input->post('eatbig'),
							   'set_small' => $this->input->post('eatsmall'),
							   'amt_big' => $admin_intake['amt_big'],
							   'amt_small' => $admin_intake['amt_small'],
							);

				// set big small eat amt to admin_intake_details
				$this->m_system->insert_intake_detail($detaildata);

				//--------- Bookie intake summary calculation --------------

				$bookie_intake = $this->m_system->get_bookie_total($today);

				$bookiedata = array(
							   'drawdate' => $today,
							   'amt_big' => $bookie_intake['amt_big'],
							   'amt_small' => $bookie_intake['amt_small'],
							);

				// set big small eat amt to bookie_intake_detail
				$this->m_system->insert_bookie_intake_detail($bookiedata);

				//--------- Master PO summary calculation --------------

				$master_po = $this->m_system->get_master_po($today);
				$masterdata = array(
							   'drawdate' => $today,
							   'amt_big' => $master_po['amt_big'],
							   'amt_small' => $master_po['amt_small'],
							);

				// set big small eat amt to master_po_detail
				$this->m_system->insert_master_po_detail($masterdata);



				echo '<script type="text/javascript">alert("Intake Saved! All ara download generated.");</script>';

				// redirect to download ara
				//redirect('c_downloadara','location',301);
			}
			
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$drawdate = $this->m_system->gettransdraw(15);
			$reportsysdata = $this->m_system->sysintakedata($today); // report pool data
			$reportsysdata_temp = $this->m_system->sysintakedata_temp($today);
			$reportbookiedata_temp = $this->m_system->bookieintakedata_temp($today);

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'closetime' => $serverdata['closetime'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'drawdate' => $drawdate,
					'reportsysdata' => $reportsysdata,
					'reportsysdata_temp' => $reportsysdata_temp,
					'reportbookiedata_temp' => $reportbookiedata_temp,
				);
		
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_genara'); // default view after login is profile

		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


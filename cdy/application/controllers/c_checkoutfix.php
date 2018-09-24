<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class c_checkoutfix extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
		$this->load->model('m_accounts','',TRUE);
	}

	function index()
	{
		if($this->input->post('WhoseBet'))
		{
			$this->load->helper('date');
			if($this->session->userdata('userinfo'))
			{
				//$this->output->enable_profiler(TRUE); // benchmarking
				$server_data = $this->m_system->settings_server();

				// Set bet records variables
				$br_bigamt = 0;
				$br_smallamt = 0;
				$br_ibigamt = 0;
				$br_ismallamt = 0;

				// Verify Memberid and downline
				$meb_id = $this->input->post('WhoseBet');
				$uid_data = $this->m_accounts->getinfo($meb_id);
			
				$agt_id = $uid_data['agt_id'];
				$agg_id = $uid_data['agg_id'];
				$mas_id = $uid_data['mas_id'];

				// Delete the old fix first
				$countentry = $this->m_accounts->get_fixpage_count($meb_id,$this->input->post('txtPage'));
				
				
				if($countentry > 0)
				{
					$this->m_accounts->delfixpagedata($meb_id,$this->input->post('txtPage'));
					$pageref = $this->input->post('txtPage');
					$reply = '<script type="text/javascript">alert("Fix Entry Updated!");</script>';
				}

				else
				{
					if(trim($this->input->post('txtPage')) == "")
					{
						$pageref = "FIX-".rand(10000,99999);
					}
					else
					{
						$pageref = "FIX-".$this->input->post('txtPage');
					}
					$reply = '<script type="text/javascript">alert("Fix Entry Added!");</script>';
				}
				
				//init the array
				$insertfix_data = array(); 
				

				// Run entry loop and insert into DB
				for ($i = 1; $i <= 80; $i++) 
				{
					$number = $this->input->post('NumberToBuy'.$i);
					if (strlen($number) == 4) // valid number to buy
					{
						$bigamt = $this->input->post('BigNum'.$i);
						$smallamt = $this->input->post('SmlNum'.$i);
						$cmd = strtoupper($this->input->post('pCmd'.$i)); // Setting Cmd to upper case 
					
						$insertfix_data[] = array(
							'number' => $number,
							'cmd' => $cmd,
							'amt_big' => $bigamt,
							'amt_small' => $smallamt,
							'meb_id' => $meb_id,
							'agt_id' => $agt_id,
							'agg_id' => $agg_id,
							'mas_id' => $mas_id,
							'numinpage' => $i,
							'pageref' => $pageref, 
							);						

						//bet records only calculate per day amount
					}
					
				}// out of 80 cell loop
				
				$this->m_system->inserttransfix($insertfix_data); // insert trans data array

				//print_r($insertfix_data);
				echo $reply;
				
				redirect('c_entryfix', 'refresh');
			
			}
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}

	}

}

?>

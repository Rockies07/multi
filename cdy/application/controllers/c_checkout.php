<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class c_CheckOut extends CI_Controller 
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
				
				//Check Close time
				$today = date("l");
				$server_data = $this->m_system->settings_server();
				$session_data = $this->session->userdata('userinfo');
				$userdata = $this->m_accounts->getinfo($session_data['uid']);
				$timenow = date('H:i:s');
				$timeonehour = date("H:i:s", strtotime ($server_data['closetime']) + 55 * 60);
				$tdatenow = date('Y-m-d');
				$entrytime = date('Y-m-d H:i:s');

				if (($today=="Wednesday") || ($today=="Saturday") || ($today=="Sunday"))
				{
					if ($timenow >= $server_data['closetime'] and $timenow <= $timeonehour)
					{
						$remain = strtotime($timenow) - strtotime($server_data['closetime']);
						$minutes = (60 - intval(($remain / 60) % 60));
						echo '<script type="text/javascript">alert("Betting is temporary closed. Please come back after 7PM for the next drawdate.!");</script>';
						redirect('c_profile', 'refresh');
					}
					else if ($timenow >= $timeonehour)
					{
						$tdatenow = date('Y-m-d', strtotime('+ 1 day'));
					}
				}
				// Set bet records variables
				$br_bigamt = 0;
				$br_smallamt = 0;
				$br_ibigamt = 0;
				$br_ismallamt = 0;

				$roll_bigamt = 0;
				$roll_smallamt = 0;
				$ibet_bigamt = 0;
				$ibet_smallamt = 0;

				$br_day1 = 0;
				$br_day2 = 0;
				$br_day3 = 0;
				$br_day6 = 0;
				$br_day7 = 0;
				$day1_bigamt = 0;
				$day1_smallamt = 0;
				$day2_bigamt = 0;
				$day2_smallamt = 0;
				$day3_bigamt = 0;
				$day3_smallamt = 0;
				$day6_bigamt = 0;
				$day6_smallamt = 0;
				$day7_bigamt = 0;
				$day7_smallamt = 0;

				$day1_ibigamt = 0;
				$day1_ismallamt = 0;
				$day2_ibigamt = 0;
				$day2_ismallamt = 0;
				$day3_ibigamt = 0;
				$day3_ismallamt = 0;
				$day6_ibigamt = 0;
				$day6_ismallamt = 0;
				$day7_ibigamt = 0;
				$day7_ismallamt = 0;


				// Set next 3 drawdate
				$drawdate = $this->m_system->getdraw($tdatenow);

				for ($i = 1; $i <= 3; $i++) 
				{
					$td = $drawdate[$i];
					$arr = explode ("-", $td);
					$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
					$t = date('D',$stamp);
					if (strcmp($t, 'Wed') == 0 ){$drawdate3[1] = $td;}
					if (strcmp($t, 'Sat') == 0 ){$drawdate3[2] = $td;}
					if (strcmp($t, 'Sun') == 0 ){$drawdate3[3] = $td;}
				}

				// Verify Memberid and downline
				$meb_id = $this->input->post('WhoseBet');
				$uid_data = $this->m_accounts->getinfo($meb_id);
				if(strlen($meb_id) != 8)
				{
					echo '<script type="text/javascript">alert("Error in entry. Please contact upline!");</script>';
					redirect('c_entry', 'refresh');				
				}
				$uid_data = $this->m_accounts->getinfo($meb_id);
			
				$agt_id = $uid_data['agt_id'];
				$agg_id = $uid_data['agg_id'];
				$mas_id = $uid_data['mas_id'];
				if(strlen($agt_id) != 6)
				{
					echo '<script type="text/javascript">alert("Error in entry. Please contact upline!");</script>';
					redirect('c_entry', 'refresh');				
				}
				if(strlen($agg_id) != 4)
				{
					echo '<script type="text/javascript">alert("Error in entry. Please contact upline!");</script>';
					redirect('c_entry', 'refresh');				
				}
				if(strlen($mas_id) != 2)
				{
					echo '<script type="text/javascript">alert("Error in entry. Please contact upline!");</script>';
					redirect('c_entry', 'refresh');				
				}
		
				// Check Credit
				$meb_balance = $uid_data['balance'];
				if($meb_balance <= 0)
				{
					echo '<script type="text/javascript">alert("Insufficient Balance. Please contact upline!");</script>';
					redirect('c_entry', 'refresh');				
				}
				
				// Get Downline intake
				$mas_intake = $this->m_accounts->getintake($mas_id); 
				$agg_intake = $this->m_accounts->getintake($agg_id); 
				$agt_intake = $this->m_accounts->getintake($agt_id); 
				
				// Get Placeout Com for bet records
				$meb_com = $uid_data['placeout_com'];
				$mas_com = $mas_intake['placeout_com'];
				$agg_com = $agg_intake['placeout_com'];
				$agt_com = $agt_intake['placeout_com'];

				// Check Page ref and set sysref
				$sysref = $this->m_system->randomref();
				if("" == trim($this->input->post('txtPage')))
				{
					$pageref = "TXT-".rand(10000,99999);
				}
				else
				{
					$pageref = "TXT-".$this->input->post('txtPage');
				}

				//init the array
				$pagedetails_data = array(); 
				$admin_intake_data = array();
				$betrecords_data = array();
				
				// Run entry loop and insert into DB
				for ($i = 1; $i <= 80; $i++) 
				{
					$number = $this->input->post('NumberToBuy'.$i);
					if (strlen($number) == 4) // valid number to buy
					{

						$trans_data = array(); // init trans array
						$daybet = $this->input->post('Day'.$i);
						$bigamt = $this->input->post('BigNum'.$i);
						$smallamt = $this->input->post('SmlNum'.$i);
						$cmd = strtoupper($this->input->post('pCmd'.$i)); // Setting Cmd to upper case 
						
						switch($daybet)
						{
							case 1:	$dayroll = 3;
									$y_value = 1;	
									$no_of_days = 3;
									break;
							case 2: $dayroll = 3;
									$y_value = 2;
									$no_of_days = 2;
									break;
							case 3: $dayroll = 1;
									$y_value = 1;
									$no_of_days = 1;
									break;
							case 6: $dayroll = 2;
									$y_value = 2;
									$no_of_days = 1;
									break;
							case 7: $dayroll = 3;
									$y_value = 3;
									$no_of_days = 1;
									break;
						}
						
						// Roll or Ibet Calculation and insert
						if((strcmp($cmd, 'R') == 0) || (strcmp($cmd, 'I') == 0)) // roll and ibet
						{
							$combodata = $this->m_system->getcombo($number);

							if(strcmp($cmd, 'I') == 0) // Setting big/small amt to decimal if ibet
							{
								$tmp_bigamt = round(($bigamt / $combodata['combocount']),4);
								$tmp_smallamt = round(($smallamt / $combodata['combocount']),4);
							}
							else
							{
								$tmp_bigamt = $bigamt;
								$tmp_smallamt = $smallamt;
							}

							// doing intake from here on
							// agt -> agg -> mas -> system
							$arr = explode (",", $combodata['comblist']);
							for ($x = 0; $x <= ($combodata['combocount'] -1); $x++) // run the roll count
							{	
								$y = $y_value;
								while($y <= $dayroll) //$y_value <= $dayroll to get Wed,Sat,Sun Draws
								{
									$prein_agt = $this->m_system->runintake($agt_id, trim($arr[$x]), $drawdate3[$y]);
									$prein_agg = $this->m_system->runintake($agg_id, trim($arr[$x]), $drawdate3[$y]);
									$prein_mas = $this->m_system->runintake($mas_id, trim($arr[$x]), $drawdate3[$y]);

									$eatagt = $this->m_system->dividefunc($agt_intake['intake_big'], $agt_intake['intake_small'], $prein_agt['prebig'], $prein_agt['presmall'], $tmp_bigamt, $tmp_smallamt);
									$eatagg = $this->m_system->dividefunc($agg_intake['intake_big'], $agg_intake['intake_small'], $prein_agg['prebig'], $prein_agg['presmall'], $eatagt[1], $eatagt[3]);
									$eatmas = $this->m_system->dividefunc($mas_intake['intake_big'], $mas_intake['intake_small'], $prein_mas['prebig'], $prein_mas['presmall'], $eatagg[1], $eatagg[3]);


									$trans_data[] = array(
										'drawdate' => $drawdate3[$y],
										'number' => $arr[$x],
										'amt_big' => $tmp_bigamt,
										'amt_small' => $tmp_smallamt,
										'cmd' => $cmd,
										'meb_id' => $meb_id,
										'agt_id' => $agt_id,
										'agg_id' => $agg_id,
										'mas_id' => $mas_id,
										'agt_intake_big' => $eatagt[0],
										'agt_intake_small' => $eatagt[2],
										'agt_intake_tax' => $agt_intake['intake_tax'],
										'agg_intake_big' => $eatagg[0],
										'agg_intake_small' => $eatagg[2],
										'agg_intake_tax' => $agg_intake['intake_tax'],
										'mas_intake_big' => $eatmas[0],
										'mas_intake_small' => $eatmas[2],
										'mas_intake_tax' => $mas_intake['intake_tax'],
										'ref' => $sysref );

									if($eatmas[1] > 0 || $eatmas[3] > 0)
									{
										$admin_intake_data[] = array(
											'drawdate' => $drawdate3[$y],
											'number' => $arr[$x],
											'amt_big' => $eatmas[1],
											'amt_small' => $eatmas[3],
											'meb_id' => $meb_id,
											'agt_id' => $agt_id,
											'agg_id' => $agg_id,
											'mas_id' => $mas_id,
											'ref' => $sysref );
									}
									$y = $y + 1;
								}

								if(strcmp($cmd, 'R') == 0) // Calculating Bet amount per day
								{
									$roll_bigamt = $roll_bigamt + $tmp_bigamt;
									$roll_smallamt = $roll_smallamt + $tmp_smallamt;								
								}

							} // End of roll count


							// add page detail by the number of day
							$y = $y_value;
							while($y <= $dayroll)
							{
								$pagedetails_data[] = array(
									'drawdate' => $drawdate3[$y],
									'number' => $number,
									'cmd' => $cmd,
									'draws' => $daybet,
									'curday1' => $drawdate3[1],
									'curday2' => $drawdate3[2],
									'curday3' => $drawdate3[3],
									'amt_big' => $bigamt,
									'amt_small' => $smallamt,
									'numinpage' => $i,
									'pageref' => $pageref,
									'ref' => $sysref );
								$y = $y + 1;
							}

							if(strcmp($cmd, 'I') == 0) // Calculating Bet records total
							{
								$ibet_bigamt = $ibet_bigamt + $bigamt;
								$ibet_smallamt = $ibet_smallamt + $smallamt;
							}

							switch($daybet) // splitting out different day value for Bet records
							{
								case 1:	$day1_bigamt = $day1_bigamt + $roll_bigamt;
										$day1_smallamt = $day1_smallamt + $roll_smallamt;
										$day1_ibigamt = $day1_ibigamt + $ibet_bigamt;
										$day1_ismallamt = $day1_ismallamt + $ibet_smallamt;
										$br_day1 = 1;
										break;
								case 2:	$day2_bigamt = $day2_bigamt + $roll_bigamt;
										$day2_smallamt = $day2_smallamt + $roll_smallamt;
										$day2_ibigamt = $day2_ibigamt + $ibet_bigamt;
										$day2_ismallamt = $day2_ismallamt + $ibet_smallamt;
										$br_day2 = 1;
										break;
								case 3:	$day3_bigamt = $day3_bigamt + $roll_bigamt;
										$day3_smallamt = $day3_smallamt + $roll_smallamt;
										$day3_ibigamt = $day3_ibigamt + $ibet_bigamt;
										$day3_ismallamt = $day3_ismallamt + $ibet_smallamt;
										$br_day3 = 1;
										break;
								case 6:	$day6_bigamt = $day6_bigamt + $roll_bigamt;
										$day6_smallamt = $day6_smallamt + $roll_smallamt;
										$day6_ibigamt = $day6_ibigamt + $ibet_bigamt;
										$day6_ismallamt = $day6_ismallamt + $ibet_smallamt;
										$br_day6 = 1;
										break;
								case 7:	$day7_bigamt = $day7_bigamt + $roll_bigamt;
										$day7_smallamt = $day7_smallamt + $roll_smallamt;
										$day7_ibigamt = $day7_ibigamt + $ibet_bigamt;
										$day7_ismallamt = $day7_ismallamt + $ibet_smallamt;
										$br_day7 = 1;
										break;
							}
							
							// insert trans records
							$this->m_system->inserttrans($trans_data); // insert trans data

							// resetting all the values to 0 for next ibet or roll.
							$roll_bigamt = 0;
							$roll_smallamt = 0;
							$ibet_bigamt = 0;
							$ibet_smallamt = 0;

						}// end of Roll/ i-bet
					
						else
						{
							$y = $y_value; // set number of draws insert
							while($y <= $dayroll)
							{
								$prein_agt = $this->m_system->runintake($agt_id, $number, $drawdate3[$y]);
								$prein_agg = $this->m_system->runintake($agg_id, $number, $drawdate3[$y]);
								$prein_mas = $this->m_system->runintake($mas_id, $number, $drawdate3[$y]);

								// doing intake from here on
								// agt -> agg -> mas -> system
								$eatagt = $this->m_system->dividefunc($agt_intake['intake_big'], $agt_intake['intake_small'], $prein_agt['prebig'], $prein_agt['presmall'], $bigamt, $smallamt);
								$eatagg = $this->m_system->dividefunc($agg_intake['intake_big'], $agg_intake['intake_small'], $prein_agg['prebig'], $prein_agg['presmall'], $eatagt[1], $eatagt[3]);
								$eatmas = $this->m_system->dividefunc($mas_intake['intake_big'], $mas_intake['intake_small'], $prein_mas['prebig'], $prein_mas['presmall'], $eatagg[1], $eatagg[3]);
								
								$trans_data[] = array(
									'drawdate' => $drawdate3[$y],
									'number' => $number,
									'amt_big' => $bigamt,
									'amt_small' => $smallamt,
									'cmd' => $cmd,
									'meb_id' => $meb_id,
									'agt_id' => $agt_id,
									'agg_id' => $agg_id,
									'mas_id' => $mas_id,
									'agt_intake_big' => $eatagt[0],
									'agt_intake_small' => $eatagt[2],
									'agt_intake_tax' => $agt_intake['intake_tax'],
									'agg_intake_big' => $eatagg[0],
									'agg_intake_small' => $eatagg[2],
									'agg_intake_tax' => $agg_intake['intake_tax'],
									'mas_intake_big' => $eatmas[0],
									'mas_intake_small' => $eatmas[2],
									'mas_intake_tax' => $mas_intake['intake_tax'],
									'ref' => $sysref );

								if($eatmas[1] > 0 || $eatmas[3] > 0)
								{
									$admin_intake_data[] = array(
										'drawdate' => $drawdate3[$y],
										'number' => $number,
										'amt_big' => $eatmas[1],
										'amt_small' => $eatmas[3],
										'meb_id' => $meb_id,
										'agt_id' => $agt_id,
										'agg_id' => $agg_id,
										'mas_id' => $mas_id,
										'ref' => $sysref );
								}

								$pagedetails_data[] = array(
									'drawdate' => $drawdate3[$y],
									'number' => $number,
									'cmd' => $cmd,
									'draws' => $daybet,
									'curday1' => $drawdate3[1],	
									'curday2' => $drawdate3[2],
									'curday3' => $drawdate3[3],
									'amt_big' => $bigamt,
									'amt_small' => $smallamt,
									'numinpage' => $i,
									'pageref' => $pageref,
									'ref' => $sysref );

								$y = $y + 1;
							} // end number of draws insert while
							

							//bet records only calculate per day amount
							$br_bigamt = $br_bigamt + $bigamt;
							$br_smallamt = $br_smallamt + $smallamt;

							switch($daybet) // splitting out different day value for Bet records
							{
								case 1:	$day1_bigamt = $day1_bigamt + $bigamt;
										$day1_smallamt = $day1_smallamt + $smallamt;
										$br_day1 = 1;
										break;
								case 2:	$day2_bigamt = $day2_bigamt + $bigamt;
										$day2_smallamt = $day2_smallamt + $smallamt;
										$br_day2 = 1;
										break;
								case 3:	$day3_bigamt = $day3_bigamt + $bigamt;
										$day3_smallamt = $day3_smallamt + $smallamt;
										$br_day3 = 1;
										break;
								case 6:	$day6_bigamt = $day6_bigamt + $bigamt;
										$day6_smallamt = $day6_smallamt + $smallamt;
										$br_day6 = 1;
										break;
								case 7:	$day7_bigamt = $day7_bigamt + $bigamt;
										$day7_smallamt = $day7_smallamt + $smallamt;
										$br_day7 = 1;
										break;
							}

							$this->m_system->inserttrans($trans_data); // insert trans data array

						}// end else if not i or R
					}
					
				}// out of 80 cell loop
			
				$this->m_system->insertpage($pagedetails_data); // insert page details
				if (sizeof($admin_intake_data) > 0) 
				{
					$this->m_system->insertadminintake($admin_intake_data); // insert admin intake pool array
				}
				
				$totalbig = 0;
				$totalsmall = 0;

				if($br_day1 == 1 || $br_day3 == 1) // somewhere in loop there is a 3 selection for bets
				{
					$temp_big = 0;
					$temp_small = 0;

					$betrecords_data[] = array(
						'drawdate' => $drawdate3[1],
						'entrytime' => $entrytime,
						'meb_id' => $meb_id,
						'agt_id' => $agt_id,
						'agg_id' => $agg_id,	
						'mas_id' => $mas_id,
						'meb_com' => $meb_com,
						'agt_com' => $agt_com,
						'agg_com' => $agg_com,	
						'mas_com' => $mas_com,
						'amt_big' => $day1_bigamt + $day3_bigamt,
						'amt_small' => $day1_smallamt + $day3_smallamt,
						'amt_ibig' => $day1_ibigamt + $day3_ibigamt,
						'amt_ismall' => $day1_ismallamt + $day3_ismallamt,
						'pageref' => $pageref,
						'ref' => $sysref,
						'strike' => '',
						'enterby' => 'Admin',
						'sms_charges' => '0',
						);
					
					$temp_big = $day1_bigamt + $day3_bigamt + $day1_ibigamt + $day3_ibigamt;
					$temp_small = $day1_smallamt + $day3_smallamt + $day1_ismallamt + $day3_ismallamt;

					$totalbig = $totalbig + $temp_big;
					$totalsmall = $totalsmall + $temp_small;

				}

				if($br_day1 == 1 || $br_day6 == 1 || $br_day2 == 1) // somewhere in loop there is a 6 selection for bets
				{
					$temp_big = 0;
					$temp_small = 0;

					$betrecords_data[] = array(
						'drawdate' => $drawdate3[2],
						'entrytime' => $entrytime,
						'meb_id' => $meb_id,
						'agt_id' => $agt_id,
						'agg_id' => $agg_id,	
						'mas_id' => $mas_id,
						'meb_com' => $meb_com,
						'agt_com' => $agt_com,
						'agg_com' => $agg_com,	
						'mas_com' => $mas_com,
						'amt_big' => $day6_bigamt + $day1_bigamt + $day2_bigamt,
						'amt_small' => $day6_smallamt + $day1_smallamt + $day2_smallamt,
						'amt_ibig' => $day6_ibigamt + $day1_ibigamt + $day2_ibigamt,
						'amt_ismall' => $day6_ismallamt + $day1_ismallamt + $day2_ismallamt,
						'pageref' => $pageref,
						'ref' => $sysref,
						'strike' => '',
						'enterby' => 'Admin',
						'sms_charges' => '0',
						);

					$temp_big = $day6_bigamt + $day1_bigamt + $day2_bigamt + $day6_ibigamt + $day1_ibigamt + $day2_ibigamt;
					$temp_small = $day6_smallamt + $day1_smallamt + $day2_smallamt + $day6_ismallamt + $day1_ismallamt + $day2_ismallamt;

					$totalbig = $totalbig + $temp_big;
					$totalsmall = $totalsmall + $temp_small;

				}

				if($br_day1 == 1 || $br_day7 == 1 || $br_day2 == 1) // somewhere in loop there is a 6 selection for bets
				{
					$temp_big = 0;
					$temp_small = 0;

					$betrecords_data[] = array(
						'drawdate' => $drawdate3[3],
						'entrytime' => $entrytime,
						'meb_id' => $meb_id,
						'agt_id' => $agt_id,
						'agg_id' => $agg_id,	
						'mas_id' => $mas_id,
						'meb_com' => $meb_com,
						'agt_com' => $agt_com,
						'agg_com' => $agg_com,	
						'mas_com' => $mas_com,
						'amt_big' => $day7_bigamt + $day1_bigamt + $day2_bigamt,
						'amt_small' => $day7_smallamt + $day1_smallamt + $day2_smallamt,
						'amt_ibig' => $day7_ibigamt + $day1_ibigamt + $day2_ibigamt,
						'amt_ismall' => $day7_ismallamt + $day1_ismallamt + $day2_ismallamt,
						'pageref' => $pageref,
						'ref' => $sysref,
						'strike' => '',
						'enterby' => 'Admin',
						'sms_charges' => '0',
						);

					$temp_big = $day7_bigamt + $day1_bigamt + $day2_bigamt + $day7_ibigamt + $day1_ibigamt + $day2_ibigamt;
					$temp_small = $day7_smallamt + $day1_smallamt + $day2_smallamt + $day7_ismallamt + $day1_ismallamt + $day2_ismallamt;

					$totalbig = $totalbig + $temp_big;
					$totalsmall = $totalsmall + $temp_small;

				}

				$this->m_system->insertbetrecords($betrecords_data); // insert bet records

				$totalamt = ($totalbig * $server_data['bigprice']) + ($totalsmall * $server_data['smallprice']);
				
				$meb_totalamt = $totalamt - ($totalamt * ($meb_com / 100));

				//Update member balance
				$this->m_accounts->update_member_balance($meb_totalamt,$meb_id);

				// Send Result page
				$flashdata = array(
							'meb_id' => $meb_id,
							'placeout_com' => $meb_com,
							'totalbig' => $totalbig,
							'totalsmall' => $totalsmall,
							'totalamt' => $totalamt,
							'totalmeb' => $meb_totalamt,

					);
				
				$this->session->set_flashdata($flashdata);
				redirect('c_checkout/betsummary', 'refresh');
			}
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}

	}

	function betsummary()
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
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_betsummary'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}
}

?>

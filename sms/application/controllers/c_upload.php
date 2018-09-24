<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_upload extends CI_Controller 
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
			$upload_records = 0;
			$upload_records = $this->m_accounts->getupload_records($session_data['uid']);

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
					'upload_records' => $upload_records,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view('v_upload'); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function do_upload()
	{
		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = '*';
			$config['max_size']    = '1000';
			$config['encrypt_name']    = True;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('myFile'))
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
				echo '<script type="text/javascript">alert("File upload ERROR!");</script>';
				//uploading failed. $error will holds the errors.
			}
			else
			{
				$entrytime = date('Y-m-d H:i:s');
				$data = array('upload_data' => $this->upload->data());
				// uploading successfull, now do your further actions
				//echo '<script type="text/javascript">alert("File upload success!");</script>';
				$aradata = array(
							'ara_filename' => $data['upload_data']['orig_name'] ,
							'fileref' => $data['upload_data']['raw_name'],
							'ara_filesize' => $data['upload_data']['file_size'],
							'datetime' => $entrytime,
							'uploaded_by' => $session_data['uid'],
						);

				$this->m_system->ara_records($aradata);

				$this->m_system->loadara($data['upload_data']['full_path'], $data['upload_data']['raw_name']);
				echo '<script type="text/javascript">alert("File upload successfully!");</script>';

				//echo $data['upload_data']['full_path'];
				//var_dump($data);
			}
			redirect('c_upload', 'refresh');
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function delete_ara($fileref,$uid)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$this->m_accounts->delupload_records($fileref,$uid);
			echo '<script type="text/javascript">alert("File Deleted Successfully!");</script>';
			redirect('c_upload', 'refresh');
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function load_ara($fileref,$uid)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
				//$this->output->enable_profiler(TRUE); // benchmarking

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
						redirect('c_upload', 'refresh');
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
				if(strlen($uid) == 2)
				{
					$meb_id = $uid."------";
				}
				if(strlen($uid) == 4)
				{
					$meb_id = $uid."----";
				}
				$uid_data = $this->m_accounts->getinfo($meb_id);
			
				$agt_id = $uid_data['agt_id'];
				$agg_id = $uid_data['agg_id'];
				$mas_id = $uid_data['mas_id'];

				// Check Credit
				$meb_balance = $uid_data['balance'];
				
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

				if("" == $this->m_system->getara_page($fileref))
				{
					$pageref = "ARA-".rand(10000,99999);
				}
				else
				{
					$pageref = "ARA-".$this->m_system->getara_page($fileref);
				}

				switch(date("l"))
				{
					case "Monday"	:	$daybet = 3;
										break;
					case "Tuesday"	:	$daybet = 3;
										break;
					case "Wednesday":	if ($timenow >= $timeonehour)
										{
											$daybet = 6;
											break;
										}
										$daybet = 3;
										break;
					case "Thursday"	:	$daybet = 6;
										break;
					case "Friday"	:	$daybet = 6;
										break;
					case "Saturday"	:	if ($timenow >= $timeonehour)
										{
											$daybet = 7;
											break;
										}
										$daybet = 6;
										break;
					case "Sunday"	:	if ($timenow >= $timeonehour)
										{
											$daybet = 3;
											break;
										}
										$daybet = 7;
										break;
										
				}
				//init the array
				$pagedetails_data = array(); 
				$admin_intake_data = array();
				$betrecords_data = array();
				$ara_array = $this->m_system->getara($fileref);

				$numinpage = 1;
				// Run entry loop and insert into DB
				foreach($ara_array as $ara_data)
				{				
					
					$number = substr($ara_data['data'], 2, 4);
					
					if(!is_numeric($number))
					{
						echo '<script type="text/javascript">alert("Error in ARA file! invalid bet number");</script>';
						redirect('c_upload', 'refresh');
					}
					
					if (strlen($number) == 4) // valid number to buy
					{
						$trans_data = array(); // init trans array
						$bigamt = trim(str_replace(" ", "", substr($ara_data['data'], 7, 4)));
						$smallamt = trim(str_replace(" ", "", substr($ara_data['data'], 12, 3)));
						$smallamt = (int)$smallamt; // convert to int
						if(strlen($bigamt) == 0)
						{
							$bigamt = 0;
						}
						if(strlen($smallamt) == 0)
						{
							$smallamt = 0;
						}
						//echo $smallamt;
						$cmd = "";

						if($bigamt < 0 || $smallamt < 0) // arafile bet amount cannot be smaller than 0
						{
							echo '<script type="text/javascript">alert("Error in ARA file! big small amount < 0");</script>';
							redirect('c_upload', 'refresh');							
						}
						
						if(!is_int($smallamt)) // arafile bet amount cannot be smaller than 0
						{
							echo '<script type="text/javascript">alert("Error in ARA file! small amount < 0");</script>';
							redirect('c_upload', 'refresh');				
							//die();
						}	
						
						if(!is_numeric($bigamt)) // arafile bet amount cannot be smaller than 0
						{
							echo '<script type="text/javascript">alert("Error in ARA file! big amount < 0");</script>';
							redirect('c_upload', 'refresh');							
						}
						
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

							if($eatmas[1] > 0 || $eatmas[3] > 0) // remaining after agt/agg/mas intake
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
								'numinpage' => $numinpage,
								'pageref' => $pageref,
								'ref' => $sysref );

							$y = $y + 1;
						} //end of while daybet
							
						//bet records only calculate per day amount
						$br_bigamt = $br_bigamt + $bigamt;
						$br_smallamt = $br_smallamt + $smallamt;


						$numinpage = $numinpage + 1;
						$this->m_system->inserttrans($trans_data); // insert trans data array

					}// end of if number = 4
					

				}// out of foreach
				

				//print_r($pagedetails_data);
				$this->m_system->insertpage($pagedetails_data); // insert page details
				
				if (sizeof($admin_intake_data) > 0) 
				{
					$this->m_system->insertadminintake($admin_intake_data); // insert admin intake pool array
				}


				$y = $y_value;
				while($y <= $dayroll)
				{
					$betrecords_data[] = array(
						'drawdate' => $drawdate3[$y],
						'entrytime' => $entrytime,
						'meb_id' => $meb_id,
						'agt_id' => $agt_id,
						'agg_id' => $agg_id,	
						'mas_id' => $mas_id,
						'meb_com' => $meb_com,
						'agt_com' => $agt_com,
						'agg_com' => $agg_com,	
						'mas_com' => $mas_com,
						'amt_big' => $br_bigamt,
						'amt_small' => $br_smallamt,
						'amt_ibig' => $br_ibigamt,
						'amt_ismall' => $br_ismallamt,
						'pageref' => $pageref,
						'ref' => $sysref,
						'strike' => '',
						'enterby' => $session_data['uid'],
						'sms_charges' => '0',
						);
					$y = $y + 1;
				}

				//print_r($betrecords_data);
				$this->m_system->insertbetrecords($betrecords_data); // insert admin intake pool array

				$this->m_accounts->delupload_records($fileref,$uid); // delete from ara_upload and ara_data when done
				echo '<script type="text/javascript">alert("File Loaded successfully!");</script>';
				redirect('c_upload', 'refresh');
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


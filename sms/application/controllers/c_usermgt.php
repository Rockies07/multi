<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_usermgt extends CI_Controller 
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

			switch(strlen($session_data['uid']))
			{
				case 2: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						$count_users['agt'] = $this->m_accounts->count_users($session_data['uid'],'users_agt');
						$count_users['agg'] = $this->m_accounts->count_users($session_data['uid'],'users_agg');
						$member_array = $this->m_accounts->get_allusers($session_data['uid'], 'users_agg', $session_data['uid'],'agg_id');
						$viewpage = 'v_usermgt_agentgroup';
						break;
				
				case 4: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						$count_users['agt'] = $this->m_accounts->count_users($session_data['uid'],'users_agt');
						$member_array = $this->m_accounts->get_allusers($session_data['uid'],'users_agt', $session_data['uid'],'agt_id');
						$viewpage = 'v_usermgt_agent';
						break;

				case 6: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						$member_array = $this->m_accounts->get_allusers($session_data['uid'],'users_meb', $session_data['uid'],'meb_id');
						$viewpage = 'v_usermgt_member';
						break;

				default: $count_users = 0;

			}

			$attributes = array(
						  'width'      => '910',
						  'height'     => '580',
						  'scrollbars' => 'yes',
						  'status'     => 'no',
						  'resizable'  => 'no',
						  'screenx'    => '0',
						  'screeny'    => '0',
						  'class'	   => 'btn',
						);

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
					'member_array' => $member_array,
					'attributes' => $attributes,
					'count_users' => $count_users,
				);
			$this->session->set_userdata('side_page', '1');
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view($viewpage); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function view($level,$uid)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{
			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$userdata = $this->m_accounts->getinfo($session_data['uid']);

			if(!isset($uid))
			{
				$uid = $session_data['uid'];
			}

			switch($level)
			{
				case 'member':	$userdb = "users_meb";
								$usertype = "meb_id";
								$viewpage = 'v_usermgt_member';
								break;
				case 'agent':	$userdb = "users_agt";
								$usertype = "agt_id";
								$viewpage = 'v_usermgt_agent';
								break;	
				case 'agentgroup':	$userdb = "users_agg";
									$usertype = "agg_id";
									$viewpage = 'v_usermgt_agentgroup';
									break;	
				case 'master':	$userdb = "users_mas";
								$usertype = "mas_id";
								$viewpage = 'v_usermgt_member';
								break;	
				case 'manager':	$userdb = "users_man";
								$usertype = "man_id";
								$viewpage = 'v_usermgt_member';
								break;	
			}

			$member_array = $this->m_accounts->get_allusers($uid, $userdb, $session_data['uid'],$usertype);

			switch(strlen($session_data['uid']))
			{
				case 2: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						$count_users['agt'] = $this->m_accounts->count_users($session_data['uid'],'users_agt');
						$count_users['agg'] = $this->m_accounts->count_users($session_data['uid'],'users_agg');
						break;
				
				case 4: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						$count_users['agt'] = $this->m_accounts->count_users($session_data['uid'],'users_agt');
						break;

				case 6: $count_users['meb'] = $this->m_accounts->count_users($session_data['uid'],'users_meb');
						break;

				default: $count_users = 0;

			}

			$attributes = array(
						  'width'      => '885',
						  'height'     => '700',
						  'scrollbars' => 'yes',
						  'status'     => 'no',
						  'resizable'  => 'no',
						  'screenx'    => '0',
						  'screeny'    => '0',
						  'class'	   => 'btn',
						);

			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'bigvalue' => $serverdata['bigprice'],
					'smallvalue' => $serverdata['smallprice'],
					'closetime' => $serverdata['closetime'],
					'userdata' => $userdata,
					'member_array' => $member_array,
					'attributes' => $attributes,
					'count_users' => $count_users,
				);
			
			$this->load->view('v_header',$header_data);
			$this->load->view('v_sidelinks');
			$this->load->view($viewpage); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function add($level)
	{
		if($this->session->userdata('userinfo'))
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');

			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$downlinedata = 0;
			switch($level)
			{
				case 'agentgroup'	:	$viewpage = 'v_addagg';
										$this->form_validation->set_rules('agg_id', 'Username', 'trim|required|min_length[2]|max_length[2]|alpha_numeric');
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('intake_tax', 'Intake Tax', 'trim|required|numeric|less_than[1]');
										$this->form_validation->set_rules('intake_big', 'Intake Big', 'trim|required|numeric');
										$this->form_validation->set_rules('intake_small', 'Intake Small', 'trim|required|numeric');
										$this->form_validation->set_rules('sharemas', 'Share Intake', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('sharepo', 'Share Placeout', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('shareco', 'Share Company', 'trim|required|numeric|less_than[100]');
										break;

				case 'agent'		:	$viewpage = 'v_addagt';
										$downlinedata = $this->m_accounts->getuplinedata_type($session_data['uid'],'agg_id');
										//$this->form_validation->set_rules('agg_id', 'Username', 'trim|required');
										$this->form_validation->set_rules('agt_id', 'Username', 'trim|required|min_length[2]|max_length[2]|alpha_numeric');
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('credit', 'Credit', 'trim|required|numeric');
										$this->form_validation->set_rules('intake_tax', 'Intake Tax', 'trim|required|numeric|less_than[1]');
										$this->form_validation->set_rules('intake_big', 'Intake Big', 'trim|required|numeric');
										$this->form_validation->set_rules('intake_small', 'Intake Small', 'trim|required|numeric');
										$this->form_validation->set_rules('shareagg', 'Share Intake', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('sharemas', 'Share Master', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('shareco', 'Share Company', 'trim|required|numeric|less_than[100]');
										break;

				case 'member'		:	$viewpage = 'v_addmeb';
										$downlinedata = $this->m_accounts->getuplinedata_type($session_data['uid'],'agt_id');
										$this->form_validation->set_rules('meb_id', 'Username', 'trim|required|min_length[2]|max_length[2]|alpha_numeric');
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('credit', 'Credit', 'trim|required|numeric');
										$this->form_validation->set_rules('handphone1', 'Mobile phone 1', 'trim|numeric');
										$this->form_validation->set_rules('handphone2', 'Mobile phone 2', 'trim|numeric');
										break;
				default				:	redirect('c_login', 'refresh');
										break;
			}


			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'downlinedata' => $downlinedata,
				);

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view($viewpage,$header_data);
			}
			else
			{
				$newdownline_data = array();

				switch($level)
				{
					case 'agentgroup'	:	$viewpage = 'v_addagg';

											if(strlen($session_data['uid']) == 2)
											{
												$mas_id = $session_data['uid'];
												$mas_info = $this->m_accounts->getinfo($session_data['uid']);
											}
											else
											{
												$mas_id = $this->input->post('mas_id');
												$mas_info = $this->m_accounts->getinfo($this->input->post('mas_id'));
											}
											if($this->m_accounts->count_users($mas_id.$this->input->post('agg_id'),'users_agg') > 0)
											{
												echo '<script type="text/javascript">alert("Account already exist!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $this->input->post('intake_tax') == 0)
											{
												echo '<script type="text/javascript">alert("Intake Tax cannot be 0 with Intake Big or Small set!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($mas_info['intake_big'] == 0 || $mas_info['intake_small'] == 0) && $this->input->post('sharemas') > 0)
											{
												echo '<script type="text/javascript">alert("Share Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($mas_info['share_co'] == 0 && $this->input->post('shareco') > 0)
											{
												echo '<script type="text/javascript">alert("Share Company is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($mas_info['share_po'] == 0 && $this->input->post('sharepo') > 0)
											{
												echo '<script type="text/javascript">alert("Share Place Out is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}

											$newdownline_data[] = array(
												'man_id' => strtolower($mas_info['man_id']),
												'mas_id' => strtolower($mas_id),
												'agg_id' => strtolower($mas_id.$this->input->post('agg_id')),
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'intake_tax' => $this->input->post('intake_tax'),
												'intake_big' => $this->input->post('intake_big'),
												'intake_small' => $this->input->post('intake_small'),
												'share_co' => $this->input->post('shareco'),
												'share_po' => $this->input->post('sharepo'),
												'share_mas' => $this->input->post('sharemas'),
												'status' => 'active',
												);
											$this->m_accounts->add_downline($newdownline_data, 'users_agg');
											$this->m_accounts->add_aradownline($mas_info['man_id'],$mas_id,$this->input->post('agg_id')); // Add ARA accounts
											echo '<script type="text/javascript">alert("Account Added Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					case 'agent'		:	$viewpage = 'v_addagt';
											$downlinedata = $this->m_accounts->getuplinedata_type($session_data['uid'],'agg_id');
											if(strlen($session_data['uid']) == 4)
											{
												$agg_id = $session_data['uid'];
												$agg_info = $this->m_accounts->getinfo($session_data['uid']);
											}
											else
											{
												if($this->input->post('agg_id') == '#')
												{
													echo '<script type="text/javascript">alert("Please select Group Account!");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}
												else
												{
													$agg_id = $this->input->post('agg_id');
													$agg_info = $this->m_accounts->getinfo($this->input->post('agg_id'));
												}
											}
											if($this->m_accounts->count_users($agg_id.$this->input->post('agt_id'),'users_agt') > 0)
											{
												echo '<script type="text/javascript">alert("Account already exist!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $this->input->post('intake_tax') == 0)
											{
												echo '<script type="text/javascript">alert("Intake Tax cannot be 0 with Intake Big or Small set!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $agg_info['intake_tax'] == 0)
											{
												echo '<script type="text/javascript">alert("Intake Not Allowed for Agent! Please Contact Upline.");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}

											if(($agg_info['intake_big'] == 0 || $agg_info['intake_small'] == 0) && $this->input->post('shareagg') > 0)
											{
												echo '<script type="text/javascript">alert("Share Group Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($agg_info['share_co'] == 0 && $this->input->post('shareco') > 0)
											{
												echo '<script type="text/javascript">alert("Share Company is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($agg_info['share_mas'] == 0 && $this->input->post('sharemas') > 0)
											{
												echo '<script type="text/javascript">alert("Share Master Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											$newdownline_data[] = array(
												'man_id' => strtolower($agg_info['man_id']),
												'mas_id' => strtolower($agg_info['mas_id']),
												'agg_id' => strtolower($agg_id),
												'agt_id' => strtolower($agg_id.$this->input->post('agt_id')),
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'intake_tax' => $this->input->post('intake_tax'),
												'intake_big' => $this->input->post('intake_big'),
												'intake_small' => $this->input->post('intake_small'),
												'share_co' => $this->input->post('shareco'),
												'share_mas' => $this->input->post('sharemas'),
												'share_agg' => $this->input->post('shareagg'),
												'status' => 'active',
												'credit' => $this->input->post('credit'),
												'balance' => $this->input->post('credit') 
												);
											$this->m_accounts->add_downline($newdownline_data, 'users_agt');
											echo '<script type="text/javascript">alert("Account Added Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					case 'member'		:	$viewpage = 'v_addmeb';
											$downlinedata = $this->m_accounts->getuplinedata_type($session_data['uid'],'agt_id');
											if(strlen($session_data['uid']) == 6)
											{
												$agt_id = $session_data['uid'];
												$agt_info = $this->m_accounts->getinfo($session_data['uid']);
											}
											else
											{
												if($this->input->post('agt_id') == '#')
												{
													echo '<script type="text/javascript">alert("Please select Agent Account!");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}
												else
												{
													$agt_id = $this->input->post('agt_id');
													$agt_info = $this->m_accounts->getinfo($this->input->post('agt_id'));
												}
											}
											if($this->m_accounts->count_users($agt_id.$this->input->post('meb_id'),'users_meb') > 0)
											{
												echo '<script type="text/javascript">alert("Account already exist!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($agt_info['balance'] < $this->input->post('credit'))
											{
												echo '<script type="text/javascript">alert("Insufficient Balance!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											$newdownline_data[] = array(
												'man_id' => strtolower($agt_info['man_id']),
												'meb_id' => strtolower($agt_id.$this->input->post('meb_id')),
												'mas_id' => strtolower($agt_info['mas_id']),
												'agg_id' => strtolower($agt_info['agg_id']),
												'agt_id' => strtolower($agt_id),
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'handphone1' => $this->input->post('handphone1'),
												'handphone2' => $this->input->post('handphone2'),
												'status' => 'active',
												'credit' => $this->input->post('credit'),
												'balance' => $this->input->post('credit'), 
												'refresh' => $this->input->post('refresh'), 
												);
											$this->m_accounts->add_downline($newdownline_data, 'users_meb');
											$this->m_accounts->update_deduct_balance($this->input->post('credit'), $agt_id); // update balance
											echo '<script type="text/javascript">alert("Account Added Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					default				:	redirect('c_login', 'refresh');
											break;
				}	

			}
			
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

	function edit($level,$uid)
	{
		if($this->session->userdata('userinfo'))
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');

			$session_data = $this->session->userdata('userinfo');
			$serverdata = $this->m_system->settings_server();
			$uid_data = $this->m_accounts->secure_getinfo($uid, $session_data['uid']);
			$difference = 0;
			if(!isset($uid_data))
			{
				echo '<script type="text/javascript">alert("Serious Error! Please contact admin!");</script>';
				echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
				redirect('c_login', 'refresh');
			}

			switch($level)
			{
				case 'agentgroup'	:	$viewpage = 'v_viewagg';
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('intake_tax', 'Intake Tax', 'trim|required|numeric|less_than[1]');
										$this->form_validation->set_rules('intake_big', 'Intake Big', 'trim|required|numeric');
										$this->form_validation->set_rules('intake_small', 'Intake Small', 'trim|required|numeric');
										$this->form_validation->set_rules('sharemas', 'Share Intake', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('sharepo', 'Share Placeout', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('shareco', 'Share Company', 'trim|required|numeric|less_than[100]');
										break;

				case 'agent'		:	$viewpage = 'v_viewagt';
										//$this->form_validation->set_rules('agg_id', 'Username', 'trim|required');
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('intake_tax', 'Intake Tax', 'trim|required|numeric|less_than[1]');
										$this->form_validation->set_rules('intake_big', 'Intake Big', 'trim|required|numeric');
										$this->form_validation->set_rules('intake_small', 'Intake Small', 'trim|required|numeric');
										$this->form_validation->set_rules('shareagg', 'Share Group Intake', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('sharemas', 'Share Master Intake', 'trim|required|numeric|less_than[100]');
										$this->form_validation->set_rules('shareco', 'Share Company', 'trim|required|numeric|less_than[100]');
										break;

				case 'member'		:	$viewpage = 'v_viewmeb';
										$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[15]');
										$this->form_validation->set_rules('password', 'Password', 'required');
										$this->form_validation->set_rules('placeout_com', 'Ticket Commision', 'required|numeric|less_than[15]');
										$this->form_validation->set_rules('handphone1', 'Mobile phone 1', 'trim|numeric');
										$this->form_validation->set_rules('handphone2', 'Mobile phone 2', 'trim|numeric');
										break;
				default				:	redirect('c_login', 'refresh');
										break;
			}


			$header_data = array(
					'sitename' => $serverdata['sitename'],
					'uid' => $session_data['uid'],
					'uid_data' => $uid_data,
				);

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view($viewpage,$header_data);
			}
			else
			{
				switch($level)
				{
					case 'agentgroup'	:	$viewpage = 'v_viewagg';
											$agg_info = $this->m_accounts->getinfo($uid);

											if(strlen($session_data['uid']) == 2)
											{
												$mas_id = $session_data['uid'];
											}
											else
											{
												$mas_id = $agg_info['mas_id'];
											}
											
											$mas_info = $this->m_accounts->getinfo($mas_id); // Get Master infor

											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $this->input->post('intake_tax') == 0)
											{
												echo '<script type="text/javascript">alert("Intake Tax cannot be 0 with Intake Big or Small set!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($mas_info['intake_big'] == 0 || $mas_info['intake_small'] == 0) && $this->input->post('sharemas') > 0)
											{
												echo '<script type="text/javascript">alert("Share Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($mas_info['share_co'] == 0 && $this->input->post('shareco') > 0)
											{
												echo '<script type="text/javascript">alert("Share Company is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($mas_info['share_po'] == 0 && $this->input->post('sharepo') > 0)
											{
												echo '<script type="text/javascript">alert("Share Place Out is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}

					/*if($this->input->post('placeout_com') != $agg_info['placeout_com'])
											{
												$today = date("l");
												if (($today=="Wednesday") || ($today=="Saturday") || ($today=="Sunday"))
												{
													$server_data = $this->m_system->settings_server();
													$timenow = date('H:i:s');
													$timeonehour = date("H:i:s", strtotime ($server_data['closetime']) + 55 * 60);

													if ($timenow <= $server_data['closetime'])
													{
														echo '<script type="text/javascript">alert("Placeout comm change is disabled during draw day!");</script>';
														$this->load->view($viewpage,$header_data);
														break;
													}
												}
											}*/

											$newdownline_data = array(
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'intake_tax' => $this->input->post('intake_tax'),
												'intake_big' => $this->input->post('intake_big'),
												'intake_small' => $this->input->post('intake_small'),
												'share_co' => $this->input->post('shareco'),
												'share_po' => $this->input->post('sharepo'),
												'share_mas' => $this->input->post('sharemas'),
												'status' => $this->input->post('status'),
												);
											
											if($this->input->post('status') == 'closed')
											{
												$this->m_accounts->close_all_downline($uid,'users_agt');
												$this->m_accounts->close_all_downline($uid,'users_meb');
											}
					
											$this->m_accounts->update_downline($newdownline_data, 'users_agg', $uid);
											echo '<script type="text/javascript">alert("Account Updated Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					case 'agent'		:	$viewpage = 'v_viewagt';
											$agt_info = $this->m_accounts->getinfo($uid);

											if(strlen($session_data['uid']) == 4)
											{
												$agg_id = $session_data['uid'];
											}
											else
											{
												$agg_id = $agt_info['agg_id'];
											}
											
											$agg_info = $this->m_accounts->getinfo($agg_id);
											$credit = $agt_info['credit'];
											$balance = $agt_info['balance'];

					/*if($this->input->post('placeout_com') != $agt_info['placeout_com'])
											{
												$today = date("l");
												if (($today=="Wednesday") || ($today=="Saturday") || ($today=="Sunday"))
												{
													$server_data = $this->m_system->settings_server();
													$timenow = date('H:i:s');
													$timeonehour = date("H:i:s", strtotime ($server_data['closetime']) + 55 * 60);

													if ($timenow <= $server_data['closetime'])
													{
														echo '<script type="text/javascript">alert("Placeout comm change is disabled during draw day!");</script>';
														$this->load->view($viewpage,$header_data);
														break;
													}
												}
											}*/

											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $this->input->post('intake_tax') == 0)
											{
												echo '<script type="text/javascript">alert("Intake Tax cannot be 0 with Intake Big or Small set!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($this->input->post('intake_big') > 0 || $this->input->post('intake_small') > 0) && $agg_info['intake_tax'] == 0)
											{
												echo '<script type="text/javascript">alert("Intake Not Allowed for Agent! Please Contact Upline.");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if(($agg_info['intake_big'] == 0 || $agg_info['intake_small'] == 0) && $this->input->post('shareagg') > 0)
											{
												echo '<script type="text/javascript">alert("Share Group Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($agg_info['share_co'] == 0 && $this->input->post('shareco') > 0)
											{
												echo '<script type="text/javascript">alert("Share Company is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($agg_info['share_mas'] == 0 && $this->input->post('sharemas') > 0)
											{
												echo '<script type="text/javascript">alert("Share Master Intake is not available for this downline!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}
											if($this->input->post('updatecredit') < 0) // deduction of credit
											{
												if(($agt_info['credit'] + $this->input->post('updatecredit')) < 0)
												{
													echo '<script type="text/javascript">alert("Credit cannot be deducted to less than 0");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}

												$newcredit = $agt_info['credit'] + $this->input->post('updatecredit');
												$difference = $agt_info['credit'] - $newcredit; // to be refunded to upline
												
												if(($agt_info['balance'] + $this->input->post('updatecredit')) >= 0)
												{
													$credit = $newcredit;
													$balance = $agt_info['balance'] + $this->input->post('updatecredit');
												}
												else
												{
													echo '<script type="text/javascript">alert("Not enough balance to update credit");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}
												//$this->m_accounts->update_add_balance($this->input->post('credit'), $mas_id); // update balance
											}
											if($this->input->post('updatecredit') > 0) // additional of credit
											{
												$newcredit = $agt_info['credit'] + $this->input->post('updatecredit');
												$credit = $newcredit;
												$balance = $agt_info['balance'] + $this->input->post('updatecredit');
											}											

											$balance = $balance + $this->input->post('updatebal');

											$newdownline_data = array(
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'intake_tax' => $this->input->post('intake_tax'),
												'intake_big' => $this->input->post('intake_big'),
												'intake_small' => $this->input->post('intake_small'),
												'share_co' => $this->input->post('shareco'),
												'share_mas' => $this->input->post('sharemas'),
												'share_agg' => $this->input->post('shareagg'),
												'status' => $this->input->post('status'),
												'credit' => $credit,
												'balance' => $balance, 
												);
											$this->m_accounts->update_downline($newdownline_data, 'users_agt', $this->input->post('agt_id'));
					
											if($this->input->post('status') == 'closed')
												{
													$this->m_accounts->close_all_downline($uid,'users_meb');
												}
					
											echo '<script type="text/javascript">alert("Account Updated Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					case 'member'		:	$viewpage = 'v_viewmeb';
											$meb_info = $this->m_accounts->getinfo($uid);

											if(strlen($session_data['uid']) == 6)
											{
												$agt_id = $session_data['uid'];
											}
											else
											{
												$agt_id = $meb_info['agt_id'];
											}
											
											$agt_info = $this->m_accounts->getinfo($agt_id);
											$credit = $meb_info['credit'];
											$balance = $meb_info['balance'];

					/*if($this->input->post('placeout_com') != $meb_info['placeout_com'])
											{
												$today = date("l");
												if (($today=="Wednesday") || ($today=="Saturday") || ($today=="Sunday"))
												{
													$server_data = $this->m_system->settings_server();
													$timenow = date('H:i:s');
													$timeonehour = date("H:i:s", strtotime ($server_data['closetime']) + 55 * 60);

													if ($timenow <= $server_data['closetime'])
													{
														echo '<script type="text/javascript">alert("Placeout comm change is disabled during draw day!");</script>';
														$this->load->view($viewpage,$header_data);
														break;
													}
												}
											}*/

											if($agt_info['balance'] < $this->input->post('updatecredit'))
											{
												echo '<script type="text/javascript">alert("Insufficient Balance!");</script>';
												$this->load->view($viewpage,$header_data);
												break;
											}

											if($this->input->post('updatecredit') < 0) // deduction of credit
											{
												if(($meb_info['credit'] + $this->input->post('updatecredit')) < 0)
												{
													echo '<script type="text/javascript">alert("Credit cannot be deducted to less than 0");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}

												$newcredit = $meb_info['credit'] + $this->input->post('updatecredit');
												$difference = $meb_info['credit'] - $newcredit; // to be refunded to upline
												
												if(($meb_info['balance'] + $this->input->post('updatecredit')) >= 0)
												{
													$credit = $newcredit;
													$balance = $meb_info['balance'] + $this->input->post('updatecredit');
												}
												else
												{
													echo '<script type="text/javascript">alert("Not enough balance to update credit");</script>';
													$this->load->view($viewpage,$header_data);
													break;
												}
												//$this->m_accounts->update_add_balance($this->input->post('credit'), $mas_id); // update balance
											}
											if($this->input->post('updatecredit') > 0) // additional of credit
											{
												$newcredit = $meb_info['credit'] + $this->input->post('updatecredit');
												$credit = $newcredit;
												$balance = $meb_info['balance'] + $this->input->post('updatecredit');
											}											

											$balance = $balance + $this->input->post('updatebal');

											$newdownline_data = array(
												'password' => $this->input->post('password'),
												'name' => $this->input->post('name'),
												'placeout_com' => $this->input->post('placeout_com'),
												'handphone1' => $this->input->post('handphone1'),
												'handphone2' => $this->input->post('handphone2'),
												'status' => $this->input->post('status'),
												'credit' => $credit,
												'balance' => $balance, 
												'refresh' => $this->input->post('refresh'), 
												);

											$this->m_accounts->update_downline($newdownline_data, 'users_meb', $this->input->post('meb_id'));

											if($difference > 0)
											{
												$this->m_accounts->update_add_balance($difference, $agt_id); // update balance
											}
											else
											{
												$this->m_accounts->update_deduct_balance($this->input->post('updatecredit'), $agt_id); // update balance
											}

											//$this->m_accounts->update_deduct_balance($this->input->post('credit'), $agt_id); // update balance
											echo '<script type="text/javascript">alert("Account Updated Successfully!");</script>';
											echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
											break;

					default				:	redirect('c_login', 'refresh');
											break;
				}	
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


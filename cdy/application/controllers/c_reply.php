<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_reply extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
		$this->load->model('m_accounts','',TRUE);
	}

	function reply_view($id,$flag)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{			
			if($this->input->post('Reply'))
			{
				$domain = "gateway.onewaysms.sg";
				$port = 10002;
				
				//$domain = "www.isms.com.my";
				//$port = 80;
				
				
				$this->m_system->send_sms($domain, $port, "username", "password", $this->input->post('mobile'), $this->input->post('smsreply'));
				$this->m_accounts->sms_mark_reply($this->input->post('sms_id'), $this->input->post('smsreply')); // Set sms as Replied
				echo '<script type="text/javascript">alert("SMS Sent!");</script>';
				echo "<script type='text/javascript'>window.open('', '_self', ''); window.close();</script>";
				//$this->load->view('v_showpost'); // default view after login is profile
			}
			if($flag == 'true')
			{
				$data = $this->m_accounts->get_smsmsg($id);
				$header_data = array(
						'msg' => $data['msg'],
						'mobile' => $data['mobile'],
						'sms_id' => $id,
					);
				$this->load->view('v_reply',$header_data); // default view after login is profile
			}
			else
			{
				$data = $this->m_accounts->get_smsmsg($id);
				$header_data = array(
						'msg' => '',
						'mobile' => $data['mobile'],
						'sms_id' => $id,
					);
				$this->load->view('v_reply',$header_data); // default view after login is profile
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


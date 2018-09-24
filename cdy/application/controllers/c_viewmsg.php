<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_viewmsg extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_system','',TRUE);
		$this->load->model('m_accounts','',TRUE);
	}

	function view($id)
	{
		$this->load->helper(array('form'));

		if($this->session->userdata('userinfo'))
		{			

				$data = $this->m_accounts->get_smsmsg($id);
				$header_data = array(
						'msg' => $data['msg'],
						'mobile' => $data['mobile'],
						'sms_id' => $id,
					);
				$this->load->view('v_view',$header_data); // default view after login is profile
		}
		else
		{
			//If no session, redirect to login page
			redirect('c_login', 'refresh');
		}
	}

}

?>


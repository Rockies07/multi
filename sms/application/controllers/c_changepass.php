<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class c_changepass extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_accounts','',TRUE); //load model file user.php
	}

	function index()
	{
		//This method will have the credentials validation
		$session_data = $this->session->userdata('userinfo');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('new_pass1', 'New Password', 'trim|required|xss_clean|matches[new_pass2]');
		$this->form_validation->set_rules('new_pass2', 'New Password Confirmation', 'trim|required|xss_clean');


		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.&nbsp; User redirected to login page
			echo '<script type="text/javascript">alert("Your Passwords do not match!");</script>';
			redirect('c_profile', 'refresh');
		}
		else
		{
			$newpass = $this->input->post('new_pass2');
			echo '<script type="text/javascript">alert("Password Update successfully!");</script>';
			$this->m_accounts->changepass($session_data['uid'], $newpass);
			redirect('c_profile', 'refresh');
		}
	}

}

?>

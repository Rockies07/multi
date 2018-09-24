<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_VerifyLogin extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_accounts','',TRUE); //load model file user.php
	}

	function index()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');


		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.&nbsp; User redirected to login page
			$this->load->view('v_login');
		}
		else
		{
			//Go to private area
			redirect('c_smsincoming', 'refresh');
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.&nbsp; Validate against database
		$username = $this->input->post('username');
		$account_type = "users_adm";
		$account_db = "adm_id";
		//query the database

		//echo "account type = ".$account_type."<br>";

		$result = $this->m_accounts->login($username, $password, $account_type, $account_db);

		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'uid' => $row->$account_db,
					);
				$this->session->set_userdata('userinfo', $sess_array);
			}

			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}

?>

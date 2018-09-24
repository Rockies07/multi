<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Access_Controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(!$this->access->is_login())
		{
			redirect('user_access/login');
		}
	}
	 
	function is_login()
	{
		return $this->access->is_login();
	}
}

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
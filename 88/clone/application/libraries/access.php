<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access
{
	public $user;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->CI =& get_instance();
		$auth = $this->CI->config->item('auth');
		
		$this->CI->load->helper('cookie');
		$this->CI->load->model('user_access_model');
		
		$this->user_access_model =& $this->CI->user_access_model;
	}
	
	/**
	 * Check User Login
	 */
	function login($username, $password)
	{
		$result=$this->user_access_model->get_login($username);
		
		if($result) //IF Result Found
		{
			//$password=md5($password);
			if($password===$result->password && $result->status=="Active")
			{
				//Start Session
				$this->CI->session->set_userdata('username',$username);
				$this->CI->session->set_userdata('user_id',$result->id);
				$this->CI->session->set_userdata('is_admin',$result->is_admin);
				$this->CI->session->set_userdata('site_name','Shop899');
				$this->CI->session->set_userdata('sys_name','Shop899');
				$this->CI->session->set_userdata('sys_motto','Shop899');
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/**
	 * Check is_login
	 */
	function is_login()
	{
		return (($this->CI->session->userdata('username'))?TRUE:FALSE);
	}
	
	/**
	 * get level
	 */
	function get_admin()
	{
		return $this->CI->session->userdata('is_admin');
	}
	
	/**
	 * get level
	 */
	
	function get_username()
	{
		return $this->CI->session->userdata('username');
	}

	function get_user_id()
	{
		return $this->CI->session->userdata('user_id');
	}

	function get_site_name()
	{
		return $this->CI->session->userdata('site_name');
	}

	function get_sys_name()
	{
		return $this->CI->session->userdata('sys_name');
	}

	function get_sys_motto()
	{
		return $this->CI->session->userdata('sys_motto');
	}
	
	/**
	 * Logout
	 */
	function logout()
	{
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('user_id');
		$this->CI->session->unset_userdata('is_admin');
		$this->CI->session->unset_userdata('site_name');
		$this->CI->session->unset_userdata('sys_name');
		$this->CI->session->unset_userdata('sys_motto');
	}
}

/* End of file access.php */
/* Location: ./application/libraries/access.php */
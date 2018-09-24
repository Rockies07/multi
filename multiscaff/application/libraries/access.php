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
		$this->CI->load->model('setting_model');
		
		$this->user_access_model =& $this->CI->user_access_model;
		$this->setting_model =& $this->CI->setting_model;
	}
	
	/**
	 * Check User Login
	 */
	function login($username, $password)
	{
		$result=$this->user_access_model->get_login($username);
		$get_setting=$this->setting_model->get_by_id(1);
		
		if($result) //IF Result Found
		{
			//$password=md5($password);
			if($password===$result->password)
			{
				//Start Session
				$this->CI->session->set_userdata('username',$username);
				$this->CI->session->set_userdata('position',$result->position);
				$this->CI->session->set_userdata('role_id',$result->role_id);
				$this->CI->session->set_userdata('site_name',$get_setting->site_name);
				$this->CI->session->set_userdata('sys_name',$get_setting->sys_name);
				$this->CI->session->set_userdata('sys_motto',$get_setting->sys_motto);
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
	function get_position()
	{
		return $this->CI->session->userdata('position');
	}
	
	/**
	 * get level
	 */
	
	function get_username()
	{
		return $this->CI->session->userdata('username');
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
		$this->CI->session->unset_userdata('position');
		$this->CI->session->unset_userdata('role_id');
		$this->CI->session->unset_userdata('site_name');
		$this->CI->session->unset_userdata('sys_name');
		$this->CI->session->unset_userdata('sys_motto');
	}
}

/* End of file access.php */
/* Location: ./application/libraries/access.php */
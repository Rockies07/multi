<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_access extends CI_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');

		$global_data = array(
			'title'=>$this->access->get_site_name(),
			'sys_name'=>$this->access->get_sys_name(),
			'quote'=>$this->access->get_sys_motto(),
			'is_admin'=>$this->access->get_admin(),
		);

		//Send the data into the current view
		//http://ellislab.com/codeigniter/user-guide/libraries/loader.html
		$this->load->vars($global_data);
	}
	 
	function index()
	{
		$this->access->logout();
		$this->login();
	}
	
	function login()
	{
		$data['action']=site_url('user_access/login');
		$data['attribute'] = array('class' => 'form-signin');
		
		$this->form_validation->set_rules('username','Username','trim|strip_tags');
		$this->form_validation->set_rules('password','Password','trim');
		$this->form_validation->set_rules('token','token','callback_check_login');
		
		//$this->output->enable_profiler(1);
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('index',$data);
		}
		else 
		{
			redirect('home/index');
		}
	}
	
	function logout()
	{
		$this->access->logout();
		redirect('home/index');
	}
	
	function check_login()
	{
		$username=$this->input->post('username',TRUE);
		$password=$this->input->post('password',TRUE);
		
		$login=$this->access->login($username,$password);
		if($login)
		{
			return TRUE;
		}
		else 
		{
			$this->form_validation->set_message('check_login','Username or Password invalid');
			return FALSE;
		}
	}
}

/* End of file user_access.php */
/* Location: ./application/controllers/user_access.php */
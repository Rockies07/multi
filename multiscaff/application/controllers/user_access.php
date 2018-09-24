<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_access extends CI_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('setting_model');
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

		$get_setting=$this->setting_model->get_by_id(1);
		$data['title'] = $get_setting->site_name;
		
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
		$get_setting=$this->setting_model->get_by_id(1);
		$data['title'] = $get_setting->site_name;
		
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
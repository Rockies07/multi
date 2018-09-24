<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends User_Access_Controller 
{
	private $limit=30;
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('customer_model','customer_model',TRUE);
		$this->load->model('file_upload_model','file_upload_model',TRUE);
		$this->load->model('user_model','user_model',TRUE);
	}
	 
	function index()
	{	
		$data['file']=$this->file_upload_model->get_data_list();
		$data['user']=$this->user_model->get_data_list();

		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('file/index',$data);
		$this->load->view('template/footer');
	}

	function assign_user($file_id,$user_id)
	{	
		$file=array(
			'user_id'=>$user_id
		);
			
		$this->file_upload_model->update($file_id,$file);
		$this->customer_model->update_customer_user_assign($file_id,$file);
	}
}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */
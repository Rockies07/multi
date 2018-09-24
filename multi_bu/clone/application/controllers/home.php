<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends User_Access_Controller 
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
		$this->load->model('member_model','member_model',TRUE);
	}
	 
	function index()
	{	
		$data['member']=$this->member_model->get_member_report();
		$data['title'] = $this->access->get_site_name();
		$data['sys_name'] = $this->access->get_sys_name();
		$data['quote'] = $this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink',$data);
		$this->load->view('home/index',$data);
		$this->load->view('template/footer');
	}

	function test()
	{
        $this->load->library('csv');
		$result = $this->csv->parse_file('test.csv');

		$i=0;
		foreach ($result as $test_item){
			$i++;
			$data=array(
					'username'=>$test_item['username'],
					'first_name'=>$test_item['first_name'],
					'last_name'=>$test_item['last_name']
			);
				
			$this->customer_model->insert($data);
		}

        $data['test'] =  $result;
        $this->load->view('home/test', $data);  
	}
}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */
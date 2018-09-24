<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends User_Access_Controller 
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
	}
	 
	function index()
	{	
		$data['customer']=$this->customer_model->get_customer_list();

		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('customer/index',$data);
		$this->load->view('template/footer');
	}

	function detail($id)
	{	
		$data['action']=site_url('customer/detail/'.$id);
		$data['link_back']=anchor('customer/detail/'.$id, 'Back', array('class'=>'back'));
		
		$username=$this->input->post('username');
		$edit_id=$this->input->post('edit_id');
		
		if($username!="")
		{
			//if update from existing data
			$customer=array(
					'username'=>$username,
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'level'=>$this->input->post('level'),
					'call_status'=>$this->input->post('call_status'),
					'phone'=>$this->input->post('phone'),
					'email'=>$this->input->post('email'),
					'wechat_id'=>$this->input->post('wechat_id'),
					'qq_id'=>$this->input->post('qq_id'),
					'remark'=>$this->input->post('remark'),
					'notification'=>$this->input->post('notification'),
					'date'=>date('Y-m-d H:i:s',now()),
					'status'=>'Done'
			);
				
			$this->customer_model->update($edit_id,$customer);

			if($this->input->post('call_status')!='')
			{
				$customer_detail=$this->customer_model->get_by_id($edit_id);
				$get_file_id=$customer_detail->file_id;

				$file_detail=$this->file_upload_model->get_by_id($get_file_id);
				$get_total_done=$file_detail->total_done;
				$get_total_row=$file_detail->total_row;
				$new_total_done=$get_total_done+1;

				if($get_total_row==$new_total_done)
				{
					$file=array(
						'total_done'=>$new_total_done,
						'status'=>'Done'
					);
				}
				else
				{
					$file=array(
						'total_done'=>$new_total_done
					);
				}

				$this->file_upload_model->update($get_file_id,$file);
			}
			//$this->output->enable_profiler(1);
			redirect('home/index');
		}

		$data['customer']=$this->customer_model->get_by_id($id);

		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('customer/detail',$data);
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
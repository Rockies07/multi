<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('account_model','account_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['account']=$this->account_model->get_data_list();
		
		if (empty($data['account']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('account/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('name','Account Name','required');
		$this->form_validation->set_rules('type','Type','required');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('account/management/'.$id);
		$data['link_back']=anchor('account/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_account']=$this->account_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$account=array(
					'name'=>$this->input->post('name'),
					'account_no'=>$this->input->post('account_no'),
					'type'=>$this->input->post('type'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->account_model->update($edit_id,$account);
			//$this->output->enable_profiler(1);
			redirect('account/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['account']=$this->account_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('account/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$account=array(
						'name'=>$this->input->post('name'),
						'account_no'=>$this->input->post('account_no'),
						'type'=>$this->input->post('type'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->account_model->insert($account);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('account/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete account
		$this->account_model->delete($id);
		redirect('account/'.$page);
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
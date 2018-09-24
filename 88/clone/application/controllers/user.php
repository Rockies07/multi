<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('user_model','user_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['user']=$this->user_model->get_data_list();
		
		if (empty($data['user']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('user/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('user/management/'.$id);
		$data['link_back']=anchor('user/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_user']=$this->user_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');

		$data['user']=$this->user_model->get_data_list();
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('user/index',$data);
		$this->load->view('template/footer');
		
	}

	function add($id=0)
	{
		$data['action']=site_url('user/add/'.$id);
		$data['link_back']=anchor('user/add/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_user']=$this->user_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			$user=array(
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'status'=>$this->input->post('status'),
					'is_admin'=>$this->input->post('is_admin')
			);
				
			$this->user_model->update($edit_id,$user);
			//$this->output->enable_profiler(1);
			redirect('user/add/'.$edit_id);
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$data['is_admin']=$this->access->get_admin();
				$this->load->view('template/sidelink',$data);
				$this->load->view('user/add',$data);
				$this->load->view('template/footer');
			}
			else
			{
				$user=array(
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'status'=>$this->input->post('status'),
					'is_admin'=>$this->input->post('is_admin')
				);
					
				$id=$this->user_model->insert($user);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('user/management');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete user
		$this->user_model->delete($id);
		redirect('user/'.$page);
	}

	function delete_group($id,$page)
	{
		//delete user
		$this->subgroup_model->delete($id);
		redirect('user/'.$page);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
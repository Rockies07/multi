<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('user_access_model','user_model',TRUE);
		$this->load->model('department_model','department_model',TRUE);
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
		$this->load->view('template/sidelink');
		$this->load->view('user/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('phone','Phone','trim');
		$this->form_validation->set_rules('position','Position','trim');
		$this->form_validation->set_rules('department','Department','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('user/management/'.$id);
		$data['link_back']=anchor('user/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_user']=$this->user_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		$data['department']=$this->department_model->get_data_list();
		
		if($edit_id>"0")
		{
			//if update from existing data
			$user=array(
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'name'=>$this->input->post('name'),
					'phone'=>$this->input->post('phone'),
					'position'=>$this->input->post('position'),
					'department'=>$this->input->post('department'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->user_model->update($edit_id,$user);
			//$this->output->enable_profiler(1);
			redirect('user/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['user']=$this->user_model->get_data_list($this->access->get_username());
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('user/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$user=array(
						'username'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
						'name'=>$this->input->post('name'),
						'phone'=>$this->input->post('phone'),
						'position'=>$this->input->post('position'),
						'department'=>$this->input->post('department'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->user_model->insert($user);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('user/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete user
		$this->user_model->delete($id);
		redirect('user/'.$page);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
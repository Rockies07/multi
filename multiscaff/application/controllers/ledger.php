<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ledger extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('ledger_model','ledger_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['ledger']=$this->ledger_model->get_data_list();
		
		if (empty($data['ledger']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('ledger/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('ledger','Ledger','required');
		$this->form_validation->set_rules('header','Header','required');
		$this->form_validation->set_rules('type','Type','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('ledger/management/'.$id);
		$data['link_back']=anchor('ledger/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_ledger']=$this->ledger_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$ledger=array(
					'code'=>$this->input->post('code'),
					'header'=>$this->input->post('header'),
					'ledger'=>$this->input->post('ledger'),
					'type'=>$this->input->post('type'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->ledger_model->update($edit_id,$ledger);
			//$this->output->enable_profiler(1);
			redirect('ledger/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['ledger']=$this->ledger_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('ledger/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$ledger=array(
						'code'=>$this->input->post('code'),
						'header'=>$this->input->post('header'),
						'ledger'=>$this->input->post('ledger'),
						'type'=>$this->input->post('type'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->ledger_model->insert($ledger);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('ledger/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete ledger
		$this->ledger_model->delete($id);
		redirect('ledger/'.$page);
	}
}

/* End of file ledger.php */
/* Location: ./application/controllers/ledger.php */
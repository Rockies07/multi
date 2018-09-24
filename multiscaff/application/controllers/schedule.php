<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('schedule_model','schedule_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['schedule']=$this->schedule_model->get_data_list();
		
		if (empty($data['schedule']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('schedule/index',$data);
		$this->load->view('template/footer');
	}

	function calendar()
	{
		// Write to $content
		//$data['schedule']=$this->schedule_model->get_data_list();
		/*
		if (empty($data['schedule']))
		{
			show_404();
		}
		*/

		$get_schedule = $this->schedule_model->get_data_list();

		$jsonevents = array();

		foreach($get_schedule as $schedule_item)
	    {
	    	$time_start_arr=explode(" ",$schedule_item->start);
	    	if($time_start_arr[1]=="00:00:00")
	    	{
	    		$time_start=$time_start_arr[0];
	    	}
	    	else
	    	{
	    		$time_start=$schedule_item->start;
	    	}

	    	$time_end_arr=explode(" ",$schedule_item->end);
	    	if($time_end_arr[1]=="00:00:00")
	    	{
	    		$time_end=$time_end_arr[0];
	    	}
	    	else
	    	{
	    		$time_end=$schedule_item->end;
	    	}

	        $jsonevents[] = array(
	            'id' => $schedule_item->id,
	            'title' => $schedule_item->title,
	            'start' => $time_start,
	            'end' => $time_end,
	            'url' => $schedule_item->url,
	            'allDay' => $schedule_item->allDay
	        );
	    }

	    $data['schedule'] = json_encode($jsonevents);
    	
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();

		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('schedule/calendar',$data);
		$this->load->view('template/footer');
	}
	
	function timeline()
	{
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();

		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink');
		$this->load->view('schedule/timeline',$data);
		$this->load->view('template/footer');
	}

	function _set_rules()
	{
		$this->form_validation->set_rules('name','Schedule Name','required');
		$this->form_validation->set_rules('description','Description','trim');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('schedule/management/'.$id);
		$data['link_back']=anchor('schedule/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_schedule']=$this->schedule_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$schedule=array(
					'name'=>$this->input->post('name'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->schedule_model->update($edit_id,$schedule);
			//$this->output->enable_profiler(1);
			redirect('schedule/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['schedule']=$this->schedule_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('schedule/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$schedule=array(
						'name'=>$this->input->post('name'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->schedule_model->insert($schedule);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('schedule/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete schedule
		$this->schedule_model->delete($id);
		redirect('schedule/'.$page);
	}
}

/* End of file schedule.php */
/* Location: ./application/controllers/schedule.php */
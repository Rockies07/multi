<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends User_Access_Controller 
{
	private $limit=30;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('form');
		$this->load->model('product_model','product_model',TRUE);
	}
	 
	function index()
	{
		// Write to $content
		$data['product']=$this->product_model->get_data_list();
		
		if (empty($data['product']))
		{
			show_404();
		}
		
		// Render the template
		$this->load->view('template/header');
		$this->load->view('template/sidelink');
		$this->load->view('product/index',$data);
		$this->load->view('template/footer');
	}
	
	function _set_rules()
	{
		$this->form_validation->set_rules('code','Code','trim');
		$this->form_validation->set_rules('name','Inventory Name','required');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('sales_price','Sales Price','required|numeric');
		$this->form_validation->set_rules('purchase_price','Purchase Price','required|numeric');
		$this->form_validation->set_rules('unit','Unit','trim');
		$this->form_validation->set_rules('stock','Stock','trim|numeric');
	}
	
	function management($id=0)
	{
		$data['action']=site_url('product/management/'.$id);
		$data['link_back']=anchor('product/management/'.$id, 'Back', array('class'=>'back'));
		
		$data['notification']="";
		$data['edit_id']=$id;
		
		$data['edit_product']=$this->product_model->get_by_id($id);
		
		$edit_id=$this->input->post('edit_id');
		
		if($edit_id>"0")
		{
			//if update from existing data
			$product=array(
					'code'=>$this->input->post('code'),
					'name'=>$this->input->post('name'),
					'sales_price'=>$this->input->post('sales_price'),
					'purchase_price'=>$this->input->post('purchase_price'),
					'unit'=>$this->input->post('unit'),
					'stock'=>$this->input->post('stock'),
					'description'=>$this->input->post('description'),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);
				
			$this->product_model->update($edit_id,$product);
			//$this->output->enable_profiler(1);
			redirect('product/management');
		}
		else 
		{
			//set common properties
			//$this->output->enable_profiler(1);
			$this->_set_rules();
				
			if($this->form_validation->run() === FALSE)
			{
				$data['product']=$this->product_model->get_data_list();
				$data['title']=$this->access->get_site_name();
				$data['site_name']=$this->access->get_sys_name();	
				$data['quote']=$this->access->get_sys_motto();
				$this->load->view('template/header',$data);
				$this->load->view('template/sidelink');
				$this->load->view('product/index',$data);
				$this->load->view('template/footer');
			}
			else
			{
				//save data
				$product=array(
						'code'=>$this->input->post('code'),
						'name'=>$this->input->post('name'),
						'sales_price'=>$this->input->post('sales_price'),
						'purchase_price'=>$this->input->post('purchase_price'),
						'unit'=>$this->input->post('unit'),
						'stock'=>$this->input->post('stock'),
						'description'=>$this->input->post('description'),
						'createdate'=>date('Y-m-d H:i:s',now()),
						'createby'=>$this->access->get_username(),
						'updateby'=>$this->access->get_username(),
						'updatedate'=>date('Y-m-d H:i:s',now())
				);
					
				$id=$this->product_model->insert($product);
					
				//set form input nama ="id"
				$this->validation->id=$id;
					
				redirect('product/management/0');
			}
		}
	}
	
	function delete($id,$page)
	{
		//delete product
		$this->product_model->delete($id);
		redirect('product/'.$page);
	}
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */
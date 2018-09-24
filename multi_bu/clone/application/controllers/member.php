<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends User_Access_Controller 
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
		$this->load->model('transaction_model','transaction_model',TRUE);
		$this->load->model('bm_model','bm_model',TRUE);
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

	function setting()
	{	
		$data['member']=$this->member_model->get_data_list();
		$data['title'] = $this->access->get_site_name();
		$data['sys_name'] = $this->access->get_sys_name();
		$data['quote'] = $this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink',$data);
		$this->load->view('member/setting',$data);
		$this->load->view('template/footer');
	}

	function detail($memberid)
	{	
		$data['action']=site_url('member/detail/'.$memberid);
		$data['link_back']=anchor('member/detail/'.$memberid, 'Back', array('class'=>'back'));

		$member_count=$this->input->post('member_count');
		$i=1;
		if(isset($member_count))
		{
			for($i=1;$i<=$member_count;$i++)
			{	
				$pm_post=$this->input->post("pm_check_".$i);
				if($pm_post==='on')
				{
					$pm_value=1;
				}
				else
				{
					$pm_value=0;
				}

				$clr_post=$this->input->post("clr_check_".$i);
				if($clr_post=='on')
				{
					$clr_value=1;
				}
				else
				{
					$clr_value=0;
				}

				$method=$this->input->post('method_'.$i);
				$ref=$this->input->post('ref_'.$i);
				$amount=$this->input->post('amount_'.$i);

				if($method=='payment')
				{
					$table_name='bmdatabase_payment';
				}
				else
				{
					$table_name='bmdatabase_wlplaceout';
				}

				$transaction=array(
					'pm'=>$pm_value,
					'clr'=>$clr_value
				);

				$this->transaction_model->update($table_name,$ref,$transaction);
			}
		}

		$get_total_payment=$this->transaction_model->get_sum_payment('bmdatabase_payment',$memberid)->amount;
		$get_total_placeout=$this->transaction_model->get_sum_payment('bmdatabase_wlplaceout',$memberid)->amount;
		$grand_total=$get_total_placeout+$get_total_payment;

		if($value=='1')
		{
			$total_outstanding=$grand_total;
			$total_amount_due=0-$grand_total;
		}
		else
		{
			$total_outstanding=0-$grand_total;
			$total_amount_due=$grand_total;
		}

		$member_total=array(
			'total'=>$grand_total,
			'outstanding'=>$total_outstanding,
			'amountdue'=>$total_amount_due,
		);

		$this->transaction_model->update_member_total($memberid,$member_total);

		$data['member']=$this->member_model->get_member_report_detail($memberid);
		$data['title'] = $this->access->get_site_name();
		$data['sys_name'] = $this->access->get_sys_name();
		$data['quote'] = $this->access->get_sys_motto();
		$data['bm_model']= $this->bm_model;
		$data['member_model']= $this->member_model;
		$data['memberid']=$memberid;
		$data['transaction_total']=$this->member_model->get_page_total($memberid);
		$this->load->view('template/header',$data);
		$this->load->view('template/sidelink',$data);
		$this->load->view('member/detail',$data);
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

	function update_clone_show($memberid,$value)
	{
		$member=array(
			'clone_show'=>$value
		);

		$this->member_model->update($memberid,$member);

		$data['result']="1";

		echo json_encode($data);
		exit();
	}
}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */
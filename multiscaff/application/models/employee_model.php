<?php
class Employee_model extends CI_Model
{
	private $table_name='employee';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list($status="",$match='1',$filter_nationality="",$filter_work_exp="",$filter_have="",$filter_other="")
	{
		if($status!="")
		{
			if($match=='1')
			{
				$filter_value=" and status='$status' ";
			}
			else
			{
				$filter_value=" and status!='$status' ";
			}
		}

		if($filter_nationality!="")
		{
			$filter_value=$filter_value." and nationality='$filter_nationality' ";
		}

		/*
		if($filter_work_exp!="")
		{
			$filter_value=$filter_value." and (YEAR(NOW()) - YEAR(start_work_date)
    - (DATE_FORMAT(NOW(), '%m%d') < DATE_FORMAT(start_work_date, '%m%d'))+prev_work_exp_year)>=$filter_work_exp ";
		}
		*/

		if($filter_have!="" && $filter_other!="")
		{
			switch($filter_have)
			{	
				case "Have":
							switch($filter_other)
							{
								case '1': $filter_value=$filter_value." and ap_exp_date!='0000-00-00' ";break;
								case '2': $filter_value=$filter_value." and (bcss_no!='' or csoc_no!='') ";break;
								case '3': $filter_value=$filter_value." and (mses_no!='' or msec_no!='' or wahs_no!='' or wahw_no='') ";break;
								case '4': $filter_value=$filter_value." and (core_exp_date!='0000-00-00' or multi_skill_exp_date!='0000-00-00') ";break;
								default : $filter_value=$filter_value; break;
							}
							break;
				case "Don't Have":
							switch($filter_other)
							{
								case '1': $filter_value=$filter_value." and ap_exp_date='0000-00-00' ";break;
								case '2': $filter_value=$filter_value." and bcss_no='' and csoc_no='' ";break;
								case '3': $filter_value=$filter_value." and mses_no='' and msec_no='' and wahs_no='' and wahw_no='' ";break;
								case '4': $filter_value=$filter_value." and core_exp_date='0000-00-00' and multi_skill_exp_date='0000-00-00' ";break;
								default : $filter_value=$filter_value; break;
							}
							break;
				default: $filter_value=$filter_value; break;
			}
		}

		$query=$this->db->query("select * from employee where nts!='' $filter_value order by nts asc");
		return $query->result_array();
	}

	function get_data_list_by_date($date)
	{
		$this->db->select("*,name as emp_name");
		$this->db->where("start_work_date <=", $date);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function insert($value)
	{
		$this->db->insert($this->table_name, $value);
		return $this->db->insert_id();
	}
	
	function update($id,$value)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->update($this->table_name, $value);
	}
	
	function delete($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
	
	function get_employee_count()
	{
		$query = $this->db->count_all_results($this->table_name);
		return $query;
	}
	
	function get_employee_count_by_date($date="")
	{
		$date_arr=explode("/",$date);
		$date=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

		$this->db->where('start_work_date <=', $date);
		$this->db->where('end_work_date >', $date);
		$query = $this->db->count_all_results($this->table_name);
		return $query;
	}

	function is_exist($field,$value)
	{
		$this->db->where($field,$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_employee_by_value($field,$value)
	{
		if($field=="nts")
		{
			$this->db->where('nts',$value);
		}
		else
		{
			$this->db->where('name',$value);
		}
		
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_employee_list_by_value($value, $field){
		//$this->db->select('bird');
		
		if($field=="nts")
		{
			$this->db->like('nts', $value);
			$this->db->order_by('nts', 'ASC');
		}
		else 
		{
			$this->db->like('name', $value);
			$this->db->order_by('name', 'ASC');
		}
		$this->db->where('status','Active');
		$query = $this->db->get($this->table_name);
		if($query->num_rows > 0)
		{
	      	foreach ($query->result_array() as $row){
	      		if($field=="nts")
	      		{
	      			$row_set[] = htmlentities(stripslashes($row['nts']));
	      		}
	      		else
	      		{
	      			$row_set[] = htmlentities(stripslashes($row['name']));
	      		}
		      }
	      	echo json_encode($row_set); //format the array into json data
	      	exit();
	    }
	}
}


/* End of file Employee_model.php */
/* Location: ./application/model/Employee_model.php */
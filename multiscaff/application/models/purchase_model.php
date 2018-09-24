<?php
class Transaction_journal_model extends CI_Model
{
	private $table_name='transaction_journal';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{
		$this->db->select('transaction_journal.id,transaction_journal.date,transaction_journal.project_id,project.name as project_name,transaction_journal.site_id,site.name as site_name,transaction_journal.amount,transaction_journal.location,employee.name as group_name');
		$this->db->from($this->table_name);
		$this->db->join('project', 'project.id = transaction_journal.project_id');
		$this->db->join('site', 'site.id = transaction_journal.site_id');
		$this->db->join('employee', 'employee.nts = transaction_journal.group');
		
		return $this->db->get()->result_array();
	}
	
	function get_report_list($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
		$this->db->select('client.name as client_name,transaction_employee.site_id, project.name as project_name, site.name as site_name,(COUNT(transaction_employee.nts)-SUM(transaction_employee.add_shift)) AS no_of_men,SUM(transaction_employee.normal_salary) AS normal_salary,SUM(transaction_employee.ot_salary) AS ot_salary,SUM(transaction_employee.meal_fee+transaction_employee.ns_fee) AS allowance_fee, site.type as site_type, site.hourly_rate as site_rate, ((SUM(transaction_employee.work_hour*transaction_employee.site_rate)+SUM(transaction_employee.ot_hour*transaction_employee.ot_site_rate))) as job_done, SUM(transaction_employee.work_hour) as total_work_hour, SUM(transaction_employee.ot_hour) as total_ot_hour, (sum(transaction_employee.levy)-(sum(transaction_employee.add_shift*transaction_employee.levy))) as levy, (sum(transaction_employee.dormitory)-(sum(transaction_employee.add_shift*transaction_employee.dormitory))) as dormitory, (sum(transaction_employee.transportation)-(sum(transaction_employee.add_shift*transaction_employee.transportation))) as transportation, (sum(transaction_employee.administration)-(sum(transaction_employee.add_shift*transaction_employee.administration))) as administration, (sum(transaction_employee.operation)-(sum(transaction_employee.add_shift*transaction_employee.operation))) as operation');
		$this->db->from('transaction_employee');
		$this->db->join('project', 'project.id = transaction_employee.project_id');
		$this->db->join('client', 'client.id = project.client_id');
		$this->db->join('site', 'site.id = transaction_employee.site_id');
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_filter_from);
			$date_filter_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		else
		{
			$date_arr=explode("/",$date_filter_to);
			$date_filter_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('transaction_employee.date >=',$date_filter_from);
		$this->db->where('transaction_employee.date <=',$date_filter_to);
		
		if($project!="")
		{
			$this->db->where('transaction_employee.project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('transaction_employee.site_id',$site);
		}
		$types = array('Unit', 'Lumpsum');
		$this->db->where_in('site.type', $types);
		$positions = array('Supervisor', 'Driver', 'Storeman');
		$this->db->where_not_in('transaction_employee.position', $positions);
		$this->db->group_by('site_id');
		$query=$this->db->get()->result_array();

		foreach ($query as &$row)
		{
		   $row['job_done'] = $this->get_jobdone_by_site($row['site_id'],$date_filter_from,$date_filter_to)->amount;
		}
		
		return $query;
	}

	function get_jobdone_by_site($site_id,$date_from,$date_to)
	{
		$this->db->select_sum('amount');
		$this->db->where('site_id',$site_id);
		$this->db->where('date >=',$date_from);
		$this->db->where('date <=',$date_to);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
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
	
	function get_transaction_total($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
		$this->db->select('(COUNT(transaction_employee.nts)-SUM(transaction_employee.add_shift)) AS total_no_of_men,SUM(transaction_employee.normal_salary) AS total_normal_salary,SUM(transaction_employee.ot_salary) AS total_ot_salary,SUM(transaction_employee.meal_fee+transaction_employee.ns_fee) AS total_allowance_fee');
		$this->db->from('transaction_employee');
		$this->db->join('project', 'project.id = transaction_employee.project_id');
		$this->db->join('client', 'client.id = project.client_id');
		$this->db->join('site', 'site.id = transaction_employee.site_id');
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_filter_from);
			$date_filter_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		else
		{
			$date_arr=explode("/",$date_filter_to);
			$date_filter_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('transaction_employee.date >=',$date_filter_from);
		$this->db->where('transaction_employee.date <=',$date_filter_to);
		
		if($project!="")
		{
			$this->db->where('transaction_employee.project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('transaction_employee.site_id',$site);
		}
		$types = array('Unit', 'Lumpsum');
		$this->db->where_in('site.type', $types);
		$positions = array('Supervisor', 'Driver', 'Storeman');
		$this->db->where_not_in('transaction_employee.position', $positions);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function is_exist($field,$value)
	{
		$this->db->where($field,$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
}


/* End of file Transaction_employee_model.php */
/* Location: ./application/model/Transaction_employee_model.php */
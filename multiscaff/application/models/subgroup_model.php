<?php
class Subgroup_model extends CI_Model
{
	private $table_name='subgroup';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_leader_list()
	{
		$this->db->select('subgroup.nts,employee.name');
		$this->db->from($this->table_name);
		$this->db->join('employee', 'employee.nts = subgroup.nts');
		$this->db->group_by('subgroup.leader');
		$query=$this->db->get();
		return $query->result_array();
	}

	function get_data_list($leader)
	{
		$query=$this->db->query("SELECT t2.id as id, e.name as group_name, t1.nts AS lev1, e2.name as emp_name, t2.nts as nts, t2.pos FROM subgroup AS t1 LEFT JOIN subgroup AS t2 ON t2.leader = t1.nts left join employee as e on t1.nts=e.nts left join employee as e2 on t2.nts=e2.nts having nts is not null");
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
		$this->db->where($this->primary_key,$id);
		$get_detail=$this->db->get($this->table_name)->row();
		$nts=$get_detail->nts;

		$this->db->where('leader',$nts);
		$detail_is_leader=$this->db->get($this->table_name);

		if($detail_is_leader->num_rows()>0)
		{
			$this->db->where('leader', $nts);
			$this->db->delete($this->table_name);
		}
		else
		{
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->table_name);
		}
	}
	
	function get_subgroup_count()
	{
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

	function get_employee_on_group($value)
	{
		$this->db->where('leader',$value);
		
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}
}


/* End of file Subgroup_model.php */
/* Location: ./application/model/Subgroup_model.php */
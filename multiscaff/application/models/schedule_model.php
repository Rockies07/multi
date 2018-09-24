<?php
class Schedule_model extends CI_Model
{
	private $table_name='schedule';
	private $primary_key='ref';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{	
		return $this->db->get($this->table_name)->result();
	}
	
	function get_by_ref($id)
	{
		$this->db->where($this->primary_key,$id);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->result():FALSE;
	}

	function get_by_id($id)
	{
		$this->db->where('id',$id);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->result():FALSE;
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

	function update_by_ref($ref,$value)
	{
		$this->db->where("ref", $ref);
		$this->db->update($this->table_name, $value);
	}
	
	function delete($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
	
	function get_schedule_count()
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
}


/* End of file Schedule_model.php */
/* Location: ./application/model/Schedule_model.php */
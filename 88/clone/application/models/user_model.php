<?php
class User_model extends CI_Model
{
	private $table_name='clone_user';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{	
		$this->db->order_by('username');
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}

	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		return $this->db->get($this->table_name)->row();
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
	
	function get_user_count()
	{
		$query = $this->db->count_all_results($this->table_name);
		return $query;
	}

	function is_exist($value)
	{
		$this->db->where('username',$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
}


/* End of file User_model.php */
/* Location: ./application/model/User_model.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud
{
	public $user;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function get_data_list($field, $table_name, $user)
	{
		$this->db->select($field);
		$this->db->from($table_name);
		$this->db->where('username',$user);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		return $this->db->get($this->table_name)->row();
	}
	
	function insert($table_name, $value)
	{
		$this->db->insert($table_name, $value);
		return $this->db->insert_id();
	}
	
	function update($id, $table_name, $value)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->update($table_name, $value);
	}
	
	function delete($id, $table_name)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($table_name);
	}
}

/* End of file access.php */
/* Location: ./application/libraries/access.php */
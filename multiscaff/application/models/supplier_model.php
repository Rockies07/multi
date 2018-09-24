<?php
class Supplier_model extends CI_Model
{
	private $table_name='supplier';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{
		return $this->db->get($this->table_name)->result_array();
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
	
	function get_supplier_count()
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
	
	function get_supplier_by_value($field,$value)
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
	
	function get_supplier_list_by_value($value, $field){
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


/* End of file Supplier_model.php */
/* Location: ./application/model/Supplier_model.php */
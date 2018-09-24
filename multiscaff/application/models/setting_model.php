<?php
class Setting_model extends CI_Model
{
	private $table_name='setting';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{
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
	
	function get_setting_count()
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
	
	function get_setting_by_value($field,$value)
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
	
	function get_setting_list_by_value($value, $field){
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

	function get_multiple_rate($transaction_date,$is_ph)
	{
		$this->db->where($this->primary_key,'1');
		$query=$this->db->get($this->table_name);
		$get_setting=$query->row();

		$time = mktime(0, 0, 0, date('m',strtotime($transaction_date)), date('d',strtotime($transaction_date)), date('Y',strtotime($transaction_date)));
		$weekday = date('w', $time);
		if (($weekday == 0)||($is_ph))
		{
			$ot_multiple=$get_setting->ot_sunday;
		}
		else
		{
			$ot_multiple=$get_setting->ot_weekday;
		}
		return $ot_multiple;
	}
}


/* End of file Setting_model.php */
/* Location: ./application/model/Setting_model.php */
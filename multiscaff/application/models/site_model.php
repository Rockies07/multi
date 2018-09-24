<?php
class Site_model extends CI_Model
{
	private $table_name='site';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list($is_all=0, $status="all")
	{
		$this->db->select('site.id,site.name,site.code,site.type,site.status,site.hourly_rate, site.ot_normal_rate, site.ot_sunday_rate, site.spv_hourly_rate, site.spv_ot_normal_rate, site.spv_ot_sunday_rate, site.unit_rate, site.e_percentage, site.d_percentage, site.project_id, project.name as project_name, site.description, site.spv_payment');
		$this->db->from($this->table_name);
		$this->db->join('project', 'project.id = site.project_id');
		if(! $is_all)
		{
			$this->db->where('site.id >','5');
		}

		if($status!='all')
		{
			$this->db->where('status','Active');
		}

		$this->db->order_by('site.code','ASC');
		return $this->db->get()->result_array();
	}

	function get_data_list_by_type($type="Supply",$status="all")
	{
		$this->db->select('site.id,site.name,site.code,site.type,site.hourly_rate, site.ot_normal_rate, site.ot_sunday_rate, site.spv_hourly_rate, site.spv_ot_normal_rate, site.spv_ot_sunday_rate, site.unit_rate, site.e_percentage, site.d_percentage, site.project_id, project.name as project_name, site.description, site.spv_payment');
		$this->db->from($this->table_name);
		$this->db->join('project', 'project.id = site.project_id');
		
		if($type!="Supply")
		{
			$this->db->where('site.type !=','Supply');
			$this->db->where('site.id >','5');
		}
		else
		{
			$this->db->where('site.type',$type);
		}

		if($status!='all')
		{
			$this->db->where('status','Active');
		}
		
		$this->db->order_by('site.name','ASC');
		return $this->db->get()->result_array();
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
	
	function get_site_count()
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
	
	function get_site_by_value($field,$value)
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
	
	function get_site_list_by_value($value,$status="all")
	{
		//$this->db->select('bird');
		
		$this->db->like('project_id', $value);
		if($status!='all')
		{
			$this->db->where('status','Active');
		}

		$this->db->order_by('name', 'ASC');
		
		$query = $this->db->get($this->table_name);
		$data = array();
	 
	 	if($query->result())
	 	{
	 		$i=0;
	 		foreach ($query->result() as $row) 
	 		{
	 			$text=$row->name;
		 		$data[$row->id] = $text;
		 		$i++;
		 	}	
		 	if($i>1)
		 	{
		 		$data['0']="-Select All-";
		 	}
		 	return $data;
	 	}
	 	else
	 	{
	 		return FALSE;
	 	}
	}

	
}


/* End of file Site_model.php */
/* Location: ./application/model/Site_model.php */
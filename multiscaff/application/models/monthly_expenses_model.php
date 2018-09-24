<?php
class Monthly_expenses_model extends CI_Model
{
	private $table_name='monthly_expenses';
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
	
	function get_monthly_expenses_count()
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
	
	function get_monthly_expenses_by_date($date_filter)
	{
		if($date_filter=="")
		{
			$month=date('m');
			$year=date('Y');
			$date_filter=date('Y-m-d');
		}
		else
		{
			$date_arr=explode("/",$date_filter);
			$month=$date_arr[0];
			$year=$date_arr[2];
		}
		
		$first_day=$year."-".$month."-01";
		$last_day=date('Y-m-t',strtotime($date_filter));

		$sql_get_sunday_count=$this->db->query("select count(row+1) as sunday_count from (SELECT @row := @row + 1 as row FROM (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t1, (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2, (SELECT @row:=-1) t3 limit 31) b where DATE_ADD('$first_day', INTERVAL ROW DAY) between '$first_day' and '$last_day' and DAYOFWEEK(DATE_ADD('$first_day', INTERVAL ROW DAY))=1");
		$get_sunday_count=$sql_get_sunday_count->row()->sunday_count;

		$sql_get_holiday_count=$this->db->query("select count(*) as holiday_count from day_preset where date between '$first_day' and '$last_day'");
		$get_holiday_count=$sql_get_holiday_count->row()->holiday_count;

		$day_of_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$total_day=$day_of_month-$get_sunday_count-$get_holiday_count;
		
		$this->db->select("month, year, levy, dormitory, transportation, administration, operation, (levy/$total_day) as daily_levy, (dormitory/$total_day) as daily_dormitory, (transportation/$total_day) as daily_transportation, (administration/$total_day) as daily_administration, (operation/$total_day) as daily_operation");
		$this->db->from($this->table_name);
		
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_monthly_expenses_list_by_value($value, $field){
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


/* End of file Monthly Expenses_model.php */
/* Location: ./application/model/Monthly Expenses_model.php */
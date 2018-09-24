<?php
class Transaction_employee_model extends CI_Model
{
	private $table_name='transaction_employee';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list_bu($date_filter_from="",$date_filter_from="",$project="",$site="")
	{
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
		
		$complete_filter="and transaction_employee.date between '$date_filter_from' and '$date_filter_to'";
		
		if(($project=="")&&($site=="0"))
		{
			$query_union="UNION Select transaction_employee.id,transaction_employee.date,transaction_employee.project_id,project.name as project_name,transaction_employee.site_id,site.name as site_name,employee.name as employee_name,employee.position,transaction_employee.nts,transaction_employee.hourly_rate,transaction_employee.ot_rate,transaction_employee.work_hour,transaction_employee.ot_hour,transaction_employee.normal_salary,transaction_employee.ot_salary,transaction_employee.meal_fee,transaction_employee.ns_fee from transaction_employee, employee, project, site where employee.nts=transaction_employee.nts and project.id=transaction_employee.project_id and site.id=transaction_employee.site_id $complete_filter HAVING transaction_employee.nts not in (Select nts from transaction_employee where date between '$date_filter_from' and '$date_filter_to')";
		}
		else
		{
			$query_union="";
		}
		
		if($project!="")
		{
			$complete_filter=$complete_filter." and transaction_employee.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$complete_filter=$complete_filter." and transaction_employee.site_id='$site'";
		}

		$query=$this->db->query("Select transaction_employee.id,transaction_employee.date,transaction_employee.project_id,project.name as project_name,transaction_employee.site_id,site.name as site_name,employee.name as employee_name,employee.position,transaction_employee.nts,transaction_employee.hourly_rate,transaction_employee.ot_rate,transaction_employee.work_hour,transaction_employee.ot_hour,transaction_employee.normal_salary,transaction_employee.ot_salary,transaction_employee.meal_fee,transaction_employee.ns_fee from transaction_employee, employee, project, site where employee.nts=transaction_employee.nts and project.id=transaction_employee.project_id and site.id=transaction_employee.site_id $complete_filter $query_union");
		
		return $query->result_array();
	}

	function get_data_list($date_from="",$date_to="",$project="",$site="")
	{
		$this->db->select('transaction_employee.id,transaction_employee.date,transaction_employee.project_id,project.name as project_name,transaction_employee.site_id,site.name as site_name,employee.name as employee_name,employee.position,transaction_employee.nts,transaction_employee.hourly_rate,transaction_employee.ot_rate,transaction_employee.work_hour,transaction_employee.ot_hour,transaction_employee.normal_salary,transaction_employee.ot_salary,transaction_employee.meal_fee,transaction_employee.ns_fee');
		$this->db->from($this->table_name);
		$this->db->join('employee', 'employee.nts = transaction_employee.nts');
		$this->db->join('project', 'project.id = transaction_employee.project_id');
		$this->db->join('site', 'site.id = transaction_employee.site_id');
		
		if($date_from=="")
		{
			$date_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_from);
			$date_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		if($date_to=="")
		{
			$date_to=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_to);
			$date_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('transaction_employee.date >=',$date_from);
		$this->db->where('transaction_employee.date <=',$date_to);
		
		if($project!="")
		{
			$this->db->where('transaction_employee.project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('transaction_employee.site_id',$site);
		}
		return $this->db->get()->result_array();
	}
	
	function get_report_list($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
		$this->db->select('client.name as client_name,transaction_employee.site_id, project.name as project_name, site.name as site_name,(COUNT(transaction_employee.nts)-SUM(transaction_employee.add_shift)) AS no_of_men,SUM(transaction_employee.normal_salary) AS normal_salary,SUM(transaction_employee.ot_salary) AS ot_salary,SUM(transaction_employee.meal_fee+transaction_employee.ns_fee) AS allowance_fee, site.type as site_type, site.hourly_rate as site_rate, ((SUM(transaction_employee.work_hour*transaction_employee.site_rate)+SUM(transaction_employee.ot_hour*transaction_employee.ot_site_rate))) as job_done, SUM(transaction_employee.work_hour) as total_work_hour, SUM(transaction_employee.ot_hour) as total_ot_hour, (sum(transaction_employee.levy)-(sum(transaction_employee.add_shift*transaction_employee.levy))) as levy, (sum(transaction_employee.dormitory)-(sum(transaction_employee.add_shift*transaction_employee.dormitory))) as dormitory, (sum(transaction_employee.transportation)-(sum(transaction_employee.add_shift*transaction_employee.transportation))) as transportation, (sum(transaction_employee.administration)-(sum(transaction_employee.add_shift*transaction_employee.administration))) as administration, (sum(transaction_employee.operation)-(sum(transaction_employee.add_shift*transaction_employee.operation))) as operation');
		$this->db->from($this->table_name);
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
		$this->db->where('site.type',"Supply");
		$positions = array('Driver', 'Storeman');
		$this->db->where_not_in('transaction_employee.position', $positions);
		$this->db->where('transaction_employee.site_id !=',"23");
		$this->db->group_by('site_id');
		return $this->db->get()->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}

	function get_by_project($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
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
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		if(strtotime($date_filter_from)<strtotime('2015-05-01'))
		{
		 	$filter_position = " or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
		}
		else 
		{
			$filter_position = " or s.type='Unit' or s.type='Lumpsum' ";
		}

		$query=$this->db->query("select p.name as project_name, p.id as project_id, c.name as client_name, s.id as site_id, sum(te.normal_salary) as normal_salary, sum(te.ot_salary) as ot_salary, sum(te.meal_fee+te.ns_fee) as allowance_fee, (sum(te.levy)-(sum(te.add_shift*te.levy))) as levy, (sum(te.dormitory)-(sum(te.add_shift*te.dormitory))) as dormitory, (sum(te.transportation)-(sum(te.add_shift*te.transportation))) as transportation, (sum(te.administration)-(sum(te.add_shift*te.administration))) as administration, (sum(te.operation)-(sum(te.add_shift*te.operation))) as operation from transaction_employee te, site s, project p, client c where te.site_id=s.id and te.project_id=p.id and p.client_id=c.id and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' and te.site_id!='23' and te.project_id>1 $date_filter group by te.project_id order by p.name");
		return $query->result_array();
	}

	function get_by_site($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		if(strtotime($date_filter_from)<strtotime('2015-05-01'))
		{
		 	$filter_position = " or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
		}
		else 
		{
			$filter_position = " or s.type='Unit' or s.type='Lumpsum' ";
		}

		$query=$this->db->query("select p.name as project_name, p.id as project_id, c.name as client_name, s.name as site_name, s.id as site_id, sum(te.normal_salary) as normal_salary, sum(te.ot_salary) as ot_salary, sum(te.meal_fee+te.ns_fee) as allowance_fee, (sum(te.levy)-(sum(te.add_shift*te.levy))) as levy, (sum(te.dormitory)-(sum(te.add_shift*te.dormitory))) as dormitory, (sum(te.transportation)-(sum(te.add_shift*te.transportation))) as transportation, (sum(te.administration)-(sum(te.add_shift*te.administration))) as administration, (sum(te.operation)-(sum(te.add_shift*te.operation))) as operation from transaction_employee te, site s, project p, client c where te.site_id=s.id and te.project_id=p.id and p.client_id=c.id and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' and te.site_id!='23' and te.site_id>5 $date_filter group by te.site_id order by s.name");
		return $query->result_array();
	}

	function get_monthly_groupby_date($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
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
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		if(strtotime($date_filter_from)<strtotime('2015-05-01'))
		{
		 	$filter_position = " or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
		}
		else 
		{
			$filter_position = " or s.type='Unit' or s.type='Lumpsum' ";
		}

		$query=$this->db->query("select te.date as date, (count(te.nts)-sum(add_shift)) as no_of_men, sum(te.normal_salary) as normal_salary, sum(te.ot_salary) as ot_salary, sum(te.meal_fee+te.ns_fee) as allowance_fee, (sum(te.levy)-(sum(te.add_shift*te.levy))) as levy, (sum(te.dormitory)-(sum(te.add_shift*te.dormitory))) as dormitory, (sum(te.transportation)-(sum(te.add_shift*te.transportation))) as transportation, (sum(te.administration)-(sum(te.add_shift*te.administration))) as administration, (sum(te.operation)-(sum(te.add_shift*te.operation))) as operation from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' and te.site_id!='23' and te.site_id>5 $date_filter group by te.date");
		return $query->result_array();
	}

	function get_man_count_summary($date_filter_from="",$project="",$site="",$date_filter_to="")
	{
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
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		$count=(strtotime($date_filter_to)-strtotime($date_filter_from))/(60*60*24);

		$i=0;

		$data[$i] = array(
			'project_name'=>'Total Strength',
			'site_id'=>'0',
			'site_name'=>'Total Strength',
			'page'=>'all',
		);

	    for($x=0;$x<=$count;$x++)
		{
			if($x==0)
			{
				$set_date=$date_filter_from;
			}
			else
			{
				$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
			}

			$query_2=$this->db->query("select IFNULL((count(nts)),0) as no_of_men from employee where start_work_date<='$set_date' and end_work_date>'$set_date'");
			
			
			if($query_2->num_rows()>0)
			{
				$no_of_men=$query_2->row()->no_of_men;
			}
			else
			{
				$no_of_men=0;
			}
			
			array_push($data[$i], $no_of_men);
		}
		$i++;

		$query_1=$this->db->query("select te.name as project_name, te.name as site_name, te.id as site_id, te.type as site_type from site te, project p where te.project_id=p.id and te.id<=5 and te.id!=2 order by te.id");

		foreach($query_1->result_array() as $row)
		{
			$data[$i] = array(
				'project_name'=>$row['project_name'],
				'site_id'=>$row['site_id'],
				'site_name'=>$row['site_name'],
				'page'=>'absent',
			);

		    $query_filter=" and te.site_id='$row[site_id]' ";

		    for($x=0;$x<=$count;$x++)
			{
				if($x==0)
				{
					$set_date=$date_filter_from;
				}
				else
				{
					$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
				}

				$loop_date_filter=" and te.date='$set_date'";

				$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id $query_filter $loop_date_filter group by te.site_id order by p.name");
				
				
				if($query_2->num_rows()>0)
				{
					$no_of_men=$query_2->row()->no_of_men;
				}
				else
				{
					$no_of_men=0;
				}
				
				array_push($data[$i], $no_of_men);
			}
		    $i++;
		}

		$data[$i] = array(
			'project_name'=>'Driver',
			'site_id'=>'23',
			'site_name'=>'Driver',
			'page'=>'driver',
		);

	    $query_filter=" and te.site_id='$row[site_id]' ";

	    for($x=0;$x<=$count;$x++)
		{
			if($x==0)
			{
				$set_date=$date_filter_from;
			}
			else
			{
				$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
			}

			$loop_date_filter=" and te.date='$set_date'";

			$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te where te.position='Driver' $loop_date_filter");
			
			
			if($query_2->num_rows()>0)
			{
				$no_of_men=$query_2->row()->no_of_men;
			}
			else
			{
				$no_of_men=0;
			}
			
			array_push($data[$i], $no_of_men);
		}
		$i++;

		$data[$i] = array(
			'project_name'=>'Storeman',
			'site_id'=>'23',
			'site_name'=>'Storeman',
			'page'=>'storeman',
		);

	    $query_filter=" and te.site_id='$row[site_id]' ";

	    for($x=0;$x<=$count;$x++)
		{
			if($x==0)
			{
				$set_date=$date_filter_from;
			}
			else
			{
				$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
			}

			$loop_date_filter=" and te.date='$set_date'";

			$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te where (te.position='Storeman' or (te.position!='Driver' and te.position!='Storeman' and te.site_id='23')) $loop_date_filter");
			
			
			if($query_2->num_rows()>0)
			{
				$no_of_men=$query_2->row()->no_of_men;
			}
			else
			{
				$no_of_men=0;
			}
			
			array_push($data[$i], $no_of_men);
		}
		$i++;
		
		$query_1=$this->db->query("select p.id as project_id, p.name as project_name, s.name as site_name, te.site_id as site_id, s.type as site_type from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and te.position!='Driver' and te.position!='Storeman' and te.site_id>5 $date_filter group by te.project_id order by p.name");

		foreach($query_1->result_array() as $row)
		{
			$data[$i] = array(
				'project_id'=>$row['project_id'],
				'project_name'=>$row['project_name'],
				'site_id'=>$row['site_id'],
				'site_name'=>$row['site_name'],
				'page'=>'project',
			);

		    $query_filter=" and te.project_id='$row[project_id]' ";

		    for($x=0;$x<=$count;$x++)
			{
				if($x==0)
				{
					$set_date=$date_filter_from;
				}
				else
				{
					$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
				}

				$loop_date_filter=" and te.date='$set_date'";

				if(strtotime($set_date)<strtotime('2015-05-01'))
				{
				 	$filter_position = " or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
				}
				else 
				{
					$filter_position = " or s.type='Unit' or s.type='Lumpsum' ";
				}

				$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' $query_filter $loop_date_filter group by te.project_id order by p.name");
				
				
				if($query_2->num_rows()>0)
				{
					$no_of_men=$query_2->row()->no_of_men;
				}
				else
				{
					$no_of_men=0;
				}
				
				array_push($data[$i], $no_of_men);
			}
		    $i++;
		}

		$data[$i] = array(
			'project_name'=>'Supervisor',
			'site_id'=>'23',
			'site_name'=>'Supervisor',
			'page'=>'supervisor',
		);

	    $query_filter=" and te.site_id='$row[site_id]' ";

	    for($x=0;$x<=$count;$x++)
		{
			if($x==0)
			{
				$set_date=$date_filter_from;
			}
			else
			{
				$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
			}

			$loop_date_filter=" and te.date='$set_date'";

			$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and (s.type='Lumpsum' or s.type='Unit') and te.position='Supervisor' $loop_date_filter");
			
			if($query_2->num_rows()>0)
			{
				if(strtotime($set_date)<strtotime('2015-05-01'))
				{
				 	$no_of_men=$query_2->row()->no_of_men;
				}
				else 
				{
					$no_of_men=0;
				}
			}
			else
			{
				$no_of_men=0;
			}
			
			array_push($data[$i], $no_of_men);
		}
		$i++;

		$data[$i] = array(
			'project_name'=>'No Job',
			'site_id'=>'0',
			'site_name'=>'No Job',
			'page'=>'nojob',
		);

	    for($x=0;$x<=$count;$x++)
		{
			if($x==0)
			{
				$set_date=$date_filter_from;
			}
			else
			{
				$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
			}

			$query_2=$this->db->query("select IFNULL((count(nts)),0) as no_of_men from employee where start_work_date<='$set_date' and end_work_date>'$set_date'");
			
			if($query_2->num_rows()>0)
			{
				$total_strength=$query_2->row()->no_of_men;
			}
			else
			{
				$total_strength=0;
			}

			$query_3=$this->db->query("select IFNULL((count(nts)-sum(add_shift)),0) as no_of_men from transaction_employee where date='$set_date'");
			
			if($query_3->num_rows()>0)
			{
				$no_of_men_working=$query_3->row()->no_of_men;
			}
			else
			{
				$no_of_men_working=0;
			}

			$query_4=$this->db->query("select IFNULL(count(nts),0) as no_of_men from transaction_employee where date='$set_date' and site_id='5'");

			if($query_4->num_rows()>0)
			{
				$no_job=$query_4->row()->no_of_men;
			}
			else
			{
				$no_job=0;
			}
			
			array_push($data[$i], $no_job);
		}
		$i++;

		return $data;
	}

	function get_man_count_summary_detail($date_filter_from="",$project="",$site="",$date_filter_to="")
	{	
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		$count=(strtotime($date_filter_to)-strtotime($date_filter_from))/(60*60*24);

		$i=0;
		
		$query_1=$this->db->query("select p.id as project_id, p.name as project_name, s.name as site_name, te.site_id as site_id, s.type as site_type from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and te.position!='Driver' and te.position!='Storeman' and te.site_id>5 $date_filter group by te.site_id order by p.name");

		foreach($query_1->result_array() as $row)
		{
			$data[$i] = array(
				'project_id'=>$row['project_id'],
				'project_name'=>$row['project_name'],
				'site_id'=>$row['site_id'],
				'site_name'=>$row['site_name'],
				'page'=>'site',
			);

		    $query_filter=" and te.site_id='$row[site_id]' ";

		    for($x=0;$x<=$count;$x++)
			{
				if($x==0)
				{
					$set_date=$date_filter_from;
				}
				else
				{
					$set_date=date('Y-m-d',strtotime($set_date.'+1 days'));
				}

				$loop_date_filter=" and te.date='$set_date'";

				if(strtotime($set_date)<strtotime('2015-05-01'))
				{
				 	$filter_position = " or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
				}
				else 
				{
					$filter_position = " or s.type='Unit' or s.type='Lumpsum' ";
				}

				$query_2=$this->db->query("select IFNULL((count(te.nts)-sum(te.add_shift)),0) as no_of_men from transaction_employee te, site s, project p where te.site_id=s.id and te.project_id=p.id and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' $query_filter $loop_date_filter group by te.site_id order by p.name");
				
				
				if($query_2->num_rows()>0)
				{
					$no_of_men=$query_2->row()->no_of_men;
				}
				else
				{
					$no_of_men=0;
				}
				
				array_push($data[$i], $no_of_men);
			}
		    $i++;
		}

		return $data;
	}

	function get_employee_list_by_position($position="",$date_filter_from="",$date_filter_to="")
	{
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if(($position!=""))
		{
			if($position!="Supervisor")
			{
				$date_filter=$date_filter." and te.position='$position'";
			}
			else
			{	
				if(strtotime($date_filter_from)<strtotime('2015-05-01'))
				{ 	
					$date_filter=$date_filter." and te.position='$position' and (s.type='Unit' or s.type='Lumpsum') ";
				}
				else 
				{	
					$date_filter=$date_filter." and te.position='$position' ";
				}
			}
		}

		$query=$this->db->query("select *,e.name as emp_name from transaction_employee te, employee e, site s where te.site_id>5 and te.nts=e.nts and te.site_id=s.id $date_filter order by te.nts");
		return $query->result_array();
	}

	function get_employee_list_by_site($site="",$site_type="",$date_filter_from="",$date_filter_to="")
	{
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if(($site!=""))
		{
			$date_filter=$date_filter." and te.site_id='$site'";
		}

		if(($site_type=="Unit")||($site_type=="Lumpsum"))
		{
			if(strtotime($date_filter_from)<strtotime('2015-05-01'))
			{ 	
				$date_filter=$date_filter." and te.position!='Supervisor'";
			}
			else 
			{	
				$date_filter=$date_filter." ";
			}
		}

		$query=$this->db->query("select *, e.name as emp_name from transaction_employee te, site s, employee e where te.site_id=s.id and add_shift='0' and te.nts=e.nts $date_filter order by te.nts");
		return $query->result_array();
	}

	function get_employee_list_by_project($project="",$date_filter_from="",$date_filter_to="")
	{
		if($date_filter_from=="")
		{
			$date_filter_from=date("Y-m-d");
		}

		if($date_filter_to=="")
		{
			$date_filter_to=$date_filter_from;
		}
		
		$date_filter="and te.date between '$date_filter_from' and '$date_filter_to'";
		
		if(($project!=""))
		{
			$date_filter=$date_filter." and te.project_id='$project'";
		}

		if(($site_type=="Unit")||($site_type=="Lumpsum"))
		{
			if(strtotime($date_filter_from)<strtotime('2015-05-01'))
			{ 	
				$date_filter=$date_filter." and te.position!='Supervisor'";
			}
			else 
			{	
				$date_filter=$date_filter." ";
			}
		}

		$query=$this->db->query("select *, e.name as emp_name from transaction_employee te, site s, employee e where te.site_id=s.id and add_shift='0' and te.nts=e.nts $date_filter order by te.nts");
		return $query->result_array();
	}
	
	function update_daily_expenses($date)
	{
		if(strtotime($date)<strtotime('2015-05-01'))
		{ 	
			$filter_position=" or (s.type='Unit' and te.position!='Supervisor') or (s.type='Lumpsum' and te.position!='Supervisor') ";
		}
		else 
		{	
			$filter_position=" or s.type='Unit' or s.type='Lumpsum' ";
		}

		$is_weekend=date('N', strtotime($date));

		$sql_get_is_holiday=$this->db->query("select * from day_preset where date ='$date'");
		$is_holiday=$sql_get_is_holiday->num_rows();

		if($is_weekend=='7' || $is_holiday=='1')
		{
			$daily_levy=0;
			$daily_dormitory=0;
			$daily_transportation=0;
			$daily_administration=0;
			$daily_operation=0;
		}
		else
		{
			$month=date('m',strtotime($date));
			$year=date('Y',strtotime($date));
			$first_day=date('Y-m-01',strtotime($date));
			$last_day=date('Y-m-t',strtotime($date));

			$sql_get_sunday_count=$this->db->query("select count(row+1) as sunday_count from (SELECT @row := @row + 1 as row FROM (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t1, (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2, (SELECT @row:=-1) t3 limit 31) b where DATE_ADD('$first_day', INTERVAL ROW DAY) between '$first_day' and '$last_day' and DAYOFWEEK(DATE_ADD('$first_day', INTERVAL ROW DAY))=1");
			$get_sunday_count=$sql_get_sunday_count->row()->sunday_count;

			$sql_get_holiday_count=$this->db->query("select count(*) as holiday_count from day_preset where date between '$first_day' and '$last_day'");
			$get_holiday_count=$sql_get_holiday_count->row()->holiday_count;

			$day_of_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$total_day=$day_of_month-$get_sunday_count-$get_holiday_count;

			$query=$this->db->query("select (ROUND(me.levy/$total_day/(count(te.nts)-SUM(te.add_shift)),5)) as daily_levy,(ROUND(me.dormitory/$total_day/(count(te.nts)-SUM(te.add_shift)),5)) as daily_dormitory,(ROUND(me.transportation/$total_day/(count(te.nts)-SUM(te.add_shift)),5)) as daily_transportation,(ROUND(me.administration/$total_day/(count(te.nts)-SUM(te.add_shift)),5)) as daily_administration,(ROUND(me.operation/$total_day/(count(te.nts)-SUM(te.add_shift)),5)) as daily_operation from transaction_employee te, site s, monthly_expenses me where te.date='$date' and te.site_id=s.id and te.site_id>5 and te.project_id>1 and (s.type='Supply' $filter_position) and te.position!='Driver' and te.position!='Storeman' and te.site_id!='23' and MONTH('$date')=me.month");  

			$get_expenses=$query->row();
			$daily_levy=$get_expenses->daily_levy;
			$daily_dormitory=$get_expenses->daily_dormitory;
			$daily_transportation=$get_expenses->daily_transportation;
			$daily_administration=$get_expenses->daily_administration;
			$daily_operation=$get_expenses->daily_operation;
		}

		$update_value=array(
				'levy'=>$daily_levy,
				'dormitory'=>$daily_dormitory,
				'transportation'=>$daily_transportation,
				'administration'=>$daily_administration,
				'operation'=>$daily_operation,
			);

		$this->db->where('date',$date);
		$this->db->update($this->table_name,$update_value);
	}

	function update_daily_expenses_all($month="")
	{
		if($month!="")
		{
			$date_filter="where month(date)='$month'";
		}

		$query_get_date=$this->db->query("Select * from transaction_employee $date_filter group by date");
		foreach($query_get_date->result_array() as $row)
		{
			$date=$row['date'];

			$this->update_daily_expenses($date);
		}
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
	
	function get_transaction_total($date_filter_from="",$project="",$site="", $date_filter_to="")
	{
		$this->db->select('(COUNT(transaction_employee.nts)-SUM(transaction_employee.add_shift)) AS total_no_of_men,SUM(transaction_employee.normal_salary) AS total_normal_salary,SUM(transaction_employee.ot_salary) AS total_ot_salary,SUM(transaction_employee.meal_fee+transaction_employee.ns_fee) AS total_allowance_fee');
		$this->db->from($this->table_name);
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
		$this->db->where('site.type',"Supply");
		$positions = array('Driver', 'Storeman');
		$this->db->where_not_in('transaction_employee.position', $positions);
		$this->db->where('transaction_employee.site_id !=',"23");
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function is_exist($field,$value)
	{
		$this->db->where($field,$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_transaction_employee_by_value($field,$value)
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
	
	function get_transaction_employee_list_by_value($value, $field){
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

	function get_worker_position_list($date_filter_from="",$project="",$site="", $date_filter_to="")
	{

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

		if($project!="")
		{
			$filter_project="and te.project_id='$project'";
		}
		else
		{
			$filter_project="";
		}
		
		if(($site!="")&&($site!=0))
		{
			$filter_site="and te.site_id='$site'";
		}
		else
		{
			$filter_site="";
		}

		if(strtotime($date_filter_from)<strtotime('2015-05-01'))
		{ 	
			$filter_position=" and te.position!='Supervisor' ";
		}
		else 
		{	
			$filter_position=" ";
		}

		$query=$this->db->query("select concat(position,' on Supply') as position,(count(te.nts)-SUM(add_shift)) as no_of_men_supply,0 as no_of_men_unit from transaction_employee te, site s where s.id=te.site_id and s.type='Supply' and te.position!='Driver' and te.position!='Storeman' and date between '$date_filter_from' and '$date_filter_to' $filter_project $filter_site group by position UNION select concat(position,' on Unit') as position,0 as no_of_men_supply,count(te.nts) as no_of_men_unit from transaction_employee te, site s where s.id=te.site_id and (s.type='Unit' or s.type='Lumpsum') $filter_position and te.position!='Driver' and te.position!='Storeman' and te.site_id!='23' and date between '$date_filter_from' and '$date_filter_to' $filter_project $filter_site group by position order by position");

		return $query->result_array();
	}

	function get_total_absent($date_filter_from="",$date_filter_to="")
	{
		$this->db->select('count(nts) as no_of_men');
		$this->db->where('site_id <=',5);

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
		
		$this->db->where('date >=',$date_filter_from);
		$this->db->where('date <=',$date_filter_to);
		
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}

	function get_absent_list($date_filter_from="",$date_filter_to="")
	{
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
		
		$query=$this->db->query("select 'Home Leave' as name, count(te.nts) as no_of_men from transaction_employee te where date between '$date_filter_from' and '$date_filter_to' and site_id='1' UNION select 'Standby@Dorm' as name, count(te.nts) as no_of_men from transaction_employee te where date between '$date_filter_from' and '$date_filter_to' and site_id='2' UNION select 'MC' as name, count(te.nts) as no_of_men from transaction_employee te where date between '$date_filter_from' and '$date_filter_to' and site_id='3' UNION select 'Course' as name, count(te.nts) as no_of_men from transaction_employee te where date between '$date_filter_from' and '$date_filter_to' and site_id='4' UNION select 'Absent' as name, count(te.nts) as no_of_men from transaction_employee te where date between '$date_filter_from' and '$date_filter_to' and site_id='5'");
		return $query->result_array();
	}

	function get_count_by_position($value,$date_filter_from="",$project="",$site="",$date_filter_to="")
	{
		$this->db->select('IFNULL((COUNT(transaction_employee.nts)-SUM(transaction_employee.add_shift)),0) AS total_no_of_men', false);
		$this->db->from($this->table_name);
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

		$this->db->where('site_id >',5);
		if($value!='Driver' && $value!='Storeman')
		{
			$this->db->where('transaction_employee.project_id >',1);
		}
		if($value=="Storeman")
		{
			$where_con = "(position = '$value'  OR (position!='Driver' and position!='Storeman' and site_id = '23'))";
			$this->db->where($where_con);
		}
		else
		{
			$this->db->where('position',$value);
		}

		$query = $this->db->get();

		return ($query->num_rows()>0)?$query->row():FALSE;
	}

	function get_employee_by_value($nts,$transaction_date)
	{
		$this->db->select_sum('work_hour');
		$this->db->where('nts',$nts);
		$this->db->where('date',$transaction_date);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}

	function update_salary_by_date($nts,$date,$value)
	{
		$this->db->query("Update transaction_employee te set ot_rate=ot_rate/hourly_rate*$value, hourly_rate='$value' where date>='$date'");
		$this->db->query("Update transaction_employee te set normal_salary=work_hour*hourly_rate, ot_salary=ot_hour*ot_rate where date>='$date'");
	}

	function update_site_date($site,$date_from,$date_to)
	{
		$setting_query=$this->db->query("Select * from setting where id='1'");
		$get_setting_detail=$setting_query->row();

		$site_query=$this->db->query("Select * from site where id='$site'");
		$get_site_detail=$site_query->row();

		$is_weekend=date('N', strtotime($date_from));

		$sql_get_is_holiday=$this->db->query("select * from day_preset where date ='$date_from'");
		$is_holiday=$sql_get_is_holiday->num_rows();

		if($is_weekend=='7' || $is_holiday=='1')
		{
			$from_is_holiday='1';
			$from_multiple=$get_setting_detail->ot_sunday;
		}
		else
		{
			$from_is_holiday='0';
			$from_multiple=$get_setting_detail->ot_weekday;
		}

		$is_weekend=date('N', strtotime($date_to));

		$sql_get_is_holiday=$this->db->query("select * from day_preset where date ='$date_to'");
		$is_holiday=$sql_get_is_holiday->num_rows();

		if($is_weekend=='7' || $is_holiday=='1')
		{
			$to_is_holiday='1';
			$to_multiple=$get_setting_detail->ot_sunday;
			$ot_site_rate=$get_site_detail->ot_sunday_rate;
		}
		else
		{
			$to_is_holiday='0';
			$to_multiple=$get_setting_detail->ot_weekday;
			$ot_site_rate=$get_site_detail->ot_normal_rate;
		}

		if($to_is_holiday==$from_is_holiday)
		{
			$this->db->query("Update transaction_employee te set date='$date_to' where date='$date_from' and site_id='$site'");
		}
		else
		{
			$this->db->query("Update transaction_employee te set ot_rate=hourly_rate*$to_multiple, ot_site_rate='$ot_site_rate' where date='$date_from' and site_id='$site'");
			$this->db->query("Update transaction_employee te set ot_salary=ot_hour*ot_rate where date='$date_from' and site_id='$site'");
			$this->db->query("Update transaction_employee te set date='$date_to' where date='$date_from' and site_id='$site'");
		}
	}

	function update_site_to_site($current_site,$target_site,$date_site)
	{
		$query=$this->db->query("Select * from transaction_employee te where date='$date_site' and site_id='$current_site'");
		$setting_query=$this->db->query("Select * from setting where id='1'");
		$get_setting_detail=$setting_query->row();

		$multiple_weekday=$get_setting_detail->ot_weekday;
		$multiple_sunday=$get_setting_detail->ot_sunday;

		$site_query=$this->db->query("Select * from site where id='$target_site'");
		$get_site_detail=$site_query->row();
		$project_id=$get_site_detail->project_id;

		foreach($query->result_array() as $row)
		{
			$position=$row['position'];
			$id=$row['id'];
			$multiple=$ot_rate/$hourly_rate;

			if($multiple==$multiple_sunday)
			{
				$is_weekend='1';
			}
			else 
			{
				$is_weekend='0';
			}

			if($is_weekend)
			{
				if($position=="Supervisor")
				{
					$ot_site_rate=$get_site_detail->spv_ot_sunday_rate;
					$site_rate=$get_site_detail->spv_hourly_rate;
				}
				else
				{
					$ot_site_rate=$get_site_detail->ot_sunday_rate;
					$site_rate=$get_site_detail->hourly_rate;
				}
			}
			else
			{
				if($position=="Supervisor")
				{
					$ot_site_rate=$get_site_detail->spv_ot_normal_rate;
					$site_rate=$get_site_detail->spv_hourly_rate;
				}
				else
				{
					$ot_site_rate=$get_site_detail->ot_normal_rate;
					$site_rate=$get_site_detail->hourly_rate;
				}
			}

			$this->db->query("Update transaction_employee set project_id=$project_id, site_id='$target_site', site_rate='$site_rate', ot_site_rate='$ot_site_rate' where id='$id'");
		}
	}

	function get_mc_list($nts, $year)
	{
		$this->db->where('nts',$nts);
		$this->db->where('site_id','3');
		$this->db->where('YEAR(date)',$year);
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}

	function delete_home_leave($nts,$start_hl_date,$end_hl_date)
	{
		$this->db->query("Delete from transaction_employee where nts='$nts' and date between '$start_hl_date' and '$end_hl_date' and site_id='1'");
	}

	function get_employee_absent($date)
	{
		$query=$this->db->query("SELECT *, e.name as emp_name FROM transaction_employee te, employee e WHERE e.start_work_date<='$date' and e.end_work_date>'$date' and e.nts=te.nts and te.site_id='5' and te.date='$date' group by te.nts");
		return $query->result_array();
	}

	function check_total_ot($nts,$date)
	{
		$query=$this->db->query("Select sum(ot_hour) as total_ot from transaction_employee where nts='$nts' and date='$date'");
		return $query->row();
	}

	function update_meal_fee($nts,$date,$meal_fee)
	{
		$this->db->query("Update transaction_employee set meal_fee='$meal_fee' where nts='$nts' and date='$date' and add_shift='0'");
	}

	function get_employee_activity($date_from="",$date_to="",$project="",$site="",$nts="")
	{
		$this->db->select('transaction_employee.id,transaction_employee.date,transaction_employee.project_id,project.name as project_name,transaction_employee.site_id,site.name as site_name,employee.name as employee_name,employee.position,transaction_employee.nts,transaction_employee.hourly_rate,transaction_employee.ot_rate,transaction_employee.work_hour,transaction_employee.ot_hour,transaction_employee.normal_salary,transaction_employee.ot_salary,transaction_employee.meal_fee,transaction_employee.ns_fee');
		$this->db->from($this->table_name);
		$this->db->join('employee', 'employee.nts = transaction_employee.nts');
		$this->db->join('project', 'project.id = transaction_employee.project_id');
		$this->db->join('site', 'site.id = transaction_employee.site_id');
		
		if($date_from=="")
		{
			$date_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_from);
			$date_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		if($date_to=="")
		{
			$date_to=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_to);
			$date_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('transaction_employee.date >=',$date_from);
		$this->db->where('transaction_employee.date <=',$date_to);
		
		if($project!="")
		{
			$this->db->where('transaction_employee.project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('transaction_employee.site_id',$site);
		}

		if($nts!="")
		{
			$this->db->where('transaction_employee.nts',$nts);
		}

		$this->db->order_by('transaction_employee.date','ASC');
		return $this->db->get()->result_array();
	}

	function calc_meal_allowance($date_from="",$date_to="",$project="",$site="",$nts="")
	{
		$this->db->select('COUNT(id) as counter, SUM(meal_fee)');
		$this->db->from($this->table_name);
		
		if($date_from=="")
		{
			$date_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_from);
			$date_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		if($date_to=="")
		{
			$date_to=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_to);
			$date_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('date >=',$date_from);
		$this->db->where('date <=',$date_to);
		
		if($project!="")
		{
			$this->db->where('project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('site_id',$site);
		}

		if($nts!="")
		{
			$this->db->where('nts',$nts);
		}

		$this->db->where('meal_fee >',0);
		$this->db->order_by('date','ASC');
		return $this->db->get()->row();
	}

	function delete_absent($date)
	{
		$this->db->where('date', $date);
		$this->db->where('site_id', '5');
		$this->db->delete($this->table_name);
	}

	function update_absent($date)
	{
		$this->delete_absent($date);

		$query_get_date=$this->db->query("select nts,hourly_rate,position from employee where start_work_date<='$date' and end_work_date>'$date' having nts not in (select nts from transaction_employee where date='$date')");
		
		foreach($query_get_date->result_array() as $row)
		{
			$nts=$row['nts'];
			$hourly_rate=$row['hourly_rate'];
			$position=$row['position'];

			$absent=array(
					'date'=>$date,
					'project_id'=>'1',
					'site_id'=>'5',
					'nts'=>$nts,
					'position'=>$position,
					'hourly_rate'=>$hourly_rate,
					'ot_rate'=>'0.00',
					'work_hour'=>'0',
					'ot_hour'=>'0',
					'normal_salary'=>'0.00',
					'ot_salary'=>'0.00',
					'meal_fee'=>'0.00',
					'ns_fee'=>'0.00',
					'add_shift'=>'0',
					'site_rate'=>'0.00',
					'ot_site_rate'=>'0.00',
					'createdate'=>date('Y-m-d H:i:s',now()),
					'createby'=>$this->access->get_username(),
					'updateby'=>$this->access->get_username(),
					'updatedate'=>date('Y-m-d H:i:s',now())
			);

			$this->transaction_employee_model->insert($absent);
		}
	}

	function update_absent_all()
	{
		$query_get_date=$this->db->query("Select * from transaction_employee group by date");
		foreach($query_get_date->result_array() as $row)
		{
			$date=$row['date'];

			$this->update_absent($date);
		}
	}
}


/* End of file Transaction_employee_model.php */
/* Location: ./application/model/Transaction_employee_model.php */
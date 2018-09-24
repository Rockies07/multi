<?php
Class m_System extends CI_Model
{
	function settings_server()
	{
		$this->db->select('closetime,sitename,bigprice,smallprice,placeout_comm,exp');
		$query = $this->db->get('settings');

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}
	
	function getdraw($drawdate)
	{
		$sql = "SELECT drawdate FROM drawdate WHERE drawdate >= ? limit 3"; 
		$query = $this->db->query($sql, array($drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$nextday[$x] = $row['drawdate'];
			$x = $x + 1;
		}
		return $nextday;
	}

	function getpastdraw($limit)
	{

		$this->db->distinct();
		$this->db->select('drawdate');
		$this->db->order_by("drawdate", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get('results');
		
		$drawdate = array();

		foreach ($query->result_array() as $row)
		{
			$td = $row['drawdate'];
			$arr = explode ("-", $td);
			$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
			$t = date('D',$stamp);
			if (strcmp($t, 'Wed') == 0 ){$day = 'Wed';}
			if (strcmp($t, 'Sat') == 0 ){$day = 'Sat';}
			if (strcmp($t, 'Sun') == 0 ){$day = 'Sun';}

		   $drawdate[$row['drawdate']] = $row['drawdate']." (".$day.")";
		}
		return $drawdate;
	}

	function gettransdraw($limit)
	{

		$this->db->distinct();
		$this->db->select('drawdate');
		$this->db->order_by("drawdate", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get('bet_records');
		
		$drawdate = array();

		foreach ($query->result_array() as $row)
		{
			$td = $row['drawdate'];
			$arr = explode ("-", $td);
			$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
			$t = date('D',$stamp);
			if (strcmp($t, 'Wed') == 0 ){$day = 'Wed';}
			if (strcmp($t, 'Sat') == 0 ){$day = 'Sat';}
			if (strcmp($t, 'Sun') == 0 ){$day = 'Sun';}

		   $drawdate[$row['drawdate']] = $row['drawdate']." (".$day.")";
		}
		return $drawdate;
	}

	function get_sms_date($type)
	{
		$this->db->select('datetime');
		if($type=="sent")
		{
			$this->db->where('reply_status','Y');
		}
		else
		{
			$this->db->where('reply_status','D');
		}
		$this->db->group_by('Date(datetime)'); 
		$this->db->order_by("datetime", "desc"); 
		$query = $this->db->get('sms_manual');
		
		return $query->result_array();
	}

	function randomref() 
	{
		$code=md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
		$number = substr($code,0,20);
		return $number;
	}

	function getcombo($number)
	{

		$this->db->select('drawnum,combocount,comblist');
		$this->db->like('comblist', $number); 
		$query = $this->db->get('combo');

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function runintake($uid, $number, $drawdate)
	{
		switch(strlen($uid))
		{
			case 2:	$account_type = "mas_id";
					$inbig = "mas_intake_big";
					$insmall = "mas_intake_small";
					break;
			case 4: $account_type = "agg_id";
					$inbig = "agg_intake_big";
					$insmall = "agg_intake_small";
					break;
			case 6: $account_type = "agt_id";
					$inbig = "agt_intake_big";
					$insmall = "agt_intake_small";
					break;
			default: return FALSE;
		}

		$this->db->select_sum($inbig,'prebig');
		$this->db->select_sum($insmall,'presmall');
		$this->db->where('drawdate', $drawdate); 
		$this->db->where('number', $number); 
		$this->db->where($account_type, $uid); 
		$query = $this->db->get('transactions');
		
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getadminpool($drawdate)
	{
		$sql = "SELECT number,sum(amt_big) as amt_big,sum(amt_small) as amt_small FROM admin_intake_pool WHERE drawdate = ? group by number"; 
		$query = $this->db->query($sql, array($drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function sysintakedata($drawdate)
	{
		$sql = "SELECT sum(amt_big) as total_big,sum(amt_small) as total_small FROM admin_intake_pool WHERE drawdate = ?"; 
		$query = $this->db->query($sql, array($drawdate)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function sysintakedata_temp($drawdate)
	{
		$sql = "SELECT sum(amt_big) as total_big,sum(amt_small) as total_small FROM admin_intake_temp WHERE drawdate = ?"; 
		$query = $this->db->query($sql, array($drawdate)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function bookieintakedata_temp($drawdate)
	{
		$sql = "SELECT sum(amt_big) as total_big,sum(amt_small) as total_small FROM bookie_intake_pool WHERE drawdate = ?"; 
		$query = $this->db->query($sql, array($drawdate)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function getbookie()
	{
		$sql = "SELECT bok_id, placeout_com, intake_big, intake_small FROM `users_bok` where status = 'active' order by piority asc"; 
		$query = $this->db->query($sql); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getbookieintake($drawdate)
	{
		$sql = "SELECT bok_id,sum(amt_big) as amt_big,sum(amt_small) as amt_small FROM bookie_intake WHERE drawdate = ? group by bok_id"; 
		$query = $this->db->query($sql, array($drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getstatus($drawdate)
	{
		$sql = "SELECT log FROM log_payout_co WHERE drawdate = ?"; 
		$query = $this->db->query($sql, array($drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getaradata($drawdate, $bok_id)
	{
		$sql = "SELECT bok_id, number, amt_big, amt_small FROM bookie_intake WHERE drawdate = ? AND bok_id = ?"; 
		$query = $this->db->query($sql, array($drawdate, $bok_id)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}
	function insertresults($data)
	{
		$this->db->insert_batch('results', $data);
	}

	function insertpage($data)
	{
		$this->db->insert_batch('page_details', $data);
	}
	function inserttransfix($data)
	{
		$this->db->insert_batch('transactions_fix', $data);
	}
	function inserttrans($data)
	{
		$this->db->insert_batch('transactions', $data);
	}

	function insertadminintake($data)
	{
		$this->db->insert_batch('admin_intake_pool', $data);
	}

	function insertbetrecords($data)
	{
		$this->db->insert_batch('bet_records', $data);
	}

	function insertadmintemp($data)
	{
		$this->db->truncate('admin_intake_temp'); 
		$this->db->insert_batch('admin_intake_temp', $data);
	}

	function insertbookietemp($data)
	{
		$this->db->truncate('bookie_intake_pool'); 
		$this->db->insert_batch('bookie_intake_pool', $data);
	}

	function insert_system_intake($drawdate)
	{
		$sql = "INSERT INTO admin_intake SELECT * FROM admin_intake_temp where drawdate = ?";
		$query = $this->db->query($sql, array($drawdate)); 
	}

	function insert_bookie_intake($drawdate)
	{
		$sql = "INSERT INTO bookie_intake SELECT * FROM bookie_intake_pool where drawdate = ?";
		$query = $this->db->query($sql, array($drawdate)); 
	}

	function insert_intake_detail($data)
	{
		$this->db->insert('admin_intake_detail', $data);
	}

	function get_bookie_total($date)
	{
		$sql = "SELECT 
				sum(amt_big) as amt_big,
				sum(amt_small) as amt_small
				FROM bookie_intake 
				WHERE drawdate = ?";

		$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_admin_intake_total($date)
	{
		$sql = "SELECT 
				sum(amt_big) as amt_big,
				sum(amt_small) as amt_small
				FROM admin_intake 
				WHERE drawdate = ?";

		$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_master_po($date)
	{
		$sql = "SELECT 
				sum(amt_big - agt_intake_big - agg_intake_big - mas_intake_big) as amt_big,
				sum(amt_small - agt_intake_small - agg_intake_small - mas_intake_small) as amt_small
				FROM transactions 
				WHERE drawdate = ?";

		$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}
	
	function get_draw_count($fromdate,$todate)
	{
		$sql = "SELECT 
				count(distinct(drawdate)) as count
				FROM drawdate WHERE drawdate >= ? and drawdate <= ?"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['count'];
			}
		}
	}	
	
	function get_coy_report($fromdate,$todate)
	{
		$sql = "SELECT
				mas_id,
				man_id,
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(ticket_perc) as ticket_perc,
				sum(intake_tax) as intake_tax,
				sum(sms_charges) as sms_charges,
				sum(share_co_perc) as share_co_perc,
				sum(share_co_amt) as share_co_amt,
				sum(share_co_amt100) as share_co_amt100,
				sum(share_po_perc) as share_po_perc,
				sum(share_po_amt) as share_po_amt,
				sum(share_po_amt100) as share_po_amt100
				FROM pl_coy WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0 group by mas_id order by mas_id asc";
		
		$query = $this->db->query($sql, array($fromdate,$todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}	
	
	function get_coy_sum_report($fromdate,$todate)
	{
		$sql = "SELECT 
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(ticket_perc) as total_perc,
				sum(share_co_amt100) as total_co_amt,
				sum(share_po_amt100) as total_po_amt
				FROM pl_coy WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}	
	
	function get_bok_report($fromdate,$todate)
	{
		$sql = "SELECT 
				pl_bok.bok_id,
				users_bok.name,
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(po_return) as po_return
				FROM pl_bok
				left join users_bok on users_bok.bok_id = pl_bok.bok_id 
				WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0 group by pl_bok.bok_id order by users_bok.bok_id asc"; 
		$query = $this->db->query($sql, array($fromdate,$todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function get_bok_sum_report($fromdate,$todate)
	{
		$sql = "SELECT 
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(po_return) as total_po_return
				FROM pl_bok WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}	
	
	function insert_master_po_detail($data)
	{
		$this->db->insert('master_po_detail', $data);
	}


	function insert_bookie_intake_detail($data)
	{
		$this->db->insert('bookie_intake_detail', $data);
	}


	function dividefunc($eatbig, $eatsmall, $prebig, $presmall, $big, $small)
	{
		$divideamt[0] = 0; //  eat big
		$divideamt[1] = 0; //  out big
		$divideamt[2] = 0; //  eat small
		$divideamt[3] = 0; //  out small
		
		if ($presmall < 0)
		{
			$presmall = 0;
		}
		// --------------- big eat & out -----------------------
		if ($big > ($eatbig - $prebig)) // eat remiander big and out the rest
		{
			$eatbamt = $eatbig - $prebig;
			$divideamt[0] = round($eatbamt,4); // eat big amt
			$big = $big - $eatbamt;
			$divideamt[1] = round($big,4); // out big amt
		}
		else //eat all into system
		{
			$eatbamt = $big;
			$divideamt[0] = round($eatbamt,4); // eat big amt
			$big = 0;
		}

		// --------------- small eat & out ---------------------

		
		if ($eatsmall > 0)
		{
			if((($eatbamt + $prebig) * 4) >= ($eatsmall * 3))
			{
				$PreOutSml = Ceil((($prebig * 4) - ($eatsmall * 3)) / 3);
				if ($PreOutSml < 0) {$PreOutSml = 0;}
				$NewOutsml = Ceil(((($eatbamt+$prebig) * 4) - ($eatsmall * 3)) / 3) - $PreOutSml; // amount to top up for max big
				$small = $small + $NewOutsml + $presmall; // total amt to out as small
				$divideamt[3] = round($small,4); // out small amt

				$outsamt = $NewOutsml;
				//echo "System top-up for max big = ".$outsamt." small<br>";
				$tempresult = 0 - ($presmall + $NewOutsml); // eat small amt
				$divideamt[2] = round($tempresult,4);
			}

			else 
			{
				$eatsamt = floor((($eatsmall * 3) - (($eatbamt + $prebig)*4)) / 3); // max small amt to eat
				if (($small + $presmall) >= $eatsamt)
				{
					$small = ($small + $presmall) - $eatsamt;
					$divideamt[3] = round($small,4); // out small amt
					$eatsamt = $eatsamt - $presmall;
					$divideamt[2] = round($eatsamt,4); // eat small amt
				}
				else
				{
					$eatsamt = $small;
					$divideamt[2] = round($eatsamt,4); // eat small amt
					$small = 0;
				}
			}
		}
		else
		{
			$eatsamt = 0 - $presmall;
			$divideamt[2] = round($eatsamt,4); // eat small amt
			$small = $small - $eatsamt;
			$divideamt[3] = round($small,4); // out small amt
		}
		
		return $divideamt;
	}

	function admindividefunc($eatbig, $eatsmall, $prebig, $presmall, $big, $small)
	{
		$divideamt[0] = 0; //  eat big
		$divideamt[1] = 0; //  out big
		$divideamt[2] = 0; //  eat small
		$divideamt[3] = 0; //  out small
		$remaindecimal = 0; // remainding decimal amount to add into current eat
		$outdecbig = 0; // out decimal big amount
		$bd = explode(".", $big);
		$bigdecimal = "0.".$bd[1];
		$pbd = explode(".", $prebig);			
		$prebigdecimal = "0.".$pbd[1];
		$newbig = $bd[0];
		$newprebig = $pbd[0];

// --------------- eat decimal place -------------------
		if(strpos($big,".") !== false)
		{
			// get big decimal
			// check previous big decimal with new decimal
			if ($bigdecimal + $prebigdecimal == 1)
			{
				// get remainding decimal
			//	echo "both decimal adds to 1<BR>";
				if (($big + $prebig) > $eatbig)
				{
					$remaindecimal = 0 - $prebigdecimal; //got to make it negative to reflect correctly on transaction
				}
				else
				{
			//		echo "Amount smaller than system eat<BR>";
					$remaindecimal = $bigdecimal; // if amount smaller or equal to system eat, it should be positive
				}
			//	echo "big dec ".$bigdecimal."<BR>";
			//	echo "prebig dec ".$prebigdecimal."<BR>";
			//	echo "Remaing dec ".$remaindecimal."<BR>";
				$outdecbig = 1;
			}
			else if ($bigdecimal + $prebigdecimal > 1 )
			{
				// get remainding decimal
			//	echo "both decimal > 1<BR>";
				if (($big + $prebig) > $eatbig + 0.75)
				{
				//	echo "amount bigger or equal to system eat<br>";
					$remaindecimal = $bigdecimal - 1; //got to make it negative to reflect correctly on transaction			
				}
				else if (($big + $prebig) < $eatbig)
				{
				//	echo "Amount smaller than system eat<BR>";
					$remaindecimal = 0 - ($bigdecimal + $prebigdecimal - 1);  // if amount smaller or equal to system eat, it should be positive
				}
				else 
				{
					$remaindecimal = $bigdecimal;
				}
			//	echo "big dec ".$bigdecimal."<BR>";
			//	echo "prebig dec ".$prebigdecimal."<BR>";
			//	echo "Remaing dec ".$remaindecimal."<BR>";
				$outdecbig = 1;
			}
			else
			{
				//should eat the current decimal
				$remaindecimal = $bigdecimal;
				$outdecbig = 0;
			}
			// intake big with decimal
			// out big without decimal
			//strip prebig and bigamt dec out
		//	echo "new big ".$newbig."<BR>";
		//	echo "new pre big ".$newprebig."<BR>";

		}
// --------------- big eat & out -----------------------
		if ($newbig >= ($eatbig - $newprebig)) // eat remiander big and out the rest
		{
			$eatbamt = $eatbig - $newprebig;
			$divideamt[0] = $eatbamt + $remaindecimal; // eat big amt with new remainding decimal
			$newbig = $newbig - $eatbamt;
			$divideamt[1] = $newbig + $outdecbig; // out big amt with new decimal big
		}
		else //eat all into system
		{
			$eatbamt = $newbig;
			$divideamt[0] = $eatbamt + $remaindecimal; // eat big amt with new remainding decimal
			$newbig = 0;
		}
// --------------- small eat & out ---------------------

		if ($eatsmall > 0)
		{
			if((($eatbamt + $prebig) * 4) >= ($eatsmall * 3))
			{
				$PreOutSml = Ceil((($prebig * 4) - ($eatsmall * 3)) / 3);
				if ($PreOutSml < 0) {$PreOutSml = 0;}
				$NewOutsml = Ceil(((($eatbamt+$prebig) * 4) - ($eatsmall * 3)) / 3) - $PreOutSml; // amount to top up for max big
				$small = $small + $NewOutsml + $presmall; // total amt to out as small
				$divideamt[3] = $small; // out small amt

				$outsamt = $NewOutsml;
				//echo "System top-up for max big = ".$outsamt." small<br>";
				$divideamt[2] = 0 - $presmall; // eat small amt
			}

			else 
			{
				$eatsamt = floor((($eatsmall * 3) - (($eatbamt + $prebig)*4)) / 3); // max small amt to eat
				if (($small + $presmall) >= $eatsamt)
				{
					$small = ($small + $presmall) - $eatsamt;
					$divideamt[3] = $small; // out small amt
					$eatsamt = $eatsamt - $presmall;
					$divideamt[2] = $eatsamt; // eat small amt
				}
				else
				{
					$eatsamt = $small;
					$divideamt[2] = $eatsamt; // eat small amt
					$small = 0;
				}
			}
		}
		else
		{
			$eatsamt = 0 - $presmall;
			$divideamt[2] = $eatsamt; // eat small amt
			$small = $small - $eatsamt;
			$divideamt[3] = $small; // out small amt
		}
		return $divideamt;
	}

	function getresults($date)
	{
		$sql = "SELECT prizetype,number FROM results WHERE drawdate = ?"; 
		$query = $this->db->query($sql, array($date)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function get_trans_number($date,$number)
	{
		$sql = "SELECT * FROM transactions WHERE drawdate = ? and number = ?"; 
		$query = $this->db->query($sql, array($date, $number)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function get_admin_number($date,$number)
	{
		$sql = "SELECT * FROM admin_intake WHERE drawdate = ? and number = ?"; 
		$query = $this->db->query($sql, array($date, $number)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function get_bookie_number($date,$number)
	{
		$sql = "SELECT * FROM bookie_intake WHERE drawdate = ? and number = ?"; 
		$query = $this->db->query($sql, array($date, $number)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function insert_users_strike($data)
	{
		$this->db->insert_batch('strike_users', $data);
	}

	function insert_admin_strike($data)
	{
		$this->db->insert_batch('strike_company', $data);
	}

	function insert_bookie_strike($data)
	{
		$this->db->insert_batch('strike_bookie', $data);
	}

	function insert_pl_bok($data)
	{
		$this->db->insert_batch('pl_bok', $data);
	}
	function insert_pl_coy($data)
	{
		$this->db->insert_batch('pl_coy', $data);
	}
	function insert_pl_man($data)
	{
		$this->db->insert_batch('pl_man', $data);
	}
	function insert_pl_mas($data)
	{
		$this->db->insert_batch('pl_mas', $data);
	}
	function insert_pl_agg($data)
	{
		$this->db->insert_batch('pl_agg', $data);
	}
	function insert_pl_agt($data)
	{
		$this->db->insert_batch('pl_agt', $data);
	}
	function insert_pl_meb($data)
	{
		$this->db->insert_batch('pl_meb', $data);
	}

	function update_strike($amount,$ref,$date)
	{
		$sql = "update bet_records set strike = strike + ? WHERE ref = ? and drawdate = ?"; 
		$query = $this->db->query($sql, array($amount,$ref,$date));
	}

	function update_bookie_po($amount,$uid,$date)
	{
		$sql = "update pl_bok set po_return = ? WHERE bok_id = ? and drawdate = ?"; 
		$query = $this->db->query($sql, array($amount,$uid,$date));
	}

	function update_po($type,$amt100,$amt,$uid,$date)
	{
		switch($type)
		{
			case 'users_man':	$sql = "update pl_man set share_po_amt = ?, share_po_amt100 = ? WHERE man_id = ? and drawdate = ?"; 
								break;
			case 'users_mas':	$sql = "update pl_mas set share_po_amt = ?, share_po_amt100 = ? WHERE mas_id = ? and drawdate = ?"; 
								break;
			case 'users_agg':	$sql = "update pl_agg set share_po_amt = ?, share_po_amt100 = ? WHERE agg_id = ? and drawdate = ?"; 
								break;
		}
		$query = $this->db->query($sql, array($amt,$amt100,$uid,$date));
	}


	function get_total_ticket($date,$uid) // get total ticket at individual level
	{
		switch(strlen($uid))
		{
			case 2:		$sql = "SELECT 
						sum(((amt_big - (agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (agg_intake_small + agt_intake_small)) * 0.7)) as ticket_amt
						FROM transactions
						WHERE drawdate = ? 
						and 
						mas_id = ?"; 
						$query = $this->db->query($sql, array($date,$uid)); 
						break;
			case 4:		$sql = "SELECT 
						sum(((amt_big - agt_intake_big) * 1.6)  + ((amt_small - agt_intake_small) * 0.7)) as ticket_amt 
						FROM transactions 
						WHERE drawdate = ? and agg_id = ?"; 
						$query = $this->db->query($sql, array($date,$uid)); 
						break;
			case 6:		$sql = "SELECT 
						sum((amt_big * 1.6) + (amt_small * 0.7)) as ticket_amt 
						FROM transactions 
						WHERE drawdate = ? and agt_id = ?"; 
						$query = $this->db->query($sql, array($date,$uid)); 
						break;
			case 8:		$sql = "SELECT 
						sum(((amt_big - (mas_intake_big + agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (mas_intake_small + agg_intake_small + agt_intake_small)) * 0.7)) as ticket_amt 
						FROM transactions 
						WHERE drawdate = ? and meb_id = ?"; 
						$query = $this->db->query($sql, array($date,$uid)); 
						break;
			default:	$sql = "SELECT 
						sum(((amt_big - (mas_intake_big + agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (mas_intake_small + agg_intake_small + agt_intake_small)) * 0.7)) as ticket_amt 
						FROM transactions WHERE drawdate = ?"; 
						$query = $this->db->query($sql, array($date)); 
						break;
		}

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['ticket_amt'];
			}
		}
	}

	function get_co_strike($date)
	{
		$sql = "SELECT 
				sum(coy_strike) as coy_strike FROM strike_company WHERE drawdate = ?"; 
				$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['coy_strike'];
			}
		}
	}

	function get_bookie_ticket($date)
	{
		$sql = "SELECT sum(((bookie_intake.amt_big * 1.6) +  (bookie_intake.amt_small * 0.7)) * (1 - (users_bok.placeout_com / 100))) as ticket_amt
				FROM `bookie_intake` left join users_bok on bookie_intake.bok_id = users_bok.bok_id
				WHERE drawdate = ?";
				$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['ticket_amt'];
			}
		}
	}

	function get_bookie_ticket_detail($date, $uid)
	{
		$sql = "SELECT sum(((bookie_intake.amt_big * 1.6) +  (bookie_intake.amt_small * 0.7)) * (1 - (users_bok.placeout_com / 100))) as ticket_amt
				FROM `bookie_intake` left join users_bok on bookie_intake.bok_id = users_bok.bok_id
				WHERE bookie_intake.drawdate = ? and bookie_intake.bok_id = ?";
				$query = $this->db->query($sql, array($date, $uid)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['ticket_amt'];
			}
		}
	}

	function get_bookie_strike($date)
	{
		$sql = "SELECT 
				sum(bok_strike) as bok_strike FROM strike_bookie WHERE drawdate = ?"; 
				$query = $this->db->query($sql, array($date)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['bok_strike'];
			}
		}
	}

	function get_bookie_strike_detail($date, $uid)
	{
		$sql = "SELECT 
				sum(bok_strike) as bok_strike FROM strike_bookie WHERE drawdate = ? and bok_id = ?"; 
				$query = $this->db->query($sql, array($date, $uid)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['bok_strike'];
			}
		}
	}

	function get_bookie_pl($date)
	{
		$sql = "SELECT * FROM pl_bok WHERE drawdate = ?"; 
				
		$query = $this->db->query($sql, array($date)); 		
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function get_manager_ticket_detail($date, $uid)
	{
		$sql = "SELECT 
				sum(total_po_ticket - total_intake_ticket) as ticket_amt,
				sum(total_meb_strike - total_own_strike - total_downline_strike) as strike_amt,
				sum(ticket_perc) as ticket_perc,
				sum(total_intake_tax) as downline_intake_tax,
				sum(total_intake_ticket) as downline_intake_ticket

				FROM pl_mas 
				WHERE drawdate = ? and man_id = ?";

				$query = $this->db->query($sql, array($date, $uid)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_mas_coin($date,$uid)
	{
		$sql = "SELECT 
				sum((total_own_intake_ticket - total_own_strike) - total_own_intake_tax) as intake_pl,
				sum(share_co_amt) as shareco_pl
				FROM `pl_mas`
				WHERE drawdate = ? and mas_id = ?";

				$query = $this->db->query($sql, array($date, $uid)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_agg_coin($date,$uid)
	{
		$sql = "SELECT 
				sum(total_own_intake_ticket - total_own_strike) as agg_intake_pl,
				sum(share_mas_amt) as mas_intake_pl,
				sum(share_co_amt) as shareco_pl
				FROM `pl_agg`
				WHERE drawdate = ? and agg_id = ?";
				$query = $this->db->query($sql, array($date, $uid)); 

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}


	function get_uid_ticket($date,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							users_mas.placeout_com as placeout_comm,

							mas_intake_tax as intake_tax,

							sum(amt_big) as total_po_big,

							sum(amt_small) as total_po_small,

							sum(mas_intake_big + agg_intake_big + agt_intake_big) as total_intake_big,

							sum(mas_intake_small + agg_intake_small + agt_intake_small) as total_intake_small,

							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_mas.placeout_com /100))) as total_ticket_amount,

							sum((((amt_big - (mas_intake_big + agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (mas_intake_small + agg_intake_small + agt_intake_small)) * 0.7))  * (1 - (users_mas.placeout_com /100))) as own_po_amount,

							sum(((amt_big - (mas_intake_big + agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (mas_intake_small + agg_intake_small + agt_intake_small)) * 0.7)) as own_po_amount_wo_comm,

							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_agg.placeout_com /100))) as downline_po_amount,

							sum((((mas_intake_big + agg_intake_big + agt_intake_big)* 1.6) + ((mas_intake_small + agg_intake_small + agt_intake_small) * 0.7))  * (mas_intake_tax / 100) ) as total_tax_amount,

							sum(((mas_intake_big * 1.6) + (mas_intake_small * 0.7))  * (mas_intake_tax / 100) ) as own_tax_amount,

							sum((((agg_intake_big + agt_intake_big)* 1.6) + ((agg_intake_small + agt_intake_small) * 0.7))  * (agg_intake_tax / 100) ) as downline_tax_amount,

							sum((((mas_intake_big + agg_intake_big + agt_intake_big) * 1.6) + ((mas_intake_small + agg_intake_small + agt_intake_small) * 0.7)) * (1 - (users_mas.placeout_com /100))) as total_intake_amount,

							sum(((mas_intake_big * 1.6) + (mas_intake_small * 0.7)) * (1 - (users_mas.placeout_com /100))) as own_intake_amount,

							sum((((agg_intake_big + agt_intake_big) * 1.6) + ((agg_intake_small + agt_intake_small) * 0.7)) * (1 - (users_agg.placeout_com /100))) as downline_intake_amount

							FROM `transactions` 
							left join users_agg on transactions.agg_id = users_agg.agg_id
							left join users_mas on transactions.mas_id = users_mas.mas_id
							where 
							transactions.mas_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 4: $sql = "SELECT 
							users_agg.placeout_com as placeout_comm,

							agg_intake_tax as intake_tax,

							sum(amt_big) as total_po_big,

							sum(amt_small) as total_po_small,

							sum(agg_intake_big + agt_intake_big) as total_intake_big,

							sum(agg_intake_small + agt_intake_small) as total_intake_small,

							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_agg.placeout_com /100))) as total_ticket_amount,

							sum((((agg_intake_big + agt_intake_big) * 1.6) + ((agg_intake_small + agt_intake_small) * 0.7)) * (1 - (users_agg.placeout_com /100))) as total_intake_amount,

							sum(((amt_big - (agg_intake_big + agt_intake_big)) * 1.6)  + ((amt_small - (agg_intake_small + agt_intake_small)) * 0.7)) as own_po_amount_wo_comm,

							sum((((agg_intake_big + agt_intake_big)* 1.6) + ((agg_intake_small + agt_intake_small) * 0.7))  * (agg_intake_tax / 100) ) as total_tax_amount,	
							
							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_agt.placeout_com /100))) as downline_po_amount,

							sum(((agg_intake_big * 1.6) + (agg_intake_small * 0.7))  * (agg_intake_tax / 100) ) as own_tax_amount,

							sum(((agt_intake_big* 1.6) + (agt_intake_small * 0.7))  * (agt_intake_tax / 100) ) as downline_tax_amount,

							sum(((agg_intake_big * 1.6) + (agg_intake_small * 0.7)) * (1 - (users_agg.placeout_com /100))) as own_intake_amount,

							sum(((agt_intake_big * 1.6) + (agt_intake_small * 0.7)) * (1 - (users_agt.placeout_com /100))) as downline_intake_amount

							FROM `transactions` 
							left join users_agt on transactions.agt_id = users_agt.agt_id
							left join users_agg on transactions.agg_id = users_agg.agg_id
							where 
							transactions.agg_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 6: $sql = "SELECT 
							users_agt.placeout_com as placeout_comm,

							agt_intake_tax as intake_tax,

							sum(amt_big) as total_po_big,

							sum(amt_small) as total_po_small,

							sum(agt_intake_big) as total_intake_big,

							sum(agt_intake_small) as total_intake_small,

							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_agt.placeout_com /100))) as total_ticket_amount,

							sum(((amt_big - agt_intake_big) * 1.6)  + ((amt_small - agt_intake_small) * 0.7)) as own_po_amount_wo_comm,

							sum((((amt_big - agt_intake_big) * 1.6)  + ((amt_small - agt_intake_small) * 0.7))  * (1 - (users_agt.placeout_com /100))) as own_po_amount,
							
							sum((((amt_big) * 1.6) + ((amt_small) * 0.7)) * (1 - (users_meb.placeout_com /100))) as downline_po_amount,

							sum(((amt_big - agt_intake_big) * 1.6)  + ((amt_small - agt_intake_small) * 0.7)) as own_po_amount_wo_comm,

							sum(((agt_intake_big * 1.6) + (agt_intake_small * 0.7))  * (agt_intake_tax / 100)) as own_tax_amount,

							sum(((agt_intake_big * 1.6) + (agt_intake_small * 0.7)) * (1 - (users_agt.placeout_com /100))) as own_intake_amount

							FROM `transactions` 
							left join users_agt on transactions.agt_id = users_agt.agt_id
							left join users_meb on transactions.meb_id = users_meb.meb_id
							where 
							transactions.agt_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 8: $sql = "SELECT 
							users_meb.placeout_com as placeout_comm,

							sum(amt_big) as total_po_big,

							sum(amt_small) as total_po_small,

							sum(((amt_big * 1.6) + (amt_small * 0.7)) * (1 - (users_meb.placeout_com /100))) as total_ticket_amount
							FROM `transactions`

							left join users_meb on transactions.meb_id = users_meb.meb_id
							where 
							transactions.meb_id = ?
							and 
							drawdate = ? 
							";
					break;
		}
		$query = $this->db->query($sql, array($uid, $date)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function get_uid_strike($date,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							sum(meb_strike) as total_strike_amount,
							sum(mas_strike) as own_intake_strike,
							sum(agg_strike + agt_strike) as downline_intake_strike
							FROM `strike_users` 
							where 
							mas_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 4: $sql = "SELECT 
							sum(meb_strike) as total_strike_amount,
							sum(agg_strike) as own_intake_strike,
							sum(agt_strike) as downline_intake_strike
							FROM `strike_users` 
							where 
							agg_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 6: $sql = "SELECT 
							sum(meb_strike) as total_strike_amount,
							sum(agt_strike) as own_intake_strike
							FROM `strike_users` 
							where 
							agt_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 8: $sql = "SELECT 
							sum(meb_strike) as total_strike_amount
							FROM `strike_users` 
							where 
							meb_id = ?
							and 
							drawdate = ? 
							";
					break;
		}
		$query = $this->db->query($sql, array($uid, $date)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function get_uid_sms($date,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							sum(sms_charges) as sms_charges
							FROM `bet_records` 
							where 
							mas_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 4: $sql = "SELECT 
							sum(sms_charges) as sms_charges
							FROM `bet_records` 
							where 
							agg_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 6: $sql = "SELECT 
							sum(sms_charges) as sms_charges
							FROM `bet_records` 
							where 
							agt_id = ?
							and 
							drawdate = ? 
							";
					break;
			case 8: break;
		}
		$query = $this->db->query($sql, array($uid, $date)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function get_all_users($table)
	{
		switch($table)
		{
			case 'users_bok':	$sql = "SELECT * FROM users_bok where status = 'active'";
								break;
			case 'users_man':	$sql = "SELECT * FROM users_man where status = 'active'";
								break;
			case 'users_mas':	$sql = "SELECT * FROM users_mas where status = 'active'";
								break;
			case 'users_agg':	$sql = "SELECT * FROM users_agg where status = 'active'";
								break;
			case 'users_agt':	$sql = "SELECT * FROM users_agt where status = 'active'";
								break;
			case 'users_meb':	$sql = "SELECT * FROM users_meb where status = 'active'";
								break;
		}
		
		$query = $this->db->query($sql); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function get_all_po_perc($table,$date,$uid)
	{
		switch($table)
		{
			case 'users_man':	$sql = "SELECT ticket_perc, share_po_perc FROM pl_man where drawdate = ? and man_id = ?";
								break;
			case 'users_mas':	$sql = "SELECT ticket_perc, share_po_perc FROM pl_mas where drawdate = ? and mas_id = ?";
								break;
			case 'users_agg':	$sql = "SELECT ticket_perc, share_po_perc FROM pl_agg where drawdate = ? and agg_id = ?";
								break;
		}
		
		$query = $this->db->query($sql, array($date, $uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_all_po_amt($table,$date,$uid)
	{
		switch($table)
		{
			case 'users_man':	$sql = "SELECT share_po_amt FROM pl_man where drawdate = ? and man_id = ?";
								break;
			case 'users_mas':	$sql = "SELECT share_po_amt FROM pl_mas where drawdate = ? and mas_id = ?";
								break;
		}
		
		$query = $this->db->query($sql, array($date, $uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row['share_po_amt'];
		}
	}


	function get_strike_data($date,$uid)
	{
		$sql = "SELECT 
				sum(meb_strike) as total_strike,
				sum(agt_strike) as intake_strike_agt,
				sum(agg_strike) as intake_strike_agg,
				sum(mas_strike) as intake_strike_mas,
				sum(meb_strike - agt_strike - agg_strike - mas_strike) as strike_sys
				FROM strike_users WHERE drawdate = ? and meb_id = ?"; 
		$query = $this->db->query($sql, array($date,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function delete_table($table,$drawdate)
	{
		switch($table)
		{
			case 'pl_agg':			$sql = "Delete FROM pl_agg WHERE drawdate = ?"; 
									break;
			case 'pl_agt':			$sql = "Delete FROM pl_agt WHERE drawdate = ?"; 
									break;
			case 'pl_mas':			$sql = "Delete FROM pl_mas WHERE drawdate = ?"; 
									break;
			case 'pl_meb':			$sql = "Delete FROM pl_meb WHERE drawdate = ?"; 
									break;
			case 'pl_man':			$sql = "Delete FROM pl_man WHERE drawdate = ?"; 
									break;
			case 'pl_coy':			$sql = "Delete FROM pl_coy WHERE drawdate = ?"; 
									break;
			case 'pl_bok':			$sql = "Delete FROM pl_bok WHERE drawdate = ?"; 
									break;
			case 'strike_bookie':	$sql = "Delete FROM strike_bookie WHERE drawdate = ?"; 
									break;
			case 'strike_company':	$sql = "Delete FROM strike_company WHERE drawdate = ?"; 
									break;
			case 'strike_users':	$sql = "Delete FROM strike_users WHERE drawdate = ?"; 
									break;
			case 'admin_intake':	$sql = "Delete FROM admin_intake WHERE drawdate = ?"; 
									break;
			case 'admin_intake_detail':		$sql = "Delete FROM admin_intake_detail WHERE drawdate = ?"; 
											break;
			case 'admin_intake_temp':		$sql = "Delete FROM admin_intake_temp WHERE drawdate = ?"; 
											break;
			case 'bookie_intake':	$sql = "Delete FROM bookie_intake WHERE drawdate = ?"; 
									break;
			case 'bookie_intake_detail':	$sql = "Delete FROM bookie_intake_detail WHERE drawdate = ?"; 
											break;
			case 'bookie_intake_pool':	$sql = "Delete FROM bookie_intake_pool WHERE drawdate = ?"; 
											break;
			case 'master_po_detail':	$sql = "Delete FROM master_po_detail WHERE drawdate = ?"; 
										break;
			case 'results':			$sql = "Delete FROM results WHERE drawdate = ?"; 
									break;
			case 'po_returns_bok':	$sql = "Update pl_bok set po_return = '0' where drawdate = ?"; 
									break;
			case 'po_returns_man':	$sql = "Update pl_man set share_po_amt = '0', share_po_amt100 = '0' where drawdate = ?"; 
									break;
			case 'po_returns_mas':	$sql = "Update pl_mas set share_po_amt = '0', share_po_amt100 = '0' where drawdate = ?"; 
									break;
			case 'po_returns_agg':	$sql = "Update pl_agg set share_po_amt = '0', share_po_amt100 = '0' where drawdate = ?"; 
									break;
		}
		$query = $this->db->query($sql, array($drawdate)); 
	}

	function get_report_man($todate,$fromdate,$uid)
	{
		$sql = "SELECT
				drawdate,
				man_id,
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(downline_intake_ticket) as downline_intake_ticket,
				sum(downline_intake_tax) as downline_intake_tax,
				sum(own_intake_tax) as own_intake_tax,
				sum(ticket_perc) as ticket_perc,
				sum(share_po_perc) as share_po_perc,
				sum(share_po_amt) as share_po_amt,
				sum(share_po_amt100) as share_po_amt100,
				sum(share_co_perc) as share_co_perc,
				sum(share_co_amt) as share_co_amt,
				sum(share_co_amt100) as share_co_amt100
				FROM pl_man WHERE drawdate >= ? and drawdate <= ? and man_id = ?";

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_share_downline_man($todate,$fromdate,$uid)
	{
		$sql = "SELECT 
				sum(share_co_amt + share_po_amt) as share,
				sum(total_intake_tax) as tax
				FROM pl_mas WHERE drawdate >= ? and drawdate <= ? and man_id = ?"; 

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_downline_total_man($todate,$fromdate,$uid)
	{
		$sql = "SELECT 
				sum(total_po_ticket) as total_po_ticket,
				sum(total_intake_ticket) as total_intake_ticket,
				sum(total_meb_strike) as total_strike,
				sum(total_own_strike + total_downline_strike) as total_intake_strike,
				sum(ticket_perc) as total_perc,
				sum(share_po_amt) as total_share_po,
				sum(share_co_amt) as total_share_co,
				sum(total_intake_tax) as total_tax
				FROM pl_mas WHERE drawdate >= ? and drawdate <= ? and man_id = ?"; 

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}
	
	function get_downline_report_man($todate,$fromdate,$uid)
	{
		
		$sql = "SELECT users_mas.name as name,
				pl_mas.drawdate as drawdate,
				pl_mas.man_id as man_id,
				pl_mas.mas_id as mas_id,
				pl_mas.placeout_comm as placeout_comm,
				pl_mas.intake_tax as intake_tax,
				sum(pl_mas.total_po_big) as total_po_big,
				sum(pl_mas.total_po_small) as total_po_small,
				sum(pl_mas.total_intake_big) as total_intake_big,
				sum(pl_mas.total_intake_small) as total_intake_small,
				sum(pl_mas.ticket_perc) as ticket_perc,
				sum(pl_mas.total_po_ticket) as total_po_ticket,
				sum(pl_mas.downline_total_po_ticket) as downline_total_po_ticket,
				sum(pl_mas.total_meb_strike) as total_meb_strike,
				sum(pl_mas.total_own_strike) as total_own_strike,
				sum(pl_mas.total_downline_strike) as total_downline_strike,
				sum(pl_mas.total_intake_ticket) as total_intake_ticket,
				sum(pl_mas.total_own_intake_ticket) as total_own_intake_ticket,
				sum(pl_mas.total_downline_intake_ticket) as total_downline_intake_ticket,
				sum(pl_mas.total_intake_tax) as total_intake_tax,
				sum(pl_mas.total_own_intake_tax) as total_own_intake_tax,
				sum(pl_mas.total_downline_intake_tax) as total_downline_intake_tax,
				pl_mas.share_co_perc as share_co_perc,
				sum(pl_mas.share_co_amt) as share_co_amt,
				sum(pl_mas.share_co_amt100) as share_co_amt100,
				pl_mas.share_po_perc as share_po_perc,
				sum(pl_mas.share_po_amt) as share_po_amt,
				sum(pl_mas.share_po_amt100) as share_po_amt100,
				sum(pl_mas.sms_charges) as sms_charges,
				sum(pl_mas.expenses) as expenses

				FROM pl_mas
				left join users_mas on pl_mas.mas_id = users_mas.mas_id
				WHERE drawdate >= ? and drawdate <= ? and pl_mas.man_id = ? group by users_mas.mas_id order by users_mas.mas_id asc"; 

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function get_downline_report($todate,$fromdate,$uid)
	{
		
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT users_agg.name as name,
							pl_agg.drawdate as drawdate,
							pl_agg.mas_id as mas_id,
							pl_agg.agg_id as agg_id,
							pl_agg.placeout_comm as placeout_comm,
							pl_agg.intake_tax as intake_tax,
							sum(pl_agg.total_po_big) as total_po_big,
							sum(pl_agg.total_po_small) as total_po_small,
							sum(pl_agg.total_intake_big) as total_intake_big,
							sum(pl_agg.total_intake_small) as total_intake_small,
							sum(pl_agg.ticket_perc) as ticket_perc,
							sum(pl_agg.total_po_ticket) as total_po_ticket,
							sum(pl_agg.downline_total_po_ticket) as downline_total_po_ticket,
							sum(pl_agg.total_meb_strike) as total_meb_strike,
							sum(pl_agg.total_own_strike) as total_own_strike,
							sum(pl_agg.total_downline_strike) as total_downline_strike,
							sum(pl_agg.total_intake_ticket) as total_intake_ticket,
							sum(pl_agg.total_own_intake_ticket) as total_own_intake_ticket,
							sum(pl_agg.total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(pl_agg.total_intake_tax) as total_intake_tax,
							sum(pl_agg.total_own_intake_tax) as total_own_intake_tax,
							sum(pl_agg.total_downline_intake_tax) as total_downline_intake_tax,
							pl_agg.share_co_perc as share_co_perc,
							sum(pl_agg.share_co_amt) as share_co_amt,
							sum(pl_agg.share_co_amt100) as share_co_amt100,
							pl_agg.share_po_perc as share_po_perc,
							sum(pl_agg.share_po_amt) as share_po_amt,
							sum(pl_agg.share_po_amt100) as share_po_amt100,
							pl_agg.share_mas_perc as share_mas_perc,
							sum(pl_agg.share_mas_amt) as share_mas_amt,
							sum(pl_agg.share_mas_amt100) as share_mas_amt100			
							FROM pl_agg
							left join users_agg on pl_agg.agg_id = users_agg.agg_id
							WHERE drawdate >= ? and drawdate <= ? and pl_agg.mas_id = ? group by pl_agg.agg_id order by pl_agg.agg_id asc"; 
					break;
			case 4: $sql = "SELECT users_agt.name as name,
							pl_agt.drawdate,
							pl_agt.mas_id,
							pl_agt.agg_id,
							pl_agt.agt_id,
							pl_agt.placeout_comm as placeout_comm,
							pl_agt.intake_tax as intake_tax,
							sum(pl_agt.total_po_big) as total_po_big,
							sum(pl_agt.total_po_small) as total_po_small,
							sum(pl_agt.total_intake_big) as total_intake_big,
							sum(pl_agt.total_intake_small) as total_intake_small,
							sum(pl_agt.ticket_perc) as ticket_perc,
							sum(pl_agt.total_po_ticket) as total_po_ticket,
							sum(pl_agt.downline_total_po_ticket) as downline_total_po_ticket,
							sum(pl_agt.total_meb_strike) as total_meb_strike,
							sum(pl_agt.total_own_strike) as total_own_strike,
							sum(pl_agt.total_own_intake_ticket) as total_own_intake_ticket,
							sum(pl_agt.total_own_intake_tax) as total_own_intake_tax,
							pl_agt.share_co_perc as share_co_perc,
							sum(pl_agt.share_co_amt) as share_co_amt,
							sum(pl_agt.share_co_amt100) as share_co_amt100,
							pl_agt.share_agg_perc as share_agg_perc,
							sum(pl_agt.share_agg_amt) as share_agg_amt,
							sum(pl_agt.share_agg_amt100) as share_agg_amt100,
							pl_agt.share_mas_perc as share_mas_perc,
							sum(pl_agt.share_mas_amt) as share_mas_amt,
							sum(pl_agt.share_mas_amt100) as share_mas_amt100
							FROM pl_agt
							left join users_agt on pl_agt.agt_id = users_agt.agt_id
							WHERE drawdate >= ? and drawdate <= ? and pl_agt.agg_id = ? group by pl_agt.agt_id order by pl_agt.agt_id asc"; 
					break;
			case 6: $sql = "SELECT 
							users_meb.name as name,
							pl_meb.drawdate as drawdate,
							pl_meb.mas_id as mas_id,
							pl_meb.agg_id as agg_id,
							pl_meb.agt_id as agt_id,
							pl_meb.meb_id as meb_id,
							sum(pl_meb.placeout_comm) as placeout_comm,
							sum(pl_meb.total_po_big) as total_po_big,
							sum(pl_meb.total_po_small) as total_po_small,
							sum(pl_meb.total_ticket) as total_ticket,
							sum(pl_meb.total_strike) as total_strike
							FROM pl_meb 
							left join users_meb on pl_meb.meb_id = users_meb.meb_id
							WHERE drawdate >= ? and drawdate <= ? and pl_meb.agt_id = ? group by pl_meb.meb_id order by pl_meb.meb_id asc"; 
					break;
			case 8: 
					break;
		}
		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	
	function get_downline_total($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
					sum(total_po_ticket - total_intake_ticket) as total_ticket,
					sum(total_meb_strike - total_own_strike - total_downline_strike) as total_strike,
					sum(ticket_perc) as total_perc,
					sum(share_mas_amt + share_po_amt + share_co_amt) as total_share,
					sum(total_intake_tax) as total_tax
					FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and mas_id = ?"; 
					break;
			case 4: $sql = "SELECT 
					sum(total_po_ticket - total_own_intake_ticket) as total_ticket,
					sum(total_meb_strike - total_own_strike) as total_strike,
					sum(ticket_perc) as total_perc,
					sum(share_mas_amt + share_agg_amt + share_co_amt) as total_share,
					sum(total_own_intake_tax) as total_tax
					FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agg_id = ?"; 
					break;
			case 6: $sql = "SELECT 
					sum(total_po_big) as total_big,
					sum(total_po_small) as total_small,
					sum(total_ticket) as total_ticket,
					sum(total_strike) as total_strike
					FROM pl_meb WHERE drawdate >= ? and drawdate <= ? and agt_id = ?";
					break;
			case 8: break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}	
	
	function get_share_downline($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
					sum(share_co_amt) as share_co,
					sum(share_po_amt) as share_po,
					sum(share_mas_amt) as share_mas,
					sum(total_own_intake_tax) as tax
					FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and mas_id = ?"; 
					break;
			case 4: $sql = "SELECT 
					sum(share_co_amt) as share_co,
					sum(share_agg_amt) as share_agg,
					sum(share_mas_amt) as share_mas,
					sum(total_own_intake_tax) as tax
					FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agg_id = ?"; 
					break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}
	
	function get_report($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT drawdate,
							man_id,
							mas_id,
							sum(placeout_comm) as placeout_comm,
							sum(intake_tax) as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_downline_strike) as total_downline_strike,
							sum(total_intake_ticket) as total_intake_ticket,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(total_intake_tax) as total_intake_tax,
							sum(total_own_intake_tax) as total_own_intake_tax,
							sum(total_downline_intake_tax) as total_downline_intake_tax,
							sum(share_co_perc) as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							sum(share_po_perc) as share_po_perc,
							sum(share_po_amt) as share_po_amt,
							sum(share_po_amt100) as share_po_amt100,
							sum(sms_charges) as sms_charges,
							sum(expenses) as expenses		
							FROM pl_mas WHERE drawdate >= ? and drawdate <= ? and mas_id = ?";
					break;
			case 4: $sql = "SELECT
							drawdate,
							mas_id,
							agg_id,
							sum(placeout_comm) as placeout_comm,
							sum(intake_tax) as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_downline_strike) as total_downline_strike,
							sum(total_intake_ticket) as total_intake_ticket,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(total_intake_tax) as total_intake_tax,
							sum(total_own_intake_tax) as total_own_intake_tax,
							sum(total_downline_intake_tax) as total_downline_intake_tax,
							sum(share_co_perc) as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							sum(share_po_perc) as share_po_perc,
							sum(share_po_amt) as share_po_amt,
							sum(share_po_amt100) as share_po_amt100,
							sum(share_mas_perc) as share_mas_perc,
							sum(share_mas_amt) as share_mas_amt,
							sum(share_mas_amt100) as share_mas_amt100
							FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and agg_id = ?";
					break;
			case 6: $sql = "SELECT
							drawdate,
							mas_id,
							agg_id,
							agt_id,
							sum(placeout_comm) as placeout_comm,
							sum(intake_tax) as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_own_intake_tax) as total_own_intake_tax,
							sum(share_co_perc) as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							sum(share_agg_perc) as share_agg_perc,
							sum(share_agg_amt) as share_agg_amt,
							sum(share_agg_amt100) as share_agg_amt100,
							sum(share_mas_perc) as share_mas_perc,
							sum(share_mas_amt) as share_mas_amt,
							sum(share_mas_amt100) as share_mas_amt100
							FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agt_id = ?";
					break;
			case 8: 
					break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}
	function get_intake_details($date,$type)
	{
		switch($type)
		{
			case 'admin':	$sql = "SELECT *		
							FROM admin_intake_detail WHERE drawdate = ?";
							break;
			case 'bookie':	$sql = "SELECT *		
							FROM bookie_intake_detail WHERE drawdate = ?";
							break;
			case 'master':	$sql = "SELECT *		
							FROM master_po_detail WHERE drawdate = ?";
							break;
		}

		$query = $this->db->query($sql, array($date)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}
	function get_generate_draw($limit)
	{

		$this->db->distinct();
		$this->db->select('drawdate');
		$this->db->order_by("drawdate", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get('admin_intake_detail');
		
		$drawdate = array();

		foreach ($query->result_array() as $row)
		{
			$td = $row['drawdate'];
			$arr = explode ("-", $td);
			$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
			$t = date('D',$stamp);
			if (strcmp($t, 'Wed') == 0 ){$day = 'Wed';}
			if (strcmp($t, 'Sat') == 0 ){$day = 'Sat';}
			if (strcmp($t, 'Sun') == 0 ){$day = 'Sun';}

		   $drawdate[$row['drawdate']] = $row['drawdate']." (".$day.")";
		}
		return $drawdate;
	}	
	
	function send_sms ($host, $port, $username, $password, $phoneNoRecip, $msgText) { 
	 
		$fp = fsockopen($host, $port, $errno, $errstr);
		if (!$fp) {
			echo "errno: $errno \n";
			echo "errstr: $errstr\n";
			return $result;
		}
		
		fwrite($fp, "GET /api.aspx?apiusername=APIJGTB1BMJ4C&apipassword=APIJGTB1BMJ4CJGTB1&mobileno=65" . rawurlencode($phoneNoRecip) . "&senderid=+6018991888&languagetype=1&message=" . rawurlencode($msgText) . " HTTP/1.0\n");
		
		//fwrite($fp, "GET /isms_send.php?un=angel1888&pwd=angel1888&dstno=65" . rawurlencode($phoneNoRecip) . "&sendid=6018991888&type=1&msg=" . rawurlencode($msgText) . " HTTP/1.0\n");
		
		if ($username != "") {
		   $auth = $username . ":" . $password;
		   $auth = base64_encode($auth);
		   fwrite($fp, "Authorization: Basic " . $auth . "\n");
		}
		fwrite($fp, "\n");
	  
		$res = "";
	 
		while(!feof($fp)) {
			$res .= fread($fp,1);
		}
		fclose($fp);
		
	 
		return $res;
	}
}
?>
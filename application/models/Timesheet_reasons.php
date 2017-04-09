<?php

class Timesheet_reasons extends CI_Model {

	

	public function createReasons($emp_id, $login_time, $total_hours, $reason)
	{	
			$date = new DateTime($login_time);
			$date = $date->format('Y-m-d H:i:s');
			$row['emp_id'] = $emp_id;
			$row['reason'] = $reason;
			$row['loggedIn_date'] = $date;
			$row['loggedOut_date'] = date("Y-m-d H:i:s");
			$row['total_hours'] = $total_hours;

			$this->db->insert('timesheet_reason', $row);
		

			return true;
		
	}

	
}
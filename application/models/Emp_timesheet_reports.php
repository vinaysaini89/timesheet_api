<?php

class Emp_timesheet_reports extends CI_Model {

	

	public function createReports($emp_id, $data)
	{
		foreach ($data as $key => $value) {
			$row['emp_id'] = $emp_id;
			$row['p_id'] = $value['p_id'];
			$row['p_name'] = $value['p_name'];
			$row['description'] = $value['description'];
			$row['hours'] = $value['time'];

			$this->db->insert('emp_timesheet_reports', $row);
		}

		return true;
		
	}

	
}
<?php

class Emp_timesheet_reports extends CI_Model {
	public $_ci = "";
	public function __construct($input=null)
	{
	    $this->_ci =& get_instance();

	    $this->_ci =& get_instance();
        $this->_ci->load->model('projects');
	}

	public function createReports($emp_id, $data)
	{
		foreach ($data as $key => $value) {

			$projects = $this->_ci->projects->getProject($value['p_id']);
			$row['emp_id'] = $emp_id;
			$row['p_id'] = $value['p_id'];
			$row['p_name'] = $projects->p_name;
			$row['activity'] = $projects->activity;
			//$row['description'] = $value['description'];
			$row['minutes'] = $value['time'];

			$this->db->insert('emp_timesheet_reports', $row);
		}

		return true;
		
	}

	
}
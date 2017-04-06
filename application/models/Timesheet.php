<?php

class Timesheet extends CI_Model {

	public function timeSheetData($data)
	{
		return $this->db->insert('timesheet', $data); 
	}

	public function timeSheetDataFetch($emp_id)
	{

			$this->db->select('*');           

		    $this->db->from('timesheet');
		    $this->db->where('emp_id',$emp_id);
			$query=$this->db->get();
			return $query->result_array();

		
	}

	public function timeSheetDataUpdate($emp_id)
	{
		$this->db->select_max('login_date');          
		$this->db->from('timesheet');
		$this->db->where('emp_id', $emp_id);
		$query=$this->db->get()->row();
		$max_login_date = $query->login_date;
		
		$data=array('end_time' => date('Y-m-d H:i:s'));
		$this->db->where('start_time', $max_login_date);
		$this->db->update('timesheet',$data);
	}
}
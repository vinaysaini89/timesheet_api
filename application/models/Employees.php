<?php

class Employees extends CI_Model {

		public function allEmployee()
		{
			$this->db->select('*');           

		    $this->db->from('employees');
			$query=$this->db->get();
			return $query->result_array();

		}
      
      	public function login($emp_id, $password)
		{
			$this->db->select('*');           

		    $this->db->from('employees');
		    $this->db->where('id', $emp_id);
		    $this->db->where('password', $password);
			$result=$this->db->get()->row();
			return $result;

		}

		public function checkLogin($emp_id)
		{ 	
			$this->db->select('*');           
			$this->db->from('timesheet');
			$this->db->where('emp_id', $emp_id);
		    $this->db->where('Date(login_date)', 'CURDATE()', FALSE);
			$query=$this->db->get();
			
			if($query->num_rows() > 0)
			{
				
				return $query->row()->login_date;
			}
			
			return false;
			
		}


		public function checkLogout($emp_id)
		{ 	
			$this->db->select('*');           
			$this->db->from('timesheet');
			$this->db->where('emp_id', $emp_id);
		    $this->db->where('Date(end_time)', 'CURDATE()', FALSE);
			$query=$this->db->get();
			
			if($query->num_rows() > 0)
			{
				
				return $query->row()->login_date;
			}
			
			return false;
			
		}

		public function getTodayLogindata($emp_id)
		{ 	
			$this->db->select('*');           
			$this->db->from('timesheet');
			$this->db->where('emp_id', $emp_id);
		    $this->db->where('Date(login_date)', 'CURDATE()', FALSE);
			$query=$this->db->get();
			
			if($query->num_rows() > 0)
			{
				
				return $query->row();
			}
			
			return false;
			
		}

		
		
}
<?php

class Emp_projects extends CI_Model {

	

	public function userProject($emp_id)
	{

			$this->db->select('*');           

		    $this->db->from('emp_projects');
		    $this->db->where('emp_id',$emp_id);
			$query=$this->db->get()->row();
			$data = [];
			$data['id'] = $query->id;
			$data['emp_id'] = $query->emp_id;
			$data['p_id'] = $query->p_id;
			$data['p_name'] = $query->p_name;
			return $data;

		
	}

	
}
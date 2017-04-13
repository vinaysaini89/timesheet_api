<?php

class Projects extends CI_Model {

		public function allProjects()
		{
			$this->db->select('*');           

		    $this->db->from('projects');
			$query=$this->db->get();
			return $query->result_array();

		}
      
      	public function getProject($id)
		{
			$this->db->select('*');           

		    $this->db->from('projects');
		    $this->db->where('id', $id);
			$query=$this->db->get();
			return $query->row();

		}
		
		
}
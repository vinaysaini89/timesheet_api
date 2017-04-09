<?php

class Projects extends CI_Model {

		public function allProjects()
		{
			$this->db->select('*');           

		    $this->db->from('projects');
			$query=$this->db->get();
			return $query->result_array();

		}
      
      	
		
		
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct() 
	{		
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library('session');
		$this->load->model('employees');
		$this->load->model('timesheet');
		$this->load->model('emp_projects');
		$this->load->model('projects');
		$this->load->model('emp_timesheet_reports');
		$this->load->model('timesheet_reasons');
	}

	public function index()
	{
		
		$projects = $this->projects->allProjects();
		if($projects){
			echo json_encode(['code'=>200, "message"=>'', 'data'=>$projects]);
			die();
		}
		
		echo json_encode(['code'=>401, "message"=>'Data not found.', 'data'=>$data]);
		die();
	}

	public function createReports()
	{
		$total_working_hours = $this->input->post('total_working_hours');
		$emp_id = $this->input->get('emp_id');
		$login_time = $this->input->post('login_time');
		$report_data = $this->input->post('report_data');
		//print_r($report_data);die();
		if(!$emp_id){
			echo json_encode(['code'=>401, "message"=>'employees id is required']);
			die();
		}

		if(!$report_data){
			echo json_encode(['code'=>401, "message"=>'report data is required']);
			die();
		}

		if(!is_array($report_data)){
			echo json_encode(['code'=>401, "message"=>'report data must be array']);
			die();
		}
		/*$data = [];
		$i=0;
		foreach ($report_data as $key => $value) {
			
				$data[$i]['p_id'] = $value['project'];
				//$data[$i]['p_id'] = $value['id'];
				//$data[$i]['description'] = $value['description'];
				$data[$i]['time'] = $value['time'];
			


			$i++;
		}*/

		$data = [];
		$i=0;
		foreach ($report_data as $key => $value) {
				if($value['pro'] != 0 || ($value['time'] != "" && $value['time'] !=0))
				{
					$data[$i]['p_id'] = $value['pro']['id'];
					//$data[$i]['p_id'] = $value['id'];
					//$data[$i]['description'] = $value['description'];
					$data[$i]['time'] = $value['time'];
				}


			$i++;
		}

		//print_r($data);die();

		$this->emp_timesheet_reports->createReports($emp_id, $data);
		echo json_encode(['code'=>200, "message"=>'']);
		die();
		
	}


	public function timesheetReason()
	{
		$total_working_hours = $this->input->post('total_working_hours');
		$emp_id = $this->input->get('emp_id');
		$report_data = $this->input->post('report_data');
		$login_time = $this->input->post('login_time');
		$reason = $this->input->post('reason');
		//print_r($report_data);die();
		if(!$emp_id){
			echo json_encode(['code'=>401, "message"=>'employees id is required']);
			die();
		}

		if(!$report_data){
			echo json_encode(['code'=>401, "message"=>'report data is required']);
			die();
		}

		if(!$login_time){
			echo json_encode(['code'=>401, "message"=>'Logged in time is required']);
			die();
		}

		if(!$reason){
			echo json_encode(['code'=>401, "message"=>'reason is required']);
			die();
		}

		if(!is_array($report_data)){
			echo json_encode(['code'=>401, "message"=>'report data must be array']);
			die();
		}
		$data = [];
		$i=0;
		foreach ($report_data as $key => $value) {
				if($value['pro'] != 0 || ($value['time'] != "" && $value['time'] !=0))
				{
					$data[$i]['p_id'] = $value['pro']['id'];
					//$data[$i]['p_id'] = $value['id'];
					//$data[$i]['description'] = $value['description'];
					$data[$i]['time'] = $value['time'];
				}


			$i++;
		}
		//print_r($data);die();
		$this->emp_timesheet_reports->createReports($emp_id, $data);
		$this->timesheet_reasons->createReasons($emp_id, $login_time, $total_working_hours, $reason);
		echo json_encode(['code'=>200, "message"=>'']);
		die();
		
	}

	public function loginReason()
	{
		$emp_id = $this->input->get('emp_id');
		$login_time = $this->input->post('login_time');
		$reason = $this->input->post('reason');
		if(!$emp_id){
			echo json_encode(['code'=>401, "message"=>'employees id is required']);
			die();
		}

		

		if(!$login_time){
			echo json_encode(['code'=>401, "message"=>'Logged in time is required']);
			die();
		}

		if(!$reason){
			echo json_encode(['code'=>401, "message"=>'reason is required']);
			die();
		}

		$this->timesheet_reasons->createReasonsForLogin($emp_id, $login_time, $reason);
		echo json_encode(['code'=>200, "message"=>'']);
		die();
		
	}


	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	}

	public function index()
	{
		$emp_id = $this->input->get('emp_id');
		$data = $this->timesheet->timeSheetDataFetch($emp_id);
		$user_project = $this->emp_projects->userProject($emp_id);
		if($data){
			$results = [];
			$i =0;
			foreach ($data as $key => $value) {
				$results['timesheet'][$i]['emp_id'] = $value['id'];
				$results['timesheet'][$i]['login_date'] = date('Y-m-d', strtotime($value['login_date']));
				$results['timesheet'][$i]['start_time'] = date('H:i', strtotime($value['start_time']));
				$results['timesheet'][$i]['end_time'] = date('H:i', strtotime($value['end_time']));
				$results['timesheet'][$i]['regular_hours'] = $regular_hours = date("H:i",strtotime($value['regular_hours']));
				$overtime_hours= date("H:i",strtotime($value['overtime_hours']));

				$current_time = new DateTime();
				$s_time = new DateTime($value['start_time']);
				              		
				$total_hours = "";
				if($value['end_time'] == 0)
				{
					$interval = $current_time->diff($s_time);
					$total_hours = $interval->format('%H:%I');	
				}
				else
				{
				    $e_time = new DateTime($value['end_time']);
				    $interval = $e_time->diff($s_time);

				    $total_hours = $interval->format('%H:%I');
				}
				              		
				$time1 = new DateTime($total_hours);
				$time2 = new DateTime($regular_hours);
									

				if($time1 > $time2){

					$interval = $time1->diff($time2);
					$overtime_hours =  $interval->format('%H:%I');
				}

				$results['timesheet'][$i]['overtime_hours']  = $overtime_hours;
				$results['timesheet'][$i]['total_hours'] = $total_hours;
				$i++;
			}
			$results['user_project'] = $user_project;
			echo json_encode(['code'=>200, "message"=>'', 'data'=>$results]);
			die();
		}
		
		echo json_encode(['code'=>401, "message"=>'Data not found.', 'data'=>$data]);
		die();
	}

	
}

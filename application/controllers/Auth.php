<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
	}

	public function login()
	{

		$data['emp'] = $this->employees->allEmployee();

		$this->load->view('login',$data);
	}

	public function logout()
	{
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$emp_id = $this->input->get('emp_id');
			$password = $this->input->get('password');
			if(!$emp_id)
					{
						echo json_encode(['code'=>401, "message"=>'Employee id is required']);
						die();
					}
			if(!$password)
					{
						echo json_encode(['code'=>401, "message"=>'Password id is required']);
						die();
					
					}

			if($this->employees->login($emp_id, $password))
				{
					if($login_date = $this->employees->checkLogout($emp_id)){
					echo json_encode(['code'=>400, "message"=>'You are already logged Out']);
					die();
					}

					$this->timesheet->timeSheetDataUpdate($emp_id);
					
					$this->lib_user->logout();

					echo json_encode(['code'=>200, "message"=>'You have to logged out successfully!']);
					die();
				}
				else
				{
					echo json_encode(['code'=>401, "message"=>'You are already logged Out']);
					die();
				}

			
		}else
			{
				echo json_encode(['code'=>401, "message"=>'Method not allowed']);
				die();
			}

	}


	public function checkLogout()
	{
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$emp_id = $this->input->get('emp_id');
			$password = $this->input->get('password');
			if(!$emp_id)
					{
						echo json_encode(['code'=>401, "message"=>'Employee id is required']);
						die();
					}
			if(!$password)
					{
						echo json_encode(['code'=>401, "message"=>'Password id is required']);
						die();
					
					}

			if($emp = $this->employees->login($emp_id, $password))
				{
					if($login_date = $this->employees->checkLogout($emp_id))
					{
						echo json_encode(['code'=>200, "message"=>'You are already logged Out']);
						die();
					}
					else
					{
						if($login_data = $this->employees->getTodayLogindata($emp_id))
						{
							$emp->logged_in_time = $login_data->login_date;
						}
						else{
							$emp->logged_in_time = $login_data;
						}
						
						echo json_encode(['code'=>400, "message"=>'You are not logged Out',"data" => $emp]);
						die();

					}

			}
			else
			{
				echo json_encode(['code'=>401, "message"=>'Employee id and password does not match!']);
				die();
			}
		}
		else
		{
			echo json_encode(['code'=>401, "message"=>'Method not allowed']);
				die();
		}

	}

	public function postlogin()
	{
			
		
			if($this->input->server('REQUEST_METHOD') == 'POST'){
					$emp_id = $this->input->get('emp_id');
					$password = $this->input->get('password');

					if(!$emp_id)
					{
						echo json_encode(['code'=>401, "message"=>'Employee id is required']);
						die();
					}

					if(!$password)
					{
						echo json_encode(['code'=>401, "message"=>'Password id is required']);
						die();
					
					}

					if($emp = $this->employees->login($emp_id, $password))
					{
						if($re = $this->employees->checkLogin($emp_id)){
							$emp->logged_in_time = $re->start_time;
							if($re->end_time == 0){
								$emp->logged_out_time = 0;
							}
							else
							{
								$emp->logged_out_time = 1;	
							}
							echo json_encode(['code'=>400, "message"=>'You are already logged in', 'data'=>$emp]);
							die();
						}	
							
						echo json_encode(['code'=>200, "message"=>'', 'data'=>$emp]);
						die();
					 
					}
					else{
						echo json_encode(['code'=> 401, "message" => 'Employee id and password does not match']);
						die();
			
					}
		
		
			}else
			{
				echo json_encode(['code'=>401, "message"=>'Method not allowed']);
				die();
			}
		

		

	}

	public function timestart()
	{
		$emp_id = $this->input->get('emp_id');
		if(!$emp_id)
		{
			echo json_encode(['code'=>401, "message"=>'Employee id is required']);
			die();
		}
		$start_time = date('Y-m-d H:i:s');
		$timesheet_data = [

				'emp_id' 			=> $emp_id,
				'start_time' 		=> $start_time,
				'end_time' 			=> '0'
								
			];

		$this->timesheet->timeSheetData($timesheet_data);
		$data['logged_in_time'] = $start_time;
		echo json_encode(['code'=>200, "message"=>'', 'data'=>$data]);
		die();
	}

}

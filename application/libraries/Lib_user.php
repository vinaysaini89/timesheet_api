<?php
/*
Lib_user is library containing all the functions related to user accounts
*/
class Lib_user{
	private $employee_id 		= 0;
	private $first_name			= '';
	private $last_name			= '';
	private $dob				= '';
	private $doj				= '';
	private $mobile_no			= '';
	private $personal_email		= '';
	private $professional_email	= '';
	private $user_type  		= 0;
	private $current_path 		= '';
	public $data				= array();
	/*
	@Initialization of user session and checking user permissions.@
	*/
	public function __construct(){
		$this->ci =  get_instance();

		if( $this->ci->session->userdata('auth') ){
			$auth = $this->ci->session->userdata('auth');
			$this->employee_id 		= $auth['id'];
			$this->first_name 		= $auth['first_name'];
			$this->last_name 		= $auth['last_name'];
			$this->dob 				= $auth['dob'];
			$this->doj 				= $auth['doj'];
			$this->personal_email 	= $auth['personal_email'];
			$this->professional_email = $auth['professional_email'];
			//$this->mobile_no 		= $auth['mobile_no'];
		}
		
		
		$this->ci->load->helper('url');
		

	}
	
	
	
	/*
	@get current logged in user id.@
	*/
	public function isLoggedIn(){
		return $this->employee_id;
	}

	public function getUserData(){
		$data = [
					'employee_id' 		=> $this->employee_id,
					'first_name'  		=> $this->first_name,
					'last_name' 		=> $this->last_name,
					'dob' 				=> $this->dob,
					'doj' 				=> $this->doj,
					'personal_email' 	=> $this->personal_email,
					'professional_email' => $this->professional_email
					
				];
		return $data;		
	}
	
	public function fullName(){
		return $this->first_name." ".$this->last_name;		
	}

	public function logout(){
		
		$this->ci->session->unset_userdata('auth');
		$this->ci->session->sess_destroy();
		return true;
		//redirect('login');	
	}
}

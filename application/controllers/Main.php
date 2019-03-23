<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	 function __construct(){
        parent::__construct();
    }

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
	public function index()
	{
		$this->load->view('login_view.php');
	}

	function login_validation(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run()){

			$username=$this->input->post('username');
			$password=$this->input->post('password');
			$desig_name="";
			$dept_name="";
			$employeeId="";
			$desigId ="";
			$deptId = "";
			$emp_name="";
			$empId="";


			$this->load->model('login_model');

			if($this->login_model->can_login($username,$password)){

				 $data['employees'] = $this->login_model->get_user($username,$password);

				 $this->load->model('designation_model');
				  $this->load->model('department_model');



				 foreach ($data['employees']  as $employee) {

				  	$employeeId= $employee->e_id;
				  	$empId= $employee->emp_id;
				  	$desigId = $employee->designation;
				  	$deptId = $employee->department;
				  	$emp_name = $employee->emp_name;
				  	$emp_image = $employee->image;

				  	

				  	 $data['designations'] = $this->designation_model->get_designation($desigId);
				  	 $data['departments'] = $this->department_model->get_department($deptId);

				  	 foreach ($data['designations']  as $designation) {

				  	 		$desig_name = $designation->desig_name;
				  	 }

				  	 foreach ($data['departments']  as $department) {

				  	 		$dept_name = $department->dept_name;
				  	 }
				  	
				  }


				  $session_data = array('employeeId' => $employeeId,'empId' => $empId, 'empname' => $emp_name,'desigId' => $desigId,'desig_name' => $desig_name,'deptId' => $deptId,'dept_name' => $dept_name,'image'	=> $emp_image);

				  $this->session->set_userdata($session_data);

				 
				  if ($username=="admin") {
				  	
				  		redirect(base_url().'admin');
				  	
				  }else{

				  	redirect(base_url().'employee_home');

				  }
				

			}else{
				$this->session->set_flashdata('error','Invalid Username and Password');
				redirect(base_url());
			}


		}else{
			$this->index();
		}
	}
}
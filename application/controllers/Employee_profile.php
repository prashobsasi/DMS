<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_profile extends CI_Controller {

	
	public function index()
	{
		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_all_employee();

		$this->load->model('department_model');
		$data['departments'] = $this->department_model->get_all_department();

		$this->load->model('designation_model');
		$data['designations'] = $this->designation_model->get_all_designation();


		$this->load->view('employee_profile',$data);
	}

	public function curPasswordCheck(){

		$id = $this->input->post('id');
		$currentPassword = $this->input->post('current');
		$status="";
			
		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		foreach ($data['employees'] as $employee) {

			if($employee->password==$currentPassword){
				$status=true;
			}else{
				$status=false;
			}

		}

			echo json_encode($status);
	}

	public function changePassword(){
		$id = $this->input->post('id');
		$newPassword = $this->input->post('password');

		$emp_id="";

        $this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		$status = $this->employee_model->update_password($id,$newPassword);

		echo json_encode($status);
	}
}

?>
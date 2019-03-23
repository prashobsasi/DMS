<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	
	public function index()
	{
		
		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_all_employee();

		$this->load->model('department_model');
		$data['departments'] = $this->department_model->get_all_department();

		$this->load->model('designation_model');
		$data['designations'] = $this->designation_model->get_all_designation();

		$this->load->view('employee_view',$data);
	}

	public function view(){

		$id = $this->input->post('id');
		$employee_data ="";
		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		foreach ($data['employees'] as $employee) {

			$dept_name="";
			$desig_name="";

			$this->load->model('department_model');
			$data['departments'] = $this->department_model->get_department($employee->department);

			foreach ($data['departments'] as $department) {

				$dept_name=$department->dept_name;
				
			}


			$this->load->model('designation_model');
			$data['designation'] = $this->designation_model->get_designation($employee->designation);

			foreach ($data['designation'] as $designation) {

					$desig_name=$designation->desig_name;
			}

			$employee_data = array('employeeId' => $employee->emp_id, 'empname' => $employee->emp_name,'email' => $employee->email,'uname' => $employee->username,'dob' => $employee->dob,'doj' => $employee->doj,'phone' => $employee->phone,'address' => $employee->address,'department' => $dept_name,'designation' => $desig_name,'image' => base64_encode($employee->image));

		}

		echo json_encode($employee_data);

	}

	public function insert()
	{
		
		$empId = $this->input->post('employeeId');
        $empname = $this->input->post('empname');
        $dob = $this->input->post('dob');
        $doj = $this->input->post('doj');
        $department = $this->input->post('department');
        $designation = $this->input->post('designation');
        $base64String = $this->input->post('image');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

      	$image=base64_decode($base64String);
      	
        $employee_data = array('emp_id' => $empId, 'emp_name' => $empname,'dob' => $dob,'doj' => $doj,'department' => $department,'designation' => $designation,'image' => $image,'phone' => $phone,'address' => $address,'email' => $email,'username' => $username,'password' => $password);
        
        $this->load->model('employee_model');
		$status = $this->employee_model->insert_employee($employee_data);

		$status = $this->employee_model->insert_employee_privilege($empId);

		$e_data="";

		if ($status==true) {

			$data['employees'] = $this->employee_model->get_all_employee();

			foreach ($data['employees']  as $employee) {

				  	 		if($employee->emp_id==$empId){
				  	 			$e_data=array('e_Id'=>$employee->e_id,'employeeId' => $employee->emp_id, 'empname' => $employee->emp_name,'email' => $employee->email);
				  	 			
				  	 		}
				  	 }

				$to= $email;
 				$subject = "DMS Login Details -VAS";
 				$from = "dms@vidyaacademy.ac.in";
 				$nick = "DMS | VAS";
 				$body="<html><body>Dear " .$empname. ",<br> Your username and password for logging to DMS is given below<br><br> Username: ".$username. "<br> Password: ".$password. "</body></html>";
				$headers = "From: " . $nick . "<" . $from . "> \n";
				$headers .= "Return-Path: " . $nick . "<" . $from . "> \n";
				$headers .= "Reply-To: " . $nick . "<" . $from . "> \n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				//$headers .= "X-Priority: 1\r\n";
				$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
				//mail($to, $subject, $body, $headers,"-f".$from);
				mail($to, $subject, $body, $headers,"-f".$from);




				  	 echo json_encode($e_data);
				  	
			
		}else{
			echo json_encode($status);
		}
	}

	public function edit(){

		$id = $this->input->post('id');
		$employee_data ="";
		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		foreach ($data['employees'] as $employee) {

			$employee_data = array('employeeId' => $employee->emp_id, 'empname' => $employee->emp_name,'email' => $employee->email,'uname' => $employee->username,'dob' => $employee->dob,'doj' => $employee->doj,'phone' => $employee->phone,'address' => $employee->address,'department' => $employee->department,'designation' => $employee->designation,'image' => base64_encode($employee->image),'password' => $employee->password);

		}

		echo json_encode($employee_data);

	} 

	public function update()
	{
		
		$id = $this->input->post('id');
		$phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $email = $this->input->post('email');

    	
        
        $this->load->model('employee_model');
		$data = $this->employee_model->update_employee($id,$phone,$address,$email);

		echo json_encode($data);

	}

	public function delete()
	{
		
		$id = $this->input->post('id');

        $this->load->model('employee_model');
		$data = $this->employee_model->delete_employee($id);

		echo json_encode($data);

	}

	public function filterEmployee(){


		$departmentId = $this->input->post('departmentId');
		$designationId = $this->input->post('designationId');

		$this->load->model('employee_model');
		$data =array();
		$e_data=array();

		if ($departmentId == -1 && $designationId == -1) {
			$data['employees'] =  $this->employee_model->get_all_employee();
		} else {
			if ($departmentId != -1 && $designationId == -1) {
				$data['employees'] =  $this->employee_model->get_all_employee_by_department($departmentId);
			} else if ($departmentId == -1 && $designationId != -1) {
				$data['employees'] =  $this->employee_model->get_all_employee_by_designation($designationId);
			} else {
				$data['employees'] = $this->employee_model->get_all_employee_by_department_and_designation($departmentId,$designationId);
			}

		}


		foreach ($data['employees']  as $employee) {

				if($employee->emp_name!='admin'){
					$e_data[]=array('e_Id'=>$employee->e_id,'employeeId' => $employee->emp_id, 'empname' => $employee->emp_name,'email' => $employee->email); 	
				}	
			}
				  	 

		echo json_encode($e_data);
	}


	public function savePrivilege()
	{
		
		$id = $this->input->post('id');
		$principal = $this->input->post('principal');
        $hod = $this->input->post('hod');
        $directors = $this->input->post('directors');
        $reception = $this->input->post('reception');
        $associative_professor = $this->input->post('associative_professor');
        $assistant_professor = $this->input->post('assistant_professor');
        $officestaff = $this->input->post('officestaff');
        $trade_instructor = $this->input->post('trade_instructor');

        
        $emp_id="";

        $this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		foreach ($data['employees'] as $employee) {

			if($id==$employee->e_id){
				 $emp_id=$employee->emp_id;
			}
		}

		$privilege=array('principal' =>$principal , 'hod' =>$hod,'directors' =>$directors,'reception' =>$reception,'associative_professor' =>$associative_professor,'assistant_professor' =>$assistant_professor,'office_staff' =>$officestaff,'trade_instructor' =>$trade_instructor);
        
		$status = $this->employee_model->update_privilege($emp_id,$privilege);

		
		echo json_encode($status);
				  	
	}


	public function editPrivilege(){

		$id = $this->input->post('id');

		$emp_id="";

		$emp_pri_data=array();

        $this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_employee($id);

		foreach ($data['employees'] as $employee) {

			if($id==$employee->e_id){
				 $emp_id=$employee->emp_id;
			}
		}

		$data['priveleges'] = $this->employee_model->get_employee_privelege($emp_id);

		foreach ($data['priveleges'] as $privelege) {
        					
			$emp_pri_data = array('eid'=>$emp_id,'principal' => $privelege->principal, 'hod' => $privelege->hod,'directors' => $privelege->directors,'reception' => $privelege->reception,'associative_professor' => $privelege->associative_professor,'assistant_professor' => $privelege->assistant_professor,'officestaff' => $privelege->office_staff,'trade_instructor' =>  $privelege->trade_instructor);

		}

		echo json_encode($emp_pri_data);


	} 

	function chekEmployeeId(){

		$empId = $this->input->post('id');

		$this->load->model('employee_model');

		$data['employees']=$this->employee_model->find_employee_id($empId);

		if(sizeof($data['employees'])!=0){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}

		
	}

	function chekEmployeePhone(){

		$phone = $this->input->post('phone');

		$this->load->model('employee_model');

		$data['employees']=$this->employee_model->find_employee_phone($phone);

		if(sizeof($data['employees'])!=0){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}

		
	}

	function chekEmployeeEmail(){

		$email = $this->input->post('email');

		$this->load->model('employee_model');

		$data['employees']=$this->employee_model->find_employee_email($email);

		if(sizeof($data['employees'])!=0){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}

		
	}

	function chekEmployeeUsername(){

		$username = $this->input->post('username');

		$this->load->model('employee_model');

		$data['employees']=$this->employee_model->find_employee_username($username);

		if(sizeof($data['employees'])!=0){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}

		
	}


}

?>
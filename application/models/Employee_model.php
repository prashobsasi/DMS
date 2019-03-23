<?php


class Employee_model extends CI_Model {

	

	function get_employee($empId){

		

		$this->db->where('e_id',$empId);

		$query = $this->db->get('employee');

		
			
		return $query->result();
		
	}

	function get_employee_name($empId){

		

		$this->db->where('emp_id',$empId);

		$query = $this->db->get('employee');
			
		return $query->result();
		
	}

	function get_employee_by_dept_and_desig($empCheck){

		

		$this->db->where($empCheck);

		$query = $this->db->get('employee');
			
		return $query->result();
		
	}

	function get_employee_by_desig($empCheck){

		

		$this->db->where($empCheck);

		$query = $this->db->get('employee');
			
		return $query->result();
		
	}

	function get_all_employee(){

		
		$this->db->where('is_deleted',0);

		$query = $this->db->get('employee');

		return $query->result();
		
	}

	function insert_employee($employee_data){


    	$this->db->insert('employee',$employee_data);


		return true;
		
		
	}

	function get_all_privileges(){

		
		

		$query = $this->db->get('privileges');

		return $query->result();
		
	}


	function insert_employee_privilege($empId){


    	$this->db->insert('privileges',array('emp_Id' => $empId));


		return true;
		
		
	}

	function update_employee($id,$phone,$address,$email){

		$this->db->where('e_id',$id);
		$this->db->update('employee', array('phone' => $phone,'address' => $address,'email' => $email));

		return true;

	}

	function delete_employee($id){

		$this->db->where('e_id',$id);
		$this->db->update('employee', array('is_deleted' => 1));

		return true;

	}

	function get_all_employee_by_department($departmentId){

		$array = array('department' => $departmentId, 'is_deleted' => 0);

		
		$this->db->where($array);


		$query = $this->db->get('employee');

		return $query->result();
		
	}

	function get_all_employee_by_designation($designationId){

		$array = array('designation' => $designationId, 'is_deleted' => 0);

		
		$this->db->where($array);


		$query = $this->db->get('employee');

		return $query->result();
		
	}

	function get_all_employee_by_department_and_designation($departmentId,$designationId){

		$array = array('department' => $departmentId,'designation' => $designationId, 'is_deleted' => 0);

		
		$this->db->where($array);


		$query = $this->db->get('employee');

		return $query->result();
		
	}

	function update_privilege($emp_id,$privilege){

		$this->db->where('emp_Id',$emp_id);
		$this->db->update('privileges',$privilege);

		return true;

	}

	function update_password($emp_id,$password){

		$this->db->where('e_id',$emp_id);
		$this->db->update('employee',array('password' =>$password ));

		return true;

	}

	
	function get_employee_privelege($emp_id){

		

		$this->db->where('emp_Id',$emp_id);

		$query = $this->db->get('privileges');

		
			
		return $query->result();
		
	}


	function find_employee_id($empId){

		$this->db->where('emp_id',$empId);
		$query = $this->db->get('employee');
		return $query->result();
		
	}

	function find_employee_phone($phone){

		$this->db->where('phone',$phone);
		$query = $this->db->get('employee');
		return $query->result();
		
	}

	function find_employee_email($email){

		$this->db->where('email',$email);
		$query = $this->db->get('employee');
		return $query->result();
		
	}

	function find_employee_username($username){

		$this->db->where('username',$username);
		$query = $this->db->get('employee');
		return $query->result();
		
	}



}

?>
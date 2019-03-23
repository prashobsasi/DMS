<?php


class Department_model extends CI_Model {

	

	function get_department($deptId){

		

		$this->db->where('dept_id',$deptId);

		$query = $this->db->get('department');

		
			
		return $query->result();
		
	}

	function get_all_department(){

		
		$this->db->where('is_deleted',0);

		$query = $this->db->get('department');

		return $query->result();
		
	}

	function insert_department($name){

		
		$dept = array(
        				'dept_name'=>$name,
        				'is_deleted'=>0
   		 			);

    	$this->db->insert('department',$dept);


		return true;
		
		
	}

	function update_department($id,$name){

		$this->db->where('dept_Id',$id);
		$this->db->update('department', array('dept_name' => $name));

		return true;

	}

	function delete_department($id){

		$this->db->where('dept_Id',$id);
		$this->db->update('department', array('is_deleted' => 1));

		return true;

	}

}

?>
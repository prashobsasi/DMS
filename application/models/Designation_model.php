<?php


class Designation_model extends CI_Model {

	

	function get_designation($desigId){

		

		$this->db->where('desig_id',$desigId);

		$query = $this->db->get('designation');

		
			
		return $query->result();
		
	}

	function get_designation_by_name($forId){

		

		$this->db->where('desig_name',$forId);

		$query = $this->db->get('designation');

		return $query->result();
		
	}

	

	function get_all_designation(){

		
		$this->db->where('is_deleted',0);

		$query = $this->db->get('designation');

		return $query->result();
		
	}

	function insert_designation($name){

		
		$dept = array(
        				'desig_name'=>$name,
        				'is_deleted'=>0
   		 			);

    	$this->db->insert('designation',$dept);


		return true;
		
		
	}

	function update_designation($id,$name){

		$this->db->where('desig_id',$id);
		$this->db->update('designation', array('desig_name' => $name));

		return true;

	}

	function delete_designation($id){

		$this->db->where('desig_id',$id);
		$this->db->update('designation', array('is_deleted' => 1));

		return true;

	}


}

?>
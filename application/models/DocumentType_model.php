<?php


class DocumentType_model extends CI_Model {

	

	function get_documentType($documentType_Id){

		

		$this->db->where('id',$documentType_Id);

		$query = $this->db->get('doc_type');

		
			
		return $query->result();
		
	}

	function get_all_documentType(){

		
		$this->db->where('is_deleted',0);

		$query = $this->db->get('doc_type');

		return $query->result();
		
	}

	function insert_documentType($name,$keyword){

		
		$docType = array(
        				'name'=>$name,
        				'keyword'=>$keyword,
        				'is_deleted'=>0
   		 			);

    	$this->db->insert('doc_type',$docType);


		return true;
		
		
	}

	function update_documentType($id,$name,$keyword){

		$this->db->where('id',$id);
		$this->db->update('doc_type', array('name' => $name,'keyword'=>$keyword));

		return true;

	}

	function delete_documentType($id){

		$this->db->where('id',$id);
		$this->db->update('doc_type', array('is_deleted' => 1));

		return true;

	}

}

?>
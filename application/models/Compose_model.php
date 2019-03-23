<?php


class Compose_model extends CI_Model {

	function insert_document($document){

    	$this->db->insert('document',$document);
		return $this->db->insert_id();
	}

	function insert_doc_remark($doc_remarks){

    	$this->db->insert('doc_remarks',$doc_remarks);
		return true;
	}

	function get_all_documents_of_employee($empId){

		
			$this->db->from("doc_remarks");
			$this->db->where('from_Id',$empId);
		 	$this->db->order_by('time_stamp', 'desc');
    		$query = $this->db->get();
			
		return $query->result();

		/*$this->db->where('from_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');

		
			
		return $query->result();*/
	}

	function get_doc_remark_by_id($r_id){

		
			$this->db->from("doc_remarks");
			$this->db->where('r_Id',$r_id);
    		$query = $this->db->get();
			
		return $query->result();
	}

	function get_all_documents_of_employee_outbox($empId){

		
			$this->db->from("doc_remarks");

			$condition=array('from_Id' =>$empId ,'f_status' =>1);
			$this->db->where($condition);
		 	$this->db->order_by('time_stamp', 'desc');
    		$query = $this->db->get();
			
		return $query->result();

		/*$this->db->where('from_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');

		
			
		return $query->result();*/
	}

		function get_all_documents_of_employee_drafts($empId){

		
			$this->db->from("doc_remarks");

			$condition=array('from_Id' =>$empId ,'f_status' =>0);
			$this->db->where($condition);
		 	$this->db->order_by('time_stamp', 'desc');
    		$query = $this->db->get();
			
		return $query->result();

		/*$this->db->where('from_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');

		
			
		return $query->result();*/
	}

		function get_all_documents(){

		
			$this->db->from("doc_remarks");
		 	$this->db->order_by('time_stamp', 'desc');
    		$query = $this->db->get();
			
		return $query->result();

		/*$this->db->where('from_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');

		
			
		return $query->result();*/
	}

	function getDocumentByDocType($docTypeId,$empId){

		$this->db->from("document");

		$where = array('doc_type'=> $docTypeId, 'doc_owner'=>$empId);
		$this->db->where($where);
    	$query = $this->db->get();
			
		return $query->result();

	}

	function get_all_documents_of_employee_in($empId){

		
/*
		$this->db->where('to_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');*/

		$this->db->from("doc_remarks");
		$condition=array('to_Id'=>$empId,'f_status'=>1);
		$this->db->where($condition);
		 $this->db->order_by('time_stamp', 'desc');
    	$query = $this->db->get();
			
		return $query->result();
		
	}


	function get__document_name($docId){

		

		$this->db->where('doc_Id',$docId);

		$query = $this->db->get('document');

		
			
		return $query->result();
		
	}

	function update__remark_status($r_id){
		$status=array('status'=>"1");
            $this->db->where('r_Id',$r_id);
            $this->db->update('doc_remarks',$status);
	}
			
	
}

?>
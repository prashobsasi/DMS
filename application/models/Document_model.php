<?php


class Document_model extends CI_Model {

	function insert_document($document){

    	$this->db->insert('document',$document);
		return $this->db->insert_id();
	}

	function insert_doc_remark($doc_remarks){

    	$this->db->insert('doc_remarks',$doc_remarks);
		return true;
	}

	function get_document_count($documentType_Id){
		$this->db->from("document");
		$this->db->where('doc_type',$documentType_Id);
		$query = $this->db->get();

		return $query->num_rows();
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

	function getDocumentByDocTypeAndDocUrlAndDocOwner($docTypeId,$docUrl,$empId){
			$this->db->from("document");
			$condition=array('doc_type' => $docTypeId,'doc_Url' => $docUrl,'doc_owner' => $empId);
			$this->db->where($condition);
    		$query = $this->db->get();
    		return $query->result();
	}

	function get_documents_of_employee($empId){

		
			$this->db->from("document");
			$this->db->where('doc_owner',$empId);
		 	$this->db->order_by('created_date', 'DESC');
    		$query = $this->db->get();
			
		return $query->result();

		/*$this->db->where('from_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');

		
			
		return $query->result();*/
		
	}

	function get_all_documents_of_employee_in($empId){

		
/*
		$this->db->where('to_Id',$empId);
		//$this->db->order_by('time_stamp', 'asc');
		$query = $this->db->get('doc_remarks');*/

		$this->db->from("doc_remarks");
		$this->db->where('to_Id',$empId);
		 $this->db->order_by('time_stamp', 'desc');
    	$query = $this->db->get();
			
		return $query->result();
		
	}


	function get__document_name($docId){

		

		$this->db->where('doc_Id',$docId);

		$query = $this->db->get('document');

		
			
		return $query->result();
		
	}


	function get__document_by_Id($docId){

		

		$this->db->where('doc_Id',$docId);

		$query = $this->db->get('document');

		
			
		return $query->result();
		
	}

	function update__remark_status($r_id){
		$status=array('status'=>"1");
            $this->db->where('r_Id',$r_id);
            $this->db->update('doc_remarks',$status);
	}

	function get_all_documents(){

		
		$this->db->from("doc_remarks");
	 	$this->db->order_by('time_stamp', 'desc');
		$query = $this->db->get();
			
		return $query->result();

		
	}

	function get_all_documents_by_date($date){

		$this->db->where('sub_date',$date);
		$this->db->order_by('time_stamp', 'desc');
		$query = $this->db->get('doc_remarks');
	
		return $query->result();
		
	}

	function get_all_documents_by_date_between($startDate,$endDate){

		$this->db->where('sub_date >=', $startDate);
		$this->db->where('sub_date <=', $endDate);
		$this->db->order_by('time_stamp', 'desc');
		$query = $this->db->get('doc_remarks');
			
		return $query->result();
		
	}



			
	
}

?>
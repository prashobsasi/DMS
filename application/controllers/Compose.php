<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compose extends CI_Controller {

	
	public function index()
	{
		
		$this->load->model('documentType_model');
		$data['doc_types'] = $this->documentType_model->get_all_documentType();

		$this->load->model('employee_model');
		$data['employees'] = $this->employee_model->get_all_employee();
		$privelege['privileges']= $this->employee_model->get_all_privileges();

		$this->load->model('department_model');
		$data['departments'] = $this->department_model->get_all_department();

		$this->load->model('designation_model');
		$data['designations'] = $this->designation_model->get_all_designation();

			foreach ($privelege['privileges'] as $pri) {

				if($pri->emp_Id==$this->session->userdata('empId')) {
					$data['privileges'] = $this->employee_model->get_employee_privelege($pri->emp_Id);
				}	
			}

		$this->load->view('compose',$data);
	}

	public function forward(){

        $forId =$this->input->post('forIds');

        //print_r($forIds);

       $forIds = explode(",", $forId);

		$config = array(
		'upload_path' => "./uploads/docs/",
		'encrypt_name'=> TRUE,
		'allowed_types' => "gif|jpg|png|jpeg|pdf",
		// 'overwrite' => TRUE,
		// 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
		// 'max_height' => "768",
		// 'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if($this->upload->do_upload('file'))
		{
			$data = array('upload_data' => $this->upload->data());

		}
		else
		{
			$data = array('error' => $this->upload->display_errors());
		}

		$doc_Url =$data['upload_data']['file_name'];
		$file_name =$this->input->post('filename');
       	
       	$document = array('doc_Url' => $doc_Url, 'doc' =>$file_name);
        $this->load->model('compose_model');
		$doc_id = $this->compose_model->insert_document($document);


		foreach ($forIds as $forIdSingle) {
			
			$sub_date=date("Y/m/d");
			$fromId = $this->input->post('fromId');
	        // $forId = $this->input->post('forId');
	        $remarks = $this->input->post('remarks');
	        if($doc_id!=0){
	        	$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $forIdSingle,'status'=>0,'f_status' => 1,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}

			//var_dump($doc_id);exit();
/*			if($doc_id!=0){

				$sub_date=date("Y/m/d");
				$to_Id="";

				$desig_Id="";
				$dept_Id = $this->session->userdata('deptId');

				if ($forIdSingle=='Principal'||$forIdSingle=='HOD') {
					# code...
				
					$this->load->model('designation_model');
					$data['designations'] = $this->designation_model->get_designation_by_name($forIdSingle);

					foreach ($data['designations']  as $designation) {

						 $desig_Id = $designation->desig_id;
					}

					if($forIdSingle!='Principal')

					{

						$empCheck = array('designation' => $desig_Id,'department' => $dept_Id);
						$this->load->model('employee_model');
						$data['employees'] = $this->employee_model->get_employee_by_dept_and_desig($empCheck);

					}else{
						$empCheck1 = array('designation' => $desig_Id);
						$this->load->model('employee_model');
						$data['employees'] = $this->employee_model->get_employee_by_desig($empCheck1);
					}

					foreach ($data['employees']  as $employee) {

					 $to_Id = $employee->emp_id;
					}
				}else{
					$to_Id = $forIdSingle;
				}

	        }
	        $doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $to_Id,'f_status' => 1,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);*/

	    }

	    if($status==true){
					echo json_encode("File Forwarded");
			}else{
				echo json_encode($doc_id);
			}
	}

	
	
	public function getDocumentByDocType(){
		
		$docTypeId = $this->input->post('id');
		$emp_Id=$this->session->userdata('empId');
		
		$this->load->model('compose_model');
		$data['documents'] = $this->compose_model->getDocumentByDocType($docTypeId,$emp_Id);

		echo json_encode($data);
	}



	public function getDocument(){
		$id = $this->input->post('id');
		$r_id= $this->input->post('r_Id');
		$doc_url="";
		$this->load->model('compose_model');
		$data['documents'] = $this->compose_model->get__document_name($id);
			foreach ($data['documents']  as $document) {
					$doc_url=$document->doc_Url;
			}
		$pdf=base64_encode($doc_url);

		$this->compose_model->update__remark_status($r_id);

		echo json_encode($doc_url);
	}

	public function forwardInbox(){

		$docId = $this->input->post('docId');
		$from_Id = $this->input->post('fromId');
		$forId =$this->input->post('forIds');

       	$forIds = explode(",", $forId);

		$remarks = $this->input->post('remarks');
		$doc_url="";
		$doc_name="";
		$fromId="";

		$this->load->model('employee_model');

		$data['employees'] = $this->employee_model->get_employee($from_Id);

		foreach ($data['employees'] as $employee) {
			$fromId= $employee->emp_id; 
		}

		
		$this->load->model('compose_model');
		$data['documents'] = $this->compose_model->get__document_name($docId);
			foreach ($data['documents']  as $document) {
					$doc_url=$document->doc_Url;
					$doc_name=$document->doc;
			}
       $document = array('doc_Url' => $doc_url, 'doc' =>$doc_name);

        $this->load->model('compose_model');
		$doc_id = $this->compose_model->insert_document($document);


		foreach ($forIds as $forIdSingle) {

			if($doc_id!=0){
				$sub_date=date("Y/m/d");
	        	$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $forIdSingle,'status'=>0,'f_status' => 1,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}
			
			/*if($doc_id!=0){
			//var_dump($doc_id);exit();
							$sub_date=date("Y/m/d");
				$to_Id="";

				$desig_Id="";
				$dept_Id = $this->session->userdata('deptId');

				if ($forIdSingle=='Principal'||$forIdSingle=='HOD') {
					# code...
				
					$this->load->model('designation_model');
					$data['designations'] = $this->designation_model->get_designation_by_name($forIdSingle);

					foreach ($data['designations']  as $designation) {

						 $desig_Id = $designation->desig_id;
					}

					if($forIdSingle!='Principal')

					{

						$empCheck = array('designation' => $desig_Id,'department' => $dept_Id);
						$this->load->model('employee_model');
						$data['employees1'] = $this->employee_model->get_employee_by_dept_and_desig($empCheck);

					}else{
						$empCheck1 = array('designation' => $desig_Id);
						$this->load->model('employee_model');
						$data['employees1'] = $this->employee_model->get_employee_by_desig($empCheck1);
					}

					foreach ($data['employees1']  as $employee) {

					 $to_Id = $employee->emp_id;
					}
				}else{
					$to_Id = $forIdSingle;
				}

				$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $to_Id,'f_status' => 1,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}
*/
	        
	    }

	    if($status==true){
					echo json_encode("File Forwarded");
		}
	}



	public function forwardTo(){

        $forIds =$this->input->post('forIds');
       /*	$forIds = explode(",", $forId);*/

       	$remarks=$this->input->post('remarks');

       	$docTypeId=$this->input->post('docTypeId');
       	$docUrl=$this->input->post('documentId');
       	
       	$sub_date=date("Y/m/d");
		$fromId = $this->input->post('fromId');
		$doc_id=0;

		$this->load->model('document_model');
		$data['documents'] = $this->document_model->getDocumentByDocTypeAndDocUrlAndDocOwner($docTypeId,$docUrl,$fromId);
			foreach ($data['documents']  as $document) {
					$doc_id=$document->doc_Id;
			}

		/*foreach ($forIds as $forIdSingle) {
			*/
	        if($doc_id!=0){
	        	$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $forIds,'status'=>0,'f_status' => 1,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}

	/*    }*/

	    if($status==true){
					echo json_encode("File Forwarded");
			}else{
				echo json_encode($doc_id);
			}
	}

	public function saveTo(){

        $forIds =$this->input->post('forIds');
       	/*$forIds = explode(",", $forId);*/

       	$remarks=$this->input->post('remarks');

       	$docTypeId=$this->input->post('docTypeId');
       	$docUrl=$this->input->post('documentId');
       	
       	$sub_date=date("Y/m/d");
		$fromId = $this->input->post('fromId');
		$doc_id=0;

		$this->load->model('document_model');
		$data['documents'] = $this->document_model->getDocumentByDocTypeAndDocUrlAndDocOwner($docTypeId,$docUrl,$fromId);
			foreach ($data['documents']  as $document) {
					$doc_id=$document->doc_Id;
			}

		/*foreach ($forIds as $forIdSingle) {*/
			
	        if($doc_id!=0){
	        	$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $forIds,'status'=>0,'f_status' => 0,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}

	   /* }*/

	    if($status==true){
					echo json_encode("File Saved to Drafts");
			}else{
				echo json_encode($doc_id);
			}
	}

}
?>
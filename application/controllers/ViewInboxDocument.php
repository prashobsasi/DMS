<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewInboxDocument extends CI_Controller {

	
	public function index()
	{

		 $r_id = $_GET["r_id"];

		$this->load->model('compose_model');
		$this->compose_model->update__remark_status($r_id);

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

		$docRemarkObject=$this->compose_model->get_doc_remark_by_id($r_id);
		$empName="";
		$docRemark=get_object_vars($docRemarkObject[0]);
		$remarks=$docRemark['remark'];
		$docId=$docRemark['doc_Id'];

		foreach ($data['employees'] as $emp) {

				if($emp->emp_id==$docRemark['from_Id']) {
					$empName=$emp->emp_name;
				}	
		}

		$doc['documents'] = $this->compose_model->get__document_name($docId);

		$doc_url="";

		foreach ($doc['documents']  as $document) {
			$doc_url=$document->doc_Url;
		}
		
		$data['viewDocument'] = (object)(array('doc_id'=>$docId,'doc_url' => $doc_url, 'remarks'=>$remarks,'emp_name'=>$empName));


		

		 $this->load->view('view_inbox_document',$data);
	}


	public function forwardFrom(){

        $forIds =$this->input->post('forIds');
       	$remarks=$this->input->post('remarks');
       	$doc_id=$this->input->post('documentId');
       	$sub_date=date("Y/m/d");
		$fromId = $this->session->userdata('empId');


		$this->load->model('document_model');
		
		/*foeach ($forIds as $forIdSingle) {
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

	public function saveFrom(){

        $forIds =$this->input->post('forIds');
       	$remarks=$this->input->post('remarks');
       	$doc_id=$this->input->post('documentId');
       	$sub_date=date("Y/m/d");
		$fromId = $this->session->userdata('empId');


		$this->load->model('document_model');
		
		/*foeach ($forIds as $forIdSingle) {
			*/
	        if($doc_id!=0){
	        	$doc_remarks=array('doc_Id' => $doc_id,'from_Id' =>$fromId,'sub_date' => $sub_date,'to_Id' => $forIds,'status'=>0,'f_status' => 0,'remark' =>$remarks);

	        	$this->load->model('compose_model');
				$status = $this->compose_model->insert_doc_remark($doc_remarks);
			}

	/*    }*/

	    if($status==true){
					echo json_encode("File Saved to Drafts");
			}else{
				echo json_encode($doc_id);
			}
	}
}

?>
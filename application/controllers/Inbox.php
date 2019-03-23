<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends CI_Controller {

	
	public function index()
	{

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

		$this->load->model('compose_model');
		$empId=$this->session->userdata('empId');
		$result['document_remarks'] = $this->compose_model->get_all_documents();

		$documtRemarks=array();
		foreach ($result['document_remarks'] as $docRemark) {

			$toIds=$docRemark->to_Id;

			$toIdsArray = explode(",", $toIds);

			foreach ($toIdsArray as $toId) {

				if($toId==$empId && $docRemark->f_status==1) {
					$documtRemarks[]= (object)(array('r_Id'=>$docRemark->r_Id,'doc_Id' => $docRemark->doc_Id,'from_Id' =>$docRemark->from_Id,'sub_date' =>$docRemark->sub_date,'to_Id' =>$toId,'status'=>$docRemark->status,'f_status' => $docRemark->f_status,'remark' =>$docRemark->remark,'time_stamp'=>$docRemark->time_stamp));
				}
			}
		}

		
		
		$data['document_remarks']=$documtRemarks;

	/*	print_r($data['document_remarks']);
		return;
		exit();
*/

		$this->load->view('inbox_view',$data);
	}

	public function filterInbox(){
		

		$filterBy = $this->input->post('filterBy');

		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime("-1 days"));
		$week=date("W",strtotime($today));
		$month=date("m",strtotime($today));
		$year=date("Y",strtotime($today));
		$currentweek = date("W");
		$currentMonth = date("m");

		$weekStartDate="";
		$weekEndDate="";

		$monthStartDate="";
		$monthEndDate="";

		$empId=$this->session->userdata('empId');

		for($i=$week;$i<=$currentweek;$i++) {
   			 $resultWeek=$this->getWeek($i,$year);
   			 $weekStartDate=$resultWeek['start'];
   			 $weekEndDate=$resultWeek['end'];
		}

		for($i=$month;$i<=$currentMonth;$i++) {
   			 $resultMonth=$this->getMonth($i,$year);
   			 $monthStartDate=$resultMonth['start'];
   			 $monthEndDate=$resultMonth['end'];
		}


		$this->load->model('document_model');

		$result['document_remarks']="";

		if($filterBy=="ALL"){
			$result =$this->document_model->get_all_documents();
			//echo json_encode($result);
		}


		if($filterBy=="TODAY"){
			$result =$this->document_model->get_all_documents_by_date($today);
			//echo json_encode($result);
		}

		if($filterBy=="YESTERDAY"){
			$result =$this->document_model->get_all_documents_by_date($yesterday);
			//echo json_encode($result);
		}

		if($filterBy=="WTD"){
			$result =$this->document_model->get_all_documents_by_date_between($weekStartDate,$weekEndDate);
			//echo json_encode($result);
		}


		if($filterBy=="MTD"){
			$result =$this->document_model->get_all_documents_by_date_between($monthStartDate,$monthEndDate);
			//echo json_encode($result);
		}

		$data=$this->getDocRemarks($result,$empId);

		echo json_encode($data);

	}


	public function filterCustomInbox(){
		

		$fromDate = date('Y-m-d',strtotime($this->input->post('fromdate')));
		$toDate = date('Y-m-d',strtotime($this->input->post('todate')));

		$this->load->model('document_model');
		$empId=$this->session->userdata('empId');
		$result['document_remarks']="";

		
		$result =$this->document_model->get_all_documents_by_date_between($fromDate,$toDate);
		

		$data=$this->getDocRemarks($result,$empId);

		echo json_encode($data);

	}

	function getDocRemarks($result,$empId){
		$documtRemarks=array();

		$this->load->model('compose_model');
		$this->load->model('employee_model');
			$count=0;
			foreach ($result as $docRemark) {

				$toIds=$docRemark->to_Id;

				$toIdsArray = explode(",", $toIds);

				foreach ($toIdsArray as $toId) {

					if($toId==$empId && $docRemark->f_status==1) {
						$count++;

						$doc_name="";
						$recFrom="";
						$emp_Id="";
						$to_Id="";

						$data['documents'] = $this->compose_model->get__document_name($docRemark->doc_Id);
						foreach ($data['documents']  as $document) {
								$doc_name=$document->doc;
						}
						$data['employees'] = $this->employee_model->get_employee_name($docRemark->from_Id);
						foreach ($data['employees']  as $employee) {
									$recFrom=$employee->emp_name;
									$emp_Id=$employee->emp_id;
									$to_Id=$employee->e_id;
						}


						$documtRemarks[]= array('r_Id'=>$docRemark->r_Id,'doc_Id' => $docRemark->doc_Id,'from_Id' =>$docRemark->from_Id,'sub_date' =>$docRemark->sub_date,'to_Id' =>$toId,'status'=>$docRemark->status,'f_status' => $docRemark->f_status,'remark' =>$docRemark->remark,'time_stamp'=>$docRemark->time_stamp,"doc_name"=>$doc_name,"recFrom"=>$recFrom,"toId"=>$to_Id);
					}
				}
			}
		

		//$data['document_remarks']=$documtRemarks;

		return $documtRemarks;


	}


	function getWeek($week, $year) {
		  $dto = new DateTime();
		  $result['start'] = $dto->setISODate($year, $week, 0)->format('Y-m-d');
		  $result['end'] = $dto->setISODate($year, $week, 6)->format('Y-m-d');
		  return $result;
	}

	function getMonth($month, $year) {
		
		$resultStartDate = strtotime("{$year}-{$month}-01");
   		$resultEndDate = strtotime('-1 second', strtotime('+1 month', $resultStartDate));

   		
		$result['start'] =date('Y-m-d',$resultStartDate);
		$result['end'] = date('Y-m-d',$resultEndDate );

		  return $result;
	}

}

?>
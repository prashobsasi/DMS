<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drafts extends CI_Controller {

	
	public function index()
	{

		$this->load->model('employee_model');
		$this->load->model('compose_model');
		$empId=$this->session->userdata('empId');
		$data['document_remarks'] = $this->compose_model->get_all_documents_of_employee_drafts($empId);
		$this->load->view('draft_view',$data);
	}
}

?>
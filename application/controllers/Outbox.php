<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outbox extends CI_Controller {

	
	public function index()
	{

		$this->load->model('employee_model');
		$this->load->model('compose_model');
		$empId=$this->session->userdata('empId');
		$data['document_remarks'] = $this->compose_model->get_all_documents_of_employee_outbox($empId);
		$this->load->view('outbox_view',$data);
	}
}

?>
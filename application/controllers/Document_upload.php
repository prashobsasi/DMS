<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_upload extends CI_Controller {

	
	public function index()
	{
		
		$this->load->model('documentType_model');
		$data['doc_types'] = $this->documentType_model->get_all_documentType();

		$this->load->model('document_model');
		$data['documents']=$this->document_model->get_documents_of_employee($this->session->userdata('empId'));

		$this->load->view('document_upload_view',$data);
	}

	public function getFileName()
	{
		
		
		$documentType_Id = $this->input->post('id');

		$this->load->model('documentType_model');
		$data['doc_types'] = $this->documentType_model->get_documentType($documentType_Id);
		$file_keyword="abc";
		$filename="";

		$no=1;
		foreach ($data['doc_types'] as $doc_type) {
			$file_keyword=$doc_type->keyword;
		}

		$this->load->model('document_model');
		$count = $this->document_model->get_document_count($documentType_Id);

		if($count == 0)
		{
			$filename=$file_keyword."1";
		
		}else{
			$no=$no+$count++;
			$filename=$file_keyword.$no++;
		}

		
		

		echo json_encode($filename);
	}

	public function save(){

        $owner =$this->input->post('emp_id');

		$config = array(
		'upload_path' => "./uploads/docs/",
		'encrypt_name'=> TRUE,
		'allowed_types' => "gif|jpg|png|jpeg|pdf",
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
		$doc_type =$this->input->post('doc_type_id');
       	
       	$document = array('doc_Url' => $doc_Url, 'doc' =>$file_name,'doc_type'=>$doc_type ,'doc_owner'=>$owner);
        $this->load->model('document_model');
		$doc_id= $this->document_model->insert_document($document);

		$doc_type_name="";

		$this->load->model('documentType_model');
		$data['doc_types'] = $this->documentType_model->get_documentType($doc_type);
		

		foreach ($data['doc_types'] as $doc_type) {
			$doc_type_name=$doc_type->name;
		}

		$data = array('doc_id' => $doc_id ,'doc_type'=>$doc_type_name );

		echo json_encode($data);
		
	}

}

?>
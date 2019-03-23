<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentType extends CI_Controller {

	
	public function index()
	{
		
		 $this->load->model('documentType_model');
		 $data['documentTypes'] = $this->documentType_model->get_all_documentType();

		$this->load->view('documentType_view',$data);
	}

	public function insert()
	{
		

		$name = $this->input->post('name');

		$keyword = $this->input->post('keyword');
        
        $this->load->model('documentType_model');
		$status = $this->documentType_model->insert_documentType($name,$keyword);

		if ($status==true) {

			$data['documentTypes'] = $this->documentType_model->get_all_documentType();

			foreach ($data['documentTypes']  as $documentType) {

				  	 		if($documentType->name==$name){
				  	 			echo json_encode($data);
				  	 		}
				  	 }
				  	
			
		}else{
			echo json_encode($status);
		}

		

	}

	public function edit()
	{
		
		$id = $this->input->post('id');

    	
        
        $this->load->model('documentType_model');
		$data['documentTypes'] = $this->documentType_model->get_documentType($id);

		echo json_encode($data);

	}

	public function update()
	{
		
		$id = $this->input->post('id');

		$name = $this->input->post('name');

		$keyword = $this->input->post('keyword');

    	
        
        $this->load->model('documentType_model');
		$data = $this->documentType_model->update_documentType($id,$name,$keyword);

		echo json_encode($data);

	}

	public function delete()
	{
		
		$id = $this->input->post('id');

        $this->load->model('documentType_model');
		$data = $this->documentType_model->delete_documentType($id);

		echo json_encode($data);

	}

}

?>
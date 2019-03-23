<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designation extends CI_Controller {

	
	public function index()
	{
		
		 $this->load->model('designation_model');
		 $data['designations'] = $this->designation_model->get_all_designation();

		$this->load->view('designation_view',$data);
	}

	public function insert()
	{
		

		$name = $this->input->post('name');
        
        $this->load->model('designation_model');
		$status = $this->designation_model->insert_designation($name);

		if ($status==true) {

			$data['designations'] = $this->designation_model->get_all_designation();

			foreach ($data['designations']  as $designation) {

				  	 		if($designation->desig_name==$name){
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

    	
        
        $this->load->model('designation_model');
		$data['designations'] = $this->designation_model->get_designation($id);

		echo json_encode($data);

	}

	public function update()
	{
		
		$id = $this->input->post('id');

		$name = $this->input->post('name');

    	
        
        $this->load->model('designation_model');
		$data = $this->designation_model->update_designation($id,$name);

		echo json_encode($data);

	}

	public function delete()
	{
		
		$id = $this->input->post('id');

        $this->load->model('designation_model');
		$data = $this->designation_model->delete_designation($id);

		echo json_encode($data);

	}

}

?>
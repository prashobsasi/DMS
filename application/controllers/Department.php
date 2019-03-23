<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	
	public function index()
	{
		
		 $this->load->model('department_model');
		 $data['departments'] = $this->department_model->get_all_department();

		$this->load->view('department_view',$data);
	}

	public function insert()
	{
		

		$name = $this->input->post('name');
        
        $this->load->model('department_model');
		$status = $this->department_model->insert_department($name);

		if ($status==true) {

			$data['departments'] = $this->department_model->get_all_department();

			foreach ($data['departments']  as $department) {

				  	 		if($department->dept_name==$name){
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

    	
        
        $this->load->model('department_model');
		$data['departments'] = $this->department_model->get_department($id);

		echo json_encode($data);

	}

	public function update()
	{
		
		$id = $this->input->post('id');

		$name = $this->input->post('name');

    	
        
        $this->load->model('department_model');
		$data = $this->department_model->update_department($id,$name);

		echo json_encode($data);

	}

	public function delete()
	{
		
		$id = $this->input->post('id');

        $this->load->model('department_model');
		$data = $this->department_model->delete_department($id);

		echo json_encode($data);

	}

}

?>
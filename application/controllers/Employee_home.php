<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_home extends CI_Controller {

	
	public function index()
	{
		$this->load->view('employee_home');
	}
}

?>
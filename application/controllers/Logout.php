<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	
	public function index()
	{
		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('empname');
		$this->session->unset_userdata('desigId');
		$this->session->unset_userdata('desig_name');
		$this->session->unset_userdata('deptId');
		$this->session->unset_userdata('dept_name');
		$this->session->sess_destroy();

		redirect(base_url());
	}

}

?>
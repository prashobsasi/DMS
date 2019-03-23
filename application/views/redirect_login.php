<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	if($this->session->userdata('employeeId')==""){
			redirect(base_url());
	}
?>
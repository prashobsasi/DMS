<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Level extends CI_Controller {

	
	public function index()
	{
		$this->load->view('user_level_view');
	}

}

?>
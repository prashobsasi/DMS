<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	

	function can_login($username,$password){

		
		$this->load->database();
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$query = $this->db->get('employee');

		if ($query->num_rows() > 0) {
			
			return true;
		}else{
			return false;
		}

	}


	function get_user($username,$password){

		

		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$query = $this->db->get('employee');

		
			
		return $query->result();
		
	}


}

?>
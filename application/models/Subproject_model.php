<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Subproject_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_subproject() {
	  return $this->db->get("xin_projects_sub");
	}
		
	public function get_all_subproject() {
	  $query = $this->db->get("xin_projects_sub");
	  return $query->result();
	}
	 
	public function read_users_info($id) {
	
		$sql = 'SELECT * FROM xin_users WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// check email address
	public function check_user_email($email) {
	
		$sql = 'SELECT * FROM xin_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_projects_sub', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// get single sub project by id
	public function read_single_subproject($id)
	{

		$sql = "SELECT * FROM xin_projects_sub WHERE secid = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('secid', $id);
		$this->db->delete('xin_projects_sub');
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_users',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without photo > in table
	public function update_record_no_photo($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_users',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}

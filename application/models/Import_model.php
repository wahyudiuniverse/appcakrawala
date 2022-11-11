<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Import_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_employees_temp() {
	  return $this->db->get("xin_employees_temp");
	}
		
	public function get_all_users() {
	  $query = $this->db->get("xin_users");
	  return $query->result();
	}
	 

	public function get_temp_employees($id) {
	
		$sql = 'SELECT * FROM xin_employees_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_eslip_by_id($id) {
	
		$sql = 'SELECT * FROM xin_employees_eslip WHERE secid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


 	// get all employes
	public function get_all_eslip() {

		$sql = "SELECT uploadid, periode, project, project_sub, createdby, DATE_FORMAT(createdon, '%Y-%m-%d') AS up_date, COUNT(nip) AS total_mp FROM xin_employees_eslip
GROUP BY uploadid ORDER BY uploadid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// get all employes
	public function get_all_temp_eslip() {

		$sql = 'SELECT uploadid, periode, project, project_sub, COUNT(nip) AS total_mp FROM xin_employees_eslip
GROUP BY uploadid, periode, project, project_sub;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

	public function get_temp_eslip($id) {
	
		$sql = 'SELECT * FROM xin_employees_eslip_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	 	public function get_temp_pkwt($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
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


		// get all employes temporary
	public function get_eslip_preview($importid) {
		
		$sql = 'SELECT * FROM xin_employees_eslip WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
	    return $query;
	}

		// get all employes temporary
	public function get_eslip_temp($importid) {
		
		$sql = 'SELECT * FROM xin_employees_eslip_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
	    return $query;
	}

	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_users', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('user_id', $id);
		$this->db->delete('xin_users');
		
	}
		// Function to Delete selected record from table
	public function delete_all_eslip_preview($uploadid){
		$this->db->where('uploadid', $uploadid);
		$this->db->delete('xin_employees_eslip');
		
	}

		// Function to Delete selected record from table
	public function delete_all_eslip_temp_preview($uploadid){
		$this->db->where('uploadid', $uploadid);
		$this->db->delete('xin_employees_eslip_temp');
		
	}
	
	// Function to update record in table > basic_info
	public function update_release_eslip($data, $id){
		$this->db->where('uploadid', $id);
		if( $this->db->update('xin_employees_eslip',$data)) {
			return true;
		} else {
			return false;
		}		
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

	// Function to add record in table
	public function addtemp($data){
		$this->db->insert('xin_employees_eslip_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_temp_by_nip(){
		$this->db->where('nip', 'NIP');
		$this->db->delete('xin_employees_eslip_temp');
		
	}
	
}
?>
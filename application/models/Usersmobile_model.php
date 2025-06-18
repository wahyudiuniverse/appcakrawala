<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Usersmobile_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_users_mobile() {
	  // return $this->db->get("xin_user_mobile");
		$this->db->order_by("createdon");
		$this->db->limit(5);
		$query = $this->db->get('xin_user_mobile');

		return $query->result();

	}
		

	// get all employees
	public function all_employees($nip)	
	{

	  $query = $this->db->query("SELECT user_id, employee_id, first_name
		FROM xin_employees
		where project_id in (select DISTINCT(project_id) from xin_projects_akses where nip = '$nip')
		AND status_resign = 1");
  	  return $query->result();
	}

	// get employees list> reports
	public function user_mobile_limit() {
		return $query = $this->db->query("SELECT * FROM xin_user_mobile ORDER BY createdon DESC LIMIT 10");
	}

	// get employees list> reports
	public function user_mobile_limit_fillter($company_id, $project_id, $subproject) {

		if($subproject == "0"){
			return $query = $this->db->query("SELECT userm.*, emp.sub_project_id
			FROM xin_user_mobile userm
			LEFT JOIN xin_employees emp ON emp.employee_id = userm.employee_id
			WHERE userm.project_id = '$project_id'");

		} else {

			return $query = $this->db->query("SELECT userm.*, emp.sub_project_id
			FROM xin_user_mobile userm
			LEFT JOIN xin_employees emp ON emp.employee_id = userm.employee_id
			WHERE userm.project_id = '$project_id'
			AND emp.sub_project_id = '$subproject'");
		}
	}


	public function get_usertype()
	{
	  return $this->db->get("xin_user_mobile_type");
	}
	
	public function get_district()
	{
	  return $this->db->get("mt_districts");
	}


	public function get_regencies()
	{
	  return $this->db->get("mt_regencies");
	}

	public function get_all_users() {
	  $query = $this->db->get("xin_user_mobile");
	  return $query->result();
	}
	 

	public function read_usersmobile_type($id) {
	
		$sql = 'SELECT * FROM xin_user_mobile_type WHERE secid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function read_usersmobile_area($id) {
	
		$sql = 'SELECT * FROM mt_regencies WHERE id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function read_users_info($id) {
	
		$sql = 'SELECT * FROM xin_user_mobile WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function read_users_mobile_by_nik($id) {
	
		$sql = 'SELECT * FROM xin_user_mobile WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('employee_id', $id);
		$data = $this->security->xss_clean($data);
		if( $this->db->update('xin_user_mobile',$data)) {
			return true;
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
		$this->db->insert('xin_user_mobile', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('user_id', $id);
		$this->db->delete('xin_user_mobile');
		
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


	// get all project
	public function get_projects_usermobile()
	{
	  $query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title 
		FROM xin_projects 
		WHERE project_id IN (SELECT DISTINCT(project_id) FROM xin_user_mobile)
		ORDER BY title ASC;");
  	  return $query->result();
	}
	
	public function get_employee_cis($empID)
	{

	  // $cisdb = $this->load->database('cisdb', TRUE);
	  $query = $this->db->query("SELECT  emp.employee_id, emp.first_name, emp.company_id, com.name as comp_name, emp.project_id, pro.title, prosub.sub_project_name, pos.designation_name, emp.penempatan
			FROM xin_employees emp
			LEFT JOIN xin_companies com ON com.company_id = emp.company_id
			LEFT JOIN xin_projects pro ON pro.project_id = emp.project_id
			LEFT JOIN xin_projects_sub prosub ON prosub.secid = emp.sub_project_id 
			LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
			WHERE emp.employee_id = '$empID';");
  	  return $query->result();
	}

}
?>
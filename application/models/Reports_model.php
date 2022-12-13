<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function getAttendToday() {
		$query = $this->db->query("

			SELECT attdin.employee_id, attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
			FROM (
				SELECT employee_id, customer_id, DATE_FORMAT(cio_date, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(cio_date, '%H:%i:%s') AS time_in
				FROM xin_trx_cio
				WHERE DATE_FORMAT(cio_date, '%Y-%m-%d') = CURDATE()
				AND c_io = 1
				ORDER BY createdon DESC) attdin
			LEFT JOIN (
				SELECT employee_id, c_io, DATE_FORMAT(cio_date, '%H:%i:%s') AS time_out
				FROM xin_trx_cio
				WHERE DATE_FORMAT(cio_date, '%Y-%m-%d') = CURDATE()
				AND c_io = 2
			) cout ON cout.employee_id = attdin.employee_id"

		);
		return $query->result();
	}

	// get payslip list> reports
	public function get_payslip_list($cid,$eid,$re_date) {
	  if($eid=='' || $eid==0){
		
		$sql = 'SELECT * from xin_salary_payslips where salary_month = ? and company_id = ?';
		$binds = array($re_date,$cid);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	  } else {
	 	 
		$sql = 'SELECT * from xin_salary_payslips where employee_id = ? and salary_month = ? and company_id = ?';
		$binds = array($eid,$re_date,$cid);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	  }
	}
	// get training list> reports
	public function get_training_list($cid,$sdate,$edate) {
		
		$sql = 'SELECT * from `xin_training` where company_id = ? and start_date >= ? and finish_date <= ?';
		$binds = array($cid,$sdate,$edate);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	// get leave list> reports
	public function get_leave_application_list() {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `xin_leave_applications` group by employee_id';
		$query = $this->db->query($sql);
		return $query;
	}
	// get filter leave list> reports
	public function get_leave_application_filter_list($sd,$ed,$user_id,$company_id) {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `xin_leave_applications` where company_id = ? and employee_id = ? and from_date >= ? and to_date <= ? group by employee_id';
		$binds = array($company_id,$user_id,$sd,$ed);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get pending leave list> reports
	public function get_pending_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get approved leave list> reports
	public function get_approved_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get upcoming leave list> reports
	public function get_upcoming_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,4);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get rejected leave list> reports
	public function get_rejected_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,3);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get only pending leave list> reports
	public function get_pending_leave_list($employee_id,$status) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get project list> reports
	public function get_project_list($projId,$projStatus) {
		
		if($projId==0 && $projStatus=='all') {
			return $query = $this->db->query("SELECT * FROM `xin_projects`");
		} else if($projId==0 && $projStatus!='all') {
			$sql = 'SELECT * from `xin_projects` where status = ?';
			$binds = array($projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus=='all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ?';
			$binds = array($projId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus!='all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ? and status = ?';
			$binds = array($projId,$projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	// get employee projects
	public function get_employee_projectsx($id) {
	
		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get task list> reports
	public function get_task_list($taskId,$taskStatus) {
		
		  if($taskId==0 && $taskStatus==4) {
			  return $query = $this->db->query("SELECT * FROM xin_tasks");
		  } else if($taskId==0 && $taskStatus!=4) {
			  $sql = 'SELECT * from xin_tasks where task_status = ?';
			  $binds = array($taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus==4) {
			  $sql = 'SELECT * from xin_tasks where task_id = ?';
			  $binds = array($taskId);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus!=4) {
		  	  $sql = 'SELECT * from xin_tasks where task_id = ? and task_status = ?';
			  $binds = array($taskId,$taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}
	
	// get roles list> reports
	public function get_roles_employees($role_id) {
		  if($role_id==0) {
			  return $query = $this->db->query("SELECT * FROM xin_employees");
		  } else {
			  $sql = 'SELECT * from xin_employees where user_role_id = ?';
			  $binds = array($role_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}
	
	
	// get employees list> reports
	public function filter_employees_reports($company_id,$department_id,$project_id,$sub_project_id,$status_resign) {

			// if($status_resign==1){
			// 	$status_resign=='AKTIF';
			// } else if ($status_resign==2){
			// 	$status_resign=='RESIGN';
			// } else if ($status_resign==3){
			// 	$status_resign=='BLACKLIST';
			// }
		// 0-0-0-0-0
		  if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		 	 return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		// 1-0-0-0-0
		  } else if($company_id!=0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-0-0-0
		  } else if($company_id!=0 && $department_id!=0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-0-0
		  } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id,$project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-1-0
		  } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id,$project_id,$sub_project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 0-0-1-0-0
		  } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 0-0-1-1-0
		  } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($project_id,$sub_project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-1-0-0
		  } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-0-0-1
		  } else if ($company_id!=0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-0-0-1
		  } else if ($company_id!=0 && $department_id!=0 && $project_id==0 && $sub_project_id==0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND department_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id, $status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-0-1
		  } else if ($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND department_id = ? AND $project_id = ? AND $sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id, $project_id, $sub_project_id, $status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-1-0-1
		  } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id, $project_id, $status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-1-1-0
		  } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id, $project_id, $sub_project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-1-1-1
		  } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id, $project_id, $sub_project_id, $status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-1-1
		  } else if ($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND department_id = ? AND $project_id = ? AND $sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id, $project_id, $sub_project_id, $status_resign);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else {
			  return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		  }
	}



	// get employees list> reports
	public function filter_employees_reports_null($company_id,$department_id,$project_id,$sub_project_id,$status_resign) {
		// return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
	}


	// get employees list> reports
	public function filter_esign_reports_null($company_id,$department_id,$project_id,$sub_project_id,$status_resign) {
		return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip not in('0') ORDER BY secid DESC LIMIT 500");
	}
}
?>
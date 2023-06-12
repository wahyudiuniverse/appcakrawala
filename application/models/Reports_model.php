<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model { 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function getAttendToday($company_id,$project_id,$employee_id,$start_date,$end_date) {
		$query = $this->db->query("

			SELECT attdin.employee_id, attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
			FROM (
				SELECT employee_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in
				FROM xin_trx_cio
				WHERE DATE_FORMAT(datetime_phone, '%Y-%m-%d') = CURDATE()
				AND c_io = 1
				ORDER BY createdon DESC) attdin
			LEFT JOIN (
				SELECT employee_id, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out
				FROM xin_trx_cio
				WHERE DATE_FORMAT(datetime_phone, '%Y-%m-%d') = CURDATE()
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
		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
// 		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (
// 		21402887,
// 21500057,
// 21402888,
// 21500070,
// 21300040,
// 21602889,
// 21202890,
// 21500053,
// 21500048,
// 21600037,
// 21500006,
// 21300046,
// 21600019,
// 21600009,
// 21300038,
// 21500017,
// 21300024,
// 21300004,
// 21500071,
// 21500049,
// 21500014,
// 21300044,
// 21500034,
// 21600032,
// 21500027,
// 21500051,
// 21500064,
// 21500016,
// 21500052,
// 21500007,
// 21300033,
// 21502912,
// 21502909,
// 21500058,
// 21500056,
// 21300018,
// 21502907,
// 21502906,
// 21502905,
// 21502904,
// 21300086,
// 21302893,
// 21500086,
// 21502899,
// 21502900,
// 21302902,
// 21302916,
// 21502915,
// 21300094,
// 21300089,
// 21300095,
// 21300090,
// 21504636,
// 21300091,
// 21500088,
// 21300093,
// 21305730,
// 21305732,
// 21205736,
// 21505790,
// 21505934,
// 21509427,
// 21505942,
// 22505713,
// 21209428,
// 21209528,
// 21502903,
// 21309784,
// 21509785,
// 21309963,
// 21509905,
// 21509851,
// 21310055,
// 21509887,
// 21402913,
// 21402888,
// 21402887,
// 21500063,
// 21300023,
// 21500066,
// 21500062,
// 21500065,
// 21500072,
// 21500047,
// 21300026,
// 21500055,
// 21300001,
// 21600035,
// 21300028,
// 21300043,
// 21300020,
// 21502914,
// 21300002,
// 21300083,
// 21300012,
// 21600013,
// 21300031,
// 21300088,
// 21300087,
// 21500078,
// 21300084,
// 21500075,
// 21500081,
// 21300082,
// 21300837
//  	)");
	}


	// get employees list> reports
	public function filter_employees_hotspot($company_id,$department_id,$project_id,$sub_project_id,$status_resign) {
		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
	}


	// get employees list> reports
	public function filter_esign_reports_null($company_id,$department_id,$project_id,$sub_project_id,$status_resign) {
		
		// 0-0-0-0-0
		  if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		 	 return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip in('99') ORDER BY secid DESC");
		// 1-0-0-0-0
		  } else if($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		 	  $sql = "SELECT skk.*, emp.company_id, emp.project_id, emp.designation_id 
						FROM xin_qrcode_skk skk
						LEFT JOIN xin_employees emp ON emp.employee_id = skk.nip 
						WHERE skk.nip not in('0') 
						AND emp.company_id = ?
						AND emp.project_id = ?
						ORDER BY skk.secid DESC";
			  $binds = array($company_id, $project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-0-0-0
		  }	else {





		return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip not in('0') ORDER BY secid DESC LIMIT 500");
	}
	}

		// get employees att reports
	public function filter_report_emp_att_null() {

		return $query = $this->db->query("SELECT employee_id, customer_id, datetime_phone as date_phone, datetime_phone as time_in, datetime_phone as time_out, datetime_phone as timestay
FROM xin_trx_cio
WHERE employee_id = '99'");


		// return $query = $this->db->query("SELECT attdin.employee_id, attdin.project_id, emp.sub_project_id,attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
		// 	FROM (
		// 		SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 1
		// 		AND project_id = '62'
		// 		AND employee_id in (22505731,22505713)
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '2023-02-01' AND '2023-02-28'
		// 		ORDER BY createdon DESC) attdin
		// 	LEFT JOIN (
		// 		SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 2 
		// 		AND project_id = '62'
		// 		AND employee_id in (22505731,22505713)
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '2023-02-01' AND '2023-02-28'
		// 	) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
		// 	LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id");

	}

		// get employees att reports
	public function filter_report_emp_att($company_id,$project_id,$sub_id,$start_date,$end_date) {

		// return $query = $this->db->query("SELECT attdin.employee_id, attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
		// 	FROM (
		// 		SELECT employee_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 1
		// 		AND project_id = '$project_id'
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		// 		ORDER BY createdon DESC) attdin
		// 	LEFT JOIN (
		// 		SELECT employee_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 2 
		// 		AND project_id = '$project_id'
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		// 	) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone");


		// return $query = $this->db->query("SELECT attdin.employee_id, attdin.project_id, attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
		// 	FROM (
		// 		SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 1
		// 		AND project_id = '$project_id'
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		// 		ORDER BY createdon DESC) attdin
		// 	LEFT JOIN (
		// 		SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out
		// 		FROM xin_trx_cio
		// 		WHERE c_io = 2 
		// 		AND project_id = '$project_id'
        //         AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		// 	) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone");

		return $query = $this->db->query("


			SELECT attdin.employee_id, emp.first_name AS fullname, attdin.project_id, proj.title, emp.sub_project_id, projs.sub_project_name, attdin.customer_id, attdin.date_phone, 
attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay,attdin.latitude, attdin.longitude, attdin.foto_in, cout.foto_out
			FROM (
				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in, latitude, longitude, foto AS foto_in
				FROM xin_trx_cio
				WHERE c_io = 1
                AND project_id = '$project_id'
                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
				ORDER BY createdon DESC) attdin
			LEFT JOIN (
				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out, latitude, longitude,foto AS foto_out
				FROM xin_trx_cio
				WHERE c_io = 2
                AND project_id = '$project_id'
                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
			) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
			LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id
			LEFT JOIN xin_projects proj ON proj.project_id = attdin.project_id
			LEFT JOIN xin_projects_sub projs ON projs.secid = emp.sub_project_id
WHERE emp.sub_project_id = '$sub_id'


-- SELECT attdin.employee_id, emp.first_name AS fullname, attdin.project_id, proj.title, emp.sub_project_id, projs.sub_project_name, attdin.customer_id, attdin.date_phone, 
-- attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay,attdin.latitude, attdin.longitude, attdin.foto_in, cout.foto_out
-- 			FROM (
-- 				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in,latitude,longitude, foto AS foto_in
-- 				FROM xin_trx_cio
-- 				WHERE c_io = 1
--                 AND project_id = '22'
--                 AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '2023-05-09' AND '2023-05-09'
-- 				ORDER BY createdon DESC) attdin
-- 			LEFT JOIN (
-- 				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out,latitude,longitude,foto AS foto_out
-- 				FROM xin_trx_cio
-- 				WHERE c_io = 2
--                 AND project_id = '22'
--                 AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '2023-05-09' AND '2023-05-09'
-- 			) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
-- 			LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id
-- 			LEFT JOIN xin_projects proj ON proj.project_id = attdin.project_id
-- 			LEFT JOIN xin_projects_sub projs ON projs.secid = emp.sub_project_id
-- WHERE emp.sub_project_id = '2'



-- SELECT attdin.employee_id, attdin.project_id, emp.sub_project_id,attdin.customer_id, attdin.date_phone, attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay
-- 			FROM (
-- 				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in
-- 				FROM xin_trx_cio
-- 				WHERE c_io = 1
-- 				AND project_id = '$project_id'
--                 AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
-- 				ORDER BY createdon DESC) attdin
-- 			LEFT JOIN (
-- 				SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out
-- 				FROM xin_trx_cio
-- 				WHERE c_io = 2 
-- 				AND project_id = '$project_id'
--                 AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
-- 			) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
-- 			LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id
-- WHERE emp.sub_project_id = '$sub_id'

");




			
	}


		// get employees att reports
	public function report_order() {

		return $query = $this->db->query("
			SELECT morder.secid, 
			morder.customer_id,cust.customer_name, cust.address, city.name as city, kec.name as kec, desa.name as desa,
            cust.owner_name, cust.no_contact,
			morder.employee_id,emp.first_name, morder.material_id, sku.nama_material, 
		morder.order_date, morder.qty, morder.price, morder.total
		FROM xin_mobile_order morder
		LEFT JOIN xin_sku_material sku ON sku.kode_sku = morder.material_id
		LEFT JOIN xin_employees emp ON emp.employee_id = morder.employee_id
		LEFT JOIN xin_customer cust ON cust.customer_id = morder.customer_id
		LEFT JOIN mt_regencies city ON city.id = cust.city_id
		LEFT JOIN mt_districts kec ON kec.id = cust.district_id
		LEFT JOIN mt_villages desa ON desa.id = cust.village_id

		WHERE DATE_FORMAT(morder.order_date, '%Y-%m-%d') = CURDATE() 
		-- AND morder.customer_id = '123456789'
		-- AND morder.employee_id = '21300043'
		");
	}

		// get employees order
	public function report_order_filter($company_id,$project_id,$sub_id,$start_date,$end_date) {

		return $query = $this->db->query("
			SELECT morder.secid, 
			morder.customer_id,cust.customer_name, cust.address, city.name as city, kec.name as kec, desa.name as desa,
			cust.owner_name, cust.no_contact,
			morder.employee_id,emp.first_name, morder.material_id, sku.nama_material, 
		morder.order_date, morder.qty, morder.price, morder.total
		FROM xin_mobile_order morder
		LEFT JOIN xin_sku_material sku ON sku.kode_sku = morder.material_id
		LEFT JOIN xin_employees emp ON emp.employee_id = morder.employee_id
		LEFT JOIN xin_customer cust ON cust.customer_id = morder.customer_id
		LEFT JOIN mt_regencies city ON city.id = cust.city_id
		LEFT JOIN mt_districts kec ON kec.id = cust.district_id
		LEFT JOIN mt_villages desa ON desa.id = cust.village_id

		WHERE DATE_FORMAT(morder.order_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		AND emp.project_id = '$project_id'
		-- AND morder.customer_id = '123456789'
		-- AND morder.employee_id = '21300043'
		");

	}

		// get employees att reports
	public function report_order_resume() {

		return $query = $this->db->query("

SELECT distinct(cio.employee_id) AS emp_id, emp.penempatan, CURDATE() AS sdate, CURDATE() AS ndate, COUNT(cio.customer_id) count_call, morder.count_ec, morder.qty_renceng, morder.total
FROM xin_trx_cio cio
LEFT JOIN xin_employees emp ON emp.employee_id = cio.employee_id
LEFT JOIN (SELECT DISTINCT(employee_id) emp_order, COUNT(DISTINCT customer_id) count_ec, SUM(qty) AS qty_renceng, SUM(total) AS total
	FROM xin_mobile_order 
	WHERE DATE_FORMAT(order_date, '%Y-%m-%d') BETWEEN CURDATE() AND CURDATE()
    GROUP BY employee_id) morder ON morder.emp_order = cio.employee_id
WHERE cio.project_id = 25
AND emp.sub_project_id = 151
AND cio.c_io = 1
AND DATE_FORMAT(cio_date, '%Y-%m-%d') BETWEEN CURDATE() AND CURDATE()
GROUP BY cio.employee_id


		-- 	SELECT morder.secid, 
		-- 	morder.customer_id,cust.customer_name, cust.address, city.name as city, kec.name as kec, desa.name as desa,
		-- 	morder.employee_id,emp.first_name, morder.material_id, sku.nama_material, 
		-- morder.order_date, morder.qty, morder.price, morder.total
		-- FROM xin_mobile_order morder
		-- LEFT JOIN xin_sku_material sku ON sku.kode_sku = morder.material_id
		-- LEFT JOIN xin_employees emp ON emp.employee_id = morder.employee_id
		-- LEFT JOIN xin_customer cust ON cust.customer_id = morder.customer_id
		-- LEFT JOIN mt_regencies city ON city.id = cust.city_id
		-- LEFT JOIN mt_districts kec ON kec.id = cust.district_id
		-- LEFT JOIN mt_villages desa ON desa.id = cust.village_id
		-- WHERE DATE_FORMAT(morder.order_date, '%Y-%m-%d') = CURDATE() 
		-- AND morder.customer_id = '123456789'
		-- AND morder.employee_id = '21300043'
		");
	}


		// get employees att reports
	public function report_order_resume_filter($company_id,$project_id,$sub_id,$start_date,$end_date) {

		return $query = $this->db->query("

SELECT distinct(cio.employee_id) AS emp_id, emp.penempatan, '$start_date' AS sdate, '$end_date' AS ndate, COUNT(cio.customer_id) count_call, morder.count_ec, morder.qty_renceng, morder.total
FROM xin_trx_cio cio
LEFT JOIN xin_employees emp ON emp.employee_id = cio.employee_id
LEFT JOIN (SELECT DISTINCT(employee_id) emp_order, COUNT(DISTINCT customer_id) count_ec, SUM(qty) AS qty_renceng, SUM(total) AS total
	FROM xin_mobile_order 
	WHERE DATE_FORMAT(order_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
    GROUP BY employee_id) morder ON morder.emp_order = cio.employee_id
WHERE cio.project_id = '$project_id'
AND emp.sub_project_id = '$sub_id'
AND cio.c_io = 1
AND DATE_FORMAT(cio_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
GROUP BY cio.employee_id

		-- 	SELECT morder.secid, 
		-- 	morder.customer_id,cust.customer_name, cust.address, city.name as city, kec.name as kec, desa.name as desa,
		-- 	morder.employee_id,emp.first_name, morder.material_id, sku.nama_material, 
		-- morder.order_date, morder.qty, morder.price, morder.total
		-- FROM xin_mobile_order morder
		-- LEFT JOIN xin_sku_material sku ON sku.kode_sku = morder.material_id
		-- LEFT JOIN xin_employees emp ON emp.employee_id = morder.employee_id
		-- LEFT JOIN xin_customer cust ON cust.customer_id = morder.customer_id
		-- LEFT JOIN mt_regencies city ON city.id = cust.city_id
		-- LEFT JOIN mt_districts kec ON kec.id = cust.district_id
		-- LEFT JOIN mt_villages desa ON desa.id = cust.village_id
		-- WHERE DATE_FORMAT(morder.order_date, '%Y-%m-%d') = CURDATE() 
		-- AND morder.customer_id = '123456789'
		-- AND morder.employee_id = '21300043'
		");
	}

}
?>
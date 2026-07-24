<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*
	* persiapan data untuk datatable pagination
	* data list log blast email
	* 
	* @author Fadla Qamara
	*/
	function list_log_blast_email($postData = null)
	{
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$session = $this->session->userdata('username');
		$user = $this->Xin_model->read_user_info($session['user_id']);

		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		//variabel filter (diambil dari post ajax di view)
		// $project = $postData['project'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			// if (strlen($searchValue) >= 3) {
			$searchQuery = " (nama like '%" . $searchValue .  "%' 
					or nip like '%" . $searchValue . "%' 
					or email like '%" . $searchValue . "%'
					or project_name like '%" . $searchValue . "%' 
					or sub_project_name like '%" . $searchValue . "%'
					or jabatan_name like '%" . $searchValue . "%'
					or penempatan like '%" . $searchValue . "%'
					) ";
			// }
		}

		## Filter
		// $filterProject = "";
		// if (($project != null) && ($project != "") && ($project != '0')) {
		// 	$filterProject = "xin_employees.project_id = '" . $project . "'";
		// } else {
		// 	$filterProject = "";
		// }

		## Kondisi Default 
		// $kondisiDefaultQuery = "(project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")) AND `user_id` != '1'";
		// $kondisiDefaultQuery = "(
		// 	karyawan_id = " . $emp_id . "
		// AND	pkwt_id = " . $contract_id . "
		// )";
		// $kondisiDefaultQuery = "`xin_employees.user_id` != '1'";
		$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		if ($kondisiDefaultQuery != '') {
			$this->db->where($kondisiDefaultQuery);
		}
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		$records = $this->db->get('log_blast_email')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if ($kondisiDefaultQuery != '') {
			$this->db->where($kondisiDefaultQuery);
		}
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		$records = $this->db->get('log_blast_email')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		// $this->db->select('*');
		$this->db->select('id');
		$this->db->select('nip');
		$this->db->select('nama');
		$this->db->select('project_name');
		$this->db->select('jabatan_name');
		$this->db->select('penempatan');
		$this->db->select('email');
		$this->db->select('email_subject');
		$this->db->select('blast_on');
		$this->db->select('blast_name');
		$this->db->select('blast_by');
		if ($kondisiDefaultQuery != '') {
			$this->db->where($kondisiDefaultQuery);
		}
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		$this->db->order_by($columnName, $columnSortOrder);
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		//$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('log_blast_email')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$button_open_email = '<br><button type="button" onclick="open_email(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >LIHAT EMAIL</button>';

			$data[] = array(
				"nama" => "<strong>" . strtoupper($record->nama) . "</strong><br><small>" . $record->nip,
				"project_name" => "<strong>" . strtoupper($record->project_name) . "</strong><br><small>" . strtoupper($record->jabatan_name) . "</small>",
				"penempatan" => strtoupper($record->penempatan),
				"email" => $record->email . $button_open_email,
				"email_subject" => $record->email_subject,
				"blast_on" => $this->Xin_model->tgl_indo($record->blast_on),
				"blast_name" => "<strong>" . strtoupper($record->blast_name) . "</strong><br><small>" . $record->blast_by . "</small>",
			);
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);
		//print_r($this->db->last_query());
		//die;

		return $response;
	}

	public function getAttendToday($company_id, $project_id, $employee_id, $start_date, $end_date)
	{
		$query = $this->db->query(
			"

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
	public function get_payslip_list($cid, $eid, $re_date)
	{
		if ($eid == '' || $eid == 0) {

			$sql = 'SELECT * from xin_salary_payslips where salary_month = ? and company_id = ?';
			$binds = array($re_date, $cid);
			$query = $this->db->query($sql, $binds);

			return $query;
		} else {

			$sql = 'SELECT * from xin_salary_payslips where employee_id = ? and salary_month = ? and company_id = ?';
			$binds = array($eid, $re_date, $cid);
			$query = $this->db->query($sql, $binds);

			return $query;
		}
	}
	// get training list> reports
	public function get_training_list($cid, $sdate, $edate)
	{

		$sql = 'SELECT * from `xin_training` where company_id = ? and start_date >= ? and finish_date <= ?';
		$binds = array($cid, $sdate, $edate);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get leave list> reports
	public function get_leave_application_list()
	{

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `xin_leave_applications` group by employee_id';
		$query = $this->db->query($sql);
		return $query;
	}
	// get filter leave list> reports
	public function get_leave_application_filter_list($sd, $ed, $user_id, $company_id)
	{

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `xin_leave_applications` where company_id = ? and employee_id = ? and from_date >= ? and to_date <= ? group by employee_id';
		$binds = array($company_id, $user_id, $sd, $ed);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get pending leave list> reports
	public function get_pending_leave_application_list($employee_id)
	{

		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id, 1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get approved leave list> reports
	public function get_approved_leave_application_list($employee_id)
	{

		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id, 2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get upcoming leave list> reports
	public function get_upcoming_leave_application_list($employee_id)
	{

		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id, 4);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get rejected leave list> reports
	public function get_rejected_leave_application_list($employee_id)
	{

		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id, 3);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get only pending leave list> reports
	public function get_pending_leave_list($employee_id, $status)
	{

		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id, $status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get project list> reports
	public function get_project_list($projId, $projStatus)
	{

		if ($projId == 0 && $projStatus == 'all') {
			return $query = $this->db->query("SELECT * FROM `xin_projects`");
		} else if ($projId == 0 && $projStatus != 'all') {
			$sql = 'SELECT * from `xin_projects` where status = ?';
			$binds = array($projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($projId != 0 && $projStatus == 'all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ?';
			$binds = array($projId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($projId != 0 && $projStatus != 'all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ? and status = ?';
			$binds = array($projId, $projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	// get employee projects
	public function get_employee_projectsx($id)
	{

		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get task list> reports
	public function get_task_list($taskId, $taskStatus)
	{

		if ($taskId == 0 && $taskStatus == 4) {
			return $query = $this->db->query("SELECT * FROM xin_tasks");
		} else if ($taskId == 0 && $taskStatus != 4) {
			$sql = 'SELECT * from xin_tasks where task_status = ?';
			$binds = array($taskStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($taskId != 0 && $taskStatus == 4) {
			$sql = 'SELECT * from xin_tasks where task_id = ?';
			$binds = array($taskId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($taskId != 0 && $taskStatus != 4) {
			$sql = 'SELECT * from xin_tasks where task_id = ? and task_status = ?';
			$binds = array($taskId, $taskStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}

	// get roles list> reports
	public function get_roles_employees($role_id)
	{
		if ($role_id == 0) {
			return $query = $this->db->query("SELECT * FROM xin_employees");
		} else {
			$sql = 'SELECT * from xin_employees where user_role_id = ?';
			$binds = array($role_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}



	// get employees list> reports
	public function filter_employees_reports($project_id, $sub_project_id, $status_resign)
	{

		if ($project_id == 0 && $sub_project_id == 0 && $status_resign == 0) {
			return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
		} else if ($project_id != 0 && $sub_project_id == 0 && $status_resign == 0) {
			$sql = "SELECT emp.*, pos.level from xin_employees emp left join xin_designations pos ON pos.designation_id = emp.designation_id where emp.project_id = ? AND emp.employee_id NOT IN (1) AND pos.level NOT IN ('A','A1','B1','B2')";
			$binds = array($project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($project_id != 0 && $sub_project_id != 0 && $status_resign == 0) {
			$sql = "SELECT emp.*, pos.level from xin_employees emp left join xin_designations pos ON pos.designation_id = emp.designation_id where emp.project_id = ? AND emp.sub_project_id = ? AND emp.employee_id NOT IN (1) AND pos.level NOT IN ('A','A1','B1','B2')";
			$binds = array($project_id, $sub_project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($project_id != 0 && $sub_project_id == 0 && $status_resign != 0) {
			$sql = "SELECT emp.*, pos.level from xin_employees emp left join xin_designations pos ON pos.designation_id = emp.designation_id where emp.project_id = ? AND emp.status_resign = ? AND emp.employee_id NOT IN (1) AND pos.level NOT IN ('A','A1','B1','B2')";
			$binds = array($project_id, $status_resign);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if ($project_id != 0 && $sub_project_id != 0 && $status_resign != 0) {

			//$sql = "SELECT * from xin_employees where project_id in (6) and employee_id NOT IN (1)";
			$sql = "SELECT emp.*, pos.level from xin_employees emp left join xin_designations pos ON pos.designation_id = emp.designation_id where emp.project_id = ? AND emp.sub_project_id = ? AND emp.status_resign = ? AND emp.employee_id NOT IN (1) AND pos.level NOT IN ('A','A1','B1','B2')";
			$binds = array($project_id, $sub_project_id, $status_resign);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else {

			return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
		}

		// 0-0-0-0-0
		//   if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		//  	 return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		// // 1-0-0-0-0
		//   } else if($company_id!=0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		//  	  // $sql = "SELECT * from xin_employees where company_id = ? AND employee_id NOT IN (1)";
		// 	  // $binds = array($company_id);
		// 	  // $query = $this->db->query($sql, $binds);
		// 	  // return $query;
		// 	  return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1) LIMIT 0");
		// // 1-1-0-0-0
		//   } else if($company_id!=0 && $department_id!=0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($company_id,$department_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-1-0-0
		//   } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where department_id = ? AND project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($department_id,$project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-1-1-0
		//   } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where department_id = ? AND project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($department_id,$project_id,$sub_project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 0-0-1-0-0
		//   } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 0-0-1-1-0
		//   } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id,$sub_project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-0-1-0-0
		//   } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-0-0-0-1
		//   } else if ($company_id!=0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where status_resign = ? AND employee_id NOT IN (1) LIMIT 0";
		// 	  $binds = array($status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-0-0-1
		//   } else if ($company_id!=0 && $department_id!=0 && $project_id==0 && $sub_project_id==0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where department_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($department_id, $status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-1-0-1
		//   } else if ($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where department_id = ? AND $project_id = ? AND $sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($department_id, $project_id, $sub_project_id, $status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-0-1-0-1
		//   } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id, $status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-0-1-1-0
		//   } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign==0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id, $sub_project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-0-1-1-1
		//   } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($project_id, $sub_project_id, $status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-1-1-1
		//   } else if ($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0 && $status_resign!=0) {
		//  	  $sql = "SELECT * from xin_employees where department_id = ? AND $project_id = ? AND $sub_project_id = ? AND status_resign = ? AND employee_id NOT IN (1)";
		// 	  $binds = array($department_id, $project_id, $sub_project_id, $status_resign);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		//   } else {
		// 	  return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		//   }

	}


	// get employees list> reports
	public function filter_employees_reports_null($project_id, $sub_project_id, $status_resign)
	{
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
		// 21500051,
		// 21500064,
		// 21500016,
		// 21500052,
		// 21500007,
		// 21300033,
		// 21502912,
		// 21500058,
		// 21500056,
		// 21300018,
		// 21502907,
		// 21502906,
		// 21502905,
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
		// 21500088,
		// 21300093,
		// 21305730,
		// 21305732,
		// 21205736,
		// 21505790,
		// 21505934,
		// 21509427,
		// 22505713,
		// 21209428,
		// 21209528,
		// 21309963,
		// 21310055,
		// 21509887,
		// 21502898,
		// 21510350,
		// 21510429,
		// 21610425,
		// 21310410,
		// 21510478,
		// 21511379,
		// 21511601,
		// 21511796,
		// 21512008,
		// 21512110,
		// 21512046,
		// 22509105,
		// 21510595,
		// 21502917,
		// 21512800,
		// 21512881,
		// 21513421,
		// 21513420,
		// 21513419,
		// 21513271,
		// 21513067,
		// 21513074,
		// 21310845,
		// 22505781,
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
		// 21300002,
		// 21300012,
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
	public function filter_employees_hotspot($company_id, $department_id, $project_id, $sub_project_id, $status_resign)
	{
		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (99)");
	}


	// get employees list> reports
	public function filter_esign_reports_null($company_id, $department_id, $project_id, $sub_project_id, $status_resign)
	{

		// 0-0-0-0-0
		if ($company_id == 0 && $department_id == 0 && $project_id == 0 && $sub_project_id == 0 && $status_resign == 0) {
			return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip in('99') ORDER BY secid DESC");
			// 1-0-0-0-0
		} else if ($company_id != 0 && $department_id == 0 && $project_id != 0 && $sub_project_id == 0 && $status_resign == 0) {
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
		} else {





			return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip not in('0') ORDER BY secid DESC LIMIT 500");
		}
	}


	// get employees list> reports
	public function filter_dokumen_sk_null($project_id, $sub_project_id, $status_resign)
	{


		return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip in('99') ORDER BY secid DESC");

		// 0-0-0-0-0
		//   if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		//  	 return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip in('99') ORDER BY secid DESC");
		// // 1-0-0-0-0
		//   } else if($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT skk.*, emp.company_id, emp.project_id, emp.designation_id 
		// 				FROM xin_qrcode_skk skk
		// 				LEFT JOIN xin_employees emp ON emp.employee_id = skk.nip 
		// 				WHERE skk.nip not in('0') 
		// 				AND emp.company_id = ?
		// 				AND emp.project_id = ?
		// 				ORDER BY skk.secid DESC";
		// 	  $binds = array($company_id, $project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-0-0-0
		// }	else {





		// return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip not in('0') ORDER BY secid DESC LIMIT 500");
		// }


	}


	// get employees list> reports
	public function filter_dokumen_sk_project($project_id, $sub_project_id, $status_resign)
	{


		return $query = $this->db->query("SELECT skk.*, emp.company_id, emp.project_id, emp.designation_id 
		 				FROM xin_qrcode_skk skk
		 				LEFT JOIN xin_employees emp ON emp.employee_id = skk.nip 
		 				WHERE skk.nip not in('0') 
		 				AND emp.project_id = $project_id
		 				ORDER BY skk.secid DESC");

		// 0-0-0-0-0
		//   if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0 && $status_resign==0) {
		//  	 return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip in('99') ORDER BY secid DESC");
		// // 1-0-0-0-0
		//   } else if($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0 && $status_resign==0) {
		//  	  $sql = "SELECT skk.*, emp.company_id, emp.project_id, emp.designation_id 
		// 				FROM xin_qrcode_skk skk
		// 				LEFT JOIN xin_employees emp ON emp.employee_id = skk.nip 
		// 				WHERE skk.nip not in('0') 
		// 				AND emp.company_id = ?
		// 				AND emp.project_id = ?
		// 				ORDER BY skk.secid DESC";
		// 	  $binds = array($company_id, $project_id);
		// 	  $query = $this->db->query($sql, $binds);
		// 	  return $query;
		// // 1-1-0-0-0
		// }	else {





		// return $query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip not in('0') ORDER BY secid DESC LIMIT 500");
		// }


	}

	// get employees att reports
	public function filter_report_emp_att_null()
	{


		return $query = $this->db->query("SELECT employee_id, customer_id, datetime_phone as date_phone, datetime_phone as time_in, datetime_phone as time_out, datetime_phone as timestay
FROM xin_trx_cio
WHERE employee_id = '99'");
	}

	// get employees att reports
	public function filter_report_emp_att($project_id, $sub_id, $area, $start_date, $end_date)
	{

		if ($area == '0') {

			return $query = $this->db->query("

			SELECT attdin.employee_id, emp.first_name AS fullname, attdin.project_id, proj.title, emp.sub_project_id, projs.sub_project_name, emp.penempatan, attdin.customer_id, attdin.date_phone, 
			attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay,attdin.latitude, attdin.longitude, attdin.foto_in, cout.foto_out
						FROM (
							SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in, latitude, longitude, foto AS foto_in
							FROM xin_trx_cio
							WHERE c_io = 1
			                AND project_id = '$project_id'
			                -- AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') ='$start_date'
			                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
							ORDER BY createdon DESC) attdin
						LEFT JOIN (
							SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out, latitude, longitude,foto AS foto_out
							FROM xin_trx_cio
							WHERE c_io = 2
			                AND project_id = '$project_id'
			                -- AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') = '$start_date'
			                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
						) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
						LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id
						LEFT JOIN xin_projects proj ON proj.project_id = attdin.project_id
						LEFT JOIN xin_projects_sub projs ON projs.secid = emp.sub_project_id
			WHERE emp.sub_project_id = '$sub_id'
		
			");
		} else {

			return $query = $this->db->query("

			SELECT attdin.employee_id, emp.first_name AS fullname, attdin.project_id, proj.title, emp.sub_project_id, projs.sub_project_name, emp.penempatan, attdin.customer_id, attdin.date_phone, 
			attdin.time_in, cout.time_out, TIMEDIFF(cout.time_out, attdin.time_in) AS timestay,attdin.latitude, attdin.longitude, attdin.foto_in, cout.foto_out
						FROM (
							SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_in, latitude, longitude, foto AS foto_in
							FROM xin_trx_cio
							WHERE c_io = 1
			                AND project_id = '$project_id'
			                -- AND DATE_FORMAT(datetime_phone, '%Y-%m-%d')='$start_date'
			                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
							ORDER BY createdon DESC) attdin
						LEFT JOIN (
							SELECT employee_id, project_id, customer_id, DATE_FORMAT(datetime_phone, '%Y-%m-%d') AS date_phone, c_io, DATE_FORMAT(datetime_phone, '%H:%i:%s') AS time_out, latitude, longitude,foto AS foto_out
							FROM xin_trx_cio
							WHERE c_io = 2
			                AND project_id = '$project_id'
			                -- AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') = '$start_date'
			                AND DATE_FORMAT(datetime_phone, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
						) cout ON cout.employee_id = attdin.employee_id AND cout.customer_id = attdin.customer_id AND cout.date_phone = attdin.date_phone
						LEFT JOIN xin_employees emp ON emp.employee_id = attdin.employee_id
						LEFT JOIN xin_projects proj ON proj.project_id = attdin.project_id
						LEFT JOIN xin_projects_sub projs ON projs.secid = emp.sub_project_id
			WHERE emp.sub_project_id = '$sub_id'
			AND emp.penempatan = '$area'

			");
		}
	}


	// get employees att reports
	public function report_order()
	{

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
	public function report_order_filter($company_id, $project_id, $sub_id, $start_date, $end_date)
	{

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
	public function report_order_resume()
	{

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
	public function report_order_resume_filter($company_id, $project_id, $sub_id, $start_date, $end_date)
	{

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

	// get employees att reports
	public function filter_pkwt_history()
	{

		return $query = $this->db->query("SELECT employee_id, customer_id, datetime_phone as date_phone, datetime_phone as time_in, datetime_phone as time_out, datetime_phone as timestay
		FROM xin_trx_cio
		WHERE employee_id = '99'");
	}
}

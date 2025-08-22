<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pkwt_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_pkwt()
	{
		return $this->db->get("xin_employee_contract");
	}



	// $CI->db->select('*');
	// $CI->db->from('xin_employee_contract');
	// $CI->db->where('contract_id', $userid);
	// $CI->db->join('user_email', 'user_email.user_id = emails.id', 'left');
	// $query = $CI->db->get(); 

	public function get_pkwt_employee()
	{

		// $condition = "invoice_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		// $this->db->where($id);
		// $this->db->limit(1);
		$this->db->join('xin_employees', 'xin_employees.employee_id = xin_employee_contract.employee_id', 'left');
		// $query = $this->db->get();
		return $this->db->get();
	}


	public function get_pkwt_approval()
	{

		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		$this->db->join('xin_employees', 'xin_employees.user_id = xin_employee_contract.employee_id', 'left');
		$this->db->where('status_approve', 0);
		return $this->db->get();
		// $query = $this->db->get ();
		//   	return $query->result ();

	}


	// get all employes temporary
	public function get_pkwt_temp($importid)
	{

		$sql = 'SELECT * FROM xin_employee_contract_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}


	// get single project by id
	public function read_pkwt_emp($empid)
	{

		$sql = " 
SELECT contract_id, employee_id, basic_pay, from_date, to_date, file_name, upload_pkwt FROM xin_employee_contract WHERE employee_id = ?
ORDER BY contract_id DESC LIMIT 1";
		$binds = array($empid);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get employees list> reports
	public function filter_employees_reports($company_id, $department_id, $project_id, $sub_project_id)
	{

		// 0-0-0-0
		if ($company_id == 0 && $department_id == 0 && $project_id == 0 && $sub_project_id == 0) {
			return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
			// 1-0-0-0
		} else if ($company_id != 0 && $department_id == 0 && $project_id == 0 && $sub_project_id == 0) {
			$sql = "SELECT * from xin_employees where company_id = ? AND employee_id NOT IN (1)";
			$binds = array($company_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 1-1-0-0
		} else if ($company_id != 0 && $department_id != 0 && $project_id == 0 && $sub_project_id == 0) {
			$sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND employee_id NOT IN (1)";
			$binds = array($company_id, $department_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 1-1-1-0
		} else if ($company_id != 0 && $department_id != 0 && $project_id != 0 && $sub_project_id == 0) {
			$sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			$binds = array($company_id, $department_id, $project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 1-1-1-1
		} else if ($company_id != 0 && $department_id != 0 && $project_id != 0 && $sub_project_id != 0) {
			$sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			$binds = array($company_id, $department_id, $project_id, $sub_project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 0-0-1-0
		} else if ($company_id == 0 && $department_id == 0 && $project_id != 0 && $sub_project_id == 0) {
			$sql = "SELECT * from xin_employees where project_id = ? AND employee_id NOT IN (1)";
			$binds = array($project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 0-0-1-1
		} else if ($company_id == 0 && $department_id == 0 && $project_id != 0 && $sub_project_id != 0) {
			$sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			$binds = array($project_id, $sub_project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
			// 1-0-1-0
		} else if ($company_id != 0 && $department_id == 0 && $project_id != 0 && $sub_project_id == 0) {
			$sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			$binds = array($company_id, $project_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else {
			return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		}
	}

	// get employees list> reports
	public function filter_employees_reports_none($company_id, $department_id, $project_id, $sub_project_id)
	{

		return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (21300023)");
	}

	// Function to add record in table
	public function add_pkwt_record($data)
	{
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add($data)
	{
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addtemp($data)
	{
		$this->db->insert('xin_employee_contract_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	// Function to add record in table > document info
	public function document_pkwt_add($data)
	{
		$this->db->insert('xin_employee_contract_pdf', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addsign($data)
	{
		$this->db->insert('xin_documents_qrcode', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_temp_by_employeeid()
	{
		$this->db->where('employee_id', 'NIK');
		$this->db->delete('xin_employee_contract_temp');
	}

	// Function to Delete selected record from table
	public function delete_sign_doc($id)
	{
		$this->db->where('secid', $id);
		$this->db->delete('xin_documents_qrcode');
	}

	// Function to Delete selected record from table
	public function delete_pkwt_cancel($id)
	{
		$this->db->where('contract_id', $id);
		$this->db->delete('xin_employee_contract');
	}

	// get single employee
	public function read_pkwt_info($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single employee
	public function read_pkwt_info_byuniq($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE uniqueid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee
	public function read_pkwt_by_nip($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ? ORDER BY contract_id DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_pkwt_last_bynip($nip)
	{

		$sql = "SELECT * FROM xin_employee_contract WHERE employee_id = ? ORDER BY contract_id DESC LIMIT 1";
		// $sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ?';
		$binds = array($nip);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_last_active_pkwt_bynip($nip)
	{

		$sql = "SELECT * FROM xin_employee_contract WHERE employee_id = ? AND status_pkwt = '1' AND cancel_stat = '0' AND approve_hrd != '0' AND approve_nae != '0' AND approve_nom != '0' ORDER BY contract_id DESC LIMIT 1";
		// $sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ?';
		$binds = array($nip);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_last_active_pkwt_bynip_array($nip)
	{
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		$this->db->where('employee_id', $nip);
		$this->db->where('status_pkwt', '1');
		$this->db->where('cancel_stat', '0');
		$this->db->where('approve_hrd !=', '0');
		$this->db->where('approve_nae !=', '0');
		$this->db->where('approve_nom !=', '0');
		$this->db->order_by('contract_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get()->row_array();

		if (!empty($query)) {
			return $query;
		} else {
			return null;
		}
	}

	public function read_last_request_pkwt_bynip_array($nip)
	{
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		$this->db->where('employee_id', $nip);
		$this->db->where('status_pkwt', '0');
		$this->db->where('cancel_stat', '0');
		$this->db->where('approve_hrd', '0');
		$this->db->where('approve_nae', '0');
		$this->db->where('approve_nom', '0');
		$this->db->order_by('contract_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get()->row_array();

		if (!empty($query)) {
			return $query;
		} else {
			return null;
		}
	}

	// get single employee
	public function read_info_ratecard($proj, $posi, $area)
	{

		$sql = 'SELECT * FROM xin_employee_ratecard WHERE project_id = ? AND posisi_jabatan = ? AND kota = ?';
		$binds = array($proj, $posi, $area);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// monitoring request
	public function get_monitoring_pkwt($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE approve_hrd = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC LIMIT 50";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_apnae($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae = 0
			AND cancel_stat = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_cancel($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND cancel_stat = 1
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_apnom($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_aphrd($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom != 0
			AND approve_hrd = 0
			AND cancel_stat = 0
	        -- AND project in (8,97,90,106,94,46,74)
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC
			LIMIT 0";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_aphrdpro($empID, $project)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom != 0
			AND approve_hrd = 0
			AND cancel_stat = 0
	        -- AND project in (8,97,90,106,94,46,74)
	        AND project = '$project'
	        LIMIT 100";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_pkwt_history($empID)
	{

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND status_pkwt = 1
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}



	public function read_pkwt_pengajuan($id)
	{

		$sql = 'SELECT employee_id FROM xin_employee_contract WHERE status_pkwt = 0 AND approve_nae != 0 AND approve_nom != 0 AND approve_hrd = 0 AND cancel_stat = 0 AND employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// monitoring request
	public function report_pkwt_history_null($empID)
	{
		$today_date = date('Y-m-d');
		$sql = "SELECT uniqueid, contract_id, employee_id, project, sub_project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE date_format(approve_hrd_date, '%Y-%m-%d') = '$today_date' 
			AND approve_nom !=0
			AND approve_hrd != 0
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			AND employee_id = 0";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function report_pkwt_history_all($empID, $datefrom, $enddate)
	{

		$sql = "SELECT uniqueid, contract_id, employee_id, project, sub_project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND approve_hrd != 0
			-- AND date_format(approve_hrd_date, '%Y-%m-%d') = '$datefrom'  
			AND DATE_FORMAT(approve_hrd_date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$enddate'
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function report_pkwt_history($empID, $project_id, $datefrom, $enddate)
	{

		$sql = "SELECT uniqueid, contract_id, employee_id, project, sub_project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND approve_hrd != 0
			AND project = '$project_id'
			-- AND date_format(approve_hrd_date, '%Y-%m-%d') = '$datefrom'  
			AND DATE_FORMAT(approve_hrd_date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$enddate'
			-- AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	/*
	* persiapan data untuk datatable pagination
	* data list pkwt expired
	* 
	* @author Fadla Qamara
	*/
	function pkwt_expired_list2($postData = null)
	{
		$role_resources_ids = $this->Xin_model->user_role_resource();

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
		$project = $postData['project'];
		$periode = $postData['periode'];
		$session_id = $postData['session_id'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (project_name like '%" . $searchValue .  "%' or sub_project_name like '%" . $searchValue . "%') ";
		}

		## Filter
		$filterProject = "";
		if (($project != null) && ($project != "") && ($project != '0')) {
			$filterProject = "(
				project_id = " . $project . "
			)";
		} else {
			$filterProject = "";
		}

		$filterPeriode = "";
		if (($periode != null) && ($periode != "") && ($periode != '0')) {
			$filterPeriode = "(
				(DATE_SUB(to_date, INTERVAL $periode DAY)) < CURDATE()
			)";
		} else {
			$filterPeriode = "";
		}

		$filterPeriode = "(
			(DATE_SUB(to_date, INTERVAL 3 DAY)) < CURDATE()
		)";

		// $filterPeriode = "";

		## Kondisi Default 
		$kondisiDefaultQuery = "project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")";
		// $kondisiDefaultQuery = "(
		// 	karyawan_id = " . $emp_id . "
		// AND	pkwt_id = " . $contract_id . "
		// )";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterPeriode != '') {
			$this->db->where($filterPeriode);
		}
		$this->db->where($kondisiDefaultQuery);
		// (SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)
		$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id) WHERE ( (DATE_SUB(to_date, INTERVAL 7 DAY)) < CURDATE() )) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(SELECT MAX(contract_id), to_date, employee_id FROM xin_employee_contract GROUP BY employee_id) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(select max(id) as maxid from xin_saltab_bulk_release group by project_id,sub_project_id,periode_salary) b', 'a.id = b.maxid', 'inner');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		$records = $this->db->get('xin_employees a')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterPeriode != '') {
			$this->db->where($filterPeriode);
		}
		$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id) WHERE ( (DATE_SUB(to_date, INTERVAL 7 DAY)) < CURDATE() )) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(SELECT MAX(contract_id), to_date, employee_id FROM xin_employee_contract GROUP BY employee_id) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		$records = $this->db->get('xin_employees a')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('a.first_name');
		$this->db->select('a.employee_id');
		$this->db->select('a.project_id');
		$this->db->select('a.sub_project_id');
		$this->db->select('a.designation_id');
		$this->db->select('a.penempatan');
		$this->db->select('b.contract_id');
		$this->db->select('to_date');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterPeriode != '') {
			$this->db->where($filterPeriode);
		}
		$this->db->join('(SELECT contract_id, employee_id, from_date, to_date FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->join('(SELECT MAX(contract_id) as contract_id, to_date, employee_id FROM xin_employee_contract GROUP BY employee_id) b', 'a.employee_id = b.employee_id', 'left');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		// $this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_employees a')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			// $nama_download_bpjs = "";
			// if (empty($record->down_bpjs_by) || ($record->down_bpjs_by == "")) {
			// 	$nama_download_bpjs = "";
			// } else {
			// 	$nama_download_bpjs = "<BR> <span style='color:#3F72D5;'>" . $this->Employees_model->get_nama_karyawan_by_nip($record->down_bpjs_by) . ' [' . $this->Xin_model->tgl_indo($record->down_bpjs_on) . ']' . "</span>";
			// }

			// $periode_salary = "";
			// if (empty($record->periode_salary) || ($record->periode_salary == "")) {
			// 	$periode_salary = "--";
			// } else {
			// 	$periode_salary = $this->Xin_model->tgl_indo($record->periode_salary) . $nama_download_bpjs;
			// }

			// if (empty($record->eslip_release) || ($record->eslip_release == "")) {
			// 	$eslip_release = "";
			// } else {
			// 	$eslip_release = "<p>&#x2705;</p>";
			// }


			// $text_periode_from = "";
			// $text_periode_to = "";
			// $text_periode = "";
			// if (empty($record->periode_cutoff_from) || ($record->periode_cutoff_from == "")) {
			// 	$text_periode_from = "";
			// } else {
			// 	$text_periode_from = $this->Xin_model->tgl_indo($record->periode_cutoff_from);
			// }
			// if (empty($record->periode_cutoff_to) || ($record->periode_cutoff_to == "")) {
			// 	$text_periode_to = "";
			// } else {
			// 	$text_periode_to = $this->Xin_model->tgl_indo($record->periode_cutoff_to);
			// }
			// if (($text_periode_from == "") && ($text_periode_to == "")) {
			// 	$text_periode = "";
			// } else {
			// 	$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			// }

			//cek apakah sudah release eslip
			// $release_eslip = "<span style='color:#FF0000;'>Belum Release Eslip</span>";
			// if (empty($record->eslip_release) || ($record->eslip_release == "")) {
			// 	if (in_array('1100', $role_resources_ids)) {
			// 		$release_eslip = $release_eslip . '<button type="button" onclick="releaseEslip(' . $record->id . ')" class="btn btn-xs btn-outline-primary ml-1 mt-1" >Release Eslip</button>';
			// 	}
			// } else {
			// 	$release_eslip = "Tanggal terbit: " . $this->Xin_model->tgl_indo($record->eslip_release);
			// 	$release_eslip = $release_eslip . '<button type="button" onclick="detailReleaseEslip(' . $record->id . ')" class="btn btn-xs btn-outline-success ml-1 mt-1" >Detail Info</button>';
			// }

			//hitung dokumen ke-
			// $dokumen_ke = $this->get_jumlah_dokumen_salatab_sama($record->project_id,$record->sub_project_id,$record->periode_salary);
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchSaltabRelease(' . $record->contract_id . ')" class="btn btn-block btn-sm btn-outline-twitter" >VIEW</button>';
			$download_nip_kosong = '<button type="button" onclick="downloadBatchSaltabReleaseNIPKosong(' . $record->contract_id . ')" class=" btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> NIP Kosong</button>';
			$download_raw = '<button type="button" onclick="downloadBatchSaltabRelease(' . $record->contract_id . ')" class=" btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Raw Data</button>';
			$download_BPJS = '<button type="button" onclick="downloadBatchSaltabReleaseBPJS(' . $record->contract_id . ')" class="btn btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Data BPJS</button>';
			$download_Payroll = '<button type="button" onclick="downloadBatchSaltabReleasePayroll(' . $record->contract_id . ')" class="btn btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Data Payroll</button>';
			$delete = '<button type="button" onclick="deleteBatchSaltabRelease(' . $record->contract_id . ')" class="btn btn-block btn-sm btn-outline-danger" >DELETE</button>';

			$button_download = '<div class="btn-group mt-2" style="width:100%">
      			<button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-toggle="dropdown">
      				DOWNLOAD <span class="caret"></span></button>
      				<ul class="dropdown-menu" role="menu" style="width: 100%;background-color:#faf7f0;">
					<span style="color:#3F72D5;">DOWNLOAD OPTION:</span>
        				<li class="mb-1">' . $download_nip_kosong . '</li>
        				<li class="mb-1">' . $download_raw . '</li>
						<li class="mb-1">' . $download_BPJS . '</li>
						<li class="mb-1">' . $download_Payroll . '</li>
      				</ul>
    		</div>';


			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . $button_download,
				// "aksi" => $view . $button_download . "<br>" . $tes_query,
				// "aksi" => $view . " " . $download_nip_kosong . " " . $download_raw . " " . $download_BPJS . " " . $download_Payroll,
				// "periode_salary" => $periode_salary . "<br>" . $tes_query,
				"status_pkwt" => $record->contract_id,
				"employee_id" => $record->employee_id,
				"first_name" => $record->first_name,
				"project_name" => $record->project_id,
				"sub_project_name" => $record->sub_project_id,
				"jabatan_name" => $record->designation_id,
				"penempatan" => $record->penempatan,
				"kontrak_terakhir" => $record->to_date,
				// $this->get_nama_karyawan($record->upload_by)
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

	// monitoring request
	public function report_pkwt_expired_default($empID)
	{
		// $today_date = date('Y-m-d');
		$sql = "

		SELECT emp.user_id, emp.employee_id, emp.first_name, empct.project, empct.sub_project, empct.jabatan, emp.contact_no, empct.contract_id, empct.penempatan, empct.from_date, empct.to_date, empct.approve_hrd_date, empct.upload_pkwt, empct.file_name
		FROM xin_employees emp 
		LEFT JOIN ( 
		    SELECT con.contract_id, con.employee_id, con.project, con.sub_project, con.jabatan, con.penempatan, con.from_date, con.to_date, con.approve_hrd_date, con.upload_pkwt, con.file_name 
		    FROM xin_employee_contract con 
		    WHERE con.contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id) AND con.project = 00) empct 
		ON empct.employee_id = emp.employee_id 
		WHERE emp.user_id=00;";

		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function report_pkwt_expired_key($key, $empID)
	{
		// $today_date = date('Y-m-d');
		$sql = "

		SELECT emp.user_id, emp.employee_id, emp.first_name, empct.project, empct.sub_project, empct.jabatan, emp.contact_no, empct.contract_id, empct.penempatan, empct.from_date, empct.to_date, empct.approve_hrd_date, empct.upload_pkwt, empct.file_name
		FROM xin_employees emp 
		LEFT JOIN ( 
		    SELECT con.contract_id, con.employee_id, con.project, con.sub_project, con.jabatan, con.penempatan, con.from_date, con.to_date, con.approve_hrd_date, con.upload_pkwt, con.file_name 
		    FROM xin_employee_contract con 
		    WHERE con.contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) empct 
		ON empct.employee_id = emp.employee_id 
		WHERE emp.status_employee = 1
        AND CONCAT(emp.employee_id,emp.first_name) LIKE '%$key%'";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function report_pkwt_expired_pro($project, $downtime, $empID)
	{
		// $today_date = date('Y-m-d');
		$sql = "

		SELECT emp.user_id, emp.employee_id, emp.first_name, empct.project, empct.sub_project, empct.jabatan, emp.contact_no, empct.contract_id, empct.penempatan, empct.from_date, empct.to_date, empct.approve_hrd_date, empct.upload_pkwt, empct.file_name
		FROM xin_employees emp 
		LEFT JOIN ( 
		    SELECT con.contract_id, con.employee_id, con.project, con.sub_project, con.jabatan, con.penempatan, con.from_date, con.to_date, con.approve_hrd_date, con.upload_pkwt, con.file_name 
		    FROM xin_employee_contract con 
		    WHERE con.contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id) AND con.project = $project) empct 
		ON empct.employee_id = emp.employee_id 
		WHERE emp.project_id = $project 
		AND (DATE_SUB(empct.to_date, INTERVAL $downtime DAY)) < CURDATE() 
		AND emp.status_employee = 1;
		";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_all_employees_byproject_exp($id)
	{
		$query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, project_id, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign = 1
		AND employee_id IN (
				SELECT empc.employee_id AS nip 
				FROM (
					SELECT contract_id, employee_id, max(to_date) AS to_date FROM xin_employee_contract group by employee_id ORDER BY contract_id DESC
					) empc
				WHERE (DATE_SUB(empc.to_date, INTERVAL 1 MONTH)) < CURDATE() 
				GROUP BY empc.employee_id
				ORDER BY empc.contract_id DESC
			)
		AND project_id = '$id'
		ORDER BY date_of_leaving DESC");
		return $query->result();
	}

	// get single pkwt by nosurat
	public function read_pkwt_info_by_contractid($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single pkwt by nosurat
	public function read_pkwt_info_by_nosurat($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE no_surat = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single pkwt by nosurat
	public function read_pkwt_info_by_docid($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE docid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_esign_all()
	{

		// $sql = 'SELECT * FROM xin_documents_qrcode WHERE employee_id not IN (1)';
		$sql = 'SELECT * FROM xin_documents_qrcode ORDER BY secid DESC';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get single employee
	public function read_esign_doc($id)
	{

		$sql = 'SELECT * FROM xin_documents_qrcode WHERE doc_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_single_pkwt($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function get_single_pkwt_array($id)
	{
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		$this->db->where('contract_id', $id);
		$query = $this->db->get()->row_array();

		return $query;
	}

	// Function to update record in table
	public function update_pkwt_edit($data, $id)
	{
		$this->db->where('contract_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_pkwt_apnae($data, $id)
	{
		$this->db->where('contract_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_pkwt_aphrd($data, $id)
	{
		$this->db->where('contract_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			//sekalian update employee
			$detail_pkwt = $this->get_single_pkwt_array($id);
			$data_update_employee = array(
				'project_id' =>  $detail_pkwt['project'],
				'sub_project_id' =>  $detail_pkwt['sub_project'],
				'designation_id' =>  $detail_pkwt['jabatan'],
				'penempatan' =>  $detail_pkwt['penempatan'],
				'company_id' =>  $detail_pkwt['company'],
				'e_status' => $detail_pkwt['contract_type_id'],
				'contract_id' =>  $detail_pkwt['contract_id'],
				'contract_start' =>  $detail_pkwt['from_date'],
				'contract_end' =>  $detail_pkwt['to_date'],
				'contract_periode' =>  $detail_pkwt['waktu_kontrak'],
				'hari_kerja' =>  $detail_pkwt['hari_kerja'],
				'basic_salary' =>  $detail_pkwt['basic_pay'],
			);
			if ($this->Employees_model->update_pkwt_employee($data_update_employee, $detail_pkwt['employee_id'])) {
				return true;
			} else {
				$data_up = array(
					'sign_nip'	=> null,
					'sign_fullname' => null,
					'sign_jabatan' => null,
					'status_pkwt' => null,
					'approve_hrd' =>  null,
					'approve_hrd_date' => null,
				);
				$this->db->where('contract_id', $id);
				if ($this->db->update('xin_employee_contract', $data_up)) {
					return false;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_pkwt_status($data, $id)
	{
		$this->db->where('employee_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_pkwt_docid($data, $id)
	{
		$this->db->where('docid', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > basic_info
	public function update_error_temp($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employee_contract_temp', $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function get_taxes()
	{
		return $this->db->get("xin_tax_types");
	}


	// get single pkwt by userid
	public function get_single_pkwt_by_userid($id)
	{

		$sql = "SELECT * FROM xin_employee_contract WHERE employee_id = ? AND status_pkwt = 1 ORDER BY contract_id DESC LIMIT 1";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_pkwt_by_userid($id)
	{
		$query = $this->db->query(
			"

SELECT contract.contract_id, contract.no_surat, contract.employee_id, contract.from_date, contract.to_date, pdf.document_file, pdf.createdat
FROM xin_employee_contract contract
LEFT JOIN ( SELECT * FROM xin_employee_contract_pdf GROUP BY kontrak_id) pdf ON pdf.kontrak_id = contract.contract_id
WHERE contract.employee_id = '$id'
"

		);
		return $query->result();
	}




	// get single pkwt by userid
	public function get_pkwt_file($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract_pdf WHERE kontrak_id = ? ORDER BY secid DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	public function get_montly_expired_pkwt($empID)
	{
		$query = $this->db->query("SELECT pros.project_id, CONCAT('[',pro.priority,']', ' ', pro.title) AS title
		FROM xin_projects_akses pros
		LEFT JOIN xin_projects pro ON pro.project_id = pros.project_id
		WHERE pros.nip = '$empID'
		GROUP BY pros.project_id");
		return $query->result();
	}

	// Function to update record in table
	public function update_pkwt_record($data, $id)
	{
		$this->db->where('contract_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}
}

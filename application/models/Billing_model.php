<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_projects()
	{
		return $this->db->get("xin_projects");
	}


	public function get_akses_projects()
	{
		return $this->db->get("xin_projects_akses");
	}


	public function get_region_billing($empID)
	{
		$query = $this->db->query("SELECT DISTINCT(billing_area) as billing_area FROM xin_saltab order by billing_area asc");
				return $query->result();
	}

	public function get_am_billing($empID)
	{
		$query = $this->db->query("SELECT DISTINCT(nama_am) as nama_am FROM xin_saltab order by nama_am asc");
				return $query->result();
	}

	public function get_periode_billing($empID)
	{
		$query = $this->db->query("SELECT DISTINCT(DATE_FORMAT(periode_salary, '%Y-%m')) as periode FROM xin_saltab_bulk_release ORDER BY periode DESC LIMIT 12");
				return $query->result();
	}

	// monitoring request
	public function list_akses_project()
	{

		$sql = "SELECT pa.secid, pa.nip, emp.first_name, pos.designation_name, pro.title, pro.priority
					FROM (SELECT secid, nip, project_id FROM `xin_projects_akses` ORDER by secid DESC limit 10) pa
					LEFT JOIN xin_employees emp ON emp.employee_id = pa.nip
					LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
					LEFT JOIN xin_projects pro ON pro.project_id = pa.project_id;";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function list_akses_project_nip($nip)
	{

		$sql = "SELECT pa.secid, pa.nip, emp.first_name, pos.designation_name, pro.title, pro.priority
				FROM (SELECT secid, nip, project_id FROM `xin_projects_akses` WHERE nip = '$nip' ORDER by secid DESC) pa
				LEFT JOIN xin_employees emp ON emp.employee_id = pa.nip
				LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
				LEFT JOIN xin_projects pro ON pro.project_id = pa.project_id;";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	// monitoring request
	public function list_project_posisi()
	{

		$sql = "SELECT mappos.secid,mappos.project_id, CONCAT('[',pro.priority,']', ' ', pro.title) AS title, mappos.sub_project, prosub.sub_project_name, prosub.sub_active, mappos.posisi, pos.designation_name
			FROM xin_projects_posisi mappos
			LEFT JOIN xin_projects_sub prosub ON prosub.secid = mappos.sub_project
			LEFT JOIN xin_projects pro ON pro.project_id = prosub.id_project
			LEFT JOIN xin_designations pos ON pos.designation_id = mappos.posisi
			ORDER BY mappos.secid DESC
			LIMIT 10;";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employees
	public function all_projects_admin()
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title from xin_projects ORDER BY project_id DESC");
		return $query->result();
	}

	// get all employees
	public function all_projects()
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title from xin_projects WHERE project_id not in (22, 95) ORDER BY project_id DESC;");
		return $query->result();
	}

	// get all employees
	public function all_jabatan()
	{
		$query = $this->db->query("SELECT designation_id, CONCAT('[',level,']', ' ', designation_name) as designation_name  FROM xin_designations");
		return $query->result();
	}

	// get all employees
	public function get_project_emprequest()
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title from xin_projects WHERE project_id not in (22, 95);");
		return $query->result();
	}



	function get_list_billing($postData = null)
	{

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
		$periode 		= $postData['periode'];
		$am 			= $postData['am'];
		$region 		= $postData['region'];
		$session_id 	= $postData['session_id'];

		// if ($periode == "0") {
			## Search 
			$searchQuery = "";
			if ($searchValue != '') {
				if (strlen($searchValue) >= 3) {
					$searchQuery = " (xin_saltab.billing_area like '%" . $searchValue .  "%' 
					or xin_saltab.nama_am like '%" . $searchValue . "%') ";
				}
			}

			$filterPeriode = "";
			if (($periode != null) && ($periode != "") && ($periode != "0")) {
				$filterPeriode = "DATE_FORMAT(xin_saltab_bulk_release.periode_salary, '%Y-%m') = '".$periode."'";
			} else {
				$filterPeriode = "";
			}

			$kondisiDefaultQuery = "";

			## Total number of records without filtering
			$this->db->select('count(*) as allcount');
			// if ($filterProject != '') {
			// 	$this->db->where($filterProject);
			// }
			// if ($filterSubProject != '') {
			// 	$this->db->where($filterSubProject);
			// }
			if ($filterPeriode != '') {
				$this->db->where($filterPeriode);
			}
			// $dbtraxes->where($kondisiDefaultQuery);
			$this->db->join('xin_saltab_bulk_release', 'xin_saltab_bulk_release.id = xin_saltab.uploadid', 'left');
			// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			// $this->db->group_by('xin_saltab_bulk_release.project_id');
			$this->db->group_by('xin_saltab.billing_area');
			$records = $this->db->get('xin_saltab')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(*) as allcount');
			// $dbtraxes->where($kondisiDefaultQuery);
			if ($searchQuery != '') {
				$this->db->where($searchQuery);
			}
			$filterPeriode = "";
			if (($periode != null) && ($periode != "") && ($periode != "0")) {
				$filterPeriode = "DATE_FORMAT(xin_saltab_bulk_release.periode_salary, '%Y-%m') = '".$periode."'";
			} else {
				$filterPeriode = "";
			}
			// if ($filterSubProject != '') {
			// 	$this->db->where($filterSubProject);
			// }
			if ($filterPeriode != '') {
				$this->db->where($filterPeriode);
			}
			$this->db->join('xin_saltab_bulk_release', 'xin_saltab_bulk_release.id = xin_saltab.uploadid', 'left');
			// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			// $this->db->group_by('xin_saltab_bulk_release.project_id');
			$this->db->group_by('xin_saltab.billing_area');
			$records = $this->db->get('xin_saltab')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$this->db->select("DATE_FORMAT(xin_saltab_bulk_release.periode_salary, '%Y-%m') AS periode_salary ");
			$this->db->select('xin_saltab.nip_am');
			$this->db->select('xin_saltab.nama_am');
			$this->db->select('xin_saltab.billing_area');
			$this->db->select('xin_saltab_bulk_release.project_id');
			$this->db->select('xin_saltab_bulk_release.project_name');
			$this->db->select("COUNT(xin_saltab.secid) AS total_mpp");
			$this->db->select("SUM(xin_saltab.total_thp) AS total_thp");

			// $this->db->select('tx_cio.date_cio');
			if ($searchQuery != '') {
				$this->db->where($searchQuery);
			}
			$filterPeriode = "";
			if (($periode != null) && ($periode != "") && ($periode != "0")) {
				$filterPeriode = "DATE_FORMAT(xin_saltab_bulk_release.periode_salary, '%Y-%m') = '".$periode."'";
			} else {
				$filterPeriode = "";
			}
			// if ($filterSubProject != '') {
			// 	$this->db->where($filterSubProject);
			// }
			if ($filterPeriode != '') {
				$this->db->where($filterPeriode);
			}


			$this->db->join('xin_saltab_bulk_release', 'xin_saltab_bulk_release.id = xin_saltab.uploadid', 'left');
			// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			// $this->db->group_by('xin_saltab_bulk_release.project_id');
			$this->db->group_by('xin_saltab.billing_area');
			$this->db->limit($rowperpage, $start);
			$records = $this->db->get('xin_saltab')->result();

			#Debugging variable
			$tes_query = $this->db->last_query();
			// print_r($tes_query);
			// echo "<script>console.log('Debug Objects: " . $tes_query . "' );</script>";
			$data = array();


			foreach ($records as $record) {

				//cek interviewer
				// $nik_validation = "0";
				// $jo_interviewer = $this->Jo_model->get_jo_interviewer($record->id_screening);
				// if (is_null($jo_interviewer)) {
				// 	$nama_interviewer = "-";
				// } else {
				// 	$nama_interviewer = $nama_interviewer['interview_rto_by_name'];
				// }

				$totalthp = 'Rp. '.$this->Xin_model->rupiah_titik($record->total_thp).'-,';


				$data[] = array(
					"periode" 		=> $record->periode_salary,
					"nip_am" 		=> strtoupper($record->nip_am),
					"nama_am" 		=> strtoupper($record->nama_am),
					"billing_area" 	=> strtoupper($record->billing_area),
					"project_name" 	=> strtoupper($record->project_name),
					"total_mpp" 	=> $record->total_mpp,
					"total_billing" => $totalthp,
					"fee_percen" 	=> '8%',
					"fee_value" 	=> "0",
					"total" 		=> "0"
				);

			}
		// } 
		// else {
		// 	$totalRecords = 0;
		// 	$totalRecordwithFilter = 0;
		// 	$data = array();
		// }


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



	public function read_project_information($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	//ambil data employee berdasarkan NIK dari table employee
	public function get_document_id($postData)
	{
		//$otherdb = $this->load->database('default', TRUE);

		$this->db->select('*');
		$this->db->from('xin_projects');
		$this->db->where('project_id', $postData['project']);

		$query = $this->db->get()->result_array();

		// $this->db->select('*');
		// $this->db->from('xin_projects');
		// $this->db->where('project_id', $id);

		// $query = $this->db->get()->row_array();

		//print_r($this->db->last_query());

		return $query;
	}

	public function read_all_project_information($id)
	{

		//$sql = 'SELECT * FROM xin_projects WHERE project_id = ?';
		$sql = 'SELECT * FROM xin_projects';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_all_sub_project_information($id)
	{

		//$sql = 'SELECT * FROM xin_projects WHERE project_id = ?';
		$sql = 'SELECT * FROM xin_projects_sub';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single project by id
	public function read_single_project($id)
	{

		$sql = "SELECT CONCAT('[ ',priority,' ] ',title) title FROM xin_projects WHERE project_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single project by id
	public function read_single_project_name($id)
	{

		$sql = "SELECT title FROM xin_projects WHERE project_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single project by id
	public function getcomp_single_project($id)
	{

		$sql = "SELECT company_id, title, doc_id FROM xin_projects WHERE project_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get all designation
	public function get_designations()
	{
		$query = $this->db->query("SELECT * from xin_designations");
		return $query->result();
	}

	public function read_project_posisi_ho()
	{
		$query = $this->db->query("SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp
LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE company_id = '2' AND pp.project_id in (22)  ORDER BY `title` ASC;");
		return $query->result();
	}

	public function read_project_posisi()
	{
		$query = $this->db->query("SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp
LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE company_id = '2' AND npro.doc_id=1  ORDER BY `title` ASC;");
		return $query->result();
	}


	public function read_project_posisi_kac()
	{
		$query = $this->db->query("SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp
LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE company_id = '3' AND npro.doc_id=1  ORDER BY `title` ASC;");
		return $query->result();
	}

	public function read_project_posisi_mata()
	{
		$query = $this->db->query("SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp
LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE company_id = '4' AND npro.doc_id=1  ORDER BY `title` ASC;");
		return $query->result();
	}


	public function read_project_posisi_tkhl()
	{
		$query = $this->db->query("SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp
LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE npro.doc_id=2  ORDER BY `title` ASC;");
		return $query->result();
	}

	public function get_project_bycompany($id, $empID)
	{
		$query = $this->db->query("SELECT * FROM xin_projects 
	  	WHERE company_id = '$id' 
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
	  	ORDER BY title ASC;");
		return $query->result();
	}




	// get single project by id
	public function read_single_subproject($id)
	{

		$sql = 'SELECT * FROM xin_projects_sub WHERE secid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single project by id
	public function read_project_by_subproject($idsub)
	{

		$sql = "SELECT * FROM xin_projects_sub WHERE secid = ? LIMIT 1";
		$binds = array($idsub);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_project_exist_all()
	{
		$query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, CONCAT('[ ',proj.priority,' ] ',proj.title) title 
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.project_id NOT IN (0)
		AND emp.status_employee = 0
		ORDER BY proj.title");
		return $query->result();
	}

	public function get_project_exist_deactive($empID)
	{
		$query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, CONCAT('[',proj.priority,']', ' ', proj.title) AS title 
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		AND emp.status_employee = 0
		ORDER BY proj.title");
		return $query->result();
	}


	public function get_project_ratecard_all_()
	{
		$query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, proj.title 
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.project_id NOT IN (0)
		AND emp.status_employee = 1
		AND emp.project_id in (
				select distinct(project_id) as project_id FROM xin_employee_ratecard WHERE status_ratecard = '1'
			)
		ORDER BY proj.title");
		return $query->result();
	}

	public function get_project_pkwt_exp()
	{
		$query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, proj.title 
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.project_id NOT IN (0)
		AND emp.status_employee = 1
		AND emp.project_id in (
				select distinct(project_id) as project_id 
				FROM xin_employee_ratecard 
				WHERE status_ratecard = '1'
				AND project_id IN (
					SELECT DISTINCT(project) AS project_id FROM xin_employee_contract
					WHERE (DATE_SUB(to_date, INTERVAL 1 MONTH)) < CURDATE()
				)
			)
		ORDER BY proj.title;");
		return $query->result();
	}

	public function get_project_exist()
	{
		$query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, proj.title FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.project_id NOT IN (22,23)
		AND emp.status_employee = 1
		ORDER BY proj.title");
		return $query->result();
	}


	// Ambil semua PT yang ada di database
	public function get_all_pts()
	{
		$this->db->select('id, pt');
		$query = $this->db->get('mt_budget_target');  // Ganti 'pt_table' dengan nama tabel yang sesuai
		return $query->result();
	}

	public function get_all_areas()
	{
		$this->db->select('id, area'); // sesuaikan dengan nama kolom di tabelmu
		$query = $this->db->get('mt_budget_target');        // sesuaikan dengan nama tabel di database
		return $query->result();
	}


	public function get_project_maping($empID)
	{
		$query = $this->db->query("SELECT pros.project_id, CONCAT('[',pro.priority,']', ' ', pro.title) AS title
FROM xin_projects_akses pros
LEFT JOIN xin_projects pro ON pro.project_id = pros.project_id
WHERE pros.nip = '$empID'
GROUP BY pros.project_id");
		return $query->result();
	}


	public function get_project_brand()
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title
FROM xin_projects
ORDER BY title ASC");
		return $query->result();
	}

	public function get_sub_project_filter($project_id)
	{
		$query = $this->db->query("SELECT * FROM xin_projects_sub WHERE id_project = '$project_id' ORDER BY sub_project_name");
		return $query->result();
	}


	// public function get_dokumen_skk($nip)
	// {
	// 	$query = $this->db->query("SELECT * FROM xin_qrcode_skk WHERE nip = '$nip' LIMIT 1;");
	// 	return $query->result();
	// }


	// get single employee
	public function get_dokumen_skk($nip)
	{

		$sql = 'SELECT * FROM xin_qrcode_skk WHERE nip = ?';
		// $sql = 'SELECT * FROM xin_employee_contract WHERE uniqueid = ?';
		$binds = array($nip);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// check email
	// public function cek_jenis_dokumen($id)
	// {

	// 	$sql = "SELECT doc_id FROM xin_projects WHERE project_id = ?";
	// 	$binds = array($id);
	// 	$query = $this->db->query($sql, $binds);
	// 	return $query->num_rows();
	// }


	// get single project by id
	public function cek_jenis_dokumen($id)
	{

		$sql = "SELECT doc_id FROM xin_projects WHERE project_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get employees list> reports
	public function project_list()
	{

		return $query = $this->db->query("SELECT * FROM xin_projects ORDER BY project_id DESC");
	}


	// get all employees
	public function get_sub_project_aktif()
	{
		$query = $this->db->query("SELECT psub.secid, CONCAT('[',pro.priority,']', ' ', pro.title,' - ', psub.sub_project_name) as title_sub
			FROM `xin_projects_sub` psub
			LEFT JOIN xin_projects pro ON pro.project_id = psub.id_project
			WHERE psub.sub_active=1");
		return $query->result();
	}

	// get single employee by NIP
	public function read_project_by_id($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to update record in table
	public function project_record($data, $id)
	{
		$this->db->where('project_id', $id);
		if ($this->db->update('xin_projects', $data)) {
			return true;
		} else {
			return false;
		}
	}


	// get task categories
	public function get_task_categories()
	{
		return $this->db->get("xin_task_categories");
	}
	public function get_project_timelogs($project_id)
	{
		$sql = "SELECT * FROM xin_projects_timelogs where project_id = ?";
		$binds = array($project_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_all_project_timelogs()
	{
		$sql = "SELECT * FROM xin_projects_timelogs";
		$query = $this->db->query($sql);
		return $query;
	}
	public function get_all_project_employee_timelogs($user_id)
	{
		$sql = "SELECT * FROM xin_projects_timelogs where employee_id = ?";
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_bug_information($id)
	{

		$sql = 'SELECT * FROM xin_projects_bugs WHERE bug_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single record > company | employees
	public function ajax_company_department($id)
	{

		$sql = "SELECT project_id, title FROM xin_projects WHERE company_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// check akses project
	public function check_mapping_posisi($subproject, $posisi)
	{

		$sql = 'SELECT * FROM xin_projects_posisi WHERE sub_project = ? AND posisi = ?';
		$binds = array($subproject, $posisi);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}


	// Function to add record in table
	public function add($data)
	{
		$this->db->insert('xin_projects', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_akses_project($data)
	{
		$this->db->insert('xin_projects_akses', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_mapping_posisi($data)
	{
		$this->db->insert('xin_projects_posisi', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_task_categories($data)
	{
		$this->db->insert('xin_task_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_project_timelog($data)
	{
		$this->db->insert('xin_projects_timelogs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_akses_project($id)
	{
		$this->db->where('secid', $id);
		$this->db->delete('xin_projects_akses');
	}

	// Function to Delete selected record from table
	public function delete_task_category_record($id)
	{
		$this->db->where('task_category_id', $id);
		$this->db->delete('xin_task_categories');
	}

	// get task category by id
	public function read_task_category_information($id)
	{

		$sql = 'SELECT * FROM xin_task_categories WHERE task_category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get timelog record by id
	public function read_timelog_info($id)
	{

		$sql = 'SELECT * FROM xin_projects_timelogs WHERE timelogs_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to update record in table
	public function update_task_category_record($data, $id)
	{
		$this->db->where('task_category_id', $id);
		if ($this->db->update('xin_task_categories', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table
	public function update_project_timelog_record($data, $id)
	{
		$this->db->where('timelogs_id', $id);
		if ($this->db->update('xin_projects_timelogs', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to Delete selected record from table
	public function delete_record($id)
	{
		$this->db->where('project_id', $id);
		$this->db->delete('xin_projects');
	}
	// Function to Delete selected record from table
	public function delete_timelog_record($id)
	{
		$this->db->where('timelogs_id', $id);
		$this->db->delete('xin_projects_timelogs');
	}

	// Function to Delete selected record from table
	public function delete_bug_record($id)
	{
		$this->db->where('bug_id', $id);
		$this->db->delete('xin_projects_bugs');
	}

	// get attachments > projects
	public function get_attachments($id)
	{

		$sql = 'SELECT * FROM xin_projects_attachment WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get clients projects
	public function get_client_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE client_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	public function get_all_projects()
	{
		$query = $this->db->query("SELECT * from xin_projects ORDER BY title ASC");
		return $query->result();
	}

	public function get_all_projects_sub()
	{
		$query = $this->db->query("SELECT * from xin_projects_sub ORDER BY sub_project_name ASC");
		return $query->result();
	}
	// Function to add record in table > add attachment
	public function add_new_attachment($data)
	{
		$this->db->insert('xin_projects_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_attachment_record($id)
	{
		$this->db->where('project_attachment_id', $id);
		$this->db->delete('xin_projects_attachment');
	}

	// get project discussion
	public function get_discussion($id)
	{

		$sql = 'SELECT * FROM xin_projects_discussion WHERE project_id = ? order by discussion_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get project bugs/issues
	public function get_bug($id)
	{

		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ? order by bug_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// Function to add record in table > add discussion
	public function add_discussion($data)
	{
		$this->db->insert('xin_projects_discussion', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > add bug
	public function add_bug($data)
	{
		$this->db->insert('xin_projects_bugs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_bug($data, $id)
	{
		$this->db->where('bug_id', $id);
		if ($this->db->update('xin_projects_bugs', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_record($data, $id)
	{
		$this->db->where('project_id', $id);
		if ($this->db->update('xin_projects', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// get single record > company | projects
	public function ajax_company_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single record > company | employees
	public function ajax_sub_project($id)
	{

		$sql = "SELECT * FROM xin_projects_sub WHERE id_project = ? AND sub_active = 1";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single record > company | employees
	public function ajax_area_employees($area, $sub, $pro)
	{

		$sql = "SELECT distinct(penempatan) as penempatan FROM xin_employees WHERE status_employee = 1 AND project_id = ? AND sub_project_id = ?";
		$binds = array($pro, $sub);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get total project tasks 
	public function total_project_tasks($id)
	{

		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get total project bugs 
	public function total_project_bugs($id)
	{

		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get total project files 
	public function total_project_files($id)
	{

		$sql = 'SELECT * FROM xin_projects_attachment WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get total project > deffered
	public function cancelled_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get calendar project > deffered
	public function calendar_cancelled_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > deffered
	public function calendar_cancelled_tasks()
	{

		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get total project > completed
	public function complete_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get calendar project > completed
	public function calendar_complete_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > completed
	public function calendar_complete_tasks()
	{

		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get total project > in progress
	public function inprogress_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get calendar project > in progress
	public function calendar_inprogress_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > in progress
	public function calendar_inprogress_tasks()
	{

		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get total project > not started
	public function not_started_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get calendar project > not started
	public function calendar_not_started_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > not started
	public function calendar_not_started_tasks()
	{

		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get total project > hold
	public function hold_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get calendar project > hold
	public function calendar_hold_projects()
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > hold
	public function calendar_hold_tasks()
	{

		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	//////////////////////////////	
	// get calendar project > hold
	public function calendar_user_hold_projects($id)
	{

		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar project > not started
	public function calendar_user_not_started_projects($id)
	{

		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar project > completed
	public function calendar_user_complete_projects($id)
	{

		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar project > in progress
	public function calendar_user_inprogress_projects($id)
	{

		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar project > deffered
	public function calendar_user_cancelled_projects($id)
	{

		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	///////////////////////////////////////
	//////////////////////////////	
	// get calendar tasks > hold
	public function calendar_user_hold_tasks($id)
	{

		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > not started
	public function calendar_user_not_started_tasks($id)
	{

		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > completed
	public function calendar_user_complete_tasks($id)
	{

		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > in progress
	public function calendar_user_inprogress_tasks($id)
	{

		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	// get calendar tasks > deffered
	public function calendar_user_cancelled_tasks($id)
	{

		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	///////////////////////////////////////
	//clients // get total project > deffered
	public function deffered_client_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(3, $id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	//clients // get total project > completed
	public function complete_client_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(2, $id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	//clients // get total project > in progress
	public function inprogress_client_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(1, $id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	//clients // get total project > not started
	public function not_started_client_projects($id)
	{

		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(0, $id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get all project tasks>completed
	public function completed_project_bugs($id)
	{

		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ? and status = ?';
		$binds = array($id, 1);
		$query = $this->db->query($sql, $binds);

		$cTasks = $query->num_rows();
		$pQuery = $this->total_project_bugs($id);
		if ($pQuery == 0) {
			return $ctTasks = 0;
		} else {
			// get actual data
			$calTasks = $cTasks / $pQuery * 100;
			$ctTasks = round($calTasks);
			return $ctTasks;
		}
	}

	// get all project tasks>completed
	public function completed_project_tasks($id)
	{

		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ? and task_status = ?';
		$binds = array($id, 2);
		$query = $this->db->query($sql, $binds);

		$cTasks = $query->num_rows();
		$pQuery = $this->total_project_tasks($id);
		if ($pQuery == 0) {
			return $ctTasks = 0;
		} else {
			// get actual data
			$calTasks = $cTasks / $pQuery * 100;
			$ctTasks = round($calTasks);
			return $ctTasks;
		}
	}
	// get company projects
	public function get_company_projects($company_id)
	{

		$sql = "SELECT * FROM xin_projects WHERE company_id like '%$id,%' or company_id like '%,$id%' or company_id = '$id'";
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get employee projects
	public function get_employee_projects($id)
	{

		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}


	// get company > projects
	public function ajax_proj_subproj_info($id)
	{

		$condition = "id_project =" . "'" . $id . "'" . " and sub_active=1";
		$this->db->select('*');
		$this->db->from('xin_projects_sub');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// get all employes
	public function get_employees()
	{

		$sql = 'SELECT * FROM xin_employees WHERE employee_id not IN (1)';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_employees_all()
	{

		$sql = 'SELECT emp.user_id, emp.employee_id, emp.ktp_no, emp.first_name, emp.project_id, pro.title, emp.last_login_date,
				emp.designation_id, pos.designation_name, emp.penempatan, emp.contact_no, emp.date_of_birth, emp.user_role_id, emp.date_of_joining
				FROM xin_employees emp
				LEFT JOIN xin_projects pro ON pro.project_id = emp.project_id
				LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
				WHERE emp.employee_id not IN (1)';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_employees_notho()
	{

		$sql = "SELECT emp.user_id, emp.employee_id, emp.ktp_no, emp.first_name, emp.project_id, pro.title,
				emp.designation_id, pos.designation_name, emp.penempatan, emp.contact_no, emp.date_of_birth, emp.user_role_id, emp.last_login_date, emp.private_code, emp.date_of_joining
				FROM xin_employees emp
				LEFT JOIN xin_projects pro ON pro.project_id = emp.project_id
				LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
				WHERE emp.employee_id not IN (1)
				-- AND emp.project_id not in (18)
				AND emp.project_id not in (22,95)
				";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	public function get_employees_who()
	{

		$sql = "SELECT emp.user_id, emp.employee_id, emp.ktp_no, emp.first_name, emp.project_id, pro.title,
				emp.designation_id, pos.designation_name, emp.penempatan, emp.contact_no, emp.date_of_birth, emp.user_role_id, emp.last_login_date, emp.private_code, emp.date_of_joining
				FROM xin_employees emp
				LEFT JOIN xin_projects pro ON pro.project_id = emp.project_id
				LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
				WHERE emp.employee_id not IN (1)";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_all_employees_all()
	{
		$query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND  status_resign = 1
		AND employee_id not IN (SELECT 1 AS nip FROM DUAL)
		AND project_id = 50
		ORDER BY date_of_leaving DESC;");
		return $query->result();
	}


	public function get_all_employees_byproject($id)
	{
		$query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, project_id, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign = 1
		AND employee_id not IN (SELECT 1 AS nip FROM DUAL
			UNION
			SELECT employee_id AS nip FROM xin_employee_contract WHERE status_pkwt = 1)
		AND project_id = '$id'
		ORDER BY date_of_leaving DESC;");
		return $query->result();
	}

	// get all employees
	public function get_employees_aktif()
	{
		$query = $this->db->query("SELECT emp.user_id, emp.employee_id, emp.first_name
			FROM xin_employees emp
			LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
			WHERE pos.level not in ('E1','E2')
			AND emp.status_resign = 1");
		return $query->result();
	}


	public function get_empdeactive_byproject($id)
	{
		$query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, project_id, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign in (2,3,4,5)
		AND approve_resignhrd is null
		AND project_id = '$id'
		ORDER BY date_of_leaving DESC;");
		return $query->result();
	}

	// AND employee_id not IN (SELECT 1 AS nip FROM DUAL
	// 	UNION
	// 	SELECT employee_id AS nip FROM xin_employee_contract WHERE status_pkwt in (0,1))


	public function get_all_employees_byposisi($id)
	{
		$query = $this->db->query("SELECT posisi_jabatan FROM xin_employee_ratecard WHERE project_id = '19' AND status_ratecard = '1';");
		return $query->result();
	}

	public function get_all_employees_byarea($id)
	{
		$query = $this->db->query("SELECT distinct(kota) as area FROM xin_employee_ratecard WHERE project_id = '19' AND status_ratecard = '1';");
		return $query->result();
	}


	public function get_all_employees_project()
	{
		$query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND  status_resign = 1
		AND project_id NOT IN (22)
		AND employee_id not IN (SELECT 1 AS nip FROM DUAL)
		ORDER BY date_of_leaving DESC;");
		return $query->result();
	}

	// monitoring request
	public function get_monitoring_daftar_ho()
	{

		$sql = "SELECT *
				FROM xin_employee_request
				WHERE datediff(current_date(),DATE_FORMAT(createdon, '%Y-%m-%d')) <=20
				AND request_empby = '1'
				AND project = '22'
				AND e_status = '1'
				ORDER BY secid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_daftar()
	{

		$sql = "SELECT emp.secid, emp.fullname,emp.contact_no,emp.project,emp.createdon,pro.title
				FROM xin_employee_request emp
				LEFT JOIN xin_projects pro ON pro.project_id = emp.project
				WHERE datediff(current_date(),DATE_FORMAT(emp.createdon, '%Y-%m-%d')) <=7
				AND emp.request_empby = '1'
				AND e_status IN (1,2)
				ORDER BY secid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_daftar_tkhl()
	{

		$sql = "SELECT emp.fullname,emp.contact_no,emp.project,emp.createdon,pro.title
				FROM xin_employee_request emp
				LEFT JOIN xin_projects pro ON pro.project_id = emp.project
				WHERE datediff(current_date(),DATE_FORMAT(emp.createdon, '%Y-%m-%d')) <=10
				AND emp.request_empby = '1'
				AND e_status = '1'
				ORDER BY secid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_daftarnik($nik_ktp)
	{

		$sql = "SELECT *
				FROM xin_employee_request
				WHERE datediff(current_date(),DATE_FORMAT(createdon, '%Y-%m-%d')) <=20
				AND e_status = '0'
				ORDER BY secid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}
	// monitoring request
	public function get_monitoring_request($empID)
	{

		$sql = 'SELECT *
				FROM xin_employee_request
				WHERE datediff(current_date(),DATE_FORMAT(createdon, "%Y-%m-%d")) <=20
				AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = "$empID")
				ORDER BY secid DESC';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_request_cancel($empID)
	{

		$sql = "SELECT * FROM xin_employee_request 
		WHERE cancel_stat = 1
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID');";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_request_nae($empID)
	{

		$sql = "SELECT * 
			FROM xin_employee_request 
			WHERE request_empby is not null 
			AND approved_naeby is null 
			AND approved_nomby is null 
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
	        AND cancel_stat = 0
        	AND e_status = 0
			ORDER BY secid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_request_nom($empID)
	{

		$sql = "SELECT * FROM xin_employee_request 
		WHERE request_empby is not null 
		AND approved_naeby is not null
		AND approved_nomby is null
		AND approved_hrdby is null
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		AND cancel_stat = 0
        AND e_status = 0";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_request_hrd($empID)
	{

		$sql = "SELECT * FROM xin_employee_request 
		WHERE request_empby is not null 
		AND approved_naeby is not null
		AND approved_nomby is not null
		AND approved_hrdby is null
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		AND cancel_stat = 0";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	// monitoring request
	public function get_request_hrdpro($empID, $project)
	{

		$sql = "SELECT * FROM xin_employee_request 
		WHERE request_empby is not null 
		AND approved_naeby is not null
		AND approved_nomby is not null
		AND approved_hrdby is null
		AND project  = '$project'
		AND cancel_stat = 0
        AND e_status = 0";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	//ambil golongan karawan berdasarkan project
	function get_golongan_karyawan($proj_id)
	{
		// $golongan = "GOL";
		if ($proj_id == null) {
			return "";
		} else if ($proj_id == 0) {
			return "";
		} else {
			$this->db->select('doc_id');
			$this->db->from('xin_projects');
			$this->db->where('project_id', $proj_id);

			$query = $this->db->get()->row_array();

			//return $query->doc_id;
			if (empty($query)) {
				return "";
			} else if ($query['doc_id'] == '1') {
				return "PKWT";
			} else if ($query['doc_id'] == '2') {
				return "TKHL";
			}
		}
	}

	//ambil nama project
	function get_nama_project($proj_id)
	{
		if ($proj_id == null) {
			return "";
		} else if ($proj_id == 0) {
			return "";
		} else {
			$this->db->select('priority');
			$this->db->select('title');
			$this->db->from('xin_projects');
			$this->db->where('project_id', $proj_id);

			$query = $this->db->get()->row_array();

			if (empty($query)) {
				return "";
			} else {
				return "[" . $query['priority'] . "] " . $query['title'];
			}
			//return $query['title'];
		}
	}

	//ambil nama karyawan
	function get_nama_karyawan_by_nip($nip)
	{
		if ($nip == null) {
			return "";
		} else if ($nip == 0) {
			return "";
		} else {
			$this->db->select('first_name');
			$this->db->from('xin_employees');
			$this->db->where('employee_id', $nip);

			$query = $this->db->get()->row_array();

			if (empty($query)) {
				return "";
			} else {
				return $query['first_name'];
			}
			//return $query['title'];
		}
	}

	//ambil nama karyawan by id
	function get_nama_karyawan_by_id($user_id)
	{
		if ($user_id == null) {
			return "";
		} else if ($user_id == 0) {
			return "";
		} else {
			$this->db->select('first_name');
			$this->db->from('xin_employees');
			$this->db->where('user_id', $user_id);

			$query = $this->db->get()->row_array();

			if (empty($query)) {
				return "";
			} else {
				return $query['first_name'];
			}
			//return $query['title'];
		}
	}

	//ambil nama sub project
	function get_nama_sub_project($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('sub_project_name');
			$this->db->from('xin_projects_sub');
			$this->db->where('secid', $id);

			$query = $this->db->get()->row_array();

			//return $query['sub_project_name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['sub_project_name'];
			}
		}
	}

	//ambil nama kategori karyawan
	function get_nama_kategori($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('name');
			$this->db->from('mt_employee_category');
			$this->db->where('id', $id);

			$query = $this->db->get()->row_array();

			//return $query['sub_project_name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['name'];
			}
		}
	}

	//ambil nama compamy
	function get_nama_company($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('name');
			$this->db->from('xin_companies');
			$this->db->where('company_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['name'];
			}
		}
	}

	//ambil nama departement
	function get_nama_department($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('department_name');
			$this->db->from('xin_departments');
			$this->db->where('department_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['department_name'];
			}
		}
	}

	//ambil nama agama
	function get_nama_agama($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('type');
			$this->db->from('xin_ethnicity_type');
			$this->db->where('ethnicity_type_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['type'];
			}
		}
	}

	//ambil id jabatan
	function get_id_jabatan($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('designation_id');
			$this->db->from('xin_employees');
			$this->db->where('employee_id', $id);
			// $this->db->order_by('createdon', 'desc');
			// $this->db->limit(1);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['designation_id'];
			}
		}
	}

	//ambil level jabatan
	function get_level($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('level');
			$this->db->from('xin_designations');
			$this->db->where('designation_id', $id);
			// $this->db->order_by('createdon', 'desc');
			// $this->db->limit(1);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['level'];
			}
		}
	}

	//ambil link pkwt
	function get_link_pkwt($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('max(contract_id)');
			$this->db->select('file_name');
			$this->db->from('xin_employee_contract');
			$this->db->where('employee_id', $id);
			// $this->db->order_by('createdon', 'desc');
			// $this->db->limit(1);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['file_name'];
			}
		}
	}

	//ambil tanggal upload pkwt lengkap
	function get_tanggal_pkwt($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('max(contract_id)');
			$this->db->select('upload_pkwt');
			$this->db->from('xin_employee_contract');
			$this->db->where('employee_id', $id);
			// $this->db->order_by('createdon', 'desc');
			// $this->db->limit(1);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['upload_pkwt'];
			}
		}
	}

	//ambil nama kontak darurat
	function get_nama_kontak_darurat($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('nama');
			$this->db->from('xin_employee_emergency');
			$this->db->where('employee_request_nik', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['nama'];
			}
		}
	}

	//ambil nama kontak darurat2
	function get_nama_kontak_darurat2($id, $nip)
	{
		if (($id == null) || ($nip == null)) {
			return "";
		} else if (($id == 0) || ($nip == 0)) {
			return "";
		} else {
			$this->db->select('nama');
			$this->db->from('xin_employee_emergency');
			$this->db->where('nip', $nip);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return $this->get_nama_kontak_darurat($id);
				// return "";
			} else {
				return $query['nama'];
			}
		}
	}

	//ambil nomor kontak darurat
	function get_nomor_kontak_darurat($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('no_kontak');
			$this->db->from('xin_employee_emergency');
			$this->db->where('employee_request_nik', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['no_kontak'];
			}
		}
	}

	//ambil nomor kontak darurat2
	function get_nomor_kontak_darurat2($id, $nip)
	{
		if (($id == null) || ($nip == null)) {
			return "";
		} else if (($id == 0) || ($nip == 0)) {
			return "";
		} else {
			$this->db->select('no_kontak');
			$this->db->from('xin_employee_emergency');
			$this->db->where('nip', $nip);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return $this->get_nomor_kontak_darurat($id);
			} else {
				return $query['no_kontak'];
			}
		}
	}

	//ambil hubunan kontak darurat
	function get_hubungan_kontak_darurat($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('hubungan');
			$this->db->from('xin_employee_emergency');
			$this->db->where('employee_request_nik', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $this->get_nama_hubungan_kontak_darurat($query['hubungan']);
			}
		}
	}

	//ambil hubunan kontak darurat2
	function get_hubungan_kontak_darurat2($id, $nip)
	{
		if (($id == null) || ($nip == null)) {
			return "";
		} else if (($id == 0) || ($nip == 0)) {
			return "";
		} else {
			$this->db->select('hubungan');
			$this->db->from('xin_employee_emergency');
			$this->db->where('nip', $nip);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return $this->get_hubungan_kontak_darurat($id);
			} else {
				return $this->get_nama_hubungan_kontak_darurat($query['hubungan']);
			}
		}
	}

	//ambil hubunan kontak darurat
	function get_nama_hubungan_kontak_darurat($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('name');
			$this->db->from('mt_family_relation');
			$this->db->where('secid', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['name'];
			}
		}
	}

	//ambil nama pendidikan
	function get_nama_pendidikan($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('name');
			$this->db->from('xin_qualification_education_level');
			$this->db->where('education_level_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['name'];
			}
		}
	}

	//ambil status kawin
	function get_status_kawin($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('kode');
			$this->db->from('mt_marital');
			$this->db->where('id_marital', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return $id;
			} else {
				if ($query['kode'] == null) {
					return "";
				} else {
					return $query['kode'];
				}
			}
		}
	}

	//ambil nama bank
	function get_nama_bank($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else if ($id == "") {
			return "";
		} else {
			$this->db->select('bank_name');
			$this->db->from('mt_bank');
			$this->db->where('secid', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['bank_name'];
			}
		}
	}

	//ambil id bank
	function get_id_bank($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else if ($id == "") {
			return "";
		} else {
			$this->db->select('bank_code');
			$this->db->from('mt_bank');
			$this->db->where('secid', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return "";
			} else {
				return substr($query['bank_code'], -3);
			}
		}
	}

	//ubah tanggal YYYY-MM-DD diubah jadi MM/DD/YYYY
	function ubah_format_tanggal($tanggal_lahir)
	{

		if (empty($tanggal_lahir)) {
			return "";
		} else {
			$tanggal_lahir_temp = explode("-", $tanggal_lahir);
			if (count($tanggal_lahir_temp) >= 3) {
				if (strlen($tanggal_lahir_temp[0]) == 4) {
					return $tanggal_lahir_temp[2] . "-" . $tanggal_lahir_temp[1] . "-" . $tanggal_lahir_temp[0];
				}
				return "";
			}
			return "";
		}
	}

	//mengambil semua status perkawinan
	public function getAllMarital()
	{
		//$otherdb = $this->load->database('default', TRUE);

		$query = $this->db->get('mt_marital')->result_array();

		return $query;
	}

	//ambil nama jabatan
	function get_nama_jabatan($id)
	{
		if (empty($id)) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('designation_name');
			$this->db->from('xin_designations');
			$this->db->where('designation_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['designation_name'];
			if (empty($query)) {
				return "";
			} else {
				return $query['designation_name'];
			}
		}
	}

	//get lock status kolom
	function get_lock_status($id, $column)
	{
		$this->db->select('*');
		$this->db->from('log_lock_unlock');
		$this->db->where('employee_id', $id);
		$this->db->where('nama_kolom', $column);
		$this->db->order_by('time', 'desc');
		$this->db->limit(1);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//get validation status kolom
	function get_valiadation_status($id, $column)
	{
		$this->db->select('*');
		$this->db->from('log_employee_verification');
		$this->db->where('id_employee_request', $id);
		$this->db->where('kolom', $column);
		$this->db->order_by('verified_on', 'desc');
		$this->db->limit(1);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//set Lock Kolom
	public function setLockKolom($postData)
	{
		//Input untuk Database
		$datalock = [
			'employee_id'     => $postData['employee_id'],
			'nama_kolom'      => $postData['nama_kolom'],
			'status'          => $postData['status'],
			'change_by'       => $postData['user_id']
		];

		//$otherdb = $this->load->database('default', TRUE);

		$this->db->insert('log_lock_unlock', $datalock);

		//return null;
	}

	//validasi employee request
	public function valiadsi_employee_request($postData)
	{
		//Input untuk Database
		$datalock = [
			'id_employee_request'     => $postData['id_employee_request'],
			'kolom'      			  => $postData['kolom'],
			'nilai_sebelum'           => $postData['nilai_sebelum'],
			'nilai_sesudah'       	  => $postData['nilai_sesudah'],
			'status'      			  => $postData['status'],
			'verified_by'             => $postData['verified_by'],
			'verified_by_id'          => $postData['verified_by_id']
		];

		//update data employee
		if ($postData['kolom'] == "nik") {
			$data = array(
				'nik_ktp' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		} else if ($postData['kolom'] == "kk") {
			$data = array(
				'no_kk' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		} else if ($postData['kolom'] == "nama") {
			$data = array(
				'fullname' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		} else if ($postData['kolom'] == "bank") {
			$data = array(
				'bank_id' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		} else if ($postData['kolom'] == "norek") {
			$data = array(
				'no_rek' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		} else if ($postData['kolom'] == "pemilik_rekening") {
			$data = array(
				'pemilik_rekening' => $postData['nilai_sesudah']
			);
			$this->db->where('secid', $postData['id_employee_request']);
			$this->db->update('xin_employee_request', $data);
		}


		$this->db->insert('log_employee_verification', $datalock);
	}

	//un validasi employee request
	public function un_valiadsi_employee_request($postData)
	{
		//Input untuk Database
		$datalock = [
			'id_employee_request'     => $postData['id_employee_request'],
			'kolom'      			  => $postData['kolom'],
			'nilai_sebelum'           => $postData['nilai_sebelum'],
			'nilai_sesudah'       	  => $postData['nilai_sesudah'],
			'status'      			  => $postData['status'],
			'verified_by'             => $postData['verified_by'],
			'verified_by_id'          => $postData['verified_by_id']
		];

		//$otherdb = $this->load->database('default', TRUE);

		$this->db->insert('log_employee_verification', $datalock);

		//return null;
	}

	//validasi employee request
	public function valiadsi_employee_existing($postData)
	{
		//Input untuk Database
		$datalock = [
			'id_employee_request'     => $postData['id_employee_request'],
			'kolom'      			  => $postData['kolom'],
			'nilai_sebelum'           => $postData['nilai_sebelum'],
			'nilai_sesudah'       	  => $postData['nilai_sesudah'],
			'status'      			  => $postData['status'],
			'verified_by'             => $postData['verified_by'],
			'verified_by_id'          => $postData['verified_by_id']
		];

		//get user varification_id info
		$result = $this->read_employee_info_by_nik($postData['employee_id']);

		//update data employee
		if ($postData['kolom'] == "nik") {
			$data = array(
				'ktp_no' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		} else if ($postData['kolom'] == "kk") {
			$data = array(
				'kk_no' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		} else if ($postData['kolom'] == "nama") {
			$data = array(
				'first_name' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		} else if ($postData['kolom'] == "bank") {
			$data = array(
				'bank_name' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		} else if ($postData['kolom'] == "norek") {
			$data = array(
				'nomor_rek' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		} else if ($postData['kolom'] == "pemilik_rekening") {
			$data = array(
				'pemilik_rek' => $postData['nilai_sesudah']
			);
			if ((empty($result[0]->verification_id)) || ($result[0]->verification_id == "")) {
				$data["verification_id"] = $postData['id_employee_request'];
			}
			$this->db->where('employee_id', $postData['employee_id']);
			$this->db->update('xin_employees', $data);
		}


		$this->db->insert('log_employee_verification', $datalock);

		//get user varification_id info
		$result = $this->get_employee_array_by_nip($postData['employee_id']);

		return $result;
	}

	//un validasi employee request
	public function un_valiadsi_employee_existing($postData)
	{
		//Input untuk Database
		$datalock = [
			'id_employee_request'     => $postData['id_employee_request'],
			'kolom'      			  => $postData['kolom'],
			'nilai_sebelum'           => $postData['nilai_sebelum'],
			'nilai_sesudah'       	  => $postData['nilai_sesudah'],
			'status'      			  => $postData['status'],
			'verified_by'             => $postData['verified_by'],
			'verified_by_id'          => $postData['verified_by_id']
		];

		//$otherdb = $this->load->database('default', TRUE);

		$this->db->insert('log_employee_verification', $datalock);

		//return null;
	}

	/*
	* persiapan data export excel
	* data request employee yang belum diapprove HRD dan belum ditolak HRD
	* 
	* @author Fadla Qamara
	*/
	function get_request_print($postData = null)
	{

		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project_id = $postData['project_id'];
		$golongan = $postData['golongan'];
		$kategori = $postData['kategori'];
		$approve = $postData['approve'];
		$idsession = $postData['idsession'];
		$filter = $postData['filter'];
		$filterProject = "";
		$filterGolongan = "";
		$filterKategori = "";

		## Search 
		$searchQuery = "";
		if ($filter != '') {
			$searchQuery = " (penempatan like '%" . $filter . "%' or nik_ktp like '%" . $filter . "%' or fullname like'%" . $filter . "%' ) ";
		}


		$kondisiDefaultQuery = "(
			request_empby = 1
		AND	approved_naeby = 1
		AND approved_nomby = 1
		AND approved_hrdby is null
		AND cancel_stat = 0
		)";
		//AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")

		$kondisiBelumSiapApprove = "(
			gaji_pokok = '0'
		OR	gaji_pokok is null
		OR  gaji_pokok = ''

		OR  doj = '0'
		OR	doj is null
		OR  doj = ''

		OR  penempatan = '0'
		OR	penempatan is null
		OR  penempatan = ''

		OR  contract_start = '0'
		OR	contract_start is null
		OR  contract_start = ''

		OR  contract_end = '0'
		OR	contract_end is null
		OR  contract_end = ''

		OR  contract_periode = '0'
		OR	contract_periode is null
		OR  contract_periode = ''

		OR  cut_start = '0'
		OR	cut_start is null
		OR  cut_start = ''

		OR  cut_off = '0'
		OR	cut_off is null
		OR  cut_off = ''

		OR  date_payment = '0'
		OR	date_payment is null
		OR  date_payment = ''

		OR  hari_kerja = '0'
		OR	hari_kerja is null
		OR  hari_kerja = ''

		OR  company_id = '0'
		OR	company_id is null
		OR  company_id = ''

		OR  project = '0'
		OR	project is null
		OR  project = ''

		OR  sub_project = '0'
		OR	sub_project is null
		OR  sub_project = ''

		OR  posisi = '0'
		OR	posisi is null
		OR  posisi = ''
		)";

		//kalau ada input filter
		//project
		if (($project_id != null) && ($project_id != "") && ($project_id != '0')) {
			$filterProject = "(
			project = " . $project_id . "
		)";
		} else {
			//$filterProject = "(project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")";
			$filterProject = "project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")";
			//$filterProject = "";
		}
		//golongan
		if (($golongan != null) && ($golongan != "") && ($golongan != '0')) {
			$filterGolongan = "(
			e_status = " . $golongan . "
		)";
		} else {
			$filterGolongan = "";
		}
		//kaegori
		if (($kategori != null) && ($kategori != "") && ($kategori != '0')) {
			$filterKategori = "(
			location_id = " . $kategori . "
		)";
		} else {
			$filterKategori = "";
		}

		## Fetch records
		$this->db->select('*');
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->where($kondisiDefaultQuery);
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterGolongan != '') {
			$this->db->where($filterGolongan);
		}
		if ($filterKategori != '') {
			$this->db->where($filterKategori);
		}
		if ($approve == '1') {
			$this->db->where('gaji_pokok !=', '0');
			$this->db->where('gaji_pokok !=', 'null');
			$this->db->where('gaji_pokok !=', '');

			$this->db->where('doj !=', '0');
			$this->db->where('doj !=', 'null');
			$this->db->where('doj !=', '');

			$this->db->where('penempatan !=', '0');
			$this->db->where('penempatan !=', 'null');
			$this->db->where('penempatan !=', '');

			$this->db->where('contract_start !=', '0');
			$this->db->where('contract_start !=', 'null');
			$this->db->where('contract_start !=', '');

			$this->db->where('contract_end !=', '0');
			$this->db->where('contract_end !=', 'null');
			$this->db->where('contract_end !=', '');

			$this->db->where('contract_periode !=', '0');
			$this->db->where('contract_periode !=', 'null');
			$this->db->where('contract_periode !=', '');

			$this->db->where('cut_start !=', '0');
			$this->db->where('cut_start !=', 'null');
			$this->db->where('cut_start !=', '');

			$this->db->where('cut_off !=', '0');
			$this->db->where('cut_off !=', 'null');
			$this->db->where('cut_off !=', '');

			$this->db->where('date_payment !=', '0');
			$this->db->where('date_payment !=', 'null');
			$this->db->where('date_payment !=', '');

			$this->db->where('hari_kerja !=', '0');
			$this->db->where('hari_kerja !=', 'null');
			$this->db->where('hari_kerja !=', '');

			$this->db->where('company_id !=', '0');
			$this->db->where('company_id !=', 'null');
			$this->db->where('company_id !=', '');

			$this->db->where('project !=', '0');
			$this->db->where('project !=', 'null');
			$this->db->where('project !=', '');

			$this->db->where('sub_project !=', '0');
			$this->db->where('sub_project !=', 'null');
			$this->db->where('sub_project !=', '');

			$this->db->where('posisi !=', '0');
			$this->db->where('posisi !=', 'null');
			$this->db->where('posisi !=', '');
		} else if ($approve == '2') {
			$this->db->where($kondisiBelumSiapApprove);
		}
		$this->db->order_by('createdon', 'desc');
		$records = $this->db->get('xin_employee_request')->result();
		$tes_query = $this->db->last_query();

		$data = array();

		foreach ($records as $record) {

			$sambung_periode = "";
			if (($record->contract_start == null) || ($record->contract_start == "")) {
				if (($record->contract_end == null) || ($record->contract_end == "")) {
					$sambung_periode = " -- ";
				} else {
					$sambung_periode = " s/d ";
				}
			} else {
				$sambung_periode = " s/d ";
			}

			$periode = "";
			if ($sambung_periode == " s/d ") {
				$periode = $record->contract_start . $sambung_periode . $record->contract_end;
			}

			$status_golongan = "";
			if ($record->e_status == '1') {
				$status_golongan = "PKWT";
			} else if ($record->e_status == '2') {
				$status_golongan = "TKHL";
			} else {
				$status_golongan = "--";
			}

			$jenis_kelamin = "";
			if (($record->gender == null) || ($record->gender == "")) {
				$jenis_kelamin = "";
			} else {
				if ($record->gender == "L") {
					$jenis_kelamin = "Laki-Laki";
				} else if ($record->gender == "P") {
					$jenis_kelamin = "Perempuan";
				}
			}

			$periode_kontrak = "";
			if (($record->contract_periode == null) || ($record->contract_periode == "") || ($record->contract_periode == "0")) {
				$periode_kontrak = "";
			} else {
				$periode_kontrak = $record->contract_periode . " Bulan";
			}

			$nik = "";
			if (empty($record->nik_ktp)) {
				$nik = "";
			} else {
				$nik = $record->nik_ktp;
			}

			$data[] = array(
				"nik_ktp" => $nik . " ",
				"fullname" => strtoupper($record->fullname),
				"nama_ibu" => strtoupper($record->nama_ibu),
				"tempat_lahir" => strtoupper($record->tempat_lahir),
				"tanggal_lahir" => $this->ubah_format_tanggal($record->tanggal_lahir),
				"companies" => strtoupper($this->get_nama_company($record->company_id)),
				"project" => strtoupper($this->get_nama_project($record->project)),
				"sub_project" => strtoupper($this->get_nama_sub_project($record->sub_project)),
				"department" => strtoupper($this->get_nama_department($record->department)),
				"posisi" => strtoupper($this->get_nama_jabatan($record->posisi)),
				"jenis_kelamin" => strtoupper($jenis_kelamin),
				"agama" => strtoupper($this->get_nama_agama($record->agama)),
				"status_kawin" => strtoupper($this->get_status_kawin($record->status_kawin)),
				"doj" => $this->ubah_format_tanggal($record->doj),
				"contract_start" => $this->ubah_format_tanggal($record->contract_start),
				"contract_end" => $this->ubah_format_tanggal($record->contract_end),
				"contract_periode" => strtoupper($periode_kontrak),
				"contact_no" => $record->contact_no . " ",
				"alamat_ktp" => strtoupper($record->alamat_ktp),
				"alamat_domisili" => strtoupper($record->alamat_domisili),
				"no_kk" => $record->no_kk . " ",
				"npwp" => strtoupper($record->npwp) . " ",
				"email" => strtoupper($record->email),
				"penempatan" => strtoupper($record->penempatan),
				"nama_bank" => $this->get_nama_bank($record->bank_id),
				"code_bank" => $this->get_id_bank($record->bank_id),
				"no_rek" => $record->no_rek . " ",
				"pemilik_rekening" => strtoupper($record->pemilik_rekening),
				"gaji_pokok" => $record->gaji_pokok,
				"allow_jabatan" => $record->allow_jabatan,
				"allow_konsumsi" => $record->allow_konsumsi,
				"allow_transport" => $record->allow_transport,
				"allow_comunication" => $record->allow_comunication,
				"allow_rent" => $record->allow_rent,
				"allow_parking" => $record->allow_parking,
				"request_empon" => $record->request_empon
			);
		}

		//print_r($this->db->last_query());
		//die;
		//var_dump($postData);
		//var_dump($this->db->last_query());

		return $data;
		//json_encode($data);
	}


	/*
	* persiapan data untuk datatable pagination
	* data request employee yang belum diapprove HRD dan belum ditolak HRD
	* 
	* @author Fadla Qamara
	*/
	function get_request_hrd2($postData = null)
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
		$project_id = $postData['project_id'];
		$golongan = $postData['golongan'];
		$kategori = $postData['kategori'];
		$approve = $postData['approve'];
		$idsession = $postData['idsession'];
		$filterProject = "";
		$filterGolongan = "";
		$filterKategori = "";

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (penempatan like '%" . $searchValue . "%' or nik_ktp like '%" . $searchValue . "%' or fullname like'%" . $searchValue . "%' ) ";
		}

		$kondisiDefaultQuery = "(
			request_empby = 1
		AND	approved_naeby = 1
		AND approved_nomby = 1
		AND approved_hrdby is null
		AND cancel_stat = 0
		)";
		//AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")

		$kondisiBelumSiapApprove = "(
			gaji_pokok = '0'
		OR	gaji_pokok is null
		OR  gaji_pokok = ''

		OR  doj = '0'
		OR	doj is null
		OR  doj = ''

		OR  penempatan = '0'
		OR	penempatan is null
		OR  penempatan = ''

		OR  contract_start = '0'
		OR	contract_start is null
		OR  contract_start = ''

		OR  contract_end = '0'
		OR	contract_end is null
		OR  contract_end = ''

		OR  contract_periode = '0'
		OR	contract_periode is null
		OR  contract_periode = ''

		OR  cut_start = '0'
		OR	cut_start is null
		OR  cut_start = ''

		OR  cut_off = '0'
		OR	cut_off is null
		OR  cut_off = ''

		OR  date_payment = '0'
		OR	date_payment is null
		OR  date_payment = ''

		OR  hari_kerja = '0'
		OR	hari_kerja is null
		OR  hari_kerja = ''

		OR  company_id = '0'
		OR	company_id is null
		OR  company_id = ''

		OR  project = '0'
		OR	project is null
		OR  project = ''

		OR  sub_project = '0'
		OR	sub_project is null
		OR  sub_project = ''

		OR  posisi = '0'
		OR	posisi is null
		OR  posisi = ''
		)";

		//kalau ada input filter
		//project
		if (($project_id != null) && ($project_id != "") && ($project_id != '0')) {
			$filterProject = "(
			project = " . $project_id . "
		)";
		} else {
			//$filterProject = "(project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")";
			$filterProject = "project in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $idsession . ")";
			//$filterProject = "";
		}
		//golongan
		if (($golongan != null) && ($golongan != "") && ($golongan != '0')) {
			$filterGolongan = "(
			e_status = " . $golongan . "
		)";
		} else {
			$filterGolongan = "";
		}
		//kaegori
		if (($kategori != null) && ($kategori != "") && ($kategori != '0')) {
			$filterKategori = "(
			location_id = " . $kategori . "
		)";
		} else {
			$filterKategori = "";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterGolongan != '') {
			$this->db->where($filterGolongan);
		}
		if ($filterKategori != '') {
			$this->db->where($filterKategori);
		}
		if ($approve == '1') {
			$this->db->where('gaji_pokok !=', '0');
			$this->db->where('gaji_pokok !=', 'null');
			$this->db->where('gaji_pokok !=', '');

			$this->db->where('doj !=', '0');
			$this->db->where('doj !=', 'null');
			$this->db->where('doj !=', '');

			$this->db->where('penempatan !=', '0');
			$this->db->where('penempatan !=', 'null');
			$this->db->where('penempatan !=', '');

			$this->db->where('contract_start !=', '0');
			$this->db->where('contract_start !=', 'null');
			$this->db->where('contract_start !=', '');

			$this->db->where('contract_end !=', '0');
			$this->db->where('contract_end !=', 'null');
			$this->db->where('contract_end !=', '');

			$this->db->where('contract_periode !=', '0');
			$this->db->where('contract_periode !=', 'null');
			$this->db->where('contract_periode !=', '');

			$this->db->where('cut_start !=', '0');
			$this->db->where('cut_start !=', 'null');
			$this->db->where('cut_start !=', '');

			$this->db->where('cut_off !=', '0');
			$this->db->where('cut_off !=', 'null');
			$this->db->where('cut_off !=', '');

			$this->db->where('date_payment !=', '0');
			$this->db->where('date_payment !=', 'null');
			$this->db->where('date_payment !=', '');

			$this->db->where('hari_kerja !=', '0');
			$this->db->where('hari_kerja !=', 'null');
			$this->db->where('hari_kerja !=', '');

			$this->db->where('company_id !=', '0');
			$this->db->where('company_id !=', 'null');
			$this->db->where('company_id !=', '');

			$this->db->where('project !=', '0');
			$this->db->where('project !=', 'null');
			$this->db->where('project !=', '');

			$this->db->where('sub_project !=', '0');
			$this->db->where('sub_project !=', 'null');
			$this->db->where('sub_project !=', '');

			$this->db->where('posisi !=', '0');
			$this->db->where('posisi !=', 'null');
			$this->db->where('posisi !=', '');
		} else if ($approve == '2') {
			$this->db->where($kondisiBelumSiapApprove);
		}
		$records = $this->db->get('xin_employee_request')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->where($kondisiDefaultQuery);
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterGolongan != '') {
			$this->db->where($filterGolongan);
		}
		if ($filterKategori != '') {
			$this->db->where($filterKategori);
		}
		if ($approve == '1') {
			$this->db->where('gaji_pokok !=', '0');
			$this->db->where('gaji_pokok !=', 'null');
			$this->db->where('gaji_pokok !=', '');

			$this->db->where('doj !=', '0');
			$this->db->where('doj !=', 'null');
			$this->db->where('doj !=', '');

			$this->db->where('penempatan !=', '0');
			$this->db->where('penempatan !=', 'null');
			$this->db->where('penempatan !=', '');

			$this->db->where('contract_start !=', '0');
			$this->db->where('contract_start !=', 'null');
			$this->db->where('contract_start !=', '');

			$this->db->where('contract_end !=', '0');
			$this->db->where('contract_end !=', 'null');
			$this->db->where('contract_end !=', '');

			$this->db->where('contract_periode !=', '0');
			$this->db->where('contract_periode !=', 'null');
			$this->db->where('contract_periode !=', '');

			$this->db->where('cut_start !=', '0');
			$this->db->where('cut_start !=', 'null');
			$this->db->where('cut_start !=', '');

			$this->db->where('cut_off !=', '0');
			$this->db->where('cut_off !=', 'null');
			$this->db->where('cut_off !=', '');

			$this->db->where('date_payment !=', '0');
			$this->db->where('date_payment !=', 'null');
			$this->db->where('date_payment !=', '');

			$this->db->where('hari_kerja !=', '0');
			$this->db->where('hari_kerja !=', 'null');
			$this->db->where('hari_kerja !=', '');

			$this->db->where('company_id !=', '0');
			$this->db->where('company_id !=', 'null');
			$this->db->where('company_id !=', '');

			$this->db->where('project !=', '0');
			$this->db->where('project !=', 'null');
			$this->db->where('project !=', '');

			$this->db->where('sub_project !=', '0');
			$this->db->where('sub_project !=', 'null');
			$this->db->where('sub_project !=', '');

			$this->db->where('posisi !=', '0');
			$this->db->where('posisi !=', 'null');
			$this->db->where('posisi !=', '');
		} else if ($approve == '2') {
			$this->db->where($kondisiBelumSiapApprove);
		}
		$records = $this->db->get('xin_employee_request')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->where($kondisiDefaultQuery);
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterGolongan != '') {
			$this->db->where($filterGolongan);
		}
		if ($filterKategori != '') {
			$this->db->where($filterKategori);
		}
		if ($approve == '1') {
			$this->db->where('gaji_pokok !=', '0');
			$this->db->where('gaji_pokok !=', 'null');
			$this->db->where('gaji_pokok !=', '');

			$this->db->where('doj !=', '0');
			$this->db->where('doj !=', 'null');
			$this->db->where('doj !=', '');

			$this->db->where('penempatan !=', '0');
			$this->db->where('penempatan !=', 'null');
			$this->db->where('penempatan !=', '');

			$this->db->where('contract_start !=', '0');
			$this->db->where('contract_start !=', 'null');
			$this->db->where('contract_start !=', '');

			$this->db->where('contract_end !=', '0');
			$this->db->where('contract_end !=', 'null');
			$this->db->where('contract_end !=', '');

			$this->db->where('contract_periode !=', '0');
			$this->db->where('contract_periode !=', 'null');
			$this->db->where('contract_periode !=', '');

			$this->db->where('cut_start !=', '0');
			$this->db->where('cut_start !=', 'null');
			$this->db->where('cut_start !=', '');

			$this->db->where('cut_off !=', '0');
			$this->db->where('cut_off !=', 'null');
			$this->db->where('cut_off !=', '');

			$this->db->where('date_payment !=', '0');
			$this->db->where('date_payment !=', 'null');
			$this->db->where('date_payment !=', '');

			$this->db->where('hari_kerja !=', '0');
			$this->db->where('hari_kerja !=', 'null');
			$this->db->where('hari_kerja !=', '');

			$this->db->where('company_id !=', '0');
			$this->db->where('company_id !=', 'null');
			$this->db->where('company_id !=', '');

			$this->db->where('project !=', '0');
			$this->db->where('project !=', 'null');
			$this->db->where('project !=', '');

			$this->db->where('sub_project !=', '0');
			$this->db->where('sub_project !=', 'null');
			$this->db->where('sub_project !=', '');

			$this->db->where('posisi !=', '0');
			$this->db->where('posisi !=', 'null');
			$this->db->where('posisi !=', '');
		} else if ($approve == '2') {
			$this->db->where($kondisiBelumSiapApprove);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		//$this->db->order_by('request_empon', 'desc');
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_employee_request')->result();
		$tes_query = $this->db->last_query();

		$data = array();
		$i = 1;

		foreach ($records as $record) {

			$status_migrasi = "";
			$editReq = '<a href="' . site_url() . 'admin/employee_request_cancelled/request_edit/' . $record->secid . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">EDIT</button></a>';

			$cancel = '<button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target=".edit-modal-data" data-company_id="@' . $record->secid . '">TOLAK</button>';

			$noteHR = '<button type="button" class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target=".edit-modal-data" data-company_id="!' . $record->secid . '">note</button>';

			$sambung_periode = "";
			if (($record->contract_start == null) || ($record->contract_start == "")) {
				if (($record->contract_end == null) || ($record->contract_end == "")) {
					$sambung_periode = " -- ";
				} else {
					$sambung_periode = " s/d ";
				}
			} else {
				$sambung_periode = " s/d ";
			}

			$status_golongan = "";
			if ($record->e_status == '1') {
				$status_golongan = "PKWT";
			} else if ($record->e_status == '2') {
				$status_golongan = "TKHL";
			} else {
				$status_golongan = "--";
			}

			//cek kondisi siap approve
			$siap_approve = "";
			if (($record->gaji_pokok != null) && ($record->gaji_pokok != "") && ($record->gaji_pokok != "0")) { //cek gaji pokok
				if (($record->doj != null) && ($record->doj != "") && ($record->doj != "0")) { //cek join date
					if (($record->penempatan != null) && ($record->penempatan != "") && ($record->penempatan != "0")) { //cek penempatan
						if (($record->contract_start != null) && ($record->contract_start != "") && ($record->contract_start != "0")) { //cek start kontak
							if (($record->contract_end != null) && ($record->contract_end != "") && ($record->contract_end != "0")) { //cek end kontrak
								if (($record->contract_periode != null) && ($record->contract_periode != "") && ($record->contract_periode != "0")) { //cek waku kontrak
									if (($record->cut_start != null) && ($record->cut_start != "") && ($record->cut_start != "0")) { //cek cut start
										if (($record->cut_off != null) && ($record->cut_off != "") && ($record->cut_off != "0")) { //cek cut off
											if (($record->date_payment != null) && ($record->date_payment != "") && ($record->date_payment != "0")) { //cek date payment
												if (($record->hari_kerja != null) && ($record->hari_kerja != "") && ($record->hari_kerja != "0")) { //cek hari kerja
													if (($record->company_id != null) && ($record->company_id != "") && ($record->company_id != "0")) {
														if (($record->project != null) && ($record->project != "") && ($record->project != "0")) {
															if (($record->sub_project != null) && ($record->sub_project != "") && ($record->sub_project != "0")) {
																if (($record->posisi != null) && ($record->posisi != "") && ($record->posisi != "0")) {
																	$siap_approve = "</br><button type='button' class='btn btn-xs btn-outline-info' data-toggle='modal' data-target='.edit-modal-data' data-company_id='$" . $record->secid . "'>Siap Approve</button>";
																	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$' . $record->secid . '">Approve HRD</button>';
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}


			//cek status verifikasi
			$nik_validation = "0";
			$nik_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'nik');
			if (is_null($nik_validation_query)) {
				$nik_validation = "0";
			} else {
				$nik_validation = $nik_validation_query['status'];
			}
			$kk_validation = "0";
			$kk_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'kk');
			if (is_null($kk_validation_query)) {
				$kk_validation = "0";
			} else {
				$kk_validation = $kk_validation_query['status'];
			}
			$nama_validation = "0";
			$nama_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'nama');
			if (is_null($nama_validation_query)) {
				$nama_validation = "0";
			} else {
				$nama_validation = $nama_validation_query['status'];
			}
			$bank_validation = "0";
			$bank_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'bank');
			if (is_null($bank_validation_query)) {
				$bank_validation = "0";
			} else {
				$bank_validation = $bank_validation_query['status'];
			}
			$norek_validation = "0";
			$norek_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'norek');
			if (is_null($norek_validation_query)) {
				$norek_validation = "0";
			} else {
				$norek_validation = $norek_validation_query['status'];
			}
			$pemilik_rekening_validation = "0";
			$pemilik_rekening_validation_query = $this->Employees_model->get_valiadation_status($record->secid, 'pemilik_rekening');
			if (is_null($pemilik_rekening_validation_query)) {
				$pemilik_rekening_validation = "0";
			} else {
				$pemilik_rekening_validation = $pemilik_rekening_validation_query['status'];
			}

			$status_verifikasi = "";
			if (
				($nik_validation == "1") && ($kk_validation == "1") && ($nama_validation == "1") &&
				($bank_validation == "1") && ($norek_validation == "1") && ($pemilik_rekening_validation == "1")
			) {
				$url_icon_verifikasi = base_url('/assets/icon/verified.png');
				$status_verifikasi = " <img src='" . $url_icon_verifikasi . "' width='20'>";
			}

			$data[] = array(
				"aksi" => $status_migrasi . ' <br>' . $cancel . ' ' . $editReq,
				//"golongan_karyawan" => $this->get_golongan_karyawan($record->project),
				"golongan_karyawan" => $status_golongan,
				//"fullname" => "<i class='fa-regular fa-circle-check'></i> " . $record->fullname,
				//"fullname" => $record->fullname . $siap_approve  . "<br>" . $tes_query,
				// "fullname" => $record->fullname . $siap_approve,
				"fullname" => $record->fullname . $status_verifikasi . $siap_approve,
				"nik_ktp" => $record->nik_ktp . "<br>" . $record->catatan_hr . "<br>" . $noteHR,
				"penempatan" => $record->penempatan,
				"project" => $this->get_nama_project($record->project),
				//"project" => $record->project,
				"sub_project" => $this->get_nama_sub_project($record->sub_project),
				//"sub_project" => $record->sub_project,
				"posisi" => strtoupper($this->get_nama_jabatan($record->posisi)),
				// "posisi" => $record->posisi,
				//"jabatan" => $record->posisi,
				"gaji_pokok" => $record->gaji_pokok,
				"periode" => $record->contract_start . $sambung_periode . $record->contract_end,
				"kategori" => $this->get_nama_kategori($record->location_id),
				"request_empon" => $record->request_empon
			);

			// if ($approve == '1') {
			// 	if ($siap_approve != "") {
			// 		$data[] = array(
			// 			"aksi" => $status_migrasi . ' <br>' . $cancel . ' ' . $editReq,
			// 			//"golongan_karyawan" => $this->get_golongan_karyawan($record->project),
			// 			"golongan_karyawan" => $status_golongan,
			// 			//"fullname" => "<i class='fa-regular fa-circle-check'></i> " . $record->fullname,
			// 			"fullname" => $record->fullname . $siap_approve,
			// 			"nik_ktp" => $record->nik_ktp . "<br>" . $record->catatan_hr . "<br>" . $noteHR,
			// 			"penempatan" => $record->penempatan,
			// 			"project" => $this->get_nama_project($record->project),
			// 			//"project" => $record->project,
			// 			"sub_project" => $this->get_nama_sub_project($record->sub_project),
			// 			//"sub_project" => $record->sub_project,
			// 			"jabatan" => $this->get_nama_jabatan($record->posisi),
			// 			//"jabatan" => $record->posisi,
			// 			"gaji_pokok" => $record->gaji_pokok,
			// 			"periode" => $record->contract_start . $sambung_periode . $record->contract_end,
			// 			"kategori" => $this->get_nama_kategori($record->location_id),
			// 			"tanggal_register" => $record->request_empon
			// 		);
			// 	}
			// } else if ($approve == '2') {
			// 	if ($siap_approve == "") {
			// 		$data[] = array(
			// 			"aksi" => $status_migrasi . ' <br>' . $cancel . ' ' . $editReq,
			// 			//"golongan_karyawan" => $this->get_golongan_karyawan($record->project),
			// 			"golongan_karyawan" => $status_golongan,
			// 			//"fullname" => "<i class='fa-regular fa-circle-check'></i> " . $record->fullname,
			// 			"fullname" => $record->fullname . $siap_approve,
			// 			"nik_ktp" => $record->nik_ktp . "<br>" . $record->catatan_hr . "<br>" . $noteHR,
			// 			"penempatan" => $record->penempatan,
			// 			"project" => $this->get_nama_project($record->project),
			// 			//"project" => $record->project,
			// 			"sub_project" => $this->get_nama_sub_project($record->sub_project),
			// 			//"sub_project" => $record->sub_project,
			// 			"jabatan" => $this->get_nama_jabatan($record->posisi),
			// 			//"jabatan" => $record->posisi,
			// 			"gaji_pokok" => $record->gaji_pokok,
			// 			"periode" => $record->contract_start . $sambung_periode . $record->contract_end,
			// 			"kategori" => $this->get_nama_kategori($record->location_id),
			// 			"tanggal_register" => $record->request_empon
			// 		);
			// 	}
			// } else {

			// 	$data[] = array(
			// 		"aksi" => $status_migrasi . ' <br>' . $cancel . ' ' . $editReq,
			// 		//"golongan_karyawan" => $this->get_golongan_karyawan($record->project),
			// 		"golongan_karyawan" => $status_golongan,
			// 		//"fullname" => "<i class='fa-regular fa-circle-check'></i> " . $record->fullname,
			// 		"fullname" => $record->fullname . $siap_approve,
			// 		"nik_ktp" => $record->nik_ktp . "<br>" . $record->catatan_hr . "<br>" . $noteHR,
			// 		"penempatan" => $record->penempatan,
			// 		"project" => $this->get_nama_project($record->project),
			// 		//"project" => $record->project,
			// 		"sub_project" => $this->get_nama_sub_project($record->sub_project),
			// 		//"sub_project" => $record->sub_project,
			// 		"jabatan" => $this->get_nama_jabatan($record->posisi),
			// 		//"jabatan" => $record->posisi,
			// 		"gaji_pokok" => $record->gaji_pokok,
			// 		"periode" => $record->contract_start . $sambung_periode . $record->contract_end,
			// 		"kategori" => $this->get_nama_kategori($record->location_id),
			// 		"tanggal_register" => $record->request_empon
			// 	);
			// }
			$i++;
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

	/*
	* persiapan data untuk datatable pagination
	* data list employees
	* 
	* @author Fadla Qamara
	*/
	function get_list_employees($postData = null)
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
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
		$status = $postData['status'];
		$session_id = $postData['session_id'];

		if ($project != "0") {
			## Search 
			$searchQuery = "";
			if ($searchValue != '') {
				if (strlen($searchValue) >= 3) {
					$searchQuery = " (xin_employees.employee_id like '%" . $searchValue .  "%' or xin_employees.first_name like '%" . $searchValue . "%' or xin_designations.designation_name like '%" . $searchValue . "%' or xin_employees.ktp_no like '%" . $searchValue . "%') ";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "xin_employees.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				$filterSubProject = "xin_employees.sub_project_id = '" . $sub_project . "'";
			} else {
				$filterSubProject = "";
			}

			$filterStatus = "";
			if (($status != null) && ($status != "") && ($status != '0')) {
				$filterStatus = "xin_employees.status_resign = '" . $status . "'";
			} else {
				$filterStatus = "";
			}

			## Kondisi Default 
			// $kondisiDefaultQuery = "(project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")) AND `user_id` != '1'";
			// $kondisiDefaultQuery = "(
			// 	karyawan_id = " . $emp_id . "
			// AND	pkwt_id = " . $contract_id . "
			// )";
			$kondisiDefaultQuery = "`xin_employees.user_id` != '1'";

			## Total number of records without filtering
			$this->db->select('count(*) as allcount');
			if ($filterProject != '') {
				$this->db->where($filterProject);
			}
			if ($filterSubProject != '') {
				$this->db->where($filterSubProject);
			}
			if ($filterStatus != '') {
				$this->db->where($filterStatus);
			}
			$this->db->where($kondisiDefaultQuery);
			$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $this->db->get('xin_employees')->result();
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
			if ($filterSubProject != '') {
				$this->db->where($filterSubProject);
			}
			if ($filterStatus != '') {
				$this->db->where($filterStatus);
			}
			$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $this->db->get('xin_employees')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$this->db->select('xin_employees.user_id');
			$this->db->select('xin_employees.employee_id');
			$this->db->select('xin_employees.status_resign');
			$this->db->select('xin_employees.ktp_no');
			$this->db->select('xin_employees.first_name');
			$this->db->select('xin_employees.project_id');
			$this->db->select('xin_employees.sub_project_id');
			$this->db->select('xin_employees.designation_id');
			// $this->db->select('xin_designations.designation_id');
			$this->db->select('xin_designations.designation_name');
			$this->db->select('xin_employees.penempatan');
			$this->db->select('b.from_date');
			$this->db->select('b.to_date');
			$this->db->select('xin_employees.contract_start');
			$this->db->select('xin_employees.contract_end');
			$this->db->select('xin_employees.private_code');
			// $this->db->select('xin_projects.priority');
			// $this->db->select('xin_designations.designation_name');
			$this->db->where($kondisiDefaultQuery);
			if ($searchQuery != '') {
				$this->db->where($searchQuery);
			}
			if ($filterProject != '') {
				$this->db->where($filterProject);
			}
			if ($filterSubProject != '') {
				$this->db->where($filterSubProject);
			}
			if ($filterStatus != '') {
				$this->db->where($filterStatus);
			}
			// $this->db->order_by($columnName, $columnSortOrder);
			$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
			// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
			$this->db->limit($rowperpage, $start);
			$records = $this->db->get('xin_employees')->result();

			#Debugging variable
			$tes_query = $this->db->last_query();
			//print_r($tes_query);

			$data = array();

			foreach ($records as $record) {
				$text_periode_from = "";
				$text_periode_to = "";
				$text_periode = "";
				if (empty($record->from_date) || ($record->from_date == "")) {
					$text_periode_from = "";
				} else {
					$text_periode_from = $this->Xin_model->tgl_indo($record->from_date);
				}
				if (empty($record->to_date) || ($record->to_date == "")) {
					$text_periode_to = "";
				} else {
					$text_periode_to = $this->Xin_model->tgl_indo($record->to_date);
				}
				if (($text_periode_from == "") && ($text_periode_to == "")) {
					$text_periode = "";
				} else {
					$text_periode = $text_periode_from . " s/d " . $text_periode_to;
				}

				$text_resign = "";
				if (empty($record->status_resign) || ($record->status_resign == "")) {
					$text_resign = "";
				} else if ($record->status_resign == "1") {
					$text_resign = " - [AKTIF]";
				} else if ($record->status_resign == "2") {
					$text_resign = " - [RESIGN]";
				} else if ($record->status_resign == "3") {
					$text_resign = " - [BLACKLIST]";
				} else if ($record->status_resign == "4") {
					$text_resign = " - [END CONTRACT]";
				} else if ($record->status_resign == "5") {
					$text_resign = " - [DEACTIVE]";
				} else {
					$text_resign = "";
				}

				//cek komparasi string
				// $teskomparasi_1 = "A";
				// $teskomparasi_2 = "C2";
				// $hasilkomparasi = "";

				// if ($teskomparasi_2 < $teskomparasi_1) {
				// 	$hasilkomparasi = "2 lebih kecil";
				// } else {
				// 	$hasilkomparasi = "2 lebih besar";
				// }

				$text_pin = "";
				$id_jabatan_user = $this->get_id_jabatan($session_id);
				$level_record = $this->get_level($record->designation_id);
				$level_user = $this->get_level($id_jabatan_user);

				if (empty($level_user) || $level_user == "") {
					$level_user = "Z9";
				} else {
					if (strlen($level_user) == 1) {
						$level_user = $level_user . "0";
					}
				}

				if (empty($level_record) || $level_record == "") {
					$level_record = "Z9";
				} else {
					if (strlen($level_record) == 1) {
						$level_record = $level_record . "0";
					}
				}
				if ($level_record <= $level_user) {
					$text_pin = "**********";
				} else {
					$text_pin = $record->private_code;
				}

				// $addendum_id = $this->secure->encrypt_url($record->id);
				// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

				$view = '<button id="tesbutton" type="button" onclick="viewEmployee(' . $record->employee_id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
				$viewDocs = '<button id="tesbutton2" type="button" onclick="viewDocumentEmployee(' . $record->employee_id . ')" class="btn btn-xs btn-outline-twitter" >DOCUMENT</button>';
				$editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->employee_id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
				$delete = '<br><button type="button" onclick="deleteBatchSaltabRelease(' . $record->employee_id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

				// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

				$data[] = array(
					"aksi" => $view,
					"employee_id" => $record->employee_id . $text_resign,
					"ktp_no" => $record->ktp_no,
					"first_name" => strtoupper($record->first_name),
					"project" => strtoupper($this->get_nama_project($record->project_id)),
					"sub_project" => strtoupper($this->get_nama_sub_project($record->sub_project_id)),
					"designation_name" => strtoupper($record->designation_name),
					"penempatan" => strtoupper($record->penempatan),
					"periode" => $text_periode,
					"pincode" => $text_pin,
					// $this->get_nama_karyawan($record->upload_by)
				);
			}
		} else {
			$totalRecords = 0;
			$totalRecordwithFilter = 0;
			$data = array();
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

	/*
	* persiapan data export excel
	* data request employee yang belum diapprove HRD dan belum ditolak HRD
	* 
	* @input array of variable from post
	* @return array of employee data
	* @author Fadla Qamara
	*/
	function get_employee_print($postData = null)
	{

		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
		$status = $postData['status'];
		$filter = $postData['filter'];
		$session_id = $postData['session_id'];

		$filterProject = "";
		$filterGolongan = "";
		$filterKategori = "";

		## Search 
		$searchQuery = "";
		if ($filter != '') {
			$searchQuery = " (xin_employees.employee_id like '%" . $filter .  "%' or xin_employees.first_name like '%" . $filter . "%' or xin_designations.designation_name like '%" . $filter . "%') ";
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

		$filterSubProject = "";
		if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
			$filterSubProject = "(
				sub_project_id = '" . $sub_project . "'
			)";
		} else {
			$filterSubProject = "";
		}

		$filterStatus = "";
		if (($status != null) && ($status != "") && ($status != '0')) {
			$filterStatus = "(
				status_resign = '" . $status . "'
			)";
		} else {
			$filterStatus = "";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(xin_employees.project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")) AND `user_id` != '1'";

		## Fetch records
		// $this->db->select('*');
		$this->db->select('xin_employees.employee_id');
		$this->db->select('xin_employees.status_resign');
		$this->db->select('xin_employees.private_code');
		$this->db->select('xin_employees.ktp_no');
		$this->db->select('xin_employees.first_name');
		$this->db->select('xin_employees.company_id');
		$this->db->select('xin_employees.department_id');
		$this->db->select('xin_employees.designation_id');
		$this->db->select('xin_designations.designation_name');
		$this->db->select('xin_employees.project_id');
		$this->db->select('xin_employees.sub_project_id');
		$this->db->select('xin_employees.penempatan');
		$this->db->select('xin_employees.region');
		$this->db->select('xin_employees.tempat_lahir');
		$this->db->select('xin_employees.date_of_birth');
		$this->db->select('xin_employees.date_of_joining');
		$this->db->select('xin_employees.contract_start');
		$this->db->select('xin_employees.contract_end');
		$this->db->select('xin_employees.basic_salary');
		$this->db->select('xin_employees.date_of_leaving');
		$this->db->select('xin_employees.gender');
		$this->db->select('xin_employees.marital_status');
		$this->db->select('xin_employees.ethnicity_type');
		$this->db->select('xin_employees.email');
		$this->db->select('xin_employees.contact_no');
		$this->db->select('xin_employees.last_edu');
		$this->db->select('xin_employees.alamat_ktp');
		$this->db->select('xin_employees.alamat_domisili');
		$this->db->select('xin_employees.kk_no');
		$this->db->select('xin_employees.npwp_no');
		$this->db->select('xin_employees.bpjs_tk_no');
		$this->db->select('xin_employees.bpjs_ks_no');
		$this->db->select('xin_employees.ibu_kandung');
		$this->db->select('xin_employees.bank_name');
		$this->db->select('xin_employees.nomor_rek');
		$this->db->select('xin_employees.pemilik_rek');
		$this->db->select('xin_employees.filename_ktp');
		$this->db->select('xin_employees.filename_kk');
		$this->db->select('xin_employees.filename_npwp');
		$this->db->select('xin_employees.filename_isd');
		$this->db->select('xin_employees.filename_skck');
		$this->db->select('xin_employees.filename_cv');
		$this->db->select('xin_employees.filename_paklaring');
		$this->db->select('b.from_date');
		$this->db->select('b.to_date');
		$this->db->select('b.file_name');
		$this->db->select('b.upload_pkwt');

		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterSubProject != '') {
			$this->db->where($filterSubProject);
		}
		if ($filterStatus != '') {
			$this->db->where($filterStatus);
		}
		// $this->db->join('xin_companies', 'xin_companies.company_id = xin_employees.company_id');
		// $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
		// $this->db->join('xin_projects', 'xin_projects.project_id = xin_employees.project_id');
		// $this->db->join('xin_projects_sub', 'xin_projects_sub.secid = xin_employees.sub_project_id');
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
		$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		$this->db->join('(SELECT contract_id, employee_id, from_date, to_date, file_name, upload_pkwt  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		$records = $this->db->get('xin_employees')->result();
		$tes_query = $this->db->last_query();

		$data = array();

		foreach ($records as $record) {
			$text_periode_from = "";
			$text_periode_to = "";
			$text_periode = "";
			if (empty($record->from_date) || ($record->from_date == "")) {
				$text_periode_from = "";
			} else {
				$text_periode_from = $this->Xin_model->tgl_indo($record->from_date);
			}
			if (empty($record->to_date) || ($record->to_date == "")) {
				$text_periode_to = "";
			} else {
				$text_periode_to = $this->Xin_model->tgl_indo($record->to_date);
			}
			if (($text_periode_from == "") && ($text_periode_to == "")) {
				$text_periode = "";
			} else {
				$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			}

			$text_resign = "";
			if (empty($record->status_resign) || ($record->status_resign == "")) {
				$text_resign = "";
			} else if ($record->status_resign == "1") {
				$text_resign = "AKTIF";
			} else if ($record->status_resign == "2") {
				$text_resign = "RESIGN";
			} else if ($record->status_resign == "3") {
				$text_resign = "BLACKLIST";
			} else if ($record->status_resign == "4") {
				$text_resign = "END CONTRACT";
			} else if ($record->status_resign == "5") {
				$text_resign = "DEACTIVE";
			} else {
				$text_resign = "";
			}

			$text_marital = "";
			if (empty($record->marital_status) || ($record->marital_status == "")) {
				$text_marital = "-";
			} else if ($record->marital_status == "1") {
				$text_marital = "TK/0";
			} else if ($record->marital_status == "2") {
				$text_marital = "TK/0";
			} else if ($record->marital_status == "3") {
				$text_marital = "TK/1";
			} else if ($record->marital_status == "4") {
				$text_marital = "TK/2";
			} else if ($record->marital_status == "5") {
				$text_marital = "TK/3";
			} else if ($record->marital_status == "6") {
				$text_marital = "K/0";
			} else if ($record->marital_status == "7") {
				$text_marital = "K/1";
			} else if ($record->marital_status == "8") {
				$text_marital = "K/2";
			} else if ($record->marital_status == "9") {
				$text_marital = "K/3";
			} else {
				$text_marital = "-";
			}

			$text_ktp = "";
			if (empty($record->filename_ktp) || ($record->filename_ktp == "") || ($record->filename_ktp == "0")) {
				$text_ktp = "-";
			} else {
				$text_ktp = base_url() . "uploads/document/ktp/" . $record->filename_ktp;
			}

			$text_kk = "";
			if (empty($record->filename_kk) || ($record->filename_kk == "") || ($record->filename_kk == "0")) {
				$text_kk = "-";
			} else {
				$text_kk = base_url() . "uploads/document/kk/" . $record->filename_kk;
			}

			$text_npwp = "";
			if (empty($record->filename_npwp) || ($record->filename_npwp == "") || ($record->filename_npwp == "0")) {
				$text_npwp = "-";
			} else {
				$text_npwp = base_url() . "uploads/document/npwp/" . $record->filename_npwp;
			}

			$text_ijazah = "";
			if (empty($record->filename_isd) || ($record->filename_isd == "") || ($record->filename_isd == "0")) {
				$text_ijazah = "-";
			} else {
				$text_ijazah = base_url() . "uploads/document/ijazah/" . $record->filename_isd;
			}

			$text_skck = "";
			if (empty($record->filename_skck) || ($record->filename_skck == "") || ($record->filename_skck == "0")) {
				$text_skck = "-";
			} else {
				$text_skck = base_url() . "uploads/document/skck/" . $record->filename_skck;
			}

			$text_cv = "";
			if (empty($record->filename_cv) || ($record->filename_cv == "") || ($record->filename_cv == "0")) {
				$text_cv = "-";
			} else {
				$text_cv = base_url() . "uploads/document/cv/" . $record->filename_cv;
			}

			$text_paklaring = "";
			if (empty($record->filename_paklaring) || ($record->filename_paklaring == "") || ($record->filename_paklaring == "0")) {
				$text_paklaring = "-";
			} else {
				$text_paklaring = base_url() . "uploads/document/" . $record->filename_paklaring;
			}

			$text_gaji = "";
			$text_pin = "";
			$id_jabatan_user = $this->get_id_jabatan($session_id);
			$level_record = $this->get_level($record->designation_id);
			$level_user = $this->get_level($id_jabatan_user);

			if (empty($level_user) || $level_user == "") {
				$level_user = "Z9";
			} else {
				if (strlen($level_user) == 1) {
					$level_user = $level_user . "0";
				}
			}

			if (empty($level_record) || $level_record == "") {
				$level_record = "Z9";
			} else {
				if (strlen($level_record) == 1) {
					$level_record = $level_record . "0";
				}
			}
			if ($level_record <= $level_user) {
				$text_gaji = "**********";
				$text_pin = "**********";
			} else {
				$text_gaji = $record->basic_salary;
				$text_pin = $record->private_code;
			}

			// if ("B" >= "D2") {
			// 	$text_gaji = "**********";
			// } else {
			// 	$text_gaji = $record->basic_salary . " ";
			// }

			// $data[] = array(
			// 	"status" => $text_resign,
			// 	"nip" => $record->employee_id,
			// 	"nama" => strtoupper($record->first_name),
			// 	"company_name" => strtoupper($this->get_nama_company($record->company_id)),
			// 	"department_name" => strtoupper($this->get_nama_department($record->department_id)),
			// 	"jabatan" => strtoupper($record->designation_name),
			// 	"project" => strtoupper($this->get_nama_project($record->project_id)),
			// 	"sub_project" => strtoupper($this->get_nama_sub_project($record->sub_project_id)),
			// 	"area" => strtoupper($record->penempatan),
			// 	"region" => strtoupper($record->region),
			// 	"tempat_lahir" => strtoupper($record->tempat_lahir),
			// 	"date_of_birth" => $this->Xin_model->tgl_indo($record->date_of_birth),
			// 	"date_of_joining" => $this->Xin_model->tgl_indo($record->date_of_joining),
			// 	"contract_start" => $this->Xin_model->tgl_indo($record->contract_start),
			// 	"contract_end" => $this->Xin_model->tgl_indo($record->contract_end),
			// 	"basic_salary" => $text_gaji,
			// 	"date_of_leaving" => $this->Xin_model->tgl_indo($record->date_of_leaving),
			// 	"gender" => $record->gender,
			// 	"text_marital" => $text_marital,
			// 	"agama" => strtoupper($this->get_nama_agama($record->ethnicity_type)),
			// 	"email" => strtoupper($record->email),
			// 	"contact_no" => $record->contact_no,
			// 	"pendidikan" => strtoupper($this->get_nama_pendidikan($record->last_edu)),
			// 	"alamat_ktp" => strtoupper($record->alamat_ktp),
			// 	"alamat_domisili" => strtoupper($record->alamat_domisili),
			// 	"no_kk" => $record->kk_no . " ",
			// 	"no_ktp" => $record->ktp_no,
			// 	"no_npwp" => $record->npwp_no . " ",
			// 	"bpjs_tk" => $record->bpjs_tk_no . " ",
			// 	"bpjs_ks" => $record->bpjs_ks_no . " ",
			// 	"nama_ibu" => strtoupper($record->ibu_kandung),
			// 	"nama_kontak" => strtoupper($this->get_nama_kontak_darurat($record->ktp_no)),
			// 	"hubungan_kontak" => strtoupper($this->get_hubungan_kontak_darurat($record->ktp_no)),
			// 	"nomor_kontak" => $this->get_nomor_kontak_darurat($record->ktp_no) . " ",
			// 	"nama_bank" => strtoupper($this->get_nama_bank($record->bank_name)),
			// 	"no_rekening" => $record->nomor_rek . " ",
			// 	"pemilik_rekening" => strtoupper($record->pemilik_rek),
			// 	"foto_ktp" => $text_ktp,
			// 	"foto_kk" => $text_kk,
			// 	"foto_npwp" => $text_npwp,
			// 	"foto_ijazah" => $text_ijazah,
			// 	"foto_skck" => $text_skck,
			// 	"foto_cv" => $text_cv,
			// 	"foto_paklaring" => $text_paklaring,
			// 	"dokumen_pkwt" => $this->get_link_pkwt($record->employee_id),
			// 	"tanggal_pkwt" => $this->get_tanggal_pkwt($record->employee_id),
			// 	// $this->get_nama_karyawan($record->upload_by)
			// );

			$data[] = array(
				$text_resign,
				$record->employee_id,
				$text_pin,
				$record->ktp_no,
				trim(strtoupper($record->first_name), " "),
				// strtoupper($record->first_name),
				strtoupper($this->get_nama_company($record->company_id)),
				strtoupper($this->get_nama_department($record->department_id)),
				strtoupper($record->designation_name),
				strtoupper($this->get_nama_project($record->project_id)),
				strtoupper($this->get_nama_sub_project($record->sub_project_id)),
				strtoupper($record->penempatan),
				strtoupper($record->region),
				strtoupper($record->tempat_lahir),
				$this->Xin_model->tgl_indo($record->date_of_birth),
				$this->Xin_model->tgl_indo($record->date_of_joining),
				$this->Xin_model->tgl_indo($record->from_date),
				$this->Xin_model->tgl_indo($record->to_date),
				$text_gaji,
				$this->Xin_model->tgl_indo($record->date_of_leaving),
				$record->gender,
				$text_marital,
				strtoupper($this->get_nama_agama($record->ethnicity_type)),
				strtoupper($record->email),
				$record->contact_no,
				strtoupper($this->get_nama_pendidikan($record->last_edu)),
				strtoupper($record->alamat_ktp),
				strtoupper($record->alamat_domisili),
				$record->kk_no,
				$record->ktp_no,
				$record->npwp_no,
				$record->bpjs_tk_no,
				$record->bpjs_ks_no,
				strtoupper($record->ibu_kandung),
				strtoupper($this->get_nama_kontak_darurat($record->ktp_no)),
				strtoupper($this->get_hubungan_kontak_darurat($record->ktp_no)),
				$this->get_nomor_kontak_darurat($record->ktp_no),
				strtoupper($this->get_nama_bank($record->bank_name)),
				$record->nomor_rek,
				strtoupper($record->pemilik_rek),
				$text_ktp,
				$text_kk,
				$text_npwp,
				$text_ijazah,
				$text_skck,
				$text_cv,
				$text_paklaring,
				$record->file_name,
				$record->upload_pkwt,
				// $this->get_tanggal_pkwt($record->upload_pkwt),
				// $this->get_nama_karyawan($record->upload_by)
			);
		}

		//print_r($this->db->last_query());
		//die;
		//var_dump($postData);
		//var_dump($this->db->last_query());

		return $data;
		//json_encode($data);
	}


	public function get_req_empproject($empID)
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title from xin_projects WHERE project_id in (SELECT distinct(project) FROM xin_employee_request 
		WHERE request_empby is not null 
		AND approved_naeby is not null
		AND approved_nomby is not null
		AND approved_hrdby is null
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		AND cancel_stat = 0)
        
		ORDER BY title asc");
		return $query->result();
	} //AND e_status = 0)

	public function get_proj_pkwtchecker($empID)
	{
		$query = $this->db->query("SELECT project_id, CONCAT('[',priority,']', ' ', title) AS title from xin_projects WHERE project_id in (SELECT  distinct(project) FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom != 0
			AND approve_hrd = 0
			AND cancel_stat = 0
	        -- AND project in (8,97,90,106,94,46,74)
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC)");
		return $query->result();
	}

	// monitoring request
	public function get_request_tkhl($empID)
	{

		$sql = "SELECT * FROM xin_employee_request 
		WHERE request_empby is not null 
		AND approved_naeby is not null
		AND approved_nomby is not null
		AND approved_hrdby is null
		AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		AND cancel_stat = 0
        AND e_status = 1";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_request_approve($empID)
	{


		$sql = "SELECT secid,nik_ktp,fullname,location_id,project,sub_project,department,posisi,penempatan,doj,contact_no,approved_naeby,approved_nomby,approved_hrdby,cancel_stat
				FROM xin_employee_request
				WHERE datediff(current_date(),DATE_FORMAT(createdon, '%Y-%m-%d')) <=30
				AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
				ORDER BY createdon DESC";

		// $sql = "SELECT * FROM xin_employee_request 
		// WHERE request_empby is not null 
		// AND approved_naeby is not null
		// AND approved_nomby is not null
		// AND approved_hrdby is not null
		// AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')";

		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign($empID)
	{

		$sql = "SELECT *
		FROM xin_employees
		WHERE request_resign_by is not null
	    AND project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		ORDER BY request_resign_date DESC LIMIT 50;";

		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign_cancel($empID)
	{

		$sql = "SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ('NULL','0')	
		-- AND approve_resignnae NOT IN ('NULL','0')
		-- AND approve_resignnom NOT IN ('NULL','0')
		AND approve_resignhrd IS NULL
		AND cancel_resign_stat = 1
	    AND project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
		ORDER BY request_resign_date DESC;";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign_nae()
	{

		$sql = 'SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ("NULL","0")		
		AND approve_resignnae IS NULL
		AND approve_resignnom IS NULL
		AND cancel_resign_stat = 0
		ORDER BY request_resign_date DESC;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign_nom()
	{

		$sql = 'SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ("NULL","0")
		AND approve_resignnae NOT IN ("NULL","0")
		AND approve_resignnom IS NULL
		-- AND project_id NOT IN (22)
		AND cancel_resign_stat = 0
		ORDER BY request_resign_date DESC;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	// monitoring request
	public function get_monitoring_rsign_ho()
	{

		$sql = 'SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ("NULL","0")
		AND approve_resignnae NOT IN ("NULL","0")
		AND approve_resignnom IS NULL
		-- AND project_id = 22
		ORDER BY request_resign_date DESC;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign_hrd()
	{

		$sql = 'SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ("NULL","0")
		AND approve_resignnae NOT IN ("NULL","0")
		AND approve_resignnom NOT IN ("NULL","0")
		AND approve_resignhrd IS NULL
		AND cancel_resign_stat = 0
		ORDER BY request_resign_date DESC;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// monitoring request
	public function get_monitoring_rsign_history()
	{

		$sql = 'SELECT *
		FROM xin_employees
		WHERE request_resign_by NOT IN ("NULL","0")
		AND approve_resignnae NOT IN ("NULL","0")
		AND approve_resignnom NOT IN ("NULL","0")
		AND approve_resignhrd IS NOT NULL
		ORDER BY request_resign_date DESC;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_employees_request()
	{

		$sql = 'SELECT * FROM xin_employee_request WHERE verified_by is null';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	// get all employes
	public function default_list()
	{

		$sql = "SELECT '2' FROM DUAL;";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_employees_request_verify()
	{

		$sql = 'SELECT * FROM xin_employee_request WHERE verified_by is not null AND approved_by is null';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_employees_request_approve()
	{

		$sql = 'SELECT *
				FROM xin_employee_request
				WHERE datediff(current_date(),DATE_FORMAT(createdon, "%Y-%m-%d")) <=30
				AND migrasi = 1
				ORDER BY modifiedon DESC';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_employees_master()
	{

		$sql = 'SELECT * FROM xin_employees WHERE e_status = 1';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}


	// get single employee
	public function read_employee_info($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee
	public function checknik($nik)
	{

		$sql = 'SELECT max(date_of_joining), emp.employee_id, emp.first_name, emp.designation_id, pos.designation_name, emp.project_id,pro.priority, pro.title, emp.company_id,emp.ktp_no, emp.status_resign
FROM xin_employees emp
LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id
LEFT JOIN xin_projects pro ON pro.project_id = emp.project_id
WHERE ktp_no = ?';
		$binds = array($nik);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_employee_info_by_nik($id)
	{

		$sql = "SELECT *, DATE_FORMAT(date_resign_request, '%Y-%m-%d') AS tanggal_resign FROM xin_employees WHERE employee_id = ? AND user_id not in (1)";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single employee by NIP
	public function read_employee_info_eslip($id)
	{

		$sql = "SELECT * FROM xin_employees WHERE employee_id = ? AND user_id not in (1)";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIK KTP
	public function read_employee_info_by_nik_ktp($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE ktp_no = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee request
	public function read_employee_request($id)
	{
		$sql = "SELECT * FROM xin_employee_request WHERE secid = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee request 2
	public function read_employee_request2($id)
	{
		$this->db->select('*');
		$this->db->from('xin_employee_request');
		$this->db->where('secid', $id);

		$query = $this->db->get()->row_array();

		return $query;
	}



	// get single employee request
	public function read_employee_expired($id)
	{

		$sql = "SELECT * FROM xin_employees WHERE employee_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_eslip_info_by_nip_periode($id, $periode)
	{

		$sql = 'SELECT * FROM xin_employees_eslip WHERE nip = ? and periode = ?';
		$binds = array($id, $periode);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_eslip_info_by_id($id)
	{

		$sql = 'SELECT * FROM xin_employees_eslip WHERE secid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_eslip_by_nip($id)
	{

		$sql = 'SELECT * FROM xin_employees_eslip WHERE nip = ? ORDER BY secid DESC LIMIT 3';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return null;
		}
	}


	// get single employee by NIP
	public function read_saltab_by_nip($id)
	{

		$sql = "
			SELECT  bulk.periode_cutoff_from, bulk.periode_cutoff_to, bulk.eslip_release, bulk.project_id, bulk.project_name, bulk.total_mpp, saltab.* 
			FROM xin_saltab saltab
			LEFT JOIN xin_saltab_bulk_release bulk ON bulk.id = saltab.uploadid
			WHERE bulk.eslip_release is not null
			AND DATE_FORMAT(bulk.eslip_release, '%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')
			AND nip = ?
			ORDER BY bulk.id DESC LIMIT 6";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return null;
		}
	}

	// get saltab by NIP v.2
	public function read_saltab_by_nip2($id)
	{

		$sql = "
			
			SELECT saltab.secid, saltab.nip, saltab.fullname, saltab.jabatan, bulk.periode_cutoff_from, bulk.periode_cutoff_to, bulk.periode_salary, bulk.project_name  
			FROM xin_saltab saltab
			LEFT JOIN xin_saltab_bulk_release bulk ON bulk.id = saltab.uploadid
			WHERE bulk.eslip_release is not null
			AND DATE_FORMAT(bulk.eslip_release, '%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')
			AND nip = ?
			ORDER BY bulk.id DESC LIMIT 6";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			$result = $query->result_array();

			$data = array();

			foreach ($result as $record) {
				$data[] = array(
					"id_eslip" => $record['secid'],
					"nip" => $record['nip'],
					"nama" => strtoupper($record['fullname']),
					"cutoff_start" => $this->Xin_model->tgl_indo($record['periode_cutoff_from']),
					"cutoff_end" => $this->Xin_model->tgl_indo($record['periode_cutoff_to']),
					"project" => strtoupper($record['project_name']),
					"jabatan" => strtoupper($record['jabatan']),
					"tanggal_penggajian" => $this->Xin_model->tgl_indo($record['periode_salary']),
					"button_lihat" => '<button onclick="lihat_eslip(' . $record['secid'] . ',' . $record['nip'] . ')" class="btn btn-sm btn-outline-success mr-1 my-1">Lihat e-Slip</button>',
				);
			}
		} else {
			$data = null;
		}

		return $data;
	}

	// get all my team employes > not super admin
	public function get_employees_my_team($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id != ? and reports_to = ?';
		$binds = array(1, $cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all employes > not super admin
	public function get_employees_for_other($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id != ? and company_id = ?';
		$binds = array(1, $cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all employes > not super admin
	public function get_employees_for_location($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id != ? and location_id = ?';
		$binds = array(1, $cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}


	// get all employes|company>
	public function get_company_employees_flt($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all MY TEAM employes
	public function get_my_team_employees($reports_to)
	{

		$sql = 'SELECT * FROM xin_employees WHERE reports_to = ?';
		$binds = array($reports_to);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employes temporary
	public function get_employees_temp($importid)
	{

		$sql = 'SELECT * FROM xin_employees_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employes>company|location >
	public function get_company_location_employees_flt($cid, $lid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id = ?';
		$binds = array($cid, $lid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all employes>company|location|department >
	public function get_company_location_department_employees_flt($cid, $lid, $dep_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id = ? and department_id = ?';
		$binds = array($cid, $lid, $dep_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all employes>company|location|department|designation >
	public function get_company_location_department_designation_employees_flt($cid, $lid, $dep_id, $des_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id = ? and department_id = ? and designation_id = ?';
		$binds = array($cid, $lid, $dep_id, $des_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get all employes >
	public function get_employees_payslip()
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_role_id != ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get employes
	public function get_attendance_employees()
	{

		$sql = 'SELECT * FROM xin_employees WHERE is_active = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employes with location
	public function get_attendance_location_employees($location_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE location_id = ? and is_active = ?';
		$binds = array($location_id, 1);
		$query = $this->db->query($sql, $binds);

		return $query;
	}



	// get single record > company | locations
	public function ajax_project_sub($id)
	{

		$sql = 'SELECT * FROM xin_projects_sub WHERE id_project = ? AND sub_active = 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single record > company | locations
	public function ajax_project_posisi($id)
	{

		$sql = "SELECT pos.posisi, jab.designation_name FROM xin_projects_posisi pos
LEFT JOIN xin_designations jab ON jab.designation_id = pos.posisi
WHERE pos.project_id = ?
ORDER BY jab.designation_id ASC";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get total number of employees
	public function get_total_employees()
	{
		$query = $this->db->get("xin_employees");
		return $query->num_rows();
	}

	public function read_employee_information($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_saltab_by_id($id)
	{

		$sql = "SELECT bulk.periode_cutoff_from, bulk.periode_cutoff_to, bulk.periode_salary, bulk.project_name, saltab.* 
				FROM xin_saltab saltab
				LEFT JOIN xin_saltab_bulk_release bulk ON bulk.id = saltab.uploadid
				WHERE secid = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_saltab_temp_by_id($id)
	{

		$sql = "SELECT bulk.periode_cutoff_from, bulk.periode_cutoff_to, bulk.periode_salary, bulk.project_name, saltab.* 
				FROM xin_saltab_temp saltab
				LEFT JOIN xin_saltab_bulk bulk ON bulk.id = saltab.uploadid
				WHERE secid = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	public function read_employee_information_nip($nip)
	{

		$sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
		$binds = array($nip);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_employee_nae($id)
	{

		$sql = "SELECT * FROM xin_employees WHERE sub_project_id = '1' AND user_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee by NIP
	public function read_employee_jabatan($id)
	{

		$sql = 'SELECT emp.employee_id, emp.first_name, emp.designation_id, pos.designation_name FROM xin_employees emp LEFT JOIN xin_designations pos ON pos.designation_id = emp.designation_id WHERE emp.employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function CheckExistNIK($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function CheckExistNIP_Periode($id, $periode)
	{

		$sql = 'SELECT * FROM xin_employees_eslip WHERE nip = ? and periode = ?';
		$binds = array($id, $periode);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function CheckExistNIP_esaltab($id, $periode, $project)
	{

		$sql = 'SELECT * FROM xin_employees_saltab WHERE fullname = ? and periode = ? and project = ?';
		$binds = array($id, $periode, $project);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function CheckExistNIP($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// check akses project
	public function check_akses_project($empid, $projectid)
	{

		$sql = 'SELECT * FROM xin_projects_akses WHERE nip = ? AND project_id = ?';
		$binds = array($empid, $projectid);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}


	// check employeeID
	public function check_employee_id($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	// check old password
	public function check_old_password($old_password, $user_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		//$rw_password = $query->result();
		$options = array('cost' => 12);
		$password_hash = password_hash($old_password, PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if (password_verify($old_password, $rw_password[0]->password)) {
				return 1;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	// check username
	public function check_employee_username($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE username = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// check email
	public function check_employee_email($id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE email = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// check email
	public function check_employee_pincode($pincode)
	{

		$sql = 'SELECT * FROM xin_employees WHERE pincode = ?';
		$binds = array($pincode);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	// Function to add record in table
	public function add($data)
	{
		$this->db->insert('xin_employees', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addeslip($data)
	{
		$this->db->insert('xin_employees_eslip', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addtemp($data)
	{
		$this->db->insert('xin_employees_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addkandidat($data)
	{
		$this->db->insert('xin_employee_request', $data);
		// $this->db->insert('xin_employee_kandidat', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	// Function to add record in table
	public function addrequest($data)
	{
		$this->db->insert('xin_employee_request', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function request_resign($data, $id)
	{

		$this->db->where('employee_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Import try
	public function add_marital($data)
	{
		$this->db->insert('mt_marital', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_record($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('xin_employees');
	}

	// Function to Delete selected record from table
	public function delete_temp_by_employeeid()
	{
		$this->db->where('employee_id', 'nip');
		$this->db->delete('xin_employees_temp');
	}
	/*  Update Employee Record */

	// Function to Delete selected record from table
	public function delete_new_emp($id)
	{
		$this->db->where('secid', $id);
		$this->db->delete('xin_employee_request');
	}

	// Function to update record in table
	public function update_record($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_record_bynip($data, $id)
	{
		$this->db->where('employee_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}


	// Function to update record in table > basic_info
	public function basic_info($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > basic_info
	public function update_error_temp($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employees_temp', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > basic_info
	public function update_error_eslip_temp($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employees_eslip_temp', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > change_password
	public function change_password($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > social_info
	public function social_info($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > profile picture
	public function profile_picture($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table
	public function update_request_employee($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employee_request', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update kontak darurat
	public function update_kontak_darurat($nik_ktp, $employee_id)
	{
		$data = array(
			'nip' => $employee_id,
		);

		$this->db->where('employee_request_nik', $nik_ktp);
		if ($this->db->update('xin_employee_emergency', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function save_pkwt_expired($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_resign_apnae($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_resign_apnom($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_employees', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > contact_info
	public function contact_info_add($data)
	{
		$this->db->insert('xin_employee_contacts', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > contact_info
	public function contact_info_update($data, $id)
	{
		$this->db->where('contact_id', $id);
		if ($this->db->update('xin_employee_contacts', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > document_info_update
	public function document_info_update($data, $id)
	{
		$this->db->where('document_id', $id);
		if ($this->db->update('xin_employee_documents', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > document_info_update
	public function img_document_info_update($data, $id)
	{
		$this->db->where('immigration_id', $id);
		if ($this->db->update('xin_employee_immigration', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > document info
	public function document_info_add($data)
	{
		$this->db->insert('xin_employee_documents', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
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

	// Function to add record in table > immigration info
	public function immigration_info_add($data)
	{
		$this->db->insert('xin_employee_immigration', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	// Function to add record in table > qualification_info_add
	public function qualification_info_add($data)
	{
		$this->db->insert('xin_employee_qualification', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > qualification_info_update
	public function qualification_info_update($data, $id)
	{
		$this->db->where('qualification_id', $id);
		if ($this->db->update('xin_employee_qualification', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > work_experience_info_add
	public function work_experience_info_add($data)
	{
		$this->db->insert('xin_employee_work_experience', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > work_experience_info_update
	public function work_experience_info_update($data, $id)
	{
		$this->db->where('work_experience_id', $id);
		if ($this->db->update('xin_employee_work_experience', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > bank_account_info_add
	public function bank_account_info_add($data)
	{
		$this->db->insert('xin_employee_bankaccount', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > security level info_add
	public function security_level_info_add($data)
	{
		$this->db->insert('xin_employee_security_level', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > bank_account_info_update
	public function bank_account_info_update($data, $id)
	{
		$this->db->where('bankaccount_id', $id);
		if ($this->db->update('xin_employee_bankaccount', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table > security_level_info_update
	public function security_level_info_update($data, $id)
	{
		$this->db->where('security_level_id', $id);
		if ($this->db->update('xin_employee_security_level', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > contract_info_add
	public function contract_info_add($data)
	{
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	//for current contact > employee
	public function check_employee_contact_current($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ? and contact_type = ? limit 1';
		$binds = array($id, 'current');
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	//for permanent contact > employee
	public function check_employee_contact_permanent($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ? and contact_type = ? limit 1';
		$binds = array($id, 'permanent');
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get current contacts by id
	public function read_contact_info_current($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? and contact_type = ? limit 1';
		$binds = array($id, 'current');
		$query = $this->db->query($sql, $binds);

		$row = $query->row();
		return $row;
	}

	// get permanent contacts by id
	public function read_contact_info_permanent($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? and contact_type = ? limit 1';
		$binds = array($id, 'permanent');
		$query = $this->db->query($sql, $binds);

		$row = $query->row();
		return $row;
	}

	// Function to update record in table > contract_info_update
	public function contract_info_update($data, $id)
	{
		$this->db->where('contract_id', $id);
		if ($this->db->update('xin_employee_contract', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > leave_info_add
	public function leave_info_add($data)
	{
		$this->db->insert('xin_employee_leave', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table > leave_info_update
	public function leave_info_update($data, $id)
	{
		$this->db->where('leave_id', $id);
		if ($this->db->update('xin_employee_leave', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > shift_info_add
	public function shift_info_add($data)
	{
		$this->db->insert('xin_employee_shift', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > shift_info_update
	public function shift_info_update($data, $id)
	{
		$this->db->where('emp_shift_id', $id);
		if ($this->db->update('xin_employee_shift', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table > location_info_add
	public function location_info_add($data)
	{
		$this->db->insert('xin_employee_location', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > location_info_update
	public function location_info_update($data, $id)
	{
		$this->db->where('office_location_id', $id);
		if ($this->db->update('xin_employee_location', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// get all office shifts 
	public function all_office_shifts()
	{
		$query = $this->db->query("SELECT * from xin_office_shift");
		return $query->result();
	}

	// get contacts
	public function set_employee_contacts($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get documents
	public function set_employee_documents($id)
	{

		$sql = 'SELECT * FROM xin_employee_documents WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get documents
	public function get_documents_expired_all()
	{

		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_documents where date_of_expiry < '" . $curr_date . "' ORDER BY `date_of_expiry` asc");
		return $query;
	}
	// user/
	public function get_user_documents_expired_all($employee_id)
	{

		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_documents where employee_id = '" . $employee_id . "' and date_of_expiry < '" . $curr_date . "' ORDER BY `date_of_expiry` asc");
		return $query;
	}
	// get immigration documents
	public function get_img_documents_expired_all()
	{

		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_immigration where expiry_date < '" . $curr_date . "' ORDER BY `expiry_date` asc");
		return $query;
	}
	//user // get immigration documents
	public function get_user_img_documents_expired_all($employee_id)
	{

		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_immigration where employee_id = '" . $employee_id . "' and expiry_date < '" . $curr_date . "' ORDER BY `expiry_date` asc");
		return $query;
	}
	public function company_license_expired_all()
	{
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_company_documents where expiry_date < '" . $curr_date . "' ORDER BY `expiry_date` asc");
		return $query;
	}
	public function get_company_license_expired($company_id)
	{

		$curr_date = date('Y-m-d');
		$sql = "SELECT * FROM xin_company_documents WHERE expiry_date < '" . $curr_date . "' and company_id = ?";
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// assets warranty all
	public function warranty_assets_expired_all()
	{
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where warranty_end_date < '" . $curr_date . "' ORDER BY `warranty_end_date` asc");
		return $query;
	}
	// user assets warranty all
	public function user_warranty_assets_expired_all($employee_id)
	{
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where employee_id = '" . $employee_id . "' and warranty_end_date < '" . $curr_date . "' ORDER BY `warranty_end_date` asc");
		return $query;
	}
	// company assets warranty all
	public function company_warranty_assets_expired_all($company_id)
	{
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where company_id = '" . $company_id . "' and warranty_end_date < '" . $curr_date . "' ORDER BY `warranty_end_date` asc");
		return $query;
	}
	// get immigration
	public function set_employee_immigration($id)
	{

		$sql = 'SELECT * FROM xin_employee_immigration WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee qualification
	public function set_employee_qualification($id)
	{

		$sql = 'SELECT * FROM xin_employee_qualification WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee work experience
	public function set_employee_experience($id)
	{

		$sql = 'SELECT * FROM xin_employee_work_experience WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee bank account
	public function set_employee_bank_account($id)
	{

		$sql = 'SELECT * FROM xin_employee_bankaccount WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee bank account
	public function set_employee_security_level($id)
	{

		$sql = 'SELECT * FROM xin_employee_security_level WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee bank account > Last
	public function get_employee_bank_account_last($id)
	{

		$sql = 'SELECT * FROM xin_employee_bankaccount WHERE employee_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee contract
	public function set_employee_contract($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ? AND status_pkwt = 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee office shift
	public function set_employee_shift($id)
	{

		$sql = 'SELECT * FROM xin_employee_shift WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee leave
	public function set_employee_leave($id)
	{

		$sql = 'SELECT * FROM xin_employee_leave WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee location
	public function set_employee_location($id)
	{

		$sql = 'SELECT * FROM xin_employee_location WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get document type by id
	public function read_document_type_information($id)
	{

		$sql = 'SELECT * FROM xin_document_type WHERE document_type_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// contract type
	public function read_contract_type_information($id)
	{

		$sql = 'SELECT * FROM xin_contract_type WHERE contract_type_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// contract employee
	public function read_contract_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// office shift
	public function read_shift_information($id)
	{

		$sql = 'SELECT * FROM xin_office_shift WHERE office_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}



	// get all contract types
	public function all_contract_types()
	{
		$query = $this->db->query("SELECT * from xin_contract_type");
		return $query->result();
	}

	// get all contracts
	public function all_contracts()
	{
		$query = $this->db->query("SELECT * from xin_employee_contract");
		return $query->result();
	}

	// get all document types
	public function all_document_types()
	{
		$query = $this->db->query("SELECT * from xin_document_type");
		return $query->result();
	}

	// get all document types
	public function all_document_types_ready($id)
	{


		$sql = 'SELECT * 
FROM xin_document_type 
WHERE document_type_id 
NOT IN (SELECT distinct(document_type_id) AS iddoc FROM xin_employee_documents WHERE employee_id = ?)';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get all education level
	public function all_education_level()
	{
		$query = $this->db->query("SELECT * from xin_qualification_education_level");
		return $query->result();
	}

	// get education level by id
	public function read_education_information($id)
	{

		$sql = 'SELECT * FROM xin_qualification_education_level WHERE education_level_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get all qualification languages
	public function all_qualification_language()
	{
		$query = $this->db->query("SELECT * from xin_qualification_language");
		return $query->result();
	}

	// get languages by id
	public function read_qualification_language_information($id)
	{

		$sql = 'SELECT * FROM xin_qualification_language WHERE language_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get all qualification skills
	public function all_qualification_skill()
	{
		$query = $this->db->query("SELECT * from xin_qualification_skill");
		return $query->result();
	}

	// get qualification by id
	public function read_qualification_skill_information($id)
	{

		$sql = 'SELECT * FROM xin_qualification_skill WHERE skill_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get contacts by id
	public function read_contact_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get documents by id
	public function read_document_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_documents WHERE document_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get documents by id
	public function read_imgdocument_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_immigration WHERE immigration_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get qualifications by id
	public function read_qualification_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_qualification WHERE qualification_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get qualifications by id
	public function read_work_experience_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_work_experience WHERE work_experience_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get bank account by id
	public function read_bank_account_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_bankaccount WHERE bankaccount_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get sc level by id
	public function read_security_level_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_security_level WHERE security_level_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get leave by id
	public function read_leave_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_leave WHERE leave_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get shift by id
	public function read_emp_shift_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_shift WHERE emp_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to Delete selected record from table
	public function delete_contact_record($id)
	{
		$this->db->where('contact_id', $id);
		$this->db->delete('xin_employee_contacts');
	}

	// Function to Delete selected record from table
	public function delete_document_record($id)
	{
		$this->db->where('document_id', $id);
		$this->db->delete('xin_employee_documents');
	}

	// Function to Delete selected record from table
	public function delete_imgdocument_record($id)
	{
		$this->db->where('immigration_id', $id);
		$this->db->delete('xin_employee_immigration');
	}

	// Function to Delete selected record from table
	public function delete_qualification_record($id)
	{
		$this->db->where('qualification_id', $id);
		$this->db->delete('xin_employee_qualification');
	}

	// Function to Delete selected record from table
	public function delete_work_experience_record($id)
	{
		$this->db->where('work_experience_id', $id);
		$this->db->delete('xin_employee_work_experience');
	}

	// Function to Delete selected record from table
	public function delete_bank_account_record($id)
	{
		$this->db->where('bankaccount_id', $id);
		$this->db->delete('xin_employee_bankaccount');
	}
	// Function to Delete selected record from table
	public function delete_security_level_record($id)
	{
		$this->db->where('security_level_id', $id);
		$this->db->delete('xin_employee_security_level');
	}

	// Function to Delete selected record from table
	public function delete_contract_record($id)
	{
		$this->db->where('contract_id', $id);
		$this->db->delete('xin_employee_contract');
	}

	// Function to Delete selected record from table
	public function delete_leave_record($id)
	{
		$this->db->where('leave_id', $id);
		$this->db->delete('xin_employee_leave');
	}

	// Function to Delete selected record from table
	public function delete_shift_record($id)
	{
		$this->db->where('emp_shift_id', $id);
		$this->db->delete('xin_employee_shift');
	}

	// Function to Delete selected record from table
	public function delete_location_record($id)
	{
		$this->db->where('office_location_id', $id);
		$this->db->delete('xin_employee_location');
	}

	// get location by id
	public function read_location_information($id)
	{

		$sql = 'SELECT * FROM xin_employee_location WHERE office_location_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function record_count()
	{
		$sql = 'SELECT * FROM xin_employees where user_role_id!=1';
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	public function record_count_myteam($reports_to)
	{
		$sql = 'SELECT * FROM xin_employees where user_role_id!=1 and reports_to = ' . $reports_to . '';
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	// read filter record
	public function get_employee_by_department($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE department_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// read filter record
	public function record_count_company_employees($cid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// read filter record
	public function record_count_company_location_employees($cid, $lid)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id= ?';
		$binds = array($cid, $lid);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// read filter record
	public function record_count_company_location_department_employees($cid, $lid, $dep_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id= ? and department_id= ?';
		$binds = array($cid, $lid, $dep_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// read filter record
	public function record_count_company_location_department_designation_employees($cid, $lid, $dep_id, $des_id)
	{

		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and location_id= ? and department_id= ? and designation_id= ?';
		$binds = array($cid, $lid, $dep_id, $des_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	//reports_to -> my employees
	public function fetch_all_team_employees($limit, $start)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		//$this->db->where("user_role_id!=",1);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$this->db->where("reports_to", $session['user_id']);
		$this->db->where("user_role_id!=1");
		$query = $this->db->get("xin_employees");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function fetch_all_employees($limit, $start)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		//$this->db->where("user_role_id!=",1);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if ($user_info[0]->user_role_id != 1) {
			$this->db->where("company_id", $user_info[0]->company_id);
		}
		$this->db->where("user_role_id!=1");
		$query = $this->db->get("xin_employees");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	// get company employees
	public function fetch_all_company_employees_flt($limit, $start, $cid)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		$this->db->where("company_id", $cid);
		$query = $this->db->get("xin_employees");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	// get company|location employees
	public function fetch_all_company_location_employees_flt($limit, $start, $cid, $lid)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		$this->db->where("company_id=", $cid);
		$this->db->where("location_id=", $lid);
		$query = $this->db->get("xin_employees");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	// get company|location|department employees
	public function fetch_all_company_location_department_employees_flt($limit, $start, $cid, $lid, $dep_id)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		$this->db->where("company_id=", $cid);
		$this->db->where("location_id=", $lid);
		$this->db->where("department_id=", $dep_id);
		$query = $this->db->get("xin_employees");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	// get company|location|department|designation employees
	public function fetch_all_company_location_department_designation_employees_flt($limit, $start, $cid, $lid, $dep_id, $des_id)
	{
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
		$this->db->where("company_id=", $cid);
		$this->db->where("location_id=", $lid);
		$this->db->where("department_id=", $dep_id);
		$this->db->where("designation_id=", $des_id);
		$query = $this->db->get("xin_employees");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function des_fetch_all_employees($limit, $start)
	{
		// $this->db->limit($limit, $start);

		$sql = 'SELECT * FROM xin_employees order by designation_id asc limit ?, ?';
		$binds = array($limit, $start);
		$query = $this->db->query($sql, $binds);

		//  $query = $this->db->get("xin_employees");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	// get employee allowances
	public function set_employee_allowances($id)
	{

		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee commissions
	public function set_employee_commissions($id)
	{

		$sql = 'SELECT * FROM xin_salary_commissions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee statutory deductions
	public function set_employee_statutory_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_statutory_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee other payments
	public function set_employee_other_payments($id)
	{

		$sql = 'SELECT * FROM xin_salary_other_payments WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee overtime
	public function set_employee_overtime($id)
	{

		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee allowances
	public function set_employee_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	//-- payslip data
	// get employee allowances
	public function set_employee_allowances_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_allowances WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee commissions
	public function set_employee_commissions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_commissions WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee other payments
	public function set_employee_other_payments_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_other_payments WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee statutory_deductions
	public function set_employee_statutory_deductions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_statutory_deductions WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	// get employee overtime
	public function set_employee_overtime_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_overtime WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get employee allowances
	public function set_employee_deductions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_loan WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	//------
	// get employee allowances
	public function count_employee_allowances_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_allowances WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee commissions
	public function count_employee_commissions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_commissions WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee statutory_deductions
	public function count_employee_statutory_deductions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_statutory_deductions WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee other payments
	public function count_employee_other_payments_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_other_payments WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee overtime
	public function count_employee_overtime_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_overtime WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get employee allowances
	public function count_employee_deductions_payslip($id)
	{

		$sql = 'SELECT * FROM xin_salary_payslip_loan WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	//////////////////////
	// get employee allowances
	public function count_employee_allowances($id)
	{

		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee commissions
	public function count_employee_commissions($id)
	{

		$sql = 'SELECT * FROM xin_salary_commissions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee other payments
	public function count_employee_other_payments($id)
	{

		$sql = 'SELECT * FROM xin_salary_other_payments WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee statutory deduction
	public function count_employee_statutory_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_statutory_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	// get employee overtime
	public function count_employee_overtime($id)
	{

		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get employee allowances
	public function count_employee_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get employee salary allowances
	public function read_salary_allowances($id)
	{

		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee salary commissions
	public function read_salary_commissions($id)
	{

		$sql = 'SELECT * FROM xin_salary_commissions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee salary other payments
	public function read_salary_other_payments($id)
	{

		$sql = 'SELECT * FROM xin_salary_other_payments WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee statutory deductions
	public function read_salary_statutory_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_statutory_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee overtime
	public function read_salary_overtime($id)
	{

		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee salary loan_deduction
	public function read_salary_loan_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee salary loan_deduction
	public function read_single_loan_deductions($id)
	{

		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE loan_deduction_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	//Calculates how many months is past between two timestamps.
	public function get_month_diff($start, $end = FALSE)
	{
		$end or $end = time();
		$start = new DateTime($start);
		$end   = new DateTime($end);
		$diff  = $start->diff($end);
		return $diff->format('%y') * 12 + $diff->format('%m');
	}
	// get employee salary allowances
	public function read_single_salary_allowance($id)
	{

		$sql = 'SELECT * FROM xin_salary_allowances WHERE allowance_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee commissions
	public function read_single_salary_commissions($id)
	{

		$sql = 'SELECT * FROM xin_salary_commissions WHERE salary_commissions_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get
	public function read_single_salary_statutory_deduction($id)
	{

		$sql = 'SELECT * FROM xin_salary_statutory_deductions WHERE statutory_deductions_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_single_salary_other_payment($id)
	{

		$sql = 'SELECT * FROM xin_salary_other_payments WHERE other_payments_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get employee overtime record
	public function read_salary_overtime_record($id)
	{

		$sql = 'SELECT * FROM xin_salary_overtime WHERE salary_overtime_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to add record in table > allowance
	public function add_salary_allowances($data)
	{
		$this->db->insert('xin_salary_allowances', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > commissions
	public function add_salary_commissions($data)
	{
		$this->db->insert('xin_salary_commissions', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > statutory_deductions
	public function add_salary_statutory_deductions($data)
	{
		$this->db->insert('xin_salary_statutory_deductions', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > other payments
	public function add_salary_other_payments($data)
	{
		$this->db->insert('xin_salary_other_payments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > loan
	public function add_salary_loan($data)
	{
		$this->db->insert('xin_salary_loan_deductions', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table > overtime
	public function add_salary_overtime($data)
	{
		$this->db->insert('xin_salary_overtime', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to Delete selected record from table
	public function delete_allowance_record($id)
	{
		$this->db->where('allowance_id', $id);
		$this->db->delete('xin_salary_allowances');
	}
	// Function to Delete selected record from table
	public function delete_commission_record($id)
	{
		$this->db->where('salary_commissions_id', $id);
		$this->db->delete('xin_salary_commissions');
	}
	// Function to Delete selected record from table
	public function delete_statutory_deductions_record($id)
	{
		$this->db->where('statutory_deductions_id', $id);
		$this->db->delete('xin_salary_statutory_deductions');
	}
	// Function to Delete selected record from table
	public function delete_other_payments_record($id)
	{
		$this->db->where('other_payments_id', $id);
		$this->db->delete('xin_salary_other_payments');
	}
	// Function to Delete selected record from table
	public function delete_loan_record($id)
	{
		$this->db->where('loan_deduction_id', $id);
		$this->db->delete('xin_salary_loan_deductions');
	}
	// Function to Delete selected record from table
	public function delete_overtime_record($id)
	{
		$this->db->where('salary_overtime_id', $id);
		$this->db->delete('xin_salary_overtime');
	}
	// Function to update record in table > update allowance record
	public function salary_allowance_update_record($data, $id)
	{
		$this->db->where('allowance_id', $id);
		if ($this->db->update('xin_salary_allowances', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table >
	public function salary_commissions_update_record($data, $id)
	{
		$this->db->where('salary_commissions_id', $id);
		if ($this->db->update('xin_salary_commissions', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table >
	public function salary_statutory_deduction_update_record($data, $id)
	{
		$this->db->where('statutory_deductions_id', $id);
		if ($this->db->update('xin_salary_statutory_deductions', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table >
	public function salary_other_payment_update_record($data, $id)
	{
		$this->db->where('other_payments_id', $id);
		if ($this->db->update('xin_salary_other_payments', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table > update allowance record
	public function salary_loan_update_record($data, $id)
	{
		$this->db->where('loan_deduction_id', $id);
		if ($this->db->update('xin_salary_loan_deductions', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table > update allowance record
	public function salary_overtime_update_record($data, $id)
	{
		$this->db->where('salary_overtime_id', $id);
		if ($this->db->update('xin_salary_overtime', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// get single record > company | office shift
	public function ajax_company_officeshift_information($id)
	{

		$sql = 'SELECT * FROM xin_office_shift WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	public function ktp_exist_blacklist($ktp)
	{
		$query = $this->db->query("SELECT ktp_no FROM xin_employees WHERE status_resign = '3' AND ktp_no = '$ktp';");
		return $query->num_rows();
	}

	public function ktp_exist_active($ktp)
	{
		$query = $this->db->query("SELECT ktp_no FROM xin_employees WHERE status_resign = '1' AND ktp_no = '$ktp';");
		return $query->num_rows();
	}

	public function ktp_exist_regis($ktp)
	{
		$query = $this->db->query("SELECT nik_ktp AS ktp_no FROM xin_employee_request WHERE migrasi = 0 AND nik_ktp = '$ktp';");
		return $query->num_rows();
	}

	// get single project by id
	public function read_ethnicity($id)
	{

		$sql = 'SELECT * FROM xin_ethnicity_type WHERE ethnicity_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	//ambil status kawin
	function get_status_kawin_nama($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('nama');
			$this->db->from('mt_marital');
			$this->db->where('id_marital', $id);

			$query = $this->db->get()->row_array();

			//return $query['name'];
			if (empty($query)) {
				return $id;
			} else {
				if ($query['nama'] == null) {
					return "";
				} else {
					return $query['nama'];
				}
			}
		}
	}

	// get all my team employes > not super admin
	public function get_all_employees_active()
	{

		$sql = 'SELECT user_id, employee_id, CONCAT( employee_id, " - ", first_name) AS fullname FROM xin_employees WHERE is_active = 1 AND employee_id not IN (1)';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all my team employes > not super admin
	public function get_all_employees_resign()
	{

		$sql = 'SELECT user_id, employee_id, CONCAT( employee_id, " - ", first_name) AS fullname FROM xin_employees WHERE is_active = 1 AND  status_resign = 2 AND employee_id not IN (1)';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// public function get_maxid() {
	// 	$sql = 'SELECT max(employee_id) AS maxid FROM xin_employees';
	// 	$query = $this->db->query($sql);
	//     return $query->result();
	// }

	public function get_maxid()
	{
		// $query = $this->db->query("SELECT max(employee_id) AS maxid FROM xin_employees");
		//   return $query->result();

		$maxid = 0;
		$row = $this->db->query("SELECT max(employee_id) AS maxid FROM xin_employees")->row();
		if ($row) {
			$maxid = $row->maxid;
		}
		return $maxid;
	}

	// public function get_countries()
	// {
	//   $query = $this->db->query("SELECT * from xin_countries");
	//  	  return $query->result();
	// }


	//ambil data jabatan berdasarkan sub project untuk Json
	public function getJabatanBySubProject($postData)
	{
		//$otherdb = $this->load->database('default', TRUE);

		$this->db->select('*');
		$this->db->from('xin_projects_posisi');
		$this->db->join('xin_designations', 'xin_designations.designation_id=xin_projects_posisi.posisi');
		$this->db->where('sub_project', $postData['sub_project']);

		$query = $this->db->get()->result_array();

		return $query;
	}

	//ambil PIN employee
	public function get_pin($postData)
	{
		$this->db->select('first_name,employee_id,private_code');
		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil jabatan employee
	public function get_jabatan($postData)
	{
		$this->db->select('first_name,employee_id,designation_id');
		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//update PIN employee
	public function update_pin($postData)
	{
		$this->db->set('private_code', $postData['pin_baru']);
		$this->db->set('password', $postData['password_hash']);
		$this->db->set('username', $postData['employee_id']);
		$this->db->where('employee_id', $postData['employee_id']);
		$this->db->update('xin_employees');
	}

	//ambil data diri employee
	public function get_data_diri($postData)
	{
		$this->db->select('employee_id');
		$this->db->select('first_name');
		$this->db->select('gender');
		$this->db->select('tempat_lahir');
		$this->db->select('date_of_birth');
		$this->db->select('last_edu');
		$this->db->select('ethnicity_type');
		$this->db->select('marital_status');
		$this->db->select('tinggi_badan');
		$this->db->select('berat_badan');
		$this->db->select('blood_group');

		$this->db->select('ktp_no');
		$this->db->select('kk_no');
		$this->db->select('npwp_no');
		$this->db->select('contact_no');
		$this->db->select('email');
		$this->db->select('ibu_kandung');
		$this->db->select('alamat_ktp');
		$this->db->select('alamat_domisili');

		$this->db->select('bank_name');
		$this->db->select('nomor_rek');
		$this->db->select('pemilik_rek');

		$this->db->select('status_resign');
		$this->db->select('deactive_by');
		$this->db->select('deactive_date');
		$this->db->select('deactive_reason');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data project employee
	public function get_data_project($postData)
	{
		$this->db->select('user_role_id');
		$this->db->select('sub_project_id');
		$this->db->select('designation_id');
		$this->db->select('penempatan');
		$this->db->select('location_id');
		$this->db->select('date_of_joining');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data kontak employee
	public function get_data_kontak($postData)
	{
		$this->db->select('ktp_no');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		$this->db->select('*');

		$this->db->from('xin_employee_emergency',);
		$this->db->where('employee_request_nik', $query['ktp_no']);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}



	//ambil data rekening employee
	public function get_data_rekening($postData)
	{
		$this->db->select('verification_id');
		$this->db->select('bank_name');
		$this->db->select('nomor_rek');
		$this->db->select('pemilik_rek');
		$this->db->select('filename_rek');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data rekening employee
	public function get_data_bpjs($postData)
	{
		$this->db->select('bpjs_tk_no');
		$this->db->select('bpjs_ks_no');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data verification_id employee
	public function get_verification_id($postData)
	{
		$this->db->select('verification_id');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data buku tabungan employee
	public function get_data_buku_tabungan($postData)
	{
		$this->db->select('bank_name');
		$this->db->select('nomor_rek');
		$this->db->select('pemilik_rek');
		$this->db->select('filename_rek');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data dokumen pribadi employee
	public function get_data_dokumen_pribadi($postData)
	{
		$this->db->select('gender');
		$this->db->select('filename_ktp');
		$this->db->select('filename_kk');
		$this->db->select('filename_npwp');
		$this->db->select('filename_cv');
		$this->db->select('filename_skck');
		$this->db->select('filename_isd');
		$this->db->select('filename_rek');
		$this->db->select('profile_picture');

		$this->db->from('xin_employees',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data dokumen kontrak ttd employee
	public function get_data_dokumen_kontrak($postData)
	{
		$this->db->select('*');

		$this->db->from('xin_employee_contract');
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data dokumen addendum ttd employee
	public function get_data_dokumen_addendum($postData)
	{
		$this->db->select('*');

		$this->db->from('xin_contract_addendum');
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data kontrak+addendum employee
	public function get_data_kontrak($nip, $karyawan_id)
	{
		//ambil role resource id
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// get data kontrak
		$this->db->select('uniqueid');
		$this->db->select('from_date');
		$this->db->select('to_date');
		$this->db->select('no_surat');
		$this->db->select('project');
		$this->db->select('sub_project');
		$this->db->select('jabatan');

		$this->db->from('xin_employee_contract');
		$this->db->where('cancel_stat', "0");
		$this->db->where('employee_id', $nip);

		$query = $this->db->get()->result_array();

		// get data addendum
		$this->db->select('id');
		$this->db->select('kontrak_start_new');
		$this->db->select('kontrak_end_new');
		$this->db->select('no_addendum');
		$this->db->select('tgl_terbit');
		$this->db->select('xin_employee_contract.project');
		$this->db->select('xin_employee_contract.sub_project');
		$this->db->select('xin_employee_contract.jabatan');


		$this->db->from('xin_contract_addendum');
		$this->db->join('xin_employee_contract', 'xin_employee_contract.contract_id = xin_contract_addendum.pkwt_id', 'left');
		$this->db->where('xin_contract_addendum.cancel_stat', "0");
		$this->db->where('karyawan_id', $karyawan_id);

		$query2 = $this->db->get()->result_array();

		$data = array();

		foreach ($query as $record) {
			if (in_array('1010', $role_resources_ids)) {
				$button_hapus = '<button onclick="hapus_kontrak(\'' . $record['uniqueid'] . '\')" class="btn btn-sm btn-outline-danger mr-1 my-1">Hapus Kontrak</button>';
			} else {
				$button_hapus = '';
			}
			$data[] = array(
				"jenis_dokumen" => "KONTRAK",
				"nomor_surat" => $record['no_surat'],
				"periode_start" => $this->Xin_model->tgl_indo($record['from_date']),
				"periode_end" => $this->Xin_model->tgl_indo($record['to_date']),
				"project" => strtoupper($this->get_nama_project($record['project'])),
				"sub_project" => strtoupper($this->get_nama_sub_project($record['sub_project'])),
				"jabatan" => strtoupper($this->get_nama_jabatan($record['jabatan'])),
				"tanggal_terbit" => $this->Xin_model->tgl_indo($record['from_date']),
				"button_open" => '<button onclick="open_kontrak(\'' . $record['uniqueid'] . '\',' . $record['sub_project'] . ')" class="btn btn-sm btn-outline-primary mr-1 my-1">Download Draft Kontrak</button>',
				"button_upload" => '<button onclick="upload_kontrak(\'' . $record['uniqueid'] . '\')" class="btn btn-sm btn-outline-primary mr-1 my-1">Upload Kontrak</button>',
				"button_lihat" => '<button onclick="lihat_kontrak(\'' . $record['uniqueid'] . '\')" class="btn btn-sm btn-outline-success mr-1 my-1">Lihat Kontrak</button>',
				"button_hapus" => $button_hapus,
			);
		}

		foreach ($query2 as $record) {
			if (in_array('1010', $role_resources_ids)) {
				$button_hapus = '<button onclick="hapus_addendum(' . $record['id'] . ')" class="btn btn-sm btn-outline-danger mr-1 my-1">Hapus Kontrak</button>';
			} else {
				$button_hapus = '';
			}
			$data[] = array(
				"jenis_dokumen" => "ADDENDUM",
				"nomor_surat" => $record['no_addendum'],
				"periode_start" => $this->Xin_model->tgl_indo($record['kontrak_start_new']),
				"periode_end" => $this->Xin_model->tgl_indo($record['kontrak_end_new']),
				"project" => strtoupper($this->get_nama_project($record['project'])),
				"sub_project" => strtoupper($this->get_nama_sub_project($record['sub_project'])),
				"jabatan" => strtoupper($this->get_nama_jabatan($record['jabatan'])),
				"tanggal_terbit" => $this->Xin_model->tgl_indo($record['tgl_terbit']),
				"button_open" => '<button onclick="open_addendum(' . $record['id'] . ')" class="btn btn-sm btn-outline-primary mr-1 my-1">Download Draft Kontrak</button>',
				"button_upload" => '<button onclick="upload_addendum(' . $record['id'] . ')" class="btn btn-sm btn-outline-primary mr-1 my-1">Upload Kontrak</button>',
				"button_lihat" => '<button onclick="lihat_addendum(' . $record['id'] . ')" class="btn btn-sm btn-outline-success mr-1 my-1">Lihat Kontrak</button>',
				"button_hapus" => $button_hapus,
			);
		}

		array_multisort(array_column($data, "tanggal_terbit"), SORT_DESC, $data);

		return $data;
	}

	//ambil data addendum employee
	public function get_data_addendum($karyawan_id)
	{
		// get data addendum
		$this->db->select('id');
		$this->db->select('kontrak_start_new');
		$this->db->select('kontrak_end_new');
		$this->db->select('no_addendum');
		$this->db->select('tgl_terbit');
		$this->db->select('xin_employee_contract.project');
		$this->db->select('xin_employee_contract.sub_project');
		$this->db->select('xin_employee_contract.jabatan');


		$this->db->from('xin_contract_addendum');
		$this->db->join('xin_employee_contract', 'xin_employee_contract.contract_id = xin_contract_addendum.pkwt_id', 'left');
		$this->db->where('xin_contract_addendum.cancel_stat', "0");
		$this->db->where('karyawan_id', $karyawan_id);

		$query = $this->db->get()->result_array();

		return $query;
	}

	//ambil data detail addendum employee
	public function get_detail_addendum($datarequest)
	{
		// $this->db->select('*');no_surat
		$this->db->select('kontrak_start_new');
		$this->db->select('kontrak_end_new');
		$this->db->select('no_addendum');
		$this->db->select('tgl_terbit');
		$this->db->select('xin_employee_contract.project');
		$this->db->select('xin_employee_contract.sub_project');
		$this->db->select('xin_employee_contract.jabatan');

		$this->db->from('xin_contract_addendum');
		$this->db->join('xin_employee_contract', 'xin_employee_contract.contract_id = xin_contract_addendum.pkwt_id', 'left');
		$this->db->where($datarequest);

		$query = $this->db->get()->row_array();

		$data = array(
			"jenis_dokumen" => "ADDENDUM",
			"nomor_surat" => $query['no_addendum'],
			"periode_start" => $this->Xin_model->tgl_indo($query['kontrak_start_new']),
			"periode_end" => $this->Xin_model->tgl_indo($query['kontrak_end_new']),
			"project" => strtoupper($this->get_nama_project($query['project'])),
			"sub_project" => strtoupper($this->get_nama_sub_project($query['sub_project'])),
			"jabatan" => strtoupper($this->get_nama_jabatan($query['jabatan'])),
			"tanggal_terbit" => $this->Xin_model->tgl_indo($query['tgl_terbit']),
		);

		return $data;
	}

	//ambil data detail kontrak employee
	public function get_detail_kontrak($datarequest)
	{
		// get data kontrak
		$this->db->select('from_date');
		$this->db->select('to_date');
		$this->db->select('no_surat');
		$this->db->select('project');
		$this->db->select('sub_project');
		$this->db->select('jabatan');

		$this->db->from('xin_employee_contract');
		$this->db->where('cancel_stat', "0");
		$this->db->where($datarequest);

		$query = $this->db->get()->row_array();

		$data = array(
			"jenis_dokumen" => "KONTRAK",
			"nomor_surat" => $query['no_surat'],
			"periode_start" => $this->Xin_model->tgl_indo($query['from_date']),
			"periode_end" => $this->Xin_model->tgl_indo($query['to_date']),
			"project" => strtoupper($this->get_nama_project($query['project'])),
			"sub_project" => strtoupper($this->get_nama_sub_project($query['sub_project'])),
			"jabatan" => strtoupper($this->get_nama_jabatan($query['jabatan'])),
			"tanggal_terbit" => $this->Xin_model->tgl_indo($query['from_date']),
		);

		return $data;
	}

	//save data diri employee
	public function save_data_diri($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('first_name');
		$this->db->select('gender');
		$this->db->select('tempat_lahir');
		$this->db->select('date_of_birth');
		$this->db->select('last_edu');
		$this->db->select('ethnicity_type');
		$this->db->select('marital_status');
		$this->db->select('tinggi_badan');
		$this->db->select('berat_badan');
		$this->db->select('blood_group');
		$this->db->select('ktp_no');
		$this->db->select('kk_no');
		$this->db->select('npwp_no');
		$this->db->select('contact_no');
		$this->db->select('email');
		$this->db->select('ibu_kandung');
		$this->db->select('alamat_ktp');
		$this->db->select('alamat_domisili');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//hapus detail single kontrak employee
	public function hapus_detail_kontrak($postData, $id)
	{
		//update data
		$this->db->where('uniqueid', $id);
		$this->db->update('xin_employee_contract', $postData);
	}

	//hapus detail single addendum employee
	public function hapus_detail_addendum($postData, $id)
	{
		//update data
		$this->db->where('id', $id);
		$this->db->update('xin_contract_addendum', $postData);
	}

	//save data project employee
	public function save_project($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('sub_project_id');
		$this->db->select('designation_id');
		$this->db->select('penempatan');
		$this->db->select('location_id');
		$this->db->select('date_of_joining');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data kontak employee
	public function save_kontak($postData, $nip)
	{
		$this->db->select('ktp_no');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		//update data
		$this->db->where('employee_request_nik', $query['ktp_no']);
		$this->db->update('xin_employee_emergency', $postData);

		//fetch data terbaru
		$this->db->select('*');

		$this->db->from('xin_employee_emergency',);
		$this->db->where('employee_request_nik', $query['ktp_no']);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data bpjs employee
	public function save_data_bpjs($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('bpjs_tk_no');
		$this->db->select('bpjs_ks_no');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data resign employee
	public function save_data_resign($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('status_resign');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data project employee
	public function save_rekening($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('bank_name');
		$this->db->select('nomor_rek');
		$this->db->select('pemilik_rek');
		$this->db->select('filename_rek');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data project employee
	public function save_file_rekening($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		//fetch data terbaru
		$this->db->select('bank_name');
		$this->db->select('nomor_rek');
		$this->db->select('pemilik_rek');
		$this->db->select('filename_rek');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save data project employee
	public function save_file_dokumen($postData, $nip)
	{
		//update data
		$this->db->where('employee_id', $nip);
		$this->db->update('xin_employees', $postData);

		// //fetch data terbaru
		$this->db->select('gender');
		$this->db->select('filename_ktp');
		$this->db->select('filename_kk');
		$this->db->select('filename_npwp');
		$this->db->select('filename_cv');
		$this->db->select('filename_skck');
		$this->db->select('filename_isd');
		$this->db->select('filename_rek');
		$this->db->select('profile_picture');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//save file kontrak employee
	public function save_file_kontrak($postData, $id)
	{
		//update data
		$this->db->where('uniqueid', $id);
		$this->db->update('xin_employee_contract', $postData);
	}

	//save file addendum employee
	public function save_file_addendum($postData, $id)
	{
		//update data
		$this->db->where('id', $id);
		$this->db->update('xin_contract_addendum', $postData);
	}

	//get data employee by nip
	public function get_employee_array_by_nip($nip)
	{
		// //fetch data terbaru
		$this->db->select('*');

		$this->db->from('xin_employees',);
		$this->db->where('employee_id', $nip);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//get data employee by nip
	public function is_have_project_access($project_id)
	{
		$session = $this->session->userdata('username');

		// //fetch data terbaru
		$this->db->select('*');

		$this->db->from('xin_projects_akses',);
		$this->db->where('project_id', $project_id);
		$this->db->where('nip', $session['employee_id']);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->result_array();

		if(empty($query)){
			return false;
		} else {
			return true;
		}
	}
}

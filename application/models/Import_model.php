<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Import_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_employees_temp()
	{
		return $this->db->get("xin_employees_temp");
	}

	public function get_all_users()
	{
		$query = $this->db->get("xin_users");
		return $query->result();
	}


	public function get_temp_employees($id)
	{

		$sql = 'SELECT * FROM xin_employees_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_eslip_by_id($id)
	{

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
	public function get_all_eslip($empID)
	{

		if ($empID == '21502900') {

			$sql = "SELECT uploadid, periode, project, project_sub, createdby, DATE_FORMAT(createdon, '%Y-%m-%d') AS up_date, COUNT(nip) AS total_mp 
FROM xin_employees_eslip
WHERE project = 'PT. Indofarma Global Medika'
GROUP BY uploadid ORDER BY uploadid DESC LIMIT 100";
		} else {

			$sql = "SELECT uploadid, periode, project, project_sub, createdby, DATE_FORMAT(createdon, '%Y-%m-%d') AS up_date, COUNT(nip) AS total_mp 
FROM xin_employees_eslip
WHERE createdby = '$empID'
GROUP BY uploadid ORDER BY uploadid DESC LIMIT 100";
		}

		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_all_saltab()
	{

		$sql = "SELECT uploadid, periode, project, project_sub, createdby, DATE_FORMAT(createdon, '%Y-%m-%d') AS up_date, COUNT(nip) AS total_mp FROM xin_employees_saltab
GROUP BY uploadid ORDER BY uploadid DESC LIMIT 100";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_eslip_project()
	{

		$sql = "SELECT uploadid, periode, project, project_sub, downloadby, createdby, DATE_FORMAT(createdon, '%Y-%m-%d') AS up_date, COUNT(nip) AS total_mp FROM xin_employees_saltab
		WHERE createdby != 0
GROUP BY uploadid ORDER BY uploadid DESC LIMIT 150";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_all_ratecard()
	{

		$sql = "SELECT uploadid, periode, project, sub_project, createdby, DATE_FORMAT(createdon,'%Y-%m-%d') AS up_date
FROM xin_employee_ratecard
GROUP BY uploadid ORDER BY uploadid DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	// get all employes
	public function get_all_temp_eslip()
	{

		$sql = 'SELECT uploadid, periode, project, project_sub, COUNT(nip) AS total_mp FROM xin_employees_eslip
GROUP BY uploadid, periode, project, project_sub;';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_temp_eslip($id)
	{

		$sql = 'SELECT * FROM xin_employees_eslip_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_temp_esaltab($id)
	{

		$sql = 'SELECT * FROM xin_employees_saltab_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// get single employee
	public function read_esaltab_temp_info($id)
	{

		$sql = 'SELECT * FROM xin_employees_saltab_temp WHERE secid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_temp_ratecard($id)
	{

		$sql = 'SELECT * FROM xin_employee_ratecard_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	// get single employee by NIP
	public function read_ratecard_info_by_project_periode($periode, $project, $area, $jabatan)
	{

		$sql = 'SELECT * FROM xin_employee_ratecard WHERE periode = ? and project_id = ? and kota = ? and posisi_jabatan = ?';
		$binds = array($periode, $project, $area, $jabatan);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to update record in table > basic_info
	public function update_error_ratecard_temp($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employee_ratecard_temp', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addratecard($data)
	{
		$this->db->insert('xin_employee_ratecard', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addesaltab($data)
	{
		$this->db->insert('xin_employees_saltab', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function get_temp_pkwt($id)
	{

		$sql = 'SELECT * FROM xin_employee_contract_temp WHERE uploadid = ? AND status_error is null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function CheckExistRatecard_Periode($project, $periode)
	{

		$sql = 'SELECT * FROM xin_employee_ratecard WHERE project_id = ? and periode = ?';
		$binds = array($project, $periode);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_users_info($id)
	{

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
	public function check_user_email($email)
	{

		$sql = 'SELECT * FROM xin_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	//get table saltab
	public function get_saltab_table()
	{
		$data = [""];

		$this->db->select('*');
		$this->db->from('mt_tabel_esaltab');
		//$this->db->limit(2147483647, 2);

		$query = $this->db->get()->result_array();
		if (empty($query)) {
			$data = [""];
		} else {
			$data = $query;
		}

		return $data;
	}

	public function get_detail_saltab($id = null)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('xin_saltab_temp');
		$this->db->where('secid', $id);

		$records = $this->db->get()->row_array();

		$result_index = array_keys($records);
		$result_value = array_values($records);

		$length = count($result_index);

		for ($i = 2; $i < ($length); $i++) {
			$data[] = array(
				$this->get_nama_kolom_detail_saltab($result_index[$i]),
				$result_value[$i],
			);
		}

		return $data;
	}

	public function get_detail_saltab_release($id = null)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('xin_saltab');
		$this->db->where('secid', $id);

		$records = $this->db->get()->row_array();

		$result_index = array_keys($records);
		$result_value = array_values($records);

		$length = count($result_index);

		for ($i = 2; $i < ($length); $i++) {
			$data[] = array(
				$this->get_nama_kolom_detail_saltab($result_index[$i]),
				$result_value[$i],
			);
		}

		return $data;
	}

	public function get_nama_kolom_detail_saltab($nama_tabel)
	{
		$this->db->select('*');
		$this->db->from('mt_tabel_esaltab');
		$this->db->where('nama_tabel', $nama_tabel);

		$records = $this->db->get()->row_array();

		return $records['alias'];
	}

	//get table saltab untuk download excel
	public function get_saltab_temp_detail_excel($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_saltab_temp');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $records;
	}

	//get table saltab release untuk download excel
	public function get_saltab_temp_detail_excel_release($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $records;
	}


	// get all employes temporary
	public function get_eslip_preview($importid)
	{

		$sql = "SELECT eslip.*, emp.contact_no FROM xin_employees_eslip eslip LEFT JOIN xin_employees emp ON emp.employee_id = eslip.nip WHERE uploadid = ?";
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employes temporary
	public function get_eslip_temp($importid)
	{

		$sql = 'SELECT * FROM xin_employees_eslip_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employes temporary
	public function get_esaltab_temp($importid)
	{

		$sql = 'SELECT * FROM xin_employees_saltab_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employes temporary
	public function get_ratecard_temp($importid)
	{

		$sql = 'SELECT * FROM xin_employee_ratecard_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}


	// Function to add record in table
	public function add($data)
	{
		$this->db->insert('xin_users', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_record($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('xin_users');
	}
	// Function to Delete selected record from table
	public function delete_all_eslip_preview($uploadid)
	{
		$this->db->where('uploadid', $uploadid);
		$this->db->delete('xin_employees_eslip');
	}

	// Function to Delete selected record from table
	public function delete_all_eslip_temp_preview($uploadid)
	{
		$this->db->where('uploadid', $uploadid);
		$this->db->delete('xin_employees_eslip_temp');
	}


	// Function to update record in table > basic_info
	public function update_error_esaltab_temp($data, $id)
	{
		$this->db->where('secid', $id);
		if ($this->db->update('xin_employees_saltab_temp', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > basic_info
	public function update_release_eslip($data, $id)
	{
		$this->db->where('uploadid', $id);
		if ($this->db->update('xin_employees_eslip', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_record($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_users', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record without photo > in table
	public function update_record_no_photo($data, $id)
	{
		$this->db->where('user_id', $id);
		if ($this->db->update('xin_users', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addtemp($data)
	{
		$this->db->insert('xin_employees_eslip_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_saltab_temp($data)
	{
		$this->db->insert('xin_employees_saltab_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_temp_by_nip()
	{
		$this->db->where('nip', 'NIP');
		$this->db->delete('xin_employees_eslip_temp');
	}

	// Function to Delete selected record from table
	public function delete_saltabtemp_by_nip()
	{
		$this->db->where('nip', 'NIP');
		$this->db->delete('xin_employees_saltab_temp');
	}

	// Function to Delete selected record from table
	public function delete_temp_by_pt()
	{
		$this->db->where('company_id', 'PT');
		$this->db->delete('xin_employee_ratecard_temp');
	}

	// Function to add record in table
	public function addratecardtemp($data)
	{
		$this->db->insert('xin_employee_ratecard_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function get_id_saltab_batch($data)
	{
		$this->db->order_by('upload_on', 'desc');
		$query = $this->db->get_where('xin_saltab_bulk', $data);
		$result = $query->row_array();

		if (empty($result)) {
			return "";
		} else {
			return $result['id'];
		}
	}

	function get_saltab_batch($id)
	{

		$this->db->select('*');
		$this->db->from('xin_saltab_bulk');
		$this->db->where('id', $id);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function get_saltab_batch_release($id)
	{

		$this->db->select('*');
		$this->db->from('xin_saltab_bulk_release');
		$this->db->where('id', $id);

		$query = $this->db->get()->row_array();

		return $query;
	}

	/*
    |-------------------------------------------------------------------
    | Insert detail saltab Data
    |-------------------------------------------------------------------
    |
    | @param $data  detail saltab Array Data
    |
    */
	function insert_saltab_detail($data)
	{
		// $this->db->insert_batch("xin_employees_saltab_temp", $data);
		// if (!$this->db->insert_batch("xin_employees_saltab_temp", $data)) {
		// 	$error = $this->db->error(); // Has keys 'code' and 'message'
		// }

		$this->db->insert_batch("xin_saltab_temp", $data);

		// $tes_query = $this->db->last_query();
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
	}

	/*
    |-------------------------------------------------------------------
    | Insert bach saltab Data
    |-------------------------------------------------------------------
    |
    | @param $data  detail saltab Array Data
    |
    */
	function insert_saltab_batch($data)
	{
		$this->db->replace("xin_saltab_bulk", $data);
	}

	function delete_batch_saltab($id = null)
	{
		$this->db->delete('xin_saltab_bulk', array('id' => $id));
		$this->db->delete('xin_saltab_temp', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function delete_batch_saltab_release($id = null)
	{
		$this->db->delete('xin_saltab_bulk_release', array('id' => $id));
		$this->db->delete('xin_saltab', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function release_batch_saltab($id = null)
	{
		$session = $this->session->userdata('username');

		## Get Batch Saltab
		$this->db->select('*');
		$this->db->from('xin_saltab_bulk');
		$this->db->where('id', $id);
		$saltab_batch = $this->db->get()->result_array();

		## Get Detail Saltab
		$this->db->select('*');
		$this->db->from('xin_saltab_temp');
		$this->db->where('uploadid', $id);
		$saltab_detail = $this->db->get()->result_array();

		## Insert Batch Saltab Release
		$this->db->insert_batch("xin_saltab_bulk_release", $saltab_batch);

		## Insert Batch Saltab Detail
		$this->db->insert_batch("xin_saltab", $saltab_detail);

		## Delete Batch Saltab dan Delete Detail Saltab
		$this->delete_batch_saltab($id);

		## Update mpp
		$data = array(
			'upload_on' => null,
			'upload_by' => $this->get_nama_karyawan($session['employee_id']),
			'upload_by_id' => $session['employee_id'],
		);

		$this->db->where('id', $id);
		$this->db->update('xin_saltab_bulk_release', $data);
	}

	//delete detail saltab temporary
	function delete_detail_saltab($id = null)
	{
		//kalau delete data, update jumlah mpp pada batch
		## Get Batch Id
		$this->db->select('*');
		$this->db->from('xin_saltab_temp');
		$this->db->where('secid', $id);
		$query = $this->db->get()->row_array();
		$id_batch = $query['uploadid'];

		$this->db->delete('xin_saltab_temp', array('secid' => $id));

		## Total number of records 
		$this->db->select('count(*) as allcount');
		$this->db->where("uploadid", $id_batch);
		$records = $this->db->get('xin_saltab_temp')->result();
		$totalRecords = $records[0]->allcount;

		## Update mpp
		$data = array(
			'total_mpp' => $totalRecords,
		);

		$this->db->where('id', $id_batch);
		$this->db->update('xin_saltab_bulk', $data);
	}

	//delete detail saltab release
	function delete_detail_saltab_release($id = null)
	{
		//kalau delete data, update jumlah mpp pada batch
		## Get Batch Id
		$this->db->select('*');
		$this->db->from('xin_saltab');
		$this->db->where('secid', $id);
		$query = $this->db->get()->row_array();
		$id_batch = $query['uploadid'];

		$this->db->delete('xin_saltab', array('secid' => $id));

		## Total number of records 
		$this->db->select('count(*) as allcount');
		$this->db->where("uploadid", $id_batch);
		$records = $this->db->get('xin_saltab')->result();
		$totalRecords = $records[0]->allcount;

		## Update mpp
		$data = array(
			'total_mpp' => $totalRecords,
		);

		$this->db->where('id', $id_batch);
		$this->db->update('xin_saltab_bulk_release', $data);
	}

	//ambil nama employee
	function get_nama_karyawan($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('*');
			$this->db->from('xin_employees');
			$this->db->where('user_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['designation_name'];
			if ($query['first_name'] == null) {
				return "";
			} else {
				return $query['first_name'];
			}
		}
	}

	/*
	* persiapan data untuk datatable pagination
	* data list batch saltab
	* 
	* @author Fadla Qamara
	*/
	function get_list_batch_saltab($postData = null)
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
		//$nip = $postData['nip'];
		//$emp_id = $postData['emp_id'];
		//$contract_id = $postData['contract_id'];
		$session_id = $postData['session_id'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (project_name like '%" . $searchValue .  "%' or sub_project_name like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab_bulk')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_saltab_bulk')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab_bulk')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchSaltab(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$editReq = '<br><button type="button" onclick="downloadBatchSaltab(' . $record->id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
			$delete = '<br><button type="button" onclick="deleteBatchSaltab(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $editReq . " " . $delete,
				"tanggal_penggajian" => $this->Xin_model->tgl_indo($record->periode_salary),
				"periode" => $this->Xin_model->tgl_indo($record->periode_cutoff_from) . " s/d " . $this->Xin_model->tgl_indo($record->periode_cutoff_to),
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"total_mpp" => $record->total_mpp,
				"upload_by" => $record->upload_by,
				"upload_on" => $record->upload_on,
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

	/*
	* persiapan data untuk datatable pagination
	* data list batch saltab release
	* 
	* @author Fadla Qamara
	*/
	function get_list_batch_saltab_release($postData = null)
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
		$search_periode_from = $postData['search_periode_from'];
		$search_periode_to = $postData['search_periode_to'];
		//$emp_id = $postData['emp_id'];
		//$contract_id = $postData['contract_id'];
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

		$filterRangeFrom = "";
		if (($search_periode_from != null) && ($search_periode_from != "") && ($search_periode_from != '0')) {
			$filterRangeFrom = "(
				periode_salary >= '" . $search_periode_from . "'
			)";
		} else {
			$filterRangeFrom = "";
		}

		$filterRangeTo = "";
		if (($search_periode_to != null) && ($search_periode_to != "") && ($search_periode_to != '0')) {
			$filterRangeTo = "(
				periode_salary <= '" . $search_periode_to . "'
			)";
		} else {
			$filterRangeTo = "";
		}

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
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab_bulk_release')->result();
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
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$records = $this->db->get('xin_saltab_bulk_release')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab_bulk_release')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$periode_salary = "";
			if (empty($record->periode_salary) || ($record->periode_salary == "")) {
				$periode_salary = "--";
			} else {
				$periode_salary = $this->Xin_model->tgl_indo($record->periode_salary);
			}

			$text_periode_from = "";
			$text_periode_to = "";
			$text_periode = "";
			if (empty($record->periode_cutoff_from) || ($record->periode_cutoff_from == "")) {
				$text_periode_from = "";
			} else {
				$text_periode_from = $this->Xin_model->tgl_indo($record->periode_cutoff_from);
			}
			if (empty($record->periode_cutoff_to) || ($record->periode_cutoff_to == "")) {
				$text_periode_to = "";
			} else {
				$text_periode_to = $this->Xin_model->tgl_indo($record->periode_cutoff_to);
			}
			if (($text_periode_from == "") && ($text_periode_to == "")) {
				$text_periode = "";
			} else {
				$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			}
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
			$delete = '<br><button type="button" onclick="deleteBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $editReq . " " . $delete,
				// "periode_salary" => $periode_salary . "<br>" . $tes_query,
				"periode_salary" => $periode_salary,
				"periode" => $text_periode,
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"total_mpp" => $record->total_mpp,
				"upload_by" => $record->upload_by,
				"upload_on" => $record->upload_on,
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

	/*
	* persiapan data untuk datatable pagination
	* data list batch saltab release untuk download
	* 
	* @author Fadla Qamara
	*/
	function get_list_batch_saltab_release_download($postData = null)
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
		$search_periode_from = $postData['search_periode_from'];
		$search_periode_to = $postData['search_periode_to'];
		//$emp_id = $postData['emp_id'];
		//$contract_id = $postData['contract_id'];
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

		$filterRangeFrom = "";
		if (($search_periode_from != null) && ($search_periode_from != "") && ($search_periode_from != '0')) {
			$filterRangeFrom = "(
				periode_salary >= '" . $search_periode_from . "'
			)";
		} else {
			$filterRangeFrom = "";
		}

		$filterRangeTo = "";
		if (($search_periode_to != null) && ($search_periode_to != "") && ($search_periode_to != '0')) {
			$filterRangeTo = "(
				periode_salary <= '" . $search_periode_to . "'
			)";
		} else {
			$filterRangeTo = "";
		}

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
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab_bulk_release')->result();
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
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$records = $this->db->get('xin_saltab_bulk_release')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		if ($filterProject != '') {
			$this->db->where($filterProject);
		}
		if ($filterRangeFrom != '') {
			$this->db->where($filterRangeFrom);
		}
		if ($filterRangeTo != '') {
			$this->db->where($filterRangeTo);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab_bulk_release')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$periode_salary = "";
			if (empty($record->periode_salary) || ($record->periode_salary == "")) {
				$periode_salary = "--";
			} else {
				$periode_salary = $this->Xin_model->tgl_indo($record->periode_salary);
			}

			$text_periode_from = "";
			$text_periode_to = "";
			$text_periode = "";
			if (empty($record->periode_cutoff_from) || ($record->periode_cutoff_from == "")) {
				$text_periode_from = "";
			} else {
				$text_periode_from = $this->Xin_model->tgl_indo($record->periode_cutoff_from);
			}
			if (empty($record->periode_cutoff_to) || ($record->periode_cutoff_to == "")) {
				$text_periode_to = "";
			} else {
				$text_periode_to = $this->Xin_model->tgl_indo($record->periode_cutoff_to);
			}
			if (($text_periode_from == "") && ($text_periode_to == "")) {
				$text_periode = "";
			} else {
				$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			}
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
			$delete = '<br><button type="button" onclick="deleteBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $editReq,
				// "periode_salary" => $periode_salary . "<br>" . $tes_query,
				"periode_salary" => $periode_salary,
				"periode" => $text_periode,
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"total_mpp" => $record->total_mpp,
				"upload_by" => $record->upload_by,
				"upload_on" => $record->upload_on,
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

	/*
	* persiapan data untuk datatable pagination
	* data list detail saltab
	* 
	* @author Fadla Qamara
	*/
	function get_list_detail_saltab($postData = null)
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

		//variabel id batch
		$id_batch = $postData['id_batch'];
		$data_batch = $this->get_saltab_batch($id_batch);

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (nip like '%" . $searchValue .  "%' or fullname like '%" . $searchValue . "%' or nik like '%" . $searchValue . "%' or area like '%" . $searchValue . "%' or sub_project like '%" . $searchValue . "%' or jabatan like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(
			uploadid = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab_temp')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_saltab_temp')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab_temp')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$sub_project = "";

			if ($data_batch['sub_project_name'] == "-ALL-") {
				$sub_project = $record->sub_project;
			} else {
				$sub_project = $data_batch['sub_project_name'];
			}

			$view = '<button id="tesbutton" type="button" onclick="lihatDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$delete = '<br><button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $delete,
				"nik" => $record->nik,
				"nip" => $record->nip,
				"fullname" => $record->fullname,
				"sub_project" => $sub_project,
				"jabatan" => $record->jabatan,
				"area" => $record->area,
				"hari_kerja" => $record->hari_kerja,
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

	/*
	* persiapan data untuk datatable pagination
	* data list detail saltab release
	* 
	* @author Fadla Qamara
	*/
	function get_list_detail_saltab_release($postData = null)
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

		//variabel id batch
		$id_batch = $postData['id_batch'];
		$data_batch = $this->get_saltab_batch_release($id_batch);

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (nip like '%" . $searchValue .  "%' or fullname like '%" . $searchValue . "%' or nik like '%" . $searchValue . "%' or area like '%" . $searchValue . "%' or sub_project like '%" . $searchValue . "%' or jabatan like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(
			uploadid = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_saltab')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$sub_project = "";

			if ($data_batch['sub_project_name'] == "-ALL-") {
				$sub_project = $record->sub_project;
			} else {
				$sub_project = $data_batch['sub_project_name'];
			}

			$view = '<button id="tesbutton" type="button" onclick="lihatDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$delete = '<br><button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $delete,
				"nik" => $record->nik,
				"nip" => $record->nip,
				"fullname" => $record->fullname,
				"sub_project" => $sub_project,
				"jabatan" => $record->jabatan,
				"area" => $record->area,
				"hari_kerja" => $record->hari_kerja,
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

	/*
	* persiapan data untuk datatable pagination
	* data list detail saltab release untuk download
	* 
	* @author Fadla Qamara
	*/
	function get_list_detail_saltab_release_download($postData = null)
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

		//variabel id batch
		$id_batch = $postData['id_batch'];
		$data_batch = $this->get_saltab_batch_release($id_batch);

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (nip like '%" . $searchValue .  "%' or fullname like '%" . $searchValue . "%' or nik like '%" . $searchValue . "%' or area like '%" . $searchValue . "%' or sub_project like '%" . $searchValue . "%' or jabatan like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(
			uploadid = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_saltab')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_saltab')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$sub_project = "";

			if ($data_batch['sub_project_name'] == "-ALL-") {
				$sub_project = $record->sub_project;
			} else {
				$sub_project = $data_batch['sub_project_name'];
			}

			$view = '<button id="tesbutton" type="button" onclick="lihatDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$delete = '<br><button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view,
				"nik" => $record->nik,
				"nip" => $record->nip,
				"fullname" => $record->fullname,
				"sub_project" => $sub_project,
				"jabatan" => $record->jabatan,
				"area" => $record->area,
				"hari_kerja" => $record->hari_kerja,
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
}

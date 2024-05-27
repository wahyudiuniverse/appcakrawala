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

	//get table saltab untuk download excel
	public function get_saltab_temp_detail_excel($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_employees_saltab_temp');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		$tabel_saltab = $this->Import_model->get_saltab_table();
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
		$query = $this->db->get_where('xin_employees_saltab_bulk', $data);
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
		$this->db->from('xin_employees_saltab_bulk');
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
		$this->db->insert_batch("xin_employees_saltab_temp", $data);
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
		$this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function delete_batch_saltab($id = null)
	{
		// $id = $postData['id'];
		// if ($id == null) {
		// 	return "";
		// } else if ($id == 0) {
		// 	return "";
		// } else {
		// 	$this->db->where('id', $id);
		// 	$this->db->delete('xin_employees_saltab_bulk');

		// 	return "Sukses";
		// }

		$this->db->delete('xin_employees_saltab_bulk', array('id' => $id));
		$this->db->delete('xin_employees_saltab_temp', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
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
		//$idsession = $postData['idsession'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (project_name like '%" . $searchValue .  "%' or sub_project_name like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		// $kondisiDefaultQuery = "(
		// 	karyawan_id = " . $emp_id . "
		// AND	pkwt_id = " . $contract_id . "
		// )";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		//$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_employees_saltab_bulk')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		//$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_employees_saltab_bulk')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		//$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_employees_saltab_bulk')->result();

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
				"periode" => $this->Xin_model->tgl_indo($record->periode_saltab_from) . " s/d " . $this->Xin_model->tgl_indo($record->periode_saltab_to),
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
			$searchQuery = " (nip like '%" . $searchValue .  "%' or fullname like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(
			uploadid = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_employees_saltab_temp')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_employees_saltab_temp')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_employees_saltab_temp')->result();

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
			$editReq = '<br><button type="button" onclick="editDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-success" >EDIT</button>';
			$delete = '<br><button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $editReq . " " . $delete,
				"nik" => $record->nik,
				"nip" => $record->nip,
				"fullname" => $record->fullname,
				"periode_salary" => $record->periode_salary,
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

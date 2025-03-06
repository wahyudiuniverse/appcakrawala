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

	// Function to update record in table > basic_info
	public function update_pkwt_emp($data, $id)
	{
		$this->db->where('employee_id', $id);
		if ($this->db->update('xin_employees', $data)) {
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
		// $this->db->limit(2147483647, 1);

		$query = $this->db->get()->result_array();
		if (empty($query)) {
			$data = [""];
		} else {
			$data = $query;
		}

		return $data;
	}

	//get table bupot
	public function get_bupot_table()
	{
		$data = [""];

		$this->db->select('*');
		$this->db->from('mt_tabel_bupot');
		// $this->db->limit(2147483647, 1);

		$query = $this->db->get()->result_array();
		if (empty($query)) {
			$data = [""];
		} else {
			$data = $query;
		}

		return $data;
	}

	//get table bpjs
	public function get_bpjs_table()
	{
		$data = [""];

		$this->db->select('*');
		$this->db->from('mt_tabel_bpjs');
		// $this->db->limit(2147483647, 1);

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
			// $button_edit_nip = "";
			// if (in_array('1101', $role_resources_ids)) {
			// 	if ($i == "3") {
			// 		$button_edit_nip = '<button type="button" onclick="edit_nip(' . $id . ')" class="btn btn-sm btn-outline-success ml-2" ><i class="fa fa-file mr-1"></i> EDIT NIP</button>';
			// 	}
			// }

			// $data[] = array(
			// 	$this->get_nama_kolom_detail_saltab($result_index[$i]),
			// 	$result_value[$i] . $button_edit_nip,
			// );

			$data[] = array(
				$this->get_nama_kolom_detail_saltab($result_index[$i]),
				$result_value[$i],
			);
		}

		return $data;
	}

	public function get_detail_bupot($id = null)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('xin_bupot');
		$this->db->where('id', $id);

		$records = $this->db->get()->row_array();

		$result_index = array_keys($records);
		$result_value = array_values($records);

		$length = count($result_index);

		for ($i = 1; $i < ($length); $i++) {
			// $button_edit_nip = "";
			// if (in_array('1101', $role_resources_ids)) {
			// 	if ($i == "3") {
			// 		$button_edit_nip = '<button type="button" onclick="edit_nip(' . $id . ')" class="btn btn-sm btn-outline-success ml-2" ><i class="fa fa-file mr-1"></i> EDIT NIP</button>';
			// 	}
			// }

			// $data[] = array(
			// 	$this->get_nama_kolom_detail_saltab($result_index[$i]),
			// 	$result_value[$i] . $button_edit_nip,
			// );

			$nama_kolom = $this->get_nama_kolom_detail_bupot($result_index[$i]);

			if ($nama_kolom != "") {
				$data[] = array(
					$nama_kolom,
					$result_value[$i],
				);
			}
		}

		return $data;
	}

	public function get_detail_saltab_release($id = null)
	{
		$role_resources_ids = $this->Xin_model->user_role_resource();

		$data = array();
		$this->db->select('*');
		$this->db->from('xin_saltab');
		$this->db->where('secid', $id);

		$records = $this->db->get()->row_array();

		$result_index = array_keys($records);
		$result_value = array_values($records);

		$length = count($result_index);

		for ($i = 2; $i < ($length); $i++) {
			$button_edit_nip = "";
			if (in_array('1101', $role_resources_ids)) {
				if ($i == "3") {
					$button_edit_nip = '<button type="button" onclick="edit_nip(' . $id . ',\'' . $result_value[$i] . '\')" class="btn btn-sm btn-outline-success ml-2" ><i class="fa fa-file mr-1"></i> EDIT NIP</button>';
				}
			}

			$data[] = array(
				$this->get_nama_kolom_detail_saltab($result_index[$i]),
				$result_value[$i] . $button_edit_nip,
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

	public function get_nama_kolom_detail_bupot($nama_tabel)
	{
		$this->db->select('*');
		$this->db->from('mt_tabel_bupot');
		$this->db->where('nama_tabel', $nama_tabel);

		$records = $this->db->get()->row_array();

		if (empty($records)) {
			return "";
		} else {
			return $records['alias'];
		}
	}

	//update NIP employee
	public function update_nip($postData)
	{
		$this->db->set('nip', $postData['nip_baru']);
		$this->db->where('secid', $postData['id']);
		$this->db->update('xin_saltab');
	}

	//ambil data diri employee
	public function get_single_nip_saltab_release($postData)
	{
		$this->db->select('secid');
		$this->db->select('nip');
		$this->db->select('fullname');

		$this->db->from('xin_saltab',);
		$this->db->where('secid', $postData['id']);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//get table saltab untuk download excel
	public function get_saltab_temp_detail_excel($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_saltab_temp');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		$data = array();

		foreach ($records as $row) {
			$new_row = array_values($row);
			array_push($data, $new_row);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
	}

	//get table bupot untuk download excel
	public function get_bupot_detail_excel($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_bupot');
		$this->db->where('batch_bupot_id', $id);

		$records = $this->db->get()->result_array();

		$data = array();

		foreach ($records as $row) {
			$new_row = array_values($row);
			array_push($data, $new_row);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
	}

	//get table saltab release untuk download excel
	public function get_saltab_temp_detail_excel_release($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		$data = array();

		foreach ($records as $row) {
			$new_row = array_values($row);
			array_push($data, $new_row);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
	}

	//get table saltab release untuk download excel
	public function get_saltab_temp_detail_excel_release_nip_kosong($id, $parameter)
	{
		$data = array();

		$this->db->select($parameter);
		$this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		$records = $this->db->get()->result_array();

		$data = array();

		foreach ($records as $row) {
			if (!is_integer(intval($row['nip'])) || intval($row['nip']) == "0") {
				$new_row = array_values($row);
				// $new_row = array_keys($row);
				array_push($data, $new_row);
			}
		}

		return $data;
	}

	//get table saltab release untuk download excel BPJS
	public function get_saltab_temp_detail_excel_release_bpjs($id, $data_batch)
	{
		// $this->db->select($parameter);
		$this->db->select("*");
		// $this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		// $records = $this->db->get()->result_array();
		$records = $this->db->get('xin_saltab')->result();

		$data = array();

		foreach ($records as $record) {
			$tempat_lahir = "";
			$tanggal_lahir = "";
			$nama_ibu = "";
			$jenis_kelamin = "";
			$status_pernikahan = "";
			$alamat = "";
			$contract_start = "";
			$contract_end = "";

			if ((!empty($record->nip)) || ($record->nip != "") || ($record->nip != "0")) {
				$this->db->select('tempat_lahir,date_of_birth,ibu_kandung,gender,alamat_ktp,marital_status');
				$this->db->from('xin_employees');
				$this->db->where('employee_id', $record->nip);

				$query = $this->db->get()->row_array();

				if (!empty($query)) {
					$tempat_lahir = $query['tempat_lahir'];
					$tanggal_lahir = $query['date_of_birth'];
					$nama_ibu = $query['ibu_kandung'];
					$jenis_kelamin = $query['gender'];
					$alamat = $query['alamat_ktp'];

					if (empty($query['marital_status']) || ($query['marital_status'] == "")) {
						$status_pernikahan = "-";
					} else if ($query['marital_status'] == "1") {
						$status_pernikahan = "TK/0";
					} else if ($query['marital_status'] == "2") {
						$status_pernikahan = "TK/0";
					} else if ($query['marital_status'] == "3") {
						$status_pernikahan = "TK/1";
					} else if ($query['marital_status'] == "4") {
						$status_pernikahan = "TK/2";
					} else if ($query['marital_status'] == "5") {
						$status_pernikahan = "TK/3";
					} else if ($query['marital_status'] == "6") {
						$status_pernikahan = "K/0";
					} else if ($query['marital_status'] == "7") {
						$status_pernikahan = "K/1";
					} else if ($query['marital_status'] == "8") {
						$status_pernikahan = "K/2";
					} else if ($query['marital_status'] == "9") {
						$status_pernikahan = "K/3";
					} else if ($query['marital_status'] == "10") {
						$status_pernikahan = "HB/0";
					} else if ($query['marital_status'] == "11") {
						$status_pernikahan = "HB/1";
					} else if ($query['marital_status'] == "12") {
						$status_pernikahan = "HB/2";
					} else if ($query['marital_status'] == "13") {
						$status_pernikahan = "HB/3";
					} else {
						$status_pernikahan = "-";
					}
				}

				$this->db->select('max(to_date)');
				$this->db->select('from_date');
				$this->db->from('xin_employee_contract');
				$this->db->where('employee_id', $record->nip);
				$query2 = $this->db->get()->row_array();
				if (!empty($query)) {
					$contract_start = $query2['from_date'];
					$contract_end = $query2['max(to_date)'];
				}
				// $tes_query = $this->db->last_query();
				// $contract_start = $tes_query;
			}
			// $this->db->select('*');
			// $this->db->from('xin_employees');
			// $this->db->where('employee_id', $record->nip);

			// $query = $this->db->get()->row_array();

			// if (!empty($query)) {
			// }

			$bpjs_ketenagakerjaan = $record->bpjs_tk_deduction_jkk_jkm + $record->bpjs_tk_deduction_jht + $record->jaminan_pensiun_deduction + $record->bpjs_tk + $record->jaminan_pensiun;
			$bpjs_kesehatan = $record->bpjs_ks_deduction + $record->bpjs_ks;

			$data[] = array(
				// trim(strtoupper($detail_saltab[$i][$j]), " ")
				trim(strtoupper($record->status_emp), " "),
				$record->nip,
				$record->nik,
				trim(strtoupper($record->fullname), " "),
				trim(strtoupper($data_batch['project_name']), " "),
				trim(strtoupper($record->sub_project), " "),
				trim(strtoupper($record->jabatan), " "),
				trim(strtoupper($record->area), " "),
				trim(strtoupper($tempat_lahir), " "),
				$tanggal_lahir,
				trim(strtoupper($nama_ibu), " "),
				trim(strtoupper($jenis_kelamin), " "),
				trim(strtoupper($status_pernikahan), " "),
				trim(strtoupper($alamat), " "),
				$contract_start,
				$contract_end,
				round($record->gaji_umk),
				round($record->total_thp),
				round($bpjs_ketenagakerjaan),
				round($bpjs_kesehatan),
			);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
	}

	//get table saltab release untuk download excel Pajak
	public function get_saltab_temp_detail_excel_release_pajak($id, $data_batch)
	{
		// $this->db->select($parameter);
		$this->db->select("*");
		// $this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		// $records = $this->db->get()->result_array();
		$records = $this->db->get('xin_saltab')->result();

		$data = array();

		foreach ($records as $record) {
			$nip = $record->nip;
			$nik = $record->nik;
			$nama_lengkap = $record->fullname;
			$nik_validation = "0";
			$tanggal_join = "";
			$tempat_lahir = "";
			$tanggal_lahir = "";
			$nama_ibu = "";
			$jenis_kelamin = "";
			$status_pernikahan = "";
			$alamat = "";
			$contract_start = "";
			$contract_end = "";

			if ((!is_null($record->nip)) && ($record->nip != "") && ($record->nip != "0")) {
				$this->db->select('user_id,verification_id,first_name,date_of_joining,ktp_no,marital_status');
				$this->db->from('xin_employees');
				$this->db->where('employee_id', $record->nip);

				$query = $this->db->get()->row_array();

				if (!empty($query)) {
					$tanggal_join = $query['date_of_joining'];

					//verification id
					$actual_verification_id = "";
					if ((is_null($query['verification_id'])) || ($query['verification_id'] == "") || ($query['verification_id'] == "0")) {
						$actual_verification_id = "e_" . $query['user_id'];
					} else {
						$actual_verification_id = $query['verification_id'];
					}

					//cek status validation ke database
					$nik_validation = "0";
					$nik_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nik');
					if (is_null($nik_validation_query)) {
						$nik_validation = "0";
					} else {
						$nik_validation = $nik_validation_query['status'];
					}

					if (empty($query['marital_status']) || ($query['marital_status'] == "")) {
						$status_pernikahan = "-";
					} else if ($query['marital_status'] == "1") {
						$status_pernikahan = "TK/0";
					} else if ($query['marital_status'] == "2") {
						$status_pernikahan = "TK/0";
					} else if ($query['marital_status'] == "3") {
						$status_pernikahan = "TK/1";
					} else if ($query['marital_status'] == "4") {
						$status_pernikahan = "TK/2";
					} else if ($query['marital_status'] == "5") {
						$status_pernikahan = "TK/3";
					} else if ($query['marital_status'] == "6") {
						$status_pernikahan = "K/0";
					} else if ($query['marital_status'] == "7") {
						$status_pernikahan = "K/1";
					} else if ($query['marital_status'] == "8") {
						$status_pernikahan = "K/2";
					} else if ($query['marital_status'] == "9") {
						$status_pernikahan = "K/3";
					} else if ($query['marital_status'] == "10") {
						$status_pernikahan = "HB/0";
					} else if ($query['marital_status'] == "11") {
						$status_pernikahan = "HB/1";
					} else if ($query['marital_status'] == "12") {
						$status_pernikahan = "HB/2";
					} else if ($query['marital_status'] == "13") {
						$status_pernikahan = "HB/3";
					} else {
						$status_pernikahan = "-";
					}

					if ((!empty($query['ktp_no'])) || ($query['ktp_no'] != "") || ($query['ktp_no'] != "0")) {
						$nik = $query['ktp_no'];
					} else {
						$nik = $record->nik;
					}

					if ((!empty($query['first_name'])) || ($query['first_name'] != "") || ($query['first_name'] != "0")) {
						$nama_lengkap = $query['first_name'];
					} else {
						$nama_lengkap = $record->fullname;
					}
				}
				// $nama_lengkap = "NIP TIDAK KOSONG";
				// $tes_query = $this->db->last_query();
				// $contract_start = $tes_query;
			} else {
				if ((!is_null($record->nip)) && ($record->nik != "") && ($record->nik != "0")) {
					$this->db->select('user_id,employee_id,verification_id,first_name,date_of_joining,ktp_no,marital_status');
					$this->db->from('xin_employees');
					$this->db->where('ktp_no', $record->nik);
					$this->db->order_by('user_id', 'DESC');
					$this->db->limit(1);

					$query = $this->db->get()->row_array();

					// $tes_query = $this->db->last_query();

					if (!empty($query)) {
						$tanggal_join = $query['date_of_joining'];
						$nip = $query['employee_id'];

						//verification id
						$actual_verification_id = "";
						if ((is_null($query['verification_id'])) || ($query['verification_id'] == "") || ($query['verification_id'] == "0")) {
							$actual_verification_id = "e_" . $query['user_id'];
						} else {
							$actual_verification_id = $query['verification_id'];
						}

						//cek status validation ke database
						$nik_validation = "0";
						$nik_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nik');
						if (is_null($nik_validation_query)) {
							$nik_validation = "0";
						} else {
							$nik_validation = $nik_validation_query['status'];
						}

						if (empty($query['marital_status']) || ($query['marital_status'] == "")) {
							$status_pernikahan = "-";
						} else if ($query['marital_status'] == "1") {
							$status_pernikahan = "TK/0";
						} else if ($query['marital_status'] == "2") {
							$status_pernikahan = "TK/0";
						} else if ($query['marital_status'] == "3") {
							$status_pernikahan = "TK/1";
						} else if ($query['marital_status'] == "4") {
							$status_pernikahan = "TK/2";
						} else if ($query['marital_status'] == "5") {
							$status_pernikahan = "TK/3";
						} else if ($query['marital_status'] == "6") {
							$status_pernikahan = "K/0";
						} else if ($query['marital_status'] == "7") {
							$status_pernikahan = "K/1";
						} else if ($query['marital_status'] == "8") {
							$status_pernikahan = "K/2";
						} else if ($query['marital_status'] == "9") {
							$status_pernikahan = "K/3";
						} else if ($query['marital_status'] == "10") {
							$status_pernikahan = "HB/0";
						} else if ($query['marital_status'] == "11") {
							$status_pernikahan = "HB/1";
						} else if ($query['marital_status'] == "12") {
							$status_pernikahan = "HB/2";
						} else if ($query['marital_status'] == "13") {
							$status_pernikahan = "HB/3";
						} else {
							$status_pernikahan = "-";
						}

						if ((!empty($query['ktp_no'])) || ($query['ktp_no'] != "") || ($query['ktp_no'] != "0")) {
							$nik = $query['ktp_no'];
						} else {
							$nik = $record->nik;
						}

						if ((!empty($query['first_name'])) || ($query['first_name'] != "") || ($query['first_name'] != "0")) {
							$nama_lengkap = $query['first_name'];
						} else {
							$nama_lengkap = $record->fullname;
						}
					}
					// $tes_query = $this->db->last_query();
					// $contract_start = $tes_query;
					// $nama_lengkap = $tes_query;
				}
			}

			// $bpjs_ketenagakerjaan = $record->bpjs_tk_deduction_jkk_jkm + $record->bpjs_tk_deduction_jht + $record->jaminan_pensiun_deduction + $record->bpjs_tk + $record->jaminan_pensiun;
			// $bpjs_kesehatan = $record->bpjs_ks_deduction + $record->bpjs_ks;
			$total_bpjs_tk_pensiun = $record->bpjs_tk + $record->jaminan_pensiun;

			$data[] = array(
				// $record->nip,
				$nip,
				$tanggal_join,
				$nik,
				$nik_validation,
				trim(strtoupper($nama_lengkap), " "),
				trim(strtoupper($status_pernikahan), " "),
				trim(strtoupper($record->sub_project), " "),
				trim(strtoupper($record->jabatan), " "),
				trim(strtoupper($record->status_emp), " "),
				$record->gaji_pokok,
				$record->allow_pph,
				$record->allow_jabatan,
				$record->allow_keahlian,
				$record->allow_area,
				$record->allow_masakerja,
				$record->allow_konsumsi,
				$record->allow_transport,
				$record->allow_rent,
				$record->allow_comunication,
				$record->allow_parking,
				$record->allow_residence_cost,
				$record->allow_akomodasi,
				$record->allow_device,
				$record->allow_kasir,
				$record->allow_trans_meal,
				$record->allow_trans_rent,
				$record->allow_medicine,
				$record->allow_grooming,
				$record->allow_kehadiran,
				$record->allow_operation,
				$record->allow_others,
				$record->over_salary,
				$record->penyesuaian_umk,
				$record->insentive,
				$record->overtime,
				$record->overtime_holiday,
				$record->overtime_national_day,
				$record->overtime_rapel,
				$record->kompensasi,
				$record->bonus,
				$record->uuck,
				$record->thr,
				$record->adjustment_pph,
				$record->adjustment_bruto,
				$record->adjustment_dlk_bruto,
				$record->deduction_bruto,
				$record->deduction_so_bruto,
				$record->potongan_kpi_bruto,
				$record->total_pendapatan_tidak_teratur,
				$record->total_1,
				$record->bpjs_tk_deduction_jkk_jkm,
				$record->bpjs_ks_deduction,
				$record->bpjs_tk,
				$record->jaminan_pensiun,
				$total_bpjs_tk_pensiun,
				$record->pph_21,
				$record->pph_21_thr,
			);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
	}

	//get table saltab release untuk download excel BPJS
	public function get_saltab_temp_detail_excel_release_payroll($id, $data_batch)
	{
		// $this->db->select($parameter);
		$this->db->select("*");
		// $this->db->from('xin_saltab');
		$this->db->where('uploadid', $id);

		// $records = $this->db->get()->result_array();
		$records = $this->db->get('xin_saltab')->result();

		$data = array();

		foreach ($records as $record) {
			$sub_project = "";
			if ($data_batch['sub_project_name'] == "-ALL-") {
				$sub_project = $record->sub_project;
			} else {
				$sub_project = $data_batch['sub_project_name'];
			}

			$nomor_rekening = "";
			if (strtoupper($record->status_hold) == "HOLD") {
				$nomor_rekening = "";
			} else {
				$nomor_rekening = $record->norek;
			}

			$data[] = array(
				trim(strtoupper($record->status_emp), " "),
				$record->nip,
				$record->nik,
				trim(strtoupper($record->fullname), " "),
				trim(strtoupper($data_batch['project_name']), " "),
				trim(strtoupper($sub_project), " "),
				trim(strtoupper($record->area), " "),
				round($record->total_thp, 2),
				$nomor_rekening,
				trim(strtoupper($record->nama_bank), " "),
				trim(strtoupper($record->pemilik_rek), " "),
				trim(strtoupper($record->status_hold), " "),
				"",
			);
		}

		//$tabel_saltab = $this->Import_model->get_saltab_table();
		//$paremeter = implode(",", $tabel_saltab);
		// $jumlah_data = count($tabel_saltab);

		// foreach ($records as $record) {

		// 	$data[] = array(

		// 	);
		// }

		return $data;
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
		if ($this->db->update('xin_saltab_bulk_release', $data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table > basic_info
	public function update_download_bpjs($data, $id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('xin_saltab_bulk_release', $data)) {
			return true;
		} else {
			return false;
		}
	}


	// check client email
	public function CheckDownloadBPJS($id)
	{

		$sql = 'SELECT * FROM xin_saltab_bulk_release WHERE id = ? AND down_bpjs_by is not null';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
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

	function get_id_bupot_batch($data)
	{
		$this->db->order_by('created_on', 'desc');
		$query = $this->db->get_where('xin_bupot_batch', $data);
		$result = $query->row_array();

		if (empty($result)) {
			return "";
		} else {
			return $result['id_batch'];
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

	function get_bupot_batch($id)
	{

		$this->db->select('*');
		$this->db->from('xin_bupot_batch');
		$this->db->where('id_batch', $id);

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

		// if (!$this->db->insert_batch("xin_employees_saltab_temp", $data)) {
		// 	$tes_query = $this->db->last_query();
		// 	echo "<pre>";
		// 	print_r($tes_query);
		// 	echo "</pre>";
		// 	$error = $this->db->error(); // Has keys 'code' and 'message'
		// }
	}

	/*
    |-------------------------------------------------------------------
    | Insert detail BUPOT
    |-------------------------------------------------------------------
    |
    | @param $data  detail BUPOT Array Data
    |
    */
	function insert_bupot_detail($data)
	{
		// $this->db->insert_batch("xin_employees_saltab_temp", $data);
		// if (!$this->db->insert_batch("xin_employees_saltab_temp", $data)) {
		// 	$error = $this->db->error(); // Has keys 'code' and 'message'
		// }

		$this->db->insert_batch("xin_bupot", $data);

		// if (!$this->db->insert_batch("xin_employees_saltab_temp", $data)) {
		// 	$tes_query = $this->db->last_query();
		// 	echo "<pre>";
		// 	print_r($tes_query);
		// 	echo "</pre>";
		// 	$error = $this->db->error(); // Has keys 'code' and 'message'
		// }
	}

	/*
    |-------------------------------------------------------------------
    | Insert detail BPJS
    |-------------------------------------------------------------------
    |
    | @param $data  detail BUPOT Array Data
    |
    */
	function insert_bpjs_detail($data)
	{
		foreach ($data as $record) {
			$cekdata = $this->cek_bpjs($record['nip']);
			$nip = $record['nip'];

			if ($cekdata > 0) {
				$array_data  = [];

				//susun data untuk update
				if (!is_null($record['nik']) && ($record['nik'] != "") && ($record['nik'] != "0")) {
					$array_data += ['nik' => $record['nik']];
				}
				if (!is_null($record['nama_lengkap']) && ($record['nama_lengkap'] != "") && ($record['nama_lengkap'] != "0")) {
					$array_data += ['nama_lengkap' => $record['nama_lengkap']];
				}
				if (!is_null($record['project']) && ($record['project'] != "") && ($record['project'] != "0")) {
					$array_data += ['project' => $record['project']];
				}
				if (!is_null($record['sub_project']) && ($record['sub_project'] != "") && ($record['sub_project'] != "0")) {
					$array_data += ['sub_project' => $record['sub_project']];
				}
				if (!is_null($record['bpjs_kesehatan']) && ($record['bpjs_kesehatan'] != "") && ($record['bpjs_kesehatan'] != "0")) {
					$array_data += ['bpjs_kesehatan' => $record['bpjs_kesehatan']];
				}
				if (!is_null($record['bpjs_ketenagakerjaan']) && ($record['bpjs_ketenagakerjaan'] != "") && ($record['bpjs_ketenagakerjaan'] != "0")) {
					$array_data += ['bpjs_ketenagakerjaan' => $record['bpjs_ketenagakerjaan']];
				}
				$array_data += ['modify_by' => $record['upload_by']];
				$array_data += ['modify_by_id' => $record['upload_by_id']];
				$array_data += ['modify_on' => $record['upload_on']];

				$this->db->where('nip', $nip);
				$this->db->update('xin_bpjs', $array_data);
			} else {
				$this->db->replace("xin_bpjs", $record);
			}
		}

		// $this->db->insert_batch("xin_bupot", $data);

		// if (!$this->db->insert_batch("xin_employees_saltab_temp", $data)) {
		// 	$tes_query = $this->db->last_query();
		// 	echo "<pre>";
		// 	print_r($tes_query);
		// 	echo "</pre>";
		// 	$error = $this->db->error(); // Has keys 'code' and 'message'
		// }
	}

	function cek_bpjs($nip)
	{
		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('nip', $nip);
		$records = $this->db->get('xin_bpjs')->result();
		$totalRecords = $records[0]->allcount;

		return $totalRecords;
	}

	function get_bpjs_ks($nip)
	{
		## Total number of records without filtering
		$this->db->select('id');
		$this->db->select('bpjs_kesehatan');
		$this->db->where('nip', $nip);
		$this->db->order_by('id', 'DESC');
		$records = $this->db->get('xin_bpjs')->row_array();

		if (empty($records)) {
			return "";
		} else {
			return $records['bpjs_kesehatan'];
		}
	}

	function get_bpjs_tk($nip)
	{
		## Total number of records without filtering
		$this->db->select('id');
		$this->db->select('bpjs_ketenagakerjaan');
		$this->db->where('nip', $nip);
		$this->db->order_by('id', 'DESC');
		$records = $this->db->get('xin_bpjs')->row_array();

		if (empty($records)) {
			return "";
		} else {
			return $records['bpjs_ketenagakerjaan'];
		}
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

	/*
    |-------------------------------------------------------------------
    | Insert bach BUPOT Data
    |-------------------------------------------------------------------
    |
    | @param $data  detail saltab Array Data
    |
    */
	function insert_bupot_batch($data)
	{
		$this->db->replace("xin_bupot_batch", $data);
	}

	function delete_batch_saltab($id = null)
	{
		$this->db->delete('xin_saltab_bulk', array('id' => $id));
		$this->db->delete('xin_saltab_temp', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function delete_batch_bupot($id = null)
	{
		$this->db->delete('xin_bupot_batch', array('id_batch' => $id));
		$this->db->delete('xin_bupot', array('batch_bupot_id' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function delete_bpjs($id = null)
	{
		$this->db->delete('xin_bpjs', array('id' => $id));
	}

	function delete_batch_saltab_release($id = null)
	{
		$this->db->delete('xin_saltab_bulk_release', array('id' => $id));
		$this->db->delete('xin_saltab', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function release_eslip_batch_saltab_release($postdata = null)
	{
		// $session = $this->session->userdata('username');
		$tanggal_penggajian = $postdata['tanggal_penggajian'];
		if ((empty($postdata['tanggal_terbit'])) || ($postdata['tanggal_terbit'] == "")) {
			$tanggal_terbit = $tanggal_penggajian;
		} else {
			$tanggal_terbit = $postdata['tanggal_terbit'];
		}
		$eslip_release_by = $postdata['release_by'];
		$eslip_release_on = date("Y-m-d H:i:s");

		$this->db->set('eslip_release', $tanggal_terbit);
		$this->db->set('eslip_release_by', $eslip_release_by);
		$this->db->set('eslip_release_on', $eslip_release_on);
		$this->db->where('id', $postdata['id']);
		$this->db->update('xin_saltab_bulk_release');
	}

	function release_batch_bupot($postdata = null)
	{
		// $session = $this->session->userdata('username');
		$release_by_id = $postdata['release_by_id'];
		$release_by = $this->Import_model->get_nama_karyawan($postdata['release_by_id']);
		$release_on = date("Y-m-d H:i:s");

		$this->db->set('status_release', "1");
		$this->db->set('release_by_id', $release_by_id);
		$this->db->set('release_by', $release_by);
		$this->db->set('release_on', $release_on);
		$this->db->where('id_batch', $postdata['id_batch']);
		$this->db->update('xin_bupot_batch');
	}

	function accept_request($postData = null)
	{
		$this->db->set('status', "0");
		$this->db->set('accept_by_id', $postData['request_by']);
		$this->db->set('accept_by_name', $postData['request_name']);
		$this->db->set('accept_on', $postData['request_on']);
		$this->db->where('id', $postData['id']);
		$this->db->update('log_request_open_saltab');

		// $this->db->delete('xin_saltab_bulk_release', array('id' => $id));
		// $this->db->delete('xin_saltab', array('uploadid' => $id));
		// $this->db->replace("xin_employees_saltab_bulk", $data);
	}

	function reject_request($postData = null)
	{
		$this->db->set('status', "2");
		$this->db->set('accept_by_id', $postData['id']);
		$this->db->set('accept_by_name', $postData['request_name']);
		$this->db->set('accept_on', $postData['request_on']);
		$this->db->where('id', $postData['id']);
		$this->db->update('log_request_open_saltab');

		// $this->db->delete('xin_saltab_bulk_release', array('id' => $id));
		// $this->db->delete('xin_saltab', array('uploadid' => $id));
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

		$waktu_stamp = date("Y-m-d H:i:s");

		## Update data release
		$data = array(
			'release_on' => $waktu_stamp,
			'release_by' => $this->get_nama_karyawan($session['employee_id']),
			'release_by_id' => $session['employee_id'],
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

	//delete detail bupot
	function delete_detail_bupot($id = null)
	{
		//kalau delete data, update jumlah mpp pada batch
		## Get Batch Id
		$this->db->select('*');
		$this->db->from('xin_bupot');
		$this->db->where('id', $id);
		$query = $this->db->get()->row_array();
		$id_batch = $query['batch_bupot_id'];

		$this->db->delete('xin_bupot', array('id' => $id));

		## Total number of records 
		$this->db->select('count(*) as allcount');
		$this->db->where("batch_bupot_id", $id_batch);
		$records = $this->db->get('xin_bupot')->result();
		$totalRecords = $records[0]->allcount;

		## Update mpp
		$data = array(
			'jumlah_data' => $totalRecords,
		);

		$this->db->where('id_batch', $id_batch);
		$this->db->update('xin_bupot_batch', $data);
	}

	//ambil data bupot berdasarkan NIK
	public function get_all_bupot_by_nik($nik)
	{
		// get data bupot
		$this->db->select('*');

		$this->db->from('xin_bupot');
		$this->db->where('nik', $nik);

		$query = $this->db->get()->result_array();

		$data = array();

		foreach ($query as $record) {
			$tanggal_release = $this->get_tanggal_release_bupot($record['batch_bupot_id']);

			if (is_null($tanggal_release) || $tanggal_release == "" || $tanggal_release == "0") {
			} else {
				$data[] = array(
					"batch_bupot_id" => $record['batch_bupot_id'],
					"no_bukti_potong" => $record['no_bukti_potong'],
					"tanggal_bukti_potong" => $record['tanggal_bukti_potong'],
					"npwp_pemotong" => $record['npwp_pemotong'],
					"nama_pemotong" => $record['nama_pemotong'],
					"perekam" => $record['perekam'],
					"nik" => $record['nik'],
					"nama_penerima_penghasilan" => $record['nama_penerima_penghasilan'],
					"penghasilan_bruto" => $record['penghasilan_bruto'],
					"penghasilan_bruto_masa_terakhir" => $record['penghasilan_bruto_masa_terakhir'],
					"pph_dipotong" => $record['pph_dipotong'],
					"kode_objek_pajak" => $record['kode_objek_pajak'],
					"pasal" => $record['pasal'],
					"masa_pajak" => $record['masa_pajak'],
					"tahun_pajak" => $record['tahun_pajak'],
					"status" => $record['status'],
					"rev_no" => $record['rev_no'],
					"posting" => $record['posting'],
					"id_sistem" => $record['id_sistem'],
					"file_bupot" => $record['file_bupot'],
					"tanggal_release" => $tanggal_release,

					"periode_bupot" => $this->get_periode_bupot($record['batch_bupot_id']),
					"release_on" => $this->Xin_model->tgl_indo($tanggal_release),
					"button_lihat" => '<a href="' . $record['file_bupot'] . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-md btn-outline-success">OPEN BUPOT</button></a>',
				);
			}
		}

		array_multisort(array_column($data, "periode_bupot"), SORT_DESC, $data);

		return $data;
	}

	//get periode bupot
	function get_periode_bupot($batch_bupot_id = null)
	{
		//kalau delete data, update jumlah mpp pada batch
		## Get Batch Id
		$this->db->select('periode_bupot');
		$this->db->from('xin_bupot_batch');
		$this->db->where('id_batch', $batch_bupot_id);
		$query = $this->db->get()->row_array();

		return $query['periode_bupot'];
	}

	//get tanggal release bupot
	function get_tanggal_release_bupot($batch_bupot_id = null)
	{
		//kalau delete data, update jumlah mpp pada batch
		## Get Batch Id
		$this->db->select('release_on');
		$this->db->from('xin_bupot_batch');
		$this->db->where('id_batch', $batch_bupot_id);
		$query = $this->db->get()->row_array();

		return $query['release_on'];
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
			$this->db->where('employee_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['designation_name'];
			if ($query['first_name'] == null) {
				return "";
			} else {
				return $query['first_name'];
			}
		}
	}

	//ambil nama employee
	function get_ktp_karyawan($id)
	{
		if ($id == null) {
			return "";
		} else if ($id == 0) {
			return "";
		} else {
			$this->db->select('*');
			$this->db->from('xin_employees');
			$this->db->where('employee_id', $id);

			$query = $this->db->get()->row_array();

			//return $query['designation_name'];
			if (empty($query)) {
				return "0";
			} else {
				if (($query['ktp_no'] == null) || ($query['ktp_no'] == "")) {
					return "0";
				} else {
					return $query['ktp_no'];
				}
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
				"periode_salary" => $this->Xin_model->tgl_indo($record->periode_salary),
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
	* data list batch bupot
	* 
	* @author Fadla Qamara
	*/
	function get_list_batch_bupot($postData = null)
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
		//$nip = $postData['nip'];
		//$emp_id = $postData['emp_id'];
		//$contract_id = $postData['contract_id'];
		$session_id = $postData['session_id'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (project_name like '%" . $searchValue .  "%' or sub_project_name like '%" . $searchValue . "%' or periode_bupot like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_bupot_batch')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_bupot_batch')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_bupot_batch')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			//cek apakah sudah release eslip
			$release_bupot = "<span style='color:#FF0000;'>Belum Release BUPOT</span>";
			if (empty($record->status_release) || ($record->status_release == "") || ($record->status_release == "0")) {
				if (in_array('1302', $role_resources_ids)) {
					$release_bupot = $release_bupot . '</br><button type="button" onclick="releaseBupot(' . $record->id_batch . ')" class="btn btn-sm btn-outline-primary" >Release BUPOT</button>';
				}
			} else {
				$release_bupot = "Sudah Release BUPOT.</br>Tanggal release: " . $this->Xin_model->tgl_indo($record->release_on);
				$release_bupot = $release_bupot . '</br><button type="button" onclick="detailReleaseBupot(' . $record->id_batch . ')" class="btn btn-sm btn-outline-success" >Detail Info</button>';
			}

			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchBupot(' . $record->id_batch . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$download = '<br><button type="button" onclick="downloadBatchBupot(' . $record->id_batch . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
			$delete = "";
			if (in_array('1303', $role_resources_ids)) {
				$delete = '<br><button type="button" onclick="deleteBatchBupot(' . $record->id_batch . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';
			}


			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $download . " " . $delete,
				"periode_bupot" => $record->periode_bupot,
				// "periode" => $this->Xin_model->tgl_indo($record->periode_cutoff_from) . " s/d " . $this->Xin_model->tgl_indo($record->periode_cutoff_to),
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"jumlah_data" => $record->jumlah_data,
				"release_bupot" => $release_bupot,
				"created_by" => $record->created_by,
				"created_on" => $record->created_on,
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
	* data list bpjs
	* 
	* @author Fadla Qamara
	*/
	function get_list_bpjs($postData = null)
	{
		// $role_resources_ids = $this->Xin_model->user_role_resource();

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
			$searchQuery = " (nip like '%" . $searchValue .  "%' or nik like '%" . $searchValue . "%' or nama_lengkap like '%" . $searchValue . "%' or project like '%" . $searchValue . "%' or sub_project like '%" . $searchValue . "%' or bpjs_kesehatan like '%" . $searchValue . "%' or bpjs_ketenagakerjaan like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		// $kondisiDefaultQuery = "project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")";
		// $kondisiDefaultQuery = "1=1";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		// $this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_bpjs')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		// $this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_bpjs')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		// $this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_bpjs')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBPJS(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$edit = '<button type="button" onclick="editBPJS(' . $record->id . ')" class="btn btn-xs btn-outline-success" >EDIT</button>';
			$delete = '<button type="button" onclick="deleteBPJS(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $delete,
				"nip" => $record->nip,
				"nik" => $record->nik,
				"nama_lengkap" => $record->nama_lengkap,
				"project" => $record->project,
				"sub_project" => $record->sub_project,
				"bpjs_kesehatan" => $record->bpjs_kesehatan,
				"bpjs_ketenagakerjaan" => $record->bpjs_ketenagakerjaan,
				"upload_by" => $record->upload_by,
				"upload_on" => $record->upload_on,
				"modify_by" => $record->modify_by,
				"modify_on" => $record->modify_on,
				// "periode" => $this->Xin_model->tgl_indo($record->periode_cutoff_from) . " s/d " . $this->Xin_model->tgl_indo($record->periode_cutoff_to),
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
				"release_by" => $record->release_by,
				"release_on" => $record->release_on,
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
		$this->db->join('(select max(id) as maxid from xin_saltab_bulk_release group by project_id,sub_project_id,periode_cutoff_from,periode_cutoff_to,periode_salary) b', 'a.id = b.maxid', 'inner');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		$records = $this->db->get('xin_saltab_bulk_release a')->result();
		$totalRecords = $records[0]->allcount;

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

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
		$this->db->join('(select max(id) as maxid from xin_saltab_bulk_release group by project_id,sub_project_id,periode_cutoff_from,periode_cutoff_to,periode_salary) b', 'a.id = b.maxid', 'inner');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		$records = $this->db->get('xin_saltab_bulk_release a')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('a.*');
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
		$this->db->join('(select max(id) as maxid from xin_saltab_bulk_release group by project_id,periode_cutoff_from,periode_cutoff_to,sub_project_id,periode_salary) b', 'a.id = b.maxid', 'inner');
		// $this->db->group_by(array("periode_salary", "project_id","sub_project_id", "periode_cutoff_to","periode_cutoff_from"));
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_saltab_bulk_release a')->result();

		$data = array();

		foreach ($records as $record) {
			$nama_download_bpjs = "";
			if (empty($record->down_bpjs_by) || ($record->down_bpjs_by == "")) {
				$nama_download_bpjs = "";
			} else {
				$nama_download_bpjs = "<BR> <span style='color:#3F72D5;'>" . $this->Employees_model->get_nama_karyawan_by_nip($record->down_bpjs_by) . ' [' . $this->Xin_model->tgl_indo($record->down_bpjs_on) . ']' . "</span>";
			}

			$periode_salary = "";
			if (empty($record->periode_salary) || ($record->periode_salary == "")) {
				$periode_salary = "--";
			} else {
				$periode_salary = $this->Xin_model->tgl_indo($record->periode_salary) . $nama_download_bpjs;
			}

			// if (empty($record->eslip_release) || ($record->eslip_release == "")) {
			// 	$eslip_release = "";
			// } else {
			// 	$eslip_release = "<p>&#x2705;</p>";
			// }


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

			//cek apakah sudah release eslip
			$release_eslip = "<span style='color:#FF0000;'>Belum Release Eslip</span>";
			if (empty($record->eslip_release) || ($record->eslip_release == "")) {
				if (in_array('1100', $role_resources_ids)) {
					$release_eslip = $release_eslip . '<button type="button" onclick="releaseEslip(' . $record->id . ')" class="btn btn-xs btn-outline-primary ml-1 mt-1" >Release Eslip</button>';
				}
			} else {
				$release_eslip = "Tanggal terbit: " . $this->Xin_model->tgl_indo($record->eslip_release);
				$release_eslip = $release_eslip . '<button type="button" onclick="detailReleaseEslip(' . $record->id . ')" class="btn btn-xs btn-outline-success ml-1 mt-1" >Detail Info</button>';
			}

			//hitung dokumen ke-
			$dokumen_ke = $this->get_jumlah_dokumen_salatab_sama($record->project_id, $record->sub_project_id, $record->periode_salary);
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			$view = '<button id="tesbutton" type="button" onclick="lihatBatchSaltabRelease(' . $record->id . ')" class="btn btn-block btn-sm btn-outline-twitter" >VIEW</button>';
			$download_nip_kosong = '<button type="button" onclick="downloadBatchSaltabReleaseNIPKosong(' . $record->id . ')" class=" btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> NIP Kosong</button>';
			$download_raw = '<button type="button" onclick="downloadBatchSaltabRelease(' . $record->id . ')" class=" btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Raw Data</button>';
			$download_BPJS = '<button type="button" onclick="downloadBatchSaltabReleaseBPJS(' . $record->id . ')" class="btn btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Data BPJS</button>';
			$download_Payroll = '<button type="button" onclick="downloadBatchSaltabReleasePayroll(' . $record->id . ')" class="btn btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Data Payroll</button>';
			$download_Pajak = '<button type="button" onclick="downloadBatchSaltabReleasePajak(' . $record->id . ')" class="btn btn-block btn-sm btn-outline-success" ><i class="fa fa-download"></i> Data Pajak</button>';
			$delete = '<button type="button" onclick="deleteBatchSaltabRelease(' . $record->id . ')" class="btn btn-block btn-sm btn-outline-danger" >DELETE</button>';

			$button_download = '<div class="btn-group mt-2">
      			<button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-toggle="dropdown">
      				DOWNLOAD <span class="caret"></span></button>
      				<ul class="dropdown-menu" role="menu" style="width: 100px;background-color:#faf7f0;">
					<span style="color:#3F72D5;">DOWNLOAD OPTION:</span>
        				<li class="mb-1">' . $download_nip_kosong . '</li>
        				<li class="mb-1">' . $download_raw . '</li>
						<li class="mb-1">' . $download_BPJS . '</li>
						<li class="mb-1">' . $download_Payroll . '</li>
						<li class="mb-1">' . $download_Pajak . '</li>
      				</ul>
    		</div>';


			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . $button_download,
				// "aksi" => $view . " " . $download_nip_kosong . " " . $download_raw . " " . $download_BPJS . " " . $download_Payroll,
				// "periode_salary" => $periode_salary . "<br>" . $tes_query,
				"periode_salary" => $periode_salary,
				"periode" => $text_periode . "<span style='color:#3F72D5;'><br>Dokumen ke " . $dokumen_ke . "</span>",
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"total_mpp" => $record->total_mpp,
				"release_by" => $record->release_by,
				"release_on" => $record->release_on,
				"release_eslip" => $release_eslip,
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

	//hitung jumlah batch saltab yang sama
	function get_jumlah_dokumen_salatab_sama($project_id, $sub_project_id, $periode_salary)
	{
		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('project_id', $project_id);
		$this->db->where('sub_project_id', $sub_project_id);
		$this->db->where('periode_salary', $periode_salary);
		$records = $this->db->get('xin_saltab_bulk_release')->result();
		$totalRecords = $records[0]->allcount;

		return $totalRecords;
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
			$esaltab = '<a href="' . site_url() . 'admin/importexceleslip/eslip_temp2/' . $record->nip . '/' . $record->secid . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">E-SLIP</button></a>';
			$delete = '<button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $esaltab . " "  . $delete,
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
	* data list detail bupot
	* 
	* @author Fadla Qamara
	*/
	function get_list_detail_bupot($postData = null)
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

		//variabel id batch
		$id_batch = $postData['id_batch'];
		$data_batch = $this->get_bupot_batch($id_batch);

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (nik like '%" . $searchValue .  "%' or no_bukti_potong like '%" . $searchValue . "%' or nama_penerima_penghasilan like '%" . $searchValue . "%') ";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "(
			batch_bupot_id = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		$records = $this->db->get('xin_bupot')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get('xin_bupot')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_bupot')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {

			$view = '<button id="tesbutton" type="button" onclick="lihatDetailBupot(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$esaltab = '<a href="' . $record->file_bupot . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">OPEN BUPOT</button></a>';
			$delete = "";
			if (in_array('1303', $role_resources_ids)) {
				$delete = '<button type="button" onclick="deleteDetailBupot(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';
			}

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $esaltab . " "  . $delete,
				"nik" => $record->nik,
				"no_bukti_potong" => $record->no_bukti_potong,
				"nama_penerima_penghasilan" => $record->nama_penerima_penghasilan,
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
			$esaltab = '<a href="' . site_url() . 'admin/importexceleslip/eslip_final/' . $record->nip . '/' . $record->secid . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">E-SLIP</button></a>';
			$delete = '<button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $esaltab . " " . $delete,
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
			$esaltab = '<a href="' . site_url() . 'admin/importexceleslip/eslip_final/' . $record->nip . '/' . $record->secid . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">E-SLIP</button></a>';
			$delete = '<br><button type="button" onclick="deleteDetailSaltab(' . $record->secid . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';


			$getContact = $this->Employees_model->getKontak($record->nip);
			if (!is_null($getContact)) {
				$contact_no = $getContact[0]->contact_no;
			} else {
				$contact_no = '#';
			}


			$copypaste = '*Payroll Notification -> Elektronik SLIP.*%0a%0a

				Yang Terhormat Bapak/Ibu Karyawan PT. Siprama Cakrawala, telah terbit dokumen E-SLIP Periode 1 Oktober 2024 - 31 Oktober 2024, segera Login C.I.S untuk melihat lebih lengkap.%0a%0a

				Lakukan Pembaharuan PIN anda secara berkala, dengan cara Login C.I.S kemudian akses Menu My Profile dan Ubah PIN.%0a%0a

				Link C.I.S : https://apps-cakrawala.com/admin%0a

				*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a
				
				Terima kasih.';

			$whatsapp = '<a href="https://wa.me/62' . $contact_no . '?text=' . $copypaste . '" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-success">Send WA</button> </a>';


			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view . " " . $esaltab . " " . $whatsapp,
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

	//request_open_import
	public function insert_request_open_import($postData)
	{
		$this->db->insert('log_request_open_saltab', $postData);
	}

	//request_open_import
	public function cek_request_open_import($postData)
	{
		$this->db->select('*');
		$this->db->from('log_request_open_saltab',);
		$this->db->where($postData);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//request_open_import
	public function update_request_open_import($postData)
	{
		$this->db->select('*');
		$this->db->from('log_request_open_saltab',);
		$this->db->where($postData);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		if (empty($query)) {
			//do nothing
		} else {
			$data = array(
				'status' => "3",
			);

			$this->db->where('id', $query['id']);
			$this->db->update('log_request_open_saltab', $data);
		}
	}

	//request_open_import_manual
	public function cek_request_open_import_manual($project_id)
	{
		$this->db->select('*');
		$this->db->from('xin_saltab_lock_import',);
		$this->db->where("project_id = " . $project_id);

		$query = $this->db->get()->row_array();

		return $query;
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

	// get single sub project by id
	public function read_single_subproject($id)
	{

		$sql = "SELECT * FROM xin_projects_sub WHERE secid = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	/*
	* persiapan data untuk datatable pagination
	* data list request open import saltab
	* 
	* @author Fadla Qamara
	*/
	function get_list_request_open_import_saltab($postData = null)
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
		$status = $postData['status'];
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
				tanggal_gajian >= '" . $search_periode_from . "'
			)";
		} else {
			$filterRangeFrom = "";
		}

		$filterRangeTo = "";
		if (($search_periode_to != null) && ($search_periode_to != "") && ($search_periode_to != '0')) {
			$filterRangeTo = "(
				tanggal_gajian <= '" . $search_periode_to . "'
			)";
		} else {
			$filterRangeTo = "";
		}

		## Kondisi Default AND status = "
		$kondisi_status = "";
		if ($status == "0") {
			$kondisi_status = "";
		} else if ($status == "1") {
			$kondisi_status = "and status = 1";
		} else if ($status == "2") {
			$kondisi_status = "and (status = 0 or status = 3)";
		} else if ($status == "3") {
			$kondisi_status = "and status = 2";
		}

		$kondisiDefaultQuery = "project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ") " . $kondisi_status;
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
		$records = $this->db->get('log_request_open_saltab')->result();
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
		$records = $this->db->get('log_request_open_saltab')->result();
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
		$records = $this->db->get('log_request_open_saltab')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$periode_salary = "";
			if (empty($record->tanggal_gajian) || ($record->tanggal_gajian == "")) {
				$periode_salary = "--";
			} else {
				$periode_salary = $this->Xin_model->tgl_indo($record->tanggal_gajian);
			}

			$text_periode_from = "";
			$text_periode_to = "";
			$text_periode = "";
			if (empty($record->periode_saltab_from) || ($record->periode_saltab_from == "")) {
				$text_periode_from = "";
			} else {
				$text_periode_from = $this->Xin_model->tgl_indo($record->periode_saltab_from);
			}
			if (empty($record->periode_saltab_to) || ($record->periode_saltab_to == "")) {
				$text_periode_to = "";
			} else {
				$text_periode_to = $this->Xin_model->tgl_indo($record->periode_saltab_to);
			}
			if (($text_periode_from == "") && ($text_periode_to == "")) {
				$text_periode = "";
			} else {
				$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			}

			$text_status = "";
			$accept_button = "";
			$reject_button = "";
			if ($record->status == "1") {
				$text_status = "<font color='#0000FF'>REQUESTED</font>";
				$accept_button = '<button id="tesbutton" type="button" onclick="acceptRequest(' . $record->id . ')" class="btn btn-xs btn-outline-success" >ACCEPT</button>';
				// $editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
				$reject_button = '<br><button type="button" onclick="rejectRequest(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >REJECT</button>';
			} else if ($record->status == "2") {
				$text_status = "<font color='#FF0000'>REJECTED</font>";
			} else if ($record->status == "3") {
				$text_status = "<font color='#006600'>ACCEPTED and UPLOADED</font>";
			} else if ($record->status == "0") {
				$text_status = "<font color='#006600'>ACCEPTED and NOT UPLOADED</font>";
			} else {
				$text_status = "-";
			}
			// $addendum_id = $this->secure->encrypt_url($record->id);
			// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $accept_button . " " . $reject_button,
				// "periode_salary" => $periode_salary . "<br>" . $tes_query,
				"tanggal_gajian" => $periode_salary,
				"periode" => $text_periode,
				"project_name" => $record->project_name,
				"sub_project_name" => $record->sub_project_name,
				"note" => $record->note,
				"request_by_name" => $record->request_by_name,
				"request_on" => $record->request_on,
				"status" => $text_status,
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

	//ambil data eslip release
	public function get_data_eslip_release($postData)
	{
		$this->db->select('*');

		$this->db->from('xin_saltab_bulk_release',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}

	//ambil data bupot
	public function get_data_batch_bupot($postData)
	{
		$this->db->select('*');

		$this->db->from('xin_bupot_batch',);
		$this->db->where($postData);
		$this->db->limit(1);
		// $this->db->where($searchQuery);

		$query = $this->db->get()->row_array();

		return $query;
	}
}

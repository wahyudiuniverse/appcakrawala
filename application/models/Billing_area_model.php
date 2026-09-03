<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_area_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//get data billing area dari saltab finalize
	public function get_all_billing_area()
	{
		$this->db->select('secid');
		$this->db->select('uploadid');
		$this->db->select('billing_area');
		$this->db->group_by('billing_area');
		$this->db->from('xin_saltab');

		$query = $this->db->get()->result_array();

		return $query;
	}

	/*
	* persiapan data untuk datatable pagination
	* data list billing area
	* 
	* @author Fadla Qamara
	*/
	function list_billing_area($postData = null)
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
		$area_filter = $postData['area_filter'];
		$tahun_filter = $postData['tahun_filter'];
		$bulan_filter = $postData['bulan_filter'];
		$session_id = $postData['session_id'];

		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			if (strlen($searchValue) >= 3) {
				$searchQuery = " (xin_employees.employee_id like '%" . $searchValue .  "%' 
					or xin_employees.first_name like '%" . $searchValue . "%' 
					or xin_designations.designation_name like '%" . $searchValue . "%'
					or xin_employees.penempatan like '%" . $searchValue . "%'  
					or xin_employees.ktp_no like '%" . $searchValue . "%') ";
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
		$this->db->select('xin_employees.verification_id');
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
		//$this->db->select('b.from_date');
		//$this->db->select('b.to_date');
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
		//$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_employees')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			//verification id
			$actual_verification_id = "";
			if ((is_null($record->verification_id)) || ($record->verification_id == "") || ($record->verification_id == "0")) {
				$actual_verification_id = "e_" . $record->user_id;
			} else {
				$actual_verification_id = $record->verification_id;
			}

			//cek status validation ke database
			$nik_validation = "0";
			$nik_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nik');
			if (is_null($nik_validation_query)) {
				$nik_validation = "0";
			} else {
				$nik_validation = $nik_validation_query['status'];
			}

			$validate_nik = "";
			if ($nik_validation == "1") {
				$validate_nik = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
			} else {
				$validate_nik = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
			}
			$button_open_ktp = '<button onclick="open_ktp(' . $record->employee_id . ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KTP</button>';

			// $text_periode_from = "";
			// $text_periode_to = "";
			// $text_periode = "";
			// if (empty($record->from_date) || ($record->from_date == "")) {
			// 	$text_periode_from = "";
			// } else {
			// 	$text_periode_from = $this->Xin_model->tgl_indo($record->from_date);
			// }
			// if (empty($record->to_date) || ($record->to_date == "")) {
			// 	$text_periode_to = "";
			// } else {
			// 	$text_periode_to = $this->Xin_model->tgl_indo($record->to_date);
			// }
			// if (($text_periode_from == "") && ($text_periode_to == "")) {
			// 	$text_periode = "";
			// } else {
			// 	$text_periode = $text_periode_from . " s/d " . $text_periode_to;
			// }

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
				"ktp_no" => $record->ktp_no . $validate_nik . $button_open_ktp,
				"first_name" => strtoupper($record->first_name),
				"project" => strtoupper($this->get_nama_project($record->project_id)),
				"sub_project" => strtoupper($this->get_nama_sub_project($record->sub_project_id)),
				"designation_name" => strtoupper($record->designation_name),
				"penempatan" => strtoupper($record->penempatan),
				"periode" => $this->get_periode_pkwt($record->employee_id),
				"pincode" => $text_pin,
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

	function tgl_indo($tanggal)
	{
		if (($tanggal == "") || ($tanggal == "0") || empty($tanggal)) {
			return "";
		} else {
			// $input = '06/10/2011 19:00:02';
			$timetodate = strtotime($tanggal);
			$date = date('Y-m-d', $timetodate);


			$bulan = array(
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$pecahkan = explode('-', $date);

			// variabel pecahkan 0 = tanggal
			// variabel pecahkan 1 = bulan
			// variabel pecahkan 2 = tahun

			return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
		}
	}
}

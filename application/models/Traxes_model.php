<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Traxes_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	function get_list_tx_cio($postData = null)
	{

		$dbtraxes = $this->load->database('dbtraxes', TRUE);

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
		$project 		= $postData['project'];
		$sub_project 	= $postData['sub_project'];
		$sdate 			= $postData['sdate'];
		$edate 			= $postData['edate'];
		$session_id 	= $postData['session_id'];

		if ($project != "0") {
			## Search 
			$searchQuery = "";
			if ($searchValue != '') {
				if (strlen($searchValue) >= 3) {
					$searchQuery = " (tx_cio.employee_id like '%" . $searchValue .  "%' or tx_cio.employee_name like '%" . $searchValue . "%' or tx_cio.jabatan_name like '%" . $searchValue . "%' or tx_cio.penempatan like '%" . $searchValue . "%') ";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "tx_cio.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				// $filterSubProject = "tx_cio.sub_project_id = '" . $sub_project . "'";
				$filterSubProject = "tx_cio.sub_project_name = '".$sub_project."'";
			} else {
				$filterSubProject = "";
			}

			$filterPeriode = "";
			if (($sdate != null) && ($edate != "")) {
				// $filterPeriode = "tx_cio.date_cio = '" . $status . "'";
				$filterPeriode = "DATE_FORMAT(tx_cio.date_cio, '%Y-%m-%d') BETWEEN '".$sdate."' AND '".$edate."'";

				// $filterPeriode = "DATE_FORMAT(tx_cio.date_cio, '%Y-%m-%d') BETWEEN '2025-05-01' AND '2025-05-31'";

			} else {
				$filterPeriode = "";
			}

			## Kondisi Default 
			// $kondisiDefaultQuery = "(project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")) AND `user_id` != '1'";
			// $kondisiDefaultQuery = "(
			// 	karyawan_id = " . $emp_id . "
			// AND	pkwt_id = " . $contract_id . "
			// )";
			$kondisiDefaultQuery = "";

			## Total number of records without filtering
			$dbtraxes->select('count(*) as allcount');
			if ($filterProject != '') {
				$dbtraxes->where($filterProject);
			}
			if ($filterSubProject != '') {
				$dbtraxes->where($filterSubProject);
			}
			if ($filterPeriode != '') {
				$dbtraxes->where($filterPeriode);
			}
			// $dbtraxes->where($kondisiDefaultQuery);
			// $dbtraxes->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $dbtraxes->get('tx_cio')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$dbtraxes->select('count(*) as allcount');
			// $dbtraxes->where($kondisiDefaultQuery);
			if ($searchQuery != '') {
				$dbtraxes->where($searchQuery);
			}
			if ($filterProject != '') {
				$dbtraxes->where($filterProject);
			}
			if ($filterSubProject != '') {
				$dbtraxes->where($filterSubProject);
			}
			if ($filterPeriode != '') {
				$dbtraxes->where($filterPeriode);
			}
			// $dbtraxes->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $dbtraxes->get('tx_cio')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$dbtraxes->select('tx_cio.secid');
			$dbtraxes->select('tx_cio.employee_id');
			$dbtraxes->select('tx_cio.employee_name');
			$dbtraxes->select('tx_cio.customer_id');
			$dbtraxes->select('tx_cio.customer_name');
			$dbtraxes->select('tx_cio.project_id');
			$dbtraxes->select('tx_cio.project_name');
			$dbtraxes->select('tx_cio.sub_project_name');
			$dbtraxes->select('tx_cio.jabatan_name');
			$dbtraxes->select('tx_cio.penempatan');
			$dbtraxes->select('tx_cio.date_cio');
			$dbtraxes->select('tx_cio.datetimephone_in');
			$dbtraxes->select('tx_cio.latitude_in');
			$dbtraxes->select('tx_cio.datetimephone_out');
			// $dbtraxes->where($kondisiDefaultQuery);
			if ($searchQuery != '') {
				$dbtraxes->where($searchQuery);
			}
			if ($filterProject != '') {
				$dbtraxes->where($filterProject);
			}
			if ($filterSubProject != '') {
				$dbtraxes->where($filterSubProject);
			}
			if ($filterPeriode != '') {
				$dbtraxes->where($filterPeriode);
			}
			// $this->db->order_by($columnName, $columnSortOrder);
			// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			//$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
			// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
			$dbtraxes->limit($rowperpage, $start);
			$records = $dbtraxes->get('tx_cio')->result();

			#Debugging variable
			$tes_query = $dbtraxes->last_query();
			//print_r($tes_query);

			$data = array();

			foreach ($records as $record) {
				//verification id
				// $actual_verification_id = "";
				// if ((is_null($record->verification_id)) || ($record->verification_id == "") || ($record->verification_id == "0")) {
				// 	$actual_verification_id = "e_" . $record->user_id;
				// } else {
				// 	$actual_verification_id = $record->verification_id;
				// }

				//cek status validation ke database
				// $nik_validation = "0";
				// $nik_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nik');
				// if (is_null($nik_validation_query)) {
				// 	$nik_validation = "0";
				// } else {
				// 	$nik_validation = $nik_validation_query['status'];
				// }

				// $validate_nik = "";
				// if($nik_validation == "1"){
				// 	$validate_nik = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
				// } else {
				// 	$validate_nik = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
				// }
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

				// $text_resign = "";
				// if (empty($record->status_resign) || ($record->status_resign == "")) {
				// 	$text_resign = "";
				// } else if ($record->status_resign == "1") {
				// 	$text_resign = " - [AKTIF]";
				// } else if ($record->status_resign == "2") {
				// 	$text_resign = " - [RESIGN]";
				// } else if ($record->status_resign == "3") {
				// 	$text_resign = " - [BLACKLIST]";
				// } else if ($record->status_resign == "4") {
				// 	$text_resign = " - [END CONTRACT]";
				// } else if ($record->status_resign == "5") {
				// 	$text_resign = " - [DEACTIVE]";
				// } else {
				// 	$text_resign = "";
				// }

				//cek komparasi string
				// $teskomparasi_1 = "A";
				// $teskomparasi_2 = "C2";
				// $hasilkomparasi = "";

				// if ($teskomparasi_2 < $teskomparasi_1) {
				// 	$hasilkomparasi = "2 lebih kecil";
				// } else {
				// 	$hasilkomparasi = "2 lebih besar";
				// }

				// $text_pin = "";
				// $id_jabatan_user = $this->get_id_jabatan($session_id);
				// $level_record = $this->get_level($record->designation_id);
				// $level_user = $this->get_level($id_jabatan_user);

				// if (empty($level_user) || $level_user == "") {
				// 	$level_user = "Z9";
				// } else {
				// 	if (strlen($level_user) == 1) {
				// 		$level_user = $level_user . "0";
				// 	}
				// }

				// if (empty($level_record) || $level_record == "") {
				// 	$level_record = "Z9";
				// } else {
				// 	if (strlen($level_record) == 1) {
				// 		$level_record = $level_record . "0";
				// 	}
				// }
				// if ($level_record <= $level_user) {
				// 	$text_pin = "**********";
				// } else {
				// 	$text_pin = $record->private_code;
				// }

				// $addendum_id = $this->secure->encrypt_url($record->id);
				// $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

				// $view = '<button id="tesbutton" type="button" onclick="viewEmployee(' . $record->employee_id . ')" class="btn btn-xs btn-outline-twitter" >AJUKAN PAKLARING</button>';
				// $viewDocs = '<button id="tesbutton2" type="button" onclick="viewDocumentEmployee(' . $record->employee_id . ')" class="btn btn-xs btn-outline-twitter" >DOCUMENT</button>';
				// $editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->employee_id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
				// $delete = '<br><button type="button" onclick="deleteBatchSaltabRelease(' . $record->employee_id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

				// $open_pengajuan = '<button onclick="open_pengajuan(' . $record->employee_id . ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">AJUKAN PAKLARING</button>';


				// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

				$data[] = array(
					"aksi" => $record->secid,
					"employee_id" => $record->employee_id,
					"fullname" => strtoupper($record->employee_name),
					"customer_id" => strtoupper($record->customer_id),
					"customer_name" => strtoupper($record->customer_name),
					"project_id" => strtoupper($record->project_id),
					"project_name" => strtoupper($record->project_name),
					"sub_project_name" => strtoupper($record->sub_project_name),
					"jabatan_name" => strtoupper($record->jabatan_name),
					"penempatan" => strtoupper($record->penempatan),
					"customer_name" => strtoupper($record->customer_name),
					"datetimephone_in" => strtoupper($record->datetimephone_in),
					"datetimephone_out" => strtoupper($record->datetimephone_out),
					// "pincode" => $text_pin,
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


	function get_employee_print($postData = null)
	{


		$dbtraxes = $this->load->database('dbtraxes', TRUE);
		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
		// $sub_project = urldecode($postData['sub_project']);
		// $sub_project = 'HELPER DRIVER';
		$sdate = $postData['sdate'];
		$edate = $postData['edate'];
		$filter = $postData['filter'];
		$session_id = $postData['session_id'];

		$filterProject = "";
		$filterGolongan = "";
		$filterKategori = "";

		## Search 
		$searchQuery = "";
		if ($filter != '') {
			$searchQuery = " (tx_cio.employee_id like '%" . $filter .  "%' or tx_cio.employee_name like '%" . $filter . "%' or tx_cio.jabatan_name like '%" . $filter . "%') ";
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
				sub_project_name = '" . $sub_project . "'
			)";
		} else {
			$filterSubProject = "";
		}

		$filterStatus = "";
		if (($sdate != null) && ($sdate != "") && ($sdate != '0')) {
			$filterStatus = "(
				DATE_FORMAT(tx_cio.date_cio, '%Y-%m-%d') BETWEEN '" . $sdate . "' AND '" . $edate . "'
			)";

			// $filterStatus = "(
			// 	DATE_FORMAT(tx_cio.date_cio, '%Y-%m-%d') BETWEEN '2025-05-01' AND '2025-05-31'
			// )";
		} else {
			$filterStatus = "";
		}

		## Kondisi Default 
		$kondisiDefaultQuery = "";

		## Fetch records
		// $this->db->select('*');
		$dbtraxes->select('tx_cio.employee_id');
		$dbtraxes->select('tx_cio.employee_name');
		$dbtraxes->select('tx_cio.project_name');
		$dbtraxes->select('tx_cio.sub_project_name');
		$dbtraxes->select('tx_cio.jabatan_name');
		$dbtraxes->select('tx_cio.penempatan');
		$dbtraxes->select('tx_cio.status_emp');
		$dbtraxes->select('tx_cio.customer_id');
		$dbtraxes->select('tx_cio.customer_name');
		$dbtraxes->select('tx_cio.customer_address');
		$dbtraxes->select('tx_cio.owner_name');
		$dbtraxes->select('tx_cio.owner_contact');
		$dbtraxes->select('tx_cio.date_cio');
		$dbtraxes->select('tx_cio.datetimephone_in');
		$dbtraxes->select('tx_cio.createdon');
		$dbtraxes->select('tx_cio.distance_in');
		$dbtraxes->select('tx_cio.datetimephone_out');
		$dbtraxes->select('tx_cio.createdon_out');
		$dbtraxes->select('tx_cio.distance_out');
		$dbtraxes->select('TIMEDIFF(tx_cio.datetimephone_out, tx_cio.datetimephone_in) AS timestay');
		$dbtraxes->select('tx_cio.keterangan');
		$dbtraxes->select('tx_cio.foto_in');
		$dbtraxes->select('tx_cio.foto_out');


		// $dbtraxes->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$dbtraxes->where($searchQuery);
		}
		if ($filterProject != '') {
			$dbtraxes->where($filterProject);
		}
		if ($filterSubProject != '') {
			$dbtraxes->where($filterSubProject);
		}
		if ($filterStatus != '') {
			$dbtraxes->where($filterStatus);
		}
		// $this->db->join('xin_companies', 'xin_companies.company_id = xin_employees.company_id');
		// $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
		// $this->db->join('xin_projects', 'xin_projects.project_id = xin_employees.project_id');
		// $this->db->join('xin_projects_sub', 'xin_projects_sub.secid = xin_employees.sub_project_id');
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		// $this->db->join('(SELECT contract_id, employee_id, from_date, to_date, file_name, upload_pkwt, no_surat FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		// $this->db->join('(SELECT * FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		$records = $dbtraxes->get('tx_cio')->result();
		$tes_query = $dbtraxes->last_query();

		$data = array();

		foreach ($records as $record) {
			

			$data[] = array(
				$record->employee_id,
				trim(strtoupper($record->employee_name), " "),
				strtoupper($record->project_name),
				strtoupper($record->sub_project_name),
				strtoupper($record->jabatan_name),
				strtoupper($record->penempatan),
				strtoupper($record->status_emp),
				strtoupper($record->customer_id),
				strtoupper($record->customer_name),
				strtoupper($record->customer_address),
				strtoupper($record->owner_name),
				strtoupper($record->owner_contact),
				strtoupper($record->date_cio),
				strtoupper($record->datetimephone_in),
				strtoupper($record->createdon),
				strtoupper($record->distance_in),
				strtoupper($record->datetimephone_out),
				strtoupper($record->createdon_out),
				strtoupper($record->distance_out),
				strtoupper($record->timestay),
				strtoupper($record->keterangan),
				strtoupper($record->foto_in),
				strtoupper($record->foto_out),

			);
		}

		//print_r($this->db->last_query());
		//die;
		//var_dump($postData);
		//var_dump($this->db->last_query());

		return $data;
		//json_encode($data);
	}
}

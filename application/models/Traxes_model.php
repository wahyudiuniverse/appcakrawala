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
		// $sub_project = str_replace($postData['sub_project']," ","");
		$sub_project = $postData['sub_project'];
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
			// $filterSubProject = "(
			// 	REPLACE(tx_cio.sub_project_name,' ','' = '" . $sub_project . "'
			// )";
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
				'https://api.traxes.id/'.$record->foto_in,
				'https://api.traxes.id/'.$record->foto_out,

			);
		}

		//print_r($this->db->last_query());
		//die;
		//var_dump($postData);
		//var_dump($this->db->last_query());

		return $data;
		//json_encode($data);
	}


	// get company > projects
	public function ajax_proj_subproj_info($id)
	{


		$dbtraxes = $this->load->database('dbtraxes', TRUE);

		// $condition = "id_project =" . "'" . $id . "'" . " and sub_active=1";
		$condition = "project_id =" . "'" . $id . "'";
		$dbtraxes->select('DISTINCT(project_sub) AS sub_project_name');
		$dbtraxes->from('xin_user_mobile');
		$dbtraxes->where($condition);
		// $dbtraxes->limit(100);
		$query = $dbtraxes->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// get single record > company | employees
	public function ajax_sub_project($id)
	{

		// $sql = "SELECT * FROM xin_projects_sub WHERE id_project = ?";
		$sql = "SELECT distinct(project_sub) as sub_project_name FROM xin_user_mobile WHERE project_id = ?";
		// $sql = "SELECT DISTINCT(project_sub) as sub_project_name FROM xin_user_mobile WHERE project_id = '24';";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// LIST TX_CIO SUMMARY

	function get_summary_cio($postData = null)
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
		$periode 		= $postData['periode'];
		$session_id 	= $postData['session_id'];

		if ($project != "0") {
			## Search 
			$searchQuery = "";
			if ($searchValue != '') {
				if (strlen($searchValue) >= 3) {
					$searchQuery = " (tx_cio_summary.employee_id like '%" . $searchValue .  "%' or tx_cio_summary.employee_name like '%" . $searchValue . "%' or tx_cio_summary.project_name like '%" . $searchValue . "%' or tx_cio_summary.penempatan like '%" . $searchValue . "%') ";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "tx_cio_summary.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				// $filterSubProject = "tx_cio.sub_project_id = '" . $sub_project . "'";
				$filterSubProject = "tx_cio_summary.sub_project_name = '".$sub_project."'";
			} else {
				$filterSubProject = "";
			}

			$filterPeriode = "";
			if (($periode != null) && ($periode != "")) {
				$filterPeriode = "DATE_FORMAT(tx_cio_summary.date_cio, '%Y-%m')  = '" . $periode . "'";
				// $filterPeriode = "DATE_FORMAT(tx_cio.date_cio, '%Y-%m')  = '2025-05'";

			} else {
				$filterPeriode = "";
			}

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

			$dbtraxes->group_by('tx_cio_summary.employee_id');
			// $records = $dbtraxes->get('tx_cio_summary')->result();

			$tes_query = $dbtraxes->last_query();
			// $totalRecords = $records[0]->allcount;
			$totalRecords = $dbtraxes->count_all_results('tx_cio_summary');
			// $dbtraxes->count_all()

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

			$dbtraxes->group_by('tx_cio_summary.employee_id');
			// $records = $dbtraxes->get('tx_cio_summary')->result();
			// $totalRecordwithFilter = $records[0]->allcount;
			$totalRecordwithFilter = $dbtraxes->count_all_results('tx_cio_summary');

			## Fetch records

			$dbtraxes->group_by('tx_cio_summary.employee_id');
			$dbtraxes->select('tx_cio_summary.employee_id');
			$dbtraxes->select('tx_cio_summary.employee_name');
			$dbtraxes->select('tx_cio_summary.project_name');
			$dbtraxes->select('tx_cio_summary.sub_project_name');
			$dbtraxes->select('tx_cio_summary.penempatan');
			
				$date_startx = $periode.'-01';
				$date_start = new DateTime($date_startx);

				for ($x = 0; $x <= 30; $x++) {

					$dbtraxes->select("MAX(IF(tx_cio_summary.date_cio = '" . $date_start->format('Y-m-d') . "', DATE_FORMAT(tx_cio_summary.datetimephone_in, '%H:%i') , NULL)) AS '" . $x+1 . "-in'");
					$dbtraxes->select("MAX(IF(tx_cio_summary.date_cio = '" . $date_start->format('Y-m-d') . "', DATE_FORMAT(tx_cio_summary.datetimephone_out, '%H:%i') , NULL)) AS '" . $x+1 . "-out'");
					$date_start->modify('+1 day');
				}

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
			$dbtraxes->limit($rowperpage, $start);
			// $records = $dbtraxes->get('tx_cio_summary')->result();
			$records = $dbtraxes->get('tx_cio_summary')->result_array();

			#Debugging variable
			// $tes_query = $dbtraxes->last_query();
			//print_r($tes_query);

			$data = array();

			foreach ($records as $record) {
				//verification id

				$data[] = array(
					// "aksi" 			=> $record['secid'],
					"aksi" 			=> $tes_query,
					"employee_id" 	=> $record['employee_id'],
					"fullname" 		=> strtoupper($record['employee_name']),
					"project_name" 	=> strtoupper($record['project_name']),
					"project_sub" 	=> strtoupper($record['sub_project_name']),
					"penempatan" 	=> strtoupper($record['penempatan']),
					"1io" 	=> strtoupper($record['1-in'])." ".strtoupper($record['1-out']),
					"2io" 	=> strtoupper($record['2-in'])." ".strtoupper($record['2-out']),
					"3io" 	=> strtoupper($record['3-in'])." ".strtoupper($record['3-out']),
					"4io" 	=> strtoupper($record['4-in'])." ".strtoupper($record['4-out']),
					"5io" 	=> strtoupper($record['5-in'])." ".strtoupper($record['5-out']),
					"6io" 	=> strtoupper($record['6-in'])." ".strtoupper($record['6-out']),
					"7io" 	=> strtoupper($record['7-in'])." ".strtoupper($record['7-out']),
					"8io" 	=> strtoupper($record['8-in'])." ".strtoupper($record['8-out']),
					"9io" 	=> strtoupper($record['9-in'])." ".strtoupper($record['9-out']),
					"10io" 		=> strtoupper($record['10-in'])." ".strtoupper($record['10-out']),
					"11io" 		=> strtoupper($record['11-in'])." ".strtoupper($record['11-out']),
					"12io" 		=> strtoupper($record['12-in'])." ".strtoupper($record['12-out']),
					"13io" 		=> strtoupper($record['13-in'])." ".strtoupper($record['13-out']),
					"14io" 		=> strtoupper($record['14-in'])." ".strtoupper($record['14-out']),
					"15io" 		=> strtoupper($record['15-in'])." ".strtoupper($record['15-out']),
					"16io" 		=> strtoupper($record['16-in'])." ".strtoupper($record['16-out']),
					"17io" 		=> strtoupper($record['17-in'])." ".strtoupper($record['17-out']),
					"18io" 		=> strtoupper($record['18-in'])." ".strtoupper($record['18-out']),
					"19io" 		=> strtoupper($record['19-in'])." ".strtoupper($record['19-out']),
					"20io" 		=> strtoupper($record['20-in'])." ".strtoupper($record['20-out']),
					"21io" 		=> strtoupper($record['21-in'])." ".strtoupper($record['21-out']),
					"22io" 		=> strtoupper($record['22-in'])." ".strtoupper($record['22-out']),
					"23io" 		=> strtoupper($record['23-in'])." ".strtoupper($record['23-out']),
					"24io" 		=> strtoupper($record['24-in'])." ".strtoupper($record['24-out']),
					"25io" 		=> strtoupper($record['25-in'])." ".strtoupper($record['25-out']),
					"26io" 		=> strtoupper($record['26-in'])." ".strtoupper($record['26-out']),
					"27io" 		=> strtoupper($record['27-in'])." ".strtoupper($record['27-out']),
					"28io" 		=> strtoupper($record['28-in'])." ".strtoupper($record['28-out']),
					"29io" 		=> strtoupper($record['29-in'])." ".strtoupper($record['29-out']),
					"30io" 		=> strtoupper($record['30-in'])." ".strtoupper($record['30-out']),
					"31io" 		=> strtoupper($record['31-in'])." ".strtoupper($record['31-out']),

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

	function get_summary_print($postData = null)
	{


		$dbtraxes = $this->load->database('dbtraxes', TRUE);
		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
		// $project = '7008';
		// $sub_project = 'KUDUS';
		$periode = $postData['periode'];
		$filter = $postData['filter'];
		$session_id = $postData['session_id'];

		$filterProject = "";
		$filterGolongan = "";
		$filterKategori = "";

		## Search 
		$searchQuery = "";
		if ($filter != '') {
			$searchQuery = " (tx_cio_summary.employee_id like '%" . $filter .  "%' or tx_cio_summary.employee_name like '%" . $filter . "%' or tx_cio_summary.jabatan_name like '%" . $filter . "%') ";
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
			// $filterSubProject = "(
			// 	REPLACE(tx_cio.sub_project_name,' ','' = '" . $sub_project . "'
			// )";
			$filterSubProject = "(
				sub_project_name = '" . $sub_project . "'
			)";

		} else {
			$filterSubProject = "";
		}


		$filterPeriode = "";
			if (($periode != null) && ($periode != "")) {
			$filterPeriode = "DATE_FORMAT(tx_cio_summary.date_cio, '%Y-%m')  = '" . $periode . "'";
			// $filterPeriode = "DATE_FORMAT(tx_cio.date_cio, '%Y-%m')  = '2025-05'";

		} else {
			$filterPeriode = "";
		}


		## Kondisi Default 
		$kondisiDefaultQuery = "";

		## Fetch records

			$dbtraxes->group_by('tx_cio_summary.employee_id');
			$dbtraxes->select('tx_cio_summary.employee_id');
			$dbtraxes->select('tx_cio_summary.employee_name');
			$dbtraxes->select('tx_cio_summary.project_name');
			$dbtraxes->select('tx_cio_summary.sub_project_name');
			$dbtraxes->select('tx_cio_summary.penempatan');
			
				$date_startx = $periode.'-01';
				$date_start = new DateTime($date_startx);

				for ($x = 0; $x <= 30; $x++) {

					$dbtraxes->select("MAX(IF(tx_cio_summary.date_cio = '" . $date_start->format('Y-m-d') . "', DATE_FORMAT(tx_cio_summary.datetimephone_in, '%H:%i') , NULL)) AS '" . $x+1 . "-in'");
					$dbtraxes->select("MAX(IF(tx_cio_summary.date_cio = '" . $date_start->format('Y-m-d') . "', DATE_FORMAT(tx_cio_summary.datetimephone_out, '%H:%i') , NULL)) AS '" . $x+1 . "-out'");
					$date_start->modify('+1 day');
				}


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

			$records = $dbtraxes->get('tx_cio_summary')->result_array();

		$data = array();

		foreach ($records as $record) {
			

			$data[] = array(

				$record['employee_id'],
				strtoupper($record['employee_name']),
				strtoupper($record['project_name']),
				strtoupper($record['sub_project_name']),
				strtoupper($record['penempatan']),
				$periode,
				strtoupper($record['1-in']),
				strtoupper($record['1-out']),
				strtoupper($record['2-in']),
				strtoupper($record['2-out']),
				strtoupper($record['3-in']),
				strtoupper($record['3-out']),
				strtoupper($record['4-in']),
				strtoupper($record['4-out']),
				strtoupper($record['5-in']),
				strtoupper($record['5-out']),
				strtoupper($record['6-in']),
				strtoupper($record['6-out']),
				strtoupper($record['7-in']),
				strtoupper($record['7-out']),
				strtoupper($record['8-in']),
				strtoupper($record['8-out']),
				strtoupper($record['9-in']),
				strtoupper($record['9-out']),
				strtoupper($record['10-in']),
				strtoupper($record['10-out']),
				strtoupper($record['11-in']),
				strtoupper($record['11-out']),
				strtoupper($record['12-in']),
				strtoupper($record['12-out']),
				strtoupper($record['13-in']),
				strtoupper($record['13-out']),
				strtoupper($record['14-in']),
				strtoupper($record['14-out']),
				strtoupper($record['15-in']),
				strtoupper($record['15-out']),
				strtoupper($record['16-in']),
				strtoupper($record['16-out']),
				strtoupper($record['17-in']),
				strtoupper($record['17-out']),
				strtoupper($record['18-in']),
				strtoupper($record['18-out']),
				strtoupper($record['19-in']),
				strtoupper($record['19-out']),
				strtoupper($record['20-in']),
				strtoupper($record['20-out']),
				strtoupper($record['21-in']),
				strtoupper($record['21-out']),
				strtoupper($record['22-in']),
				strtoupper($record['22-out']),
				strtoupper($record['23-in']),
				strtoupper($record['23-out']),
				strtoupper($record['24-in']),
				strtoupper($record['24-out']),
				strtoupper($record['25-in']),
				strtoupper($record['25-out']),
				strtoupper($record['26-in']),
				strtoupper($record['26-out']),
				strtoupper($record['27-in']),
				strtoupper($record['27-out']),
				strtoupper($record['28-in']),
				strtoupper($record['28-out']),
				strtoupper($record['29-in']),
				strtoupper($record['29-out']),
				strtoupper($record['30-in']),
				strtoupper($record['30-out']),
				strtoupper($record['31-in']),
				strtoupper($record['31-out']),

			);
		}

		return $data;
		//json_encode($data);
	}


	function get_list_tx_order($postData = null)
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
					$searchQuery = " (xin_mobile_order.employee_id like '%" . $searchValue .  "%' or xin_mobile_order.employee_name like '%" . $searchValue . "%' or xin_mobile_order.customer_name like '%" . $searchValue . "%')";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "xin_mobile_order.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				// $filterSubProject = "tx_cio.sub_project_id = '" . $sub_project . "'";
				$filterSubProject = "xin_mobile_order.sub_project = '".$sub_project."'";
			} else {
				$filterSubProject = "";
			}

			$filterPeriode = "";
			if (($sdate != null) && ($edate != "")) {
				// $filterPeriode = "tx_cio.date_cio = '" . $status . "'";
				$filterPeriode = "DATE_FORMAT(xin_mobile_order.order_date, '%Y-%m-%d') BETWEEN '".$sdate."' AND '".$edate."'";

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
			$dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$records = $dbtraxes->get('xin_mobile_order')->result();
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
			$dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$records = $dbtraxes->get('xin_mobile_order')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$dbtraxes->select('xin_mobile_order.secid');
			$dbtraxes->select('xin_mobile_order.customer_id');
			$dbtraxes->select('xin_mobile_order.customer_name');
			$dbtraxes->select('xin_mobile_order.employee_id');
			$dbtraxes->select('xin_mobile_order.employee_name');
			$dbtraxes->select('xin_mobile_order.project_id');
			$dbtraxes->select('xin_mobile_order.project_name');
			$dbtraxes->select('xin_mobile_order.sub_project');
			$dbtraxes->select('xin_mobile_order.jabatan');
			$dbtraxes->select('xin_mobile_order.penempatan');
			$dbtraxes->select('xin_mobile_order.material_id');
			$dbtraxes->select('xin_sku_material.nama_material');
			$dbtraxes->select('xin_sku_material.brand');
			$dbtraxes->select('xin_sku_material.poin');
			$dbtraxes->select('xin_mobile_order.qty');
			$dbtraxes->select('xin_mobile_order.price');
			$dbtraxes->select('xin_mobile_order.total');
			$dbtraxes->select('xin_mobile_order.order_date');

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

			$dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$dbtraxes->limit($rowperpage, $start);
			$records = $dbtraxes->get('xin_mobile_order')->result();

			#Debugging variable
			$tes_query = $dbtraxes->last_query();
			//print_r($tes_query);

			$data = array();

			foreach ($records as $record) {
				//verification id


				$data[] = array(
					"aksi" => $record->secid,
					"employee_id" => $record->employee_id,
					"fullname" => strtoupper($record->employee_name),
					"customer_id" => strtoupper($record->customer_id),
					"customer_name" => strtoupper($record->customer_name),
					"project_id" => strtoupper($record->project_id),
					"project_name" => strtoupper($record->project_name),
					"sub_project_name" => strtoupper($record->sub_project),
					"jabatan_name" => strtoupper($record->jabatan),
					"penempatan" => strtoupper($record->penempatan),
					"material_id" => strtoupper($record->material_id),
					"nama_material" => strtoupper($record->nama_material),
					"brand" => strtoupper($record->brand),
					"poin" => strtoupper($record->poin),
					"qty" => strtoupper($record->qty),
					"price" => strtoupper($record->price),
					"total" => strtoupper($record->total),
					"order_date" => strtoupper($record->order_date),

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

	function get_order_print($postData = null)
	{

		$dbtraxes = $this->load->database('dbtraxes', TRUE);
		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
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
			$searchQuery = " (xin_mobile_order.employee_id like '%" . $filter .  "%' or xin_mobile_order.employee_name like '%" . $filter . "%' or xin_mobile_order.customer_name like '%" . $filter . "%') ";
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
			// $filterSubProject = "(
			// 	REPLACE(tx_cio.sub_project_name,' ','' = '" . $sub_project . "'
			// )";
			$filterSubProject = "(
				sub_project = '" . $sub_project . "'
			)";

		} else {
			$filterSubProject = "";
		}

		$filterStatus = "";
		if (($sdate != null) && ($sdate != "") && ($sdate != '0')) {
			$filterStatus = "(
				DATE_FORMAT(xin_mobile_order.order_date, '%Y-%m-%d') BETWEEN '" . $sdate . "' AND '" . $edate . "'
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

			$dbtraxes->select('xin_mobile_order.secid');
			$dbtraxes->select('xin_mobile_order.employee_id');
			$dbtraxes->select('xin_mobile_order.employee_name');
			$dbtraxes->select('xin_mobile_order.project_id');
			$dbtraxes->select('xin_mobile_order.project_name');
			$dbtraxes->select('xin_mobile_order.sub_project');
			$dbtraxes->select('xin_mobile_order.jabatan');
			$dbtraxes->select('xin_mobile_order.penempatan');
			$dbtraxes->select('xin_mobile_order.customer_id');
			$dbtraxes->select('xin_mobile_order.customer_name');
			$dbtraxes->select('xin_mobile_order.material_id');
			$dbtraxes->select('xin_sku_material.nama_material');
			$dbtraxes->select('xin_sku_material.brand');
			$dbtraxes->select('xin_sku_material.poin');
			$dbtraxes->select('xin_mobile_order.qty');
			$dbtraxes->select('xin_mobile_order.price');
			$dbtraxes->select('xin_mobile_order.total');
			$dbtraxes->select('xin_mobile_order.order_date');



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

			$dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');

		$records = $dbtraxes->get('xin_mobile_order')->result();
		$tes_query = $dbtraxes->last_query();

		$data = array();

		foreach ($records as $record) {
			

			$data[] = array(
				$record->employee_id,
				trim(strtoupper($record->employee_name), " "),
				strtoupper($record->project_name),

				strtoupper($record->sub_project),
				strtoupper($record->jabatan),
				strtoupper($record->penempatan),
				
				strtoupper($record->customer_id),
				strtoupper($record->customer_name),
				strtoupper($record->material_id),
				
				strtoupper($record->nama_material),
				strtoupper($record->brand),
				strtoupper($record->poin),
				
				strtoupper($record->qty),
				strtoupper($record->price),
				strtoupper($record->total),
				
				strtoupper($record->order_date),

			);
		}

		//print_r($this->db->last_query());
		//die;
		//var_dump($postData);
		//var_dump($this->db->last_query());

		return $data;
		//json_encode($data);
	}


	function get_list_tx_display($postData = null)
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
					$searchQuery = " (tx_display.nik like '%" . $searchValue .  "%' or tx_display.employee_name like '%" . $searchValue . "%' or tx_display.customer_name like '%" . $searchValue . "%')";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "tx_display.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				// $filterSubProject = "tx_cio.sub_project_id = '" . $sub_project . "'";
				$filterSubProject = "tx_display.project_sub = '".$sub_project."'";
			} else {
				$filterSubProject = "";
			}

			$filterPeriode = "";
			if (($sdate != null) && ($edate != "")) {
				// $filterPeriode = "tx_cio.date_cio = '" . $status . "'";
				$filterPeriode = "DATE_FORMAT(tx_display.created_at, '%Y-%m-%d') BETWEEN '".$sdate."' AND '".$edate."'";

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
			// $dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$records = $dbtraxes->get('tx_display')->result();
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
			// $dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$records = $dbtraxes->get('tx_display')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$dbtraxes->select('tx_display.secid');
			$dbtraxes->select('tx_display.nik');
			$dbtraxes->select('tx_display.employee_name');
			$dbtraxes->select('tx_display.project_id');
			$dbtraxes->select('tx_display.project_name');
			$dbtraxes->select('tx_display.project_sub');
			$dbtraxes->select('tx_display.jabatan');
			$dbtraxes->select('tx_display.id_toko');
			$dbtraxes->select('tx_display.customer_name');
			$dbtraxes->select('tx_display.display');
			$dbtraxes->select('tx_display.display2');
			$dbtraxes->select('tx_display.display3');
			$dbtraxes->select('tx_display.status_display');
			$dbtraxes->select('tx_display.poin');
			$dbtraxes->select('tx_display.created_at');

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

			// $dbtraxes->join('xin_sku_material', 'xin_sku_material.kode_sku = xin_mobile_order.material_id', 'left');
			$dbtraxes->limit($rowperpage, $start);
			$records = $dbtraxes->get('tx_display')->result();

			#Debugging variable
			$tes_query = $dbtraxes->last_query();
			//print_r($tes_query);

			$data = array();

			foreach ($records as $record) {
				//verification id


				$data[] = array(
					"aksi" => $record->secid,
					"employee_id" => $record->nik,
					"fullname" => strtoupper($record->employee_name),
					"project_name" => strtoupper($record->project_name),
					"project_sub" => strtoupper($record->project_sub),
					"jabatan_name" => strtoupper($record->jabatan),
					"customer_name" => strtoupper($record->customer_name),
					"tanggal" => strtoupper($record->created_at),
					"display" => "https://api.traxes.id/".$record->display,
					"display2" => "https://api.traxes.id/".$record->display2,
					"display3" => "https://api.traxes.id/".$record->display3,

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


	function get_display_print($postData = null)
	{

		$dbtraxes = $this->load->database('dbtraxes', TRUE);
		$response = array();

		//variabel filter (diambil dari post ajax di view)
		$project = $postData['project'];
		$sub_project = $postData['sub_project'];
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
			$searchQuery = " (tx_display.employee_id like '%" . $filter .  "%' or tx_display.employee_name like '%" . $filter . "%' or 
				tx_display.customer_name like '%" . $filter . "%') ";
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
			// $filterSubProject = "(
			// 	REPLACE(tx_cio.sub_project_name,' ','' = '" . $sub_project . "'
			// )";
			$filterSubProject = "(
				project_sub = '" . $sub_project . "'
			)";

		} else {
			$filterSubProject = "";
		}

		$filterStatus = "";
		if (($sdate != null) && ($sdate != "") && ($sdate != '0')) {
			$filterStatus = "(
				DATE_FORMAT(tx_display.created_at, '%Y-%m-%d') BETWEEN '" . $sdate . "' AND '" . $edate . "'
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

			$dbtraxes->select('tx_display.secid');

			$dbtraxes->select('tx_display.nik');
			$dbtraxes->select('tx_display.employee_name');
			$dbtraxes->select('tx_display.project_name');
			$dbtraxes->select('tx_display.project_sub');
			$dbtraxes->select('tx_display.jabatan');

			$dbtraxes->select('tx_display.id_toko');
			$dbtraxes->select('tx_display.customer_name');
			$dbtraxes->select('tx_display.created_at');

			$dbtraxes->select('tx_display.display');
			$dbtraxes->select('tx_display.display2');
			$dbtraxes->select('tx_display.display3');
			// $dbtraxes->select('tx_display.status_display');

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

			// $dbtraxes->join('tx_display', 'tx_display.kode_sku = xin_mobile_order.material_id', 'left');

		$records = $dbtraxes->get('tx_display')->result();
		$tes_query = $dbtraxes->last_query();

		$data = array();

		foreach ($records as $record) {
			

			$data[] = array(
				trim(strtoupper($record->nik), " "),
				strtoupper($record->employee_name),
				strtoupper($record->project_name),
				strtoupper($record->project_sub),
				strtoupper($record->jabatan),

				strtoupper($record->id_toko),
				strtoupper($record->customer_name),
				strtoupper($record->created_at),
				
				"https://api.traxes.id/".$record->display,
				"https://api.traxes.id/".$record->display2,
				"https://api.traxes.id/".$record->display3,
				
				// strtoupper($record->status_display),

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

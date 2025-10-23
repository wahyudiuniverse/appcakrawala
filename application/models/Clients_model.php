<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Clients_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_clients()
	{
		return $query = $this->db->query("SELECT * from xin_clients");
	}

	public function get_all_clients()
	{
		$query = $this->db->query("SELECT * from xin_clients");
		return $query->result();
	}

	public function get_projects_by_client($id_client)
	{
		$sql = "SELECT * FROM xin_projects WHERE client_id = ?";
		$binds = array($id_client);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		// $query = $this->db->query("SELECT * from xin_projects WHERE client_id = ?");
		// return $query->result();
	}

	public function get_finish_projects_by_client($id_client)
	{
		$sql = "SELECT * FROM xin_projects WHERE client_id = ? AND status_finish = 1";
		$binds = array($id_client);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		// $query = $this->db->query("SELECT * from xin_projects WHERE client_id = ?");
		// return $query->result();
	}

	public function read_client_info($id)
	{

		$sql = "SELECT * FROM xin_clients WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Read data using username and password
	public function login($data)
	{

		$sql = "SELECT * FROM xin_clients WHERE email = ? AND is_active = ?";
		$binds = array($data['username'], 1);
		$query = $this->db->query($sql, $binds);

		$options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if (password_verify($data['password'], $rw_password[0]->client_password)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// get single user > by email
	public function read_client_info_byemail($email)
	{

		$sql = "SELECT * FROM xin_clients WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// Read data from database to show data in admin page
	public function read_client_information($username)
	{

		$sql = "SELECT * FROM xin_clients WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add($data)
	{
		$this->db->insert('xin_clients', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_record($id)
	{
		$this->db->where('client_id', $id);
		$this->db->delete('xin_clients');
	}

	// Function to update record in table
	public function update_record($data, $id)
	{
		$this->db->where('client_id', $id);
		if ($this->db->update('xin_clients', $data)) {
			return true;
		} else {
			return false;
		}
	}

	/// leads
	public function get_leads()
	{
		return $query = $this->db->query("SELECT * from xin_leads");
	}
	public function get_lead_followup($lead_id)
	{
		$sql = "SELECT * FROM xin_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	public function get_all_leads()
	{
		$query = $this->db->query("SELECT * from xin_leads");
		return $query->result();
	}

	public function read_lead_info($id)
	{

		$sql = "SELECT * FROM xin_leads WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// get single user > by email
	public function read_lead_info_byemail($email)
	{

		$sql = "SELECT * FROM xin_leads WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// Read data from database to show data in admin page
	public function read_lead_information($username)
	{

		$sql = "SELECT * FROM xin_leads WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// Read data from database to show data in admin page
	public function read_lead_followup_info($leads_followup_id)
	{

		$sql = "SELECT * FROM xin_leads_followup WHERE leads_followup_id = ?";
		$binds = array($leads_followup_id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_lead($data)
	{
		$this->db->insert('xin_leads', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_lead_followup($data)
	{
		$this->db->insert('xin_leads_followup', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_lead_record($id)
	{
		$this->db->where('client_id', $id);
		$this->db->delete('xin_leads');
	}
	// Function to Delete selected record from table
	public function delete_lead_followup($id)
	{
		$this->db->where('leads_followup_id', $id);
		$this->db->delete('xin_leads_followup');
	}
	// Function to Delete selected record from table
	public function delete_main_lead_followup($id)
	{
		$this->db->where('lead_id', $id);
		$this->db->delete('xin_leads_followup');
	}

	// Function to update record in table
	public function update_lead_record($data, $id)
	{
		$this->db->where('client_id', $id);
		if ($this->db->update('xin_leads', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table
	public function update_lead_followup_record($data, $id)
	{
		$this->db->where('leads_followup_id', $id);
		if ($this->db->update('xin_leads_followup', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// get total leads
	public function get_total_leads()
	{

		$sql = "SELECT * FROM xin_leads";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	// get total clients
	public function get_total_clients()
	{

		$sql = "SELECT * FROM xin_clients";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	// get total client convert
	public function get_total_client_convert()
	{

		$sql = "SELECT * FROM xin_leads WHERE is_changed = ?";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get total pending followup
	public function get_total_pending_followup()
	{

		$query = $this->db
			->select('lead_id')
			->group_by('lead_id')
			->get('xin_leads_followup');
		return $query->num_rows();
	}
	// get lead followup
	public function get_total_lead_followup($lead_id)
	{

		$sql = "SELECT * FROM xin_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	/*
	* persiapan data untuk datatable pagination
	* data list employees
	* 
	* @author Fadla Qamara
	*/
	function get_list_clients($postData = null)
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
		// $project = $postData['project'];
		// $sub_project = $postData['sub_project'];
		// $status = $postData['status'];
		// $session_id = $postData['session_id'];

		// if ($project != "0") {
		## Search 
		$searchQuery = "";
		if ($searchValue != '') {
			// if (strlen($searchValue) >= 3) {
			$searchQuery = " (company_name like '%" . $searchValue .  "%' or address_1 like '%" . $searchValue .  "%' or no_npwp like '%" . $searchValue .  "%') ";
			// }
		}

		## Filter
		// $filterProject = "";
		// if (($project != null) && ($project != "") && ($project != '0')) {
		// 	$filterProject = "xin_employees.project_id = '" . $project . "'";
		// } else {
		// 	$filterProject = "";
		// }

		// $filterSubProject = "";
		// if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
		// 	$filterSubProject = "xin_employees.sub_project_id = '" . $sub_project . "'";
		// } else {
		// 	$filterSubProject = "";
		// }

		// $filterStatus = "";
		// if (($status != null) && ($status != "") && ($status != '0')) {
		// 	$filterStatus = "xin_employees.status_resign = '" . $status . "'";
		// } else {
		// 	$filterStatus = "";
		// }

		## Kondisi Default 
		// $kondisiDefaultQuery = "(project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = " . $session_id . ")) AND `user_id` != '1'";
		// $kondisiDefaultQuery = "(
		// 	karyawan_id = " . $emp_id . "
		// AND	pkwt_id = " . $contract_id . "
		// )";
		$kondisiDefaultQuery = "`status_finish` = '1'";

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		// if ($filterSubProject != '') {
		// 	$this->db->where($filterSubProject);
		// }
		// if ($filterStatus != '') {
		// 	$this->db->where($filterStatus);
		// }
		$this->db->where($kondisiDefaultQuery);
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		$records = $this->db->get('xin_clients')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		// if ($filterSubProject != '') {
		// 	$this->db->where($filterSubProject);
		// }
		// if ($filterStatus != '') {
		// 	$this->db->where($filterStatus);
		// }
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		$records = $this->db->get('xin_clients')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		// $this->db->select('xin_employees.user_id');
		// $this->db->select('xin_employees.verification_id');
		// $this->db->select('xin_employees.employee_id');
		// $this->db->select('xin_employees.status_resign');
		// $this->db->select('xin_employees.ktp_no');
		// $this->db->select('xin_employees.first_name');
		// $this->db->select('xin_employees.project_id');
		// $this->db->select('xin_employees.sub_project_id');
		// $this->db->select('xin_employees.designation_id');
		// $this->db->select('xin_designations.designation_id');
		// $this->db->select('xin_designations.designation_name');
		// $this->db->select('xin_employees.penempatan');
		//$this->db->select('b.from_date');
		//$this->db->select('b.to_date');
		// $this->db->select('xin_employees.contract_start');
		// $this->db->select('xin_employees.contract_end');
		// $this->db->select('xin_employees.private_code');
		// $this->db->select('xin_projects.priority');
		// $this->db->select('xin_designations.designation_name');
		$this->db->where($kondisiDefaultQuery);
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		// if ($filterProject != '') {
		// 	$this->db->where($filterProject);
		// }
		// if ($filterSubProject != '') {
		// 	$this->db->where($filterSubProject);
		// }
		// if ($filterStatus != '') {
		// 	$this->db->where($filterStatus);
		// }
		$this->db->order_by($columnName, $columnSortOrder);
		// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
		//$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
		// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('xin_clients')->result();

		#Debugging variable
		$tes_query = $this->db->last_query();
		//print_r($tes_query);

		$data = array();

		foreach ($records as $record) {
			$list_project = $this->get_finish_projects_by_client($record->client_id);
			$list_project_text = "";
			if ((is_null($list_project)) || ($list_project == "") || ($list_project == "0")) {
				$list_project_text = "";
			} else {
				$list_project_text = "<table><tr><th>Jenis Dokumen</th><th>Project</th><th>Alias</th><th>Dokumen</th><th>Status</th></tr>";
				foreach ($list_project as $list_project) {
					$jenis_dokumen = "";
					if ($list_project->doc_id == "1") {
						$jenis_dokumen = "PKWT";
					} else if ($list_project->doc_id == "2") {
						$jenis_dokumen = "TKHL";
					} else {
						$jenis_dokumen = "";
					}
					$status_project = "";
					if ($list_project->status == "1") {
						$status_project = "AKTIF";
					} else {
						$status_project = "TIDAK AKTIF";
					}
					$status_pks = "";
					if ($list_project->file_pks == "") {
						$status_pks = "<button onclick='open_pks(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/not-verified.png') . "' width='20'></button>";
					} else {
						$status_pks = "<button onclick='open_pks(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/verified.png') . "' width='20'></button>";
					}
					$status_mou = "";
					if ($list_project->file_mou == "") {
						$status_mou = "<button onclick='open_mou(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/not-verified.png') . "' width='20'></button>";
					} else {
						$status_mou = "<button onclick='open_mou(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/verified.png') . "' width='20'></button>";
					}
					$status_ratecard = "";
					if ($list_project->file_ratecard == "") {
						$status_ratecard = "<button onclick='open_ratecard(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/not-verified.png') . "' width='20'></button>";
					} else {
						$status_ratecard = "<button onclick='open_ratecard(\"".$list_project->project_id."\")' type='button' class='btn btn-sm'><img src='". base_url('/assets/icon/verified.png') . "' width='20'></button>";
					}
					$status_dokumen_project = "<table><tr><th>PKS</th><th>MOU</th><th>Ratecard</th></tr>";
					$status_dokumen_project = $status_dokumen_project . "<tr><td align='center' style='text-align: center;'>" . $status_pks . "</td><td align='center' style='text-align: center;'>" . $status_mou . "</td><td align='center' style='text-align: center;'>" . $status_ratecard . "</td></tr>";
					$status_dokumen_project = $status_dokumen_project . "</table>";
					$list_project_text = $list_project_text . "<tr><td>" . $jenis_dokumen . "</td>";
					$list_project_text = $list_project_text . "<td>" . $list_project->title . "</td>";
					$list_project_text = $list_project_text . "<td>" . $list_project->priority . "</td>";
					$list_project_text = $list_project_text . "<td>" . $status_dokumen_project . "</td>";
					$list_project_text = $list_project_text . "<td>" . $status_project . "</td></tr>";
				}
				$list_project_text = $list_project_text . "</table>";
			}

			//alamat client
			$alamat = "";
			if ((is_null($record->address_1)) || ($record->address_1 == "") || ($record->address_1 == "0")) {
				if ((is_null($record->address_2)) || ($record->address_2 == "") || ($record->address_2 == "0")) {
					$alamat = "";
				} else {
					$alamat = "<table><tr><td style='width:30%'>Alamat 1</td><td style='width:70%'>" . strtoupper($record->address_2) . "</td></tr></table>";
				}
			} else {
				if ((is_null($record->address_2)) || ($record->address_2 == "") || ($record->address_2 == "0")) {
					$alamat = "<table><tr><td style='width:30%'>Alamat 1</td><td style='width:70%'>" . strtoupper($record->address_1) . "</td></tr></table>";
				} else {
					$alamat = "<table><tr><td style='width:30%'>Alamat 1</td><td style='width:70%'>" . strtoupper($record->address_1) . "</td></tr><tr><td style='width:30%'>Alamat 2</td><td style='width:70%'>" . strtoupper($record->address_2) . "</td></tr></table>";
				}
			}

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
			// $button_open_ktp = '<button onclick="open_ktp(' . $record->employee_id . ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KTP</button>';

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

			$view = '<button id="tesbutton" type="button" onclick="viewClient(' . $record->client_id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
			$viewDocs = '<button id="tesbutton2" type="button" onclick="viewDocumentEmployee(' . $record->client_id . ')" class="btn btn-xs btn-outline-twitter" >DOCUMENT</button>';
			$editReq = '<br><button type="button" onclick="downloadBatchSaltabRelease(' . $record->client_id . ')" class="btn btn-xs btn-outline-success" >DOWNLOAD</button>';
			$delete = '<br><button type="button" onclick="deleteBatchSaltabRelease(' . $record->client_id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

			$add_brand = '<button id="add_brand" type="button" onclick="add_brand(' . $record->client_id . ')" class="btn btn-sm btn-outline-twitter" >+ ADD PROJECT/BRAND</button>';

			// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

			$data[] = array(
				"aksi" => $view,
				"company_name" => $record->company_name,
				"brand" => $list_project_text . $add_brand,
				"alamat" => $record->address_1,
				"no_npwp" => $record->no_npwp,
				"status_migrasi" => $record->company_name,
				// $this->get_nama_karyawan($record->upload_by)
			);
		}
		// } else {
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

	//save data nama client
	public function save_client_name($postData)
	{
		//save data
		$this->db->insert('xin_clients', $postData);

		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	//save data detail project
	public function save_project_detail($postData)
	{
		//save data
		$this->db->insert('xin_projects', $postData);

		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	//save data dokumen client
	public function save_dokumen($file_data, $id_client, $name)
	{
		//update data
		if ($name == "npwp") {
			//Cek variabel post
			$datarequest = [
				'file_npwp'   => $file_data,
			];

			$this->db->where('client_id', $id_client);
			// $this->db->where('client_id', '5');
			$this->db->update('xin_clients', $datarequest);
		} else if ($name == "ktp") {
			//Cek variabel post
			$datarequest = [
				'file_ktp'   => $file_data,
			];

			$this->db->where('client_id', $id_client);
			$this->db->update('xin_clients', $datarequest);
		}
	}

	//save data NPWP client
	public function save_dokumen_client($postData)
	{
		//Cek variabel post
		$datarequest = [
			'no_npwp'     => trim($postData['no_npwp']),
			'file_npwp'   => $postData['link_file_npwp'],
		];

		//update data
		$this->db->where('client_id', $postData['id_client']);
		$this->db->update('xin_clients', $datarequest);
	}

	//save data Kontak client
	public function save_kontak_client($postData)
	{
		//Cek variabel post
		$datarequest = [
			'name'      		=> trim($postData['nama_kontak_pt']),
			'contact_number'    => trim($postData['nomor_kontak_pt']),
			'email'      		=> trim($postData['email_kontak_pt']),
			'is_active'      	=> "1",
			'status_finish'    	=> "1",
		];

		//update data
		$this->db->where('client_id', $postData['id_client']);
		$this->db->update('xin_clients', $datarequest);
	}
}

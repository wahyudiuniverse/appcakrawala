<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class company_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_companies() {
	  return $this->db->get("xin_companies");
	}
	
	public function get_company_documents() {
	  return $this->db->get("xin_company_documents");
	}
	
	// company types
	public function get_company_types() {
		$query = $this->db->get("xin_company_type");
		return $query->result();
	}
	public function get_company_single($company_id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_company_documents_single($company_id) {
	
		$sql = 'SELECT * FROM xin_company_documents WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_all_companies() {
	  $query = $this->db->get("xin_companies");
	  return $query->result();
	}
	 
	public function read_company_information($id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_company_type($id) {
	
		$sql = 'SELECT * FROM xin_company_type WHERE type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_company_document_info($id) {
	
		$sql = 'SELECT * FROM xin_company_documents WHERE document_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_companies', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	//save data Kontak client
	public function save_pengajuan_skk($postData)
	{
		//Cek variabel post
		$data = [

			'employee_name'     => trim($postData['employee_name']),
			'doc_id'      		=> '0',
			'nip'    			=> trim($postData['employee_id']),
			'jenis_dokumen'     => trim($postData['jenis_dokumen']),
			'nomor_dokumen'     => trim($postData['nomor_dokumen']),
			'ktp'     			=> trim($postData['ktp']),
			'posisi_jabatan'    => trim($postData['posisi_jabatan']),
			'penempatan'    	=> trim($postData['penempatan']),
			'project_id'     	=> trim($postData['project_id']),
			'project_name'     	=> trim($postData['project_name']),
			'company'     		=> trim($postData['company']),
			'company_name'     	=> trim($postData['company_name']),
			'join_date'     	=> trim($postData['join_date']),
			'resign_date'     	=> trim($postData['resign_date']),
			'bpjs_join'     	=> trim($postData['bpjs_join']),
			'bpjs_date'     	=> trim($postData['bpjs_date']),
			'resign_status'		=> trim($postData['resign_status']),
			'exit_clearance'	=> trim($postData['exit_clearance']),
			'resign_letter'		=> trim($postData['resign_letter']),
			'request_resign_date'	=> trim($postData['request_resign_date']),
			'request_resign_by'		=> trim($postData['request_resign_by']),

			// 'is_active'      	=> "1",
			// 'status_finish'    	=> "1",
		];
		
		$this->db->insert('xin_qrcode_skk', $data);
		//update data
		// $this->db->where('client_id', $postData['id_client']);
		// $this->db->update('xin_clients', $datarequest);
	}


	//save data Kontak client
	public function update_pengajuan_skk($postData, $qr_code)
	{
		//Cek variabel post
		$data = [
			'doc_id'      		=> trim($postData['docid']),
			'jenis_dokumen'     => trim($postData['jenis_dokumen']),
			'nomor_dokumen'     => trim($postData['nomor_dokumen']),
			'join_date'     	=> trim($postData['join_date']),
			'resign_date'     	=> trim($postData['resign_date']),
			'bpjs_join'     	=> trim($postData['bpjs_join']),
			'bpjs_date'     	=> trim($postData['bpjs_date']),
			'resign_status'		=> trim($postData['resign_status']),
			'exit_clearance'	=> trim($postData['exit_clearance']),
			'resign_letter'		=> trim($postData['resign_letter']),
			'approve_hrd'		=> trim($postData['session_hrd']),
			'approve_hrd_date'	=> date("Y-m-d h:m:i"),
			'sign_nip'			=> '24536132',
			'sign_fullname'		=> 'PAMUNGKAS SUSANTO',
			'sign_jabatan'		=> 'SM HRD & GA',
			'sign_company'		=> trim($postData['company_id']),
			'sign_company_name'	=> trim($postData['company_name']),
			'qr_code'			=> trim($qr_code),
		];
		
		// $this->db->insert('xin_qrcode_skk', $data);
		//update data
		$this->db->where('secid', $postData['secid']);
		$this->db->update('xin_qrcode_skk', $data);
	}


	//save rebuild qrcode
	public function rebuild_qrcode_skk($secid, $docid, $qr_code)
	{
		//Cek variabel post
		$data = [
			'doc_id'      		=> trim($docid),
			'qr_code'			=> trim($qr_code),
		];
		
		// $this->db->insert('xin_qrcode_skk', $data);
		//update data
		$this->db->where('secid', $secid);
		$this->db->update('xin_qrcode_skk', $data);
	}


	//save data Kontak client
	public function update_revisi_skk($postData)
	{
		//Cek variabel post
		$data = [
			'jenis_dokumen'     => trim($postData['jenis_dokumen']),
			'join_date'     	=> trim($postData['join_date']),
			'resign_date'     	=> trim($postData['resign_date']),
			'bpjs_join'     	=> trim($postData['bpjs_join']),
			'bpjs_date'     	=> trim($postData['bpjs_date']),
			'resign_status'		=> trim($postData['resign_status']),
			'exit_clearance'	=> trim($postData['exit_clearance']),
			'resign_letter'		=> trim($postData['resign_letter']),
			'cancel_status'		=> 0,
			'modifiedby'		=> trim($postData['modifiedby']),
			'modifiedon'		=> date("Y-m-d h:m:i"),
		];
		
		// $this->db->insert('xin_qrcode_skk', $data);
		//update data
		$this->db->where('secid', $postData['secid']);
		$this->db->update('xin_qrcode_skk', $data);
	}

	//save data Kontak client
	public function update_tolak_pengajuan_skk($postData)
	{
		//Cek variabel post
		$data = [
			// 'doc_id'      			=> trim($postData['docid']),
			'cancel_status'     	=> trim($postData['cancel_status']),
			'cancel_description'     => trim($postData['cancel_description']),
			'cancel_date'     		=> trim($postData['cancel_date']),
		];
		
		// $this->db->insert('xin_qrcode_skk', $data);
		//update data
		$this->db->where('secid', $postData['secid']);
		$this->db->update('xin_qrcode_skk', $data);
	}

	// get company > projects
	public function ajax_proj_subproj_info($id)
	{

		// $condition = "id_project =" . "'" . $id . "'" . " and sub_active=1";
		$condition = "id_project =" . "'" . $id . "'";
		$this->db->select('DISTINCT(sub_project_name) AS sub_project_name');
		$this->db->from('xin_projects_sub');
		$this->db->where($condition);
		// $dbtraxes->limit(100);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

function get_list_skk_report($postData = null)
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
		$project 		= $postData['project'];
		$sub_project 	= $postData['sub_project'];
		$status 			= $postData['status'];
		$session_id 	= $postData['session_id'];

		if ($project != "5") {
			## Search 
			$searchQuery = "";
			if ($searchValue != '') {
				if (strlen($searchValue) >= 3) {
					$searchQuery = " (xin_qrcode_skk.employee_name like '%" . $searchValue .  "%' 
					or xin_qrcode_skk.ktp like '%" . $searchValue . "%'
					or xin_qrcode_skk.nip like '%" . $searchValue . "%') ";
				}
			}

			## Filter
			$filterProject = "";
			if (($project != null) && ($project != "") && ($project != '0')) {
				$filterProject = "xin_qrcode_skk.project_id = '" . $project . "'";
			} else {
				$filterProject = "";
			}

			$filterSubProject = "";
			if (($sub_project != null) && ($sub_project != "") && ($sub_project != '0')) {
				// $filterSubProject = "tx_cio.sub_project_id = '" . $sub_project . "'";
				$filterSubProject = "xin_qrcode_skk.sub_project_name = '".$sub_project."'";
			} else {
				$filterSubProject = "";
			}

			$filterStatus = "";
			if (($status != null) && ($status != "")) {
				$filterStatus = "xin_qrcode_skk.employee_name LIKE '%" . $status . "%' 
				or xin_qrcode_skk.ktp LIKE '%" . $status . "%' 
				or xin_qrcode_skk.nip LIKE '%" . $status . "%'";
				// $filterStatus = "nip LIKE '%$status%' OR ktp LIKE '%$status%' OR employee_name LIKE '%$status%'";
			} else {
				$filterStatus = "";
			}

			## Kondisi Default 
			$kondisiDefaultQuery = "xin_qrcode_skk.cancel_status = 0 AND xin_qrcode_skk.approve_hrd is not null";

			## Total number of records without filtering
			$this->db->select('count(*) as allcount');
			$this->db->where($kondisiDefaultQuery);
			if ($filterProject != '') {
				$this->db->where($filterProject);
			}
			if ($filterSubProject != '') {
				$this->db->where($filterSubProject);
			}
			if ($filterStatus != '') {
				$this->db->where($filterStatus);
			}
			// $dbtraxes->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $this->db->get('xin_qrcode_skk')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(*) as allcount');
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
			$this->db->where($kondisiDefaultQuery);
			// $dbtraxes->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			$records = $this->db->get('xin_qrcode_skk')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			// $this->db->select('*');
			$this->db->select('xin_qrcode_skk.secid');
			$this->db->select('xin_qrcode_skk.nomor_dokumen');
			$this->db->select('xin_qrcode_skk.nip');
			$this->db->select('xin_qrcode_skk.ktp');
			$this->db->select('xin_qrcode_skk.employee_name');
			$this->db->select('xin_qrcode_skk.project_name');
			$this->db->select('xin_qrcode_skk.resign_date');
			$this->db->select('xin_qrcode_skk.approve_hrd_date');

			// $dbtraxes->select('xin_qrcode_skk.sub_project_name');
			// $dbtraxes->select('xin_qrcode_skk.jabatan_name');
			// $dbtraxes->select('xin_qrcode_skk.penempatan');
			// $dbtraxes->select('tx_cio.date_cio');
			// $dbtraxes->select('tx_cio.datetimephone_in');
			// $dbtraxes->select('tx_cio.latitude_in');
			// $dbtraxes->select('tx_cio.datetimephone_out');
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
			$this->db->where($kondisiDefaultQuery);
			// $this->db->order_by($columnName, $columnSortOrder);
			// $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
			//$this->db->join('(SELECT contract_id, employee_id, from_date, to_date  FROM xin_employee_contract WHERE contract_id IN ( SELECT MAX(contract_id) FROM xin_employee_contract GROUP BY employee_id)) b', 'b.employee_id = xin_employees.employee_id', 'left');
			// $this->db->join('(select max(contract_id), employee_id from xin_employee_contract group by employee_id) b', 'b.employee_id = xin_employees.employee_id', 'inner');
			$this->db->limit($rowperpage, $start);
			$records = $this->db->get('xin_qrcode_skk')->result();

			#Debugging variable
			// $tes_query = $this->db->last_query();
			// print_r($tes_query);

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

				$open_sk = '<button onclick="lihat_sk(' . $record->secid . ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">'.$record->nomor_dokumen.'</button>';


				// $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';


				$data[] = array(
					"aksi" => $record->secid,
					"nomor_dokumen" => $open_sk,
					"nip" => strtoupper($record->nip),
					"ktp" => strtoupper($record->ktp),
					"employee_name" => strtoupper($record->employee_name),
					"project_name" => strtoupper($record->project_name),
					"resign_date" => strtoupper($record->resign_date),
					"approve_hrd_date" => strtoupper($record->approve_hrd_date),
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

	// Function to add record in table
	public function add_document($data){
		$this->db->insert('xin_company_documents', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('company_id', $id);
		$this->db->delete('xin_companies');
		
	}
	
	// Function to Delete selected record from table
	public function delete_doc_record($id){
		$this->db->where('document_id', $id);
		$this->db->delete('xin_company_documents');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('company_id', $id);
		if( $this->db->update('xin_companies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('company_id', $id);
		if( $this->db->update('xin_companies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_company_document_record($data, $id){
		$this->db->where('document_id', $id);
		if( $this->db->update('xin_company_documents',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get company > departments
	public function ajax_company_departments_info($id) {
	
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_departments');
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
?>
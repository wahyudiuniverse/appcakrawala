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
			'company'     		=> trim($postData['company_id']),
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
	public function update_pengajuan_skk($postData)
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
			// 'qr_code'			=> trim($postData['request_resign_by']),
		];
		
		// $this->db->insert('xin_qrcode_skk', $data);
		//update data
		$this->db->where('secid', $postData['secid']);
		$this->db->update('xin_qrcode_skk', $data);
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
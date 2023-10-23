<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Esign_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 


	public function count_skk(){
		
			$sql = "SELECT MAX(secid) AS maxid FROM xin_qrcode_skk";
			$query = $this->db->query($sql);
			return $query->result();
	}

	 public function read_skk($id) {
		$sql = "SELECT secid, doc_id, jenis_dokumen, nomor_dokumen, nip, join_date, resign_date, bpjs_date, TIMESTAMPDIFF(MONTH, join_date, resign_date) AS waktu_kerja, qr_code, sign_fullname,sign_jabatan,sign_company, createdby, createdon FROM xin_qrcode_skk WHERE secid = ? ";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// get single employee by NIP
	public function read_skk_by_nip($id) {
	
		$sql = 'SELECT * FROM xin_qrcode_skk WHERE nip = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return null;
		}
	}

	// get single employee
	public function read_skk_by_doc($id) {
	
		$sql = 'SELECT * FROM xin_qrcode_skk WHERE doc_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get single employee
	public function read_pkwt_by_doc($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE docid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_all_employees_resign()
	{
	  $query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND  status_resign in (2,4,5)
		AND approve_resignhrd is not null
		AND employee_id not IN (SELECT distinct(nip) AS nip FROM xin_qrcode_skk
		UNION
		SELECT 1 AS nip FROM DUAL)
		ORDER BY date_of_leaving DESC;");
  	  return $query->result();
	}

	public function get_project_exist_resign() {
	  $query = $this->db->query("SELECT distinct(emp.project_id) AS project_id, proj.title
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.is_active = 1 
		AND  emp.status_resign in (2,4,5)
        AND emp.approve_resignhrd is not null
		AND emp.employee_id not IN (SELECT distinct(nip) AS nip FROM xin_qrcode_skk
		UNION SELECT 1 AS nip FROM DUAL)

		UNION

		SELECT distinct(emp.project_id) AS project_id, proj.title
		FROM xin_employees emp
		LEFT JOIN xin_projects proj ON proj.project_id=emp.project_id
		WHERE emp.is_active = 1
        AND emp.status_resign = '3'
        AND emp.approve_resignhrd is not null        
        AND emp.dok_exit_clearance is not null
        AND emp.employee_id not IN (SELECT distinct(nip) AS nip FROM xin_qrcode_skk
        UNION SELECT 1 AS nip FROM DUAL)
        ;");
  	  return $query->result();
	}


	public function get_all_employees_active()
	{
	  $query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND  status_resign = 1
		AND employee_id not IN (SELECT 1 AS nip FROM DUAL)
		ORDER BY date_of_leaving DESC;");
  	  return $query->result();
	}

	public function ajax_proj_emp_info($id)
	{
	  $query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,project_id,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign in (2,4)
		AND approve_resignhrd is not null
		AND employee_id not IN (SELECT distinct(nip) AS nip FROM xin_qrcode_skk
		UNION
		SELECT 1 AS nip FROM DUAL)
		AND project_id = '$id'

		UNION

		SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, date_of_leaving,project_id,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign = '3'
        AND approve_resignhrd is not null        
        AND dok_exit_clearance is not null
		AND employee_id not IN (SELECT distinct(nip) AS nip FROM xin_qrcode_skk
		UNION
		SELECT 1 AS nip FROM DUAL)
		AND project_id = '$id';");
  	  return $query->result();
	}


	public function get_pkwt()
	{
	  return $this->db->get("xin_employee_contract");
	}
	

	// get single record > company | employees
	 public function ajax_employee_info($id) {
	
		//$sql = "SELECT * FROM xin_employees WHERE company_id = ? and user_role_id!='1' and is_logged_in='1'";
		$sql = "SELECT * FROM xin_employees WHERE employee_id = ? ";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}


	// public function get_employees($id) {

	//   $hasil=$this->db->query("SELECT * FROM xin_employee WHERE employee_id='$id'");
	//         return $hasil->result();

	// }
	// $CI->db->select('*');
	// $CI->db->from('xin_employee_contract');
	// $CI->db->where('contract_id', $userid);
	// $CI->db->join('user_email', 'user_email.user_id = emails.id', 'left');
	// $query = $CI->db->get(); 

	public function get_pkwt_employee() {
	
		// $condition = "invoice_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		// $this->db->where($id);
		// $this->db->limit(1);
		$this->db->join('xin_employees','xin_employees.employee_id = xin_employee_contract.employee_id','left');
		// $query = $this->db->get();
		return $this->db->get();

	}


	public function get_pkwt_approval() {
	
		$this->db->select('*');
		$this->db->from('xin_employee_contract');
		$this->db->join('xin_employees','xin_employees.user_id = xin_employee_contract.employee_id','left');
		$this->db->where ( 'status_approve', 0);
		return $this->db->get();
		// $query = $this->db->get ();
  //   	return $query->result ();

	}


		// get all employes temporary
	public function get_pkwt_temp($importid) {
		
		$sql = 'SELECT * FROM xin_employee_contract_temp WHERE uploadid = ?';
		$binds = array($importid);
		$query = $this->db->query($sql, $binds);
	    return $query;
	}
	

	// get employees list> reports
	public function filter_employees_reports($company_id,$department_id,$project_id,$sub_project_id) {

		// 0-0-0-0
		  if($company_id==0 && $department_id==0 && $project_id==0 && $sub_project_id==0) {
		 	 return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		// 1-0-0-0
		  } else if($company_id!=0 && $department_id==0 && $project_id==0 && $sub_project_id==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-0-0
		  } else if($company_id!=0 && $department_id!=0 && $project_id==0 && $sub_project_id==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-0
		  } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id,$project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-1-1-1
		  } else if($company_id!=0 && $department_id!=0 && $project_id!=0 && $sub_project_id!=0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? and department_id = ? AND project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$department_id,$project_id,$sub_project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 0-0-1-0
		  } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id==0) {
		 	  $sql = "SELECT * from xin_employees where project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 0-0-1-1
		  } else if ($company_id==0 && $department_id==0 && $project_id!=0 && $sub_project_id!=0) {
		 	  $sql = "SELECT * from xin_employees where project_id = ? AND sub_project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($project_id,$sub_project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		// 1-0-1-0
		  } else if ($company_id!=0 && $department_id==0 && $project_id!=0 && $sub_project_id==0) {
		 	  $sql = "SELECT * from xin_employees where company_id = ? AND project_id = ? AND employee_id NOT IN (1)";
			  $binds = array($company_id,$project_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else {
			  return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id NOT IN (1)");
		  }
	}

	// get employees list> reports
	public function filter_employees_reports_none($company_id,$department_id,$project_id,$sub_project_id) {

			  return $query = $this->db->query("SELECT * FROM xin_employees WHERE employee_id IN (21300023)");
		  
	}


	// Function to add record in table
	public function addsign_skk($data){
		$this->db->insert('xin_qrcode_skk', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_pkwt_record($data){
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function addtemp($data){
		$this->db->insert('xin_employee_contract_temp', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	// Function to add record in table > document info
	public function document_pkwt_add($data){
		$this->db->insert('xin_employee_contract_pdf', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}

	// Function to add record in table
	public function addsign($data){
		$this->db->insert('xin_documents_qrcode', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	// Function to Delete selected record from table
	public function delete_sign_skk($id){
		$this->db->where('secid', $id);
		$this->db->delete('xin_qrcode_skk');
		
	}

	// Function to Delete selected record from table
	public function delete_temp_by_employeeid(){
		$this->db->where('employee_id', 'NIK');
		$this->db->delete('xin_employee_contract_temp');
		
	}

	// Function to Delete selected record from table
	public function delete_sign_doc($id){
		$this->db->where('secid', $id);
		$this->db->delete('xin_documents_qrcode');
		
	}

	// get single employee
	public function read_pkwt_info($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}


	// get single pkwt by nosurat
	public function read_pkwt_info_by_nosurat($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE no_surat = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_esign_skk() {

		// $sql = 'SELECT * FROM xin_documents_qrcode WHERE employee_id not IN (1)';
		$sql = 'SELECT * FROM xin_qrcode_skk WHERE jenis_dokumen NOT IN (0,9) ORDER BY secid DESC LIMIT 50';
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

	// get single employee
	public function read_esign_doc($id) {
	
		$sql = 'SELECT * FROM xin_documents_qrcode WHERE doc_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}


	// Function to update record in table > basic_info
	public function update_error_temp($data, $id) {
		$this->db->where('secid', $id);
		if( $this->db->update('xin_employee_contract_temp',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function get_taxes() {
	  return $this->db->get("xin_tax_types");
	}
	 
	public function get_single_pkwt($id) {
		
		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
	 	return $query->result();
	}


	// get single pkwt by userid
	public function get_single_pkwt_by_userid($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ? ORDER BY contract_id DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

		public function get_pkwt_by_userid($id) {
		$query = $this->db->query("

SELECT contract.contract_id, contract.no_surat, contract.employee_id, contract.from_date, contract.to_date, pdf.document_file, pdf.createdat
FROM xin_employee_contract contract
LEFT JOIN ( SELECT * FROM xin_employee_contract_pdf GROUP BY kontrak_id) pdf ON pdf.kontrak_id = contract.contract_id
WHERE contract.employee_id = '$id'
"

		);
		return $query->result();
	}




	// get single pkwt by userid
	public function get_pkwt_file($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract_pdf WHERE kontrak_id = ? ORDER BY secid DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function update_pkwt_record($data, $id){
		$this->db->where('contract_id', $id);
		if( $this->db->update('xin_employee_contract',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	
}
?>
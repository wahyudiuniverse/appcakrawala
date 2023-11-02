<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkwt_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_pkwt()
	{
	  return $this->db->get("xin_employee_contract");
	}
	


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
	

	// get single project by id
	public function read_pkwt_emp($empid) {
	
		$sql = "SELECT employee_id, basic_pay FROM xin_employee_contract WHERE employee_id = ? AND status_pkwt = 1;";
		$binds = array($empid);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
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
	public function delete_temp_by_employeeid(){
		$this->db->where('employee_id', 'NIK');
		$this->db->delete('xin_employee_contract_temp');
		
	}

	// Function to Delete selected record from table
	public function delete_sign_doc($id){
		$this->db->where('secid', $id);
		$this->db->delete('xin_documents_qrcode');
		
	}

	// Function to Delete selected record from table
	public function delete_pkwt_cancel($id){
		$this->db->where('contract_id', $id);
		$this->db->delete('xin_employee_contract');
		
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

	// get single employee
	public function read_pkwt_info_byuniq($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE uniqueid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}

	// get single employee
	public function read_pkwt_by_nip($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ? ORDER BY contract_id DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}

	// get single employee
	public function read_info_ratecard($proj,$posi,$area) {
	
		$sql = 'SELECT * FROM xin_employee_ratecard WHERE project_id = ? AND posisi_jabatan = ? AND kota = ?';
		$binds = array($proj,$posi,$area);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

 	// monitoring request
	public function get_monitoring_pkwt($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE approve_hrd = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC LIMIT 50";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function get_monitoring_pkwt_apnae($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae = 0
			AND cancel_stat = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function get_monitoring_pkwt_cancel($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND cancel_stat = 1
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function get_monitoring_pkwt_apnom($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function get_monitoring_pkwt_aphrd($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE status_pkwt = 0
			AND approve_nae != 0
			AND approve_nom != 0
			AND approve_hrd = 0
			AND cancel_stat = 0
	        AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function get_monitoring_pkwt_history($empID) {

		$sql = "SELECT *
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND status_pkwt = 1
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}


 	// monitoring request
	public function report_pkwt_history_null($empID) {
		$today_date = date('Y-m-d');
		$sql = "SELECT uniqueid, contract_id, employee_id, project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE date_format(approve_hrd_date, '%Y-%m-%d') = '$today_date' 
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function report_pkwt_history_all($empID,$datefrom,$enddate) {

		$sql = "SELECT uniqueid, contract_id, employee_id, project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND status_pkwt = 1
			-- AND date_format(approve_hrd_date, '%Y-%m-%d') = '$datefrom'  
			AND DATE_FORMAT(approve_hrd_date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$enddate'
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function report_pkwt_history($empID,$project_id,$datefrom,$enddate) {

		$sql = "SELECT uniqueid, contract_id, employee_id, project, jabatan, penempatan, from_date, to_date, approve_hrd_date, file_name
			FROM xin_employee_contract
			WHERE approve_nom !=0
			AND status_pkwt = 1
			AND project = '$project_id'
			-- AND date_format(approve_hrd_date, '%Y-%m-%d') = '$datefrom'  
			AND DATE_FORMAT(approve_hrd_date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$enddate'
			AND project in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')
			ORDER BY contract_id DESC";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}



 	// monitoring request
	public function report_pkwt_expired_default($empID) {
		// $today_date = date('Y-m-d');
		$sql = "


		SELECT emp.user_id,emp.employee_id,pkwt.approve_hrd,emp.first_name,emp.company_id,emp.project_id,emp.sub_project_id,emp.designation_id, emp.date_of_joining, emp.penempatan, pkwt.to_date as contract_end 
		FROM xin_employees emp 
		LEFT JOIN (SELECT employee_id, max(to_date) AS to_date, max(approve_hrd_date) as approve_hrd FROM xin_employee_contract GROUP BY employee_id) pkwt 
		ON pkwt.employee_id = emp.employee_id 
		WHERE emp.status_employee = 1 
		AND emp.status_resign = 1 
		AND emp.employee_id not in (1,1024)
		AND emp.sub_project_id not in (1,2) 
		AND pkwt.to_date < now() + INTERVAL 21 day
      --  AND pkwt.approve_hrd = 0
		AND emp.project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID')

		UNION 

		SELECT emp.user_id,emp.employee_id,pkwt.approve_hrd,emp.first_name,emp.company_id,emp.project_id,emp.sub_project_id,emp.designation_id, emp.date_of_joining, emp.penempatan, pkwt.to_date as contract_end 
		FROM xin_employees emp 
		LEFT JOIN (SELECT employee_id, max(to_date) AS to_date, max(approve_hrd_date) as approve_hrd FROM xin_employee_contract GROUP BY employee_id) pkwt 
		ON pkwt.employee_id = emp.employee_id 
		WHERE emp.status_employee = 1 
		AND emp.status_resign = 1 
		AND emp.employee_id not in (1,1024)
		AND emp.sub_project_id not in (1,2) 
		AND pkwt.to_date is null
      --  AND pkwt.approve_hrd = 0
		AND emp.project_id in (SELECT project_id FROM xin_projects_akses WHERE nip = '$empID');";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function report_pkwt_expired_key($key, $empID) {
		// $today_date = date('Y-m-d');
		$sql = "

		SELECT exp.user_id, exp.employee_id, exp.first_name, exp.company_id, exp.project_id, exp.sub_project_id, exp.designation_id, exp.date_of_joining, exp.penempatan, exp.contract_end, exp.all_name
		FROM (
			SELECT emp.user_id,emp.employee_id,emp.first_name,emp.company_id,emp.project_id,emp.sub_project_id,emp.designation_id, emp.date_of_joining, emp.penempatan, pkwt.to_date as contract_end, concat(concat(emp.employee_id,emp.first_name),emp.ktp_no) as all_name
			FROM xin_employees emp 
			LEFT JOIN (SELECT employee_id, max(to_date) AS to_date, max(approve_hrd_date) as approve_hrd FROM xin_employee_contract GROUP BY employee_id) pkwt 
			ON pkwt.employee_id = emp.employee_id 
			WHERE emp.status_employee = 1
			AND emp.status_resign = 1
			AND emp.employee_id not in (1,1024)) exp
		WHERE exp.all_name LIKE '%$key%'";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

 	// monitoring request
	public function report_pkwt_expired_pro($project, $empID) {
		// $today_date = date('Y-m-d');
		$sql = "

		SELECT emp.user_id,emp.employee_id,pkwt.approve_hrd,emp.first_name,emp.company_id,emp.project_id,emp.sub_project_id,emp.designation_id, emp.date_of_joining, emp.penempatan, pkwt.to_date as contract_end 
		FROM xin_employees emp 
		LEFT JOIN (SELECT employee_id, max(to_date) AS to_date, max(approve_hrd_date) as approve_hrd FROM xin_employee_contract GROUP BY employee_id) pkwt 
		ON pkwt.employee_id = emp.employee_id 
		WHERE emp.status_employee = 1 
		AND emp.status_resign = 1 
		AND emp.employee_id not in (1,1024)
		AND pkwt.to_date < now() + INTERVAL 21 day
      --  AND pkwt.approve_hrd = 0
		AND emp.project_id = '$project'

		UNION 

		SELECT emp.user_id,emp.employee_id,pkwt.approve_hrd,emp.first_name,emp.company_id,emp.project_id,emp.sub_project_id,emp.designation_id, emp.date_of_joining, emp.penempatan, pkwt.to_date as contract_end 
		FROM xin_employees emp 
		LEFT JOIN (SELECT employee_id, max(to_date) AS to_date, max(approve_hrd_date) as approve_hrd FROM xin_employee_contract GROUP BY employee_id) pkwt 
		ON pkwt.employee_id = emp.employee_id 
		WHERE emp.status_employee = 1 
		AND emp.status_resign = 1 
		AND emp.employee_id not in (1,1024)
		AND pkwt.to_date is null 
      --  AND pkwt.approve_hrd = 0
		AND emp.project_id = '$project'
";
		// $binds = array(1,$cid);
		$query = $this->db->query($sql);
	    return $query;
	}

	public function get_all_employees_byproject_exp($id)
	{
	  $query = $this->db->query("SELECT user_id, employee_id, CONCAT( employee_id, '-', first_name) AS fullname, project_id, date_of_leaving,month(date_of_leaving) bln_skrng
		FROM xin_employees 
		WHERE is_active = 1 
		AND status_resign = 1
		AND employee_id IN (
				SELECT empc.employee_id AS nip 
				FROM (
					SELECT contract_id, employee_id, max(to_date) AS to_date FROM xin_employee_contract group by employee_id ORDER BY contract_id DESC
					) empc
				WHERE (DATE_SUB(empc.to_date, INTERVAL 1 MONTH)) < CURDATE() 
				GROUP BY empc.employee_id
				ORDER BY empc.contract_id DESC
			)
		AND project_id = '$id'
		ORDER BY date_of_leaving DESC");
  	  return $query->result();
	}

	// get single pkwt by nosurat
	public function read_pkwt_info_by_contractid($id) {
	
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

	// get single pkwt by nosurat
	public function read_pkwt_info_by_docid($id) {
	
		$sql = 'SELECT * FROM xin_employee_contract WHERE docid = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_esign_all() {

		// $sql = 'SELECT * FROM xin_documents_qrcode WHERE employee_id not IN (1)';
		$sql = 'SELECT * FROM xin_documents_qrcode ORDER BY secid DESC';
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

	public function get_single_pkwt($id) {
		
		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query->result();
	}

		// Function to update record in table
	public function update_pkwt_edit($data, $id){
		$this->db->where('contract_id', $id);
		if( $this->db->update('xin_employee_contract',$data)) {
			return true;
		} else {
			return false;
		}		
	}

		// Function to update record in table
	public function update_pkwt_apnae($data, $id){
		$this->db->where('contract_id', $id);
		if( $this->db->update('xin_employee_contract',$data)) {
			return true;
		} else {
			return false;
		}		
	}

		// Function to update record in table
	public function update_pkwt_status($data, $id){
		$this->db->where('employee_id', $id);
		if( $this->db->update('xin_employee_contract',$data)) {
			return true;
		} else {
			return false;
		}		
	}

		// Function to update record in table
	public function update_pkwt_docid($data, $id){
		$this->db->where('docid', $id);
		if( $this->db->update('xin_employee_contract',$data)) {
			return true;
		} else {
			return false;
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
	 

	// get single pkwt by userid
	public function get_single_pkwt_by_userid($id) {
	
		$sql = "SELECT * FROM xin_employee_contract WHERE employee_id = ? AND status_pkwt = 1 ORDER BY contract_id DESC";
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
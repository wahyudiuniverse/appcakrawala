<?php
  /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author   dndsoft
 * @author-email  komputer.dnd@gmail.com
 * @copyright  Copyright © dndsoft.my.id All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_pkwt_apnom extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Employees_model");
		$this->load->model("Project_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Location_model");
		$this->load->model("Pkwt_model");
		$this->load->library('wablas');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_pkwt_digital').' | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_digital');
		$data['path_url'] = 'emp_pkwt_approve_nom';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('504',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_list_appnom", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function pkwt_list_appnom() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/pkwt_list_appnom", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_employees_request_verify();
		// $employee = $this->Employees_model->get_monitoring_rsign_nae();
		$employee = $this->Pkwt_model->get_monitoring_pkwt_apnom($session['employee_id']);

		$data = array();

          foreach($employee->result() as $r) {
			  
				$nip = $r->employee_id;
				$project = $r->project;
				$jabatan = $r->jabatan;
				$penempatan = $r->penempatan;
				$begin_until = $r->from_date .' s/d ' . $r->to_date;
				$basic_pay = $r->basic_pay;
				$approve_nom = $r->approve_nom;

				if($approve_nom=='0'){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Need Approval NOM</button>';
				} else {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Need Approval HRD</button>';
				}

				$emp = $this->Employees_model->read_employee_info_by_nik($nip);
				if(!is_null($emp)){
					$fullname = $emp[0]->first_name;
				} else {
					$fullname = '--';	
				}

				$projects = $this->Project_model->read_single_project($project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			
				// $department = $this->Department_model->read_department_information($r->department);
				// if(!is_null($department)){
				// 	$department_name = $department[0]->department_name;
				// } else {
				// 	$department_name = '--';	
				// }

				// $designation = $this->Designation_model->read_designation_information($r->designation_id);
				// if(!is_null($designation)){
				// 	$designation_name = $designation[0]->designation_name;
				// } else {
				// 	$designation_name = '--';	
				// }

			$data[] = array(
				$status_migrasi,
				$nip,
				$fullname,
				$nama_project,
				$jabatan,
				$penempatan,
				$begin_until,
				 $this->Xin_model->rupiah($basic_pay),
			);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $employee->num_rows(),
                 "recordsFiltered" => $employee->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }


	 // get location > departments
	public function get_project_sub_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_project_sub_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	

	// Validate and add info in database
	public function request_add_employee() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		if($this->input->post('add_type')=='company') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$system = $this->Xin_model->read_setting_info(1);

				if($this->input->post('fullname')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_first_name');
				} else if ($this->input->post('office_lokasi')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_location_office');
				} else if ($this->input->post('project_id')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_project');
				} else if ($this->input->post('sub_project')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_sub_project');
				} else if ($this->input->post('department_id')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_department');
				} else if ($this->input->post('posisi')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_designation');
				} else if ($this->input->post('date_of_join')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_joining_date');
				} else if ($this->input->post('nomor_hp')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
				} else if ($this->input->post('nomor_ktp')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
				}

					if($Return['error']!=''){
					$this->output($Return);
			    }
			}

		   	$fullname = $this->Xin_model->clean_post($this->input->post('fullname'));
				$office_lokasi = $this->input->post('office_lokasi');
				$project_id = $this->input->post('project_id');
				$sub_project_id = $this->input->post('sub_project');
				$department_id = $this->input->post('department_id');
				$posisi = $this->input->post('posisi');
				$date_of_join = $this->input->post('date_of_join');
				$contact_no = $this->input->post('nomor_hp');
				$ktp_no = $this->input->post('nomor_ktp');
				
			// $options = array('cost' => 12);
			// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			// $leave_categories = array($this->input->post('leave_categories'));
			// $cat_ids = implode(',',$this->input->post('leave_categories'));

			$data = array(
				'fullname' => $fullname,
				'location_id' => $office_lokasi,
				'project' => $project_id,
				'sub_project' => $sub_project_id,
				'department' => $department_id,
				'posisi' => $posisi,
				'doj' => $date_of_join,
				'contact_no' => $contact_no,
				'nik_ktp' => $ktp_no,
				// 'pincode' => $this->input->post('pin_code'),
				// 'createdon' => date('Y-m-d h:i:s'),
				'createdby' => $session['user_id']
			);

			$iresult = $this->Employees_model->addrequest($data);
			if ($iresult) {
					$Return['result'] = $this->lang->line('xin_success_add_employee');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		// $result = $this->Company_model->read_company_information('2');
		// $result = $this->Employees_model->read_employee_info($id);
		$result = $this->Pkwt_model->read_pkwt_info_by_contractid($id);

				$emp = $this->Employees_model->read_employee_info_by_nik($result[0]->employee_id);
				if(!is_null($emp)){
					$filename_ktp 		= $emp[0]->filename_ktp;
					$filename_kk 			= $emp[0]->filename_kk;
					$filename_skck 		= $emp[0]->filename_skck;
					$filename_isd 		= $emp[0]->filename_isd;
				} else {
					$filename_ktp 		= '0';	
					$filename_kk 			= '0';	
					$filename_skck 		= '0';	
					$filename_isd 		= '0';	
				}


		$data = array(
				'contract_id' => $result[0]->contract_id,
				'no_surat' => $result[0]->no_surat,
				'no_spb' => $result[0]->no_spb,
				'nip' => $result[0]->employee_id,
				'employee' => $this->Employees_model->read_employee_info_by_nik($result[0]->employee_id),
				'company' => $result[0]->company,
				'jabatan' => $result[0]->jabatan,
				'posisi' => $this->Designation_model->read_designation_information($result[0]->jabatan),
				'project' => $this->Project_model->read_project_information($result[0]->project),
				'penempatan' => $result[0]->penempatan,

				'ktp' => $filename_ktp,
				'kk' => $filename_kk,
				'skck' => $filename_skck,
				'ijazah' => $filename_isd,
				
				'waktu_kontrak' => $result[0]->waktu_kontrak.' (Bulan)',
				'begin' => $result[0]->from_date . ' s/d '. $result[0]->to_date,
				'hari_kerja' => $result[0]->hari_kerja,
				'basic_pay' => $result[0]->basic_pay,
				'dm_allow_grade' => $result[0]->dm_allow_grade,
				'allowance_grade' => $result[0]->allowance_grade,
				'dm_allow_masakerja' => $result[0]->dm_allow_masakerja,
				'allowance_masakerja' => $result[0]->allowance_masakerja,
				'dm_allow_meal' => $result[0]->dm_allow_meal,
				'allowance_meal' => $result[0]->allowance_meal,
				'dm_allow_transport' => $result[0]->dm_allow_transport,
				'allowance_transport' => $result[0]->allowance_transport,
				'dm_allow_rent' => $result[0]->dm_allow_rent,
				'allowance_rent' => $result[0]->allowance_rent,
				'dm_allow_komunikasi' => $result[0]->dm_allow_komunikasi,
				'allowance_komunikasi' => $result[0]->allowance_komunikasi,
				'dm_allow_park' => $result[0]->dm_allow_park,
				'allowance_park' => $result[0]->allowance_park,
				'dm_allow_residance' => $result[0]->dm_allow_residance,
				'allowance_residance' => $result[0]->allowance_residance,
				'dm_allow_laptop' => $result[0]->dm_allow_laptop,
				'allowance_laptop' => $result[0]->allowance_laptop,
				'dm_allow_kasir' => $result[0]->dm_allow_kasir,
				'allowance_kasir' => $result[0]->allowance_kasir,
				'dm_allow_transmeal' => $result[0]->dm_allow_transmeal,
				'allowance_transmeal' => $result[0]->allowance_transmeal,
				'dm_allow_medicine' => $result[0]->dm_allow_medicine,
				'allowance_medicine' => $result[0]->allowance_medicine,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->request_pkwt),
				'request_date' => $result[0]->request_date,
				'approve_nae' => $this->Employees_model->read_employee_info($result[0]->approve_nae),
				'approve_nae_date' => $result[0]->approve_nae_date,
				'approve_nom' => $this->Employees_model->read_employee_info($result[0]->approve_nom),
				'approve_nom_date' => $result[0]->approve_nom_date,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/pkwt/dialog_pkwt_approve_nom', $data);
	}
	
	// Validate and update info in database
	public function update() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		if($this->input->post('edit_type')=='company') {
		$id = $this->uri->segment(4);
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$data_up = array(
				'approve_nom' =>  $session['user_id'],
				'approve_nom_date' => date("Y-m-d h:i:s")
			);

			$result = $this->Pkwt_model->update_pkwt_apnae($data_up,$id);

		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_company');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}

		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Company_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_company');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_document() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Company_model->delete_doc_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hr_official_document_deleted');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

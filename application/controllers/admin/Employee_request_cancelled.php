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

class Employee_request_cancelled extends MY_Controller {
	
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
		$data['title'] = $this->lang->line('xin_request_employee').' | '.$this->Xin_model->site_title();

			$data['all_companies'] = $this->Xin_model->get_companies();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
			$data['list_bank'] = $this->Xin_model->get_bank_code();

		$data['breadcrumbs'] = $this->lang->line('xin_request_employee');
		$data['path_url'] = 'emp_request_cancel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('338',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_list_cancel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list_cancel() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/employees/request_list_cancel", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		$employee = $this->Employees_model->get_request_cancel();

		$data = array();

          foreach($employee->result() as $r) {
			  $no = $r->secid;
				$fullname = $r->fullname;
				$location_id = $r->location_id;
				$project = $r->project;
				$sub_project = $r->sub_project;
				$department = $r->department;
				$posisi = $r->posisi;
				$penempatan = $r->penempatan;
				$doj = $r->doj;
				$contact_no = $r->contact_no;
				$nik_ktp = $r->nik_ktp;
				$approved_naeby = $r->approved_naeby;
				$approved_nomby = $r->approved_nomby;
				$approved_hrdby = $r->approved_hrdby;
			  

				if($approved_naeby==null){
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Need Approval NAE</button>';
				} else if ($approved_nomby==null) {
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Need Approval NOM</button>';
				} else if ($approved_hrdby==null){
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Need Approval HRD</button>';
				} else {
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Approved</button>';
				}


				$projects = $this->Project_model->read_single_project($r->project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			
				$subprojects = $this->Project_model->read_single_subproject($r->sub_project);
				if(!is_null($subprojects)){
					$nama_subproject = $subprojects[0]->sub_project_name;
				} else {
					$nama_subproject = '--';	
				}

				$department = $this->Department_model->read_department_information($r->department);
				if(!is_null($department)){
					$department_name = $department[0]->department_name;
				} else {
					$department_name = '--';	
				}

				$designation = $this->Designation_model->read_designation_information($r->posisi);
				if(!is_null($designation)){
					$designation_name = $designation[0]->designation_name;
				} else {
					$designation_name = '--';	
				}

			$data[] = array(
				$no,
				$status_migrasi,
				$nik_ktp,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$penempatan,
				$doj,
				$contact_no
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
	

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		// $result = $this->Company_model->read_company_information('2');
		$result = $this->Employees_model->read_employee_request($id);
		$data = array(
				'nik_ktp' => $result[0]->nik_ktp,
				'fullname' => $result[0]->fullname,
				'location_id' => $this->Location_model->read_location_information($result[0]->location_id),
				'project' => $this->Project_model->read_project_information($result[0]->project),
				'sub_project' => $this->Project_model->read_single_subproject($result[0]->sub_project),
				'department' => $this->Department_model->read_department_information($result[0]->department),
				'posisi' => $this->Designation_model->read_designation_information($result[0]->posisi),
				'doj' => $result[0]->doj,
				'contact_no' => $result[0]->contact_no,
				'email' => $result[0]->migrasi,
				'logo' => $result[0]->tgl_migrasi,
				'contact_number' => $result[0]->nip,
				'alamat_ktp' => $result[0]->alamat_ktp,
				'penempatan' => $result[0]->penempatan,

				'waktu_kontrak' => $result[0]->contract_periode.' (Bulan)',
				'begin' => $result[0]->contract_start . ' s/d '. $result[0]->contract_end,
				'hari_kerja' => $result[0]->hari_kerja,
				'basic_pay' => $result[0]->gaji_pokok,
				'dm_allow_grade' => $result[0]->dm_allow_jabatan,
				'allowance_grade' => $result[0]->allow_jabatan,
				'dm_allow_area' => $result[0]->dm_allow_area,
				'allowance_area' => $result[0]->allow_area,
				'dm_allow_masakerja' => $result[0]->dm_allow_masakerja,
				'allowance_masakerja' => $result[0]->allow_masakerja,
				'dm_allow_transmeal' => $result[0]->dm_allow_transmeal,
				'allowance_transmeal' => $result[0]->allow_trans_meal,
				'dm_allow_meal' => $result[0]->dm_allow_konsumsi,
				'allowance_meal' => $result[0]->allow_konsumsi,
				'dm_allow_transport' => $result[0]->dm_allow_transport,
				'allowance_transport' => $result[0]->allow_transport,
				'dm_allow_komunikasi' => $result[0]->dm_allow_comunication,
				'allowance_komunikasi' => $result[0]->allow_comunication,
				'dm_allow_laptop' => $result[0]->dm_allow_device,
				'allowance_laptop' => $result[0]->allow_device,
				'dm_allow_residance' => $result[0]->dm_allow_residance,
				'allowance_residance' => $result[0]->allow_residence_cost,
				'dm_allow_rent' => $result[0]->dm_allow_rent,
				'allowance_rent' => $result[0]->allow_rent,
				'dm_allow_park' => $result[0]->dm_allow_park,
				'allowance_park' => $result[0]->allow_parking,
				'dm_allow_medicine' => $result[0]->dm_allow_medicine,
				'allowance_medicine' => $result[0]->allow_medichine,
				'dm_allow_akomodasi' => $result[0]->dm_allow_akomodasi,
				'allow_akomodsasi' => $result[0]->allow_akomodsasi,
				'dm_allow_kasir' => $result[0]->dm_allow_kasir,
				'allowance_kasir' => $result[0]->allow_kasir,
				'dm_allow_operational' => $result[0]->dm_allow_operational,
				'allow_operational' => $result[0]->allow_operational,
				
				'ktp' => $result[0]->ktp,
				'kk' => $result[0]->kk,
				'skck' => $result[0]->skck,
				'ijazah' => $result[0]->ijazah,
				'info_revisi' => $result[0]->cancel_ket,
				'idrequest' => $result[0]->secid,
				'request_empby' => $this->Employees_model->read_employee_info($result[0]->request_empby),
				'request_empon' => $result[0]->request_empon,
				'approved_naeby' => $this->Employees_model->read_employee_info($result[0]->approved_naeby),
				'approved_naeon' => $result[0]->approved_naeon,
				'approved_nomby' => $this->Employees_model->read_employee_info($result[0]->approved_nomby),
				'approved_nomon' => $result[0]->approved_nomon,
				'approved_hrdby' => $this->Employees_model->read_employee_info($result[0]->approved_hrdby),
				'approved_hrdon' => $result[0]->approved_hrdon,

				// 'createdon' => $result[0]->createdon,
				// 'modifiedon' => $result[0]->modifiedon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_emp_cancel', $data);
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
		


							if($_FILES['document_ktp']['size'] == 0) {$fnamektp=$this->input->post('fktp_name');} else {
								if(is_uploaded_file($_FILES['document_ktp']['tmp_name'])) {
									//checking image type
									$allowedktp =  array('png','jpg','PNG','JPG','jpeg','JPEG');
									$filenamektp = $_FILES['document_ktp']['name'];
									$extktp = pathinfo($filenamektp, PATHINFO_EXTENSION);
									
									if(in_array($extktp,$allowedktp)){
										$tmp_namektp = $_FILES["document_ktp"]["tmp_name"];
										$documentdktp = "uploads/document/ktp/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_ktp"]["name"]);
										$newfilenamektp = 'ktp_'.round(microtime(true)).'.'.$extktp;
										move_uploaded_file($tmp_namektp, $documentdktp.$newfilenamektp);
										$fnamektp = $newfilenamektp;
									} else {
										$Return['error'] = 'Jenis File KTP tidak diterima..';
									}
								}
							}


							if($_FILES['document_kk']['size'] == 0) {$fnamekk=$this->input->post('fkk_name');} else {
								if(is_uploaded_file($_FILES['document_kk']['tmp_name'])) {
									//checking image type
									$allowedkk =  array('png','jpg','PNG','JPG','jpeg','JPEG');
									$filenamekk = $_FILES['document_kk']['name'];
									$extkk = pathinfo($filenamekk, PATHINFO_EXTENSION);
									
									if(in_array($extkk,$allowedkk)){
										$tmp_namekk = $_FILES["document_kk"]["tmp_name"];
										$documentdkk = "uploads/document/kk/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_kk"]["name"]);
										$newfilenamekk = 'kk_'.round(microtime(true)).'.'.$extkk;
										move_uploaded_file($tmp_namekk, $documentdkk.$newfilenamekk);
										$fnamekk = $newfilenamekk;
									} else {
										$Return['error'] = 'Jenis File KK tidak diterima..';
									}
								}
							}

							if($_FILES['document_skck']['size'] == 0) {$fnameskck=$this->input->post('fskck_name');} else {
								if(is_uploaded_file($_FILES['document_skck']['tmp_name'])) {
									//checking image type
									$allowedskck =  array('png','jpg','PNG','JPG','jpeg','JPEG');
									$filenameskck = $_FILES['document_skck']['name'];
									$extskck = pathinfo($filenameskck, PATHINFO_EXTENSION);
									
									if(in_array($extskck,$allowedskck)){
										$tmp_nameskck = $_FILES["document_skck"]["tmp_name"];
										$documentdskck = "uploads/document/skck/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_skck"]["name"]);
										$newfilenameskck = 'skck_'.round(microtime(true)).'.'.$extskck;
										move_uploaded_file($tmp_nameskck, $documentdskck.$newfilenameskck);
										$fnameskck = $newfilenameskck;
									} else {
										$Return['error'] = 'Jenis File SKCK tidak diterima..';
									}
								}
							}

							if($_FILES['document_ijazah']['size'] == 0) {$fnameijazah=$this->input->post('fijz_name');} else {
								if(is_uploaded_file($_FILES['document_ijazah']['tmp_name'])) {
									//checking image type
									$allowedijazah =  array('png','jpg','PNG','JPG','jpeg','JPEG');
									$filenameijazah = $_FILES['document_ijazah']['name'];
									$extijazah = pathinfo($filenameijazah, PATHINFO_EXTENSION);
									
									if(in_array($extijazah,$allowedijazah)){
										$tmp_nameijazah = $_FILES["document_ijazah"]["tmp_name"];
										$documentdijazah = "uploads/document/ijazah/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_ijazah"]["name"]);
										$newfilenameijazah = 'skck_'.round(microtime(true)).'.'.$extijazah;
										move_uploaded_file($tmp_nameijazah, $documentdijazah.$newfilenameijazah);
										$fnameijazah = $newfilenameijazah;
									} else {
										$Return['error'] = 'Jenis File IJAZAH tidak diterima..';
									}
								}
							}


			$data_up = array(
				'ktp'							=> $fnamektp,
				'kk'							=> $fnamekk,
				'skck'						=> $fnameskck,
				'ijazah'					=> $fnameijazah,
				'cancel_stat'			=> 0,
				'verified_by' 			=>  $session['user_id'],
				'verified_date' 			=> date('Y-m-d h:i:s')
			);
			$result = $this->Employees_model->update_request_employee($data_up,$id);

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

}

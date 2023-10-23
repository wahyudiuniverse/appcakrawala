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

class Profile extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Awards_model");
		$this->load->model("Travel_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Project_model");
		$this->load->model("Pkwt_model");
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

		$result = $this->Employees_model->read_employee_information($session['user_id']);

		// $result = $this->Employees_model->read_employee_info_by_nik($id);

		// company info
		$company = $this->Xin_model->read_company_info($result[0]->company_id);
		if(!is_null($company)){
		  $company_name = $company[0]->name;
		} else {
		  $company_name = '--';
		}

		$department = $this->Department_model->read_department_information($result[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}


		$projects = $this->Project_model->read_single_project($result[0]->project_id);
		if(!is_null($projects)){
			$nama_project = $projects[0]->title;
		} else {
			$nama_project = '--';	
		}
			
		$subprojects = $this->Project_model->read_single_subproject($result[0]->sub_project_id);
		if(!is_null($subprojects)){
			$nama_subproject = $projects[0]->title;
		} else {
			$nama_subproject = '--';	
		}



		// get designation
		$designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}

		$data = array(
			'breadcrumbs' => 'My Profile',
			'title' => $this->lang->line('header_my_profile').' | '.$this->Xin_model->site_title(),
			'path_url' => 'profile',
			'user_id' => $result[0]->user_id,
			'username' => $result[0]->username,
			'employee_id' => $result[0]->employee_id,
			'first_name' => strtoupper($result[0]->first_name),
			'tempat_lahir' => $result[0]->tempat_lahir,
			'date_of_birth' => $result[0]->date_of_birth,
			'ibu_kandung' => $result[0]->ibu_kandung,
			'contact_no' => $result[0]->contact_no,
			'ktp_no' => $result[0]->ktp_no,
			'filename_ktp' => $result[0]->filename_ktp,
			'kk_no' => $result[0]->kk_no,
			'filename_kk' => $result[0]->filename_kk,
			'npwp_no' => $result[0]->npwp_no,
			'filename_npwp' => $result[0]->filename_npwp,
			'filename_cv' => $result[0]->filename_cv,
			'filename_skck' => $result[0]->filename_skck,
			'filename_pkwt' => $result[0]->filename_pkwt,
			'filename_isd' => $result[0]->filename_isd,
			'filename_paklaring' => $result[0]->filename_paklaring,
			'bpjs_tk_no' => $result[0]->bpjs_tk_no,
			'bpjs_tk_status' => $result[0]->bpjs_tk_status,
			'bpjs_ks_no' => $result[0]->bpjs_ks_no,
			'bpjs_ks_status' => $result[0]->bpjs_ks_status,
			'nomor_rek' => $result[0]->nomor_rek,
			'filename_rek' => $result[0]->filename_rek,
			'pemilik_rek' => $result[0]->pemilik_rek,
			'bank_name' => $result[0]->bank_name,
			'list_bank' => $this->Xin_model->get_bank_code(),
			'alamat_ktp' => $result[0]->alamat_ktp,
			'alamat_domisili' => $result[0]->alamat_domisili,
			'gender' => $result[0]->gender,
			'ethnicity_type' => $result[0]->ethnicity_type,
			'all_ethnicity' => $this->Xin_model->get_ethnicity_type_result(),
			'blood_group' => $result[0]->blood_group,
			'tinggi_badan' => $result[0]->tinggi_badan,
			'berat_badan' => $result[0]->berat_badan,
			'profile_picture' => $result[0]->profile_picture,
			'email' => $result[0]->email,
			'designation_id' => $result[0]->designation_id,
			'designations' => $designation_name,
			'company_id' => $result[0]->company_id,
			'company_name' => $company_name,
			'department_id' => $result[0]->department_id,
			'department_name' => $department_name,
			'project_id' => $result[0]->project_id,
			'project_name' => $nama_project,
			'sub_project_id' => $result[0]->sub_project_id,
			// 'sub_project_name' => $nama_subproject,
			'date_of_joining' => $result[0]->date_of_joining,
			'penempatan' => $result[0]->penempatan,

			'user_role_id' => $result[0]->user_role_id,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'marital_status' => $result[0]->marital_status,
			'wages_type' => $result[0]->wages_type,
			'is_active' => $result[0]->is_active,

			'contract_start' => $result[0]->contract_start,
			'contract_end' => $result[0]->contract_end,
			'contract_periode' => $result[0]->contract_periode,
			'hari_kerja' => $result[0]->hari_kerja,
			'cut_start' => $result[0]->cut_start,
			'cut_off' => $result[0]->cut_off,
			'date_payment' => $result[0]->date_payment,
			'basic_salary' => $result[0]->basic_salary,
			'allow_jabatan' => $result[0]->allow_jabatan,
			'allow_area' => $result[0]->allow_area,
			'allow_masakerja' => $result[0]->allow_masakerja,
			'allow_trans_meal' => $result[0]->allow_trans_meal,
			'allow_konsumsi' => $result[0]->allow_konsumsi,
			'allow_transport' => $result[0]->allow_transport,
			'allow_comunication' => $result[0]->allow_comunication,
			'allow_device' => $result[0]->allow_device,
			'allow_residence_cost' => $result[0]->allow_residence_cost,
			'allow_rent' => $result[0]->allow_rent,
			'allow_parking' => $result[0]->allow_parking,
			'allow_medichine' => $result[0]->allow_medichine,
			
			'allow_akomodsasi' => $result[0]->allow_akomodsasi,
			'allow_kasir' => $result[0]->allow_kasir,
			'allow_operational' => $result[0]->allow_operational,
			
			'status_employee' => $result[0]->status_employee,
			'deactive_by' => $result[0]->deactive_by,
			'deactive_date' => $result[0]->deactive_date,
			'deactive_reason' => $result[0]->deactive_reason,

			);
		// $data['breadcrumbs'] = 'My Profile';
		// $data['path_url'] = 'profile';

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/employees/profile", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('hr/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 	
	/*  add and update employee details info */	
	// Validate and update info in database // basic info
	public function user_basic_info() {
	
		if($this->input->post('type')=='basic_info') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		// $first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
		// $last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
		// $date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
		// $contact_no = $this->Xin_model->clean_date_post($this->input->post('contact_no'));
		// $address = $this->Xin_model->clean_date_post($this->input->post('address'));
			
		/* Server side PHP input validation */		
		if($this->input->post('first_name')==='') {
      $Return['error'] = 'Nama Legnkap Kosong';
		} else if($this->input->post('tempat_lahir')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_tempat_lahir');
		} else if($this->input->post('tanggal_lahir')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
		} else if($this->Xin_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('ibu_kandung')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_ibu_kandung');
		} else if($this->input->post('no_kontak')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		} else if($this->input->post('email')==='') {
			 $Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('ktp_no')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_ktp');
		} else if($this->input->post('kk_no')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_nomor_kk');
		} else if($this->input->post('alamat_ktp')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_alamat_ktp');
		} else if($this->input->post('gender')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_jenis_kelamin');
		} else if($this->input->post('marital_status')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_status_pernikahan');
		}

		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'first_name' => $this->input->post('first_name'),
		'tempat_lahir' => $this->input->post('tempat_lahir'),
		'date_of_birth' => $this->input->post('tanggal_lahir'),
		'ibu_kandung' => $this->input->post('ibu_kandung'),
		'contact_no' => $this->input->post('no_kontak'),
		'email' => $this->input->post('email'),
		'ktp_no' => $this->input->post('ktp_no'),
		'kk_no' => $this->input->post('kk_no'),
		'npwp_no' => $this->input->post('npwp_no'),
		'alamat_ktp' => $this->input->post('alamat_ktp'),
		'alamat_domisili' => $this->input->post('alamat_domisili'),
		'gender' => $this->input->post('gender'),
		'ethnicity_type' => $this->input->post('ethnicity'),
		'marital_status' => $this->input->post('marital_status'),
		'blood_group' => $this->input->post('blood_group'),
		'tinggi_badan' => $this->input->post('tinggi_badan'),
		'berat_badan' => $this->input->post('berat_badan'),

		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function grade() {
	
		if($this->input->post('type')=='grade_info') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('penempatan')==='') {
      $Return['error'] = 'Penempatan Kosong';
		} else if($this->input->post('project_id')==='') {
			$Return['error'] = 'PROJECT masih kosong...';
		} else if($this->input->post('company_id')==='') {
			 $Return['error'] = 'COMPANY masih kosong';
		} else if($this->input->post('sub_project_id')==='') {
			 $Return['error'] = 'SUB PROJECT masih kosong';
		} 


		if($Return['error']!='') {
       		$this->output($Return);
    	}
	
		$data = array(
		// 'penempatan' => $this->input->post('penempatan'),
		// 'date_of_joining' => $this->input->post('tanggal_bergabung'),
		// 'designation_id' => $this->input->post('designation_id'),
		// 'project_id' => $this->input->post('project_id'),
		// 'company_id' => $this->input->post('company_id'),
		// 'sub_project_id' => $this->input->post('sub_project_id'),
		);

		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = 'Berhasil Diubah';
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}



	// Validate and add info in database // document info
	public function document_info() {
	
	
		if($this->input->post('type')=='document_info') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			// if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {		
			// /* Define return | here result is used to return user data and error for error message */
			// $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			// $Return['csrf_hash'] = $this->security->get_csrf_hash();
				
			/* Server side PHP input validation */		
			if($this->input->post('nomor_ktp')==='') {
				 $Return['error'] = 'Nomor KTP Kosong..!';
			}
		
			else if ($_FILES['document_file']['size'] > 2000000){
				$Return['error'] = 'File KTP Lebih dari 2MB	..';
			}

			else if ($_FILES['document_file_kk']['size'] > 2000000){
				$Return['error'] = 'File KK Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_npwp']['size'] > 2000000){
				$Return['error'] = 'File NPWP Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_cv']['size'] > 2000000){
				$Return['error'] = 'File CV Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_skck']['size'] > 2000000){
				$Return['error'] = 'File SKCK Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_isd']['size'] > 2000000){
				$Return['error'] = 'File IJAZAH Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_pak']['size'] > 2000000){
				$Return['error'] = 'File PAKLARING Lebih dari 2MB..';
			}

			else if ($_FILES['document_file_pkwt']['size'] > 2000000){
				$Return['error'] = 'File PKWT Lebih dari 2MB..';
			}

			else {
							// if($_FILES['document_file']['size'] > 2000000){
							// 	$Return['error'] = 'File PKWT Lebih dari 2MB..';
							// } else {

								if($_FILES['document_file']['size'] == 0) {
									$fname = $this->input->post('ffoto_ktp');
								} else {
									if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
										//checking image type
										$allowed =  array('png','jpg','jpeg','PNG','JPG','JPEG');
										$filename = $_FILES['document_file']['name'];
										$ext = pathinfo($filename, PATHINFO_EXTENSION);
										
										if(in_array($ext,$allowed)){
											$tmp_name = $_FILES["document_file"]["tmp_name"];
											$documentd = "uploads/document/ktp/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file"]["name"]);
											$newfilename = 'ktp_'.round(microtime(true)).'.'.$ext;
											move_uploaded_file($tmp_name, $documentd.$newfilename);
											$fname = $newfilename;
										} else {
											$Return['error'] = 'Jenis File KTP tidak diterima..';
										}
									}
								}
							// }

								if($_FILES['document_file_kk']['size'] == 0) {
									$fname_kk = $this->input->post('ffoto_kk');
								} else {
									if(is_uploaded_file($_FILES['document_file_kk']['tmp_name'])) {
										//checking image type
										$allowedkk =  array('png','jpg','jpeg','PNG','JPG','JPEG');
										$filenamekk = $_FILES['document_file_kk']['name'];
										$extkk = pathinfo($filenamekk, PATHINFO_EXTENSION);
										
										if(in_array($extkk,$allowedkk)){
											$tmp_namekk = $_FILES["document_file_kk"]["tmp_name"];
											$documentdkk = "uploads/document/kk/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_kk"]["name"]);
											$newfilenamekk = 'kk_'.round(microtime(true)).'.'.$extkk;
											move_uploaded_file($tmp_namekk, $documentdkk.$newfilenamekk);
											$fname_kk = $newfilenamekk;
										} else {
											$Return['error'] = 'Jenis File KK tidak diterima..';
										}
									}
								}


								if($_FILES['document_file_npwp']['size'] == 0) {
									$fname_npwp = $this->input->post('ffoto_npwp');
								} else {
									if(is_uploaded_file($_FILES['document_file_npwp']['tmp_name'])) {
										//checking image type
										$allowed_npwp =  array('png','jpg','jpeg','PNG','JPG','JPEG');
										$filename_npwp = $_FILES['document_file_npwp']['name'];
										$ext_npwp = pathinfo($filename_npwp, PATHINFO_EXTENSION);
										
										if(in_array($ext_npwp,$allowed_npwp)){
											$tmp_name_npwp = $_FILES["document_file_npwp"]["tmp_name"];
											$documentd_npwp = "uploads/document/npwp/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_npwp"]["name"]);
											$newfilename_npwp = 'npwp_'.round(microtime(true)).'.'.$ext_npwp;
											move_uploaded_file($tmp_name_npwp, $documentd_npwp.$newfilename_npwp);
											$fname_npwp = $newfilename_npwp;
										} else {
											$Return['error'] = 'Jenis File NPWP tidak diterima..';
										}
									}
								}

								if($_FILES['document_file_cv']['size'] == 0) {
									$fname_cv = $this->input->post('ffile_cv');
								} else {
									if(is_uploaded_file($_FILES['document_file_cv']['tmp_name'])) {
										//checking image type
										$allowed_cv =  array('pdf','PDF');
										$filename_cv = $_FILES['document_file_cv']['name'];
										$ext_cv = pathinfo($filename_cv, PATHINFO_EXTENSION);
										
										if(in_array($ext_cv,$allowed_cv)){
											$tmp_name_cv = $_FILES["document_file_cv"]["tmp_name"];
											$yearmonth = date('Y/m');
											$documentd_cv = "uploads/document/cv/".$yearmonth.'/';
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_cv"]["name"]);
											$newfilename_cv = 'cv_'.$this->input->post('nomor_ktp').'_'.round(microtime(true)).'.'.$ext_cv;
											move_uploaded_file($tmp_name_cv, $documentd_cv.$newfilename_cv);
											$fname_cv = 'https://apps-cakrawala.com/uploads/document/cv/'.$yearmonth.'/'.$newfilename_cv;
										} else {
											$Return['error'] = 'Jenis File CV tidak diterima..';
										}
									}
								}

								if($_FILES['document_file_skck']['size'] == 0) {
									$fname_skck = $this->input->post('ffile_skck');
								} else {
									if(is_uploaded_file($_FILES['document_file_skck']['tmp_name'])) {
										//checking image type
										$allowed_skck =  array('pdf','PDF');
										$filename_skck = $_FILES['document_file_skck']['name'];
										$ext_skck = pathinfo($filename_skck, PATHINFO_EXTENSION);
										
										if(in_array($ext_skck,$allowed_skck)){
											$tmp_name_skck = $_FILES["document_file_skck"]["tmp_name"];
											$documentd_skck = "uploads/document/skck/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_skck"]["name"]);
											$newfilename_skck = 'skck_'.round(microtime(true)).'.'.$ext_skck;
											move_uploaded_file($tmp_name_skck, $documentd_skck.$newfilename_skck);
											$fname_skck = $newfilename_skck;
										} else {
											$Return['error'] = 'Jenis File SKCK tidak diterima..';
										}
									}
								}

								if($_FILES['document_file_isd']['size'] == 0) {
									$fname_isd = $this->input->post('ffile_isd');
								} else {
									if(is_uploaded_file($_FILES['document_file_isd']['tmp_name'])) {
										//checking image type
										$allowed_isd =  array('pdf','PDF');
										$filename_isd = $_FILES['document_file_isd']['name'];
										$ext_isd = pathinfo($filename_isd, PATHINFO_EXTENSION);
										
										if(in_array($ext_isd,$allowed_isd)){
											$tmp_name_isd = $_FILES["document_file_isd"]["tmp_name"];
											$documentd_isd = "uploads/document/ijazah/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_isd"]["name"]);
											$newfilename_isd = 'isd_'.round(microtime(true)).'.'.$ext_isd;
											move_uploaded_file($tmp_name_isd, $documentd_isd.$newfilename_isd);
											$fname_isd = $newfilename_isd;
										} else {
											$Return['error'] = 'Jenis File IJAZAH SD tidak diterima..';
										}
									}
								}

								if($_FILES['document_file_pak']['size'] == 0) {
									$fname_pak = $this->input->post('ffile_pak');
								} else {
									if(is_uploaded_file($_FILES['document_file_pak']['tmp_name'])) {
										//checking image type
										$allowed_pak =  array('pdf','PDF');
										$filename_pak = $_FILES['document_file_pak']['name'];
										$ext_pak = pathinfo($filename_pak, PATHINFO_EXTENSION);
										
										if(in_array($ext_pak,$allowed_pak)){
											$tmp_name_pak = $_FILES["document_file_pak"]["tmp_name"];
											$documentd_pak = "uploads/document/paklaring/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_pak"]["name"]);
											$newfilename_pak = 'pak_'.round(microtime(true)).'.'.$ext_pak;
											move_uploaded_file($tmp_name_pak, $documentd_pak.$newfilename_pak);
											$fname_pak = $newfilename_pak;
										} else {
											$Return['error'] = 'Jenis File PAKLARING tidak diterima..';
										}
									}
								}

								if($_FILES['document_file_pkwt']['size'] == 0) {
									$fname_pkwt = $this->input->post('ffile_pkwt');
								} else {
									if(is_uploaded_file($_FILES['document_file_pkwt']['tmp_name'])) {
										//checking image type
										$allowed_pkwt =  array('pdf','PDF');
										$filename_pkwt = $_FILES['document_file_pkwt']['name'];
										$ext_pkwt = pathinfo($filename_pkwt, PATHINFO_EXTENSION);
										
										if(in_array($ext_pkwt,$allowed_pkwt)){
											$tmp_name_pkwt = $_FILES["document_file_pkwt"]["tmp_name"];
											$documentd_pkwt = "uploads/document/pkwt/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_pkwt"]["name"]);
											$newfilename_pkwt = 'pkwt_'.round(microtime(true)).'.'.$ext_pkwt;
											move_uploaded_file($tmp_name_pkwt, $documentd_pkwt.$newfilename_pkwt);
											$fname_pkwt = $newfilename_pkwt;
										} else {
											$Return['error'] = 'Jenis File PKWT tidak diterima..';
										}
									}
								}


				//clean simple fields
				$nomor_ktp = $this->Xin_model->clean_post($this->input->post('nomor_ktp'));
				$kk_no = $this->Xin_model->clean_post($this->input->post('kk_no'));
				$npwp_no = $this->Xin_model->clean_post($this->input->post('npwp_no'));
				// $no_bpjstk = $this->Xin_model->clean_post($this->input->post('no_bpjstk'));
				// $bpjstk_confirm = $this->Xin_model->clean_post($this->input->post('bpjstk_confirm'));
				// $no_bpjsks = $this->Xin_model->clean_post($this->input->post('no_bpjsks'));
				// $bpjsks_confirm = $this->Xin_model->clean_post($this->input->post('bpjsks_confirm'));
				// clean date fields
				// $date_of_expiry = $this->Xin_model->clean_date_post($this->input->post('date_of_expiry'));
				// $document_type = $this->input->post('document_type_id');

				$data = array(

				'ktp_no' 				=> $nomor_ktp,
				'kk_no' 				=> $kk_no,
				'npwp_no' 			=> $npwp_no,

				'filename_ktp' 	=> $fname,
				'filename_kk' 	=> $fname_kk,
				'filename_npwp' => $fname_npwp,
				'filename_cv' 	=> $fname_cv,
				'filename_skck' => $fname_skck,
				'filename_isd' 	=> $fname_isd,
				'filename_paklaring' => $fname_pak,
				'filename_pkwt' => $fname_pkwt

				);

				$id = $this->input->post('user_id');
				// $result = $this->Employees_model->document_info_add($data);
				$result = $this->Employees_model->basic_info($data,$id);

			}

			if($Return['error']!=''){
					$this->output($Return);
	    }


			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_d_info_added');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}

			$this->output($Return);
			exit;
		}
	}
	


	public function dialog_contact() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_contact_information($id);
		$data = array(
				'contact_id' => $result[0]->contact_id,
				'employee_id' => $result[0]->employee_id,
				'relation' => $result[0]->relation,
				'is_primary' => $result[0]->is_primary,
				'is_dependent' => $result[0]->is_dependent,
				'contact_name' => $result[0]->contact_name,
				'work_phone' => $result[0]->work_phone,
				'work_phone_extension' => $result[0]->work_phone_extension,
				'mobile_phone' => $result[0]->mobile_phone,
				'home_phone' => $result[0]->home_phone,
				'work_email' => $result[0]->work_email,
				'personal_email' => $result[0]->personal_email,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'country' => $result[0]->country,
				'all_countries' => $this->Xin_model->get_countries()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}

	 // employee contacts - listing
	public function contacts()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$contacts = $this->Employees_model->set_employee_contacts($id);
		
		$data = array();

        foreach($contacts->result() as $r) {
			
			if($r->is_primary==1){
				$primary = '<span class="badge badge-success">'.$this->lang->line('xin_employee_primary').'</span>';
			 } else {
				 $primary = '';
			 }
			 if($r->is_dependent==2){
				$dependent = '<span class="badge badge-red">'.$this->lang->line('xin_employee_dependent').'</span>';
			 } else {
				 $dependent = '';
			 }
			 		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->contact_id . '" data-field_type="contact"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contact_id . '" data-token_type="contact"><i class="fas fa-trash-restore"></i></button></span>',
			$r->contact_name . ' ' .$primary . ' '.$dependent,
			$r->relation,
			$r->work_email,
			$r->mobile_phone
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contacts->num_rows(),
			 "recordsFiltered" => $contacts->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee documents - listing
	public function documents() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		// $documents = $this->Employees_model->set_employee_documents($id);
		
		$data = array();

    // foreach($documents->result() as $r) {
			
		// 	$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
		// 	if(!is_null($d_type)){
		// 		$document_d = $d_type[0]->document_type;
		// 	} else {
		// 		$document_d = '--';
		// 	}

		// 	$date_of_expiry = $this->Xin_model->set_date_format($r->date_of_expiry);
		// 	if($r->document_file!='' && $r->document_file!='no file') {
		// 	 $functions = '';
		// 	 } else {
		// 		 $functions ='';
		// 	 }
		
			$data[] = array(
				'-',
				'-',
				'-',
				'-',
				'-'
			);
    // }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 

	// employee qualification - listing
	public function qualification() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$qualification = $this->Employees_model->set_employee_qualification($id);
		
		$data = array();

        foreach($qualification->result() as $r) {
			
			$education = $this->Employees_model->read_education_information($r->education_level_id);
			if(!is_null($education)){
				$edu_name = $education[0]->name;
			} else {
				$edu_name = '--';	
			}
			$language = $this->Employees_model->read_qualification_language_information($r->language_id);
			if(!is_null($language)){
				$language_name = $language[0]->name;
			} else {
				$language_name = '--';	
			}
			$skill = $this->Employees_model->read_qualification_skill_information($r->skill_id);
			if(!is_null($skill)){
				$skill_name = $skill[0]->name;
			} else {
				$skill_name = '--';	
			}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fas fa-trash-restore-o"></i></button></span>',
			$r->name,
			$r->from_year,
			$r->to_year,
			$edu_name,
			$language_name,
			$skill_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $qualification->num_rows(),
			 "recordsFiltered" => $qualification->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee work experience - listing
	public function experience() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$experience = $this->Employees_model->set_employee_experience($id);
		
		$data = array();

        foreach($experience->result() as $r) {
			
			$from_date = $this->Xin_model->set_date_format($r->from_date);
			$to_date = $this->Xin_model->set_date_format($r->to_date);
			
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->work_experience_id . '" data-field_type="work_experience"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->work_experience_id . '" data-token_type="work_experience"><i class="fas fa-trash-restore-o"></i></button></span>',
			$r->company_name,
			$from_date,
			$to_date,
			$r->post,
			$r->description
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $experience->num_rows(),
			 "recordsFiltered" => $experience->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee bank account - listing

	public function bank_account_info() {
	
		if($this->input->post('type')=='bank_account_info') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('no_rek')==='') {
      $Return['error'] = 'Nomor Rekening Kosong...!';
		} 
	

				if ($_FILES['docfile_rek']['size'] > 2000000){
					$Return['error'] = 'Ukuran File Lebih dari 2 MB..!';
				} else {
					if(is_uploaded_file($_FILES['docfile_rek']['tmp_name'])) {
						//checking image type
						$alloweda =  array('png','jpg','jpeg','PNG','JPG','JPEG');
						$filenamea = $_FILES['docfile_rek']['name'];
						$exta = pathinfo($filenamea, PATHINFO_EXTENSION);
						
						if(in_array($exta,$alloweda)){
							$tmp_namea = $_FILES["docfile_rek"]["tmp_name"];
							$documentda = "uploads/document/rekening/";
							// basename() may prevent filesystem traversal attacks;
							// further validation/sanitation of the filename may be appropriate
							$name = basename($_FILES["docfile_rek"]["name"]);
							$newfilenamea = 'rekening_'.round(microtime(true)).'.'.$exta;
							move_uploaded_file($tmp_namea, $documentda.$newfilenamea);
							$fname_rek = $newfilenamea;
						} else {
							$Return['error'] = 'Jenis File bukan Image (PNG, JPG, JPEG)';
						}
					} else {
						$fname_rek = $this->input->post('ffoto_rek');
					}
				} 




					// 	if(is_uploaded_file($_FILES['document_file_rek']['tmp_name'])) {
					// 	//checking image type
					// 	$allowed_rek =  array('png','jpg','jpeg','pdf','gif','txt','pdf');
					// 	$filename_rek = $_FILES['document_file_rek']['name'];
					// 	$ext_rek = pathinfo($filename_rek, PATHINFO_EXTENSION);
						
					// 	if(in_array($ext_rek,$allowed_rek)){
					// 		$tmp_name_rek = $_FILES["document_file_rek"]["tmp_name"];
					// 		$documentd_rek = "uploads/document/";
					// 		// basename() may prevent filesystem traversal attacks;
					// 		// further validation/sanitation of the filename may be appropriate
					// 		$name = basename($_FILES["document_file_rek"]["name"]);
					// 		$newfilename_rek = 'rek_'.round(microtime(true)).'.'.$ext_rek;
					// 		move_uploaded_file($tmp_name_rek, $documentd_rek.$newfilename_rek);
					// 		$fname_rek = $newfilename_rek;
					// 	} else {
					// 		$Return['error'] = 'Jenis File Foto Rekening tidak diterima..';
					// 	}
					// }

		if($Return['error']!='') {
       		$this->output($Return);
    	}
	
		$data = array(
			'nomor_rek' => $this->input->post('no_rek'),
			'bank_name' => $this->input->post('bank_name'),
			'pemilik_rek' => $this->input->post('pemilik_rek'),
			'filename_rek' => $fname_rek,

		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = 'Berhasil Diubah x';
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// employee contract - listing
	public function contract() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else { 
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$contract = $this->Employees_model->set_employee_contract($session['employee_id']);

		$data = array();

        foreach($contract->result() as $r) {			
			// designation
			$projects = $this->Project_model->read_single_project($r->project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}

			$designation = $this->Designation_model->read_designation_information($r->jabatan);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

				if($r->file_name==NULL || $r->file_name== '0' ){
			  	$status_upload = '<button type="button" class="btn btn-xs btn-outline-warning" style="background: #FFD950;color: black;">Blum Upload</button>';
				} else {
			  	$status_upload = '<button type="button" class="btn btn-xs btn-outline-success" style="background: #5DD2A6;color: black;">Sudah Upload</button>';
				}
		

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '" >UPLOAD</button>';


		$data[] = array(
			$r->no_surat,
			$nama_project,
			$designation_name,
			$status_upload.' '.$status_migrasi
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contract->num_rows(),
			 "recordsFiltered" => $contract->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	 
	// employee leave - listing
	public function leave() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$leave = $this->Employees_model->set_employee_leave($id);
		
		$data = array();

        foreach($leave->result() as $r) {			
			// contract
			$contract = $this->Employees_model->read_contract_information($r->contract_id);
			if(!is_null($contract)){
				// contract duration
				$duration = $this->Xin_model->set_date_format($contract[0]->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($contract[0]->to_date);
				$ctitle = $contract[0]->title.' '.$duration;
			} else {
				$ctitle = '--';
			}
			
			$contracti = $ctitle;
			
		
		$data[] = array(
			$contracti,
			$r->casual_leave,
			$r->medical_leave
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $leave->num_rows(),
			 "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

			$id = $this->input->get('company_id');

				$emp = $this->Pkwt_model->get_single_pkwt($id);
				if(!is_null($emp)){
					$no_surat 		= $emp[0]->no_surat;
					$nip 			= $emp[0]->employee_id;
					$file_name 		= $emp[0]->file_name;
					$contract_id 		= $emp[0]->contract_id;
					$upload_pkwt 	= $emp[0]->upload_pkwt;
				} else {
					$no_surat 		= '0';	
					$nip 			= '0';	
					$file_name 		= '0';	
					$contract_id 		= '0';	
					$upload_pkwt 	= '0';
				}


		$data = array(
				'nip' => $nip,
				'file_name' => $file_name,
				'idrequest' => $id,
				'no_surat' => $no_surat,
				'contract_id' => $contract_id,
				'tgl_upload_pkwt' => $upload_pkwt
				);

			$this->load->view('admin/employees/dialog_profile_pkwt.php', $data);


		// $this->load->view('admin/pkwt/dialog_pkwt_approve_hrd', $data);
	}


	// Validate and update info in database
	public function updatepkwt() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		if($this->input->post('edit_type')=='company') {

		$id = $this->uri->segment(4);
	
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if ($_FILES['document_file_pkwt']['size'] > 3072000){
				$Return['error'] = 'File PKWT Lebih dari 3MB..';
			}



								if($_FILES['document_file_pkwt']['size'] == 0) {
									$fname_pkwt = $this->input->post('ffile_pkwt');
								} else {
									if(is_uploaded_file($_FILES['document_file_pkwt']['tmp_name'])) {
										//checking image type
										$allowed_pkwt =  array('pdf','PDF');
										$filename_pkwt = $_FILES['document_file_pkwt']['name'];
										$ext_pkwt = pathinfo($filename_pkwt, PATHINFO_EXTENSION);
										
										if(in_array($ext_pkwt,$allowed_pkwt)){
											$tmp_name_pkwt = $_FILES["document_file_pkwt"]["tmp_name"];
											$yearmonth = date('Y/m');
											$documentd_pkwt = "uploads/document/pkwt/".$yearmonth.'/';
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_file_pkwt"]["name"]);
											$newfilename_pkwt = 'pkwt_'.round(microtime(true)).'.'.$ext_pkwt;
											move_uploaded_file($tmp_name_pkwt, $documentd_pkwt.$newfilename_pkwt);
											$fname_pkwt = 'https://apps-cakrawala.com/uploads/document/pkwt/'.$yearmonth.'/'.$newfilename_pkwt;
										} else {
											$Return['error'] = 'Jenis File PKWT tidak diterima..';
										}
									}
								}

				$data_up = array(

					'file_name' 	=> $fname_pkwt,
					'upload_pkwt' => date('d-m-Y h:i:s')

				);



			$result = $this->Pkwt_model->update_pkwt_edit($data_up,$id);

		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {
			$Return['result'] = 'Dokumen PKWT berhasil disimpan...';
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}

		$this->output($Return);
		exit;
		}
	}

	// employee office shift - listing
	public function shift() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/profile", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$shift = $this->Employees_model->set_employee_shift($id);
		
		$data = array();

        foreach($shift->result() as $r) {			
			// contract
			$shift_info = $this->Employees_model->read_shift_information($r->shift_id);
			// contract duration
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			if(!is_null($shift_info)){
				$shift_name = $shift_info[0]->shift_name;
			} else {
				$shift_name = '--';
			}
		
		$data[] = array(
			$duration,
			$shift_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $shift->num_rows(),
			 "recordsFiltered" => $shift->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
}
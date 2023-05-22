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

class Profile_emp extends MY_Controller {
	
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
		$this->load->model("Payroll_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
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

		// $company_id = $this->uri->segment(4);
		$ids = $_GET['id'];
		// $department_id = $this->uri->segment(5);

		$result = $this->Employees_model->read_employee_information($ids);

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
			$edesignation_name = $designation[0]->designation_name;
		} else {
			$edesignation_name = '--';	
		}

		$data = array(
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
			'nomor_rek' => $result[0]->nomor_rek,
			'filename_rek' => $result[0]->filename_rek,
			'pemilik_rek' => $result[0]->pemilik_rek,
			'bank_name' => $result[0]->bank_name,
			'alamat_ktp' => $result[0]->alamat_ktp,
			'list_bank' => $this->Xin_model->get_bank_code(),
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
			'designation' => $edesignation_name,
			'company_name' => $company_name,
			'department_id' => $result[0]->department_id,
			'department_name' => $department_name,
			'project_id' => $result[0]->project_id,
			'project_name' => $nama_project,
			'sub_project_id' => $result[0]->sub_project_id,
			'sub_project_name' => $nama_subproject,
			'penempatan' => $result[0]->penempatan,

			'user_role_id' => $result[0]->user_role_id,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'marital_status' => $result[0]->marital_status,
			'wages_type' => $result[0]->wages_type,
			'basic_salary' => $result[0]->basic_salary,
			'is_active' => $result[0]->is_active,
			'date_of_joining' => $result[0]->date_of_joining,
			'all_departments' => $this->Department_model->all_departments(),
			'all_designations' => $this->Designation_model->all_designations(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('header_my_profile').' | '.$this->Xin_model->site_title(),
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'last_login_date' => $result[0]->last_login_date,
			'last_login_date' => $result[0]->last_login_date,
			'last_login_ip' => $result[0]->last_login_ip,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_document_types_ready' => $this->Employees_model->all_document_types_ready($result[0]->user_id),
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_contracts' => $this->Employees_model->all_contracts(),
			'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			'all_office_locations' => $this->Location_model->all_office_locations(),
			'all_leave_types' => $this->Timesheet_model->all_leave_types()
			);
		$data['breadcrumbs'] = 'Profile Karyawan';
		$data['path_url'] = 'profile';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/employees/profile_emp", $data, TRUE);
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
      $Return['error'] = $this->lang->line('xin_employee_error_first_name');
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
	
	// Validate and add info in database // document info
	public function document_info() {
	
		if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('title')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		} else if($_FILES['document_file']['size'] == 0) {
			$fname = $this->input->post('ffoto_ktp');
			// $fname = '';
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
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
				

		/* Check if file uploaded..*/
		if($_FILES['document_file_kk']['size'] == 0) {
			$fname_kk = $this->input->post('ffoto_kk');
			// $fname_kk = '';
		} else {
			if(is_uploaded_file($_FILES['document_file_kk']['tmp_name'])) {
				//checking image type
				$allowed_kk =  array('png','jpg','jpeg','pdf','gif','txt','pdf');
				$filename_kk = $_FILES['document_file_kk']['name'];
				$ext_kk = pathinfo($filename_kk, PATHINFO_EXTENSION);
				
				if(in_array($ext_kk,$allowed_kk)){
					$tmp_name_kk = $_FILES["document_file_kk"]["tmp_name"];
					$documentd_kk = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file_kk"]["name"]);
					$newfilename_kk = 'kk_'.round(microtime(true)).'.'.$ext_kk;
					move_uploaded_file($tmp_name_kk, $documentd_kk.$newfilename_kk);
					$fname_kk = $newfilename_kk;
				} else {
					$Return['error'] = 'Jenis File KK tidak diterima..';
				}
			}
		}

		/* Check if file uploaded..*/
		if($_FILES['document_file_npwp']['size'] == 0) {
			$fname_npwp = $this->input->post('ffoto_npwp');
			// $fname_kk = '';
		} else {
			if(is_uploaded_file($_FILES['document_file_npwp']['tmp_name'])) {
				//checking image type
				$allowed_npwp =  array('png','jpg','jpeg','pdf','gif','txt','pdf');
				$filename_npwp = $_FILES['document_file_npwp']['name'];
				$ext_npwp = pathinfo($filename_npwp, PATHINFO_EXTENSION);
				
				if(in_array($ext_npwp,$allowed_npwp)){
					$tmp_name_npwp = $_FILES["document_file_npwp"]["tmp_name"];
					$documentd_npwp = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file_npwp"]["name"]);
					$newfilename_npwp = 'npwp_'.round(microtime(true)).'.'.$ext_npwp;
					move_uploaded_file($tmp_name_npwp, $documentd_npwp.$newfilename_npwp);
					$fname_npwp = $newfilename_npwp;
				} else {
					$Return['error'] = 'Jenis File KK tidak diterima..';
				}
			}
		}

		if($Return['error']!=''){
       		$this->output($Return);
    	}

		//clean simple fields
		$title = $this->Xin_model->clean_post($this->input->post('title'));
		$kk_no = $this->Xin_model->clean_post($this->input->post('kk_no'));
		$npwp_no = $this->Xin_model->clean_post($this->input->post('npwp_no'));
		$no_bpjstk = $this->Xin_model->clean_post($this->input->post('no_bpjstk'));
		$bpjstk_confirm = $this->Xin_model->clean_post($this->input->post('bpjstk_confirm'));
		$no_bpjsks = $this->Xin_model->clean_post($this->input->post('no_bpjsks'));
		$bpjsks_confirm = $this->Xin_model->clean_post($this->input->post('bpjsks_confirm'));
		// clean date fields
		// $date_of_expiry = $this->Xin_model->clean_date_post($this->input->post('date_of_expiry'));
		// $document_type = $this->input->post('document_type_id');

		$data = array(

		'ktp_no' 				=> $title,
		'filename_ktp' 	=> $fname,
		'kk_no' 				=> $kk_no,
		'filename_kk' 	=> $fname_kk,
		'npwp_no' 			=> $npwp_no,
		'filename_npwp' => $fname_npwp,
		'bpjs_tk_no' => $no_bpjstk,
		'bpjs_tk_status' => $bpjstk_confirm,
		'bpjs_ks_no' => $no_bpjsks,
		'bpjs_ks_status' => $bpjsks_confirm,

		);

		$id = $this->input->post('user_id');
		// $result = $this->Employees_model->document_info_add($data);
		$result = $this->Employees_model->basic_info($data,$id);

		if ($result == TRUE) {

				$Return['result'] = $this->lang->line('xin_employee_d_info_added');

		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // bank account info
	public function bank_account_info() {
			
			if($this->input->post('type')=='bank_account_info' && $this->input->post('data')=='bank_account_info') {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

				/* Server side PHP input validation */		
				if($this->input->post('no_rek')==='') {
					 $Return['error'] = $this->lang->line('xin_employee_error_nomor_rek');
				} else if ($this->input->post('bank_name')===''){
					 $Return['error'] = $this->lang->line('xin_employee_error_bank_name');
				} else if ($this->input->post('pemilik_rek')===''){
					 $Return['error'] = $this->lang->line('xin_employee_error_pemilik_rek');
				} else if($_FILES['document_file_rek']['size'] == 0) {
					$fname_rek = $this->input->post('ffoto_rek');
					// $fname = '';
				} else {
					if(is_uploaded_file($_FILES['document_file_rek']['tmp_name'])) {
						//checking image type
						$allowed_rek =  array('png','jpg','jpeg','pdf','gif','txt','pdf');
						$filename_rek = $_FILES['document_file_rek']['name'];
						$ext_rek = pathinfo($filename_rek, PATHINFO_EXTENSION);
						
						if(in_array($ext_rek,$allowed_rek)){
							$tmp_name_rek = $_FILES["document_file_rek"]["tmp_name"];
							$documentd_rek = "uploads/document/";
							// basename() may prevent filesystem traversal attacks;
							// further validation/sanitation of the filename may be appropriate
							$name = basename($_FILES["document_file_rek"]["name"]);
							$newfilename_rek = 'rek_'.round(microtime(true)).'.'.$ext_rek;
							move_uploaded_file($tmp_name_rek, $documentd_rek.$newfilename_rek);
							$fname_rek = $newfilename_rek;
						} else {
							$Return['error'] = 'Jenis File Foto Rekening tidak diterima..';
						}
					}
				}
					
				if($Return['error']!=''){
		       		$this->output($Return);
		    	}
			
				$data = array(
				'bank_name' => $this->input->post('bank_name'),
				'nomor_rek' => $this->input->post('no_rek'),
				'pemilik_rek' => $this->input->post('pemilik_rek'),
				'filename_rek' => $fname_rek,
				);

				$id = $this->input->post('user_id');
				// $result = $this->Employees_model->bank_account_info_add($data);
				$result = $this->Employees_model->basic_info($data,$id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_error_bank_info_added');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}
	
	// Validate and add info in database // e_document info
	public function e_document_info() {
	 
		if($this->input->post('type')=='e_document_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($this->input->post('title')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['document_file']['size'] == 0) {
			$data = array(
				'document_type_id' => $this->input->post('document_type_id'),
				'date_of_expiry' => $this->input->post('date_of_expiry'),
				'title' => $this->input->post('title'),
				//'notification_email' => $this->input->post('email'),
				//'is_alert' => $this->input->post('send_mail'),
				'description' => $this->input->post('description')
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Employees_model->document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
					$data = array(
					'document_type_id' => $this->input->post('document_type_id'),
					'date_of_expiry' => $this->input->post('date_of_expiry'),
					'document_file' => $fname,
					'title' => $this->input->post('title'),
					//'notification_email' => $this->input->post('email'),
					//'is_alert' => $this->input->post('send_mail'),
					'description' => $this->input->post('description')
					);
					$e_field_id = $this->input->post('e_field_id');
					$result = $this->Employees_model->document_info_update($data,$e_field_id);
					if ($result == TRUE) {
						$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
					$this->output($Return);
					exit;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
					
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
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
	
	/*  add and update employee details info */	
	// Validate and update info in database // basic info
	public function grade() {
	
		if($this->input->post('type')=='grade_info') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		// $first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
		// $last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
		// $date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
		// $contact_no = $this->Xin_model->clean_date_post($this->input->post('contact_no'));
		// $address = $this->Xin_model->clean_date_post($this->input->post('address'));
			
		/* Server side PHP input validation */		
		if($this->input->post('penempatan')==='') {
      $Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} 
		// else if($this->input->post('tempat_lahir')==='') {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_tempat_lahir');
		// } else if($this->input->post('tanggal_lahir')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
		// } else if($this->Xin_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
		// 	 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		// } else if($this->input->post('ibu_kandung')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_ibu_kandung');
		// } else if($this->input->post('no_kontak')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		// } else if($this->input->post('email')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_error_cemail_field');
		// } else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		// } else if($this->input->post('ktp_no')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_ktp');
		// } else if($this->input->post('kk_no')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_nomor_kk');
		// } else if($this->input->post('address_ktp')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_alamat_domisili');
		// } else if($this->input->post('gender')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_jenis_kelamin');
		// } else if($this->input->post('marital_status')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_status_pernikahan');
		// }

		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'penempatan' => $this->input->post('penempatan'),
		// 'tempat_lahir' => $this->input->post('tempat_lahir'),
		// 'date_of_birth' => $this->input->post('tanggal_lahir'),
		// 'ibu_kandung' => $this->input->post('ibu_kandung'),
		// 'contact_no' => $this->input->post('no_kontak'),
		// 'email' => $this->input->post('email'),
		// 'ktp_no' => $this->input->post('ktp_no'),
		// 'kk_no' => $this->input->post('kk_no'),
		// 'npwp_no' => $this->input->post('npwp_no'),
		// 'address_domisili' => $this->input->post('address_domisili'),
		// 'address' => $this->input->post('address'),
		// 'gender' => $this->input->post('gender'),
		// 'ethnicity_type' => $this->input->post('ethnicity'),
		// 'marital_status' => $this->input->post('marital_status'),
		// 'blood_group' => $this->input->post('blood_group'),
		// 'tinggi_badan' => $this->input->post('tinggi_badan'),
		// 'berat_badan' => $this->input->post('berat_badan'),

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
	public function bank_account() {
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
		$bank_account = $this->Employees_model->set_employee_bank_account($id);
		
		$data = array();

        foreach($bank_account->result() as $r) {			
		
		$data[] = array(
			'-',
			'-',
			'-',
			'-',
			'-',
			'-'
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
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
		$contract = $this->Employees_model->set_employee_contract($id);
		
		$data = array();

        foreach($contract->result() as $r) {			
			// designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
			//contract type
			$contract_type = $this->Employees_model->read_contract_type_information($r->contract_type_id);
			if(!is_null($contract_type)){
				$ctype = $contract_type[0]->name;
			} else {
				$ctype = '--';
			}
			// date
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
		
		$data[] = array(
			$duration,
			$designation_name,
			$ctype,
			$r->title
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
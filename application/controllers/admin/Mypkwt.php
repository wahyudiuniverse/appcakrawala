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

class Mypkwt extends MY_Controller {
	
		public function __construct() {
      parent::__construct();
			//load the models
			$this->load->model("Employees_model");
			$this->load->model("Xin_model");
			$this->load->model("Department_model");
			$this->load->model("Designation_model");
			$this->load->model("Roles_model");
			$this->load->model("Location_model");
			$this->load->model("Company_model");
			$this->load->model("Timesheet_model");
			$this->load->model("Custom_fields_model");
			$this->load->model("Assets_model");
			$this->load->model("Training_model");
			$this->load->model("Trainers_model");
			$this->load->model("Awards_model");
			$this->load->model("Travel_model");
			$this->load->model("Tickets_model");
			$this->load->model("Transfers_model");
			$this->load->model("Promotion_model");
			$this->load->model("Complaints_model");
			$this->load->model("Warning_model");
			$this->load->model("Project_model");
			$this->load->model("Payroll_model");
			$this->load->model("Events_model");
			$this->load->model("Meetings_model");
			$this->load->model('Exin_model');
			$this->load->model('Pkwt_model');
			$this->load->library("pagination");
			$this->load->library('Pdf');
			$this->load->helper('string');
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
			$role_resources_ids = $this->Xin_model->user_role_resource();
			$data['title'] = $this->lang->line('header_my_contract').' | '.$this->Xin_model->site_title();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
			$data['all_user_roles'] = $this->Roles_model->all_user_roles();
			$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
			$data['get_all_companies'] = $this->Xin_model->get_companies();
			$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
			$data['breadcrumbs'] = $this->lang->line('header_my_contract');

			// if(!in_array('13',$role_resources_ids)) {
			// 	$data['path_url'] = 'myteam_employees';
			// } else {
				$data['path_url'] = 'mypkwt';
			// }
		
			// reports to 
	 		$reports_to = get_reports_team_data($session['user_id']);
			if(in_array('137',$role_resources_ids) || $reports_to > 0) {
				if(!empty($session)){ 
					$data['subview'] = $this->load->view("admin/mypkwt/mypkwt_status", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard');
			}
	}


	public function detail() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Employees_model->read_employee_information($id);
		if(is_null($result)){
			redirect('admin/employees');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);
		// if(!in_array('202',$role_resources_ids)) {
		// 	redirect('admin/employees');
		// }
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/employees');
		}*/
		
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('xin_employee_details');
		//$data['path_url'] = 'employees_detail';	

		$data = array(
			'breadcrumbs' => $this->lang->line('xin_employee_detail'),
			'path_url' => 'employees_detail',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'ibu_kandung' => $result[0]->ibu_kandung,
			'user_id' => $result[0]->user_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'location_id' => $result[0]->location_id,
			'office_shift_id' => $result[0]->office_shift_id,
			'ereports_to' => $result[0]->reports_to,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'designation_id' => $result[0]->designation_id,
			'user_role_id' => $result[0]->user_role_id,
			'date_of_birth' => $result[0]->date_of_birth,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'gender' => $result[0]->gender,
			'marital_status' => $result[0]->marital_status,
			'contact_no' => $result[0]->contact_no,
			'state' => $result[0]->state,
			'city' => $result[0]->city,
			'zipcode' => $result[0]->zipcode,
			'blood_group' => $result[0]->blood_group,
			'citizenship_id' => $result[0]->citizenship_id,
			'nationality_id' => $result[0]->nationality_id,
			'iethnicity_type' => $result[0]->ethnicity_type,
			'address' => $result[0]->address,
			'wages_type' => $result[0]->wages_type,
			'basic_salary' => $result[0]->basic_salary,
			'is_active' => $result[0]->is_active,
			'date_of_joining' => $result[0]->date_of_joining,
			'all_departments' => $this->Department_model->all_departments(),
			'all_designations' => $this->Designation_model->all_designations(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('xin_employee_detail').' | '.$this->Xin_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'leave_categories' => $result[0]->leave_categories,
			'view_companies_id' => $result[0]->view_companies_id,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_contracts' => $this->Employees_model->all_contracts(),
			'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_office_locations' => $this->Location_model->all_office_locations(),
			'all_leave_types' => $this->Timesheet_model->all_leave_types(),
			'all_countries' => $this->Xin_model->get_countries()
			);
		
		if($check_role[0]->user_role_id==1 || $check_role[0]->user_role_id==3 || $check_role[0]->user_role_id==4) {

		$data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		} else {

		$data['subview'] = $this->load->view("admin/employees/employee_detail_employee", $data, TRUE);
		}

		// if($result[0]->user_id == $id) {

		// $data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		// } else {
		// $data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		// }

		$this->load->view('admin/layout/layout_main', $data); //page load
		
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	/*  add and update employee details info */
	// Validate and update info in database // basic info
	public function basic_info() {
	
		if($this->input->post('type')=='basic_info') {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array(
				'result'=>'', 
				'error'=>'', 
				'csrf_hash'=>''
			);

			$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
			//$office_shift_id = $this->input->post('office_shift_id');
			$system = $this->Xin_model->read_setting_info(1);
			
			//cek string aneh
			/*
			if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('xin_hr_string_error');
			}*/

			/* Server side PHP input validation */	
			if($this->input->post('username')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_username');
			}	else if($this->input->post('employee_id')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_employee_id');
			} else if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_first_name');
			} else if($this->input->post('email')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			} else if($this->input->post('contact_no')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
			} else if($this->input->post('date_of_birth')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_date_of_birth');
			} else if($this->input->post('ibu_kandung')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_ibu_kandung');
			}

			// else if($this->Xin_model->validate_date($this->input->post('date_of_birth'),'Y-m-d') == false) {
			//  	$Return['error'] = $this->lang->line('xin_hr_date_format_error');
			// } 

			else if($this->input->post('company_id')==='') {
			 	$Return['error'] = $this->lang->line('error_company_field');
			} else if($this->input->post('location_id')==='') {
			 	$Return['error'] = $this->lang->line('xin_location_field_error');
			} else if($this->input->post('department_id')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_department');
			} else if($this->input->post('subdepartment_id')==='') {
        $Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
			} else if($this->input->post('designation_id')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_designation');
			} else if($this->input->post('date_of_joining')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_joining_date');
			} 
			// else if($this->Xin_model->validate_date($this->input->post('date_of_joining'),'Y-m-d') == false) {
			//  	$Return['error'] = $this->lang->line('xin_hr_date_format_error');
			// } 

			else if($this->input->post('role')==='') {
			 	$Return['error'] = $this->lang->line('xin_employee_error_user_role');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
			}
				
			if($Return['error']!=''){
       		$this->output($Return);
    	}
		
			$employee_id = $this->input->post('employee_id');
			$username = $this->input->post('username');
			$first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
			// $last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
			$contact_no = $this->Xin_model->clean_post($this->input->post('contact_no'));
			$date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
			$date_of_joining = $this->Xin_model->clean_date_post($this->input->post('date_of_joining'));
			$leave_categories = array($this->input->post('leave_categories'));
			$cat_ids = implode(',',$this->input->post('leave_categories'));
			$address = $this->input->post('address');
			
			$module_attributes = $this->Custom_fields_model->all_hrpremium_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_module_attributes();	
			$i=1;
			// 	if($count_module_attributes > 0){
			// 	 foreach($module_attributes as $mattribute) {
			// 		 if($mattribute->validation == 1){
			// 			 if($i!=1) {
			// 			 } else if($this->input->post($mattribute->attribute)=='') {
			// 				$Return['error'] = $this->lang->line('xin_hrpremium_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('xin_hrpremium_custom_field_is_required');
			// 			}
			// 		 }
			// 	 }		
			// 	 if($Return['error']!=''){
			// 		$this->output($Return);
			// 	}	
			// }
	
			$data = array(
			'employee_id' => $employee_id,
			'username' => $employee_id,
			'first_name' => $first_name,
			// 'last_name' => $last_name,
			'ibu_kandung' => $this->input->post('ibu_kandung'),
			'email' => $this->input->post('email'),
			'contact_no' => $contact_no,
			'date_of_birth' => $date_of_birth,
			'company_id' => $this->input->post('company_id'),
			// 'view_companies_id' => $view_companies_id,
			'location_id' => $this->input->post('location_id'),
			'department_id' => $this->input->post('department_id'),
			// 'sub_department_id' => $this->input->post('subdepartment_id'),
			'designation_id' => $this->input->post('designation_id'),
			'date_of_joining' => $date_of_joining,
			'date_of_leaving' => $this->input->post('date_of_leaving'),
			'ethnicity_type' => $this->input->post('ethnicity_type'),
			'gender' => $this->input->post('gender'),
			'marital_status' => $this->input->post('marital_status'),
			'blood_group' => $this->input->post('blood_group'),
			'leave_categories' => $cat_ids,
			// 'office_shift_id' => $this->input->post('office_shift_id'),
			'address' => $address,
			'state' => $this->input->post('estate'),
			'city' => $this->input->post('ecity'),
			'zipcode' => $this->input->post('ezipcode'),
			'nationality_id' => $this->input->post('nationality_id'),
			//'citizenship_id' => $this->input->post('citizenship_id'),
			'reports_to' => $this->input->post('reports_to'),
			// 'is_active' => $this->input->post('status'),
			'user_role_id' => $this->input->post('role'),
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




	public function uploadpkwt() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Employees_model->read_employee_information($session['user_id']);
		if(is_null($result)){
			redirect('admin/mypkwt');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);

		$data = array(
			'breadcrumbs' => $this->lang->line('xin_pkwt_dokumen'),
			'path_url' => 'mypkwt_upload',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'title' => 'Dokumen PKWT | '.$this->Xin_model->site_title(),
			);

		$data['subview'] = $this->load->view("admin/mypkwt/upload", $data, TRUE);

		$this->load->view('admin/layout/layout_main', $data); //page load
		
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	// Validate and add info in database // document info
	public function document_pkwt() {
	
		if($this->input->post('type')=='document_file' && $this->input->post('data')=='document_file') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		if($_FILES['document_file']['size'] == 0) {
			$fname = '';
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				// $allowed =  array('pdf');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_pkwt_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
					
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		

		$data = array(
		'kontrak_id' => $this->input->post('contract_id'),
		'document_file' => $fname,
		);
		$result = $this->Pkwt_model->document_pkwt_add($data);

		if ($result == TRUE) {

		// header("Location: http://yourpagehere.com");
			$Return['result'] = $this->lang->line('xin_employee_d_info_added');
		} else {

		// header("Location: http://yourpagehere.com");
			$Return['error'] = $this->lang->line('xin_error_msg');
		}

		// $Return['error'] = $this->lang->line('xin_employee_d_info_added');
		$this->output($Return);
		exit();
		}
	}


}

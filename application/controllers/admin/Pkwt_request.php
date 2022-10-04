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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pkwt_request extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
		  $this->load->model('Xin_model');
		  $this->load->model("Employees_model");
		  $this->load->model('Customers_model');
          $this->load->model('Company_model');
		  $this->load->model('Exin_model');
		  $this->load->model('Department_model');
		  $this->load->model('Payroll_model');
		  $this->load->model('Reports_model');
		  $this->load->model('Timesheet_model');
		  $this->load->model('Training_model');
		  $this->load->model('Trainers_model');
		  $this->load->model("Project_model");
		  $this->load->model("Roles_model");
		  $this->load->model("Designation_model");
		  $this->load->model("Pkwt_model");
     }
	 

	// employees report
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_request_pkwt').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_request_pkwt');
		$data['path_url'] = 'pkwt_request';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_projects'] = $this->Xin_model->get_projects();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('117',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_request_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	 
	public function report_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/pkwt_request_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);

		$project_id = $this->uri->segment(6);
		$subproject_id = $this->uri->segment(7);

		// $designation_id = $this->uri->segment(6);
		if($company_id==0 || is_null($company_id)){

		$employee = $this->Pkwt_model->filter_employees_reports_none($company_id,$department_id,$project_id,$subproject_id);
		
		} else {

		$employee = $this->Pkwt_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id);
		
		}
		$data = array();

        foreach($employee->result() as $r) {		  

        	$nopkwt = '[autogenerate]';
        	$nospb = '[autogenerate]';
			$nip = $r->employee_id;
			$full_name = $r->first_name.' '.$r->last_name;

			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
				
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}

			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if(!is_null($project)){
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';	
			}

			$subproject = $this->Project_model->read_single_subproject($r->sub_project_id);
			if(!is_null($subproject)){
				$subproject_name = $subproject[0]->sub_project_name;
			} else {
				$subproject_name = '--';	
			}


			if(!is_null($r->gender)){
				$gender = $r->gender;
			} else {
				$gender = '--';	
			}

			if(!is_null($r->marital_status)){
				$marital = $r->marital_status;
			} else {
				$marital = '--';	
			}

			if(!is_null($r->date_of_birth)){
				$dob = $r->date_of_birth;
			} else {
				$dob = '--';	
			}

			if(!is_null($r->date_of_joining)){
				$doj = $r->date_of_joining;
			} else {
				$doj = '--';	
			}
			if(!is_null($r->email)){
				$email = $r->email;
			} else {
				$email = '--';	
			}
			if(!is_null($r->contact_no)){
				$kontak = $r->contact_no;
			} else {
				$kontak = '--';	
			}

			if(!is_null($r->address)){
				$alamat = $r->address;
			} else {
				$alamat = '--';	
			}


			if(!is_null($r->kk_no)){
				$kk = $r->kk_no;
			} else {
				$alamat = '--';	
			}

			if(!is_null($r->ktp_no)){
				$ktp = $r->ktp_no;
			} else {
				$alamat = '--';	
			}

			if(!is_null($r->npwp_no)){
				$npwp = $r->npwp_no;
			} else {
				$alamat = '--';	
			}

			if(!is_null($r->private_code)){
				$pin = $r->private_code;
			} else {
				$alamat = '--';	
			}
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
						
			$data[] = array(
				$nopkwt,
				$nopkwt,
				$nip,
				$full_name,
				$designation_name,
				$project_name,
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				''
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
	
	
	// get company > departments
	public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	// get company > departments
	public function get_subprojects() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'project_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_subprojects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	 // get departmens > designations
	public function designation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	
	// Validate and add info in database
	public function payslip_report() {
	
		if($this->input->post('type')=='payslip_report') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_hr_report_error_month_field');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
		}
		$Return['result'] = $this->lang->line('xin_hr_request_submitted');
		$this->output($Return);
		}
	}
	 
} 
?>
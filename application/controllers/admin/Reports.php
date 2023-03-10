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

class Reports extends MY_Controller
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
	 
	// reports
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'reports_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('117',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// payslip reports > employees and company
	public function payslip() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_payslip').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_payslip');
		$data['path_url'] = 'reports_payslip';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/payslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// projects report
	public function projects() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_projects').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_projects');
		$data['path_url'] = 'reports_project';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('114',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// tasks report
	public function tasks() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_tasks').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_tasks');
		$data['path_url'] = 'reports_task';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('115',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/tasks", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// roles/privileges report
	public function roles() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_user_roles_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_user_roles_report');
		$data['path_url'] = 'reports_roles';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('116',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/roles", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// employees report
	public function employees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'reports_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('117',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
		// employees report
	public function manage_employees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_manage_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_manage_employees');
		$data['path_url'] = 'reports_man_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('470',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/manage_employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


		// employees report
	public function skk_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_sk_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_sk_report');
		$data['path_url'] = 'reports_skk';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
			// $data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('470',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/skk_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

		// employees report
	public function bpjs_employees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_emp_bpjs').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_emp_bpjs');
		$data['path_url'] = 'reports_bpjs_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('476',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/bpjs_employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// employees report
	public function pkwt() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'pkwt_request';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_projects'] = $this->Project_model->get_project_exist();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('376',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_request_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	 
	public function report_employees_list_pkwt() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employees", $data);
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
				'',
				'',
				'YYYY-MM-DD',
				'YYYY-MM-DD',
				'YYYY-MM-DD',
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

	public function report_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employees", $data);
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
		$status_resign = $this->uri->segment(8);
	

		if($company_id==0 || is_null($company_id)){
			$employee = $this->Reports_model->filter_employees_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		}else{
			$employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		}
		
		$data = array();

        foreach($employee->result() as $r) {		  

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
				$kk = '--';	
			}

			if(!is_null($r->ktp_no)){
				$ktp = $r->ktp_no;
			} else {
				$ktp = '--';	
			}

			if(!is_null($r->npwp_no)){
				$npwp = $r->npwp_no;
			} else {
				$npwp = '--';	
			}

			if(!is_null($r->private_code)){
				$pin = $r->private_code;
			} else {
				$pin = '--';	
			}

				if($r->status_resign==2){
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">RESIGN</button>';
				} else if ($r->status_resign==3) {
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-danger">BLACKLIST</button>';
				} else if($r->status_resign==4) {
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-info">END CONTRACT</button>';
				} else {
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-success">ACTIVE</button>';
				}

			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
						
			$data[] = array(
				$stat,
				$r->employee_id,
				$full_name,
				$comp_name,
				$department_name,
				$designation_name,
				$project_name,
				$subproject_name,
				$gender,
				$marital,
				$this->Xin_model->tgl_indo($dob),
				$this->Xin_model->tgl_indo($doj),
				$email,
				$kontak,
				$alamat,
				$kk,
				$ktp,
				$npwp,
				$pin
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
	
	
	public function report_manage_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/manage_employees", $data);
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
		$status_resign = $this->uri->segment(8);

		// $designation_id = $this->uri->segment(6);

		if($company_id==0 || is_null($company_id)){

		$employee = $this->Reports_model->filter_employees_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		}else{

		$employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		}
		
		$data = array();

        foreach($employee->result() as $r) {		  

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

			// $agama = '--';
			$ethnicity = $this->Employees_model->read_ethnicity($r->ethnicity_type);
			if(!is_null($ethnicity)){
				$agama = $ethnicity[0]->type;
			} else {
				$agama = '--';
			}

			$banklist = $this->Xin_model->read_bank_info($r->bank_name);
			if(!is_null($banklist)){
				$bank_name = $banklist[0]->bank_name;
			} else {
				$bank_name = '--';
			}

			// $docktp = $this->Xin_model->read_bank_info($r->user_id);
			// if(!is_null($docktp)){
			// 	$ktp = $docktp[0]->title;
			// } else {
			// 	$ktp = '--';
			// }


			// $dockk = $this->Xin_model->read_document_kk($r->user_id);
			// if(!is_null($dockk)){
			// 	$kk = $dockk[0]->title;
			// } else {
			// 	$kk = '--';
			// }

			// $docnpwp = $this->Xin_model->read_document_npwp($r->user_id);
			// if(!is_null($docnpwp)){
			// 	$npwp = $docnpwp[0]->title;
			// } else {
			// 	$npwp = '--';
			// }

			// $docnpwp = $this->Xin_model->read_document_npwp($r->user_id);
			// if(!is_null($docnpwp)){
			// 	$npwp = $docnpwp[0]->title;
			// } else {
			// 	$npwp = '--';
			// }

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

			if($r->date_of_joining!='' || !is_null($r->date_of_birth)){
				$dob = $this->Xin_model->tgl_indo($r->date_of_birth);
			} else {
				$dob = '--';	
			}

			if($r->date_of_joining!='' || !is_null($r->date_of_joining)){
				$doj = $this->Xin_model->tgl_indo($r->date_of_joining);
			} else {
				$doj = '--';	
			}

			if($r->date_of_leaving!='' || !is_null($r->date_of_leaving)){
				// $dol = $r->date_of_leaving;
				$dol = $this->Xin_model->tgl_indo($r->date_of_leaving);
			} else {
				$dol = '--';	
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

			if(!is_null($r->bpjs_tk_no)){
				$bpjstk = $r->bpjs_tk_no;
			} else {
				$bpjstk = '--';	
			}
			if(!is_null($r->bpjs_ks_no)){
				$bpjsks = $r->bpjs_ks_no;
			} else {
				$bpjsks = '--';
			}

			if(!is_null($r->ibu_kandung)){
				$ibu = $r->ibu_kandung;
			} else {
				$ibu = '--';	
			}

			if(!is_null($r->penempatan)){
				$penempatan = $r->penempatan;
			} else {
				$penempatan = '--';	
			}

			if(!is_null($r->tempat_lahir)){
				$tempat_lahir = $r->tempat_lahir;
			} else {
				$tempat_lahir = '--';
			}

			// if($r->dol != '' || !is_null($r->dol)){
			// 	$dol = $this->Xin_model->tgl_indo($dol);
			// } else {
			// 	$dol = '--';	
			// }

			if($r->password_change==0 || $r->project_id != '22'){
					
				$pin = $r->private_code;
			} else {
				$pin = '******';
			}

			$ktp = $r->ktp_no;
			$kk = $r->kk_no;
			$npwp = $r->npwp_no;
			$nomor_rek = $r->nomor_rek;
			// $bank_name = $r->bank_name;
			$pemilik_rek = $r->pemilik_rek;

				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/employees/emp_edit/'.$r->employee_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
				if($r->status_resign==2){
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">RESIGN</button>';
				} else if ($r->status_resign==3) {
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-danger">BLACKLIST</button>';
				} else if($r->status_resign==4) {
					$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-info">END CONTRACT</button>';
				} else {
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-success">ACTIVE</button>';
				}


			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;

			$role_resources_ids = $this->Xin_model->user_role_resource();

			if(in_array('471',$role_resources_ids) || in_array('472',$role_resources_ids) || in_array('473',$role_resources_ids)) {
				$edits = $edit.' '.$stat;
			} else {
				$edits = $stat;
			}
						
			$data[] = array(
				$edits,
				$r->employee_id,
				strtoupper($full_name),
				$pin,
				$comp_name,
				$department_name,
				$designation_name,
				$project_name,
				$subproject_name,
				$penempatan, // AREA
				$tempat_lahir, // TEMPAT LAHIR
				$dob,
				$doj,
				$dol,
				$gender,
				$marital,
				$agama, // agama
				$email,
				$kontak,
				$alamat,
				"'".$kk,
				"'".$ktp,
				$npwp,
				$bpjstk,
				$bpjsks,
				$ibu,
				$bank_name,
				"'".$nomor_rek,
				$pemilik_rek
				// $pin
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

	public function report_skk_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/skk_list", $data);
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
		$status_resign = $this->uri->segment(8);

		$role_resources_ids = $this->Xin_model->user_role_resource();
		// $designation_id = $this->uri->segment(6);


		if($company_id==0 || is_null($company_id)){
		// $employee = $this->Reports_model->filter_employees_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);

		$esign = $this->Reports_model->filter_esign_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);

		}else{
		// $employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id,$status_resign);

		$esign = $this->Reports_model->filter_esign_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);

		}
		
		$data = array();

        foreach($esign->result() as $r) {		  

        	$doc_id = $r->doc_id;
			$nomor_dokumen = $r->nomor_dokumen;
			$nip = $r->nip;
			$jenis_doc = $r->jenis_dokumen;
			$createdat = $this->Xin_model->tgl_indo(substr($r->createdon,0,10));

			$head_user = $this->Employees_model->read_employee_info_by_nik($r->nip);

			if(!is_null($head_user)){
				$fullname = $head_user[0]->first_name;
				if(!is_null($head_user[0]->project_id)){
					$project = $this->Project_model->read_single_project($head_user[0]->project_id);
					if(!is_null($project)){
						$project_name = $project[0]->title;
					} else {
						$project_name = '--';	
					}
					
					// $project_name = '--';
				} else {
					$project_name = '--';
				}
				// $project_name = $head_user[0]->project_id;


					// $project_name = '--';

			} else {

					$project_name = '--';
				$fullname = '--';	
			}

			// JENIS DOKUMENT
			if($jenis_doc==1){
				$jdoc = 'SK KERJA';
			} else if ($jenis_doc==2) {
				$jdoc = 'PAKLARING';	
			} else if ($jenis_doc==3) {
				$jdoc = 'SK KERJA & PAKLARING';	
			} else {
				$jdoc = '--';	
			}


			if(in_array('470',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/skk/view/'.$r->secid.'/'.$nip.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}

			if(in_array('470',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $delete.' '.$view;
						
			$data[] = array(
				$combhr,
				$nomor_dokumen,
				$nip,
				$fullname,
				$jdoc,
				$createdat,
				$project_name,
			);
      
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $esign->num_rows(),
			 "recordsFiltered" => $esign->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }

	public function report_bpjs_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/bpjs_employees", $data);
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

		$employee = $this->Reports_model->filter_employees_reports_null($company_id,$department_id,$project_id,$subproject_id);
		}else{

		$employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id);
		}
		
		$data = array();

        foreach($employee->result() as $r) {		  

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
				$kk = '--';	
			}

			if(!is_null($r->ktp_no)){
				$ktp = $r->ktp_no;
			} else {
				$ktp = '--';	
			}

			if(!is_null($r->npwp_no)){
				$npwp = $r->npwp_no;
			} else {
				$npwp = '--';	
			}

			if(!is_null($r->private_code)){
				$pin = $r->private_code;
			} else {
				$pin = '--';	
			}

							$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/employees/emp_edit/'.$r->employee_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';

			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;

			
						
			$data[] = array(
				$edit,
				$r->employee_id,
				$full_name,
				// $comp_name,
				// $department_name,
				// $designation_name,
				// $project_name,
				// $subproject_name,
				// $gender,
				// $marital,
				// $this->Xin_model->tgl_indo($dob),
				// $this->Xin_model->tgl_indo($doj),
				// $email,
				// $kontak,
				// $alamat,
				// $kk,
				// $ktp,
				// $npwp,
				// $pin
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
	
	// reports > employee attendance
	public function employee_attendance() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_reports_attendance_employee').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_attendance_employee');
		$data['path_url'] = 'reports_employee_attendance';
		$data['all_companies'] = $this->Xin_model->get_companies();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}
		if(in_array('112',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_attendance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// reports > employee attendance
	public function report_order() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_order_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_order_report');
		$data['path_url'] = 'reports_order';
		$data['all_companies'] = $this->Xin_model->get_companies();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}
		if(in_array('114',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_order", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// reports > employee attendance
	public function report_resume() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_order_resume').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_order_resume');
		$data['path_url'] = 'reports_order_resume';
		$data['all_companies'] = $this->Xin_model->get_companies();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}
		if(in_array('114',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_order_resume", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// daily attendance list > timesheet
    public function empdtwise_attendance_list()
    {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		
		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$sub_id = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);

		if($company_id==0 || is_null($company_id)){
			$employee = $this->Reports_model->filter_report_emp_att_null();
		} else {
			$employee = $this->Reports_model->filter_report_emp_att($company_id,$project_id,$sub_id,$start_date,$end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
 		foreach($employee->result() as $r) {

			$emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			if(!is_null($emp)){
				$fullname = $emp[0]->first_name;
			} else {
				$fullname = '--';	
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if(!is_null($project)){
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';	
			}

			$cust = $this->Customers_model->read_single_customer($r->customer_id);
			if(!is_null($cust)){
				$nama_toko = $cust[0]->customer_name;
			} else {
				$nama_toko = '--';	
			}

			if(!is_null($r->date_phone)){

			} else {

			}

			$data[] = array (
				$r->employee_id,
				$fullname,
				$project_name,
				$nama_toko,
				$r->date_phone,
				$r->time_in,
				$r->time_out,
				$r->timestay
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

	
	// daily attendance list > timesheet
    public function empdtwise_order()
    {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_order", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		
		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$sub_id = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);

		if($company_id==0 || is_null($company_id)){
			$employee = $this->Reports_model->report_order();
		} else {
			$employee = $this->Reports_model->report_order_filter($company_id,$project_id,$sub_id,$start_date,$end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
 		foreach($employee->result() as $r) {

			$emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			if(!is_null($emp)){
				$fullname = $emp[0]->first_name;
			} else {
				$fullname = '--';	
			}

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			$cust = $this->Customers_model->read_single_customer($r->customer_id);
			if(!is_null($cust)){
				$nama_toko = $cust[0]->customer_name;
			} else {
				$nama_toko = '--';	
			}

			// if(!is_null($r->date_phone)){

			// } else {

			// }

			$data[] = array (
				$r->employee_id,
				$fullname,
				$nama_toko,
				$r->address,
				$r->city,
				$r->kec,
				$r->desa,
				$r->material_id,
				$r->nama_material,
				$r->order_date,
				$r->qty,
				$r->price,
				$r->total
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

	// daily attendance list > timesheet
    public function empdtwise_order_resume()
    {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_order_resume", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		
		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$sub_id = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);

		if($company_id==0 || is_null($company_id)){
			$employee = $this->Reports_model->report_order_resume();
		} else {
			$employee = $this->Reports_model->report_order_resume_filter($company_id,$project_id,$sub_id,$start_date,$end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
 		foreach($employee->result() as $r) {

			// $emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			// if(!is_null($emp)){
			// 	$fullname = $emp[0]->first_name;
			// } else {
			// 	$fullname = '--';	
			// }

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			// $cust = $this->Customers_model->read_single_customer($r->customer_id);
			// if(!is_null($cust)){
			// 	$nama_toko = $cust[0]->customer_name;
			// } else {
			// 	$nama_toko = '--';	
			// }

			// if(!is_null($r->date_phone)){

			// } else {

			// }

			$data[] = array (
				$r->emp_id,
				'Fullname',
				$r->count_call,
				$r->count_ec,
				$r->qty_renceng,
				'Rp. 10.000;',
				$r->total
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
	public function get_company_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_company' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_company_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_sub_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_sub_project", $data);
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
	
	public function role_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/roles", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$roleId = $this->uri->segment(4);
		$employee = $this->Reports_model->get_roles_employees($roleId);
		
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			// user full name 
			$full_name = $r->first_name.' '.$r->last_name;				
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// user role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';	
			}
			$department_designation = $designation_name.' ('.$department_name.')';
			
			$data[] = array(
				$r->employee_id,
				$full_name,
				$comp_name,
				$r->email,
				$role_name,
				$department_designation,
				$status
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
	 

	public function project_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/projects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$projId = $this->uri->segment(4);
		$projStatus = $this->uri->segment(5);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$project = $this->Reports_model->get_project_list($projId,$projStatus);
		} else {
			$project = $this->Project_model->get_employee_projects($session['user_id']);
		}		
		$data = array();

        foreach($project->result() as $r) {
			 			  
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$end_date = $this->Xin_model->set_date_format($r->end_date);
		
		$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' '.$r->project_progress.'%</p>';
				
		//status
		if($r->status == 0) {
			$status = $this->lang->line('xin_not_started');
		} else if($r->status ==1){
			$status = $this->lang->line('xin_in_progress');
		} else if($r->status ==2){
			$status = $this->lang->line('xin_completed');
		} else {
			$status = $this->lang->line('xin_deffered');
		}
		
		// priority
		if($r->priority == 1) {
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
		} else if($r->priority ==2){
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
		} else if($r->priority ==3){
			$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
		} else {
			$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
		}
		
		//assigned user
		if($r->assigned_to == '') {
			$ol = $this->lang->line('xin_not_assigned');
		} else {
			$ol = '';
			foreach(explode(',',$r->assigned_to) as $desig_id) {
				$assigned_to = $this->Xin_model->read_user_info($desig_id);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 $ol .= $assigned_name."<br>";
			 }
		}
		$ol .= '';
		}
		$new_time = $this->Xin_model->actual_hours_timelog($r->project_id);
		
		//echo $new_time;
		$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '">'.$r->title.'</a></div>';
		$data[] = array(
			$project_summary,
			$priority,
			$start_date,
			$end_date,
			$status,
			$pbar,
			$ol,
			$r->budget_hours,
			$new_time,
			
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $project->num_rows(),
			 "recordsFiltered" => $project->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	public function training_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_training", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$start_date = $this->uri->segment(4);
		$end_date = $this->uri->segment(5);
		$uid = $this->uri->segment(6);
		$cid = $this->uri->segment(7);
		
		$training = $this->Reports_model->get_training_list($cid,$start_date,$end_date);
		
		$data = array();

        foreach($training->result() as $r) {
			
		 $aim = explode(',',$r->employee_id);
		 foreach($aim as $dIds) {
		 if($uid == $dIds) {
		
		// get training type
		$type = $this->Training_model->read_training_type_information($r->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		/*$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}*/
		// get trainer
			if($r->trainer_option == 2){
				$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
				// trainer full name
				if(!is_null($trainer)){
					$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$trainer_name = '--';	
				}
			} elseif($r->trainer_option == 1){
				// get user > employee_
				$trainer = $this->Xin_model->read_user_info($r->trainer_id);
				// employee full name
				if(!is_null($trainer)){
					$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$trainer_name = '--';	
				}
			} else {
				$trainer_name = '--';
			}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$finish_date = $this->Xin_model->set_date_format($r->finish_date);
		// training date
		$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
		// set currency
		$training_cost = $this->Xin_model->currency_sign($r->training_cost);
		/* get Employee info*/
		if($uid == '') {
			$ol = '--';
		} else {
			$user = $this->Exin_model->read_user_info($uid);
			$fname = $user[0]->first_name.' '.$user[0]->last_name;				
		}
		// status
		if($r->training_status==0): $status = $this->lang->line('xin_pending');
		elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
		else: $status = $this->lang->line('xin_terminated'); endif;
		
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
		$comp_name = $company[0]->name;
		} else {
		  $comp_name = '--';	
		}
		
		$data[] = array(
			$comp_name,
			$fname,
			$itype,
			$trainer_name,
			$training_date,
			$training_cost,
			$status
		);
      }
		 } } // e- training
		
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $training->num_rows(),
			 "recordsFiltered" => $training->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	// hourly_list > templates
	public function payslip_report_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/payslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$cid = $this->uri->segment(4);
		$eid = $this->uri->segment(5);
		$re_date = $this->uri->segment(6);
		
		
		$payslip_re = $this->Reports_model->get_payslip_list($cid,$eid,$re_date);
		
		$data = array();

          foreach($payslip_re->result() as $r) {

			  // get addd by > template
			  $user = $this->Xin_model->read_user_info($r->employee_id);
			  // user full name
			  if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$emp_link = $user[0]->employee_id;				  
				
				$month_payment = date("F, Y", strtotime($r->salary_month));
				
				$p_amount = $this->Xin_model->currency_sign($r->net_salary);
				if($r->wages_type==1){
					$payroll_type = $this->lang->line('xin_payroll_basic_salary');
				} else {
					$payroll_type = $this->lang->line('xin_employee_daily_wages');
				}
				
				// get date > created at > and format
				$created_at = $this->Xin_model->set_date_format($r->created_at);

               $data[] = array(
                    $emp_link,
					$full_name,
                    $p_amount,
                    $month_payment,
                    $created_at,
					$payroll_type
               );
          }
		  } // if employee available

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payslip_re->num_rows(),
                 "recordsFiltered" => $payslip_re->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	
	 // get company > employees
	public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // get company > employees
	 public function get_employees_att() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_employees_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 
	 // get company > employees
	 public function get_project_att() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_project_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	// date wise attendance list > timesheet
    public function employee_date_wise_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$employee_id = $this->input->get("user_id");
		//$employee = $this->Xin_model->read_user_info($employee_id);
		
		$employee = $this->Xin_model->read_user_info($employee_id);
		
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$attendance_arr = array();
		
		$data = array();
		foreach($date_range as $date) {
		$attendance_date =  $date->format("Y-m-d");
       // foreach($employee->result() as $r) {
			 			  		
		// user full name
		//	$full_name = $r->first_name.' '.$r->last_name;	
		// get office shift for employee
		$get_day = strtotime($attendance_date);
		$day = date('l', $get_day);
		
		// office shift
		$office_shift = $this->Timesheet_model->read_office_shift_information($employee[0]->office_shift_id);
		
		// get clock in/clock out of each employee
		if($day == 'Monday') {
			if($office_shift[0]->monday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->monday_in_time;
				$out_time = $office_shift[0]->monday_out_time;
			}
		} else if($day == 'Tuesday') {
			if($office_shift[0]->tuesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->tuesday_in_time;
				$out_time = $office_shift[0]->tuesday_out_time;
			}
		} else if($day == 'Wednesday') {
			if($office_shift[0]->wednesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->wednesday_in_time;
				$out_time = $office_shift[0]->wednesday_out_time;
			}
		} else if($day == 'Thursday') {
			if($office_shift[0]->thursday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->thursday_in_time;
				$out_time = $office_shift[0]->thursday_out_time;
			}
		} else if($day == 'Friday') {
			if($office_shift[0]->friday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->friday_in_time;
				$out_time = $office_shift[0]->friday_out_time;
			}
		} else if($day == 'Saturday') {
			if($office_shift[0]->saturday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->saturday_in_time;
				$out_time = $office_shift[0]->saturday_out_time;
			}
		} else if($day == 'Sunday') {
			if($office_shift[0]->sunday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->sunday_in_time;
				$out_time = $office_shift[0]->sunday_out_time;
			}
		}
		// check if clock-in for date
		$attendance_status = '';
		$check = $this->Timesheet_model->attendance_first_in_check($employee[0]->user_id,$attendance_date);		
		if($check->num_rows() > 0){
			// check clock in time
			$attendance = $this->Timesheet_model->attendance_first_in($employee[0]->user_id,$attendance_date);
			// clock in
			$clock_in = new DateTime($attendance[0]->clock_in);
			$clock_in2 = $clock_in->format('h:i a');
			$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_in_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_in" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkin_ip').'</button>';
			
			$office_time =  new DateTime($in_time.' '.$attendance_date);
			//time diff > total time late
			$office_time_new = strtotime($in_time.' '.$attendance_date);
			$clock_in_time_new = strtotime($attendance[0]->clock_in);
			if($clock_in_time_new <= $office_time_new) {
				$total_time_l = '00:00';
			} else {
				$interval_late = $clock_in->diff($office_time);
				$hours_l   = $interval_late->format('%h');
				$minutes_l = $interval_late->format('%i');			
				$total_time_l = $hours_l ."h ".$minutes_l."m";
			}
			
			// total hours work/ed
			$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($employee[0]->user_id,$attendance_date);
			$hrs_old_int1 = 0;
			$Total = '';
			$Trest = '';
			$hrs_old_seconds = 0;
			$hrs_old_seconds_rs = 0;
			$total_time_rs = '';
			$hrs_old_int_res1 = 0;
			foreach ($total_hrs->result() as $hour_work){		
				// total work			
				$timee = $hour_work->total_work.':00';
				$str_time =$timee;
	
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H:i", $hrs_old_int1);	
			}
			if($Total=='') {
				$total_work = '00:00';
			} else {
				$total_work = $Total;
			}
			
			// total rest > 
			$total_rest = $this->Timesheet_model->total_rest_attendance($employee[0]->user_id,$attendance_date);
			foreach ($total_rest->result() as $rest){			
				// total rest
				$str_time_rs = $rest->total_rest.':00';
				//$str_time_rs =$timee_rs;
	
				$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
				
				sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
				
				$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
				
				$hrs_old_int_res1 += $hrs_old_seconds_rs;
				
				$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
			}
			
			// check attendance status
			$status = $attendance[0]->attendance_status;
			if($total_time_rs=='') {
				$Trest = '00:00';
			} else {
				$Trest = $total_time_rs;
			}
		
		} else {
			$clock_in2 = '-';
			$total_time_l = '00:00';
			$total_work = '00:00';
			$Trest = '00:00';
			$clkInIp = $clock_in2;
			// get holiday/leave or absent
			/* attendance status */
			// get holiday
			$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
			$holiday_arr = array();
			if($h_date_chck->num_rows() == 1){
				$h_date = $this->Timesheet_model->holiday_date($attendance_date);
				$begin = new DateTime( $h_date[0]->start_date );
				$end = new DateTime( $h_date[0]->end_date);
				$end = $end->modify( '+1 day' ); 
				
				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				
				foreach($daterange as $date){
					$holiday_arr[] =  $date->format("Y-m-d");
				}
			} else {
				$holiday_arr[] = '99-99-99';
			}
			
			
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($employee[0]->user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($employee[0]->user_id,$attendance_date);
				$begin1 = new DateTime( $leave_date[0]->from_date );
				$end1 = new DateTime( $leave_date[0]->to_date);
				$end1 = $end1->modify( '+1 day' ); 
				
				$interval1 = new DateInterval('P1D');
				$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
				
				foreach($daterange1 as $date1){
					$leave_arr[] =  $date1->format("Y-m-d");
				}	
			} else {
				$leave_arr[] = '99-99-99';
			}
				
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = $this->lang->line('xin_holiday');	
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = $this->lang->line('xin_holiday');
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = $this->lang->line('xin_on_leave');
			} 
			else {
				$status = $this->lang->line('xin_absent');
			}
		}
		
		// check if clock-out for date
		$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->user_id,$attendance_date);		
		if($check_out->num_rows() == 1){
			/* early time */
			$early_time =  new DateTime($out_time.' '.$attendance_date);
			// check clock in time
			$first_out = $this->Timesheet_model->attendance_first_out($employee[0]->user_id,$attendance_date);
			// clock out
			$clock_out = new DateTime($first_out[0]->clock_out);
			
			if ($first_out[0]->clock_out!='') {
				$clock_out2 = $clock_out->format('h:i a');
				$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_out_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkout_ip').'</button>';
				// early leaving
				$early_new_time = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new = strtotime($first_out[0]->clock_out);
			
				if($early_new_time <= $clock_out_time_new) {
					$total_time_e = '00:00';
				} else {			
					$interval_lateo = $clock_out->diff($early_time);
					$hours_e   = $interval_lateo->format('%h');
					$minutes_e = $interval_lateo->format('%i');			
					$total_time_e = $hours_e ."h ".$minutes_e."m";
				}
				
				/* over time */
				$over_time =  new DateTime($out_time.' '.$attendance_date);
				$overtime2 = $over_time->format('h:i a');
				// over time
				$over_time_new = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
				
				if($clock_out_time_new1 <= $over_time_new) {
					$overtime2 = '00:00';
				} else {			
					$interval_lateov = $clock_out->diff($over_time);
					$hours_ov   = $interval_lateov->format('%h');
					$minutes_ov = $interval_lateov->format('%i');			
					$overtime2 = $hours_ov ."h ".$minutes_ov."m";
				}				
				
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$overtime2 = '00:00';
				$clkOutIp = $clock_out2;
			}
					
		} else {
			$clock_out2 =  '-';
			$total_time_e = '00:00';
			$overtime2 = '00:00';
			$clkOutIp = $clock_out2;
		}		
		// user full name
			$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get company
			$company = $this->Xin_model->read_company_info($employee[0]->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}	
			// attendance date
			$tdate = $this->Xin_model->set_date_format($attendance_date);
			/*if($user_info[0]->user_role_id==1){
				$fclckIn = $clkInIp;
				$fclckOut = $clkOutIp;
			} else {
				$fclckIn = $clock_in2;
				$fclckOut = $clock_out2;
			}*/	
			// attendance date
			//$tdate = $this->Xin_model->set_date_format($attendance_date);
			
			$data[] = array(
				$full_name,
				$comp_name,
				$status,
				$tdate,
				$clock_in2,
				$clock_out2,
				$total_work
			);
      }

	  $output = array(
		   "draw" => $draw,
			 //"recordsTotal" => count($date_range),
			 //"recordsFiltered" => count($date_range),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function employee_leave_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_leave", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$sd = $this->uri->segment(4);
		$ed = $this->uri->segment(5);
		$user_id = $this->uri->segment(6);
		$company_id = $this->uri->segment(7);
		if($user_id == '') {
			$employee = $this->Reports_model->get_leave_application_list();
		} else {
			$employee = $this->Reports_model->get_leave_application_filter_list($sd,$ed,$user_id,$company_id);
		}
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			$employee = $this->Xin_model->read_user_info($r->employee_id);
			// user full name 
			if(!is_null($employee)){
				$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			} else {
				$full_name = '--';
			}
			//approved leave
			$rapproved = $this->Reports_model->get_approved_leave_application_list($r->employee_id);
			$approved = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Approved" data-employee_id="'. $r->employee_id . '">'.$rapproved.' '.$this->lang->line('xin_view').'</a>';
			// pending leave
			$rpending = $this->Reports_model->get_pending_leave_application_list($r->employee_id);
			$pending = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Pending" data-employee_id="'. $r->employee_id . '">'.$rpending.' '.$this->lang->line('xin_view').'</a>';
			//upcoming leave
			$rupcoming = $this->Reports_model->get_upcoming_leave_application_list($r->employee_id);
			$upcoming = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Upcoming" data-employee_id="'. $r->employee_id . '">'.$rupcoming.' '.$this->lang->line('xin_view').'</a>';
			//rejected leave
			$rrejected = $this->Reports_model->get_rejected_leave_application_list($r->employee_id);
			$rejected = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Rejected" data-employee_id="'. $r->employee_id . '">'.$rrejected.' '.$this->lang->line('xin_view').'</a>';			
			
			$data[] = array(
				$comp_name,
				$full_name,
				$approved,
				$pending,
				$upcoming,
				$rejected,
			);
      
	  }
	  $output = array(
		   "draw" => $draw,
			 //"recordsTotal" => $employee->num_rows(),
			 //"recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	  public function read_leave_details() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
		//$result = $this->Job_post_model->read_job_application_info($id);
		$data = 'A';
		if(!empty($session)){ 
			$this->load->view('admin/reports/dialog_leave_details', $data);
		} else {
			redirect('admin/');
		}
	}

	 
} 
?>
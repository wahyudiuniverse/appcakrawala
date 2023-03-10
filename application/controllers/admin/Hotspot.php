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

class Hotspot extends MY_Controller
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
		  $this->load->model("Project_model");
     }
	 
	// reports
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'Hotspot | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Hotspot';
		$data['path_url'] = 'access_hotspot';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if(in_array('139',$role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('479',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/access_hotspot", $data, TRUE);
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
	 
	 

	public function report_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/access_hotspot", $data);
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
	

		// if($company_id==0 || is_null($company_id)){
			$employee = $this->Reports_model->filter_employees_hotspot($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		// }else{
		// 	$employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id,$status_resign);
		// }
		
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
				$kontak = '<a href="https://wa.me/62'.$this->Xin_model->clean_post($r->contact_no).'" target="_blank">https://wa.me/62'.$this->Xin_model->clean_post($r->contact_no).'</a>';
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

			$copypaste = '
			<textarea rows="4" cols="20">*C.I.S -> Employees Registration.*&#13;&#10;&#13;&#10;Nama Lengkap: *'.$full_name.'*&#13;&#10;NIP: *'.$r->employee_id.'*&#13;&#10;PIN: *'.$pin.'*&#13;&#10;&#13;&#10;Silahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.*&#13;&#10;Link : *https://apps-cakrawala.com/admin*&#13;&#10;&#13;&#10;Lakukan Pembaharuan PIN anda secara berkala, dengan cara&#13;&#10;Pilih Menu *Employee* kemudian akses Menu *My Profile* dan *Ubah Pin*&#13;&#10;&#13;&#10;Jika ada yang ditanyakan hubungi IT-Care di Nomor Whatsapp: 085174123434&#13;&#10;Terima kasih.&#13;&#10;&#13;&#10;PT SIPRAMA CAKRAWALA SYSTEM</textarea>';

				if($r->status_resign==2){
			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">RESIGN</button>';
				} else if ($r->status_resign==3) {

			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-danger">BLACKLIST</button>';
				} else {

			  		$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-success">ACTIVE</button>';
				}

			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
						
			$data[] = array(
				$stat,
				$r->employee_id,
				$copypaste,
				$kontak,
				$department_name,
				$designation_name,
				$project_name,
				$subproject_name,
				$this->Xin_model->tgl_indo($dob)
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
	
	 
	 
	 
	 
	 
} 
?>
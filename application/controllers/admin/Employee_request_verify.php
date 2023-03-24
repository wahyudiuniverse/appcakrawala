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

class Employee_request_verify extends MY_Controller {
	
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
		$data['title'] = $this->lang->line('xin_request_employee_verified').' | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_request_employee_verified');
		$data['path_url'] = 'emp_request_verify';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('374',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_verify_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/request_verify_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		$employee = $this->Employees_model->get_employees_request_verify();

		$data = array();

          foreach($employee->result() as $r) {
			  
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
			  

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Need Approval</button>';

				$projects = $this->Project_model->read_single_project($r->project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			
				$subprojects = $this->Project_model->read_single_subproject($r->sub_project);
				if(!is_null($subprojects)){
					$nama_subproject = $projects[0]->title;
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
				'idrequest' => $result[0]->secid,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->createdby),
				'verified_by' => $this->Employees_model->read_employee_info($result[0]->verified_by),
				'approved_by' => $this->Employees_model->read_employee_info($result[0]->approved_by),
				// 'idefault_timezone' => $result[0]->default_timezone,

				'createdon' => $result[0]->createdon,
				'modifiedon' => $result[0]->modifiedon,
				
				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_emp_verified', $data);
	}

	public function read_document() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('document_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_document_info($id);
		$data = array(
				'document_id' => $result[0]->document_id,
				'license_name' => $result[0]->license_name,
				'document_type_id' => $result[0]->document_type_id,
				'company_id' => $result[0]->company_id,
				'expiry_date' => $result[0]->expiry_date,
				'license_number' => $result[0]->license_number,
				'license_notification' => $result[0]->license_notification,
				'document' => $result[0]->document,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_document_types' => $this->Employees_model->all_document_types(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/dialog_official_document', $data);
	}

	public function read_info()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_information($id);
		$data = array(
				'company_id' => $result[0]->company_id,
				'name' => $result[0]->name,
				'username' => $result[0]->username,
				'password' => $result[0]->password,
				'type_id' => $result[0]->type_id,
				'government_tax' => $result[0]->government_tax,
				'trading_name' => $result[0]->trading_name,
				'registration_no' => $result[0]->registration_no,
				'email' => $result[0]->email,
				'logo' => $result[0]->logo,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'idefault_currency' => $result[0]->default_currency,
				'idefault_timezone' => $result[0]->default_timezone,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/view_company.php', $data);
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
			

					$count_nip = $this->Xin_model->count_nip();
					$employee_request = $this->Employees_model->read_employee_request($id);


					$fullname = $employee_request[0]->fullname;
					$nama_ibu = $employee_request[0]->nama_ibu;
					$tempat_lahir = $employee_request[0]->tempat_lahir;
					$tanggal_lahir = $employee_request[0]->tanggal_lahir;
					$contact_no = $employee_request[0]->contact_no;
					$nik_ktp = $employee_request[0]->nik_ktp;
					$alamat_ktp = $employee_request[0]->alamat_ktp;
					$no_kk = $employee_request[0]->no_kk;
					$npwp = $employee_request[0]->npwp;
					$email = $employee_request[0]->email;
					$company_id = $employee_request[0]->company_id;
					$location_id = $employee_request[0]->location_id;
					$project = $employee_request[0]->project;
					$sub_project = $employee_request[0]->sub_project;
					$department = $employee_request[0]->department;
					$posisi = $employee_request[0]->posisi;
					$doj = $employee_request[0]->doj;
					$penempatan = $employee_request[0]->penempatan;
					$createdby = $employee_request[0]->createdby;

					// $employee_id = '2'.$employee_request[0]->location_id.$employee_request[0]->department.$count_nip;
					$employee_id = '2'.$employee_request[0]->location_id.$employee_request[0]->department.sprintf("%05d", $count_nip[0]->newcount);
					$private_code = rand(100000,999999);
					$options = array('cost' => 12);
					$password_hash = password_hash($private_code, PASSWORD_BCRYPT, $options);

					$data_migrate = array(
						'employee_id' => $employee_id,
						'username' => $employee_id,
						'first_name' => $fullname,
						'ibu_kandung' => $nama_ibu,
						'company_id' => $company_id,
						'location_id' => $location_id,
						'project_id' => $project,
						'sub_project_id' => $sub_project,
						'department_id' => $department,
						'designation_id' => $posisi,
						'date_of_joining' => $doj,
						'contact_no' => $contact_no,
						'alamat_ktp' => $alamat_ktp,
						'ktp_no' => $nik_ktp,
						'kk_no' => $no_kk,
						'npwp_no' => $npwp,
						'email' => $email,
						'penempatan' => $penempatan,
						'tempat_lahir' => $tempat_lahir,
						'date_of_birth' => $tanggal_lahir,

						'user_role_id' => '2',
						'is_active' => '1',
						'password' => $password_hash,
						'private_code' => $private_code,
						'created_at' => date('Y-m-d h:i:s'),
						'created_by' => $createdby,
					);

			$iresult = $this->Employees_model->add($data_migrate);

			$data_up = array(
				'migrasi' => '1',
				'approved_by' =>  $session['user_id'],
				'approved_date' => date("Y-m-d h:i:s"),
				'modifiedon' => date('Y-m-d h:i:s')
			);
			$result = $this->Employees_model->update_request_employee($data_up,$id);

		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {

					if ($iresult) {
						

							$Return['result'] = $this->lang->line('xin_success_add_employee');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}

			$Return['result'] = $this->lang->line('xin_success_update_company');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}


						// $this->wablas->simple_wa('6281573819104','Contoh Pesan');

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

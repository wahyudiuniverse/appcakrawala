<?php
  /**
 * NOTICE OF LICENSE // REQUEST RESIGN
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author   dndsoft
 * @author-email  komputer.dnd@gmail.com
 * @copyright  Copyright © dndsoft.my.id All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_resign extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		$this->load->model("Esign_model");
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

		$role_resources_ids = $this->Xin_model->user_role_resource();
			$data['title'] = $this->lang->line('xin_resignin_employee').' | '.$this->Xin_model->site_title();
			$data['all_companies'] = $this->Xin_model->get_companies();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			if(in_array('139',$role_resources_ids)) {
				$data['all_emp_active'] = $this->Employees_model->get_all_employees_all();
				$data['all_projects'] = $this->Project_model->get_project_exist_all();
			} else {
				$data['all_emp_active'] = $this->Employees_model->get_all_employees_project();
				$data['all_projects'] = $this->Project_model->get_project_exist();
			}

			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_resignin_employee');
		$data['path_url'] = 'emp_resign';
		if(in_array('490',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/resign_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function resign_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/resign_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		$employee = $this->Employees_model->get_monitoring_rsign();

		$data = array();

          foreach($employee->result() as $r) {
			  
				$project = $r->project_id;
				$nip = $r->employee_id;
				$fullname = $r->first_name;
				$posisi = $r->designation_id;
				$date_of_leaving = $r->date_of_leaving;
				$ktp_no = $r->ktp_no;
				$penempatan = $r->penempatan;
				$approve_resignnae = $r->approve_resignnae;
				$approve_resignnom = $r->approve_resignnom;
				$approve_resignhrd = $r->approve_resignhrd;

				if(is_null($approve_resignnae) || $approve_resignnae=='0'){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->user_id . '">Need Approval NAE</button>';
				} else if(is_null($approve_resignnom) || $approve_resignnom=='0') {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->user_id . '">Need Approval NOM</button>';
				} else if(is_null($approve_resignhrd) || $approve_resignhrd=='0') {

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->user_id . '">Need Approval HRD</button>';
				} else {

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal">Resigned</button>';
				}


				$projects = $this->Project_model->read_single_project($r->project_id);
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

				$designation = $this->Designation_model->read_designation_information($r->designation_id);
				if(!is_null($designation)){
					$designation_name = $designation[0]->designation_name;
				} else {
					$designation_name = '--';	
				}

			$data[] = array(
				$status_migrasi,
				$nip,
				$fullname,
				$nama_project,
				$designation_name,
				$date_of_leaving,
				$penempatan,
				$ktp_no,
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
	
	public function request_employee_resign() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		if($this->input->post('add_type')=='company') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$system = $this->Xin_model->read_setting_info(1);


				if($this->input->post('project_id')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_project');
				} else if($this->input->post('employee_id')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_first_name');
				} else if ($this->input->post('nomor_ktp')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_ktp');
				} else if ($this->input->post('status_resign')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_resign_status');
				} else if ($this->input->post('date_of_leave')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_dol');
				} else if($_FILES['dok_exitc']['size'] == 0){
					$Return['error'] = $this->lang->line('xin_employee_error_exitc');
				} else if($_FILES['dok_sresign']['size'] == 0){
					$Return['error'] = $this->lang->line('xin_employee_error_sresign');
				} else {


			   	$idproject = $this->input->post('project_id');
			   	$id = $this->input->post('employee_id');
			   	$nomor_ktp = $this->input->post('nomor_ktp');
			   	$status_resign	= $this->input->post('status_resign');
					$date_of_leave = $this->input->post('date_of_leave');

					if(is_uploaded_file($_FILES['dok_exitc']['tmp_name'])) {
						//checking image type
						$allowed =  array('png','jpg','jpeg','gif');
						$filename = $_FILES['dok_exitc']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);

						if(in_array($ext,$allowed)){
							$tmp_name = $_FILES["dok_exitc"]["tmp_name"];
							$bill_copy = "uploads/resign/";
							$name = basename($_FILES["dok_exitc"]["name"]);
							$newfilename = 'doc_exit_clearance'.round(microtime(true)).'.'.$ext;
							move_uploaded_file($tmp_name, $bill_copy.$newfilename);
							$fnameExit = $newfilename;

						} else {
							$Return['error'] = $this->lang->line('xin_error_attatchment_type');
						}
					} else {
						$fname = "";
					}

					if(is_uploaded_file($_FILES['dok_sresign']['tmp_name'])) {
						//checking image type
						$allowed_kk =  array('png','jpg','jpeg','gif');
						$filename_kk = $_FILES['dok_sresign']['name'];
						$ext_kk = pathinfo($filename_kk, PATHINFO_EXTENSION);

						if(in_array($ext_kk,$allowed_kk)){
							$tmp_name_kk = $_FILES["dok_sresign"]["tmp_name"];
							$bill_copy_kk = "uploads/resign/";
							$name_kk = basename($_FILES["dok_sresign"]["name"]);
							$newfilename_kk = 'doc_surat_resign'.round(microtime(true)).'.'.$ext_kk;
							move_uploaded_file($tmp_name_kk, $bill_copy_kk.$newfilename_kk);
							$fname_kk = $newfilename_kk;

						} else {
							$Return['error'] = $this->lang->line('xin_error_attatchment_type');
						}
					} else {
						$fname_kk = "";
					}

					if($idproject == 22){
						$data = array(
							'request_resign_by' => $session['user_id'],
							'request_resign_date' => date('Y-m-d h:i:s'),
							'approve_resignnae' => $session['user_id'],
							'approve_resignnae_on' => date('Y-m-d h:i:s'),
							'ktp_no' => $nomor_ktp,																																																								
							'status_resign' => $status_resign,
							'date_of_leaving' => $date_of_leave,
							'dok_exit_clearance' => $fnameExit,
							'date_resign_request' => date('Y-m-d h:i:s')

							// 'pincode' => $this->input->post('pin_code'),
							// 'createdon' => date('Y-m-d h:i:s'),
							// 'createdby' => $session['user_id']
							// 'modifiedon' => date('Y-m-d h:i:s')
						);
					} else {
						$data = array(
							'request_resign_by' => $session['user_id'],
							'request_resign_date' => date('Y-m-d h:i:s'),
							'ktp_no' => $nomor_ktp,																																																								
							'status_resign' => $status_resign,
							'date_of_leaving' => $date_of_leave,
							'dok_exit_clearance' => $fnameExit,
							'date_resign_request' => date('Y-m-d h:i:s')

							// 'pincode' => $this->input->post('pin_code'),
							// 'createdon' => date('Y-m-d h:i:s'),
							// 'createdby' => $session['user_id']
							// 'modifiedon' => date('Y-m-d h:i:s')
						);
					}


					$iresult = $this->Employees_model->request_resign($data,$id);

				}
					if($Return['error']!=''){
					$this->output($Return);
			    }

					if ($iresult) {
							$Return['result'] = $this->lang->line('xin_success_add_employee');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
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
		$result = $this->Employees_model->read_employee_info($id);


		$data = array(
				'idrequest' => $result[0]->user_id,
				'nip' => $result[0]->employee_id,
				'nik_ktp' => $result[0]->ktp_no,
				'fullname' => $result[0]->first_name,
				// 'location_id' => $this->Location_model->read_location_information($result[0]->location_id),
				'project' => $this->Project_model->read_project_information($result[0]->project_id),
				// 'sub_project' => $this->Project_model->read_single_subproject($result[0]->sub_project),
				// 'department' => $this->Department_model->read_department_information($result[0]->department),
				'posisi' => $this->Designation_model->read_designation_information($result[0]->designation_id),
				'doj' => $result[0]->date_of_joining,
				'contact_no' => $result[0]->contact_no,
				// 'email' => $result[0]->migrasi,
				// 'logo' => $result[0]->tgl_migrasi,
				'address' => $result[0]->address,
				'penempatan' => $result[0]->penempatan,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->request_resign_by),
				'request_resign_date' => $result[0]->request_resign_date,
				'approve_nae' => $this->Employees_model->read_employee_info($result[0]->approve_resignnae),
				'approve_resignnae_on' => $result[0]->approve_resignnae_on,
				'approve_nom' => $this->Employees_model->read_employee_info($result[0]->approve_resignnom),
				'approve_resignnom_on' => $result[0]->approve_resignnom_on,
				'approve_hrd' => $this->Employees_model->read_employee_info($result[0]->approve_resignhrd),
				'approve_resignhrd_on' => $result[0]->approve_resignhrd_on,

				// 'createdon' => $result[0]->createdon,
				// 'modifiedon' => $result[0]->modifiedon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_resign_req', $data);
	}

	
	// Validate and update info in database
	public function update() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		if($this->input->post('edit_type')=='company') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		// $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		// $name = $this->input->post('name');
		// $trading_name = $this->input->post('trading_name');
		// $registration_no = $this->input->post('registration_no');
		// $email = $this->input->post('email');
		// $contact_number = $this->input->post('contact_number');
		// $website = $this->input->post('website');
		// $address_1 = $this->input->post('address_1');
		// $address_2 = $this->input->post('address_2');
		// $city = $this->input->post('city');
		// $state = $this->input->post('state');
		// $zipcode = $this->input->post('zipcode');
		// $country = $this->input->post('country');
		// $user_id = $this->input->post('user_id');
		// $file = $_FILES['logo']['tmp_name'];
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		// if($name==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_name_field');
		// } else if( $this->input->post('company_type')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_ctype_field');
		// } else if($contact_number==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_contact_field');
		// } else if($email==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_cemail_field');
		// } else if($website==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_website_field');
		// } else if($city==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_city_field');
		// } else if($zipcode==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		// } else if($country==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// } else if($this->input->post('username')==='') {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_username');
		// } else if($this->input->post('default_currency')==='') {
		// 	$Return['error'] = $this->lang->line('xin_default_currency_field_error');
		// } else if($this->input->post('default_timezone')==='') {
		// 	$Return['error'] = $this->lang->line('xin_default_timezone_field_error');
		// }
	

			$data_up = array(
				'verified_by' =>  $session['user_id'],
				'verified_date' => date("Y-m-d"),
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

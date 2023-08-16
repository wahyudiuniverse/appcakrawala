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

class employee_resign_aphrd extends MY_Controller {
	
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
		$data['title'] = 'Pengajuan Paklaring | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = 'Approval HRD';
		$data['path_url'] = 'emp_resign_approve_hrd';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('494',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/resign_list_apphrd", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/resign_list_apphrd", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		$employee = $this->Employees_model->get_monitoring_rsign_hrd();

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

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->user_id . '">Need Approval NAE</button>';
				} else if(is_null($approve_resignnom) || $approve_resignnom=='0') {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->user_id . '">Need Approval NOM</button>';
				} else if(is_null($approve_resignhrd) || $approve_resignhrd=='0') {

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->user_id . '">Need Approval HRD</button>';
				} else {

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal">Resigned</button>';
				}


				if($r->status_resign==2){
					$status_name = 'RESIGN';
				} else if ($r->status_resign==3){
					$status_name = 'BAD ATITUDE';
				} else if ($r->status_resign==4){
					$status_name = 'END CONTRACT';
				} else {
					$status_name = 'Undefined';
				}


				$vexc = '<a href="'.base_url().'uploads/document/'.$r->dok_exit_clearance.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';

				if(is_null($r->dok_resign_letter)){
					$vsrs = '';
				} else {
					$vsrs = '<a href="'.base_url().'uploads/document/'.$r->dok_resign_letter.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
				}

				if(is_null($r->dok_over_hand)){
					$vhov = '';
				} else {
					$vhov = '<a href="'.base_url().'uploads/document/'.$r->dok_over_hand.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
				}
				
				// $vexc = '<a href="'.base_url().'uploads/document/'.$r->dok_exit_clearance.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/document/'.$r->dok_exit_clearance.'"></a>';

				// $vsrs = '<a href="'.base_url().'uploads/document/'.$r->dok_resign_letter.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/document/'.$r->dok_resign_letter.'"></a>';

				// $vhov = '<a href="'.base_url().'uploads/document/'.$r->dok_over_hand.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/document/'.$r->dok_over_hand.'"></a>';


				$projects = $this->Project_model->read_single_project($r->project_id);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			

			  	$cancel = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="@'. $r->user_id . '">CANCEL</button>';

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

				$dok_p = $vexc.' '.$vsrs.' '.$vhov;

			$data[] = array(
				$status_migrasi.' '.$cancel,
				$nip,
				$fullname,
				$nama_project,
				$designation_name,
				$date_of_leaving,
				$penempatan,
				$ktp_no,
				$status_name,
				$dok_p,
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
		if(empty($session)) { 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

		$idsubmit = substr($this->input->get('company_id'),0,1);
		$id = str_replace("$","",str_replace("@","",$this->input->get('company_id')));

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
				'alamat_ktp' => $result[0]->alamat_ktp,
				'penempatan' => $result[0]->penempatan,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->request_resign_by),
				'request_resign_date' => $result[0]->request_resign_date,
				'approve_nae' => $this->Employees_model->read_employee_info($result[0]->approve_resignnae),
				'approve_resignnae_on' => $result[0]->approve_resignnae_on,
				'approve_nom' => $this->Employees_model->read_employee_info($result[0]->approve_resignnom),
				'approve_resignnom_on' => $result[0]->approve_resignnom_on,
				'approve_hrd' => $this->Employees_model->read_employee_info($result[0]->approve_resignhrd),
				'approve_resignhrd_on' => $result[0]->approve_resignhrd_on,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		if($idsubmit=='$'){
			$this->load->view('admin/employees/dialog_resign_approve_hrd', $data);
		} else {
			$this->load->view('admin/employees/dialog_resign_cancel_hrd', $data);
		}

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
		$cancel = $this->uri->segment(5);
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($cancel=='YES'){

				$data_up = array(
					// 'migrasi' => '1',
					'cancel_resign_stat' =>  1,
					'cancel_date' => date("Y-m-d h:i:s"),
					'cancel_ket' => $this->input->post('ket_revisi'),
					'status_employee' => 0, //0 = resign, 1 = aktif
					'user_role_id' => 2,

				);
			} else {
				$data_up = array(
					// 'migrasi' => '1',
					'approve_resignhrd' =>  $session['user_id'],
					'approve_resignhrd_on' => date("Y-m-d h:i:s"),
					'status_employee' => 0, //0 = resign, 1 = aktif
					'user_role_id' => 9,

				);
			}


			$result = $this->Employees_model->update_resign_apnae($data_up,$id);

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

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

class Employee_pkwt_history extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		$this->load->model("Pkwt_model");
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
		$data['title'] = $this->lang->line('xin_pkwt_digital').' | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_digital');
		$data['path_url'] = 'emp_pkwt_history';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('377',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_list_history", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }


	public function pkwt_list_history() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/pkwt_list_history", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_employees_request_verify();
		// $employee = $this->Employees_model->get_monitoring_rsign_nae();
		// $employee = $this->Pkwt_model->get_monitoring_pkwt_history();
		$employee = $this->Pkwt_model->get_monitoring_pkwt_history($session['employee_id']);
		$no = 1;
		$data = array();

          foreach($employee->result() as $r) {
			  
				// $no = $r->contract_id;
				$nip = $r->employee_id;
				$project = $r->project;
				$jabatan = $r->jabatan;
				$penempatan = $r->penempatan;
				$begin_until = $r->from_date .' s/d ' . $r->to_date;
				$basic_pay = $r->basic_pay;
				$approve_nom = $r->approve_nom;
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Approved</button>';
				

				$emp = $this->Employees_model->read_employee_info_by_nik($nip);
				if(!is_null($emp)){
					$fullname = $emp[0]->first_name;
					$sub_project = 'pkwt'.$emp[0]->sub_project_id;
				} else {
					$fullname = '--';	
					$sub_project = '0';
				}

				$projects = $this->Project_model->read_single_project($project);
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

				// $designation = $this->Designation_model->read_designation_information($r->designation_id);
				// if(!is_null($designation)){
				// 	$designation_name = $designation[0]->designation_name;
				// } else {
				// 	$designation_name = '--';	
				// }

			$view_pkwt = '<a href="'.site_url().'admin/'.$sub_project.'/view/'.$r->uniqueid.'" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-info">VIEW PKWT</button> </a>'; 


			$data[] = array(
				$no,
				$status_migrasi.' '.$view_pkwt,
				$nip,
				$fullname,
				$nama_project,
				$jabatan,
				$penempatan,
				$begin_until,
				 $this->Xin_model->rupiah($basic_pay),
			);
			$no++;
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
		$result = $this->Pkwt_model->read_pkwt_info_by_contractid($id);


				$emp = $this->Employees_model->read_employee_info_by_nik($result[0]->employee_id);
				if(!is_null($emp)){
					$filename_ktp 		= $emp[0]->filename_ktp;
					$filename_kk 			= $emp[0]->filename_kk;
					$filename_skck 		= $emp[0]->filename_skck;
					$filename_isd 		= $emp[0]->filename_isd;
				} else {
					$filename_ktp 		= '0';	
					$filename_kk 			= '0';	
					$filename_skck 		= '0';	
					$filename_isd 		= '0';	
				}


		$data = array(
				'contract_id' => $result[0]->contract_id,
				'no_surat' => $result[0]->no_surat,
				'no_spb' => $result[0]->no_spb,
				'nip' => $result[0]->employee_id,
				'employee' => $this->Employees_model->read_employee_info_by_nik($result[0]->employee_id),
				'company' => $result[0]->company,
				'jabatan' => $result[0]->jabatan,
				'project' => $this->Project_model->read_project_information($result[0]->project),
				'penempatan' => $result[0]->penempatan,

				'ktp' => $filename_ktp,
				'kk' => $filename_kk,
				'skck' => $filename_skck,
				'ijazah' => $filename_isd,
				
				'waktu_kontrak' => $result[0]->waktu_kontrak.' (Bulan)',
				'begin' => $result[0]->from_date . ' s/d '. $result[0]->to_date,
				'hari_kerja' => $result[0]->hari_kerja,
				'basic_pay' => $result[0]->basic_pay,
				'dm_allow_grade' => $result[0]->dm_allow_grade,
				'allowance_grade' => $result[0]->allowance_grade,
				'dm_allow_masakerja' => $result[0]->dm_allow_masakerja,
				'allowance_masakerja' => $result[0]->allowance_masakerja,
				'dm_allow_meal' => $result[0]->dm_allow_meal,
				'allowance_meal' => $result[0]->allowance_meal,
				'dm_allow_transport' => $result[0]->dm_allow_transport,
				'allowance_transport' => $result[0]->allowance_transport,
				'dm_allow_rent' => $result[0]->dm_allow_rent,
				'allowance_rent' => $result[0]->allowance_rent,
				'dm_allow_komunikasi' => $result[0]->dm_allow_komunikasi,
				'allowance_komunikasi' => $result[0]->allowance_komunikasi,
				'dm_allow_park' => $result[0]->dm_allow_park,
				'allowance_park' => $result[0]->allowance_park,
				'dm_allow_residance' => $result[0]->dm_allow_residance,
				'allowance_residance' => $result[0]->allowance_residance,
				'dm_allow_laptop' => $result[0]->dm_allow_laptop,
				'allowance_laptop' => $result[0]->allowance_laptop,
				'dm_allow_kasir' => $result[0]->dm_allow_kasir,
				'allowance_kasir' => $result[0]->allowance_kasir,
				'dm_allow_transmeal' => $result[0]->dm_allow_transmeal,
				'allowance_transmeal' => $result[0]->allowance_transmeal,
				'dm_allow_medicine' => $result[0]->dm_allow_medicine,
				'allowance_medicine' => $result[0]->allowance_medicine,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->request_pkwt),
				'request_date' => $result[0]->request_date,
				'approve_nae' => $this->Employees_model->read_employee_info($result[0]->approve_nae),
				'approve_nae_date' => $result[0]->approve_nae_date,
				'approve_nom' => $this->Employees_model->read_employee_info($result[0]->approve_nom),
				'approve_nom_date' => $result[0]->approve_nom_date,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/pkwt/dialog_pkwt_history', $data);
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
					$address = $employee_request[0]->address;
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
						'address' => $address,
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

}

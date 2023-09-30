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

class employee_request_cancelled extends MY_Controller {
	
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
		$data['title'] = $this->lang->line('xin_request_employee').' | '.$this->Xin_model->site_title();

			$data['all_companies'] = $this->Xin_model->get_companies();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
			$data['list_bank'] = $this->Xin_model->get_bank_code();

		$data['breadcrumbs'] = $this->lang->line('xin_request_employee');
		$data['path_url'] = 'emp_request_cancel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('338',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_list_cancel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list_cancel() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/employees/request_list_cancel", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_request_cancel();
		$employee = $this->Employees_model->get_request_cancel($session['employee_id']);

		$data = array();

          foreach($employee->result() as $r) {
			  $no = $r->secid;
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
				$approved_naeby = $r->approved_naeby;
				$approved_nomby = $r->approved_nomby;
				$approved_hrdby = $r->approved_hrdby;
				$tgl_tolak = $r->cancel_on;
			  

				if($approved_naeby==null){
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Revisi to NAE</button>';
				} else if ($approved_nomby==null) {
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Revisi to NOM</button>';
				} else if ($approved_hrdby==null){
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Revisi to HRD</button>';
				} else {
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->secid . '">Approved</button>';
				}




			$editReq = '<a href="'.site_url().'admin/employee_request_cancelled/request_edit/'.$r->secid.'" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">Edit</button></a>'; 


			$delete = '<button type="button" class="btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '">Delete</button>';


				$projects = $this->Project_model->read_single_project($r->project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			
				$subprojects = $this->Project_model->read_single_subproject($r->sub_project);
				if(!is_null($subprojects)){
					$nama_subproject = $subprojects[0]->sub_project_name;
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
				$no,
				$status_migrasi. ' ' .$editReq.' '.$delete,
				$nik_ktp,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$penempatan,
				$doj,
				$tgl_tolak
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
	

	public function request_edit() { 

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		// $id = '5700';
		$result = $this->Employees_model->read_employee_request($id);
		if(is_null($result)){
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);

		// $company = $this->Xin_model->read_company_info($result[0]->company_id);
		// if(!is_null($company)){
		//   $company_name = $company[0]->name;
		// } else {
		//   $company_name = '--';
		// }

		$department = $this->Department_model->read_department_information($result[0]->department);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}

		$designation = $this->Designation_model->read_designation_information($result[0]->posisi);
		if(!is_null($designation)){
			$edesignation_name = $designation[0]->designation_name;
		} else {
			$edesignation_name = '--';	
		}

		$data = array(

			'title' => 'Edit Permintaan Karyawan Baru',
			'breadcrumbs' => 'REQUEST EDIT >> '. $result[0]->fullname,
			'path_url' => 'emp_request_edit',
			'secid' => $result[0]->secid,
			'employee_id' => $result[0]->nip,
			'nik_ktp' => $result[0]->nik_ktp,
			'fullname' => strtoupper($result[0]->fullname),
			'nama_ibu' => $result[0]->nama_ibu,
			'tempat_lahir' => $result[0]->tempat_lahir,
			'tanggal_lahir' => $result[0]->tanggal_lahir,


			'project_id' => $result[0]->project,
			'project_list' => $this->Project_model->get_project_maping($session['employee_id']),
			'sub_project' => $result[0]->sub_project,
			'sub_project_list' => $this->Project_model->get_sub_project_filter($result[0]->project),
			'department_id' => $result[0]->department,
			'department_name' => $department_name,
			'designation_id' => $result[0]->posisi,
			'designations_list' => $this->Designation_model->all_designations(),
			'date_of_joining' => $result[0]->doj,
			'penempatan' => $result[0]->penempatan,
			'gender' => $result[0]->gender,
			'ethnicity_type' => $result[0]->agama,
			'all_ethnicity' => $this->Xin_model->get_ethnicity_type_result(),
			'marital_status' => $result[0]->status_kawin,

			'ktp_no' => $result[0]->nik_ktp,
			'kk_no' => $result[0]->no_kk,
			'alamat_ktp' => $result[0]->alamat_ktp,
			'alamat_domisili' => $result[0]->alamat_domisili,
			'npwp_no' => $result[0]->npwp,
			'contact_no' => $result[0]->contact_no,
			'email' => $result[0]->email,
			'bank_id' => $result[0]->bank_name,
			'list_bank' => $this->Xin_model->get_bank_code(),
			'nomor_rek' => $result[0]->no_rek,
			'pemilik_rek' => $result[0]->pemilik_rekening,

			// 'filename_ktp' => $result[0]->filename_ktp,
			// 'filename_kk' => $result[0]->filename_kk,
			// 'filename_npwp' => $result[0]->filename_npwp,
			// 'filename_cv' => $result[0]->filename_cv,
			// 'filename_skck' => $result[0]->filename_skck,
			// 'filename_pkwt' => $result[0]->filename_pkwt,
			// 'filename_isd' => $result[0]->filename_isd,
			// 'filename_paklaring' => $result[0]->filename_paklaring,
			
			// 'bpjs_tk_no' => $result[0]->bpjs_tk_no,
			// 'bpjs_tk_status' => $result[0]->bpjs_tk_status,
			// 'bpjs_ks_no' => $result[0]->bpjs_ks_no,
			// 'bpjs_ks_status' => $result[0]->bpjs_ks_status,
			// 'filename_rek' => $result[0]->filename_rek,
			// 'blood_group' => $result[0]->blood_group,
			// 'tinggi_badan' => $result[0]->tinggi_badan,
			// 'berat_badan' => $result[0]->berat_badan,
			// 'profile_picture' => $result[0]->profile_picture,
			// 'company_id' => $result[0]->company_id,
			// 'company_name' => $company_name,
			// 'project_name' => $nama_project,
			// 'sub_project_id' => $result[0]->sub_project_id,
			// 'sub_project_name' => $nama_subproject,

			// 'user_role_id' => $result[0]->user_role_id,
			// 'date_of_leaving' => $result[0]->date_of_leaving,
			// 'wages_type' => $result[0]->wages_type,
			// 'is_active' => $result[0]->is_active,

			'contract_start' => $result[0]->contract_start,
			'contract_end' => $result[0]->contract_end,
			'contract_periode' => $result[0]->contract_periode,
			'hari_kerja' => $result[0]->hari_kerja,
			'cut_start' => $result[0]->cut_start,
			'cut_off' => $result[0]->cut_off,
			'date_payment' => $result[0]->date_payment,
			'basic_salary' => $result[0]->gaji_pokok,
			'allow_jabatan' => $result[0]->allow_jabatan,
			'allow_area' => $result[0]->allow_area,
			'allow_masakerja' => $result[0]->allow_masakerja,
			'allow_trans_meal' => $result[0]->allow_trans_meal,
			'allow_trans_rent' => $result[0]->allow_trans_rent,
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
			
			// 'status_employee' => $result[0]->status_employee,
			// 'deactive_by' => $result[0]->deactive_by,
			// 'deactive_date' => $result[0]->deactive_date,
			// 'deactive_reason' => $result[0]->deactive_reason,


			// 'all_companies' => $this->Xin_model->get_companies(),
			// 'all_departments' => $this->Department_model->all_departments(),
			// 'all_projects' => $this->Project_model->get_all_projects(),
			// 'all_sub_projects' => $this->Project_model->get_sub_project_filter($result[0]->project_id),
			// 'all_designations' => $this->Designation_model->all_designations(),
			// 'all_user_roles' => $this->Roles_model->all_user_roles(),
			// 'facebook_link' => $result[0]->facebook_link,
			// 'twitter_link' => $result[0]->twitter_link,
			// 'blogger_link' => $result[0]->blogger_link,
			// 'linkdedin_link' => $result[0]->linkdedin_link,
			// 'google_plus_link' => $result[0]->google_plus_link,
			// 'instagram_link' => $result[0]->instagram_link,
			// 'pinterest_link' => $result[0]->pinterest_link,
			// 'youtube_link' => $result[0]->youtube_link,
			// 'last_login_date' => $result[0]->last_login_date,
			// 'last_login_date' => $result[0]->last_login_date,
			// 'last_login_ip' => $result[0]->last_login_ip,
			// 'all_countries' => $this->Xin_model->get_countries(),
			// 'all_document_types' => $this->Employees_model->all_document_types(),
			// 'all_document_types_ready' => $this->Employees_model->all_document_types_ready($result[0]->user_id),
			// 'all_education_level' => $this->Employees_model->all_education_level(),
			// 'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			// 'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			// 'all_contract_types' => $this->Employees_model->all_contract_types(),
			// 'all_contracts' => $this->Employees_model->all_contracts(),
			// 'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			// 'all_office_locations' => $this->Location_model->all_office_locations(),
			// 'all_leave_types' => $this->Timesheet_model->all_leave_types()


			);
		
		// if($check_role[0]->user_role_id==1 || $check_role[0]->user_role_id==3 || $check_role[0]->user_role_id==4) {

		// $data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		// } else {

		$data['subview'] = $this->load->view("admin/employees/request_edit", $data, TRUE);
		// }

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


	// Validate and add info in database
	public function request_edit_employee() {
		$session = $this->session->userdata('username');
		if(empty($session)){	
			redirect('admin/');
		}

			// if($this->input->post('add_type')=='company') {
				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				// $system = $this->Xin_model->read_setting_info(1);

					if($this->input->post('fullname')=='') {
						$Return['error'] = 'Nama Lengkap Kosong..!';
					} else if ($this->input->post('nama_ibu')=='') {
						$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					} else if ($this->input->post('tempat_lahir')=='') {
						$Return['error'] = 'Tempat Lahir Kosong..!';
					} 
					else {

							$idrequest 					= $this->input->post('idrequest');
					   	$fullname 					= $this->input->post('fullname');
					   	$nama_ibu						= $this->input->post('nama_ibu');
							$tempat_lahir 			= $this->input->post('tempat_lahir');
							$tanggal_lahir 			= $this->input->post('date_of_birth');
							$jenis_kelamin			= $this->input->post('gender');
							$agama 							= $this->input->post('ethnicity');
							$marital_status			= $this->input->post('marital_status');

							$nomor_ktp					= $this->input->post('nomor_ktp');
							$alamat_ktp					= $this->input->post('alamat_ktp');
							$nomor_kk						= $this->input->post('nomor_kk');
							$alamat_domisili			= $this->input->post('alamat_domisili');
							$npwp								= $this->input->post('npwp');
							$nomor_hp						= $this->input->post('nomor_hp');
							$email							= $this->input->post('email');
							$bank_name					= $this->input->post('bank_name');
							$no_rek							= $this->input->post('no_rek');
							$pemilik_rekening			= $this->input->post('pemilik_rekening');

							$project_id					= $this->input->post('project_id');
							$sub_project				= $this->input->post('sub_project');
							$posisi 							= $this->input->post('posisi');
							$date_of_join 							= $this->input->post('date_of_join');
							$penempatan 							= $this->input->post('penempatan');
							$gaji_pokok 							= $this->input->post('gaji_pokok');
							$tunjangan_jabatan 							= $this->input->post('tunjangan_jabatan');

							$tunjangan_area 							= $this->input->post('tunjangan_area');
							$tunjangan_masakerja 							= $this->input->post('tunjangan_masakerja');
							$tunjangan_makan_trans 							= $this->input->post('tunjangan_makan_trans');
							$tunjangan_trans_rental 							= $this->input->post('tunjangan_trans_rent');
							$tunjangan_makan 							= $this->input->post('tunjangan_makan');
							$tunjangan_transport 							= $this->input->post('tunjangan_transport');
							$tunjangan_komunikasi 							= $this->input->post('tunjangan_komunikasi');
							$tunjangan_device 							= $this->input->post('tunjangan_device');
							$tunjangan_tempat_tinggal 							= $this->input->post('tunjangan_tempat_tinggal');
							$tunjangan_rental 							= $this->input->post('tunjangan_rental');
							$tunjangan_parkir 							= $this->input->post('tunjangan_parkir');
							$tunjangan_kesehatan 							= $this->input->post('tunjangan_kesehatan');
							$tunjangan_akomodasi 							= $this->input->post('tunjangan_akomodasi');
							$tunjangan_kasir 							= $this->input->post('tunjangan_kasir');
							$tunjangan_operational 							= $this->input->post('tunjangan_operational');
							$join_date_pkwt 							= $this->input->post('join_date_pkwt');
							$pkwt_end_date 							= $this->input->post('pkwt_end_date');
							$waktu_kontrak 							= $this->input->post('waktu_kontrak');
							$hari_kerja 							= $this->input->post('hari_kerja');
							$cut_start 							= $this->input->post('cut_start');
							$cut_off 							= $this->input->post('cut_off');
							$date_payment 							= $this->input->post('date_payment');



					if($Return['error']!=''){
					$this->output($Return);
			    }

							$data = array(
								'fullname' 						=> $fullname,
								'nama_ibu' 						=> $nama_ibu,
								'tempat_lahir' 				=> $tempat_lahir,
								'tanggal_lahir' 			=> $tanggal_lahir,
								'gender'							=> $jenis_kelamin,
								'agama' 							=> $agama,
								'status_kawin' 				=> $marital_status,
								'nik_ktp' 						=> $nomor_ktp,
								'alamat_ktp' 					=> $alamat_ktp,
								'no_kk' 							=> $nomor_kk,

								'alamat_domisili' 		=> $alamat_domisili,
								'npwp' 								=> $npwp,
								'contact_no' 					=> $nomor_hp,
								'email' 							=> $email,
								'bank_id' 						=> $bank_name,
								'no_rek' 							=> $no_rek,
								'pemilik_rekening' 		=> $pemilik_rekening,
								'project' 						=> $project_id,
								'sub_project' 				=> $sub_project,
								'posisi' 							=> $posisi,

								'doj' 								=> $date_of_join,
								'penempatan' 					=> $penempatan,
								'gaji_pokok' 					=> str_replace(".","",$gaji_pokok),
								'allow_jabatan' 			=> str_replace(".","",$tunjangan_jabatan),
								'allow_area' 					=> str_replace(".","",$tunjangan_area),
								'allow_masakerja' 		=> str_replace(".","",$tunjangan_masakerja),
								'allow_trans_meal' 		=> str_replace(".","",$tunjangan_makan_trans),
								'allow_trans_rent' 		=> str_replace(".","",$tunjangan_trans_rental),
								'allow_konsumsi' 			=> str_replace(".","",$tunjangan_makan),
								'allow_transport' 		=> str_replace(".","",$tunjangan_transport),
								'allow_comunication' 	=> str_replace(".","",$tunjangan_komunikasi),

								'allow_device' 				=> str_replace(".","",$tunjangan_device),
								'allow_residence_cost'=> str_replace(".","",$tunjangan_tempat_tinggal),
								'allow_rent' 					=> str_replace(".","",$tunjangan_rental),
								'allow_parking' 			=> str_replace(".","",$tunjangan_parkir),
								'allow_medichine' 		=> str_replace(".","",$tunjangan_kesehatan),
								'allow_akomodsasi' 		=> str_replace(".","",$tunjangan_akomodasi),
								'allow_kasir' 				=> str_replace(".","",$tunjangan_kasir),
								'allow_operational' 	=> str_replace(".","",$tunjangan_operational),
								'contract_start' 			=> $join_date_pkwt,
								'contract_end' 				=> $pkwt_end_date,

								'contract_periode' 		=> $waktu_kontrak,
								'hari_kerja' 					=> $hari_kerja,
								'cut_start' 					=> $cut_start,
								'cut_off' 						=> $cut_off,
								'date_payment' 				=> $date_payment,
							);

						$iresult = $this->Employees_model->update_request_employee($data,$idrequest);

					}

		// $Return['result'] = ' ELSE DIBAWAH Permintaan Karyawan berhasil di Ubah..';
				if ($iresult == TRUE) {
					$Return['result'] = $idrequest.' Permintaan Karyawan Baru berhasil di Ubah..';
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				
				

				$this->output($Return);
				exit;
			// }
	}


	// Validate and add info in database
	public function xrequest_edit_employee() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

			if($this->input->post('add_type')=='company') {
				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				// $system = $this->Xin_model->read_setting_info(1);

					if($this->input->post('fullname')=='') {
						$Return['error'] = 'Nama Lengkap Kosong..!';
					} else if ($this->input->post('nama_ibu')=='') {
						$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					} else if ($this->input->post('tempat_lahir')=='') {
						$Return['error'] = 'Tempat Lahir Kosong..!';
					} 

					// else if ($this->input->post('date_of_birth')==''){
					// 	$Return['error'] = 'Tanggal Lahir Kosong..!';
					// } else if ($this->input->post('project_id')==''){
					// 	$Return['error'] = 'Project Kosong..!';
					// } else if ($this->input->post('sub_project_id')==''){
					// 	$Return['error'] = 'Sub Project Kosong..!';
					// } else if ($this->input->post('department_id')==''){
					// 	$Return['error'] = 'Departement Kosong..!';
					// } else if ($this->input->post('posisi')==''){
					// 	$Return['error'] = 'Posisi Jabatan Kosong..!';
					// } else if ($this->input->post('gender')==''){
					// 	$Return['error'] = 'Jenis Kelamin Kosong..!';
					// } else if ($this->input->post('ethnicity')==''){
					// 	$Return['error'] = 'Agama/Kepercayaan Kosong..!';
					// } else if ($this->input->post('marital_status')==''){
					// 	$Return['error'] = 'Status Perkawinan Kosong..!';
					// }

					// else if ($this->input->post('date_of_join')==''){
					// 	$Return['error'] = 'Join Date Kosong..!';
					// } else if ($this->input->post('join_date_pkwt')==''){
					// 	$Return['error'] = 'Join Date PKWT Kosong..!';
					// } else if ($this->input->post('pkwt_end_date')==''){
					// 	$Return['error'] = 'End Date PKWT Kosong..!';
					// } else if ($this->input->post('waktu_kontrak')==''){
					// 	$Return['error'] = 'Periode Kontrak Kosong..!';
					// }

					// else if ($this->input->post('nomor_hp')==''){
					// 	$Return['error'] = 'Nomor Hp Kosong..!';
					// } else if ($this->input->post('nomor_ktp')==''){
					// 	$Return['error'] = 'Nomor KTP Kosong..!';
					// } else if ($this->input->post('alamat_ktp')==''){
					// 	$Return['error'] = 'Alamat KTP Kosong..!';
					// } else if ($this->input->post('alamat_domisili')==''){
					// 	$Return['error'] = 'Alamat Domisili Kosong..!';
					// } else if ($this->input->post('nomor_kk')==''){
					// 	$Return['error'] = 'KK Kosong..!';
					// } else if ($this->input->post('email')==''){
					// 	$Return['error'] = 'Email Kosong..!';
					// } else if ($this->input->post('penempatan')==''){
					// 	$Return['error'] = 'Penempatan Kosong..!';
					// } else if ($this->input->post('hari_kerja')==''){
					// 	$Return['error'] = 'Hari Kerja Kosong..!';
					// } else if ($this->input->post('gaji_pokok')==''){
					// 	$Return['error'] = 'Gaji Pokok Kosong..!';
					// } else if ($this->input->post('bank_name')==''){
					// 	$Return['error'] = 'Nama Bank Kosong..!';
					// } else if ($this->input->post('no_rek')==''){
					// 	$Return['error'] = 'Nomor Rekening Kosong..!';
					// } else if ($this->input->post('pemilik_rekening')==''){
					// 	$Return['error'] = 'Pemilik Rekening Kosong..!';
					// } else if ($this->input->post('cut_start')==''){
					// 	$Return['error'] = 'Tanggal Cut START Kosong..!';
					// } else if ($this->input->post('cut_off')==''){
					// 	$Return['error'] = 'Tanggal Cut OFF Kosong..!';
					// } else if ($this->input->post('date_payment')==''){
					// 	$Return['error'] = 'Tanggal Penggajian Kosong..!';
					// } 

					// else if($_FILES['document_file']['size'] == 0) {
					// 	$Return['error'] = 'KTP Kosongx..!';
					// } else if ($_FILES['document_file']['size'] > 2000000){
					// 	$Return['error'] = 'File KTP Lebih dari 2MB	..';
					// }

					// else if($_FILES['document_kk']['size'] == 0) {
					// 	$Return['error'] = 'KK KosongA..!';
					// } else if ($_FILES['document_kk']['size'] > 2000000){
					// 	$Return['error'] = 'File KK Lebih dari 2MB	..';
					// }

					// else if($_FILES['document_cv']['size'] == 0) {
					// 	$Return['error'] = 'Riwayat Hidup (CV) Kosong..!';
					// } else if ($_FILES['document_cv']['size'] > 2000000){
					// 	$Return['error'] = 'File CV Lebih dari 2MB	..';
					// }

					// else if($_FILES['document_skck']['size'] > 2000000){
					// 	$Return['error'] = 'File SKCK Lebih dari 2MB	..';
					// }

					// else if($_FILES['document_ijz']['size'] == 0) {
					// 	$Return['error'] = 'Ijazah Kosong..!';
					// } else if ($_FILES['document_ijz']['size'] > 2000000){
					// 	$Return['error'] = 'File Ijazah Lebih dari 2MB	..';
					// }

					// else if ($_FILES['document_pkl']['size'] > 2000000){
					// 	$Return['error'] = 'File PAKLARING Lebih dari 2MB	..';
					// }

					else {

					// 		if($_FILES['document_file']['size'] == 0) {
					// 			$fname=0;
					// 		} else {
					// 			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
					// 				//checking image type
					// 				$allowed =  array('png','jpg','jpeg','PNG','JPG','JPEG');
					// 				$filename = $_FILES['document_file']['name'];
					// 				$ext = pathinfo($filename, PATHINFO_EXTENSION);
									
					// 				if(in_array($ext,$allowed)){
					// 					$tmp_name = $_FILES["document_file"]["tmp_name"];
					// 					$documentd = "uploads/document/ktp/";
					// 					// basename() may prevent filesystem traversal attacks;
					// 					// further validation/sanitation of the filename may be appropriate
					// 					$name = basename($_FILES["document_file"]["name"]);
					// 					$newfilename = 'ktp_'.round(microtime(true)).'.'.$ext;
					// 					move_uploaded_file($tmp_name, $documentd.$newfilename);
					// 					$fname = $newfilename;
					// 				} else {
					// 					$fname=0;
					// 					// $Return['error'] = 'Jenis File KTP tidak diterima..';
					// 				}
					// 			}
					// 		}

					// 		if($_FILES['document_kk']['size'] == 0) {
					// 			$fnamekk=0;
					// 		} else {
					// 			if(is_uploaded_file($_FILES['document_kk']['tmp_name'])) {
					// 				//checking image type
					// 				$allowedkk =  array('png','jpg','jpeg','PNG','JPG','JPEG');
					// 				$filenamekk = $_FILES['document_kk']['name'];
					// 				$extkk = pathinfo($filenamekk, PATHINFO_EXTENSION);
									
					// 				if(in_array($extkk,$allowedkk)){
					// 					$tmp_namekk = $_FILES["document_kk"]["tmp_name"];
					// 					$documentdkk = "uploads/document/kk/";
					// 					// basename() may prevent filesystem traversal attacks;
					// 					// further validation/sanitation of the filename may be appropriate
					// 					$name = basename($_FILES["document_kk"]["name"]);
					// 					$newfilenamekk = 'kk_'.round(microtime(true)).'.'.$extkk;
					// 					move_uploaded_file($tmp_namekk, $documentdkk.$newfilenamekk);
					// 					$fnamekk = $newfilenamekk;
					// 				} else {
					// 					$fnamekk=0;
					// 					// $Return['error'] = 'Jenis File KK tidak diterima..';
					// 				}
					// 			}
					// 		}

					// 		if($_FILES['document_cv']['size'] == 0) {
					// 			$fnamecv=0;
					// 		} else {
					// 			if(is_uploaded_file($_FILES['document_cv']['tmp_name'])) {
					// 					//checking image type
					// 					$allowedcv =  array('png','jpg','jpeg','PNG','JPG','JPEG','pdf','PDF');
					// 					$filenamecv = $_FILES['document_cv']['name'];
					// 					$extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
										
					// 					if(in_array($extcv,$allowedcv)){
					// 						$tmp_namecv = $_FILES["document_cv"]["tmp_name"];
					// 						$documentdcv = "uploads/document/cv/";
					// 						// basename() may prevent filesystem traversal attacks;
					// 						// further validation/sanitation of the filename may be appropriate
					// 						$name = basename($_FILES["document_cv"]["name"]);
					// 						$newfilenamecv = 'cv_'.round(microtime(true)).'.'.$extcv;
					// 						move_uploaded_file($tmp_namecv, $documentdcv.$newfilenamecv);
					// 						$fnamecv = $newfilenamecv;
					// 					} else {
					// 						$fnamecv=0;
					// 						// $Return['error'] = 'Jenis File CV tidak diterima..';
					// 					}
					// 			}
					// 		}


					// 		if($_FILES['document_ijz']['size'] == 0) {
					// 			$fnameijz=0;
					// 		} else {
					// 			if(is_uploaded_file($_FILES['document_ijz']['tmp_name'])) {
					// 					//checking image type
					// 					$allowedijz =  array('png','jpg','jpeg','PNG','JPG','JPEG','pdf','PDF');
					// 					$filenameijz = $_FILES['document_ijz']['name'];
					// 					$extijz = pathinfo($filenameijz, PATHINFO_EXTENSION);
										
					// 					if(in_array($extijz,$allowedijz)){
					// 						$tmp_nameijz = $_FILES["document_ijz"]["tmp_name"];
					// 						$documentdijz = "uploads/document/ijazah/";
					// 						// basename() may prevent filesystem traversal attacks;
					// 						// further validation/sanitation of the filename may be appropriate
					// 						$name = basename($_FILES["document_ijz"]["name"]);
					// 						$newfilenameijz = 'ijazah_'.round(microtime(true)).'.'.$extijz;
					// 						move_uploaded_file($tmp_nameijz, $documentdijz.$newfilenameijz);
					// 						$fnameijz = $newfilenameijz;
					// 					} else {
					// 						$fnameijz=0;
					// 						// $Return['error'] = 'Jenis File Ijazah tidak diterima..';
					// 					}
					// 			}
					// 		}
							

					// 		if($_FILES['document_skck']['size'] == 0) {
					// 			$fnameskck=0;
					// 		} else {
					// 				if(is_uploaded_file($_FILES['document_skck']['tmp_name'])) {
					// 					//checking image type
					// 					$allowedskck =  array('pdf','PDF','png','jpg','jpeg','PNG','JPG','JPEG');
					// 					$filenameskck = $_FILES['document_skck']['name'];
					// 					$extskck = pathinfo($filenameskck, PATHINFO_EXTENSION);
										
					// 					if(in_array($extskck,$allowedskck)){
					// 						$tmp_nameskck = $_FILES["document_skck"]["tmp_name"];
					// 						$documentdskck = "uploads/document/skck/";
					// 						// basename() may prevent filesystem traversal attacks;
					// 						// further validation/sanitation of the filename may be appropriate
					// 						$name = basename($_FILES["document_skck"]["name"]);
					// 						$newfilenameskck = 'skck_'.round(microtime(true)).'.'.$extskck;
					// 						move_uploaded_file($tmp_nameskck, $documentdskck.$newfilenameskck);
					// 						$fnameskck = $newfilenameskck;
					// 					} else {
					// 						$fnameskck=0;
					// 						// $Return['error'] = 'Jenis File KK tidak diterima..';
					// 					}
					// 				}
					// 		}


					// 		if($_FILES['document_pkl']['size'] == 0) {
					// 			$fnamepkl=0;
					// 		} else {
					// 				if(is_uploaded_file($_FILES['document_pkl']['tmp_name'])) {
					// 					//checking image type
					// 					$allowedpkl =  array('pdf','PDF','png','jpg','jpeg','PNG','JPG','JPEG');
					// 					$filenamepkl = $_FILES['document_pkl']['name'];
					// 					$extpkl = pathinfo($filenamepkl, PATHINFO_EXTENSION);
										
					// 					if(in_array($extpkl,$allowedpkl)){
					// 						$tmp_namepkl = $_FILES["document_pkl"]["tmp_name"];
					// 						$documentdpkl = "uploads/document/paklaring/";
					// 						// basename() may prevent filesystem traversal attacks;
					// 						// further validation/sanitation of the filename may be appropriate
					// 						$name = basename($_FILES["document_pkl"]["name"]);
					// 						$newfilenamepkl = 'paklaring_'.round(microtime(true)).'.'.$extpkl;
					// 						move_uploaded_file($tmp_namepkl, $documentdpkl.$newfilenamepkl);
					// 						$fnamepkl = $newfilenamepkl;
					// 					} else {
					// 						$fnamepkl=0;
					// 						// $Return['error'] = 'Jenis File Paklaring tidak diterima..';
					// 					}
					// 				}
					// 		}

					   	$fullname 					= str_replace("'"," ",$this->input->post('fullname'));
					   	$nama_ibu						= $this->input->post('nama_ibu');
							$tempat_lahir 			= $this->input->post('tempat_lahir');
							$tanggal_lahir 			= $this->input->post('date_of_birth');

					   	// $company_id					= $this->input->post('company_id');
							// $office_lokasi 			= $this->input->post('office_lokasi');
							// $project_id 				= $this->input->post('project_id');
							// $sub_project_id 		= $this->input->post('sub_project_id');
							// $department_id 			= $this->input->post('department_id');
							// $posisi 						= $this->input->post('posisi');
							// $jenis_kelamin 			= $this->input->post('gender');
							// $agama 							= $this->input->post('ethnicity');
							// $status_kawin 			= $this->input->post('marital_status');

							// $date_of_join 			= $this->input->post('date_of_join');
							// $join_date_pkwt 		= $this->input->post('join_date_pkwt');
							// $pkwt_end_date 			= $this->input->post('pkwt_end_date');
							// $waktu_kontrak 			= $this->input->post('waktu_kontrak');

							// $contact_no 				= $this->input->post('nomor_hp');
							// $ktp_no 						= $this->input->post('nomor_ktp');
							// $alamat_ktp 				= $this->input->post('alamat_ktp');
							// $alamat_domisili 		= $this->input->post('alamat_domisili');
					   	// $nomor_kk						= $this->input->post('nomor_kk');
					   	// $npwp								= $this->input->post('npwp');
					   	// $email							= $this->input->post('email');
							// $penempatan 				= $this->input->post('penempatan');
							// $hari_kerja 				= $this->input->post('hari_kerja');

							// $bank_name 					= $this->input->post('bank_name');
							// $no_rek 						= $this->input->post('no_rek');
							// $pemilik_rekening 	= $this->input->post('pemilik_rekening');

							// $gaji_pokok 					= $this->Xin_model->clean_number($this->input->post('gaji_pokok'));
							// $allow_jabatan 				= $this->Xin_model->clean_number($this->input->post('tunjangan_jabatan'));
							// $allow_area 					= $this->Xin_model->clean_number($this->input->post('tunjangan_area'));
							// $allow_masakerja			= $this->Xin_model->clean_number($this->input->post('tunjangan_masakerja'));
							// $allow_trans_meal 		= $this->Xin_model->clean_number($this->input->post('tunjangan_makan_trans'));
							// $allow_konsumsi 			= $this->Xin_model->clean_number($this->input->post('tunjangan_makan'));
							// $allow_transport			= $this->Xin_model->clean_number($this->input->post('tunjangan_transport'));
							// $allow_comunication 	= $this->Xin_model->clean_number($this->input->post('tunjangan_komunikasi'));
							// $allow_device					= $this->Xin_model->clean_number($this->input->post('tunjangan_device'));
							// $allow_residence_cost	= $this->Xin_model->clean_number($this->input->post('tunjangan_tempat_tinggal'));
							// $allow_rental					= $this->Xin_model->clean_number($this->input->post('tunjangan_rental'));
							// $allow_parking				= $this->Xin_model->clean_number($this->input->post('tunjangan_parkir'));
							// $allow_medichine			= $this->Xin_model->clean_number($this->input->post('tunjangan_kesehatan'));
							// $allow_akomodsasi			= $this->Xin_model->clean_number($this->input->post('tunjangan_akomodasi'));
							// $allow_kasir 					= $this->Xin_model->clean_number($this->input->post('tunjangan_kasir'));
							// $allow_operational		= $this->Xin_model->clean_number($this->input->post('tunjangan_operational'));

							// $cut_start			= $this->input->post('cut_start');
							// $cut_off 					= $this->input->post('cut_off');
							// $date_payment		= $this->input->post('date_payment');

							// $options = array('cost' => 12);
							// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
							// $leave_categories = array($this->input->post('leave_categories'));
							// $cat_ids = implode(',',$this->input->post('leave_categories'));

							$data = array(
								'fullname' 						=> $fullname,
								'nama_ibu' 						=> $nama_ibu,
								'tempat_lahir' 				=> $tempat_lahir,
								'tanggal_lahir' 			=> $tanggal_lahir,

								// 'company_id' 					=> $company_id,
								// 'location_id' 				=> '1',
								// 'project' 						=> $project_id,
								// 'sub_project' 				=> $sub_project_id,
								// 'department' 					=> $department_id,
								// 'posisi' 							=> $posisi,
								// 'gender' 							=> $jenis_kelamin,
								// 'agama' 							=> $agama,
								// 'status_kawin' 				=> $status_kawin,

								// 'doj' 								=> $date_of_join,
								// 'contract_start' 			=> $join_date_pkwt,
								// 'contract_end' 				=> $pkwt_end_date,
								// 'contract_periode' 		=> $waktu_kontrak,
								// 'contact_no' 					=> $contact_no,
								// 'nik_ktp' 						=> $ktp_no,
								// 'alamat_ktp' 					=> $alamat_ktp,
								// 'alamat_domisili' 		=> $alamat_domisili,
								// 'no_kk' 							=> $nomor_kk,
								// 'npwp' 								=> $npwp,
								// 'email' 							=> $email,
								// 'penempatan' 					=> $penempatan,
								// 'hari_kerja' 					=> $hari_kerja,
								// 'bank_id' 						=> $bank_name,
								// 'no_rek' 							=> $no_rek,
								// 'pemilik_rekening' 		=> $pemilik_rekening,

								// 'gaji_pokok' 						=> $gaji_pokok,
								// 'allow_jabatan' 				=> $allow_jabatan,
								// 'allow_area' 						=> $allow_area,
								// 'allow_masakerja' 			=> $allow_masakerja,
								// 'allow_trans_meal'			=> $allow_trans_meal,
								// 'allow_konsumsi'				=> $allow_konsumsi,
								// 'allow_transport'				=> $allow_transport,
								// 'allow_comunication'		=> $allow_comunication,
								// 'allow_device'					=> $allow_device,
								// 'allow_residence_cost'	=> $allow_residence_cost,
								// 'allow_rent'						=> $allow_rental,
								// 'allow_parking'					=> $allow_parking,
								// 'allow_medichine'				=> $allow_medichine,
								// 'allow_akomodsasi'			=> $allow_akomodsasi,
								// 'allow_kasir'						=> $allow_kasir,
								// 'allow_operational'			=> $allow_operational,

								// 'cut_start'							=> $cut_start,
								// 'cut_off'								=> $cut_off,
								// 'date_payment'					=> $date_payment,
								// 'ktp'										=> $fname,
								// 'kk'										=> $fnamekk,
								// 'skck'									=> $fnameskck,
								// 'ijazah'								=> $fnameijz,
								// 'civi'									=> $fnamecv,
								// 'paklaring'							=> $fnamepkl,
								// 'request_empby' 				=> $session['user_id'],
								// 'request_empon' 				=> date("Y-m-d h:i:s"),

								// 'pincode' => $this->input->post('pin_code'),
								// 'createdon' => date('Y-m-d h:i:s'),
								// 'createdby' => $session['user_id']
								// 'modifiedon' => date('Y-m-d h:i:s')
							);
						$iresult = $this->Employees_model->update_request_employee($data);
					}

					if($Return['error']!=''){
					$this->output($Return);
			    }

				if ($iresult == TRUE) {
					$Return['result'] = 'Permintaan Karyawan berhasil di Ubah..';
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
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

				'waktu_kontrak' => $result[0]->contract_periode.' (Bulan)',
				'begin' => $result[0]->contract_start . ' s/d '. $result[0]->contract_end,
				'hari_kerja' => $result[0]->hari_kerja,
				'basic_pay' => $result[0]->gaji_pokok,
				'dm_allow_grade' => $result[0]->dm_allow_jabatan,
				'allowance_grade' => $result[0]->allow_jabatan,
				'dm_allow_area' => $result[0]->dm_allow_area,
				'allowance_area' => $result[0]->allow_area,
				'dm_allow_masakerja' => $result[0]->dm_allow_masakerja,
				'allowance_masakerja' => $result[0]->allow_masakerja,
				'dm_allow_transmeal' => $result[0]->dm_allow_transmeal,
				'allowance_transmeal' => $result[0]->allow_trans_meal,
				'dm_allow_meal' => $result[0]->dm_allow_konsumsi,
				'allowance_meal' => $result[0]->allow_konsumsi,
				'dm_allow_transport' => $result[0]->dm_allow_transport,
				'allowance_transport' => $result[0]->allow_transport,
				'dm_allow_komunikasi' => $result[0]->dm_allow_comunication,
				'allowance_komunikasi' => $result[0]->allow_comunication,
				'dm_allow_laptop' => $result[0]->dm_allow_device,
				'allowance_laptop' => $result[0]->allow_device,
				'dm_allow_residance' => $result[0]->dm_allow_residance,
				'allowance_residance' => $result[0]->allow_residence_cost,
				'dm_allow_rent' => $result[0]->dm_allow_rent,
				'allowance_rent' => $result[0]->allow_rent,
				'dm_allow_park' => $result[0]->dm_allow_park,
				'allowance_park' => $result[0]->allow_parking,
				'dm_allow_medicine' => $result[0]->dm_allow_medicine,
				'allowance_medicine' => $result[0]->allow_medichine,
				'dm_allow_akomodasi' => $result[0]->dm_allow_akomodasi,
				'allow_akomodsasi' => $result[0]->allow_akomodsasi,
				'dm_allow_kasir' => $result[0]->dm_allow_kasir,
				'allowance_kasir' => $result[0]->allow_kasir,
				'dm_allow_operational' => $result[0]->dm_allow_operational,
				'allow_operational' => $result[0]->allow_operational,
				
				'ktp' => $result[0]->ktp,
				'kk' => $result[0]->kk,
				'skck' => $result[0]->skck,
				'ijazah' => $result[0]->ijazah,
				'cv' => $result[0]->civi,
				'paklaring' => $result[0]->paklaring,

				'info_revisi' => $result[0]->cancel_ket,
				'idrequest' => $result[0]->secid,
				'request_empby' => $this->Employees_model->read_employee_info($result[0]->request_empby),
				'request_empon' => $result[0]->request_empon,
				'approved_naeby' => $this->Employees_model->read_employee_info($result[0]->approved_naeby),
				'approved_naeon' => $result[0]->approved_naeon,
				'approved_nomby' => $this->Employees_model->read_employee_info($result[0]->approved_nomby),
				'approved_nomon' => $result[0]->approved_nomon,
				'approved_hrdby' => $this->Employees_model->read_employee_info($result[0]->approved_hrdby),
				'approved_hrdon' => $result[0]->approved_hrdon,

				// 'createdon' => $result[0]->createdon,
				// 'modifiedon' => $result[0]->modifiedon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_emp_cancel', $data);
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
		


							if($_FILES['document_ktp']['size'] == 0) {
								$fnamektp=$this->input->post('fktp_name');
							} else {
								// if($_FILES['document_ktp']['size'] > 2000000){
								// 	$Return['error'] = 'File KTP Lebih dari 2MB	..';
								// } else {
									if(is_uploaded_file($_FILES['document_ktp']['tmp_name'])) {
										//checking image type
										$allowedktp =  array('png','jpg','jpeg','pdf');
										$filenamektp = $_FILES['document_ktp']['name'];
										$extktp = pathinfo($filenamektp, PATHINFO_EXTENSION);
										
										if(in_array($extktp,$allowedktp)){
											$tmp_namektp = $_FILES["document_ktp"]["tmp_name"];
											$documentdktp = "uploads/document/ktp/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_ktp"]["name"]);
											$newfilenamektp = 'ktp_'.round(microtime(true)).'.'.$extktp;
											move_uploaded_file($tmp_namektp, $documentdktp.$newfilenamektp);
											$fnamektp = $newfilenamektp;
										} else {
											$Return['error'] = 'Jenis File KTP tidak diterima..';
										}
									}
								// }
							}


							if($_FILES['document_kk']['size'] == 0) {$fnamekk=$this->input->post('fkk_name');} else {
								if(is_uploaded_file($_FILES['document_kk']['tmp_name'])) {
									//checking image type
									$allowedkk =  array('png','jpg','jpeg','pdf');
									$filenamekk = $_FILES['document_kk']['name'];
									$extkk = pathinfo($filenamekk, PATHINFO_EXTENSION);
									
									if(in_array($extkk,$allowedkk)){
										$tmp_namekk = $_FILES["document_kk"]["tmp_name"];
										$documentdkk = "uploads/document/kk/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_kk"]["name"]);
										$newfilenamekk = 'kk_'.round(microtime(true)).'.'.$extkk;
										move_uploaded_file($tmp_namekk, $documentdkk.$newfilenamekk);
										$fnamekk = $newfilenamekk;
									} else {
										$Return['error'] = 'Jenis File KK tidak diterima..';
									}
								}
							}

							if($_FILES['document_skck']['size'] == 0) {$fnameskck=$this->input->post('fskck_name');} else {
								if(is_uploaded_file($_FILES['document_skck']['tmp_name'])) {
									//checking image type
									$allowedskck =  array('png','jpg','jpeg','pdf');
									$filenameskck = $_FILES['document_skck']['name'];
									$extskck = pathinfo($filenameskck, PATHINFO_EXTENSION);
									
									if(in_array($extskck,$allowedskck)){
										$tmp_nameskck = $_FILES["document_skck"]["tmp_name"];
										$documentdskck = "uploads/document/skck/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_skck"]["name"]);
										$newfilenameskck = 'skck_'.round(microtime(true)).'.'.$extskck;
										move_uploaded_file($tmp_nameskck, $documentdskck.$newfilenameskck);
										$fnameskck = $newfilenameskck;
									} else {
										$Return['error'] = 'Jenis File SKCK tidak diterima..';
									}
								}
							}

							if($_FILES['document_ijazah']['size'] == 0) {
								$fnameijazah=$this->input->post('fijz_name');
							} else {
								if(is_uploaded_file($_FILES['document_ijazah']['tmp_name'])) {
									//checking image type
									$allowedijazah =  array('png','jpg','jpeg','pdf');
									$filenameijazah = $_FILES['document_ijazah']['name'];
									$extijazah = pathinfo($filenameijazah, PATHINFO_EXTENSION);
									
									if(in_array($extijazah,$allowedijazah)){
										$tmp_nameijazah = $_FILES["document_ijazah"]["tmp_name"];
										$documentdijazah = "uploads/document/ijazah/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_ijazah"]["name"]);
										$newfilenameijazah = 'ijz_'.round(microtime(true)).'.'.$extijazah;
										move_uploaded_file($tmp_nameijazah, $documentdijazah.$newfilenameijazah);
										$fnameijazah = $newfilenameijazah;
									} else {
										$Return['error'] = 'Jenis File IJAZAH tidak diterima..';
									}
								}
							}


								if($_FILES['document_cv']['size'] == 0) {
									$fname_cv = $this->input->post('fcivi_name');
								} else {
									if(is_uploaded_file($_FILES['document_cv']['tmp_name'])) {
										//checking image type
										$allowed_cv =  array('png','jpg','jpeg','pdf');
										$filename_cv = $_FILES['document_cv']['name'];
										$ext_cv = pathinfo($filename_cv, PATHINFO_EXTENSION);
										
										if(in_array($ext_cv,$allowed_cv)){
											$tmp_name_cv = $_FILES["document_cv"]["tmp_name"];
											$documentd_cv = "uploads/document/cv/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_cv"]["name"]);
											$newfilename_cv = 'cv_'.round(microtime(true)).'.'.$ext_cv;
											move_uploaded_file($tmp_name_cv, $documentd_cv.$newfilename_cv);
											$fname_cv = $newfilename_cv;
										} else {
											$Return['error'] = 'Jenis File CV tidak diterima..';
										}
									}
								}

			$data_up = array(
				'ktp'							=> $fnamektp,
				'kk'							=> $fnamekk,
				'skck'						=> $fnameskck,
				'ijazah'					=> $fnameijazah,
				'civi'						=> $fname_cv,
				'cancel_stat'			=> 0,
				'verified_by' 			=>  $session['user_id'],
				'verified_date' 			=> date('Y-m-d h:i:s')
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
			$result = $this->Employees_model->delete_new_emp($id);
			if(isset($id)) {
				$Return['result'] = 'Delete Karyawan Baru Tolak berhasil.';
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}

}

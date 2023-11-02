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

class Employee_pkwt_cancel extends MY_Controller {
	
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
		$this->load->model("Pkwt_model");
		$this->load->library('wablas');
		$this->load->library('ciqrcode');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()) { 
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
		$data['title'] = 'PKWT DITOLAK | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = 'PKWT DITOLAK';
		$data['path_url'] = 'emp_pkwt_cancel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('379',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_list_appcancel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function pkwt_list_appcancel() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/pkwt_list_appcancel", $data);
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
		$employee = $this->Pkwt_model->get_monitoring_pkwt_cancel($session['employee_id']);

		$data = array();

          foreach($employee->result() as $r) {
			  
				$nip = $r->employee_id;
				$project = $r->project;
				$jabatan = $r->jabatan;
				$penempatan = $r->penempatan;
				$begin_until = $r->from_date .' s/d ' . $r->to_date;
				$basic_pay = $r->basic_pay;
				$approve_nom = $r->approve_nom;
				$approve_nae = $r->approve_nae;
				$cancel_on = $r->cancel_on;

				if($approve_nae=='0') {

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Need Approval NAE</button>';
			  	
				} else if($approve_nom=='0'){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Need Approval NOM</button>';
				} else {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->contract_id . '">Need Approval HRD</button>';
				}

			$editReq = '<a href="'.site_url().'admin/employee_pkwt_cancel/pkwt_edit/'.$r->contract_id.'" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">Edit</button></a>'; 

			$delete = '<button type="button" class="btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contract_id . '">Delete</button>';


				$emp = $this->Employees_model->read_employee_info_by_nik($nip);
				if(!is_null($emp)){
					$fullname = $emp[0]->first_name;
				} else {
					$fullname = '--';	
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

				$designation = $this->Designation_model->read_designation_information($r->jabatan);
				if(!is_null($designation)){
					$designation_name = $designation[0]->designation_name;
				} else {
					$designation_name = '--';	
				}

			$data[] = array(
				$status_migrasi.' '.$editReq. ' '.$delete,
				$nip,
				$fullname,
				$nama_project,
				$designation_name,
				$penempatan,
				$begin_until,
				$cancel_on,
				 // $this->Xin_model->rupiah($basic_pay),
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
	


	public function pkwt_edit() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		// $id = '5700';
		$result = $this->Pkwt_model->read_pkwt_info($id);
		if(is_null($result)){
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);


		$emp_info = $this->Employees_model->read_employee_information_nip($result[0]->employee_id);
		if(!is_null($emp_info)){
		  $fullname = $emp_info[0]->first_name;
		  $ibu_kandung = $emp_info[0]->ibu_kandung;
		  $ktp_no = $emp_info[0]->ktp_no;
		  $tempat_lahir = $emp_info[0]->tempat_lahir;
		  $date_of_birth = $emp_info[0]->date_of_birth;
		  $sub_project = $emp_info[0]->sub_project_id;
		  $department = $emp_info[0]->department_id;

		  $kk_no = $emp_info[0]->kk_no;
		  $alamat_ktp = $emp_info[0]->alamat_ktp;
		  $alamat_domisili = $emp_info[0]->alamat_domisili;
		  $npwp_no = $emp_info[0]->npwp_no;
		  $contact_no = $emp_info[0]->contact_no;
		  $email = $emp_info[0]->email;
		  $date_of_joining = $emp_info[0]->date_of_joining;
		  $gender = $emp_info[0]->gender;
		  $ethnicity_type = $emp_info[0]->ethnicity_type;
		  $marital_status = $emp_info[0]->marital_status;

		  $fullname = $emp_info[0]->first_name;
		  $fullname = $emp_info[0]->first_name;
		} else {
		  $fullname = '--';
		  $ibu_kandung = '--';
		  $ktp_no = '--';
		  $tempat_lahir = '--';
		  $date_of_birth = '--';

		  $sub_project = '-';
		  $department = '-';

		}

		// $company = $this->Xin_model->read_company_info($result[0]->company_id);
		// if(!is_null($company)){
		//   $company_name = $company[0]->name;
		// } else {
		//   $company_name = '--';
		// }

		// $department = $this->Department_model->read_department_information($result[0]->department);
		// if(!is_null($department)){
		// 	$department_name = $department[0]->department_name;
		// } else {
		// 	$department_name = '--';	
		// }

		// $designation = $this->Designation_model->read_designation_information($result[0]->posisi);
		// if(!is_null($designation)){
		// 	$edesignation_name = $designation[0]->designation_name;
		// } else {
		// 	$edesignation_name = '--';	
		// }

		$data = array(

			'title' => 'Edit PKWT Karyawan',
			'breadcrumbs' => 'PKWT EDIT >> '. $result[0]->employee_id,
			'path_url' => 'emp_pkwt_edit',

			'secid' => $result[0]->contract_id,
			'employee_id' => $result[0]->employee_id,
			'fullname' => strtoupper($fullname),
			'nik_ktp' => $ktp_no,
			'nama_ibu' => $ibu_kandung,
			'tempat_lahir' => $tempat_lahir,
			'tanggal_lahir' => $date_of_birth,


			'project_id' => $result[0]->project,
			'project_list' => $this->Project_model->get_project_maping($session['employee_id']),


			'sub_project_id' => $sub_project,
			'sub_project_list' => $this->Project_model->get_sub_project_filter($result[0]->project),

			'sub_project' => $sub_project,

			'designation_id' => $result[0]->jabatan,
			'designations_list' => $this->Designation_model->all_designations(),
			'date_of_joining' => $date_of_joining,
			'penempatan' => $result[0]->penempatan,
			'gender' => $gender,
			'ethnicity_type' => $ethnicity_type,
			'all_ethnicity' => $this->Xin_model->get_ethnicity_type_result(),
			'marital_status' => $marital_status,

			'ktp_no' => $ktp_no,
			'kk_no' => $kk_no,
			'alamat_ktp' => $alamat_ktp,
			'alamat_domisili' => $alamat_domisili,
			'npwp_no' => $npwp_no,
			'contact_no' => $contact_no,
			'email' => $email,

			'contract_start' => $result[0]->from_date,
			'contract_end' => $result[0]->to_date,
			'contract_periode' => $result[0]->waktu_kontrak,
			'hari_kerja' => $result[0]->hari_kerja,
			'cut_start' => $result[0]->start_period_payment,
			'cut_off' => $result[0]->end_period_payment,
			'date_payment' => $result[0]->tgl_payment,
			'basic_salary' => $result[0]->basic_pay,
			'allow_jabatan' => $result[0]->allowance_grade,
			'allow_area' => $result[0]->allowance_area,
			'allow_masakerja' => $result[0]->allowance_masakerja,
			'allow_trans_meal' => $result[0]->allowance_transmeal,
			'allow_konsumsi' => $result[0]->allowance_meal,
			'allow_transport' => $result[0]->allowance_transport,
			'allow_comunication' => $result[0]->allowance_komunikasi,
			'allow_device' => $result[0]->allowance_laptop,
			'allow_residence_cost' => $result[0]->allowance_residance,
			'allow_rent' => $result[0]->allowance_rent,
			'allow_parking' => $result[0]->allowance_park,
			'allow_medichine' => $result[0]->allowance_medicine,
			'allow_akomodsasi' => $result[0]->allowance_akomodasi,
			'allow_kasir' => $result[0]->allowance_kasir,
			'allow_operational' => $result[0]->allowance_operation,
			
			// 'status_employee' => $result[0]->status_employee,
			// 'deactive_by' => $result[0]->deactive_by,
			// 'deactive_date' => $result[0]->deactive_date,
			// 'deactive_reason' => $result[0]->deactive_reason,

			);
		
		// if($check_role[0]->user_role_id==1 || $check_role[0]->user_role_id==3 || $check_role[0]->user_role_id==4) {

		// $data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		// } else {

		$data['subview'] = $this->load->view("admin/pkwt/pkwt_edit", $data, TRUE);
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
	public function pkwt_edit_request() {
		$session = $this->session->userdata('username');
		if(empty($session)){	
			redirect('admin/');
		}

			// if($this->input->post('add_type')=='company') {
				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				// $system = $this->Xin_model->read_setting_info(1);

					if($this->input->post('gaji_pokok')=='') {
						$Return['error'] = 'Gaji Pokok Kosong..!';
					} 
						// else if ($this->input->post('nama_ibu')=='') {
					// 	$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					// } else if ($this->input->post('tempat_lahir')=='') {
					// 	$Return['error'] = 'Tempat Lahir Kosong..!';
					// } 
					else {

							$idrequest 					= $this->input->post('idrequest');
					   	// $fullname 					= $this->input->post('fullname');
					   	// $nama_ibu						= $this->input->post('nama_ibu');
							// $tempat_lahir 			= $this->input->post('tempat_lahir');
							// $tanggal_lahir 			= $this->input->post('date_of_birth');
							// $jenis_kelamin			= $this->input->post('gender');
							// $agama 							= $this->input->post('ethnicity');
							// $marital_status			= $this->input->post('marital_status');

							// $nomor_ktp					= $this->input->post('nomor_ktp');
							// $alamat_ktp					= $this->input->post('alamat_ktp');
							// $nomor_kk						= $this->input->post('nomor_kk');
							// $alamat_domisili			= $this->input->post('alamat_domisili');
							// $npwp								= $this->input->post('npwp');
							// $nomor_hp						= $this->input->post('nomor_hp');
							// $email							= $this->input->post('email');
							// $bank_name					= $this->input->post('bank_name');
							// $no_rek							= $this->input->post('no_rek');
							// $pemilik_rekening			= $this->input->post('pemilik_rekening');

							// $project_id					= $this->input->post('project_id');
							// $sub_project				= $this->input->post('sub_project');
							$jabatan 							= $this->input->post('posisi');
							// $date_of_join 							= $this->input->post('date_of_join');
							$penempatan 							= $this->input->post('penempatan');
							$gaji_pokok 							= $this->input->post('gaji_pokok');
							$tunjangan_jabatan 							= $this->input->post('tunjangan_jabatan');
							$tunjangan_area 							= $this->input->post('tunjangan_area');
							$tunjangan_masakerja 							= $this->input->post('tunjangan_masakerja');
							$tunjangan_makan 							= $this->input->post('tunjangan_makan');
							$tunjangan_transport 							= $this->input->post('tunjangan_transport');
							$tunjangan_komunikasi 							= $this->input->post('tunjangan_komunikasi');
							$tunjangan_makan_trans 							= $this->input->post('tunjangan_makan_trans');
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
						}


					if($Return['error']!=''){
					$this->output($Return);


			    }

							$data = array(
								// 'fullname' 						=> $fullname,
								// 'nama_ibu' 						=> $nama_ibu,
								// 'tempat_lahir' 				=> $tempat_lahir,
								// 'tanggal_lahir' 			=> $tanggal_lahir,
								// 'gender'							=> $jenis_kelamin,
								// 'agama' 							=> $agama,
								// 'status_kawin' 				=> $marital_status,
								// 'nik_ktp' 						=> $nomor_ktp,
								// 'alamat_ktp' 					=> $alamat_ktp,
								// 'no_kk' 							=> $nomor_kk,

								// 'alamat_domisili' 		=> $alamat_domisili,
								// 'npwp' 								=> $npwp,
								// 'contact_no' 					=> $nomor_hp,
								// 'email' 							=> $email,
								// 'bank_id' 						=> $bank_name,
								// 'no_rek' 							=> $no_rek,
								// 'pemilik_rekening' 		=> $pemilik_rekening,
								// 'project' 						=> $project_id,
								// 'sub_project' 				=> $sub_project,
								'jabatan' 							=> $jabatan,

								// 'doj' 								=> $date_of_join,
								'penempatan' 					=> $penempatan,
								'basic_pay' 					=> $gaji_pokok,
								'allowance_grade' 			=> $tunjangan_jabatan,
								'allowance_area' 					=> $tunjangan_area,
								'allowance_masakerja' 		=> $tunjangan_masakerja,
								'allowance_meal' 			=> $tunjangan_makan,
								'allowance_transport' 		=> $tunjangan_transport,
								'allowance_komunikasi' 	=> $tunjangan_komunikasi,

								'allowance_rent' 					=> $tunjangan_rental,
								'allowance_park' 			=> $tunjangan_parkir,
								'allowance_transmeal' 		=> $tunjangan_makan_trans,
								'allowance_residance'=> $tunjangan_tempat_tinggal,
								'allowance_laptop' 				=> $tunjangan_device,
								
								'allowance_medicine' 		=> $tunjangan_kesehatan,
								'allowance_akomodasi' 		=> $tunjangan_akomodasi,
								'allowance_kasir' 				=> $tunjangan_kasir,
								'allowance_operation' 	=> $tunjangan_operational,
								'from_date' 			=> $join_date_pkwt,
								'to_date' 				=> $pkwt_end_date,
								'waktu_kontrak' 		=> $waktu_kontrak,
								'hari_kerja' 					=> $hari_kerja,
								'start_period_payment' 					=> $cut_start,
								'end_period_payment' 						=> $cut_off,
								'tgl_payment' 				=> $date_payment,
							);

						$iresult = $this->Pkwt_model->update_pkwt_edit($data,$idrequest);

					// }

				if ($iresult == TRUE) {
					$Return['result'] = $idrequest.' Permintaan Karyawan Baru berhasil di Ubah..';
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				
				// $Return['result'] = $idrequest.' Permintaan Karyawan Baru berhasil di Ubah..';

				$this->output($Return);
				exit;
			// }
	}


	public function pkwt_expired_edit() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$edit_approve = $this->uri->segment(5);
		// $id = '5700';
		// $result = $this->Pkwt_model->read_pkwt_info($id);
		$result = $this->Employees_model->read_employee_expired($id);
		if(is_null($result)){
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);


		$emp_info = $this->Employees_model->read_employee_information_nip($result[0]->employee_id);
		if(!is_null($emp_info)){
		  $fullname = $emp_info[0]->first_name;
		  $ibu_kandung = $emp_info[0]->ibu_kandung;
		  $ktp_no = $emp_info[0]->ktp_no;
		  $tempat_lahir = $emp_info[0]->tempat_lahir;
		  $date_of_birth = $emp_info[0]->date_of_birth;


		  $kk_no = $emp_info[0]->kk_no;
		  $alamat_ktp = $emp_info[0]->alamat_ktp;
		  $alamat_domisili = $emp_info[0]->alamat_domisili;
		  $npwp_no = $emp_info[0]->npwp_no;
		  $contact_no = $emp_info[0]->contact_no;
		  $email = $emp_info[0]->email;
		  $date_of_joining = $emp_info[0]->date_of_joining;
		  $gender = $emp_info[0]->gender;
		  $ethnicity_type = $emp_info[0]->ethnicity_type;
		  $marital_status = $emp_info[0]->marital_status;

		  $fullname = $emp_info[0]->first_name;
		  $fullname = $emp_info[0]->first_name;
		} else {
		  $fullname = '--';
		  $ibu_kandung = '--';
		  $ktp_no = '--';
		  $tempat_lahir = '--';
		  $date_of_birth = '--';
		}

		// $company = $this->Xin_model->read_company_info($result[0]->company_id);
		// if(!is_null($company)){
		//   $company_name = $company[0]->name;
		// } else {
		//   $company_name = '--';
		// }

		// $department = $this->Department_model->read_department_information($result[0]->department);
		// if(!is_null($department)){
		// 	$department_name = $department[0]->department_name;
		// } else {
		// 	$department_name = '--';	
		// }

		// $designation = $this->Designation_model->read_designation_information($result[0]->posisi);
		// if(!is_null($designation)){
		// 	$edesignation_name = $designation[0]->designation_name;
		// } else {
		// 	$edesignation_name = '--';	
		// }

		$data = array(

			'title' => 'Edit PKWT Expired Karyawan',
			'breadcrumbs' => 'PKWT EDIT EXPIRED >> '. $result[0]->first_name,
			'path_url' => 'emp_pkwt_exp_edit',

			'secid' => $result[0]->user_id,
			'employee_id' => $result[0]->employee_id,
			'fullname' => strtoupper($fullname),
			'nik_ktp' => $ktp_no,
			'nama_ibu' => $ibu_kandung,
			'tempat_lahir' => $tempat_lahir,
			'tanggal_lahir' => $date_of_birth,


			'company' => $result[0]->company_id,
			'project_id' => $result[0]->project_id,
			'project_list' => $this->Project_model->get_project_maping($session['employee_id']),

			'sub_project_id' => $result[0]->sub_project_id,
			'sub_project_list' => $this->Project_model->get_sub_project_filter($result[0]->project_id),

			'designation_id' => $result[0]->designation_id,
			'designations_list' => $this->Designation_model->all_designations(),
			'date_of_joining' => $date_of_joining,
			'penempatan' => $result[0]->penempatan,
			'gender' => $gender,
			'ethnicity_type' => $ethnicity_type,
			'all_ethnicity' => $this->Xin_model->get_ethnicity_type_result(),
			'marital_status' => $marital_status,

			'ktp_no' => $ktp_no,
			'kk_no' => $kk_no,
			'alamat_ktp' => $alamat_ktp,
			'alamat_domisili' => $alamat_domisili,
			'npwp_no' => $npwp_no,
			'contact_no' => $contact_no,
			'email' => $email,

			'contract_start' => $result[0]->contract_start,
			'contract_end' => $result[0]->contract_end,
			'contract_periode' => $result[0]->contract_periode,
			'hari_kerja' => $result[0]->hari_kerja,
			'cut_start' => $result[0]->cut_start,
			'cut_off' => $result[0]->cut_off,
			'date_payment' => $result[0]->date_payment,
			'basic_salary' => $result[0]->basic_salary,
			'allow_jabatan' => $result[0]->allow_jabatan,
			'allow_area' => $result[0]->allow_area,
			'allow_masakerja' => $result[0]->allow_masakerja,
			'allow_trans_meal' => $result[0]->allow_trans_meal,
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

			);
		
		// if($check_role[0]->user_role_id==1 || $check_role[0]->user_role_id==3 || $check_role[0]->user_role_id==4) {

		// $data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		// } else {
		if($edit_approve=='1'){
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_expired_approve", $data, TRUE);
		} else {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_expired_edit", $data, TRUE);
		}
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
	public function pkwt_expired_save() {
		$session = $this->session->userdata('username');
		if(empty($session)){	
			redirect('admin/');
		}

			// if($this->input->post('add_type')=='company') {
				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				// $system = $this->Xin_model->read_setting_info(1);





					if($this->input->post('gaji_pokok')=='') {
						$Return['error'] = 'Gaji Pokok Kosong..!';
					} 
					// else if ($this->input->post('nama_ibu')=='') {
					// 	$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					// } else if ($this->input->post('tempat_lahir')=='') {
					// 	$Return['error'] = 'Tempat Lahir Kosong..!';
					// } 
					else {

							$idrequest 					= $this->input->post('idrequest');
					   	$fullname 					= $this->input->post('fullname');
					   	$nama_ibu						= $this->input->post('nama_ibu');
							$tempat_lahir 			= $this->input->post('tempat_lahir');
							$tanggal_lahir 			= $this->input->post('date_of_birth');
							$department_id 			= '5';
							$project_id					= $this->input->post('project_id');
							$sub_project				= $this->input->post('sub_project_id');
							$jabatan 							= $this->input->post('posisi');
							$date_of_join 							= $this->input->post('date_of_join');
							$penempatan 							= $this->input->post('penempatan');
							$gaji_pokok 							= $this->input->post('gaji_pokok');

							// $jenis_kelamin			= $this->input->post('gender');
							// $agama 							= $this->input->post('ethnicity');
							// $marital_status			= $this->input->post('marital_status');

							// $nomor_ktp					= $this->input->post('nomor_ktp');
							// $alamat_ktp					= $this->input->post('alamat_ktp');
							// $nomor_kk						= $this->input->post('nomor_kk');
							// $alamat_domisili			= $this->input->post('alamat_domisili');
							// $npwp								= $this->input->post('npwp');
							// $nomor_hp						= $this->input->post('nomor_hp');
							// $email							= $this->input->post('email');
							// $bank_name					= $this->input->post('bank_name');
							// $no_rek							= $this->input->post('no_rek');
							// $pemilik_rekening			= $this->input->post('pemilik_rekening');

							$tunjangan_jabatan 							= $this->input->post('tunjangan_jabatan');
							$tunjangan_area 							= $this->input->post('tunjangan_area');
							$tunjangan_masakerja 							= $this->input->post('tunjangan_masakerja');
							$tunjangan_makan 							= $this->input->post('tunjangan_makan');
							$tunjangan_transport 							= $this->input->post('tunjangan_transport');
							$tunjangan_komunikasi 							= $this->input->post('tunjangan_komunikasi');
							$tunjangan_makan_trans 							= $this->input->post('tunjangan_makan_trans');
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

							// $date_exp_pkwt		= $this->input->post('date_exp_pkwt');
							$by_exp_pkwt			= $session['user_id'];
						}


					if($Return['error']!=''){
					$this->output($Return);




			    }

							$data = array(
								'first_name' 							=> $fullname,
								'ibu_kandung' 						=> $nama_ibu,
								'tempat_lahir' 						=> $tempat_lahir,
								'date_of_birth' 					=> $tanggal_lahir,
								// 'gender'							=> $jenis_kelamin,
								// 'agama' 							=> $agama,
								// 'status_kawin' 				=> $marital_status,
								// 'nik_ktp' 						=> $nomor_ktp,
								// 'alamat_ktp' 					=> $alamat_ktp,
								// 'no_kk' 							=> $nomor_kk,

								// 'alamat_domisili' 		=> $alamat_domisili,
								// 'npwp' 								=> $npwp,
								// 'contact_no' 					=> $nomor_hp,
								// 'email' 							=> $email,
								// 'bank_id' 						=> $bank_name,
								// 'no_rek' 							=> $no_rek,
								// 'pemilik_rekening' 		=> $pemilik_rekening,
								'department_id'						=> $department_id,
								'project_id' 							=> $project_id,
								'sub_project_id' 					=> $sub_project,
								'designation_id' 					=> $jabatan,
								'date_of_joining' 				=> $date_of_join,
								'penempatan' 							=> $penempatan,
								'basic_salary'		 				=> $gaji_pokok,

								'allow_jabatan' 			=> $tunjangan_jabatan,
								'allow_area' 					=> $tunjangan_area,
								'allow_masakerja' 		=> $tunjangan_masakerja,
								'allow_konsumsi' 			=> $tunjangan_makan,
								'allow_transport' 		=> $tunjangan_transport,
								'allow_comunication' 	=> $tunjangan_komunikasi,

								'allow_rent' 					=> $tunjangan_rental,
								'allow_parking' 			=> $tunjangan_parkir,
								'allow_trans_meal' 		=> $tunjangan_makan_trans,
								'allow_residence_cost'=> $tunjangan_tempat_tinggal,
								'allow_device' 				=> $tunjangan_device,
								
								'allow_medichine' 		=> $tunjangan_kesehatan,
								'allow_akomodsasi' 		=> $tunjangan_akomodasi,
								'allow_kasir' 				=> $tunjangan_kasir,
								'allow_operational' 	=> $tunjangan_operational,

								'contract_start' 			=> $join_date_pkwt,
								'contract_end' 				=> $pkwt_end_date,
								'contract_periode' 		=> $waktu_kontrak,
								'hari_kerja' 					=> $hari_kerja,
								'cut_start' 					=> $cut_start,
								'cut_off' 						=> $cut_off,
								'date_payment' 				=> $date_payment,

								'date_exp_pkwt'							=> date('Y-m-d h:i:s'),
								'by_exp_pkwt' 							=> $by_exp_pkwt



							);

						$iresult = $this->Employees_model->save_pkwt_expired($data,$idrequest);

					// }

				if ($iresult == TRUE) {
					$Return['result'] = $fullname.' Perubahan PKWT Expired berhasil di Ubah..';
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				
				// $Return['result'] = $idrequest.' Permintaan Karyawan Baru berhasil di Ubah..';

				$this->output($Return);
				exit;
			// }
	}

	// Validate and add info in database
	public function pkwt_expired_approve() {
		$session = $this->session->userdata('username');
		if(empty($session)){	
			redirect('admin/');
		}

			// if($this->input->post('add_type')=='company') {
				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				// $system = $this->Xin_model->read_setting_info(1);


			$config['cacheable']	= true; //boolean, the default is true
			$config['cachedir']		= './assets/'; //string, the default is application/cache/
			$config['errorlog']		= './assets/'; //string, the default is application/logs/
			$config['imagedir']		= './assets/images/pkwt/'; //direktori penyimpanan qr code
			$config['quality']		= true; //boolean, the default is true
			$config['size']			= '1024'; //interger, the default is 1024
			$config['black']		= array(224,255,255); // array, default is array(255,255,255)
			$config['white']		= array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);



					if($this->input->post('gaji_pokok')=='') {
						$Return['error'] = 'Gaji Pokok Kosong..!';
					} 
					// else if ($this->input->post('nama_ibu')=='') {
					// 	$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					// } else if ($this->input->post('tempat_lahir')=='') {
					// 	$Return['error'] = 'Tempat Lahir Kosong..!';
					// } 
					else {

						if(strtoupper($this->input->post('company'))=='2'){
							$pkwt_hr = 'E-PKWT-JKT/SC-HR/';
							$spb_hr = 'E-SPB-JKT/SC-HR/';
							$companyID = '2';
						}else if (strtoupper($this->input->post('company'))=='3'){
							$pkwt_hr = 'E-PKWT-JKT/KAC-HR/';
							$spb_hr = 'E-SPB-JKT/KAC-HR/';
							$companyID = '3';
						} else {
							$pkwt_hr = 'E-PKWT-JKT/MATA-HR/';
							$spb_hr = 'E-SPB-JKT/MATA-HR/';
							$companyID = '4';
						}


						$count_pkwt = $this->Xin_model->count_pkwt();
						$romawi = $this->Xin_model->tgl_pkwt();
						$unicode = $this->Xin_model->getUniqueCode(20);
						$nomor_surat = sprintf("%05d", $count_pkwt[0]->newpkwt).'/'.$pkwt_hr.$romawi;
						$nomor_surat_spb = sprintf("%05d", $count_pkwt[0]->newpkwt).'/'.$spb_hr.$romawi;

							$idrequest 					= $this->input->post('idrequest');
							$employee_id 				= $this->input->post('employee_id');
					   	$fullname 					= $this->input->post('fullname');
					   	$nama_ibu						= $this->input->post('nama_ibu');
							$tempat_lahir 			= $this->input->post('tempat_lahir');
							$tanggal_lahir 			= $this->input->post('date_of_birth');
							$department_id 			= '5';
							$project_id					= $this->input->post('project_id');
							$sub_project				= $this->input->post('sub_project_id');
							$jabatan 							= $this->input->post('posisi');
							$date_of_join 							= $this->input->post('date_of_join');
							$penempatan 							= $this->input->post('penempatan');
							$gaji_pokok 							= $this->input->post('gaji_pokok');

							// $jenis_kelamin			= $this->input->post('gender');
							// $agama 							= $this->input->post('ethnicity');
							// $marital_status			= $this->input->post('marital_status');

							// $nomor_ktp					= $this->input->post('nomor_ktp');
							// $alamat_ktp					= $this->input->post('alamat_ktp');
							// $nomor_kk						= $this->input->post('nomor_kk');
							// $alamat_domisili			= $this->input->post('alamat_domisili');
							// $npwp								= $this->input->post('npwp');
							// $nomor_hp						= $this->input->post('nomor_hp');
							// $email							= $this->input->post('email');
							// $bank_name					= $this->input->post('bank_name');
							// $no_rek							= $this->input->post('no_rek');
							// $pemilik_rekening			= $this->input->post('pemilik_rekening');

							$tunjangan_jabatan 							= $this->input->post('tunjangan_jabatan');
							$tunjangan_area 							= $this->input->post('tunjangan_area');
							$tunjangan_masakerja 							= $this->input->post('tunjangan_masakerja');
							$tunjangan_makan 							= $this->input->post('tunjangan_makan');
							$tunjangan_transport 							= $this->input->post('tunjangan_transport');
							$tunjangan_komunikasi 							= $this->input->post('tunjangan_komunikasi');
							$tunjangan_makan_trans 							= $this->input->post('tunjangan_makan_trans');
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

							// $date_exp_pkwt		= $this->input->post('date_exp_pkwt');
							$by_exp_pkwt			= $session['user_id'];


						$docid = date('ymdHisv');
						$image_name='esign_pkwt'.date('ymdHisv').'.png'; //buat name dari qr code sesuai dengan nim
						$domain = 'https://apps-cakrawala.com/esign/pkwt/'.$docid;
						$params['data'] = $domain; //data yang akan di jadikan QR CODE
						$params['level'] = 'H'; //H=High
						$params['size'] = 10;
						$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
						$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
						

				$pkwt_down = array(

				'status_pkwt	' => 0

				);

				$resultx = $this->Pkwt_model->update_pkwt_status($pkwt_down,$employee_id);




						$data = array(
							'uniqueid' 							=> $unicode,
							'employee_id' 					=> $employee_id,
							'docid'									=> $docid,
							'project' 							=> $project_id,
							'from_date'	 						=> $join_date_pkwt,
							'to_date' 							=> $pkwt_end_date,
							'no_surat' 							=> $nomor_surat,
							'no_spb' 								=> $nomor_surat_spb,
							'waktu_kontrak' 				=> $waktu_kontrak,
							'company' 							=> $companyID,
							'jabatan' 							=> $jabatan,
							'penempatan' 						=> $penempatan,
							'hari_kerja' 						=> $hari_kerja,
							'tgl_payment'						=> $date_payment,
							'start_period_payment' 	=> $cut_start,
							'end_period_payment'		=> $cut_off,
							'basic_pay' 						=> $gaji_pokok,
							'dm_allow_grade' 				=> 'Month',
							'allowance_grade'				=> $tunjangan_jabatan,
							'dm_allow_area' 				=> 'Month',
							'allowance_area'				=> $tunjangan_area,
							'dm_allow_masakerja' 		=> 'Month',
							'allowance_masakerja' 	=> $tunjangan_masakerja,
							'dm_allow_transmeal' 		=> 'Month',
							'allowance_transmeal' 	=> $tunjangan_makan_trans,
							'dm_allow_meal' 				=> 'Month',
							'allowance_meal' 				=> $tunjangan_makan,
							'dm_allow_transport' 		=> 'Month',
							'allowance_transport' 	=> $tunjangan_transport,
							'dm_allow_komunikasi' 	=> 'Month',
							'allowance_komunikasi' 	=> $tunjangan_komunikasi,
							'dm_allow_laptop' 			=> 'Month',
							'allowance_laptop' 			=> $tunjangan_device,
							'dm_allow_residance' 		=> 'Month',
							'allowance_residance' 	=> $tunjangan_tempat_tinggal,
							'dm_allow_rent' 				=> 'Month',
							'allowance_rent' 				=> $tunjangan_rental,
							'dm_allow_park' 				=> 'Month',
							'allowance_park' 				=> $tunjangan_parkir,
							'dm_allow_medicine' 		=> 'Month',
							'allowance_medicine' 		=> $tunjangan_kesehatan,
							'dm_allow_akomodasi' 		=> 'Month',
							'allowance_akomodasi' 	=> $tunjangan_akomodasi,
							'dm_allow_kasir' 				=> 'Month',
							'allowance_kasir' 			=> $tunjangan_kasir,
							'dm_allow_operation' 		=> 'Month',
							'allowance_operation' 	=> $tunjangan_operational,
							'img_esign'							=> $image_name,

							'sign_nip'							=> '21500006',
							'sign_fullname'					=> 'ASTI PRASTISTA',
							'sign_jabatan'					=> 'SM HR & GA',
							'status_pkwt' => 0,
							'request_pkwt' => $session['user_id'],
							'request_date' => date('Y-m-d h:i:s'),
							'approve_nae' => $session['user_id'],
							'approve_nae_date' => date('Y-m-d h:i:s'),
							'approve_nom' =>  $session['user_id'],
							'approve_nom_date' => date('Y-m-d h:i:s')

						);


					$iresult = $this->Pkwt_model->add_pkwt_record($data);





				}


				if ($iresult == TRUE) {
					$Return['result'] = $fullname.' PENGAJUAN PKWT EXPIRED berhasil..';
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				
				// $Return['result'] = $idrequest.' Permintaan Karyawan Baru berhasil di Ubah..';

				$this->output($Return);
				exit;
			// }
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
		// $result = $this->Employees_model->read_employee_info($id);
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
				'posisi' => $this->Designation_model->read_designation_information($result[0]->jabatan),
				'project' => $this->Project_model->read_project_information($result[0]->project),
				'penempatan' => $result[0]->penempatan,

				'info_revisi' => $result[0]->cancel_ket,
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
		$this->load->view('admin/pkwt/dialog_pkwt_cancel', $data);
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

		$employeeID = $this->input->post('employeeID');



							if($_FILES['document_ktp']['size'] == 0) {$fnamektp=$this->input->post('fktp_name');} else {
								if(is_uploaded_file($_FILES['document_ktp']['tmp_name'])) {
									//checking image type
									$allowedktp =  array('png','jpg','PNG','JPG','jpeg','JPEG');
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
							}


							if($_FILES['document_kk']['size'] == 0) {$fnamekk=$this->input->post('fkk_name');} else {
								if(is_uploaded_file($_FILES['document_kk']['tmp_name'])) {
									//checking image type
									$allowedkk =  array('png','jpg','PNG','JPG','jpeg','JPEG');
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
									$allowedskck =  array('png','jpg','PNG','JPG','jpeg','JPEG');
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

							if($_FILES['document_ijazah']['size'] == 0) {$fnameijazah=$this->input->post('fijz_name');} else {
								if(is_uploaded_file($_FILES['document_ijazah']['tmp_name'])) {
									//checking image type
									$allowedijazah =  array('png','jpg','PNG','JPG','jpeg','JPEG','pdf','PDF');
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


			$data_emp = array(
				'filename_ktp'				=> $fnamektp,
				'filename_kk' 				=> $fnamekk,
				'filename_skck' 			=> $fnameskck,
				'filename_isd'				=> $fnameijazah
			);

			$result = $this->Employees_model->update_record_bynip($data_emp,$employeeID);

			$data_up = array(
				'cancel_stat'			=> 0,
				'modifiedby' 			=>  $session['user_id'],
				'modifiedon' 			=> date('Y-m-d h:i:s')
			);

			$result = $this->Pkwt_model->update_pkwt_apnae($data_up,$id);

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
			$result = $this->Pkwt_model->delete_pkwt_cancel($id);
			if(isset($id)) {
				$Return['result'] = 'Delete PKWT Tolak berhasil.';
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

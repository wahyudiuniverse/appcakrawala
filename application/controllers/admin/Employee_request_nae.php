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

class Employee_request_nae extends MY_Controller {
	
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
			// $data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
			$data['list_bank'] = $this->Xin_model->get_bank_code();
			$data['all_ethnicity'] = $this->Xin_model->get_ethnicity_type_result();

		$data['breadcrumbs'] = $this->lang->line('xin_request_employee');
		$data['path_url'] = 'emp_request_nae';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('327',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_list_nae", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list_nae() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/employees/request_list_nae", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_request_nae();
		
		$employee = $this->Employees_model->get_request_nae($session['employee_id']);

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
				$request_empon = $r->request_empon;
				$approved_naeby = $r->approved_naeby;
			  

				if($approved_naeby==null){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->secid . '">Approval Nae</button>';
				} else {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->secid . '">Approved</button>';
				}

				$editReq = '<a href="'.site_url().'admin/employee_request_cancelled/request_edit/'.$r->secid.'" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">EDIT</button></a>'; 

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


			  	$cancel = '<button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target=".edit-modal-data" data-company_id="@'. $r->secid . '">TOLAK</button>';

			$data[] = array(
				$no,
				$status_migrasi.' <br>'.$cancel.' '.$editReq,
				$nik_ktp,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$penempatan,
				$doj,
				$request_empon
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
				// $system = $this->Xin_model->read_setting_info(1);

					if($this->input->post('fullname')=='') {
						$Return['error'] = 'Nama Lengkap Kosong..!';
					} else if ($this->input->post('nama_ibu')=='') {
						$Return['error'] = 'Nama Ibu Kandung Kosong..!';
					} else if ($this->input->post('tempat_lahir')=='') {
						$Return['error'] = 'Tempat Lahir Kosong..!';
					} else if ($this->input->post('date_of_birth')==''){
						$Return['error'] = 'Tanggal Lahir Kosong..!';
					} 

					// else if ($this->input->post('company_id')==''){
					// 	$Return['error'] = 'Company Kosong..!';
					// } else if ($this->input->post('office_lokasi')==''){
					// 	$Return['error'] = 'Office Location Kosong..!';
					// } 
					else if ($this->input->post('project_id')==''){
						$Return['error'] = 'Project Kosong..!';
					} else if ($this->input->post('sub_project_id')==''){
						$Return['error'] = 'Sub Project Kosong..!';
					} else if ($this->input->post('department_id')==''){
						$Return['error'] = 'Departement Kosong..!';
					} else if ($this->input->post('posisi')==''){
						$Return['error'] = 'Posisi Jabatan Kosong..!';
					} else if ($this->input->post('gender')==''){
						$Return['error'] = 'Jenis Kelamin Kosong..!';
					} else if ($this->input->post('ethnicity')==''){
						$Return['error'] = 'Agama/Kepercayaan Kosong..!';
					} else if ($this->input->post('marital_status')==''){
						$Return['error'] = 'Status Perkawinan Kosong..!';
					}

					else if ($this->input->post('date_of_join')==''){
						$Return['error'] = 'Join Date Kosong..!';
					} else if ($this->input->post('join_date_pkwt')==''){
						$Return['error'] = 'Join Date PKWT Kosong..!';
					} else if ($this->input->post('pkwt_end_date')==''){
						$Return['error'] = 'End Date PKWT Kosong..!';
					} else if ($this->input->post('waktu_kontrak')==''){
						$Return['error'] = 'Periode Kontrak Kosong..!';
					}

					else if ($this->input->post('nomor_hp')==''){
						$Return['error'] = 'Nomor Hp Kosong..!';
					} else if ($this->input->post('nomor_ktp')==''){
						$Return['error'] = 'Nomor KTP Kosong..!';
					} else if ($this->input->post('alamat_ktp')==''){
						$Return['error'] = 'Alamat KTP Kosong..!';
					} else if ($this->input->post('alamat_domisili')==''){
						$Return['error'] = 'Alamat Domisili Kosong..!';
					} else if ($this->input->post('nomor_kk')==''){
						$Return['error'] = 'KK Kosong..!';
					} else if ($this->input->post('email')==''){
						$Return['error'] = 'Email Kosong..!';
					} else if ($this->input->post('penempatan')==''){
						$Return['error'] = 'Penempatan Kosong..!';
					} else if ($this->input->post('hari_kerja')==''){
						$Return['error'] = 'Hari Kerja Kosong..!';
					} 
					else if ($this->input->post('gaji_pokok')==''){
						$Return['error'] = 'Gaji Pokok Kosong..!';
					} else if ($this->input->post('bank_name')==''){
						$Return['error'] = 'Nama Bank Kosong..!';
					} else if ($this->input->post('no_rek')==''){
						$Return['error'] = 'Nomor Rekening Kosong..!';
					} else if ($this->input->post('pemilik_rekening')==''){
						$Return['error'] = 'Pemilik Rekening Kosong..!';
					} else if ($this->input->post('cut_start')==''){
						$Return['error'] = 'Tanggal Cut START Kosong..!';
					} else if ($this->input->post('cut_off')==''){
						$Return['error'] = 'Tanggal Cut OFF Kosong..!';
					} else if ($this->input->post('date_payment')==''){
						$Return['error'] = 'Tanggal Penggajian Kosong..!';
					} 

					else if($_FILES['document_file']['size'] == 0) {
						$Return['error'] = 'KTP Kosongx..!';
					} else if ($_FILES['document_file']['size'] > 2000000){
						$Return['error'] = 'File KTP Lebih dari 2MB	..';
					}

					else if($_FILES['document_kk']['size'] == 0) {
						$Return['error'] = 'KK KosongA..!';
					} else if ($_FILES['document_kk']['size'] > 2000000){
						$Return['error'] = 'File KK Lebih dari 2MB	..';
					}

					else if($_FILES['document_cv']['size'] == 0) {
						$Return['error'] = 'Riwayat Hidup (CV) Kosong..!';
					} else if ($_FILES['document_cv']['size'] > 2000000){
						$Return['error'] = 'File CV Lebih dari 2MB	..';
					}

					else if($_FILES['document_skck']['size'] > 2000000){
						$Return['error'] = 'File SKCK Lebih dari 2MB	..';
					}

					else if($_FILES['document_ijz']['size'] == 0) {
						$Return['error'] = 'Ijazah Kosong..!';
					} else if ($_FILES['document_ijz']['size'] > 2000000){
						$Return['error'] = 'File Ijazah Lebih dari 2MB	..';
					}

					else if ($_FILES['document_pkl']['size'] > 2000000){
						$Return['error'] = 'File PAKLARING Lebih dari 2MB	..';
					}

					else {

								if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
									//checking image type
									$allowed =  array('png','jpg','jpeg','PNG','JPG','JPEG');
									$filename = $_FILES['document_file']['name'];
									$ext = pathinfo($filename, PATHINFO_EXTENSION);
									
									if(in_array($ext,$allowed)){
										$tmp_name = $_FILES["document_file"]["tmp_name"];
										$documentd = "uploads/document/ktp/";
										// basename() may prevent filesystem traversal attacks;
										// further validation/sanitation of the filename may be appropriate
										$name = basename($_FILES["document_file"]["name"]);
										$newfilename = 'ktp_'.round(microtime(true)).'.'.$ext;
										move_uploaded_file($tmp_name, $documentd.$newfilename);
										$fname = $newfilename;
									} else {
										$Return['error'] = 'Jenis File KTP tidak diterima..';
									}
								}

								if(is_uploaded_file($_FILES['document_kk']['tmp_name'])) {
									//checking image type
									$allowedkk =  array('png','jpg','jpeg','PNG','JPG','JPEG');
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

								if(is_uploaded_file($_FILES['document_cv']['tmp_name'])) {
										//checking image type
										$allowedcv =  array('png','jpg','jpeg','PNG','JPG','JPEG','pdf','PDF');
										$filenamecv = $_FILES['document_cv']['name'];
										$extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
										
										if(in_array($extcv,$allowedcv)){
											$tmp_namecv = $_FILES["document_cv"]["tmp_name"];
											$documentdcv = "uploads/document/cv/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_cv"]["name"]);
											$newfilenamecv = 'cv_'.round(microtime(true)).'.'.$extcv;
											move_uploaded_file($tmp_namecv, $documentdcv.$newfilenamecv);
											$fnamecv = $newfilenamecv;
										} else {
											$Return['error'] = 'Jenis File CV tidak diterima..';
										}
								}

								if(is_uploaded_file($_FILES['document_ijz']['tmp_name'])) {
										//checking image type
										$allowedijz =  array('png','jpg','jpeg','PNG','JPG','JPEG','pdf','PDF');
										$filenameijz = $_FILES['document_ijz']['name'];
										$extijz = pathinfo($filenameijz, PATHINFO_EXTENSION);
										
										if(in_array($extijz,$allowedijz)){
											$tmp_nameijz = $_FILES["document_ijz"]["tmp_name"];
											$documentdijz = "uploads/document/ijazah/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_ijz"]["name"]);
											$newfilenameijz = 'ijazah_'.round(microtime(true)).'.'.$extijz;
											move_uploaded_file($tmp_nameijz, $documentdijz.$newfilenameijz);
											$fnameijz = $newfilenameijz;
										} else {
											$Return['error'] = 'Jenis File Ijazah tidak diterima..';
										}
								}
							

							if($_FILES['document_skck']['size'] == 0) {
								$fnameskck=0;
							} else {
									if(is_uploaded_file($_FILES['document_skck']['tmp_name'])) {
										//checking image type
										$allowedskck =  array('pdf','PDF','png','jpg','jpeg','PNG','JPG','JPEG');
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
											$Return['error'] = 'Jenis File KK tidak diterima..';
										}
									}
							}


							if($_FILES['document_pkl']['size'] == 0) {
								$fnamepkl=0;
							} else {
									if(is_uploaded_file($_FILES['document_pkl']['tmp_name'])) {
										//checking image type
										$allowedpkl =  array('pdf','PDF','png','jpg','jpeg','PNG','JPG','JPEG');
										$filenamepkl = $_FILES['document_pkl']['name'];
										$extpkl = pathinfo($filenamepkl, PATHINFO_EXTENSION);
										
										if(in_array($extpkl,$allowedpkl)){
											$tmp_namepkl = $_FILES["document_pkl"]["tmp_name"];
											$documentdpkl = "uploads/document/paklaring/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["document_pkl"]["name"]);
											$newfilenamepkl = 'paklaring_'.round(microtime(true)).'.'.$extpkl;
											move_uploaded_file($tmp_namepkl, $documentdpkl.$newfilenamepkl);
											$fnamepkl = $newfilenamepkl;
										} else {
											$Return['error'] = 'Jenis File Paklaring tidak diterima..';
										}
									}
							}

					   	$fullname 					= str_replace("'"," ",$this->input->post('fullname'));
					   	$nama_ibu						= $this->input->post('nama_ibu');
							$tempat_lahir 			= $this->input->post('tempat_lahir');
							$tanggal_lahir 			= $this->input->post('date_of_birth');

					   	$company_id					= $this->input->post('company_id');
							$office_lokasi 			= $this->input->post('office_lokasi');
							$project_id 				= $this->input->post('project_id');
							$sub_project_id 		= $this->input->post('sub_project_id');
							$department_id 			= $this->input->post('department_id');
							$posisi 						= $this->input->post('posisi');
							$jenis_kelamin 			= $this->input->post('gender');
							$agama 							= $this->input->post('ethnicity');
							$status_kawin 			= $this->input->post('marital_status');

							$date_of_join 			= $this->input->post('date_of_join');
							$join_date_pkwt 		= $this->input->post('join_date_pkwt');
							$pkwt_end_date 			= $this->input->post('pkwt_end_date');
							$waktu_kontrak 			= $this->input->post('waktu_kontrak');

							$contact_no 				= $this->input->post('nomor_hp');
							$ktp_no 						= $this->input->post('nomor_ktp');
							$alamat_ktp 				= $this->input->post('alamat_ktp');
							$alamat_domisili 		= $this->input->post('alamat_domisili');
					   	$nomor_kk						= $this->input->post('nomor_kk');
					   	$npwp								= $this->input->post('npwp');
					   	$email							= $this->input->post('email');
							$penempatan 				= $this->input->post('penempatan');
							$hari_kerja 				= $this->input->post('hari_kerja');

							$bank_name 					= $this->input->post('bank_name');
							$no_rek 						= $this->input->post('no_rek');
							$pemilik_rekening 	= $this->input->post('pemilik_rekening');

							$gaji_pokok 					= $this->Xin_model->clean_number($this->input->post('gaji_pokok'));
							$allow_jabatan 				= $this->Xin_model->clean_number($this->input->post('tunjangan_jabatan'));
							$allow_area 					= $this->Xin_model->clean_number($this->input->post('tunjangan_area'));
							$allow_masakerja			= $this->Xin_model->clean_number($this->input->post('tunjangan_masakerja'));
							$allow_trans_meal 		= $this->Xin_model->clean_number($this->input->post('tunjangan_makan_trans'));
							$allow_konsumsi 			= $this->Xin_model->clean_number($this->input->post('tunjangan_makan'));
							$allow_transport			= $this->Xin_model->clean_number($this->input->post('tunjangan_transport'));
							$allow_comunication 	= $this->Xin_model->clean_number($this->input->post('tunjangan_komunikasi'));
							$allow_device					= $this->Xin_model->clean_number($this->input->post('tunjangan_device'));
							$allow_residence_cost	= $this->Xin_model->clean_number($this->input->post('tunjangan_tempat_tinggal'));
							$allow_rental					= $this->Xin_model->clean_number($this->input->post('tunjangan_rental'));
							$allow_parking				= $this->Xin_model->clean_number($this->input->post('tunjangan_parkir'));
							$allow_medichine			= $this->Xin_model->clean_number($this->input->post('tunjangan_kesehatan'));
							$allow_akomodsasi			= $this->Xin_model->clean_number($this->input->post('tunjangan_akomodasi'));
							$allow_kasir 					= $this->Xin_model->clean_number($this->input->post('tunjangan_kasir'));
							$allow_operational		= $this->Xin_model->clean_number($this->input->post('tunjangan_operational'));

							$cut_start			= $this->input->post('cut_start');
							$cut_off 					= $this->input->post('cut_off');
							$date_payment		= $this->input->post('date_payment');

							// $options = array('cost' => 12);
							// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
							// $leave_categories = array($this->input->post('leave_categories'));
							// $cat_ids = implode(',',$this->input->post('leave_categories'));

							$data = array(
								'fullname' 						=> $fullname,
								'nama_ibu' 						=> $nama_ibu,
								'tempat_lahir' 				=> $tempat_lahir,
								'tanggal_lahir' 			=> $tanggal_lahir,

								'company_id' 					=> $company_id,
								'location_id' 				=> '1',
								'project' 						=> $project_id,
								'sub_project' 				=> $sub_project_id,
								'department' 					=> $department_id,
								'posisi' 							=> $posisi,
								'gender' 							=> $jenis_kelamin,
								'agama' 							=> $agama,
								'status_kawin' 				=> $status_kawin,

								'doj' 								=> $date_of_join,
								'contract_start' 			=> $join_date_pkwt,
								'contract_end' 				=> $pkwt_end_date,
								'contract_periode' 		=> $waktu_kontrak,
								'contact_no' 					=> $contact_no,
								'nik_ktp' 						=> $ktp_no,
								'alamat_ktp' 					=> $alamat_ktp,
								'alamat_domisili' 		=> $alamat_domisili,
								'no_kk' 							=> $nomor_kk,
								'npwp' 								=> $npwp,
								'email' 							=> $email,
								'penempatan' 					=> $penempatan,
								'hari_kerja' 					=> $hari_kerja,
								'bank_id' 						=> $bank_name,
								'no_rek' 							=> $no_rek,
								'pemilik_rekening' 		=> $pemilik_rekening,

								'gaji_pokok' 						=> $gaji_pokok,
								'allow_jabatan' 				=> $allow_jabatan,
								'allow_area' 						=> $allow_area,
								'allow_masakerja' 			=> $allow_masakerja,
								'allow_trans_meal'			=> $allow_trans_meal,
								'allow_konsumsi'				=> $allow_konsumsi,
								'allow_transport'				=> $allow_transport,
								'allow_comunication'		=> $allow_comunication,
								'allow_device'					=> $allow_device,
								'allow_residence_cost'	=> $allow_residence_cost,
								'allow_rent'						=> $allow_rental,
								'allow_parking'					=> $allow_parking,
								'allow_medichine'				=> $allow_medichine,
								'allow_akomodsasi'			=> $allow_akomodsasi,
								'allow_kasir'						=> $allow_kasir,
								'allow_operational'			=> $allow_operational,

								'cut_start'							=> $cut_start,
								'cut_off'								=> $cut_off,
								'date_payment'					=> $date_payment,
								'ktp'										=> $fname,
								'kk'										=> $fnamekk,
								'skck'									=> $fnameskck,
								'ijazah'								=> $fnameijz,
								'civi'									=> $fnamecv,
								'paklaring'							=> $fnamepkl,

								'request_empby' 				=> $session['user_id'],
								'request_empon' 				=> date("Y-m-d h:i:s"),
								'approved_naeby' 				=> $session['user_id'],
								'approved_naeon'				=> date("Y-m-d h:i:s"),

								// 'pincode' => $this->input->post('pin_code'),
								// 'createdon' => date('Y-m-d h:i:s'),
								'createdby' => $session['user_id']
							);
						$iresult = $this->Employees_model->addrequest($data);
					}

					if($Return['error']!=''){
					$this->output($Return);
			    }

				if ($iresult == TRUE) {
					$Return['result'] = $this->lang->line('xin_success_add_employee');
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

			$idsubmit = substr($this->input->get('company_id'),0,1);
			$id = str_replace("$","",str_replace("@","",$this->input->get('company_id')));


		// $id = $this->input->get('company_id');
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
				
				'idrequest' => $result[0]->secid,
				'request_empby' => $this->Employees_model->read_employee_info($result[0]->request_empby),
				'request_empon' => $result[0]->request_empon,
				'approved_naeby' => $this->Employees_model->read_employee_info($result[0]->approved_naeby),
				'approved_naeon' => $result[0]->approved_naeon,
				'approved_nomby' => $this->Employees_model->read_employee_info($result[0]->approved_nomby),
				'approved_nomon' => $result[0]->approved_nomon,
				
				// 'idefault_timezone' => $result[0]->default_timezone,

				// 'createdon' => $result[0]->createdon,
				// 'modifiedon' => $result[0]->modifiedon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
				if($idsubmit=='$'){
			$this->load->view('admin/employees/dialog_emp_nae', $data);
		} else {
			$this->load->view('admin/employees/dialog_emp_cancel_nae', $data);
		}

		// $this->load->view('admin/employees/dialog_emp_nae', $data);
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

		// $id = $this->uri->segment(4);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		

			if($cancel=='YES'){

				$data_up = array(

					'cancel_stat' =>  1,
					'cancel_on' => date("Y-m-d h:i:s"),
					'cancel_by' => $session['user_id'],
					'cancel_ket' => 'REVISI DOKUMEN PENDUKUNG'

				);
			} else {
				$data_up = array(
					// 'migrasi' => '1',
					'approved_naeby' =>  $session['user_id'],
					'approved_naeon' => date("Y-m-d h:i:s"),
					'approved_nomby' =>  $session['user_id'],
					'approved_nomon' => date('Y-m-d h:i:s')

				);
			}

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

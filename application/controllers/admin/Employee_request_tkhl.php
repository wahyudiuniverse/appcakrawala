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

class Employee_request_tkhl extends MY_Controller {
	
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
		$this->load->library('ciqrcode');
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
		$data['path_url'] = 'emp_request_tkhl';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('312',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_list_tkhl", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function request_list_tkhl() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/employees/request_list_tkhl", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_request_hrd();
		$employee = $this->Employees_model->get_request_tkhl($session['employee_id']);

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
				$notes = $r->catatan_hr;

				$register_date = $r->request_empon;
				$approved_hrdby = $r->approved_hrdby;


				if($approved_hrdby==null){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$'. $r->secid . '">Need Approval HRD</button>';
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

			  	$cancel = '<button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target=".edit-modal-data" data-company_id="@'. $r->secid . '">TOLAK</button>';

			  	$noteHR = '<button type="button" class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target=".edit-modal-data" data-company_id="!'. $r->secid . '">note</button>';

				if(in_array('382',$role_resources_ids)){
					$nik_note = $nik_ktp. '<br><i>' .$notes.'</i> '.$noteHR;
				} else {
					$nik_note = $nik_ktp. '<br><i>' .$notes;
				}

			$data[] = array(
				$no,
				$status_migrasi.' <br>'.$cancel.' '.$editReq,
				$nik_note,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$penempatan,
				$doj,
				$register_date
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

					else if ($this->input->post('company_id')==''){
						$Return['error'] = 'Company Kosong..!';
					} else if ($this->input->post('office_lokasi')==''){
						$Return['error'] = 'Office Location Kosong..!';
					} else if ($this->input->post('project_id')==''){
						$Return['error'] = 'Project Kosong..!';
					} else if ($this->input->post('sub_project_id')==''){
						$Return['error'] = 'Sub Project Kosong..!';
					} else if ($this->input->post('department_id')==''){
						$Return['error'] = 'Departement Kosong..!';
					} else if ($this->input->post('posisi')==''){
						$Return['error'] = 'Posisi Jabatan Kosong..!';
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
						$Return['error'] = 'KTP Kosong..!';
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
					} 
					else if ($this->input->post('bank_name')==''){
						$Return['error'] = 'Nama Bank Kosong..!';
					} else if ($this->input->post('no_rek')==''){
						$Return['error'] = 'Nomor Rekening Kosong..!';
					} else if ($this->input->post('pemilik_rekening')==''){
						$Return['error'] = 'Pemilik Rekening Kosong..!';
					} 
					// else if ($this->input->post('tunjangan_makan_trans')==''){
					// 	$Return['error'] = 'Tunjangan Makan & Transport Kosong..!';
					// } else if ($this->input->post('tunjangan_makan')==''){
					// 	$Return['error'] = 'Tunjangan Masa Kerja Kosong..!';
					// } else if ($this->input->post('tunjangan_transport')==''){
					// 	$Return['error'] = 'Tunjangan Masa Kerja Kosong..!';
					// } 

					else {

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

							$gaji_pokok 					= $this->input->post('gaji_pokok');
							$allow_jabatan 				= $this->input->post('tunjangan_jabatan');
							$allow_area 					= $this->input->post('tunjangan_area');
							$allow_masakerja			= $this->input->post('tunjangan_masakerja');
							$allow_trans_meal 		= $this->input->post('tunjangan_makan_trans');
							$allow_konsumsi 			= $this->input->post('tunjangan_makan');
							$allow_transport			= $this->input->post('tunjangan_transport');
							$allow_comunication 	= $this->input->post('tunjangan_komunikasi');
							$allow_device					= $this->input->post('tunjangan_device');
							$allow_residence_cost	= $this->input->post('tunjangan_tempat_tinggal');
							$allow_rental					= $this->input->post('tunjangan_rental');
							$allow_parking				= $this->input->post('tunjangan_parkir');
							$allow_medichine			= $this->input->post('tunjangan_kesehatan');
							$allow_akomodsasi			= $this->input->post('tunjangan_akomodasi');
							$allow_kasir 					= $this->input->post('tunjangan_kasir');
							$allow_operational		= $this->input->post('tunjangan_operational');
						
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
								'location_id' 				=> $office_lokasi,
								'project' 						=> $project_id,
								'sub_project' 				=> $sub_project_id,
								'department' 					=> $department_id,
								'posisi' 							=> $posisi,

								'doj' 								=> $date_of_join,
								'contract_start' 			=> $date_of_join,
								'contract_end' 				=> $date_of_join,
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

								'request_empby' 				=> $session['user_id'],
								'request_empon' 				=> date("Y-m-d h:i:s"),
								'approved_naeby' 				=> $session['user_id'],
								'approved_naeon'				=> date("Y-m-d h:i:s"),

								// 'pincode' => $this->input->post('pin_code'),
								// 'createdon' => date('Y-m-d h:i:s'),
								// 'createdby' => $session['user_id']
								// 'modifiedon' => date('Y-m-d h:i:s')
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
			// $id = str_replace("#","",str_replace("$","",str_replace("@","",$this->input->get('company_id'))));
			$id = str_replace("!","",str_replace("$","",str_replace("@","",$this->input->get('company_id'))));

		// $id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		// $result = $this->Company_model->read_company_information('2');
		$result = $this->Employees_model->read_employee_request($id);
		$data = array(
				'nik_ktp' => $result[0]->nik_ktp,
				// 'nik_ktp' => $idsubmit,
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
				'approved_hrdby' => $this->Employees_model->read_employee_info($result[0]->approved_hrdby),
				'approved_hrdon' => $result[0]->approved_hrdon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);

				if($idsubmit=='$'){
			$this->load->view('admin/employees/dialog_emp_tkhl', $data);
		} else if($idsubmit=='@'){
			$this->load->view('admin/employees/dialog_emp_cancel_hrd', $data);
		} else {
			$this->load->view('admin/employees/dialog_emp_notehrd', $data);
		}

		// $this->load->view('admin/employees/dialog_emp_hrd', $data);
	}


	// Validate and update info in database
	public function update() {
		
		$session = $this->session->userdata('username');
		if(empty($session)) {
			redirect('admin/');
		}

			$config['cacheable']	= true; //boolean, the default is true
			$config['cachedir']		= './assets/'; //string, the default is application/cache/
			$config['errorlog']		= './assets/'; //string, the default is application/logs/
			$config['imagedir']		= './assets/images/tkhl/'; //direktori penyimpanan qr code
			$config['quality']		= true; //boolean, the default is true
			$config['size']			= '1024'; //interger, the default is 1024
			$config['black']		= array(224,255,255); // array, default is array(255,255,255)
			$config['white']		= array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

		// $id = '31';

		if($this->input->post('edit_type')=='company') {

			$idtransaksi 	= $this->input->post('idtransaksi');
			$id = $this->uri->segment(4);
			$cancel = $this->uri->segment(5);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		


					$count_nip = $this->Xin_model->count_nip();
					$employee_request = $this->Employees_model->read_employee_request($id);

					$fullname 					= $employee_request[0]->fullname;
					$nama_ibu 					= $employee_request[0]->nama_ibu;
					$tempat_lahir 			= $employee_request[0]->tempat_lahir;
					$tanggal_lahir 			= $employee_request[0]->tanggal_lahir;
					$contact_no 				= $employee_request[0]->contact_no;
					$nik_ktp 						= $employee_request[0]->nik_ktp;
					$alamat_ktp 				= $employee_request[0]->alamat_ktp;
					$alamat_domisili		= $employee_request[0]->alamat_domisili;

					$no_kk 							= $employee_request[0]->no_kk;
					$npwp 							= $employee_request[0]->npwp;
					$email 							= $employee_request[0]->email;
					$company_id 				= $employee_request[0]->company_id;
					$location_id 				= $employee_request[0]->location_id;
					$project 						= $employee_request[0]->project;
					$sub_project 				= $employee_request[0]->sub_project;
					$department 				= $employee_request[0]->department;
					$posisi 						= $employee_request[0]->posisi;

					$gender 						= $employee_request[0]->gender;
					$agama 							= $employee_request[0]->agama;
					$status_kawin 			= $employee_request[0]->status_kawin;

					$doj 								= $employee_request[0]->doj;
					$contract_start			= $employee_request[0]->contract_start;
					$contract_end				= $employee_request[0]->contract_end;
					$contract_periode		= $employee_request[0]->contract_periode;
					$penempatan 				= $employee_request[0]->penempatan;
					$hari_kerja					= $employee_request[0]->hari_kerja;
					$bank_id						= $employee_request[0]->bank_id;
					$no_rek							= $employee_request[0]->no_rek;
					$pemilik_rekening		= $employee_request[0]->pemilik_rekening;

					$gaji_pokok					= $employee_request[0]->gaji_pokok;
					$allow_jabatan			= $employee_request[0]->allow_jabatan;
					$allow_area					= $employee_request[0]->allow_area;
					$allow_masakerja		= $employee_request[0]->allow_masakerja;
					$allow_trans_meal		= $employee_request[0]->allow_trans_meal;
					$allow_trans_rent		= $employee_request[0]->allow_trans_rent;
					$allow_konsumsi			= $employee_request[0]->allow_konsumsi;
					$allow_transport		= $employee_request[0]->allow_transport;
					$allow_comunication		= $employee_request[0]->allow_comunication;
					$allow_device					= $employee_request[0]->allow_device;
					$allow_residence_cost	= $employee_request[0]->allow_residence_cost;
					$allow_rent						= $employee_request[0]->allow_rent;
					$allow_parking				= $employee_request[0]->allow_parking;
					$allow_medichine			= $employee_request[0]->allow_medichine;
					$allow_akomodsasi			= $employee_request[0]->allow_akomodsasi;
					$allow_kasir					= $employee_request[0]->allow_kasir;
					$allow_operational		= $employee_request[0]->allow_operational;

					$cut_start 						=	$employee_request[0]->cut_start;
					$cut_off							= $employee_request[0]->cut_off;
					$date_payment 				= $employee_request[0]->date_payment;
					$ktp									= $employee_request[0]->ktp;
					$kk										= $employee_request[0]->kk;
					$skck									= $employee_request[0]->skck;
					$ijazah								= $employee_request[0]->ijazah;
					$civi									= $employee_request[0]->civi;
					$paklaring						= $employee_request[0]->paklaring;

					$createdby 						= $employee_request[0]->request_empby;
					$createdon 						= $employee_request[0]->request_empon;
					$approved_naeby 						= $employee_request[0]->approved_naeby;
					$approved_naeon 						= $employee_request[0]->approved_naeon;
					$approved_nomby 						= $employee_request[0]->approved_nomby;
					$approved_nomon 						= $employee_request[0]->approved_nomon;

					// $employee_id = '2'.$employee_request[0]->location_id.$employee_request[0]->department.$count_nip;
					$employee_id = '2'.$employee_request[0]->location_id.$employee_request[0]->department.sprintf("%05d", $count_nip[0]->newcount);
					$private_code = rand(100000,999999);
					$options = array('cost' => 12);
					$password_hash = password_hash($private_code, PASSWORD_BCRYPT, $options);

					//PKWT ATTRIBUTE
					if ($company_id=='2'){
						$pkwt_hr = 'KEMITRAAN/SC-HR/';
						$spb_hr = 'KEMITRAAN/SC-HR/';
					} else if($company_id=='3') {
						$pkwt_hr = 'KEMITRAAN/KAC-HR/';
						$spb_hr = 'KEMITRAAN/KAC-HR/';
					} else {
						$pkwt_hr = 'KEMITRAAN/MATA-HR/';
						$spb_hr = 'KEMITRAAN/MATA-HR/';
					} 

					$count_pkwt = $this->Xin_model->count_tkhl();
					$romawi = $this->Xin_model->tgl_pkwt();
					$unicode = $this->Xin_model->getUniqueCode(20);
					$nomor_surat = sprintf("%05d", $count_pkwt[0]->newpkwt).'/'.$pkwt_hr.$romawi;
					$nomor_surat_spb = sprintf("%05d", $count_pkwt[0]->newpkwt).'/'.$spb_hr.$romawi;


					$docid = date('ymdHisv');
					$image_name='esign_pkwt'.date('ymdHisv').'.png'; //buat name dari qr code sesuai dengan nim
					$domain = 'https://apps-cakrawala.com/esign/tkhl/'.$docid;
					$params['data'] = $domain; //data yang akan di jadikan QR CODE
					$params['level'] = 'H'; //H=High
					$params['size'] = 10;
					$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
					$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE


					if($cancel==='YES'){

						$data_up = array(

							'cancel_stat' => 1,
							'cancel_on' 	=> date("Y-m-d h:i:s"),
							'cancel_by' 	=> $session['user_id'], 
							'cancel_ket' 	=> $this->input->post('ket_revisi')

						);

						$result = $this->Employees_model->update_request_employee($data_up,$id);

					} else if ($contract_start=='' || $contract_end==''){

						$Return['error'] = 'Periode Kontrak Kosong...';

					} else {

								$data_migrate = array(

											'employee_id' 					=> $employee_id,
											'username' 							=> $employee_id,

											'first_name' 						=> $fullname,
											'ibu_kandung' 					=> $nama_ibu,
											'tempat_lahir' 					=> $tempat_lahir,
											'date_of_birth' 				=> $tanggal_lahir,

											'company_id' 					=> $company_id,
											'location_id' 				=> $location_id,
											'project_id' 					=> $project,
											'sub_project_id' 			=> $sub_project,
											'department_id' 			=> $department,
											'designation_id' 			=> $posisi,
											'gender' 							=> $gender,
											'ethnicity_type' 			=> $agama,
											'marital_status' 			=> $status_kawin,

											'date_of_joining' 		=> $doj,
											'contract_start' 			=> $contract_start,
											'contract_end' 				=> $contract_end,
											'contract_periode' 		=> $contract_periode,
											'contact_no' 					=> $contact_no,
											'ktp_no' 							=> $nik_ktp,
											'alamat_ktp' 					=> $alamat_ktp,
											'alamat_domisili' 			=> $alamat_domisili,
											'kk_no' 								=> $no_kk,
											'npwp_no' 							=> $npwp,
											'email' 								=> $email,
											'penempatan' 						=> $penempatan,
											'hari_kerja' 						=> $hari_kerja,
											'bank_name' 						=> $bank_id,
											'nomor_rek' 						=> $no_rek,
											'pemilik_rek' 					=> $pemilik_rekening,
											'e_status'							=> 1,

											'basic_salary' 					=> $gaji_pokok,
											'allow_jabatan' 				=> $allow_jabatan,
											'allow_area' 						=> $allow_area,
											'allow_masakerja' 			=> $allow_masakerja,
											'allow_trans_meal'			=> $allow_trans_meal,
											'allow_trans_rent'			=> $allow_trans_rent,
											'allow_konsumsi'				=> $allow_konsumsi,
											'allow_transport'				=> $allow_transport,
											'allow_comunication'		=> $allow_comunication,
											'allow_device'					=> $allow_device,
											'allow_residence_cost'	=> $allow_residence_cost,
											'allow_rent'						=> $allow_rent,
											'allow_parking'					=> $allow_parking,
											'allow_medichine'				=> $allow_medichine,
											'allow_akomodsasi'			=> $allow_akomodsasi,
											'allow_kasir'						=> $allow_kasir,
											'allow_operational'			=> $allow_operational,

											'cut_start' 						=> $cut_start,
											'cut_off'								=> $cut_off,
											'date_payment'					=> $date_payment,
											'filename_ktp'					=> $ktp,
											'filename_kk'						=> $kk,
											'filename_skck'					=> $skck,
											'filename_isd'					=> $ijazah,
											'filename_cv'						=> $civi,
											'filename_paklaring'		=> $paklaring,

											'user_role_id' => '2',
											'is_active' => '1',
											'password' => $password_hash,
											'private_code' => $private_code,
											'created_by' => $createdby
								);

								$iresult = $this->Employees_model->add($data_migrate);

								$data = array(
										'uniqueid' 							=> $unicode,
										'employee_id' 					=> $employee_id,
										'docid'									=> $docid,
										'project' 							=> $project,
										'from_date'	 						=> $contract_start,
										'to_date' 							=> $contract_end,
										'no_surat' 							=> $nomor_surat,
										'no_spb' 								=> $nomor_surat_spb,
										'waktu_kontrak' 				=> $contract_periode,
										'company' 							=> $company_id,
										'jabatan' 							=> $posisi,
										'penempatan' 						=> $penempatan,
										'hari_kerja' 						=> $hari_kerja,
										'tgl_payment'						=> $date_payment,
										'start_period_payment'	=> $cut_start,
										'end_period_payment'		=> $cut_off,
										'basic_pay' 						=> $gaji_pokok,
										'dm_allow_grade' 				=> 'Month',
										'allowance_grade'				=> $allow_jabatan,
										'dm_allow_area' 				=> 'Month',
										'allowance_area'				=> $allow_area,
										'dm_allow_masakerja' 		=> 'Month',
										'allowance_masakerja' 	=> $allow_masakerja,
										'dm_allow_transmeal' 		=> 'Month',
										'allowance_transmeal' 	=> $allow_trans_meal,
										'dm_allow_transrent' 		=> 'Month',
										'allowance_transrent' 	=> $allow_trans_rent,
										'dm_allow_meal' 				=> 'Month',
										'allowance_meal' 				=> $allow_konsumsi,
										'dm_allow_transport' 		=> 'Month',
										'allowance_transport' 	=> $allow_transport,
										'dm_allow_komunikasi' 	=> 'Month',
										'allowance_komunikasi' 	=> $allow_comunication,
										'dm_allow_laptop' 			=> 'Month',
										'allowance_laptop' 			=> $allow_device,
										'dm_allow_residance' 		=> 'Month',
										'allowance_residance' 	=> $allow_residence_cost,
										'dm_allow_rent' 				=> 'Month',
										'allowance_rent' 				=> $allow_rent,
										'dm_allow_park' 				=> 'Month',
										'allowance_park' 				=> $allow_parking,
										'dm_allow_medicine' 		=> 'Month',
										'allowance_medicine' 		=> $allow_medichine,
										'dm_allow_akomodasi' 		=> 'Month',
										'allowance_akomodasi' 	=> $allow_akomodsasi,
										'dm_allow_kasir' 				=> 'Month',
										'allowance_kasir' 			=> $allow_kasir,
										'dm_allow_operation' 		=> 'Month',
										'allowance_operation' 	=> $allow_operational,
										'img_esign'							=> $image_name,
										'contract_type_id'			=> '2',

										'request_pkwt' 					=> $createdby,
										'request_date'					=> $createdon,
										'approve_nae'						=> $approved_naeby,
										'approve_nae_date'			=> $approved_naeon,
										'approve_nom'						=> $approved_nomby,
										'approve_nom_date'			=> $approved_nomon,
										'approve_hrd'						=> $session['user_id'],
										'approve_hrd_date'			=> date('Y-m-d h:i:s'),

										'sign_nip'							=> '21500006',
										'sign_fullname'					=> 'ASTI PRASTISTA',
										'sign_jabatan'					=> 'SM HR & GA',
										'status_pkwt' => 1,
										'createdon' => date('Y-m-d h:i:s'),
										'createdby' => $session['user_id']
								);

								$xresult = $this->Pkwt_model->add_pkwt_record($data);

								$data_up = array(
									// 'nip'							=> $employee_id,
									'migrasi' => '1',
									'approved_hrdby' =>  $session['user_id'],
									'approved_hrdon' => date("Y-m-d h:i:s")
								);
								
								$result = $this->Employees_model->update_request_employee($data_up,$id);

					}

			// $data_up = array(
			// 	'nip' => $employee_id,
			// 	'approved_hrdby' =>  $session['user_id'],
			// 	'approved_hrdon' => date('Y-m-d h:i:s'),
			// );

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
	

	// Validate and update info in database
	public function updateNote() {
		
		$session = $this->session->userdata('username');
		if(empty($session)) {
			redirect('admin/');
		}

			$config['cacheable']	= true; //boolean, the default is true
			$config['cachedir']		= './assets/'; //string, the default is application/cache/
			$config['errorlog']		= './assets/'; //string, the default is application/logs/
			$config['imagedir']		= './assets/images/pkwt/'; //direktori penyimpanan qr code
			$config['quality']		= true; //boolean, the default is true
			$config['size']			= '1024'; //interger, the default is 1024
			$config['black']		= array(224,255,255); // array, default is array(255,255,255)
			$config['white']		= array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

		// $id = '31';
		$id = $this->uri->segment(4);
		$cancel = $this->uri->segment(5);

		if($this->input->post('edit_type')=='company') {

					$idtransaksi 	= $this->input->post('idtransaksi');
		// $id = $this->uri->segment(4);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		



				$data_up = array(

					'catatan_hr' 	=> $this->input->post('ket_note')

				);

			// if($cancel==='YES'){

			// 	$data_up = array(

			// 		'cancel_stat' => 1,
			// 		'cancel_on' 	=> date("Y-m-d h:i:s"),
			// 		'cancel_by' 	=> $session['user_id'], 
			// 		'cancel_ket' 	=> $this->input->post('ket_revisi')

			// 	);
			// } else if ($cancel==='3'){


			// 	$data_up = array(

			// 		'catatan_hr' 	=> $this->input->post('ket_note')

			// 	);

			// }else {
			// 	$data_up = array(
			// 		// 'nip'							=> $employee_id,
			// 		'migrasi' => '1',
			// 		'approved_hrdby' =>  $session['user_id'],
			// 		'approved_hrdon' => date("Y-m-d h:i:s")

			// 	);
			// }

			// $data_up = array(
			// 	'nip' => $employee_id,
			// 	'approved_hrdby' =>  $session['user_id'],
			// 	'approved_hrdon' => date('Y-m-d h:i:s'),
			// );
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

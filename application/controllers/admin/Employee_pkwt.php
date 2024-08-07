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

class Employee_pkwt extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		$this->load->model("Esign_model");
		$this->load->model("Pkwt_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Employees_model");
		$this->load->model("Project_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Location_model");
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

		$role_resources_ids = $this->Xin_model->user_role_resource();
			$data['title'] = $this->lang->line('xin_pkwt_digital').' | '.$this->Xin_model->site_title();
			$data['all_companies'] = $this->Xin_model->get_companies();

			$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
			$data['all_emp_active'] = $this->Employees_model->get_all_employees_all();
			// if(in_array('139',$role_resources_ids)) {
			// } else {
			// 	$data['all_emp_active'] = $this->Employees_model->get_all_employees_project();
			// }

			// $data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_digital');
		$data['path_url'] = 'emp_pkwt';
		if(in_array('376',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function pkwt_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/pkwt_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_monitoring_rsign();
		$listpkwt = $this->Pkwt_model->get_monitoring_pkwt($session['employee_id']);

		$data = array();

          foreach($listpkwt->result() as $r) {
			  

				$emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
				if(!is_null($emp)){
					$fullname = $emp[0]->first_name;
					$sub_project = 'pkwt'.$emp[0]->sub_project_id;
				} else {
					$fullname = '--';	
					$sub_project = '0';
				}

				$no = $r->contract_id;
				$nip = $r->employee_id;
				$jabatan = $r->jabatan;
				$begin_until = $r->from_date .' s/d ' . $r->to_date;

				// if($emp[0]->sub_project_id == '1' || $emp[0]->sub_project_id == '2'){

				// 	$basic_pay = '******' ;
				// } else {

				// 	$basic_pay = $this->Xin_model->rupiah($r->basic_pay) ;
				// }

				$approve_nae = $r->approve_nae;
				$approve_nom = $r->approve_nom;
				$approve_hrd = $r->approve_hrd;

				if($approve_nae=="0"){
			  	$status_pkwt = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'.$r->contract_id. '">Need Approval NAE</button> <br>' . $r->no_surat;
				} else if($approve_nae!="0" && $approve_nom=="0") {
			  	$status_pkwt = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'.$r->contract_id. '">Need Approval NOM/SM</button><br>' . $r->no_surat;
				} else if($approve_nae!="0" && $approve_nom!="0") {
				  $status_pkwt = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'.$r->contract_id. '">Belum Terbit</button><br>' . $r->no_surat;
				} 
				else {
			  	$status_pkwt = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal">Contact IT Care</button>';
				}



				$projects = $this->Project_model->read_single_project($r->project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}


			// $view_pkwt = '<a href="'.site_url().'admin/'.$sub_project.'/view/'.$r->uniqueid.'" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-info">VIEW PKWT</button> </a>'; 

			$data[] = array(
				$no,
				// $status_pkwt.' '.$view_pkwt,
				$status_pkwt,
				$nip,
				$fullname,
				$nama_project,
				$jabatan,
				$begin_until,
				'$basic_pay',
			);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $listpkwt->num_rows(),
                 "recordsFiltered" => $listpkwt->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }


	 // get location > departments
	public function get_project_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pkwt/get_project_employees_pkwt", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_project_posisi() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_project_posisi", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_project_area() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_project_area", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_posisi() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_posisi", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_area() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		// $posi = $this->uri->segment(5);
		// $proj = $this->uri->segment(6);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_area", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_gaji() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		// $posi = $this->uri->segment(5);
		// $proj = $this->uri->segment(6);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/employees/get_pkwt_gaji", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_hk() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		// $posi = $this->uri->segment(5);
		// $proj = $this->uri->segment(6);
		
		$data = array(
			'id_project' => $id,
			// 'posi' => $posi,
			// 'proj' => $proj
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_hk", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_allow() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_allow", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	 // get location > departments
	public function get_pkwt_kontrak() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_kontrak", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_begin() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'id_project' => $id,
			// 'waktu_kontrak' => ''
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_begin", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_pkwt_waktukontrak() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$emp = $this->uri->segment(5);
		
		$data = array(
			'id_project' => $emp
			// 'waktu_kontrak' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_pkwt_begin", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_ktp() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'employee_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_ktp", $data);
		} else { 
			redirect('admin/');
		} 
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	 // get location > departments
	public function get_info_pkwt() { 

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array( 
			'employee_id' => $id
		); 
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_info_pkwt", $data);
		} else { 
			redirect('admin/');
		} 
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	public function request_employee_pkwt() { 
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		} 

		if($this->input->post('add_type')=='company') { 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>''); 
			$Return['csrf_hash'] = $this->security->get_csrf_hash(); 
			$system = $this->Xin_model->read_setting_info(1); 


			$config['cacheable']	= true; //boolean, the default is true
			$config['cachedir']		= './assets/'; //string, the default is application/cache/
			$config['errorlog']		= './assets/'; //string, the default is application/logs/
			$config['imagedir']		= './assets/images/pkwt/'; //direktori penyimpanan qr code
			$config['quality']		= true; //boolean, the default is true
			$config['size']			= '1024'; //interger, the default is 1024
			$config['black']		= array(224,255,255); // array, default is array(255,255,255)
			$config['white']		= array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

				if($this->input->post('project_id')=='') {
					$Return['error'] = 'Project Tidak ditemukan..!';
				} else if($this->input->post('employee_id')=='') {
					$Return['error'] = 'NIP Karyawan Tidak ditemukan..!';
				} else if ($this->input->post('begin')=='') {
					$Return['error'] = 'Tanggal PKWT Kosong..!';
				} else if ($this->input->post('waktu_kontrak')=='') {
					$Return['error'] = 'Periode Kontrak kosong..!';
				} else if ($this->input->post('jabatan')==''){
					$Return['error'] = 'Posisi/Jabatan tidak ditemukan..!';
				} else if ($this->input->post('area')==''){
					$Return['error'] = 'Penempatan kosong..!';
				} else if ($this->input->post('harikerja')==''){
					$Return['error'] = 'Jumlah HK Kosong..!';
				} else if ($this->input->post('cutoff')==''){
					$Return['error'] = 'Tanggal CUTOFF Kosong..!';
				} else if ($this->input->post('penggajian')==''){
					$Return['error'] = 'Tanggal PENGGAJIAN Kosong..!';
				} else if ($this->input->post('gaji')==''){
					$Return['error'] = 'GAJI POKOK Kosong..!';
				} 

				else {

					if(strtoupper($this->input->post('company'))=='PT. SIPRAMA CAKRAWALA'){
						$pkwt_hr = 'E-PKWT-JKT/SC-HR/';
						$spb_hr = 'E-SPB-JKT/SC-HR/';
						$companyID = '2';
					}else if (strtoupper($this->input->post('company'))=='PT. KRISTA AULIA CAKRAWALA'){
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

			   	$idproject = $this->input->post('project_id');
			   	$employee_id = $this->input->post('employee_id');
			   	$begin_date = $sub_kalimat = substr($this->input->post('begin'),0,10);
			   	$end_date = $sub_kalimat = substr($this->input->post('begin'),-10);
					$waktu_kontrak = $this->input->post('waktu_kontrak');
					$company = $companyID;
					$jabatan = strtoupper($this->input->post('jabatan'));
					$area = strtoupper($this->input->post('area'));
					$harikerja = strtoupper($this->input->post('harikerja'));
					$cutoff = strtoupper($this->input->post('cutoff'));
					$penggajian = strtoupper($this->input->post('penggajian'));
					$gaji = strtoupper($this->input->post('gaji'));
					// $dm_grade = strtoupper($this->input->post('dm_grade'));
					$allow_grade = strtoupper($this->input->post('allow_grade'));
					// $dm_area = strtoupper($this->input->post('dm_area'));
					$allow_area = strtoupper($this->input->post('allow_area'));
					// $dm_masakerja = strtoupper($this->input->post('dm_masakerja'));
					$allow_masakerja = strtoupper($this->input->post('allow_masakerja'));
					// $dm_trans_meal = strtoupper($this->input->post('dm_trans_meal'));
					$allow_trans_meal = strtoupper($this->input->post('allow_trans_meal'));
					// $dm_konsumsi = strtoupper($this->input->post('dm_konsumsi'));
					$allow_konsumsi = strtoupper($this->input->post('allow_konsumsi'));
					// $dm_transport = strtoupper($this->input->post('dm_transport'));
					$allow_transport = strtoupper($this->input->post('allow_transport'));
					// $dm_comunication = strtoupper($this->input->post('dm_comunication'));
					$allow_comunication = strtoupper($this->input->post('allow_comunication'));
					// $dm_device = strtoupper($this->input->post('dm_device'));
					$allow_device = strtoupper($this->input->post('allow_device'));
					// $dm_residance = strtoupper($this->input->post('dm_residance'));
					$allow_residance = strtoupper($this->input->post('allow_residance'));
					// $dm_rent = strtoupper($this->input->post('dm_rent'));
					$allow_rent = strtoupper($this->input->post('allow_rent'));
					// $dm_parking = strtoupper($this->input->post('dm_parking'));
					$allow_parking = strtoupper($this->input->post('allow_parking'));
					// $dm_medicine = strtoupper($this->input->post('dm_medicine'));
					$allow_medichine = strtoupper($this->input->post('allow_medichine'));
					// $dm_akomodsasi = strtoupper($this->input->post('dm_akomodsasi'));
					$allow_akomodsasi = strtoupper($this->input->post('allow_akomodsasi'));
					// $dm_kasir = strtoupper($this->input->post('dm_kasir'));
					$allow_kasir = strtoupper($this->input->post('allow_kasir'));
					// $dm_operational = strtoupper($this->input->post('dm_operational'));
					$allow_operational = strtoupper($this->input->post('allow_operational'));

					$docid = date('ymdHisv');
					$image_name='esign_pkwt'.date('ymdHisv').'.png'; //buat name dari qr code sesuai dengan nim
					$domain = 'https://apps-cakrawala.com/esign/pkwt/'.$docid;
					$params['data'] = $domain; //data yang akan di jadikan QR CODE
					$params['level'] = 'H'; //H=High
					$params['size'] = 10;
					$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
					$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
					

						$data = array(
							'uniqueid' 							=> $unicode,
							'employee_id' 					=> $employee_id,
							'docid'									=> $docid,
							'project' 							=> $idproject,
							'from_date'	 						=> $begin_date,
							'to_date' 							=> $end_date,
							'no_surat' 							=> $nomor_surat,
							'no_spb' 								=> $nomor_surat_spb,
							'waktu_kontrak' 				=> $waktu_kontrak,
							'company' 							=> $company,
							'jabatan' 							=> $jabatan,
							'penempatan' 						=> $area,
							'hari_kerja' 						=> $harikerja,
							'tgl_payment'						=> $penggajian,
							'end_period_payment'		=> $cutoff,
							'basic_pay' 						=> $gaji,
							'dm_allow_grade' 				=> 'Month',
							'allowance_grade'				=> $allow_grade,
							'dm_allow_area' 				=> 'Month',
							'allowance_area'				=> $allow_area,
							'dm_allow_masakerja' 		=> 'Month',
							'allowance_masakerja' 	=> $allow_masakerja,
							'dm_allow_transmeal' 		=> 'Month',
							'allowance_transmeal' 	=> $allow_trans_meal,
							'dm_allow_meal' 				=> 'Month',
							'allowance_meal' 				=> $allow_konsumsi,
							'dm_allow_transport' 		=> 'Month',
							'allowance_transport' 	=> $allow_transport,
							'dm_allow_komunikasi' 	=> 'Month',
							'allowance_komunikasi' 	=> $allow_comunication,
							'dm_allow_laptop' 			=> 'Month',
							'allowance_laptop' 			=> $allow_device,
							'dm_allow_residance' 		=> 'Month',
							'allowance_residance' 	=> $allow_residance,
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

							'sign_nip'							=> '21300033',
							'sign_fullname'					=> 'SISKYLA KHAIRANA PRITIGARINI',
							'sign_jabatan'					=> 'HR & GA MANAGER',
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
				'posisi' => $this->Designation_model->read_designation_information($result[0]->jabatan),
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
				// 'approve_hrd' => $this->Employees_model->read_employee_info($result[0]->approve_resignhrd),
				// 'approve_resignhrd_on' => $result[0]->approve_resignhrd_on,
				
				
				// // 'location_id' => $this->Location_model->read_location_information($result[0]->location_id),
				// // 'sub_project' => $this->Project_model->read_single_subproject($result[0]->sub_project),
				// // 'department' => $this->Department_model->read_department_information($result[0]->department),
				// 'posisi' => $this->Designation_model->read_designation_information($result[0]->designation_id),

				// 'createdon' => $result[0]->createdon,
				// 'modifiedon' => $result[0]->modifiedon,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/pkwt/dialog_pkwt_req', $data);
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

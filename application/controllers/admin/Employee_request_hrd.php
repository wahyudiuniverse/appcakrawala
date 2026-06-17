<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author traxes
 * @author-email  supoort@traxes.co.id
 * @copyright  Copyright © traxes.co.id All Rights Reserved
 */
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Employee_request_hrd extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Register_model");
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
	public function output($Return = array())
	{
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function index()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$data['title'] = $this->lang->line('xin_request_employee') . ' | ' . $this->Xin_model->site_title();

		$data['all_companies'] = $this->Xin_model->get_companies();
		// $data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);
		$data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);

		//Parameter filter datatables
		$project_karyawan = $this->input->post('project_id');
		$golongan_karyawan = $this->input->post('golongan');
		$kategori_karyawan = $this->input->post('kategori');
		$approve_karyawan = $this->input->post('approve');

		//Cek apakah ada input parameter
		$data['project_karyawan'] = is_null($project_karyawan) ? "" : $project_karyawan;
		$data['golongan_karyawan'] = is_null($golongan_karyawan) ? "" : $golongan_karyawan;
		$data['kategori_karyawan'] = is_null($kategori_karyawan) ? "" : $kategori_karyawan;
		$data['approve_karyawan'] = is_null($approve_karyawan) ? "" : $approve_karyawan;
		$data['session'] = $session;

		$data['list_agama'] 		= $this->Xin_model->getAllEthnicity();
		$data['list_ptkp'] 			= $this->Xin_model->getAllptkp();
		$data['list_relation'] 		= $this->Xin_model->getAllrelation();
		// $data['list_bank'] 			= $this->Xin_model->getAllbank();
		$data['list_bank'] 			= $this->Xin_model->get_bank_code();
		$data['list_project'] 		= $this->Xin_model->getAllProject($session['employee_id']);
		$data['list_subproject'] 	= $this->Xin_model->getAllsubProject();
		$data['list_posisi'] 		= $this->Xin_model->getAllPosisi();
		$data['list_location'] 		= $this->Xin_model->getAllLocation();
		// $data['all_projects_sub'] = $this->Project_model->get_all_projects();
		// $data['all_departments'] = $this->Department_model->all_departments();
		// $data['all_designations'] = $this->Designation_model->all_designations();
		$count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']);

		$data['breadcrumbs'] = 'KARYAWAN BARU ( ' . $count_emp_request_hrd . ' )';
		$data['path_url'] = 'emp_request_hrd';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//$role_resources_ids = is_null($role_resources_ids_temp) ? 0 : $role_resources_ids_temp;
		if (in_array('327', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/request_list_hrd", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//coba data tables custom load per page
	public function request_list_hrd2()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Employees_model->get_request_hrd2($postData);

		echo json_encode($data);
	}


	//mengambil Json data interviewer
	public function get_data_employee_request()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'xin_employee_request.secid'        => $postData['secid']
		];

		// get data diri
		$data = $this->Employees_model->get_data_employee_request2($datarequest);

		if (empty($data)) {
			$data_empty = array();

			$response = array(
				'status'	=> "0",
				'pesan' 	=> "Belum ada data",
				'data'		=> $data_empty,
			);
		} else {
			$response = array(
				'status'	=> "1",
				'pesan' 	=> "Berhasil Fetch Data",
				'data'		=> $data,
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	//mengambil Json data interviewer
	public function get_data_upah_request()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'xin_employee_request.secid'        => $postData['secid']
		];

		// get data diri
		$data = $this->Employees_model->get_data_upah_request($datarequest);

		if (empty($data)) {
			$data_empty = array();

			$response = array(
				'status'	=> "0",
				'pesan' 	=> "Belum ada data",
				'data'		=> $data_empty,
			);
		} else {
			$response = array(
				'status'	=> "1",
				'pesan' 	=> "Berhasil Fetch Data",
				'data'		=> $data,
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	//mengambil Json data interviewer
	public function get_dokumen_employee_request()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'xin_employee_request.secid'        => $postData['secid']
		];

		// get data diri
		$data = $this->Employees_model->get_dokumen_employee_request($datarequest);

		//verification id
		// $actual_verification_id = $postData['secid'];

		// //cek status verifikasi ke database
		// $nik_validation = "0";
		// $nik_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nik');
		// if (is_null($nik_validation_query)) {
		// 	$nik_validation = "0";
		// } else {
		// 	$nik_validation = $nik_validation_query['status'];
		// }
		// $kk_validation = "0";
		// $kk_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'kk');
		// if (is_null($kk_validation_query)) {
		// 	$kk_validation = "0";
		// } else {
		// 	$kk_validation = $kk_validation_query['status'];
		// }
		// $nama_validation = "0";
		// $nama_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'nama');
		// if (is_null($nama_validation_query)) {
		// 	$nama_validation = "0";
		// } else {
		// 	$nama_validation = $nama_validation_query['status'];
		// }
		// $bank_validation = "0";
		// $bank_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'bank');
		// if (is_null($bank_validation_query)) {
		// 	$bank_validation = "0";
		// } else {
		// 	$bank_validation = $bank_validation_query['status'];
		// }
		// $norek_validation = "0";
		// $norek_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'norek');
		// if (is_null($norek_validation_query)) {
		// 	$norek_validation = "0";
		// } else {
		// 	$norek_validation = $norek_validation_query['status'];
		// }
		// $pemilik_rekening_validation = "0";
		// $pemilik_rekening_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'pemilik_rekening');
		// if (is_null($pemilik_rekening_validation_query)) {
		// 	$pemilik_rekening_validation = "0";
		// } else {
		// 	$pemilik_rekening_validation = $pemilik_rekening_validation_query['status'];
		// }
		// $dokumen_ktp_validation = "0";
		// $dokumen_ktp_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'dokumen_ktp');
		// if (is_null($dokumen_ktp_validation_query)) {
		// 	$dokumen_ktp_validation = "0";
		// } else {
		// 	$dokumen_ktp_validation = $dokumen_ktp_validation_query['status'];
		// }
		// $dokumen_kk_validation = "0";
		// $dokumen_kk_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'dokumen_kk');
		// if (is_null($dokumen_kk_validation_query)) {
		// 	$dokumen_kk_validation = "0";
		// } else {
		// 	$dokumen_kk_validation = $dokumen_kk_validation_query['status'];
		// }
		// $buku_rekening_validation = "0";
		// $buku_rekening_validation_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'buku_rekening');
		// if (is_null($buku_rekening_validation_query)) {
		// 	$buku_rekening_validation = "0";
		// } else {
		// 	$buku_rekening_validation = $buku_rekening_validation_query['status'];
		// }
		// $ijazah_validation = "0";
		// $ijazah_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'ijazah');
		// if (is_null($ijazah_query)) {
		// 	$ijazah_validation = "0";
		// } else {
		// 	$ijazah_validation = $ijazah_query['status'];
		// }
		// $cv_validation = "0";
		// $cv_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'cv');
		// if (is_null($cv_query)) {
		// 	$cv_validation = "0";
		// } else {
		// 	$cv_validation = $cv_query['status'];
		// }
		// $skck_validation = "0";
		// $skck_query = $this->Employees_model->get_valiadation_status($actual_verification_id, 'skck');
		// if (is_null($skck_query)) {
		// 	$skck_validation = "0";
		// } else {
		// 	$skck_validation = $skck_query['status'];
		// }

		//assign checklist hijau kalau sudah diverifikasi
		// $validate_nik = "";
		// if ($nik_validation == "1") {
		// 	$validate_nik = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_nik = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $button_open_ktp = '<button onclick="open_ktp(' . $record->employee_id . ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KTP</button>';
		// $validate_kk = "";
		// if ($kk_validation == "1") {
		// 	$validate_kk = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_kk = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_nama = "";
		// if ($nama_validation == "1") {
		// 	$validate_nama = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_nama = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_bank = "";
		// if ($bank_validation == "1") {
		// 	$validate_bank = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_bank = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_norek = "";
		// if ($norek_validation == "1") {
		// 	$validate_norek = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_norek = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_pemilik_rekening = "";
		// if ($pemilik_rekening_validation == "1") {
		// 	$validate_pemilik_rekening = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_pemilik_rekening = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_dokumen_ktp = "";
		// if ($dokumen_ktp_validation == "1") {
		// 	$validate_dokumen_ktp = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_dokumen_ktp = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_dokumen_kk = "";
		// if ($dokumen_kk_validation == "1") {
		// 	$validate_dokumen_kk = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_dokumen_kk = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_buku_rekening = "";
		// if ($buku_rekening_validation == "1") {
		// 	$validate_buku_rekening = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_buku_rekening = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_ijazah = "";
		// if ($ijazah_validation == "1") {
		// 	$validate_ijazah = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_ijazah = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_cv = "";
		// if ($cv_validation == "1") {
		// 	$validate_cv = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_cv = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }
		// $validate_skck = "";
		// if ($skck_validation == "1") {
		// 	$validate_skck = "<img src=" . base_url('/assets/icon/verified.png') . " width='20'>";
		// } else {
		// 	$validate_skck = "<img src=" . base_url('/assets/icon/not-verified.png') . " width='20'>";
		// }


		if (empty($data)) {
			$data_empty = array();

			$response = array(
				'status'	=> "0",
				'pesan' 	=> "Belum ada data",
				'data'		=> $data_empty,
				'nik_validation'			=> $nik_validation,
				'validate_nik'				=> $validate_nik
			);
		} else {
			$response = array(
				'status'	=> "1",
				'pesan' 	=> "Berhasil Fetch Data",
				'data'		=> $data,
				'nik_validation'			=> $nik_validation,
				'validate_nik'				=> $validate_nik
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	public function printExcel($project_id, $kategori, $golongan,  $approve, $idsession, $filter)
	{
		$postData = array();

		//variabel filter (diambil dari post ajax di view)
		$postData['project_id'] = $project_id;
		$postData['golongan'] = $golongan;
		$postData['kategori'] = $kategori;
		$postData['approve'] = $approve;
		$postData['idsession'] = $idsession;
		$postData['nama_file'] = 'Data Request Karyawan';
		if ($filter == '-no_input-') {
			$postData['filter'] = '';
		} else {
			$postData['filter'] = urldecode($filter);
		}

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('Data Request Karyawan'); //nama Spreadsheet yg baru dibuat

		//data satu row yg mau di isi
		$rowArray = [
			'KTP',
			'FULL NAME',
			'NAMA IBU',
			'TEMPAT LAHIR',
			'TANGGAL LAHIR (DD-MM-YYYY)',
			'PT',
			'PROJECT',
			'SUB PROJECT',
			'DEPARTEMEN',
			'POSISI',
			'GENDER',
			'AGAMA',
			'STATUS KAWIN',
			'DATE OF JOIN',
			'CONTRACT START (DD-MM-YYYY)',
			'CONTRACT END (DD-MM-YYYY)',
			'PERIODE',
			'NO KONTAK',
			'ALAMAT KTP',
			'ALAMAT DOMISILI',
			'NO KK',
			'NO NPWP',
			'EMAIL',
			'PENEMPATAN',
			'BANK NAME',
			'BANK CODE',
			'NO REKENING',
			'PEMILIK REKENING',
			'GAJI POKOK',
			'allow_jabatan',
			'allow_konsumsi',
			'allow_transport',
			'allow_comunication',
			'allow_rent',
			'allow_parking',
			'allow_device',
			'allow_trans_meal',
			'allow_trans_rent',
			'allow_operational',
			'catatan_hr',
			'TANGGAL REGISTER',
			'FILE KTP',
			'FILE KK',
			'FILE NPWP',
			'FILE IJAZAH',
			'FILE CV',
			'FILE SKCK',
		];

		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$rowArray,   // The data to set
				NULL,
				'A1'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= 100; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set background color
		$spreadsheet
			->getActiveSheet()
			->getStyle('A1:AL1')
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		//$spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR);

		// Get data
		$data = $this->Employees_model->get_request_print($postData);
		//$data = var_dump(json_decode($data_temp, true));

		if (!is_array(end($data))) {
			$data = [$data];
		}

		$jumlah = count($data) + 1;

		//var_dump($data);

		$spreadsheet->getActiveSheet()
			->fromArray(
				$data,  // The data to set
				NULL,        // Array values with this value will not be set
				'A2',
				false,
				false         // Top left coordinate of the worksheet range where
				//    we want to set these values (default is A1)
			);

		//----------Begin conditional kalau ada value blank---------------
		$redStyle = new Style(false, true);
		$redStyle->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getEndColor()->setARGB(Color::changeBrightness("FF0000", 0.7));
		$redStyle->getFont()->setColor(new Color(Color::COLOR_WHITE));

		$blueStyle = new Style(false, true);
		$blueStyle->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getEndColor()->setARGB(Color::changeBrightness("0000FF", 0));
		$blueStyle->getFont()->setColor(new Color(Color::COLOR_WHITE));
		$blueStyle->getNumberFormat()->setFormatCode('@');
		$blueStyle->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$blueStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

		$cellRange = 'A2:AL' . $jumlah;
		$conditionalStyles = [];
		$wizardFactory = new Wizard($cellRange);
		/** @var Wizard\Blanks $blanksWizard */
		$blanksWizard = $wizardFactory->newRule(Wizard::BLANKS);

		$blanksWizard->setStyle($redStyle);

		$conditionalStyles[] = $blanksWizard->getConditional();

		$spreadsheet->getActiveSheet()
			->getStyle($blanksWizard->getCellRange())
			->setConditionalStyles($conditionalStyles);

		$cellWizard = $wizardFactory->newRule(Wizard::CELL_VALUE);

		$cellWizard->equals(0)
			->setStyle($redStyle);
		$conditionalStyles[] = $cellWizard->getConditional();

		$spreadsheet->getActiveSheet()
			->getStyle($cellWizard->getCellRange())
			->setConditionalStyles($conditionalStyles);
		//----------End conditional kalau ada value blank---------------


		//---------Begin Conditional Formatting siap approve------------
		// $cellRange2 = 'A2:H' . $jumlah;
		// $conditionalStyles2 = [];
		// $wizardFactory2 = new Wizard($cellRange2);

		// $cellWizard2 = $wizardFactory2->newRule(Wizard::EXPRESSION);

		// $cellWizard2->expression('ISNUMBER(SEARCH("(Siap Approve)", $B1))')
		// 	->setStyle($blueStyle);
		// $conditionalStyles2[] = $cellWizard2->getConditional();

		// $spreadsheet->getActiveSheet()
		// 	->getStyle($cellWizard2->getCellRange())
		// 	->setConditionalStyles($conditionalStyles2);
		//---------End Conditional Formatting siap approve------------

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:1')->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');
		$spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$spreadsheet->getActiveSheet()->getStyle('AC:AI')->getNumberFormat()->setFormatCode('Rp #,##0');
		$spreadsheet->getActiveSheet()->getStyle('1:1')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('1:1')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = $postData['nama_file'];

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');


		$writer->save('php://output');
	}

	public function tes()
	{
		$postData = array();

		//variabel filter (diambil dari post ajax di view)
		$postData['project_id'] = 0;
		$postData['golongan'] = 0;
		$postData['kategori'] = 0;
		$postData['approve'] = 0;
		$postData['idsession'] = 1;
		$postData['nama_file'] = 'Data Request Karyawan';
		$postData['filter'] = 'NUR FADOLI';
		$data = $this->Employees_model->get_request_print($postData);

		if (!is_array(end($data))) {
			$data = [$data];
		}

		//echo json_encode($data);
		print_r($data);
		//echo $data;
	}

	public function request_list_hrd()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/employees/request_list_hrd", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$project_id = $this->uri->segment(4);

		if ($project_id == 0) {
			// $employee = $this->Pkwt_model->report_pkwt_expired_default($session['employee_id']);

			$employee = $this->Employees_model->get_request_hrd($session['employee_id']);
		} else {
			// $employee = $this->Pkwt_model->report_pkwt_expired_pro($project_id, $session['employee_id']);

			$employee = $this->Employees_model->get_request_hrdpro($session['employee_id'], $project_id);
		}

		// $employee = $this->Employees_model->get_request_hrd();
		// $employee = $this->Employees_model->get_request_hrd($session['employee_id']);

		$data = array();

		foreach ($employee->result() as $r) {
			$no = $r->secid;
			$fullname = $r->fullname;
			$location_id = $r->location_id;
			$project = $r->project;
			$sub_project = $r->sub_project;
			$department = $r->department;
			$posisi = $r->posisi;
			$contact_no = $r->contact_no;
			$penempatan = $r->penempatan;
			$doj = $r->doj;
			$contact_no = $r->contact_no;
			$nik_ktp = $r->nik_ktp;
			$notes = $r->catatan_hr;

			$register_date = $r->request_empon;
			$approved_hrdby = $r->approved_hrdby;


			if ($approved_hrdby == null) {

				$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$' . $r->secid . '">Need Approval HRD</button>';
			} else {

				$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="$' . $r->secid . '">Approved</button>';
			}

			$editReq = '<a href="' . site_url() . 'admin/employee_request_cancelled/request_edit/' . $r->secid . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">EDIT</button></a>';

			$projects = $this->Project_model->read_single_project($r->project);
			if (!is_null($projects)) {
				$nama_project = $projects[0]->title;
			} else {
				$nama_project = '--';
			}

			$subprojects = $this->Project_model->read_single_subproject($r->sub_project);
			if (!is_null($subprojects)) {
				$nama_subproject = $subprojects[0]->sub_project_name;
			} else {
				$nama_subproject = '--';
			}

			$department = $this->Department_model->read_department_information($r->department);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}

			$designation = $this->Designation_model->read_designation_information($r->posisi);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$cancel = '<button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target=".edit-modal-data" data-company_id="@' . $r->secid . '">TOLAK</button>';

			$noteHR = '<button type="button" class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target=".edit-modal-data" data-company_id="!' . $r->secid . '">note</button>';

			if (in_array('382', $role_resources_ids)) {
				$nik_note = $nik_ktp . '<br><i>' . $notes . '</i> ' . $noteHR;
			} else {
				$nik_note = $nik_ktp . '<br><i>' . $notes;
			}

			$data[] = array(
				$no,
				$status_migrasi . ' <br>' . $cancel . ' ' . $editReq,
				$nik_note,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$contact_no,
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
	public function get_project_sub_project()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
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
	public function request_add_employee()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		if ($this->input->post('add_type') == 'company') {
			$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// $system = $this->Xin_model->read_setting_info(1);

			if ($this->input->post('fullname') == '') {
				$Return['error'] = 'Nama Lengkap Kosong..!';
			} else if ($this->input->post('nama_ibu') == '') {
				$Return['error'] = 'Nama Ibu Kandung Kosong..!';
			} else if ($this->input->post('tempat_lahir') == '') {
				$Return['error'] = 'Tempat Lahir Kosong..!';
			} else if ($this->input->post('date_of_birth') == '') {
				$Return['error'] = 'Tanggal Lahir Kosong..!';
			} else if ($this->input->post('company_id') == '') {
				$Return['error'] = 'Company Kosong..!';
			} else if ($this->input->post('office_lokasi') == '') {
				$Return['error'] = 'Office Location Kosong..!';
			} else if ($this->input->post('project_id') == '') {
				$Return['error'] = 'Project Kosong..!';
			} else if ($this->input->post('sub_project_id') == '') {
				$Return['error'] = 'Sub Project Kosong..!';
			} else if ($this->input->post('department_id') == '') {
				$Return['error'] = 'Departement Kosong..!';
			} else if ($this->input->post('posisi') == '') {
				$Return['error'] = 'Posisi Jabatan Kosong..!';
			} else if ($this->input->post('date_of_join') == '') {
				$Return['error'] = 'Join Date Kosong..!';
			} else if ($this->input->post('join_date_pkwt') == '') {
				$Return['error'] = 'Join Date PKWT Kosong..!';
			} else if ($this->input->post('pkwt_end_date') == '') {
				$Return['error'] = 'End Date PKWT Kosong..!';
			} else if ($this->input->post('waktu_kontrak') == '') {
				$Return['error'] = 'Periode Kontrak Kosong..!';
			} else if ($this->input->post('nomor_hp') == '') {
				$Return['error'] = 'Nomor Hp Kosong..!';
			} else if ($this->input->post('nomor_ktp') == '') {
				$Return['error'] = 'KTP Kosong..!';
			} else if ($this->input->post('alamat_ktp') == '') {
				$Return['error'] = 'Alamat KTP Kosong..!';
			} else if ($this->input->post('alamat_domisili') == '') {
				$Return['error'] = 'Alamat Domisili Kosong..!';
			} else if ($this->input->post('nomor_kk') == '') {
				$Return['error'] = 'KK Kosong..!';
			} else if ($this->input->post('email') == '') {
				$Return['error'] = 'Email Kosong..!';
			} else if ($this->input->post('penempatan') == '') {
				$Return['error'] = 'Penempatan Kosong..!';
			} else if ($this->input->post('hari_kerja') == '') {
				$Return['error'] = 'Hari Kerja Kosong..!';
			} else if ($this->input->post('gaji_pokok') == '') {
				$Return['error'] = 'Gaji Pokok Kosong..!';
			} else if ($this->input->post('bank_name') == '') {
				$Return['error'] = 'Nama Bank Kosong..!';
			} else if ($this->input->post('no_rek') == '') {
				$Return['error'] = 'Nomor Rekening Kosong..!';
			} else if ($this->input->post('pemilik_rekening') == '') {
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

				$fullname 					= str_replace("'", " ", $this->input->post('fullname'));
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
				$allow_medicine			= $this->input->post('tunjangan_kesehatan');
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
					'allow_medicine'				=> $allow_medicine,
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

			if ($Return['error'] != '') {
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


	//mengambil Json all outlet dan user mobile by project id
	public function get_entitas_project()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'project_id'        	=> $postData['project_id'],
		];

		// get data all jabatan by project dari request man power JO
		// $data = $this->Callplan_model->get_outlet_user_mobile_by_project($datarequest);
		$data = $this->Employees_model->get_entitas_by_project($datarequest);

		echo json_encode($data);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	//mengambil Json all outlet dan user mobile by project id
	public function get_posisi_subproject()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'sub_project'        	=> $postData['sub_project_id'],
		];

		// get data all jabatan by project dari request man power JO
		// $data = $this->Callplan_model->get_outlet_user_mobile_by_project($datarequest);
		$data = $this->Employees_model->get_posisi_by_entitas($datarequest);

		echo json_encode($data);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	public function read()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

		$idsubmit = substr($this->input->get('company_id'), 0, 1);
		// $id = str_replace("#","",str_replace("$","",str_replace("@","",$this->input->get('company_id'))));
		$id = str_replace("!", "", str_replace("$", "", str_replace("@", "", $this->input->get('company_id'))));

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
			'department' => 5,
			'posisi' => $this->Designation_model->read_designation_information($result[0]->posisi),
			'doj' => $result[0]->doj,
			'contact_no' => $result[0]->contact_no,
			'email' => $result[0]->migrasi,
			'logo' => $result[0]->tgl_migrasi,
			'contact_number' => $result[0]->nip,
			'alamat_ktp' => $result[0]->alamat_ktp,
			'penempatan' => $result[0]->penempatan,
			'region_name' => $result[0]->region_name,
			'dc_name' => $result[0]->dc_name,
			'e_status' => $result[0]->e_status,

			'waktu_kontrak' => $result[0]->contract_periode . ' (Bulan)',
			'begin' => $result[0]->contract_start . ' s/d ' . $result[0]->contract_end,

			'cut_off' => $result[0]->cut_start . ' - ' . $result[0]->cut_off,
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
			'allowance_medicine' => $result[0]->allow_medicine,
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
			'catatan_hr' => $result[0]->catatan_hr,

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

		if ($idsubmit == '$') {
			$this->load->view('admin/employees/dialog_emp_hrd', $data);
		} else if ($idsubmit == '@') {
			$this->load->view('admin/employees/dialog_emp_cancel_hrd', $data);
		} else {
			$this->load->view('admin/employees/dialog_emp_notehrd', $data);
		}

		// $this->load->view('admin/employees/dialog_emp_hrd', $data);
	}


	// Validate and update info in database
	public function update()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$yearmonth = date('Y/m');
		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= './assets/'; //string, the default is application/cache/
		$config['errorlog']		= './assets/'; //string, the default is application/logs/
		$config['imagedir']		= './assets/images/pkwt/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '1024'; //interger, the default is 1024
		$config['black']		= array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']		= array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		// $id = '31';

		//if ($this->input->post('edit_type') == 'company') {

		// $idtransaksi 	= $this->input->post('idtransaksi');
		$id = $this->uri->segment(4);
		$cancel = $this->uri->segment(5);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
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
		$allow_medicine			= $employee_request[0]->allow_medicine;
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
		$civi								= $employee_request[0]->civi;
		$paklaring								= $employee_request[0]->paklaring;

		$createdby 						= $employee_request[0]->request_empby;
		$createdon 						= $employee_request[0]->request_empon;
		$approved_naeby 						= $employee_request[0]->approved_naeby;
		$approved_naeon 						= $employee_request[0]->approved_naeon;
		$approved_nomby 						= $employee_request[0]->approved_nomby;
		$approved_nomon 						= $employee_request[0]->approved_nomon;

		// $employee_id = '2'.$employee_request[0]->location_id.$employee_request[0]->department.$count_nip;
		//NIP
		$employee_id = '2' . $employee_request[0]->location_id . $employee_request[0]->department . sprintf("%05d", $count_nip[0]->newcount);
		//PIN
		$private_code = rand(100000, 999999);
		//Pass
		$options = array('cost' => 12);
		$password_hash = password_hash($private_code, PASSWORD_BCRYPT, $options);

		//PKWT ATTRIBUTE
		if ($company_id == '2') {
			$pkwt_hr = 'E-PKWT-JKT/SC-HR/';
			$spb_hr = 'E-SPB-JKT/SC-HR/';
		} else if ($company_id == '3') {
			$pkwt_hr = 'E-PKWT-JKT/KAC-HR/';
			$spb_hr = 'E-SPB-JKT/KAC-HR/';
		} else {
			$pkwt_hr = 'E-PKWT-JKT/MATA-HR/';
			$spb_hr = 'E-SPB-JKT/MATA-HR/';
		}

		$count_pkwt = $this->Xin_model->count_pkwt();
		$romawi = $this->Xin_model->tgl_pkwt();
		$unicode = $this->Xin_model->getUniqueCode(20);
		$nomor_surat = sprintf("%06d", $count_pkwt[0]->newpkwt) . '/' . $pkwt_hr . $romawi;
		$nomor_surat_spb = sprintf("%06d", $count_pkwt[0]->newpkwt) . '/' . $spb_hr . $romawi;


		$docid = date('ymdHisv');
		$yearmonth = date('Y/m');
		$image_name = $yearmonth . '/esign_pkwt' . date('ymdHisv') . '.png'; //buat name dari qr code sesuai dengan nim
		$domain = 'https://apps-cakrawala.com/esign/pkwt/' . $yearmonth . '/' . $docid;
		$params['data'] 	= $domain; //data yang akan di jadikan QR CODE
		$params['level'] 	= 'H'; //H=High
		$params['size'] 	= 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE


		if ($cancel === 'YES') {

			$data_up = array(

				'cancel_stat' => 1,
				'cancel_on' 	=> date("Y-m-d h:i:s"),
				'cancel_by' 	=> $session['user_id'],
				'cancel_ket' 	=> $this->input->post('ket_revisi')

			);

			$result = $this->Employees_model->update_request_employee($data_up, $id);
		} else if ($contract_start == '' || $contract_end == '') {

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
				'allow_medicine'				=> $allow_medicine,
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
				'sub_project'						=> $sub_project,
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
				'allowance_medicine' 		=> $allow_medicine,
				'dm_allow_akomodasi' 		=> 'Month',
				'allowance_akomodasi' 	=> $allow_akomodsasi,
				'dm_allow_kasir' 				=> 'Month',
				'allowance_kasir' 			=> $allow_kasir,
				'dm_allow_operation' 		=> 'Month',
				'allowance_operation' 	=> $allow_operational,
				'img_esign'							=> $image_name,

				'request_pkwt' 					=> $createdby,
				'request_date'					=> $createdon,
				'approve_nae'						=> $approved_naeby,
				'approve_nae_date'			=> $approved_naeon,
				'approve_nom'						=> $approved_nomby,
				'approve_nom_date'			=> $approved_nomon,
				'approve_hrd'						=> $session['user_id'],
				'approve_hrd_date'			=> date('Y-m-d h:i:s'),


							'sign_nip'							=> '21541934',
							'sign_fullname'					=> 'MARLIA ULFA',
							'sign_jabatan'					=> 'SM HRD & GA',

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

			$result = $this->Employees_model->update_request_employee($data_up, $id);
		}

		// $data_up = array(
		// 	'nip' => $employee_id,
		// 	'approved_hrdby' =>  $session['user_id'],
		// 	'approved_hrdon' => date('Y-m-d h:i:s'),
		// );

		if ($Return['error'] != '') {
			$this->output($Return);
		}


		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_company');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		//}
	}

	// Validate and update info in database
	public function update2()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$yearmonth = date('Y/m');
		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= './assets/'; //string, the default is application/cache/
		$config['errorlog']		= './assets/'; //string, the default is application/logs/
		$config['imagedir']		= './assets/images/pkwt/' . $yearmonth . '/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '1024'; //interger, the default is 1024
		$config['black']		= array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']		= array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);
		$dirsave = './assets/images/pkwt/';

		//kalau blm ada folder path nya
		if (!file_exists($config['imagedir'])) {
			mkdir($config['imagedir'], 0777, true);
		}

		//if ($this->input->post('edit_type') == 'company') {

		$id = $this->uri->segment(4);
		$cancel = $this->uri->segment(5);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();



		$count_nip = $this->Xin_model->count_nip();
		$employee_request = $this->Employees_model->read_employee_request2($id);

		$verification_id 		= $employee_request['secid'];
		$id_kandidat	 		= $employee_request['id_kandidat'];
		$id_screening	 		= $employee_request['id_screening'];
		$last_edu				= $employee_request['last_edu'];
		$jurusan				= $employee_request['jurusan'];
		$school_name			= $employee_request['school_name'];
		$tinggi_badan			= $employee_request['tinggi_badan'];
		$berat_badan			= $employee_request['berat_badan'];
		$golongan_darah			= $employee_request['golongan_darah'];
		$fullname 				= $employee_request['fullname'];
		$nama_ibu 				= $employee_request['nama_ibu'];
		$tempat_lahir 			= $employee_request['tempat_lahir'];
		$tanggal_lahir 			= $employee_request['tanggal_lahir'];
		$contact_no 			= $employee_request['contact_no'];
		$nik_ktp 				= $employee_request['nik_ktp'];
		$alamat_ktp 			= $employee_request['alamat_ktp'];
		$alamat_domisili		= $employee_request['alamat_domisili'];
		$id_kota_domisili		= $employee_request['id_kota_domisili'];
		$nama_kota_domisili		= $employee_request['nama_kota_domisili'];

		$no_kk 					= $employee_request['no_kk'];
		$npwp 					= $employee_request['npwp'];
		$email 					= $employee_request['email'];
		$company_id 			= $employee_request['company_id'];
		$location_id 			= $employee_request['location_id'];
		$project 				= $employee_request['project'];
		$sub_project 			= $employee_request['sub_project'];
		$department 			= $employee_request['department'];
		$posisi 				= $employee_request['posisi'];

		$gender 				= $employee_request['gender'];
		$agama 					= $employee_request['agama'];
		$status_kawin 			= $employee_request['status_kawin'];
		$e_status 				= $employee_request['e_status'];

		$doj 					= $employee_request['doj'];
		$contract_start			= $employee_request['contract_start'];
		$contract_end			= $employee_request['contract_end'];
		$contract_periode		= $employee_request['contract_periode'];
		$penempatan 			= $employee_request['penempatan'];
		$region_name 			= $employee_request['region_name'];
		$dc_name	 			= $employee_request['dc_name'];
		$hari_kerja				= $employee_request['hari_kerja'];
		$bank_id				= $employee_request['bank_id'];
		$no_rek					= $employee_request['no_rek'];
		$pemilik_rekening		= $employee_request['pemilik_rekening'];

		$gaji_pokok				= $employee_request['gaji_pokok'];
		$allow_jabatan			= $employee_request['allow_jabatan'];
		$allow_area				= $employee_request['allow_area'];
		$allow_masakerja		= $employee_request['allow_masakerja'];
		$allow_trans_meal		= $employee_request['allow_trans_meal'];
		$allow_trans_rent		= $employee_request['allow_trans_rent'];
		$allow_konsumsi			= $employee_request['allow_konsumsi'];
		$allow_transport		= $employee_request['allow_transport'];
		$allow_comunication		= $employee_request['allow_comunication'];
		$allow_device			= $employee_request['allow_device'];
		$allow_residence_cost	= $employee_request['allow_residence_cost'];
		$allow_rent				= $employee_request['allow_rent'];
		$allow_parking			= $employee_request['allow_parking'];
		$allow_medicine		= $employee_request['allow_medicine'];
		$allow_akomodsasi		= $employee_request['allow_akomodsasi'];
		$allow_kasir			= $employee_request['allow_kasir'];
		$allow_operational		= $employee_request['allow_operational'];
		$allow_skill			= $employee_request['allow_skill'];
		$allow_training			= $employee_request['allow_training'];

		$cut_start 				= $employee_request['cut_start'];
		$cut_off				= $employee_request['cut_off'];
		$date_payment 			= $employee_request['date_payment'];
		$foto_profile			= $employee_request['foto_profile'];
		$ktp					= $employee_request['ktp'];
		$kk						= $employee_request['kk'];
		$skck					= $employee_request['skck'];
		$ijazah					= $employee_request['ijazah'];
		$civi					= $employee_request['civi'];
		$paklaring				= $employee_request['paklaring'];

		$createdby 				= $employee_request['request_empby'];
		$createdon 				= $employee_request['request_empon'];
		$approved_naeby 		= $employee_request['approved_naeby'];
		$approved_naeon 		= $employee_request['approved_naeon'];
		$approved_nomby 		= $employee_request['approved_nomby'];
		$approved_nomon 		= $employee_request['approved_nomon'];

		//NIP
		$employee_id = $employee_request['company_id'] . $employee_request['location_id'] . $employee_request['department'] . sprintf("%05d", $count_nip[0]->newcount);
		//PIN
		$private_code = rand(100000, 999999);
		//Pass
		$options = array('cost' => 12);
		$password_hash = password_hash($private_code, PASSWORD_BCRYPT, $options);


		if ($e_status == 1) {

			if (strtoupper($company_id) == '2') {
				$pkwt_hr = 'E-PKWT-JKT/SC-HR/';
				$spb_hr = 'E-SPB-JKT/SC-HR/';
				$companyID = '2';
			} else if (strtoupper($company_id) == '3') {
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
			$nomor_surat = sprintf("%05d", $count_pkwt[0]->newpkwt) . '/' . $pkwt_hr . $romawi;
			$nomor_surat_spb = sprintf("%05d", $count_pkwt[0]->newpkwt) . '/' . $spb_hr . $romawi;
		} else {

			if (strtoupper($company_id) == '2') {
				$pkwt_hr = 'KEMITRAAN/SC-HR/';
				$spb_hr = 'KEMITRAAN/SC-HR/';
				$companyID = '2';
			} else if (strtoupper($company_id) == '3') {
				$pkwt_hr = 'KEMITRAAN/KAC-HR/';
				$spb_hr = 'KEMITRAAN/KAC-HR/';
				$companyID = '3';
			} else {
				$pkwt_hr = 'KEMITRAAN/MATA-HR/';
				$spb_hr = 'KEMITRAAN/MATA-HR/';
				$companyID = '4';
			}

			$count_pkwt = $this->Xin_model->count_tkhl();
			$romawi = $this->Xin_model->tgl_pkwt();
			$unicode = $this->Xin_model->getUniqueCode(20);
			$nomor_surat = sprintf("%05d", $count_pkwt[0]->newpkwt) . '/' . $pkwt_hr . $romawi;
			$nomor_surat_spb = sprintf("%05d", $count_pkwt[0]->newpkwt) . '/' . $spb_hr . $romawi;
		}


		$docid = date('ymdHisv');
		$yearmonth = date('Y/m');
		$image_name = $yearmonth . '/esign_pkwt' . date('ymdHisv') . '.png'; //buat name dari qr code sesuai dengan nim
		$domain = 'https://apps-cakrawala.com/esign/pkwt/' . $docid;
		$params['data'] 	= $domain; //data yang akan di jadikan QR CODE
		$params['level'] 	= 'H'; //H=High
		$params['size'] 	= 10;
		$params['savename'] = FCPATH . $dirsave . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE


		if ($cancel === 'YES') {

			$data_up = array(

				'cancel_stat' 	=> 1,
				'cancel_on' 	=> date("Y-m-d h:i:s"),
				'cancel_by' 	=> $session['user_id'],
				'cancel_ket' 	=> $this->input->post('ket_revisi')

			);

			$result = $this->Employees_model->update_request_employee($data_up, $id);
		} else if ($contract_start == '' || $contract_end == '') {

			$Return['error'] = 'Periode Kontrak Kosong...';
		} else {

			$data_migrate = array(

				'verification_id'			=> $verification_id,
				'id_kandidat'				=> $id_kandidat,
				'id_screening'				=> $id_screening,
				'last_edu'					=> $last_edu,
				'edu_prodi_name'			=> $jurusan,
				'edu_school_name'			=> $school_name,
				'employee_id' 				=> $employee_id,
				'username' 					=> $employee_id,
				'first_name' 				=> $fullname,
				'ibu_kandung' 				=> $nama_ibu,
				'tempat_lahir' 				=> $tempat_lahir,
				'date_of_birth' 			=> $tanggal_lahir,
				'blood_group' 				=> $golongan_darah,
				'tinggi_badan' 				=> $tinggi_badan,
				'berat_badan' 				=> $berat_badan,

				'company_id' 				=> $company_id,
				'location_id' 				=> $location_id,
				'project_id' 				=> $project,
				'sub_project_id' 			=> $sub_project,
				'department_id' 			=> $department,
				'designation_id' 			=> $posisi,
				'gender' 					=> $gender,
				'ethnicity_type' 			=> $agama,
				'marital_status' 			=> $status_kawin,
				'e_status' 					=> $e_status,

				'date_of_joining' 			=> $doj,
				'contract_start' 			=> $contract_start,
				'contract_end' 				=> $contract_end,
				'contract_periode' 			=> $contract_periode,
				'contact_no' 				=> $contact_no,
				'ktp_no' 					=> $nik_ktp,
				'alamat_ktp' 				=> $alamat_ktp,
				'alamat_domisili' 			=> $alamat_domisili,
				'id_kota_domisili' 			=> $id_kota_domisili,
				'nama_kota_domisili' 		=> $nama_kota_domisili,
				'kk_no' 					=> $no_kk,
				'npwp_no' 					=> $npwp,
				'email' 					=> $email,
				'penempatan' 				=> $penempatan,
				'region_name' 				=> $region_name,
				'dc_name' 					=> $dc_name,
				'hari_kerja' 				=> $hari_kerja,
				'bank_name' 				=> $bank_id,
				'nomor_rek' 				=> $no_rek,
				'pemilik_rek' 				=> $pemilik_rekening,

				'basic_salary' 				=> $gaji_pokok,
				'allow_jabatan' 			=> $allow_jabatan,
				'allow_area' 				=> $allow_area,
				'allow_masakerja' 			=> $allow_masakerja,
				'allow_trans_meal'			=> $allow_trans_meal,
				'allow_trans_rent'			=> $allow_trans_rent,
				'allow_konsumsi'			=> $allow_konsumsi,
				'allow_transport'			=> $allow_transport,
				'allow_comunication'		=> $allow_comunication,
				'allow_device'				=> $allow_device,
				'allow_residence_cost'		=> $allow_residence_cost,
				'allow_rent'				=> $allow_rent,
				'allow_parking'				=> $allow_parking,
				'allow_medicine'			=> $allow_medicine,
				'allow_akomodsasi'			=> $allow_akomodsasi,
				'allow_kasir'				=> $allow_kasir,
				'allow_operational'			=> $allow_operational,
				'allow_skill'				=> $allow_skill,
				'allow_training'			=> $allow_training,

				'cut_start' 				=> $cut_start,
				'cut_off'					=> $cut_off,
				'date_payment'				=> $date_payment,
				'profile_picture'			=> $foto_profile,
				'filename_ktp'				=> $ktp,
				'filename_kk'				=> $kk,
				'filename_skck'				=> $skck,
				'filename_isd'				=> $ijazah,
				'filename_cv'				=> $civi,
				'filename_paklaring'		=> $paklaring,

				'user_role_id' 				=> '2',
				'is_active' 				=> '1',
				'password' 					=> $password_hash,
				'private_code' 				=> $private_code,
				'created_by' 				=> $createdby
			);

			$iresult = $this->Employees_model->add($data_migrate);

			$data = array(
				'uniqueid' 					=> $unicode,
				'employee_id' 				=> $employee_id,
				'docid'						=> $docid,
				'project' 					=> $project,
				'sub_project'				=> $sub_project,
				'from_date'	 				=> $contract_start,
				'to_date' 					=> $contract_end,
				'no_surat' 					=> $nomor_surat,
				'no_spb' 					=> $nomor_surat_spb,
				'waktu_kontrak' 			=> $contract_periode,
				'company' 					=> $company_id,
				'jabatan' 					=> $posisi,
				'penempatan' 				=> $penempatan,
				'hari_kerja' 				=> $hari_kerja,
				'tgl_payment'				=> $date_payment,
				'start_period_payment'		=> $cut_start,
				'end_period_payment'		=> $cut_off,
				'basic_pay' 				=> $gaji_pokok,
				'dm_allow_grade' 			=> 'Bulan',
				'allowance_grade'			=> $allow_jabatan,
				'dm_allow_area' 			=> 'Bulan',
				'allowance_area'			=> $allow_area,
				'dm_allow_masakerja' 		=> 'Bulan',
				'allowance_masakerja' 		=> $allow_masakerja,
				'dm_allow_transmeal' 		=> 'Bulan',
				'allowance_transmeal' 		=> $allow_trans_meal,
				'dm_allow_transrent' 		=> 'Bulan',
				'allowance_transrent' 		=> $allow_trans_rent,
				'dm_allow_meal' 			=> 'Bulan',
				'allowance_meal' 			=> $allow_konsumsi,
				'dm_allow_transport' 		=> 'Bulan',
				'allowance_transport' 		=> $allow_transport,
				'dm_allow_komunikasi' 		=> 'Bulan',
				'allowance_komunikasi' 		=> $allow_comunication,
				'dm_allow_laptop' 			=> 'Bulan',
				'allowance_laptop' 			=> $allow_device,
				'dm_allow_residance' 		=> 'Bulan',
				'allowance_residance' 		=> $allow_residence_cost,
				'dm_allow_rent' 			=> 'Bulan',
				'allowance_rent' 			=> $allow_rent,
				'dm_allow_park' 			=> 'Bulan',
				'allowance_park' 			=> $allow_parking,
				'dm_allow_medicine' 		=> 'Bulan',
				'allowance_medicine' 		=> $allow_medicine,
				'dm_allow_akomodasi' 		=> 'Bulan',
				'allowance_akomodasi' 		=> $allow_akomodsasi,
				'dm_allow_kasir' 			=> 'Bulan',
				'allowance_kasir' 			=> $allow_kasir,
				'dm_allow_operation' 		=> 'Bulan',
				'allowance_operation' 		=> $allow_operational,
				'dm_allow_skill' 			=> 'Bulan',
				'allowance_skill' 			=> $allow_skill,
				'dm_allow_training' 		=> 'Bulan',
				'allowance_training' 		=> $allow_training,
				'img_esign'					=> $image_name,

				'request_pkwt' 				=> $createdby,
				'request_date'				=> $createdon,
				'approve_nae'				=> $approved_naeby,
				'approve_nae_date'			=> $approved_naeon,
				'approve_nom'				=> $approved_nomby,
				'approve_nom_date'			=> $approved_nomon,
				'approve_hrd'				=> $session['user_id'],
				'approve_hrd_date'			=> date('Y-m-d h:i:s'),


							'sign_nip'						=> '21300033',
							'sign_fullname'					=> 'SISKYLA KHAIRANA PRITIGARINI',
							'sign_jabatan'					=> 'HR MANAGER',

				'status_pkwt' 				=> 1, //0 belum approve, 1 sudah approve
				'contract_type_id'			=> $e_status, //1 pkwt, 2 tkhl
				'createdon' 				=> date('Y-m-d h:i:s'),
				'createdby' 				=> $session['user_id']
			);

			$xresult = $this->Pkwt_model->add_pkwt_record($data);

			$data_up = array(
				'migrasi' => '1',
				'approved_hrdby' =>  $session['user_id'],
				'approved_hrdon' => date("Y-m-d h:i:s")
			);

			$result = $this->Employees_model->update_request_employee($data_up, $id);


			$data_traxes = array(

				'employee_id'			=> $employee_id,
				'fullname'				=> $fullname,
				'pin'					=> md5($private_code),
				'company_id'			=> $company_id,
				'company_name'			=> $this->Employees_model->get_nama_company($company_id),
				'project_id' 			=> $project,
				'project_name' 			=> $this->Employees_model->get_nama_project($project),
				'project_sub' 			=> $this->Employees_model->get_nama_sub_project($sub_project),
				'jabatan' 				=> $this->Employees_model->get_nama_jabatan($posisi),
				'penempatan' 			=> $penempatan,
				'usertype_id' 			=> 1,
				'device_id_one' 		=> 0,
				'server_inv' 			=> 'PROD',
				'is_active' 			=> 1,
				'createdby' 			=> $session['user_id'],
				'createdon'				=> date("Y-m-d h:i:s")

			);

			$txresult = $this->Employees_model->add_traxes($data_traxes);


			//update data emergency contact
			if ((empty($nik_ktp)) || ($nik_ktp == "") || ($nik_ktp == "0") || (empty($employee_id)) || ($employee_id == "") || ($employee_id == "0")) {
				//do nothing
				$result_emergency_contract = false;
			} else {
				$result_emergency_contract = $this->Employees_model->update_kontak_darurat($nik_ktp, $employee_id);
			}
		}

		// 	if ($Return['error'] != '') {
		// 		$this->output($Return);
		// 	}


		// 	if ($result == TRUE) {
		// 		$Return['result'] = $this->lang->line('xin_success_update_company');
		// 	} else {
		// 		$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		// 	}
		// 	$this->output($Return);
		// 	exit;

		//$data['tes'] = "berhasil";
		//$data['tes2'] = "berhasil2";
		$data['count_nip'] = $count_nip;
		$data['employee_request'] = $employee_request;
		$data['fullname'] = $fullname;
		$data['employee_id'] = $employee_id;
		$data['private_code'] = $private_code;
		$data['nomor_surat'] = $nomor_surat;
		$data['nomor_surat_spb'] = $nomor_surat_spb;

		$data['data_migrate'] = $data_migrate;

		$data['iresult'] = $iresult;
		$data['xresult'] = $xresult;
		$data['result'] = $result;
		$data['result_emergency_contract'] = $result_emergency_contract;
		echo json_encode($data);
		//}
	}


	// Validate and update info in database
	public function updateNote()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= './assets/'; //string, the default is application/cache/
		$config['errorlog']		= './assets/'; //string, the default is application/logs/
		$config['imagedir']		= './assets/images/pkwt/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '1024'; //interger, the default is 1024
		$config['black']		= array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']		= array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		// $id = '31';
		$id = $this->uri->segment(4);
		$cancel = $this->uri->segment(5);

		if ($this->input->post('edit_type') == 'company') {

			$idtransaksi 	= $this->input->post('idtransaksi');
			// $id = $this->uri->segment(4);

			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
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
			$result = $this->Employees_model->update_request_employee($data_up, $id);




			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_update_company');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}

			if ($Return['error'] != '') {
				$this->output($Return);
			}
			$this->output($Return);
			//exit;

			redirect(base_url() . 'admin/employee_request_hrd/');
		}
	}

	//update data outlet
	public function update_data_profile()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'nama_ibu'   		=> strtoupper($postData['nama_ibu']),
			'tempat_lahir'    	=> strtoupper($postData['tempat_lahir']),
			'tanggal_lahir'   	=> $postData['tanggal_lahir'],
			'gender'    		=> $postData['gender'],
			'agama'    			=> $postData['agama'],
			'status_kawin'    	=> $postData['status_kawin'],
			'npwp'    			=> $postData['no_npwp'],
			'contact_no'    	=> $postData['contact_no'],
			'email'    			=> strtoupper($postData['email']),

		];

		// update data profile
		$data = $this->Employees_model->update_profile_employee_request($datarequest, $postData['secid']);

		//Cek variabel post
		$datarequestemergency = [
			'hubungan'   		=> $postData['emergency_hubungan_modal'],
			'nama'    			=> strtoupper($postData['emergency_name_modal']),
			'no_kontak'   		=> $postData['emergency_kontak_modal'],

		];

		$data2 = $this->Employees_model->update_emergency_employee_request($datarequestemergency, $postData['secid']);

		if ($data == false) {
			if ($data2 == false) {
				$response = array(
					'status'	=> "201",
					'pesan' 	=> "Tidak ada perubahan data",
				);
			} else {
				$response = array(
					'status'	=> "200",
					'pesan' 	=> "Berhasil Update Data",
				);
			}
		} else {
			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Update Data",
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	//update data outlet
	public function update_data_project()
	{
		$postData = $this->input->post();

		$result_cutoff = explode("/", $postData['cut_off']);
		//Cek variabel post
		$datarequest = [
			'project'   		=> $postData['project'],
			'sub_project'    	=> $postData['sub_project'],
			'company_id'   		=> $postData['company_id'],
			'e_status'    		=> $postData['e_status'],
			'posisi'    		=> $postData['posisi'],
			'location_id'		=> $postData['location_id'],
			'penempatan'    	=> strtoupper($postData['penempatan']),
			'region_name'    	=> strtoupper($postData['region_name']),
			'region'    		=> strtoupper($postData['region']),
			'dc_name'    		=> strtoupper($postData['dc_name']),
			'doj'    			=> $postData['doj'],
			'contract_start'    => $postData['contract_start'],
			'contract_end'    	=> $postData['contract_end'],
			'contract_periode'  => $postData['contract_periode'],
			'cut_start'    		=> $result_cutoff[0],
			'cut_off'    		=> $result_cutoff[1],
			'hari_kerja'    	=> $postData['hari_kerja'],
			'date_payment'    	=> $postData['date_payment'],

		];


		// update data profile
		$data = $this->Employees_model->update_project_employee_request($datarequest, $postData['secid']);

		if ($data == false) {
			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Update Data",
			);
		} else {
			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Update Data",
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	//update data outlet
	public function update_data_upah()
	{
		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [

          	'secid' 				=> $postData['secid'],
            'gaji_pokok'			=> $postData['gaji_pokok'],
            'allow_jabatan'			=> $postData['allow_jabatan'],
            'dm_allow_jabatan'		=> $postData['dm_allow_jabatan'],
            'allow_skill'			=> $postData['allow_skill'],
            'dm_allow_skill'		=> $postData['dm_allow_skill'],
            'allow_area'			=> $postData['allow_area'],
            'dm_allow_area'			=> $postData['dm_allow_area'],
            'allow_masakerja'		=> $postData['allow_masakerja'],
            'dm_allow_masakerja'	=> $postData['dm_allow_masakerja'],
            'allow_konsumsi'		=> $postData['allow_konsumsi'],
            'dm_allow_konsumsi'		=> $postData['dm_allow_konsumsi'],
            'allow_transport'		=> $postData['allow_transport'],
            'dm_allow_transport'	=> $postData['dm_allow_transport'],
            'allow_rent'			=> $postData['allow_rent'],
            'dm_allow_rent'			=> $postData['dm_allow_rent'],
            'allow_comunication'	=> $postData['allow_comunication'],
            'dm_allow_comunication'	=> $postData['dm_allow_comunication'],
            'allow_parking'			=> $postData['allow_parking'],
            'dm_allow_park'			=> $postData['dm_allow_park'],
            'allow_residence_cost'	=> $postData['allow_residence_cost'],
            'dm_allow_residance'	=> $postData['dm_allow_residance'],
            'allow_akomodsasi'		=> $postData['allow_akomodsasi'],
            'dm_allow_akomodasi'	=> $postData['dm_allow_akomodasi'],
            'allow_device'			=> $postData['allow_device'],
            'dm_allow_device'		=> $postData['dm_allow_device'],
            'allow_kasir'			=> $postData['allow_kasir'],
            'dm_allow_kasir'		=> $postData['dm_allow_kasir'],
            'allow_trans_meal'		=> $postData['allow_trans_meal'],
            'dm_allow_transmeal'	=> $postData['dm_allow_transmeal'],
            'allow_trans_rent'		=> $postData['allow_trans_rent'],
            'dm_allow_transrent'	=> $postData['dm_allow_transrent'],
            'allow_medicine'		=> $postData['allow_medicine'],
            'dm_allow_medicine'		=> $postData['dm_allow_medicine'],
            'allow_grooming'		=> $postData['allow_grooming'],
            'dm_allow_grooming'		=> $postData['dm_allow_grooming'],
            'allow_kehadiran'		=> $postData['allow_kehadiran'],
            'dm_allow_kehadiran'	=> $postData['dm_allow_kehadiran'],
            'allow_operational'		=> $postData['allow_operational'],
            'dm_allow_operational'	=> $postData['dm_allow_operational'],
            'allow_training'		=> $postData['allow_training'],
            'dm_allow_training'		=> $postData['dm_allow_training'],
            'allow_kinerja'			=> $postData['allow_kinerja'],
            'dm_allow_kinerja'		=> $postData['dm_allow_kinerja'],
            'allow_disiplin'		=> $postData['allow_disiplin'],
            'dm_allow_disiplin'		=> $postData['dm_allow_disiplin'],
            'allow_pph'				=> $postData['allow_pph'],
            'dm_allow_pph'			=> $postData['dm_allow_pph'],
            'allow_others'			=> $postData['allow_others'],
            'dm_allow_others'		=> $postData['dm_allow_others'],

		];


		// update data profile
		$data = $this->Employees_model->update_upah_employee_request($datarequest, $postData['secid']);

		if ($data == false) {
			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Update Data",
			);
		} else {
			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Update Data",
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	public function delete()
	{

		if ($this->input->post('is_ajax') == 2) {
			$session = $this->session->userdata('username');
			if (empty($session)) {
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Company_model->delete_record($id);
			if (isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_company');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

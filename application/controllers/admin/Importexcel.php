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
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcel extends MY_Controller
{

	/*Function to set JSON output*/
	public function output($Return = array())
	{
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function __construct()
	{
		parent::__construct();
		//load the models
    	$this->load->library('session');
		$this->load->model("Employees_model");
		$this->load->model("Register_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Company_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Project_model");
		$this->load->model("Assets_model");
		// $this->load->model("Training_model");
		// $this->load->model("Trainers_model");
		// $this->load->model("Awards_model");
		$this->load->model("Travel_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Subproject_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Exin_model');
		$this->load->model('Import_model');
		$this->load->model('Pkwt_model');
		$this->load->model('Xin_model');
		$this->load->library("pagination");
		$this->load->library('Pdf');
		//$this->load->library("phpspreadsheet");
		$this->load->helper('string');
	}

	// import
	public function index()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_imports') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_imports');
		$data['path_url'] = 'hrpremium_import';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if (in_array('127', $role_resources_ids) || in_array('127', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/hr_import_excel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// Validate and add info in database
	public function import_employees()
	{

		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file
		// $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// $csvMimes =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel');

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;

						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);
							$data = array(
								'uploadid' => $uploadid,
								'employee_id' 		=> str_replace(' ', '', $line[0]), // auto
								'fullname' 				=> $line[1],
								'company_id' 			=> $line[2],
								'location_id' 		=> $line[3], //ho-area
								'department_id' 	=> $line[4], //divisi
								'designation_id' 	=> $line[5], //jabatan
								'project_id' 			=> $line[6], //jabatan
								'sub_project_id' 	=> $line[7], //jabatan
								'penempatan' 			=> $line[8],
								'marital_status' 	=> $line[9], //status perkawinan
								'gender' 					=> $line[10], //jenis kelamin
								'tempat_lahir'		=> $line[11],
								'date_of_birth' 	=> $line[12],
								'date_of_joining' => $line[13],
								'contact_no' 			=> $line[14],
								'email' 					=> $line[15],
								'alamat_ktp' 			=> $line[16],
								'alamat_domisili' => $line[17],
								'kk_no' 					=> $line[18],
								'ktp_no' 					=> $line[19],
								'npwp_no' 				=> $line[20],
								'bpjs_tk_no' 			=> $line[21],
								'bpjs_ks_no' 			=> $line[22],
								'ibu_kandung' 		=> $line[23],
								'bank_name' 			=> $line[24],
								'nomor_rek' 			=> $line[25],
								'pemilik_rek' 		=> $line[26],
								'basic_salary' 		=> $line[27]
							);
							$result = $this->Employees_model->addtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Employees_model->delete_temp_by_employeeid();
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}


		redirect('admin/ImportExcelEmployees?upid=' . $uploadid);
	}


	// Validate and add info in database
	public function import_employees_active()
	{

		if ($this->input->post('is_ajax') == '3') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			//validate whether uploaded file is a csv file
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if ($_FILES['file']['name'] === '') {
				$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
			} else {
				if (in_array($_FILES['file']['type'], $csvMimes)) {
					if (is_uploaded_file($_FILES['file']['tmp_name'])) {

						// check file size
						if (filesize($_FILES['file']['tmp_name']) > 2000000) {
							$Return['error'] = $this->lang->line('xin_error_employees_import_size');
						} else {

							//open uploaded csv file with read only mode
							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

							//skip first line
							fgetcsv($csvFile);

							//parse data from csv file line by line
							while (($line = fgetcsv($csvFile)) !== FALSE) {

								$data = array(
									'employee_id' => $line[0], // auto
									'username' => $line[0], // nik
									'first_name' => $line[1],
									'designation_id' => $line[2], //jabatan
									'department_id' => $line[3], //divisi
									'location_id' => $line[4], //ho-area
									'marital_status' => $line[5], //status perkawinan
									'gender' => $line[6], //jenis kelamin
									'date_of_birth' => $line[7],
									'contact_no' => $line[8],
									'address' => $line[9],
									'company_id' => 2, //auto cakrawala => 2
									'user_role_id' => 2, // auto 2 => emplyee
									'is_active' => 0, // auto 0 disactive
									'ktp_no' => $line[10],
									'kk_no' => $line[11],
									'npwp_no' => $line[12],
									'bpjs_tk_no' => $line[13],
									'bpjs_ks_no' => $line[14],
									'created_at' => date('Y-m-d h:i:s')

								);
								$last_insert_id = $this->Employees_model->add($data);

								$bank_account_data = array(
									'account_title' => 'Rekening',
									'account_number' => $line[15], //NO. REK
									'bank_name' => $line[16],
									'employee_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);
							}
							//close opened csv file
							fclose($csvFile);

							$Return['result'] = $this->lang->line('xin_success_empactive_import');
						}
					} else {
						$Return['error'] = $this->lang->line('xin_error_not_employee_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_invalid_file');
				}
			} // file empty

			if ($Return['error'] != '') {
				$this->output($Return);
			}

			$this->output($Return);
			exit;
		}
	}

	// expired page
	public function importpkwt()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_pkwt_import') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_import');
		$data['all_projects'] = $this->Project_model->get_projects();
		// $data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrpremium_import_pkwt';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('129', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// Validate and add info in database
	public function import_pkwt()
	{

		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file
		// $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// $csvMimes =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel');

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;

						$count_pkwt = $this->Xin_model->count_pkwt();
						$i = 0;
						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							$romawi = $this->Xin_model->tgl_pkwt();
							$nomor_surat = sprintf("%05d", $count_pkwt) . '/' . 'PKWT-JKTSC-HR/' . $romawi;
							$nomor_surat_spb = sprintf("%05d", $count_pkwt) . '/' . 'SPB-JKTSC-HR/' . $romawi;

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);
							$data = array(
								'uploadid' => $uploadid,
								'no_surat' => $nomor_surat, // auto
								'no_spb' => $nomor_surat_spb,
								'employee_id' => str_replace(' ', '', $line[2]),
								'contract_type_id' => $line[6], //1 tetap, 2 kontrak
								'posisi' => $line[4], //posisi id
								'project' => $line[5], //project id
								'penempatan' => $line[7],
								'waktu_kontrak' => $line[8], //satuan bulan, 1 tahun = 12 bulan
								'hari_kerja' => $line[9], //hari kerja dari 1 minggu
								'basic_pay' => $line[10],
								'allowance_meal' => $line[11],
								'allowance_transport' => $line[12],
								'allowance_bbm' => $line[13],
								'allowance_pulsa' => $line[14],
								'allowance_rent' => $line[15],
								'allowance_grade' => $line[16],
								'allowance_laptop' => $line[17],
								'from_date' => $line[18],
								'to_date' => $line[19],
								'start_period_payment' => $line[20],
								'end_period_payment' => $line[21],
								'tgl_payment' => $line[22]

							);
							$result = $this->Pkwt_model->addtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Pkwt_model->delete_temp_by_employeeid();
							$count_pkwt++;
						}
						//close opened csv file
						fclose($csvFile);

						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}

		redirect('admin/ImportExcelPKWT?upid=' . $uploadid);
	}

	// expired page
	public function importnewemployees()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_new_employee') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_new_employee');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_new_employees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('109', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/new_employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// expired page
	public function importratecard()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_excl_ratecard') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_ratecard');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_ratecard';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('232', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/import_ratecard", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// expired page
	public function importeslip()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_excl_eslip') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_eslip');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_eslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('469', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/import_eslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//delete batch saltab
	public function delete_batch_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->delete_batch_saltab($postData['id']);

		echo json_encode($data);
	}

	//delete batch saltab release
	public function delete_batch_saltab_release()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->delete_batch_saltab_release($postData['id']);

		echo json_encode($data);
	}

	//release eslip batch saltab release
	public function release_eslip_batch_saltab_release()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->release_eslip_batch_saltab_release($postData);

		echo json_encode($data);
	}

	//accept request open lock saltab
	public function accept_request()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->accept_request($postData);

		echo json_encode($data);
	}

	//reject request open lock saltab
	public function reject_request()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->reject_request($postData);

		echo json_encode($data);
	}

	//release batch saltab
	public function release_batch_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->release_batch_saltab($postData['id']);

		echo json_encode($data);
	}

	//delete detail saltab
	public function delete_detail_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->delete_detail_saltab($postData['id']);

		echo json_encode($data);
	}

	//delete detail saltab release
	public function delete_detail_saltab_release()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->delete_detail_saltab_release($postData['id']);

		echo json_encode($data);
	}

	//load datatables list batch saltab
	public function list_batch_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_batch_saltab($postData);

		echo json_encode($data);
	}

	//load datatables list batch saltab release
	public function list_batch_saltab_release()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_batch_saltab_release($postData);

		echo json_encode($data);
	}

	//load datatables list open import batch saltab
	public function list_open_import_batch_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_request_open_import_saltab($postData);

		echo json_encode($data);
	}

	//load datatables list batch saltab release untuk download
	public function list_batch_saltab_release_download()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_batch_saltab_release_download($postData);

		echo json_encode($data);
	}

	//load datatables list detail saltab
	public function list_detail_saltab()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_detail_saltab($postData);

		echo json_encode($data);
	}

	//load datatables list detail saltab release
	public function list_detail_saltab_release()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_detail_saltab_release($postData);

		echo json_encode($data);
	}

	//load datatables list detail saltab release untuk download
	public function list_detail_saltab_release_download()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Import_model->get_list_detail_saltab_release_download($postData);

		echo json_encode($data);
	}

	public function downloadTemplateSaltab()
	{
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab'); //nama Spreadsheet yg baru dibuat

		$tabel_saltab = $this->Import_model->get_saltab_table();

		$header_tabel_saltab = array_column($tabel_saltab, 'nama_tabel');
		$header2_tabel_saltab = array_column($tabel_saltab, 'alias');
		$jumlah_data = count($header_tabel_saltab);
		//$tes = print_r($tabel_saltab);

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$header_tabel_saltab,   // The data to set
				NULL,
				'A1'
			);

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A2'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= $jumlah_data; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		$spreadsheet
			->getActiveSheet()
			->getStyle("A2:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'Template E-Saltab'; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function format_array_print_excel($tabel_hasil)
	{
		// $tabel_saltab = $this->Import_model->get_saltab_table();

		// $jumlah_data = count($tabel_saltab);

		// $new_tabel_saltab = array_values($tabel_saltab);

		// if($tabel_hasil['sub_project']){
		// }

		$data = array();

		foreach ($tabel_hasil as $row) {
			$new_row = array_values($row);
			array_push($data, $new_row);
		}

		$jumlah_data = count($data);

		for ($i = 0; $i < $jumlah_data; $i++) {
			$jumlah_kolom = count($data[$i]);
			for ($j = 0; $j < $jumlah_kolom; $j++) {
				if (is_numeric($data[$i][$j])) {
					// $data[$i][$j] = "NUMERIC";
					if ($data[$i][$j] <= 100000000) {
						// $data[$i][$j] = "NUMERIC kecil";
						$data[$i][$j] = round($data[$i][$j]) . " ";
					} else {
						// $data[$i][$j] = "NUMERIC besar";
						$data[$i][$j] = $data[$i][$j] . " ";
					}
				} else {
					// $data[$i][$j] = "NOT NUMERIC";
					$data[$i][$j] = $data[$i][$j] . " ";
				}
			}
		}

		return $data;

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
	}

	//mengambil Json data Detail Saltab
	public function get_detail_saltab()
	{
		$postData = $this->input->post();

		// get data 
		$data = $this->Import_model->get_detail_saltab($postData['id']);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
	}

	//mengambil Json data Detail Saltab
	public function get_detail_saltab_release()
	{
		$postData = $this->input->post();

		// get data 
		$data = $this->Import_model->get_detail_saltab_release($postData['id']);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
	}

	//ganti data nip employee
	public function ganti_nip()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//update NIP
		$this->Import_model->update_NIP($postData);

		//data response NIP
		$data2 = $this->Import_model->get_single_nip_saltab_release($postData);
		$response = array(
			'status'	=> "200",
			'pesan' 	=> "Berhasil Ubah NIP",
			'data'		=> $data2,
		);

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	public function downloadDetailSaltab($id = null)
	{
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab'); //nama Spreadsheet yg baru dibuat

		$tabel_saltab = $this->Import_model->get_saltab_table();
		$data_batch_saltab = $this->Import_model->get_saltab_batch($id);

		$header_tabel_saltab = array_column($tabel_saltab, 'nama_tabel');
		$header2_tabel_saltab = array_column($tabel_saltab, 'alias');
		$length_array = count($header_tabel_saltab);
		$gabung = implode(",", $header_tabel_saltab);

		$detail_saltab = $this->Import_model->get_saltab_temp_detail_excel($id, $gabung);
		$detail_saltab_fix = $this->format_array_print_excel($detail_saltab);

		$project = $data_batch_saltab['project_name'];
		$sub_project = $data_batch_saltab['sub_project_name'];
		$peride_salary = $this->Xin_model->tgl_indo($data_batch_saltab['periode_salary']);
		$peride_cutoff = $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_to']);

		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Project');
		$spreadsheet->getActiveSheet()->setCellValue('B1', ': ' . $project);
		$spreadsheet->getActiveSheet()->mergeCells("B1:J1");

		$spreadsheet->getActiveSheet()->setCellValue('A2', 'Sub Project');
		$spreadsheet->getActiveSheet()->setCellValue('B2', ': ' . $sub_project);
		$spreadsheet->getActiveSheet()->mergeCells("B2:J2");

		$spreadsheet->getActiveSheet()->setCellValue('A3', 'Periode Cutoff');
		$spreadsheet->getActiveSheet()->setCellValue('B3', ': ' . $peride_cutoff);
		$spreadsheet->getActiveSheet()->mergeCells("B3:J3");

		$spreadsheet->getActiveSheet()->setCellValue('A4', 'Periode Salary');
		$spreadsheet->getActiveSheet()->setCellValue('B4', ': ' . $peride_salary);
		$spreadsheet->getActiveSheet()->mergeCells("B4:J4");

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A6'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		$spreadsheet
			->getActiveSheet()
			->getStyle("A6:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$length_data = count($detail_saltab);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 7])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab_fix,   // The data to set
		// 		NULL,
		// 		'A7'
		// 	);

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('6:6')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('6:6')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('6:6')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'E-Saltab - ' . $data_batch_saltab['project_name']; // set filename for excel file to be exported
		// $filename = $gabung;

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function downloadDetailSaltabRelease($id = null)
	{
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab'); //nama Spreadsheet yg baru dibuat

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		$tabel_saltab = $this->Import_model->get_saltab_table();
		$data_batch_saltab = $this->Import_model->get_saltab_batch_release($id);

		$header_tabel_saltab = array_column($tabel_saltab, 'nama_tabel');
		$header2_tabel_saltab = array_column($tabel_saltab, 'alias');
		$length_array = count($header_tabel_saltab);
		$gabung = implode(",", $header_tabel_saltab);

		$detail_saltab = $this->Import_model->get_saltab_temp_detail_excel_release($id, $gabung);
		// $detail_saltab_fix = $this->format_array_print_excel($detail_saltab);

		$project = $data_batch_saltab['project_name'];
		$sub_project = $data_batch_saltab['sub_project_name'];
		$peride_salary = $this->Xin_model->tgl_indo($data_batch_saltab['periode_salary']);
		$peride_cutoff = $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_to']);

		$waktu_stamp = date("Y-m-d H:i:s");

		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Project');
		$spreadsheet->getActiveSheet()->setCellValue('B1', ': ' . $project);
		$spreadsheet->getActiveSheet()->mergeCells("B1:J1");

		$spreadsheet->getActiveSheet()->setCellValue('A2', 'Sub Project');
		$spreadsheet->getActiveSheet()->setCellValue('B2', ': ' . $sub_project);
		$spreadsheet->getActiveSheet()->mergeCells("B2:J2");

		$spreadsheet->getActiveSheet()->setCellValue('A3', 'Periode Cutoff');
		$spreadsheet->getActiveSheet()->setCellValue('B3', ': ' . $peride_cutoff);
		$spreadsheet->getActiveSheet()->mergeCells("B3:J3");

		$spreadsheet->getActiveSheet()->setCellValue('A4', 'Periode Salary');
		$spreadsheet->getActiveSheet()->setCellValue('B4', ': ' . $peride_salary);
		$spreadsheet->getActiveSheet()->mergeCells("B4:J4");

		$spreadsheet->getActiveSheet()->setCellValue('A5', 'Upload Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B5', ': ' . $data_batch_saltab['upload_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B5:J5");

		$spreadsheet->getActiveSheet()->setCellValue('A6', 'Finalization Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B6', ': ' . $data_batch_saltab['release_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B6:J6");

		$spreadsheet->getActiveSheet()->setCellValue('A7', 'Download Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B7', ': ' . $waktu_stamp);
		$spreadsheet->getActiveSheet()->mergeCells("B7:J7");

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A9'
			);

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		$spreadsheet
			->getActiveSheet()
			->getStyle("A9:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$length_data = count($detail_saltab);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 10])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab_fix,   // The data to set
		// 		NULL,
		// 		'A10'
		// 	);

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'E-Saltab - ' . $data_batch_saltab['project_name'] . ' - ' . $data_batch_saltab['sub_project_name']; // set filename for excel file to be exported
		// $filename = $gabung;

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function downloadDetailSaltabReleaseBPJS($id = null)
	{


		if($this->Import_model->CheckDownloadBPJS($id) < 1) {
			$this->update_downloader($id);
		}

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab BPJS'); //nama Spreadsheet yg baru dibuat

		$tabel_saltab = $this->Import_model->get_saltab_table();
		$data_batch_saltab = $this->Import_model->get_saltab_batch_release($id);

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		$header2_tabel_saltab = array(
			'STATUS',
			'NIP',
			'NIK',
			'NAMA LENGKAP',
			'PROJECT',
			'SUB PROJECT',
			'JABATAN',
			'AREA',
			'TEMPAT LAHIR',
			'TANGGAL LAHIR (Y-m-d)',
			'NAMA IBU KANDUNG',
			'JENIS KELAMIN',
			'STATUS PERNIKAHAN',
			'ALAMAT',
			'TANGGAL MULAI KONTRAK',
			'TANGGAL AKHIR KONTRAK',
			'GAPOK UMK',
			'GAPOK DIERIMA (THP)',
			'BPJS KETENAGAKERJAAN',
			'BPJS KESEHATAN',
		);

		$length_array = count($header2_tabel_saltab);

		$detail_saltab = $this->Import_model->get_saltab_temp_detail_excel_release_bpjs($id, $data_batch_saltab);
		// $detail_saltab_fix = $this->format_array_print_excel($detail_saltab);

		$project = $data_batch_saltab['project_name'];
		$sub_project = $data_batch_saltab['sub_project_name'];
		$peride_salary = $this->Xin_model->tgl_indo($data_batch_saltab['periode_salary']);
		$peride_cutoff = $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_to']);

		$waktu_stamp = date("Y-m-d H:i:s");

		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Project');
		$spreadsheet->getActiveSheet()->setCellValue('B1', ': ' . $project);
		$spreadsheet->getActiveSheet()->mergeCells("B1:J1");

		$spreadsheet->getActiveSheet()->setCellValue('A2', 'Sub Project');
		$spreadsheet->getActiveSheet()->setCellValue('B2', ': ' . $sub_project);
		$spreadsheet->getActiveSheet()->mergeCells("B2:J2");

		$spreadsheet->getActiveSheet()->setCellValue('A3', 'Periode Cutoff');
		$spreadsheet->getActiveSheet()->setCellValue('B3', ': ' . $peride_cutoff);
		$spreadsheet->getActiveSheet()->mergeCells("B3:J3");

		$spreadsheet->getActiveSheet()->setCellValue('A4', 'Periode Salary');
		$spreadsheet->getActiveSheet()->setCellValue('B4', ': ' . $peride_salary);
		$spreadsheet->getActiveSheet()->mergeCells("B4:J4");

		$spreadsheet->getActiveSheet()->setCellValue('A5', 'Upload Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B5', ': ' . $data_batch_saltab['upload_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B5:J5");

		$spreadsheet->getActiveSheet()->setCellValue('A6', 'Finalization Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B6', ': ' . $data_batch_saltab['release_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B6:J6");

		$spreadsheet->getActiveSheet()->setCellValue('A7', 'Download Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B7', ': ' . $waktu_stamp);
		$spreadsheet->getActiveSheet()->mergeCells("B7:J7");

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A9'
			);

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();



		$spreadsheet
			->getActiveSheet()
			->getStyle("A9:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$length_data = count($detail_saltab);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 10])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab_fix,   // The data to set
		// 		NULL,
		// 		'A9'
		// 	);

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('8:8')
			->getAlignment()->setWrapText(true);

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('8:8')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('8:8')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'E-Saltab BPJS - ' . $data_batch_saltab['project_name'] . ' - ' . $data_batch_saltab['sub_project_name']; // set filename for excel file to be exported
		// $filename = $gabung;

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function downloadDetailSaltabReleasePayroll($id = null)
	{
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab Payroll'); //nama Spreadsheet yg baru dibuat

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		$tabel_saltab = $this->Import_model->get_saltab_table();
		$data_batch_saltab = $this->Import_model->get_saltab_batch_release($id);

		$header2_tabel_saltab = array(
			'STATUS',
			'NIP',
			'NIK',
			'NAMA LENGKAP',
			'PROJECT',
			'SUB PROJECT',
			'AREA',
			'THP',
			'NOMOR REKENING',
			'NAMA BANK',
			'PEMILIK REKENING',
			'STATUS HOLD',
			'STATUS VERIFIKASI',
		);

		$length_array = count($header2_tabel_saltab);

		$detail_saltab = $this->Import_model->get_saltab_temp_detail_excel_release_payroll($id, $data_batch_saltab);
		// $detail_saltab_fix = $this->format_array_print_excel($detail_saltab);

		$project = $data_batch_saltab['project_name'];
		$sub_project = $data_batch_saltab['sub_project_name'];
		$peride_salary = $this->Xin_model->tgl_indo($data_batch_saltab['periode_salary']);
		$peride_cutoff = $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_to']);

		$waktu_stamp = date("Y-m-d H:i:s");

		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Project');
		$spreadsheet->getActiveSheet()->setCellValue('B1', ': ' . $project);
		$spreadsheet->getActiveSheet()->mergeCells("B1:J1");

		$spreadsheet->getActiveSheet()->setCellValue('A2', 'Sub Project');
		$spreadsheet->getActiveSheet()->setCellValue('B2', ': ' . $sub_project);
		$spreadsheet->getActiveSheet()->mergeCells("B2:J2");

		$spreadsheet->getActiveSheet()->setCellValue('A3', 'Periode Cutoff');
		$spreadsheet->getActiveSheet()->setCellValue('B3', ': ' . $peride_cutoff);
		$spreadsheet->getActiveSheet()->mergeCells("B3:J3");

		$spreadsheet->getActiveSheet()->setCellValue('A4', 'Periode Salary');
		$spreadsheet->getActiveSheet()->setCellValue('B4', ': ' . $peride_salary);
		$spreadsheet->getActiveSheet()->mergeCells("B4:J4");

		$spreadsheet->getActiveSheet()->setCellValue('A5', 'Upload Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B5', ': ' . $data_batch_saltab['upload_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B5:J5");

		$spreadsheet->getActiveSheet()->setCellValue('A6', 'Finalization Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B6', ': ' . $data_batch_saltab['release_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B6:J6");

		$spreadsheet->getActiveSheet()->setCellValue('A7', 'Download Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B7', ': ' . $waktu_stamp);
		$spreadsheet->getActiveSheet()->mergeCells("B7:J7");

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A9'
			);

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		$spreadsheet
			->getActiveSheet()
			->getStyle("A9:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$length_data = count($detail_saltab);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 10])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab_fix,   // The data to set
		// 		NULL,
		// 		'A10'
		// 	);

		// echo "<pre>";
		// print_r($detail_saltab);
		// echo "</pre>";

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'E-Saltab Payroll - ' . $data_batch_saltab['project_name'] . ' - ' . $data_batch_saltab['sub_project_name']; // set filename for excel file to be exported
		// $filename = $gabung;

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		// $writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function downloadBatchSaltabReleaseNIPKosong($id = null)
	{
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('E-Saltab'); //nama Spreadsheet yg baru dibuat

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		$tabel_saltab = $this->Import_model->get_saltab_table();
		$data_batch_saltab = $this->Import_model->get_saltab_batch_release($id);

		$header_tabel_saltab = array_column($tabel_saltab, 'nama_tabel');
		$header2_tabel_saltab = array_column($tabel_saltab, 'alias');
		$length_array = count($header_tabel_saltab);
		$gabung = implode(",", $header_tabel_saltab);

		$detail_saltab = $this->Import_model->get_saltab_temp_detail_excel_release_nip_kosong($id, $gabung);
		// $detail_saltab_fix = $this->format_array_print_excel($detail_saltab);

		$project = $data_batch_saltab['project_name'];
		$sub_project = $data_batch_saltab['sub_project_name'];
		$peride_salary = $this->Xin_model->tgl_indo($data_batch_saltab['periode_salary']);
		$peride_cutoff = $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data_batch_saltab['periode_cutoff_to']);

		$waktu_stamp = date("Y-m-d H:i:s");

		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Project');
		$spreadsheet->getActiveSheet()->setCellValue('B1', ': ' . $project);
		$spreadsheet->getActiveSheet()->mergeCells("B1:J1");

		$spreadsheet->getActiveSheet()->setCellValue('A2', 'Sub Project');
		$spreadsheet->getActiveSheet()->setCellValue('B2', ': ' . $sub_project);
		$spreadsheet->getActiveSheet()->mergeCells("B2:J2");

		$spreadsheet->getActiveSheet()->setCellValue('A3', 'Periode Cutoff');
		$spreadsheet->getActiveSheet()->setCellValue('B3', ': ' . $peride_cutoff);
		$spreadsheet->getActiveSheet()->mergeCells("B3:J3");

		$spreadsheet->getActiveSheet()->setCellValue('A4', 'Periode Salary');
		$spreadsheet->getActiveSheet()->setCellValue('B4', ': ' . $peride_salary);
		$spreadsheet->getActiveSheet()->mergeCells("B4:J4");

		$spreadsheet->getActiveSheet()->setCellValue('A5', 'Upload Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B5', ': ' . $data_batch_saltab['upload_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B5:J5");

		$spreadsheet->getActiveSheet()->setCellValue('A6', 'Finalization Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B6', ': ' . $data_batch_saltab['release_on']);
		$spreadsheet->getActiveSheet()->mergeCells("B6:J6");

		$spreadsheet->getActiveSheet()->setCellValue('A7', 'Download Time (Y-m-d)');
		$spreadsheet->getActiveSheet()->setCellValue('B7', ': ' . $waktu_stamp);
		$spreadsheet->getActiveSheet()->mergeCells("B7:J7");

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A9'
			);

		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		$spreadsheet
			->getActiveSheet()
			->getStyle("A9:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$length_data = count($detail_saltab);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 10])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab_fix,   // The data to set
		// 		NULL,
		// 		'A10'
		// 	);

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('9:9')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'E-Saltab - ' . $data_batch_saltab['project_name'] . ' - ' . $data_batch_saltab['sub_project_name']; // set filename for excel file to be exported
		// $filename = $gabung;

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	public function update_downloader($id) {
		/* Define return | here result is used to return user data and error for error message */
		// $status_id = $this->uri->segment(4);
		// $session = $this->session->userdata('username');
		// if(empty($session)){ 
		// 	redirect('admin/');
		// }



		$session = $this->session->userdata('username');
		if(empty($session)) { 
			redirect('admin/');
		}

				$datas = array(
					'down_bpjs_by' => $session['employee_id'],
					'down_bpjs_on' =>  date("Y-m-d h:i:s"),
				);

				$this->Import_model->update_download_bpjs($datas, $id);


		// $resultdel = $this->Import_model->delete_all_eslip_preview($upload_id);
		// $tempEmployees = $this->Import_model->get_temp_eslip($upload_id);


	}

	/*
    |-------------------------------------------------------------------
    | Import Excel saltab
    |-------------------------------------------------------------------
    |
    */
	function import_saltab2()
	{
		//ambil parameter yg di post sebagai acuan
		$nik = $this->input->post('nik');
		$project = $this->input->post('project');
		$sub_project = $this->input->post('sub_project');
		$saltab_from = $this->input->post('saltab_from');
		$saltab_to = $this->input->post('saltab_to');
		$periode_salary = $this->input->post('periode_salary');

		//load data Project
		$nama_project = "";
		$projects = $this->Project_model->read_single_project($project);
		if (!is_null($projects)) {
			$nama_project = $projects[0]->title;
		} else {
			$nama_project = '--';
		}

		//load data Sub Project
		$nama_sub_project = "";
		if ($sub_project == 0) {
			$nama_sub_project = '-ALL-';
		} else {
			$subprojects = $this->Subproject_model->read_single_subproject($sub_project);
			if (!is_null($subprojects)) {
				$nama_sub_project = $subprojects[0]->sub_project_name;
			} else {
				$nama_sub_project = '--';
			}
		}

		$this->load->helper('file');

		/* Allowed MIME(s) File */
		$file_mimes = array(
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

			$array_file = explode('.', $_FILES['file_excel']['name']);
			$extension  = end($array_file);

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
			$array_data  = [];
			$array_data_final  = [];
			$data        = [];
			$header_tabel_saltab = $sheet_data[0];
			$length_header = count($header_tabel_saltab);
			$jumlah_data = count($sheet_data) - 2;
			// $highestColumnInRow5 = $spreadsheet->getActiveSheet(0)->getHighestColumn(1);

			//susun array batch saltab
			$data_batch = array(
				'periode_cutoff_from'    => $saltab_from,
				'periode_cutoff_to'      => $saltab_to,
				'periode_salary'      	 => $periode_salary,
				'project_id'        	 => $project,
				'project_name'        	 => $nama_project,
				'sub_project_id'         => $sub_project,
				'sub_project_name'       => $nama_sub_project,
				'total_mpp'        	 	 => $jumlah_data,
				'upload_by'        	 	 => $this->Import_model->get_nama_karyawan($nik),
				'upload_by_id'        	 => $nik,
				'upload_ip'        	 	 => $this->get_client_ip(),
			);

			//susun array untuk cek apakah sudah ada data batch yg sama
			$data_batch_cek = array(
				'periode_cutoff_from'    => $saltab_from,
				'periode_cutoff_to'      => $saltab_to,
				'periode_salary'      	 => $periode_salary,
				'project_id'        	 => $project,
				'project_name'        	 => $nama_project,
				'sub_project_id'         => $sub_project,
				'sub_project_name'       => $nama_sub_project,
			);

			$id_batch_awal = $this->Import_model->get_id_saltab_batch($data_batch_cek);

			//susun array untuk cek apakah sudah ada data batch yg sama
			$data_batch_cek_request_open = array(
				'periode_saltab_from'    => $saltab_from,
				'periode_saltab_to'      => $saltab_to,
				'tanggal_gajian'      	 => $periode_salary,
				'project_id'        	 => $project,
				'project_name'        	 => $nama_project,
				'sub_project_id'         => $sub_project,
				'sub_project_name'       => $nama_sub_project,
			);

			$this->Import_model->update_request_open_import($data_batch_cek_request_open);

			if ($id_batch_awal != "") {
				$this->Import_model->delete_batch_saltab($id_batch_awal);
			}

			// $data_batch += ['id' => $id_batch_awal];

			if ($data_batch != '') {
				$this->Import_model->insert_saltab_batch($data_batch);
			}

			$id_batch = $this->Import_model->get_id_saltab_batch($data_batch);

			//susun array saltab detail
			for ($i = 2; $i < count($sheet_data); $i++) {
				$data += ['uploadid' => $id_batch];
				for ($j = 0; $j < $length_header; $j++) {
					if ($header_tabel_saltab[$j] == "nip") {
						if (($sheet_data[$i][$j] == "0") || ($sheet_data[$i][$j] == "")) {
							// $data += [$header_tabel_saltab[$j] => $sheet_data[$i][$j]];
							$trimmed_nip = trim($sheet_data[$i][$j], " ");
							$data += [$header_tabel_saltab[$j] => $trimmed_nip];
						} else {
							if (($sheet_data[$i][$j + 1] == "0") || ($sheet_data[$i][$j + 1] == "")) {
								// $data += [$header_tabel_saltab[$j] => $sheet_data[$i][$j]];
								$trimmed_nip = trim($sheet_data[$i][$j], " ");
								$data += [$header_tabel_saltab[$j] => $trimmed_nip];
								// $data += [$header_tabel_saltab[$j + 1] => "NIK KOSONG"];
								$data += [$header_tabel_saltab[$j + 1] => $this->Import_model->get_ktp_karyawan($sheet_data[$i][$j])];
								// $data += [$header_tabel_saltab[$j + 1] => "CEK CIS"];
								$j = $j + 1;
							} else {
								$trimmed_nip = trim($sheet_data[$i][$j], " ");
								$data += [$header_tabel_saltab[$j] => $trimmed_nip];
							}
						}
						// $data += [$header_tabel_saltab[$j] => $sheet_data[$i][$j]];
					} else {
						$trimmed_nip = trim($sheet_data[$i][$j], " ");
						$data += [$header_tabel_saltab[$j] =>$trimmed_nip];
					}
				}
				$array_data[] = $data;
				$data = array();
			}

			if ($nama_sub_project == "-ALL-") {
				if (!empty($array_data)) {
					$this->Import_model->insert_saltab_detail($array_data);
				}
			} else {
				foreach ($array_data as $array_data) {
					$array_data['sub_project'] = $nama_sub_project;
					$array_data_final[] = $array_data;
				}
				if (!empty($array_data_final)) {
					$this->Import_model->insert_saltab_detail($array_data_final);
				}
			}

			$tes_query = $this->db->last_query();


			// if ($array_data != '') {
			// 	$this->Import_model->insert_saltab_detail($array_data);
			// }

			// $this->modal_feedback('success', 'Success', 'Data Imported', 'OK');

			// print_r($id_batch . "," . $nik . "," . $project . "," . $sub_project . "," . $saltab_from . "," . $saltab_to);
			// echo '<pre>';
			// print_r($tes_query);
			// echo '</pre>';
			// echo '<pre>';
			// print_r("NIK : " . $nik);
			// echo '</pre>';
			// echo '<pre>';
			// print_r($array_data_final);
			// echo '</pre>';
			// echo '<pre>';
			// print_r($header_tabel_saltab);
			// echo '</pre>';
		} else {
			// $this->modal_feedback('error', 'Error', 'Import failed', 'Try again');
			print_r("gagal import");
			print_r($_FILES['file_excel']['name']);
		}

		//$this->view_batch_saltab_temporary($id_batch);
		//redirect('/');

		redirect('admin/Importexcel/view_batch_saltab_temporary/' . $id_batch);
	}

	function view_batch_saltab_temporary($id_batch = null)
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);

		$data['title'] = 'Preview E-Saltab | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = "<a href='" . base_url('admin/Importexcel/importesaltab') . "'>Import E-SALTAB</a> | Preview E-Saltab";

		$session = $this->session->userdata('username');

		$data['id_batch'] = $id_batch;
		$data['batch_saltab'] = $this->Import_model->get_saltab_batch($id_batch);

		if (!empty($session)) {
			$data['subview'] = $this->load->view("admin/import_excel/preview_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}

	function view_batch_saltab_release($id_batch = null)
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);

		$data['title'] = 'Detail E-Saltab | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = "<a href='" . base_url('admin/Importexcel/manage_esaltab') . "'>Manage E-SALTAB</a> | Detail E-Saltab";

		$session = $this->session->userdata('username');

		$data['id_batch'] = $id_batch;
		$data['batch_saltab'] = $this->Import_model->get_saltab_batch_release($id_batch);

		if (!empty($session)) {
			$data['subview'] = $this->load->view("admin/import_excel/detail_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}

	function view_batch_saltab_release_download($id_batch = null)
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);

		$data['title'] = 'Detail E-Saltab | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = "<a href='" . base_url('admin/Importexcel/download_esaltab') . "'>Download E-SALTAB</a> | Detail E-Saltab";

		$session = $this->session->userdata('username');

		$data['id_batch'] = $id_batch;
		$data['batch_saltab'] = $this->Import_model->get_saltab_batch_release($id_batch);

		if (!empty($session)) {
			$data['subview'] = $this->load->view("admin/import_excel/detail_esaltab_download", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}

	// Function to get the client IP address
	function get_client_ip()
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	// Validate and add info in database
	public function import_newemp()
	{

		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;
						$lastnik = $this->Employees_model->get_maxid();
						$formula4 = substr($lastnik, 5);

						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);

							if ($line[2] == 'HO' || $line[2] == 'INHOUSE' || $line[2] == 'IN-HOUSE') {
								$formula2 = '2';
							} else {
								$formula2 = '3';
							}

							$formula3 = sprintf("%03d", $line[3]);



							$ids = '2' . $formula2 . $formula3 . (int)$formula4 + 1;
							// $ids = (int)$formula4+1;


							$data = array(
								'uploadid' => $uploadid,
								'employee_id' => $ids, // auto
								'fullname' => $line[1],
								'company_id' => '2',
								'location_id' => '3', //ho-area
								'department_id' => $line[2], //divisi
								'designation_id' => $line[3], //jabatan
								'date_of_joining' => $line[4],
								'ktp_no' => $line[0],

							);
							$result = $this->Employees_model->addtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Employees_model->delete_temp_by_employeeid();
							$formula4++;
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}


		redirect('admin/ImportExcelEmployees?upid=' . $uploadid);
	}


	// Validate and add info in database
	public function import_eslip()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;
						$lastnik = $this->Employees_model->get_maxid();
						$formula4 = substr($lastnik, 5);


						//parse data from csv file line by line
						//while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);

							// if($line[2]=='HO' || $line[2]=='INHOUSE' || $line[2]=='IN-HOUSE'){
							// 	$formula2 = '2';
							// } else {
							// 	$formula2 = '3';
							// }

							// $formula3 = sprintf("%03d", $line[3]);

							// $ids = '2'.$formula2.$formula3.(int)$formula4+1;
							// $ids = (int)$formula4+1;


							$data = array(
								'uploadid' 								=> $uploadid,
								'nip' 										=> $line[0],
								'fullname' 								=> str_replace("'", " ", $line[1]),
								'periode' 								=> str_replace("'", " ", $line[2]),
								'project' 								=> $line[3],
								'project_sub' 						=> $line[4],
								'area' 										=> str_replace("'", " ", $line[5]),
								'status_emp' 							=> $line[6],
								'hari_kerja' 							=> $line[7],
								'gaji_umk' 								=> $line[8],
								'gaji_pokok' 							=> $line[9],
								'allow_jabatan' 					=> $line[10],
								'allow_area' 							=> $line[11],
								'allow_masakerja' 				=> $line[12],
								'allow_konsumsi' 					=> $line[13],
								'allow_transport' 				=> $line[14],
								'allow_rent' 							=> $line[15],
								'allow_comunication' 			=> $line[16],
								'allow_parking' 					=> $line[17],
								'allow_residence_cost' 		=> $line[18],
								'allow_akomodasi' 				=> $line[19],
								'allow_device' 						=> $line[20],
								'allow_kasir' 						=> $line[21],
								'allow_trans_meal' 				=> $line[22],
								'allow_trans_rent' 				=> $line[23],
								'allow_vitamin' 					=> $line[24],
								'allow_grooming'					=> $line[25],
								'allow_others'						=> $line[26],
								'allow_operation' 				=> $line[27],
								'over_salary' 						=> $line[28],
								'penyesuaian_umk' 				=> $line[29],
								'insentive'								=> $line[30],
								'overtime' 								=> $line[31],
								'overtime_holiday' 				=> $line[32],
								'overtime_national_day' 	=> $line[33],
								'overtime_rapel' 					=> $line[34],
								'kompensasi' 							=> $line[35],
								'bonus' 									=> $line[36],
								'uuck' 										=> $line[37],
								'thr' 										=> $line[38],
								'bpjs_tk_deduction' 			=> $line[39],
								'bpjs_ks_deduction' 			=> $line[40],
								'jaminan_pensiun_deduction' => $line[41],
								'pendapatan' 							=> $line[42],
								'bpjs_tk' 								=> $line[43],
								'bpjs_ks' 								=> $line[44],
								'jaminan_pensiun' 				=> $line[45],
								'deposit' 								=> $line[46],
								'pph' 										=> $line[47],
								'pph_thr' 								=> $line[48],
								'penalty_late' 						=> $line[49],
								'penalty_alfa' 						=> $line[50],
								'penalty_attend' 					=> $line[51],
								'mix_oplos' 							=> $line[52],
								'pot_trip_malang' 				=> $line[53],
								'pot_device' 							=> $line[54],
								'pot_kpi' 								=> $line[55],
								'deduction' 							=> $line[56],
								'simpanan_pokok' 					=> $line[57],
								'simpanan_wajib_koperasi' => $line[58],
								'pembayaran_pinjaman' 		=> $line[59],
								'biaya_admin_bank' 				=> $line[60],
								'adjustment' 							=> $line[61],
								'adjustment_dlk' 					=> $line[62],
								'total' 									=> $line[63],
								'createdby' 							=> $employee_id,

							);
							$result = $this->Import_model->addtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Import_model->delete_temp_by_nip();
							// $formula4++;
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}

		redirect('admin/Importexceleslip?upid=' . $uploadid);
	}



	// Validate and add info in database
	public function import_ratecard()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();


		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;
						// $lastnik = $this->Employees_model->get_maxid();
						// $formula4 = substr($lastnik,5);

						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);

							// if($line[2]=='HO' || $line[2]=='INHOUSE' || $line[2]=='IN-HOUSE'){
							// 	$formula2 = '2';
							// } else {
							// 	$formula2 = '3';
							// }

							// $formula3 = sprintf("%03d", $line[3]);

							// $ids = '2'.$formula2.$formula3.(int)$formula4+1;
							// $ids = (int)$formula4+1;


							$data = array(
								'uploadid' 						=> $uploadid,
								'company_id' 					=> $line[1],
								'nama_pt' 						=> 'PT Siprama Cakrawala',
								'periode' 						=> $line[2], //periode
								'date_periode_start' 	=> $line[3], //start date
								'date_periode_end' 		=> $line[4], //start date
								'project_id' 					=> $line[5], //project id
								'project' 						=> $line[6], //project
								'sub_project_id' 			=> $line[7], //sub project id
								'sub_project' 				=> $line[8], // sub project
								'kota' 								=> $line[9], //kota
								'posisi_jabatan' 			=> $line[10], //jabatan
								'jumlah_mpp' 					=> $line[11], //jumlah mpp
								'gaji_pokok' 					=> $line[12], //gapok
								'hari_kerja' 					=> $line[13], //hari kerja
								'dm_grade' 						=> $line[14], // dm_grade
								'allow_grade' 				=> $line[15], //grade
								'dm_masa_kerja' 			=> $line[16], // dm_grade
								'allow_masa_kerja' 		=> $line[17], //grade
								'dm_konsumsi' 				=> $line[18], //dm_konsumsi
								'allow_konsumsi' 			=> $line[19], //konsumsi
								'dm_transport' 				=> $line[20], //dm_transport
								'allow_transport' 		=> $line[21], //transport
								'dm_rent' 						=> $line[22], //dm_sewa
								'allow_rent' 					=> $line[23], //sewa
								'dm_comunication' 		=> $line[24], //
								'allow_comunication'	=> $line[25], //
								'dm_parking'					=> $line[26], //dm_parkir
								'allow_parking' 			=> $line[27], //parkir
								'dm_resicance' 				=> $line[28], //dm_residance
								'allow_residance' 		=> $line[29], //allow resicande
								'dm_device' 					=> $line[30], //dm_device
								'allow_device' 				=> $line[31], //device
								'dm_kasir' 						=> $line[32], //dm kasair
								'allow_kasir' 				=> $line[33], //allow kasir
								'dm_trans_meal' 			=> $line[34], //dm_transmeal
								'allow_trans_meal' 		=> $line[35], //transmeal
								'dm_medicine' 				=> $line[36], //dm_medical
								'allow_medicine' 			=> $line[37], //medical
								'total_allow' 				=> $line[38], //total_tunjangan
								'gaji_bersih' 				=> $line[39], //gaji bersih
								'kompensasi' 					=> $line[40], //kompensasi
								'kompensasi_pt' 			=> $line[41], //kompensasi client
								'bpjs_tk' 						=> $line[42], //bpjs tk
								'bpjs_ks' 						=> $line[43], //bpjs ks
								'insentive' 					=> $line[44], //insentive
								'total' 							=> $line[45], //total
								'grand_total' 				=> $line[46], //grand_total

								'createdby' => $employee_id,
								'createdon' => date('Y-m-d h:i:s'),


							);
							$result = $this->Import_model->addratecardtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Import_model->delete_temp_by_pt();
							// $formula4++;
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}


		redirect('admin/Importexcelratecard?upid=' . $uploadid);
	}


	public function history_upload_ratecard_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/import_excel/import_ratecard", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));



		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$location = $this->Location_model->get_locations();
		// } else {
		// 	$location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
		// }
		$history_eslip = $this->Import_model->get_all_ratecard();

		$data = array();

		foreach ($history_eslip->result() as $r) {
			$uploadid = $r->uploadid;
			$up_date = $r->up_date;
			$periode = $r->periode;
			$project = $r->project;
			$project_sub = $this->Xin_model->clean_post($r->sub_project);
			$createdby = $r->createdby;

			$preiode_param 			= str_replace(" ", "", $r->periode);
			$project_param 			= str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project)));
			$project_sub_param 	= str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->sub_project)));

			// get created
			$empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			if (!is_null($empname)) {
				$fullname = $empname[0]->first_name;
			} else {
				$fullname = '--';
			}

			if ($project_sub == 'INHOUSE' || $project_sub == 'INHOUSE AREA' || $project_sub == 'AREA' || $project_sub == 'HO') {
				if ($session['user_id'] == '1') {

					$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				} else {

					$view_data = '';
				}
			} else {
				$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
			}


			$data[] = array(
				$view_data,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$fullname,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history_eslip->num_rows(),
			"recordsFiltered" => $history_eslip->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	// expired page
	public function importsaltab()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = 'Import Saltab to BPJS | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Import Saltab to BPJS';
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_saltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('481', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/import_saltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	public function history_upload_eslip_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/import_excel/import_eslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));



		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$location = $this->Location_model->get_locations();
		// } else {
		// 	$location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
		// }
		$history_eslip = $this->Import_model->get_all_eslip($user_info[0]->employee_id);

		$data = array();

		foreach ($history_eslip->result() as $r) {
			$uploadid = $r->uploadid;
			$up_date = $r->up_date;
			$periode = $r->periode;
			$project = $r->project;
			$project_sub = $this->Xin_model->clean_post($r->project_sub);
			$total_mp = $r->total_mp;
			$createdby = $r->createdby;

			$preiode_param = str_replace(" ", "", $r->periode);
			$project_param 			= str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project)));
			$project_sub_param = str_replace("]", "", str_replace("[", "", str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project_sub)))));

			// get created
			$empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			if (!is_null($empname)) {
				$fullname = $empname[0]->first_name;
			} else {
				$fullname = '--';
			}

			if ($project_sub == 'INHOUSE' || $project_sub == 'INHOUSE AREA' || $project_sub == 'AREA' || $project_sub == 'HO') {
				if ($session['user_id'] == '1') {

					$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				} else {

					$view_data = '';
				}
			} else {
				$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
			}


			$data[] = array(
				$view_data,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$total_mp,
				$fullname,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history_eslip->num_rows(),
			"recordsFiltered" => $history_eslip->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function history_upload_saltab_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/import_excel/import_saltab", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));



		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$location = $this->Location_model->get_locations();
		// } else {
		// 	$location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
		// }
		$history_eslip = $this->Import_model->get_all_saltab();

		$data = array();

		foreach ($history_eslip->result() as $r) {
			$uploadid = $r->uploadid;
			$up_date = $r->up_date;
			$periode = $r->periode;
			$project = $r->project;
			$project_sub = $this->Xin_model->clean_post($r->project_sub);
			$total_mp = $r->total_mp;
			$createdby = $r->createdby;

			$preiode_param = str_replace(" ", "", $r->periode);
			$project_param 			= str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project)));
			$project_sub_param = str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project_sub)));

			// get created
			$empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			if (!is_null($empname)) {
				$fullname = $empname[0]->first_name;
			} else {
				$fullname = '--';
			}

			if ($project_sub == 'INHOUSE' || $project_sub == 'INHOUSE AREA' || $project_sub == 'AREA' || $project_sub == 'HO') {
				if ($session['user_id'] == '1') {

					$view_data = '<a href="' . site_url() . 'admin/importexcelsaltab/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				} else {

					$view_data = '';
				}
			} else {
				$view_data = '<a href="' . site_url() . 'admin/importexcelsaltab/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
			}


			$data[] = array(
				$view_data,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$total_mp,
				$fullname,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history_eslip->num_rows(),
			"recordsFiltered" => $history_eslip->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	// Validate and add info in database
	public function import_saltab()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;
						$lastnik = $this->Employees_model->get_maxid();
						$formula4 = substr($lastnik, 5);

						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);

							// if($line[2]=='HO' || $line[2]=='INHOUSE' || $line[2]=='IN-HOUSE'){
							// 	$formula2 = '2';
							// } else {
							// 	$formula2 = '3';
							// }

							// $formula3 = sprintf("%03d", $line[3]);

							// $ids = '2'.$formula2.$formula3.(int)$formula4+1;
							// $ids = (int)$formula4+1;


							$data = array(
								'uploadid' 								=> $uploadid,
								'nip' 										=> $line[0],
								'fullname' 								=> $line[1],
								'periode' 								=> $line[2],
								'project' 								=> $line[3],
								'project_sub' 						=> $line[4],
								'area' 										=> $line[5],
								'status_emp' 							=> $line[6],
								'hari_kerja' 							=> $line[7],
								'gaji_umk' 								=> $line[8],
								'gaji_pokok' 							=> $line[9],


								'allow_jabatan' 					=> $line[10],
								'allow_area' 							=> $line[11],
								'allow_masakerja' 				=> $line[12],
								'allow_konsumsi' 					=> $line[13],
								'allow_transport' 				=> $line[14],
								'allow_rent' 							=> $line[15],
								'allow_comunication' 			=> $line[16],
								'allow_parking' 					=> $line[17],
								'allow_residence_cost' 		=> $line[18],
								'allow_akomodasi' 				=> $line[19],
								'allow_device' 						=> $line[20],
								'allow_kasir' 						=> $line[21],
								'allow_trans_meal' 				=> $line[22],
								'allow_trans_rent' 				=> $line[23],
								'allow_vitamin' 					=> $line[24],
								'allow_grooming'					=> $line[25],
								'allow_others'						=> $line[26],
								'allow_operation' 				=> $line[27],

								'over_salary' 						=> $line[28],
								'penyesuaian_umk' 				=> $line[29],
								'insentive'								=> $line[30],
								'overtime' 								=> $line[31],
								'overtime_holiday' 				=> $line[32],
								'overtime_national_day' 	=> $line[33],
								'overtime_rapel' 					=> $line[34],
								'kompensasi' 							=> $line[35],
								'bonus' 									=> $line[36],
								'uuck' 										=> $line[37],
								'thr' 										=> $line[38],
								'bpjs_tk_deduction' 			=> $line[39],
								'bpjs_ks_deduction' 			=> $line[40],
								'jaminan_pensiun_deduction' => $line[41],
								'pendapatan' 							=> $line[42],
								'bpjs_tk' 								=> $line[43],
								'bpjs_ks' 								=> $line[44],
								'jaminan_pensiun' 				=> $line[45],
								'deposit' 								=> $line[46],
								'pph' 										=> $line[47],
								'pph_thr' 								=> $line[48],
								'penalty_late' 						=> $line[49],
								'penalty_alfa' 						=> $line[50],
								'penalty_attend' 					=> $line[51],
								'mix_oplos' 							=> $line[52],
								'pot_trip_malang' 				=> $line[53],
								'pot_device' 							=> $line[54],
								'pot_kpi' 								=> $line[55],
								'deduction' 							=> $line[56],
								'simpanan_pokok' 					=> $line[57],
								'simpanan_wajib_koperasi' => $line[58],
								'pembayaran_pinjaman' 		=> $line[59],
								'biaya_admin_bank' 				=> $line[60],
								'adjustment' 							=> $line[61],
								'adjustment_dlk' 					=> $line[62],
								'total' 									=> $line[63],
								'createdby' 							=> $employee_id,

							);
							$result = $this->Import_model->add_saltab_temp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Import_model->delete_saltabtemp_by_nip();
							// $formula4++;
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}

		redirect('admin/Importexcelsaltab?upid=' . $uploadid);
	}

	// expired page
	public function bpjs()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = 'E-Slip To BPJS | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'E-Slip to BPJS';
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_eslip_bpjs';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('477', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/bpjs/eslip_bpjs_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	public function history_upload_eslip_bpjs()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/bpjs/eslip_bpjs_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));



		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$location = $this->Location_model->get_locations();
		// } else {
		// 	$location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
		// }
		$history_eslip = $this->Import_model->get_eslip_project();

		$data = array();

		foreach ($history_eslip->result() as $r) {
			$uploadid = $r->uploadid;
			$up_date = $r->up_date;
			$periode = $r->periode;
			$project = $r->project;
			$project_sub = $this->Xin_model->clean_post($r->project_sub);
			$total_mp = $r->total_mp;
			$createdby = $r->createdby;

			$preiode_param = str_replace(" ", "", $r->periode);
			$project_param = str_replace(" ", "", $r->project);
			$project_sub_param = str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project_sub)));

			// get created
			$empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			if (!is_null($empname)) {
				$fullname = $empname[0]->first_name;
			} else {
				$fullname = '--';
			}

			$view_data = '<a href="' . site_url() . 'admin/reports/saltab_bpjs/?upid=' . $uploadid . '" target="_blank"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';

			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="' . $this->lang->line('xin_edit') . '"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-usermobile_id="' . $uploadid . '"><span class="fas fa-pencil-alt"></span></button></span>';

			$data[] = array(
				$view_data,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$total_mp,
				$fullname,
				$edit

			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history_eslip->num_rows(),
			"recordsFiltered" => $history_eslip->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	public function read()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

		// $keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		// $keystring = $this->input->get('department_id');

		// 	if(!is_null($keywords[0])){

		// 		$read_employee = $this->Employees_model->read_employee_info_by_nik($keywords[0]);
		// 		$read_usermobile = $this->Usersmobile_model->read_users_mobile_by_nik($keywords[0]);

		// 		$full_name = $read_employee[0]->first_name;

		// 		$all_projects = $this->Project_model->get_projects();
		// 		$all_usertype = $this->Usersmobile_model->get_usertype();
		// 		$all_area = $this->Xin_model->get_area();
		// 		// $all_area = $this->Usersmobile_model->get_district();

		// 	}

		// if(is_numeric($keywords[0])) {

		// 	$id = $keywords[0];
		// 	$id = $this->security->xss_clean($id);


		// }

		$data = array(
			'usermobile_id' => 'DIALOG'
			// 'fullname' => $full_name,
			// 'usertype_id' => $read_usermobile[0]->usertype_id,
			// 'project_id' => $read_usermobile[0]->project_id,
			// 'areaid' => $read_usermobile[0]->areaid,
			// 'areaid_extra1' => $read_usermobile[0]->areaid_extra1,
			// 'areaid_extra2' => $read_usermobile[0]->areaid_extra2,
			// 'device_id' => $read_usermobile[0]->device_id_one,
			// 'all_usertype' => $all_usertype,
			// 'all_projects' => $all_projects,
			// 'all_area' => $all_area
		);

		$this->load->view('admin/usermobile/dialog_usermobile', $data);
		// $session = $this->session->userdata('username');

		// if(!empty($session)){
		// 	$this->load->view('admin/usermobile/dialog_usermobile', $data);
		// } else {
		// 	redirect('admin/');
		// }

	}

	//manage saltab release
	public function manage_esaltab()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['title'] = 'Manage E-SALTAB | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Manage E-SALTAB';
		// $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
		// $data['all_projects'] = $this->Project_model->get_projects();
		//$data['path_url'] = 'hrpremium_download_esaltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('513', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/manage_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//konfigurasi import saltab
	public function konfig_import_esaltab()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['title'] = 'Konfigurasi Import E-SALTAB | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Konfigurasi Import E-SALTAB';
		// $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
		// $data['all_projects'] = $this->Project_model->get_projects();
		//$data['path_url'] = 'hrpremium_download_esaltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('512', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/manage_import_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//download saltab release
	public function download_esaltab()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['title'] = 'Download E-SALTAB | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Download E-SALTAB';
		// $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
		// $data['all_projects'] = $this->Project_model->get_projects();
		//$data['path_url'] = 'hrpremium_download_esaltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('514', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/download_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// import saltab
	public function importesaltab()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['title'] = 'Import E-SALTAB | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Import E-SALTAB';
		// $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
		// $data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_esaltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('511', $role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/import_esaltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	public function history_upload_esaltab_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/import_excel/import_esaltab", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));



		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$location = $this->Location_model->get_locations();
		// } else {
		// 	$location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
		// }
		$history_eslip = $this->Import_model->get_all_eslip($user_info[0]->employee_id);

		$data = array();

		foreach ($history_eslip->result() as $r) {
			$uploadid = $r->uploadid;
			$up_date = $r->up_date;
			$periode = $r->periode;
			$project = $r->project;
			$project_sub = $this->Xin_model->clean_post($r->project_sub);
			$total_mp = $r->total_mp;
			$createdby = $r->createdby;

			$preiode_param = str_replace(" ", "", $r->periode);
			$project_param 			= str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project)));
			$project_sub_param = str_replace("]", "", str_replace("[", "", str_replace(")", "", str_replace("(", "", str_replace(" ", "", $r->project_sub)))));

			// get created
			$empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			if (!is_null($empname)) {
				$fullname = $empname[0]->first_name;
			} else {
				$fullname = '--';
			}

			if ($project_sub == 'INHOUSE' || $project_sub == 'INHOUSE AREA' || $project_sub == 'AREA' || $project_sub == 'HO') {
				if ($session['user_id'] == '1') {

					$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				} else {

					$view_data = '';
				}
			} else {
				$view_data = '<a href="' . site_url() . 'admin/Importexceleslip/show_eslip/' . $uploadid . '/' . $preiode_param . '/' . $project_param . '/' . $project_sub_param . '"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
			}


			$data[] = array(
				$view_data,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$total_mp,
				$fullname,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history_eslip->num_rows(),
			"recordsFiltered" => $history_eslip->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	// Validate and add info in database
	public function import_eslip2()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $config['allowed_types'] = 'csv';
		// 	$this->load->library('upload', $config);
		//validate whether uploaded file is a csv file

		$csvMimes =  array(

			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'text/semicolon-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'

		);

		if ($_FILES['file']['name'] === '') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if (in_array($_FILES['file']['type'], $csvMimes)) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// check file size
					if (filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {

						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

						//skip first line
						// fgetcsv($csvFile,0,';');
						$d = new DateTime();
						$datetimestamp = $d->format("YmdHisv");
						$uploadid = $datetimestamp;
						$lastnik = $this->Employees_model->get_maxid();
						$formula4 = substr($lastnik, 5);

						//parse data from csv file line by line
						while (($line = fgetcsv($csvFile, 1000, ';')) !== FALSE) {

							// $options = array('cost' => 12);
							// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);

							// if($line[2]=='HO' || $line[2]=='INHOUSE' || $line[2]=='IN-HOUSE'){
							// 	$formula2 = '2';
							// } else {
							// 	$formula2 = '3';
							// }

							// $formula3 = sprintf("%03d", $line[3]);

							// $ids = '2'.$formula2.$formula3.(int)$formula4+1;
							// $ids = (int)$formula4+1;


							$data = array(
								'uploadid' 								=> $uploadid,
								'nip' 										=> $line[0],
								'fullname' 								=> str_replace("'", " ", $line[1]),
								'periode' 								=> str_replace("'", " ", $line[2]),
								'project' 								=> $line[3],
								'project_sub' 						=> $line[4],
								'area' 										=> str_replace("'", " ", $line[5]),
								'status_emp' 							=> $line[6],
								'hari_kerja' 							=> $line[7],
								'gaji_umk' 								=> $line[8],
								'gaji_pokok' 							=> $line[9],
								'allow_jabatan' 					=> $line[10],
								'allow_area' 							=> $line[11],
								'allow_masakerja' 				=> $line[12],
								'allow_konsumsi' 					=> $line[13],
								'allow_transport' 				=> $line[14],
								'allow_rent' 							=> $line[15],
								'allow_comunication' 			=> $line[16],
								'allow_parking' 					=> $line[17],
								'allow_residence_cost' 		=> $line[18],
								'allow_akomodasi' 				=> $line[19],
								'allow_device' 						=> $line[20],
								'allow_kasir' 						=> $line[21],
								'allow_trans_meal' 				=> $line[22],
								'allow_trans_rent' 				=> $line[23],
								'allow_vitamin' 					=> $line[24],
								'allow_grooming'					=> $line[25],
								'allow_others'						=> $line[26],
								'allow_operation' 				=> $line[27],
								'over_salary' 						=> $line[28],
								'penyesuaian_umk' 				=> $line[29],
								'insentive'								=> $line[30],
								'overtime' 								=> $line[31],
								'overtime_holiday' 				=> $line[32],
								'overtime_national_day' 	=> $line[33],
								'overtime_rapel' 					=> $line[34],
								'kompensasi' 							=> $line[35],
								'bonus' 									=> $line[36],
								'uuck' 										=> $line[37],
								'thr' 										=> $line[38],
								'bpjs_tk_deduction' 			=> $line[39],
								'bpjs_ks_deduction' 			=> $line[40],
								'jaminan_pensiun_deduction' => $line[41],
								'pendapatan' 							=> $line[42],
								'bpjs_tk' 								=> $line[43],
								'bpjs_ks' 								=> $line[44],
								'jaminan_pensiun' 				=> $line[45],
								'deposit' 								=> $line[46],
								'pph' 										=> $line[47],
								'pph_thr' 								=> $line[48],
								'penalty_late' 						=> $line[49],
								'penalty_alfa' 						=> $line[50],
								'penalty_attend' 					=> $line[51],
								'mix_oplos' 							=> $line[52],
								'pot_trip_malang' 				=> $line[53],
								'pot_device' 							=> $line[54],
								'pot_kpi' 								=> $line[55],
								'deduction' 							=> $line[56],
								'simpanan_pokok' 					=> $line[57],
								'simpanan_wajib_koperasi' => $line[58],
								'pembayaran_pinjaman' 		=> $line[59],
								'biaya_admin_bank' 				=> $line[60],
								'adjustment' 							=> $line[61],
								'adjustment_dlk' 					=> $line[62],
								'total' 									=> $line[63],
								'createdby' 							=> $employee_id,

							);
							$result = $this->Import_model->addtemp($data);

							// $bank_account_data = array(
							// 'account_title' => 'Rekening',
							// 'account_number' => $line[18], //NO. REK
							// 'bank_name' => $line[19],
							// 'employee_id' => $last_insert_id,
							// 'created_at' => date('d-m-Y'),
							// );
							// $ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);

							$resultdel = $this->Import_model->delete_temp_by_nip();
							// $formula4++;
						}
						//close opened csv file
						fclose($csvFile);


						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty

		if ($Return['error'] != '') {
			$this->output($Return);
		}

		redirect('admin/Importexceleslip?upid=' . $uploadid);
	}

	//mengambil Json data validasi employee request
	public function request_open_import()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		$nama_project = "";
		$projects = $this->Project_model->read_single_project($postData['project_id']);
		if (!is_null($projects)) {
			$nama_project = $projects[0]->title;
		} else {
			$nama_project = '--';
		}

		//load data Sub Project
		$nama_sub_project = "";
		if ($postData['sub_project_id'] == 0) {
			$nama_sub_project = '-ALL-';
		} else {
			$subprojects = $this->Subproject_model->read_single_subproject($postData['sub_project_id']);
			if (!is_null($subprojects)) {
				$nama_sub_project = $subprojects[0]->sub_project_name;
			} else {
				$nama_sub_project = '--';
			}
		}

		//Input untuk Database
		$datarequest = [
			'request_by_id'     	=> $postData['employee_id'],
			'request_by_name'       => $postData['request_by_name'],
			'request_on'      		=> $postData['tgl_request'],
			'tanggal_gajian'        => $postData['tgl_gajian'],
			'project_id'       	  	=> $postData['project_id'],
			'project_name'       	=> $nama_project,
			'sub_project_id'      	=> $postData['sub_project_id'],
			'sub_project_name'      => $nama_sub_project,
			'periode_saltab_from'   => $postData['periode_saltab_from'],
			'periode_saltab_to'     => $postData['periode_saltab_to'],
			'note'          		=> $postData['note_open'],
			'status'          		=> '1',
		];

		// get data 
		$data = $this->Import_model->insert_request_open_import($datarequest);

		if (empty($data)) {
			$response = array(
				'pesan' 	=> "Gagal",
			);
		} else {
			$response = array(
				'pesan' 	=> "Berhasil",
				'data'		=> $data,
			);
		}

		//echo "data berhasil masuk";
		echo json_encode($response);
		echo "<pre>";
		print_r($response);
		echo "</pre>";
	}

	//mengambil Json data validasi employee request
	public function cek_request_open_import()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//Cek Request ACC
		$datarequest = [
			'tanggal_gajian'        => $postData['tgl_gajian'],
			'project_id'       	  	=> $postData['project_id'],
			'sub_project_id'      	=> $postData['sub_project_id'],
			'periode_saltab_from'   => $postData['periode_saltab_from'],
			'periode_saltab_to'     => $postData['periode_saltab_to']
		];

		// get data 
		$data = $this->Import_model->cek_request_open_import($datarequest);

		//cek pengaturan lock manual
		$project_id = $postData['project_id'];

		//cek pengaturan lock otomatis
		$jam_sekarang = $postData['jam_sekarang'];

		if (empty($data)) {
			//cek pengaturan lock manual
			$project_id = $postData['project_id'];
			$data2 = $this->Import_model->cek_request_open_import_manual($project_id);

			if (empty($data2)) {
				//cek pengaturan lock otomatis
				$jam_sekarang = $postData['jam_sekarang'];

				if ($jam_sekarang >= 12) {
					$response = array(
						'status'	=> "100",
						'pesan' 	=> "LOCK IMPORT. Tidak ada request. Jam Tidak Diset. Jam lebih dari 12",
					);
				} else {
					$response = array(
						'status'	=> "101",
						'pesan' 	=> "OPEN IMPORT. Tidak ada request. Jam Tidak Diset. Jam blm 12",
					);
				}
			} else {
				if ($jam_sekarang >= $data2['jam']) {
					$response = array(
						'status'	=> "102",
						'pesan' 	=> "LOCK IMPORT. Tidak ada request. Jam Diset. Jam melebihi angka yang di set",
						'data'		=> $data2,
					);
				} else {
					$response = array(
						'status'	=> "103",
						'pesan' 	=> "OPEN IMPORT. Tidak ada request. Jam Diset. Jam tidak melebihi angka yang di set",
						'data'		=> $data2,
					);
				}
			}
		} else {
			if ($data['status'] == 1) {
				$response = array(
					'status'	=> "104",
					'pesan' 	=> "LOCK IMPORT. Ada Request Blm ACC. Tidak Boleh Request",
					'data'		=> $data,
				);
			} else if ($data['status'] == 0) {
				$response = array(
					'status'	=> "105",
					'pesan' 	=> "OPEN IMPORT. Ada Request dan di ACC",
					'data'		=> $data,
				);
			} else if ($data['status'] == 2) {
				$response = array(
					'status'	=> "106",
					'pesan' 	=> "LOCK IMPORT. Ada Request dan ditolak. Boleh request ulang",
					'data'		=> $data,
				);
			} else {
				$response = array(
					'status'	=> "107",
					'pesan' 	=> "LOCK IMPORT. Ada Request dan berhasil upload. Boleh request ulang",
					'data'		=> $data,
				);
			}
		}

		// //echo "data berhasil masuk";
		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	/**
	 * Compress a file using gzip
	 *
	 * Rewritten from Simon East's version here:
	 * https://stackoverflow.com/a/22754032/3499843
	 *
	 * @param string $inFilename Input filename
	 * @param int    $level      Compression level (default: 9)
	 *
	 * @throws Exception if the input or output file can not be opened
	 *
	 * @return string Output filename
	 */
	function gzcompressfile(string $inFilename, int $level = 9): string
	{
		// Is the file gzipped already?
		$extension = pathinfo($inFilename, PATHINFO_EXTENSION);
		if ($extension == "gz") {
			return $inFilename;
		}

		// Open input file
		$inFile = fopen($inFilename, "rb");
		if ($inFile === false) {
			throw new \Exception("Unable to open input file: $inFilename");
		}

		// Open output file
		$gzFilename = $inFilename . ".gz";
		$mode = "wb" . $level;
		$gzFile = gzopen($gzFilename, $mode);
		if ($gzFile === false) {
			fclose($inFile);
			throw new \Exception("Unable to open output file: $gzFilename");
		}

		// Stream copy
		$length = 512 * 1024; // 512 kB
		while (!feof($inFile)) {
			gzwrite($gzFile, fread($inFile, $length));
		}

		// Close files
		fclose($inFile);
		gzclose($gzFile);

		// Return the new filename
		return $gzFilename;
	}

	//mengambil Json data eslip release
	public function get_data_eslip_release()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'id'        => $postData['id']
		];

		// get data rekening
		$data = $this->Import_model->get_data_eslip_release($datarequest);

		if (empty($data)) {
			$response = array(
				'status'	=> "201",
				'pesan' 	=> "Karyawan tidak ditemukan",
			);
		} else {
			$full_name = "";
			$user = $this->Xin_model->read_user_info($data['eslip_release_by']);
			if (empty($user)) {
				$full_name = "";
			} else {
				$full_name = strtoupper($user[0]->first_name);
			}

			if((empty($data['eslip_release_on'])) || ($data['eslip_release_on'] == "")){
				$eslip_release_on_text = "";
			} else {
				$eslip_release_on_array = explode(" ", $data['eslip_release_on']);
				$eslip_release_on_text = $this->Xin_model->tgl_indo($data['eslip_release_on']) . " " . $eslip_release_on_array[1];
			}
			
			$data2 = array(
				'tanggal_penggajian'	=> $this->Xin_model->tgl_indo($data['periode_salary']),
				'periode_salary'		=> $data['periode_salary'],
				'release_by'			=> $data['release_by'],
				'sub_project_name'		=> $data['sub_project_name'],
				'project_name'			=> $data['project_name'],
				'total_mpp'				=> $data['total_mpp'],
				'periode_cutoff'		=> $this->Xin_model->tgl_indo($data['periode_cutoff_from']) . " s/d " . $this->Xin_model->tgl_indo($data['periode_cutoff_to']),
				'tanggal_terbit'		=> $this->Xin_model->tgl_indo($data['eslip_release']),
				'eslip_release_by'		=> $full_name,
				// 'eslip_release_on'		=> $eslip_release_on_array[1],
				'eslip_release_on'		=> $eslip_release_on_text,
			);

			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Fetch Data",
				'data'		=> $data2,
			);
		}

		echo json_encode($response);
	}
}

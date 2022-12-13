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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExcel extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
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
		$this->load->model("Employees_model");
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
		$this->load->model("Project_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Exin_model');
		$this->load->model('Import_model');
		$this->load->model('Pkwt_model');
		$this->load->library("pagination");
		$this->load->library('Pdf');
		$this->load->helper('string');
     }
	 
	// import
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_imports').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_imports');
		$data['path_url'] = 'hrpremium_import';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('126',$role_resources_ids) || in_array('127',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/hr_import_excel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}	 
	
	// Validate and add info in database
	public function import_employees() {
	
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
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

		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
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
					while(($line = fgetcsv($csvFile,1000,';')) !== FALSE){

						// $options = array('cost' => 12);
						// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);
						$data = array(
						'uploadid' => $uploadid,
						'employee_id' => str_replace(' ','',$line[0]) , // auto
						'fullname' => $line[1],
						'company_id' => $line[2],
						'location_id' => $line[3], //ho-area
						'department_id' =>$line[4], //divisi
						'designation_id' => $line[5], //jabatan
						'project_id' => $line[6], //jabatan
						'sub_project_id' => $line[7], //jabatan
						'email' => $line[8],
						'marital_status' => $line[9], //status perkawinan
						'gender' => $line[10], //jenis kelamin
						'date_of_birth' => $line[11],
						'date_of_joining' => $line[12],
						'contact_no' => $line[13],
						'address' => $line[14],
						'kk_no' =>$line[15],
						'ktp_no' =>$line[16],
						'npwp_no' =>$line[17],
						'bpjs_tk_no' =>$line[18],
						'bpjs_ks_no' =>$line[19]
						// 'created_at' => date('Y-m-d h:i:s')
						// 'user_role_id' => 2, // auto 2 => emplyee
						// 'is_active' => 0, // auto 0 disactive

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
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}

		
		redirect('admin/ImportExcelEmployees?upid='.$uploadid);


	}


	// Validate and add info in database
	public function import_employees_active() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
					
						$data = array(
						'employee_id' => $line[0], // auto
						'username' => $line[0], // nik
						'first_name' => $line[1],
						'designation_id' => $line[2], //jabatan
						'department_id' =>$line[3], //divisi
						'location_id' => $line[4], //ho-area
						'marital_status' => $line[5], //status perkawinan
						'gender' => $line[6], //jenis kelamin
						'date_of_birth' => $line[7],
						'contact_no' => $line[8],
						'address' => $line[9],
						'company_id' => 2, //auto cakrawala => 2
						'user_role_id' => 2, // auto 2 => emplyee
						'is_active' => 0, // auto 0 disactive
						'ktp_no' =>$line[10],
						'kk_no' =>$line[11],
						'npwp_no' =>$line[12],
						'bpjs_tk_no' =>$line[13],
						'bpjs_ks_no' =>$line[14],
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
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$this->output($Return);
		exit;
		}
	}

	// Validate and add info in database
	public function import_attendance() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if(empty($_FILES['file']['name'])) {
			$Return['error'] = $this->lang->line('xin_attendance_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 512000) {
						$Return['error'] = $this->lang->line('xin_error_attendance_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
							
						$attendance_date = $line[1];
						$clock_in = $line[2];
						$clock_out = $line[3];
						$clock_in2 = $attendance_date.' '.$clock_in;
						$clock_out2 = $attendance_date.' '.$clock_out;
						
						//total work
						$total_work_cin =  new DateTime($clock_in2);
						$total_work_cout =  new DateTime($clock_out2);
						
						$interval_cin = $total_work_cout->diff($total_work_cin);
						$hours_in   = $interval_cin->format('%h');
						$minutes_in = $interval_cin->format('%i');
						$total_work = $hours_in .":".$minutes_in;
						
						$user = $this->Xin_model->read_user_by_employee_id($line[0]);
						if(!is_null($user)){
							$user_id = $user[0]->user_id;
						} else {
							$user_id = '0';
						}
					
						$data = array(
						'employee_id' => $user_id,
						'attendance_date' => $attendance_date,
						'clock_in' => $clock_in2,
						'clock_out' => $clock_out2,
						'time_late' => $clock_in2,
						'total_work' => $total_work,
						'early_leaving' => $clock_out2,
						'overtime' => $clock_out2,
						'attendance_status' => 'Present',
						'clock_in_out' => '0'
						);
					$result = $this->Timesheet_model->add_employee_attendance($data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_attendance_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_attendance_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		$this->output($Return);
		exit;
		}
	}
	
	 // Validate and add info in database
	public function import_leads() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
						
						$options = array('cost' => 12);
						$password_hash = password_hash($line[2], PASSWORD_BCRYPT, $options);
						$data = array(
						'name' => $line[0],
						'email' => $line[1],
						'client_password' => $password_hash,
						'contact_number' => $line[3],
						'company_name' => $line[4],
						'website_url' => $line[5],
						'address_1' => $line[6],
						'address_2' => $line[7],
						'city' => $line[8],
						'state' => $line[9],
						'zipcode' => $line[10],
						'country' => $line[11],
						'is_active' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'is_changed' => '0',
						'client_profile' => '',
						);
					$this->Clients_model->add_lead($data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_leads_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_leads_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		$this->output($Return);
		exit;
		}
	}


	// expired page
	public function importpkwt() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_pkwt_import').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_import');
		$data['all_projects'] = $this->Project_model->get_projects();
		// $data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrpremium_import_pkwt';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('129',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// Validate and add info in database
	public function import_pkwt() {
	
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
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

		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
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
					$i=0;
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile,1000,';')) !== FALSE){

					$romawi = $this->Xin_model->tgl_pkwt();
					$nomor_surat = sprintf("%05d", $count_pkwt).'/'.'PKWT-JKTSC-HR/'.$romawi;
					$nomor_surat_spb = sprintf("%05d", $count_pkwt).'/'.'SPB-JKTSC-HR/'.$romawi;

						// $options = array('cost' => 12);
						// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);
						$data = array(
						'uploadid' => $uploadid,
						'no_surat' => $nomor_surat, // auto
						'no_spb' => $nomor_surat_spb,
						'employee_id' => str_replace(' ','',$line[2]),
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
						'allowance_pulsa' =>$line[14],
						'allowance_rent' =>$line[15],
						'allowance_grade' =>$line[16],
						'allowance_laptop' =>$line[17],
						'from_date' =>$line[18],
						'to_date' =>$line[19],
						'start_period_payment' =>$line[20],
						'end_period_payment' =>$line[21],
						'tgl_payment' =>$line[22]

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
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}

		redirect('admin/ImportExcelPKWT?upid='.$uploadid);

	}



	// expired page
	public function importnewemployees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_new_employee').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_new_employee');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_new_employees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('109',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/new_employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// expired page
	public function importratecard() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_excl_ratecard').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_ratecard');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_ratecard';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('109',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/import_ratecard", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	// expired page
	public function importeslip() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_excl_eslip').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_eslip');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_eslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('469',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/import_excel/import_eslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// Validate and add info in database
	public function import_newemp() {
	
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
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

		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
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
					$formula4 = substr($lastnik,5);

					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile,1000,';')) !== FALSE){

						// $options = array('cost' => 12);
						// $password_hash = password_hash('123456', PASSWORD_BCRYPT, $options);
						
						if($line[2]=='HO' || $line[2]=='INHOUSE' || $line[2]=='IN-HOUSE'){
							$formula2 = '2';
						} else {
							$formula2 = '3';
						}

						$formula3 = sprintf("%03d", $line[3]);



						$ids = '2'.$formula2.$formula3.(int)$formula4+1;
						// $ids = (int)$formula4+1;


						$data = array(
						'uploadid' => $uploadid,
						'employee_id' => $ids , // auto
						'fullname' => $line[1],
						'company_id' => '2',
						'location_id' => '3', //ho-area
						'department_id' =>$line[2], //divisi
						'designation_id' => $line[3], //jabatan
						'date_of_joining' => $line[4],
						'ktp_no' =>$line[0],

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
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}

		
		redirect('admin/ImportExcelEmployees?upid='.$uploadid);


	}


	// Validate and add info in database
	public function import_eslip() {
			$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
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

		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
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
					$formula4 = substr($lastnik,5);

					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile,1000,';')) !== FALSE){

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
						'uploadid' => $uploadid,
						'nip' => $line[0],
						'fullname' => $line[1],
						'periode' => $line[2],
						'project' => $line[3],
						'project_sub' => $line[4],
						'area' =>$line[5],
						'hari_kerja' => $line[6],
						'gaji_pokok' => $line[7],
						'allow_jabatan' => $line[8],
						'allow_konsumsi' => $line[9],
						'allow_transport' => $line[10],
						'allow_rent' => $line[11],
						'allow_comunication' => $line[12],
						'allow_parking' => $line[13],
						'allow_residence_cost' => $line[14],
						'allow_device' => $line[15],
						'allow_kasir' => $line[16],
						'allow_trans_meal' => $line[17],
						'allow_vitamin' => $line[18],
						'penyesuaian_umk' => $line[19],
						'insentive'	=> $line[20],
						'overtime' => $line[21],
						'overtime_national_day' => $line[22],
						'overtime_rapel' => $line[23],
						'kompensasi' => $line[24],
						'bonus' => $line[25],
						'thr' => $line[26],
						'bpjs_tk_deduction' => $line[27],
						'bpjs_ks_deduction' => $line[28],
						'jaminan_pensiun_deduction' => $line[29],
						'pendapatan' => $line[30],
						'bpjs_tk' => $line[31],
						'bpjs_ks' => $line[32],
						'jaminan_pensiun' => $line[33],
						'deposit' => $line[34],
						'pph' => $line[35],
						'penalty_late' => $line[36],
						'penalty_attend' => $line[37],
						'deduction' => $line[38],
						'simpanan_pokok' => $line[39],
						'simpanan_wajib_koperasi' => $line[40],
						'pembayaran_pinjaman' => $line[41],
						'biaya_admin_bank' => $line[42],
						'adjustment' => $line[43],
						'total' => $line[44],
						'createdby' => $employee_id,


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
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}

		
		redirect('admin/Importexceleslip?upid='.$uploadid);

	}


  public function history_upload_eslip_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
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
		$history_eslip = $this->Import_model->get_all_eslip();

		$data = array();

          foreach($history_eslip->result() as $r) {
          	$uploadid = $r->uploadid;
          	$up_date = $r->up_date;
				  	$periode = $r->periode;
				  	$project = $r->project;
				  	$project_sub = $this->Xin_model->clean_post($r->project_sub);
				  	$total_mp = $r->total_mp;
				  	$createdby = $r->createdby;

				  	$preiode_param = str_replace(" ","",$r->periode);
				  	$project_param = str_replace(" ","",$r->project);
				  	$project_sub_param = str_replace(")","",str_replace("(","",str_replace(" ","",$r->project_sub)));

			  // get created
			  $empname = $this->Employees_model->read_employee_info_by_nik($r->createdby);
			  if(!is_null($empname)){
			  	$fullname = $empname[0]->first_name;
			  } else {
				  $fullname = '--';	
			  }

				  	if($project_sub=='INHOUSE' || $project_sub=='INHOUSE AREA' || $project_sub=='AREA' || $project_sub=='HO'){
				  		if($session['user_id']=='1'){

			  			$view_data = '<a href="'.site_url().'admin/Importexceleslip/show_eslip/'.$uploadid.'/'.$preiode_param.'/'.$project_param.'/'.$project_sub_param.'"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				  		} else {
				  			
			  			$view_data = '';
				  		}
				  	} else {
			  			$view_data = '<a href="'.site_url().'admin/Importexceleslip/show_eslip/'.$uploadid.'/'.$preiode_param.'/'.$project_param.'/'.$project_sub_param.'"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
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


	// expired page
	// public function preview() {
	
	// 	$session = $this->session->userdata('username');
	// 	if(empty($session)){ 
	// 		redirect('admin/');
	// 	}
	// 	$data['title'] = $this->lang->line('xin_import_excl_eslip').' | '.$this->Xin_model->site_title();
	// 	$data['breadcrumbs'] = $this->lang->line('xin_import_excl_eslip');
	// 	$data['all_projects'] = $this->Project_model->get_projects();
	// 	$data['path_url'] = 'hrpremium_import_eslip';
	// 	$role_resources_ids = $this->Xin_model->user_role_resource();
	// 	if(in_array('469',$role_resources_ids)) {
	// 		// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
	// 		$data['subview'] = $this->load->view("admin/import_excel/import_eslip", $data, TRUE);
	// 		$this->load->view('admin/layout/layout_main', $data); //page load
	// 	} else {
	// 		redirect('admin/dashboard');
	// 	}
	// }

} 
?>
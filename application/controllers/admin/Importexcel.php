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
		if(in_array('127',$role_resources_ids) || in_array('127',$role_resources_ids)) {
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
						'employee_id' 		=> str_replace(' ','',$line[0]) , // auto
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
		if(in_array('232',$role_resources_ids)) {
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
						'allow_operation' 				=> $line[25],
						'over_salary' 						=> $line[26],
						'penyesuaian_umk' 				=> $line[27],
						'insentive'								=> $line[28],
						'overtime' 								=> $line[29],
						'overtime_holiday' 				=> $line[30],
						'overtime_national_day' 	=> $line[31],
						'overtime_rapel' 					=> $line[32],
						'kompensasi' 							=> $line[33],
						'bonus' 									=> $line[34],
						'uuck' 										=> $line[35],
						'thr' 										=> $line[36],
						'bpjs_tk_deduction' 			=> $line[37],
						'bpjs_ks_deduction' 			=> $line[38],
						'jaminan_pensiun_deduction' => $line[39],
						'pendapatan' 							=> $line[40],
						'bpjs_tk' 								=> $line[41],
						'bpjs_ks' 								=> $line[42],
						'jaminan_pensiun' 				=> $line[43],
						'deposit' 								=> $line[44],
						'pph' 										=> $line[45],
						'pph_thr' 								=> $line[46],
						'penalty_late' 						=> $line[47],
						'penalty_alfa' 						=> $line[48],
						'penalty_attend' 					=> $line[49],
						'mix_oplos' 							=> $line[50],
						'pot_trip_malang' 				=> $line[51],
						'pot_device' 							=> $line[52],
						'pot_kpi' 								=> $line[53],
						'deduction' 							=> $line[54],
						'simpanan_pokok' 					=> $line[55],
						'simpanan_wajib_koperasi' => $line[56],
						'pembayaran_pinjaman' 		=> $line[57],
						'biaya_admin_bank' 				=> $line[58],
						'adjustment' 							=> $line[59],
						'adjustment_dlk' 					=> $line[60],
						'total' 									=> $line[61],
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



	// Validate and add info in database
	public function import_ratecard() {
			$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$employee_id = $session['employee_id'];
		// if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
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
					// $lastnik = $this->Employees_model->get_maxid();
					// $formula4 = substr($lastnik,5);

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
						'uploadid' 						=> $uploadid,
						'company_id' 					=> $line[1],
						'nama_pt' 						=> 'PT Siprama Cakrawala',
						'periode' 						=> $line[2], //periode
						'date_periode_start' 	=> $line[3], //start date
						'date_periode_end' 		=> $line[4], //start date
						'project_id' 					=> $line[5], //project id
						'project' 						=> $line[6],//project
						'sub_project_id' 			=> $line[7],//sub project id
						'sub_project' 				=> $line[8], // sub project
						'kota' 								=> $line[9], //kota
						'posisi_jabatan' 			=> $line[10],//jabatan
						'jumlah_mpp' 					=> $line[11],//jumlah mpp
						'gaji_pokok' 					=> $line[12],//gapok
						'hari_kerja' 					=> $line[13],//hari kerja
						'dm_grade' 						=> $line[14], // dm_grade
						'allow_grade' 				=> $line[15],//grade
						'dm_masa_kerja' 			=> $line[16], // dm_grade
						'allow_masa_kerja' 		=> $line[17],//grade
						'dm_konsumsi' 				=> $line[18],//dm_konsumsi
						'allow_konsumsi' 			=> $line[19],//konsumsi
						'dm_transport' 				=> $line[20],//dm_transport
						'allow_transport' 		=> $line[21],//transport
						'dm_rent' 						=> $line[22],//dm_sewa
						'allow_rent' 					=> $line[23],//sewa
						'dm_comunication' 		=> $line[24],
						'allow_comunication'	=> $line[25],
						'dm_parking'					=> $line[26],//dm_parkir
						'allow_parking' 			=> $line[27],//parkir
						'dm_resicance' 				=> $line[28],//dm_residance
						'allow_residance' 		=> $line[29], //allow resicande
						'dm_device' 					=> $line[30],//dm_device
						'allow_device' 				=> $line[31],//device
						'dm_kasir' 						=> $line[32],//dm kasair
						'allow_kasir' 				=> $line[33], //allow kasir
						'dm_trans_meal' 			=> $line[34],//dm_transmeal
						'allow_trans_meal' 		=> $line[35],//transmeal
						'dm_medicine' 				=> $line[36],//dm_medical
						'allow_medicine' 			=> $line[37],//medical
						'total_allow' 				=> $line[38],//total_tunjangan
						'gaji_bersih' 				=> $line[39],//gaji bersih
						'kompensasi' 					=> $line[40],//kompensasi
						'kompensasi_pt' 			=> $line[41],//kompensasi client
						'bpjs_tk' 						=> $line[42],//bpjs tk
						'bpjs_ks' 						=> $line[43],//bpjs ks
						'insentive' 					=> $line[44],//insentive
						'total' 							=> $line[45],//total
						'grand_total' 				=> $line[46],//grand_total

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

		
		redirect('admin/Importexcelratecard?upid='.$uploadid);

	}


  public function history_upload_ratecard_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
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

          foreach($history_eslip->result() as $r) {
          	$uploadid = $r->uploadid;
          	$up_date = $r->up_date;
				  	$periode = $r->periode;
				  	$project = $r->project;
				  	$project_sub = $this->Xin_model->clean_post($r->sub_project);
				  	$createdby = $r->createdby;

				  	$preiode_param = str_replace(" ","",$r->periode);
				  	$project_param = str_replace(" ","",$r->project);
				  	$project_sub_param = str_replace(")","",str_replace("(","",str_replace(" ","",$r->sub_project)));

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
	public function importsaltab() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'Import Saltab to BPJS | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Import Saltab to BPJS';
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_import_saltab';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('481',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/import_saltab", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
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
		$history_eslip = $this->Import_model->get_all_eslip($user_info[0]->employee_id);

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

  public function history_upload_saltab_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
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

			  			$view_data = '<a href="'.site_url().'admin/importexcelsaltab/show_eslip/'.$uploadid.'/'.$preiode_param.'/'.$project_param.'/'.$project_sub_param.'"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
				  		} else {
				  			
			  			$view_data = '';
				  		}
				  	} else {
			  			$view_data = '<a href="'.site_url().'admin/importexcelsaltab/show_eslip/'.$uploadid.'/'.$preiode_param.'/'.$project_param.'/'.$project_sub_param.'"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';
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
	public function import_saltab() {
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
						'allow_operation' 				=> $line[25],
						'over_salary' 						=> $line[26],
						'penyesuaian_umk' 				=> $line[27],
						'insentive'								=> $line[28],
						'overtime' 								=> $line[29],
						'overtime_holiday' 				=> $line[30],
						'overtime_national_day' 	=> $line[31],
						'overtime_rapel' 					=> $line[32],
						'kompensasi' 							=> $line[33],
						'bonus' 									=> $line[34],
						'uuck' 										=> $line[35],
						'thr' 										=> $line[36],
						'bpjs_tk_deduction' 			=> $line[37],
						'bpjs_ks_deduction' 			=> $line[38],
						'jaminan_pensiun_deduction' => $line[39],
						'pendapatan' 							=> $line[40],
						'bpjs_tk' 								=> $line[41],
						'bpjs_ks' 								=> $line[42],
						'jaminan_pensiun' 				=> $line[43],
						'deposit' 								=> $line[44],
						'pph' 										=> $line[45],
						'pph_thr' 								=> $line[46],
						'penalty_late' 						=> $line[47],
						'penalty_alfa' 						=> $line[48],
						'penalty_attend' 					=> $line[49],
						'mix_oplos' 							=> $line[50],
						'pot_trip_malang' 				=> $line[51],
						'pot_device' 							=> $line[52],
						'pot_kpi' 								=> $line[53],
						'deduction' 							=> $line[54],
						'simpanan_pokok' 					=> $line[55],
						'simpanan_wajib_koperasi' => $line[56],
						'pembayaran_pinjaman' 		=> $line[57],
						'biaya_admin_bank' 				=> $line[58],
						'adjustment' 							=> $line[59],
						'adjustment_dlk' 					=> $line[60],
						'total' 									=> $line[61],
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

		redirect('admin/Importexcelsaltab?upid='.$uploadid);

	}

	// expired page
	public function bpjs() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'E-Slip To BPJS | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'E-Slip to BPJS';
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['path_url'] = 'hrpremium_eslip_bpjs';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('477',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
			$data['subview'] = $this->load->view("admin/bpjs/eslip_bpjs_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


  public function history_upload_eslip_bpjs() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
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

			  			$view_data = '<a href="'.site_url().'admin/reports/saltab_bpjs/?upid='.$uploadid.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';

				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-usermobile_id="'. $uploadid . '"><span class="fas fa-pencil-alt"></span></button></span>';

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
		if(empty($session)){
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


} 
?>
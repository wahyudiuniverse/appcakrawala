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

class ImportExcelEmployees extends MY_Controller 
{

	public function __construct(){
    parent::__construct();
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Callplan_model");
		$this->load->model("Customers_model");
		$this->load->model("Import_model");
  }
	 		
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['title'] = $this->lang->line('xin_import_excl_employee_view').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_employee_view');

		$product_id = 
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['uploadid'] = $this->input->get('upid', TRUE);
		// $data['all_posisi'] = $this->Xin_model->get_designations();
		// $data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'import_excel_employees';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('127',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/import_excel/view_import_employee", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else { 
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	
	
	public function view_import_excel_employees() {

		$datad['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/import_excel/view_import_employee", $datad);
		} else {
			redirect('admin/');
		}
		$product_id = $this->input->get('upid', TRUE);

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$employees_temp = $this->Employees_model->get_employees_temp($product_id);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

    foreach($employees_temp->result() as $r) {
			  
			  $importid = $r->uploadid;
			  $nik = $r->employee_id;
			  $fullname = $r->fullname;
			  $company_id = $r->company_id;
			  $location_id = $r->location_id;
			  $department_id = $r->department_id;
			  $designation_id = $r->designation_id;
			  $project_id = $r->project_id;
			  $subproject_id = $r->sub_project_id;
			  $email = $r->email;
			  $marital_status = $r->marital_status;
			  $gender = $r->gender;
			  $date_of_birth = $r->date_of_birth;
			  $date_of_joining = $r->date_of_joining;
			  $contact_no = $r->contact_no;
			  $alamat_ktp = $r->alamat_ktp;
			  $kk_no = $r->kk_no;
			  $ktp_no = $r->ktp_no;
			  $npwp_no = $r->npwp_no;
			  $bpjs_tk_no = $r->bpjs_tk_no;
			  $bpjs_ks_no = $r->bpjs_ks_no;

				$now = new DateTime(date("Y-m-d"));

				$isExist = $this->Employees_model->CheckExistNIK($r->employee_id);


				if(!is_null($r->status_error)){
					if($r->status_error=='Duplicate'){

						$error = '<p style="color:#6b4141">Gagal Tersimpan (Duplikat NIK)</p>';
					} else {
						$error = '<p style="color:#75b37f">Success Import</p>';
					}
				} else {

						if(!is_null($isExist)){
							$status_btn = 'btn-success'; 
							// $status_title = $this->lang->line('xin_employees_active');

							$error = '<p style="color:#f95275">NIK Sudah Terdaftar</p>';

						}else {
							$status_btn = 'btn-outline-danger'; 
							// $status_title = $this->lang->line('xin_employees_inactive');

							$error = '
								<div class="btn-group btn-success" data-toggle="tooltip" data-state="primary" data-placement="top">
									<div>
										<a class="dropdown-item inserttemp" href="javascript:void(0)" data-status="1" data-user-id="'.$r->secid.'" style="color: azure;">Import</a>
									</div>
								</div>';


						}


				}


		   $data[] = array(
		   	$error,
				// $importid,
				$nik,
				$fullname,
				$company_id,
				$location_id,
				$department_id,
				$designation_id,
				$r->project_id,
				$subproject_id,
				$email,
				$marital_status,
				$gender,
				$date_of_birth,
				$date_of_joining,
				$contact_no,
				$alamat_ktp,
				$kk_no,
				$ktp_no,
				$npwp_no,
				$bpjs_tk_no,
				$bpjs_ks_no,
		   );
     }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $employees_temp->num_rows(),
                 "recordsFiltered" => $employees_temp->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }

	// Validate and update status info in database // status info
	public function temp_to_primary() {
		/* Define return | here result is used to return user data and error for error message */
		$status_id = $this->uri->segment(4);
		// if($status_id == 2){
		// 	$status_id = 0;
		// }
		// $user_id = $this->uri->segment(5);
		$user = $this->Xin_model->read_employee_temp_info($status_id);
		$duplicate = $this->Employees_model->read_employee_info_by_nik($user[0]->employee_id);


			if(!is_null($duplicate)) {
				// $error = 'Error';

				$datas = array(
					'status_error' => 'Duplicate',
				);

				$this->Employees_model->update_error_temp($datas, $user[0]->secid);

			} else {
				

				$employee_id 				= $user[0]->employee_id;
				$fullname 					= $user[0]->fullname;
				$email 							= $user[0]->email;
				$date_of_birth 			= $user[0]->date_of_birth;
				$tempat_lahir				= $user[0]->tempat_lahir;
				$gender 						= $user[0]->gender;
				$department_id 			= $user[0]->department_id;
				$designation_id 		= $user[0]->designation_id;
				$project_id 				= $user[0]->project_id;
				$sub_project_id 		= $user[0]->sub_project_id;
				$company_id 				= $user[0]->company_id;
				$location_id 				= $user[0]->location_id;
				$penempatan 				= $user[0]->penempatan;
				$date_of_joining 		= $user[0]->date_of_joining;
				$marital_status 		= $user[0]->marital_status;
				$alamat_ktp 				= $user[0]->alamat_ktp;
				$alamat_domisili		= $user[0]->alamat_domisili;
				$contact_no 				= $user[0]->contact_no;
				$ktp_no 						= $user[0]->ktp_no;
				$kk_no 							= $user[0]->kk_no; 
				$npwp_no 						= $user[0]->npwp_no;
				$bpjs_tk_no 				= $user[0]->bpjs_tk_no;
				$bpjs_ks_no 				= $user[0]->bpjs_ks_no;
				$ibu_kandung				= $user[0]->ibu_kandung;
				$bank_name					= $user[0]->bank_name;
				$nomor_rek					= $user[0]->nomor_rek;
				$pemilik_rek				= $user[0]->pemilik_rek;
				$basic_salary				= $user[0]->basic_salary;
				$private_code 			= rand(100000,999999);
				$options 						= array('cost' => 12);
				$password_hash 			= password_hash($private_code, PASSWORD_BCRYPT, $options);

				$data = array(
					'employee_id' 		=> $employee_id,
					'username' 				=> $employee_id,
					'first_name' 			=> $fullname,
					'password' 				=> $password_hash,
					'gender' 					=> $gender,
					'user_role_id' 		=> 2,
					'department_id' 	=> $department_id,
					'designation_id' 	=> $designation_id,
					'project_id' 			=> $project_id,
					'sub_project_id' 	=> $sub_project_id,
					'company_id' 			=> $company_id,
					'location_id' 		=> $location_id,
					'penempatan'			=> $penempatan,
					'tempat_lahir'		=> $tempat_lahir,
					'date_of_birth' 	=> $date_of_birth,
					'date_of_joining' => $date_of_joining,
					'marital_status' 	=> $marital_status,
					'alamat_ktp' 			=> $alamat_ktp,
					'alamat_domisili'	=> $alamat_domisili,
					'contact_no' 			=> $contact_no,
					'email' 					=> $email,
					'kk_no' 					=> $kk_no,
					'ktp_no' 					=> $ktp_no,
					'npwp_no' 				=> $npwp_no,
					'bpjs_tk_no' 			=> $bpjs_tk_no,
					'bpjs_ks_no' 			=> $bpjs_ks_no,
					'ibu_kandung'			=> $ibu_kandung,
					'bank_name'				=> $bank_name,
					'nomor_rek'				=> $nomor_rek,
					'pemilik_rek'			=> $pemilik_rek,
					'basic_salary'		=> $basic_salary,
					'is_active' 			=> 1,
					'private_code' 		=> $private_code,
					'created_by' 			=> $session['user_id'],
				);



				//$id = $this->input->post('user_id');
				$this->Employees_model->add($data);

				$datas = array(
					'status_error' => 'Success Import',
				);

				$this->Employees_model->update_error_temp($datas, $user[0]->secid);

				//$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
				echo $user[0]->employee_id.' '.$this->lang->line('xin_employee_status_updated');

			}

		//$this->output($Return);
		//exit;
	}

	
	// Validate and update status info in database // status info
	public function temp_to_primary_all() {
		/* Define return | here result is used to return user data and error for error message */
		// $status_id = $this->uri->segment(4);

		$upload_id = $this->uri->segment(4);



		$tempEmployees = $this->Import_model->get_temp_employees($upload_id);

		for($i=0; $i< count($tempEmployees); $i++){



				$user = $this->Xin_model->read_employee_temp_info($tempEmployees[$i]->secid);
				$duplicate = $this->Employees_model->read_employee_info_by_nik($user[0]->employee_id);


					if(!is_null($duplicate)) {
						// $error = 'Error';

						$datas = array(
							'status_error' => 'Duplicate',
						);

						$this->Employees_model->update_error_temp($datas, $user[0]->secid);

					} else {
						

						$employee_id 				= $user[0]->employee_id;
						$fullname 					= $user[0]->fullname;
						$email 							= $user[0]->email;
						$date_of_birth 			= $user[0]->date_of_birth;
						$tempat_lahir				= $user[0]->tempat_lahir;
						$gender 						= $user[0]->gender;
						$department_id 			= $user[0]->department_id;
						$designation_id 		= $user[0]->designation_id;
						$project_id 				= $user[0]->project_id;
						$sub_project_id 		= $user[0]->sub_project_id;
						$company_id 				= $user[0]->company_id;
						$location_id 				= $user[0]->location_id;
						$penempatan 				= $user[0]->penempatan;
						$date_of_joining 		= $user[0]->date_of_joining;
						$marital_status 		= $user[0]->marital_status;
						$alamat_ktp 						= $user[0]->alamat_ktp;
						$alamat_domisili		= $user[0]->alamat_domisili;
						$contact_no 				= $user[0]->contact_no;
						$ktp_no 						= $user[0]->ktp_no;
						$kk_no 							= $user[0]->kk_no; 
						$npwp_no 						= $user[0]->npwp_no;
						$bpjs_tk_no 				= $user[0]->bpjs_tk_no;
						$bpjs_ks_no 				= $user[0]->bpjs_ks_no;
						$ibu_kandung				= $user[0]->ibu_kandung;
						$bank_name					= $user[0]->bank_name;
						$nomor_rek					= $user[0]->nomor_rek;
						$pemilik_rek				= $user[0]->pemilik_rek;
						$basic_salary				= $user[0]->basic_salary;
						$private_code = rand(100000,999999);
						$options = array('cost' => 12);
						$password_hash = password_hash($private_code, PASSWORD_BCRYPT, $options);

						$data = array(
							'employee_id' 		=> $employee_id,
							'username' 				=> $employee_id,
							'first_name' 			=> $fullname,
							'password' 				=> $password_hash,
							'gender' 					=> $gender,
							'user_role_id' 		=> 2,
							'department_id' 	=> $department_id,
							'designation_id' 	=> $designation_id,
							'project_id' 			=> $project_id,
							'sub_project_id' 	=> $sub_project_id,
							'company_id' 			=> $company_id,
							'location_id' 		=> $location_id,
							'penempatan'			=> $penempatan,
							'tempat_lahir'		=> $tempat_lahir,
							'date_of_birth' 	=> $date_of_birth,
							'date_of_joining' => $date_of_joining,
							'marital_status' 	=> $marital_status,
							'alamat_ktp' 			=> $alamat_ktp,
							'alamat_domisili'	=> $alamat_domisili,
							'contact_no' 			=> $contact_no,
							'email' 					=> $email,
							'kk_no' 					=> $kk_no,
							'ktp_no' 					=> $ktp_no,
							'npwp_no' 				=> $npwp_no,
							'bpjs_tk_no' 			=> $bpjs_tk_no,
							'bpjs_ks_no' 			=> $bpjs_ks_no,
							'ibu_kandung'			=> $ibu_kandung,
							'bank_name'				=> $bank_name,
							'nomor_rek'				=> $nomor_rek,
							'pemilik_rek'			=> $pemilik_rek,
							'basic_salary'		=> $basic_salary,
							'is_active' 			=> 1,
							'private_code' 		=> $private_code,
							'created_by' 			=> $session['user_id'],
						);

						//$id = $this->input->post('user_id');
						$this->Employees_model->add($data);

						$datas = array(
							'status_error' => 'Success Import',
						);

						$this->Employees_model->update_error_temp($datas, $user[0]->secid);
		}

				//$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
				echo $user[0]->employee_id.' '.$this->lang->line('xin_employee_status_updated');

			}

		//$this->output($Return);
		//exit;
	}


} 
?>
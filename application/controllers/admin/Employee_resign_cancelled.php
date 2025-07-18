<?php
  /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author TRAXES
 * @author-email  support@traxes.id
 * @copyright  Copyright traxes.id
 */
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Employee_resign_cancelled extends MY_Controller {
	
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
		$this->load->library('wablas');
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
		$data['title'] = 'Pengajuan Paklaring | '.$this->Xin_model->site_title();
			$data['all_projects'] = $this->Project_model->get_all_projects();
			$data['all_projects_sub'] = $this->Project_model->get_all_projects();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = 'PENGAJUAN PAKLARING DITOLAK';
		$data['path_url'] = 'emp_resign_cancel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('506',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/resign_list_cancelled", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }

	public function resign_list_cancel() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/resign_list_cancelled", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_monitoring_rsign_nae();
		$employee = $this->Employees_model->get_monitoring_rsign_cancel($session['employee_id']);

		$data = array();

          foreach($employee->result() as $r) {
			  
				$project = $r->project_id;
				$nip = $r->employee_id;
				$fullname = $r->first_name;
				$posisi = $r->designation_id;
				$date_of_leaving = $r->date_of_leaving;
				$ktp_no = $r->ktp_no;
				$penempatan = $r->penempatan;
				$cancel_ket = $r->cancel_ket;
				$approve_resignnae = $r->approve_resignnae;

				if(is_null($approve_resignnae) || $approve_resignnae=='0'){

			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->user_id . '">Need Revisi</button>';
				} else {
					
			  	$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-info" data-toggle="modal" data-target=".edit-modal-data" data-company_id="'. $r->user_id . '">Need Revisi</button>';
				}

				if($r->status_resign==2){
					$status_name = 'RESIGN';
				} else if ($r->status_resign==3){
					$status_name = 'BAD ATITUDE';
				} else if ($r->status_resign==4){
					$status_name = 'END CONTRACT';
				} else {
					$status_name = 'Undefined';
				}


				if(is_null($r->dok_exit_clearance)) {
					$vexc = '';
				} else {

					$nama_file_exit = $r->dok_exit_clearance;
					//kalau blm ada folder path nya
					if (file_exists($nama_file_exit)) {
						// $pesan = "ada file"; //tampil file skema terbaru
							$vexc = '<a href="'.base_url().$nama_file_exit.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					} else {
							$vexc = '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_exit.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					}
				}

				if(is_null($r->dok_resign_letter)) {
					$vsrs = '';
				} else {

					$nama_file_sresign = $r->dok_resign_letter;
					//kalau blm ada folder path nya
					if (file_exists($nama_file_sresign)) {
						// $pesan = "ada file"; //tampil file skema terbaru
							$vsrs = '<a href="'.base_url().$nama_file_sresign.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					} else {
							$vsrs = '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_sresign.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					}
				}


				if(is_null($r->dok_over_hand)) {
					$vhov = '';
				} else {

					$nama_file_overh = $r->dok_over_hand;
					//kalau blm ada folder path nya
					if (file_exists($nama_file_overh)) {
						// $pesan = "ada file"; //tampil file skema terbaru
							$vhov = '<a href="'.base_url().$nama_file_overh.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					} else {
							$vhov = '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_overh.'" target="_blank"> <img id="myImg" style="width: 30px;" src="'.base_url().'uploads/logo/icon_document.png"></a>';
					}
				}

				$projects = $this->Project_model->read_single_project($r->project_id);
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

				$designation = $this->Designation_model->read_designation_information($r->designation_id);
				if(!is_null($designation)){
					$designation_name = $designation[0]->designation_name;
				} else {
					$designation_name = '--';	
				}

				$dok_p = $vexc.' '.$vsrs.' '.$vhov;

			$data[] = array(
				$status_migrasi,
				$nip,
				$fullname,
				$nama_project,
				$designation_name,
				$date_of_leaving,
				$penempatan,
				$ktp_no,
				'['.$status_name.']<br> <p style="background-color: #ff4f4f; color: white; padding-right: 5px; padding-left: 5px;">'.$cancel_ket.'</p>',
				$dok_p,
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


	//load datatables Employee
	public function resign_list_cancel2()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Employees_model->list_resign_cancel($postData);

		echo json_encode($data);
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
			$system = $this->Xin_model->read_setting_info(1);

				if($this->input->post('fullname')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_first_name');
				} else if ($this->input->post('office_lokasi')=='') {
					$Return['error'] = $this->lang->line('xin_employee_error_location_office');
				} else if ($this->input->post('project_id')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_project');
				} else if ($this->input->post('sub_project')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_sub_project');
				} else if ($this->input->post('department_id')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_department');
				} else if ($this->input->post('posisi')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_designation');
				} else if ($this->input->post('date_of_join')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_joining_date');
				} else if ($this->input->post('nomor_hp')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
				} else if ($this->input->post('nomor_ktp')==''){
					$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
				}

					if($Return['error']!=''){
					$this->output($Return);
			    }
			}

		   	$fullname = $this->Xin_model->clean_post($this->input->post('fullname'));
				$office_lokasi = $this->input->post('office_lokasi');
				$project_id = $this->input->post('project_id');
				$sub_project_id = $this->input->post('sub_project');
				$department_id = $this->input->post('department_id');
				$posisi = $this->input->post('posisi');
				$date_of_join = $this->input->post('date_of_join');
				$contact_no = $this->input->post('nomor_hp');
				$ktp_no = $this->input->post('nomor_ktp');
				
			// $options = array('cost' => 12);
			// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			// $leave_categories = array($this->input->post('leave_categories'));
			// $cat_ids = implode(',',$this->input->post('leave_categories'));

			$data = array(
				'fullname' => $fullname,
				'location_id' => $office_lokasi,
				'project' => $project_id,
				'sub_project' => $sub_project_id,
				'department' => $department_id,
				'posisi' => $posisi,
				'doj' => $date_of_join,
				'contact_no' => $contact_no,
				'nik_ktp' => $ktp_no,
				// 'pincode' => $this->input->post('pin_code'),
				// 'createdon' => date('Y-m-d h:i:s'),
				'createdby' => $session['user_id']
			);

			$iresult = $this->Employees_model->addrequest($data);
			if ($iresult) {
					$Return['result'] = $this->lang->line('xin_success_add_employee');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
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
		$result = $this->Employees_model->read_employee_info($id);
		$data = array(
				'idrequest' => $result[0]->user_id,
				'nip' => $result[0]->employee_id,
				'nik_ktp' => $result[0]->ktp_no,
				'fullname' => $result[0]->first_name,
				'dok_exit_clearance' => $result[0]->dok_exit_clearance,
				'dok_resign_letter' => $result[0]->dok_resign_letter,
				'dok_over_hand' => $result[0]->dok_over_hand,
				'project' => $this->Project_model->read_project_information($result[0]->project_id),
				'posisi' => $this->Designation_model->read_designation_information($result[0]->designation_id),
				'doj' => $result[0]->date_of_joining,
				'contact_no' => $result[0]->contact_no,
				'info_revisi' => $result[0]->cancel_ket,
				'cancel_date' => $result[0]->cancel_date,
				'status_resign' => $result[0]->status_resign,
				'alamat_ktp' => $result[0]->alamat_ktp,
				'penempatan' => $result[0]->penempatan,
				'request_by' => $this->Employees_model->read_employee_info($result[0]->request_resign_by),
				'request_resign_date' => $result[0]->request_resign_date,
				'approve_nae' => $this->Employees_model->read_employee_info($result[0]->approve_resignnae),
				'approve_resignnae_on' => $result[0]->approve_resignnae_on,
				'approve_nom' => $this->Employees_model->read_employee_info($result[0]->approve_resignnom),
				'approve_resignnom_on' => $result[0]->approve_resignnom_on,
				'approve_hrd' => $this->Employees_model->read_employee_info($result[0]->approve_resignhrd),
				'approve_resignhrd_on' => $result[0]->approve_resignhrd_on,

				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_resign_cancel', $data);
	}

	public function read_document() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('document_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_document_info($id);
		$data = array(
				'document_id' => $result[0]->document_id,
				'license_name' => $result[0]->license_name,
				'document_type_id' => $result[0]->document_type_id,
				'company_id' => $result[0]->company_id,
				'expiry_date' => $result[0]->expiry_date,
				'license_number' => $result[0]->license_number,
				'license_notification' => $result[0]->license_notification,
				'document' => $result[0]->document,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_document_types' => $this->Employees_model->all_document_types(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/dialog_official_document', $data);
	}

	public function read_info()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_information($id);
		$data = array(
				'company_id' => $result[0]->company_id,
				'name' => $result[0]->name,
				'username' => $result[0]->username,
				'password' => $result[0]->password,
				'type_id' => $result[0]->type_id,
				'government_tax' => $result[0]->government_tax,
				'trading_name' => $result[0]->trading_name,
				'registration_no' => $result[0]->registration_no,
				'email' => $result[0]->email,
				'logo' => $result[0]->logo,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'idefault_currency' => $result[0]->default_currency,
				'idefault_timezone' => $result[0]->default_timezone,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/view_company.php', $data);
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



		/* Server side PHP input validation */		
		// if($this->input->post('title')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		// } else 
		if($_FILES['dok_exitc']['size'] == 0) {
			$fnameExit = $this->input->post('dexitc');
		} else {
			if(is_uploaded_file($_FILES['dok_exitc']['tmp_name'])) {
				//checking image type

				$yearmonth = date('Y/m');
				$allowed =  array('pdf','PDF');
				$filename = $_FILES['dok_exitc']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["dok_exitc"]["tmp_name"];
					$documentd = "uploads/document/exit/".$yearmonth.'/';

                //kalau blm ada folder path nya
                if (!file_exists($documentd)) {
                    mkdir($documentd, 0777, true);
                }

					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["dok_exitc"]["name"]);
					$newfilename = 'document_exc_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fnameExit = $documentd.$newfilename;
				} else {
					$Return['error'] = 'Jenis File Exit Clearance tidak diterima..';
				}
			}
		}
	

		/* Check if file uploaded..*/
		if($_FILES['dok_sresign']['size'] == 0) {
			$fname_sresign = $this->input->post('dsresign');
		} else {
			if(is_uploaded_file($_FILES['dok_sresign']['tmp_name'])) {
				//checking image type
				$yearmonth = date('Y/m');
				$allowed_kk =  array('pdf','PDF');
				$filename_kk = $_FILES['dok_sresign']['name'];
				$ext_kk = pathinfo($filename_kk, PATHINFO_EXTENSION);
				
				if(in_array($ext_kk,$allowed_kk)) {
					$tmp_name_sresign = $_FILES["dok_sresign"]["tmp_name"];
					$documentd_sresign = "uploads/document/resign/".$yearmonth.'/';

                //kalau blm ada folder path nya
                if (!file_exists($documentd_sresign)) {
                    mkdir($documentd_sresign, 0777, true);
                }

					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["dok_sresign"]["name"]);
					$newfilename_resign = 'kk_'.round(microtime(true)).'.'.$ext_kk;
					move_uploaded_file($tmp_name_sresign, $documentd_sresign.$newfilename_resign);
					$fname_sresign = $documentd_sresign.$newfilename_resign;
				} else {
					$Return['error'] = 'Jenis File SURAT RESIGN tidak diterima..';
				}
			}
		}

		if($Return['error']!=''){
       		$this->output($Return);
    	}

			$data_up = array(
									'dok_exit_clearance' => $fnameExit,
									'dok_resign_letter' => $fname_sresign,
									'cancel_resign_stat' =>  0
			);


			$result = $this->Employees_model->update_resign_apnae($data_up,$id);

			if ($result == TRUE) {
					$Return['result'] = "Revisi Karyawan Resign sudah dibuat.";
			} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
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

	public function get_data_diri()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'employee_id'        => $postData['nip']
		];

		// get data diri
		$data = $this->Employees_model->get_data_diri($datarequest);

		if (empty($data)) {
			$response = array(
				'status'	=> "201",
				'pesan' 	=> "Karyawan tidak ditemukan",
			);
		} else {
			//nama status resign
			if ($data['status_resign'] == "1") {
				$status_resign_name = "AKTIF";
			} else if ($data['status_resign'] == "2") {
				$status_resign_name = "RESIGN";
			} else if ($data['status_resign'] == "3") {
				$status_resign_name = "BLACKLIST";
			} else if ($data['status_resign'] == "4") {
				$status_resign_name = "END CONTRACT";
			} else if ($data['status_resign'] == "5") {
				$status_resign_name = "RESIGN";
			} else {
				$status_resign_name = "";
			}

			//deactive date
			$deactive_date_seed = "";
			if ((empty($data['date_resign_request'])) || ($data['date_resign_request'] == "")) {
				$deactive_date_text = "";
			} else {
				$deactive_date_array = explode(" ", $data['date_resign_request']);
				$deactive_date_seed = $deactive_date_array[0];
				// $deactive_date_seed = $data['date_resign_request'];

				if(count($deactive_date_array) == "1"){
					$deactive_date_text = $this->Xin_model->tgl_indo($deactive_date_array[0]);
				} else {
					$deactive_date_text = $this->Xin_model->tgl_indo($deactive_date_array[0]) . " " . $deactive_date_array[1];
				}
			}

			$data2 = array(
				'employee_id'		=> $data['employee_id'],
				'first_name'		=> $data['first_name'],
				'gender'			=> $data['gender'],
				'tempat_lahir'		=> $data['tempat_lahir'],
				'date_of_birth'		=> $data['date_of_birth'],
				'last_edu'			=> $data['last_edu'],
				'edu_school_name'	=> $data['edu_school_name'],
				'edu_prodi_name'	=> $data['edu_prodi_name'],
				'ethnicity_type'	=> $data['ethnicity_type'],
				'marital_status'	=> $data['marital_status'],
				'tinggi_badan'		=> $data['tinggi_badan'],
				'berat_badan'		=> $data['berat_badan'],
				'blood_group'		=> $data['blood_group'],

				'ktp_no'			=> $data['ktp_no'],
				'kk_no'				=> $data['kk_no'],
				'npwp_no'			=> $data['npwp_no'],
				'contact_no'		=> $data['contact_no'],
				'email'				=> $data['email'],
				'ibu_kandung'		=> $data['ibu_kandung'],
				'alamat_ktp'		=> $data['alamat_ktp'],
				'alamat_domisili'	=> $data['alamat_domisili'],

				'project_id'				=> $this->Employees_model->get_nama_project($data['project_id']),
				'project_sub_id'		=> $this->Employees_model->get_nama_sub_project($data['sub_project_id']),
				'designation_id'		=> $this->Employees_model->get_nama_jabatan($data['designation_id']),
				'penempatan'				=> $data['penempatan'],
				'cancel_ket'				=> $data['cancel_ket'],

				'bank_name'			=> $data['bank_name'],
				'nomor_rek'			=> $data['nomor_rek'],
				'pemilik_rek'		=> $data['pemilik_rek'],

				'request_resign_by'	=> $this->Employees_model->get_nama_karyawan_by_id($data['request_resign_by']).' ('.$data['request_resign_date'].')',
				'approve_resignnae'	=> $this->Employees_model->get_nama_karyawan_by_id($data['approve_resignnae']).' ('.$data['approve_resignnae_on'].')',
				'approve_resignnom'	=> $this->Employees_model->get_nama_karyawan_by_id($data['approve_resignnom']).' ('.$data['approve_resignnom_on'].')',
				'approve_resignhrd'	=> $this->Employees_model->get_nama_karyawan_by_id($data['approve_resignhrd']).' ('.$data['approve_resignhrd_on'].')',

				'status_resign'		=> $data['status_resign'],
				'status_resign_name' => $status_resign_name,
				'deactive_by'		=> $data['deactive_by'],
				'deactive_by_name'	=> $this->Employees_model->get_nama_karyawan_by_id($data['deactive_by']),
				'deactive_date'		=> $data['deactive_date'],
				'deactive_date_seed' => $deactive_date_seed,
				// 'deactive_date_seed' => '12-12-2025',
				'deactive_date_text' => $deactive_date_text,
				'deactive_reason'	=> $data['deactive_reason'],
			);

			$response = array(
				'status'	=> "200",
				'pesan' 	=> "Berhasil Fetch Data",
				'data'		=> $data2,
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}


	//accept request open lock saltab
	public function save_revisi_paklaring()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Employees_model->save_revisi_resign_cancel($postData);

		echo json_encode($data);
	}


	// upload addendum
	public function UpdateRevisiCancel()
	{


			$nip_post 		= $this->input->post('nip_modal');
			$status_post 	= $this->input->post('status_resign_modal');
		$pesan_error = "";
		if ($_FILES['file_dokumen_exc']['error'] == "0") {

			//parameter untuk path dokumen
			$yearmonth = date('Y/m');
			$path_exitclerance = "./uploads/document/exit/" . $yearmonth . '/';

			//kalau blm ada folder path nya
			if (!file_exists($path_exitclerance)) {
				mkdir($path_exitclerance, 0777, true);
			}

			$nip_post = $this->input->post('nip_modal');
			$file_signed_time_post = "2024-12-17 15:33:00";

			//konfigurasi upload
			$config['upload_path']          	= $path_exitclerance;
			$config['allowed_types']        	= 'pdf';
			$config['max_size']             	= 3072;
			$config['file_name']             	= 'exitclerance_' . $nip_post . '_' . round(microtime(true));
			$config['overwrite']             	= TRUE;

			//inisialisasi proses upload
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			//upload data kalau tidak ada error
			if (!$this->upload->do_upload('file_dokumen_exc')) {
				$error = array('error' => $this->upload->display_errors());
				//$data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
				if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
					$pesan_error = "Dokumen Exitclearance melebihi ukuran 3 MB. Silahkan upload ulang";
				} else {
					$pesan_error = "Hanya menerima file berformat PDF";
				}
			} else {
				//save path ktp ke database
				$new_filename_exitclearance = $this->upload->data('file_name');
				$exitclearance_database = $yearmonth . '/' . $new_filename_exitclearance;
				$this->Employees_model->updateExit($nip_post, $exitclearance_database, $file_signed_time_post);
				$data = array('upload_data' => $this->upload->data());
			}

			//print_r($_FILES['document_file_addendum']);
			echo $pesan_error;
		} else {
			$pesan_error = "Tidak ada file yang dipilih";
			//print_r($_FILES['document_file_addendum']);
			echo $pesan_error;
		}


	}


}

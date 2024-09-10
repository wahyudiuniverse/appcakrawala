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
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Reports extends MY_Controller
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
		//load the login model
		//load the login model
		$this->load->model('Xin_model');
		$this->load->model("Employees_model");
		$this->load->model('Customers_model');
		$this->load->model('Company_model');
		$this->load->model('Exin_model');
		$this->load->model('Department_model');
		$this->load->model('Payroll_model');
		$this->load->model('Reports_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Training_model');
		$this->load->model('Trainers_model');
		$this->load->model("Project_model");
		$this->load->model("Roles_model");
		$this->load->model("Designation_model");
		$this->load->model("Pkwt_model");
		$this->load->model("Bpjs_model");
	}

	// reports
	public function index()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_report_employees') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'reports_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('117', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// payslip reports > employees and company
	public function payslip()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_payslip') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_payslip');
		$data['path_url'] = 'reports_payslip';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('111', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/payslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// projects report
	public function projects()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_projects') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_projects');
		$data['path_url'] = 'reports_project';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('114', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// tasks report
	public function tasks()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_tasks') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_tasks');
		$data['path_url'] = 'reports_task';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('115', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/tasks", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// roles/privileges report
	public function roles()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_user_roles_report') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_user_roles_report');
		$data['path_url'] = 'reports_roles';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('116', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/roles", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// employees report
	public function employees()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_report_employees') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'reports_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('117', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// employees report
	public function manage_employees()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_manage_employees') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_manage_employees');
		$data['path_url'] = 'reports_man_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('470', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/manage_employees2", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//load datatables Employee
	public function list_employees()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Employees_model->get_list_employees($postData);

		echo json_encode($data);
	}


	public function report_manage_employees_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/manage_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);

		$project_id = $this->uri->segment(6);
		$subproject_id = $this->uri->segment(7);
		$status_resign = $this->uri->segment(8);


		// $designation_id = $this->uri->segment(6);

		if ($project_id == 0 || is_null($project_id)) {

			$employee = $this->Reports_model->filter_employees_reports_null($company_id, $department_id, $project_id, $subproject_id, $status_resign);
		} else {

			$employee = $this->Reports_model->filter_employees_reports($project_id, $subproject_id, $status_resign);
		}

		$data = array();

		foreach ($employee->result() as $r) {

			$full_name = $r->first_name . ' ' . $r->last_name;
			$company = $this->Xin_model->read_company_info($r->company_id);
			if (!is_null($company)) {
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';
			}

			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}

			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if (!is_null($project)) {
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';
			}

			$subproject = $this->Project_model->read_single_subproject($r->sub_project_id);
			if (!is_null($subproject)) {
				$subproject_name = $subproject[0]->sub_project_name;
			} else {
				$subproject_name = '--';
			}

			// $agama = '--';
			$ethnicity = $this->Employees_model->read_ethnicity($r->ethnicity_type);
			if (!is_null($ethnicity)) {
				$agama = $ethnicity[0]->type;
			} else {
				$agama = '--';
			}

			$banklist = $this->Xin_model->read_bank_info($r->bank_name);
			if (!is_null($banklist)) {
				$bank_name = $banklist[0]->bank_name;
			} else {
				$bank_name = '--';
			}

			$readPkwt = $this->Pkwt_model->read_pkwt_emp($r->employee_id);
			if (!is_null($readPkwt)) {
				if ($r->level == "D2" || $r->level == "E1" || $r->level == "E2") {
					$basicpay 		= $readPkwt[0]->basic_pay;
				} else {
					$basicpay 		= "******";
				}
				$start_kontrak 	= $this->Xin_model->tgl_excel($readPkwt[0]->from_date);
				$end_kontrak 	= $this->Xin_model->tgl_excel($readPkwt[0]->to_date);
				$pkwt_files 	= $readPkwt[0]->file_name;
				$pkwt_tanggal	= $readPkwt[0]->upload_pkwt;
			} else {

				$basicpay = '0';
				$start_kontrak 	= '0';
				$end_kontrak 	= '0';
				$pkwt_files 	= '0';
				$pkwt_tanggal	= '-';
			}


			if (!is_null($r->last_edu)) {
				if ($r->last_edu == '1') {
					$education = 'Sekolah Dasar (SD)';
				} else if ($r->last_edu == '2') {
					$education = 'Sekolah Menengah Pertama (SMP/MTS)';
				} else if ($r->last_edu == '3') {
					$education = 'Sekolah Menengah Atas (SMA/SMK/MA)';
				} else if ($r->last_edu == '4') {
					$education = 'Diploma (D1,D2,D3)';
				} else if ($r->last_edu == '5') {
					$education = 'Strata 1 (S1)';
				} else if ($r->last_edu == '6') {
					$education = 'Strata 2 (S2)';
				} else if ($r->last_edu == '7') {
					$education = 'Strata 3 (S3)';
				} else {
					$education = '-';
				}
			} else {
				$education = '--';
			}


			if (!is_null($r->gender)) {
				$gender = $r->gender;
			} else {
				$gender = '--';
			}

			if (!is_null($r->marital_status)) {
				if ($r->marital_status == '1') {
					$marital = 'TK/0';
				} else if ($r->marital_status == '2') {
					$marital = 'TK/0';
				} else if ($r->marital_status == '3') {
					$marital = 'TK/1';
				} else if ($r->marital_status == '4') {
					$marital = 'TK/2';
				} else if ($r->marital_status == '5') {
					$marital = 'TK/3';
				} else if ($r->marital_status == '6') {
					$marital = 'K/0';
				} else if ($r->marital_status == '7') {
					$marital = 'K/1';
				} else if ($r->marital_status == '8') {
					$marital = 'K/2';
				} else if ($r->marital_status == '9') {
					$marital = 'K/3';
				} else {
					$marital = '--';
				}
			} else {
				$marital = '--';
			}

			if ($r->date_of_birth != '' || !is_null($r->date_of_birth)) {
				$dob = $this->Xin_model->tgl_indo($r->date_of_birth);
			} else {
				$dob = '--';
			}

			if ($r->date_of_joining != '' || !is_null($r->date_of_joining)) {
				$doj = $this->Xin_model->tgl_excel($r->date_of_joining);
			} else {
				$doj = '--';
			}

			if ($r->date_of_leaving != '' || !is_null($r->date_of_leaving)) {
				// $dol = $r->date_of_leaving;
				$dol = $this->Xin_model->tgl_indo($r->date_of_leaving);
			} else {
				$dol = '--';
			}

			if (!is_null($r->email)) {
				$email = $r->email;
			} else {
				$email = '--';
			}

			if (!is_null($r->contact_no)) {
				$kontak = $r->contact_no;
			} else {
				$kontak = '--';
			}

			if (!is_null($r->alamat_ktp)) {
				$alamat_ktp = $r->alamat_ktp;
			} else {
				$alamat_ktp = '--';
			}

			if (!is_null($r->alamat_domisili)) {
				$alamat_domisili = $r->alamat_domisili;
			} else {
				$alamat_domisili = '--';
			}

			if (!is_null($r->bpjs_tk_no)) {
				$bpjstk = $r->bpjs_tk_no;
			} else {
				$bpjstk = '--';
			}

			if (!is_null($r->bpjs_ks_no)) {
				$bpjsks = $r->bpjs_ks_no;
			} else {
				$bpjsks = '--';
			}

			if (!is_null($r->ibu_kandung)) {
				$ibu = $r->ibu_kandung;
			} else {
				$ibu = '--';
			}

			if (!is_null($r->penempatan)) {
				$penempatan = $r->penempatan;
			} else {
				$penempatan = '--';
			}

			if (!is_null($r->tempat_lahir)) {
				$tempat_lahir = $r->tempat_lahir;
			} else {
				$tempat_lahir = '--';
			}


			if ($r->password_change == 0 || $r->project_id != '22' || $r->project_id != '95') {

				$pin = $r->private_code;
			} else {
				$pin = '******';
			}

			if ($r->filename_ktp == '0' || $r->filename_ktp == null) {
				$link_ktp = '-';
			} else {
				$link_ktp = '<a href="' . base_url() . 'uploads/document/ktp/' . $r->filename_ktp . '" target="_blank"> ' . base_url() . 'uploads/document/ktp/' . $r->filename_ktp . '</a>';
			}

			if ($r->filename_kk == '0' || $r->filename_kk == null) {
				$link_kk = '-';
			} else {
				$link_kk = '<a href="' . base_url() . 'uploads/document/kk/' . $r->filename_kk . '" target="_blank"> ' . base_url() . 'uploads/document/kk/' . $r->filename_kk . '</a>';
			}

			if ($r->filename_npwp == '0' || $r->filename_npwp == null) {
				$link_npwp = '-';
			} else {
				$link_npwp = '<a href="' . base_url() . 'uploads/document/npwp/' . $r->filename_npwp . '" target="_blank"> ' . base_url() . 'uploads/document/npwp/' . $r->filename_npwp . '</a>';
			}

			if ($r->filename_isd == '0' || $r->filename_isd == null) {
				$link_isd = '-';
			} else {
				$link_isd = '<a href="' . base_url() . 'uploads/document/ijazah/' . $r->filename_isd . '" target="_blank"> ' . base_url() . 'uploads/document/ijazah/' . $r->filename_isd . '</a>';
			}

			if ($r->filename_skck == '0' || $r->filename_skck == null) {
				$link_skck = '-';
			} else {
				$link_skck = '<a href="' . base_url() . 'uploads/document/skck/' . $r->filename_skck . '" target="_blank"> ' . base_url() . 'uploads/document/skck/' . $r->filename_skck . '</a>';
			}

			if ($r->filename_cv == '0' || $r->filename_cv == null) {
				$link_cv = '-';
			} else {
				$link_cv = '<a href="' . base_url() . 'uploads/document/cv/' . $r->filename_cv . '" target="_blank"> ' . base_url() . 'uploads/document/cv/' . $r->filename_cv . '</a>';
			}

			if ($r->filename_paklaring == '0' || $r->filename_paklaring == null) {
				$link_paklaring = '-';
			} else {
				$link_paklaring = '<a href="' . base_url() . 'uploads/document/paklaring/' . $r->filename_paklaring . '" target="_blank"> ' . base_url() . 'uploads/document/paklaring/' . $r->filename_paklaring . '</a>';
			}

			$ktp = $r->ktp_no;
			$kk = $r->kk_no;
			$npwp = $r->npwp_no;
			$nomor_rek = $r->nomor_rek;
			// $bank_name = $r->bank_name;
			$pemilik_rek = $r->pemilik_rek;

			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="' . $this->lang->line('xin_edit') . '"><a href="' . site_url() . 'admin/employees/emp_edit/' . $r->employee_id . '" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';

			if ($r->status_resign == 2) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">RESIGN</button>';
			} else if ($r->status_resign == 3) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-danger">BLACKLIST</button>';
			} else if ($r->status_resign == 4) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-info">END CONTRACT</button>';
			} else if ($r->status_resign == 5) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-secondary">NON ACTIVE</button>';
			} else if ($r->status_resign == 6) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-secondary">NON ACTIVE</button>';
			} else {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-success">ACTIVE</button>';
			}


			// if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			// elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;

			$role_resources_ids = $this->Xin_model->user_role_resource();

			if (in_array('471', $role_resources_ids) || in_array('472', $role_resources_ids) || in_array('473', $role_resources_ids)) {
				$edits = $edit . ' ' . $stat;
			} else {
				$edits = $stat;
			}


			if (!is_null($pkwt_files) || $pkwt_files != 0) {

				$file_pkwt = '<a href="' . $pkwt_files . '" target="_blank">
					<button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"> PKWT </button>
				</a>';
			} else {
				$file_pkwt = '-';
			}


			$data[] = array(
				$edits,
				$r->employee_id,
				strtoupper($full_name),
				$pin,
				$comp_name,
				$department_name,
				$designation_name,
				$project_name,
				$subproject_name,
				$penempatan, // AREA
				$r->region,
				$tempat_lahir, // TEMPAT LAHIR
				$dob,
				$doj,

				$start_kontrak,
				$end_kontrak,
				$basicpay,
				$dol,
				$gender,
				$marital,
				$agama, // agama
				$email,
				$kontak,
				$education,
				$alamat_ktp,
				$alamat_domisili,
				"'" . $kk,
				"'" . $ktp,
				$npwp,
				$bpjstk,
				$bpjsks,
				$ibu,
				$bank_name,
				"'" . $nomor_rek,
				$pemilik_rek,
				$link_ktp,
				$link_kk,
				$link_npwp,
				$link_isd,
				$link_skck,
				$link_cv,
				$link_paklaring,
				$file_pkwt,
				$pkwt_tanggal

				// $pin
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


	// employees report
	public function skk_report()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_sk_report') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_sk_report');
		$data['path_url'] = 'reports_skk';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
			// $data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('470', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/skk_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// employees report
	public function bpjs_employees()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_emp_bpjs') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_emp_bpjs');
		$data['path_url'] = 'reports_bpjs_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}

		$data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('476', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/bpjs_employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// employees report
	public function pkwt()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_employees') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'pkwt_request';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_projects'] = $this->Project_model->get_project_exist();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('376', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_request_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	public function report_employees_list_pkwt()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);

		$project_id = $this->uri->segment(6);
		$subproject_id = $this->uri->segment(7);

		// $designation_id = $this->uri->segment(6);
		if ($company_id == 0 || is_null($company_id)) {

			$employee = $this->Pkwt_model->filter_employees_reports_none($company_id, $department_id, $project_id, $subproject_id);
		} else {

			$employee = $this->Pkwt_model->filter_employees_reports($company_id, $department_id, $project_id, $subproject_id);
		}
		$data = array();

		foreach ($employee->result() as $r) {

			$nopkwt = '[autogenerate]';
			$nospb = '[autogenerate]';
			$nip = $r->employee_id;
			$full_name = $r->first_name . ' ' . $r->last_name;

			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}

			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if (!is_null($project)) {
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';
			}

			$data[] = array(
				$nopkwt,
				$nopkwt,
				$nip,
				$full_name,
				$designation_name,
				$project_name,
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'YYYY-MM-DD',
				'YYYY-MM-DD',
				'YYYY-MM-DD',
				'',
				''
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

	public function report_employees_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);
		$project_id = $this->uri->segment(6);
		$subproject_id = $this->uri->segment(7);
		$status_resign = $this->uri->segment(8);


		if ($company_id == 0 || is_null($company_id)) {
			$employee = $this->Reports_model->filter_employees_reports_null($company_id, $department_id, $project_id, $subproject_id, $status_resign);
		} else {
			$employee = $this->Reports_model->filter_employees_reports($company_id, $department_id, $project_id, $subproject_id, $status_resign);
		}

		$data = array();

		foreach ($employee->result() as $r) {

			$full_name = $r->first_name . ' ' . $r->last_name;
			$company = $this->Xin_model->read_company_info($r->company_id);
			if (!is_null($company)) {
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';
			}

			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}

			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if (!is_null($project)) {
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';
			}

			$subproject = $this->Project_model->read_single_subproject($r->sub_project_id);
			if (!is_null($subproject)) {
				$subproject_name = $subproject[0]->sub_project_name;
			} else {
				$subproject_name = '--';
			}


			if (!is_null($r->gender)) {
				$gender = $r->gender;
			} else {
				$gender = '--';
			}

			if (!is_null($r->marital_status)) {
				$marital = $r->marital_status;
			} else {
				$marital = '--';
			}

			if (!is_null($r->date_of_birth)) {
				$dob = $r->date_of_birth;
			} else {
				$dob = '--';
			}

			if (!is_null($r->date_of_joining)) {
				$doj = $r->date_of_joining;
			} else {
				$doj = '--';
			}
			if (!is_null($r->email)) {
				$email = $r->email;
			} else {
				$email = '--';
			}
			if (!is_null($r->contact_no)) {
				$kontak = $r->contact_no;
			} else {
				$kontak = '--';
			}

			if (!is_null($r->address)) {
				$alamat = $r->address;
			} else {
				$alamat = '--';
			}


			if (!is_null($r->kk_no)) {
				$kk = $r->kk_no;
			} else {
				$kk = '--';
			}

			if (!is_null($r->ktp_no)) {
				$ktp = $r->ktp_no;
			} else {
				$ktp = '--';
			}

			if (!is_null($r->npwp_no)) {
				$npwp = $r->npwp_no;
			} else {
				$npwp = '--';
			}

			if (!is_null($r->private_code)) {
				$pin = $r->private_code;
			} else {
				$pin = '--';
			}

			if ($r->status_resign == 2) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">RESIGN</button>';
			} else if ($r->status_resign == 3) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-danger">BLACKLIST</button>';
			} else if ($r->status_resign == 4) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-info">END CONTRACT</button>';
			} else if ($r->status_resign == 5) {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-warning">NON ACTIVE</button>';
			} else {
				$stat = '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-outline-success">ACTIVE</button>';
			}

			// get status
			if ($r->is_active == 0) : $status = $this->lang->line('xin_employees_inactive');
			elseif ($r->is_active == 1) : $status = $this->lang->line('xin_employees_active');
			endif;

			$data[] = array(
				$stat,
				$r->employee_id,
				$full_name,
				$comp_name,
				$department_name,
				$designation_name,
				$project_name,
				$subproject_name,
				$gender,
				$marital,
				$this->Xin_model->tgl_indo($dob),
				$this->Xin_model->tgl_indo($doj),
				$email,
				$kontak,
				$alamat,
				$kk,
				$ktp,
				$npwp,
				$pin
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




	// get company > departments
	public function get_comp_project()
	{


		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id,
			'empid' => $session['employee_id']
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/usermobile/get_comp_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// LIST PAKLARING
	public function report_skk_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/skk_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$project_id 		= $this->uri->segment(4);
		$subproject_id 		= $this->uri->segment(5);
		$status_resign 		= $this->uri->segment(6);

		$role_resources_ids = $this->Xin_model->user_role_resource();
		// $designation_id = $this->uri->segment(6);


		if ($project_id == 0 || is_null($project_id)) {
			// $employee = $this->Reports_model->filter_employees_reports_null($company_id,$department_id,$project_id,$subproject_id,$status_resign);

			$esign = $this->Reports_model->filter_dokumen_sk_null($project_id, $subproject_id, $status_resign);
		} else {
			// $employee = $this->Reports_model->filter_employees_reports($company_id,$department_id,$project_id,$subproject_id,$status_resign);

			$esign = $this->Reports_model->filter_dokumen_sk_project($project_id, $subproject_id, $status_resign);
		}

		$data = array();

		foreach ($esign->result() as $r) {

			$doc_id = $r->doc_id;
			$nomor_dokumen = $r->nomor_dokumen;
			$nip = $r->nip;
			$jenis_doc = $r->jenis_dokumen;
			$createdat = $this->Xin_model->tgl_indo(substr($r->createdon, 0, 10));

			$head_user = $this->Employees_model->read_employee_info_by_nik($r->nip);

			if (!is_null($head_user)) {
				$fullname = $head_user[0]->first_name;
				if (!is_null($head_user[0]->project_id)) {
					$project = $this->Project_model->read_single_project($head_user[0]->project_id);
					if (!is_null($project)) {
						$project_name = $project[0]->title;
					} else {
						$project_name = '--';
					}

					// $project_name = '--';
				} else {
					$project_name = '--';
				}
				// $project_name = $head_user[0]->project_id;


				// $project_name = '--';

			} else {

				$project_name = '--';
				$fullname = '--';
			}

			// JENIS DOKUMENT
			if ($jenis_doc == 1) {
				$jdoc = 'SK KERJA';
			} else if ($jenis_doc == 2) {
				$jdoc = 'PAKLARING';
			} else if ($jenis_doc == 3) {
				$jdoc = 'SK KERJA & PAKLARING';
			} else {
				$jdoc = '--';
			}


			if (in_array('470', $role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="' . $this->lang->line('xin_view') . '"><a href="' . site_url() . 'admin/skk/view/' . $r->secid . '/' . $nip . '" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}

			if (in_array('470', $role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="' . $this->lang->line('xin_delete') . '"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="' . $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $delete . ' ' . $view;

			$data[] = array(
				$combhr,
				$nomor_dokumen,
				$nip,
				$fullname,
				$jdoc,
				$createdat,
				$project_name,
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $esign->num_rows(),
			"recordsFiltered" => $esign->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function report_bpjs_employees_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/bpjs_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);

		$project_id = $this->uri->segment(6);
		$subproject_id = $this->uri->segment(7);

		// $designation_id = $this->uri->segment(6);

		if ($company_id == 0 || is_null($company_id)) {

			$employee = $this->Reports_model->filter_employees_reports_null($company_id, $department_id, $project_id, $subproject_id);
		} else {

			$employee = $this->Reports_model->filter_employees_reports($company_id, $department_id, $project_id, $subproject_id);
		}

		$data = array();

		foreach ($employee->result() as $r) {

			$full_name = $r->first_name . ' ' . $r->last_name;
			$company = $this->Xin_model->read_company_info($r->company_id);
			if (!is_null($company)) {
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';
			}

			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}

			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if (!is_null($project)) {
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';
			}

			$subproject = $this->Project_model->read_single_subproject($r->sub_project_id);
			if (!is_null($subproject)) {
				$subproject_name = $subproject[0]->sub_project_name;
			} else {
				$subproject_name = '--';
			}


			if (!is_null($r->gender)) {
				$gender = $r->gender;
			} else {
				$gender = '--';
			}

			if (!is_null($r->marital_status)) {
				$marital = $r->marital_status;
			} else {
				$marital = '--';
			}

			if (!is_null($r->date_of_birth)) {
				$dob = $r->date_of_birth;
			} else {
				$dob = '--';
			}

			if (!is_null($r->date_of_joining)) {
				$doj = $r->date_of_joining;
			} else {
				$doj = '--';
			}
			if (!is_null($r->email)) {
				$email = $r->email;
			} else {
				$email = '--';
			}
			if (!is_null($r->contact_no)) {
				$kontak = $r->contact_no;
			} else {
				$kontak = '--';
			}

			if (!is_null($r->address)) {
				$alamat = $r->address;
			} else {
				$alamat = '--';
			}


			if (!is_null($r->kk_no)) {
				$kk = $r->kk_no;
			} else {
				$kk = '--';
			}

			if (!is_null($r->ktp_no)) {
				$ktp = $r->ktp_no;
			} else {
				$ktp = '--';
			}

			if (!is_null($r->npwp_no)) {
				$npwp = $r->npwp_no;
			} else {
				$npwp = '--';
			}

			if (!is_null($r->private_code)) {
				$pin = $r->private_code;
			} else {
				$pin = '--';
			}

			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="' . $this->lang->line('xin_edit') . '"><a href="' . site_url() . 'admin/employees/emp_edit/' . $r->employee_id . '"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';

			// get status
			if ($r->is_active == 0) : $status = $this->lang->line('xin_employees_inactive');
			elseif ($r->is_active == 1) : $status = $this->lang->line('xin_employees_active');
			endif;



			$data[] = array(
				$edit,
				$r->employee_id,
				$full_name,
				// $comp_name,
				// $department_name,
				// $designation_name,
				// $project_name,
				// $subproject_name,
				// $gender,
				// $marital,
				// $this->Xin_model->tgl_indo($dob),
				// $this->Xin_model->tgl_indo($doj),
				// $email,
				// $kontak,
				// $alamat,
				// $kk,
				// $ktp,
				// $npwp,
				// $pin
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


	// get company > departments
	public function get_departments()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// get company > departments
	public function get_subprojects()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'project_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_get_subprojects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// get departmens > designations
	public function designation()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// reports > employee attendance
	public function employee_attendance()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_hr_reports_attendance_employee') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_attendance_employee');
		$data['path_url'] = 'reports_employee_attendance';
		$data['all_companies'] = $this->Xin_model->get_companies();

		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);

		// if(in_array('112',$role_resources_ids)) {

		if ($session['employee_id'] == 1 || $session['employee_id'] == 21505790 || $session['employee_id'] == 21300093 || $session['employee_id'] == 21500081) {
			$data['subview'] = $this->load->view("admin/reports/employee_attendance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/profile');
		}

		// redirect('admin/dashboard');
	}

	// reports > employee attendance
	public function report_order()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_order_report') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_order_report');
		$data['path_url'] = 'reports_order';
		$data['all_companies'] = $this->Xin_model->get_companies();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}
		if (in_array('114', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_order", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// reports > employee attendance
	public function report_resume()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_order_resume') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_order_resume');
		$data['path_url'] = 'reports_order_resume';
		$data['all_companies'] = $this->Xin_model->get_companies();
		if (in_array('139', $role_resources_ids)) {
			$data['all_projects'] = $this->Project_model->get_project_exist_all();
		} else {
			// $data['all_projects'] = $this->Project_model->get_project_exist_all();
			$data['all_projects'] = $this->Project_model->get_project_exist();
		}
		if (in_array('114', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_order_resume", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// daily attendance list > timesheet
	public function empdtwise_attendance_list()
	{

		// redirect('admin/');

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		// $company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(4);
		$sub_id = $this->uri->segment(5);
		$area = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);
		$finalarea = str_replace("%20", " ", $area);

		if ($sub_id == 0 || is_null($sub_id)) {
			$employee = $this->Reports_model->filter_report_emp_att_null();
			// $employee = $this->Reports_model->filter_report_emp_att($project_id,$sub_id,$area,$start_date,$end_date);
		} else {
			$employee = $this->Reports_model->filter_report_emp_att($project_id, $sub_id, $finalarea, $start_date, $end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			// $emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			// if(!is_null($emp)){
			// 	$fullname = $emp[0]->first_name;
			// } else {
			// 	$fullname = '--';
			// }

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			$cust = $this->Customers_model->read_single_customer($r->customer_id);
			if (!is_null($cust)) {
				$nama_toko 	= $cust[0]->customer_name;
				$pemilik 	= $cust[0]->owner_name;
				$no_kontak 	= $cust[0]->no_contact;
			} else {
				$nama_toko 	= '--';
				$pemilik 	= '--';
				$no_kontak 	= '--';
			}

			if (!is_null($r->foto_in)) {
				$fotovIn = 'https://api.apps-cakrawala.com/' . $r->foto_in;
			} else {
				$fotovIn = '-';
			}

			if (!is_null($r->foto_out)) {
				$fotovOut = 'https://api.apps-cakrawala.com/' . $r->foto_out;
			} else {
				$fotovOut = '-';
			}

			$data[] = array(
				$r->employee_id,
				$r->fullname,
				$r->title,
				// $project_id,
				// $sub_id,
				$r->sub_project_name,
				$r->penempatan,
				$r->customer_id,
				$nama_toko,

				$pemilik,
				$no_kontak,

				$r->date_phone,
				$r->time_in,
				$r->time_out,
				$r->latitude . ', ' . $r->longitude,
				$r->timestay,
				$fotovIn,
				$fotovOut
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


	// daily attendance list > timesheet
	public function empdtwise_order()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employee_order", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$sub_id = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);

		if ($company_id == 0 || is_null($company_id)) {
			$employee = $this->Reports_model->report_order();
		} else {
			$employee = $this->Reports_model->report_order_filter($company_id, $project_id, $sub_id, $start_date, $end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			$emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			if (!is_null($emp)) {
				$fullname = $emp[0]->first_name;
			} else {
				$fullname = '--';
			}

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			$cust = $this->Customers_model->read_single_customer($r->customer_id);
			if (!is_null($cust)) {
				$nama_toko = $cust[0]->customer_name;
			} else {
				$nama_toko = '--';
			}

			// if(!is_null($r->date_phone)){

			// } else {

			// }

			$data[] = array(
				$r->employee_id,
				$fullname,
				$nama_toko,
				$r->address,
				$r->city,
				$r->kec,
				$r->desa,

				$r->owner_name,
				$r->no_contact,

				$r->material_id,
				$r->nama_material,
				$r->order_date,
				$r->qty,
				$r->price,
				$r->total
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

	// daily attendance list > timesheet
	public function empdtwise_order_resume()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employee_order_resume", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$sub_id = $this->uri->segment(6);
		$start_date = $this->uri->segment(7);
		$end_date = $this->uri->segment(8);

		if ($company_id == 0 || is_null($company_id)) {
			$employee = $this->Reports_model->report_order_resume();
		} else {
			$employee = $this->Reports_model->report_order_resume_filter($company_id, $project_id, $sub_id, $start_date, $end_date);
		}

		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			$emp = $this->Employees_model->read_employee_info_by_nik($r->emp_id);
			if (!is_null($emp)) {
				$fullname = $emp[0]->first_name;
			} else {
				$fullname = '--';
			}

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			// $cust = $this->Customers_model->read_single_customer($r->customer_id);
			// if(!is_null($cust)){
			// 	$nama_toko = $cust[0]->customer_name;
			// } else {
			// 	$nama_toko = '--';	
			// }

			// if(!is_null($r->date_phone)){

			// } else {

			// }

			$data[] = array(
				$r->emp_id,
				$fullname,
				$r->penempatan,
				$r->sdate,
				$r->ndate,
				$r->count_call,
				$r->count_ec,
				$r->qty_renceng,
				'Rp. 10.000;',
				$r->total
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


	// reports > employee attendance
	public function pkwt_history()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'PKWT REPORT';
		$data['breadcrumbs'] = 'PKWT REPORT';
		$data['path_url'] = 'reports_pkwt_history';
		// $data['path_url'] = 'reports_employee_attendance';
		$data['all_companies'] = $this->Xin_model->get_companies();

		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);


		// if(in_array('139',$role_resources_ids)) {
		// 	$data['all_projects'] = $this->Project_model->get_project_exist_all();
		// } else { 
		// 	// $data['all_projects'] = $this->Project_model->get_project_exist_all(); 
		// 	$data['all_projects'] = $this->Project_model->get_project_exist(); 
		// } 
		if (in_array('380', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/report_pkwt_history", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load 
		} else {
			redirect('admin/dashboard');
		}
	}


	public function read_pkwt_report()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
		// $data['all_countries'] = $this->xin_model->get_countries(); 
		// $result = $this->Company_model->read_company_information('2');
		// $result = $this->Employees_model->read_employee_info($id);
		$result = $this->Pkwt_model->read_pkwt_info_by_contractid($id);

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
			'penempatan' => $result[0]->penempatan
		);
		$this->load->view('admin/pkwt/dialog_pkwt_cancel_report', $data);
	}


	// daily attendance list > timesheet
	public function pkwt_history_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_pkwt_history", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		// $company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(4);
		$start_date = $this->uri->segment(5);
		$end_date = $this->uri->segment(6);
		// $employee = $this->Pkwt_model->report_pkwt_history($session['employee_id'],$project_id,$start_date,$keywords);
		if ($project_id == 0 || $start_date == 0) {
			// 	$employee = $this->Reports_model->report_pkwt_history();
			// $employee = $this->Reports_model->filter_report_emp_att($project_id,$sub_id,$area,$start_date,$end_date);
			$employee = $this->Pkwt_model->report_pkwt_history_null($session['employee_id']);
		} else if ($project_id == 999) {
			$employee = $this->Pkwt_model->report_pkwt_history_all($session['employee_id'], $start_date, $end_date);
		} else {
			$employee = $this->Pkwt_model->report_pkwt_history($session['employee_id'], $project_id, $start_date, $end_date);
		}
		// $employee = $this->Employees_model->get_employees();
		$no = 1;
		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			$nip = $r->employee_id;
			$project = $r->project;
			$jabatan = $r->jabatan;
			$penempatan = $r->penempatan;
			$begin_until = $r->from_date . ' s/d ' . $r->to_date;
			// $file_pkwt = $r->file_name;

			if (!is_null($r->file_name)) {

				$pkwt_file = '<a href="' . $r->file_name . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">PKWT FILE</button></a>';
			} else {
				$pkwt_file = '';
			}

			$emp = $this->Employees_model->read_employee_info_by_nik($nip);
			if (!is_null($emp)) {

				$pin = $emp[0]->private_code;
				$fullname = $emp[0]->first_name;
				$sub_project = 'pkwt' . $emp[0]->sub_project_id;
				$nowhatsapp = $emp[0]->contact_no;
				$tkhl_status = $emp[0]->e_status;
				$roleid = $emp[0]->user_role_id;

			} else {

				$pin = '--';
				$fullname = '--';
				$sub_project = '0';
				$nowhatsapp = '0';
				$tkhl_status = '0';
				$roleid = '0';
			}

			$projects = $this->Project_model->read_single_project($project);
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

			$designation = $this->Designation_model->read_designation_information($r->jabatan);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}

			$status_migrasi = '<button type="button" class="btn btn-xs btn-outline-success" data-toggle="modal" data-target=".edit-modal-data" data-company_id="' . $r->contract_id . '">Approved</button>';

			$view_pkwt = '<a href="' . site_url() . 'admin/' . $sub_project . '/view/' . $r->uniqueid . '" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-info">VIEW PKWT' . $roleid . '</button> </a>';


			if ($tkhl_status == '1') {

				$copypaste = '*HRD Notification -> PKWT Digital.*%0a%0a
				Nama Lengkap: *' . $fullname . '*%0a
				NIP: *' . $r->employee_id . '*%0a
				PIN: *' . $pin . '*%0a
				PROJECT: *' . $nama_project . '* %0a%0a

				Yang Terhormat Bapak/Ibu  dibawah naungan Cakrawala Group, telah terbit dokumen PKWT, segera unduh dan tanda tangan serta unggah kembali ke C.I.S maksimal H%2B3 dari pesan ini diterima.%0a%0a

				Silahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.%0a
				Link C.I.S : https://apps-cakrawala.com/admin%0a
				Link Tutorial Tandatangan digital dan pengunggahan kembali PKWT bertanda tangan digital : https://pkwt.apps-cakrawala.com/app/%0a%0a

				*INFO HRD di Nomor Whatsapp: 085175168275* %0a
				*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a
				
				Terima kasih.';
			} else {

				$copypaste = '*HRD Notification -> KEMITRAAN DIGITAL.*%0a%0a
				Nama Lengkap: *' . $fullname . '*%0a
				NIP: *' . $r->employee_id . '*%0a
				PIN: *' . $pin . '*%0a
				PROJECT: *' . $nama_project . '* %0a%0a

				Yang Terhormat Bapak/Ibu  dibawah naungan Cakrawala Group, telah terbit dokumen KEMITRAAN, segera unduh dan tanda tangan serta unggah kembali ke C.I.S maksimal H%2B3 dari pesan ini diterima.%0a%0a

				Silahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.%0a
				Link C.I.S : https://apps-cakrawala.com/admin%0a
				Link Tutorial Tandatangan digital dan pengunggahan kembali PKWT Kemitraan bertanda tangan digital : https://pkwt.apps-cakrawala.com/app/%0a%0a

				*INFO HRD di Nomor Whatsapp: 085175168275* %0a
				*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a
				
				Terima kasih.';
			}

			$whatsapp = '<a href="https://wa.me/62' . $nowhatsapp . '?text=' . $copypaste . '" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-success">' . $nowhatsapp . '</button> </a>';

			// if($roleid=='1' || $roleid=='3' || $roleid=='11'){
			$editReq = '<a href="' . site_url() . 'admin/employee_pkwt_cancel/pkwt_edit/' . $r->contract_id . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">Edit</button></a>';
			$delete = '<button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target=".edit-modal-data" data-company_id="' . $r->contract_id . '">Hapus</button>';
			// } else {
			// 	$editReq = '';
			// 	$delete = '';

			// }

			$data[] = array(
				$no,
				$view_pkwt . ' ' . $editReq . ' ' . $delete,
				$r->employee_id,
				$fullname . '#<br>' . $whatsapp,
				$nama_project,
				$nama_subproject,
				$designation_name,
				$penempatan,
				$begin_until,
				$r->approve_hrd_date,
				$pkwt_file
			);
			$no++;
		}

		$no++;

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $employee->num_rows(),
			"recordsFiltered" => $employee->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	// reports > employee attendance
	public function new_employees()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'KARYAWAN BARU';
		$data['breadcrumbs'] = 'KARYAWAN BARU';
		$data['path_url'] = 'reports_new_employees';


		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_projects'] = $this->Project_model->get_all_projects();
		$data['all_projects_sub'] = $this->Project_model->get_all_projects();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['list_bank'] = $this->Xin_model->get_bank_code();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('327', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/request_list_hrd", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	public function request_list_hrd()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/request_list_hrd", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Xin_model->user_role_resource();

		// $employee = $this->Employees_model->get_request_hrd();
		$employee = $this->Employees_model->get_request_hrd($session['employee_id']);

		$data = array();

		foreach ($employee->result() as $r) {
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
			$nik_ktp = "'" . $r->nik_ktp;
			$notes = $r->catatan_hr;
			$ktp = 'https://apps-cakrawala.com/admin/uploads/document/ktp/' . $r->ktp;

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
				$nik_ktp,
				$fullname,
				$nama_project,
				$nama_subproject,
				$department_name,
				$designation_name,
				$penempatan,
				$contact_no,
				$doj,
				$ktp,
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


	// reports > employee attendance
	public function pkwt_expired()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'PKWT EXPIRED';
		$data['breadcrumbs'] = 'PKWT EXPIRED';
		$data['path_url'] = 'reports_pkwt_expired';
		// $data['path_url'] = 'reports_employee_attendance';
		$data['all_companies'] = $this->Xin_model->get_companies();

		$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);

		if (in_array('377', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/report_pkwt_expired", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	public function pkwt_expired_list()

	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_pkwt_expired", $data);
		} else {
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		// $company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(4);
		$start_date = $this->uri->segment(5);
		$end_date = $this->uri->segment(6);
		$searchkey = $this->uri->segment(7);
		$finalkey = str_replace("%20", " ", $searchkey);
		// $employee = $this->Pkwt_model->report_pkwt_history($session['employee_id'],$project_id,$start_date,$keywords);



		//$employee = $this->Pkwt_model->get_monitoring_pkwt_aphrd($session['employee_id']);

		if ($searchkey == '0') {

			if ($project_id == '0') {
				$employee = $this->Pkwt_model->report_pkwt_expired_default($session['employee_id']);
			} else {
				$employee = $this->Pkwt_model->report_pkwt_expired_pro($project_id, $session['employee_id']);
			}
		} else {

			if ($searchkey != "") {

				$employee = $this->Pkwt_model->report_pkwt_expired_key($finalkey, $session['employee_id']);
			} else {

				if ($project_id == 0) {
					$employee = $this->Pkwt_model->report_pkwt_expired_default($session['employee_id']);
				} else {
					$employee = $this->Pkwt_model->report_pkwt_expired_pro($project_id, $session['employee_id']);
				}
			}
		}


		$no = 1;
		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			$user_id = $r->user_id;
			$nip = $r->employee_id;
			$fullname = $r->first_name;
			$project = $r->project_id;
			$penempatan = $r->penempatan;
			$last_contract = $r->contract_end;


			$projects = $this->Project_model->read_single_project($r->project_id);
			if (!is_null($projects)) {
				$nama_project = $projects[0]->title;
			} else {
				$nama_project = '--';
			}

			// $subprojects = $this->Project_model->read_single_subproject($r->sub_project_id);
			// if (!is_null($projects)) {
			// 	$nama_subproject = $subprojects[0]->sub_project_name;
			// } else {
			// 	$nama_subproject = '--';
			// }

			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}


			$readyHrd = $this->Pkwt_model->read_pkwt_pengajuan($r->employee_id);

			if (!is_null($readyHrd)) {

				$terbitPkwt = '<a href="#" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-warning">SUDAH DIAJUKAN</button></a>';
			} else {

				$terbitPkwt = '<a href="' . site_url() . 'admin/employee_pkwt_cancel/pkwt_expired_edit/' . $r->employee_id . '/1" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">AJUKAN PERPANJANG PKWT</button></a>';
			}









			// $terbitPkwt = '<a href="'.site_url().'admin/employee_pkwt_cancel/pkwt_expired_edit/'.$r->employee_id.'/1" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">AJUKAN PERPANJANG PKWT</button></a>'; 
			// $whatsapp = '<a href="https://wa.me/62'.$nowhatsapp.'?text='.$copypaste.'" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-success">'.$nowhatsapp.'</button> </a>'; 

			$editReq = '<a href="' . site_url() . 'admin/employee_pkwt_cancel/pkwt_expired_edit/' . $r->employee_id . '/0" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-info">PERPANJANG PKWT</button></a>';



			$stopPkwt = '<a href="' . site_url() . 'admin/employees/emp_edit/' . $r->employee_id . '" class="d-block text-primary" target="_blank"><button type="button" class="btn btn-xs btn-outline-danger">STOP PKWT</button></a>';


			$data[] = array(
				$terbitPkwt . ' ' . $stopPkwt,
				// $stopPkwt,
				$nip,
				$fullname,
				$nama_project,
				'$nama_subproject',
				$designation_name,
				$penempatan,
				$last_contract
			);
			$no++;
		}

		// $no++;

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
	public function get_company_project()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'id_company' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_company_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// get location > departments
	public function get_sub_project()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'id_project' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_sub_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	// get location > departments
	public function get_area_emp()
	{

		$data['title'] = $this->Xin_model->site_title();
		// $id = $this->uri->segment(4);

		$area = $this->uri->segment(4);
		$sub_id = $this->uri->segment(5);
		$project_id = $this->uri->segment(6);


		$data = array(
			'area' => $area,
			'sub_id' => $sub_id,
			'pro_id' => $project_id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_area_emp", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// Validate and add info in database
	public function payslip_report()
	{

		if ($this->input->post('type') == 'payslip_report') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
			if ($this->input->post('company_id') === '') {
				$Return['error'] = $this->lang->line('error_company_field');
			} else if ($this->input->post('employee_id') === '') {
				$Return['error'] = $this->lang->line('xin_error_employee_id');
			} else if ($this->input->post('month_year') === '') {
				$Return['error'] = $this->lang->line('xin_hr_report_error_month_field');
			}

			if ($Return['error'] != '') {
				$this->output($Return);
			}
			$Return['result'] = $this->lang->line('xin_hr_request_submitted');
			$this->output($Return);
		}
	}

	public function role_employees_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/roles", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$roleId = $this->uri->segment(4);
		$employee = $this->Reports_model->get_roles_employees($roleId);

		$data = array();

		foreach ($employee->result() as $r) {

			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if (!is_null($company)) {
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';
			}

			// user full name 
			$full_name = $r->first_name . ' ' . $r->last_name;
			// get status
			if ($r->is_active == 0) : $status = $this->lang->line('xin_employees_inactive');
			elseif ($r->is_active == 1) : $status = $this->lang->line('xin_employees_active');
			endif;
			// user role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if (!is_null($role)) {
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if (!is_null($designation)) {
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if (!is_null($department)) {
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}
			$department_designation = $designation_name . ' (' . $department_name . ')';

			$data[] = array(
				$r->employee_id,
				$full_name,
				$comp_name,
				$r->email,
				$role_name,
				$department_designation,
				$status
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


	public function project_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/projects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$projId = $this->uri->segment(4);
		$projStatus = $this->uri->segment(5);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if ($user_info[0]->user_role_id == 1) {
			$project = $this->Reports_model->get_project_list($projId, $projStatus);
		} else {
			$project = $this->Project_model->get_employee_projects($session['user_id']);
		}
		$data = array();

		foreach ($project->result() as $r) {

			// get start date
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			// get end date
			$end_date = $this->Xin_model->set_date_format($r->end_date);

			$pbar = '<p class="m-b-0-5">' . $this->lang->line('xin_completed') . ' ' . $r->project_progress . '%</p>';

			//status
			if ($r->status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if ($r->status == 1) {
				$status = $this->lang->line('xin_in_progress');
			} else if ($r->status == 2) {
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}

			// priority
			if ($r->priority == 1) {
				$priority = '<span class="tag tag-danger">' . $this->lang->line('xin_highest') . '</span>';
			} else if ($r->priority == 2) {
				$priority = '<span class="tag tag-danger">' . $this->lang->line('xin_high') . '</span>';
			} else if ($r->priority == 3) {
				$priority = '<span class="tag tag-primary">' . $this->lang->line('xin_normal') . '</span>';
			} else {
				$priority = '<span class="tag tag-success">' . $this->lang->line('xin_low') . '</span>';
			}

			//assigned user
			if ($r->assigned_to == '') {
				$ol = $this->lang->line('xin_not_assigned');
			} else {
				$ol = '';
				foreach (explode(',', $r->assigned_to) as $desig_id) {
					$assigned_to = $this->Xin_model->read_user_info($desig_id);
					if (!is_null($assigned_to)) {

						$assigned_name = $assigned_to[0]->first_name . ' ' . $assigned_to[0]->last_name;
						$ol .= $assigned_name . "<br>";
					}
				}
				$ol .= '';
			}
			$new_time = $this->Xin_model->actual_hours_timelog($r->project_id);

			//echo $new_time;
			$project_summary = '<div class="text-semibold"><a href="' . site_url() . 'admin/project/detail/' . $r->project_id . '">' . $r->title . '</a></div>';
			$data[] = array(
				$project_summary,
				$priority,
				$start_date,
				$end_date,
				$status,
				$pbar,
				$ol,
				$r->budget_hours,
				$new_time,

			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $project->num_rows(),
			"recordsFiltered" => $project->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function training_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/employee_training", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$start_date = $this->uri->segment(4);
		$end_date = $this->uri->segment(5);
		$uid = $this->uri->segment(6);
		$cid = $this->uri->segment(7);

		$training = $this->Reports_model->get_training_list($cid, $start_date, $end_date);

		$data = array();

		foreach ($training->result() as $r) {

			$aim = explode(',', $r->employee_id);
			foreach ($aim as $dIds) {
				if ($uid == $dIds) {

					// get training type
					$type = $this->Training_model->read_training_type_information($r->training_type_id);
					if (!is_null($type)) {
						$itype = $type[0]->type;
					} else {
						$itype = '--';
					}
					// get trainer
					/*$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}*/
					// get trainer
					if ($r->trainer_option == 2) {
						$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
						// trainer full name
						if (!is_null($trainer)) {
							$trainer_name = $trainer[0]->first_name . ' ' . $trainer[0]->last_name;
						} else {
							$trainer_name = '--';
						}
					} elseif ($r->trainer_option == 1) {
						// get user > employee_
						$trainer = $this->Xin_model->read_user_info($r->trainer_id);
						// employee full name
						if (!is_null($trainer)) {
							$trainer_name = $trainer[0]->first_name . ' ' . $trainer[0]->last_name;
						} else {
							$trainer_name = '--';
						}
					} else {
						$trainer_name = '--';
					}
					// get start date
					$start_date = $this->Xin_model->set_date_format($r->start_date);
					// get end date
					$finish_date = $this->Xin_model->set_date_format($r->finish_date);
					// training date
					$training_date = $start_date . ' ' . $this->lang->line('dashboard_to') . ' ' . $finish_date;
					// set currency
					$training_cost = $this->Xin_model->currency_sign($r->training_cost);
					/* get Employee info*/
					if ($uid == '') {
						$ol = '--';
					} else {
						$user = $this->Exin_model->read_user_info($uid);
						$fname = $user[0]->first_name . ' ' . $user[0]->last_name;
					}
					// status
					if ($r->training_status == 0) : $status = $this->lang->line('xin_pending');
					elseif ($r->training_status == 1) : $status = $this->lang->line('xin_started');
					elseif ($r->training_status == 2) : $status = $this->lang->line('xin_completed');
					else : $status = $this->lang->line('xin_terminated');
					endif;

					// get company
					$company = $this->Xin_model->read_company_info($r->company_id);
					if (!is_null($company)) {
						$comp_name = $company[0]->name;
					} else {
						$comp_name = '--';
					}

					$data[] = array(
						$comp_name,
						$fname,
						$itype,
						$trainer_name,
						$training_date,
						$training_cost,
						$status
					);
				}
			}
		} // e- training

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $training->num_rows(),
			"recordsFiltered" => $training->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	// hourly_list > templates
	public function payslip_report_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/payslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$cid = $this->uri->segment(4);
		$eid = $this->uri->segment(5);
		$re_date = $this->uri->segment(6);


		$payslip_re = $this->Reports_model->get_payslip_list($cid, $eid, $re_date);

		$data = array();

		foreach ($payslip_re->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if (!is_null($user)) {
				$full_name = $user[0]->first_name . ' ' . $user[0]->last_name;
				$emp_link = $user[0]->employee_id;

				$month_payment = date("F, Y", strtotime($r->salary_month));

				$p_amount = $this->Xin_model->currency_sign($r->net_salary);
				if ($r->wages_type == 1) {
					$payroll_type = $this->lang->line('xin_payroll_basic_salary');
				} else {
					$payroll_type = $this->lang->line('xin_employee_daily_wages');
				}

				// get date > created at > and format
				$created_at = $this->Xin_model->set_date_format($r->created_at);

				$data[] = array(
					$emp_link,
					$full_name,
					$p_amount,
					$month_payment,
					$created_at,
					$payroll_type
				);
			}
		} // if employee available

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $payslip_re->num_rows(),
			"recordsFiltered" => $payslip_re->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	// get company > employees
	public function get_employees()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	// get company > employees
	public function get_employees_att()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_employees_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	// get company > employees
	public function get_project_att()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/get_project_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function saltab_bpjs()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'Saltab to BPJS | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'BPJS Project';
		$data['uploadid'] = $this->input->get('upid', TRUE);
		$data['path_url'] = 'reports_saltab_bpjs';
		// $data['all_companies'] = $this->Xin_model->get_companies();
		// $data['all_departments'] = $this->Department_model->all_departments();
		// $data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		// $data['all_designations'] = $this->Designation_model->all_designations();
		if (in_array('477', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/saltab_bpjs", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// daily attendance list > timesheet
	public function saltab_bpjs_list()
	{

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/saltab_bpjs", $data);
		} else {
			redirect('admin/');
		}

		$uploadID = $this->input->get('upid', TRUE);
		// $uploadID = '20230612142717943';

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$employee = $this->Bpjs_model->saltab_bpjs_list($uploadID);


		// $employee = $this->Employees_model->get_employees();

		$data = array();

		// for($i=0 ; $i < count($attend); $i++) {
		foreach ($employee->result() as $r) {

			// $emp = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
			// if(!is_null($emp)){
			// 	$fullname = $emp[0]->first_name;
			// } else {
			// 	$fullname = '--';
			// }

			// $project = $this->Project_model->read_single_project($r->project_id);
			// if(!is_null($project)){
			// 	$project_name = $project[0]->title;
			// } else {
			// 	$project_name = '--';	
			// }

			// $cust = $this->Customers_model->read_single_customer($r->customer_id);
			// if(!is_null($cust)){
			// 	$nama_toko = $cust[0]->customer_name;
			// } else {
			// 	$nama_toko = '--';	
			// }

			// if(!is_null($r->foto_in)){
			// 	$fotovIn = 'https://api.apps-cakrawala.com/'.$r->foto_in;
			// } else {
			// 	$fotovIn = '-';
			// }

			// if(!is_null($r->foto_out)){
			// 	$fotovOut = 'https://api.apps-cakrawala.com/'.$r->foto_out;
			// } else {
			// 	$fotovOut = '-';
			// }

			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="' . $this->lang->line('xin_edit') . '"><a href="' . site_url() . 'admin/employees/emp_edit/' . $r->nip . '" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';

			$data[] = array(
				$r->status_emp,
				$edit . ' ' . $r->nip,
				$r->fullname,
				$r->project,
				$r->project_sub,
				$r->area,

				$r->gaji_umk,
				$r->gaji_pokok,
				$r->bpjs_tk_deduction + $r->bpjs_tk + $r->jaminan_pensiun_deduction + $r->jaminan_pensiun,
				$r->bpjs_ks_deduction + $r->bpjs_ks
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

	// Validate and update status info in database // status info
	public function tandai_download()
	{
		/* Define return | here result is used to return user data and error for error message */
		// $status_id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		// if(empty($session)){ 
		// 	redirect('admin/');
		// }
		$upload_id = $this->uri->segment(4);


		$datas = array(
			'release' => $session['user_id'],
			'release_date' =>  date("Y-m-d h:i:s"),
		);

		$this->Import_model->update_release_saltab($datas, $upload_id);


		// $resultdel = $this->Import_model->delete_all_eslip_preview($upload_id);
		// $tempEmployees = $this->Import_model->get_temp_eslip($upload_id);


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
			$result = $this->Pkwt_model->delete_pkwt_cancel($id);
			if (isset($id)) {
				$Return['result'] = 'Delete PKWT Tolak berhasil.';
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}

	public function printExcel($project, $sub_project, $status,  $searchVal, $session_id)
	{
		$postData = array();

		//variabel filter (diambil dari post ajax di view)
		$postData['project'] = $project;
		$postData['sub_project'] = $sub_project;
		$postData['status'] = $status;
		$postData['session_id'] = $session_id;
		$postData['nama_file'] = 'Data Karyawan';
		if ($searchVal == '-no_input-') {
			$postData['filter'] = '';
		} else {
			$postData['filter'] = urldecode($searchVal);
		}

		// echo $postData['filter'];

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('Data Karyawan'); //nama Spreadsheet yg baru dibuat

		//data satu row yg mau di isi
		$rowArray = [
			'STATUS',
			'NIP',
			'PIN',
			'NIK',
			'NAMA LENGKAP',
			'PERUSAHAAN/PT',
			'DEPARTMENT',
			'POSISI/JABATAN',
			'PROJECT/PRINCIPLE',
			'SUB PROJECT/ENTITAS',
			'AREA/PENEMPATAN',
			'REGION',
			'TEMPAT LAHIR',
			'TANGGAL LAHIR',
			'TANGGAL BERGABUNG',
			'MULAI KONTRAK',
			'AKHIR KONTRAK',
			'GAJI POKOK',
			'TANGGAL RESIGN',
			'JENIS KELAMIN',
			'STATUS KAWIN',
			'AGAMA',
			'EMAIL',
			'NOMOR KONTAK',
			'PENDIDIKAN',
			'ALAMAT KTP',
			'ALAMAT DOMISILI',
			'NO KK',
			'NO KTP',
			'NO NPWP',
			'BPJS TK',
			'BPJS KS',
			'NAMA IBU KANDUNG',
			'NAMA KONTAK DARURAT',
			'HUB. KONTAK DARURAT',
			'NOMOR KONTAK DARURAT',
			'NAMA BANK',
			'NO REKENING',
			'NAMA PEMILIK REKENING',
			'FOTO KTP',
			'FOTO KK',
			'FOTO NPWP',
			'FOTO IJAZAH',
			'DOKUMEN SKCK',
			'DOKUMEN CV',
			'DOKUMEN PAKLARING',
			'PKWT',
			'TANGGAL UPLOAD PKWT',
		];

		$length_array = count($rowArray);
		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$rowArray,   // The data to set
				NULL,
				'A1'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}
		//set background color
		$spreadsheet
			->getActiveSheet()
			->getStyle('A1:AV1')
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//$spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR);

		// Get data
		$data = $this->Employees_model->get_employee_print($postData);
		$length_data = count($data);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 2])->setvalueExplicit($data[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}
		//$data = var_dump(json_decode($data_temp, true));

		// if (!is_array(end($data))) {
		// 	$data = [$data];
		// }

		$jumlah = count($data) + 1;

		//var_dump($data);

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$data,  // The data to set
		// 		NULL,        // Array values with this value will not be set
		// 		'A2',
		// 		false,
		// 		false         // Top left coordinate of the worksheet range where
		// 		//    we want to set these values (default is A1)
		// 	);


		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:1')->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');
		$spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		// $spreadsheet->getActiveSheet()->getStyle('AC:AI')->getNumberFormat()->setFormatCode('Rp #,##0');
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
}

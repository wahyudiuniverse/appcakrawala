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

class Traxes_msellout_employee extends MY_Controller
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
		$this->load->model("Traxes_model");
		$this->load->model("Xin_model");
		// $this->load->model("Department_model");
		// $this->load->model("Designation_model");
		$this->load->model("Roles_model");
		// $this->load->model("Location_model");
		$this->load->model("Company_model");
		// $this->load->model("Timesheet_model");
		$this->load->model("Project_model");
		$this->load->model("Assets_model");
		// $this->load->model("Training_model");
		// $this->load->model("Trainers_model");
		// $this->load->model("Awards_model");
		// $this->load->model("Travel_model");
		// $this->load->model("Tickets_model");
		// $this->load->model("Transfers_model");
		// $this->load->model("Promotion_model");
		// $this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Subproject_model");
		// $this->load->model("Payroll_model");
		// $this->load->model("Events_model");
		// $this->load->model("Meetings_model");
		// $this->load->model('Exin_model');
		// $this->load->model('Import_model');
		// $this->load->model('Pkwt_model');
		$this->load->model('Xin_model');
		$this->load->library("pagination");
		// $this->load->library('Pdf');
		//$this->load->library("phpspreadsheet");
		// $this->load->helper('string');
		// $this->load->library('ciqrcode');
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

	// INI KEPAKE //download saltab release
	public function summary_employees_sellout()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		// $data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
		// $data['all_subproject'] = $this->Project_model->get_project_maping($session['employee_id']);
		$data['title'] = 'View Summary Employees Sellout | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'SUMMARY EMPLOYEES SELLOUT';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (in_array('514', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/traxes/summary_employees_sellout", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

}

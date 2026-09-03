<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author   dndsoft
 * @author-email  komputer.dnd@gmail.com
 * @copyright  Copyright © dndsoft.my.id All Rights Reserveds
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_area extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load the models
		$this->load->model("Xin_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Employees_model");
		$this->load->model("Project_model");
		$this->load->model("Billing_area_model");
		$this->load->library("pagination");
		//$this->load->library('Pdf');
		$this->load->helper('string');
	}

	// Billing Area Report
	public function index()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = 'Billing Area' . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'BILLING AREA';
		$data['path_url'] = 'job_order';
		$data['all_billing_area'] = $this->Billing_area_model->get_all_billing_area();
		if (in_array('121', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/billing/billing_area", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//load datatables biling area
	public function list_billing_area()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Billing_area_model->list_billing_area($postData);

		echo json_encode($data);
	}
}

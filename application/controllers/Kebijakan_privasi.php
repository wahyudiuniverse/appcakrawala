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

class kebijakan_privasi extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->helper('string');
		// $this->load->library('email');
	}
	

	public function index() {
		// $system = $this->Xin_model->read_setting_info(1);
		// if($system[0]->module_recruitment!='true'){
		// 	redirect('admin/');
		// }
		$data['title'] = 'KEBIJAKAN PRIVASI';
		// $data['all_companies'] = $this->Xin_model->get_companies();
		// $data['all_ethnicity'] = $this->Xin_model->get_ethnicity_type();
		// $data['all_dept'] = $this->Xin_model->get_departments();
		// $data['all_designation'] = $this->Xin_model->get_designations();
		// $data['all_project'] = $this->Xin_model->get_projects();
		// $data['nomor_ktp'] = $this->input->post('nomor_ktp');
		$data['path_url'] = 'ceknik';
		$data['subview'] = $this->load->view("frontend/hrpremium/kebijakan_privasi", $data, TRUE);
		// $data['subview'] = $this->load->view("frontend/hrpremium/register_stop", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
  }
}

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

class Privacy extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->library('email');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Kebijakan Privasi';
		$data['path_url'] = 'job_contact';
		$data['subview'] = $this->load->view("frontend/hrpremium/privacy", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
     }
	 
}

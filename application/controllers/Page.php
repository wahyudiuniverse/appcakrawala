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

class Page extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	public function view() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$url = $this->uri->segment(3);
		$result = $this->Recruitment_model->read_main_page_info($url);
		if(is_null($result)){ 
			redirect('jobs/');
		}
		$data = array(
			'title' => $result[0]->page_title,
			'path_url' => '',
			'page_title' => $result[0]->page_title,
			'page_id' => $result[0]->page_id,
			'page_url' => $result[0]->page_url,
			'page_details' => $result[0]->page_details
		);
		$data['subview'] = $this->load->view("frontend/hrpremium/pages", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
     }	 
}

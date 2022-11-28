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

class Bpjs_kartu extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct(){
          parent::__construct();
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Project_model");
		  $this->load->model("Employees_model");
		  $this->load->model("Invoices_model");
		  $this->load->model("Clients_model");
		  $this->load->model("Finance_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_manage_employees_bpjs').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_manage_employees_bpjs');
		$data['all_projects'] = $this->Project_model->get_projects();
		// $data['path_url'] = 'hrpremium_invoices';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/bpjs/bpjs_kartu", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		// } else {
		// 	redirect('admin/dashboard');
		// }
	}


	

} 
?>
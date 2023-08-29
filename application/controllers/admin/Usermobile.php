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

class Usermobile extends MY_Controller 
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
		$this->load->model("Usersmobile_model");
		$this->load->model("Project_model");
		$this->load->model("Designation_model");

		// $this->load->model("Department_model");
		// $this->load->model("Location_model");
		// $this->load->model("Pkwt_model");
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

		$data['title'] = $this->lang->line('xin_user_mobile').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_user_mobile');

		$data['all_employees'] = $this->Xin_model->all_employees();
		// $data['all_usermobile_type'] = $this->Xin_model->get_usermobile_type();
		$data['all_projects'] = $this->Xin_model->get_projects();
		$data['all_area'] = $this->Xin_model->get_area();
		$data['all_posisi'] = $this->Xin_model->get_designations();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'usermobile';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('59',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/usermobile/usermobile_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}


	// get company > departments
	public function get_comp_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/usermobile/get_comp_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	// get company > departments
	public function get_subprojects() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'project_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_subprojects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	public function usermobile_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/usermobile/usermobile_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$company_id = $this->uri->segment(4);
		$project_id = $this->uri->segment(5);
		$subproject_id = $this->uri->segment(6);


		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);


		if($project_id=="0" || is_null($project_id)){
			$usermobile = $this->Usersmobile_model->user_mobile_limit();
		}else{
			$usermobile = $this->Usersmobile_model->user_mobile_limit_fillter($company_id, $project_id, $subproject_id);
		}
		


		$data = array();

    foreach($usermobile->result() as $r) {

    	$nik = $r->employee_id;

    	$read_employee = $this->Employees_model->read_employee_info_by_nik($r->employee_id);
    	if(!is_null($read_employee)){
				$fullname = $read_employee[0]->first_name;
    	} else {
				$fullname = '--';
    	}

    	$read_usertype = $this->Usersmobile_model->read_usersmobile_type($r->usertype_id);
			if(!is_null($read_usertype)){
				$usertype = $read_usertype[0]->user_type_name;
			} else {
				$usertype = '--';	
			}

			$project_info = $this->Project_model->read_project_information($r->project_id);
			if(!is_null($project_info)){
				$projectname = $project_info[0]->title;
			} else {
				$projectname = '--';	
			}
			

			$read_area = $this->Usersmobile_model->read_usersmobile_area($r->areaid);
			if(!is_null($read_area)){
				$area = $read_area[0]->name;
			} else {
				$area = '--';	
			}

			// get company
			// $location = $this->Location_model->read_location_information($r->location_id);
			// if(!is_null($location)){
			// 	$location_name = $location[0]->location_name;
			// } else {
			// 	$location_name = '--';	
			// }
			
			if(in_array('65',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-usermobile_id="'. $r->employee_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('66',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $edit.$delete;
			  
		   $data[] = array(
				$combhr,
				$nik,
				$fullname,
				$usertype,
				$projectname,
				ucwords(strtolower($area)),
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $usermobile->num_rows(),
                 "recordsFiltered" => $usermobile->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	


	// Validate and add info in database
	public function add_usermobile() {
	
		if($this->input->post('add_type')=='usermobile') {
		// Check validation for user input
		$session = $this->session->userdata('username');
		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();


		/* Server side PHP input validation */
		if($this->input->post('employees')==='') {
  	  $Return['error'] = 'Employee Kosong..!';
		} else if($this->input->post('project')==='') {
			$Return['error'] = 'Project Kosong..!';
		} else if($this->input->post('area')==='') {
			$Return['error'] = 'Area/Penempatan Kosong..!';
		} 

		if($Return['error']!='') {
  	 	$this->output($Return);
  	}
	
		$data = array(
		'employee_id' => $this->input->post('employees'),
		'project_id' => $this->input->post('project'),
		'usertype_id' => 1,
		'areaid' => $this->input->post('area'),
		'areaid_extra1' => $this->input->post('area2'),
		'areaid_extra2' => $this->input->post('area3'),
		'device_id_one' => $this->input->post('device_id'),
		'createdby' => $session['user_id'],

		);

		$result = $this->Usersmobile_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_usermobile');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}



	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

		$keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		$keystring = $this->input->get('department_id');

			if(!is_null($keywords[0])){

    		$read_employee = $this->Employees_model->read_employee_info_by_nik($keywords[0]);
    		$read_usermobile = $this->Usersmobile_model->read_users_mobile_by_nik($keywords[0]);

    		$full_name = $read_employee[0]->first_name;

				$all_projects = $this->Project_model->get_projects();
				$all_usertype = $this->Usersmobile_model->get_usertype();
				$all_area = $this->Xin_model->get_area();
				// $all_area = $this->Usersmobile_model->get_district();

			}

		// if(is_numeric($keywords[0])) {

		// 	$id = $keywords[0];
		// 	$id = $this->security->xss_clean($id);


		// }

			$data = array(
				'usermobile_id' => $keywords[0],
				'fullname' => $full_name,
				'usertype_id' => $read_usermobile[0]->usertype_id,
				'project_id' => $read_usermobile[0]->project_id,
				'areaid' => $read_usermobile[0]->areaid,
				'areaid_extra1' => $read_usermobile[0]->areaid_extra1,
				'areaid_extra2' => $read_usermobile[0]->areaid_extra2,
				'device_id' => $read_usermobile[0]->device_id_one,
				'all_usertype' => $all_usertype,
				'all_projects' => $all_projects,
				'all_area' => $all_area
				);
			$session = $this->session->userdata('username');
			
			if(!empty($session)){
				$this->load->view('admin/usermobile/dialog_usermobile', $data);
			} else {
				redirect('admin/');
			}
		
	}


	// Validate and update info in database
	public function update() { 
	
		// if($this->input->post('edit_type')=='department') {
			
		
		// $keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		// if(is_numeric($keywords[0])) {
			// $id = $keywords[0];
			$emp = $this->input->post('employeeid');

			// Check validation for user input
			// $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');

			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			/* Server side PHP input validation */
			// if($this->input->post('department_name')==='') {
			// 	$Return['error'] = $this->lang->line('error_department_field');
			// } else if($this->input->post('company_id')==='') {
			// 	$Return['error'] = $this->lang->line('error_company_field');
			// } else if($this->input->post('location_id')==='') {
			// 	$Return['error'] = $this->lang->line('xin_location_field_error');
			// } 

			// if($Return['error']!=''){
			// 	$this->output($Return);
			// }

			$data = array(
			'usertype_id' => $this->input->post('usertype'),
			'project_id' => $this->input->post('project'),
			'areaid' => $this->input->post('area'),
			'areaid_extra1' => $this->input->post('area2'),
			'areaid_extra2' => $this->input->post('area3'),
			'device_id_one' => $this->input->post('device_id'),
			// 'device_id_one' => $this->input->post('device_id'),
			);

			// $data = $this->security->xss_clean($data);
			$result = $this->Usersmobile_model->update_record($data,$emp);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_update_department');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		// }
		// }
	}


	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Usersmobile_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_job_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}


} 
?>
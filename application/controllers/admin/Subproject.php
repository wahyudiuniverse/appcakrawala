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

class Subproject extends MY_Controller 
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
		$this->load->model("Subproject_model");

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

		$data['title'] = $this->lang->line('xin_pkwt_sub_project').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt_sub_project');

		$data['all_subproject'] = $this->Subproject_model->get_all_subproject();
		// $data['all_usermobile_type'] = $this->Xin_model->get_usermobile_type();
		$data['all_project'] = $this->Xin_model->get_projects();
		// $data['all_area'] = $this->Xin_model->get_area();
		// $data['all_posisi'] = $this->Xin_model->get_designations();
		// $data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'sub_project';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('130',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/project/subproject_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}


	public function sub_projects_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/project/subproject_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);

		// $usermobile = $this->Usersmobile_model->get_users_mobile();
		$subproject = $this->Subproject_model->get_subproject();

		$data = array();

    foreach($subproject->result() as $r) {

    	$sid = $r->secid;
    	$subproject_name = $r->sub_project_name;
    	$project_name = $r->id_project;

				$projects = $this->Project_model->read_single_project($r->id_project);
				if(!is_null($projects)){
					$nama_project = $projects[0]->title;
				} else {
					$nama_project = '--';	
				}
			
			if(in_array('134',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-subproject_id="'. $r->secid . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('135',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $edit.$delete;
			  

		   $data[] = array(
				$combhr,
				$sid,
				$subproject_name,
				$nama_project,
		   );

          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $subproject->num_rows(),
                 "recordsFiltered" => $subproject->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	

	// Validate and add info in database
	public function add_subproject() {
	
		if($this->input->post('add_type')=='subproject') {
		// Check validation for user input
		$session = $this->session->userdata('username');
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		$data = array(
		'sub_project_name' => $this->input->post('subproject'),
		'id_project' => $this->input->post('project'),

		);

		$result = $this->Subproject_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_sub_project');
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

    		// $read_employee = $this->Employees_model->read_employee_info_by_nik($keywords[0]);
    		// $read_usermobile = $this->Usersmobile_model->read_users_mobile_by_nik($keywords[0]);

    		// $full_name = $read_employee[0]->first_name.' '.$read_employee[0]->last_name;

				$all_projects = $this->Project_model->get_projects();
				// $all_sub_projects = $this->Subproject_model->get_subproject();
				// $all_usertype = $this->Usersmobile_model->get_usertype();
				// $all_area = $this->Xin_model->get_area();
				// $all_area = $this->Usersmobile_model->get_district();

			}

		// if(is_numeric($keywords[0])) {

		// 	$id = $keywords[0];
		// 	$id = $this->security->xss_clean($id);


		// }

			$data = array(
				'id_sub_project' => $keywords[0],
				'name_sub_project' => $keywords[0]
				// 'usertype_id' => $read_usermobile[0]->usertype_id,
				// 'project_id' => $read_usermobile[0]->project_id,
				// 'areaid' => $read_usermobile[0]->areaid,
				// 'device_id' => $read_usermobile[0]->device_id_one,
				// 'all_usertype' => $all_usertype,
				// 'all_projects' => $all_projects,
				// 'all_area' => $all_area
				);
			$session = $this->session->userdata('username');
			
			if(!empty($session)){ 
				$this->load->view('admin/project/dialog_sub_project', $data);
			} else {
				redirect('admin/');
			}
		
	}

	// Validate and update info in database
	public function update() {
	
		// if($this->input->post('edit_type')=='department') {
			
		
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

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
			'district_id' => $this->input->post('area'),
			'device_id_one' => $this->input->post('device_id'),
			);

			$data = $this->security->xss_clean($data);
			$result = $this->Usersmobile_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_update_department');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
		// }
	}

	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Subproject_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_job_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}


} 
?>
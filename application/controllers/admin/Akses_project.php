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

class Akses_project extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Designation_model");
		$this->load->model("Xin_model");
		$this->load->model("Project_model");
		$this->load->model("Employees_model");
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
		
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$data['title'] = $this->lang->line('xin_akses_project').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();

		if($user_info[0]->user_role_id==1){
			$data['all_projects'] = $this->Project_model->all_projects_admin();
		} else {
			$data['all_projects'] = $this->Project_model->all_projects();
		}
		// $data['get_all_companies'] = $this->Xin_model->get_companies();
		//$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_akses_project');
		$data['path_url'] = 'akses_project';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('207',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/project/akses_project_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load		  
		} else {
			redirect('admin/dashboard');
		}
  }
 
  public function akses_project_list(){

		$session = $this->session->userdata('username');
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/project/akses_project_list", $data);
		} else {
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		// if($user_info[0]->user_role_id==1){
		// 	$designation = $this->Designation_model->get_designations();
		// } else {
		// 	$designation = $this->Designation_model->get_company_designations($user_info[0]->company_id);
		// }

			$aksesproject = $this->Project_model->get_akses_projects();

		$data = array();

      foreach($aksesproject->result() as $r) {
			 

      $ids = $r->secid;
      $nip = $r->nip;
      $project_id = $r->project_id;

			$posisi = $this->Employees_model->read_employee_jabatan($r->nip);
			if(!is_null($posisi)){
				$nama_lengkap = $posisi[0]->first_name;
				$nama_posisi = $posisi[0]->designation_name;
			} else {
				$nama_lengkap = '--';	
				$nama_posisi = '--';	
			}

			$project = $this->Project_model->read_single_project($r->project_id);
			if(!is_null($project)){
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';	
			}

			if(in_array('209',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $delete;
			// $idesignation_name = $r->designation_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department').': '.$department_name.'<i></i></i></small>'.$subdep_name.'';

	       $data[] = array(
					$combhr,
					$nip,
					$nama_lengkap,
					$nama_posisi,
					$project_name
			  );
      }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $aksesproject->num_rows(),
                 "recordsFiltered" => $aksesproject->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }
	
	public function add_akses_project() {
	
		if($this->input->post('add_type')=='aksesproject') {
		// Check validation for user input
		// $this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('designation_name', 'Designation', 'trim|required|xss_clean');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$system = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		if($this->input->post('employees')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('project')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_project');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$data = array(
		'nip' => $this->input->post('employees'),
		'project_id' => $this->input->post('project'),
		);
		$result = $this->Project_model->add_akses_project($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_designation');
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
			$result = $this->Project_model->delete_akses_project($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_akses_project');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

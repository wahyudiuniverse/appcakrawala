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

class Project_posisi extends MY_Controller {
	
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
		$data['title'] = 'Mapping Project Posisi | '.$this->Xin_model->site_title();
		$data['all_subpro_active'] = $this->Project_model->get_sub_project_aktif();
		$data['all_jabatan'] = $this->Project_model->all_jabatan();

		// if($user_info[0]->user_role_id==1){
		// } else {
		// 	$data['all_projects'] = $this->Project_model->all_projects();
		// }
		
		$data['breadcrumbs'] = 'Mapping Project Posisi';
		$data['path_url'] = 'project_posisi';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('207',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/project/view_project_posisi", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load		  
		} else {
			redirect('admin/dashboard');
		}
  }
 

  public function project_posisi_list(){

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
		
		$project = $this->uri->segment(4);
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);


			if($project=="0" || is_null($project)){
				$projectpos = $this->Project_model->list_project_posisi();
				// $usermobile = $this->Usersmobile_model->user_mobile_limit();
			}else{
				$projectpos = $this->Project_model->list_project_posisi_id($project);
				// $usermobile = $this->Usersmobile_model->user_mobile_limit_fillter($company_id, $project_id, $subproject_id);
			}


		$data = array();

      foreach($projectpos->result() as $r) {

      $title = $r->title;
      $subproject = $r->sub_project;
      $subproject_name = $r->sub_project_name;
      $posisi_id = $r->posisi;
      $posisi_name = $r->designation_name;
      $sub_active = $r->sub_active;

      if($r->sub_active==1){
      	$status_aktif = $subproject. ' - Aktif';
      } else {
      	$status_aktif = $subproject. ' - Non Aktif';
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
					$title,
					$status_aktif,
					$subproject_name,
					$posisi_name
			  );
      }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $projectpos->num_rows(),
                 "recordsFiltered" => $projectpos->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }


	public function add_mapping_posisi() {	
	
		if($this->input->post('add_type')=='aksesproject') {
		// Check validation for user input
		// $this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('designation_name', 'Designation', 'trim|required|xss_clean');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$system = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		if($this->input->post('sub_project')==='') {
        $Return['error'] = 'Sub Project Blum dipilih...';
		} else if($this->input->post('posisi')==='') {
        $Return['error'] = 'Posisi/Jabatan Blum dipilih';
		} else if($this->Project_model->check_mapping_posisi($this->input->post('sub_project'), $this->input->post('posisi')) > 0) {
				$Return['error'] = "Mappingan sudah ada...!";
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    }

		$data = array(
		'sub_project' => $this->input->post('sub_project'),
		'posisi' => $this->input->post('posisi'),
		);
		$result = $this->Project_model->add_mapping_posisi($data);
		if ($result == TRUE) {
			$Return['result'] = 'Berhasil membuat mapping posisi baru...';
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
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
		} else if($this->Employees_model->check_akses_project($this->input->post('employees'), $this->input->post('project')) > 0) {
				$Return['error'] = "Akses project sudah ada...!";
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

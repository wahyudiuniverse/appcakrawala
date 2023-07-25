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

class bpjs extends MY_Controller 
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
		$this->load->model("Bpjs_model");
		$this->load->model("Import_model");

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
		$data['breadcrumbs'] = 'Saltab To BPJS';

		$data['all_employees'] = $this->Xin_model->all_employees();
		// $data['all_usermobile_type'] = $this->Xin_model->get_usermobile_type();
		$data['all_projects'] = $this->Xin_model->get_projects();
		$data['all_area'] = $this->Xin_model->get_area();
		$data['all_posisi'] = $this->Xin_model->get_designations();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'bpjs';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('470',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/bpjs/bpjs_saltab_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}


	public function usermobile_list() {

		$data['title'] = 'BPJS SALTAB';
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/bpjs/bpjs_saltab_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		// $company_id = $this->uri->segment(4);
		// $project_id = $this->uri->segment(5);
		// $subproject_id = $this->uri->segment(6);


		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);


		// if($project_id=="0" || is_null($project_id)){
		// 	$usermobile = $this->Usersmobile_model->user_mobile_limit();
		// }else{
		// 	$usermobile = $this->Usersmobile_model->user_mobile_limit_fillter($company_id, $project_id, $subproject_id);
		// }
		
			$usermobile = $this->Import_model->get_eslip_project();

		$data = array();

    foreach($usermobile->result() as $r) {

          	$uploadid = $r->uploadid;
          	$up_date = $r->up_date;
				  	$periode = $r->periode;
				  	$project = $r->project;
				  	$project_sub = $this->Xin_model->clean_post($r->project_sub);
				  	$total_mp = $r->total_mp;
				  	$createdby = $r->createdby;
				  		// $downloadby = '-';


				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-usermobile_id="'. $r->uploadid . '"><span class="fas fa-download" style="color:#25c103"></span></button></span>';


				  	$preiode_param = str_replace(" ","",$r->periode);
				  	$project_param = str_replace(" ","",$r->project);
				  	$project_sub_param = str_replace(")","",str_replace("(","",str_replace(" ","",$r->project_sub)));

			

				$view = '<a href="'.site_url().'admin/reports/saltab_bpjs/?upid='.$r->uploadid.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info">View Data</button></a>';


				  	if(is_null($r->downloadby) || $r->downloadby=='0'){
							$unduh =	$edit;
				  	} else {
							$unduh =	$r->downloadby;
				  	}


			  // get created
			  $empname = $this->Employees_model->read_employee_info_by_nik($createdby);
			  if(!is_null($empname)){
			  	$fullname = $empname[0]->first_name;
			  } else {
				  $fullname = '--';	
			  }

			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $view;
			  
		   $data[] = array(
				$combhr,
				$up_date,
				$periode,
				$project,
				$project_sub,
				$total_mp,
				$fullname,
				$unduh,
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
	


	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();

		// $keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		$keystring = $this->input->get('department_id');

			// if(!is_null($keywords[0])){

    		// $read_usermobile = $this->Usersmobile_model->read_users_mobile_by_nik($keywords[0]);

    	// 	$full_name = $read_employee[0]->first_name;

			// 	$all_projects = $this->Project_model->get_projects();
			// 	$all_usertype = $this->Usersmobile_model->get_usertype();
			// 	$all_area = $this->Xin_model->get_area();
			// 	// $all_area = $this->Usersmobile_model->get_district();

			// }

    		$read_employee = $this->Employees_model->read_employee_info($session['user_id']);
			// if(is_numeric($keywords[0])) {

			// 	$id = $keystring;
			// 	$id = $this->security->xss_clean($id);


			// }

			$data = array(
				'keywords' => $keystring,
				'downloadby' => $read_employee[0]->first_name,
				// 'usertype_id' => $read_usermobile[0]->usertype_id,
				// 'project_id' => $read_usermobile[0]->project_id,
				// 'areaid' => $read_usermobile[0]->areaid,
				// 'areaid_extra1' => $read_usermobile[0]->areaid_extra1,
				// 'areaid_extra2' => $read_usermobile[0]->areaid_extra2,
				// 'device_id' => $read_usermobile[0]->device_id_one,
				// 'all_usertype' => $all_usertype,
				// 'all_projects' => $all_projects,
				// 'all_area' => $all_area
				);
			$session = $this->session->userdata('username');
			
			if(!empty($session)){
				$this->load->view('admin/bpjs/dialog_bpjs_saltab', $data);
			} else {
				redirect('admin/');
			}
		
	}


	// Validate and update info in database
	public function update() { 
	

			$upid = $this->input->post('uploadid');
			$emp = $this->input->post('downloadby');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	


			$data = array(
			// 'downloadby' => $this->input->post('downloadby'),

			'downloadby' => $this->input->post('downloadby'),
			'downloadon' => date('Y-m-d h:i:s'),
			);

			// // $data = $this->security->xss_clean($data);
			$result = $this->Bpjs_model->update_bpjs_saltab($data,$upid);

			if ($result == TRUE) {
				$Return['result'] = 'Tandai Unduh Berhasil..';
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;

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
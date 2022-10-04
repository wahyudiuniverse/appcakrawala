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

class Callplan extends MY_Controller 
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
		$this->load->model("Callplan_model");
		$this->load->model("Customers_model");

		// $this->load->model("Project_model");
		// $this->load->model("Department_model");
		// $this->load->model("Location_model");
		// $this->load->model("Pkwt_model");
		// $this->load->model("Designation_model");
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

		$data['title'] = $this->lang->line('xin_callplan').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_callplan');

		$data['all_employees'] = $this->Xin_model->all_employees();
		// $data['all_project'] = $this->Xin_model->get_projects();
		// $data['all_posisi'] = $this->Xin_model->get_designations();
		// $data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'callplan';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('105',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/callplan/callplan_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else { 
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}


	public function callplan_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/callplan/callplan_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$callplan = $this->Callplan_model->get_callplan();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

    foreach($callplan->result() as $r) {
			  
			  $callplan_id = $r->callplan_id;
			  $nik = $r->user_id;
			  $cust_id = $r->customer_id;
			  $callplan_date = $r->callplan_date;
			  $sun = $r->sun;
			  $mon = $r->mon;
			  $tue = $r->tue;
			  $wed = $r->wed;
			  $thu = $r->thu;
			  $fri = $r->fri;
			  $sat = $r->sat;

				$now = new DateTime(date("Y-m-d"));

				$emp = $this->Employees_model->read_employee_info_by_nik($r->user_id);
				if(!is_null($emp)){
					$fullname = $emp[0]->first_name.' '.$emp[0]->last_name;
				} else {
					$fullname = '--';	
				}

				$customer = $this->Customers_model->read_single_customer($r->customer_id);
				if(!is_null($customer)){
					$customer_name = $customer[0]->customer_name;
				} else {
					$customer_name = '--';	
				}

				// $city = $this->Customers_model->read_city($r->city_id);
				// if(!is_null($city)){
				// 	$city_name = $city[0]->name;
				// } else {
				// 	$city_name = '--';	
				// }



				$coordinate ='

				<div class="text-success small text-truncate">
					<a href="#" class="" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_cust_latitude').'">Lat : '.$callplan_id.'

					</a>
				</div>

				<div class="text-success small text-truncate">
					<a href="#" class="" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_cust_longitude').'">Lon: '.$callplan_id.'

					</a>
				</div>';



			  if(in_array('38',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><a href="#"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
			} else {
				$edit = '';
			}


			if(in_array('34',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="#" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}

			$combhr = $edit.$view;

		   $data[] = array(
		   	$combhr,
				$callplan_id,
				$nik,
				$fullname,
				$cust_id,
				$customer_name,
				$callplan_date,
				$sun,
				$mon,
				$tue,
				$wed,
				$thu,
				$fri,
				$sat,
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $callplan->num_rows(),
                 "recordsFiltered" => $callplan->num_rows(),
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
		
		// $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('company_id', 'Company', 'trim|required|xss_clean');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		//if($this->form_validation->run() == FALSE) {
				//$Return['error'] = 'validation error.';
		//}
		/* Server side PHP input validation */
		// if($this->input->post('department_name')==='') {
  //       	$Return['error'] = $this->lang->line('error_department_field');
		// } else if($this->input->post('company_id')==='') {
		// 	$Return['error'] = $this->lang->line('error_company_field');
		// } else if($this->input->post('location_id')==='') {
		// 	$Return['error'] = $this->lang->line('xin_location_field_error');
		// } 
		// if($Return['error']!=''){
			
  //      		$this->output($Return);
  //   	}
	
		$data = array(
		'employee_id' => $this->input->post('employees'),
		'project_id' => $this->input->post('project'),
		'posisi_id' => $this->input->post('posisi'),
		// 'device_id_one' => $this->input->post('device_id'),
		// 'createdby' => $session,

		
		);

		// $data = $this->security->xss_clean($data);
		$result = $this->Usersmobile_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_department');
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
    		$full_name = $read_employee[0]->first_name.' '.$read_employee[0]->last_name;

				$all_projects = $this->Project_model->get_projects();

			}

		// if(is_numeric($keywords[0])) {

		// 	$id = $keywords[0];
		// 	$id = $this->security->xss_clean($id);


		// }

			$data = array(
				'usermobile_id' => $keywords[0],
				'fullname' => $full_name,
				'project_id' => $read_usermobile[0]->project_id,
				'device_id' => $read_usermobile[0]->device_id_one,
				'all_projects' =>$all_projects
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
			'project_id' => $this->input->post('project'),
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


} 
?>
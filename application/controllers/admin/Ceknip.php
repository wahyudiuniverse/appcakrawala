<?php
  /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author   dndsoft
 * @author-email  komputer.dnd@gmail.com
 * @copyright  Copyright © dndsoft.my.id All Rights Reserveds
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ceknip extends MY_Controller {
	
		public function __construct() {
      parent::__construct();
			//load the models
			$this->load->model("Employees_model");
			$this->load->model("Xin_model");
			$this->load->model("Department_model");
			$this->load->model("Designation_model");
			$this->load->model("Roles_model");
			$this->load->model("Location_model");
			$this->load->model("Company_model");
			$this->load->model("Timesheet_model");
			$this->load->model("Custom_fields_model");
			$this->load->model("Assets_model");
			$this->load->model("Training_model");
			$this->load->model("Trainers_model");
			$this->load->model("Awards_model");
			$this->load->model("Travel_model");
			$this->load->model("Tickets_model");
			$this->load->model("Transfers_model");
			$this->load->model("Promotion_model");
			$this->load->model("Complaints_model");
			$this->load->model("Warning_model");
			$this->load->model("Project_model");
			$this->load->model("Payroll_model");
			$this->load->model("Events_model");
			$this->load->model("Meetings_model");
			$this->load->model('Exin_model');
			$this->load->model('Pkwt_model');
			$this->load->library("pagination");
			$this->load->library('Pdf');
			$this->load->helper('string');
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
			$role_resources_ids = $this->Xin_model->user_role_resource();
			$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
			$data['all_departments'] = $this->Department_model->all_departments();
			$data['all_designations'] = $this->Designation_model->all_designations();
			$data['all_user_roles'] = $this->Roles_model->all_user_roles();
			$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
			$data['get_all_companies'] = $this->Xin_model->get_companies();
			$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
			$data['breadcrumbs'] = $this->lang->line('xin_employees');

			// if(!in_array('13',$role_resources_ids)) {
			// 	$data['path_url'] = 'myteam_employees';
			// } else {
				$data['path_url'] = 'employees';
			// }
		
			// reports to 
	 		$reports_to = get_reports_team_data($session['user_id']);
			if(in_array('134',$role_resources_ids) || $reports_to > 0) {
				if(!empty($session)){ 
					$data['subview'] = $this->load->view("admin/employees/employees_list", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard');
			}
	}

 
  public function employees_list() {

			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$this->load->view("admin/employees/employees_list", $data);
			} else {
				redirect('admin/');
			}
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$role_resources_ids = $this->Xin_model->user_role_resource();		
			$system = $this->Xin_model->read_setting_info(1);
			$user_info = $this->Xin_model->read_user_info($session['user_id']);

			if($user_info[0]->user_role_id == '1' || $user_info[0]->user_role_id == '3' || $user_info[0]->user_role_id == '4'){

			$employee = $this->Employees_model->get_employees_who();
			} else {

			$employee = $this->Employees_model->get_employees_notho();
			}


			$data = array();

			foreach($employee->result() as $r) {

				// user full name 
				$full_name = $r->first_name;
				$area = $r->penempatan;
				if($r->user_role_id==2){
					$role = '['.$r->user_role_id.'] '.'Employee';
				} else if ($r->user_role_id==3) {
					$role = '['.$r->user_role_id.'] '.'HRD Admin';
				} else if ($r->user_role_id==4){
					$role = '['.$r->user_role_id.'] '.'HRD Admin';
				} else if ($r->user_role_id==8){
					$role = '['.$r->user_role_id.'] '.'NAE/ADMIN';
				} else if ($r->user_role_id==9){
					$role = '['.$r->user_role_id.'] '.'RESIGN';
				} else if ($r->user_role_id==10){
					$role = '['.$r->user_role_id.'] '.'PAYROLL ADMIN';
				} else if ($r->user_role_id==11){
					$role = '['.$r->user_role_id.'] '.'IT SUPPORT';
				} else if ($r->user_role_id==12){
					$role = '['.$r->user_role_id.'] '.'HEAD OF PAYROLL';
				} else if ($r->user_role_id==13){
					$role = '['.$r->user_role_id.'] '.'NOM';
				} else if ($r->user_role_id==14){
					$role = '['.$r->user_role_id.'] '.'TEAM LEADER';
				} else if ($r->user_role_id==15){
					$role = '['.$r->user_role_id.'] '.'BPJS ADMIN';
				} else if ($r->user_role_id==16){
					$role = '['.$r->user_role_id.'] '.'AREA MANAGER';
				} else {
					$role = $r->user_role_id;
				}
				

			$ename = '<a href="'.site_url().'admin/employees/emp_edit/'.$r->employee_id.'" class="d-block text-primary" target="_blank">'.$r->employee_id.'</a>'; 


			$copypaste = '*Payroll Notification -> Elektronik SLIP.*%0a%0a

			Yang Terhormat Bapak/Ibu Karyawan PT. Siprama Cakrawala, telah terbit dokumen E-SLIP Periode September 2023, segera Login C.I.S untuk melihat lebih lengkap.%0a%0a

			Lakukan Pembaharuan PIN anda secara berkala, dengan cara Login C.I.S kemudian akses Menu My Profile dan Ubah PIN.%0a%0a

			Link C.I.S : https://apps-cakrawala.com/admin%0a

			*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a
			
			Terima kasih.';



			$whatsapp = '<a href="https://wa.me/62'.$r->contact_no.'?text='.$copypaste.'" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-success">'.$r->contact_no.'</button> </a>';


			// $role_status = $role_name;
			$data[] = array(
				$ename,
				$r->ktp_no,
				$full_name,
				$r->title,
				$r->designation_name,
				$r->penempatan,
				$whatsapp,
				$r->date_of_birth,
				$r->last_login_date,
				$role
			);

	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }




}

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

class Dashboard extends MY_Controller {

	public function __construct()
     {
          parent::__construct();
          //load the models
          $this->load->model('Login_model');
		  $this->load->model('Pkwt_model');
		  $this->load->model('Designation_model');
		  $this->load->model('Department_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Xin_model');
		  // $this->load->model('Exin_model');
		  // $this->load->model('Expense_model');
		  // $this->load->model('Timesheet_model');
		  // $this->load->model('Travel_model');
		  // $this->load->model('Training_model');
		  $this->load->model('Project_model');
		  // $this->load->model('Job_post_model');
		  // $this->load->model('Goal_tracking_model');
		  // $this->load->model('Events_model');
		  // $this->load->model('Meetings_model');
		  // $this->load->model('Announcement_model');
		  // $this->load->model('Clients_model');
		  // $this->load->model("Recruitment_model");
		  // $this->load->model('Tickets_model');
		  // $this->load->model('Assets_model');
		  // $this->load->model('Awards_model');
		  $this->load->model('Esign_model');
		  // $this->load->model('Pkwt_model');
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
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks=='true'){
			// get user > added by
			$user = $this->Xin_model->read_user_info($session['user_id']);
			// get designation
			$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
			if(!is_null($designation)){
				$des_emp = $designation[0]->designation_name;
			} else {
				$des_emp = '--';
			}
			// get designation
			// $department = $this->Department_model->read_department_information($user[0]->department_id);
			// if(!is_null($department)){
			// 	$dep_emp = $department[0]->department_name;
			// } else {
			// 	$dep_emp = '--';
			// }
			$data = array(
			'title' => $this->lang->line('dashboard_title').' | '.$this->Xin_model->site_title(),
			'path_url' => 'dashboard',
			'first_name' => $user[0]->first_name,
			'last_name' => $user[0]->last_name,
			'employee_id' => $user[0]->employee_id,
			'username' => $user[0]->username,
			'email' => $user[0]->email,
			'designation_name' => $des_emp,
			'department_name' => 'Department',
			'date_of_birth' => $user[0]->date_of_birth,
			'date_of_joining' => $user[0]->date_of_joining,
			'contact_no' => $user[0]->contact_no,
			// 'last_four_employees' => $this->Xin_model->last_four_employees(),
			// 'get_last_payment_history' => $this->Xin_model->get_last_payment_history(),
			// 'all_holidays' => $this->Timesheet_model->get_holidays_calendar(),
			// 'all_leaves_request_calendar' => $this->Timesheet_model->get_leaves_request_calendar(),
			// 'all_upcoming_birthday' => $this->Xin_model->employees_upcoming_birthday(),
			// 'all_travel_request' => $this->Travel_model->get_travel(),
			// 'all_training' => $this->Training_model->get_training(),
			// 'all_projects' => $this->Project_model->get_projects(),
			// 'all_tasks' => $this->Timesheet_model->get_tasks(),
			// 'all_goals' => $this->Goal_tracking_model->get_goal_tracking(),
			// 'all_events' => $this->Events_model->get_events(),
			// 'all_meetings' => $this->Meetings_model->get_meetings(),
			// 'all_jobsx' => $this->Job_post_model->five_latest_jobs(),
			// 'all_jobs' => $this->Recruitment_model->get_all_jobs_last_desc()
			);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
		// get user > added by
		$user = $this->Xin_model->read_user_info($session['user_id']);
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		// get designation
		// $department = $this->Department_model->read_department_information($user[0]->department_id);
		$data = array(
			'title' => $this->Xin_model->site_title(),
			'path_url' => 'dashboard',
			'first_name' => $user[0]->first_name,
			'last_name' => $user[0]->last_name,
			'employee_id' => $user[0]->employee_id,
			'username' => $user[0]->username,
			'email' => $user[0]->email,
			'designation_name' => $designation[0]->designation_name,
			'department_name' => 'Department',
			'date_of_birth' => $user[0]->date_of_birth,
			'date_of_joining' => $user[0]->date_of_joining,
			'contact_no' => $user[0]->contact_no,
			// 'last_four_employees' => $this->Xin_model->last_four_employees(),
			// 'get_last_payment_history' => $this->Xin_model->get_last_payment_history(),
			// 'all_holidays' => $this->Timesheet_model->get_holidays_calendar(),
			// 'all_leaves_request_calendar' => $this->Timesheet_model->get_leaves_request_calendar(),
			// 'all_upcoming_birthday' => $this->Xin_model->employees_upcoming_birthday(),
			// 'all_travel_request' => $this->Travel_model->get_travel(),
			// 'all_training' => $this->Training_model->get_training(),
			// 'all_projects' => $this->Project_model->get_projects(),
			// 'all_tasks' => $this->Timesheet_model->get_tasks(),
			// 'all_goals' => $this->Goal_tracking_model->get_goal_tracking(),
			// 'all_events' => $this->Events_model->get_events(),
			// 'all_meetings' => $this->Meetings_model->get_meetings(),
			// 'all_jobsx' => $this->Job_post_model->all_jobs(),
			// 'all_jobs' => $this->Recruitment_model->get_all_jobs_last_desc()
			);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		}
	}
	
	
	// hrpremium notifications
	public function notifications()
	{
		/* Define return | here result is used to return user data and error for error message */
		$data['title'] = $this->lang->line('header_notifications').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('header_notifications');
		//$this->load->view('admin/settings/hrpremium_notifications', $data);
		$data['subview'] = $this->load->view("admin/settings/hrpremium_notifications", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		
		//$this->output($Return);
		//exit;
	}
	
	// set new language
	public function set_language($language = "") {
        
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
        redirect($_SERVER['HTTP_REFERER']);
        
    }
}

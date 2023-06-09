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

class Esign extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Pkwt_model");
		$this->load->model("Esign_model");
		$this->load->helper('string');
		$this->load->library('email');
	}
	

	 public function index() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'E-Sign PT. Siprama Cakrawala';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_dept'] = $this->Xin_model->get_departments();
		$data['all_designation'] = $this->Xin_model->get_designations();
		$data['all_project'] = $this->Xin_model->get_projects();
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrpremium/esign_view", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
    }  

	public function doc() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$nodoc = $this->uri->segment(3);
		$srcdoc = $this->Pkwt_model->read_esign_doc($nodoc);

		$data['title'] = 'E-Sign PT. Siprama Cakrawala';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_dept'] = $this->Xin_model->get_departments();
		$data['all_designation'] = $this->Xin_model->get_designations();
		$data['all_project'] = $this->Xin_model->get_projects();
		$data['nodoc']= $srcdoc[0]->nomor_dokumen;
		$data['release_date'] = $this->Xin_model->tgl_indo(substr($srcdoc[0]->createdat,0,10));
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrpremium/esign_view", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
    }  

	public function sk() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$nodoc = $this->uri->segment(3);
		$srcdoc = $this->Esign_model->read_skk_by_doc($nodoc);

		$data['title'] = 'E-Sign PT. Siprama Cakrawala';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_dept'] = $this->Xin_model->get_departments();
		$data['all_designation'] = $this->Xin_model->get_designations();
		$data['all_project'] = $this->Xin_model->get_projects();
		$data['nodoc']= $srcdoc[0]->nomor_dokumen;
		$data['sign_fullname']= $srcdoc[0]->sign_fullname;
		$data['sign_nip'] = $srcdoc[0]->sign_nip;
		$data['sign_company'] = $this->Company_model->read_company_information($srcdoc[0]->sign_company);
		$data['release_date']= $this->Xin_model->tgl_indo(substr($srcdoc[0]->createdon,0,10));
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrpremium/esign_view", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
    }  

	public function pkwt() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$nodoc = $this->uri->segment(3);
		$srcdoc = $this->Esign_model->read_pkwt_by_doc($nodoc);

		$data['title'] = 'E-Sign PT. Siprama Cakrawala';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_dept'] = $this->Xin_model->get_departments();
		$data['all_designation'] = $this->Xin_model->get_designations();
		$data['all_project'] = $this->Xin_model->get_projects();
		$data['nodoc']= $srcdoc[0]->no_surat;

		$data['sign_fullname']= $srcdoc[0]->sign_fullname;
		$data['sign_nip'] = $srcdoc[0]->sign_nip;
		
		$data['sign_company'] = $this->Company_model->read_company_information($srcdoc[0]->company);
		$data['release_date']= $this->Xin_model->tgl_indo(substr($srcdoc[0]->approve_hrd_date,0,10));
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrpremium/esign_view", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
  }  

	public function signup() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Sign Up';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_dept'] = $this->Xin_model->get_departments();
		$data['all_designation'] = $this->Xin_model->get_designations();
		$data['all_project'] = $this->Xin_model->get_projects();
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrpremium/register", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
  }

	 public function dashboard() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['title'] = 'Dashboard';
		$data['path_url'] = 'job_home';
		$data['subview'] = $this->load->view("frontend/hrpremium/dashboard", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
     }
	
	
	public function send_mail() {
				
		if($this->input->post('type')=='fpassword') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			/* Server side PHP input validation */
			if($this->input->post('iemail')==='') {
				$Return['error'] = $this->lang->line('xin_error_enter_email_address');
			} else if(!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if($this->input->post('iemail')) {
		
				//$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(2);
				//get employee info
				$query = $this->Xin_model->read_user_jobs_byemail($this->input->post('iemail'));
				
				$user = $query->num_rows();
				if($user > 0) {
					
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
					//$cid = $this->email->attachment_cid($logo);
					
					$message = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->email,$user_info[0]->password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
					$this->email->to($this->input->post('iemail'));
					
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
					$Return['result'] = $this->lang->line('xin_success_sent_forgot_password');
					$this->session->set_flashdata('sent_message', $this->lang->line('xin_success_sent_forgot_password'));
				} else {
					/* Unsuccessful attempt: Set error message */
					$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
				}
				$this->output($Return);
				exit;
			}
		}
	}
}

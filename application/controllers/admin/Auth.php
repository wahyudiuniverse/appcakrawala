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

class Auth extends MY_Controller
{
	
	public function __construct()
     {
          parent::__construct();
			//load the model
			/*	$this->load->library('session');
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->database();
			$this->load->library('form_validation');*/
		
			$this->load->model('Login_model');
			$this->load->model('Employees_model');
			$this->load->model('Users_model');
			$this->load->library('email');
			$this->load->library('Session');
			$this->load->model("Xin_model");
			$this->load->model("Designation_model");
			$this->load->model("Department_model");
			$this->load->model("Location_model");
      $this->load->helper('shared');
      // $this->CI->load->library('Rest_Controller');

     }
	 
	 /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	 
	public function login() {
	
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		//$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		/*if ($this->form_validation->run() == FALSE)
		{
				//$this->load->view('myform');
		}*/
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($username==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} elseif($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->Login_model->login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_information($username);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'employee_id' => $result[0]->employee_id,
				'email' => $result[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('user_id', $session_data);
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('employee_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->session->set_flashdata('expire_official_document', 'expire_official_document');
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
	}
	public function login_pincode() {
	
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		//$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$pincode = $this->input->post('ipincode');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($pincode==='') {
			$Return['error'] = $this->lang->line('xin_enter_pincode');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$data = array(
			'pincode' => $pincode,
			);
		$result = $this->Login_model->pincode_login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_info_pin($pincode);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('user_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->session->set_flashdata('expire_official_document', 'expire_official_document');
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_invalid_pincode');
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
	}
	
	// forgot password.	
	public function forgot_password() {
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$this->load->view('admin/auth/forgot_password', $data);
	}
	
	// unlock user.	
	public function lock() {
		
		//$session_id = $this->session->userdata('user_id');
		$data['title'] = $this->lang->line('xin_lock_user');

		$session = $this->session->userdata('username');
		$this->session->unset_userdata('username');
		$Return['result'] = 'Locked User.';
		$this->load->view('admin/auth/user_lock', $data);
	}
	
	//unlock user.
	public function unlock() {
	
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$password = $this->input->post('ipassword');
		$session_id = $this->session->userdata('user_id');
		$iresult = $this->Login_model->read_user_info_session_id($session_id['user_id']);
		
		/* Server side PHP input validation */
		if($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$system = $this->read_setting_info(1);
		if($system[0]->employee_login_id=='username'):
			$username = $iresult[0]->username;
		else:
			$username = $iresult[0]->email;
		endif;
		//
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->Login_model->login($data);	
		
		if ($result == TRUE) {
			
				//$result = $this->Login_model->read_user_information($username);
				$session_data = array(
				'user_id' => $iresult[0]->user_id,
				'username' => $iresult[0]->username,
				'email' => $iresult[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('user_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				$last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $iresult[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$this->output($Return);
			}
		}
	
	public static function AlphaNumeric($length)
      {
          $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
          $clen   = strlen( $chars )-1;
          $id  = '';

          for ($i = 0; $i < $length; $i++) {
                  $id .= $chars[mt_rand(0,$clen)];
          }
          return ($id);
      }
	  
	public function send_mail() {
				
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
	
			$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(2);
			//get employee info
			$query = $this->Xin_model->read_user_info_byemail($this->input->post('iemail'));
			
			$user = $query->num_rows();
			if($user > 0) {
				
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;				
				$body = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var email}"),array($cinfo[0]->company_name,site_url(),$user_info[0]->email),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrpremium_mail($cinfo[0]->email,$cinfo[0]->company_name,$this->input->post('iemail'),$subject,$body);			
				$Return['result'] = $this->lang->line('xin_reset_password_link_success_sent_email');
			} else {
				/* Unsuccessful attempt: Set error message */
				$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function reset_password() {
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->get('change') == 'true'){
				
			if($this->input->get('email')) {
		
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(17);
				//get employee info
				$query = $this->Xin_model->read_user_info_byemail($this->input->get('email'));
				
				$user = $query->num_rows();
				if($user > 0) {
					
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					//$cid = $this->email->attachment_cid($logo);
					$password = $this->AlphaNumeric(15);
					$options = array('cost' => 12);
					$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
					$last_data = array(
						'password' => $password_hash,
					); 
					
					$id = $user_info[0]->user_id; // user id
					  
					$this->Xin_model->login_update_record($last_data, $id);
					
				$body = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;"><img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->username,$user_info[0]->pincode,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					hrpremium_mail($cinfo[0]->email,$cinfo[0]->company_name,$this->input->get('email'),$subject,$body);				
					$this->session->set_flashdata('reset_password_success', 'reset_password_success');
					redirect(site_url('admin/'));
				} else {
					/* Unsuccessful attempt: Set error message */
					//$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
				}
				//$this->output($Return);
				//exit;
			}
		}
	}



    public function login_cis() {
        $status 			= 1; $message = ''; $data = null;
        $apiName 			= "apicakrawala/auth/login_cis";

        // $nip 					= $this->input->post('nip'); 
        $nip 					= $_GET['nip'];
        // $pin 					= $this->input->post('pin');
        $pin 					= $_GET['pin'];

        $isnip 				= $this->isNullField($nip);
        $ispin 				= $this->isNullField($pin);

        if ($isnip || $ispin) {

	            restOutput(0, "NIP atau PIN Kosong.", new stdClass());
        	// $this->response(0, "NIP atau PIN Kosong.", new stdClass());

	        }else{

			      $isNIKExists = $this->isNIKExists($nip, $pin);
						$token = null;
						if($isNIKExists->STATUS){

							$data = array(
								"employee_id" => $isNIKExists->EMPLOYEE_ID,
								"fullname" => $isNIKExists->FULLNAME,
								"status_emp" => $isNIKExists->STATUS_EMP,
								"userrole" => $isNIKExists->USERROLE,
								"approle" => $isNIKExists->APPROLE,
								"project_akses" => $isNIKExists->PROJECT_ID,
								"profile_picture" => $isNIKExists->PROFILE_PICTURE

							);

							restOutput($isNIKExists->STATUS, $isNIKExists->MESSAGE, $data);

						} else {

							restOutput($isNIKExists->STATUS, $isNIKExists->MESSAGE, new stdClass());


						}

	    		}
    		}



    private function isNIKExists($nip, $pin) {
//         $q = $this->db->query("
//         	SELECT emp.user_id, emp.employee_id, emp.first_name, emp.is_active, emp.status_employee, emp.user_role_id, approle.role_resources 
// FROM xin_employees emp
// LEFT JOIN xin_user_roles approle ON approle.role_id=emp.user_role_id
// WHERE employee_id = $nip 
// AND private_code = $pin 
// AND is_active = 1;");

        $q = $this->db->query("SELECT emp.user_id, emp.employee_id, emp.first_name, emp.is_active, emp.status_employee, emp.user_role_id, approle.role_resources, ps.project_id
FROM xin_employees emp
LEFT JOIN xin_user_roles approle ON approle.role_id=emp.user_role_id
LEFT JOIN (SELECT nip, GROUP_CONCAT(project_id ORDER BY project_id ASC SEPARATOR ', ') AS project_id FROM xin_projects_akses WHERE nip = $nip) ps ON ps.nip = emp.employee_id
WHERE emp.employee_id = $nip 
AND emp.private_code = $pin 
AND emp.is_active = 1;");


        $status = 1;
        $employeeID = $fullname = $message = null;

        if ($q->num_rows() == 1) {
            $rows = $q->row();

            $message = "success";
            $isActive = $rows->is_active;
			$employeeID = $rows->employee_id;
            $fullname = $rows->first_name;
            $userRole = $rows->user_role_id;
            $appRole = $rows->role_resources;
            $project_id = $rows->project_id;
            $profile_picture = 'https://apps-cakrawala.com/uploads/profile/'.$rows->profile_picture;
            if($rows->status_employee==1){
            	$status_emp = "AKTIF";
            } else if ($rows->status_employee==2){
            	$status_emp = "RESIGN";
            } else if ($rows->status_employee==3){
            	$status_emp = "BLACKLIST";
            } else if ($rows->status_employee==4){
            	$status_emp = "END CONTRACT";
            } else if ($rows->status_employee==5){
            	$status_emp = "DEACTIVE";
            } else {
	            $status_emp = $rows->status_employee;			
            }


            if ($isActive != 1) {
                $status = 0;
                $message = "NIP anda sudah tidak aktif, Hubungi admin untuk informasi lengkapnya.";
								$isActive = "";
								$employeeID = "";
								$fullname = "";
            					$status_emp = "";	
								$userRole = "";
								$appRole = "";
								$project_id = "";
								$profile_picture = "";

            } 

        }  else {
            $status = 0;
            $message = "NIP atau PIN salah, Hubungi admin untuk informasi lengkapnya.";
						$isActive = "";
						$employeeID = "";
						$fullname = "";
            			$status_emp = "";
						$userRole = "";
						$appRole = "";
						$project_id = "";
						$profile_picture = "";
				
        }
      
        return (object) [
            'STATUS' => $status,
            'MESSAGE' => $message,
            'EMPLOYEE_ID' => $employeeID,
            'FULLNAME' => $fullname,
            'STATUS_EMP' => $status_emp,
            'USERROLE' => $userRole,
            'APPROLE' => $appRole,
            'PROJECT_ID' => $project_id,
            'PROFILE_PICTURE' => $profile_picture,
        ];
    }


    private function isNullField($data) {
        if (is_null($data) || trim($data) == '') {
            return true;
        } else {
            return false;
        }
    }

} 
?>
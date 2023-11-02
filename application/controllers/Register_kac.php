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

class register_kac extends MY_Controller {
	
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
		$this->load->model("Recruitment_model");
		$this->load->model("Project_model");

		$this->load->helper('string');
		$this->load->library('email');
	}
	

	public function index() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'FORM KARYAWAN BARU <br>PT. KRISTA AULIA CAKRAWALA	';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_ethnicity'] = $this->Xin_model->get_ethnicity_type();
		$data['all_dept'] = $this->Xin_model->get_departments();
		// $data['all_project'] = $this->Project_model->get_designations();
		$data['all_project'] = $this->Project_model->read_project_posisi_kac();
		$data['path_url'] = 'register_projects_kac';
		$data['subview'] = $this->load->view("frontend/hrpremium/register_project_kac", $data, TRUE);
		// $data['subview'] = $this->load->view("frontend/hrpremium/register_stop", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
  }


	// Validate and add info in database
	public function tambah_kandidat() {
	
		if($this->input->post('add_type')=='employer') {

			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// $valid_email = $this->Users_model->check_user_email($this->input->post('email'));
			// $options = array('cost' => 12);
			// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			/* Server side PHP input validation */
			// if($this->input->post('company_id')==='') {
			// 	$Return['error'] = $this->lang->line('xin_employee_error_company_name');
			// } else 
			// $ktp_active = $this->Employees_model->ktp_exist_active('3211819015500007');

			if($this->input->post('first_name')==='') {
				$Return['error'] = "Nama Lengkap Kosong...";
			} else if( $this->input->post('tempat_lahir')==='') {
				$Return['error'] = "Tempat Lahir Kosong";
			} else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = "Tanggal Lahir Kosong...";
			} else if($this->input->post('alamat_domisili')==='') {
				$Return['error'] = "Alamat Domisili Kosong...";
			} else if($this->input->post('alamat_ktp')==='') {
				$Return['error'] = "Alamat KTP Kosong...";
			} else if($this->input->post('contact_number')==='') {
				$Return['error'] = 'Nomor Kotak belum diisi';
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = "Alamat Email Tidak Sesuai...";
			} else if($this->input->post('nomor_ktp')==='') {
				$Return['error'] = "Nomor KTP Kosong";
			} else if($this->input->post('nomor_kk')==='') {
				$Return['error'] = "Nomor KK Kosong...";
			} else if($this->input->post('ibu_kandung')==='') {
				$Return['error'] = "Nama Ibu Kandung Kosong...";
			} else if($this->input->post('jenis_kelamin')==='') {
				$Return['error'] = "Jenis Kelamin Kosong...";
			} else if($this->input->post('agama')==='') {
				$Return['error'] = "Agama Kosong...";
			} else if($this->input->post('pernikahan')==='') {
				$Return['error'] = "Status Pernikahan Kosong...";
			} else if($this->input->post('tinggi_badan')==='') {
				$Return['error'] = "Tinggi Badan Kosong...";
			} else if($this->input->post('berat_badan')==='') {
				$Return['error'] = "Berat Badan Kosong...";
			} else if($this->input->post('last_company')==='') {
				$Return['error'] = "Perusahaan Sebelum nya Kosong...";
			} else if($this->input->post('last_posisi')==='') {
				$Return['error'] = "Posisi Sebelumnya Kosong...";
			} else if($this->input->post('last_edu')==='') {
				$Return['error'] = "Pendidikan Terakhir Kosong...";
			} else if($this->input->post('school_name')==='') {
				$Return['error'] = "Nama Sekolah Kosong...";
			} else if($this->input->post('jurusan')==='') {
				$Return['error'] = "Jurusan Kosong...";
			} else if($this->input->post('project_id')==='') {
				$Return['error'] = 'Project belum dipilih';
			} else if($this->input->post('subproject_id')===''){
				$Return['error'] = 'Sub Project belum dipilih';
			} else if($this->input->post('posisi_id')==='') {
				$Return['error'] = "Posisi/Jabatan Kosong...";
			} else if($this->input->post('penempatan')==='') {
				$Return['error'] = "Penempatan Kosong...";
			} else if($this->input->post('bank_name')==='') {
				$Return['error'] = "Nama Bank Kosong...";
			} else if($this->input->post('nomor_rek')==='') {
				$Return['error'] = "Nomor Rekening Kosong...";
			} else if($this->input->post('pemilik_rek')==='') {
				$Return['error'] = "Pemilik Rekening Kosong...";
			} else if($_FILES['foto_ktp']['size'] == 0) {
				$Return['error'] = 'Foto KTP Masih Kosong...';
			} else if($_FILES['foto_kk']['size'] == 0) {
				$Return['error'] = 'Foto KK Masih Kosong...';
			} else if($_FILES['dokumen_cv']['size'] == 0) {
				$Return['error'] = 'Dokumen CV Masih Kosong...';
			} else if ($_FILES['dokumen_cv']['size'] > 2150000) {
				$Return['error'] = 'File CV Lebih dari 2MB..';
			} else if ($_FILES['foto_ktp']['size'] > 2150000) {
				$Return['error'] = 'Foto KTP Lebih dari 2MB..';
			} else if ($_FILES['foto_kk']['size'] > 2150000) {
				$Return['error'] = 'Foto KK Lebih dari 2MB..';
			}

			// else if($valid_email->num_rows() > 0) {
			// 	$Return['error'] = $this->lang->line('xin_rec_email_exists');
			// } 

				else {


					$ktp_exist_blacklist = $this->Employees_model->ktp_exist_blacklist($this->input->post('nomor_ktp'));

					$ktp_exist_active = $this->Employees_model->ktp_exist_active($this->input->post('nomor_ktp'));

					$ktp_exist_regis = $this->Employees_model->ktp_exist_regis($this->input->post('nomor_ktp'));
					
					if($ktp_exist_blacklist!=0) {

						$Return['error'] = 'NIK KTP sudah di BLACKLIST oleh SISTEM CAKRAWALA.';

					} else if ($ktp_exist_active!=0) {

						$Return['error'] = 'NIK KTP Sudah terdaftar dengan Status AKTIF sebegai karyawan di SISTEM CAKRAWALA.';
						
					} else if ($ktp_exist_regis!=0) {

						$Return['error'] = 'NIK KTP sudah ada di DAFTAR KARYAWAN BARU.';

					} else {

									if(is_uploaded_file($_FILES['foto_ktp']['tmp_name'])) {
										//checking image type
										$allowed =  array('png','jpg','jpeg','pdf');
										$filename = $_FILES['foto_ktp']['name'];
										$ext = pathinfo($filename, PATHINFO_EXTENSION);
										
										if(in_array($ext,$allowed)) {
											$tmp_name = $_FILES["foto_ktp"]["tmp_name"];
											$documentd = "uploads/document/ktp/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["foto_ktp"]["name"]);
											$newfilename = 'ktp_'.$this->input->post('nomor_ktp').'.'.$ext;
											move_uploaded_file($tmp_name, $documentd.$newfilename);
											$fname = $newfilename;
										} else {
											$Return['error'] = 'Jenis File KTP tidak diterima..';
										}
									}

									if(is_uploaded_file($_FILES['foto_kk']['tmp_name'])) {
										//checking image type
										$allowedkk =  array('png','jpg','jpeg','pdf');
										$filenamekk = $_FILES['foto_kk']['name'];
										$extkk = pathinfo($filenamekk, PATHINFO_EXTENSION);
										
										if(in_array($extkk,$allowedkk)){
											$tmp_namekk = $_FILES["foto_kk"]["tmp_name"];
											$documentdkk = "uploads/document/kk/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["foto_kk"]["name"]);
											$newfilenamekk = 'kk_'.$this->input->post('nomor_ktp').'.'.$extkk;
											move_uploaded_file($tmp_namekk, $documentdkk.$newfilenamekk);
											$fnamekk = $newfilenamekk;
										} else {
											$Return['error'] = 'Jenis File KK tidak diterima..';
										}
									}

								if($_FILES['foto_npwp']['size'] == 0) {
									$fnamenpwp = '0';
								} else {
									if(is_uploaded_file($_FILES['foto_npwp']['tmp_name'])) {
										//checking image type
										$allowednpwp =  array('png','jpg','jpeg','pdf');
										$filenamenpwp = $_FILES['foto_npwp']['name'];
										$extnpwp = pathinfo($filenamenpwp, PATHINFO_EXTENSION);
										
										if(in_array($extnpwp,$allowednpwp)) {
											$tmp_namenpwp = $_FILES["foto_npwp"]["tmp_name"];
											$documentnpwp = "uploads/document/npwp/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["foto_npwp"]["name"]);
											$newfilenamenpwp = 'npwp_'.$this->input->post('nomor_ktp').'.'.$extnpwp;
											move_uploaded_file($tmp_namenpwp, $documentnpwp.$newfilenamenpwp);
											$fnamenpwp = $newfilenamenpwp;
										} else {
											$Return['error'] = 'Jenis File PKWT tidak diterima..';
										}
									}
								}

								if($_FILES['foto_skck']['size'] == 0){
									$fnameskck = '0';
								} else {
									if(is_uploaded_file($_FILES['foto_skck']['tmp_name'])) {
										//checking image type
										$allowedskck =  array('png','jpg','jpeg','pdf');
										$filenameskck = $_FILES['foto_skck']['name'];
										$extskck = pathinfo($filenameskck, PATHINFO_EXTENSION);
										
										if(in_array($extskck,$allowedskck)){
											$tmp_nameskck = $_FILES["foto_skck"]["tmp_name"];
											$documentskck = "uploads/document/skck/";
											// basename() may prevent filesystem traversal attacks;
											// further validation/sanitation of the filename may be appropriate
											$name = basename($_FILES["foto_skck"]["name"]);
											$newfilenameskck = 'skck_'.$this->input->post('nomor_ktp').'.'.$extskck;
											move_uploaded_file($tmp_nameskck, $documentskck.$newfilenameskck);
											$fnameskck = $newfilenameskck;
										} else {
											$Return['error'] = 'Jenis File PKWT tidak diterima..';
										}
									}
								}

									if(is_uploaded_file($_FILES['dokumen_cv']['tmp_name'])) {
											//checking image type
											$allowedcv =  array('png','jpg','jpeg','pdf');
											$filenamecv = $_FILES['dokumen_cv']['name'];
											$extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
											
											if(in_array($extcv,$allowedcv)){
												$tmp_namecv = $_FILES["dokumen_cv"]["tmp_name"];
												$yearmonth = date('Y/m');
												$documentdcv = "uploads/document/cv/".$yearmonth.'/';
												// basename() may prevent filesystem traversal attacks;
												// further validation/sanitation of the filename may be appropriate
												$name = basename($_FILES["dokumen_cv"]["name"]);
												$newfilenamecv = 'cv_'.$this->input->post('nomor_ktp').'_'.round(microtime(true)).'.'.$extcv;
												move_uploaded_file($tmp_namecv, $documentdcv.$newfilenamecv);
												$fnamecv = 'https://apps-cakrawala.com/uploads/document/cv/'.$yearmonth.'/'.$newfilenamecv;
											} else {
												$Return['error'] = 'Jenis File CV tidak diterima..';
											}
									}

								$data = array (

								'company_id' => '3',
								'location_id' => '1',
								'department' => '5',

								'fullname' => $this->input->post('first_name'),
								'tempat_lahir' => $this->input->post('tempat_lahir'),
								'tanggal_lahir' => $this->input->post('tanggal_lahir'),
								'alamat_ktp' => $this->input->post('alamat_ktp'),
								'alamat_domisili' => $this->input->post('alamat_domisili'),
								'contact_no' => $this->input->post('contact_number'),
								'email' => $this->input->post('email'),
								'nik_ktp' => $this->input->post('nomor_ktp'),
								'no_kk' => $this->input->post('nomor_kk'),
								'npwp' => $this->input->post('npwp'),
								'nama_ibu' => $this->input->post('ibu_kandung'),
								'gender' => $this->input->post('jenis_kelamin'),
								'agama' => $this->input->post('agama'),
								'status_kawin' => $this->input->post('pernikahan'),
								'tinggi_badan' => $this->input->post('tinggi_badan'),
								'berat_badan' => $this->input->post('berat_badan'),
								'last_company' => $this->input->post('last_company'),
								'last_posisi' => $this->input->post('last_posisi'),
								'last_edu' => $this->input->post('last_edu'),
								'school_name' => $this->input->post('school_name'),
								'jurusan' => $this->input->post('jurusan'),
								'project' => $this->input->post('project_id'),
								'sub_project' => $this->input->post('subproject_id'),
								'posisi' => $this->input->post('posisi_id'),
								'penempatan' => $this->input->post('penempatan'),
								'bank_name' => $this->input->post('bank_name'),
								'no_rek' => $this->input->post('nomor_rek'),
								'pemilik_rekening' => $this->input->post('pemilik_rek'),

	
								'ktp' => $fname,
								'kk' => $fnamekk,
								'file_npwp' => $fnamenpwp,
								'skck' => $fnameskck,
								'ijazah' => 0,
								'civi' => $fnamecv,
								'gaji_pokok' => 0,

									'request_empby' 				=> '1',
									'request_empon' 				=> date("Y-m-d h:i:s"),
									'approved_naeby' 				=> '1',
									'approved_naeon' 				=> date("Y-m-d h:i:s"),
									'approved_nomby'				=> '1',
									'approved_nomon'				=> date("Y-m-d h:i:s"),
									'createdby' => '1'

								// 'project_id' => $this->input->post('project_id'),
								// 'email' => $this->input->post('email'),
								// 'contact_number' => $this->input->post('contact_number'),
								// 'created_at' => date('d-m-Y h:i:s')
								);
								// add record > model
								// $result = $this->Users_model->add($data);


								$result = $this->Employees_model->addkandidat($data);


					} 


							}

						if($Return['error']!=''){
				       		$this->output($Return);
				    }
					
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_hr_success_register_user');
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}


			$this->output($Return);
			// exit;
		}
	}


	 public function success() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Daftar Karyawan';
		$data['path_url'] = 'jobs_success';
		$data['fullname'] = $this->uri->segment(3);
		// $session = $this->session->userdata('c_user_id');
		// if(empty($session)){
		// 	redirect('employer/sign_in/');
		// }
		// $data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['subview'] = $this->load->view("frontend/hrpremium/view_daftar_success", $data, TRUE);
		$this->load->view('frontend/hrpremium/job_layout/job_layout', $data); //page load
  }


	public function success_list() {

		$data['title'] = $this->Xin_model->site_title();
		// $session = $this->session->userdata('c_user_id');
		// if(!empty($session)){ 
			$this->load->view("frontend/hrpremium/view_daftar_success", $data);
		// } else {
		// 	redirect('');
		// }

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		// $jobs = $this->Job_post_model->get_employer_jobs($session['c_user_id']);
		$jobs = $this->Employees_model->get_monitoring_daftar();

		$data = array();

        foreach($jobs->result() as $r) {
			 			  
				// get job designation
				// $category = $this->Job_post_model->read_job_category_info($r->category_id);
				// if(!is_null($category)){
				// 	$category_name = $category[0]->category_name;
				// } else {
				// 	$category_name = '--';
				// }
				// // get job type
				// $job_type = $this->Job_post_model->read_job_type_information($r->job_type);
				// if(!is_null($job_type)){
				// 	$jtype = $job_type[0]->type;
				// } else {
				// 	$jtype = '--';
				// }
				// // get date
				// $date_of_closing = $this->Xin_model->set_date_format($r->date_of_closing);
				// $created_at = $this->Xin_model->set_date_format($r->created_at);
				// /* get job status*/
				// if($r->status==1): $status = $this->lang->line('xin_published'); elseif($r->status==2): $status = $this->lang->line('xin_unpublished'); endif;
				// $employer = $this->Recruitment_model->read_employer_info($r->employer_id);
				// if(!is_null($employer)){
				// 	$employer_name = $employer[0]->company_name;
				// } else {
				// 	$employer_name = '--';	
				// }
		
				$data[] = array(
					'DD',
					$r->nik_ktp,
					'$category_name',
					'$jtype',
					'$r->job_vacancy',
					'$date_of_closing',
					'$status',
					'$created_at'
				);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $jobs->num_rows(),
			 "recordsFiltered" => $jobs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}	

	 // get location > departments
	public function get_project_sub_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(3);
		
		$data = array(
			'id_project' => $id
		);
		// $session = $this->session->userdata('username');
		// if(!empty($session)){ 
			$this->load->view("frontend/hrpremium/get_project_sub_project", $data);
		// } else {
		// 	redirect('admin/');
		// }
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	 // get location > departments
	public function get_project_posisi() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(3);
		
		$data = array(
			'id_project' => $id
		);
		// $session = $this->session->userdata('username');
		// if(!empty($session)){ 
			$this->load->view("frontend/hrpremium/get_project_posisi", $data);
		// } else {
		// 	redirect('admin/');
		// }
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
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

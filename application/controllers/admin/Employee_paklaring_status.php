<?php
  /**
 * NOTICE OF LICENSE // REQUEST RESIGN
 *
 * This source file is subject to the dndsoft License
 * that is bundled with this package in the file license.txt.
 * @author   dndsoft
 * @author-email  komputer.dnd@gmail.com
 * @copyright  Copyright © dndsoft.my.id All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_paklaring_status extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		// $this->load->model("Traxes_model");
		$this->load->model("Project_model");	
		$this->load->model("Employees_model");
		// $this->load->model("Designation_model");
		
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		// $this->load->model("Esign_model");
		// $this->load->model("Custom_fields_model");
		$this->load->model("Employees_model");
		$this->load->model("Location_model");
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
			$data['title'] = 'Status Pengajuan Paklaring | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = 'STATUS PENGAJUAN PAKLARING';
			$data['path_url'] = 'emp_view';

			// $data['all_companies'] = $this->Xin_model->get_companies();
			// $data['all_emp_active'] = $this->Employees_model->get_all_employees_all();
			$data['all_projects'] = $this->Project_model->get_project_exist_deactive($session['employee_id']);

			// $data['all_departments'] = $this->Department_model->all_departments();
			// $data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('490',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/employees/resign_list", $data, TRUE);
			$data['subview'] = $this->load->view("admin/paklaring/employee_paklaring_status", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  	}



	//load datatables Employee
	public function list_employees()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		// $data = $this->Employees_model->get_list_employees_resign($postData);
		$data = $this->Employees_model->get_list_skk_status($postData);
		echo json_encode($data);
	}


	//save Kontak Client
	public function update_pengajuan_skk()
	{
		$postData = $this->input->post();

		// update data NPWP Client
		$data = $this->Company_model->update_pengajuan_skk($postData);

		// echo json_encode($data);
	}

// get company > departments
	public function get_subprojects()
	{
		$postData = $this->input->post();

		// get data 
		// $data = $this->Project_model->ajax_proj_subproj_info($postData["project"]);
		$data = $this->Project_model->get_sub_project_filter($postData["project"]);
		echo json_encode($data);
	
	}


	//mengambil Json data dokumen kontrak ttd employee
	public function get_data_skk()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'secid'        => $postData['secid']
		];

		// get data diri
		$data = $this->Employees_model->get_data_pengajuan_skk($datarequest);

		if (empty($data)) {
			$response = array(
				'status'	=> "201",
				'pesan' 	=> "Paklaring tidak ditemukan",
			);
		} else {

			$status = "200"; //file ditemukan
			$pesan = "Berhasil Fetch Data";

			$tanggal_mulai = new DateTime($data['join_date']);
			$tanggal_selesai = new DateTime($data['resign_date']);

			// Hitung selisih
			// $selisih = $tanggal_mulai->diff($tanggal_selesai);
			$selisih = $tanggal_mulai->diff($tanggal_selesai)->days;


			// $selisih_hari = date_diff(date_create($data['resign_date'])-date_create($data['join_date']));
			$data_resign = array(
				'secid'					=> $data['secid'],
				'employee_id'					=> $data['nip'],
				'first_name'					=> $data['employee_name'],
				'ktp_no'							=> $data['ktp'],
				'company_id'					=> $data['company'],
				'company_name'				=> $data['company_name'],
				'project_id'					=> $data['project_id'],
				'project_name'				=> $data['project_name'],
				'designation_name'		=> $data['posisi_jabatan'],
				'penempatan'					=> $data['penempatan'],
				'join_date'						=> $data['join_date'],
				'resign_date'					=> $data['resign_date'],
				'working_days'				=> $selisih,
				'status_resign'				=> $data['resign_status'],
				'link_exit_clearance'			=> $data['exit_clearance'],
				'link_surat_resign'			=> $data['resign_letter'],
				'exit_clearance'			=> '<embed class="form-group col-md-12" id="output_exitclearance" type="application/pdf" src="'.$data['exit_clearance'].'"></embed>',
				'surat_resign'			=> '<embed class="form-group col-md-12" id="output_surat_resign" type="application/pdf" src="'.$data['resign_letter'].'"></embed>',

			);


			$response = array(
				'status'	=> $status,
				'pesan' 	=> $pesan,
				'data'		=> $data_resign,
			);
		}

		echo json_encode($response);
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}

	// upload addendum
	public function upload_dokumen_resign()
	{
		$pesan_error = "";
		if ($_FILES['document_file_addendum']['error'] == "0") {

			//parameter untuk path dokumen
			$yearmonth = date('Y/m');
			$path_addendum = "./uploads/document/addendum/" . $yearmonth . '/';

			//kalau blm ada folder path nya
			if (!file_exists($path_addendum)) {
				mkdir($path_addendum, 0777, true);
			}

			$nip_post = $this->input->post('nip');
			$addendum_id_post = $this->input->post('addendum_id');
			$file_signed_time_post = $this->input->post('file_signed_time');

			//konfigurasi upload
			$config['upload_path']          = $path_addendum;
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 3072;
			$config['file_name']             = 'addendum_' . $nip_post . '_' . round(microtime(true));
			$config['overwrite']             = TRUE;

			//inisialisasi proses upload
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			//upload data kalau tidak ada error
			if (!$this->upload->do_upload('document_file_addendum')) {
				$error = array('error' => $this->upload->display_errors());
				//$data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
				if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
					$pesan_error = "Foto KTP melebihi ukuran 3 MB. Silahkan upload ulang";
				} else {
					$pesan_error = "Hanya menerima file berformat PDF";
				}
			} else {
				//save path ktp ke database
				$new_filename_addendum = $this->upload->data('file_name');
				$addendum_database = $yearmonth . '/' . $new_filename_addendum;
				$this->Addendum_model->isiFileUpload($addendum_id_post, $addendum_database, $file_signed_time_post);
				$data = array('upload_data' => $this->upload->data());
			}

			//print_r($_FILES['document_file_addendum']);
			echo $pesan_error;
		} else {
			$pesan_error = "Tidak ada file yang dipilih";
			//print_r($_FILES['document_file_addendum']);
			echo $pesan_error;
		}
	}


}

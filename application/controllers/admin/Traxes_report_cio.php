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

class Traxes_report_cio extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		// $this->load->model("Company_model");
		$this->load->model("Xin_model");
		// $this->load->model("Esign_model");
		// $this->load->model("Custom_fields_model");	
		// $this->load->model("Employees_model");
		$this->load->model("Project_model");
		// $this->load->model("Department_model");
		// $this->load->model("Designation_model");
		// $this->load->model("Location_model");
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
			$data['title'] = 'Report | Traxes Check IN-OUT';
			$data['breadcrumbs'] = 'Report Check In-Out';
			$data['path_url'] = 'emp_resign';

			// $data['all_projects'] = $this->Project_model->get_project_exist_deactive();

			$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);

			// $data['all_departments'] = $this->Department_model->all_departments();
			// $data['all_designations'] = $this->Designation_model->all_designations();
		if(in_array('490',$role_resources_ids)) {
			// $data['subview'] = $this->load->view("admin/employees/resign_list", $data, TRUE);
			$data['subview'] = $this->load->view("admin/employees/employee_request_paklaring", $data, TRUE);
			$data['subview'] = $this->load->view("admin/traxes/report_traxes_cio", $data, TRUE);
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
		$data = $this->Employees_model->get_list_employees_resign($postData);
		echo json_encode($data);
	}


	// get company > departments
	public function get_subprojects()
	{

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'project_id' => $id
		);
		$session = $this->session->userdata('username');
		if (!empty($session)) {
			$this->load->view("admin/reports/report_get_subprojects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	//mengambil Json data dokumen kontrak ttd employee
	public function get_data_employee()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		$postData = $this->input->post();

		//Cek variabel post
		$datarequest = [
			'nip'        => $postData['nip']
		];

		// get data diri
		$data = $this->Employees_model->get_data_karyawan_resign($nip);

		if (empty($data)) {
			$response = array(
				'status'	=> "201",
				'pesan' 	=> "Karyawan tidak ditemukan",
			);
		} else {

			$status_resign = $data['status_resign'];
			$status = "200"; //file ditemukan
			$pesan = "Berhasil Fetch Data";



			$response = array(
				'status'	=> $status,
				'pesan' 	=> $pesan,
				'data'		=> $status_resign,
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

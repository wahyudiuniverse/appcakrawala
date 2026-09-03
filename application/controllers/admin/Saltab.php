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
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Saltab extends MY_Controller
{

	/*Function to set JSON output*/
	public function output($Return = array())
	{
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function __construct()
	{
		parent::__construct();
		//load the models
		$this->load->library('session');

		$this->load->model('Import_model');
		$this->load->model('Saltab_model');

		$this->load->model("Employees_model");
		$this->load->model("Register_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Company_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Project_model");
		$this->load->model("Assets_model");
		// $this->load->model("Training_model");
		// $this->load->model("Trainers_model");
		// $this->load->model("Awards_model");
		$this->load->model("Travel_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Subproject_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Exin_model');

		$this->load->model('Pkwt_model');
		$this->load->model('Xin_model');

		$this->load->library("pagination");
		$this->load->library('Pdf');
		//$this->load->library("phpspreadsheet");
		$this->load->helper('string');
		$this->load->library('ciqrcode');
	}

	// import
	public function index()
	{

		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_imports') . ' | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_imports');
		$data['path_url'] = 'hrpremium_import';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if (in_array('127', $role_resources_ids) || in_array('127', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/import_excel/hr_import_excel", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//hitung saltab
	public function hitung_saltab()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) {
			redirect('admin/');
		}

		// POST data
		$postData = $this->input->post();

		//initial response
		$response = array(
			"status" => "0",
			"message" => "",
			"message_perbandingan_mpp" => "",
			"data" => null
		);
		//initial lanjut step
		$lanjut_step = false;

		//ambil data batch dan detail absensi
		$data_batch_absensi = $this->Import_model->get_absensi_batch($postData['id']);
		$data_detail_absensi = $this->Saltab_model->get_list_detail_absensi($postData['id']);

		//cek data batch ratecard
		$data_batch_ratecard = $this->Saltab_model->get_ratecard_by_project_sub($data_batch_absensi['project_id'], $data_batch_absensi['sub_project_id']);
		if (empty($data_batch_ratecard)) {
			$lanjut_step = false;

			//respon end process
			$response = array(
				"status" => "0",
				"message" => "Tidak ada data Ratecard untuk project dan Entitas/Sub Project tersebut.\nSilahkan upload data Ratecard terkait.",
				"message_perbandingan_mpp" => "",
				"data" => null
			);
		} else {
			$lanjut_step = true;
		}

		//ambil data detail ratecard kalau lanjut_step = true
		if ($lanjut_step) {
			$data_detail_ratecard = $this->Saltab_model->get_ratecard_detail_by_id($data_batch_ratecard['id']);
			if (empty($data_detail_ratecard)) {
				$lanjut_step = false;

				//respon end process
				$response = array(
					"status" => "1",
					"message" => "Data Ratecard untuk project dan Entitas/Sub Project tersebut tidak ada.\nSilahkan upload data Ratecard terkait.",
					"message_perbandingan_mpp" => "",
					"data" => null
				);
			} else {
				$lanjut_step = true;
			}
		}

		//ambil data perhitungan saltab kalau lanjut_step = true
		if ($lanjut_step) {
			$data_perhitungan = $this->Saltab_model->get_tabel_perhitungan($data_batch_absensi['project_id'], $data_batch_absensi['sub_project_id']);
			if (empty($data_perhitungan)) {
				$lanjut_step = false;

				//respon end process
				$response = array(
					"status" => "2",
					"message" => "Tidak ada data Perhitungan Saltab untuk project dan Entitas/Sub Project tersebut.\nSilahkan lengkapi data Perhitungan Saltab terkait.",
					"message_perbandingan_mpp" => "",
					"data" => null
				);
			} else {
				$lanjut_step = true;
				//ambil fungsi fungsi yang dipakai di detail data perhitungan
				$detail_data_perhitungan = json_decode($data_perhitungan['fungsi'], true);
				$mpp = count($data_detail_absensi);

				if (($data_batch_absensi['id_saltab_temp'] == "") || ($data_batch_absensi['id_saltab_temp'] == null)) {
					//buat header saltab temp
					$data_header_saltab_temp = $this->Saltab_model->create_saltab_header_temp($data_batch_absensi);
				} else {
					//get data header saltab temp
					$data_header_saltab_temp = $this->Saltab_model->get_saltab_header_temp($data_batch_absensi['id_saltab_temp']);
				}

				$counter_hitung = 0;

				//proses perhitungan
				foreach ($data_detail_absensi as $data_absensi) {
					//cek apakah ada record nya di ratecard
					$data_search = array(
						"id_jabatan" => $data_absensi['id_jabatan'],
						"id_kota_kabupaten" => $data_absensi['id_area'],
					);
					$data_detail_ratecard = $this->Saltab_model->get_ratecard_detail_custom($data_batch_ratecard['id'], $data_search);
					if (empty($data_detail_ratecard)) {
						$lanjut_step = false;

						//respon end process gagal hitung
						// $response = array(
						// 	"status" => "3",
						// 	"message" => "Tidak ditemukan data Ratecard untuk Posisi/Jabatan tersebut.\nSilahkan lengkapi data Ratecard terkait.",
						// 	"data" => null
						// );

						//update flag gagal hitung di data record absensi
						$data_update = array(
							"status_hitung" => "2",
							"catatan_hitung" => "Tidak ditemukan data Ratecard untuk Posisi/Jabatan tersebut.</br>Lengkapi data Ratecard terkait.",
						);
						$hasil_update_absensi_detail = $this->Saltab_model->update_data_absensi_record($data_update, $data_absensi['id']);
					} else {
						$lanjut_step = true;
					}

					//lanjut hitung kalau ditemukan di ratecard
					if ($lanjut_step) {
						$data_detail_saltab_temp = $this->Saltab_model->create_saltab_detail_temp($data_batch_absensi, $data_absensi, $data_header_saltab_temp['id']);
						$id_detail_saltab = $data_detail_saltab_temp['secid'];
						foreach ($detail_data_perhitungan as $data_perhitungan) {
							// var_dump($data_perhitungan['nama_fungsi']);
							// $text_eval = "\$this->gaji_diterima(\$data_absensi,\$data_batch_ratecard,\$id_detail_saltab);";
							// $text_eval = "" . $data_perhitungan['nama_fungsi'];
							// eval($text_eval);

							eval($this->Saltab_model->get_fungsi_perhitungan($data_perhitungan['id_hitung_master']));
						}

						//update flag berhasil hitung di data record absensi
						$data_update = array(
							"status_hitung" => "1",
							"catatan_hitung" => "Sudah Dihitung",
							"id_detail_saltab_temp" => $id_detail_saltab,
						);
						$hasil_update_absensi_detail = $this->Saltab_model->update_data_absensi_record($data_update, $data_absensi['id']);

						//update id absensi detail di data detail saltab
						$data_update_detail_saltab = array(
							"id_absensi_detail" => $data_absensi['id'],
						);
						$hasil_update_absensi_detail = $this->Saltab_model->update_data_detail_saltab($data_update_detail_saltab, $id_detail_saltab);

						// $response = array(
						// 	"status" => "3",
						// 	"message" => "Berhasil hitung absensi dan generate saltab temporary.",
						// 	"message_perbandingan_mpp" => $this->Saltab_model->get_perbandingan_mpp_absensi_saltab_temp($data_header_saltab_temp['id'], $data_batch_absensi['id']),
						// 	"data" => $data_header_saltab_temp,
						// );

						$counter_hitung++;
					} else {
						$lanjut_step = true;

						// $response = array(
						// 	"status" => "3",
						// 	"message" => "Berhasil hitung absensi dan generate saltab temporary.",
						// 	"message_perbandingan_mpp" => $this->Saltab_model->get_perbandingan_mpp_absensi_saltab_temp($data_header_saltab_temp['id'], $data_batch_absensi['id']),
						// 	"data" => $data_header_saltab_temp,
						// );
					}

					$nip = $session['employee_id'];

					//update mpp saltab header
					$data_update_header = array(
						"total_mpp" 			=> $counter_hitung,

						'upload_by_id'      	=> $nip,
						'upload_by'      		=> $this->Import_model->get_nama_karyawan($nip),
						'upload_on'      		=> date('Y-m-d H:i:s'),
						'upload_ip'        	 	=> $this->get_client_ip(),
					);
					$hasil_update_header_saltab = $this->Saltab_model->update_data_header_saltab($data_update_header, $data_header_saltab_temp['id']);

					//update data absesnsi header
					$data_update_header_absensi = array(
						"status_hitung" 	=> 1,
						"id_saltab_temp" 	=> $data_header_saltab_temp['id'],

						'hitung_by'      	=> $nip,
						'hitung_by_name'	=> $this->Import_model->get_nama_karyawan($nip),
						'hitung_on'      	=> date('Y-m-d H:i:s'),
						'hitung_ip'        	=> $this->get_client_ip(),
					);
					$hasil_update_header_absensi = $this->Saltab_model->update_data_header_absensi($data_update_header_absensi, $data_batch_absensi['id']);

					$response = array(
						"status" => "3",
						"message" => "Berhasil hitung absensi dan generate saltab temporary.",
						"message_perbandingan_mpp" => $this->Saltab_model->get_perbandingan_mpp_absensi_saltab_temp($data_header_saltab_temp['id'], $data_batch_absensi['id']),
						"data" => $data_header_saltab_temp,
					);
				}
			}
		}

		//---------------------DEBUGGING----------------------------
		// $data2 = array(
		// 	$data_perhitungan['fungsi'],
		// 	$detail_data_perhitungan,
		// );

		// $detail_data_perhitungan = json_decode($data_perhitungan['fungsi']);

		// switch (json_last_error()) {
		// 	case JSON_ERROR_NONE:
		// 		echo "No errors";
		// 		break;
		// 	case JSON_ERROR_DEPTH:
		// 		echo "Maximum stack depth exceeded";
		// 		break;
		// 	case JSON_ERROR_STATE_MISMATCH:
		// 		echo "Invalid or malformed JSON";
		// 		break;
		// 	case JSON_ERROR_CTRL_CHAR:
		// 		echo "Control character error";
		// 		break;
		// 	case JSON_ERROR_SYNTAX:
		// 		echo "Syntax error";
		// 		break;
		// 	case JSON_ERROR_UTF8:
		// 		echo "Malformed UTF-8 characters";
		// 		break;
		// 	default:
		// 		echo "Unknown error";
		// 		break;
		// }
		// var_dump($detail_data_perhitungan);
		// var_dump(json_decode('[{"nama_kolom": "gaji_diterima","nama_fungsi": "\$this->gaji_diterima(\$data_absensi,\$data_batch_ratecard,\$id_detail_saltab)"},{"nama_kolom": "allow_konsumsi","nama_fungsi": "\$this->allow_konsumsi(\$data_absensi,\$data_batch_ratecard,\$id_detail_saltab)"}]', true));
		// echo json_encode($data2);
		// echo $detail_data_perhitungan;
		// print_r($detail_data_perhitungan);

		echo json_encode($response);
	}

	// Function to get the client IP address
	function get_client_ip()
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	//gaji diterima
	public function gaji_diterima($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_gaji_diterima = $this->Saltab_model->gaji_diterima($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//tunjangan meals
	public function allow_konsumsi($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_allow_konsumsi = $this->Saltab_model->allow_konsumsi($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//tunjangan transport
	public function allow_transport($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_allow_transport = $this->Saltab_model->allow_transport($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//total 1
	public function total_1($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_total_1 = $this->Saltab_model->total_1($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//bpjs tk (jkk, jkm, jht), kesehatan, jaminan pensiun
	public function bpjs_deduction($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_bpjs_deduction = $this->Saltab_model->bpjs_deduction($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//total 2
	public function total_2($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_total_2 = $this->Saltab_model->total_2($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//bpjs ketenagakerjaan, kesehatan, jaminan pensiun
	public function bpjs_deduction_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_bpjs_deduction = $this->Saltab_model->bpjs_deduction_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//pph karyawan
	public function pph_21($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_bpjs_deduction = $this->Saltab_model->pph_21($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}

	//total thp
	public function total_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_bpjs_deduction = $this->Saltab_model->total_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab);
	}
}

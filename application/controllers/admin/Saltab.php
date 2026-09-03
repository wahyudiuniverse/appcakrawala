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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
		$this->load->model("Project_model");
		$this->load->model("Subproject_model");
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");

		$this->load->model("Register_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Company_model");
		$this->load->model("Timesheet_model");
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

	public function download_template_absensi()
	{
		// POST data
		$postData = $this->input->post();

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('Absensi'); //nama Spreadsheet yg baru dibuat

		$tabel_saltab = $this->Saltab_model->get_absensi_table();

		$header_tabel_saltab = array_column($tabel_saltab, 'nama_tabel');
		$header2_tabel_saltab = array_column($tabel_saltab, 'alias');
		$jumlah_data = count($header_tabel_saltab);
		//$tes = print_r($tabel_saltab);

		//add 1 day
		$original_date = $postData['absensi_from'];

		for ($x = 0; $x <= 30; $x++) {
			//add 1 hari
			$new_date = date('(D) Y-m-d', strtotime($original_date . ' +' . $x . ' day'));
			$hari_ke = date('N', strtotime($original_date . ' +' . $x . ' day'));

			// $cellRef = Coordinate::stringFromColumnIndex($x + 1);

			// $spreadsheet
			// 	->getActiveSheet()
			// 	->getStyle($cellRef)
			// 	->getFill()
			// 	->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			// 	->getStartColor()
			// 	->setARGB('FF0000');

			// $spreadsheet->getActiveSheet()
			// 	->getStyle($cellRef)
			// 	->getFill()
			// 	->setFillType(Fill::FILL_SOLID)
			// 	->getStartColor()
			// 	->setARGB('FF0000FF');

			//replace hari kerja ke tanggal
			if (($key = array_search("Hari Kerja " . ($x + 1) . "", $header2_tabel_saltab)) !== false) {
				if ($hari_ke == 7) {
					$cellRef = Coordinate::stringFromColumnIndex($key + 1);

					$spreadsheet->getActiveSheet()
						->getStyle($cellRef)
						->getFill()
						->setFillType(Fill::FILL_SOLID)
						->getStartColor()
						->setARGB(Color::changeBrightness("FF0000", 0.7));

					// $spreadsheet->getActiveSheet()
					// 	->getStyle($cellRef)
					// 	->getFill()
					// 	->setFillType(Fill::FILL_SOLID)
					// 	->getStartColor()
					// 	->setARGB('FFC7CE');
				}

				$header2_tabel_saltab[$key] = $new_date;
			}
		}

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$header_tabel_saltab,   // The data to set
				NULL,
				'A1'
			);

		$spreadsheet->getActiveSheet()
			->fromArray(
				$header2_tabel_saltab,   // The data to set
				NULL,
				'A2'
			);


		//set header background color
		$maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
		$maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

		$spreadsheet
			->getActiveSheet()
			->getStyle("A2:{$maxDataColumn}{$maxDataRow}")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		//Isi data karyawan aktif di template
		$detail_saltab = $this->Saltab_model->get_employee_aktif($postData['project_id'], $postData['sub_project_id']);

		$length_data = count($detail_saltab);

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$detail_saltab,   // The data to set
		// 		NULL,
		// 		'A3'
		// 	);

		if ($length_data < 1) {
			//do nothing
		} else {
			$length_array = count($detail_saltab[0]);

			for ($i = 0; $i < $length_data; $i++) {
				for ($j = 0; $j < $length_array; $j++) {
					// $cell = chr($j + 65) . ($i);
					$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 3])->setvalueExplicit($detail_saltab[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
					// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
				}
			}
		}

		//set column width jadi auto size
		for ($i = 1; $i <= $jumlah_data; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('1:2')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//Buat sheet Master Kota Kabupaten
		$sheet2 = $spreadsheet->createSheet(); // createSheet() returns the new sheet object
		$sheet2->setTitle('Master Kota Kabupaten'); // Set the title for the second sheet

		$tabel_kota_kabupaten = $this->Import_model->get_data_kota_kabupaten();

		$sheet2->setCellValue('A1', 'ID AREA PENGGAJIAN');
		$sheet2->setCellValue('B1', 'NAMA KOTA KABUPATEN');

		$activeWorksheet = $spreadsheet->setActiveSheetIndexByName('Master Kota Kabupaten');

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$tabel_kota_kabupaten,   // The data to set
				NULL,
				'A2'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= 2; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set header background color
		$spreadsheet
			->getActiveSheet()
			->getStyle("A1:B1")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');


		//Buat sheet Master Mapping project - jabatan
		$sheet3 = $spreadsheet->createSheet(); // createSheet() returns the new sheet object
		$sheet3->setTitle('Master Project Posisi'); // Set the title for the second sheet

		$tabel_project_jabatan = $this->Import_model->get_data_mapping_project_posisi();

		$sheet3->setCellValue('A1', 'ID PROJECT');
		$sheet3->setCellValue('B1', 'NAMA PROJECT');
		$sheet3->setCellValue('C1', 'ID ENTITAS/SUB PROJECT');
		$sheet3->setCellValue('D1', 'NAMA ENTITAS/SUB PROJECT');
		$sheet3->setCellValue('E1', 'ID JABATAN');
		$sheet3->setCellValue('F1', 'NAMA JABATAN');

		$activeWorksheet = $spreadsheet->setActiveSheetIndexByName('Master Project Posisi');

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$tabel_project_jabatan,   // The data to set
				NULL,
				'A2'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= 6; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}

		//set header background color
		$spreadsheet
			->getActiveSheet()
			->getStyle("A1:F1")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		//aktifkan sheet pertama
		$spreadsheet->setActiveSheetIndex(0);

		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		//$writer->setPreCalculateFormulas(false);

		$filename = 'Template Absensi'; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');	// download file 
		//$writer->save('./absen/tes2.xlsx');	// download file 
	}

	/*
    |-------------------------------------------------------------------
    | Import Excel absensi
    |-------------------------------------------------------------------
    |
    */
	function import_excel_absensi()
	{
		//ambil parameter yg di post sebagai acuan
		$nip = $this->input->post('nip');
		$link_file_excel = $this->input->post('link_file_excel');
		$tipe_file_excel = $this->input->post('tipe_file_excel');
		$periode_salary = $this->input->post('periode_salary');
		$saltab_from = $this->input->post('saltab_from');
		$saltab_to = $this->input->post('saltab_to');
		$project = $this->input->post('project');
		$sub_project = $this->input->post('sub_project');
		$fee = $this->input->post('fee');

		$status = "0";
		$message = "";

		//load data Project
		$nama_project = "";
		$projects = $this->Project_model->read_single_project($project);
		if (!is_null($projects)) {
			$nama_project = $projects[0]->title;
		} else {
			$nama_project = '';
		}

		//load data Sub Project
		$nama_sub_project = "";
		if ($sub_project == 0) {
			$nama_sub_project = '-ALL-';
		} else {
			$subprojects = $this->Subproject_model->read_single_subproject($sub_project);
			if (!is_null($subprojects)) {
				$nama_sub_project = $subprojects[0]->sub_project_name;
			} else {
				$nama_sub_project = '';
			}
		}

		//handle file
		$this->load->helper('file');

		/* Allowed MIME(s) File */
		$file_mimes = array(
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		$local1 = ".";
		if (file_exists($local1 . $link_file_excel) && in_array($tipe_file_excel, $file_mimes)) {

			$array_file = explode('.', $link_file_excel);
			$extension  = end($array_file);

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($local1 . $link_file_excel);

			if ($spreadsheet->sheetNameExists('Absensi')) {
				$spreadsheet->setActiveSheetIndexByName('Absensi');

				// $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
				$sheet_data  = $spreadsheet->getActiveSheet()->toArray();
				// $sheet_data = array_map('trim', $sheet_data);
				$sheet_data = array_filter($sheet_data);
				$array_data  = [];
				$array_data_final  = [];
				$data        = [];
				$header_tabel_saltab = $sheet_data[0];
				$header_tabel_saltab = array_filter($header_tabel_saltab);

				// echo '<pre>';
				// print_r($sheet_data);
				// echo '</pre>';

				$length_header = count($header_tabel_saltab);
				$jumlah_data = count($sheet_data) - 2;
				// $highestColumnInRow5 = $spreadsheet->getActiveSheet(0)->getHighestColumn(1);

				//susun array batch saltab
				$data_batch = array(
					'project_id'        	=> $project,
					'project_name'        	=> $nama_project,
					'sub_project_id'        => $sub_project,
					'sub_project_name'      => $nama_sub_project,

					'periode_salary'        => $periode_salary,
					'saltab_from'    		=> $saltab_from,
					'saltab_to'    			=> $saltab_to,
					'fee'      				=> $fee,
					'file_excel'      		=> $link_file_excel,
					'status_finish_upload'  => 0,

					'upload_by'      		=> $nip,
					'upload_by_name'      	=> $this->Saltab_model->get_nama_karyawan($nip),
					'upload_on'      		=> date('Y-m-d H:i:s'),
					'upload_ip'        	 	=> $this->get_client_ip(),
				);

				$this->Saltab_model->insert_absensi_batch($data_batch);

				$id_batch = $this->Saltab_model->get_id_absensi_batch($data_batch);

				//susun array ratecard detail
				for ($i = 2; $i < count($sheet_data); $i++) {
					$lanjut = true;
					$data += ['id_absensi_header' => $id_batch];
					for ($j = 0; $j < $length_header; $j++) {
						if ($header_tabel_saltab[$j] == "fullname") {
							$trimmed_value = trim($sheet_data[$i][$j], ' ');
							$trimmed_value = trim($trimmed_value, ' ');
							$data += [$header_tabel_saltab[$j] => $trimmed_value];
							if (($trimmed_value == "") || ($trimmed_value == null)) {
								$lanjut = false;
							} else {
								$lanjut = true;
							}
						} else {
							if ($lanjut) {
								$trimmed_value = trim($sheet_data[$i][$j], ' ');
								$trimmed_value = trim($trimmed_value, ' ');
								$data += [$header_tabel_saltab[$j] => $trimmed_value];
								$lanjut = true;
							}
						}
					}
					if ($lanjut) {
						$array_data[] = $data;
						$data = array();
					} else {
						$data = array();
					}
				}

				$this->Saltab_model->insert_absensi_detail($array_data);

				//setelah berhasil insert detail, update status batch jadi 1
				//susun array batch saltab update
				$data_batch_update = array(
					'status_finish_upload'  => 1,
					'mpp' => count($array_data),
				);

				$this->Saltab_model->update_absensi_batch($data_batch_update, $id_batch);
				$tes_query = $this->db->last_query();

				$status = "1";
				$message = "Berhasil Import Absensi.";
			} else {
				$status = "0";
				$message = "Tidak ditemukan sheet \"Absensi\" di dalam file excel";
			}
		} else {
			$status = "0";
			$message = "File yang diupload bukan format excel (.xlsx)";
		}

		//$this->view_batch_saltab_temporary($id_batch);
		//redirect('/');

		// redirect('admin/Importexcel/view_batch_saltab_temporary/' . $id_batch);
		$return_value = array(
			'status' => $status,
			'message' => $message,
		);

		echo json_encode($return_value);
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

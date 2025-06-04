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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Traxes_report_summary extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model("Xin_model");
		$this->load->model("Traxes_model");
		$this->load->model("Project_model");
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
			$data['title'] = 'Report | Traxes Resume';
			$data['breadcrumbs'] = 'REPORT SUMMARY';
			$data['path_url'] = 'emp_view';
			$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);

		if(in_array('490',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/traxes/report_traxes_summary", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  	}


	//load datatables Employee
	public function list_summary()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Traxes_model->get_list_summary($postData);
		echo json_encode($data);
	}


	//load datatables Employee
	public function list_sumary_cio()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Traxes_model->get_summary_cio($postData);
		echo json_encode($data);
	}


// get company > departments
	public function get_subprojects()
	{
		$postData = $this->input->post();

		// get data 
		// $data = $this->Project_model->ajax_proj_subproj_info($postData["project"]);
		$data = $this->Traxes_model->ajax_proj_subproj_info($postData["project"]);
		echo json_encode($data);
	
	}


	public function printExcel($project, $sub_project, $periode, $searchVal, $session_id)
	{
		$postData = array();

		//variabel filter (diambil dari post ajax di view)
		$postData['project'] = $project;
		$postData['sub_project'] = urldecode($sub_project);
		$postData['periode'] = $periode;
		$postData['session_id'] = $session_id;
		$postData['nama_file'] = 'TRAXES REPORT SUMMARY';
		if ($searchVal == '-no_input-') {
			$postData['filter'] = '';
		} else {
			$postData['filter'] = urldecode($searchVal);
		}

		// echo $postData['filter'];

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('TRAXES REPORT SUMMARY'); //nama Spreadsheet yg baru dibuat

		//data satu row yg mau di isi
		$rowArray = [
			'NIP',
			'NAMA LENGKAP',
			'PROJECT/GOLONGAN',
			'SUB PROJECT/WITEL',
			'AREA/PENEMPATAN',
			'PERIODE',
			'1-IN',
			'1-OT',
			'2-IN',
			'2-OT',
			'3-IN',
			'3-OT',
			'4-IN',
			'4-OT',
			'5-IN',
			'5-OT',
			'6-IN',
			'6-OT',
			'7-IN',
			'7-OT',
			'8-IN',
			'8-OT',
			'9-IN',
			'9-OT',
			'10-IN',
			'10-OT',
			'11-IN',
			'11-OT',
			'12-IN',
			'12-OT',
			'13-IN',
			'13-OT',
			'14-IN',
			'14-OT',
			'15-IN',
			'15-OT',
			'16-IN',
			'16-OT',
			'17-IN',
			'17-OT',
			'18-IN',
			'18-OT',
			'19-IN',
			'19-OT',
			'20-IN',
			'20-OT',
			'21-IN',
			'21-OT',
			'22-IN',
			'22-OT',
			'23-IN',
			'23-OT',
			'24-IN',
			'24-OT',
			'25-IN',
			'25-OT',
			'26-IN',
			'26-OT',
			'27-IN',
			'27-OT',
			'28-IN',
			'28-OT',
			'29-IN',
			'29-OT',
			'30-IN',
			'30-OT',
			'31-IN',
			'31-OT',
		];

		$length_array = count($rowArray);
		//isi cell dari array
		$spreadsheet->getActiveSheet()
			->fromArray(
				$rowArray,   // The data to set
				NULL,
				'A1'
			);

		//set column width jadi auto size
		for ($i = 1; $i <= $length_array; $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}
		//set background color
		$spreadsheet
			->getActiveSheet()
			->getStyle('A1:AW1')
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('BFBFBF');

		$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

		//$spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR);

		// Get data
		// $data = $this->Employees_model->get_employee_print($postData);
		$data = $this->Traxes_model->get_summary_print($postData);

		$length_data = count($data);

		for ($i = 0; $i < $length_data; $i++) {
			for ($j = 0; $j < $length_array; $j++) {
				// $cell = chr($j + 65) . ($i);
				$spreadsheet->getActiveSheet()->getCell([$j + 1, $i + 2])->setvalueExplicit($data[$i][$j], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
				// $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			}
		}
		//$data = var_dump(json_decode($data_temp, true));

		// if (!is_array(end($data))) {
		// 	$data = [$data];
		// }

		$jumlah = count($data) + 1;

		//var_dump($data);

		// $spreadsheet->getActiveSheet()
		// 	->fromArray(
		// 		$data,  // The data to set
		// 		NULL,        // Array values with this value will not be set
		// 		'A2',
		// 		false,
		// 		false         // Top left coordinate of the worksheet range where
		// 		//    we want to set these values (default is A1)
		// 	);


		//set wrap text untuk row ke 1
		$spreadsheet->getActiveSheet()->getStyle('1:1')->getAlignment()->setWrapText(true);

		//set vertical dan horizontal alignment text untuk row ke 1
		// $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');
		$spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		// $spreadsheet->getActiveSheet()->getStyle('AC:AI')->getNumberFormat()->setFormatCode('Rp #,##0');
		$spreadsheet->getActiveSheet()->getStyle('1:1')
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('1:1')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


		//----------------Buat File Untuk Download--------------
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = $postData['nama_file'];

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');


		$writer->save('php://output');
	}


}

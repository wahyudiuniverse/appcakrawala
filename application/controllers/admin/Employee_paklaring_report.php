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

class Employee_paklaring_report extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('ciqrcode');
		$this->load->model("Xin_model");
		$this->load->model("Project_model");
		$this->load->model("Traxes_model");
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
		// redirect('server_error');

			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}

				$role_resources_ids = $this->Xin_model->user_role_resource();
				$data['title'] = 'Report | SKK';
				$data['breadcrumbs'] = 'LAPORAN SKK / PAKLARING';
				$data['path_url'] = 'emp_view';
				$data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);

			if(in_array('110',$role_resources_ids)) {

				$data['subview'] = $this->load->view("admin/paklaring/employee_paklaring_report", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/dashboard');
			}
  	}


	//load datatables Employee
	public function list_skk_report()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Company_model->get_list_skk_report($postData);
		echo json_encode($data);
	}



	//save qrcode
	public function rebuild_qrcode_class()
	{
		$postData = $this->input->post();

		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= './uploads/qrcode/skk/'; //string, the default is application/cache/
		$config['errorlog']		= './uploads/qrcode/skk/'; //string, the default is application/logs/
		$config['imagedir']		= './uploads/qrcode/skk/images/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '1024'; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		// $nomor_surat = $postData['nomor_dokumen'];
		$secid = $postData['secid'];
		$docid = $postData['docid'];
		$yearmonth = date('Y/m');

		$path_qr = $config['imagedir']. $yearmonth. '/';
					//kalau blm ada folder path nya
			if (!file_exists($path_qr)) {
				mkdir($path_qr, 0777, true);
			}

		$image_name='esign_skk'.date('ymdHis').'.png'; //buat name dari qr code sesuai dengan nim
		$domain = base_url().'esign/sk/'.$docid;
		$params['data'] = $domain; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH.$config['imagedir']. $yearmonth . '/'.$image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
		$url_qr = '/uploads/qrcode/skk/images/'.$yearmonth.'/'.$image_name;


		// update data NPWP Client
		$data = $this->Company_model->rebuild_qrcode_skk($secid,$docid,$url_qr);

		// echo json_encode($data);
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

// get company > departments
	public function get_entitas()
	{
		$postData = $this->input->post();

		// get data 
		// $data = $this->Project_model->ajax_proj_subproj_info($postData["project"]);
		$data = $this->Company_model->ajax_proj_subproj_info($postData["project"]);
		echo json_encode($data);
	
	}


	public function printExcel($project, $sub_project, $sdate, $edate,  $searchVal, $session_id)
	{
		$postData = array();

		//variabel filter (diambil dari post ajax di view)
		$postData['project'] = $project;
		$postData['sub_project'] = urldecode($sub_project);
		$postData['sdate'] = $sdate;
		$postData['edate'] = $edate;
		$postData['session_id'] = $session_id;
		$postData['nama_file'] = 'TRAXES REPORT CHECKIN-OUT';
		if ($searchVal == '-no_input-') {
			$postData['filter'] = '';
		} else {
			$postData['filter'] = urldecode($searchVal);
		}

		// echo $postData['filter'];

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getActiveSheet()->setTitle('TRAXES REPORT CHECKIN-OUT'); //nama Spreadsheet yg baru dibuat

		//data satu row yg mau di isi
		$rowArray = [
			'NIP',
			'NAMA LENGKAP',
			'PROJECT',
			'SUB PROJECT',
			'POSISI/JABATAN',
			'AREA/PENEMPATAN',
			'STATUS/VISIT',
			'ID TOKO/LOKASI',
			'NAMA TOKO/LOKASI',
			'ALAMAT TOKO/LOKASI',
			'PEMILIK TOKO/LOKASI',
			'KONTAK TOKO/LOKASI',
			'TANGGAL',
			'JAM MASUK',
			'WAKTU SISTEM MASUK',
			'JARAK MASUK',
			'JAM KELUAR',
			'WAKTU SISTEM KELUAR',
			'JARAK KELUAR',
			'TOTAL JAM KERJA',
			'KETERANGAN',
			'FOTO MASUK',
			'FOTO KELUAR',
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
		$data = $this->Traxes_model->get_employee_print($postData);

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

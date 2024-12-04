<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Data_karyawan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('url_helper');
		$this->load->helper('html');
		$this->load->database();
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->load->model("Employees_model");
		$this->load->model("Pkwt_model");
		$this->load->model("Xin_model");
	}

    // public function index()
	// {
	// 	$data['title'] = "Data Karyawan | HR Cakrawala";
		
    //     $data['sub_view'] = $this->load->view('frontend/data_karyawan.php', $data, TRUE);
	// 	$this->load->view('frontend/_partials/skeleton.php', $data);
	// }

	public function list_data($identifier = null)
	{
		$data['title'] = "Data Karyawan | HR Cakrawala";
		$data['identifier'] = $identifier;
		
        $data['sub_view'] = $this->load->view('frontend/data_karyawan.php', $data, TRUE);
		$this->load->view('frontend/_partials/skeleton.php', $data);
	}

	//load datatables Employee
	public function list_employees()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->Employees_model->list_employees($postData);

		echo json_encode($data);
	}
}
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

class Budget extends MY_Controller
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
        $this->load->model("Budget_model");
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
        $this->load->model('Import_model');
        $this->load->model('Pkwt_model');
        $this->load->model('Xin_model');
        $this->load->library("pagination");
        $this->load->library('Pdf');
        //$this->load->library("phpspreadsheet");
        $this->load->helper('string');
        $this->load->library('ciqrcode');
    }


    // import bupot
    public function import_budget()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        // Ambil data untuk dropdown
        $data['tahun_list'] = $this->Budget_model->get_all_years();
        $data['pt_list'] = $this->Budget_model->get_all_pts();
        $data['area_list'] = $this->Budget_model->get_all_areas();

        // $data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
        $data['title'] = 'MT Budget Target | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'MT Budget Target';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_bpjs';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('1300', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/budget/import_budget", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }



    public function report()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        // Ambil dropdown dari gabungan 2 tabel (distinct)
        $tahun_list = $this->db->query("SELECT DISTINCT tahun FROM mt_budget_target UNION SELECT DISTINCT tahun FROM mt_budget_actual")->result();
        $pt_list    = $this->db->query("SELECT DISTINCT pt FROM mt_budget_target UNION SELECT DISTINCT pt FROM mt_budget_actual")->result();
        $area_list  = $this->db->query("SELECT DISTINCT area FROM mt_budget_target UNION SELECT DISTINCT area FROM mt_budget_actual")->result();

        $data = [
            'tahun_list' => $tahun_list,
            'pt_list'    => $pt_list,
            'area_list'  => $area_list
        ];

        // $data['all_projects'] = $this->Project_model->get_project_maping($session['employee_id']);
        $data['title'] = 'MT Budget  | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'MT Budget ';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_bpjs';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('1300', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/budget/report", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }


    public function get_budget_report()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_error('No direct script access allowed');
        // }

        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        $result = $this->db->select('bulan, target')
            ->from('mt_budget_target')
            ->where('tahun', $tahun)
            ->where('pt', $pt)
            ->where('area', $area)
            ->get()
            ->result();

        // return $result;
        echo json_encode($result);
    }

    public function get_budget_data()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        $data = $this->Budget_model->get_combined_budget($tahun, $pt, $area);
        echo json_encode($data);
    }
}

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
        $data['pt_list'] = $this->Budget_model->get_all_pt();
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

        // $data = $this->Budget_model->get_dropdown_data();

        $this->load->model('Budget_model');
        $data['tahun_list'] = $this->Budget_model->get_unique('tahun');
        // $data['pt_list'] = $this->Budget_model->get_unique('pt');
        $data['pt_list'] = $this->Budget_model->get_all_pt();
        $data['area_list'] = $this->Budget_model->get_unique('area');

        // $data['tahun_list'] = $this->Budget_model->get_tahun_list();

        // Ambil dropdown dari gabungan 2 tabel (distinct)
        // $tahun_list = $this->db->query("SELECT DISTINCT tahun FROM mt_budget_target UNION SELECT DISTINCT tahun FROM mt_budget_actual")->result();
        // $pt_list    = $this->db->query("SELECT DISTINCT pt FROM mt_budget_target UNION SELECT DISTINCT pt FROM mt_budget_actual")->result();
        // $area_list  = $this->db->query("SELECT DISTINCT area FROM mt_budget_target UNION SELECT DISTINCT area FROM mt_budget_actual")->result();

        // $data = [
        //     'tahun_list' => $tahun_list,
        //     'pt_list'    => $pt_list,
        //     'area_list'  => $area_list
        // ];

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
        if (!$this->input->is_ajax_request()) {
            show_error('No direct script access allowed', 403);
        }

        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        $this->load->model('Budget_model');
        $result = $this->Budget_model->get_budget_data($tahun, $pt, $area);

        echo json_encode($result);
    }



    public function add_budget_target()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');
        $bulan = $this->input->post('bulan');
        $target = $this->input->post('target');

        if (empty($tahun) || empty($pt) || empty($area) || empty($bulan) || empty($target)) {
            echo json_encode(['success' => false, 'message' => 'Semua data harus diisi.']);
            return;
        }

        $this->load->model('Budget_model');

        // Cek duplikat
        if ($this->Budget_model->is_duplicate_budget($tahun, $pt, $area, $bulan)) {
            echo json_encode([
                'success' => false,
                'message' => 'Data dengan kombinasi tahun, PT, area, dan bulan tersebut sudah ada.'
            ]);
            return;
        }

        // Insert data
        $data = [
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'bulan' => $bulan,
            'target' => $target
        ];

        $result = $this->Budget_model->insert_budget_target($data);

        echo json_encode([
            'success' => $result ? true : false,
            'message' => $result ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data target',
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
    }


    public function add_actual_data()
    {
        // Ambil data dari request POST
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');
        $bulan = $this->input->post('bulan');
        $actual = $this->input->post('actual');
        $tgl_invoice = $this->input->post('tgl_invoice');
        $nomor_invoice = $this->input->post('nomor_invoice');
        $nomor_ps = $this->input->post('nomor_ps');

        // Validasi data
        if (empty($tahun) || empty($pt) || empty($area) || empty($bulan) || empty($actual)) {
            // Jika ada data yang kosong, kirim respons gagal
            echo json_encode(['success' => false, 'message' => 'Semua data harus diisi.']);
            return;
        }

        // Siapkan data untuk disimpan
        $data = [
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'bulan' => $bulan,
            'actual' => $actual,
            'tgl_invoice' => $tgl_invoice,
            'nomor_invoice' => $nomor_invoice,
            'nomor_ps' => $nomor_ps
        ];

        // Panggil model untuk menambahkan data ke tabel mt_budget_target
        $this->load->model('Budget_model');
        $result = $this->Budget_model->insert_budget_aktual($data);

        if ($result) {
            // Jika berhasil, kirim respons sukses
            echo json_encode(['success' => true, 'message' => 'Data budget target berhasil ditambahkan']);
        } else {
            // Jika gagal, kirim respons gagal
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data target']);
        }
    }


    public function get_tahun_list()
    {
        // Ambil data tahun dari database
        $result = $this->db->get('tahun')->result();
        echo json_encode($result);
    }


    public function get_area_list()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        // Ambil data Area berdasarkan tahun dan PT
        $result = $this->db->where('tahun', $tahun)->where('pt', $pt)->get('area')->result();
        echo json_encode($result);
    }

    public function get_pt_list()
    {
        // Mengambil data tahun dari request
        $tahun = $this->input->post('tahun');
        if ($tahun) {
            // Ambil data PT berdasarkan tahun
            $this->load->model('Budget_model');
            $data_pt = $this->Budget_model->get_pt_by_tahun($tahun);

            // Jika data ditemukan, kirimkan sebagai JSON
            if ($data_pt) {
                echo json_encode($data_pt);
            } else {
                echo json_encode([]);
            }
        } else {
            // Jika tidak ada tahun yang diberikan, kirimkan array kosong
            echo json_encode([]);
        }
    }

    public function get_area_by_pt()
    {
        $pt = $this->input->post('pt');
        $data = $this->Budget_model->get_area_by_pt($pt);
        echo json_encode($data);
    }

    public function add_actual_data2()
    {
        // Ambil data dari POST
        $data = [
            'tahun'          => $this->input->post('tahun'),
            'pt'             => $this->input->post('pt'),
            'area'           => $this->input->post('area'),
            'bulan'          => $this->input->post('bulan'),
            'actual'         => $this->input->post('actual'),
            'tgl_invoice'    => $this->input->post('tgl_invoice'),
            'nomor_invoice'  => $this->input->post('nomor_invoice'),
            'nomor_ps'       => $this->input->post('nomor_ps'),
        ];

        // Simpan ke model
        $result = $this->Budget_model->simpan_actual_data2($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

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




    public function report2()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        // $data = $this->Budget_model->get_dropdown_data();

        $this->load->model('Budget_model');
        $data['tahun_list'] = $this->Budget_model->get_unique2('tahun');
        // $data['pt_list'] = $this->Budget_model->get_unique('pt');
        $data['pt_list'] = $this->Budget_model->get_all_pt2();
        $data['area_list'] = $this->Budget_model->get_unique2('area');

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
        $data['breadcrumbs'] = 'Pengajuan Budgetting';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_bpjs';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('1300', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/budget/report2", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }


    public function po()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        // $data = $this->Budget_model->get_dropdown_data();

        $this->load->model('Budget_model');
        $data['tahun_list'] = $this->Budget_model->get_unique3('tahun');
        // $data['pt_list'] = $this->Budget_model->get_unique('pt');
        $data['pt_list'] = $this->Budget_model->get_all_pt2();
        $data['area_list'] = $this->Budget_model->get_unique3('area');

        $pengajuan_list = $this->Budget_model->get_all_pengajuan(); // Mendapatkan data proyek

        // Kirim data ke view
        $data['pengajuan_list'] = $pengajuan_list;

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
        $data['breadcrumbs'] = 'PO Budgetting';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_bpjs';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('1300', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/budget/po", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }


    public function report_invoice()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        // $data = $this->Budget_model->get_dropdown_data();

        $this->load->model('Budget_model');
        $data['tahun_list'] = $this->Budget_model->get_unique3('tahun');
        // $data['pt_list'] = $this->Budget_model->get_unique('pt');
        $data['pt_list'] = $this->Budget_model->get_all_pt2();
        $data['area_list'] = $this->Budget_model->get_unique3('area');

        $pengajuan_list = $this->Budget_model->get_all_pengajuan(); // Mendapatkan data proyek

        // Kirim data ke view
        $data['pengajuan_list'] = $pengajuan_list;

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
        $data['breadcrumbs'] = 'Report Invoice';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_bpjs';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('1300', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/budget/report_invoice", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }


    public function get_invoice_data()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        $this->db->select('nomor_invoice, tanggal_invoice, nilai_invoice, keterangan');
        $this->db->from('report_invoice_budgetting');
        $this->db->where('tahun', $tahun);
        $this->db->where('pt', $pt);
        $this->db->where('area', $area);

        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);
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



    public function get_budget_data2()
    {
        // Mengambil data dari input request
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        // Debug: cek data yang diterima
        error_log('tahun: ' . $tahun);
        error_log('pt: ' . $pt);
        error_log('area: ' . $area);

        // Mendapatkan data dari model
        $data = $this->Budget_model->get_budget_data2($tahun, $pt, $area);

        // Pastikan ada data yang diterima
        if (empty($data)) {
            error_log('Tidak ada data ditemukan.');
        }

        $result = [];
        foreach ($data as $row) {
            $total_nilai_psb_dan_pda = $row->total_nilai_psb_dan_pda;
            $total_nilai_pekerjaan_lainlain = $row->total_nilai_pekerjaan_lainlain;
            $total_nilai_pendapatan_dipengajuan = $row->total_nilai_pendapatan_dipengajuan;

            // Hitung KPI
            $kpi = 0;
            if ($total_nilai_psb_dan_pda > 0 && $total_nilai_pendapatan_dipengajuan > 0) {
                $kpi = ($total_nilai_psb_dan_pda / $total_nilai_pendapatan_dipengajuan) * 100;
            }

            $result[] = [
                'id_pengajuan' => $row->id_pengajuan,
                'tahun' => $row->tahun,
                'periode' => $row->periode,
                'project_id' => $row->project_id,
                'jmlh_ps_psb_dan_pda' => $row->jmlh_ps_psb_dan_pda,
                'total_nilai_psb_dan_pda' => $total_nilai_psb_dan_pda,
                'total_nilai_pekerjaan_lainlain' => $total_nilai_pekerjaan_lainlain,
                'total_nilai_pendapatan_dipengajuan' => $total_nilai_pendapatan_dipengajuan,
                'kpi' => number_format($kpi, 2),
                'pt' => $row->pt,
                'area' => $row->area,
                // 'keterangan' => isset($row->keterangan) ? $row->keterangan : '-'
            ];
        }

        // Debug: cek hasil data sebelum mengirimkan ke AJAX
        error_log(json_encode($result));

        // Kirimkan data dalam format JSON
        echo json_encode($result);
    }



    public function get_budget_data3()
    {
        // Mengambil data dari input request
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        // Debug: cek data yang diterima
        error_log('tahun: ' . $tahun);
        error_log('pt: ' . $pt);
        error_log('area: ' . $area);

        // Mendapatkan data dari model
        $data = $this->Budget_model->get_budget_data3($tahun, $pt, $area);

        // Pastikan ada data yang diterima
        if (empty($data)) {
            error_log('Tidak ada data ditemukan.');
        }

        $result = [];
        foreach ($data as $row) {
            $total_nilai_psb_dan_pda = $row->total_nilai_psb_dan_pda;
            $total_nilai_pekerjaan_lainlain = $row->total_nilai_pekerjaan_lainlain;
            $total_nilai_pendapatan_disp = $row->total_nilai_pendapatan_disp;

            // Hitung KPI
            $kpi = 0;
            if ($total_nilai_psb_dan_pda > 0 && $total_nilai_pendapatan_disp > 0) {
                $kpi = ($total_nilai_psb_dan_pda / $total_nilai_pendapatan_disp) * 100;
            }

            $result[] = [
                'id_po' => $row->id_po,
                'tahun' => $row->tahun,
                'periode' => $row->periode,
                'nomor_sp' => $row->nomor_sp,
                'jmlh_ps_psb_dan_pda' => $row->jmlh_ps_psb_dan_pda,
                'total_nilai_psb_dan_pda' => $total_nilai_psb_dan_pda,
                'total_nilai_pekerjaan_lainlain' => $total_nilai_pekerjaan_lainlain,
                'total_nilai_pendapatan_disp' => $total_nilai_pendapatan_disp,
                'kpi' => number_format($kpi, 2),
                'pt' => $row->pt,
                'area' => $row->area,
                // 'keterangan' => isset($row->keterangan) ? $row->keterangan : '-'
            ];
        }

        // Debug: cek hasil data sebelum mengirimkan ke AJAX
        error_log(json_encode($result));

        // Kirimkan data dalam format JSON
        echo json_encode($result);
    }

    // public function get_budget_data4()
    // {
    //     // Mengambil data dari input request
    //     $tahun = $this->input->post('tahun');
    //     $pt = $this->input->post('pt');
    //     $area = $this->input->post('area');

    //     // Debug: cek data yang diterima
    //     error_log('tahun: ' . $tahun);
    //     error_log('pt: ' . $pt);
    //     error_log('area: ' . $area);

    //     // Mendapatkan data dari model
    //     $data = $this->Budget_model->get_budget_data4($tahun, $pt, $area);

    //     // Pastikan ada data yang diterima
    //     if (empty($data)) {
    //         error_log('Tidak ada data ditemukan.');
    //     }

    //     $result = [];
    //     foreach ($data as $row) {
    //         $total_nilai_psb_dan_pda = $row->total_nilai_psb_dan_pda;
    //         $total_nilai_pekerjaan_lainlain = $row->total_nilai_pekerjaan_lainlain;
    //         $total_nilai_pendapatan_disp = $row->total_nilai_pendapatan_disp;

    //         // Hitung KPI
    //         $kpi = 0;
    //         if ($total_nilai_psb_dan_pda > 0 && $total_nilai_pendapatan_disp > 0) {
    //             $kpi = ($total_nilai_psb_dan_pda / $total_nilai_pendapatan_disp) * 100;
    //         }

    //         $result[] = [
    //             'id_invoice' => $row->id_invoice,
    //             'tahun' => $row->tahun,
    //             'periode' => $row->periode,
    //             'nomor_sp' => $row->nomor_sp,
    //             'jmlh_ps_psb_dan_pda' => $row->jmlh_ps_psb_dan_pda,
    //             'total_nilai_psb_dan_pda' => $total_nilai_psb_dan_pda,
    //             'total_nilai_pekerjaan_lainlain' => $total_nilai_pekerjaan_lainlain,
    //             'total_nilai_pendapatan_disp' => $total_nilai_pendapatan_disp,
    //             'kpi' => number_format($kpi, 2),
    //             'pt' => $row->pt,
    //             'area' => $row->area,
    //             // 'keterangan' => isset($row->keterangan) ? $row->keterangan : '-'
    //         ];
    //     }

    //     // Debug: cek hasil data sebelum mengirimkan ke AJAX
    //     error_log(json_encode($result));

    //     // Kirimkan data dalam format JSON
    //     echo json_encode($result);
    // }


    public function get_budget_data4()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');

        $this->db->select('id_invoice, nomor_invoice, tanggal_invoice, nilai_invoice, keterangan');
        $this->db->from('report_invoice_budgetting');
        $this->db->where('tahun', $tahun);
        $this->db->where('pt', $pt);
        $this->db->where('area', $area);

        $query = $this->db->get();
        echo json_encode($query->result());
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




    public function add_budget_target2()
    {
        $project_id = $this->input->post('project_id'); // Ambil project_id
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');
        $periode = $this->input->post('periode');
        $jmlh_ps_psb_dan_pda = $this->input->post('jmlh_ps_psb_dan_pda'); // Ambil jumlah PS PSB dan PDA
        $total_nilai_psb_dan_pda = $this->input->post('total_nilai_psb_dan_pda');
        $total_nilai_pekerjaan_lainlain = $this->input->post('total_nilai_pekerjaan_lainlain');
        $total_nilai_pendapatan_dipengajuan = $this->input->post('total_nilai_pendapatan_dipengajuan');

        // Periksa jika ada data yang kosong
        if (empty($tahun) || empty($pt) || empty($area) || empty($periode) || empty($project_id) || empty($jmlh_ps_psb_dan_pda) || empty($total_nilai_psb_dan_pda) || empty($total_nilai_pekerjaan_lainlain) || empty($total_nilai_pendapatan_dipengajuan)) {
            echo json_encode(['success' => false, 'message' => 'Semua data harus diisi.']);
            return;
        }

        $this->load->model('Budget_model');

        // Cek apakah data sudah ada
        if ($this->Budget_model->is_duplicate_pengajuan_budgetting($tahun, $pt, $area, $periode, $project_id)) {
            echo json_encode([
                'success' => false,
                'message' => 'Data dengan kombinasi tersebut sudah ada.'
            ]);
            return;
        }

        $data = [
            'project_id' => $project_id,
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'periode' => $periode,
            'jmlh_ps_psb_dan_pda' => $jmlh_ps_psb_dan_pda, // Simpan jumlah PS PSB dan PDA
            'total_nilai_psb_dan_pda' => $total_nilai_psb_dan_pda,
            'total_nilai_pekerjaan_lainlain' => $total_nilai_pekerjaan_lainlain,
            'total_nilai_pendapatan_dipengajuan' => $total_nilai_pendapatan_dipengajuan
        ];

        $result = $this->Budget_model->insert_budget_target2($data);

        echo json_encode([
            'success' => $result ? true : false,
            'message' => $result ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data',
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
    }



    public function add_budget_target3()
    {
        $nomor_sp = $this->input->post('nomor_sp'); // Ambil project_id
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');
        $periode = $this->input->post('periode');
        $jmlh_ps_psb_dan_pda = $this->input->post('jmlh_ps_psb_dan_pda'); // Ambil jumlah PS PSB dan PDA
        $total_nilai_psb_dan_pda = $this->input->post('total_nilai_psb_dan_pda');
        $total_nilai_pekerjaan_lainlain = $this->input->post('total_nilai_pekerjaan_lainlain');
        $total_nilai_pendapatan_disp = $this->input->post('total_nilai_pendapatan_disp');

        // Periksa jika ada data yang kosong
        if (empty($tahun) || empty($pt) || empty($area) || empty($periode) || empty($nomor_sp) || empty($jmlh_ps_psb_dan_pda) || empty($total_nilai_psb_dan_pda) || empty($total_nilai_pekerjaan_lainlain) || empty($total_nilai_pendapatan_disp)) {
            echo json_encode(['success' => false, 'message' => 'Semua data harus diisi.']);
            return;
        }

        $this->load->model('Budget_model');

        // Cek apakah data sudah ada
        if ($this->Budget_model->is_duplicate_po_budgetting($tahun, $pt, $area, $periode, $nomor_sp)) {
            echo json_encode([
                'success' => false,
                'message' => 'Data dengan kombinasi tersebut sudah ada.'
            ]);
            return;
        }

        $data = [
            'nomor_sp' => $nomor_sp,
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'periode' => $periode,
            'jmlh_ps_psb_dan_pda' => $jmlh_ps_psb_dan_pda, // Simpan jumlah PS PSB dan PDA
            'total_nilai_psb_dan_pda' => $total_nilai_psb_dan_pda,
            'total_nilai_pekerjaan_lainlain' => $total_nilai_pekerjaan_lainlain,
            'total_nilai_pendapatan_disp' => $total_nilai_pendapatan_disp
        ];

        $result = $this->Budget_model->insert_budget_target3($data);

        echo json_encode([
            'success' => $result ? true : false,
            'message' => $result ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data',
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

    public function get_pt_list2()
    {
        // Mengambil data tahun dari request
        $tahun = $this->input->post('tahun');
        if ($tahun) {
            // Ambil data PT berdasarkan tahun
            $this->load->model('Budget_model');
            $data_pt = $this->Budget_model->get_pt_by_tahun2($tahun);

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

    public function get_pt_list3()
    {
        // Mengambil data tahun dari request
        $tahun = $this->input->post('tahun');
        if ($tahun) {
            // Ambil data PT berdasarkan tahun
            $this->load->model('Budget_model');
            $data_pt = $this->Budget_model->get_pt_by_tahun3($tahun);

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


    public function get_pt_list4()
    {
        // Mengambil data tahun dari request
        $tahun = $this->input->post('tahun');
        if ($tahun) {
            // Ambil data PT berdasarkan tahun
            $this->load->model('Budget_model');
            $data_pt = $this->Budget_model->get_pt_by_tahun4($tahun);

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

    public function get_area_by_pt2()
    {
        $pt = $this->input->post('pt');
        $data = $this->Budget_model->get_area_by_pt2($pt);
        echo json_encode($data);
    }

    public function get_area_by_pt3()
    {
        $pt = $this->input->post('pt');
        $data = $this->Budget_model->get_area_by_pt3($pt);
        echo json_encode($data);
    }

    public function get_area_by_pt4()
    {
        $pt = $this->input->post('pt');
        $data = $this->Budget_model->get_area_by_pt4($pt);
        echo json_encode($data);
    }

    public function add_actual_data2()
    {
        // Ambil data dari POST
        $data = [
            'tahun' => $this->input->post('tahun'),
            'pt' => $this->input->post('pt'),
            'area' => $this->input->post('area'),
            'bulan' => $this->input->post('bulan'),
            'actual' => $this->input->post('actual'),
            'tgl_invoice' => $this->input->post('tgl_invoice'),
            'nomor_invoice' => $this->input->post('nomor_invoice'),
            'nomor_ps' => $this->input->post('nomor_ps'),
        ];

        // Simpan ke model
        $result = $this->Budget_model->simpan_actual_data2($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }


    public function add_actual_data3()
    {
        // Ambil data dari POST tanpa 'created_at'
        $data = [
            'tahun' => $this->input->post('tahun'),
            'pt' => $this->input->post('pt'),
            'area' => $this->input->post('area'),
            'bulan' => $this->input->post('bulan'),
            'actual' => $this->input->post('actual'),
            'tgl_invoice' => $this->input->post('tgl_invoice'),
            'nomor_invoice' => $this->input->post('nomor_invoice'),
            'nomor_ps' => $this->input->post('nomor_ps')
        ];

        // Simpan ke model
        $result = $this->Budget_model->simpan_actual_data3($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }


    // Fungsi untuk mengambil detail invoice
    public function get_invoice_details()
    {
        $id = $this->input->get('id'); // Mengambil parameter id dari request

        if (!$id) {
            echo json_encode(['error' => 'ID tidak ditemukan']);
            return;
        }

        $invoiceDetails = $this->Budget_model->get_invoice_by_id($id); // Ambil data invoice berdasarkan id

        if ($invoiceDetails) {
            echo json_encode($invoiceDetails); // Kirim data invoice dalam format JSON
        } else {
            echo json_encode(['error' => 'Data invoice tidak ditemukan']);
        }
    }


    public function get_invoice_detail()
    {
        $tahun = $this->input->get('tahun');
        $pt = $this->input->get('pt');
        $area = $this->input->get('area');
        $bulan = $this->input->get('bulan');

        $result = $this->Budget_model->get_invoice_by_param($tahun, $pt, $area, $bulan);
        echo json_encode($result);
    }


    // Mengambil data dari tabel pengajuan_budgetting berdasarkan filter
    public function get_pengajuan_data()
    {
        $tahun = $this->input->post('tahun');
        $pt = $this->input->post('pt');
        $area = $this->input->post('area');
        $periode = $this->input->post('periode');

        $data = $this->Budget_model->get_pengajuan_budgetting($tahun, $pt, $area, $periode);
        echo json_encode($data);
    }

    // Menambahkan data ke tabel po_budgetting
    public function add_budget_target4()
    {
        $data = [
            'nomor_sp' => $this->input->post('nomor_sp'),
            'tahun' => $this->input->post('tahun'),
            'pt' => $this->input->post('pt'),
            'area' => $this->input->post('area'),
            'periode' => $this->input->post('periode'),
            'jmlh_ps_psb_dan_pda' => $this->input->post('jmlh_ps_psb_dan_pda'),
            'total_nilai_psb_dan_pda' => $this->input->post('total_nilai_psb_dan_pda'),
            'total_nilai_pekerjaan_lainlain' => $this->input->post('total_nilai_pekerjaan_lainlain'),
            'total_nilai_pendapatan_disp' => $this->input->post('total_nilai_pendapatan_disp')
        ];

        $this->Budget_model->insert_budget_target4($data);
        echo json_encode(['success' => true]);
    }

    public function get_pengajuan_by_projectid()
    {
        $project_id = $this->input->post('project_id');
        $pengajuan = $this->db->get_where('pengajuan_budgetting', ['project_id' => $project_id])->row();

        if ($pengajuan) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'tahun' => $pengajuan->tahun,
                    'pt' => $pengajuan->pt,
                    'area' => $pengajuan->area,
                    'periode' => $pengajuan->periode,
                ],
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        }
    }

    public function get_pengajuan_by_projectid1()
    {
        $project_id = $this->input->post('project_id');
        $pengajuan = $this->db->get_where('pengajuan_budgetting', ['project_id' => $project_id])->row();

        if ($pengajuan) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'tahun' => $pengajuan->tahun,
                    'pt' => $pengajuan->pt,
                    'area' => $pengajuan->area,
                    'periode' => $pengajuan->periode,
                ],
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        }
    }


    public function get_sp_by_projectid()
    {
        $project_id = $this->input->post('project_id');
        $data = $this->db->select('nomor_sp')->where('project_id', $project_id)->get('po_budgetting')->result();
        echo json_encode(['sp_list' => $data]);
    }

    public function get_data_sp()
    {
        $project_id = $this->input->post('project_id');
        $nomor_sp = $this->input->post('nomor_sp');

        $row = $this->db->where(compact('project_id', 'nomor_sp'))->get('po_budgetting')->row();
        echo json_encode(['success' => !!$row, 'row' => $row]);
    }

    public function save_invoice_budget()
    {
        $nomor_sp = $this->input->post('nomor_sp');
        $ref_po_row = $this->db->where('nomor_sp', $nomor_sp)->get('po_budgetting')->row();

        if (!$ref_po_row) {
            echo json_encode(['success' => false, 'message' => 'Nomor SP tidak ditemukan']);
            return;
        }

        $data = [
            'ref_po' => $ref_po_row->id_po,
            'project_id' => $this->input->post('project_id'),
            'tahun' => $this->input->post('tahun'),
            'periode' => $this->input->post('periode'),
            'pt' => $this->input->post('pt'),
            'area' => $this->input->post('area'),
            'nomor_sp' => $this->input->post('nomor_sp'),
            'jmlh_ps_psb_dan_pda' => $this->input->post('jmlh_ps_psb_dan_pda'),
            'total_nilai_psb_dan_pda' => $this->input->post('total_nilai_psb_dan_pda'),
            'total_nilai_pekerjaan_lainlain' => $this->input->post('total_nilai_pekerjaan_lainlain'),
            'total_nilai_pendapatan_disp' => $this->input->post('total_nilai_pendapatan_disp'),
            'nomor_invoice' => $this->input->post('nomor_invoice'),
            'tanggal_invoice' => $this->input->post('tanggal_invoice'),
            'nilai_invoice' => $this->input->post('nilai_invoice'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->db->insert('report_invoice_budgetting', $data);

        echo json_encode(['success' => true]);
    }

    public function save_po_budgetting()
    {
        $project_id = $this->input->post('project_id');

        // Cek jika project_id sudah pernah disimpan
        $existing = $this->db->get_where('po_budgetting', ['project_id' => $project_id])->row();
        if ($existing) {
            echo json_encode([
                'success' => false,
                'message' => 'Data dengan project ID ini sudah pernah disimpan!',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        // Cari id_pengajuan
        $pengajuan = $this->db->get_where('pengajuan_budgetting', ['project_id' => $project_id])->row();
        if (!$pengajuan) {
            echo json_encode([
                'success' => false,
                'message' => 'Pengajuan tidak ditemukan.',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        $data = [
            'ref_pengajuan' => $pengajuan->id_pengajuan,
            'project_id' => $project_id,
            'tahun' => $this->input->post('tahun'),
            'periode' => $this->input->post('periode'),
            'pt' => $this->input->post('pt'),
            'area' => $this->input->post('area'),
            'nomor_sp' => $this->input->post('nomor_sp'),
            'jmlh_ps_psb_dan_pda' => $this->input->post('jmlh_ps_psb_dan_pda'),
            'total_nilai_psb_dan_pda' => $this->input->post('total_nilai_psb_dan_pda'),
            'total_nilai_pekerjaan_lainlain' => $this->input->post('total_nilai_pekerjaan_lainlain'),
            'total_nilai_pendapatan_disp' => $this->input->post('total_nilai_pendapatan_disp'),
        ];

        $this->db->insert('po_budgetting', $data);

        echo json_encode([
            'success' => true,
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
    }

    public function show_budget_input_form()
    {
        // Ambil data dari tabel pengajuan_budgetting
        $pengajuan_list = $this->Pengajuan_model->get_all_pengajuan(); // Mengambil data proyek dari model

        // Kirim data ke view
        $data['pengajuan_list'] = $pengajuan_list;
        $this->load->view('your_view_name', $data); // Pastikan nama view sudah sesuai
    }
}

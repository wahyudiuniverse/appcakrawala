<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Addendum extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the models
        $this->load->model("Employees_model");
        $this->load->model("Xin_model");
        $this->load->model('Pkwt_model');
        $this->load->model('Project_model');
        $this->load->model('Designation_model');
        $this->load->model('Subproject_model');
        $this->load->model("Addendum_model");

        $this->load->library("pagination");
        $this->load->library('secure');
        $this->load->library('ciqrcode');

        $this->load->helper('string');
    }

    //load datatables list addendum
    public function list_addendum()
    {

        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Addendum_model->get_list_addendum($postData);

        echo json_encode($data);
    }

    //load datatables list addendum
    public function list_report_addendum()
    {

        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Addendum_model->get_list_report_addendum($postData);

        echo json_encode($data);
    }

    //convert tanggal jadi romawi
    function convert_tanggal($tanggal)
    {
        $bulan = array(
            1 =>   'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
            'XI',
            'XII'
        );

        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal

        return $bulan[(int)$pecahkan[1]] . '/' . $pecahkan[0];
    }

    //delete addendum
    public function delete_addendum()
    {

        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Addendum_model->delete_addendum($postData);

        echo json_encode($data);
    }

    public function view()
    {
        //initiate pesan error
        $pesan_error = "";
        //cek sedang login atau tidak
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        //load data pkwt berdasarkan id nya
        $uniqueid = $this->uri->segment(4);
        $pkwt = $this->Pkwt_model->read_pkwt_info_byuniq($uniqueid);
        if (is_null($pkwt)) {
            redirect('admin/');
        }

        //load data employee berdasarkan NIP dari pkwt nya
        $dokumen_pkwt = '0';
        $employee = $this->Employees_model->read_employee_info_by_nik($pkwt[0]->employee_id);
        if (is_null($employee)) {
            redirect('admin/employees');
        } else {
            $dokumen_pkwt = 'pkwt' . $employee[0]->sub_project_id;
        }

        //load data Project
        $nama_project = "";
        $projects = $this->Project_model->read_single_project($pkwt[0]->project);
        if (!is_null($projects)) {
            $nama_project = $projects[0]->title;
        } else {
            $nama_project = '--';
        }

        //load data Sub Project
        $nama_sub_project = "";
        $subprojects = $this->Subproject_model->read_single_subproject($pkwt[0]->sub_project);
        if (!is_null($subprojects)) {
            $nama_sub_project = $subprojects[0]->sub_project_name;
        } else {
            $nama_sub_project = '--';
        }

        // get designation
        $designation_name = "";
        $designation = $this->Designation_model->read_designation_information($pkwt[0]->jabatan);
        if (!is_null($designation)) {
            $designation_name = $designation[0]->designation_name;
        } else {
            $designation_name = '--';
        }

        //tanggal pkwt
        $tanggal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_awal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_akhir_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->to_date);
        $periode_pkwt = $tanggal_awal_pkwt . " s/d " . $tanggal_akhir_pkwt;

        //tombol lihat dokumen pkwt
        $lihat_pkwt =
            '<a href="' . site_url() . 'admin/' . $dokumen_pkwt . '/view' . '/' . $uniqueid . '/" target="_blank">
  					<button type="button" class="btn btn-xs btn-outline-twitter">Lihat Doukumen<br> PKWT</button>
  				</a>';

        //tombol tambah addendum
        $tambah_addendum =
            '<a href="' . site_url() . 'admin/addendum/add' . '/' . $uniqueid . '/" target="_blank">
                  <button type="button" class="btn btn-xs btn-outline-twitter">Tambah<br> Addendum</button>
              </a>';

        $data = array(
            'breadcrumbs' => "Manage PKWT/TKHL Employee",
            'title' => "Addendum Manager",
        );

        //data-data
        $data['pkwt'] = $pkwt;
        $data['employee'] = $employee;
        $data['pesan_error'] = $pesan_error;
        $data['dokumen_pkwt'] = $dokumen_pkwt;
        $data['nama_project'] = $nama_project;
        $data['nama_sub_project'] = $nama_sub_project;
        $data['designation_name'] = $designation_name;
        $data['tanggal_pkwt'] = $tanggal_pkwt;
        $data['periode_pkwt'] = $periode_pkwt;

        //tombol-tombol
        $data['lihat_pkwt'] = $lihat_pkwt;
        $data['tambah_addendum'] = $tambah_addendum;

        $data['subview'] = $this->load->view("admin/employees/pkwt_manager", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function add()
    {
        //initiate pesan error
        $pesan_error = "";
        //cek sedang login atau tidak
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        //load data pkwt berdasarkan id nya
        $uniqueid = $this->uri->segment(4);
        $pkwt = $this->Pkwt_model->read_pkwt_info_byuniq($uniqueid);
        if (is_null($pkwt)) {
            redirect('admin/');
        }

        //load template addendum
        $addendum = $this->Addendum_model->getAddendumTemplate();

        //load data employee berdasarkan NIP dari pkwt nya
        $dokumen_pkwt = '0';
        $employee = $this->Employees_model->read_employee_info_by_nik($pkwt[0]->employee_id);
        if (is_null($employee)) {
            redirect('admin/employees');
        } else {
            $dokumen_pkwt = 'pkwt' . $employee[0]->sub_project_id;
        }

        //load data Project
        $nama_project = "";
        $projects = $this->Project_model->read_single_project($pkwt[0]->project);
        if (!is_null($projects)) {
            $nama_project = $projects[0]->title;
        } else {
            $nama_project = '--';
        }

        //load data Sub Project
        $nama_sub_project = "";
        $subprojects = $this->Subproject_model->read_single_subproject($pkwt[0]->sub_project);
        if (!is_null($subprojects)) {
            $nama_sub_project = $subprojects[0]->sub_project_name;
        } else {
            $nama_sub_project = '--';
        }

        // get designation
        $designation_name = "";
        $designation = $this->Designation_model->read_designation_information($pkwt[0]->jabatan);
        if (!is_null($designation)) {
            $designation_name = $designation[0]->designation_name;
        } else {
            $designation_name = '--';
        }

        //tanggal pkwt
        $tanggal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_awal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_akhir_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->to_date);
        $periode_pkwt = $tanggal_awal_pkwt . " s/d " . $tanggal_akhir_pkwt;
        $tanggal_awal_kontrak = $pkwt[0]->from_date;
        $tanggal_akhir_kontrak = $pkwt[0]->to_date;
        $periode_kontrak = $pkwt[0]->waktu_kontrak;

        //tombol lihat dokumen pkwt
        $lihat_pkwt =
            '<a href="' . site_url() . 'admin/' . $dokumen_pkwt . '/view' . '/' . $uniqueid . '/" target="_blank">
  					<button type="button" class="btn btn-xs btn-outline-twitter">Lihat Doukumen<br> PKWT</button>
  				</a>';

        //tombol tambah addendum
        $tambah_addendum =
            '<a href="' . site_url() . 'admin/addendum/add' . '/' . $uniqueid . '/">
                  <button type="button" class="btn btn-xs btn-outline-twitter">Tambah<br> Addendum</button>
              </a>';

        $data = array(
            'breadcrumbs' => "Manage PKWT/TKHL Employee",
            'title' => "Addendum Manager",
        );

        //data-data
        $data['pkwt'] = $pkwt;
        $data['addendum'] = $addendum;
        $data['employee'] = $employee;
        $data['pesan_error'] = $pesan_error;
        $data['dokumen_pkwt'] = $dokumen_pkwt;
        $data['nama_project'] = $nama_project;
        $data['nama_sub_project'] = $nama_sub_project;
        $data['designation_name'] = $designation_name;
        $data['tanggal_pkwt'] = $tanggal_pkwt;
        $data['periode_pkwt'] = $periode_pkwt;
        $data['tanggal_awal_kontrak'] = $tanggal_awal_kontrak;
        $data['tanggal_akhir_kontrak'] = $tanggal_akhir_kontrak;
        $data['periode_kontrak'] = $periode_kontrak;

        //tombol-tombol
        $data['lihat_pkwt'] = $lihat_pkwt;
        $data['tambah_addendum'] = $tambah_addendum;

        $data['subview'] = $this->load->view("admin/employees/pkwt_addendum_add", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function edit()
    {
        //initiate pesan error
        $pesan_error = "";
        //cek sedang login atau tidak
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        //get addendum
        $addendum_id = $this->uri->segment(4);
        $addendum = $this->Addendum_model->getAddendum($addendum_id);

        //get pkwt
        $pkwt_id = $addendum['pkwt_id'];
        $pkwt = $this->Pkwt_model->read_pkwt_info($pkwt_id);
        //$uniqid = $pkwt[0]->uniqueid;
        if (is_null($pkwt)) {
            redirect('admin/');
        }

        //get employee
        $employee_id = $pkwt[0]->employee_id;
        $user = $this->Xin_model->read_user_by_employee_id($employee_id);

        //get uniqueid
        $uniqueid = $pkwt[0]->uniqueid;

        //load data employee berdasarkan NIP dari pkwt nya
        $dokumen_pkwt = '0';
        $employee = $this->Employees_model->read_employee_info_by_nik($pkwt[0]->employee_id);
        if (is_null($employee)) {
            redirect('admin/employees');
        } else {
            $dokumen_pkwt = 'pkwt' . $employee[0]->sub_project_id;
        }

        //load data Project
        $nama_project = "";
        $projects = $this->Project_model->read_single_project($pkwt[0]->project);
        if (!is_null($projects)) {
            $nama_project = $projects[0]->title;
        } else {
            $nama_project = '--';
        }

        //load data Sub Project
        $nama_sub_project = "";
        $subprojects = $this->Subproject_model->read_single_subproject($pkwt[0]->sub_project);
        if (!is_null($subprojects)) {
            $nama_sub_project = $subprojects[0]->sub_project_name;
        } else {
            $nama_sub_project = '--';
        }

        // get designation
        $designation_name = "";
        $designation = $this->Designation_model->read_designation_information($pkwt[0]->jabatan);
        if (!is_null($designation)) {
            $designation_name = $designation[0]->designation_name;
        } else {
            $designation_name = '--';
        }

        //tanggal pkwt
        $tanggal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_awal_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->from_date);
        $tanggal_akhir_pkwt = $this->Xin_model->tgl_indo($pkwt[0]->to_date);
        $periode_pkwt = $tanggal_awal_pkwt . " s/d " . $tanggal_akhir_pkwt;
        $tanggal_awal_kontrak_new = $addendum['kontrak_start_new'];
        $tanggal_akhir_kontrak_new = $addendum['kontrak_end_new'];
        $periode_kontrak_new = $addendum['periode_new'];

        //tombol lihat dokumen pkwt
        $lihat_pkwt =
            '<a href="' . site_url() . 'admin/' . $dokumen_pkwt . '/view' . '/' . $uniqueid . '/" target="_blank">
  					<button type="button" class="btn btn-xs btn-outline-twitter">Lihat Doukumen<br> PKWT</button>
  				</a>';

        //tombol tambah addendum
        $tambah_addendum =
            '<a href="' . site_url() . 'admin/addendum/add' . '/' . $uniqueid . '/">
                  <button type="button" class="btn btn-xs btn-outline-twitter">Tambah<br> Addendum</button>
              </a>';

        $data = array(
            'breadcrumbs' => "Manage PKWT/TKHL Employee",
            'title' => "Addendum Manager",
        );

        //data-data
        $data['pkwt'] = $pkwt;
        $data['addendum'] = $addendum;
        $data['employee'] = $employee;
        $data['pesan_error'] = $pesan_error;
        $data['dokumen_pkwt'] = $dokumen_pkwt;
        $data['nama_project'] = $nama_project;
        $data['nama_sub_project'] = $nama_sub_project;
        $data['designation_name'] = $designation_name;
        $data['tanggal_pkwt'] = $tanggal_pkwt;
        $data['periode_pkwt'] = $periode_pkwt;
        $data['tanggal_awal_kontrak_new'] = $tanggal_awal_kontrak_new;
        $data['tanggal_akhir_kontrak_new'] = $tanggal_akhir_kontrak_new;
        $data['periode_kontrak_new'] = $periode_kontrak_new;

        //tombol-tombol
        $data['lihat_pkwt'] = $lihat_pkwt;
        $data['tambah_addendum'] = $tambah_addendum;

        $data['subview'] = $this->load->view("admin/employees/pkwt_addendum_edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function cetak()
    {
        // $addendum_id_encrypt = $this->uri->segment(4);
        // $addendum_id_temp = strtr($addendum_id_encrypt, array('.' => '+', '-' => '=', '~' => '/'));
        // $addendum_id = $this->secure->decrypt_url($addendum_id_temp);

        $addendum_id = $this->uri->segment(4);

        $addendum = $this->Addendum_model->getAddendum($addendum_id);

        $pkwt_id = $addendum['pkwt_id'];
        $pkwt = $this->Pkwt_model->read_pkwt_info($pkwt_id);
        //$uniqid = $pkwt[0]->uniqueid;
        if (is_null($pkwt)) {
            redirect('admin/');
        }
        $employee_id = $pkwt[0]->employee_id;
        $user = $this->Xin_model->read_user_by_employee_id($employee_id);

        $tanggalcetak               = $pkwt[0]->from_date;

        $designation = $this->Xin_model->read_user_xin_designation($pkwt[0]->jabatan);
        if (!is_null($designation)) {
            $jabatan = $designation[0]->designation_name;
        } else {
            $jabatan = '-';
        }

        $tglmulaipkwt               = $pkwt[0]->from_date;
        $tglakhirpkwt               = $pkwt[0]->to_date;
        $tglmulaipkwtbaru           = $addendum['kontrak_start_new'];
        $tglakhirpkwtbaru           = $addendum['kontrak_end_new'];

        $project = $this->Project_model->read_single_project($pkwt[0]->project);
        if (!is_null($project)) {
            $client = $project[0]->title;
        } else {
            $client = $project[0]->title;
        }

        $nomorAddendum              = $addendum['no_addendum'];
        $ttddigital                 = "<img src='" . base_url() . "assets/images/addendum/" . $addendum["esign"] . "' width='100px'>";
        $ttdkaryawan                = "<img src='" . base_url() . "assets/images/addendum/default.png' width='100px'>";
        $whiteSpace400x200          = "<img src='" . base_url() . "assets/images/addendum/default3.png'>";
        $whiteSpace300x200          = "<img src='" . base_url() . "assets/images/addendum/default2.png'>";
        $whiteSpace200x200          = "<img src='" . base_url() . "assets/images/addendum/default.png' width='200px' height='200px'>";
        $whiteSpace100x200          = "<img src='" . base_url() . "assets/images/addendum/default.png' width='100px' height='200px'>";
        $whiteSpace100x100          = "<img src='" . base_url() . "assets/images/addendum/default.png' width='100px' height='100px'>";
        $tanggalAddendum            = $this->Xin_model->tgl_indo($addendum['tgl_terbit']);
        $namaKaryawan               = $user[0]->first_name;
        $nipKaryawan                = $user[0]->employee_id;
        $alamatKaryawan             = $user[0]->alamat_ktp;
        $projectKaryawan            = $client;
        $jabatanKaryawan            = $jabatan;
        $nikKaryawan                = $user[0]->ktp_no;
        $nomorPKWT                  = $pkwt[0]->no_surat;
        $tanggalPKWT                = $this->Xin_model->tgl_indo($tanggalcetak);
        $periodeKontrak             = $pkwt[0]->waktu_kontrak . " bulan";
        $periodeKontrakNew          = $addendum['periode_new'] . " bulan";
        $kontrakStart               = $this->Xin_model->tgl_indo($tglmulaipkwt);
        $kontrakEnd                 = $this->Xin_model->tgl_indo($tglakhirpkwt);
        $kontrakStartNew            = $this->Xin_model->tgl_indo($tglmulaipkwtbaru);
        $kontrakEndNew              = $this->Xin_model->tgl_indo($tglakhirpkwtbaru);
        $namaSMHR                   = $pkwt[0]->sign_fullname;
        $alamatCompany              = "Gedung Graha Krista Aulia Cakrawala Lt. 2 Jl. Andara No. 20 Pangkalan Jati Baru Cinere Depok 16513";
        $urutanAddendum             = $addendum['urutan'];

        //$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);
        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'shrink_tables_to_fit' => '1']);
        $mpdf->SetCreator('HRCakrawala');
        $mpdf->SetAuthor('HRCakrawala');
        $mpdf->ignore_table_percents = FALSE;
        $mpdf->keep_table_proportions = TRUE;
        if ($pkwt[0]->company == 2) {
            $logo_cover = 'tcpdf_logo_sc.png';
            $header_namae = 'PT. Siprama Cakrawala';
        } else {
            $logo_cover = 'tcpdf_logo_kac.png';
            $header_namae = 'PT. Krista Aulia Cakrawala';
        }
        $header_html = '
        <table>
        <tr>
            <td>
                <figure class="image image-style-align-left image_resized" >
                <img style="vertical-align:middle;display:inline;float:left;width:150px;" src="./uploads/logo/' . $logo_cover . '"></figure>
            </td>
            <td>
                <p style="text-align:left; vertical-align:middle; display:inline;">
                    <strong>' . $header_namae . '</strong>&nbsp;&nbsp;<br>
                    HR Power Services - Facility Services&nbsp;&nbsp;<br>
                    Gedung Graha Krista Aulia, Jalan Andara Raya No. 20, Pangakalan Jati Baru, Kecamatan Cinere, Kota Depok 16514, Telp: (021) 74870859
                </p>
            </td>
        </tr>
        </table>
        ';

        $mpdf->SetHeader($header_html);
        $mpdf->SetFooter('{PAGENO} / {nb}');

        // set margins
        //$mpdf->SetMargins(15, 27, 15);
        //$mpdf->SetHeaderMargin(5);
        //$mpdf->SetFooterMargin(10);

        $isi = urldecode($addendum['isi']);

        $html = str_replace("-nomorAddendum-", $nomorAddendum, $isi);
        $html = str_replace("-tanggalAddendum-", $tanggalAddendum, $html);
        $html = str_replace("-namaKaryawan-", $namaKaryawan, $html);
        $html = str_replace("-nipKaryawan-", $nipKaryawan, $html);
        $html = str_replace("-alamatKaryawan-", $alamatKaryawan, $html);
        $html = str_replace("-projectKaryawan-", $projectKaryawan, $html);
        $html = str_replace("-jabatanKaryawan-", $jabatanKaryawan, $html);
        $html = str_replace("-nikKaryawan-", $nikKaryawan, $html);
        $html = str_replace("-nomorPKWT-", $nomorPKWT, $html);
        $html = str_replace("-tanggalPKWT-", $tanggalPKWT, $html);
        $html = str_replace("-periodeKontrak-", $periodeKontrak, $html);
        $html = str_replace("-kontrakStart-", $kontrakStart, $html);
        $html = str_replace("-kontrakEnd-", $kontrakEnd, $html);
        $html = str_replace("-namaSMHR-", $namaSMHR, $html);
        $html = str_replace("-alamatCompany-", $alamatCompany, $html);
        $html = str_replace("-ttddigital-", $ttddigital, $html);
        $html = str_replace("-ttdkaryawan-", $ttdkaryawan, $html);
        $html = str_replace("-urutanAddendum-", $urutanAddendum, $html);
        $html = str_replace("-periodeKontrakNew-", $periodeKontrakNew, $html);
        $html = str_replace("-kontrakStartNew-", $kontrakStartNew, $html);
        $html = str_replace("-kontrakEndNew-", $kontrakEndNew, $html);
        $html = str_replace("-whiteSpace400x200-", $whiteSpace400x200, $html);
        $html = str_replace("-whiteSpace300x200-", $whiteSpace300x200, $html);
        $html = str_replace("-whiteSpace200x200-", $whiteSpace200x200, $html);
        $html = str_replace("-whiteSpace100x200-", $whiteSpace100x200, $html);
        $html = str_replace("-whiteSpace100x100-", $whiteSpace100x100, $html);

        $mpdf->AddPage();
        $mpdf->SetFont('helvetica', 'B', 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output(); // buka di browser
        //$mpdf->Output('filePDF.pdf','D'); // ini opsi untuk mendownload
    }

    // Save data addendum
    public function save()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $yearmonth = date('Y/m');
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']        = './assets/'; //string, the default is application/cache/
        $config['errorlog']        = './assets/'; //string, the default is application/logs/
        $config['imagedir']        = './assets/images/addendum/' . $yearmonth . '/'; //direktori penyimpanan qr code
        $config['quality']        = true; //boolean, the default is true
        $config['size']            = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $dirsave = './assets/images/addendum/';

        //kalau blm ada folder path nya
        if (!file_exists($config['imagedir'])) {
            mkdir($config['imagedir'], 0777, true);
        }

        //ambil variable yg di post
        $tgl_terbit = $this->input->post('tgl_terbit');
        $pkwt_id = $this->input->post('pkwt_id');
        $karyawan_id = $this->input->post('karyawan_id');
        $isi = $this->input->post('isi');
        $created_by = $this->input->post('created_by');
        $created_time = $this->input->post('created_time');
        $kontrak_start_new = $this->input->post('kontrak_start_new');
        $kontrak_end_new = $this->input->post('kontrak_end_new');
        $periode_new = $this->input->post('periode_new');

        $urutan = $this->Addendum_model->urutan_addendum($karyawan_id, $pkwt_id);

        $employee_data = $this->Addendum_model->read_employee($karyawan_id);
        $company_id             = $employee_data['company_id'];
        $e_status               = $employee_data['e_status'];


        //Company Section di Nomor Addendum
        if ($company_id == '2') {
            $company_section = 'SC';
        } else if ($company_id == '3') {
            $company_section = 'KAC';
        } else {
            $company_section = 'MATA';
        }

        //Jenis Dokumen di Nomor Addendum
        $jenis_dokumen_section = "";
        if ($e_status == 1) {
            $jenis_dokumen_section = "Add-PKWT";
        } else if ($e_status == 2) {
            $jenis_dokumen_section = "Add-TKHL";
        }

        $count_addendum = $this->Addendum_model->count_addendum();
        $romawi = $this->convert_tanggal($tgl_terbit);

        $no_addendum = sprintf("%05d", $count_addendum[0]->newcount) . '/' . $jenis_dokumen_section . '/' . $company_section . '/' .  $romawi;

        $docid = date('ymdHisv');
        $yearmonth = date('Y/m');
        $image_name = $yearmonth . '/esign_addendum' . date('ymdHisv') . '.png'; //buat name dari qr code sesuai dengan nim
        $domain = 'https://apps-cakrawala.com/esign/addendum/' . $docid;
        //$domain = 'https://apps-cakrawala.com/esign/addendum/' . $no_addendum;

        $params['data']     = $domain; //data yang akan di jadikan QR CODE
        $params['level']     = 'H'; //H=High
        $params['size']     = 10;
        $params['savename'] = FCPATH . $dirsave . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data['pkwt_id'] = $pkwt_id;
        $data['karyawan_id'] = $karyawan_id;
        $data['no_addendum'] = $no_addendum;
        $data['tgl_terbit'] = $tgl_terbit;
        $data['isi'] = $isi;
        $data['esign'] = $image_name;
        $data['created_by'] = $created_by;
        $data['created_time'] = $created_time;
        $data['urutan'] = $urutan;
        $data['kontrak_start_new'] = $kontrak_start_new;
        $data['kontrak_end_new'] = $kontrak_end_new;
        $data['periode_new'] = $periode_new;

        $this->Addendum_model->add_addendum($data);

        echo json_encode($data);
    }


    // Update data addendum
    public function update()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        //ambil variable yg di post
        $tgl_terbit = $this->input->post('tgl_terbit');
        $id_addendum = $this->input->post('id_addendum');
        $isi = $this->input->post('isi');
        $kontrak_start_new = $this->input->post('kontrak_start_new');
        $kontrak_end_new = $this->input->post('kontrak_end_new');
        $periode_new = $this->input->post('periode_new');

        $data['id_addendum'] = $id_addendum;
        $data['tgl_terbit'] = $tgl_terbit;
        $data['isi'] = $isi;
        $data['kontrak_start_new'] = $kontrak_start_new;
        $data['kontrak_end_new'] = $kontrak_end_new;
        $data['periode_new'] = $periode_new;

        $this->Addendum_model->update_addendum($data);

        echo json_encode($data);
    }

    // report addendum
    public function report_addendum()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['all_projects'] = $this->Employees_model->get_req_empproject($session['employee_id']);
        $data['title'] = 'Report Addendum | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Report Addendum';
        // $data['all_projects'] = $this->Project_model->get_projects();
        $data['path_url'] = 'hrpremium_import_esaltab';
        // $data['tabel_saltab'] = $this->Import_model->get_saltab_table();
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('520', $role_resources_ids)) {
            // $data['subview'] = $this->load->view("admin/import_excel/hr_import_excel_pkwt", $data, TRUE);
            $data['subview'] = $this->load->view("admin/employees/report_addendum", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }

    //download template addendum
    public function downloadTemplateAddendum()
    {
        $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
        $spreadsheet->getActiveSheet()->setTitle('Addendum Data Seed'); //nama Spreadsheet yg baru dibuat

        $header = array(
            'nip',
            'id_pkwt',
            'tanggal_terbit',
            'isi'
        );

        $jumlah_data = count($header);

        //isi cell dari array
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $header,   // The data to set
                NULL,
                'A1'
            );

        //set column width jadi auto size
        for ($i = 1; $i <= $jumlah_data; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        //set header background color
        $maxDataRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
        $maxDataColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();

        $spreadsheet
            ->getActiveSheet()
            ->getStyle("A1:{$maxDataColumn}{$maxDataRow}")
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('BFBFBF');

        //set wrap text untuk row ke 1
        $spreadsheet->getActiveSheet()->getStyle('1:1')
            ->getAlignment()->setWrapText(true);

        //set vertical dan horizontal alignment text untuk row ke 1
        $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('@');

        //set vertical dan horizontal alignment text untuk row ke 1
        $spreadsheet->getActiveSheet()->getStyle('1:1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('1:1')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        //----------------Buat File Untuk Download--------------
        $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        //$writer->setPreCalculateFormulas(false);

        $filename = 'Template Import Addendum'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file 
        //$writer->save('./absen/tes2.xlsx');	// download file 
    }

    /*
    |-------------------------------------------------------------------
    | Import Excel saltab
    |-------------------------------------------------------------------
    |
    */
    function import_addendum()
    {
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

        if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

            $array_file = explode('.', $_FILES['file_excel']['name']);
            $extension  = end($array_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
            $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
            $array_data  = [];
            $data        = [];
            $header_tabel_saltab = $sheet_data[0];
            $length_header = count($header_tabel_saltab);


            //susun array saltab detail
            for ($i = 1; $i < count($sheet_data); $i++) {
                for ($j = 0; $j < $length_header; $j++) {
                    $data += [$header_tabel_saltab[$j] => $sheet_data[$i][$j]];
                }
                $this->save_import($data);
                $array_data[] = $data;
                $data = array();
            }

            echo '<pre>';
            print_r($array_data);
            echo '</pre>';
        } else {
            // $this->modal_feedback('error', 'Error', 'Import failed', 'Try again');
            print_r("gagal import");
            print_r($_FILES['file_excel']['name']);
        }

        redirect('admin/addendum/report_addendum/');
    }

    public function save_import2($data)
    {
        $yearmonth = date('Y-m-d H:i:s');
        echo '<script language="javascript">';
        echo 'alert("Warning! The role you are to going delete has some employees.\nIsi addendum:' .  $yearmonth . '")';
        echo '</script>';
    }

    // Save data addendum
    public function save_import($data)
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $yearmonth = date('Y/m');
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']        = './assets/'; //string, the default is application/cache/
        $config['errorlog']        = './assets/'; //string, the default is application/logs/
        $config['imagedir']        = './assets/images/addendum/' . $yearmonth . '/'; //direktori penyimpanan qr code
        $config['quality']        = true; //boolean, the default is true
        $config['size']            = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $dirsave = './assets/images/addendum/';

        //kalau blm ada folder path nya
        if (!file_exists($config['imagedir'])) {
            mkdir($config['imagedir'], 0777, true);
        }

        //ambil variable yg di post
        $nip = $data['nip'];
        $tgl_terbit = $data['tanggal_terbit'];
        $pkwt_id = $data['id_pkwt'];
        $isi = $data['isi'];

        //assingn variable sisanya
        $contract_data = $this->Addendum_model->getContract($pkwt_id);
        $employee_data = $this->Addendum_model->read_employee_by_nip($nip);

        $karyawan_id = $employee_data['user_id'];
        $created_by = $session['user_id'];
        $created_time = date('Y-m-d H:i:s');
        $kontrak_start_new = $contract_data['from_date'];
        $kontrak_end_new = $contract_data['to_date'];
        $periode_new = $contract_data['waktu_kontrak'];

        $urutan = $this->Addendum_model->urutan_addendum($karyawan_id, $pkwt_id);

        // $employee_data = $this->Addendum_model->read_employee($karyawan_id);
        $company_id             = $employee_data['company_id'];
        $e_status               = $employee_data['e_status'];


        //Company Section di Nomor Addendum
        if ($company_id == '2') {
            $company_section = 'SC';
        } else if ($company_id == '3') {
            $company_section = 'KAC';
        } else {
            $company_section = 'MATA';
        }

        //Jenis Dokumen di Nomor Addendum
        $jenis_dokumen_section = "";
        if ($e_status == 1) {
            $jenis_dokumen_section = "Add-PKWT";
        } else if ($e_status == 2) {
            $jenis_dokumen_section = "Add-TKHL";
        }

        $count_addendum = $this->Addendum_model->count_addendum();
        $romawi = $this->convert_tanggal($tgl_terbit);

        $no_addendum = sprintf("%05d", $count_addendum[0]->newcount) . '/' . $jenis_dokumen_section . '/' . $company_section . '/' .  $romawi;

        $docid = date('ymdHisv');
        $yearmonth = date('Y/m');
        $image_name = $yearmonth . '/esign_addendum' . date('ymdHisv') . '.png'; //buat name dari qr code sesuai dengan nim
        $domain = 'https://apps-cakrawala.com/esign/addendum/' . $docid;
        //$domain = 'https://apps-cakrawala.com/esign/addendum/' . $no_addendum;

        $params['data']     = $domain; //data yang akan di jadikan QR CODE
        $params['level']     = 'H'; //H=High
        $params['size']     = 10;
        $params['savename'] = FCPATH . $dirsave . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data['pkwt_id'] = $pkwt_id;
        $data['karyawan_id'] = $karyawan_id;
        $data['no_addendum'] = $no_addendum;
        $data['tgl_terbit'] = $tgl_terbit;
        $data['isi'] = $isi;
        $data['esign'] = $image_name;
        $data['created_by'] = $created_by;
        $data['created_time'] = $created_time;
        $data['urutan'] = $urutan;
        $data['kontrak_start_new'] = $kontrak_start_new;
        $data['kontrak_end_new'] = $kontrak_end_new;
        $data['periode_new'] = $periode_new;

        $this->Addendum_model->add_addendum($data);

        echo json_encode($data);
    }
}

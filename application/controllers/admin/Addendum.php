<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        $project = $this->Project_model->read_single_project($pkwt[0]->project);
        if (!is_null($project)) {
            $client = $project[0]->title;
        } else {
            $client = $project[0]->title;
        }

        $nomorAddendum              = $addendum['no_addendum'];
        $ttddigital                 = "<img src='" . base_url() . "assets/images/addendum/" . $addendum["esign"] . "' width='100px'>";
        $ttdkaryawan                = "<img src='" . base_url() . "assets/images/addendum/default.png' width='100px'>";
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
        $kontrakStart               = $this->Xin_model->tgl_indo($tglmulaipkwt);
        $kontrakEnd                 = $this->Xin_model->tgl_indo($tglakhirpkwt);
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

        $html = str_replace("-nomorAddendum-", $nomorAddendum, $addendum['isi']);
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
        $data['urutan'] = $urutan;

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

        $data['id_addendum'] = $id_addendum;
        $data['tgl_terbit'] = $tgl_terbit;
        $data['isi'] = $isi;

        $this->Addendum_model->update_addendum($data);

        echo json_encode($data);
    }
}

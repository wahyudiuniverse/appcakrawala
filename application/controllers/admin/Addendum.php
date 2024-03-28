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
            'breadcrumbs' => "Manage PKWT Employee",
            'title' => "PKWT Manager",
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
        $addendum = $this->Addendum_model->getAddendum($addendum_id);

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
            'breadcrumbs' => "Manage PKWT Employee",
            'title' => "PKWT Manager",
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

        $data['subview'] = $this->load->view("admin/employees/pkwt_addendum_add", $data, TRUE);
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

        $nomorsurat                 = $pkwt[0]->no_surat;
        $nomorspb                   = $pkwt[0]->no_spb;
        // $sign_nip 				= $pkwt[0]->sign_nip;
        $sign_fullname              = $pkwt[0]->sign_fullname;
        $sign_jabatan               = $pkwt[0]->sign_jabatan;
        $sign_qrcode                = $pkwt[0]->img_esign;
        $pkwt_active                = $pkwt[0]->status_pkwt;

        $tanggalcetak               = $pkwt[0]->from_date;
        $namalengkap                = $user[0]->first_name;
        $tempattgllahir             = $user[0]->tempat_lahir . ', ' . $this->Xin_model->tgl_indo($user[0]->date_of_birth);

        $designation = $this->Xin_model->read_user_xin_designation($pkwt[0]->jabatan);
        if (!is_null($designation)) {
            $jabatan = $designation[0]->designation_name;
        } else {
            $jabatan = '-';
        }

        $alamatlengkap              = $user[0]->alamat_ktp;
        $nomorkontak                = $user[0]->contact_no;
        $ktp                        = $user[0]->ktp_no;

        $penempatan                 = $pkwt[0]->penempatan;
        $waktukontrak               = $pkwt[0]->waktu_kontrak;
        $tglmulaipkwt               = $pkwt[0]->from_date;
        $tglakhirpkwt               = $pkwt[0]->to_date;
        $waktukerja                 = $pkwt[0]->hari_kerja;

        $project = $this->Xin_model->read_user_xin_project($pkwt[0]->project);
        if (!is_null($project)) {
            $client = $project[0]->title;
        } else {
            $client = $project[0]->title;
        }

        $basicpay                   = $this->Xin_model->rupiah($pkwt[0]->basic_pay);
        $allowance_grade            = $this->Xin_model->rupiah($pkwt[0]->allowance_grade);
        $allowance_area             = $this->Xin_model->rupiah($pkwt[0]->allowance_area);
        $allowance_masakerja        = $this->Xin_model->rupiah($pkwt[0]->allowance_masakerja);
        $allowance_meal             = $this->Xin_model->rupiah($pkwt[0]->allowance_meal);
        $allowance_transport        = $this->Xin_model->rupiah($pkwt[0]->allowance_transport);
        $allowance_rent             = $this->Xin_model->rupiah($pkwt[0]->allowance_rent);
        $allowance_komunikasi       = $this->Xin_model->rupiah($pkwt[0]->allowance_komunikasi);
        $allowance_park             = $this->Xin_model->rupiah($pkwt[0]->allowance_park);
        $allowance_residance        = $this->Xin_model->rupiah($pkwt[0]->allowance_residance);

        $allowance_laptop           = $this->Xin_model->rupiah($pkwt[0]->allowance_laptop);
        $allowance_kasir            = $this->Xin_model->rupiah($pkwt[0]->allowance_kasir);
        $allowance_transmeal        = $this->Xin_model->rupiah($pkwt[0]->allowance_transmeal);
        $allowance_medicine         = $this->Xin_model->rupiah($pkwt[0]->allowance_medicine);
        $allowance_akomodasi        = $this->Xin_model->rupiah($pkwt[0]->allowance_akomodasi);
        $allowance_operation        = $this->Xin_model->rupiah($pkwt[0]->allowance_operation);


        $tgl_mulaiperiode_payment   = $pkwt[0]->start_period_payment;
        $tgl_akhirperiode_payment   = $pkwt[0]->end_period_payment;
        $tgl_payment                = $pkwt[0]->tgl_payment;

        $nomorAddendum              = $nomorsurat;
        $tanggalAddendum            = $this->Xin_model->tgl_indo($tanggalcetak);
        $namaKaryawan               = $user[0]->first_name;
        $nipKaryawan                = $user[0]->employee_id;
        $alamatKaryawan             = $user[0]->alamat_ktp;
        $projectKaryawan            = $user[0]->project_id;
        $jabatanKaryawan            = $jabatan;
        $nikKaryawan                = $user[0]->ktp_no;
        $nomorPKWT                  = $pkwt[0]->no_surat;
        $tanggalPKWT                = $this->Xin_model->tgl_indo($tanggalcetak);
        $periodeKontrak             = $pkwt[0]->waktu_kontrak . " bulan";
        $kontrakStart               = $this->Xin_model->tgl_indo($tglmulaipkwt);
        $kontrakEnd                 = $this->Xin_model->tgl_indo($tglakhirpkwt);
        $namaSMHR                   = $pkwt[0]->sign_fullname;
        $alamatCompany              = "Gedung Graha Krista Aulia Cakrawala Lt. 2 Jl. Andara No. 20 Pangkalan Jati Baru Cinere Depok 16513";

        //$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);
        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch']);
        $mpdf->SetCreator('HRCakrawala');
        $mpdf->SetAuthor('HRCakrawala');
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
        $mpdf->SetFooter('{PAGENO}');

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

        $mpdf->AddPage();
        $mpdf->SetFont('helvetica', 'B', 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output(); // buka di browser
        //$mpdf->Output('filePDF.pdf','D'); // ini opsi untuk mendownload
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model registrasi
        $this->load->model('Register_model', 'register');
        //$this->load->model("Xin_model");
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil library fpdf
        $this->load->library('pdfregister');
        $this->load->library('secure');
        //Memanggil Helper Login
        //is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
        $this->load->helper(array('form', 'url'));
    }

    //Menampilkan halaman awal data karyawan
    public function index()
    {
        //initiate page dan nik default
        $halaman = 'nik';
        $nik = '0';

        //title halaman
        $data['title'] = 'Registrasi Karyawan';

        //siapkan data default awal untuk dikirim ke view
        $data['halaman'] = $halaman;
        $data['karyawan'] = $nik;

        //$this->encryption->encode($nik, $key);
        //$nik = strtr($nik, array('+' => '.', '=' => '-', '/' => '~'));

        $nik_link_temp = $this->secure->encrypt_url($nik);
        $nik_link = strtr($nik_link_temp, array('+' => '.', '=' => '-', '/' => '~'));

        //$nik_url = urlencode(base64_encode($nik));

        //redirect(base_url() . '/register/addRegister/' . $halaman . '/' . $nik);

        $this->addRegister($halaman, $nik_link);

        //menampilkan halaman form isian
        //$this->load->view('templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        //$this->load->view('templates/topbar_register', $data);
        //$this->load->view('karyawan/add_register2', $data);
        //$this->load->view('templates/footer');
    }

    //mengambil Json data Sub Project berdasarkan projectnya
    public function getSubByProject()
    {
        $postData = $this->input->post();

        // get data 
        $data = $this->register->getSubByProjectJson($postData);
        echo json_encode($data);
    }

    //mengambil Json data Sub Project berdasarkan projectnya
    public function getSubByProjectTes($id)
    {
        //$postData = $this->input->post();

        // get data 
        $data = $this->register->getSubByProjectJsonTes($id);
        echo json_encode($data);
    }

    //mengambil Json data Jabatan berdasarkan projectnya
    public function getJabatanByProject()
    {
        $postData = $this->input->post();

        // get data 
        $data = $this->register->getJabatanByProjectJson($postData);
        echo json_encode($data);
    }

    //Menampilkan Register dengan parameter untuk pindah tab
    public function addRegister($halaman, $nik_p)
    {

        //Title halaman
        $data['title'] = 'Registrasi Karyawan';

        //$nik = urldecode(base64_decode($nik_p));
        //print_r($nik_p);
        //$nik_url = urlencode(base64_encode($nik));

        //$this->encryption->encode($nik, $key);
        //$nik = strtr($nik, array('+' => '.', '=' => '-', '/' => '~'));

        $nik_temp = strtr($nik_p, array('.' => '+', '-' => '=', '~' => '/'));
        $nik = $this->secure->decrypt_url($nik_temp);

        //$nik = strtr($nik_p, array('.' => '+', '-' => '=', '~' => '/'));
        //$this->encryption->decode($nik, $key);

        $nik_url_temp = $this->secure->encrypt_url($nik);
        $nik_url = strtr($nik_url_temp, array('+' => '.', '=' => '-', '/' => '~'));

        //print_r("nik_p = " . $nik_p . "<br>");
        //print_r("nik = " . $nik . "<br>");
        //print_r("nik_url = " . $nik_url . "<br>");

        //$this->encryption->encode($nik_url, $key);
        //$nik_url = strtr($nik_url, array('+' => '.', '=' => '-', '/' => '~'));

        $data['nik_url'] = $nik_url;

        //-----cek data-----
        //data $_POST
        $data['cek_post'] = $_POST;
        //data $_FILES
        $data['cek_files'] = $_FILES;
        //data NIK
        $temp = $this->input->post('nik_karyawan');
        $data['register'] = $this->register->getAllEmployeesByNIK($nik);
        $data['cek_temp'] = $temp;
        $data_diri = $data['register'];
        //data company
        $temp_perusahaan = $this->input->post('perusahaan');
        $data['cek_company'] = is_null($data_diri) ? "0" : $data_diri['company_id'];
        $data['cek_temp_perusahaan'] = $temp_perusahaan;
        //untuk testing
        $data_company = $data['cek_company'];
        $data_project = is_null($data_diri) ? "" : $data_diri['project'];
        //data project
        $temp_project = $this->input->post('project');
        $data['projects'] = $this->register->getProjectByCompany($data_company);
        //data sub project
        $data['sub_projects'] = $this->register->getSubByProject($data_project);
        //data jabatan
        $data['jabatan'] = $this->register->getJabatanByProject($data_project);
        //data agama
        $data['agama'] = $this->register->getAllAgama();
        //data marital
        $data['marital'] = $this->register->getAllMarital();
        //data tingkat pendidikan
        $data['education_lvl'] = $this->register->getAllEducationLevel();
        //data bank
        $data['bank'] = $this->register->getAllBank();
        //data family relation
        $data['relation'] = $this->register->getAllFamilyRelation();
        //data kontak darurat
        $data['kontak_darurat'] = $this->register->getKontakDarurat($nik);
        $data['error_upload'] = "";

        //perlakuan berbeda untuk setiap halaman form
        if ($halaman == 'nik') {
            //kalau tidak ada post nik
            if ($temp == "") {
                //kalau tidak ada parsing nik dari tab lain
                if ($nik == '0') {
                    $nik = '3210293010880006';
                    //redirect(base_url() . '/register/addRegister/' . $halaman . '/' . $nik);
                }
            } else {
                $nik = $temp;
                //kalau di halaman nik dan blm ada data nik di database, save data nik baru
                $cek_nik = $this->register->getAllEmployeesByNIK($nik);
                if ($cek_nik == "") {
                    $this->register->createEmployee($nik);
                }
                //pindah next page
                $halaman = 'perusahaan';

                $nik_url_temp = $this->secure->encrypt_url($nik);
                $nik_url = strtr($nik_url_temp, array('+' => '.', '=' => '-', '/' => '~'));
                $data['nik_url'] = $nik_url;
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'perusahaan') {
            //kalau ada post perusahaan
            if ($temp_perusahaan != "") {
                $this->register->isiCompany($nik, $temp_perusahaan);
                $halaman = 'project';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'project') {
            //kalau ada post project
            if ($temp_project != "") {
                $this->register->isiProject($nik, $data['cek_post']);
                $halaman = 'data_diri';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'data_diri') {
            //kalau suda ada di database
            if ($data['cek_post']) {
                $this->register->isiDataDiri($nik, $data['cek_post']);
                $halaman = 'kontak_darurat';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'kontak_darurat') {
            //kalau dipost post
            if ($data['cek_post']) {
                //kalau udah punya kontak darurat
                $cek_kontak_darurat = $this->register->getKontakDarurat($nik);
                if ($cek_kontak_darurat == "") {
                    $this->register->isiDataKontakDarurat($nik, $data['cek_post']);
                    $halaman = 'dokumen';
                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                } else {
                    $this->register->updateDataKontakDarurat($nik, $data['cek_post']);
                    $halaman = 'dokumen';
                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            }
        } else if ($halaman == 'dokumen') {
            //jika diupload file foto ktp
            if ($_FILES['foto_ktp']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/ktp/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_ktp']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'ktp_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_ktp')) {
                    $error = array('error' => $this->upload->display_errors());
                    //$data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathKTP($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_kk']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/kk/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_kk']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'kk_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_kk')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto KK melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathKK($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_npwp']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/npwp/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_npwp']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'npwp_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_npwp')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto NPWP melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathNPWP($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_ijazah']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/ijazah/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_ijazah']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'ijazah_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_ijazah')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto Ijazah melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathIjazah($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_cv']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/cv/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_cv']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'cv_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_cv')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto CV melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathCV($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_skck']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/skck/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_skck']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'skck_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_skck')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto SKCK melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathSKCK($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            }

            //-----kodingan mas wahyu------
            /*
            if (is_uploaded_file($_FILES['dokumen_cv']['tmp_name'])) {
                //checking image type
                $allowedcv =  array('png', 'jpg', 'jpeg', 'pdf');
                $filenamecv = $_FILES['dokumen_cv']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);

                if (in_array($extcv, $allowedcv)) {
                    $tmp_namecv = $_FILES["dokumen_cv"]["tmp_name"];
                    $yearmonth = date('Y/m');
                    $documentdcv = "uploads/document/cv/" . $yearmonth . '/';
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $name = basename($_FILES["dokumen_cv"]["name"]);
                    $newfilenamecv = 'cv_' . $this->input->post('nomor_ktp') . '_' . round(microtime(true)) . '.' . $extcv;
                    move_uploaded_file($tmp_namecv, $documentdcv . $newfilenamecv);
                    $fnamecv = 'https://apps-cakrawala.com/uploads/document/cv/' . $yearmonth . '/' . $newfilenamecv;
                } else {
                    $Return['error'] = 'Jenis File CV tidak diterima..';
                }
            }*/
            //$halaman = 'data_diri';
        } else if ($halaman == 'review') {
            $halaman = 'review';
            //redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
        } else {
            $halaman = 'nik';
            //redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
        }

        /*
        //kalau belum ada data, nik di set 0, kalau sudah ada, nik menggunakan nik_ktp dari database dan pindah halaman selanjutnya
        if ($temp == "") {
            if ($nik == '0') {
                $nik = '0';
            }
        } else {
            $nik = $temp;

            //save data dan pindah ke halaman sejanjutnya
            if ($halaman == 'nik') {
                //kalau di halaman nik dan blm ada data nik di database, save data nik baru
                if ($data['register'] == "") {
                    $this->register->createEmployee($nik);
                }
                //pindah next page
                $halaman = 'perusahaan';
            } else if ($halaman == 'perusahaan') {
                $this->register->isiCompany($nik, $temp_perusahaan);

                $halaman = 'project';
            } else if ($halaman == 'project') {
                $halaman = 'data_diri';
            } else if ($halaman == 'data_diri') {
                $halaman = 'dokumen';
            } else if ($halaman == 'dokumen') {
                $halaman = 'review';
            } else if ($halaman == 'review') {
                $halaman = 'review';
            } else {
                $halaman = 'nik';
            }
        }*/

        /*if ($temp == "") {
            //save nik baru
            $this->register->createEmployee();
        }*/

        //----Persiapan data----
        $data['companies'] = $this->register->getAllCompany();
        $data['karyawan'] = $nik_url;
        $data['cek_nik'] = $nik;
        $data['halaman'] = $halaman;

        //menampilkan view form pengisian data
        $this->load->view('frontend/templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        $this->load->view('frontend/templates/topbar_register', $data);
        $this->load->view('frontend/add_register2', $data);
        $this->load->view('frontend/templates/footer');
    }

    //Menampilkan Register tanpa parameter untuk proses POST variable
    public function addRegisterPost()
    {

        //Title halaman
        $data['title'] = 'Registrasi Karyawan';

        //$nik = urldecode(base64_decode($nik_p));
        //print_r($nik_p);
        //$nik_url = urlencode(base64_encode($nik));

        //$this->encryption->encode($nik, $key);
        //$nik = strtr($nik, array('+' => '.', '=' => '-', '/' => '~'));

        $nik_temp = strtr($nik_p, array('.' => '+', '-' => '=', '~' => '/'));
        $nik = $this->secure->decrypt_url($nik_temp);

        //$nik = strtr($nik_p, array('.' => '+', '-' => '=', '~' => '/'));
        //$this->encryption->decode($nik, $key);

        $nik_url_temp = $this->secure->encrypt_url($nik);
        $nik_url = strtr($nik_url_temp, array('+' => '.', '=' => '-', '/' => '~'));

        //print_r("nik_p = " . $nik_p . "<br>");
        //print_r("nik = " . $nik . "<br>");
        //print_r("nik_url = " . $nik_url . "<br>");

        //$this->encryption->encode($nik_url, $key);
        //$nik_url = strtr($nik_url, array('+' => '.', '=' => '-', '/' => '~'));

        $data['nik_url'] = $nik_url;

        //-----cek data-----
        //data $_POST
        $data['cek_post'] = $_POST;
        //data $_FILES
        $data['cek_files'] = $_FILES;
        //data NIK
        $temp = $this->input->post('nik_karyawan');
        $data['register'] = $this->register->getAllEmployeesByNIK($nik);
        $data['cek_temp'] = $temp;
        $data_diri = $data['register'];
        //data company
        $temp_perusahaan = $this->input->post('perusahaan');
        $data['cek_company'] = is_null($data_diri) ? "0" : $data_diri['company_id'];
        $data['cek_temp_perusahaan'] = $temp_perusahaan;
        //untuk testing
        $data_company = $data['cek_company'];
        $data_project = is_null($data_diri) ? "" : $data_diri['project'];
        //data project
        $temp_project = $this->input->post('project');
        $data['projects'] = $this->register->getProjectByCompany($data_company);
        //data sub project
        $data['sub_projects'] = $this->register->getSubByProject($data_project);
        //data jabatan
        $data['jabatan'] = $this->register->getJabatanByProject($data_project);
        //data agama
        $data['agama'] = $this->register->getAllAgama();
        //data marital
        $data['marital'] = $this->register->getAllMarital();
        //data tingkat pendidikan
        $data['education_lvl'] = $this->register->getAllEducationLevel();
        //data bank
        $data['bank'] = $this->register->getAllBank();
        //data family relation
        $data['relation'] = $this->register->getAllFamilyRelation();
        //data kontak darurat
        $data['kontak_darurat'] = $this->register->getKontakDarurat($nik);
        $data['error_upload'] = "";

        //perlakuan berbeda untuk setiap halaman form
        if ($halaman == 'nik') {
            //kalau tidak ada post nik
            if ($temp == "") {
                //kalau tidak ada parsing nik dari tab lain
                if ($nik == '0') {
                    $nik = '3210293010880006';
                    //redirect(base_url() . '/register/addRegister/' . $halaman . '/' . $nik);
                }
            } else {
                $nik = $temp;
                //kalau di halaman nik dan blm ada data nik di database, save data nik baru
                $cek_nik = $this->register->getAllEmployeesByNIK($nik);
                if ($cek_nik == "") {
                    $this->register->createEmployee($nik);
                }
                //pindah next page
                $halaman = 'perusahaan';

                $nik_url_temp = $this->secure->encrypt_url($nik);
                $nik_url = strtr($nik_url_temp, array('+' => '.', '=' => '-', '/' => '~'));
                $data['nik_url'] = $nik_url;
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'perusahaan') {
            //kalau ada post perusahaan
            if ($temp_perusahaan != "") {
                $this->register->isiCompany($nik, $temp_perusahaan);
                $halaman = 'project';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'project') {
            //kalau ada post project
            if ($temp_project != "") {
                $this->register->isiProject($nik, $data['cek_post']);
                $halaman = 'data_diri';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'data_diri') {
            //kalau suda ada di database
            if ($data['cek_post']) {
                $this->register->isiDataDiri($nik, $data['cek_post']);
                $halaman = 'kontak_darurat';
                redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
            }
        } else if ($halaman == 'kontak_darurat') {
            //kalau dipost post
            if ($data['cek_post']) {
                //kalau udah punya kontak darurat
                $cek_kontak_darurat = $this->register->getKontakDarurat($nik);
                if ($cek_kontak_darurat == "") {
                    $this->register->isiDataKontakDarurat($nik, $data['cek_post']);
                    $halaman = 'dokumen';
                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                } else {
                    $this->register->updateDataKontakDarurat($nik, $data['cek_post']);
                    $halaman = 'dokumen';
                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            }
        } else if ($halaman == 'dokumen') {
            //jika diupload file foto ktp
            if ($_FILES['foto_ktp']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/ktp/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_ktp']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'ktp_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_ktp')) {
                    $error = array('error' => $this->upload->display_errors());
                    //$data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto KTP melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathKTP($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_kk']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/kk/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_kk']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'kk_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_kk')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto KK melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathKK($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_npwp']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/npwp/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_npwp']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'npwp_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_npwp')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto NPWP melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathNPWP($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_ijazah']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/ijazah/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_ijazah']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'ijazah_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_ijazah')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto Ijazah melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathIjazah($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_cv']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/cv/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_cv']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'cv_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_cv')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto CV melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathCV($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            } else if ($_FILES['foto_skck']) {
                $yearmonth = date('Y/m');
                $documentdktp = "./uploads/document/skck/" . $yearmonth . '/';

                //kalau blm ada folder path nya
                if (!file_exists($documentdktp)) {
                    mkdir($documentdktp, 0777, true);
                }

                //buat nama file baru dengan format ktp_[nik].[ext]
                $filenamecv = $_FILES['foto_skck']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
                $newfilenamecv = 'skck_' . $nik . '.' . $extcv;

                //konfigurasi upload
                $config['upload_path']          = $documentdktp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']             = 2048;
                $config['file_name']             = $newfilenamecv;
                $config['overwrite']             = TRUE;

                //inisialisasi proses upload
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload data kalau tidak ada error
                if (!$this->upload->do_upload('foto_skck')) {
                    $error = array('error' => $this->upload->display_errors());
                    if ($error['error'] == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                        $data['error_upload'] = "Foto SKCK melebihi ukuran 2 MB. Silahkan upload ulang";
                    } else {
                        $data['error_upload'] = "Hanya menerima file berformat JPG, JPEG, PNG, dan PDF";
                    }
                } else {
                    //save path ktp ke database
                    $path_ktp = $yearmonth . '/' . $newfilenamecv;
                    $this->register->isiPathSKCK($nik, $path_ktp);
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->delete_cache();

                    redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
                }
            }

            //-----kodingan mas wahyu------
            /*
            if (is_uploaded_file($_FILES['dokumen_cv']['tmp_name'])) {
                //checking image type
                $allowedcv =  array('png', 'jpg', 'jpeg', 'pdf');
                $filenamecv = $_FILES['dokumen_cv']['name'];
                $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);

                if (in_array($extcv, $allowedcv)) {
                    $tmp_namecv = $_FILES["dokumen_cv"]["tmp_name"];
                    $yearmonth = date('Y/m');
                    $documentdcv = "uploads/document/cv/" . $yearmonth . '/';
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $name = basename($_FILES["dokumen_cv"]["name"]);
                    $newfilenamecv = 'cv_' . $this->input->post('nomor_ktp') . '_' . round(microtime(true)) . '.' . $extcv;
                    move_uploaded_file($tmp_namecv, $documentdcv . $newfilenamecv);
                    $fnamecv = 'https://apps-cakrawala.com/uploads/document/cv/' . $yearmonth . '/' . $newfilenamecv;
                } else {
                    $Return['error'] = 'Jenis File CV tidak diterima..';
                }
            }*/
            //$halaman = 'data_diri';
        } else if ($halaman == 'review') {
            $halaman = 'review';
            //redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
        } else {
            $halaman = 'nik';
            //redirect(base_url() . 'register/addRegister/' . $halaman . '/' . $nik_url);
        }

        /*
        //kalau belum ada data, nik di set 0, kalau sudah ada, nik menggunakan nik_ktp dari database dan pindah halaman selanjutnya
        if ($temp == "") {
            if ($nik == '0') {
                $nik = '0';
            }
        } else {
            $nik = $temp;

            //save data dan pindah ke halaman sejanjutnya
            if ($halaman == 'nik') {
                //kalau di halaman nik dan blm ada data nik di database, save data nik baru
                if ($data['register'] == "") {
                    $this->register->createEmployee($nik);
                }
                //pindah next page
                $halaman = 'perusahaan';
            } else if ($halaman == 'perusahaan') {
                $this->register->isiCompany($nik, $temp_perusahaan);

                $halaman = 'project';
            } else if ($halaman == 'project') {
                $halaman = 'data_diri';
            } else if ($halaman == 'data_diri') {
                $halaman = 'dokumen';
            } else if ($halaman == 'dokumen') {
                $halaman = 'review';
            } else if ($halaman == 'review') {
                $halaman = 'review';
            } else {
                $halaman = 'nik';
            }
        }*/

        /*if ($temp == "") {
            //save nik baru
            $this->register->createEmployee();
        }*/

        //----Persiapan data----
        $data['companies'] = $this->register->getAllCompany();
        $data['karyawan'] = $nik_url;
        $data['cek_nik'] = $nik;
        $data['halaman'] = $halaman;

        //menampilkan view form pengisian data
        $this->load->view('frontend/templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        $this->load->view('frontend/templates/topbar_register', $data);
        $this->load->view('frontend/add_register2', $data);
        $this->load->view('frontend/templates/footer');
    }
}

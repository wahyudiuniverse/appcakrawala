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
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkwt14 extends MY_Controller 
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct(){
          parent::__construct();
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model('Xin_model');
			$this->load->model("Employees_model");
		  $this->load->model("Project_model");
			$this->load->model("Pkwt_model");
		  // $this->load->model("Tax_model");
		  // $this->load->model("Invoices_model");
		  $this->load->model("Clients_model");
		  $this->load->model("Finance_model");
			$this->load->model("Department_model");
			$this->load->model("Designation_model");
			$this->load->model("Location_model");
			$this->load->model("Roles_model");
			$this->load->model("City_model");
			$this->load->model("Contracts_model");
			$this->load->library("pagination");
			$this->load->library('Pdf');
			$this->load->helper('string');
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_pkwt').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_pkwt');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_employees'] = $this->Employees_model->get_all_employees_active();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'hrpremium_pkwt';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('34',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/pkwt/pkwt_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}


	public function view() {
		$system = $this->Xin_model->read_setting_info(1);
		 // create new PDF document
   	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$uniqueid = $this->uri->segment(4);
		// $uniqueid = $this->uri->segment(5);

		$pkwt = $this->Pkwt_model->read_pkwt_info_byuniq($uniqueid);
		if(is_null($pkwt)){
			redirect('admin/');
		}
		$employee_id = $pkwt[0]->employee_id;
		$user = $this->Xin_model->read_user_by_employee_id($employee_id);
		$bank = $this->Xin_model->read_user_bank($employee_id);

		if($pkwt[0]->approve_hrd != null){

					$logo_cover = 'tcpdf_logo_kac.png';
					$header_namae = 'PT. Krista Aulia Cakrawala';

				// set document information
				$pdf->SetCreator('HRCakrawala');
				$pdf->SetAuthor('HRCakrawala');
				// $baseurl=base_url();

				$header_namae = 'PT. Krista Aulia Cakrawala';
				$header_string = 'HR Power Services | Facility Services'."\n".'Gedung Graha Krista Aulia, Jalan Andara Raya No. 20, Pangakalan Jati Baru, Kecamatan Cinere, Kota Depok 16514, Telp: (021) 74870859';

				$pdf->SetHeaderData($logo_cover, 35, $header_namae, $header_string);
				
				$pdf->setFooterData(array(0,64,0), array(0,64,128));
			
				// set header and footer fonts
				// $pdf->setHeaderFont(Array('helvetica', ', 20));
				// $pdf->setFooterFont(Array('helvetica', ', 9));
			
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont('courier');
				
				// set margins
				$pdf->SetMargins(15, 27, 15);
				$pdf->SetHeaderMargin(5);
				$pdf->SetFooterMargin(10);
				
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 25);
				
				// set image scale factor
				$pdf->setImageScale(10);

				$pdf->SetAuthor('HRCakrawala');
				$pdf->SetTitle('PT. Krista Aulia Cakrawala '.' - '.$this->lang->line('xin_download_profile_title'));
				$pdf->SetSubject($this->lang->line('xin_download_profile_title'));
				$pdf->SetKeywords($this->lang->line('xin_download_profile_title'));
				// set font
				$pdf->SetFont('helvetica', 'B', 10);
						
				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 12);
				
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				
				// ---------------------------------------------------------

				// set default font subsetting mode
				$pdf->setFontSubsetting(true);
				
				// Set font
				// dejavusans is a UTF-8 Unicode font, if you only need to
				// print standard ASCII chars, you can use core fonts like
				// helvetica or times to reduce file size.
				$pdf->SetFont('helvetica', '', 9, '', true);
				
				// Add a page
				// This method has several options, check the source code documentation for more information.
				$pdf->AddPage();
				/*$tbl = '<br>
				<table cellpadding="1" cellspacing="1" border="0">
					<tr>
						<td align="center"><h1>'.$fname.'</h1></td>
					</tr>
				</table>
				';
				$pdf->writeHTML($tbl, true, false, false, false, ');*/
				// -----------------------------------------------------------------------------



				// $date_of_joining = $this->Xin_model->set_date_format($user[0]->date_of_joining);
				// $date_of_birth = $this->Xin_model->set_date_format($user[0]->date_of_birth);
				// $set_ethnicity = $this->Xin_model->read_user_xin_ethnicity($user[0]->ethnicity_type);
				// $set_marital = $this->Xin_model->read_user_xin_marital($user[0]->marital_status);
				// $set_location_office = $this->Xin_model->read_user_xin_office_location($user[0]->location_id);
				// $set_department = $this->Xin_model->read_user_xin_department($user[0]->department_id);
				// $set_designation = $this->Xin_model->read_user_xin_designation($user[0]->designation_id);
				//----------------------------------------------------------------------------------------
			
				// set cell padding
				$pdf->setCellPaddings(1, 1, 1, 1);
				
				// set cell margins
				$pdf->setCellMargins(0, 0, 0, 0);
				
				// set color for background
				$pdf->SetFillColor(255, 255, 127);
				/////////////////////////////////////////////////////////////////////////////////

				if(!is_null($pkwt)){



					$nomorsurat 							= $pkwt[0]->no_surat;
					$nomorspb 								= $pkwt[0]->no_spb;
					// $sign_nip 								= $pkwt[0]->sign_nip;
					$sign_fullname 						= $pkwt[0]->sign_fullname;
					$sign_jabatan 						= $pkwt[0]->sign_jabatan;
					$sign_qrcode 							= $pkwt[0]->img_esign;
					$pkwt_active							= $pkwt[0]->status_pkwt;

					$tanggalcetak 						= date("Y-m-d");
					$namalengkap 							= $user[0]->first_name;
					$tempattgllahir 					= $user[0]->tempat_lahir.', '.$this->Xin_model->tgl_indo($user[0]->date_of_birth);

					$designation = $this->Xin_model->read_user_xin_designation($pkwt[0]->jabatan);
					if(!is_null($designation)){
						$jabatan = $designation[0]->designation_name;
					} else {
						$jabatan = '-';
					}

					$alamatlengkap 					= $user[0]->alamat_ktp;
					$nomorkontak 						= $user[0]->contact_no;
					$ktp 										= $user[0]->ktp_no;

					$penempatan 						= $pkwt[0]->penempatan;
					$waktukontrak 					= $pkwt[0]->waktu_kontrak;
					$tglmulaipkwt 					= $pkwt[0]->from_date;
					$tglakhirpkwt 					= $pkwt[0]->to_date;
					$waktukerja 						= $pkwt[0]->hari_kerja;

					$project = $this->Xin_model->read_user_xin_project($pkwt[0]->project);
					if(!is_null($project)){
						$client = $project[0]->title;
					} else {
						$client = $project[0]->title;
					}

					$basicpay =	$this->Xin_model->rupiah($pkwt[0]->basic_pay);
					$allowance_grade =	$this->Xin_model->rupiah($pkwt[0]->allowance_grade);
					$allowance_area =	$this->Xin_model->rupiah($pkwt[0]->allowance_area);
					$allowance_masakerja =	$this->Xin_model->rupiah($pkwt[0]->allowance_masakerja);
					$allowance_meal =	$this->Xin_model->rupiah($pkwt[0]->allowance_meal);
					$allowance_transport =	$this->Xin_model->rupiah($pkwt[0]->allowance_transport);
					$allowance_rent =	$this->Xin_model->rupiah($pkwt[0]->allowance_rent);
					$allowance_komunikasi =	$this->Xin_model->rupiah($pkwt[0]->allowance_komunikasi);
					$allowance_park =	$this->Xin_model->rupiah($pkwt[0]->allowance_park);
					$allowance_residance =	$this->Xin_model->rupiah($pkwt[0]->allowance_residance);

					$allowance_laptop =	$this->Xin_model->rupiah($pkwt[0]->allowance_laptop);
					$allowance_kasir =	$this->Xin_model->rupiah($pkwt[0]->allowance_kasir);
					$allowance_transmeal =	$this->Xin_model->rupiah($pkwt[0]->allowance_transmeal);
					$allowance_medicine =	$this->Xin_model->rupiah($pkwt[0]->allowance_medicine);
					$allowance_akomodasi =	$this->Xin_model->rupiah($pkwt[0]->allowance_akomodasi);
					$allowance_operation =	$this->Xin_model->rupiah($pkwt[0]->allowance_operation);


					$tgl_mulaiperiode_payment = $pkwt[0]->start_period_payment;
					$tgl_akhirperiode_payment = $pkwt[0]->end_period_payment;
					$tgl_payment = $pkwt[0]->tgl_payment;

				} else {

				}


				$tbl_2 = '
				
					<div style="text-align: center; text-justify: inter-word;">
						<b><u>PERJANJIAN KERJA WAKTU TERTENTU<br>'.$nomorsurat.'</u><br>(PKWT)</b>
					</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Pada hari ini di '.$this->Xin_model->tgl_indo($tanggalcetak).' ditandatangani Perjanjian Kerja Waktu Tertentu (selanjutnya disebut "<b>PKWT</b>") oleh dan diantara:</td>
							</tr>
				</table>

				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
					<tr>
						<td>Nama</td>
						<td colspan="3">: '.$sign_fullname.'</td>
					</tr>

					<tr>
						<td>Jabatan</td>
						<td colspan="3">: '.$sign_jabatan.'</td>
					</tr>

					<tr>
						<td>Alamat Kantor</td>
						<td colspan="3">: Gedung Graha Krista Aulia Cakrawala Lt.2 Jl. Andara No. 20 Pangkalan Jati Baru Cinere Depok 16514</td>
					</tr>
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Dalam hal ini bertindak untuk dan atas nama serta sah mewakili perseroan terbatas <b>PT. Krista Aulia Cakrawala</b>, suatu Perseroan Terbatas yang bergerak dibidang Penyediaan Jasa Tenaga Kerja dan Konsultan didirikan menurut hukum Indonesa, selanjutnya disebut sebagai <b>PIHAK PERTAMA ----------------------------------------------</b></td>
							</tr>			
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0">
					<tr>
						<td>Nama</td>
						<td colspan="3"> : '.$namalengkap.'</td>
					</tr>

					<tr>
						<td>Tanggal Lahir</td>
						<td colspan="3"> : '.$tempattgllahir.'</td>
					</tr>

					<tr>
						<td>Jabatan</td>
						<td colspan="3"> : '.$jabatan.'</td>
					</tr>
					<tr>
						<td>Alamat Rumah</td>
						<td colspan="3"> : '.$alamatlengkap.'</td>
					</tr>

					<tr>
						<td>No. Hp</td>
						<td colspan="3"> : '.$nomorkontak.'</td>
					</tr>

					<tr>
						<td>No. NIK/KTP</td>
						<td colspan="3"> : '.$ktp.'</td>
					</tr>
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Dalam hal ini bertindak untuk dan atas nama dirinya sendiri, selanjutnya dalam perjanjian ini disebut sebagai <b>PIHAK KEDUA --------------------------------------------------------------------------------</b></td>
							</tr>			
				</table>
				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Untuk selanjutnya <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> di dalam Kesepakatan Kerja ini disebut sebagai <b>Para Pihak</b></td>
							</tr>			
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td><b>Para Pihak</b> terlebih dahulu menjelaskan hal-hal sebagai berikut:</td>
							</tr>			
				</table>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>a.</td>
								<td colspan="20">Bahwa <b>PIHAK PERTAMA</b> adalah suatu Perseroan terbatas yang bergerak dibidang penyedia jasa sumber daya manusia dan konsultan.</td>
							</tr>

							<tr>
								<td>b.</td>
								<td colspan="20">Bahwa <b>PIHAK KEDUA</b> adalah perseorangan yang melamar untuk berkerja di perusahaan <b>PIHAK PERTAMA</b>.</td>
							</tr>
				</table>
				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Berdasarkan hal-hal tersebut di atas , maka <b>Para Pihak</b> setuju dan sepakat untuk mengadakan PKWT dengan syarat dan ketentuan sebagai berikut:</td>
							</tr>			
				</table>
				<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 1<br>JENIS PEKERJAAN DAN LOKASI PENEMPATAN</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>1.1</td>
								<td colspan="18"><b>PIHAK PERTAMA</b> akan menempatkan <b>PIHAK KEDUA</b> dilokasi kerja <b>PIHAK PERTAMA</b> yaitu di '.$penempatan.' dengan posisi sebagai karyawan/Staff '.$jabatan.' di Jakarta atau ditempatkan di tempat lain sesuai dengan kebutuhan <b>PIHAK PERTAMA</b>.</td>
							</tr>
				<br>
							<tr>
								<td>1.2</td>
								<td colspan="18">Tugas dan tanggung jawab yang ditetapkan tersebut diatas akan dievaluasi setiap bulannya dan per <b>3 Bulan</b>, dimana hasil yang dicapai dapat mempengaruhi dan / atau dapat dijadikan dasar untuk memperpanjang pada <b>PKWT</b> selanjutnya.</td>
							</tr>
				<br>
							<tr>
								<td>1.3</td>
								<td colspan="18"><b>PIHAK PERTAMA</b> berdasarkan pertimbangan tertentu berhak memindah ke bagian lain serta merubah nama Jabatan <b>PIHAK KEDUA</b> dan karenanya <b>PIHAK KEDUA</b> wajib bersedia untuk dipindah ke bagian lain dan atau dirubah nama jabatannya sesuai dengan kebutuhan. Dalam hal ini <b>PIHAK PERTAMA</b> akan memberitahukan hal tersebut secara tertulis kepada <b>PIHAK KEDUA</b>.</td>
							</tr>
				</table>
				<br>
<br><br><br><br><br><br><br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 2<br>JANGKA WAKTU PERJANJIAN</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>2.1</td>
								<td colspan="18">PKWT ini berlangsung/berlaku selama <b>'.$waktukontrak.'</b> Bulan terhitung sejak <b>
													'.$this->Xin_model->tgl_indo($tglmulaipkwt).'</b> sampai dengan <b>
																		'.$this->Xin_model->tgl_indo($tglakhirpkwt).'</b> Selama <b>PIHAK KEDUA</b> menjadi Karyawan Kontrak maka akan ada masa Evaluasi kinerja setiap bulan dan atau per <b>3 Bulan</b>.</td>
							</tr>
				<br>
							<tr>
								<td>2.2</td>
								<td colspan="18">Jika <b>PIHAK KEDUA</b> setelah masa Evaluasi Kinerja 3 Bulan dan atau 6 Bulan dan oleh <b>PIHAK PERTAMA</b> atau Pihak User/Klien diperpanjang maka <b>PIHAK KEDUA</b> tetap melanjutkan PKWT yang sudah berlangsung/berlaku sampai PKWT berakhir.</td>
							</tr>
				<br>
							<tr>
								<td>2.3</td>
								<td colspan="18"><b>PIHAK PERTAMA</b> berhak memutuskan/memberhentikan PKWT <b>PIHAK KEDUA</b> apabila jika pada saat masa Evaluasi Kinerja tidak sesuai dengan komitmen dan kinerja, walaupun PKWT masih berlaku/berjalan.</td>
							</tr>
				</table>
				<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 3<br>GAJI DAN FASILITAS LAINNYA</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td >3.1</td>
								<td colspan="5"><b>PIHAK KEDUA</b> berhak atas:</td>
								<td colspan="13"></td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="15">Note : Detail rincian upah terlampir pada Lampiran 1</td>
								<td colspan="5"></td>
							</tr>


							<br>
							<tr>
								<td ></td>
								<td colspan="20">Jaminan kesehatan (BPJS Kesehatan) dan ketenagakerjaan (BPJS Tenaga kerja), penetapan syarat berserta ketentuan yang berlaku mengenai jaminan perawatan kesehatan ini sepenuhnya menjadi hak <b>PIHAK PERTAMA</b>.</td>
								<td colspan="0"></td>
							</tr>
							<br>
							<tr>
								<td></td>
								<td colspan="20">Note : -Bpjs Kesehatan & Ketenagakerjaan akan didaftarkan setelah karyawan memiliki minimal 10 Hari Kerja, dan akan didaftarkan di bulan berikutnya(Proses Mendaftar). Efektif terdaftar (Muncul Nomor) maksimal di tanggal 10 1 bulan setelah bulan proses pendaftaran, Apabila terjadi sesuatu hal dalam jam operasional pekerjaan baik dalam kesehatan maupun keselamatan dilingkungan kerja akan menjadi beban mandiri yaitu Karyawan Tersebut.</td>
								<td colspan="0"></td>
							</tr>

							
							<br>
							<tr>
								<td >3.2</td>
								<td colspan="20">Gaji yang di terima <b>PIHAK KEDUA</b> setiap bulan belum termasuk potongan dengan fasilitas :</td>
								<td colspan="0"></td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Iuran Jaminan Hari Tua <b>( JHT )</b> sesuai ketentuan <b>BPJS KetenagaKerjaan</b> dari hasil pendapatan perbulan</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Pajak penghasilan <b>PPH21</b>.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Iuran <b>BPJS Kesehatan</b>.</td>
							</tr>

				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">

					<tr>
						<td>3.3</td>
						<td colspan="18">Pembayaran gaji dilakukan setiap akhir bulan sesuai kalender setiap bulannya dengan cara transfer Bank BCA/Mandiri <b>PIHAK KEDUA</b>, jika akhir bulan jatuh pada hari libur, maka pembayaran akan dilakukan 1 (satu) hari lebih awal. <b>PIHAK PERTAMA</b> hanya akan melakukan pembayaran hanya melalui rekening Bank BCA/Mandiri milik <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> wajib menyerahkan nomer rekening Bank BCA/Mandiri atas nama <b>PIHAK KEDUA</b>, Kesalahan maupun keterlambatan pembayaran gaji akibat kelalaian maupun keterlambatan <b>PIHAK KEDUA</b> dalam menyerahkan nomer rekening nya atau diakibatkan kesalahan di Bank BCA/Mandiri bukan merupakan tanggung jawab dari <b>PIHAK PERTAMA</b></td>
					</tr>
				<br>
					<tr>
						<td>3.4</td>
						<td colspan="18"><b>PIHAK KEDUA</b> berhak memperoleh Tunjangan Hari Raya (THR) yang besarnya diperhitungkan secara pro-rata/proposional dan berdasarkan lamanya waktu kerja dikali 1 (satu) bulan gaji (bagi karyawan kontrak kebijakan mengenai THR disesuaikan dengan kesepakatan antara <b>PIHAK PERTAMA</b> dan Pihak User/Klien)</td>
					</tr>
				<br>
					<tr>
						<td>3.5</td>
						<td colspan="18">Tunjangan Hari Raya (THR) diberikan kepada karyawan yang telah menjalani masa kerja sekurang-kurangnya 1 (satu) bulan (ketentuan dan kebijakan bagi Karyawan Kontrak akan disesuaikan dengan peraturan dan atau kesepakatan dengan pihak User/Klien).</td>
					</tr>
				<br>
					<tr>
						<td>3.6</td>
						<td colspan="18">Apabila masa kerja telah melampaui 1 (satu) bulan tetapi belum genap 12 (dua belas) bulan, maka Tunjangan Hari Raya (THR) akan dihitung secara proporsional.</td>
					</tr>
				<br>
					<tr>
						<td>3.7</td>
						<td colspan="18"><b>PIHAK KEDUA</b> berhak mendapatkan cuti tahunan selama 12 hari dalam 1 (satu) tahun, jika masa kerja sudah melampui 1 Tahun (12 Bulan) yang diatur dan kebijakan oleh <b>PIHAK PERTAMA</b> berdasarkan kebutuhan dan kesepakatan dengan pihak User/Klien (berlaku bagi karyawan kontrak).</td>
					</tr>
				<br>

				</table>
				<br>
				<br>
				<br>
				<br>
				<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 4<br>TATA TERTIB WAKTU KERJA</b>
				</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>4.1</td>
								<td colspan="18">Hari kerja normal adalah 6 hari kerja dalam 7 (tujuh) hari kalender sesuai dengan ketentuan <b>PIHAK PERTAMA</b>.</td>
							</tr>
				<br>
							<tr>
								<td>4.2</td>
								<td colspan="18">Ketentuan waktu kerja ditentukan oleh <b>PIHAK PERTAMA</b> sesuai dengan peraturan undang – undang ketenagakerjaan dan dapat berubah sewaktu – waktu sesuai dengan kebutuhan <b>PIHAK PERTAMA</b>. Setiap perubahan waktu kerja akan diinformasikan kepada <b>PIHAK KEDUA</b> dan bersifat  mengikat.</td>
							</tr>
				<br>
							<tr>
								<td>4.3</td>
								<td colspan="18"><b>PIHAK KEDUA</b> berkewajiban untuk mematuhi waktu kerja dan kehadiran/jadwal kerja sebagai mana dimaksud dalam pasal ini dan wajib mematuhi jadwal/jam kerja yang dikeluarkan oleh <b>PIHAK PERTAMA</b>. Dan atau akan diberikan sanksi jika tidak mematuhi jadwal/jam kerja tersebut.</td>
							</tr>
				<br>
							<tr>
								<td>4.4</td>
								<td colspan="18">Jadwal/Jam kerja yang dimaksud poin 4.3 adalah disesuaikan dengan jadwal dan jam kerja yang ditentukan dari klien.</td>
							</tr>
				

				</table>

				<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 5<br>ETIKA PRILAKU</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td><b>PIHAK KEDUA</b> wajib untuk menjaga prilaku selama berada ditempat kerja <b>PIHAK PERTAMA</b> dengan :

				</td>
							</tr>			
				</table>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>5.1</td>
								<td colspan="18">Melaksanakan tugas serta pekerjaan dengan penuh rasa tanggung jawab sesuai dengan kewajiban, tanggung jawab dan batas – batas kewenangannya.</td>
							</tr>
				<br>
							<tr>
								<td>5.2</td>
								<td colspan="18">Bertindak jujur, komitmen dan dapat dipercaya dalam melaksanakan pekerjaannya.</td>
							</tr>
				<br>
							<tr>
								<td>5.3</td>
								<td colspan="18">Memelihara etika kerja termasuk ketepatan waktu datang kerja dan persiapan yang memadai sebelum mulai kerja.</td>
							</tr>
				<br>
							<tr>
								<td>5.4</td>
								<td colspan="18">Menggunakan pakaian bekerja yang telah di tentukan oleh <b>PIHAK PERTAMA</b> maupun perusahaan dimana <b>PIHAK KEDUA</b> ditempatkan.</td>
							</tr>
				<br>
							<tr>
								<td>5.5</td>
								<td colspan="18">Mematuhi hukum yang berlaku dan kebijakan-kebijakan perusahaan <b>PIHAK PERTAMA</b> maupun perusahaan dimana <b>PIHAK KEDUA</b> ditempatkan.</td>
							</tr>
				<br>
							<tr>
								<td>5.6</td>
								<td colspan="18">Dalam melaksanakan pekerjaannya, <b>PIHAK KEDUA</b> wajib memahami dan mematui pedoman/kebijakan yang telah ditentukan diperusahaan <b>PIHAK PERTAMA</b> maupun perusahaan dimana <b>PIHAK KEDUA</b> ditempatkan.</td>
							</tr>
				<br>
							<tr>
								<td>5.7</td>
								<td colspan="18">Mengelola asset dan barang milik perusahaan <b>PIHAK PERTAMA</b> maupun perusahaan dimana <b>PIHAK KEDUA</b> ditempatkan dengan penuh tanggung jawab.</td>
							</tr>
				<br>
							<tr>
								<td>5.8</td>
								<td colspan="18">Bersedia melaksanakan tanggung jawab sebagai seorang Karyawan/Staff sesuai yang tertulis pada Instruksi Kerja dan SOP yang berlaku di perusahaan.</td>
							</tr>
				</table>
						<br>


				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 6<br>KERAHASIAAN</b>
				</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Karyawan, selama bekerja dan setelah bekerja pada Perusahaan, diminta untuk menjaga kerahasiaan dan tidak membuka rahasia perdagangan <b>PIHAK PERTAMA</b>, dokumentasi atau informasi rahasia, data dan petunjuk teknis, gambar, sistem, metode, perangkat lunak proses, daftar klien, program, pemasaran, dan informasi keuangan kepada orang lain selain dari Karyawan yang dipekerjakan atau diserahi wewenang oleh <b>PIHAK PERTAMA</b> untuk mengetahui rahasia-rahasia tersebut demi kepentingan pekerjaan mereka atau berkaitan dengan <b>PIHAK PERTAMA</b>.</td>
							</tr>			
				</table>
				<br>


				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 7<br>BERAKHIRNYA PKWT</b>
				</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td><b>PIHAK PERTAMA</b> berhak mengakhiri <b>PKWT</b> (secara otomatis) sebelum jangka waktu berakhir, bilamana :</td>
							</tr>			
				</table>


				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">

							<tr>
								<td>a.</td>
								<td colspan="20"><b>PIHAK PERTAMA</b> dan Klient memutuskan hubungan kerja sepihak dengan alasan apaun tanpa mengeluarkan surat peringatan 1,2 dan 3. Dan <b>PIHAK KEDUA</b> tidak berhak menuntut apapun dan salary dari sisa kontrak, pesangon dan tali kasih dalam bentuk apapun.</td>
							</tr>

				<br>
							<tr>
								<td>b.</td>
								<td colspan="20">Hubungan kerjasama antara <b>PIHAK PERTAMA</b> dengan pihak pengguna jasa (perusahaan) dimana <b>PIHAK KEDUA</b> ditempatkan di perusahaan tersebut telah berakhir atau diakhiri dengan cara apapun. Dalam hal ini mengacu pada point a.</td>
							</tr>

				<br>
							<tr>
								<td>c.</td>
								<td colspan="20"><b>PIHAK KEDUA</b> tidak dapat memperhitungkan masa kerja sebelumnya jika Pihak Kedua dipindahkan ke lokasi penempatan baru (Rotasi/Mutasi). Dalam hal ini mengacu pada point a.</td>
							</tr>
				<br>
							<tr>
								<td>d.</td>
								<td colspan="20"><b>PIHAK PERTAMA</b> menutup usahanya dengan cara apapun. Dalam hal ini mengacu pada point a.</td>
							</tr>
				<br>

							<tr>
								<td>e.</td>
								<td colspan="20"><b>PIHAK KEDUA</b> meninggal dunia.</td>
							</tr>
				<br>
							<tr>
								<td>f.</td>
								<td colspan="18"><b>PIHAK KEDUA</b> dianggap gagal memenuhi persyaratan prestasi tertentu atas pekerjaan yang diminta oleh <b>PIHAK PERTAMA</b> tanpa adanya surat peringatan 1, 2 atau 3 dan <b>PIHAK KEDUA</b> tidak berhak menuntut salary sisa kontrak, pesangon dan tali kasih dalam bentuk apapun.</td>
							</tr>
				<br>
							<tr>
								<td>g.</td>
								<td colspan="18"><b>PIHAK KEDUA</b> dianggap gagal didalam masa evaluasi kinerja oleh <b>PIHAK PERTAMA</b> dan Pihak User/Client. Dalam hal ini mengacu pada point a.</td>
							</tr>
				<br>
							<tr>
								<td>h.</td>
								<td colspan="18"><b>PIHAK KEDUA</b> diberhentikan sepihak oleh <b>PIHAK PERTAMA</b> karena pengurangan karyawan atas persetujuan dan atau permintaan pihak pemberi jasa (User/Client). Dalam hal ini mengacu pada point a.</td>
							</tr>
				<br>
							<tr>
								<td>i.</td>
								<td colspan="18"><b>PIHAK KEDUA</b> melanggar larangan sebagian atau keseluruhan sebagaimana tercantum dalam PKWT ini, seperti halnya dan tidak terbatas pada pelanggaran tata tertib kerja, mengabaikan ketentuan tentang integritas  dan keamanan informasi yang berlaku diperusahaan <b>PIHAK PERTAMA</b>, seperti halnya:</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Melakukan mangkir kerja selama 3 hari berturut-turut tanpa pemberitahuan/keterangan dan telah dipanggil oleh perusahaan dan karyawan tidak dapat memberikan surat keterangan yang sah atau dapat diterima.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Mencuri, menggelapkan, melakukan penipuan, dan manipulasi baik itu berupa data, barang, uang dan harta benda lainnya.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Memberi keterangan palsu atau dipalsukan.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Memakai obat – obatan terlarang, minum minuman keras</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Melakukan perbuatan asusila, amoral, kegiatan perjudian ditempat kerja</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Melakukan hal-hal yang bersifat kriminal yang merugikan asset perusahaan secara material maupun non material bagi <b>PIHAK PERTAMA</b> maupun bagi perusahaan dimana <b>PIHAK KEDUA</b> ditempatkan</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">-</td>
								<td colspan="20">Menganiaya, menghina secara kasar mengucap secara fisik dan mental kepada <b>PIHAK PERTAMA</b>, atau membiarkan teman kerjanya berada dalam bahaya</td>
							</tr>

				<br>
							<tr>
								<td>j.</td>
								<td colspan="18">diketahui memiliki catatan kriminal atau pernah melakukan kejahatan.</td>
							</tr>
				<br>
							<tr>
								<td>k.</td>
								<td colspan="18">Pekerja yang melakukan mangkir sebagaimana dimaksud dalam undang-undang KetenagaKerjaan dapat diputuskan hubungan kerjanya karena dikualifikasikan mengundurkan diri.</td>
							</tr>
				<br>
							<tr>
								<td>l.</td>
								<td colspan="18">Bila mana <b>PIHAK KEDUA</b> bermaksud mengundurkan diri sebelum berakhirnya jangka waktu PKWT ini, maka <b>PIHAK KEDUA</b> wajib :</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">a)</td>
								<td colspan="20">Mengajukan surat pengunduran diri selambat – lambatnya 30 hari (one month notice) dan atau minimal 14 hari kerja sebelum tanggal pengunduruan diri tersebut berlaku efektif kepada <b>PIHAK PERTAMA</b> dan salinanya kepada atasan langsung dari <b>PIHAK KEDUA</b>.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">b)</td>
								<td colspan="20">Menyelesaikan pekerjaanya sampai dengan tanggal pengunduran diri dengan dengan sebaik-baiknya serta melakukan serah terima pekerjaan kepada penggantinya atau pihak lain yang ditunjuk oleh <b>PIHAK KEDUA</b> atau dengan klient yang dibuktikan dengan Berita Acara Serah Terima Pekerjaan (BASTP).</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="18">Dalam hal pengunduran diri tidak diajukan dengan tata cara sebagaimana dimaksud dalam Huruf a ayat ini, maka <b>PIHAK PERTAMA</b> berhak untuk tidak membayarkan upah terakhir <b>PIHAK KEDUA</b> dan tidak memberikan surat referensi kerja kepada <b>PIHAK KEDUA</b>.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="18">Dalam hal pengunduran diri tidak diajukan dengan tata cara sebagaimana dimaksud dalam Huruf b ayat ini, maka <b>PIHAK PERTAMA</b> berhak untuk menahan upah terakhir dan surat keterangan kerja <b>PIHAK KEDUA</b> apabila belum menyelesaikan BASTP.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="18">Dalam hal pengunduran diri tidak dilakukan dengan tata cara yang baik dan benar, maka <b>PIHAK PERTAMA</b> berhak memberikan sanksi kepada <b>PIHAK KEDUA</b> bilamana <b>Pihak kedua</b> mengundurkan diri sebelum masa kontrak berakhir.</td>
							</tr>
				<br>
							<tr>
								<td>m.</td>
								<td colspan="18">Bilamana PIHAK KEDUA memanipulasi absen maupun bon , Maka akan diberhentikan saat itu juga oleh PIHAK PERTAMA</td>
							</tr>

				<br>
							<tr>
								<td>n.</td>
								<td colspan="18">Bagi karyawan yang dinyatakan hamil maka karyawan harus mengundurkan diri selambat-lambatnya 3 bulan masa kehamilan dan selama proses kehamilan terjadi akibat dan resiko menjadi tanggung jawab karyawan dan bukan menjadi tanggung jawab PT. Krista Aulia Cakrawala.</td>
							</tr>

				</table>

<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 8<br>HUKUM YANG BERLAKU</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>A.</td>
								<td colspan="20">Dalam hal terjadi perselisihan yang tidak dapat didamaikan dan diselesaikan secara musyawarah mufakat, maka para pihak sepakat memilih domisili hukum penyelesaian pada Kantor Suku Dinas Tenaga Kerja dan pengadilan hubungan industrial.</td>
							</tr>
				<br>
							<tr>
								<td>B.</td>
								<td colspan="20">Apabila selama jangka waktu <b>PKWT</b> ini terjadi perubahan undang-undang yang mengaturnya, maka <b>PKWT</b> ini tetap akan berlaku sepanjang tidak bertentangan dengan undang-undang/peraturan baru tersebut serta akan disesuaikan dengan undang – undang/peraturan baru tersebut.</td>
							</tr>
				<br>
							<tr>
								<td>C.</td>
								<td colspan="20">Dalam hal selama jangka waktu <b>PKWT</b> ini ternyata dilarang oleh suatu undang-undang/peraturan baru, maka <b>PKWT</b> ini akan secara otomatis berakhir. Dalam hal ini, <b>PIHAK PERTAMA</b> maupun klient <b>PIHAK PERTAMA</b> tidak berkewajiban membayar kompensasi apapun kepada <b>PIHAK KEDUA</b> kecuali atas gaji sampai dengan hari kerjanya yang berakhir.</td>
							</tr>
				</table>
				<br>

				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 9<br>ATURAN PEMELIHARAAN</b>
				</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Dalam hal perusahaan <b>PIHAK PERTAMA</b> maupun klien <b>PIHAK PERTAMA</b> mengubah nama atau menggabungkan diri dengan perusahaan lain selama masa <b>PKWT</b> ini berlaku, maka ketentuan – ketentuan dari <b>PKWT</b> ini akan tetap berlaku bagi <b>PIHAK KEDUA</b> selama berlakunya <b>PKWT</b> ini.</td>
							</tr>			
				</table>
				<br>


				<div style="text-align: center; text-justify: inter-word;">
					<b>PASAL 10<br>KETENTUAN LAIN - LAIN</b>
				</div>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>1.</td>
								<td colspan="20"><b>PIHAK KEDUA</b> berkewajiban mengganti kerusakan material atau kerugian finansial yang diderita Perusahaan <b>PIHAK PERTAMA</b> maupun Klien <b>PIHAK PERTAMA</b> sebagai akibat kegiatan atau kecerobohan yang dilakukan <b>PIHAK KEDUA</b>. <b>PIHAK PERTAMA</b> berhak memperhitungkan dengan memotong upah bulanan <b>PIHAK KEDUA</b> hingga pergantian tersebut lunas.</td>
							</tr>
				<br>
							<tr>
								<td>2.</td>
								<td colspan="20"><b>PIHAK PERTAMA</b> berhak tidak memberikan upah/gaji kepada <b>PIHAK KEDUA</b> jika didalam masa kerja kurang dari 2 minggu (14 hari kerja) dan atau pihak kedua mengundurkan diri sepihak tanpa pemberitahuan dahulu sebelumnya (sebagaimana tertera pada Pasal 7).</td>
							</tr>
				<br>
							<tr>
								<td>3.</td>
								<td colspan="20"><b>PIHAK KEDUA</b> sebagai karyawan kontrak tidak dapat / tidak berhak mendapatkan pesangon/upah selama masa kerja jika masa kontrak berakhir maupun pengurangan karyawan yang diputuskan oleh <b>PIHAK PERTAMA</b> dan pihak User/Klien.</td>
							</tr>
				<br>
							<tr>
								<td>4.</td>
								<td colspan="20"><b>PKWT</b> ini hanya dapat dirubah atau direvisi berdasarkan kesepakatan dan persetujuan tertulis salah satu pihak.</td>
							</tr>
				<br>
							<tr>
								<td>5.</td>
								<td colspan="20"><b>PIHAK KEDUA</b> dengan ini membebaskan <b>PIHAK PERTAMA</b> dan menyatakan bertanggung jawab atas timbulnya tuntutan, gugatan maupun permintaan ganti rugi dari <b>PIHAK PERTAMA</b> akibat kerugian finansial maupun non finansial dan langsung maupun tidak langsung yang diderita oleh <b>PIHAK PERTAMA</b> yang disebabkan oleh <b>PIHAK KEDUA</b> baik secara langsung maupun tidak langsung.</td>
							</tr>
				<br>
							<tr>
								<td>6.</td>
								<td colspan="20">Hal – hal yang belum atau tidak cukup diatur dalam <b>PKWT</b> ini akan di atur dan dituangkan dalam bentuk perjanjian tambahan (addendum) yang merupakan satu kesatuan yang tidak dapat dipisahkan dari <b>PKWT</b> ini serta tunduk kepada peraturan perusahaan <b>PT. Krista Aulia Cakrawala</b> dan peraturan perundangan yang berlaku dan sepanjang tidak bertentangan.</td>
							</tr>
				<br>
				<br>
				<br>
				<br>
				
							<tr>
								<td>7.</td>
								<td colspan="20">Selama dalam hubungan kerja <b>PIHAK KEDUA</b> wajib mentaati dan melaksanakan ketentuan mengenai tata tertib, kedisiplinan dan kewajiban – kewajiban yang dibebankan kepada <b>PIHAK KEDUA</b>, sesuai dengan  ketentuan dalam peraturan perusahaan.</td>
							</tr>
				</table>
				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Demikian <b>PKWT</b> ini dibuat dalam 2 (dua) rangkap yang masing – masing mempunyai ketentuan hukum yang sama, serta Perjanjian Kerja ini berlaku dan mengikat sejak ditanda tangani oleh kedua belah pihak.</td>
							</tr>			
				</table>
				<br>
				<br>
				<br>';
				$pdf->writeHTML($tbl_2, true, false, false, false, '');

				if($pkwt_active == 1){
					$tbl_ttd = '
						<table cellpadding="2" cellspacing="0" border="0">

						<tr>
							<td>Pihak Pertama</td>
							<td>Pihak Kedua</td>
						</tr>

						<tr>
							<td><br>
							<img src="'.base_url().'assets/images/pkwt/'.$sign_qrcode.'" alt="Trulli" width="90" height="90"><br><b><u>'.$sign_fullname.'</u></b></td>
							<td><br><br><br><br><br><br><br><b><br><u>'.$namalengkap.' </u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>

						<tr>
							<td>SM HR/GA</td>
							<td>Karyawan</td>
						</tr>

						</table>';
				} else {
					$tbl_ttd = '
						<table cellpadding="2" cellspacing="0" border="0">

						<tr>
							<td>Pihak Pertama</td>
							<td>Pihak Kedua</td>
						</tr>

						<tr>
							<td><br>
							<img src="'.base_url().'assets/under_review.png" alt="Trulli" width="120" height="90"><br><b><u>'.$sign_fullname.'</u></b></td>
							<td><br><br><br><br><br><br><br><b><br><u>'.$namalengkap.' </u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>

						<tr>
							<td>SM HR/GA</td>
							<td>Karyawan</td>
						</tr>

						</table>';
				}

				
				$pdf->writeHTML($tbl_ttd, true, false, false, false, '');



				$tbl_spb = '

				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br>
				<br>			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				
				<div style="text-align: center; text-justify: inter-word;">
					<b><u>SURAT PERJANJIAN BERSAMA<br>'.$nomorspb.'</u></b>
				</div>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
					<tr>
						<td>Yang bertanda tangan di bawah ini :</td>
					</tr>			
				</table>
				<br>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
					<tr>
						<td>Demikian Surat Perjanjian Bersama ini ditandatangani dalam keadaan jasmani/rohani yang sehat, dan tanpa paksaan dari pihak manapun.</td>
					</tr>			
				</table>

				<br><br>


				<table cellpadding="2" cellspacing="0" border="0">

					<tr>
						<td>Nama</td>
						<td colspan="7">: '.$namalengkap.'</td>
					</tr>

					<tr>
						<td>Jabatan</td>
						<td colspan="7">: '.$jabatan.'</td>
					</tr>

					<tr>
						<td>Alamat</td>
						<td colspan="7">: '.$alamatlengkap.'</td>
					</tr>

					<tr>
						<td>No NIK/KTP</td>
						<td colspan="7">: '.$ktp.'</td>
					</tr>

				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
					<tr>
						<td>Selanjutnya dengan ini saya menyatakan, bahwa saya menerima, dan menyetujui serta melaksanakan ketentuan-ketentuan/tata tertib kerja PT. KRISTA AULIA CAKRAWALA (selanjutnya disebut “Perusahaan”) yang mengacu kepada Peraturan Perusahaan PT. KRISTA AULIA CAKRAWALA.</td>
					</tr>			
				</table>
				<br>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>1.</td>
								<td colspan="20">Bahwa saya akan melaksanakan kewajiban, tugas dan tanggung jawab dengan baik yang diberikan oleh Pimpinan Perusahaan atau atasan langsung maupun atasan dari atasan langsung saya, serta mengikuti/mentaati ketentuan jam kerja yang berlaku di Perusahaan.</td>
							</tr>

							<tr>
								<td>2.</td>
								<td colspan="20">Tidak datang terlambat tanpa alasan yang dapat diterima oleh Perusahaan, tidak meninggalkan tempat kerja tanpa sepengetahuan atasan, tidak mangkir dan sebagainya yang dapat merugikan Perusahaan.</td>
							</tr>

							<tr>
								<td>3.</td>
								<td colspan="20">Bahwa saya akan menjaga peralatan pekerjaan milik Perusahaan yang dipergunakan / dipercayakan kepada saya, sesuai tugas-tugas pekerjaan Perusahaan yang diberikan oleh atasan saya, ataupun oleh Pimpinan Perusahaan.</td>
							</tr>

							<tr>
								<td>4.</td>
								<td colspan="20">Bahwa apabila sampai terjadi pelanggaran-pelanggaran terhadap ketentuan-ketentuan/tata tertib kerja yang berlaku, dan apabila sampai terjadi hal-hal yang merugikan Perusahaan disebabkan kelalaian, kesengajaan atau kecerobohan kerja saya, maka saya bersedia diberikan Surat Peringatan, dan bersedia menerima Pemutusan Hubungan Kerja sepihak sesuai dengan ketentuan yang berlaku di Perusahaan dan Peraturan Ketenagakerjaan.</td>
							</tr>

							<tr>
								<td>5.</td>
								<td colspan="20">Dalam hal pengunduran diri, saya bersedia diberikan pinalty/sanksi administratif apabila saya mengundurkan diri tidak sesuai dengan ketentuan minimal mengajukan surat pengunduran diri 1 bulan sebelumnya. (sanksi administratif adalah sisa masa kontrak kerja saya dikali jumlah gaji yang diterima).</td>
							</tr>

							<tr>
								<td>6.</td>
								<td colspan="20">Untuk Pendaftaran kepesertaan BPJS Kesehatan dan BPJS Ketenagakerjaan karyawan, Proses pendaftaran dari kami PT. Siprama Cakrawala akan dilakukan pendaftaran setelah pemotongan Gaji pertama karyawan.</td>
							</tr>

				</table>



				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td >7.</td>
								<td colspan="20">Bahwa saya bersedia menjadi <b>Karyawan Kontrak</b> selama jangka waktu <b>'.$waktukontrak.'</b> bulan dengan ketentuan sebagai berikut :</td>
								<td colspan="0"></td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">a.</td>
								<td colspan="20">Selama menjadi Karyawan Kontrak, saya tidak mendapat fasilitas seperti Karyawan Tetap.</td>
							</tr>

							<tr>
								<td ></td>
								<td colspan="0">b.</td>
								<td colspan="20">Selama saya menjadi Karyawan Kontrak maka akan ada Evaluasi kinerja setiap bulan dan atau <b>per 3 Bulan</b>. </td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">c.</td>
								<td colspan="20">Apabila saya karyawan yang bertugas membawa barang ataupun uang maka saya bertanggung jawab penuh terhadap product / barang maupun uang yang menjadi tanggung jawab saya sebagai sales / motorist , apabila dikemudian hari terdapat kerusakan ataupun kehilangan barang/product akan menjadi tanggung jawab pribadi. Apabila kehilangan uang yang sengaja dilakukan oleh karyawan tersebut (lalai) akan menjadi tanggung jawab pribadi kecuali karyawan mengalami kejadian perampokan.</td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">d.</td>
								<td colspan="20">Apabila saya karyawan yang bertugas membawa kendaraan (mobil/motor) operasional/milik perusahaan lalu mengalami kerusakan maka beban kerusakan tidak ditanggung oleh perusahaan/client melainkan saya sendiri selaku driver kendaraan tersebut 100%.</td>
							</tr>

							<tr>
								<td >8.</td>
								<td colspan="20">Surat keterangan kerja tidak dapat dikeluarkan apabila karyawan bekerja dibawah 3 bulan dengan pengecualian:</td>
								<td colspan="0"></td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">a.</td>
								<td colspan="20">Klien (Penyedia kerja) melakukan pengurangan pegawai</td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">b.</td>
								<td colspan="20">Jika masa kontrak Cakrawala dengan Klien sudah habis, namun kontrak karyawan masih berjalan. Karyawan berhak mendapat surat keterangan kerja dengan catatan memiliki review baik selama bekerja.</td>
							</tr>
							<tr>
								<td >9.</td>
								<td colspan="20">Jika karyawan melanggar & menerima SP 1, SP 2 dan berakibat pada SPHK. Maka karyawan tidak berhak menuntut/mendapat hak kompensasi. Serta perusahaan berhak memutuskan kontrak kerja dengan karyawan tersebut.</td>
								<td colspan="0"></td>
							</tr>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>	
							<br>	
							<tr>
								<td >10.</td>
								<td colspan="20">Jika karyawan melakukan tindakan merugikan perusahaan secara disengaja maupun tidak disengaja maka karyawan tersebut tidak berhak mendapat/menuntut kompensasi terhadap perusahaan, serta perusahaan berhak memutus kontrak dengan karyawan tersebut. Adapun perbuatan yang dimaksud adalah:</td>
								<td colspan="0"></td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">a.</td>
								<td colspan="20">Penipuan</td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">b.</td>
								<td colspan="20">Penggelapan uang perusahaan</td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">c.</td>
								<td colspan="20">Pencemaran nama baik Perusahaan & Client</td>
							</tr>
							<tr>
								<td ></td>
								<td colspan="0">d.</td>
								<td colspan="20">Memanipulasi data (Data Absen ataupun Data Penjualan) agar mendapatkan keuntungan pribadi sekaligus kerugian untuk perusahaan.</td>
							</tr>

							<tr>
								<td >11.</td>
								<td colspan="20">Apabila terbukti menjalin hubungan dalam 1 project yang sama dan hubungan tersebut ke jenjang serius hingga pernikahan, maka salah satu karyawan akan diakhiri kontrak kerjasama.</td>
								<td colspan="0"></td>
							</tr>

							<tr>
								<td >12.</td>
								<td colspan="20">Apabila terjadi hubungan asmara diluar wajar/selingkuh yang berakibat terhadap produktivitas dan menggangu kinerja serta nama baik perusahaan maka karyawan bersedia untuk mengakhiri masa kerjasama</td>
								<td colspan="0"></td>
							</tr>

							<tr>
								<td >13.</td>
								<td colspan="20">Wajib melampirkan Exit clearance, Form handover (isi bila diperlukan) apabila secara administrasi tidak dilengkapi maka akan diberlakukan hold gaji sisa masa kerja maupun pemberian paklaring hingga administrasi diselesaikan</td>
								<td colspan="0"></td>
							</tr>

				</table>

				<br><br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
					<tr>
						<td>Demikian Surat Perjanjian Bersama ini ditandatangani dalam keadaan jasmani/rohani yang sehat, dan tanpa paksaan dari pihak manapun.</td>
					</tr>			
				</table>';
				$pdf->writeHTML($tbl_spb, true, false, false, false, '');

				if($pkwt_active == 1){


				$tbl_ttd2 = '
				<table cellpadding="2" cellspacing="0" border="0">

					<tr>
						<td>Pihak Pertama</td>
						<td>Pihak Kedua</td>
					</tr>

					<tr>
						<td><br>
					<img src="'.base_url().'assets/images/pkwt/'.$sign_qrcode.'" alt="Trulli" width="90" height="90"><br><b><u>'.$sign_fullname.'</u></b></td>
						<td><br><br><br><br><br><br><br><b><br><u>'.$namalengkap.'</u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>

					<tr>
						<td>'.$sign_jabatan.'</td>
						<td>Karyawan</td>
					</tr>

				</table>';

				} else {


				$tbl_ttd2 = '
				<table cellpadding="2" cellspacing="0" border="0">

					<tr>
						<td>Pihak Pertama</td>
						<td>Pihak Kedua</td>
					</tr>

					<tr>
						<td><br>
					<img src="'.base_url().'assets/under_review.png" alt="Trulli" width="120" height="90"><br><b><u>'.$sign_fullname.'</u></b></td>
						<td><br><br><br><br><br><br><br><b><br><u>'.$namalengkap.'</u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>

					<tr>
						<td>'.$sign_jabatan.'</td>
						<td>Karyawan</td>
					</tr>

				</table>';


				}
				$pdf->writeHTML($tbl_ttd2, true, false, false, false, '');
				
				//<img src="'.base_url().'assets/images/pkwt/esign_pkwt230604162602000.png" alt="Trulli" width="90" height="90">
				//<img src="'.base_url().'assets/images/pkwt/$sign_qrcode" alt="Trulli" width="90" height="90">
				//<img src="'.base_url().'assets/under_review.png" alt="Trulli" width="120" height="90">
				$lampiran = '

				<br><br><br><br><br><br><br><br><br><br><br><br>
				<br><br><br><br><br><br><br><br><br><br><br><br>
				<br><br><br><br><br><br><br><br><br><br>
				
				<table cellpadding="2" cellspacing="0" border="0">

					<tr>
						<td>Lapiran 1</td>
						<td colspan="5">PKWT <b>'.$nomorsurat.'</b></td>
					</tr>

				</table>
				<br>
				<br>


				<table cellpadding="2" cellspacing="0" border="1">

				<tr>
					<td>Nama</td>
					<td colspan="5">'.$namalengkap.'</td>
				</tr>

				<tr>
					<td>NIK KTP</td>
					<td colspan="5">'.$ktp.'</td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td colspan="5">'.$jabatan.'</td>
				</tr>
				<tr>
					<td>Penugasan di Klien</td>
					<td colspan="5">'.$client.'</td>
				</tr>
				<tr>
					<td>Lokasi Penempatan</td>
					<td colspan="5">'.$penempatan.'</td>
				</tr>
				<tr>
					<td>Periode Perjanjian <br><br>- Mulai<br>- Berakhir</td>
					<td colspan="5"><br><br><br>'.$this->Xin_model->tgl_indo($tglmulaipkwt).'<br>'.$this->Xin_model->tgl_indo($tglakhirpkwt).'</td>
				</tr>
				<tr>
					<td>Waktu Kerja</td>
					<td colspan="5">8 Jam Kerja 1 Jam Istirahat  atau sesuai dengan ketentuan di klien</td>
				</tr>
				<tr>
					<td>Upah per bulan</td>
					<td colspan="5">
					<table cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td>Gaji Pokok</td>
							<td colspan="3"> : '.$basicpay.',- Per Bulan</td>
						</tr>';


				if($allowance_grade!="Rp 0"){
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Grade</td>
							<td colspan="3"> : '.$allowance_grade.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_area!="Rp 0"){
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Area</td>
							<td colspan="3"> : '.$allowance_area.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_masakerja!="Rp 0"){
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Masa Kerja</td>
							<td colspan="3"> : '.$allowance_masakerja.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_meal!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Makan</td>
							<td colspan="3"> : '.$allowance_meal.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_transport!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Transport</td>
							<td colspan="3"> : '.$allowance_transport.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_rent!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Rental</td>
							<td colspan="3"> : '.$allowance_rent.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_komunikasi!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Komunikasi</td>
							<td colspan="3"> : '.$allowance_komunikasi.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_park!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Parkir</td>
							<td colspan="3"> : '.$allowance_park.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_residance!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Tempat Tinggal</td>
							<td colspan="3"> : '.$allowance_residance.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_laptop!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Laptop</td>
							<td colspan="3"> : '.$allowance_laptop.',- Per Bulan</td>
						</tr>';
				}


				if($allowance_kasir!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Kasir</td>
							<td colspan="3"> : '.$allowance_kasir.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_transmeal!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Makan-Transport</td>
							<td colspan="3"> : '.$allowance_transmeal.',- Per Bulan</td>
						</tr>';
				}

				if($allowance_medicine!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Kesehatan</td>
							<td colspan="3"> : '.$allowance_medicine.',- Per Bulan</td>
						</tr>';
				}


				if($allowance_akomodasi!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Akomodasi</td>
							<td colspan="3"> : '.$allowance_akomodasi.',- Per Bulan</td>
						</tr>';
				}


				if($allowance_operation!="Rp 0"){	
				$lampiran .= '
					
						<tr>
							<td>Tunjangan Operasional</td>
							<td colspan="3"> : '.$allowance_operation.',- Per Bulan</td>
						</tr>';
				}

				$lampiran .= '	

						<br>
						<tr>
							<td colspan="20">Note: Rincian gaji diatas belum termasuk potongan BPJS Kesehatan & Ketenagakerjaan maupun PPH21.</td>
							<td></td>
						</tr>
						
					</table>

					</td>
				</tr>
				<tr>
					<td>Waktu Pembayaran</td>
					<td colspan="5">Tanggal '.$tgl_payment.' setiap Bulan</td>
				</tr>
				<tr>
					<td>Periode Perhitungan</td>
					<td colspan="5">Periode perhitungan upah adalah tanggal '.$tgl_mulaiperiode_payment.' ke '.$tgl_akhirperiode_payment.' bulan berjalan</td>
				</tr>
				<tr>
					<td>Tunjangan Lain</td>
					<td colspan="5">


					<table cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td>Tunjangan Hari Raya (THR), dibayarkan dua minggu sebelum hari raya Idul Fitri dengan perhitungan sebagai berikut :</td>
						</tr>
						<tr>
							<td>Masa kerja > 1 bulan < 1 tahun :  prorata x Gaji</td>
						</tr>
						<tr>
							<td>Masa kerja > 1 tahun 1 kali gaji berjalan</td>
						</tr>
					</table>

					</td>
				</tr>
				<tr>
					<td>Jamsostek / BPJS Ketenagakerjaan</td>
					<td colspan="5">


					<table cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td>Jaminan Kecelakaan Kerja 0,24% ditanggung oleh Pihak Pertama</td>
						</tr>
						<tr>
							<td>Jaminan Kematian 0,3 % ditanggung oleh Pihak Pertama</td>
						</tr>
						<tr>
							<td>Jaminan Hari Tua 3,7 % ditanggung oleh Pihak Pertama</td>
						</tr>
						<tr>
							<td>Jaminan Pensiun 2 % ditanggung pihak pertama</td>
						</tr>
						<tr>
							<td>Jaminan Pensiun 1 % ditanggung pihak kedua</td>
						</tr>
						<tr>
							<td>Iuran JHT sebesar 2% ditanggung oleh Pihak Kedua</td>
						</tr>
					</table>

					</td>
				</tr>
				<tr>
					<td>Jaminan Kesehatan  ( BPJS Kesehatan )</td>
					<td colspan="5">


					<table cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td>Program BPJS (Didaftarkan Satu bulan setelah masa kerja )<br>( sesuai dengan ketentuan klien / peraturan perusahaan )
				</td>
						</tr>
						<tr>
							<td>Iuran sebesar 4% ditanggung oleh pihak Pertama, 1 % Pihak kedua,</td>
						</tr>
						<tr>
							<td>Bisa mengcover untuk karyawan, 1 orang pasangan yang sah, dan maksimal 3 orang anak.</td>
						</tr>
						<tr>
							<td>Gaji yang dilaporkan minimum sebesar UMP</td>
						</tr>
					</table>

					</td>
				</tr>
				<tr>
					<td>PPh 21</td>
					<td colspan="5">Ditanggung Pihak Kedua</td>
				</tr>

				
				</table>';
				$pdf->writeHTML($lampiran, true, false, false, false, '');
			
				$fname = strtolower($fname);
				$pay_month = strtolower(date("F Y"));
				//Close and output PDF document
				ob_start();
				$pdf->Output('pkwt_'.$fname.'_'.$pay_month.'.pdf', 'I');
				ob_end_flush();


		} else {
		 	echo '<script>alert("PKWT # ( DISACTIVE ) \nPlease Contact HR For Approval..!"); window.close();</script>';
			// redirect('admin/pkwt');
		}

	}


} 
?>
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

class Pkwt253 extends MY_Controller 
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

					$logo_cover = 'tcpdf_logo_sc.png';
					$header_namae = 'PT. Siprama Cakrawala';


				// set document information
				$pdf->SetCreator('HRCakrawala');
				$pdf->SetAuthor('HRCakrawala');
				// $baseurl=base_url();

				$header_namae = 'PT. Siprama Cakrawala';
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
				$pdf->SetTitle('PT. Siprama Cakrawala '.' - '.$this->lang->line('xin_download_profile_title'));
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

					$tanggalcetak 						= $pkwt[0]->from_date;
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

					$sum_salary = $pkwt[0]->basic_pay + $pkwt[0]->allowance_grade + $pkwt[0]->allowance_area + $pkwt[0]->allowance_masakerja + $pkwt[0]->allowance_meal + $pkwt[0]->allowance_transport + $pkwt[0]->allowance_rent + $pkwt[0]->allowance_komunikasi + $pkwt[0]->allowance_park + $pkwt[0]->allowance_residance + $pkwt[0]->allowance_laptop + $pkwt[0]->allowance_kasir + $pkwt[0]->allowance_transmeal + $pkwt[0]->allowance_medicine + $pkwt[0]->allowance_akomodasi + $pkwt[0]->allowance_operation;

					$tgl_mulaiperiode_payment = $pkwt[0]->start_period_payment;
					$tgl_akhirperiode_payment = $pkwt[0]->end_period_payment;
					$tgl_payment = $pkwt[0]->tgl_payment;

				} else {

				}


				$tbl_2 = '
				<br><br>
					<div style="text-align: center; text-justify: inter-word;">
						<b><u>PERJANJIAN KEMITRAAN<br>'.$nomorsurat.'</u></b>
					</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Perjanjian Kemitraan ini diadakan dan ditandatangani pada tanggal, <b>'.$this->Xin_model->tgl_indo($tglmulaipkwt).'</b> oleh dan antara:</td>
							</tr>
							<br>
							<tr>
								<td><b>PT. SIPRAMA CAKRAWALA</b>, yang berdudukan Gedung Graha Krista Aulia Cakrawala Jl Andara Raya No.20 Pangkalan Jati Baru Kec. Cinere Kota Depok, Jawa Barat 16513, yang dalam hal ini diwakili oleh <b>'.$sign_fullname.'</b> dalam kedudukannya sebagai Senior Manager HR dari dan oleh karenanya sah bertindak untuk dan atas nama <b>PT. SIPRAMA CAKRAWALA</b>, selanjutnya dalam perjanjian kemitraan ini disebut Perusahaan.</td>
							</tr>

				</table>

				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0">
					<tr>
						<td></td>
						<td colspan="2">Nama</td>
						<td colspan="10"> : <b>'.$namalengkap.'</b></td>
					</tr>

					<tr>
						<td></td>
						<td colspan="2">Tanggal Lahir</td>
						<td colspan="10"> : <b>'.$tempattgllahir.'</b></td>
					</tr>

					<tr>
						<td></td>
						<td colspan="2">Jabatan</td>
						<td colspan="10"> : <b>'.$jabatan.'</b></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">Alamat Rumah</td>
						<td colspan="10"> : <b>'.$alamatlengkap.'</b></td>
					</tr>

					<tr>
						<td></td>
						<td colspan="2">No. Hp</td>
						<td colspan="10"> : <b>'.$nomorkontak.'</b></td>
					</tr>

					<tr>
						<td></td>
						<td colspan="2">No. NIK/KTP</td>
						<td colspan="10"> : <b>'.$ktp.'</b></td>
					</tr>

					<tr>
						<td></td>
						<td colspan="10">dalam hal ini bertindak untuk dan atas nama diri sendiri, selanjutnya dalam perjanjian kemitraan ini disebut <b>Mitra</b></td>
						<td colspan="0"></td>
					</tr>

				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td><b>Perusahaan</b> dan <b>Mitra</b> secara sendiri-sendiri akan disebut <b>"Pihak"</b> dan secara bersama-sama disebut <b>"Para Pihak"</b>.</td>
							</tr>		
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Para pihak terlebih dahulu mempertimbangkan hal-hal sebagai berikut :</td>
							</tr>			
				</table>
				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>a.</td>
								<td colspan="20">Bahwa Perusahaan bermaksud menggunakan jasa Mitra untuk melakukan pekerjaan sebagai <b>'.$jabatan.'</b> di klien perusahaan yaitu <b>'.$client.'</b> Penempatan <b>'.$penempatan.'</b>.</td>
							</tr>

							<tr>
								<td>b.</td>
								<td colspan="20">Bahwa Mitra menyetujui untuk memberikan layanan jasa semacam ini dengan tunduk pada ketentuan dan syarat-syarat yang dinyatakan dalam Perjanjian ini.</td>
							</tr>
				</table>
				<br>
				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Setelah memperhatikan pertimbangan tersebut di atas dengan ini telah dicapai kata sepakat antara Perusahaan dan Mitra dengan ketentuan dan syarat-syarat sebagai berikut :
								</td>
							</tr>			
				</table>
				<br>

				<br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">
							<tr>
								<td>1.</td>
								<td colspan="20">Jangka waktu Perjanjian Kemitraan ini berlaku pada periode <b>'.$this->Xin_model->tgl_indo($tglmulaipkwt).'</b> sampai <b>'.$this->Xin_model->tgl_indo($tglakhirpkwt).'</b>, dan atau masa periode bekerja disesuaikan kembali dengan kebutuhan perusahaan.</td>
							</tr>
				<br>

							<tr>
								<td>2.</td>
								<td colspan="20">Hari kerja disesuaikan dengan ketentuan perusahaan/klien</td>
							</tr>
				<br>

							<tr>
								<td>3.</td>
								<td colspan="20">Waktu kerja mengikuti ketentuan perusahaan/klien.</td>
							</tr>
				<br>

							<tr>
								<td>4.</td>
								<td colspan="20">Mitra selama memberikan layanan jasanya kepada Perusahaan akan memperoleh Komisi Jasa sebesar :</td>
							</tr>';


						$tbl_2 .= '

							<tr>
								<td colspan="0"></td>
								<td colspan="1">•</td>
								<td colspan="20">Total Upah Harian yang didapatkan sebesar <b>'.$this->Xin_model->rupiah($sum_salary).'/ Hari</b></td>
							</tr>

							
							<br>
							<tr>
								<td>5.</td>
								<td colspan="20">Apabila saya mitra yang bertugas membawa barang ataupun uang maka saya bertanggung jawab penuh terhadap product / barang maupun uang yang menjadi tanggung jawab saya sebagai sales / motorist , apabila dikemudian hari terdapat kerusakan ataupun kehilangan barang/product akan menjadi tanggung jawab pribadi. Apabila kehilangan uang yang sengaja dilakukan oleh karyawan tersebut (lalai) akan menjadi tanggung jawab pribadi kecuali karyawan mengalami kejadian perampokan.</td>
							</tr>
							
							<br>	
							<tr>
								<td>6.</td>
								<td colspan="20">Apabila saya mitra yang bertugas membawa kendaraan (mobil/motor) operasional/milik perusahaan lalu mengalami kerusakan maka beban kerusakan tidak ditanggung oleh perusahaan/client melainkan saya sendiri selaku driver kendaraan tersebut 100%</td>
							</tr>
							
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<tr>
								<td>7.</td>
								<td colspan="20">Perjanjian Kemitraan ini dengan sendirinya akan berakhir apabila Mitra melakukan pelanggaran berat sebagai berikut :</td>
							</tr>

							<tr>
								<td></td>
								<td colspan="1">a.</td>
								<td colspan="20">Melakukan pelanggaran terhadap Tata Tertib & Peraturan Perusahaan termasuk penipuan, pencurian, atau penggelapan barang dan/atau uang milik perusahaan. Mabuk, meminum minuman keras yang memabukan, memakai dan atau mengedarkan narkotika, psikotropika, dan zat adiktif lainnya di tempat kerja, melakukan perbuatan asusila atau perjudian di tempat kerja.</td>
							</tr>

							<tr>
								<td></td>
								<td colspan="1">b.</td>
								<td colspan="20">Menyalahgunakan dan membocorkan informasi, data dan dokumen rahasia milik Pihak Pertama maupun Perusahaan Klien untuk kepentingan pribadi atau pihak ketiga..</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="1">c.</td>
								<td colspan="20">Mencemarkan nama baik perusahaan.</td>
							</tr>
<br>
							<tr>
								<td colspan="10">Perjanjian Kemitraan ini berlaku sejak tanggal dimana kedua belah pihak telah menandatangani Perjanjian ini.</td>
								<td colspan="0"></td>
								<td colspan="0"></td>
							</tr>

				</table>

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
							<img src="'.base_url().'assets/images/tkhl/'.$sign_qrcode.'" alt="Trulli" width="80" height="80"><br><b><u>'.$sign_fullname.'</u></b></td>
							<td><br><br><br><br><br><br><br><b><u>'.$namalengkap.' </u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
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


			
				// $fname = strtolower($fname);
				// $pay_month = strtolower(date("F Y"));
				//Close and output PDF document
				ob_start();
				// $pdf->Output('pkwt_'.$fname.'_'.$pay_month.'.pdf', 'I');
				$pdf->Output('pkwt_'.$namalengkap.'_'.$nomorsurat.'.pdf', 'I');
				ob_end_flush();


		} else {
		 	echo '<script>alert("PKWT # ( DISACTIVE ) \nPlease Contact HR For Approval..!"); window.close();</script>';
			// redirect('admin/pkwt');
		}

	}


} 
?>
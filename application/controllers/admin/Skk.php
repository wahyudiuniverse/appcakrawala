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

class Skk extends MY_Controller {
	
	 public function __construct() {
      parent::__construct();
			$this->load->library('session');
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->database();
			$this->load->library('form_validation');
			$this->load->library('ciqrcode');
			//load the model
			$this->load->model("Esign_model");
			$this->load->model("Location_model");
			$this->load->model("Xin_model");
			$this->load->model("Employees_model");
			$this->load->model("Company_model");
			$this->load->model("Project_model");
			$this->load->library('Pdf');
			$this->load->helper('string');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(!$session){
			redirect('admin/');
		}

		$session = $this->session->userdata('username');
		$data['title'] = $this->lang->line('xin_surat_keterangan_kerja').' | '.$this->Xin_model->site_title();
		$data['all_locations'] = $this->Xin_model->all_locations();
		$data['all_employees'] = $this->Esign_model->get_all_employees_resign();
		$data['all_projects'] = $this->Esign_model->get_project_exist_resign();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_surat_keterangan_kerja');
		$data['path_url'] = 'skk';
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('487',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/skk/skk_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	public function esign_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/skk/skk_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$esign = $this->Esign_model->get_esign_skk();
		$data = array();

          foreach($esign->result() as $r) {
			  
			$jenis_doc = $r->jenis_dokumen;
			$nomor_dokumen = $r->nomor_dokumen;
			$nip = $r->nip;
			$createdat = $this->Xin_model->tgl_indo(substr($r->createdon,0,10));
			// // get user > head
			// user full name
			if($jenis_doc==1){
				$jdoc = 'SK Kerja';
			} else if ($jenis_doc==2) {
				$jdoc = 'Paklaring';	
			} else if ($jenis_doc==3) {
				$jdoc = 'SK Kerja & Paklaring';	
			} else {
				$jdoc = '--';	
			}
			
			$head_user = $this->Employees_model->read_employee_info_by_nik($r->nip);
			if(!is_null($head_user)){
				$fullname = $head_user[0]->first_name;
			} else {
				$fullname = '--';	
			}

			// // get company
			// $company = $this->Xin_model->read_company_info($r->company_id);
			// if(!is_null($company)){
			// 	$comp_name = $company[0]->name;
			// } else {
			// 	$comp_name = '--';	
			// }
			
			// // get company
			// $location = $this->Location_model->read_location_information($r->location_id);
			// if(!is_null($location)){
			// 	$location_name = $location[0]->location_name;
			// } else {
			// 	$location_name = '--';	
			// }
			

			$viewqr = '<a href="'.base_url().'assets/images/'.$r->qr_code.'" target="_blank"> <img id="myImg" style="width: 50px;" src="'.base_url().'assets/images/'.$r->qr_code.'"></a>';

			if(in_array('488',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->secid . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}

			if(in_array('488',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/skk/view/'.$r->secid.'/'.$r->nip.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}

			if(in_array('488',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $delete.' '.$view;
			  
		   $data[] = array(
				$combhr,
				$nomor_dokumen,
				$nip,
				$fullname,
				$jdoc,
				$createdat,
				$viewqr
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $esign->num_rows(),
                 "recordsFiltered" => $esign->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }


	// get company > departments
	public function get_projectemp() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'project_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/skk/get_projectemp", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	// get company > departments
	public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/skk/get_join_resign", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	// Validate and add info in database
	public function add_esign() {

		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= './assets/'; //string, the default is application/cache/
		$config['errorlog']		= './assets/'; //string, the default is application/logs/
		$config['imagedir']		= './assets/images/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '1024'; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);


		if($this->input->post('add_type')=='department') {
		// Check validation for user input
		$session = $this->session->userdata('username');
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($Return['error']!=''){
			
       		$this->output($Return);
    	}

		$docid = date('ymdHis');
		$image_name='esign_skk'.date('ymdHis').'.png'; //buat name dari qr code sesuai dengan nim
		$domain = 'https://apps-cakrawala.com/esign/sk/'.$docid;
		$params['data'] = $domain; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		if($this->input->post('closing_date_bpjs')!=''){
			$bpjs_date = $this->input->post('closing_date_bpjs');
		} else {
			$bpjs_date = $this->input->post('resign_date');
		}


		$last = new DateTime(date("2022-12-31"));
		$resign_date = new DateTime($this->input->post('resign_date'));

		if($resign_date<$last){
			$sign_fullname = 'Maitsa Valenska Pristiyanty';
			$sign_nip = '21300025';
		} else {
			$sign_fullname = 'Asti Prastista';
			$sign_nip = '21500006';
		}

		if($this->input->post('company_id')=='2'){
			$ns = str_replace('[SC-KAC]','SC',$this->input->post('nomordoc'));
		} else if ($this->input->post('company_id')=='3'){
			$ns = str_replace('[SC-KAC]','KAC',$this->input->post('nomordoc'));
		} else {
			$ns = $this->input->post('company_id');
		}
		
		$count_skk = $this->Esign_model->count_skk();
		$nomor_surat = sprintf("%05d", $count_skk[0]->maxid +1).$ns;


		$data = array(
		'doc_id' => $docid,
		'jenis_dokumen' => '2',
		'nomor_dokumen' => $nomor_surat,
		'nip' => $this->input->post('manag_sign'),
		'join_date'  => $this->input->post('join_date'),
		'resign_date'  => $this->input->post('resign_date'),
		'bpjs_date' => $bpjs_date,
		'qr_code' => $image_name,
		'sign_nip' => $sign_nip,
		'sign_fullname' => $sign_fullname,
		'sign_jabatan' => 'Senior Manager HR-GA',
		'sign_company' => $this->input->post('company_id'),

		'createdby' => 1,
		);

		// $data = $this->security->xss_clean($data);
		$result = $this->Esign_model->addsign_skk($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_department');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		header("location:index.php");
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='department') {
			
		
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			// Check validation for user input
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			$this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			/* Server side PHP input validation */
			if($this->input->post('department_name')==='') {
				$Return['error'] = $this->lang->line('error_department_field');
			} else if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('xin_location_field_error');
			} 
					
			if($Return['error']!=''){
				$this->output($Return);
			}
		
			$data = array(
			'department_name' => $this->input->post('department_name'),
			'company_id' => $this->input->post('company_id'),
			'location_id' => $this->input->post('location_id'),
			'employee_id' => $this->input->post('employee_id'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->Department_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_update_department');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				$id = $this->security->xss_clean($id);
				$result = $this->Esign_model->delete_sign_skk($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('xin_success_delete');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
			}
		}
	}


	public function view() {
		$system = $this->Xin_model->read_setting_info(1);		
		 // create new PDF document
   	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$vskk = $this->uri->segment(4);
		$vpin = $this->uri->segment(5);
		// $employee_id = $this->uri->segment(5);

		// $eslip = $this->Employees_model->read_eslip_info_by_nip_periode($vpin, $vperiode);
		$employee = $this->Employees_model->read_employee_info_by_nik($vpin);
		$eskk = $this->Esign_model->read_skk($vskk);


			if(!is_null($eskk)){

				// $tanggal = $this->Xin_model->tgl_indo($eslip[0]->tanggal);
				$nip = $eskk[0]->nip;
				$nomor_dokumen = $eskk[0]->nomor_dokumen;
				$nip = $eskk[0]->nip;
				$fullname = $employee[0]->first_name;
				$blacklist = $employee[0]->status_resign;
				$join_date = $this->Xin_model->tgl_indo($eskk[0]->join_date);
				$resign_date = $this->Xin_model->tgl_indo($eskk[0]->resign_date);

				if($eskk[0]->nip == '21500005'){
					$join_bpjs = $this->Xin_model->tgl_indo('2022-05-01');
					// $join_bpjs = $this->Xin_model->tgl_indo($eskk[0]->bpjs_join);
				}else{
					$join_bpjs = $this->Xin_model->tgl_indo($eskk[0]->join_date);
				}

				if($eskk[0]->sign_company==2){
					$logo_cover = 'tcpdf_logo_sc.png';
					$header_namae = 'PT. Siprama Cakrawala';
				} else {
					$logo_cover = 'tcpdf_logo_kac.png';
					$header_namae = 'PT. Krista Aulia Cakrawala';
				}

				$closing_bpjs = $this->Xin_model->tgl_indo($eskk[0]->bpjs_date);
				$waktu_kerja = $eskk[0]->waktu_kerja;
				$qr_code = $eskk[0]->qr_code;
				$ktp_no = $employee[0]->ktp_no;
				$address = $employee[0]->alamat_ktp;
				$createdon = $this->Xin_model->tgl_indo(substr($eskk[0]->createdon,0,10));
				// $allow_rent = $eslip[0]->allow_rent;
				// $allow_comunication = $eslip[0]->allow_comunication;

				$sign_fullname = $eskk[0]->sign_fullname;
				$sign_jabatan = $eskk[0]->sign_jabatan;

				$monyear =  date('M Y');
				$tanggalcetak = date("Y-m-d");
	

					$designation = $this->Xin_model->read_user_xin_designation($employee[0]->designation_id);
					if(!is_null($designation)){
						$jabatan = $designation[0]->designation_name;
					} else {
						$jabatan = $designation[0]->designation_name;
					}

					$project = $this->Project_model->read_project_information($employee[0]->project_id);
					if(!is_null($designation)){
						if($project[0]->title == 'INHOUSE'){

						$project_name = 'PT. SIPRAMA CAKRAWALA';
						} else {

						$project_name = $project[0]->title;
						}
					} else {
						$project_name = '-';
					}

			} else {
				redirect('admin/');
			}

		// if($eslip[0]->status_kirim==1){
			// $bMargin = $this->getBreakMargin();
			// $bMargi = $this->getBreakMargin();


			// set document information
			$pdf->SetCreator('PT Siprama Cakrawala');
			$pdf->SetAuthor('PT Siprama Cakrawala');
			// $baseurl=base_url();

			$header_string = 'HR Power Services | Facility Services'."\n".'Gedung Graha Krista Aulia, Jalan Andara Raya No. 20, Pangakalan Jati Baru, Kecamatan Cinere, Kota Depok 16513, Telp: (021) 27813599';

			$pdf->SetHeaderData($logo_cover, 35, $header_namae, $header_string);
			
			$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
			// set header and footer fonts
			// $pdf->setHeaderFont(Array('helvetica', '', 20));
			// $pdf->setFooterFont(Array('helvetica', '', 9));
		
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
			// $pdf->SetProtection(array('print','copy'),'1234',null, 0, null);

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
		
			// set cell padding
			$pdf->setCellPaddings(1, 1, 1, 1);
			
			// set cell margins
			$pdf->setCellMargins(0, 0, 0, 0);
			
			// set color for background
			$pdf->SetFillColor(255, 255, 127);
			/////////////////////////////////////////////////////////////////////////////////



			if($waktu_kerja>=3 && $nip !='21305471' && $nip != '21300004' && $nip != '21306162' && $nip != '21500027' && $blacklist != 3){

			$tbl_2 = '

					<div style="text-align: center; text-justify: inter-word;">
						<b><u>SURAT KETERANGAN KERJA</u><br>No.'.$nomor_dokumen.'</b>
					</div>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Depok, '.$createdon.'<br>Yang bertanda tangan di bawah ini,</td>
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
						<td colspan="3">: Gedung Graha Krista Aulia Cakrawala Lt.2 Jl. Andara No. 20 Pangkalan Jati Baru Cinere Depok 16513</td>
					</tr>
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Menerangkan Bahwa,</td>
							</tr>
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">

					<tr>
						<td>ID Karyawan</td>
						<td colspan="3">: '.$nip.'</td>
					</tr>

					<tr>
						<td>Nama Lengkap</td>
						<td colspan="3">: '.$fullname.'</td>
					</tr>


					<tr>
						<td>Jabatan Terakhir</td>
						<td colspan="3">: '.$jabatan.'</td>
					</tr>

					<tr>
						<td>Nomor KTP</td>
						<td colspan="3">: '.$ktp_no.'</td>
					</tr>

					<tr>
						<td>Alamat KTP</td>
						<td colspan="3">: '.$address.'</td>
					</tr>

				</table>
				<br>

				<br><br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Adalah benar karyawan yang bekerja di Perusahaan kami sejak tanggal '.$join_date.' sampai dengan '.$resign_date.' yang ditempatkan pada <b>'.$project_name.'</b><br> <br>
									Selama bekerja Sdr. '.$fullname.' telah menujukan tanggung jawab dan kinerja yang baik dan dengan ini perusahaan mengucapkan terima kasih.<br><br>
									Demikian surat keterangan ini dibuat, agar dapat digunakan sebagaimana mestinya.
								</td>
							</tr>
				</table>
				<br>
				<br>
				<br>
				<table cellpadding="2" cellspacing="0" border="0">

				<tr>
					<td style="text-align:center;">'.$header_namae.'</td>
					
				</tr>

				<tr>
					<td style="text-align:center;"><br>
				<img src="'.base_url().'assets/images/'.$qr_code.'" alt="Trulli" width="80" height="80"><br><b><u>'.$sign_fullname.'</u></b></td>
					
				</tr>

				<tr>
					<td style="text-align:center;">'.$sign_jabatan.'</td>
					
				</tr>

				</table>

				<p style="font-size: 10px;"><i>*Bahwa dokumen ini sudah ditandatangani secara <b>Elektronik</b> dan dapat dipertanggung jawabkan menurut hukum yang berlaku.<br>*Tandatangan Elektronik yang tercantum secara resmi dikeluarkan oleh PT. Siprama Cakrawala.</i></p>';
			$pdf->writeHTML($tbl_2, true, false, false, false, '');

			$tbl_ttd = '			
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Depok, '.$createdon.'</td>
							</tr>	
							<tr>						
								<td>No.'.$nomor_dokumen.'</td>
							</tr>
				</table>

				<br><br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Kepada Yth.</td>
							</tr>
							<tr>
								<td>Dinas Ketenagakerjaan</td>
							</tr>	
				</table>
				<br><br><br><br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Dengan hormat.</td>
							</tr>
				</table>
				<br><br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Kami yang bertanda tangan di bawah ini:</td>
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

				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Dengan ini kami sampaikan bahwa:</td>
							</tr>
				</table>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">

					<tr>
						<td>ID Karyawan</td>
						<td colspan="3">: '.$nip.'</td>
					</tr>

					<tr>
						<td>Nama Lengkap</td>
						<td colspan="3">: '.$fullname.'</td>
					</tr>


					<tr>
						<td>Jabatan Terakhir</td>
						<td colspan="3">: '.$jabatan.'</td>
					</tr>

					<tr>
						<td>Nomor KTP</td>
						<td colspan="3">: '.$ktp_no.'</td>
					</tr>

					<tr>
						<td>Alamat KTP</td>
						<td colspan="3">: '.$address.'</td>
					</tr>

				</table>
				<br><br><br>


				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Bahwa benar karyawan kami di atas, telah bekerja di <b>'.$project_name.'</b> dari tanggal '.$join_bpjs.' sampai dengan '.$closing_bpjs.'.
								</td>
							</tr>
				</table>

				<br><br>
				<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
							<tr>
								<td>Demikian surat ini kami sampaikan sebagai kelengkapan untuk pengurusan penarikan Jaminan Ketenagakerjaan (BPJS).
								</td>
							</tr>
				</table>

				<br>
				<br>
				<br>

				<table cellpadding="2" cellspacing="0" border="0">

				<tr>
					<td></td>
					<td style="text-align:center;">Hormat kami,</td>
				</tr>

				<tr>
					<td></td>
					<td style="text-align:center;">'.$header_namae.'</td>
				</tr>


				<tr>

					<td><br><br><br><br><br><br><br><b><u></u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="text-align:center;"><br>
				<img src="'.base_url().'assets/images/'.$qr_code.'" alt="Trulli" width="80" height="80"><br><b><u>'.$sign_fullname.'</u></b></td>
				</tr>

				<tr>
					<td></td>
					<td style="text-align:center;">'.$sign_jabatan.'</td>
				</tr>

				</table>


				<p style="font-size: 10px;"><i>*Bahwa dokumen ini sudah ditandatangani secara <b>Elektronik</b> dan dapat dipertanggung jawabkan menurut hukum yang berlaku.<br>*Tandatangan Elektronik yang tercantum secara resmi dikeluarkan oleh PT. Siprama Cakrawala.</i></p>';
			$pdf->writeHTML($tbl_ttd, true, false, false, false, '');
			} else {

				$tbl_ttd = '
					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Depok, '.$createdon.'</td>
								</tr>	
								<tr>						
									<td>No.'.$nomor_dokumen.'</td>
								</tr>
					</table>

					<br><br>

					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Kepada Yth.</td>
								</tr>
								<tr>
									<td>Dinas Ketenagakerjaan</td>
								</tr>	
					</table>
					<br><br><br><br>

					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Dengan hormat.</td>
								</tr>
					</table>
					<br><br>

					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Kami yang bertanda tangan di bawah ini:</td>
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

					</table>
					<br>
					<br>

					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Dengan ini kami sampaikan bahwa:</td>
								</tr>
					</table>
					<br>
					<br>

					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify;">

						<tr>
							<td>ID Karyawan</td>
							<td colspan="3">: '.$nip.'</td>
						</tr>

						<tr>
							<td>Nama Lengkap</td>
							<td colspan="3">: '.$fullname.'</td>
						</tr>


						<tr>
							<td>Jabatan Terakhir</td>
							<td colspan="3">: '.$jabatan.'</td>
						</tr>

						<tr>
							<td>Nomor KTP</td>
							<td colspan="3">: '.$ktp_no.'</td>
						</tr>

						<tr>
							<td>Alamat KTP</td>
							<td colspan="3">: '.$address.'</td>
						</tr>

					</table>
					<br><br><br>


					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Bahwa benar karyawan kami di atas, telah bekerja di <b>'.$project_name.'</b> dari tanggal '.$join_bpjs.' sampai dengan '.$resign_date.'.
									</td>
								</tr>
					</table>

					<br><br>
					<table cellpadding="2" cellspacing="0" border="0" style="text-align: justify; text-justify: inter-word;">
								<tr>
									<td>Demikian surat ini kami sampaikan sebagai kelengkapan untuk pengurusan penarikan Jaminan Ketenagakerjaan (BPJS).
									</td>
								</tr>
					</table>

					<br>
					<br>
					<br>

					<table cellpadding="2" cellspacing="0" border="0">

					<tr>
						<td></td>
						<td style="text-align:center;">Hormat kami,</td>
					</tr>

					<tr>
						<td></td>
						<td style="text-align:center;">PT SIPRAMA CAKRAWALA</td>
					</tr>


					<tr>

						<td><br><br><br><br><br><br><br><b><u></u></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="text-align:center;"><br>
					<img src="'.base_url().'assets/images/'.$qr_code.'" alt="Trulli" width="80" height="80"><br><b><u>'.$sign_fullname.'</u></b></td>
					</tr>

					<tr>
						<td></td>
						<td style="text-align:center;">'.$sign_jabatan.'</td>
					</tr>

					</table>


					<p style="font-size: 10px;"><i>*Bahwa dokumen ini sudah ditandatangani secara <b>Elektronik</b> dan dapat dipertanggung jawabkan menurut hukum yang berlaku.<br>*Tandatangan Elektronik yang tercantum secara resmi dikeluarkan oleh PT. Siprama Cakrawala.</i></p>';
				$pdf->writeHTML($tbl_ttd, true, false, false, false, '');
			}


			$fname = strtolower($nip);
			$pay_month = strtolower(date("F Y"));
			//Close and output PDF document
			ob_start();
			$pdf->Output('skk'.$fname.'_'.$pay_month.'.pdf', 'I');
			ob_end_flush();

		// } else {
		//  	echo '<script>alert("ORDER BELUM DI PROSES...!  \nPlease Contact Admin For Approval..!"); window.close();</script>';
		// 	// redirect('admin/pkwt');
		// }
	}


}

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

class ImportExcelPKWT extends MY_Controller 
{

	public function __construct(){
    parent::__construct();
    $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Callplan_model");
		$this->load->model("Customers_model");
		$this->load->model("Pkwt_model");
		$this->load->model("Import_model");
  }
	 		
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['title'] = $this->lang->line('xin_import_excl_pkwt_view').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_excl_pkwt_view');

		$product_id = 
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['uploadid'] = $this->input->get('upid', TRUE);
		// $data['all_posisi'] = $this->Xin_model->get_designations();
		// $data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'import_excel_pkwt';
		// $data['path_url'] = 'import_excel_employees';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('129',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/import_excel/view_import_pkwt", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else { 
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	
	
	public function view_import_excel_pkwt() {

		$datad['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/import_excel/view_import_pkwt", $datad);
		} else {
			redirect('admin/');
		}
		$product_id = $this->input->get('upid', TRUE);

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		// $employees_temp = $this->Employees_model->get_employees_temp('20220616175659238');
		$pkwt_temp = $this->Pkwt_model->get_pkwt_temp($product_id);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

    foreach($pkwt_temp->result() as $r) {
			  
			  $importid = $r->uploadid;
			  $no_surat = $r->no_surat;
			  $no_spb = $r->no_spb;
			  $employee_id = $r->employee_id;
			  $contract_type_id = $r->contract_type_id;
			  $posisi = $r->posisi;
			  $posisi_terakhir = $r->posisi_terakhir;
			  $project = $r->project;
			  $penempatan = $r->penempatan;
			  $waktu_kontrak = $r->waktu_kontrak;
			  $hari_kerja = $r->hari_kerja;
			  $allowance_meal = $r->allowance_meal;
			  $allowance_transport = $r->allowance_transport;
			  $allowance_bbm = $r->allowance_bbm;
			  $allowance_pulsa = $r->allowance_pulsa;
			  $allowance_rent = $r->allowance_rent;
			  $allowance_grade = $r->allowance_grade;
			  $allowance_laptop = $r->allowance_laptop;
			  $from_date = $r->from_date;
			  $to_date = $r->to_date;
			  $start_period_payment = $r->start_period_payment;
			  $end_period_payment = $r->end_period_payment;
			  $tgl_payment = $r->tgl_payment;

				$now = new DateTime(date("Y-m-d"));

				// $isExist = $this->Employees_model->CheckExistNIK($r->employee_id);
				$isExist = $this->Pkwt_model->read_pkwt_info_by_nosurat($r->no_surat);


				if(!is_null($r->status_error)){
					$error = '<p style="color:#5daf6b"><b>Success Iport</b></p>';
				} else {

						if(!is_null($isExist)){
							$status_btn = 'btn-success'; 
							// $status_title = $this->lang->line('xin_employees_active');

							$error = '<p style="color:#f9355e"><b>NIK Sudah Terdaftar</b></p>';

						}else {
							$status_btn = 'btn-outline-danger'; 
							// $status_title = $this->lang->line('xin_employees_inactive');

							$error = '
								<div class="btn-group btn-success" data-toggle="tooltip" data-state="primary" data-placement="top">
									<div>
										<a class="dropdown-item inserttemp" href="javascript:void(0)" data-status="1" data-user-id="'.$r->secid.'" style="color: azure;">Import</a>
									</div>
								</div>';

						}

				}

		   $data[] = array(
		   	$error,
				// $importid,
				$no_surat,
				$no_spb,
				$employee_id,
				$contract_type_id,
				$posisi,
				$posisi_terakhir,
				$project,
				$penempatan,
				$waktu_kontrak,
				$hari_kerja,
			  $allowance_meal,
			  $allowance_transport,
			  $allowance_bbm,
			  $allowance_pulsa,
			  $allowance_rent,
			  $allowance_grade,
			  $allowance_laptop,
				$from_date,
				$to_date,
				$start_period_payment,
				$end_period_payment,
				$tgl_payment,
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $pkwt_temp->num_rows(),
                 "recordsFiltered" => $pkwt_temp->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }
		
	// Validate and update status info in database // status info
	public function temp_to_primary() {
		/* Define return | here result is used to return user data and error for error message */
		$status_id = $this->uri->segment(4);
		// if($status_id == 2){
		// 	$status_id = 0;
		// }
		// $user_id = $this->uri->segment(5);
		// $user = $this->Xin_model->read_employee_temp_info($status_id);
		// $duplicate = $this->Employees_model->read_employee_info_by_nik($user[0]->employee_id);

		$pkwt = $this->Xin_model->read_pkwt_temp_info($status_id);
		$duplicate_ns = $this->Pkwt_model->read_pkwt_info_by_nosurat($pkwt[0]->no_surat);



			if(!is_null($duplicate_ns)) {
				// $error = 'Error';

				$datas = array(
					'status_error' => 'Duplicate Nomor Surat',
				);

				// $this->Employees_model->update_error_temp($datas, $pkwt[0]->secid);
				$this->Pkwt_model->update_error_temp($datas, $pkwt[0]->secid);

			} else {

				$no_surat = $pkwt[0]->no_surat;
				$no_spb = $pkwt[0]->no_spb;
				$employee_id = $pkwt[0]->employee_id;
				$from_date = $pkwt[0]->from_date;
				$to_date = $pkwt[0]->to_date;
				$contract_type_id = $pkwt[0]->contract_type_id;
				$waktu_kontrak = $pkwt[0]->waktu_kontrak;
				$posisi = $pkwt[0]->posisi;
				$project = $pkwt[0]->project;
				$penempatan = $pkwt[0]->penempatan;
				$hari_kerja = $pkwt[0]->hari_kerja; 
				$basic_pay = $pkwt[0]->basic_pay;
				$allowance_meal = $pkwt[0]->allowance_meal;
				$allowance_transport = $pkwt[0]->allowance_transport;
				$allowance_bbm = $pkwt[0]->allowance_bbm;
				$allowance_pulsa = $pkwt[0]->allowance_pulsa;
				$allowance_rent = $pkwt[0]->allowance_rent;
				$allowance_grade = $pkwt[0]->allowance_grade;
				$allowance_laptop = $pkwt[0]->allowance_laptop;
				$tgl_payment = $pkwt[0]->tgl_payment;
				$start_period_payment = $pkwt[0]->start_period_payment;
				$end_period_payment = $pkwt[0]->end_period_payment;

				$data = array(
					'no_surat' => $no_surat,
					'no_spb' => $no_spb,
					'employee_id' => $employee_id,
					'from_date' => $from_date,
					'to_date' => $to_date,
					'contract_type_id' => $contract_type_id,
					'waktu_kontrak' => $waktu_kontrak,
					'posisi' => $posisi,
					'project' => $project,
					'penempatan' => $penempatan,
					'hari_kerja' => $hari_kerja,
					'basic_pay' => $basic_pay,
					'allowance_meal' => $allowance_meal,
					'allowance_transport' => $allowance_transport,
					'allowance_bbm' => $allowance_bbm,
					'allowance_pulsa' => $allowance_pulsa,
					'allowance_rent' => $allowance_rent,
					'allowance_grade' => $allowance_grade,
					'allowance_laptop' => $allowance_laptop,
					'tgl_payment' => $tgl_payment,
					'start_period_payment' => $start_period_payment,
					'end_period_payment' => $end_period_payment,
					'status_pkwt' => 1,
					'status_approve' => 1,
					'createdby' => $session['employee_id'],
				);

				$this->Pkwt_model->add($data);

				$datas = array(
					'status_error' => 'Success Import',
				);

				$this->Pkwt_model->update_error_temp($datas, $pkwt[0]->secid);

				echo $pkwt[0]->no_surat.' '.$this->lang->line('xin_employee_status_updated');

			}

		//$this->output($Return);
		//exit;
	}


	// Validate and update status info in database // status info
	public function temp_to_primary_all() {
		/* Define return | here result is used to return user data and error for error message */
		// $status_id = $this->uri->segment(4);

		$upload_id = $this->uri->segment(4);
		// if($status_id == 2){
		// 	$status_id = 0;
		// }
		// $user_id = $this->uri->segment(5);

		// $tempPkwt = $this->Import_model->get_temp_employees($upload_id);
		$tempPkwt = $this->Import_model->get_temp_pkwt($upload_id);

		for($i=0; $i< count($tempPkwt); $i++){

				// $user = $this->Xin_model->read_employee_temp_info($tempEmployees[$i]->secid);
				// $duplicate = $this->Employees_model->read_employee_info_by_nik($user[0]->employee_id);

				$user = $this->Xin_model->read_pkwt_temp_info($tempPkwt[$i]->secid);
				$duplicate = $this->Pkwt_model->read_pkwt_info_by_nosurat($user[0]->no_surat);

					if(!is_null($duplicate)) {
						// $error = 'Error';

						$datas = array(
							'status_error' => 'Duplicate',
						);

						// $this->Employees_model->update_error_temp($datas, $user[0]->secid);
						$this->Pkwt_model->update_error_temp($datas, $user[0]->secid);

					} else {
						

				$no_surat = $user[0]->no_surat;
				$no_spb = $user[0]->no_spb;
				// $employee_id = $user[0]->employee_id;
				// $from_date = $user[0]->from_date;
				// $to_date = $user[0]->to_date;
				// $contract_type_id = $user[0]->contract_type_id;
				// $waktu_kontrak = $user[0]->waktu_kontrak;
				// $posisi = $user[0]->posisi;
				// $project = $user[0]->project;
				// $penempatan = $user[0]->penempatan;
				// $hari_kerja = $user[0]->hari_kerja; 
				// $basic_pay = $user[0]->basic_pay;
				// $allowance_meal = $user[0]->allowance_meal;
				// $allowance_transport = $user[0]->allowance_transport;
				// $allowance_bbm = $user[0]->allowance_bbm;
				// $allowance_pulsa = $user[0]->allowance_pulsa;
				// $allowance_rent = $user[0]->allowance_rent;
				// $allowance_grade = $user[0]->allowance_grade;
				// $allowance_laptop = $user[0]->allowance_laptop;
				// $tgl_payment = $user[0]->tgl_payment;
				// $start_period_payment = $user[0]->start_period_payment;
				// $end_period_payment = $user[0]->end_period_payment;

				$data = array(
					'no_surat' => $no_surat,
					'no_spb' => $no_spb,
					// 'employee_id' => $employee_id,
					// 'from_date' => $from_date,
					// 'to_date' => $to_date,
					// 'contract_type_id' => $contract_type_id,
					// 'waktu_kontrak' => $waktu_kontrak,
					// 'posisi' => $posisi,
					// 'project' => $project,
					// 'penempatan' => $penempatan,
					// 'hari_kerja' => $hari_kerja,
					// 'basic_pay' => $basic_pay,
					// 'allowance_meal' => $allowance_meal,
					// 'allowance_transport' => $allowance_transport,
					// 'allowance_bbm' => $allowance_bbm,
					// 'allowance_pulsa' => $allowance_pulsa,
					// 'allowance_rent' => $allowance_rent,
					// 'allowance_grade' => $allowance_grade,
					// 'allowance_laptop' => $allowance_laptop,
					// 'tgl_payment' => $tgl_payment,
					// 'start_period_payment' => $start_period_payment,
					// 'end_period_payment' => $end_period_payment,
					// 'status_pkwt' => 1,
					// 'status_approve' => 1,
					// 'createdby' => $session['employee_id'],
				);

						//$id = $this->input->post('user_id');
						$this->Pkwt_model->add($data);

						$datas = array(
							'status_error' => 'Success Import',
						);

						// $this->Employees_model->update_error_temp($datas, $user[0]->secid);
						$this->Pkwt_model->update_error_temp($datas, $pkwt[0]->secid);

		}

				//$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
				echo $user[0]->no_surat.' '.$this->lang->line('xin_employee_status_updated');

			}
	}

} 
?>
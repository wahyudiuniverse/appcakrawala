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

class Esign extends MY_Controller {
	
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
		$this->load->model("Pkwt_model");
		$this->load->model("Location_model");
		$this->load->model("Xin_model");
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
		$data['title'] = $this->lang->line('xin_esign_register').' | '.$this->Xin_model->site_title();
		$data['all_locations'] = $this->Xin_model->all_locations();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$session = $this->session->userdata('username');
		$data['breadcrumbs'] = $this->lang->line('xin_esign_register');
		$data['path_url'] = 'esign';
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('478',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/esign/esign_list", $data, TRUE);
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
			$this->load->view("admin/esign/esign_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$esign = $this->Pkwt_model->get_esign_all();
		$data = array();

          foreach($esign->result() as $r) {
			  
			$jenis_doc = $r->jenis_dokumen;
			$nomor_dokumen = $r->nomor_dokumen;
			$createdat = $this->Xin_model->tgl_indo(substr($r->createdat,0,10));
			// // get user > head
			// $head_user = $this->Xin_model->read_user_info($r->employee_id);
			// // user full name
			if($jenis_doc==1){
				$jdoc = 'PKWT';
			} else if ($jenis_doc==2) {
				$jdoc = 'PAKLARING';	
			} else {
				$jdoc = '--';	
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
			if(in_array('478',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->secid . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('478',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->secid . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			// $ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $edit.$delete;
			  
		   $data[] = array(
				$combhr,
				$jdoc,
				$nomor_dokumen,
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
		$image_name='esign'.date('ymdHis').'.png'; //buat name dari qr code sesuai dengan nim
		$domain = 'https://apps-cakrawala.com/esign/doc/'.$docid;
		$params['data'] = $domain; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$data = array(
		'doc_id' => $docid,
		'jenis_dokumen' => $this->input->post('jenis_dokumen'),
		'nomor_dokumen' => $this->input->post('nomordoc'),
		'nip_ttd' => $this->input->post('manag_sign'),
		'qr_code' => $image_name,
		'createdby' => 1,
		);

		// $data = $this->security->xss_clean($data);
		$result = $this->Pkwt_model->addsign($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_department');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
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
				$result = $this->Pkwt_model->delete_sign_doc($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('xin_success_delete_department');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
			}
		}
	}
}

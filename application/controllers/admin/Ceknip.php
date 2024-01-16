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

class ceknip extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Location_model");
		$this->load->model("Department_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'CEK NIP';
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = "CEK NIP";
		$data['path_url'] = 'cek_nip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('134',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/ceknip/nip_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
 
  public function nip_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/location/location_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$location = $this->Employees_model->get_employees_who();
			// $location = $this->Location_model->get_locations();
		} else {
			// $location = $this->Location_model->get_company_office_location($user_info[0]->company_id);
			$location = $this->Employees_model->get_employees_notho();
		}


		$data = array();

          foreach($location->result() as $r) {
			  
			  $full_name = $r->first_name;
			  $nik = $r->ktp_no;
			  $ename = '<a href="'.site_url().'admin/employees/emp_edit/'.$r->employee_id.'" class="d-block text-primary" target="_blank">'.$r->employee_id.'</a>'; 

				if(!is_null($r->private_code)){
					$pin = $r->private_code;
				} else {
					$pin = '--';	
				}
				
							if($r->user_role_id==2){
								$role = '['.$r->user_role_id.'] '.'Employee';
							} else if ($r->user_role_id==3) {
								$role = '['.$r->user_role_id.'] '.'HRD Admin';
							} else if ($r->user_role_id==4){
								$role = '['.$r->user_role_id.'] '.'HRD Admin';
							} else if ($r->user_role_id==8){
								$role = '['.$r->user_role_id.'] '.'NAE/ADMIN';
							} else if ($r->user_role_id==9){
								$role = '['.$r->user_role_id.'] '.'RESIGN';
							} else if ($r->user_role_id==10){
								$role = '['.$r->user_role_id.'] '.'PAYROLL ADMIN';
							} else if ($r->user_role_id==11){
								$role = '['.$r->user_role_id.'] '.'IT SUPPORT';
							} else if ($r->user_role_id==12){
								$role = '['.$r->user_role_id.'] '.'HEAD OF PAYROLL';
							} else if ($r->user_role_id==13){
								$role = '['.$r->user_role_id.'] '.'NOM';
							} else if ($r->user_role_id==14){
								$role = '['.$r->user_role_id.'] '.'TEAM LEADER';
							} else if ($r->user_role_id==15){
								$role = '['.$r->user_role_id.'] '.'BPJS ADMIN';
							} else if ($r->user_role_id==16){
								$role = '['.$r->user_role_id.'] '.'AREA MANAGER';
							} else {
								$role = $r->user_role_id;
							}

							$copypaste = '*C.I.S -> Employees Registration.*%0a%0a
							Nama Lengkap: *'.$full_name.'*%0a
							NIP: *'.$r->employee_id.'*%0a
							PIN: *'.$pin.'*%0a
							PROJECT: *'.$pin.'* %0a%0a

							Silahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.%0a
							Link C.I.S : https://apps-cakrawala.com/admin%0a

							Lakukan Pembaharuan PIN anda secara berkala, dengan cara, Pilih Menu *My Profile* kemudian *Ubah Pin*%0a%0a

							*INFO HRD di Nomor Whatsapp: 085175168275* %0a
							*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a
							
							Terima kasih.';

							$whatsapp = '<a href="https://wa.me/62'.$r->contact_no.'?text='.$copypaste.'" class="d-block text-primary" target="_blank"> <button type="button" class="btn btn-xs btn-outline-success">'.$r->contact_no.'</button> </a>';



               $data[] = array(
			   				$ename,
                $nik,
								$full_name,
								$whatsapp,
								$role
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $location->num_rows(),
                 "recordsFiltered" => $location->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }
	
}

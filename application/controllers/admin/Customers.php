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

class Customers extends MY_Controller 
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
		  $this->load->model('Xin_model');
			$this->load->model("Roles_model");
      $this->load->model('Company_model');
			$this->load->model("Employees_model");
			$this->load->model("Customers_model");

		  // $this->load->model("Project_model");
		  // $this->load->model("Tax_model");
		  // $this->load->model("Invoices_model");
		  // $this->load->model("Clients_model");
		  // $this->load->model("Finance_model");
			// $this->load->model("Department_model");
			// $this->load->model("Designation_model");
			// $this->load->model("Location_model");
			// $this->load->model("City_model");
			// $this->load->model("Contracts_model");
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
		$data['title'] = $this->lang->line('left_customer').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_customer');
		$data['all_customers'] = $this->Customers_model->get_customers();
		// $data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'customers';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('69',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/customers/customers_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	public function customers_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/customers/customers_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$client = $this->Customers_model->get_customers();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

    foreach($client->result() as $r) {
			  
			  $id_customer = $r->customer_id;
			  $name_cust = $r->customer_name;
			  $address = $r->address;
			  $latitude = $r->latitude;
			  $longitude = $r->longitude;
			  // $city_id = $r->city_id;
			  // $nik = $r->username;
			  // $fullname = $r->first_name.' '.$r->last_name;


				$now = new DateTime(date("Y-m-d"));


			// 	$village = $this->Customers_model->read_village($r->village_id);
			// 	if(!is_null($village)){
			// 		$vilage_name = $village[0]->name;
			// 	} else {
			// 		$vilage_name = '--';	
			// 	}

			// 	$district = $this->Customers_model->read_kecamatan($r->district_id);
			// 	if(!is_null($district)){
			// 		$district_name = $district[0]->name;
			// 	} else {
			// 		$district_name = '--';	
			// 	}

			// 	$city = $this->Customers_model->read_city($r->city_id);
			// 	if(!is_null($city)){
			// 		$city_name = $city[0]->name;
			// 	} else {
			// 		$city_name = '--';	
			// 	}



			// 	$coordinate ='

			// 	<div class="text-success small text-truncate">
			// 		<a href="#" class="" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_cust_latitude').'">Lat : '.$latitude.'

			// 		</a>
			// 	</div>

			// 	<div class="text-success small text-truncate">
			// 		<a href="#" class="" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_cust_longitude').'">Lon: '.$longitude.'

			// 		</a>
			// 	</div>';



			//   if(in_array('38',$role_resources_ids)) { //edit
			// 	$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><a href="#"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
			// } else {
			// 	$edit = '';
			// }


			// if(in_array('34',$role_resources_ids)) { //view
			// 	$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="#" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// } else {
			// 	$view = '';
			// }

			// $combhr = $edit.$view;

		   $data[] = array(
				'$id_customer',
				'$name_cust',
				'$address',
				'ucwords(strtolower($vilage_name))',
				'ucwords(strtolower($district_name))',
				'ucwords(strtolower($city_name))',
				'$coordinate',
				'$combhr',
				// $this->Xin_model->tgl_indo($end),
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $client->num_rows(),
                 "recordsFiltered" => $client->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }
} 
?>
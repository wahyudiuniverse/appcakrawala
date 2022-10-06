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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eslip extends MY_Controller
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
		  $this->load->model("Project_model");
		  $this->load->model("Employees_model");
		  $this->load->model("Invoices_model");
		  $this->load->model("Clients_model");
		  $this->load->model("Finance_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_eslip').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_eslip');
		$data['all_projects'] = $this->Project_model->get_projects();
		// $data['path_url'] = 'hrpremium_invoices';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/eslip/eslip_status", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		// } else {
		// 	redirect('admin/dashboard');
		// }
	}

	 // invoice payment list
	public function invoice_payment_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("client/invoices/invoice_payment_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$transaction = $this->Invoices_model->get_client_invoice_payments_all();
		
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			$cr_dr = $r->dr_cr=="dr" ? "Debit" : "Credit";
			
			$invoice_info = $this->Invoices_model->read_invoice_info($r->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = $invoice_info[0]->invoice_number;
			} else {
				$inv_no = '--';	
			}
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}	
			// payment method 
			$clientinfo = $this->Clients_model->read_client_info($r->client_id);
			if(!is_null($clientinfo)){
				$name_name = $clientinfo[0]->name;
			} else {
				$name_name = '--';	
			}
			
			$invoice_number = '<a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/">'.$inv_no.'</a>';					
			$data[] = array(
				$invoice_number,
				$name_name,
				$transaction_date,
				$total_amount,
				$method_name,
				$r->description
			);
		  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transaction->num_rows(),
                 "recordsFiltered" => $transaction->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }


	

} 
?>
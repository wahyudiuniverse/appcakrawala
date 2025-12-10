<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('url_helper');
		$this->load->helper('html');
		$this->load->database();
		$this->load->helper('security');
		$this->load->library('form_validation');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function index()
	{

		$data['all_company'] = $this->Registrasi_model->getAllCompany();
		$data['all_project'] = $this->Registrasi_model->getAllProject();
		$data['all_jabatan'] = $this->Registrasi_model->getAllJabatan();
		$data['all_provinsi'] = $this->Registrasi_model->getAllProvinsi();
		$data['all_sumber_info'] = $this->Registrasi_model->get_all_sumber_info();
		$data['all_interviewer'] = $this->Registrasi_model->get_all_interviewer();
		$data['all_family_relation'] = $this->Registrasi_model->getAllFamilyRelation();

		$this->load->view('registrasi', $data);
	}




	function upload_dokumen()
	{
		$postData = $this->input->post();
		$image = $_FILES;
		$return_file_data = array();
		foreach ($image as $key => $img) {
			$ext = pathinfo($img['name'], PATHINFO_EXTENSION);
			$name = pathinfo($img['name'], PATHINFO_FILENAME);
			$yearmonth = date('Y/m/');
			if ($postData['identifier'] == "cis_pkwt") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document/pkwt/' . $yearmonth)) {
					mkdir('./uploads/document/pkwt/' . $yearmonth, 0777, TRUE);
				}
				if (!empty($img['name'])) {
					
						$config['upload_path'] 		= './uploads/document/pkwt/' . $yearmonth;
						$config['allowed_types'] 	= '*';
						$config['overwrite'] 		= TRUE;
						$config['file_name'] 		= "cis_kontrak_" . $postData['nama_client'];

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if (!$this->upload->do_upload($key)) {
							$error = array('error' => $this->upload->display_errors());
							print_r($error);
							die;
						} else {
							$nama_file = $this->upload->data('file_name');
							$path_file = 'https://apps-cakrawala.com/uploads/document/pkwt/' . $yearmonth;
							$file_data = $path_file . $nama_file;
							$return_file_data[] = array(
								"link_file" => $file_data,
							);
							// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
						}
					
				}
			} else if ($postData['identifier'] == "npwp_client") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/npwp client/')) {
					mkdir('./uploads/document_eksternal/npwp client/', 0777, TRUE);
				}
				if (!empty($img['name'])) {
					$config['upload_path'] 		= './uploads/document_eksternal/npwp client/';
					$config['allowed_types'] 	= '*';
					$config['overwrite'] 		= TRUE;
					$config['file_name'] 		= "npwp_client_" . $postData['nama_client'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						$path_file = base_url() . 'uploads/document_eksternal/npwp client/';
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			} else if ($postData['identifier'] == "pks_project") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/pks_project/')) {
					mkdir('./uploads/document_eksternal/pks_project/', 0777, TRUE);
				}
				if (!empty($img['name'])) {
					$config['upload_path'] = './uploads/document_eksternal/pks_project/';
					$config['allowed_types'] = '*';
					// $config['max_size'] = '100'; 
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$config['overwrite'] = TRUE;
					// $config['file_name'] = $name . '_' . $postData['project_name'] . '_' . time();
					$config['file_name'] = "pks_project_" . $postData['nama_project'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						// $nama_file = preg_replace('/\s+/', '_', $nama_file);
						// $nama_file = "pks_project_" . $postData['nama_project'];
						$path_file = base_url() . 'uploads/document_eksternal/pks_project/';
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			} else if ($postData['identifier'] == "mou_project") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/mou_project/')) {
					mkdir('./uploads/document_eksternal/mou_project/', 0777, TRUE);
				}
				if (!empty($img['name'])) {
					$config['upload_path'] = './uploads/document_eksternal/mou_project/';
					$config['allowed_types'] = '*';
					// $config['max_size'] = '100'; 
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$config['overwrite'] = TRUE;
					// $config['file_name'] = $name . '_' . $postData['project_name'] . '_' . time();
					$config['file_name'] = "mou_project_" . $postData['nama_project'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						// $nama_file = "mou_project_" . $postData['nama_project'];
						$path_file = base_url() . 'uploads/document_eksternal/mou_project/';
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			} else if ($postData['identifier'] == "ratecard_project") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/ratecard_project/')) {
					mkdir('./uploads/document_eksternal/ratecard_project/', 0777, TRUE);
				}
				if (!empty($img['name'])) {
					$config['upload_path'] = './uploads/document_eksternal/ratecard_project/';
					$config['allowed_types'] = '*';
					// $config['max_size'] = '100'; 
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$config['overwrite'] = TRUE;
					// $config['file_name'] = $name . '_' . $postData['project_name'] . '_' . time();
					$config['file_name'] = "ratecard_project_" . $postData['nama_project'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						// $nama_file = "ratecard_project_" . $postData['nama_project'];
						$path_file = base_url() . 'uploads/document_eksternal/ratecard_project/';
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			} else if ($postData['identifier'] == "cis_exitclear") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/cis_exitclear/'. $yearmonth)) {
					mkdir('./uploads/document_eksternal/cis_exitclear/'. $yearmonth, 0777, TRUE);
				}
				
				if (!empty($img['name'])) {
					$config['upload_path'] = './uploads/document_eksternal/cis_exitclear/'. $yearmonth;
					$config['allowed_types'] = '*';
					// $config['max_size'] = '100'; 
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$config['overwrite'] = TRUE;
					// $config['file_name'] = $name . '_' . $postData['project_name'] . '_' . time();
					$config['file_name'] = "cis_exitclear_" . $postData['nama_client'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						// $nama_file = "npwp_client_" . $postData['nama_client'];
						$path_file = base_url() . 'uploads/document_eksternal/cis_exitclear/'. $yearmonth;
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			} else if ($postData['identifier'] == "cis_resign") {
				$yearmonth = date('Y/m/');
				if (!is_dir('./uploads/document_eksternal/cis_resign/'. $yearmonth)) {
					mkdir('./uploads/document_eksternal/cis_resign/'. $yearmonth, 0777, TRUE);
				}
				if (!empty($img['name'])) {
					$config['upload_path'] = './uploads/document_eksternal/cis_resign/'. $yearmonth;
					$config['allowed_types'] = '*';
					// $config['max_size'] = '100'; 
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$config['overwrite'] = TRUE;
					// $config['file_name'] = $name . '_' . $postData['project_name'] . '_' . time();
					$config['file_name'] = "cis_resign_" . $postData['nama_client'];

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						die;
					} else {
						$nama_file = $this->upload->data('file_name');
						// $nama_file = "npwp_client_" . $postData['nama_client'];
						$path_file = base_url() . 'uploads/document_eksternal/cis_resign/'. $yearmonth;
						$file_data = $path_file . $nama_file;
						$return_file_data[] = array(
							"link_file" => $file_data,
						);
						// $this->Registrasi_model->save_dokumen($file_data, $postData['id_kandidat'], $name);
					}
				}
			}
		}
		// $this->load->view('imgtest');
		echo json_encode($return_file_data);
		// return $return_file_data;
	}


}

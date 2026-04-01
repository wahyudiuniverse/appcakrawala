<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Saltab_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_ratecard_by_project_sub($project_id, $sub_project_id)
	{
		$this->db->select('*');
		$this->db->from('xin_ratecad_header');
		$this->db->where('project_id', $project_id);
		$this->db->where('sub_project_id', $sub_project_id);
		$this->db->order_by('periode_start', 'desc');

		$query = $this->db->get()->row_array();

		return $query;
	}

	function get_ratecard_detail_by_id($id_ratecard)
	{
		$this->db->select('*');
		$this->db->from('xin_ratecad_detail');
		$this->db->where('id_ratecard_header', $id_ratecard);

		$query = $this->db->get()->result_array();

		return $query;
	}

	function get_ratecard_detail_custom($id_ratecard, $custom)
	{
		$this->db->select('*');
		$this->db->from('xin_ratecad_detail');
		$this->db->where('id_ratecard_header', $id_ratecard);
		$this->db->where($custom);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function get_list_detail_absensi($id_batch = null)
	{
		## Kondisi Default 
		$kondisiDefaultQuery = "(
			id_absensi_header = " . $id_batch . "
		)";
		//$kondisiDefaultQuery = "";

		## Fetch records
		$this->db->select('xin_absensi_detail.*');
		$this->db->select('xin_designations.designation_name as jabatan_name');
		$this->db->select('kabupaten_kota.nama as kota_kabupaten');
		$this->db->where($kondisiDefaultQuery);
		$this->db->join('xin_designations', 'xin_absensi_detail.id_jabatan = xin_designations.designation_id');
		$this->db->join('kabupaten_kota', 'xin_absensi_detail.id_area = kabupaten_kota.id_kab_kota_bps');
		$records = $this->db->get('xin_absensi_detail')->result_array();

		return $records;
	}

	function get_tabel_perhitungan($project_id, $sub_project_id)
	{
		$this->db->select('*');
		$this->db->from('xin_saltab_hitung');
		$this->db->where('project_id', $project_id);
		$this->db->where('sub_project_id', $sub_project_id);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function get_fungsi_perhitungan($id_hitung_master)
	{
		$this->db->select('*');
		$this->db->from('xin_saltab_hitung_master');
		$this->db->where('id', $id_hitung_master);

		$query = $this->db->get()->row_array(); //nama_fungsi

		if (empty($query)) {
			return "";
		} else return $query['nama_fungsi'];
	}

	function get_perbandingan_mpp_absensi_saltab_temp($id_saltab_temp, $id_absensi)
	{
		$this->db->select('mpp');
		$this->db->from('xin_absensi_header');
		$this->db->where('id', $id_absensi);

		$query_absensi = $this->db->get()->row_array(); //nama_fungsi

		if (empty($query_absensi)) {
			return "";
		} else {
			$this->db->select('total_mpp');
			$this->db->from('xin_saltab_bulk');
			$this->db->where('id', $id_saltab_temp);

			$query_saltab = $this->db->get()->row_array(); //nama_fungsi
			if (empty($query_saltab)) {
				return "";
			} else {
				if ((int)$query_saltab['total_mpp'] == (int)$query_absensi['mpp']) {
					$html_font = "<font style='color: rgb(23, 124, 38);'>";
				} else {
					$html_font = "<font style='color: rgba(133, 15, 15, 1);'>";
				}
				return $html_font . "<strong>[ Progress " . (((float)$query_saltab['total_mpp'] / (float)$query_absensi['mpp']) * 100) . " % ]</br>Berhasil hitung " . $query_saltab['total_mpp'] . " mpp dari total " . $query_absensi['mpp'] . " mpp</strong></font>";
			}
		}
	}

	function create_saltab_header_temp($data_batch_absensi)
	{
		$session = $this->session->userdata('username');
		$nip = $session['employee_id'];

		$data_insert = array(
			"id_absensi" 			=> $data_batch_absensi['id'],
			"periode_cutoff_from" 	=> $data_batch_absensi['saltab_from'],
			"periode_cutoff_to" 	=> $data_batch_absensi['saltab_to'],
			"periode_salary" 		=> $data_batch_absensi['periode_salary'],
			"project_id" 			=> $data_batch_absensi['project_id'],
			"project_name" 			=> $data_batch_absensi['project_name'],
			"sub_project_id" 		=> $data_batch_absensi['sub_project_id'],
			"sub_project_name" 		=> $data_batch_absensi['sub_project_name'],
			"fee" 					=> $data_batch_absensi['fee'],

			'upload_by_id'      	=> $nip,
			'upload_by'      		=> $this->Import_model->get_nama_karyawan($nip),
			'upload_on'      		=> date('Y-m-d H:i:s'),
			'upload_ip'        	 	=> $this->get_client_ip(),
		);

		$this->db->insert('xin_saltab_bulk', $data_insert);

		$id_saltab_header = $this->db->insert_id();

		$this->db->select('*');
		$this->db->from('xin_saltab_bulk');
		$this->db->where('id', $id_saltab_header);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function get_saltab_header_temp($id_saltab_header)
	{
		$this->db->select('*');
		$this->db->from('xin_saltab_bulk');
		$this->db->where('id', $id_saltab_header);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function create_saltab_detail_temp($data_batch_absensi, $data_absensi, $id_header_saltab)
	{
		$data_insert = array(
			"uploadid" => $id_header_saltab,
			"nik" => $data_absensi['nik'],
			"nip" => $data_absensi['nip'],
			"fullname" => $data_absensi['fullname'],
			"sub_project" => $data_batch_absensi['sub_project_name'],
			"jabatan" => $data_absensi['jabatan_name'],
			"region" => $data_absensi['region'],
			"area" => $data_absensi['kota_kabupaten'],
			"hari_kerja" => $data_absensi['hk_actual'],
			"status_emp" => $data_absensi['status_emp'],
		);

		$this->db->insert('xin_saltab_temp', $data_insert);

		$id_saltab_detail = $this->db->insert_id();

		$this->db->select('*');
		$this->db->from('xin_saltab_temp');
		$this->db->where('secid', $id_saltab_detail);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function update_data_absensi_record($data_update, $id_absensi_detail)
	{
		// $data_update = array(
		// 	"gaji_diterima" => $data_detail_ratecard['gaji_pokok'],
		// );

		$this->db->where('id', $id_absensi_detail);
		if ($this->db->update('xin_absensi_detail', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	function update_data_header_saltab($data_update, $id_header_saltab)
	{
		// $data_update = array(
		// 	"gaji_diterima" => $data_detail_ratecard['gaji_pokok'],
		// );

		$this->db->where('id', $id_header_saltab);
		if ($this->db->update('xin_saltab_bulk', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	function get_data_detail_saltab($id_detail_saltab)
	{
		$this->db->select('*');
		$this->db->from('xin_saltab_temp');
		$this->db->where('secid', $id_detail_saltab);

		$query = $this->db->get()->row_array();

		return $query;
	}

	function update_data_detail_saltab($data_update, $id_detail_saltab)
	{
		// $data_update = array(
		// 	"gaji_diterima" => $data_detail_ratecard['gaji_pokok'],
		// );

		$this->db->where('secid', $id_detail_saltab);
		if ($this->db->update('xin_saltab_temp', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	function update_data_header_absensi($data_update, $id_header_absensi)
	{
		// $data_update = array(
		// 	"gaji_diterima" => $data_detail_ratecard['gaji_pokok'],
		// );

		$this->db->where('id', $id_header_absensi);
		if ($this->db->update('xin_absensi_header', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to get the client IP address
	function get_client_ip()
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	// function gaji_diterima($data_absensi_json, $data_batch_ratecard_json, $id_detail_saltab)
	function gaji_diterima($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		//hitung gaji diterima
		if ((strtoupper($data_detail_ratecard['periode_gaji_pokok']) == "MONTH") || (strtoupper($data_detail_ratecard['periode_gaji_pokok']) == "BULAN")) {
			//cek hk actual vs target
			if ($data_absensi['hk_actual'] < $data_absensi['hk_target']) {
				$gaji_diterima = ($data_absensi['hk_actual'] / $data_absensi['hk_target']) * $data_detail_ratecard['gaji_pokok'];
			} else {
				$gaji_diterima = $data_detail_ratecard['gaji_pokok'];
			}
		} else {
			$gaji_diterima = $data_absensi['hk_actual'] * $data_detail_ratecard['gaji_pokok'];
		}

		$data_update = array(
			"gaji_umk" => $data_detail_ratecard['umk'],
			"gaji_umk_baru" => $data_detail_ratecard['umk'],
			"gaji_pokok" => $data_detail_ratecard['gaji_pokok'],
			"gaji_diterima" => round($gaji_diterima),
		);

		$this->db->where('secid', $id_detail_saltab);
		if ($this->db->update('xin_saltab_temp', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	function allow_konsumsi($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$allow_konsumsi = $data_absensi['hk_allowance'] * $data_detail_ratecard['allow_makan'];

		$data_update = array(
			"allow_konsumsi" => round($allow_konsumsi),
		);

		$this->db->where('secid', $id_detail_saltab);
		if ($this->db->update('xin_saltab_temp', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	function allow_transport($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$allow_transport = $data_absensi['hk_allowance'] * $data_detail_ratecard['allow_transport'];

		$data_update = array(
			"allow_transport" => round($allow_transport),
		);

		$this->db->where('secid', $id_detail_saltab);
		if ($this->db->update('xin_saltab_temp', $data_update)) {
			return true;
		} else {
			return false;
		}
	}

	//total 1
	function total_1($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			//perhitungan total 1 (gaji diterima + total allowance + pendapatan tidak teratur - deduction)
			$gaji_diterima = $data_detail_saltab['gaji_diterima'];
			$total_allowance =
				$data_detail_saltab['allow_jabatan']
				+ $data_detail_saltab['allow_keahlian']
				+ $data_detail_saltab['allow_area']
				+ $data_detail_saltab['allow_masakerja']
				+ $data_detail_saltab['allow_konsumsi']
				+ $data_detail_saltab['allow_transport']
				+ $data_detail_saltab['allow_rent']
				+ $data_detail_saltab['allow_comunication']
				+ $data_detail_saltab['allow_parking']
				+ $data_detail_saltab['allow_residence_cost']
				+ $data_detail_saltab['allow_akomodasi']
				+ $data_detail_saltab['allow_device']
				+ $data_detail_saltab['allow_kasir']
				+ $data_detail_saltab['allow_trans_meal']
				+ $data_detail_saltab['allow_trans_rent']
				+ $data_detail_saltab['allow_medicine']
				+ $data_detail_saltab['allow_grooming']
				+ $data_detail_saltab['allow_kehadiran']
				+ $data_detail_saltab['allow_operation']
				+ $data_detail_saltab['allow_pelatihan']
				+ $data_detail_saltab['allow_kinerja']
				+ $data_detail_saltab['allow_disiplin']
				+ $data_detail_saltab['allow_others']
				+ $data_detail_saltab['allow_pph'];
			$pendapatan_tidak_teratur = $data_detail_saltab['total_pendapatan_tidak_teratur'];
			$deduction = $data_detail_saltab['deduction_bruto'];

			$total_1 = $gaji_diterima + $total_allowance + $pendapatan_tidak_teratur - $deduction;

			$data_update = array(
				"total_1" => round($total_1),
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//bpjs deduction
	function bpjs_deduction($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			$gaji_pokok = $data_detail_saltab['gaji_pokok'];
			$umk_baru = $data_detail_saltab['gaji_umk_baru'];

			//perhitungan bpjs dan jaminan pensiun
			$bpjs_tk_jkk_jkm = ($gaji_pokok * 0.54) / 100;
			$bpjs_tk_jht = ($gaji_pokok * 3.70) / 100;
			$bpjs_ks = ($gaji_pokok * 4) / 100;
			$jaminan_pensiun = ($gaji_pokok * 2) / 100;

			$data_update = array(
				"bpjs_tk_deduction_jkk_jkm" => round($bpjs_tk_jkk_jkm),
				"bpjs_tk_deduction_jht" => round($bpjs_tk_jht),
				"bpjs_ks_deduction" => round($bpjs_ks),
				"jaminan_pensiun_deduction" => round($jaminan_pensiun),
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//total 2
	function total_2($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			//perhitungan total 2 (total 1 + bpjs_tk_jkk_jkm + bpjs_tk_jht + bpjs_ks + jaminan_pensiun)
			$total_1 = $data_detail_saltab['total_1'];
			$bpjs_tk_jkk_jkm = $data_detail_saltab['bpjs_tk_deduction_jkk_jkm'];
			$bpjs_tk_jht = $data_detail_saltab['bpjs_tk_deduction_jht'];
			$bpjs_ks = $data_detail_saltab['bpjs_ks_deduction'];
			$jaminan_pensiun = $data_detail_saltab['jaminan_pensiun_deduction'];

			$total_2 = $total_1 + $bpjs_tk_jkk_jkm + $bpjs_tk_jht + $bpjs_ks + $jaminan_pensiun;

			$data_update = array(
				"total_2" => round($total_2),
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//bpjs deduction thp
	function bpjs_deduction_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			$gaji_pokok = $data_detail_saltab['gaji_pokok'];
			$umk_baru = $data_detail_saltab['gaji_umk_baru'];

			//perhitungan bpjs dan jaminan pensiun
			$bpjs_tk = ($gaji_pokok * 2) / 100;
			$bpjs_ks = ($gaji_pokok * 1) / 100;
			$jaminan_pensiun = ($gaji_pokok * 1) / 100;

			$data_update = array(
				"bpjs_tk" => round($bpjs_tk),
				"bpjs_ks" => round($bpjs_ks),
				"jaminan_pensiun" => round($jaminan_pensiun),
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//pph 21
	function pph_21($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			$pendapatan_tidak_teratur = $data_detail_saltab['total_pendapatan_tidak_teratur'];
			$total_1 = $data_detail_saltab['total_1'];
			$pendapatan_teratur = $total_1 - $pendapatan_tidak_teratur;
			$gaji_pokok = $data_detail_saltab['gaji_pokok'];

			//perhitungan bpjs dan jaminan pensiun
			$jkk = ($gaji_pokok * 0.24) / 100;
			$jkm = ($gaji_pokok * 0.30) / 100;
			$kesehatan = ($gaji_pokok * 4) / 100;

			$total_pendapatan_bruto = round($pendapatan_teratur) + round($jkk) + round($jkm) + round($kesehatan);
			$bruto_inclcude_pendapatan_tidak_teratur = $total_pendapatan_bruto + $pendapatan_tidak_teratur;

			$persentasi_ter = 1;

			$pph_bulan_ini = ($bruto_inclcude_pendapatan_tidak_teratur * $persentasi_ter) / 100;

			$data_update = array(
				"pph_21" => round($pph_bulan_ini),
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//total thp
	function total_thp($data_absensi, $data_detail_ratecard, $id_detail_saltab)
	{
		$data_detail_saltab = $this->get_data_detail_saltab($id_detail_saltab);

		if (empty($data_detail_saltab)) {
			return false;
		} else {
			$total_1 = $data_detail_saltab['total_1'];
			$bpjs_tk = $data_detail_saltab['bpjs_tk'];
			$bpjs_ks = $data_detail_saltab['bpjs_ks'];
			$jaminan_pensiun = $data_detail_saltab['jaminan_pensiun'];
			$pph_21 = $data_detail_saltab['pph_21'];
			$deduction = $data_detail_saltab['deduction'];
			$adjustment = $data_detail_saltab['adjustment'];

			$total_thp = $total_1 - $bpjs_tk - $bpjs_ks - $jaminan_pensiun - $pph_21 - $deduction + $adjustment;

			$data_update = array(
				"total_thp" => $total_thp,
			);

			$this->db->where('secid', $id_detail_saltab);
			if ($this->db->update('xin_saltab_temp', $data_update)) {
				return true;
			} else {
				return false;
			}
		}
	}
}

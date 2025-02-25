<?php

class Register_model extends CI_model
{
    //mengambil semua data employee
    public function getAllEmployees()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('xin_employee_request')->result_array();

        return $query;
    }

    //ambil data employee berdasarkan NIK
    public function getAllEmployeesByNIK($nik)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_employee_request');
        $this->db->where('nik_ktp', $nik);

        $query = $this->db->get()->row_array();

        return $query;
    }

    //ambil data employee berdasarkan NIK dari table employee
    public function getDataEmployee($nik)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_employees');
        $this->db->where('ktp_no', $nik);
        $this->db->order_by('user_id', 'DESC');
        $this->db->limit('1');

        $query = $this->db->get()->row_array();

        //print_r($this->db->last_query());

        return $query;
    }

    //ambil data employee berdasarkan id (secid)
    public function getAllEmployeesById($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_employee_request');
        $this->db->where('secid', $id);

        $query = $this->db->get()->row_array();

        return $query;
    }

    //buat data baru hanya berisi NIK
    public function createEmployee($nik)
    {
        //Input untuk Database
        $datakaryawan = [
            "nik_ktp"                 => $nik
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->insert('xin_employee_request', $datakaryawan);
    }

    //mengambil data perusahaan
    public function getAllCompany()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('xin_companies')->result_array();

        return $query;
    }

    //mengisi company untuk data baru
    public function isiCompany($id, $cid)
    {
        //Input untuk Database
        $datakaryawan = [
            "company_id"                 => $cid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //ambil data project berdasarkan company
    public function getProjectByCompany($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->distinct("(" . 'pp.project_id' . ")");

        $this->db->select('pp.project_id,CONCAT(("[ "),npro.priority, (" ] "), npro.title) title');

        $this->db->from('xin_projects_posisi pp');

        $this->db->join('xin_projects npro', 'npro.project_id=pp.project_id', 'left');

        $this->db->where('npro.company_id', $id);
        $this->db->where('npro.doc_id', '1');

        //$otherdb->group_by('xin_projects_posisi.project_id');
        $this->db->order_by('title', 'ASC');

        //$query = $otherdb->query('SELECT distinct(pp.project_id), CONCAT('[ ',npro.priority,' ] ',npro.title) title FROM xin_projects_posisi pp LEFT JOIN xin_projects npro ON npro.project_id = pp.project_id WHERE company_id = '2' AND npro.doc_id=1 ORDER BY title ASC');

        $query = $this->db->get()->result_array();

        //return $query->result_array();
        //print_r($otherdb->last_query());
        return $query;
    }

    //ambil data sub project berdasarkan project
    public function getSubByProject($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_projects_sub');
        $this->db->where('id_project', $id);

        $query = $this->db->get()->result_array();

        return $query;
    }

    //ambil data sub project berdasarkan project untuk Json
    public function getSubByProjectJson($postData)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_projects_sub');
        $this->db->where('id_project', $postData['project']);
        $this->db->where('sub_active', '1');

        $query = $this->db->get()->result_array();

        return $query;
    }

    //ambil data sub project berdasarkan project untuk Json
    public function getSubByProjectJsonTes($postData)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_projects_sub');
        $this->db->where('id_project', $postData);

        $query = $this->db->get()->result_array();

        return $query;
    }

    //ambil data jabatan berdasarkan project
    public function getJabatanByProject($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_projects_posisi');
        $this->db->join('xin_designations', 'xin_designations.designation_id=xin_projects_posisi.posisi');
        $this->db->where('sub_project', $id);

        $query = $this->db->get()->result_array();

        return $query;
    }

    //ambil data jabatan berdasarkan project untuk Json
    public function getJabatanByProjectJson($postData)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_projects_posisi');
        $this->db->join('xin_designations', 'xin_designations.designation_id=xin_projects_posisi.posisi');
        $this->db->where('sub_project', $postData['sproject']);

        $query = $this->db->get()->result_array();

        return $query;
    }

    //mengisi project untuk data baru
    public function isiProject($id, $data)
    {
        //Input untuk Database
        $datakaryawan = [
            "project"                => $data['project'],
            "sub_project"            => $data['sub_project'],
            "posisi"                 => $data['jabatan'],
            "penempatan"             => $data['penempatan']
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengambil semua Agama
    public function getAllAgama()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('xin_ethnicity_type')->result_array();

        return $query;
    }

    //mengambil semua status perkawinan
    public function getAllMarital()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('mt_marital')->result_array();

        return $query;
    }

    //mengambil semua status pendidikan
    public function getAllEducationLevel()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('xin_qualification_education_level')->result_array();

        return $query;
    }

    //mengambil nama bank
    public function getAllBank()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('mt_bank')->result_array();

        return $query;
    }

    //mengisi data diri untuk data baru
    public function isiDataDiri($id, $data)
    {
        //Input untuk Database
        $datakaryawan = [
            "fullname"                => strtoupper($data['nama_karyawan']),
            "tempat_lahir"            => $data['tempat_lahir'],
            "golongan_darah"          => $data['golongan_darah'],
            "tanggal_lahir"           => $data['tanggal_lahir'],
            "alamat_ktp"              => $data['alamat_ktp'],
            "alamat_domisili"         => $data['alamat_domisili'],
            "contact_no"              => $data['contact_no'],
            "email"                   => $data['email'],
            "no_kk"                   => $data['no_kk'],
            "npwp"                    => $data['npwp'],
            "nama_ibu"                => strtoupper($data['nama_ibu']),
            "agama"                   => $data['agama'],
            "gender"                  => $data['gender'],
            "status_kawin"            => $data['status_pernikahan'],
            "tinggi_badan"            => $data['tinggi_badan'],
            "berat_badan"             => $data['berat_badan'],
            "last_company"            => $data['last_company'],
            "last_posisi"             => $data['last_posisi'],
            "last_edu"                => $data['pendidikan_terakir'],
            "school_name"             => $data['school_name'],
            "jurusan"                 => $data['jurusan'],
            "bank_id"                 => $data['bank'],
            "no_rek"                  => $data['no_rek'],
            "pemilik_rekening"        => $data['pemilik_rekening']
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi data saat finish
    public function updateDataFinish($id)
    {
        //Input untuk Database
        $datakaryawan = [
            'doj'                   => null,
            'contract_start'        => null,
            'contract_end'          => null,
            'contract_periode'      => null,
            'hari_kerja'            => null,
            'gaji_pokok'            => null,
            'allow_jabatan'         => null,
            'allow_area'            => null,
            'allow_masakerja'       => null,
            'allow_trans_meal'      => null,
            'allow_trans_rent'      => null,
            'allow_konsumsi'        => null,
            'allow_transport'       => null,
            'allow_comunication'    => null,
            'allow_device'          => null,
            'allow_residence_cost'  => null,
            'allow_rent'            => null,
            'allow_parking'         => null,
            'allow_medichine'       => null,
            'allow_akomodsasi'      => null,
            'allow_kasir'           => null,
            'allow_operational'     => null,
            'cut_start'             => null,
            'cut_off'               => null,
            'date_payment'          => null,
            'request_empby'           => '1',
            'request_empon'           => date("Y-m-d h:i:s"),
            'approved_naeby'          => '1',
            'approved_naeon'          => date("Y-m-d h:i:s"),
            'approved_nomby'          => '1',
            'approved_nomon'          => date("Y-m-d h:i:s"),
            'createdby'               => '1',
            'e_status'                => '1',
            'department'              => '5',
            'migrasi'                 => '0',
            'location_id'             => '4',
            'approved_hrdby'          => null,
            'approved_hrdon'          => null,
            'cancel_stat'             => '0',
            'cancel_by'               => NULL,
            'cancel_ket'              => NULL,
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id['nik']);
        $this->db->update('xin_employee_request', $datakaryawan);

        //return null;
    }

    //mengisi data saat finish TKHL
    public function updateDataFinishTKHL($id)
    {
        //Input untuk Database
        $datakaryawan = [
            'doj'                   => null,
            'contract_start'        => null,
            'contract_end'          => null,
            'contract_periode'      => null,
            'hari_kerja'            => null,
            'gaji_pokok'            => null,
            'allow_jabatan'         => null,
            'allow_area'            => null,
            'allow_masakerja'       => null,
            'allow_trans_meal'      => null,
            'allow_trans_rent'      => null,
            'allow_konsumsi'        => null,
            'allow_transport'       => null,
            'allow_comunication'    => null,
            'allow_device'          => null,
            'allow_residence_cost'  => null,
            'allow_rent'            => null,
            'allow_parking'         => null,
            'allow_medichine'       => null,
            'allow_akomodsasi'      => null,
            'allow_kasir'           => null,
            'allow_operational'     => null,
            'cut_start'             => null,
            'cut_off'               => null,
            'date_payment'          => null,
            'request_empby'           => '1',
            'request_empon'           => date("Y-m-d h:i:s"),
            'approved_naeby'          => '1',
            'approved_naeon'          => date("Y-m-d h:i:s"),
            'approved_nomby'          => '1',
            'approved_nomon'          => date("Y-m-d h:i:s"),
            'createdby'               => '1',
            'e_status'                => '2',
            'department'              => '5',
            'migrasi'                 => '0',
            'location_id'             => '4',
            'approved_hrdby'          => null,
            'approved_hrdon'          => null,
            'cancel_stat'             => '0',
            'cancel_by'               => NULL,
            'cancel_ket'              => NULL,
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id['nik']);
        $this->db->update('xin_employee_request', $datakaryawan);

        //return null;
    }

    //mengambil semua Family relation
    public function getAllFamilyRelation()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $query = $this->db->get('mt_family_relation')->result_array();

        return $query;
    }

    //ambil data kontak darurat
    public function getKontakDarurat($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_employee_emergency');
        $this->db->where('employee_request_nik', $id);
        $query = $this->db->get()->row_array();

        return $query;
    }

    //mengisi data kontak darurat
    public function isiDataKontakDarurat($id, $data)
    {
        //Input untuk Database
        $datakaryawan = [
            "employee_request_nik"   => $id,
            "hubungan"               => $data['hubungan'],
            "nama"                   => $data['nama_kontak_darurat'],
            "no_kontak"              => $data['no_kontak_darurat']
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->insert('xin_employee_emergency', $datakaryawan);
        //print_r($this->db->last_query());
    }

    //mengisi update data kontak darurat
    public function updateDataKontakDarurat($id, $data)
    {
        //Input untuk Database
        $datakaryawan = [
            "hubungan"               => $data['hubungan'],
            "nama"                   => $data['nama_kontak_darurat'],
            "no_kontak"              => $data['no_kontak_darurat']
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('employee_request_nik', $id);
        $this->db->update('xin_employee_emergency', $datakaryawan);
    }

    //mengisi path ktp untuk data baru
    public function isiPathKTP($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "ktp"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi path kk untuk data baru
    public function isiPathKK($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "kk"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi path npwp untuk data baru
    public function isiPathNPWP($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "file_npwp"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi path ijazah untuk data baru
    public function isiPathIjazah($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "ijazah"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi path CV untuk data baru
    public function isiPathCV($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "civi"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }

    //mengisi path skck untuk data baru
    public function isiPathSKCK($id, $pid)
    {
        //Input untuk Database
        $datakaryawan = [
            "skck"                 => $pid
        ];

        //$otherdb = $this->load->database('default', TRUE);

        $this->db->where('nik_ktp', $id);
        $this->db->update('xin_employee_request', $datakaryawan);
    }
}

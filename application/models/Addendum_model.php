<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addendum_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //ambil data employee berdasarkan id (secid)
    public function getAddendumTemplate()
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_contract_addendum');
        $this->db->where('no_addendum', 'template');

        $query = $this->db->get()->row_array();

        return $query;
    }

    //ambil data employee berdasarkan id (secid)
    public function getAddendum($id)
    {
        //$otherdb = $this->load->database('default', TRUE);

        $this->db->select('*');
        $this->db->from('xin_contract_addendum');
        $this->db->where('id', $id);

        $query = $this->db->get()->row_array();

        return $query;
    }

    //ambil nama project
    function get_nama_project($proj_id)
    {
        if ($proj_id == null) {
            return "";
        } else if ($proj_id == 0) {
            return "";
        } else {
            $this->db->select('*');
            $this->db->from('xin_projects');
            $this->db->where('project_id', $proj_id);

            $query = $this->db->get()->row_array();

            if ($query['title'] == null) {
                return "";
            } else {
                return $query['title'];
            }
            //return $query['title'];
        }
    }

    //ambil nama sub project
    function get_nama_sub_project($id)
    {
        if ($id == null) {
            return "";
        } else if ($id == 0) {
            return "";
        } else {
            $this->db->select('*');
            $this->db->from('xin_projects_sub');
            $this->db->where('secid', $id);

            $query = $this->db->get()->row_array();

            //return $query['sub_project_name'];
            if ($query['sub_project_name'] == null) {
                return "";
            } else {
                return $query['sub_project_name'];
            }
        }
    }

    //ambil nama jabatan
    function get_nama_jabatan($id)
    {
        if ($id == null) {
            return "";
        } else if ($id == 0) {
            return "";
        } else {
            $this->db->select('*');
            $this->db->from('xin_designations');
            $this->db->where('designation_id', $id);

            $query = $this->db->get()->row_array();

            //return $query['designation_name'];
            if ($query['designation_name'] == null) {
                return "";
            } else {
                return $query['designation_name'];
            }
        }
    }

    //ambil nama employee
    function get_nama_karyawan($id)
    {
        if ($id == null) {
            return "";
        } else if ($id == 0) {
            return "";
        } else {
            $this->db->select('*');
            $this->db->from('xin_employees');
            $this->db->where('user_id', $id);

            $query = $this->db->get()->row_array();

            //return $query['designation_name'];
            if ($query['first_name'] == null) {
                return "";
            } else {
                return $query['first_name'];
            }
        }
    }

    //ambil nama employee
    function delete_addendum($postData = null)
    {
        $id = $postData['id'];
        if ($id == null) {
            return "";
        } else if ($id == 0) {
            return "";
        } else {
            $this->db->where('id', $id);
            $this->db->delete('xin_contract_addendum');

            return "Sukses";
        }
    }

    /*
	* persiapan data untuk datatable pagination
	* data list addendum berdasarkan pkwt
	* 
	* @author Fadla Qamara
	*/
    function get_list_addendum($postData = null)
    {

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        //variabel filter (diambil dari post ajax di view)
        $nip = $postData['nip'];
        $emp_id = $postData['emp_id'];
        $contract_id = $postData['contract_id'];
        $idsession = $postData['idsession'];


        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (no_addendum like '%" . $searchValue .  "%' or tgl_terbit like '%" . $searchValue . "%') ";
        }

        ## Kondisi Default 
        $kondisiDefaultQuery = "(
			karyawan_id = " . $emp_id . "
		AND	pkwt_id = " . $contract_id . "
		)";

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where($kondisiDefaultQuery);
        $records = $this->db->get('xin_contract_addendum')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->where($kondisiDefaultQuery);
        if ($searchQuery != '') {
            $this->db->where($searchQuery);
        }
        $records = $this->db->get('xin_contract_addendum')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*');
        $this->db->where($kondisiDefaultQuery);
        if ($searchQuery != '') {
            $this->db->where($searchQuery);
        }
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('xin_contract_addendum')->result();

        #Debugging variable
        //$tes_query = $this->db->last_query();

        $data = array();

        foreach ($records as $record) {
            // $addendum_id = $this->secure->encrypt_url($record->id);
            // $addendum_id_encrypt = strtr($addendum_id, array('+' => '.', '=' => '-', '/' => '~'));

            $view = '<button id="tesbutton" type="button" onclick="lihatAddendum(' . $record->id . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';
            $editReq = '<button type="button" onclick="editAddendum(' . $record->id . ')" class="btn btn-xs btn-outline-success" >EDIT</button>';
            $delete = '<button type="button" onclick="deleteAddendum(' . $record->id . ')" class="btn btn-xs btn-outline-danger" >DELETE</button>';

            // $teslinkview = 'type="button" onclick="lihatAddendum(' . $addendum_id_encrypt . ')" class="btn btn-xs btn-outline-twitter" >VIEW</button>';

            $data[] = array(
                "aksi" => $view . " " . $editReq . " " . $delete,
                "no_addendum" => $record->no_addendum,
                "tgl_terbit" => $record->tgl_terbit,
                "created_by" => $this->get_nama_karyawan($record->created_by),
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        //print_r($this->db->last_query());
        //die;

        return $response;
    }
}

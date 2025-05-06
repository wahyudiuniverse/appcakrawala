<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Budget_model extends CI_Model
{
    // Ambil tahun yang tersedia dari tabel budget
    public function get_all_years()
    {
        $this->db->select('tahun');
        $this->db->distinct('tahun');
        $query = $this->db->get('mt_budget_target');
        return $query->result();
    }

    // // Ambil daftar PT
    // public function get_all_pts()
    // {
    //     // Ganti dengan query yang sesuai jika ada tabel untuk PT
    //     $this->db->select('id, pt');
    //     $query = $this->db->get('mt_budget_target'); // Ganti dengan nama tabel PT
    //     return $query->result();
    // }

    // // Ambil daftar area
    // public function get_all_areas()
    // {
    //     // Ganti dengan query yang sesuai jika ada tabel untuk area
    //     $this->db->select('id, area');
    //     $query = $this->db->get('mt_budget_target'); // Ganti dengan nama tabel Area
    //     return $query->result();
    // }

    public function get_budget($tahun, $pt_id, $area_id)
    {
        return $this->db->select('bulan, target, actual')
            ->from('mt_budget_target')
            ->where('tahun', $tahun)
            ->where('pt_id', $pt_id)
            ->where('area_id', $area_id)
            ->get()
            ->result();
    }

    // Ambil semua PT yang ada di database
    public function get_all_pts()
    {
        $this->db->select('id, pt');
        $query = $this->db->get('mt_budget_target');  // Ganti 'pt_table' dengan nama tabel yang sesuai
        return $query->result();
    }

    public function get_all_areas()
    {
        $this->db->select('id, area'); // sesuaikan dengan nama kolom di tabelmu
        $query = $this->db->get('mt_budget_target');        // sesuaikan dengan nama tabel di database
        return $query->result();
    }
}

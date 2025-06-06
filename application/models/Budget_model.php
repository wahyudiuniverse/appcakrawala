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

    public function get_all_pt()
    {
        return $this->db->get('xin_companies')->result();
    }

    public function get_all_areas()
    {
        $this->db->select('id, area'); // sesuaikan dengan nama kolom di tabelmu
        $query = $this->db->get('mt_budget_target');        // sesuaikan dengan nama tabel di database
        return $query->result();
    }


    // Ambil data untuk dropdown (tahun, pt, area) hanya dari mt_budget_target
    public function get_dropdown_data()
    {
        $this->db->distinct();
        $this->db->select('tahun');
        $query = $this->db->get('mt_budget_target');
        $tahun_list = $query->result();

        $this->db->distinct();
        $this->db->select('pt');
        $query = $this->db->get('mt_budget_target');
        $pt_list = $query->result();

        $this->db->distinct();
        $this->db->select('area');
        $query = $this->db->get('mt_budget_target');
        $area_list = $query->result();

        // Mengembalikan data dropdown
        return [
            'tahun' => $tahun_list,
            'pt' => $pt_list,
            'area' => $area_list
        ];
    }


    public function get_unique($column)
    {
        $this->db->group_by($column);
        $this->db->select($column);
        $query = $this->db->get('mt_budget_target');
        return $query->result();
    }


    public function get_budget_data($tahun, $pt, $area)
    {
        $this->db->select('
            target.id,
            target.tahun,
            target.pt,
            target.area,
            target.bulan,
            target.target,
            COALESCE(SUM(actual.actual), 0) AS actual
        ');
        $this->db->from('mt_budget_target AS target');
        $this->db->join(
            'mt_budget_actual AS actual',
            'target.tahun = actual.tahun AND 
             target.pt = actual.pt AND 
             target.area = actual.area AND 
             target.bulan = actual.bulan',
            'left'
        );
        $this->db->where('target.tahun', $tahun);
        $this->db->where('target.pt', $pt);
        $this->db->where('target.area', $area);
        $this->db->group_by([
            'target.id',
            'target.tahun',
            'target.pt',
            'target.area',
            'target.bulan',
            'target.target'
        ]);

        return $this->db->get()->result();
    }

    public function insert_budget_target($data)
    {
        return $this->db->insert('mt_budget_target', $data);
    }
    public function insert_pt($pt)
    {
        $data = ['name' => $pt];
        $this->db->insert('xin_companies', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;
    }

    public function insert_budget_aktual($data)
    {
        // Insert data ke dalam tabel mt_budget_target
        if ($this->db->insert('mt_budget_actual', $data)) {
            return true; // Berhasil insert
        } else {
            // Log error jika ingin debugging
            log_message('error', 'Gagal insert ke actual: ' . $this->db->last_query());
            return false; // Gagal insert
        }
    }

    public function get_tahun_list()
    {
        $this->db->select('tahun');
        $this->db->from('mt_budget_target');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pt_by_tahun($tahun)
    {
        // Query untuk mengambil data PT berdasarkan tahun
        $this->db->group_by('pt');
        $this->db->select('pt');
        $this->db->from('mt_budget_target');  // Ganti dengan tabel yang sesuai
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();

        return $query->result_array(); // Mengembalikan data dalam bentuk array
    }

    public function get_area_by_tahun_pt($tahun, $pt)
    {
        return $this->db->select('DISTINCT(area)')
            ->from('mt_budget_target')
            ->where('tahun', $tahun)
            ->where('pt', $pt)
            ->get()
            ->result();
    }

    public function get_area_by_pt($pt)
    {
        $this->db->group_by('area');
        $this->db->select('id, area');
        $this->db->from('mt_budget_target'); // Ganti dengan nama tabel area kamu
        $this->db->where('pt', $pt);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function simpan_actual_data2($data)
    {
        // Cek apakah data dengan kombinasi tersebut sudah ada
        $this->db->where([
            'tahun' => $data['tahun'],
            'pt'    => $data['pt'],
            'area'  => $data['area'],
            'bulan' => $data['bulan']
        ]);
        $existing = $this->db->get('mt_budget_actual')->row(); // Ganti 'budget_table' dengan nama tabelmu

        if ($existing) {
            // Tambahkan actual baru ke actual lama
            $newActual = floatval($existing->actual) + floatval($data['actual']);

            // Update dengan actual yang sudah ditambah
            $this->db->where('id', $existing->id); // atau where by kombinasi kalau tidak ada ID
            return $this->db->update('mt_budget_actual', [
                'actual' => $newActual,
                'tgl_invoice' => $data['tgl_invoice'],
                'nomor_invoice' => $data['nomor_invoice'],
                'nomor_ps' => $data['nomor_ps']
            ]);
        } else {
            // Insert data baru jika belum ada
            return $this->db->insert('mt_budget_actual', $data);
        }
    }


    public function is_duplicate_budget($tahun, $pt, $area, $bulan)
    {
        $this->db->where([
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'bulan' => $bulan
        ]);
        $query = $this->db->get('mt_budget_target');
        return $query->num_rows() > 0;
    }
}

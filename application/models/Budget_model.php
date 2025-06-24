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

    public function get_all_pt2()
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

    public function get_unique2($column)
    {
        $this->db->group_by($column);
        $this->db->select($column);
        $query = $this->db->get('pengajuan_budgetting');
        return $query->result();
    }

    public function get_unique3($column)
    {
        $this->db->group_by($column);
        $this->db->select($column);
        $query = $this->db->get('po_budgetting');
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


    public function get_budget_data2($tahun, $pt, $area)
    {
        $this->db->select('*');
        $this->db->from('pengajuan_budgetting');
        $this->db->where('tahun', $tahun);
        $this->db->where('pt', $pt);
        $this->db->where('area', $area);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_budget_data3($tahun, $pt, $area)
    {
        $this->db->select('*');
        $this->db->from('po_budgetting');
        $this->db->where('tahun', $tahun);
        $this->db->where('pt', $pt);
        $this->db->where('area', $area);
        $query = $this->db->get();
        return $query->result();
    }

    // public function get_budget_data4($tahun, $pt, $area)
    // {
    //     $this->db->select('*');
    //     $this->db->from('report_invoice_budgetting');
    //     $this->db->where('tahun', $tahun);
    //     $this->db->where('pt', $pt);
    //     $this->db->where('area', $area);
    //     $query = $this->db->get();
    //     return $query->result();
    // }


    public function insert_budget_target($data)
    {
        return $this->db->insert('mt_budget_target', $data);
    }


    public function insert_budget_target2($data)
    {
        return $this->db->insert('pengajuan_budgetting', $data);
    }

    public function insert_budget_target3($data)
    {
        return $this->db->insert('po_budgetting', $data);
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

    public function get_pt_by_tahun2($tahun)
    {
        // Query untuk mengambil data PT berdasarkan tahun
        $this->db->group_by('pt');
        $this->db->select('pt');
        $this->db->from('pengajuan_budgetting');  // Ganti dengan tabel yang sesuai
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();

        return $query->result_array(); // Mengembalikan data dalam bentuk array
    }

    public function get_pt_by_tahun3($tahun)
    {
        // Query untuk mengambil data PT berdasarkan tahun
        $this->db->group_by('pt');
        $this->db->select('pt');
        $this->db->from('po_budgetting');  // Ganti dengan tabel yang sesuai
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();

        return $query->result_array(); // Mengembalikan data dalam bentuk array
    }

    public function get_pt_by_tahun4($tahun)
    {
        // Query untuk mengambil data PT berdasarkan tahun
        $this->db->group_by('pt');
        $this->db->select('pt');
        $this->db->from('report_invoice_budgetting');  // Ganti dengan tabel yang sesuai
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


    public function get_area_by_pt2($pt)
    {
        $this->db->group_by('area');
        $this->db->select('id_pengajuan, area');
        $this->db->from('pengajuan_budgetting'); // Ganti dengan nama tabel area kamu
        $this->db->where('pt', $pt);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_area_by_pt3($pt)
    {
        $this->db->group_by('area');
        $this->db->select('id_po, area');
        $this->db->from('po_budgetting'); // Ganti dengan nama tabel area kamu
        $this->db->where('pt', $pt);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_area_by_pt4($pt)
    {
        $this->db->group_by('area');
        $this->db->select('id_invoice, area');
        $this->db->from('report_invoice_budgetting'); // Ganti dengan nama tabel area kamu
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

    public function simpan_actual_data3($data)
    {
        return $this->db->insert('mt_budget_actual', $data);
    }


    public function is_duplicate_pengajuan_budgetting($tahun, $pt, $area, $periode)
    {
        $this->db->where([
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'periode' => $periode
        ]);
        $query = $this->db->get('pengajuan_budgetting');
        return $query->num_rows() > 0;
    }

    public function is_duplicate_po_budgetting($tahun, $pt, $area, $periode)
    {
        $this->db->where([
            'tahun' => $tahun,
            'pt' => $pt,
            'area' => $area,
            'periode' => $periode
        ]);
        $query = $this->db->get('po_budgetting');
        return $query->num_rows() > 0;
    }



    // Fungsi untuk mengambil detail invoice berdasarkan ID
    // public function get_invoice_by_id($id)
    // {
    //     // Menyusun query untuk mendapatkan detail invoice
    //     $this->db->select('invoice_number, invoice_date, invoice_amount');  // Kolom-kolom yang diperlukan
    //     $this->db->from('invoice');  // Nama tabel invoice (ganti sesuai dengan nama tabel Anda)
    //     $this->db->where('id', $id);  // Kondisi pencarian berdasarkan ID

    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         return $query->row_array();  // Mengembalikan satu baris hasil
    //     } else {
    //         return false;  // Jika tidak ada data
    //     }
    // }

    public function get_invoice_by_param($tahun, $pt, $area, $bulan)
    {
        return $this->db->get_where('mt_budget_actual', [
            'tahun' => $tahun,
            'pt'    => $pt,
            'area'  => $area,
            'bulan' => $bulan
        ])->result();
    }

    // Mengambil data dari tabel pengajuan_budgetting berdasarkan filter
    public function get_pengajuan_budgetting($tahun, $pt, $area, $periode)
    {
        $this->db->select('tahun, pt, area, project_id, jmlh_ps_psb_dan_pda, total_nilai_psb_dan_pda, total_nilai_pekerjaan_lainlain, total_nilai_pendapatan_dipengajuan');
        $this->db->from('pengajuan_budgetting');
        $this->db->where('tahun', $tahun);
        $this->db->where('pt', $pt);
        $this->db->where('area', $area);
        $this->db->where('periode', $periode);
        $query = $this->db->get();
        return $query->result();
    }

    // Memasukkan data ke tabel po_budgetting
    public function insert_budget_target4($data)
    {
        return $this->db->insert('po_budgetting', $data);
    }




    // Ambil semua project_id dari tabel pengajuan_budgetting
    public function get_all_projects()
    {
        return $this->db->select('project_id')->get('pengajuan_budgetting')->result();
    }

    public function get_pengajuan_by_projectid($project_id)
    {
        return $this->db->get_where('pengajuan_budgetting', ['project_id' => $project_id])->row();
    }

    public function save_po_budgetting($data)
    {
        return $this->db->insert('po_budgetting', $data);
    }

    public function get_all_pengajuan()
    {
        // Ambil semua data pengajuan_budgetting
        $query = $this->db->get('pengajuan_budgetting');
        return $query->result(); // Mengembalikan data dalam bentuk array
    }
}

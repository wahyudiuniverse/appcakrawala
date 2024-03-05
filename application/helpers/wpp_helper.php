<?php

//user login
function is_logged_in()
{
    //untuk memanggil library ci didalam function is_logged_in
    $ci = get_instance();
    //untuk melakukan validasi session agar tidak bisa langsung di redirect,
    // dan role id pada saat login
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

//Helper untuk checkbox user role
function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

//Helper merubah format rupiah
function rupiah($value, $rp = '')
{
    if ($value) {
        if (!$rp) {
            $formated = str_replace(',', '.', number_format($value));
            return $formated;
        } else {
            $formated = 'Rp ' . str_replace(',', '.', number_format($value));
            return $formated;
        }
    } else {
        return '-';
    }
}

function hitungcuti($tglawal, $tglakhir, $delimiter)
{
    //    menetapkan parameter awal dan libur nasional
    //    pada prakteknya data libur nasional bisa diambil dari database

    //    $koneksi = mysqli_connect('localhost', 'root', '', 'harviacode');
    //    $query = "SELECT * FROM liburnasional";
    //    $result = mysqli_query($koneksi, $query);
    //    while ($row = mysqli_fetch_array($result)) {
    //        $liburnasional[] = tglindo($row['tgl']);
    //    }

    $tgl_awal = $tgl_akhir = $minggu = $sabtu = $koreksi = $libur = 0;

    $liburnasional = array(
        "01-01-2019", "05-02-2019", "07-03-2019", "03-04-2019", "17-04-2019", "19-04-2019", "01-05-2019",
        "30-05-2019", "31-05-2019", "03-06-2019", "04-06-2019", "05-06-2019", "06-06-2019", "07-06-2019",
        "12-08-2019", "17-08-2019", "09-11-2019", "25-12-2019", "01-01-2020", "25-03-2020", "10-04-2020",
        "01-05-2020", "07-05-2020", "21-05-2020", "22-05-2020", "25-05-2020", "26-05-2020", "27-05-2020", "28-05-2020",
        "29-05-2020", "01-06-2020", "31-07-2020", "17-08-2020", "20-08-2020", "29-10-2020", "24-12-2020", 25 - 12 - 2020,
        "01-01-2021"
    );

    //    memecah tanggal untuk mendapatkan hari, bulan dan tahun
    $pecah_tglawal = explode($delimiter, $tglawal);
    $pecah_tglakhir = explode($delimiter, $tglakhir);

    //    mengubah Gregorian date menjadi Julian Day Count
    $tgl_awal = gregoriantojd($pecah_tglawal[1], $pecah_tglawal[0], $pecah_tglawal[2]);
    $tgl_akhir = gregoriantojd($pecah_tglakhir[1], $pecah_tglakhir[0], $pecah_tglakhir[2]);

    //    mengubah ke unix timestamp
    $jmldetik = 24 * 3600;
    $a = strtotime($tglawal);
    $b = strtotime($tglakhir);

    //    menghitung jumlah libur nasional 
    for ($i = $a; $i < $b; $i += $jmldetik) {
        foreach ($liburnasional as $key => $tgllibur) {
            if ($tgllibur == date("d-m-Y", $i)) {
                $libur++;
            }
        }
    }

    //    menghitung jumlah hari minggu
    for ($i = $a; $i < $b; $i += $jmldetik) {
        if (date("w", $i) == "0") {
            $minggu++;
        }
    }

    //    menghitung jumlah hari sabtu
    for ($i = $a; $i < $b; $i += $jmldetik) {
        if (date("w", $i) == "6") {
            $sabtu++;
        }
    }

    //    dijalankan jika $tglakhir adalah hari sabtu atau minggu
    if (date("w", $b) == "0" || date("w", $b) == "6") {
        $koreksi = 1;
    }

    //    mengitung selisih dengan pengurangan kemudian ditambahkan 1 agar tanggal awal cuti juga dihitung
    $jumlahcuti =  $tgl_akhir - $tgl_awal - $libur - $minggu - $sabtu - $koreksi + 1;
    return $jumlahcuti;
}

// jika anda menggunakan database, tambahkan fungsi berikut ini untuk mengubah format tanggal
//function tglindo($tgl){
//    // merubah dari yyyy-mm-dd menjadi dd-mm-yyyy
//    $p = explode('-', $tgl);
//    return $p[2].'-'.$p[1].'-'.$p[0];
//}

//cara penggunaan fungsi hitung cuti

/*output : 
    Awal cuti 14-05-2014 dan Selesai cuti 20-05-2014
    Jumlah cuti = 4 hari kerja
    (hari sabtu,minggu dan libur nasional tidak dihitung) 
    */
# Fungsi untuk membalik tanggal dari format Indo -> English
function InggrisTgl($tanggal)
{
    $tgl = substr($tanggal, 0, 2);
    $bln = substr($tanggal, 3, 2);
    $thn = substr($tanggal, 6, 4);
    $awal = "$thn-$bln-$tgl";
    return $awal;
}

# Fungsi untuk membalik tanggal dari format English -> Indo
function IndonesiaTgl($tanggal)
{
    $tgl = substr($tanggal, 8, 2);
    $bln = substr($tanggal, 5, 2);
    $thn = substr($tanggal, 0, 4);
    $awal = "$tgl-$bln-$thn";
    return $awal;
}

function bulan($bulan)
{
    switch ($bulan) {
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;
    }
    return $bulan;
}

function bulanromawi($bulanromawi)
{
    switch ($bulanromawi) {
        case 1: {
                $bulanromawi = 'I';
            }
            break;
        case 2: {
                $bulanromawi = 'II';
            }
            break;
        case 3: {
                $bulanromawi = 'III';
            }
            break;
        case 4: {
                $bulanromawi = 'IV';
            }
            break;
        case 5: {
                $bulanromawi = 'V';
            }
            break;
        case 6: {
                $bulanromawi = "VI";
            }
            break;
        case 7: {
                $bulanromawi = 'VII';
            }
            break;
        case 8: {
                $bulanromawi = 'VIII';
            }
            break;
        case 9: {
                $bulanromawi = 'IX';
            }
            break;
        case 10: {
                $bulanromawi = 'X';
            }
            break;
        case 11: {
                $bulanromawi = 'XI';
            }
            break;
        case 12: {
                $bulanromawi = 'XII';
            }
            break;
        default: {
                $bulanromawi = 'UnKnown';
            }
            break;
    }
    return $bulanromawi;
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka)
{
    $hasil =  number_format($angka, 0, ",", ".");
    return $hasil;
}

function hari($hari)
{
    switch ($hari) {
        case 0:
            $hari = "Minggu";
            break;
        case 1:
            $hari = "Senin";
            break;
        case 2:
            $hari = "Selasa";
            break;
        case 3:
            $hari = "Rabu";
            break;
        case 4:
            $hari = "Kamis";
            break;
        case 5:
            $hari = "Jum'at";
            break;
        case 6:
            $hari = "Sabtu";
            break;
    }
    return $hari;
}

function hariini($hari)
{
    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return "<b>" . $hari_ini . "</b>";
}

function diffInMonths(\DateTime $date1, \DateTime $date2)
{
    $diff =  $date1->diff($date2);

    $months = $diff->y * 12 + $diff->m + $diff->d / 30;

    return (int) round($months);
}

function hitung_umur($tanggal_lahir)
{
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) {
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    return $y . " tahun " . $m . " bulan ";
}

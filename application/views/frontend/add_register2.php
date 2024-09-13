<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><br>
        <h2>REGISTRASI KARYAWAN BARU 2024</h2>
        <h5>CAKRAWALA GROUP</h5><br>
    </h1>

    <!-- Tab Tambah Data Karyawan -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php
        $p = $halaman;
        $dsb;
        ?>

        <?php
        if ($p == 'nik') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "disabled",
                "project"             => "disabled",
                "data_diri"           => "disabled",
                "kontak_darurat"      => "disabled",
                "dokumen"             => "disabled",
                "review"              => "disabled",
            ];
        } else if ($p == 'perusahaan') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "disabled",
                "data_diri"           => "disabled",
                "kontak_darurat"      => "disabled",
                "dokumen"             => "disabled",
                "review"              => "disabled",
            ];
        } else if ($p == 'project') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "",
                "data_diri"           => "disabled",
                "kontak_darurat"      => "disabled",
                "dokumen"             => "disabled",
                "review"              => "disabled",
            ];
        } else if ($p == 'data_diri') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "",
                "data_diri"           => "",
                "kontak_darurat"      => "disabled",
                "dokumen"             => "disabled",
                "review"              => "disabled",
            ];
        } else if ($p == 'kontak_darurat') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "",
                "data_diri"           => "",
                "kontak_darurat"      => "",
                "dokumen"             => "disabled",
                "review"              => "disabled",
            ];
        } else if ($p == 'dokumen') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "",
                "data_diri"           => "",
                "kontak_darurat"      => "",
                "dokumen"             => "",
                "review"              => "disabled",
            ];
        } else if ($p == 'review') {
            $dsb = [
                "nik"                 => "",
                "perusahaan"          => "",
                "project"             => "",
                "data_diri"           => "",
                "kontak_darurat"      => "",
                "dokumen"             => "",
                "review"              => "",
            ];
        }
        ?>
        <!-- Testing halaman -->
        <?php //echo $p;
        //echo '<pre>';
        //print_r($dsb);
        //echo '</pre>';
        ?>
        <!-- Testing NIK -->
        <?php //echo $karyawan; 
        ?>



        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['nik'];
                                ?><?php echo $p == '' || $p == 'nik' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/nik') ?>/<?php echo $karyawan; ?>">NIK</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['perusahaan'];
                                ?> <?php echo $p == 'perusahaan' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/perusahaan') ?>/<?php echo $karyawan; ?>">Perusahaan</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['project'];
                                ?> <?php echo $p == 'project' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/project') ?>/<?php echo $karyawan; ?>">Project</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['data_diri'];
                                ?> <?php echo $p == 'data_diri' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/data_diri') ?>/<?php echo $karyawan; ?>">Data Diri</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['kontak_darurat'];
                                ?> <?php echo $p == 'kontak_darurat' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/kontak_darurat') ?>/<?php echo $karyawan; ?>">Kontak Darurat</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['dokumen'];
                                ?> <?php echo $p == 'dokumen' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/dokumen') ?>/<?php echo $karyawan; ?>">Dokumen</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $dsb['review'];
                                ?> <?php echo $p == 'review' ? 'active' : ''; ?>" href="<?php echo base_url('registrasi/addRegister/review') ?>/<?php echo $karyawan; ?>">Review</a>
        </li>
    </ul>
    <!-- End Tab Tambah Data Karyawan -->

    <div class="tab-content" id="myTabContent">
        <!-- Tab NIK -->
        <?php if ($p == '' || $p == 'nik') { ?>
            <!-- Alert error -->
            <?php if ($pesan_error) : ?>
                <script type='text/javascript'>
                    alert("<?php echo $pesan_error; ?>");
                    //confirm("<?php echo $pesan_error; ?>");
                </script>;
            <?php endif; ?>


            <!-- <form action='<?php base_url() . '/registrasi/addRegisterPost' ?>' method='post'> -->
            <?php echo form_open_multipart('/registrasi/addRegisterPost');
            ?>
            <div class="tab-pane fade show active" id="nik" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form NIK</h5>
                    <div class="card-body border-bottom-blue ">

                        <input type="hidden" id="halaman" name="halaman" value="nik">

                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" <?php echo $cek_nik == '' ? '' : 'readonly'; ?> value="<?php echo is_null($cek_nik) ? "" : $cek_nik; ?>" class="form-control" id="nik_karyawan" onkeyup="angka(this);" id="nik_karyawan" name="nik_karyawan" maxlength="16" placeholder="Masukan NIK KTP" required>
                            <small class="form-text text-danger"><?php //echo form_error('agama'); 
                                                                    ?></small>
                        </div>

                        <!-- -------Testing Variabel------->
                        <?php //echo '<pre>';
                        //print_r($cek_post);
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //echo "nik url = " . $nik_url . "<br>";
                        //echo "nik = " . $cek_nik . "<br>";
                        //echo "halaman  = " . $halaman . "<br>";
                        //echo "status resign  = " . $cek_resign . "<br>";
                        //echo "cek temp  = " . $cek_temp . "<br>";
                        //echo '</pre>';
                        ?>
                        <?php //echo $register['fullname']; 
                        ?>
                        <?php //echo '<pre>';
                        //print_r($register);
                        //echo '</pre>';
                        ?>

                        <!-- button submit -->
                        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>

        <!-- Tab Perusahaan -->
        <?php if ($p == 'perusahaan') { ?>
            <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post'> -->
            <?php echo form_open_multipart('/registrasi/addRegisterPost');
            ?>
            <div class="tab-pane fade show active" id="perusahaan" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form Perusahaan</h5>
                    <div class="card-body border-bottom-blue ">

                        <input type="hidden" id="halaman" name="halaman" value="perusahaan">
                        <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                        <div class="form-group">
                            <label>Perusahaan</label>
                            <select name="perusahaan" id="perusahaan" class="form-control dropdown-dengan-search" required>
                                <option value="">Pilih Perusahaan</option>
                                <?php foreach ($companies as $cmp) : ?>
                                    <option value="<?= $cmp['company_id']; ?>" <?php if (($register['company_id']) == $cmp['company_id']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <?php echo $cmp['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <!-- -------Testing Variabel------->
                        <?php //echo '<pre>';
                        //print_r($cek_post);
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //echo "nik = " . $nik_url;
                        //echo "nik url = " . $nik_url . "<br>";
                        //echo "nik = " . $cek_nik;
                        //echo '</pre>';
                        ?>
                        <?php //echo "cek temp perusahaan = " . $cek_temp_perusahaan; 
                        ?>
                        <?php //echo "cek temp = " . $cek_temp; 
                        ?>
                        <?php //echo "cek company = " . $cek_company; 
                        ?>

                        <?php //echo $karyawan; 
                        ?>
                        <?php //echo $register['fullname']; 
                        ?>
                        <?php //echo '<pre>';
                        //print_r($companies);
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //print_r($jabatan);
                        //echo '</pre>'; 
                        ?>

                        <!-- button submit -->
                        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>

        <!-- Tab Project -->
        <?php if ($p == 'project') { ?>
            <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post'> -->
            <?php echo form_open_multipart('/registrasi/addRegisterPost');
            ?>
            <div class="tab-pane fade show active" id="perusahaan" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form Project</h5>
                    <div class="card-body border-bottom-blue ">

                        <input type="hidden" id="halaman" name="halaman" value="project">
                        <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>


                        <div class="form-group">
                            <label>Project</label>
                            <!-- <select class="col-md-12 selectpicker" data-live-search="true" name="project" id="project" class="form-control" required> -->
                            <!-- <select name="project" id="project" class="form-control selectpicker" data-show-subtext="true" data-mobile="true" data-live-search="true" required> -->
                            <select name="project" id="project" class="form-control dropdown-dengan-search" required>
                                <option value="">Pilih Project</option>
                                <?php foreach ($projects as $prj) : ?>
                                    <option value="<?= $prj['project_id']; ?>" <?php if ($register['project'] == $prj['project_id']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <div style="text-wrap: wrap;"><?php echo $prj['title']; ?></div>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Sub Project</label>
                            <select name="sub_project" id="sub_project" class="form-control dropdown-dengan-search" required>
                                <option value="">Pilih Sub Project</option>
                                <?php foreach ($sub_projects as $sub) : ?>
                                    <option value="<?= $sub['secid']; ?>" <?php if ($register['sub_project'] == $sub['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $sub['sub_project_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-control dropdown-dengan-search" required>
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($jabatan as $jabatan) : ?>
                                    <option value="<?= $jabatan['designation_id']; ?>" <?php if ($register['posisi'] == $jabatan['designation_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $jabatan['designation_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Kota/Area Penempatan</label>
                            <input type="text" style="text-transform: uppercase" value="<?php echo $register['penempatan']; ?>" class="form-control" id="penempatan" onkeyup="huruf(this);" name="penempatan" placeholder="Nama Kota Area/Penempatan Kerja" required>
                            <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                        </div>

                        <!-- -------Testing Variabel------->
                        <?php //echo '<pre>';
                        //print_r($projects);
                        //print_r($otherdb->last_query());
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //echo "nik = " . $karyawan;
                        //echo "nik url = " . $nik_url . "<br>";
                        //echo "nik = " . $cek_nik;
                        //echo "project = " . $register['project'];
                        //echo '</pre>';
                        ?>
                        <?php //echo "cek temp perusahaan = " . $cek_temp_perusahaan; 
                        ?>
                        <?php //echo "cek temp = " . $cek_temp; 
                        ?>
                        <?php //echo "cek company = " . $cek_company; 
                        ?>

                        <?php //echo $karyawan; 
                        ?>
                        <?php //echo $register['fullname']; 
                        ?>
                        <?php //echo '<pre>';
                        //print_r($register);
                        // echo '</pre>'; 
                        ?>

                        <!-- button submit -->
                        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>

        <!-- Tab Data Diri -->
        <?php if ($p == 'data_diri') { ?>
            <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post'> -->
            <?php echo form_open_multipart('/registrasi/addRegisterPost');
            ?>
            <div class="tab-pane fade show active" id="data_diri" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form Data Diri</h5>
                    <div class="card-body border-bottom-blue ">

                        <input type="hidden" id="halaman" name="halaman" value="data_diri">
                        <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                        <div class="form-group">
                            <label>Nama Lengkap (Sesuai KTP)</label>
                            <!-- style="text-transform: uppercase" -->
                            <input type="text" value="<?php if ($register['fullname'] == '0') {
                                                            echo "";
                                                        } else {
                                                            echo $register['fullname'];
                                                        } ?>" class="form-control" id="nama_karyawan" name="nama_karyawan" style="text-transform: uppercase" placeholder="Nama Lengkap (Sesuai KTP)" required>
                            <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Kota/Tempat Kelahiran</label>
                            <input type="text" value="<?php echo $register['tempat_lahir']; ?>" class="form-control" id="tempat_lahir" onkeyup="huruf(this);" name="tempat_lahir" placeholder="Kota/Tempat Kelahiran" required>
                            <small class="form-text text-danger"><?php echo form_error('tempat_lahir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir ( yyyy-mm-dd )</label>
                            <input type="text" onkeydown="return false" value="<?php echo $register['tanggal_lahir']; ?>" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir ( yyyy-mm-dd )" required>
                            <small class="form-text text-danger"><?php echo form_error('tanggal_lahir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat (Sesuai KTP)</label>
                            <input type="text" value="<?php echo $register['alamat_ktp']; ?>" class="form-control" id="alamat_ktp" name="alamat_ktp" placeholder="Alamat (Sesuai KTP)" required>
                            <small class="form-text text-danger"><?php echo form_error('alamat_ktp'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat (Sesuai Domisili)</label>
                            <input type="text" value="<?php echo $register['alamat_domisili']; ?>" class="form-control" id="alamat_domisili" name="alamat_domisili" placeholder="Alamat (Sesuai Domisili)" required>
                            <small class="form-text text-danger"><?php echo form_error('alamat_domisili'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kontak/HP/WhatsApp</label>
                            <input type="text" value="<?php echo $register['contact_no']; ?>" class="form-control" maxlength="50" id="contact_no" onkeyup="angka(this);" name="contact_no" placeholder="Nomor Kontak/HP/WhatsApp" required>
                            <small class="form-text text-danger"><?php echo form_error('contact_no'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat Email</label>
                            <input type="email" value="<?php echo $register['email']; ?>" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                            <small class="form-text text-danger"><?php echo form_error('email'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kartu Keluarga</label>
                            <input type="text" value="<?php echo $register['no_kk']; ?>" class="form-control" maxlength="16" id="no_kk" onkeyup="angka(this);" name="no_kk" placeholder="Nomor Kartu Keluarga" required>
                            <small class="form-text text-danger"><?php echo form_error('no_kk'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor NPWP (Jika Ada)</label>
                            <input type="text" value="<?php echo $register['npwp']; ?>" class="form-control" maxlength="50" id="npwp" onkeyup="angka(this);" name="npwp" placeholder="Nomor NPWP (Jika Ada)">
                            <small class="form-text text-danger"><?php echo form_error('npwp'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Ibu Kandung</label>
                            <input type="text" style="text-transform: uppercase" value="<?php echo $register['nama_ibu']; ?>" class="form-control" id="nama_ibu" onkeyup="huruf(this);" name="nama_ibu" placeholder="Nama Ibu Kandung" required>
                            <small class="form-text text-danger"><?php echo form_error('nama_ibu'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $agama) : ?>
                                    <option value="<?= $agama['ethnicity_type_id']; ?>" <?php if ($register['agama'] == $agama['ethnicity_type_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $agama['type']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?php if ($register['gender'] == 'L') {
                                                        echo " selected";
                                                    } ?>>Pria</option>
                                <option value="P" <?php if ($register['gender'] == 'P') {
                                                        echo " selected";
                                                    } ?>>Wanita</option>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('gender'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Status Pernikahan</label>
                            <select name="status_pernikahan" id="status_pernikahan" class="form-control" required>
                                <option value="">Status Pernikahan</option>
                                <?php foreach ($marital as $mrt) : ?>
                                    <option value="<?= $mrt['id_marital']; ?>" <?php if ($register['status_kawin'] == $mrt['id_marital']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <?php echo $mrt['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_pernikahan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Tinggi Badan (cm)</label>
                            <input type="text" value="<?php echo $register['tinggi_badan']; ?>" class="form-control" maxlength="16" id="tinggi_badan" onkeyup="angka(this);" name="tinggi_badan" placeholder="Tinggi Badan (cm)" required>
                            <small class="form-text text-danger"><?php echo form_error('tinggi_badan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Berat Badan (kg)</label>
                            <input type="text" value="<?php echo $register['berat_badan']; ?>" class="form-control" maxlength="16" id="berat_badan" onkeyup="angka(this);" name="berat_badan" placeholder="Berat Badan (kg)" required>
                            <small class="form-text text-danger"><?php echo form_error('berat_badan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <select class="form-control" id="golongan_darah" name="golongan_darah" data-plugin="select_modal" data-placeholder="Golongan Darah">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" <?php if ($register['golongan_darah'] == 'A'): ?> selected="selected" <?php endif; ?>>A</option>
                                <option value="A+" <?php if ($register['golongan_darah'] == 'A+'): ?> selected="selected" <?php endif; ?>>A+</option>
                                <option value="A-" <?php if ($register['golongan_darah'] == 'A-'): ?> selected="selected" <?php endif; ?>>A-</option>
                                <option value="B" <?php if ($register['golongan_darah'] == 'B'): ?> selected="selected" <?php endif; ?>>B</option>
                                <option value="B+" <?php if ($register['golongan_darah'] == 'B+'): ?> selected="selected" <?php endif; ?>>B+</option>
                                <option value="B-" <?php if ($register['golongan_darah'] == 'B-'): ?> selected="selected" <?php endif; ?>>B-</option>
                                <option value="AB" <?php if ($register['golongan_darah'] == 'AB'): ?> selected="selected" <?php endif; ?>>AB</option>
                                <option value="AB+" <?php if ($register['golongan_darah'] == 'AB+'): ?> selected="selected" <?php endif; ?>>AB+</option>
                                <option value="AB-" <?php if ($register['golongan_darah'] == 'AB-'): ?> selected="selected" <?php endif; ?>>AB-</option>
                                <option value="O" <?php if ($register['golongan_darah'] == 'O'): ?> selected="selected" <?php endif; ?>>O</option>
                                <option value="O+" <?php if ($register['golongan_darah'] == 'O+'): ?> selected="selected" <?php endif; ?>>O+</option>
                                <option value="O-" <?php if ($register['golongan_darah'] == 'O-'): ?> selected="selected" <?php endif; ?>>O-</option>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_pernikahan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Perusahaan Tempat Kerja Sebelumnya</label>
                            <input type="text" value="<?php echo $register['last_company']; ?>" class="form-control" id="last_company" name="last_company" placeholder="Perusahaan Tempat Kerja Sebelumnya" required>
                            <small class="form-text text-danger"><?php echo form_error('last_company'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Posisi/Jabatan Sebelumnya</label>
                            <input type="text" value="<?php echo $register['last_posisi']; ?>" class="form-control" id="last_posisi" name="last_posisi" placeholder="Posisi/Jabatan Sebelumnya" required>
                            <small class="form-text text-danger"><?php echo form_error('last_posisi'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select name="pendidikan_terakir" id="pendidikan_terakir" class="form-control" required>
                                <option value="">Pendidikan Terakhir</option>
                                <?php foreach ($education_lvl as $ed) : ?>
                                    <option value="<?= $ed['education_level_id']; ?>" <?php if ($register['last_edu'] == $ed['education_level_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $ed['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('pendidikan_terakir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Sekolah/Universitas</label>
                            <input type="text" value="<?php echo $register['school_name']; ?>" class="form-control" id="school_name" name="school_name" placeholder="Nama Sekolah/Universitas" required>
                            <small class="form-text text-danger"><?php echo form_error('school_name'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" value="<?php echo $register['jurusan']; ?>" class="form-control" id="jurusan" name="jurusan" placeholder="Jurusan" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Bank</label>
                            <select name="bank" id="bank" class="form-control" required>
                                <option value="">Nama Bank</option>
                                <?php foreach ($bank as $bank) : ?>
                                    <option value="<?= $bank['secid']; ?>" <?php if ($register['bank_id'] == $bank['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $bank['bank_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('pendidikan_terakir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input type="text" value="<?php echo $register['no_rek']; ?>" class="form-control" id="no_rek" onkeyup="angka(this);" name="no_rek" placeholder="Nomor Rekening" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Pemilik Rekening</label>
                            <input type="text" value="<?php echo $register['pemilik_rekening']; ?>" class="form-control" id="pemilik_rekening" onkeyup="huruf(this);" name="pemilik_rekening" placeholder="Nama Pemilik Rekening" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <!-- Testing Variabel -->
                        <?php //echo '<pre>';
                        //print_r($cek_files);
                        //echo "nik url = " . $nik_url . "<br>";
                        //echo "nik = " . $cek_nik . "<br>";
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //echo "nik = " . $karyawan;
                        //echo '</pre>';
                        ?>

                        <!-- button submit -->
                        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>

        <!-- Tab Kontak Darurat -->
        <?php if ($p == 'kontak_darurat') { ?>
            <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post'> -->
            <?php echo form_open_multipart('/registrasi/addRegisterPost');
            ?>
            <div class="tab-pane fade show active" id="kontak_darurat" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form Kontak Darurat</h5>
                    <div class="card-body border-bottom-blue ">

                        <input type="hidden" id="halaman" name="halaman" value="kontak_darurat">
                        <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                        <div class="form-group">
                            <label>Hubungan</label>
                            <select name="hubungan" id="hubungan" class="form-control" required>
                                <option value="">Hubungan dengan karyawan</option>
                                <?php foreach ($relation as $rlt) : ?>
                                    <option value="<?= $rlt['secid']; ?>" <?php if ((is_null($kontak_darurat) ? "" : $kontak_darurat['hubungan']) == $rlt['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $rlt['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Kontak Darurat</label>
                            <input type="text" value="<?php echo (is_null($kontak_darurat) ? "" : $kontak_darurat['nama']); ?>" class="form-control" id="nama_kontak_darurat" onkeyup="huruf(this);" name="nama_kontak_darurat" placeholder="Nama Kontak Darurat" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kontak Darurat</label>
                            <input type="text" value="<?php echo (is_null($kontak_darurat) ? "" : $kontak_darurat['no_kontak']); ?>" class="form-control" id="no_kontak_darurat" onkeyup="angka(this);" name="no_kontak_darurat" placeholder="Nomor Kontak Darurat" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <!-- -------Testing Variabel------->
                        <?php //echo '<pre>';
                        //print_r($cek_post);
                        //echo '</pre>';
                        ?>
                        <?php //echo '<pre>';
                        //echo "nik = " . $karyawan;
                        //echo "nik url = " . $nik_url . "<br>";
                        //echo "nik = " . $cek_nik;
                        //echo '</pre>';
                        ?>
                        <?php //echo "cek temp perusahaan = " . $cek_temp_perusahaan; 
                        ?>
                        <?php //echo "cek temp = " . $cek_temp; 
                        ?>
                        <?php //echo "cek company = " . $cek_company; 
                        ?>

                        <?php //echo $karyawan; 
                        ?>
                        <?php //echo $register['fullname']; 
                        ?>
                        <?php //echo '<pre>';
                        //print_r($register);
                        // echo '</pre>'; 
                        ?>
                        <?php //echo '<pre>';
                        //print_r($jabatan);
                        //echo '</pre>'; 
                        ?>

                        <!-- button submit -->
                        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>

        <!-- Tab Dokumen -->
        <?php if ($p == 'dokumen') { ?>
            <!-- Alert error upload -->
            <?php if ($error_upload) : ?>
                <script type='text/javascript'>
                    alert("<?php echo $error_upload; ?>");
                </script>;
            <?php endif; ?>

            <div class="tab-pane fade show active" id="dokumen" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Form Dokumen</h5>
                    <div class="card-body border-bottom-blue ">
                        <?php //print_r($this->db->last_query()); 
                        ?>

                        <div class="form-row">
                            <!-- upload ktp -->
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile1 = base_url('/uploads/document/ktp/') . $register['ktp'] . "?" . $t; ?>
                                <?php if ($register['ktp'] == "" || $register['ktp'] == "0") {
                                    $tesfile1 = base_url('/uploads/document/ktp/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile1;
                                $parameterfile1 = substr($tesfile1, -14);
                                ?>
                                <label>Foto KTP <font color="#FF0000">*</font></label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_ktp" type='<?php if (substr($parameterfile1, 0, 3) == "pdf") {
                                                                                                echo "application/pdf";
                                                                                            } else {
                                                                                                echo "image/jpg";
                                                                                            }
                                                                                            ?>' src="<?php echo $tesfile1; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_ktp" name="foto_ktp" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_ktp" for="foto_ktp">Foto KTP</label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD KTP</button>

                                <?php echo form_close(); ?>
                            </div>

                            <!-- upload kk -->
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile2 = base_url('/uploads/document/kk/') . $register['kk'] . "?" . $t; ?>
                                <?php if ($register['kk'] == "" || $register['kk'] == "0") {
                                    $tesfile2 = base_url('/uploads/document/kk/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile2;
                                $parameterfile2 = substr($tesfile2, -14);
                                //echo $parameterfile;
                                //echo substr($parameterfile, 0, 3);
                                ?>
                                <label>Foto Kartu Keluarga <font color="#FF0000">*</font></label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_kk" type='<?php if (substr($parameterfile2, 0, 3) == "pdf") {
                                                                                                echo "application/pdf";
                                                                                            } else {
                                                                                                echo "image/jpg";
                                                                                            }
                                                                                            ?>' src="<?php echo $tesfile2; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_kk" for="foto_kk">Foto KK</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD KK</button>
                                <?php echo form_close(); ?>
                            </div>

                            <!-- upload npwp -->
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile3 = base_url('/uploads/document/npwp/') . $register['file_npwp'] . "?" . $t; ?>
                                <?php if ($register['file_npwp'] == "" || $register['file_npwp'] == "0") {
                                    $tesfile3 = base_url('/uploads/document/npwp/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile3;
                                $parameterfile3 = substr($tesfile3, -14);
                                ?>
                                <label>Foto NPWP </label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_npwp" type='<?php if (substr($parameterfile3, 0, 3) == "pdf") {
                                                                                                echo "application/pdf";
                                                                                            } else {
                                                                                                echo "image/jpg";
                                                                                            }
                                                                                            ?>' src="<?php echo $tesfile3; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_npwp" name="foto_npwp" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_npwp" for="foto_npwp">Foto NPWP</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD NPWP</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- upload ijazah -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile4 = base_url('/uploads/document/ijazah/') . $register['ijazah'] . "?" . $t; ?>
                                <?php if ($register['ijazah'] == "" || $register['ijazah'] == "0") {
                                    $tesfile4 = base_url('/uploads/document/ijazah/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile4;
                                $parameterfile4 = substr($tesfile4, -14);
                                ?>
                                <label>Foto Ijazah <font color="#FF0000">*</font></label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_ijazah" type='<?php if (substr($parameterfile4, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile4; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_ijazah" name="foto_ijazah" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_ijazah" for="foto_ijazah">Foto Ijazah</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD IJAZAH</button>
                                <?php echo form_close(); ?>
                            </div>

                            <!-- upload CV -->
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile5 = base_url('/uploads/document/cv/') . $register['civi'] . "?" . $t; ?>
                                <?php if ($register['civi'] == "" || $register['civi'] == "0") {
                                    $tesfile5 = base_url('/uploads/document/cv/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile5;
                                $parameterfile5 = substr($tesfile5, -14);
                                ?>
                                <label>Foto CV/Daftar Riwayat Hidup <font color="#FF0000">*</font></label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_cv" type='<?php if (substr($parameterfile5, 0, 3) == "pdf") {
                                                                                                echo "application/pdf";
                                                                                            } else {
                                                                                                echo "image/jpg";
                                                                                            }
                                                                                            ?>' src="<?php echo $tesfile5; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_cv" name="foto_cv" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_cv" for="foto_cv">Foto CV</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD CV</button>
                                <?php echo form_close(); ?>
                            </div>

                            <!-- upload SKCK -->
                            <div class="form-group col-md-4">
                                <!-- <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('/registrasi/addRegisterPost');
                                ?>
                                <?php
                                //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                $t = time();
                                $tesfile6 = base_url('/uploads/document/skck/') . $register['skck'] . "?" . $t; ?>
                                <?php if ($register['skck'] == "" || $register['skck'] == "0") {
                                    $tesfile6 = base_url('/uploads/document/skck/') . "default.jpg";
                                } ?>
                                <?php //echo $tesfile6;
                                $parameterfile6 = substr($tesfile6, -14);
                                ?>
                                <label>Foto SKCK </label><br>
                                <label>File bertipe jpg, jpeg, png atau pdf</label><br>
                                <label>Ukuran maksimal 2 MB</label>
                                <embed class="form-group col-md-12" id="output_skck" type='<?php if (substr($parameterfile6, 0, 3) == "pdf") {
                                                                                                echo "application/pdf";
                                                                                            } else {
                                                                                                echo "image/jpg";
                                                                                            }
                                                                                            ?>' src="<?php echo $tesfile6; ?>"></embed>

                                <input type="hidden" id="halaman" name="halaman" value="dokumen">
                                <input type="hidden" id="nik_karyawan" name="nik_karyawan" value=<?php echo $cek_nik; ?>>

                                <div class="custom-file" style="padding-bottom: 50px;">
                                    <input type="file" class="custom-file-input" id="foto_skck" name="foto_skck" accept="application/pdf,image/png,image/jpg,image/jpeg">
                                    <label width='25%' class="custom-file-label" id="foto_skck" for="foto_skck">Foto SKCK</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD SKCK</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                    </div>

                    <!-- Testing Variabel -->
                    <?php //echo '<pre>';
                    //echo ($error_upload);
                    //echo '</pre>';
                    ?>
                    <?php //echo '<pre>';
                    //echo "nik = " . $karyawan;
                    //echo "nik url = " . $nik_url . "<br>";
                    //echo "nik = " . $cek_nik;
                    //echo '</pre>';
                    ?>
                    <?php //echo '<pre>';
                    //print_r($_FILES);
                    //echo '</pre>';
                    ?>
                </div>
            </div>
            <!-- Custom button pindah ke tab Review -->
            <button id="dokumen_next_button" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button>
        <?php } ?>

        <!-- Tab Review -->
        <?php if ($p == 'review') { ?>
            <!-- Modal untuk tanya finish atau tidak -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sukses</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Selamat. <?php echo $register['fullname']; ?>
                                <br>
                                Anda telah berhasil melakukan registrasi karyawan.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <!-- https://apps-cakrawala.com/register/success/ <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                            <a href="https://apps-cakrawala.com/register/success/<?php echo $register['fullname']; ?>" role="button" class="btn btn-primary ">Ok</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Data Project dan Jabatan -->
            <div class="tab-pane fade show active" id="perusahaan" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Informasi Project dan Jabatan <button id="edit_project_dan_jabatan" class="btn btn-primary">EDIT</button></h5>

                    <div class="card-body border-bottom-blue ">
                        <div class="form-group">
                            <label>NIK</label>
                            <input readonly type="text" value="<?php echo $register['nik_ktp']; ?>" class="form-control" id="nik_karyawan" onkeyup="angka(this);" id="nik_karyawan" name="nik_karyawan" maxlength="16" placeholder="Masukan NIK KTP" required>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Perusahaan</label>
                            <select disabled name="perusahaan" id="perusahaan" class="form-control" required>
                                <option value="">Pilih Perusahaan</option>
                                <?php foreach ($companies as $cmp) : ?>
                                    <option value="<?= $cmp['company_id']; ?>" <?php if ($register['company_id'] == $cmp['company_id']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <?php echo $cmp['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Project</label>
                            <select disabled name="project_review" id="project_review" class="form-control" required>
                                <option value="">Pilih Project</option>
                                <?php foreach ($projects as $prj) : ?>
                                    <option value="<?= $prj['project_id']; ?>" <?php if ($register['project'] == $prj['project_id']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <?php echo $prj['title']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Sub Project</label>
                            <select disabled name="sub_project_preview" id="sub_project_preview" class="form-control" required>
                                <option value="">Pilih Sub Project</option>
                                <?php foreach ($sub_projects as $sub) : ?>
                                    <option value="<?= $sub['secid']; ?>" <?php if ($register['sub_project'] == $sub['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $sub['sub_project_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jabatan</label>
                            <select disabled name="jabatan_review" id="jabatan_review" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($jabatan as $jabatan) : ?>
                                    <option value="<?= $jabatan['designation_id']; ?>" <?php if ($register['posisi'] == $jabatan['designation_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $jabatan['designation_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Kota/Area Penempatan</label>
                            <input disabled type="text" value="<?php echo $register['penempatan']; ?>" class="form-control" id="penempatan" onkeyup="huruf(this);" name="penempatan" placeholder="Nama Kota/Area Penempatan Kerja" required>
                            <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                        </div>

                        <!-- button submit -->
                        <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button> -->

                    </div>
                </div>
            </div>
            <!-- End Section Data Project dan Jabatan -->

            <!-- Section Data Diri -->
            <div class="tab-pane fade show active" id="data_diri" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Informasi Data Diri <button id="edit_data_diri" class="btn btn-primary">EDIT</button></h5>
                    <div class="card-body border-bottom-blue ">

                        <div class="form-group">
                            <label>Nama Lengkap (Sesuai KTP)</label>
                            <input disabled type="text" value="<?php if ($register['fullname'] == '0') {
                                                                    echo "";
                                                                } else {
                                                                    echo $register['fullname'];
                                                                } ?>" class="form-control" id="nama_karyawan" onkeyup="huruf(this);" name="nama_karyawan" placeholder="Nama Lengkap (Sesuai KTP)" required>
                            <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Kota/Tempat Kelahiran</label>
                            <input disabled type="text" value="<?php echo $register['tempat_lahir']; ?>" class="form-control" id="tempat_lahir" onkeyup="huruf(this);" name="tempat_lahir" placeholder="Kota/Tempat Kelahiran" required>
                            <small class="form-text text-danger"><?php echo form_error('tempat_lahir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir ( yyyy-mm-dd )</label>
                            <input disabled type="text" value="<?php echo $register['tanggal_lahir']; ?>" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir ( yyyy-mm-dd )" required>
                            <small class="form-text text-danger"><?php echo form_error('tanggal_lahir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat (Sesuai KTP)</label>
                            <input disabled type="text" value="<?php echo $register['alamat_ktp']; ?>" class="form-control" id="alamat_ktp" name="alamat_ktp" placeholder="Alamat (Sesuai KTP)" required>
                            <small class="form-text text-danger"><?php echo form_error('alamat_ktp'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat (Sesuai Domisili)</label>
                            <input disabled type="text" value="<?php echo $register['alamat_domisili']; ?>" class="form-control" id="alamat_domisili" name="alamat_domisili" placeholder="Alamat (Sesuai Domisili)" required>
                            <small class="form-text text-danger"><?php echo form_error('alamat_domisili'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kontak/HP/WhatsApp</label>
                            <input disabled type="text" value="<?php echo $register['contact_no']; ?>" class="form-control" maxlength="50" id="contact_no" onkeyup="angka(this);" name="contact_no" placeholder="Nomor Kontak/HP/WhatsApp" required>
                            <small class="form-text text-danger"><?php echo form_error('contact_no'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Alamat Email</label>
                            <input disabled type="text" value="<?php echo $register['email']; ?>" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                            <small class="form-text text-danger"><?php echo form_error('email'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kartu Keluarga</label>
                            <input disabled type="text" value="<?php echo $register['no_kk']; ?>" class="form-control" maxlength="50" id="no_kk" onkeyup="angka(this);" name="no_kk" placeholder="Nomor Kartu Keluarga" required>
                            <small class="form-text text-danger"><?php echo form_error('no_kk'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor NPWP (Jika Ada)</label>
                            <input disabled type="text" value="<?php echo $register['npwp']; ?>" class="form-control" maxlength="50" id="npwp" onkeyup="angka(this);" name="npwp" placeholder="Nomor NPWP (Jika Ada)">
                            <small class="form-text text-danger"><?php echo form_error('npwp'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Ibu Kandung</label>
                            <input disabled type="text" value="<?php echo $register['nama_ibu']; ?>" class="form-control" id="nama_ibu" onkeyup="huruf(this);" name="nama_ibu" placeholder="Nama Ibu Kandung" required>
                            <small class="form-text text-danger"><?php echo form_error('nama_ibu'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Agama</label>
                            <select disabled name="agama" id="agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $agama) : ?>
                                    <option value="<?= $agama['ethnicity_type_id']; ?>" <?php if ($register['agama'] == $agama['ethnicity_type_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $agama['type']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select disabled name="gender" id="gender" class="form-control" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?php if ($register['gender'] == 'L') {
                                                        echo " selected";
                                                    } ?>>Pria</option>
                                <option value="P" <?php if ($register['gender'] == 'P') {
                                                        echo " selected";
                                                    } ?>>Wanita</option>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('gender'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Status Pernikahan</label>
                            <select disabled name="status_pernikahan" id="status_pernikahan" class="form-control" required>
                                <option value="">Status Pernikahan</option>
                                <?php foreach ($marital as $mrt) : ?>
                                    <option value="<?= $mrt['id_marital']; ?>" <?php if ($register['status_kawin'] == $mrt['id_marital']) {
                                                                                    echo " selected";
                                                                                } ?>>
                                        <?php echo $mrt['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_pernikahan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Tinggi Badan (cm)</label>
                            <input disabled type="text" value="<?php echo $register['tinggi_badan']; ?>" class="form-control" maxlength="16" id="tinggi_badan" onkeyup="angka(this);" name="tinggi_badan" placeholder="Tinggi Badan (cm)" required>
                            <small class="form-text text-danger"><?php echo form_error('tinggi_badan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Berat Badan (kg)</label>
                            <input disabled type="text" value="<?php echo $register['berat_badan']; ?>" class="form-control" maxlength="16" id="berat_badan" onkeyup="angka(this);" name="berat_badan" placeholder="Berat Badan (kg)" required>
                            <small class="form-text text-danger"><?php echo form_error('berat_badan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <select disabled class="form-control" id="golongan_darah" name="golongan_darah" data-plugin="select_modal" data-placeholder="Golongan Darah">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" <?php if ($register['golongan_darah'] == 'A'): ?> selected="selected" <?php endif; ?>>A</option>
                                <option value="A+" <?php if ($register['golongan_darah'] == 'A+'): ?> selected="selected" <?php endif; ?>>A+</option>
                                <option value="A-" <?php if ($register['golongan_darah'] == 'A-'): ?> selected="selected" <?php endif; ?>>A-</option>
                                <option value="B" <?php if ($register['golongan_darah'] == 'B'): ?> selected="selected" <?php endif; ?>>B</option>
                                <option value="B+" <?php if ($register['golongan_darah'] == 'B+'): ?> selected="selected" <?php endif; ?>>B+</option>
                                <option value="B-" <?php if ($register['golongan_darah'] == 'B-'): ?> selected="selected" <?php endif; ?>>B-</option>
                                <option value="AB" <?php if ($register['golongan_darah'] == 'AB'): ?> selected="selected" <?php endif; ?>>AB</option>
                                <option value="AB+" <?php if ($register['golongan_darah'] == 'AB+'): ?> selected="selected" <?php endif; ?>>AB+</option>
                                <option value="AB-" <?php if ($register['golongan_darah'] == 'AB-'): ?> selected="selected" <?php endif; ?>>AB-</option>
                                <option value="O" <?php if ($register['golongan_darah'] == 'O'): ?> selected="selected" <?php endif; ?>>O</option>
                                <option value="O+" <?php if ($register['golongan_darah'] == 'O+'): ?> selected="selected" <?php endif; ?>>O+</option>
                                <option value="O-" <?php if ($register['golongan_darah'] == 'O-'): ?> selected="selected" <?php endif; ?>>O-</option>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_pernikahan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Perusahaan Tempat Kerja Sebelumnya</label>
                            <input disabled type="text" value="<?php echo $register['last_company']; ?>" class="form-control" id="last_company" name="last_company" placeholder="Perusahaan Tempat Kerja Sebelumnya" required>
                            <small class="form-text text-danger"><?php echo form_error('last_company'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Posisi/Jabatan Sebelumnya</label>
                            <input disabled type="text" value="<?php echo $register['last_posisi']; ?>" class="form-control" id="last_posisi" name="last_posisi" placeholder="Posisi/Jabatan Sebelumnya" required>
                            <small class="form-text text-danger"><?php echo form_error('last_posisi'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select disabled name="pendidikan_terakir" id="pendidikan_terakir" class="form-control" required>
                                <option value="">Pendidikan Terakhir</option>
                                <?php foreach ($education_lvl as $ed) : ?>
                                    <option value="<?= $ed['education_level_id']; ?>" <?php if ($register['last_edu'] == $ed['education_level_id']) {
                                                                                            echo " selected";
                                                                                        } ?>>
                                        <?php echo $ed['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('pendidikan_terakir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Sekolah/Universitas</label>
                            <input disabled type="text" value="<?php echo $register['school_name']; ?>" class="form-control" id="school_name" name="school_name" placeholder="Nama Sekolah/Universitas" required>
                            <small class="form-text text-danger"><?php echo form_error('school_name'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <input disabled type="text" value="<?php echo $register['jurusan']; ?>" class="form-control" id="jurusan" name="jurusan" placeholder="Jurusan" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Bank</label>
                            <select disabled name="bank" id="bank" class="form-control" required>
                                <option value="">Nama Bank</option>
                                <?php foreach ($bank as $bank) : ?>
                                    <option value="<?= $bank['secid']; ?>" <?php if ($register['bank_id'] == $bank['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $bank['bank_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('pendidikan_terakir'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input disabled type="text" value="<?php echo $register['no_rek']; ?>" class="form-control" id="no_rek" onkeyup="angka(this);" name="no_rek" placeholder="Nomor Rekening" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Pemilik Rekening</label>
                            <input disabled type="text" value="<?php echo $register['pemilik_rekening']; ?>" class="form-control" id="pemilik_rekening" onkeyup="huruf(this);" name="pemilik_rekening" placeholder="Nama Pemilik Rekening" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <!-- button submit -->
                        <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button> -->

                    </div>
                </div>
            </div>
            <!-- End Section Data Diri -->

            <!-- Section Data Kontak Darurat -->
            <div class="tab-pane fade show active" id="perusahaan" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Informasi Kontak Darurat <button id="edit_kontak_darurat" class="btn btn-primary">EDIT</button></h5>

                    <div class="card-body border-bottom-blue ">
                        <div class="form-group">
                            <label>Hubungan</label>
                            <select disabled name="hubungan" id="hubungan" class="form-control" required>
                                <option value="">Hubungan dengan karyawan</option>
                                <?php foreach ($relation as $rlt) : ?>
                                    <option value="<?= $rlt['secid']; ?>" <?php if ($kontak_darurat['hubungan'] == $rlt['secid']) {
                                                                                echo " selected";
                                                                            } ?>>
                                        <?php echo $rlt['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nama Kontak Darurat</label>
                            <input disabled type="text" value="<?php echo $kontak_darurat['nama']; ?>" class="form-control" id="nama_kontak_darurat" onkeyup="huruf(this);" name="nama_kontak_darurat" placeholder="Nama Kontak Darurat" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kontak Darurat</label>
                            <input disabled type="text" value="<?php echo $kontak_darurat['no_kontak']; ?>" class="form-control" id="no_kontak_darurat" onkeyup="angka(this);" name="no_kontak_darurat" placeholder="Nomor Kontak Darurat" required>
                            <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                        </div>

                        <!-- button submit -->
                        <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">NEXT</button> -->

                    </div>
                </div>
            </div>
            <!-- End Section Data Project dan Jabatan -->

            <!-- Section Dokumen -->
            <div class="tab-pane fade show active" id="dokumen" role="tabpanel" aria-labelledby="nik-tab">
                <div class="card border-blue">
                    <h5 class="card-header text-black bg-gradient-blue">Informasi Dokumen <button id="edit_dokumen" class="btn btn-primary">EDIT</button></h5>
                    <div class="card-body border-bottom-blue ">

                        <div class="form-row">
                            <!-- upload ktp -->
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile1 = base_url('/uploads/document/ktp/') . $register['ktp'] . "?" . $t; ?>
                                    <?php if ($register['ktp'] == "" || $register['ktp'] == "0") {
                                        $tesfile1 = base_url('/uploads/document/ktp/') . "default.jpg";
                                    }
                                    $parameterfile1 = substr($tesfile1, -14);
                                    ?>
                                    <label>Foto KTP</label>
                                    <embed class="form-group col-md-12" id="output_ktp" type='<?php if (substr($parameterfile1, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile1; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>

                            <!-- upload kk -->
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile2 = base_url('/uploads/document/kk/') . $register['kk'] . "?" . $t; ?>
                                    <?php if ($register['kk'] == "" || $register['kk'] == "0") {
                                        $tesfile2 = base_url('/uploads/document/kk/') . "default.jpg";
                                    }
                                    $parameterfile2 = substr($tesfile2, -14);
                                    ?>
                                    <label>Foto KK</label>
                                    <embed class="form-group col-md-12" id="output_kk" type='<?php if (substr($parameterfile2, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile2; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>

                            <!-- upload npwp -->
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile3 = base_url('/uploads/document/npwp/') . $register['file_npwp'] . "?" . $t; ?>
                                    <?php if ($register['file_npwp'] == "" || $register['file_npwp'] == "0") {
                                        $tesfile3 = base_url('/uploads/document/npwp/') . "default.jpg";
                                    }
                                    $parameterfile3 = substr($tesfile3, -14);
                                    ?>
                                    <label>Foto NPWP</label>
                                    <embed class="form-group col-md-12" id="output_npwp" type='<?php if (substr($parameterfile3, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile3; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>
                        </div>

                        <!-- upload ijazah -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile4 = base_url('/uploads/document/ijazah/') . $register['ijazah'] . "?" . $t; ?>
                                    <?php if ($register['ijazah'] == "" || $register['ijazah'] == "0") {
                                        $tesfile4 = base_url('/uploads/document/ijazah/') . "default.jpg";
                                    }
                                    $parameterfile4 = substr($tesfile4, -14);
                                    ?>
                                    <label>Foto Ijazah</label>
                                    <embed class="form-group col-md-12" id="output_ijazah" type='<?php if (substr($parameterfile4, 0, 3) == "pdf") {
                                                                                                        echo "application/pdf";
                                                                                                    } else {
                                                                                                        echo "image/jpg";
                                                                                                    }
                                                                                                    ?>' src="<?php echo $tesfile4; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>

                            <!-- upload CV -->
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile5 = base_url('/uploads/document/cv/') . $register['civi'] . "?" . $t; ?>
                                    <?php if ($register['civi'] == "" || $register['civi'] == "0") {
                                        $tesfile5 = base_url('/uploads/document/cv/') . "default.jpg";
                                    }
                                    $parameterfile5 = substr($tesfile5, -14);
                                    ?>
                                    <label>Foto CV</label>
                                    <embed class="form-group col-md-12" id="output_cv" type='<?php if (substr($parameterfile5, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile5; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>

                            <!-- upload SKCK -->
                            <div class="form-group col-md-4">
                                <form action='<?php base_url() . '/register/addRegister' ?>' method='post' enctype="multipart/form-data">
                                    <?php
                                    //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
                                    $t = time();
                                    $tesfile6 = base_url('/uploads/document/skck/') . $register['skck'] . "?" . $t; ?>
                                    <?php if ($register['skck'] == "" || $register['skck'] == "0") {
                                        $tesfile6 = base_url('/uploads/document/skck/') . "default.jpg";
                                    }
                                    $parameterfile6 = substr($tesfile6, -14);
                                    ?>
                                    <label>Foto SKCK</label>
                                    <embed class="form-group col-md-12" id="output_skck" type='<?php if (substr($parameterfile6, 0, 3) == "pdf") {
                                                                                                    echo "application/pdf";
                                                                                                } else {
                                                                                                    echo "image/jpg";
                                                                                                }
                                                                                                ?>' src="<?php echo $tesfile6; ?>"></embed>
                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">UPLOAD</button> -->
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Section Dokumen -->

            <!-- Button trigger modal finish -->
            <button type="button" id="finish" name="finish" onclick="myFunction()" class="btn btn-primary btn-sm btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">
                Selesai
            </button>
        <?php } ?>

    </div>


</div>
<!-- /.container-fluid -->
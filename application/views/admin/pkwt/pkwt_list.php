<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<hr class="border-light m-0 mb-3">

<?php if(in_array('35',$role_resources_ids)) { ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<?php $all_employees = $this->Employees_model->get_all_employees_active();?>
<?php $all_contract_types = $this->Contracts_model->get_all_contract_type();?>
<?php $all_projects = $this->Project_model->get_projects();?>
<?php $all_designations = $this->Designation_model->get_designations();?>
<?php $count_pkwt = $this->Xin_model->count_pkwt();?>
<?php $romawi = $this->Xin_model->tgl_pkwt();?>
<?php $nomor_surat = sprintf("%05d", $count_pkwt).'/'.'PKWT-JKTSC-HR/'.$romawi;?>
<?php $nomor_surat_spb = sprintf("%05d", $count_pkwt).'/'.'SPB-JKTSC-HR/'.$romawi;?>



<div class="card mb-4 <?php echo $get_animate;?> mt-3">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_pkwt');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>

    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      
      <div class="card-body">
        <?php $attributes = array('name' => 'add_location', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/pkwt/add_pkwt', $attributes, $hidden);?>

        <div class="form-body">

<!-- line 1 -->
              <div class="row">
                  <!-- nomor pkwt -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_pkwt_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_pkwt_no');?>" name="pkwt_no" type="text" value="<?php echo $nomor_surat;?>">
                    </div>
                  </div>

                  <!-- nomor spb -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_spb_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_spb_no');?>" name="spb_no" type="text" value="<?php echo $nomor_surat_spb;?>">
                    </div>
                  </div>

                  <!-- start date -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="readonly" name="start_date" type="text" value="">
                    </div>
                  </div>
                  <!-- end date -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="readonly" name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>

<div class="row">

                  <!-- fullname -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="employees"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                      <select class="form-control" name="employees" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                        <?php foreach($all_employees->result() as $emp) {?>
                        <option value="<?php echo $emp->employee_id?>"><?php echo $emp->fullname?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>


                  <!-- jenis kontrak -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contracttype"><?php echo $this->lang->line('xin_contract_type');?></label>
                      <select class="form-control" name="contracttype" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_contract_type');?>">
                        <?php foreach($all_contract_types->result() as $contype) {?>
                        <option value="<?php echo $contype->contract_type_id?>"><?php echo $contype->name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <!-- waktu kontrak -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="waktukontrak"><?php echo $this->lang->line('xin_contract_time');?></label>
                      <select class="form-control" name="waktukontrak" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_contract_time');?>">
                        <option value="1">1 Bulan</option>
                        <option value="2">2 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="5">5 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">1 Tahun</option>
                      </select>
                    </div>
                  </div>
                  <!-- hari kerja -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="harikerja"><?php echo $this->lang->line('xin_working_day');?></label>
                      <select class="form-control" name="harikerja" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_working_day');?>">
                        <option value="5">5 Hari</option>
                        <option value="6">6 Hari</option>
                        <option value="7">7 Hari</option>
                      </select>
                    </div>
                  </div>

</div>

<div class="row">

                  <!-- project -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project"><?php echo $this->lang->line('xin_project');?></label>
                      <select class="form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
                        <?php foreach($all_projects->result() as $project) {?>
                        <option value="<?php echo $project->project_id?>"><?php echo $project->title?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>


                  <!-- posisi --> 
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="designation"><?php echo $this->lang->line('xin_posisi');?></label>
                      <select class="form-control" name="designation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_posisi');?>">
                        <?php foreach($all_designations->result() as $posisi) {?>
                        <option value="<?php echo $posisi->designation_id?>"><?php echo $posisi->designation_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>


                  <!-- city -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="penempatan"><?php echo $this->lang->line('xin_placement');?></label>
                      <input class="form-control" placeholder="Jakarta Selatan, Depok,..." name="penempatan" type="text" value="">
                    </div>
                  </div>

                  <!-- jabatan terakhir -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="jabatan_terakhir"><?php echo $this->lang->line('xin_jabatan_terakhir');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_jabatan_terakhir');?>" name="jabatan_terakhir" type="text" value="">
                    </div>
                  </div>

</div>
<!-- x4 -->
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">
                      <p>* Angka dalam satuan Mata uang Rupian (Rp.).<br>* Isi dengan angka 0 <nol> jika tidak diperlukan.</p>
                    </div>
                  </div>
                </div>
                <!-- basicpay -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="basicpay"><?php echo $this->lang->line('xin_salary_basic');?></label>
                      <input type="text" id="rupiah" class="form-control" placeholder="Rp. 0" name="basicpay" style="text-align:right"/>

                    </div>
                  </div>
                </div>
                <!-- grade -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_grade');?></label>
                      <input type="text" id="rupiahgrade" class="form-control" placeholder="Rp. 0" name="price_grade" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- meal -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_meal').' [ /day ]';?></label>
                      <input type="text" id="rupiahmeal" class="form-control" placeholder="Rp. 0" name="allow_meal" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- transport -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_trans').' [ /day ]';?></label>
                      <input type="text" id="rupiahtrans" class="form-control" placeholder="Rp. 0" name="allow_trans" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- bbm -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_bbm').' [ /day ]';?></label>
                      <input type="text" id="rupiahbbm" class="form-control" placeholder="Rp. 0" name="allow_bbm" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- pulsa -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_internet').' [ /day ]';?></label>
                      <input type="text" id="rupiahinternet" class="form-control" placeholder="Rp. 0" name="allowance_pulsa" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- rent -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_rent').' [ /month ]';?></label>
                      <input type="text" id="rupiahrent" class="form-control" placeholder="Rp. 0" name="allow_rent" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>
                <!-- laptop -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_laptop').' [ /month ]';?></label>
                      <input type="text" id="rupiahlaptop" class="form-control" placeholder="Rp. 0" name="allow_laptop" value="" style="text-align:right"/>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <!-- date payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_date_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_date_payment');?>" readonly="readonly" name="date_payment" type="text">
                    </div>
                  </div>

                  <!-- start periode payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_start_periode_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_periode_payment');?>" readonly="readonly" name="startperiode_payment" type="text">
                    </div>
                  </div>
                  <!-- end periode payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_end_periode_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_periode_payment');?>" readonly="readonly" name="endperiode_payment" type="text">
                    </div>
                  </div>

        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>


            <!-- js Rp. -->

                      <script type="text/javascript">
                          var rupiah = document.getElementById('rupiah');
                          rupiah.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiah.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiah             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiah += separator + ribuan.join('.');
                              }
                   
                              rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                              return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                          }
                      </script>
                      <!-- grade -->
                      <script type="text/javascript">
                          var rupiahgrade = document.getElementById('rupiahgrade');
                          rupiahgrade.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahgrade.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahgrade             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahgrade += separator + ribuan.join('.');
                              }
                   
                              rupiahgrade = split[1] != undefined ? rupiahgrade + ',' + split[1] : rupiahgrade;
                              return prefix == undefined ? rupiahgrade : (rupiahgrade ? 'Rp. ' + rupiahgrade : '');
                          }
                      </script>
                      <!-- meal -->
                      <script type="text/javascript">
                          var rupiahmeal = document.getElementById('rupiahmeal');
                          rupiahmeal.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahmeal.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahmeal             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahmeal += separator + ribuan.join('.');
                              }
                   
                              rupiahmeal = split[1] != undefined ? rupiahmeal + ',' + split[1] : rupiahmeal;
                              return prefix == undefined ? rupiahmeal : (rupiahmeal ? 'Rp. ' + rupiahmeal : '');
                          }
                      </script>
                      <!-- transport -->
                      <script type="text/javascript">
                          var rupiahtrans = document.getElementById('rupiahtrans');
                          rupiahtrans.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahtrans.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahtrans             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahtrans += separator + ribuan.join('.');
                              }
                   
                              rupiahtrans = split[1] != undefined ? rupiahtrans + ',' + split[1] : rupiahtrans;
                              return prefix == undefined ? rupiahtrans : (rupiahtrans ? 'Rp. ' + rupiahtrans : '');
                          }
                      </script>
                      <!-- bbm -->
                      <script type="text/javascript">
                          var rupiahbbm = document.getElementById('rupiahbbm');
                          rupiahbbm.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahbbm.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahbbm             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahbbm += separator + ribuan.join('.');
                              }
                   
                              rupiahbbm = split[1] != undefined ? rupiahbbm + ',' + split[1] : rupiahbbm;
                              return prefix == undefined ? rupiahbbm : (rupiahbbm ? 'Rp. ' + rupiahbbm : '');
                          }
                      </script>
                      <!-- internet -->
                      <script type="text/javascript">
                          var rupiahinternet = document.getElementById('rupiahinternet');
                          rupiahinternet.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahinternet.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahinternet             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahinternet += separator + ribuan.join('.');
                              }
                   
                              rupiahinternet = split[1] != undefined ? rupiahinternet + ',' + split[1] : rupiahinternet;
                              return prefix == undefined ? rupiahinternet : (rupiahinternet ? 'Rp. ' + rupiahinternet : '');
                          }
                      </script>
                      <!-- rental -->
                      <script type="text/javascript">
                          var rupiahrent = document.getElementById('rupiahrent');
                          rupiahrent.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahrent.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahrent             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahrent += separator + ribuan.join('.');
                              }
                   
                              rupiahrent = split[1] != undefined ? rupiahrent + ',' + split[1] : rupiahrent;
                              return prefix == undefined ? rupiahrent : (rupiahrent ? 'Rp. ' + rupiahrent : '');
                          }
                      </script>
                      <!-- laptop -->
                      <script type="text/javascript">
                          var rupiahlaptop = document.getElementById('rupiahlaptop');
                          rupiahlaptop.addEventListener('keyup', function(e){
                              // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                              // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                              rupiahlaptop.value = formatRupiah(this.value, 'Rp. ');
                          });
                          
                          /* Fungsi formatRupiah */
                          function formatRupiah(angka, prefix){
                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                              split           = number_string.split(','),
                              sisa             = split[0].length % 3,
                              rupiahlaptop             = split[0].substr(0, sisa),
                              ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                   
                              // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                              if(ribuan){
                                  separator = sisa ? '.' : '';
                                  rupiahlaptop += separator + ribuan.join('.');
                              }
                   
                              rupiahlaptop = split[1] != undefined ? rupiahlaptop + ',' + split[1] : rupiahlaptop;
                              return prefix == undefined ? rupiahlaptop : (rupiahlaptop ? 'Rp. ' + rupiahlaptop : '');
                          }
                      </script>
                      
    </div>
  </div>
</div>
<?php } ?>




<div class="card <?php echo $get_animate;?>">

  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_nomor_surat');?></th>
            <th><?php echo $this->lang->line('xin_nik');?></th>
            <th><?php echo $this->lang->line('dashboard_fullname');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('xin_project');?></th>
            <th><?php echo $this->lang->line('xin_pkwt_of_days');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
            <th><?php echo $this->lang->line('xin_action');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.info-box-number {
  font-size:15px !important;
  font-weight:300 !important;
}
</style>

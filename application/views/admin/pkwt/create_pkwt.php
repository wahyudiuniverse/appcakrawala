<?php
// Create Invoice Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_pkwt_create_new');?></strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_invoice', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/pkwt/create_new_pkwt', $attributes, $hidden);?>
            <?php $inv_info = last_client_invoice_info(); $linv = $inv_info + 1;?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <!-- nomor pkwt -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_pkwt_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_pkwt_no');?>" name="pkwt_no" type="text" value="">
                    </div>
                  </div>
                  <!-- nomor spb -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_spb_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_spb_no');?>" name="spb_no" type="text" value="">
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

<!-- x1 -->

                <div class="row">
                  <!-- fullname -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="employees"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                      <select class="form-control" name="employees" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                        <?php foreach($all_employees->result() as $emp) {?>
                        <option value="<?php echo $emp->user_id?>"><?php echo $emp->fullname?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- type kontrak -->
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

<!-- x2 -->

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

                  <!-- sub-project -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project_sub"><?php echo $this->lang->line('xin_pkwt_sub_project');?></label>
                      <select class="form-control" name="project_sub" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_pkwt_sub_project');?>">
                        <?php foreach($all_city->result() as $city) {?>
                        <option value="<?php echo $city->city_id?>"><?php echo $city->city_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <!-- penempatan -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="city"><?php echo $this->lang->line('xin_placement');?></label>
                      <select class="form-control" name="city" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_placement');?>">
                        <?php foreach($all_city->result() as $city) {?>
                        <option value="<?php echo $city->city_id?>"><?php echo $city->city_name?></option>
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
                </div>

<!-- x3 payment -->
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

                  <!-- posisi --> 
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="last_position"><?php echo $this->lang->line('xin_posisi').' Terakahir';?></label>
                      <select class="form-control" name="last_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_posisi').' Terakahir';?>">
                        <?php foreach($all_designations->result() as $posisi) {?>
                        <option value="<?php echo $posisi->designation_id?>"><?php echo $posisi->designation_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <hr>
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
                      <label for="invoice_date"><?php echo $this->lang->line('xin_salary_basic');?></label>
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

                <hr>
<!-- x5 -->
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">
                      <h6>Terms &amp; Condition</h6> 
                      <p><?php echo $system_setting[0]->invoice_terms_condition;?></p>
                    </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="pkwt_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_submit_new_pkwt');?></button>
                    </div>
                  </div>
                </div>
<!-- x6 -->

              </div>
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
  </div>
</div>

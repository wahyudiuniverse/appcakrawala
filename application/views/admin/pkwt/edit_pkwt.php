<?php
// Create Invoice Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $info_employee = $this->Employees_model->read_employee_info($info_pkwt[0]->employee_id);?>
<?php $pkwt_id = $info_pkwt[0]->contract_id;?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo 'Nomor Surat: '.$info_pkwt[0]->no_surat .' | '. $info_employee[0]->first_name.' '.$info_employee[0]->last_name;?></strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">

            <?php $attributes = array('name' => 'create_invoice', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/pkwt/update_pkwt/'.$pkwt_id, $attributes, $hidden);?>


            <div class="bg-white">
              <div class="box-block">

              <input hidden name="idpkwt" type="text" value="<?php echo $pkwt_id;?>">

<!-- x1 -->

                <div class="row">

                  <!-- type kontrak -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contracttype"><?php echo $this->lang->line('xin_contract_type');?></label>
                      <select class="form-control" name="contracttype" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_contract_type');?>">
                        <?php foreach($all_contract_types->result() as $contype) {?>
                        <option value="<?php echo $contype->contract_type_id?>" 
                            <?php if($info_pkwt[0]->contract_type_id==$contype->contract_type_id):?> selected="selected"<?php endif;?>
                        ><?php echo $contype->name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- waktu kontrak -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="waktukontrak"><?php echo $this->lang->line('xin_contract_time');?></label>
                      <select class="form-control" name="waktukontrak" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_contract_time');?>">
                        <option value="1" <?php if($info_pkwt[0]->waktu_kontrak=='1'):?> selected="selected"<?php endif;?>>1 Bulan</option>
                        <option value="3" <?php if($info_pkwt[0]->waktu_kontrak=='3'):?> selected="selected"<?php endif;?>>3 Bulan</option>
                        <option value="6" <?php if($info_pkwt[0]->waktu_kontrak=='6'):?> selected="selected"<?php endif;?>>6 Bulan</option>
                        <option value="12" <?php if($info_pkwt[0]->waktu_kontrak=='12'):?> selected="selected"<?php endif;?>>1 Tahun</option>
                      </select>
                    </div>
                  </div>
                  <!-- hari kerja -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="harikerja"><?php echo $this->lang->line('xin_working_day');?></label>
                      <select class="form-control" name="harikerja" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_working_day');?>">
                        <option value="5" <?php if($info_pkwt[0]->hari_kerja=='5'):?> selected="selected"<?php endif;?>>5 Hari</option>
                        <option value="6" <?php if($info_pkwt[0]->hari_kerja=='6'):?> selected="selected"<?php endif;?>>6 Hari</option>
                        <option value="7" <?php if($info_pkwt[0]->hari_kerja=='7'):?> selected="selected"<?php endif;?>>7 Hari</option>
                      </select>
                    </div>
                  </div>

                  <!-- start date -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="readonly" name="start_date" type="text" value="<?php echo $info_pkwt[0]->from_date;?>">
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
                        <option value="<?php echo $project->project_id?>"
                        <?php if($info_pkwt[0]->project==$project->project_id):?> selected="selected"<?php endif;?>
                        ><?php echo $project->title?></option>
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
                        <option value="<?php echo $city->city_id?>"
                          <?php if($info_pkwt[0]->penempatan==$city->city_id):?> selected="selected"<?php endif;?>
                          ><?php echo $city->city_name?></option>
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
                        <option value="<?php echo $posisi->designation_id?>"
                          <?php if($info_pkwt[0]->posisi==$posisi->designation_id):?> selected="selected"<?php endif;?>
                          ><?php echo $posisi->designation_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <!-- end date -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="readonly" name="end_date" type="text" value="<?php echo $info_pkwt[0]->to_date;?>">
                    </div>
                  </div>
                </div>

<!-- x3 payment -->
                <div class="row">
                  <!-- date payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_date_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_date_payment');?>" readonly="readonly" name="date_payment" type="text" value="<?php echo $info_pkwt[0]->tgl_payment;?>">
                    </div>
                  </div>

                  <!-- start periode payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_start_periode_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_periode_payment');?>" readonly="readonly" name="startperiode_payment" type="text" value="<?php echo $info_pkwt[0]->start_period_payment;?>">
                    </div>
                  </div>
                  <!-- end periode payment -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_end_periode_payment');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_periode_payment');?>" readonly="readonly" name="endperiode_payment" type="text" value="<?php echo $info_pkwt[0]->end_period_payment;?>">
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
                      <input type="text" id="rupiah" class="form-control" placeholder="Rp. 0" name="basicpay" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->basic_pay);?>"/>

                    </div>
                  </div>
                </div>
                <!-- grade -->
                <div class="row">
                  <!-- basic salery -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_grade');?></label>
                      <input type="text" id="rupiahgrade" class="form-control" placeholder="Rp. 0" name="price_grade" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_grade);?>"/>
                    </div>
                  </div>
                </div>
                <!-- meal -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_meal').' [ /day ]';?></label>
                      <input type="text" id="rupiahmeal" class="form-control" placeholder="Rp. 0" name="allow_meal" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_meal);?>"/>
                    </div>
                  </div>
                </div>
                <!-- transport -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_trans').' [ /day ]';?></label>
                      <input type="text" id="rupiahtrans" class="form-control" placeholder="Rp. 0" name="allow_trans" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_transport);?>"/>
                    </div>
                  </div>
                </div>
                <!-- bbm -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_bbm').' [ /day ]';?></label>
                      <input type="text" id="rupiahbbm" class="form-control" placeholder="Rp. 0" name="allow_bbm" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_bbm);?>"/>
                    </div>
                  </div>
                </div>
                <!-- pulsa -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_internet').' [ /day ]';?></label>
                      <input type="text" id="rupiahinternet" class="form-control" placeholder="Rp. 0" name="allowance_pulsa" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_pulsa);?>"/>
                    </div>
                  </div>
                </div>
                <!-- rent -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_rent').' [ /month ]';?></label>
                      <input type="text" id="rupiahrent" class="form-control" placeholder="Rp. 0" name="allow_rent" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_rent);?>"/>
                    </div>
                  </div>
                </div>
                <!-- laptop -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_allowance_laptop').' [ /month ]';?></label>
                      <input type="text" id="rupiahlaptop" class="form-control" placeholder="Rp. 0" name="allow_laptop" style="text-align:right" value="<?php echo $this->Xin_model->rupiah($info_pkwt[0]->allowance_laptop);?>"/>
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
                      <button type="submit" name="pkwt_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_update_pkwt');?></button>
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

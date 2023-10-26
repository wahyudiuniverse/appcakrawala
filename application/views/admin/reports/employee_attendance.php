<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
		<?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/employee_attendance', $attributes, $hidden);?>
        <?php
            $data = array(
              'name'        => 'user_id',
              'id'          => 'user_id',
              'value'       => $session['user_id'],
              'type'   		  => 'hidden',
              'class'       => 'form-control',
            );
            
            echo form_input($data);
            ?>
          <div class="form-row">


            <div class="col-md mb-3">

            <label class="form-label">Projects <?php echo $session['employee_id'];?></label>
              <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
                  <option value="0">--</option>
                  <?php if($session['user_id']=='9197'){ echo '<option value="22">PT. SIPRAMA CAKRAWALA</option>'; }?>
                <?php foreach($all_projects as $proj) {?>

                  <option value="<?php echo $proj->project_id;?>"> <?php echo $proj->title;?></option>
                <?php } ?>
              </select>
            </div>


          <div class="col-md mb-3" id="subproject_ajax">
            <label class="form-label">Sub Projects</label>
            <select class="form-control" name="sub_project_id" data-plugin="select_hrm" data-placeholder="Sub Project">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3" id="areaemp_ajax">
            <label class="form-label">Area/Penempatan</label>
            <select class="form-control" name="area_emp" data-plugin="select_hrm" data-placeholder="Area/Penempatan">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
            
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d');?>">
            </div>

            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>


          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_reports_attendance_employee');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th colspan="2"><?php echo $this->lang->line('xin_hr_info');?></th>
                <th colspan="9"><?php echo $this->lang->line('xin_attendance_report');?></th>
              </tr>
              <tr>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Project</th>
                <th>Sub Project</th>
                <th>Area/Penempatan</th>
                <th>ID Toko/Office</th>
                <th>Toko/Office</th>

                <th>Nama Pemilik</th>
                <th>Nomor Kontak</th>

                <th>Tanggal</th>
                <th><?php echo $this->lang->line('dashboard_clock_in');?></th>
                <th><?php echo $this->lang->line('dashboard_clock_out');?></th>
                <th>Koordinat</th>
                <th>Total Jam Kerja</th>
                <th>Foto IN</th>
                <th>Foto OUT</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

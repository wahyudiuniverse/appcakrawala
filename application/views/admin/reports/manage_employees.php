<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'employee_reports', 'id' => 'employee_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/manage_employees', $attributes, $hidden);?>
      <?php
        $data = array(
          'name'  => 'user_id',
          'id'    => 'user_id',
          'type'  => 'hidden',
          'value' => $session['user_id'],
          'class' => 'form-control');
            echo form_input($data);
      ?> 
      
      <div class="form-row">

        <div class="col-md mb-2">
          <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <?php 
              foreach ($all_companies as $company) {
            ?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
            <?php 
              } 
            ?>
          </select>
        </div>

        <div class="col-md mb-2" hidden>
          <div class="form-group">
            <label class="form-label"><?php echo $this->lang->line('xin_employee_department');?></label>
            <select disabled="disabled" class="form-control" name="department_id" id="aj_department" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
          </div>   
        </div>
             
        <div class="col-md mb-2" id="project_ajax">
          <label class="form-label"><?php echo $this->lang->line('left_projects');?></label>
          <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <?php 
              foreach ($all_projects as $projects) {
            ?>
                <option value="<?php echo $projects->project_id?>"><?php echo $projects->title?></option>
            <?php 
              } 
            ?>
          </select>
        </div>


        <div class="col-md mb-2" >
          <div class="form-group" id="subproject_ajax">
            <label class="form-label"><?php echo $this->lang->line('left_sub_projects');?></label>
            <select disabled="disabled" class="form-control" name="subproject_id" id="aj_subproject" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_sub_projects');?>">
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
          </div>   
        </div>

        <div class="col-md mb-2">
          <div class="form-group">
            <label class="form-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status_resign" id="aj_status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
              <option value="1">AKTIF</option>
              <option value="5">DEACTIVE</option>
              <option value="2">RESIGN</option>
              <option value="4">END CONTRACT</option>
              <option value="3">BLACKLIST</option>
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
          </div>   
        </div>


        <div class="col-md col-xl-1  mb-1">
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_report_employees');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th>Status</th>
                <th><?php echo $this->lang->line('xin_nip');?></th>
                <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                <th>PIN</th>
                <th><?php echo $this->lang->line('left_company');?></th>
                <th><?php echo $this->lang->line('left_department');?></th>
                <th><?php echo $this->lang->line('left_designation');?></th>
                <th><?php echo $this->lang->line('left_projects');?></th>
                <th><?php echo $this->lang->line('left_sub_projects');?></th>                
                <th>Area</th>               
                <th>Region</th>
                <th>Tempat Lahir</th>                
                <th><?php echo $this->lang->line('xin_employee_dob');?></th>                
                <th><?php echo $this->lang->line('xin_employee_doj');?></th>  

                <th>Mulai Kontrak</th>   
                <th>Akhir Kontrak</th>   
                <th>Gaji Pokok</th>   

                <th>Tanggal Resign</th>
                                
                <th><?php echo $this->lang->line('xin_employee_gender');?></th>
                <th><?php echo $this->lang->line('xin_employee_mstatus');?></th>
                <th>Agama</th>                
                <th><?php echo $this->lang->line('dashboard_email');?></th>
                <th><?php echo $this->lang->line('xin_contact_number');?></th>
                <th>Pendidikan</th>
                <th><?php echo $this->lang->line('xin_address');?></th>    
                <th>Alamat Domisili</th>                
                <th><?php echo $this->lang->line('xin_kk');?></th>
                <th><?php echo $this->lang->line('xin_ktp');?></th>
                <th><?php echo $this->lang->line('xin_npwp');?></th>
                <th>BPJS-TK</th>
                <th>BPJS-KS</th>
                <th>Nama Ibu Kandung</th>
                <th>Nama Bank</th>
                <th>No. Rekening</th>
                <th>Nama Pemilik Rek.</th>

                <th>Foto KTP</th>   
                <th>Foto KK</th>    
                <th>Foto NPWP</th>   
                <th>Foto Ijazah</th>   
                <th>Dok SKCK</th>   
                <th>Dok CV</th>
                <th>Dok Paklaring</th>
                <th>PKWT</th>
                <th>Tanggal Upload PKWT</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

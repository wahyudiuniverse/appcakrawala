<?php
/* Employees report view
*/

?>

<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">





  <div class="card <?php echo $get_animate;?>">
    <div class="form-row">
      <div class="col-md mb-3">

    <input readonly id="uploadid" name="uploadid" type="hidden" value="<?php echo $uploadid;?>">
    
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Kode : <?php echo $uploadid;?></strong></span> </div>
      </div>

      <div class="col-md mb-3">
      </div>

      <div class="col-md mb-3">   
      </div>

      <div class="col-md-3">
      </div>         


    </div>


      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table" style="width:100%;table-layout: fixed;">
            <thead>
              <tr>
                <th>Status</th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Project</th>
                <th>Sub-Project</th>
                <th>Area</th>

                <th>Gapok UMK</th>
                <th>Gapok Diterima</th>
                <th>BPJS Ketenagakerjaan</th>
                <th>BPJS Kesehatan</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

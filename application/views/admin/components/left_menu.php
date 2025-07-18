<?php
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if ($theme[0]->right_side_icons == 'true') {
  $icons_right = 'expanded menu-icon-right';
} else {
  $icons_right = '';
}

if ($theme[0]->bordered_menu == 'true') {
  $menu_bordered = 'menu-bordered';
} else {
  $menu_bordered = '';
}

$user_info = $this->Xin_model->read_user_info($session['user_id']);
if ($user_info[0]->is_active != 1) {
  redirect('admin/');
}

$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if (!is_null($role_user)) {
  $role_resources_ids = explode(',', $role_user[0]->role_resources);
} else {
  $role_resources_ids = explode(',', 0);
}
?>


<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(), $this->router->fetch_method()); ?>
<?php $count_emp_resign = $this->Xin_model->count_emp_resign(); ?>
<?php

if ($theme[0]->sub_menu_icons != '') {
  $submenuicon = $theme[0]->sub_menu_icons;
} else {
  $submenuicon = 'fa-circle-o';
}

// reports to
$reports_to = get_reports_team_data($session['user_id']);
?>

<?php
if ($user_info[0]->profile_picture != '' && $user_info[0]->profile_picture != 'no file') {
?>
  <?php $cpimg = base_url() . 'uploads/profile/' . $user_info[0]->profile_picture; ?>
<?php
} else {
?>

  <?php
  if ($user_info[0]->gender == 'Male') {
  ?>
    <?php $de_file = base_url() . 'uploads/profile/default_male.jpg'; ?>
  <?php
  } else {
  ?>
    <?php $de_file = base_url() . 'uploads/profile/default_female.jpg'; ?>
  <?php
  }
  ?>
  <?php $cpimg = $de_file; ?>
<?php
}
?>

<ul class="sidenav-inner py-1">
  <!-- Dashboards -->
  <li class="sidenav-item <?php if (!empty($arr_mod['active'])) echo $arr_mod['active']; ?>">
    <a href="<?php echo site_url('admin/dashboard'); ?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-speedometer"></i>
      <div><?php echo $this->lang->line('dashboard_title'); ?></div>
    </a>
  </li>

  <!-- profile -->
  <?php
  if (in_array('132', $role_resources_ids)) {
  ?>

    <li class="sidenav-item <?php if (!empty($arr_mod['activep'])) echo $arr_mod['activep']; ?>">
      <a href="<?php echo site_url('admin/employees/emp_view/' . $session['employee_id']); ?>" class="sidenav-link">
        <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('header_my_profile'); ?></div>
      </a>
    </li>
  <?php
  }
  ?>



  <!-- CEK NIP -->
  <?php
  if (in_array('134', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['ceknip_active'])) echo $arr_mod['ceknip_active']; ?>">
      <a href="<?php echo site_url('admin/ceknip/'); ?>" class="sidenav-link">
        <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Check NIP</div>
      </a>
    </li>
  <?php
  }
  ?>

  <!-- hotspot -->
  <?php
  if (in_array('393', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['hotspot_active'])) echo $arr_mod['hotspot_active']; ?>">
      <a href="<?php echo site_url('admin/hotspot/'); ?>" class="sidenav-link">
        <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Access Hotspot</div>
      </a>
    </li>
  <?php
  }
  ?>




  <?php
  if (
    in_array('7', $role_resources_ids)
    || $reports_to > 0
    || $user_info[0]->user_role_id == 1
  ) {
  ?>

    <li class="<?php if (!empty($arr_mod['stff_open'])) echo $arr_mod['stff_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon fas fa-user-friends"></i>
        <div>Employees Roles</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if ($user_info[0]->user_role_id == 1) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['roles_active'])) echo $arr_mod['roles_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/roles/'); ?>"> <?php echo $this->lang->line('left_set_roles'); ?>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('7', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['shift_active'])) echo $arr_mod['shift_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/office_shift/'); ?>"> <?php echo $this->lang->line('left_office_shifts'); ?>
            </a>
          </li>
        <?php
        }
        ?>


      </ul>
    </li>
  <?php
  }
  ?>


  <!-- MENU CALL CENTER -->
  <?php
  if (in_array('479', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['callcenter_open'])) echo $arr_mod['callcenter_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('xin_menu_cs'); ?></div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('480', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['whatsapp_active'])) echo $arr_mod['whatsapp_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/Customerservices/'); ?>"> <?php echo $this->lang->line('xin_whatsapp_blast'); ?>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>


  <!-- pkwt -->
  <?php
  if (
    in_array('34', $role_resources_ids)
    || in_array('58', $role_resources_ids)
    || in_array('67', $role_resources_ids)
  ) {
  }
  ?>

  <!-- customer -->
  <?php
  if (in_array('69', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['customer_open'])) echo $arr_mod['customer_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('xin_customer'); ?></div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('69', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['customer_active'])) echo $arr_mod['customer_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/customers/'); ?>"> <?php echo $this->lang->line('xin_customer'); ?>
            </a>
          </li>
        <?php
        }
        ?>
        <?php
        if (in_array('11923', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['clients_active'])) echo $arr_mod['clients_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/pkwtexpired'); ?>"> <?php echo $this->lang->line('xin_pkwt_expired'); ?>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>



  <!-- MANAGE EMP -->
  <?php
  if (in_array('470', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['emp_manage_open'])) echo $arr_mod['emp_manage_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Database</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('470', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['man_employees_active'])) echo $arr_mod['man_employees_active']; ?>">
            <a href="<?php echo site_url('admin/reports/manage_employees'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Karyawan</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('470', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['man_client_active'])) echo $arr_mod['man_client_active']; ?>">
            <a href="<?php echo site_url('admin/reports/manage_client'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Klien</div>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>



  <!-- PERMINTAAN KARYAWAN BARU -->
  <?php
  if (
    in_array('327', $role_resources_ids) ||
    in_array('337', $role_resources_ids) ||
    in_array('338', $role_resources_ids) ||
    in_array('374', $role_resources_ids) ||
    in_array('375', $role_resources_ids) ||
    in_array('338', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['emp_request_open'])) echo $arr_mod['emp_request_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Daftar Karyawan Baru</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('5555', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_active'])) echo $arr_mod['emp_request_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>AREA</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('55555', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_nae_active'])) echo $arr_mod['emp_request_nae_active']; ?>">
            <a href="<?php echo site_url('admin/reports/new_employees/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>KARYAWAN BARU</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('5555', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_nom_active'])) echo $arr_mod['emp_request_nom_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request_nom/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>HO - NOM</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('5555', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_sm_active'])) echo $arr_mod['emp_request_sm_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request_sm'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>HO - SM</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('327', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_hrd_active'])) echo $arr_mod['emp_request_hrd_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request_hrd/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Karyawan Baru</div>
            </a>
          </li>
        <?php
        }
        ?>

        <!-- <?php
              if (in_array('312', $role_resources_ids)) { ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_tkhl_active'])) echo $arr_mod['emp_request_tkhl_active']; ?>"> 
              <a href="<?php echo site_url('admin/employee_request_tkhl/'); ?>" class="sidenav-link"> 
              <i class="sidenav-icon ion ion-logo-buffer"></i>
                <div>KARYAWAN TKHL</div>
              </a> 
            </li>
          <?php
              }
          ?>  -->

        <?php
        if (in_array('338', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['emp_request_cancel_active'])) echo $arr_mod['emp_request_cancel_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request_cancelled'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>DITOLAK</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('55555', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['man_employees_approve_active'])) echo $arr_mod['man_employees_approve_active']; ?>">
            <a href="<?php echo site_url('admin/employee_request_approve'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Monitor Karyawan</div>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>



  <!-- PERPANJANGAN PKWT -->
  <?php
  if (
    in_array('376', $role_resources_ids) ||
    in_array('379', $role_resources_ids) ||
    in_array('377', $role_resources_ids) ||
    in_array('503', $role_resources_ids) ||
    in_array('504', $role_resources_ids) ||
    in_array('505', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['pkwt_request_open'])) echo $arr_mod['pkwt_request_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Perpanjang PKWT</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('377', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pkwt_request_active'])) echo $arr_mod['pkwt_request_active']; ?>">
            <a href="<?php echo site_url('admin/reports/pkwt_expired/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>PKWT EXPIRED</div>
            </a>
          </li>
        <?php
        }
        ?>


        <?php
        if (in_array('505', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pkwt_request_hrd_active'])) echo $arr_mod['pkwt_request_hrd_active']; ?>">
            <a href="<?php echo site_url('admin/employee_pkwt_aphrd'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>HRD CHECKER</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('379', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pkwt_request_cancel_active'])) echo $arr_mod['pkwt_request_cancel_active']; ?>">
            <a href="<?php echo site_url('admin/employee_pkwt_cancel'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>PKWT DITOLAK</div>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>



  <!-- PERMINTAAN PAKLARING -->
  <?php
  if (
    in_array('491', $role_resources_ids) ||
    in_array('506', $role_resources_ids) ||
    in_array('492', $role_resources_ids) ||
    in_array('493', $role_resources_ids) ||
    in_array('494', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['resign_req_resign'])) echo $arr_mod['resign_req_resign']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Permintaan Paklaring</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('491', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_req_emp_active'])) echo $arr_mod['resign_req_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Ajukan Paklaring</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('506', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_cancel_emp_active'])) echo $arr_mod['resign_cancel_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign_cancelled'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Ditolak</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('492', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_nae_emp_active'])) echo $arr_mod['resign_nae_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign_apnae'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Approval NAE</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('493', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_nom_emp_active'])) echo $arr_mod['resign_nom_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign_apnom'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Approval NOM/SM</div>
            </a>
          </li>
        <?php
        }
        ?>


        <?php
        if (in_array('494', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_hrd_emp_active'])) echo $arr_mod['resign_hrd_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign_aphrd'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Approval HRD</div>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('490', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['resign_history_emp_active'])) echo $arr_mod['resign_history_emp_active']; ?>">
            <a href="<?php echo site_url('admin/employee_resign_history'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>History Paklaring</div>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>


  <!-- REPORT PKWT, REPORT ADDENDUM -->
  <?php
  if (
    in_array('380', $role_resources_ids) ||
    in_array('379', $role_resources_ids) ||
    in_array('377', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['report_open'])) echo $arr_mod['report_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Laporan Admin</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('380', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['report_active'])) echo $arr_mod['report_active']; ?>">
            <a href="<?php echo site_url('admin/reports/pkwt_history/'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Laporan PKWT</div>
            </a>
          </li>
        <?php
        }
        ?>



        <?php
        if (in_array('520', $role_resources_ids)) { ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['report_active'])) echo $arr_mod['report_active']; ?>">
            <a href="<?php echo site_url('admin/addendum/report_addendum'); ?>" class="sidenav-link">
              <!-- <i class="sidenav-icon fa fa-calculator"></i> -->
              <i class="sidenav-icon ion ion-logo-buffer"></i>
              <div>Laporan Adendum</div>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>



  <!-- Surat Keterangan Kerja / Paklaring -->
  <?php
  if (in_array('486', $role_resources_ids) || in_array('499', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['dokumen_open'])) echo $arr_mod['dokumen_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('xin_document_id'); ?></div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('487', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['skk_active'])) echo $arr_mod['skk_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/skk/'); ?>"> <?php echo $this->lang->line('xin_surat_keterangan_kerja'); ?> &nbsp; <span class="badge badge-success badge-pill">
                <?php echo $count_emp_resign; ?>
              </span>
            </a>
          </li>
        <?php
        }
        ?>
        <?php
        if (in_array('499', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['skk_report_active'])) echo $arr_mod['skk_report_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/reports/skk_report'); ?>"> <?php echo $this->lang->line('xin_sk_report'); ?>
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>
  <?php
  }
  ?>


  <!-- payroll -->
  <?php
  if ($system[0]->module_payroll == 'yes') {
  ?>
    <?php
    if (in_array('36', $role_resources_ids) && in_array('37', $role_resources_ids)) { ?>
      <li class="sidenav-item <?php if (!empty($arr_mod['pay_generate_active'])) echo $arr_mod['pay_generate_active']; ?>">
        <a href="<?php echo site_url('admin/payroll/generate_payslip/'); ?>" class="sidenav-link">
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('left_payroll'); ?></div>
        </a>
      </li>
    <?php
    }
    ?>
    <?php
    if (in_array('36', $role_resources_ids) && !in_array('37', $role_resources_ids)) {
    ?>
      <li class="sidenav-item <?php if (!empty($arr_mod['pay_generate_active'])) echo $arr_mod['pay_generate_active']; ?>">
        <a href="<?php echo site_url('admin/payroll/generate_payslip/'); ?>" class="sidenav-link">
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('left_payroll'); ?></div>
        </a>
      </li>
    <?php
    }
    ?>
  <?php
  }
  ?>

  <!-- finance -->
  <?php
  if ($system[0]->module_accounting == 'true') {
  ?>
    <?php
    if (
      in_array('286', $role_resources_ids)
      || in_array('72', $role_resources_ids)
      || in_array('75', $role_resources_ids)
      || in_array('76', $role_resources_ids)
      || in_array('77', $role_resources_ids)
      || in_array('78', $role_resources_ids)
    ) {
    ?>
      <li class="<?php if (!empty($arr_mod['hr_acc_open'])) echo $arr_mod['hr_acc_open']; ?> sidenav-item">
        <a href="#" class="sidenav-link sidenav-toggle">
          <i class="sidenav-icon ion ion-md-cash"></i>
          <div><?php echo $this->lang->line('xin_hr_finance'); ?></div>
        </a>

        <ul class="sidenav-menu">
          <?php
          if (in_array('286', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['dashboard_accounting_active'])) echo $arr_mod['dashboard_accounting_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/accounting_dashboard/'); ?>"> <?php echo $this->lang->line('hr_accounting_dashboard_title'); ?>
              </a>
            </li>
          <?php
          }
          ?>
          <?php
          if (in_array('72', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['bank_cash_act'])) echo $arr_mod['bank_cash_act']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/bank_cash/'); ?>"> <?php echo $this->lang->line('xin_acc_account_list'); ?> </a>
            </li>
          <?php
          }
          ?>
          <?php
          if (in_array('75', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['deposit_active'])) echo $arr_mod['deposit_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/deposit/'); ?>"> <?php echo $this->lang->line('xin_acc_deposit'); ?> </a>
            </li>
          <?php
          }
          ?>
          <?php
          if (in_array('76', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['expense_active'])) echo $arr_mod['expense_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/expense/'); ?>"> <?php echo $this->lang->line('xin_acc_expense'); ?> </a>
            </li>
          <?php
          }
          ?>
          <?php
          if (in_array('77', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['transfer_active'])) echo $arr_mod['transfer_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transfer/'); ?>"> <?php echo $this->lang->line('xin_acc_transfer'); ?> </a>
            </li>
          <?php
          }
          ?>
          <?php
          if (in_array('78', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['transactions_active'])) echo $arr_mod['transactions_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transactions/'); ?>"> <?php echo $this->lang->line('xin_acc_transactions'); ?> </a>
            </li>
          <?php
          }
          ?>
        </ul>
      </li>
    <?php
    }
    ?>
  <?php
  }
  ?>

  <!-- core hr -->
  <?php
  if (
    in_array('12', $role_resources_ids)
    || in_array('14', $role_resources_ids)
    || in_array('15', $role_resources_ids)
    || in_array('16', $role_resources_ids)
    || in_array('17', $role_resources_ids)
    || in_array('18', $role_resources_ids)
    || in_array('19', $role_resources_ids)
    || in_array('20', $role_resources_ids)
    || in_array('21', $role_resources_ids)
    || in_array('22', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['emp_open'])) echo $arr_mod['emp_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-ios-globe"></i>
        <div><?php echo $this->lang->line('xin_hr'); ?></div>
      </a>
      <ul class="sidenav-menu">
        <?php
        if ($system[0]->module_awards == 'true') {
        ?>
          <?php
          if (in_array('14', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['awar_active'])) echo $arr_mod['awar_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/awards'); ?>"> <?php echo $this->lang->line('left_awards'); ?> </a>
            </li>
          <?php
          }
          ?>
        <?php
        }
        ?>

        <?php
        if (in_array('15', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['tra_active'])) echo $arr_mod['tra_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/transfers'); ?>"> <?php echo $this->lang->line('left_transfers'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('16', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['res_active'])) echo $arr_mod['res_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/resignation'); ?>"> <?php echo $this->lang->line('left_resignations'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if ($system[0]->module_travel == 'true') {
        ?>
          <?php
          if (in_array('17', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['trav_active'])) echo $arr_mod['trav_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/travel'); ?>"> <?php echo $this->lang->line('left_travels'); ?> </a>
            </li>
          <?php
          }
          ?>

        <?php
        }
        ?>

        <?php
        if (in_array('18', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pro_active'])) echo $arr_mod['pro_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/promotion'); ?>"> <?php echo $this->lang->line('left_promotions'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('19', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['compl_active'])) echo $arr_mod['compl_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/complaints'); ?>"> <?php echo $this->lang->line('left_complaints'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('20', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['warn_active'])) echo $arr_mod['warn_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/warning'); ?>"> <?php echo $this->lang->line('left_warnings'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('21', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['term_active'])) echo $arr_mod['term_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/termination'); ?>"> <?php echo $this->lang->line('left_terminations'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('22', $role_resources_ids) || $reports_to > 0) {
        ?>
          <li class="<?php if (!empty($arr_mod['emp_ll_active'])) echo $arr_mod['emp_ll_active']; ?> sidenav-item">
            <a href="<?php echo site_url('admin/employees_last_login'); ?>" class="sidenav-link"> <?php echo $this->lang->line('left_employees_last_login'); ?></a>
          </li>
        <?php
        }
        ?>
      </ul>
    </li>
  <?php
  }
  ?>

  <!-- organization -->
  <?php
  if (
    in_array('2', $role_resources_ids)
    || in_array('3', $role_resources_ids)
    || in_array('4', $role_resources_ids)
    || in_array('5', $role_resources_ids)
    || in_array('6', $role_resources_ids)
    || in_array('11', $role_resources_ids)
    || in_array('9', $role_resources_ids)
    || in_array('119', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['adm_open'])) echo $arr_mod['adm_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-md-business"></i>
        <div><?php echo $this->lang->line('left_organization'); ?></div>
      </a>
      <ul class="sidenav-menu">
        <?php
        if (in_array('5', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['com_active'])) echo $arr_mod['com_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/company/'); ?>"> <?php echo $this->lang->line('xin_companies'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('44', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['project_active'])) echo $arr_mod['project_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/project/'); ?>"> <?php echo $this->lang->line('left_projects'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('130', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['sub_project_active'])) echo $arr_mod['sub_project_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/subproject/'); ?>"> <?php echo $this->lang->line('xin_pkwt_sub_project'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('4', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['des_active'])) echo $arr_mod['des_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/designation/'); ?>"> Posisi/Jabatan </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('207', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['mapposisi_active'])) echo $arr_mod['mapposisi_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/project_posisi/'); ?>"> Mapping Project-Posisi </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('207', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['akses_project_active'])) echo $arr_mod['akses_project_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/akses_project/'); ?>"> <?php echo $this->lang->line('xin_akses_project'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('478', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['esign_active'])) echo $arr_mod['esign_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/esign/'); ?>"> <?php echo $this->lang->line('xin_esign_register'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('11', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['ann_active'])) echo $arr_mod['ann_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/announcement/'); ?>"> <?php echo $this->lang->line('left_announcements'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('9', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pol_active'])) echo $arr_mod['pol_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/policy/'); ?>"> <?php echo $this->lang->line('header_policies'); ?> </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </li>
  <?php
  }
  ?>


  <!-- BUDGET -->
  <?php
  if (
    in_array('71', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['budgeting_open'])) echo $arr_mod['budgeting_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>BUDGETTING</div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('711', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['pengajuan_sp_active'])) echo $arr_mod['pengajuan_sp_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/budget/report2'); ?>">Pengajuan Budgetting
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('712', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['budget_invoice_active'])) echo $arr_mod['budget_invoice_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/budget/po'); ?>">PO Budgetting
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('713', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['budget_report_active'])) echo $arr_mod['budget_report_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/budget/report_invoice'); ?>">Report Invoice
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>

  <?php
  }
  ?>



  <!-- Saltab -->
  <?php
  if (
    in_array('510', $role_resources_ids)
    || in_array('511', $role_resources_ids)
    || in_array('512', $role_resources_ids)
    || in_array('513', $role_resources_ids)
    || in_array('514', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['saltab_open'])) echo $arr_mod['saltab_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>SALTAB</div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('511', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['import_esaltab_active'])) echo $arr_mod['import_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/importesaltab'); ?>"> Import SALTAB
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('512', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['conf_esaltab_active'])) echo $arr_mod['conf_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/konfig_import_esaltab'); ?>"> Konfigurasi Import SALTAB
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('513', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['manage_esaltab_active'])) echo $arr_mod['manage_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/manage_esaltab'); ?>"> Manage SALTAB
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('514', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['download_esaltab_active'])) echo $arr_mod['download_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/download_esaltab'); ?>"> Download SALTAB
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('515', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['konfig_download_esaltab_active'])) echo $arr_mod['konfig_download_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/konfig_download_esaltab'); ?>"> Konfigurasi Download SALTAB
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>

  <?php
  }
  ?>

  <!-- BUPOT -->
  <?php
  if (
    in_array('1300', $role_resources_ids)
    || in_array('1301', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['saltab_open'])) echo $arr_mod['saltab_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>BUPOT</div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('1300', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['import_esaltab_active'])) echo $arr_mod['import_esaltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/import_bupot'); ?>"> Manajemen BUPOT
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>

  <?php
  }
  ?>

  <!-- BPJS -->
  <?php
  if (
    in_array('1400', $role_resources_ids)
    || in_array('1401', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['bpjs_open'])) echo $arr_mod['bpjs_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>BPJS</div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('1400', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['manage_bpjs_active'])) echo $arr_mod['manage_bpjs_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/import_bpjs'); ?>"> Manajemen BPJS
            </a>
          </li>
        <?php
        }
        ?>

      </ul>
    </li>

  <?php
  }
  ?>

  <!-- import modul -->
  <?php
  if (
    in_array('126', $role_resources_ids)
    || in_array('127', $role_resources_ids)
    || in_array('232', $role_resources_ids)
    || in_array('469', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['importexcel_open'])) echo $arr_mod['importexcel_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('xin_import_modul'); ?></div>
      </a>

      <ul class="sidenav-menu">


        <?php
        if (in_array('127', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['employees_active'])) echo $arr_mod['employees_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/'); ?>"> <?php echo $this->lang->line('xin_import_excl_employee'); ?>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('128', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['importpkwt_active'])) echo $arr_mod['importpkwt_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/importpkwt'); ?>"> Import PKWT
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('232', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['ratecard_active'])) echo $arr_mod['ratecard_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/importratecard'); ?>"> <?php echo $this->lang->line('xin_import_excl_ratecard'); ?>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('481', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['imp_saltab_active'])) echo $arr_mod['imp_saltab_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/importsaltab'); ?>"> Import Saltab to BPJS
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('469', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['eslip_active'])) echo $arr_mod['eslip_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/importexcel/importeslip'); ?>"> <?php echo $this->lang->line('xin_import_excl_eslip'); ?>
            </a>
          </li>
        <?php
        }
        ?>



      </ul>
    </li>
  <?php
  }
  ?>


  <!-- calendar -->
  <?php
  if (in_array('95', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['calendar_hr_active'])) echo $arr_mod['calendar_hr_active']; ?>">
      <a href="<?php echo site_url('admin/calendar/hr/'); ?>" class="sidenav-link">
        <i class="sidenav-icon oi oi-calendar"></i>
        <div><?php echo $this->lang->line('xin_hr_calendar_title'); ?></div>
      </a>
    </li>
  <?php
  }
  ?>

  <!-- payslip -->
  <?php
  if ($system[0]->module_payroll == 'yes') {
  ?>
    <?php
    if (!in_array('36', $role_resources_ids) && in_array('37', $role_resources_ids)) {
    ?>
      <li class="sidenav-item <?php if (!empty($arr_mod['pay_generate_active'])) echo $arr_mod['pay_generate_active']; ?>">
        <a href="<?php echo site_url('admin/payroll/payment_history/'); ?>" class="sidenav-link">
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('xin_payslip_history'); ?></div>
        </a>
      </li>
    <?php
    }
    ?>
  <?php
  }
  ?>


  <!-- user mobile -->
  <?php
  if (in_array('59', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['usermobile_open'])) echo $arr_mod['usermobile_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>User Traxes</div>
      </a>

      <ul class="sidenav-menu">
        <?php
        if (in_array('59', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['project_active'])) echo $arr_mod['project_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/usermobile/'); ?>"> <?php echo $this->lang->line('xin_user_mobile'); ?>
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('105', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['callplan_active'])) echo $arr_mod['callplan_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/callplan'); ?>"> <?php echo $this->lang->line('xin_callplan'); ?>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </li>
  <?php
  }
  ?>

  <!-- REPORT TRAXES -->
  <?php
  if (in_array('11', $role_resources_ids) || 
    in_array('110', $role_resources_ids) || 
    in_array('111', $role_resources_ids)) {
  ?>
    <li class="<?php if (!empty($arr_mod['reports_open'])) echo $arr_mod['reports_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div>Report Traxes</div>
      </a>

      <ul class="sidenav-menu">

        <?php
        if (in_array('110', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['traxes_active'])) echo $arr_mod['traxes_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/traxes_report_cio/'); ?>"> Check In-Out Report
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('111', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['traxes_order_active'])) echo $arr_mod['traxes_order_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/traxes_report_order/'); ?>"> Sellout Report
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('112', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['traxes_stock_active'])) echo $arr_mod['traxes_stock_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/traxes_report_stock/'); ?>"> Sellin Report
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('114', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['traxes_display_active'])) echo $arr_mod['traxes_display_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/traxes_report_display/'); ?>"> Display Report
            </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('113', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['traxes_summary_active'])) echo $arr_mod['traxes_summary_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/traxes_report_summary/'); ?>"> Summary Report
            </a>
          </li>
        <?php
        }
        ?>
        
        <?php
        if (in_array('105', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['callplan_active'])) echo $arr_mod['callplan_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/callplan'); ?>"> <?php echo $this->lang->line('xin_callplan'); ?>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </li>
  <?php
  }
  ?>

  <!-- invoice -->
    <li>

<div><br></div>
    </li>


  <?php
  if (in_array('46', $role_resources_ids) && in_array('409', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['leave_active'])) echo $arr_mod['leave_active']; ?>">
      <a href="<?php echo site_url('admin/timesheet/leave/'); ?>" class="sidenav-link">
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('xin_manage_leaves'); ?></div>
      </a>
    </li>
  <?php
  }
  ?>

  <?php
  if (in_array('46', $role_resources_ids) && !in_array('409', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['leave_active'])) echo $arr_mod['leave_active']; ?>">
      <a href="<?php echo site_url('admin/timesheet/leave/'); ?>" class="sidenav-link">
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('xin_manage_leaves'); ?></div>
      </a>
    </li>
  <?php
  }
  ?>

  <?php
  if (!in_array('46', $role_resources_ids) && in_array('409', $role_resources_ids)) {
  ?>
    <li class="sidenav-item <?php if (!empty($arr_mod['leave_active'])) echo $arr_mod['leave_active']; ?>">
      <a href="<?php echo site_url('admin/reports/employee_leave/'); ?>" class="sidenav-link">
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('xin_leave_status'); ?></div>
      </a>
    </li>
  <?php
  }
  ?>

  <!-- estimates -->
  <?php
  if (
    in_array('415', $role_resources_ids)
    || in_array('410', $role_resources_ids)
    || in_array('427', $role_resources_ids)
    || in_array('428', $role_resources_ids)
    || in_array('429', $role_resources_ids)
    || in_array('430', $role_resources_ids)
  ) {
  ?>
    <li class="<?php if (!empty($arr_mod['hr_quote_manager_open'])) echo $arr_mod['hr_quote_manager_open']; ?> sidenav-item">
      <a href="#" class="sidenav-link sidenav-toggle">
        <i class="sidenav-icon fa fa-tasks"></i>
        <div><?php echo $this->lang->line('xin_estimates'); ?></div>
      </a>
      <ul class="sidenav-menu">
        <?php
        if (in_array('415', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['all_quotes_active'])) echo $arr_mod['all_quotes_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/quotes/'); ?>"> <?php echo $this->lang->line('xin_estimates'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('427', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['quote_calendar_active'])) echo $arr_mod['quote_calendar_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/quote_calendar/'); ?>"> <?php echo $this->lang->line('xin_quote_calendar'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('429', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['leadsl_quotes_active'])) echo $arr_mod['leadsl_quotes_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/leads/'); ?>"> <?php echo $this->lang->line('xin_leads'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('430', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['timelogs_quotes_active'])) echo $arr_mod['timelogs_quotes_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/timelogs/'); ?>"> <?php echo $this->lang->line('xin_project_timelogs'); ?> </a>
          </li>
        <?php
        }
        ?>

        <?php
        if (in_array('428', $role_resources_ids)) {
        ?>
          <li class="sidenav-item <?php if (!empty($arr_mod['quoted_projects_active'])) echo $arr_mod['quoted_projects_active']; ?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/'); ?>"> <?php echo $this->lang->line('xin_quoted_projects'); ?> </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </li>
  <?php
  } //297
  ?>

  <!-- JOB POST -->
  <?php
  if ($system[0]->module_recruitment == 'true') {
  ?>
    <?php
    if (
      in_array('49', $role_resources_ids)
      || in_array('51', $role_resources_ids)
      || in_array('52', $role_resources_ids)
      || in_array('296', $role_resources_ids)
    ) {
    ?>
      <li class="<?php if (!empty($arr_mod['recruit_open'])) echo $arr_mod['recruit_open']; ?> sidenav-item">
        <a href="#" class="sidenav-link sidenav-toggle">
          <i class="sidenav-icon fas fa-newspaper"></i>
          <div><?php echo $this->lang->line('left_recruitment'); ?></div>
        </a>
        <ul class="sidenav-menu">
          <?php
          if (in_array('49', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['jb_post_active'])) echo $arr_mod['jb_post_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/job_post/'); ?>"> <?php echo $this->lang->line('left_job_posts'); ?> </a>
            </li>
          <?php
          }
          ?>

          <?php
          if (in_array('51', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['job_candidates_active'])) echo $arr_mod['job_candidates_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/job_candidates/'); ?>"> <?php echo $this->lang->line('left_job_candidates'); ?> </a>
            </li>
          <?php
          }
          ?>

          <?php
          if (in_array('52', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['jb_employer_active'])) echo $arr_mod['jb_employer_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/job_post/employer/'); ?>"> <?php echo $this->lang->line('xin_jobs_employer'); ?> </a>
            </li>
          <?php
          }
          ?>

          <?php
          if (in_array('296', $role_resources_ids)) {
          ?>
            <li class="sidenav-item <?php if (!empty($arr_mod['jb_pages_active'])) echo $arr_mod['jb_pages_active']; ?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/job_post/pages/'); ?>"> <?php echo $this->lang->line('xin_jobs_cms_pages'); ?> </a>
            </li>
          <?php
          }
          ?>
        </ul>
      </li>
    <?php
    }
    ?>
  <?php
  }
  ?>


  <?php $hr_top_menu = explode(',', $system[0]->hr_top_menu); ?>
  <?php if ($system[0]->module_assets == 'true') { ?>
    <?php if (in_array('assets', $hr_top_menu)) : ?>
      <?php if (in_array('24', $role_resources_ids) && in_array('25', $role_resources_ids) && in_array('26', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/assets'); ?>"> <i class="ion ion-md-today sidenav-icon"></i>
            <div><?php echo $this->lang->line('xin_assets'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('assets_category', $hr_top_menu)) : ?>
      <?php if (!in_array('25', $role_resources_ids) && in_array('26', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/assets/category'); ?>"> <i class="ion ion-md-today sidenav-icon"></i>
            <div><?php echo $this->lang->line('xin_assets_category'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('assets', $hr_top_menu)) : ?>
      <?php if (in_array('25', $role_resources_ids) && !in_array('26', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/assets/'); ?>"> <i class="ion ion-md-today sidenav-icon"></i>
            <div><?php echo $this->lang->line('xin_assets'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
  <?php } ?>

  <?php if ($system[0]->module_training == 'true') { ?>
    <?php if (in_array('training', $hr_top_menu)) : ?>
      <?php if (in_array('54', $role_resources_ids) && in_array('55', $role_resources_ids) && in_array('56', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/training') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_training'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('training', $hr_top_menu)) : ?>
      <?php if (in_array('54', $role_resources_ids) && !in_array('55', $role_resources_ids) && !in_array('56', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/training') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_training'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('training', $hr_top_menu)) : ?>
      <?php if (in_array('54', $role_resources_ids) && in_array('55', $role_resources_ids) && !in_array('56', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/training') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_training'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('training', $hr_top_menu)) : ?>
      <?php if (in_array('54', $role_resources_ids) && !in_array('55', $role_resources_ids) && in_array('56', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/training') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_training'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('trainers_list', $hr_top_menu)) : ?>
      <?php if (!in_array('54', $role_resources_ids) && in_array('56', $role_resources_ids) && in_array('55', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/trainers') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_trainers_list'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('trainers_list', $hr_top_menu)) : ?>
      <?php if (!in_array('54', $role_resources_ids) && in_array('56', $role_resources_ids) && !in_array('55', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/trainers') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_trainers_list'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
    <?php if (in_array('training_type', $hr_top_menu)) : ?>
      <?php if (!in_array('54', $role_resources_ids) && !in_array('56', $role_resources_ids) && in_array('55', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/training_type') ?>" class="sidenav-link"> <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_training_type'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
  <?php } ?>
  <?php if (in_array('holiday', $hr_top_menu)) : ?>
    <?php if (in_array('8', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/timesheet/holidays'); ?>"> <i class="ion ion-ios-paper-plane sidenav-icon"></i>
          <div><?php echo $this->lang->line('left_holidays'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
  <?php if (in_array('hr_import', $hr_top_menu)) : ?>
    <?php if (in_array('92', $role_resources_ids) || in_array('443', $role_resources_ids) || in_array('444', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/import'); ?>"> <i class="fas fa-file-upload sidenav-icon"></i>
          <div><?php echo $this->lang->line('xin_hr_imports'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>

  <?php if (in_array('custom_fields', $hr_top_menu)) : ?>
    <?php if (in_array('393', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a class="sidenav-link" href="<?php echo site_url('admin/custom_fields'); ?>"> <i class="fas fa-sliders-h sidenav-icon"></i>
          <div><?php echo $this->lang->line('xin_hrpremium_custom_fields'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
  <?php if (in_array('hr_payees_payers', $hr_top_menu)) : ?>
    <?php if (in_array('80', $role_resources_ids) && in_array('81', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a href="<?php echo site_url('admin/accounting/payees') ?>" class="sidenav-link"> <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('xin_hr_payees_payers'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
  <?php if (in_array('acc_payees', $hr_top_menu)) : ?>
    <?php if (in_array('80', $role_resources_ids) && !in_array('81', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a href="<?php echo site_url('admin/accounting/payees') ?>" class="sidenav-link"> <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('xin_acc_payees'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
  <?php if (in_array('acc_payers', $hr_top_menu)) : ?>
    <?php if (!in_array('80', $role_resources_ids) && in_array('81', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a href="<?php echo site_url('admin/accounting/payers') ?>" class="sidenav-link"> <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('xin_acc_payers'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
  <?php if ($system[0]->is_active_sub_departments == 'yes') { ?>
    <?php if (in_array('sub_department', $hr_top_menu)) : ?>
      <?php if (in_array('3', $role_resources_ids)) { ?>
        <li class="sidenav-item"><a href="<?php echo site_url('admin/department/sub_departments') ?>" class="sidenav-link"> <i class="far fa-building sidenav-icon"></i>
            <div><?php echo $this->lang->line('xin_hr_sub_departments'); ?></div>
          </a></li>
      <?php } ?>
    <?php endif; ?>
  <?php } ?>

  <?php if (in_array('settings', $hr_top_menu)) : ?>
    <?php if (in_array('60', $role_resources_ids)) { ?>
      <li class="sidenav-item"><a href="<?php echo site_url('admin/settings') ?>" class="sidenav-link"> <i class="fas fa-cog sidenav-icon"></i>
          <div><?php echo $this->lang->line('header_configuration'); ?></div>
        </a></li>
    <?php } ?>
  <?php endif; ?>
</ul>
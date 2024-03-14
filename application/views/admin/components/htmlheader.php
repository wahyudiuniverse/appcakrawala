<?php $company = $this->Xin_model->read_company_setting_info(1); ?>
<?php $favicon = base_url() . 'uploads/logo/favicon/' . $company[0]->favicon; ?>
<?php $theme = $this->Xin_model->read_theme_info(1); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon; ?>">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/fontawesome.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/open-iconic.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/fonts/pe-icon-7-stroke.css">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/css/demo.css">

  <script src="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/js/polyfills.js"></script>

  <script src="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/js/material-ripple.js"></script>
  <script src="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/js/layout-helpers.js"></script>

  <!-- Theme settings -->
  <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
  <script src="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/js/theme-settings.js"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/',
      themesPath: '<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/rtl/'
    });
  </script>
  <!-- Core scripts -->
  <script src="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/js/pace.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

  <!-- requirement for datatables -->
  <!-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
  <link href="https://cdn.datatables.net/searchpanes/1.1.1/css/searchPanes.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
  <!-- <script src="https://cdn.datatables.net/searchpanes/1.1.1/js/dataTables.searchPanes.min.js"></script> -->
  <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
  <!-- <link href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.bootstrap4.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/colreorder/2.0.0/css/colReorder.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/keytable/2.12.0/css/keyTable.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/scroller/2.4.1/css/scroller.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/searchpanes/2.3.0/css/searchPanes.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/select/2.0.0/css/select.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/staterestore/1.4.0/css/stateRestore.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.0.2/css/dataTables.jqueryui.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.jqueryui.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.jqueryui.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/autofill/2.7.0/js/dataTables.autoFill.min.js"></script>
  <script src="https://cdn.datatables.net/autofill/2.7.0/js/autoFill.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/colreorder/2.0.0/js/dataTables.colReorder.min.js"></script>
  <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.min.js"></script>
  <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
  <script src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap4.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.min.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdn.datatables.net/scroller/2.4.1/js/dataTables.scroller.min.js"></script>
  <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.min.js"></script>
  <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/searchBuilder.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/dataTables.searchPanes.min.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/searchPanes.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/staterestore/1.4.0/js/dataTables.stateRestore.min.js"></script>
  <script src="https://cdn.datatables.net/staterestore/1.4.0/js/stateRestore.bootstrap4.min.js"></script> -->

  <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.jqueryui.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.jqueryui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.colVis.min.js"></script> -->

  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css"> -->

  <!-- <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/dataTables.searchPanes.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/searchPanes.dataTables.js"></script>
  <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
  <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
  
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script> -->

  <!-- <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.2/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/cr-2.0.0/date-1.5.2/fc-5.0.0/fh-4.0.1/kt-2.12.0/r-3.0.0/rg-1.5.0/rr-1.5.0/sc-2.4.1/sb-1.7.0/sp-2.3.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.2/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/cr-2.0.0/date-1.5.2/fc-5.0.0/fh-4.0.1/kt-2.12.0/r-3.0.0/rg-1.5.0/rr-1.5.0/sc-2.4.1/sb-1.7.0/sp-2.3.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script> -->

  <!-- jQuery Library
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

  <!-- Datatable JS
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->

  <!-- Libs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">

  <!-- hrpremium vendor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/toastr/toastr.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/datatables/datatables.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/select2/select2.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/smartwizard/smartwizard.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/jquery-ui/jquery-ui.css">

  <!-- Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/flatpickr/flatpickr.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/timepicker/timepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/pages/contacts.css">

  <!-- Conditions-->
  <?php if ($this->router->fetch_class() == 'roles') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/kendo/kendo.common.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/kendo/kendo.default.min.css">
  <?php } ?>
  <?php if ($this->router->fetch_class() == 'reports') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/pages/file-manager.css">
  <?php } ?>
  <?php if ($this->router->fetch_class() == 'chat') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/pages/chat.css">
  <?php } ?>
  <?php if ($this->router->fetch_class() == 'calendar' || $this->router->fetch_class() == 'timesheet' || $this->router->fetch_class() == 'dashboard' || $this->router->fetch_method() == 'timecalendar' || $this->router->fetch_method() == 'projects_calendar' || $this->router->fetch_method() == 'tasks_calendar' || $this->router->fetch_method() == 'quote_calendar' || $this->router->fetch_method() == 'invoice_calendar' || $this->router->fetch_method() == 'projects_dashboard' || $this->router->fetch_method() == 'calendar') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/fullcalendar/dist/fullcalendar.css">
    <link href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/fullcalendar/dist/scheduler.min.css" rel="stylesheet">
  <?php } ?>
  <?php if ($this->router->fetch_method() == 'tasks_scrum_board' || $this->router->fetch_method() == 'projects_scrum_board') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/dragula/dragula.css">
  <?php } ?>
  <?php if ($this->router->fetch_class() == 'events' || $this->router->fetch_class() == 'meetings') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/libs/minicolors/minicolors.css">
  <?php } ?>
  <?php if ($this->router->fetch_class() == 'goal_tracking' || $this->router->fetch_method() == 'task_details' || $this->router->fetch_class() == 'project' || $this->router->fetch_class() == 'quoted_projects' || $this->router->fetch_method() == 'project_details') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/ion.rangeSlider/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css">
  <?php } ?>
  <?php if ($this->router->fetch_method() == 'notifications') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrpremium_vendor/assets/vendor/css/pages/messages.css">
  <?php } ?>
</head>
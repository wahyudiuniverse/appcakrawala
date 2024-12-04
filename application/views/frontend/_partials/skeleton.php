<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/dashboard-crm.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:46:02 GMT -->

<head>

    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Job Portal Cakrawala Group" name="description" />
    <meta content="Cakrawala Group" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>uoloads/logo/favicon/favicon_1644399947.png">

    <script src="<?= base_url() ?>assets/assets_data_karyawan/libs/jquery/jquery-3.7.1.min.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <!--datatable css-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/datatables/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/datatables/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/datatables/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Layout config Js -->
    <script src="<?= base_url() ?>assets/assets_data_karyawan/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>assets/assets_data_karyawan/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/assets_data_karyawan/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/assets_data_karyawan/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?= base_url() ?>assets/assets_data_karyawan/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php //$this->load->view('frontend/_partials/topbar.php') ?>

        <?php //$this->load->view('frontend/_partials/remove_notification_modal.php') ?>

        <?php //$this->load->view('frontend/_partials/sidebar.php') ?>

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <!-- <div class="main-content col-md-12"> -->

            <!-- <div class="page-content"> -->
                <div class="container-fluid mt-3">

                    <?php echo $sub_view; ?>

                </div>
                <!-- container-fluid -->
            <!-- </div> -->
            <!-- End Page-content -->

            <?php //$this->load->view('frontend/_partials/footer.php') ?>
        <!-- </div> -->
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php //$this->load->view('frontend/_partials/theme_settings.php') ?>
    <?php $this->load->view('frontend/_partials/scripts.php') ?>

    <!-- Dashboard init -->
    <!-- <script src="<?= base_url() ?>assets/assets_data_karyawan/js/pages/dashboard-crm.init.js"></script> -->
</body>


<!-- Mirrored from themesbrand.com/velzon/html/master/dashboard-crm.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:46:03 GMT -->

</html>
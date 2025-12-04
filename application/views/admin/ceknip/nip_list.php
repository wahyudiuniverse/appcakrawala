<?php
/* Location view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<hr class="border-light m-0">


<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> CEK NIP </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="tabel_employees">
        <thead>
          <tr>
            <th>ID</th>
            <th>KTP</th>
            <th>Nama Lengkap</th>
            <th>PROJECT</th>
            <th>JOIN DATE</th>
            <th>ROLE</th>

          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  //global variable
  var employee_table;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var session_id = '<?php echo $session['employee_id']; ?>';
  var session_fullname = '<?php echo $session['employee_name']; ?>';

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  $(document).ready(function() {

    $('.select_hrm').select2({
                width: '100%',
                // dropdownParent: $("#container_modal_mulai_screening")
            });

    // var project = document.getElementById("aj_project").value;
    // var sub_project = document.getElementById("aj_sub_project").value;
    // var status = document.getElementById("aj_keyword").value;
    // var search_periode_from = "";
    // var search_periode_to = "";

    employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));


    employee_table.destroy();

    // e.preventDefault();
      // $('#button_download_data').attr("hidden", false);

      employee_table = $('#tabel_employees').DataTable({
        //"bDestroy": true,
        'processing': true,
        'serverSide': true,
        // 'stateSave': true,
        'bFilter': true,
        'serverMethod': 'post',
        //'dom': 'plBfrtip',
        'dom': 'lfrtip',
        //"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
        //'columnDefs': [{
        //  targets: 11,
        //  type: 'date-eu'
        //}],
        // 'order': [
        //   [4, 'asc']
        // ],
        'ajax': {
          'url': '<?= base_url() ?>admin/Ceknip/list_employees',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            // project: project,
            // sub_project: sub_project,
            // status: status,
            //base_url_catat: base_url_catat
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert("Status :" + xhr.status);
            alert("responseText :" + xhr.responseText);
          },
        },
        'columns': [{
            data: 'identity',
            "orderable": true
          },
          {
            data: 'ktp_no',
            "orderable": true,
            //searchable: true
          },
          {
            data: 'first_name',
            "orderable": true,
            //searchable: true
          },
          {
            data: 'project',
            "orderable": false
          },
          {
            data: 'join_date',
            "orderable": false,
          },
          {
            data: 'user_role_id',
            "orderable": false,
          },

        ]
      }).on('search.dt', () => eventFired('Search'));

  });



  function eventFired(type) {
    var searchVal = $('#tabel_employees_filter').find('input').val();
    // var project = document.getElementById("aj_project").value;
    // var sub_project = document.getElementById("aj_sub_project").value;
    // var sdate       = $("#aj_sdate").val();
    // var edate       = $("#aj_edate").val();
    // alert(searchVal.length);

    // if ((searchVal.length <= 2) && (project == "0")) {
    //   $('#button_download_data').attr("hidden", true);
    // } else {

    //   $('#button_download_data').attr("hidden", false);
    // }
    // let n = document.querySelector('#demo_info');
    // n.innerHTML +=
    //   '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
    // n.scrollTop = n.scrollHeight;

  }

</script>

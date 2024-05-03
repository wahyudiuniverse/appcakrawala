<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>

<!--CSS CKEditor5-->
<style>
  #container {
    /* width: 1000px; */
    width: 100%;
    margin: 20px auto;
  }

  .ck-editor__editable[role="textbox"] {
    /* Editing area */
    min-height: 200px;
  }

  .ck-content .image {
    /* Block images */
    max-width: 80%;
    margin: 20px auto;
  }
</style>

<!-- Menampilkan Pesan error (kalau ada) -->
<?php if ($pesan_error) : ?>
  <script type='text/javascript'>
    alert("<?php echo $pesan_error; ?>");
    //confirm("<?php echo $pesan_error; ?>");
  </script>;
<?php endif; ?>

<!--Modal untuk view list variable-->
<div class="modal fade" id="variableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">List Variable</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table style="width:100%;">
          <tr>
            <th style="width:5%;">No.</th>
            <th style="width:40%;">Nama Variabel</th>
            <th style="width:55%;">Keterangan</th>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>1.</td>
            <td>-nomorAddendum-</td>
            <td>Nomor dari dokumen addendum</td>
          </tr>
          <tr>
            <td>2.</td>
            <td>-tanggalAddendum-</td>
            <td>Tanggal terbit dokumen addendum</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>3.</td>
            <td>-namaSMHR-</td>
            <td>Nama Senior Manager HR&GA</td>
          </tr>
          <tr>
            <td>4.</td>
            <td>-alamatCompany-</td>
            <td>Alamat perusahaan</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>5.</td>
            <td>-namaKaryawan-</td>
            <td>Nama karyawan</td>
          </tr>
          <tr>
            <td>6.</td>
            <td>-nipKaryawan-</td>
            <td>NIP karyawan</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>7.</td>
            <td>-alamatKaryawan-</td>
            <td>Alamat karyawan</td>
          </tr>
          <tr>
            <td>8.</td>
            <td>-projectKaryawan-</td>
            <td>Project karyawan</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>9.</td>
            <td>-jabatanKaryawan-</td>
            <td>Jabatan karyawan</td>
          </tr>
          <tr>
            <td>10.</td>
            <td>-nikKaryawan-</td>
            <td>NIK karyawan</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>11.</td>
            <td>-nomorPKWT-</td>
            <td>Nomor dari PKWT/TKHL</td>
          </tr>
          <tr>
            <td>12.</td>
            <td>-tanggalPKWT-</td>
            <td>Tanggal terbit dari PKWT/TKHL</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>13.</td>
            <td>-periodeKontrak-</td>
            <td>Periode dari PKWT/TKHL</td>
          </tr>
          <tr>
            <td>14.</td>
            <td>-kontrakStart-</td>
            <td>Tanggal mulai dari PKWT/TKHL</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>15.</td>
            <td>-kontrakEnd-</td>
            <td>Tanggal berkahir dari PKWT/TKHL</td>
          </tr>
          <tr>
            <td>16.</td>
            <td>-ttddigital-</td>
            <td>Tanda tangan digital SM HR</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>17.</td>
            <td>-ttdkaryawan-</td>
            <td>Space untuk tanda tangan karyawan</td>
          </tr>
          <tr>
            <td>18.</td>
            <td>-urutanAddendum-</td>
            <td>Urutan addendum ke- (Untuk PKWT/TKHL yang dipilih)</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>19.</td>
            <td>-kontrakStartNew-</td>
            <td>Perubahan Tanggal Mulai Kontrak pada PKWT/TKHL</td>
          </tr>
          <tr>
            <td>20.</td>
            <td>-kontrakEndNew-</td>
            <td>Perubahan Tanggal Selesai Kontrak pada PKWT/TKHL</td>
          </tr>
          <tr style="background-color: #D6EEEE;">
            <td>21.</td>
            <td>-periodeKontrakNew-</td>
            <td>Perubahan Periode dari PKWT/TKHL</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DATA PKWT/TKHL </strong> - <?php echo $employee[0]->first_name; ?><?php echo $lihat_pkwt; ?></span>
    <div class="card-header-elements ml-md-auto"> </div>
  </div>
  <div id="add_form" class="add-form <?php echo $get_animate; ?>" data-parent="#accordion" style="">
    <div class="card-body">
      <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off'); ?>
      <?php $hidden = array('_user' => $session['user_id']); ?>
      <?php echo form_open_multipart('#', $attributes, $hidden); ?>
      <div class="form-body">
        <div class="row">

          <div class="col-md-4">
            <!-- Variabel hidden-->
            <input hidden name="contract_id" id="contract_id" type="text" value="<?php echo $pkwt[0]->contract_id; ?>">
            <input hidden name="emp_id" id="emp_id" type="text" value="<?php echo $employee[0]->user_id; ?>">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input readonly class="form-control" placeholder="Nama Lengkap" name="nama" type="text" value="<?php echo $employee[0]->first_name; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">NIP di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="NIP" name="nip" id="nip" type="text" value="<?php echo $pkwt[0]->employee_id; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Alamat KTP</label>
                  <textarea readonly class="form-control" rows="4" wrap="hard"><?php echo $employee[0]->alamat_ktp; ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Project di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Project" name="project" type="text" value="<?php echo $nama_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Sub Project di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $nama_sub_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Jabatan di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Jabatan" name="jabatan" type="text" value="<?php echo $designation_name; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Penempatan di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Penempatan" name="penempatan" type="text" value="<?php echo $pkwt[0]->penempatan; ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Nomor PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Nomor PKWT" name="pkwt_number" type="text" value="<?php echo $pkwt[0]->no_surat; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Tanggal PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $tanggal_pkwt; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Periode PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Periode PKWT" name="periode_pkwt" type="text" value="<?php echo $periode_pkwt; ?>">
                </div>
              </div>
            </div>
          </div>

          <!--untuk testing-->
          <!-- <button hidden id="tesbutton" type="button" onclick="getCK5();" class="btn btn-xs btn-outline-twitter">VIEW</button>
          <textarea hidden name="content" id="testtext"></textarea> -->

        </div>
      </div>
    </div>
  </div>

  <!-- Section Editor -->
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>ADD NEW</strong> ADDENDUM </span>
    <div class="card-header-elements ml-md-auto"> </div>
  </div>
  <div id="add_form" class="add-form <?php echo $get_animate; ?>" data-parent="#accordion" style="">

    <div class="card-body">

      <div class="row">
        <!--TANGGAL Addendum-->
        <div class="col-md-4">
          <div class="form-group">
            <label>Tanggal Addendum</label>
            <input class="form-control date" onkeydown="return false" placeholder="YYYY-MM-DD" name="tanggal_addendum" id="tanggal_addendum" type="text" value="">
          </div>
        </div>

        <!--Tombol List Variabel-->
        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <button id="variable_button" type="button" data-toggle="modal" data-target="#variableModal" class="btn btn-xs btn-outline-success form-control">LIST VARIABLE</button>
          </div>
        </div>

        <!--Tombol Save Addendum-->
        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <button id="tesbutton" type="button" onclick="addAddendum();" class="btn btn-xs btn-outline-twitter form-control">SAVE ADDENDUM</button>
          </div>
        </div>
      </div>

      <!--Checkbox ganti periode pkwt/tkhl di addendum-->
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <input type="checkbox" id="edit_periode" name="edit_periode" value="1" onchange="cek_ganti_periode(this)">
            <label for="edit_periode">Perubahan periode PKWT/TKHL</label>
          </div>
        </div>
      </div>

      <div class="row">
        <!--TANGGAL Kontrak start new-->
        <div class="col-md-4">
          <div class="form-group">
            <label hidden name="kontrak_start_new_label" id="kontrak_start_new_label">Tanggal Kontrak Start Baru</label>
            <input class="form-control date" onkeydown="return false" placeholder="YYYY-MM-DD" name="kontrak_start_new" id="kontrak_start_new" type="text" value="<?php echo $tanggal_awal_kontrak; ?>" hidden>
          </div>
        </div>

        <!--TANGGAL Kontrak end new-->
        <div class="col-md-4">
          <div class="form-group">
            <label hidden name="kontrak_end_new_label" id="kontrak_end_new_label">Tanggal Kontrak End Baru</label>
            <input class="form-control date" onkeydown="return false" placeholder="YYYY-MM-DD" name="kontrak_end_new" id="kontrak_end_new" type="text" value="<?php echo $tanggal_akhir_kontrak; ?>" hidden>
          </div>
        </div>

        <!--Periode Kontrak new-->
        <div class="col-md-4">
          <div class="form-group">
            <label hidden name="periode_new_label" id="periode_new_label">Periode Kontrak Baru (Dalam Bulan)</label>
            <input class="form-control" placeholder="Periode Kontrak Baru" name="periode_new" id="periode_new" type="number" value="<?php echo $periode_kontrak; ?>" hidden>
          </div>
        </div>
      </div>

      <div id="container">
        <div id="editor">
        </div>
      </div>
    </div>

  </div>

</div>

<!-- untuk debugging-->
<!-- <?php echo base_url(); ?>
<?php echo '<pre>';
print_r($pkwt);
echo '</pre>';
?> -->

<style type="text/css">
  input[type=file]::file-selector-button {
    margin-right: 20px;
    border: none;
    background: #26ae61;
    padding: 10px 20px;
    border-radius: 2px;
    color: #fff;
    cursor: pointer;
    transition: background .2s ease-in-out;
  }

  input[type=file]::file-selector-button:hover {
    background: #20c997;
  }
</style>

<!-----------------Script CKEdior5----------------------->

<!--
The "superbuild" of CKEditor&nbsp;5 served via CDN contains a large set of plugins and multiple editor types.
See https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start.html#running-a-full-featured-editor-from-cdn
-->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>
<!--
Uncomment to load the Spanish translation
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/translations/es.js"></script>
-->
<script>
  // This sample still does not showcase all CKEditor&nbsp;5 features (!)
  // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
  CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
      // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
      toolbar: {
        items: [
          'exportPDF', 'exportWord', '|',
          'findAndReplace', 'selectAll', '|',
          'heading', '|',
          'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
          'bulletedList', 'numberedList', 'todoList', '|',
          'outdent', 'indent', '|',
          'undo', 'redo',
          '-',
          'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
          'alignment', '|',
          'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
          'specialCharacters', 'horizontalLine', 'pageBreak', '|',
          'textPartLanguage', '|',
          'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
      },
      // Changing the language of the interface requires loading the language file using the <script> tag.
      // language: 'es',
      list: {
        properties: {
          styles: true,
          startIndex: true,
          reversed: true
        }
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
      heading: {
        options: [{
            model: 'paragraph',
            title: 'Paragraph',
            class: 'ck-heading_paragraph'
          },
          {
            model: 'heading1',
            view: 'h1',
            title: 'Heading 1',
            class: 'ck-heading_heading1'
          },
          {
            model: 'heading2',
            view: 'h2',
            title: 'Heading 2',
            class: 'ck-heading_heading2'
          },
          {
            model: 'heading3',
            view: 'h3',
            title: 'Heading 3',
            class: 'ck-heading_heading3'
          },
          {
            model: 'heading4',
            view: 'h4',
            title: 'Heading 4',
            class: 'ck-heading_heading4'
          },
          {
            model: 'heading5',
            view: 'h5',
            title: 'Heading 5',
            class: 'ck-heading_heading5'
          },
          {
            model: 'heading6',
            view: 'h6',
            title: 'Heading 6',
            class: 'ck-heading_heading6'
          }
        ]
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
      placeholder: 'Welcome to CKEditor 5!',
      //placeholder: templateAddendum,
      // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
      fontFamily: {
        options: [
          'default',
          'Arial, Helvetica, sans-serif',
          'Courier New, Courier, monospace',
          'Georgia, serif',
          'Lucida Sans Unicode, Lucida Grande, sans-serif',
          'Tahoma, Geneva, sans-serif',
          'Times New Roman, Times, serif',
          'Trebuchet MS, Helvetica, sans-serif',
          'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
      fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
      },
      // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
      // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
      htmlSupport: {
        allow: [{
          name: /.*/,
          attributes: true,
          classes: true,
          styles: true
        }]
      },
      // Be careful with enabling previews
      // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
      htmlEmbed: {
        showPreviews: true
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
      link: {
        decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
            mode: 'manual',
            label: 'Downloadable',
            attributes: {
              download: 'file'
            }
          }
        }
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
      mention: {
        feeds: [{
          marker: '@',
          feed: [
            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
            '@sugar', '@sweet', '@topping', '@wafer'
          ],
          minimumCharacters: 1
        }]
      },
      // The "superbuild" contains more premium features that require additional configuration, disable them below.
      // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
      removePlugins: [
        // These two are commercial, but you can try them out without registering to a trial.
        // 'ExportPdf',
        // 'ExportWord',
        'AIAssistant',
        'CKBox',
        'CKFinder',
        'EasyImage',
        // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
        // Storing images as Base64 is usually a very bad idea.
        // Replace it on production website with other solutions:
        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
        // 'Base64UploadAdapter',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
        // from a local file system (file://) - load this site via HTTP server if you enable MathType.
        'MathType',
        // The following features are part of the Productivity Pack and require additional license.
        'SlashCommand',
        'Template',
        'DocumentOutline',
        'FormatPainter',
        'TableOfContents',
        'PasteFromOfficeEnhanced',
        'CaseChange'
      ]
    })
    .then(editor => {
      window.editor = editor;

      //handleStatusChanges(editor);
      //handleSaveButton(editor);
      //handleBeforeunload(editor);
    });

  $(document).ready(function() {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var templateAddendum = '<?php echo $addendum['isi']; ?>';
    editor.setData(templateAddendum);
  });

  //-----cek apakah checkbox di checklist-----
  function cek_ganti_periode(obj) {
    if ($(obj).is(":checked")) {
      //alert("Yes checked"); //when checked
      document.getElementById("kontrak_start_new").removeAttribute("hidden");
      document.getElementById("kontrak_end_new").removeAttribute("hidden");
      document.getElementById("periode_new").removeAttribute("hidden");
      document.getElementById("kontrak_start_new_label").removeAttribute("hidden");
      document.getElementById("kontrak_end_new_label").removeAttribute("hidden");
      document.getElementById("periode_new_label").removeAttribute("hidden");
    } else {
      //alert("Not checked"); //when not checked
      kontrak_start_new.setAttribute("hidden", "hidden");
      kontrak_end_new.setAttribute("hidden", "hidden");
      periode_new.setAttribute("hidden", "hidden");
      kontrak_start_new_label.setAttribute("hidden", "hidden");
      kontrak_end_new_label.setAttribute("hidden", "hidden");
      periode_new_label.setAttribute("hidden", "hidden");
    }
  }

  //-----delete addendum-----
  function addAddendum() {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var tgl_terbit = document.getElementById("tanggal_addendum").value;

    //var created_time = new Date().toJSON().slice(0, 10);
    var today = new Date();
    today.setHours(today.getHours() + 7);
    var created_time = today.toISOString().substr(0, 19).replace('T', ' ');
    var date0 = new Date();
    var date = new Date().toLocaleString();
    var date2 = new Date().toJSON();

    //kalau tanggal terbit tidak diisi, diisi dengan tanggal hari ini
    if (tgl_terbit == "") {
      tgl_terbit = new Date().toJSON().slice(0, 10);
    }
    

    var pkwt_id = document.getElementById("contract_id").value;
    var karyawan_id = document.getElementById("emp_id").value;
    var kontrak_start_new = document.getElementById("kontrak_start_new").value;
    var kontrak_end_new = document.getElementById("kontrak_end_new").value;
    var periode_new = document.getElementById("periode_new").value;
    var created_by = '<?php echo $session['user_id']; ?>';
    var isi = editor.getData();


    //testing
    //alert(date0);
    //alert(date);
    //alert(date2);
    //alert(kontrak_start_new);
    //alert(kontrak_end_new);
    //alert(periode_new);

    //AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/addendum/save/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        tgl_terbit: tgl_terbit,
        pkwt_id: pkwt_id,
        karyawan_id: karyawan_id,
        isi: isi,
        created_by: created_by,
        created_time: created_time,
        kontrak_start_new: kontrak_start_new,
        kontrak_end_new: kontrak_end_new,
        periode_new: periode_new
      },
      success: function(response) {
        alert("Berhasil add addendum");
      },
      error: function() {
        alert("Error add data");
      }
    });
  }
</script>
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

<div class="card mb-4">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DATA PKWT </strong> - <?php echo $employee[0]->first_name; ?><?php echo $lihat_pkwt; ?></span>
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
                  <label for="nama">NIP di PKWT</label>
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
                  <label for="nama">Project di PKWT</label>
                  <input readonly class="form-control" placeholder="Project" name="project" type="text" value="<?php echo $nama_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Sub Project di PKWT</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $nama_sub_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Jabatan di PKWT</label>
                  <input readonly class="form-control" placeholder="Jabatan" name="jabatan" type="text" value="<?php echo $designation_name; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Penempatan di PKWT</label>
                  <input readonly class="form-control" placeholder="Penempatan" name="penempatan" type="text" value="<?php echo $pkwt[0]->penempatan; ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Nomor PKWT</label>
                  <input readonly class="form-control" placeholder="Nomor PKWT" name="pkwt_number" type="text" value="<?php echo $pkwt[0]->no_surat; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Tanggal PKWT</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $tanggal_pkwt; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Periode PKWT</label>
                  <input readonly class="form-control" placeholder="Periode PKWT" name="periode_pkwt" type="text" value="<?php echo $periode_pkwt; ?>">
                </div>
              </div>
            </div>
          </div>

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
  var editor = CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
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
  });

  editor.setData('<p>Some text.</p>');
</script>
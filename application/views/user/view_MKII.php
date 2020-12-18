<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <!-- start: PAGE -->
    <div class="main-content">

        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container load_content">
            <!-- start: PAGE HEADER -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <?php $this->session->flashdata('flash'); ?>
                    <?php endif; ?>
                    <!-- start: PAGE TITLE & BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="clip-home-3"></i>
                            <a href="<?= base_url('auth'); ?>">
                                Dashboard
                            </a>
                        </li>
                        <li class="active">
                            Program
                        </li>
                        <li class="active">
                            <?php
                            $prog = explode("_", $this->uri->segment(1));
                            echo strtoupper($prog[0]);
                            ?>
                        </li>
                        <li class="search-box">
                            <form class="sidebar-search">
                                <div class="form-group">
                                    <input type="text" placeholder="Start Searching...">
                                    <button class="submit">
                                        <i class="clip-search-3"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ol>
                    <div class="page-header">
                        <h1 style="font-size: 20px;">DRAWING FOR PROGRAM <?= substr($this->uri->segment(1), 0, 4); ?> <small>overview &amp; stats </small></h1>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                </div>
            </div>
            <!-- end: PAGE HEADER -->
            <!-- start: PAGE CONTENT -->

            <div class="row">
                <div class="col-md-12">
                    <!-- start: DYNAMIC TABLE PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            DRAWING LIST
                            <div class="panel-tools">
                                <a class="btn btn-xs btn-link" href="<?= base_url('user/excel'); ?>" title="Export to excel">
                                    <i class="fa clip-file-excel "></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?= $this->session->flashdata('message'); ?>

                            <div class="table-responsive">
                                <?php if ($this->session->userdata('nik') == '900300') : ?>
                                    <a href="<?= base_url('MKII_controller/formref'); ?>">
                                        <button class="btn btn-pinterest">
                                            <i class="fa fa-desktop "></i>
                                            | Entry new reference
                                        </button>
                                    </a>
                                    <a href="<?= base_url('MKII_controller/formchange'); ?>">
                                        <button class="btn btn-pinterest">
                                            <i class="fa fa-stack-exchange"></i>
                                            | Entry new change number
                                        </button>
                                    </a>
                                    <a href="#">
                                        <button onclick="add_data()" class="btn btn-pinterest">
                                            <i class="fa clip-note"></i>
                                            | Entry new drawing
                                        </button>
                                    </a>
                                <?php endif; ?>

                                <table id="table" class="display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <?php //if ($this->session->userdata('level') == 'user') : 
                                            ?>
                                            <th style="width:125px;">ACTION</th>
                                            <?php// endif; ?>
                                            <th>NO</th>
                                            <th>NO REFERENCE</th>
                                            <th>DRAWING</th>
                                            <th>PROGRAM</th>
                                            <th>TITLE</th>
                                            <th>TYPE</th>
                                            <th>SHEET</th>
                                            <th>ISSUE</th>
                                            <th>CHANGE NO</th>
                                            <th>RECEIVE DATE</th>
                                            <th>RELEASE DATE</th>
                                            <th>OBSOLETE DATE</th>
                                            <th>EFFECTIVITY</th>
                                            <th>STATUS</th>
                                            <th>REMARK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL -->
                </div>
            </div>
            <!-- end: PAGE CONTENT-->
        </div>
    </div>
    <!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->


<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        hide_rel();
        hide_file();

        $("#status").on('change', function() {
            hide_rel();
            let status = $(this).val();

            if (status === 'OBSOLETE') {
                $(".obsolete").show();
            } else if (status === 'RELEASE') {
                $(".release").show();
            } else {
                hide_rel();
            }
        });


        //datatables
        table = $('#table').DataTable({
            "lengthChange": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('MKII_controller/ajax_view') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [5, 6, 7, 8, 9, 10, 11, 12, 13, 14], //last column
                "orderable": false, //set not orderable
                "length": false
            }, ],

        });

        //datepicker
        $('.date-picker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        $('.date-picker2').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });


    });

    function hide_file() {

        $('.berkas').hide();
        $('.filelama').hide();

    }

    function hide_rel() {
        $(".release").hide();
        $(".obsolete").hide();
    }

    function delete_data(id) {

        const flashData = $(".flash-data").data('flash', 'Deleted');

        Swal({
            title: "Are You Sure",
            text: "FPPC Will Be Delete",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete!",
        }).then((result) => {
            if (result.value) {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('MKII_controller/ajax_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');

                        if (flashData) {
                            Swal({
                                title: "Success Message",
                                text: "Success Deleted",
                                type: "success",
                            });
                        }
                        reload_table();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            }
        });
    }

    function add_data() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add drawing'); // Set Title to Bootstrap modal title
    }

    function edit_file(id) {
        $('#form_upload')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('MKII_controller/ajax_edit/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="drawing"]').val(data.drawing);
                $('[name="program"]').val(data.program);
                $('#modal_form_upload').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Upload file drawing'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function upload_ajax() {
        $('#btnupload').text('uploading...');
        $('#btnupload').attr('disabled', true);

        var formdata = $('#form_upload').serialize();

        console.log(formdata);

        $.ajax({
            url: "<?php echo site_url('MKII_controller/do_upload') ?>",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form_upload').modal('hide');
                    reload_table();
                }

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function edit_data(id) {
        save_method = 'update';
        $(".berkas").show();
        $(".filelama").show();
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('MKII_controller/ajax_edit/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                var str = data.effectivity;
                var res = str.split("-");

                $('[name="id"]').val(data.id);
                $('[name="reference"]').val(data.reference);
                $('[name="program"]').val(data.program);
                $('[name="drawing"]').val(data.drawing).prop('selected', true);
                $('[name="title"]').val(data.title);
                $('[name="type"]').val(data.type).prop('selected', true);
                $('[name="issue"]').val(data.issue);
                $('[name="eff"]').val(res[0]);
                $('[name="eff_to"]').val(res[1]);
                $('[name="received"]').val(data.receive);
                $('[name="sheet"]').val(data.sheet);
                $('[name="status"]').val(data.status).prop('selected', true);
                $('[name="remark"]').val(data.remark);
                $('[name="change"]').val(data.change_no);
                $('.filelama').text(data.file_name);
                $('[name="filebefore"]').val(data.file_name);
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit drawing');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('MKII_controller/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('MKII_controller/ajax_update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (!data.status) //if success close modal and reload ajax table
                {
                    alert('There are required field blank, please check your data');
                } else {
                    Swal({
                        title: "Success Message",
                        text: "Success Saving",
                        type: "success",
                    });
                    $('#modal_form').modal('hide');
                    reload_table();
                }

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }
</script>
<!-- FORM MODAL ADD DATA -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal_form" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" width: 750px; enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                            </div>
                            <div class="successHandler alert alert-success no-display">
                                <i class="fa fa-ok"></i> Your form validation is successful!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                    REFERENCE <span class="symbol required"></span>
                                </label>
                                <div class="form-group">
                                    <select id="form-field-select-3" name="ref" class="form-control search-select">
                                        <option value="">&nbsp;</option>
                                        <?php foreach ($list as $ref) : ?>
                                            <option value="<?php echo $ref['reference']; ?>"><?php echo $ref['reference']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('ref', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    PROGRAM <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Drawing number" readonly value="<?= substr(strtoupper($this->uri->segment(1)), 0, 4); ?>" class="form-control" id="program" name="program">
                                <input type="hidden" placeholder="Drawing number" readonly class="form-control" id="id" name="id">

                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    DRAWING <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Drawing number" value="<?= set_value('drawing'); ?>" class="form-control" id="drawing" name="drawing">
                                <?= form_error('drawing', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    TITLE <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Title" value="<?= set_value('title'); ?>" class="form-control" id="title" name="title">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">
                                    TYPE <span class="symbol required"></span>
                                </label>
                                <select name="type" id="type" class="form-control">
                                    <option value=""></option>
                                    <option value="DR">DR (DRAWING)</option>
                                    <option value="PL">PL (PARTLIST)</option>
                                    <option value="DR + PL">DR + PL (DRAWING AND PARTLIST)</option>
                                    <option value="ADJ">ADJ</option>
                                    <option value="DML">DML</option>
                                    <option value="CP1">CP1</option>
                                </select>
                                <?= form_error('type', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    ISSUE <span class="symbol required"></span>
                                </label>
                                <input type="text" class="form-control" id="issue" name="issue" placeholder="Issue">
                                <?= form_error('issue', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group berkas">
                                <label class="control-label">
                                    UPDATE NEW FILE ? <span class="symbol required"></span>
                                </label><br>
                                <label class="control-label filelama" style="font-style: italic;"></label>
                                <input type="hidden" placeholder="Pef" class="form-control" id="filebefore" name="filebefore">
                                <select name="question" id="question" class="form-control">
                                    <option value="NO"></option>
                                    <option value=YES>YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group connected-group">
                                <label class="control-label">
                                    EFFECTIVITY <span class="symbol required"></span>
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Effective from" id="eff" name="eff" class="form-control">
                                        <?= form_error('eff', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Effective to" id="eff_to" name="eff_to" class="form-control">
                                        <?= form_error('eff_to', '<small class="text-danger">', '</small>'); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">
                                            RECEIVED <span class="symbol required"></span>
                                        </label>
                                        <input class="form-control date-picker" placeholder="Receive date" type="text" name="received" id="received">
                                        <?= form_error('received', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label">
                                            SHEET
                                        </label>
                                        <input class="form-control tooltips" placeholder="Sheet" name="sheet" id="release" type="text">
                                        <?= form_error('sheet', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">
                                            STATUS <span class="symbol required"></span>
                                        </label>
                                        <select name="status" id="status" class="form-control">
                                            <option value=""></option>
                                            <option value="PCCB">PCCB</option>
                                            <option value="ARSIP">ARSIP</option>
                                            <option value="RELEASE">RELEASE</option>
                                            <option value="OBSOLETE">OBSOLETE</option>
                                        </select>
                                        <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-7 obsolete">
                                    <div class="form-group">
                                        <label class="control-label">
                                            OBSOLETE DATE <span class="symbol required"></span>
                                        </label>
                                        <input class="form-control tooltips date-picker2" placeholder="Obsolete date" name="obsolete" id="obsolete" type="text">
                                        <?= form_error('obsolete', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-7 release">
                                    <div class="form-group">
                                        <label class="control-label">
                                            RELEASE DATE <span class="symbol required"></span>
                                        </label>
                                        <input class="form-control tooltips date-picker2" placeholder="Release date" name="release" id="release" type="text">
                                        <?= form_error('release', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            CHANGE NO
                                        </label>
                                        <div>
                                            <select id="form-field-select-3" name="change" class="form-control search-select">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($change as $changes) : ?>
                                                    <option value="<?php echo $changes['change_no']; ?>"><?php echo $changes['change_no'] . " - EFF : " . $changes['effectivity']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('change', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">
                                            REMARK
                                        </label>
                                        <textarea name="remark" id="remark" class="form-control" cols="120" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <span class="symbol required"></span>Required Fields
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row"> -->
                    <div class=" modal-footer">
                        <button type="button" id="btnupload" onclick="save()" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    <!-- </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL ADD DATA -->

<!-- START UPLOAD DATA -->
<div class="modal fade" id="modal_form_upload" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo base_url(); ?>MKII_controller/upload_file" id="form_upload" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Drawing Number</label>
                            <div class="col-md-9">
                                <input name="drawing" readonly placeholder="First Name" class="form-control" type="text">
                                <input name="id" id="id" placeholder="First Name" class="form-control" type="hidden">
                                <input name="program" id="program" placeholder="First Name" class="form-control" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">
                            File Drawing
                        </label>
                        <div class="col-xs-9">
                            <input type="file" name="filename" id="filename" class="form-control" />
                        </div>
                    </div>
            </div>
            <div class=" modal-footer">
                <button type="submit" id="btnupload" class="btn btn-primary">Upload</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- END UPLOAD DATA -->
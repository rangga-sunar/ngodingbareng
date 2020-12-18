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
                            <?php echo strtoupper($this->uri->segment(4)); ?>
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
                        <h1>Drawing <small>overview &amp; stats </small></h1>
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
                            DRAWING
                            <div class="panel-tools">
                                <a class="btn btn-xs btn-link" href="<?= base_url('user/excel'); ?>" title="Export to excel">
                                    <i class="fa clip-file-excel "></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="table-responsive">
                                <?php if ($this->session->userdata('uo') == 'PE') : ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-green">
                                            <i class="fa fa-plus"></i>
                                            Entry Data
                                        </button>
                                        <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="<?= base_url(); ?>user/formref/<?php echo $this->uri->segment(3); ?>">
                                                    <i class="fa clip-file-pdf"></i>
                                                    New Reference
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>user/formchange/<?php echo $this->uri->segment(3); ?>">
                                                    <i class="fa clip-libreoffice "></i>
                                                    New Change number
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>user/formdraw/<?php echo $this->uri->segment(3); ?>">
                                                    <i class="fa clip-note"></i>
                                                    New Drawing
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <table id="myTable" class="display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ACTION</th>
                                            <th>#</th>
                                            <th>REFERENCE</th>
                                            <th>PROGRAM</th>
                                            <th>DRAWING</th>
                                            <th class="hidden-xs">TITLE</th>
                                            <th>TYPE</th>
                                            <th>SHEET</th>
                                            <th>ISSUE</th>
                                            <th>CHANGE NO</th>
                                            <th>RECEIVED</th>
                                            <th>RELEASE</th>
                                            <th>EFFECTIVITY</th>
                                            <th>STATUS</th>
                                            <th>REMARK</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">
                                        <?php
                                        $no = 0;
                                        foreach ($draw as $row) :
                                            $no++;
                                        ?>
                                            <tr>
                                                <td class="center">
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <?php if ($row->file_name <> "") : ?>
                                                        <?php else : ?>
                                                            <a href="" data-toggle="modal" data-target="#ModalaAdd<?php echo $row->id; ?>" class="btn btn-xs btn-success tooltips" data-placement="top" data-original-title="Upload TS"><i class="fa fa-upload"></i></a>
                                                        <?php endif; ?>
                                                        <a href="<?= base_url(); ?>user/editdraw/<?= $row->id; ?>" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="" class="btn btn-xs btn-bricky tooltips hapus" id="<?= $row->id; ?> " data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>

                                                        <!-- <a href="" data-toggle="modal" data-target="#ModalaAdd<?php echo $row->id; ?>" class="btn btn-xs btn-success tooltips" data-placement="top" data-original-title="Upload TS"><i class="fa fa-upload"></i></a>
                                                        <a href="" data-toggle="modal" data-target="#ModalReprint<?php echo $row->id; ?>" class="btn btn-xs btn-success tooltips reprint" data-placement="top" data-original-title="Reprint ?"><i class="fa fa-print"></i></a>
                                                        <a href="" id="<?php echo $row->id; ?> " target="_blank" class="btn btn-xs btn-teal tooltips download" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></a> -->
                                                    </div>
                                                </td>
                                                <td><?= $no; ?></td>
                                                <td><?= $row->reference; ?></td>
                                                <td><?= $row->program; ?></td>
                                                <?php if ($row->file_name <> "") : ?>
                                                    <td><a href="<?= base_url(); ?>uploads/<?php echo $this->uri->segment(3); ?>/viewer.html?file=<?= $row->file_name; ?>" target="_blank" title="click for detail"><?= $row->drawing; ?></a></td>
                                                    <!-- <td><a href="<?= base_url(); ?>assets/pdfjs/web/viewer.html?file=<?= $row->file_name; ?>" target="_blank" title="click for detail"><?= $row->drawing; ?></a></td> -->
                                                <?php else : ?>
                                                    <td><?= $row->drawing; ?></td>
                                                <?php endif; ?>
                                                <td><?= $row->title; ?></td>
                                                <td><?= $row->type; ?></td>
                                                <td><?= $row->sheet; ?></td>
                                                <td><?= $row->issue; ?></td>
                                                <td><a href="<?= base_url(); ?>uploads/CHANGENUM_FILE/<?= $row->file_name_change; ?>" target="_blank"><?php echo $row->change_no; ?> </a> </td>
                                                <td><?= $row->receive; ?></td>
                                                <td><?= $row->release_date; ?></td>
                                                <td><?= $row->effectivity; ?></td>
                                                <td><?= $row->status; ?></td>
                                                <td><?= $row->remark; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL -->
                </div>
            </div>
            <div class="row">

            </div>
            <div class="row">

            </div>
            <div class="row">

            </div>
            <!-- end: PAGE CONTENT-->
        </div>
    </div>
    <!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->
<!-- //modal upload ts by qp -->
<?php foreach ($draw as $row) : ?>
    <div class="modal fade" id="ModalaAdd<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel">UPLOAD DRAWING</h3>
                </div>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>user/updrawing" enctype="multipart/form-data">
                    <div class=" modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Drawing</label>
                            <div class="col-xs-9">
                                <input name="program" readonly id="program" class="form-control" type="hidden" placeholder="Technical Sheet Number" value=<?= $row->program; ?> style="width:335px;" required>
                                <input name="id" readonly id="id" class="form-control" type="hidden" placeholder="Technical Sheet Number" value=<?= $row->id; ?> style="width:335px;" required>
                                <input name="drawing" readonly id="drawing" class="form-control" type="text" placeholder="Drawing" value=<?= $row->drawing; ?> style="width:335px;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">
                                File Drawing
                            </label>
                            <div class="col-xs-9">
                                <input type="file" name="filename" id="filename" class="form-control" value="<?= set_value('filename'); ?>" />
                                <?= form_error('filename', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-info" id="btn_simpan">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    $(document).ready(function() {
        $("#myTable").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'colvis'
            ]
        });

        $(".download").click(function(e) {
            e.preventDefault();
            var no = $(this).attr("id");
            if (confirm('Are you sure will print this document ? this action will update release date')) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>user/download",
                    data: ({
                        no: $(this).attr("id")
                    }),
                    success: function(data) {

                        location.href = '<?= base_url(); ?>user/print/' + no;
                        return false;
                    }
                });
            } else {
                return false;
            }
        });

        $(".hapus").click(function(e) {
            e.preventDefault();

            var id = $(this).attr("id");
            const href = $(this).attr("href")

            Swal({
                title: "Are You Sure",
                text: "Drawing Will Be Delete",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>user/removedraw",
                        method: "POST",
                        data: ({
                            id: $(this).attr("id")
                        }),
                        success: function(data) {
                            document.location.href = href;
                        }
                    });
                }
            });
        });
    });
</script>
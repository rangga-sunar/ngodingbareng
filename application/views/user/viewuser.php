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
                            List users registered
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
                        <h1 style="font-size: 20px;">Users Registered <small>overview &amp; stats </small></h1>
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
                            USERS REGISTERED
                        </div>
                        <div class="panel-body">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="table-responsive">
                                <table id="myTable" class="display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>NIK</th>
                                            <th>UNIT</th>
                                            <th>EMAIL</th>
                                            <th>DATE CREATED</th>
                                            <th>ACTIVE</th>
                                            <th>ACCESS</th>
                                            <th>LEVEL</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">
                                        <?php
                                        $no = 0;
                                        foreach ($user as $row) :
                                            $no++;
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <?php if ($row->filename != "") : ?>
                                                    <td><a href="<?php echo base_url(); ?>form/<?= $row->filename; ?>" target="_blank"><?= $row->name; ?></a></td>
                                                <?php else : ?>
                                                    <td><?= $row->name; ?></td>
                                                <?php endif; ?>
                                                <td><?= $row->nik; ?></td>
                                                <td><?= $row->uo; ?></td>
                                                <td><?= $row->email; ?></td>
                                                <td><?= date("Y-m-d H:i:s", $row->date_created); ?></td>
                                                <td><?php echo $row->is_active == 0 ? "<span class='label label-sm label-danger'>Inactive</span>" : "<span class='label label-sm label-success'>Active</span>"; ?></td>
                                                <td><?php echo $row->access; ?></td>
                                                <td><?php echo $row->level; ?></td>
                                                <td class="center">
                                                    <div>
                                                        <a href="" data-toggle="modal" data-target="#ModalaAdd<?php echo $row->id; ?>" class="btn btn-xs btn-success tooltips" data-placement="top" data-original-title="Previledge access"><i class="fa clip-user-5"></i></a>
                                                        <a href="<?= base_url(); ?>admin/approve/<?= $row->id; ?>" class="btn btn-xs btn-teal tooltips approve" data-placement="top" data-original-title="Approve"><i class="fa clip-thumbs-up"></i></a>
                                                        <a href="<?= base_url(); ?>admin/nonactive/<?= $row->id; ?>" class="btn btn-xs btn-teal tooltips nonactive" data-placement="top" data-original-title="Non Active"><i class="fa clip-thumbs-up-2"></i></a>
                                                        <a href="<?= base_url(); ?>admin/delete/<?= $row->id; ?>" class="btn btn-xs btn-bricky tooltips remove-user" data-placement=" top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                                    </div>
                                                </td>
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
<?php foreach ($user as $row) :
    $checkbox_array = explode(",", $row->access);
    $type = $row->level;
?>
    <div class="modal fade" id="ModalaAdd<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel">Set previledge user for access drawing</h3>
                </div>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>admin/saveaccess" enctype="multipart/form-data">
                    <div class=" modal-body">
                        <p>
                            Please checklist the checkbox below
                        </p>
                        <hr>
                        <p>
                            Access for username
                        </p>
                        <input name="id" readonly id="id" class="form-control" type="hidden" placeholder="Technical Sheet Number" value=<?= $row->id; ?> style="width:335px;" required>
                        <input name="nama" readonly id="nama" class="form-control" type="text" placeholder="Technical Sheet Number" value=<?= $row->name; ?> style="width:335px;" required>

                        <p></p>
                        <p>
                            Level this user
                        </p>

                        <select name="level" id="level" class="form-control">

                            <option value=""></option>
                            <option value="ADMIN" <?php if ($type == 'ADMIN') {
                                                        echo "selected=selected";
                                                    } ?>>ADMIN</option>
                            <option value="USER" <?php if ($type == 'USER') {
                                                        echo "selected=selected";
                                                    } ?>>USER</option>
                        </select>
                        <p></p>
                        <p>
                            Program allowed
                        </p>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="N219" name="program[]" class="grey" <?php if (in_array("N219", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            N219
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="KFX" name="program[]" class="grey" <?php if (in_array("KFX", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            KFX
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="CN235" name="program[]" class="grey" <?php if (in_array("CN235", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            CN235
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="C212" name="program[]" class="grey" <?php if (in_array("C212", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            C212
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="MKII" name="program[]" class="grey" <?php if (in_array("MKII", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            MKII
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="SPIRIT" name="program[]" class="grey" <?php if (in_array("SPIRIT", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            SPIRIT
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="MALE" name="program[]" class="grey" <?php if (in_array("MALE", $checkbox_array)) {
                                                                                                    echo " checked=\"checked\"";
                                                                                                } ?>>
                            MALE
                        </label>
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
        $(".download").click(function() {
            if (confirm('Are you sure will download this document ? this action will update release date')) {
                setTimeout(location.reload.bind(location), 500);
                location.href = '<?php echo base_url('user/viewtech'); ?>';
            } else {
                return false;
            }
        });
    });
</script>
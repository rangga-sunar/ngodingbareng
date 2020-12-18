<!-- start: MAIN CONTAINER -->
<div class="main-container">
	<!-- start: PAGE -->
	<div class="main-content">

		<!-- end: SPANEL CONFIGURATION MODAL FORM -->
		<div class="container">
			<!-- start: PAGE HEADER -->
			<div class="row">
				<div class="col-sm-12">

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
						<h1 style="font-size: 20px;">Change number <small>overview &amp; stats </small></h1>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->

			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-6">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>

						</div>
						<div class="panel-body">
							<h2><i class="fa fa-pencil-square teal"></i> FORM CHANGE NUMBER</h2>
							<p>
								Type following field on form then click submit button
							</p>
							<hr>
							<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
							<?php if ($this->session->flashdata('flash')) : ?>
								<?php $this->session->flashdata('flash'); ?>
							<?php endif; ?>

							<?php
							$project = explode("_", $this->uri->segment(1));
							?>
							<form action="<?= base_url($project[0] . "_controller/savechange"); ?>" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="errorHandler alert alert-danger no-display">
											<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
										</div>
										<div class="successHandler alert alert-success no-display">
											<i class="fa fa-ok"></i> Your form validation is successful!
										</div>
									</div>

									<div class="col-md-8">
										<div class="form-group connected-group">
											<label class="control-label">
												CHANGE NUMBER <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-12">
													<input type="text" placeholder="Change Number" onkeyup="pulsar(this)" id="change" name="change" class="form-control">
													<?= form_error('change', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>
										<div class="form-group connected-group">
											<label class="control-label">
												PROGRAM <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-5">
													<input type="text" readonly placeholder="Reference" value="<?= $project[0]; ?>" id="program" name="program" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group connected-group">
											<label class="control-label">
												EFFECTIVITY <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-3">
													<input type="text" placeholder="Effective from" id="eff" name="eff" class="form-control">
													<?= form_error('eff', '<small class="text-danger">', '</small>'); ?>
												</div>
												<div class="col-md-3">
													<input type="text" placeholder="Effective to" id="eff_to" name="eff_to" class="form-control">
													<?= form_error('eff_to', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">
														RECEIVED DATE <span class="symbol required"></span>
													</label>
													<input class="form-control date-picker" placeholder="Receive date" type="text" name="received" id="received">
													<?= form_error('received', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<label class="control-label">
														RELEASE DATE <span class="symbol required"></span>
													</label>
													<div>
														<input class="form-control tooltips  date-picker2" name="rel_date" id="rel_date" value="<?= set_value('rel_date'); ?>" type="text" placeholder="Receive Date">
														<?= form_error('rel_date', '<small class="text-danger">', '</small>'); ?>
													</div>
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
								<div class="row">
									<div class="col-md-2">
										<button class="btn btn-yellow btn-block" type="submit">
											Submit <i class="fa fa-arrow-circle-right"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>

						</div>
						<div class="panel-body">

							<table id="myTable" class="display responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>ACTION</th>
										<th>#</th>
										<th>CHANGE NUMBER </th>
										<th>EFFECTIVITY</th>
										<th class="hidden-xs">RELEASE DATE</th>
										<th>RECEIVE DATE</th>

									</tr>
								</thead>
								<tbody id="show_data">
									<?php
									$no = 0;
									foreach ($rows as $row) :
										$no++;
									?>
										<tr>
											<td class="center">
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<a href="" data-toggle="modal" data-target="#ModalaAdd<?php echo $row->id_change; ?>" class="btn btn-xs btn-success tooltips" data-placement="top" data-original-title="Upload TS"><i class="fa fa-upload"></i></a>
													<a href="" class="btn btn-xs btn-bricky tooltips hapus" id="<?= $row->id_change; ?> " data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
												</div>
											</td>
											<td><?= $no; ?></td>
											<?php if ($row->file_name_change <> "") : ?>
												<td><a href="<?= base_url(); ?>uploads/CHANGENUM_FILE/<?= $row->file_name_change; ?>" target="_blank" title="click for detail"><?= $row->change_no; ?></a></td>
											<?php else : ?>
												<td><?= $row->change_no; ?></td>
											<?php endif; ?>
											<td><?= $row->effectivity; ?></td>
											<td><?= $row->release_date; ?></td>
											<td><?= $row->receive_date; ?></td>

										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end: PAGE CONTENT-->
			</div>
		</div>
		<!-- end: PAGE -->
	</div>
</div>
<!-- end: MAIN CONTAINER -->

<script type="text/javascript">
	$(document).ready(function() {
		$(".date-picker").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});

		$(".date-picker2").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});

		$("#myTable").DataTable({
			dom: 'Bfrtip',
			buttons: [
				'colvis'
			]
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
						url: "<?= base_url($project[0] . "_controller/removechange"); ?>",
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

<script language="javascript" type="text/javascript">
	function pulsar(obj) {
		obj.value = obj.value.toUpperCase();
	}
</script>

<!-- //modal upload ts by qp -->
<?php foreach ($rows as $row) : ?>
	<div class="modal fade" id="ModalaAdd<?php echo $row->id_change; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="modal-title" id="myModalLabel">Upload file change number</h3>
				</div>
				<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>user/uploadchange" enctype="multipart/form-data">
					<div class=" modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3">Change number</label>
							<div class="col-xs-9">

								<input name="id" readonly id="id" class="form-control" type="hidden" placeholder="Technical Sheet Number" value="<?= $row->id_change; ?>">
								<input name="changeno" readonly id="changeno" class="form-control" type="text" placeholder="Reference" value="<?= $row->change_no; ?>">
								<input name="program" readonly id="program" class="form-control" type="hidden" placeholder="Reference" value="<?= $row->project; ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">
								File
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
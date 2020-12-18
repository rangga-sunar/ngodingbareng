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
						<h1 style="font-size: 20px;">Reference <small>overview &amp; stats </small></h1>
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
							<h2><i class="fa fa-pencil-square teal"></i> FORM REFERENCE</h2>
							<p>
								Type following field on form then click submit button
							</p>
							<hr>
							<?php
							$project = explode("_", $this->uri->segment(1));
							?>
							<form action="<?= base_url($project[0] . "_controller/saveref"); ?>" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="errorHandler alert alert-danger no-display">
											<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
										</div>
										<div class="successHandler alert alert-success no-display">
											<i class="fa fa-ok"></i> Your form validation is successful!
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group connected-group">
											<label class="control-label">
												REFERENCE <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-8">
													<input type="text" placeholder="Reference" onkeyup="pulsar(this)" id="ref" name="ref" class="form-control">
													<?= form_error('ref', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>
										<div class="form-group connected-group">
											<label class="control-label">
												PROGRAM <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-5">
													<input type="text" readonly placeholder="Reference" onkeyup="pulsar(this)" value="<?= strtoupper($project[0]); ?>" id="program" name="program" class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">
														REFERENCE DATE <span class="symbol required"></span>
													</label>
													<input class="form-control date-picker" placeholder="Rerefence date" value="<?= set_value('refdate'); ?>" type="text" name="refdate" id="refdate">
													<?= form_error('refdate', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">
														RECORD BY <span class="symbol required"></span>
													</label>
													<div>
														<input class="form-control tooltips" readonly name="createdby" id="createdby" value="<?php echo $this->session->userdata('nik'); ?>" type="text" placeholder="Change Number">
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
							<?= $this->session->flashdata('message'); ?>
							<table id="myTable" class="display responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>ACTION</th>
										<th>#</th>
										<th>REFERENCE</th>
										<th>REF DATE</th>
										<th class="hidden-xs">CREATED BY</th>
										<th>CREATED DATE</th>

									</tr>
								</thead>
								<tbody id="show_data">
									<?php
									$no = 0;
									foreach ($ref as $row) :
										$no++;
									?>
										<tr>
											<td class="center">
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<a href="" data-toggle="modal" data-target="#ModalaAdd<?php echo $row->id; ?>" class="btn btn-xs btn-success tooltips" data-placement="top" data-original-title="Upload TS"><i class="fa fa-upload"></i></a>
													<!-- <a href="<?= base_url($project[0] . "_controller/removeRef/") . $row->id; ?>" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> -->
													<a href="" class="btn btn-xs btn-bricky tooltips hapus" id="<?= $row->id; ?> " data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
												</div>
											</td>
											<td><?= $no; ?></td>
											<?php if ($row->file_name <> "") : ?>
												<td><a href="<?= base_url(); ?>uploads/ref_file/<?= $row->file_name; ?>" target="_blank" title="click for detail"><?= $row->reference; ?></a></td>
											<?php else : ?>
												<td><?= $row->reference; ?></td>
											<?php endif; ?>
											<td><?= $row->ref_date; ?></td>
											<td><?= $row->createdby; ?></td>
											<td><?= $row->created_date; ?></td>

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
						url: "<?= base_url($project[0] . "_controller/removeRef"); ?>",
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
<?php foreach ($ref as $row) : ?>
	<div class="modal fade" id="ModalaAdd<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="modal-title" id="myModalLabel">Upload file reference</h3>
				</div>
				<form class="form-horizontal" method="post" action="<?= base_url($project[0] . "_controller/upreference"); ?>" enctype="multipart/form-data">
					<div class=" modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3">Reference</label>
							<div class="col-xs-9">

								<input name="id" readonly id="id" class="form-control" type="hidden" placeholder="Technical Sheet Number" value="<?= $row->id; ?>">
								<input name="ref" readonly id="ref" class="form-control" type="text" placeholder="Reference" value="<?= $row->reference; ?>">
								<input name="program" readonly id="program" class="form-control" type="hidden" placeholder="Reference" value="<?= $row->program; ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">
								File Reference
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
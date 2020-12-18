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

			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
						</div>
						<div class="panel-body">
							<h2><i class="fa fa-pencil-square teal"></i> FORM DRAWING</h2>
							<p>
								Type following field on form then click submit button
							</p>
							<hr>
							<form action="<?= base_url('user/updatedraw'); ?>" method="post" enctype="multipart/form-data">
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
														<?php $value = $ref['reference']; ?>
														<option value="<?php echo $ref['reference']; ?>" <?php if ($value == $row['reference']) {
																												echo "selected=selected";
																											} ?>><?php echo $ref['reference']; ?></option>
													<?php endforeach; ?>
												</select>
												<?= form_error('ref', '<small class="text-danger">', '</small>'); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">
												PROGRAM <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Drawing number" readonly value="<?= $row['program']; ?>" class="form-control" id="program" name="program">

										</div>
										<div class="form-group">
											<label class="control-label">
												DRAWING <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Drawing number" value="<?= $row['drawing']; ?>" class="form-control" id="drawing" name="drawing">
											<?= form_error('drawing', '<small class="text-danger">', '</small>'); ?>
										</div>
										<div class="form-group">
											<label class="control-label">
												TITLE <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Title" value="<?= $row['title']; ?>" class="form-control" id="title" name="title">
											<?= form_error('title', '<small class="text-danger">', '</small>'); ?>
										</div>

										<div class="form-group">
											<label class="control-label">
												TYPE <span class="symbol required"></span>
											</label>
											<?php $type = $row['type'];
											?>
											<select name="type" id="type" class="form-control">
												<option value=""></option>
												<option value="DR" <?php if ($type == 'DR') {
																		echo "selected=selected";
																	} ?>>DR (DRAWING)</option>
												<option value="PL" <?php if ($type == 'PL') {
																		echo "selected=selected";
																	} ?>>PL (PARTLIST)</option>
												<option value="DR,PL" <?php if ($type == "DR,PL") {
																			echo "selected=selected";
																		} ?>>DR & PL (DRAWING & PARTLIST)</option>
												<option value="ADJ">ADJ</option>
											</select>
											<?= form_error('type', '<small class="text-danger">', '</small>'); ?>
										</div>
										<div class="form-group">
											<label class="control-label">
												ISSUE <span class="symbol required"></span>
											</label>
											<input type="text" class="form-control" id="issue" value="<?= $row['issue']; ?>" name="issue" placeholder="Issue">
											<?= form_error('issue', '<small class="text-danger">', '</small>'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group connected-group">
											<label class="control-label">
												EFFECTIVITY <span class="symbol required"></span>
											</label>
											<div class="row">
												<div class="col-md-3">
													<?php
													$hasil = explode("-", $row['effectivity']);
													?>
													<input type="text" placeholder="Effective from" id="eff" name="eff" value="<?= $hasil['0']; ?>" class="form-control">
													<?= form_error('eff', '<small class="text-danger">', '</small>'); ?>
												</div>
												<div class="col-md-3">
													<input type="text" placeholder="Effective to" id="eff_to" name="eff_to" value="<?= $hasil['1']; ?>" class="form-control">
													<?= form_error('eff_to', '<small class="text-danger">', '</small>'); ?>
												</div>

											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">
														RECEIVED <span class="symbol required"></span>
													</label>
													<input class="form-control date-picker" placeholder="Receive date" type="text" value="<?= $row['receive']; ?>" name="received" id="received">
													<?= form_error('received', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label class="control-label">
														RELEASE <span class="symbol required"></span>
													</label>
													<input class="form-control tooltips date-picker2" placeholder="Release date" value="<?= $row['release_date']; ?>" name="release" id="release" type="text">
													<?= form_error('release', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">
														STATUS <span class="symbol required"></span>
													</label>
													<?php $stat = $row['status']; ?>
													<select name="status" id="status" class="form-control">
														<option value=""></option>
														<option value="PCCB" <?php if ($stat == 'PCCB') {
																					echo "selected=selected";
																				} ?>>PCCB</option>
														</option>
														<option value="ARSIP" <?php if ($stat == 'ARSIP') {
																					echo "selected=selected";
																				} ?>>ARSIP</option>
														</option>
														<option value="RELEASE" <?php if ($stat == 'RELEASE') {
																					echo "selected=selected";
																				} ?>>RELEASE</option>
														</option>
														<option value="OBSOLETE" <?php if ($stat == 'OBSOLETE') {
																						echo "selected=selected";
																					} ?>>OBSOLETE</option>
														</option>
													</select>
													<?= form_error('status', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
											<div class="col-md-8 obsolete">
												<div class="form-group">
													<label class="control-label">
														OBSOLETE DATE <span class="symbol required"></span>
													</label>
													<input class="form-control tooltips date-picker2" placeholder="Obsolete date" name="obsolete" id="obsolete" type="text">
													<?= form_error('obsolete', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
											<div class="col-md-8 release">
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
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">
														CHANGE NO <span class="symbol required"></span>
													</label>
													<div>
														<input class="form-control tooltips" name="change" id="change" type="text" value="<?= $row['change_no']; ?>" placeholder="Change Number">
														<?= form_error('change', '<small class="text-danger">', '</small>'); ?>
													</div>
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label class="control-label">
														SHEET <span class="symbol required"></span>
													</label>
													<input class="form-control tooltips" placeholder="Sheet" name="sheet" value="<?= $row['sheet']; ?>" id="release" type="text">
													<?= form_error('sheet', '<small class="text-danger">', '</small>'); ?>
												</div>
											</div>
										</div>

										<!-- <div class="form-group">
											<label class="control-label">
												FILE <span class="symbol required"></span>
											</label>
											<div>
												<input class="form-control tooltips" name="file_name" id="file_name" type="file" placeholder="File">
											</div>
										</div> -->
										<div class="row">
											<div class="col-md-8">
												<div class="form-group">
													<label class="control-label">
														REMARK <span class="symbol required"></span>
													</label>
													<textarea name="remark" id="remark" class="form-control" cols="20" rows="1"><?= $row['remark']; ?></textarea>
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
				<!-- end: PAGE CONTENT-->
			</div>
		</div>
		<!-- end: PAGE -->
	</div>
</div>
<!-- end: MAIN CONTAINER -->

<script type="text/javascript">
	$(document).ready(function() {

		hide_rel();
		checkprogram();

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

		function hide_rel() {
			$(".obsolete").hide();
			$(".release").hide();
		}

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

		function checkprogram() {
			let program = $("#program").val();

			if (program === "KFX") {
				$(".KFX").addClass('active');
				$(".navbar").addClass('active');
			} else if (program === "N219") {
				$(".N219").addClass('active');
				$(".navbar").addClass('active');
			} else if (program === "C212") {
				$(".C212").addClass('active');
				$(".navbar").addClass('active');
			} else if (program === "MKII") {
				$(".MKII").addClass('active');
				$(".navbar").addClass('active');
			}
		}
	});
</script>
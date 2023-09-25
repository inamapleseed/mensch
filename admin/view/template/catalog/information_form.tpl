<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="button" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary btn-submit" onclick="$('#form-information').submit();"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
									<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
									<?php $repeater_row = 0; ?>
									<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_repeater_row; ?></label>
											<div class="col-sm-10">
												<div class="table-responsive">
													<table id="information-repeater<?php echo $language['language_id']; ?>" class="table table-bordered">
															<thead>
																<tr>
																	<td class="text-left"><?php echo $entry_repeater_row; ?></td>
																	<td width="1px" ></td>
																</tr>
															</thead>
															<tbody>
																<?php if(isset($information_repeaters[$language['language_id']])) { ?>
																	<?php foreach ($information_repeaters[$language['language_id']] as $index => $information_repeater) { ?>
																		<tr id="information-repeater-row<?php echo $repeater_row; ?>">
																			<td class="text-left">
																				
																				<div class="input-group col-xs-12"><p><?php echo $entry_row_image; ?></p>
																				<a href="" id="thumb-image<?php echo $language['language_id']; ?>_<?= $repeater_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?= $information_repeater['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a>
																				<input type="hidden" name="information_repeater[<?php echo $language['language_id']; ?>][<?php echo $repeater_row; ?>][image]" value="<?= $information_repeater['image']; ?>" id="input-image<?php echo $language['language_id']; ?>_<?= $repeater_row; ?>" /></div><br/>
																				<input type="hidden" name="information_repeater[<?php echo $language['language_id']; ?>][<?php echo $repeater_row; ?>][information_repeater_id]" value="<?php echo $information_repeater['information_repeater_id']; ?>"/>
													
																				<div class="input-group col-xs-12"><p><?php echo $entry_row_type; ?></p>
																					<select name="information_repeater[<?php echo $language['language_id']; ?>][<?= $repeater_row; ?>][row_type]" id="input-information_repeater-<?php echo $repeater_row; ?>" class="form-control">
																						<?php foreach ($row_types as $row_type) { ?>
																							<?php if ($information_repeater['row_type'] == $row_type['value']) { ?>
																								<option value="<?= $row_type['value']; ?>" selected="selected"><?= $row_type['name']; ?></option>
																								<?php } else { ?>
																								<option value="<?= $row_type['value']; ?>"><?= $row_type['name']; ?></option>
																							<?php } ?>
																						<?php } ?>
																					</select>
																				</div>
																			
																				<br/>
																				<p><?php echo $entry_description; ?></p>
																				<div class="input-group col-xs-12">
																					<textarea  name="information_repeater[<?php echo $language['language_id']; ?>][<?php echo $repeater_row; ?>][description][text]"  id="input-information_repeater<?php echo $language['language_id'].$repeater_row ?>" rows="5" placeholder="<?php echo $entry_description; ?>" class="form-control"><?php echo isset($information_repeater['description']) ? $information_repeater['description'] : ''; ?></textarea>
																				</td>
																				<td class="text-left">
																					<button type="button" onclick="$('#information-repeater-row<?php echo $repeater_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
																						<i class="fa fa-minus-circle"></i>
																					</button>
																				</td>
																			</tr>
																			<?php $repeater_row++; ?>
																	<?php } ?>
																<?php } ?>  
											
																</tbody>
																<tfoot>
																	<tr>
																		<td colspan="1"></td>
																		<td class="text-left">
																			<button type="button" onclick="addInformationRepeater('<?php echo $language['language_id']; ?>',this);" data-row="<?php echo $repeater_row; ?>" data-toggle="tooltip" title="<?php echo $button_add_row; ?>" class="btn btn-primary">
																				<i class="fa fa-plus-circle"></i>
																			</button>
																		</td>
																	</tr>
																</tfoot>
															</table>
											</div>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="<?php if ($ckeditor_enabled == 1) { ?>form-control<?php } else { ?>form-control summernote<?php } ?>"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php if (isset($error_description[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_meta_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab-data">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
								<div class="col-sm-10">
									<div class="well well-sm" style="height: 150px; overflow: auto;">
										<div class="checkbox">
											<label>
												<?php if (in_array(0, $information_store)) { ?>
													<input type="checkbox" name="information_store[]" value="0" checked="checked" />
													<?php echo $text_default; ?>
													<?php } else { ?>
													<input type="checkbox" name="information_store[]" value="0" />
													<?php echo $text_default; ?>
												<?php } ?>
											</label>
										</div>
										<?php foreach ($stores as $store) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($store['store_id'], $information_store)) { ?>
														<input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
														<?php echo $store['name']; ?>
														<?php } else { ?>
														<input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
														<?php echo $store['name']; ?>
													<?php } ?>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_template_type; ?></label>
								<div class="col-sm-10">
									<select name="template_type" id="input-template_type" class="form-control">
										<?php foreach ($template_types as $type) {?>
											<?php if ($template_type == $type['type']) { ?>
												<option value="<?php echo $type['type']; ?>" selected="selected"><?php echo $type['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $type['type']; ?>"><?php echo $type['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
									<?php if ($error_keyword) { ?>
										<div class="text-danger"><?php echo $error_keyword; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if ($bottom) { ?>
												<input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
												<?php } else { ?>
												<input type="checkbox" name="bottom" value="1" id="input-bottom" />
											<?php } ?>
										&nbsp; </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
									<select name="status" id="input-status" class="form-control">
										<?php if ($status) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-design">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_store; ?></td>
											<td class="text-left"><?php echo $entry_layout; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left"><?php echo $text_default; ?></td>
											<td class="text-left"><select name="information_layout[0]" class="form-control">
												<option value=""></option>
												<?php foreach ($layouts as $layout) { ?>
													<?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
														<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
														<?php } else { ?>
														<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select></td>
										</tr>
										<?php foreach ($stores as $store) { ?>
											<tr>
												<td class="text-left"><?php echo $store['name']; ?></td>
												<td class="text-left"><select name="information_layout[<?php echo $store['store_id']; ?>]" class="form-control">
													<option value=""></option>
													<?php foreach ($layouts as $layout) { ?>
														<?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
															<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Enhanced CKEditor -->
	<?php if ($fm_installed == 0) { ?>
		<?php if ($ckeditor_enabled == 1) { ?>
			<script type="text/javascript">
				<?php foreach ($languages as $language) { ?>
					CKEDITOR.replace("input-description<?php echo $language['language_id']; ?>", {
						baseHref: "<?php echo $base_url; ?>", 
						language: "<?php echo $language['code']; ?>",
						filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						skin : "<?php echo $ckeditor_skin; ?>",
						codemirror: {
							theme: "<?php echo $codemirror_skin; ?>",
						},
						height: 350
					});
				<?php } ?>
			</script>
		<?php } ?>
	<?php } ?>
	<!-- Enhanced CKEditor -->		
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
	<script type="text/javascript"><!--
		$('#language a:first').tab('show');
	//--></script></div>


	<script type="text/javascript">

		<?php foreach($languages as $language){ ?>
			<?php $repeater_row = 0; ?>
			<?php if(isset($information_repeaters[$language['language_id']])) { ?>
				<?php foreach ($information_repeaters[$language['language_id']] as $index => $information_repeater) { ?>
					CKEDITOR.replace("input-information_repeater<?= $language['language_id'].$repeater_row; ?>", { baseHref: "<?= $base_url; ?>",  language: "<?= $language['code']; ?>", filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?= $token; ?>', filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?= $token; ?>', filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?= $token; ?>', skin : "<?= $ckeditor_skin; ?>", codemirror: { theme: "<?= $codemirror_skin; ?>", }, height: 350 });
					<?php $repeater_row++; ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>

			<!--
			var repeater_row = <?php echo $repeater_row; ?>;
			
			function addInformationRepeater(i, variable) {
				var repeater_row = $(variable).attr('data-row');
				html  = '<tr id="information-repeater-row' + repeater_row + '">';
				html += '<input type="hidden" name="information_repeater['+i+'][' + repeater_row + '][information_repeater_id]" value="" />';
				html += '  <td class="text-left"><p><?php echo $entry_row_image; ?></p>';
				//html += '  </td><td class="text-left">';
				html += '<div class="input-group col-xs-12" ><a href="" id="thumb-image' +i+'_'+ repeater_row + '"data-toggle="image" class="img-thumbnail"><img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="information_repeater['+i+'][' + repeater_row + '][image]" value="" id="input-image' +i+'_'+ repeater_row + '" /></div>  <br/>';

				html += '<div class="input-group col-xs-12" ><p><?php echo $entry_row_type; ?></p><select name="information_repeater['+i+'][' + repeater_row + '][row_type]" id="input-information_repeater-'+ repeater_row + '" class="form-control">';
				
				<?php foreach ($row_types as $row_type) { ?>
					html += '<option value="<?= $row_type["value"]; ?>"><?= $row_type["name"]; ?></option>';
				<?php } ?>
			
				html +=	'</select></div>'; 

				html += '<br/> <div class="input-group col-xs-12"><p><?php echo $entry_description; ?></p>';
				html += '<textarea name="information_repeater['+i+'][' + repeater_row + '][description][text]" id="input-information_repeater' + i+repeater_row + '" rows="5" placeholder="<?php echo $entry_description; ?>" class="form-control"></textarea></div>';
				html += '  </td>';
				html += '  <td class="text-left"><button type="button" onclick="$(\'#information-repeater-row' + repeater_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
				html += '</tr>';

				$('#information-repeater'+i+' tbody').append(html);
				<?php //foreach ($languages as $language) { ?>
					cl("input-information_repeater"+i+repeater_row);
					CKEDITOR.replace("input-information_repeater"+i+repeater_row, { baseHref: "<?= $base_url; ?>", language: "dsa", filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>', filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>', filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>', skin : "<?php echo $ckeditor_skin; ?>", codemirror: { theme: "<?php echo $codemirror_skin; ?>", }, height: 350 });
				<?php //} ?>
				//attributeautocomplete(repeater_row);
				repeater_row++;
				$(variable).attr('data-row', repeater_row);
				
			}
		
			
	//--></script>

	<?php echo $footer; ?>	
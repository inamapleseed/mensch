<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-calendar" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?= $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-calendar" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?= $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?= $name; ?>" placeholder="<?= $entry_name; ?>" id="input-name" class="form-control" />
							<?php if ($error_name) { ?>
								<div class="text-danger"><?= $error_name; ?></div>
							<?php } ?>
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

					<?php $calendar_row = 0; ?>
					<table id="calendar-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-left">
									<?= $text_event; ?>
								</td>
								<td width="1px" ></td>
							</tr>
						</thead>

						<tbody>
							<?php if (isset($calendars)) { ?>
							<?php foreach ($calendars as $calendar) { ?>
							<tr id="calendar-row<?php echo $calendar_row; ?>">
								<td class="text-left">
									<div class="form-group">
										<div class="col-sm-3">
											<input type="text" name="calendars[<?php echo $calendar_row; ?>][title]" value="<?= $calendar['title']; ?>" placeholder="<?= $entry_title; ?>" id="input-title" class="form-control" />
										</div>
									
										<div class="col-sm-3">
											<div class="input-group date">
												<input type="text" name="calendars[<?php echo $calendar_row; ?>][start_date]" value="<?= $calendar['start_date']; ?>" placeholder="<?= $entry_start_date; ?>" id="input-start-date" data-date-format="YYYY-MM-DD" class="form-control" />
												<span class="input-group-btn">
							                    	<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
							                    </span>
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="input-group date">
												<input type="text" name="calendars[<?php echo $calendar_row; ?>][end_date]" value="<?= $calendar['end_date']; ?>" placeholder="<?= $entry_end_date; ?>" id="input-end-date" data-date-format="YYYY-MM-DD" class="form-control" />
												<span class="input-group-btn">
							                    	<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
							                    </span>
											</div>
										</div>

										<div class="col-sm-3">
											<select name="calendars[<?php echo $calendar_row; ?>][cevent_id]" id="input-cevent" class="form-control">
												<option value="">-- Please select --</option>
								                <?php foreach ($calendar_events as $calendar_event) { ?>
									                <?php if ($calendar_event['cevent_id'] == $calendar['cevent_id']) { ?>
									                	<option value="<?php echo $calendar_event['cevent_id']; ?>" selected="selected"><?php echo $calendar_event['name']; ?></option>
									                <?php } else { ?>
									                	<option value="<?php echo $calendar_event['cevent_id']; ?>"><?php echo $calendar_event['name']; ?></option>
									                <?php } ?>
								                <?php } ?>
								              </select>
										</div>

									</div>
								</td>
								<td class="text-left"><button type="button" onclick="$('#calendar-row<?php echo $calendar_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
							</tr>
							<?php $calendar_row++; ?>
							<?php } ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="1"></td>
								<td class="text-left">
									<button type="button" onclick="addEvent();" data-toggle="tooltip" title="Add New"
									    class="btn btn-primary">
										<i class="fa fa-plus-circle"></i>
									</button>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		<!--
		var calendar_row = <?php echo $calendar_row; ?>;

		function addEvent() {
			html = '<tr id="calendar-row' + calendar_row + '">';
			html += '<td class="text-left">';
			html += '<div class="form-group">';
			html += '<div class="col-sm-3">';

				html += '<input type="text" name="calendars[' + calendar_row + '][title]" value="" placeholder="<?= $entry_title; ?>" id="input-title" class="form-control" /><br/>';

			html += '</div>';
			html += '<div class="col-sm-3">';

				html += '<div class="input-group date">';
				html += '<input type="text" name="calendars[' + calendar_row + '][start_date]" value="" placeholder="<?= $entry_start_date; ?>" id="input-start-date" data-date-format="YYYY-MM-DD" class="form-control" />';
				html += '<span class="input-group-btn">';
            	html += '<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>';
                html += '</span>';
				html += '</div>';

			html += '</div>';
			html += '<div class="col-sm-3">';

				html += '<div class="input-group date">';
				html += '<input type="text" name="calendars[' + calendar_row + '][end_date]" value="" placeholder="<?= $entry_end_date; ?>" id="input-end-date" data-date-format="YYYY-MM-DD" class="form-control" />';
				html += '<span class="input-group-btn">';
            	html += '<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>';
                html += '</span>';
				html += '</div>';

			html += '</div>';

			html += '<div class="col-sm-3">';
					html += '<select name="calendars[' + calendar_row + '][cevent_id]" id="input-cevent" class="form-control">';
					html += '<option value="" selected="selected">-- Please select --</option>';
					html += '<?php foreach ($calendar_events as $calendar_event) { ?>';
			        html += '<option value="<?php echo $calendar_event['cevent_id']; ?>"><?php echo $calendar_event['name']; ?></option>';
					html += '<?php } ?>';
					html += '</select>';
			html += '</div>';

			html += '<td class="text-left"><button type="button" onclick="$(\'#calendar-row' + calendar_row  + ', .tooltip\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
			html += '</td>';

			html += '</tr>';

			$('#calendar-table tbody').append(html);

			calendar_row ++;

			$('.date').datetimepicker({
				pickTime: false
			});
		}
		//-->
	</script>

	<script type="text/javascript">
		$('.date').datetimepicker({
			pickTime: false
		});
	</script>

	<?php echo $footer; ?>	
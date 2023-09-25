<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> </div>
      <h1><?php echo $view_title; ?></h1>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_view; ?></h3>
      </div>
      <div class="panel-body">
		  
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
												
						<td class="text-left"><?php if ($sort == 'fieldname') { ?>
							<a href="<?php echo $sort_fieldname; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_fieldname; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_fieldname; ?>"><?php echo $column_fieldname; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'helptext') { ?>
							<a href="<?php echo $sort_helptext; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_helptext; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_helptext; ?>"><?php echo $column_helptext; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'placeholder') { ?>
							<a href="<?php echo $sort_placeholder; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_placeholder; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_placeholder; ?>"><?php echo $column_placeholder; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'error') { ?>
							<a href="<?php echo $sort_error; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_error; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_error; ?>"><?php echo $column_error; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'status') { ?>
							<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'required') { ?>
							<a href="<?php echo $sort_required; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_required; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_required; ?>"><?php echo $column_required; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'type') { ?>
							<a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?></a>
							<?php } ?>
						</td>
											
						<td class="text-left"><?php echo $column_action; ?></td>
					</tr>
				</thead>
					<?php if ($formfields) { ?>
					<?php foreach ($formfields as $formfield) { ?>
					<tr>
						<td class="text-center"><?php if (in_array($formfield['form_id'], $selected)) { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $formfield['form_id']; ?>" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $formfield['form_id']; ?>" />
							<?php } ?></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
					</tr>
						<?php } ?> 
						<?php } else { ?>
					<tr>
						<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
					</tr>
					<?php } ?>
            </table>
        </div>
    </form>
        <!--<div class="row">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          	<div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>-->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#button-filter').on('click', function() {
	var url = 'index.php?route=profile/photos&token=<?php echo $token; ?>';
	
	var filter_profile = $('input[name=\'pid\']').val();

	if (filter_profile) {
		url += '&filter_profile=' + encodeURIComponent(filter_profile);
	}
	var filter_album = $('input[name=\'aid\']').val();

	if (filter_album) {
		url += '&filter_album=' + encodeURIComponent(filter_album);
	}
	
  location = url;
});
</script>

<script type="text/javascript">
$('input[name=\'filter_profile\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=profile/profile/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					pid: 0,
					name:'<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['pid']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_profile\']').val(item['label']);
		$('input[name=\'pid\']').val(item['value']);
	}
});
</script>

<script type="text/javascript">
$('input[name=\'filter_album\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=profile/album/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					aid: 0,
					album_name:'<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['album_name'],
						value: item['aid']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_album\']').val(item['label']);
		$('input[name=\'aid\']').val(item['value']);
	}
});
</script>
<?php echo $footer; ?>
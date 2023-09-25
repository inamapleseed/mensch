<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
      <h1><?php echo $heading_title1; ?></h1>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
		 
    <form  method="post" enctype="multipart/form-data" id="form-record">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
						<td class="text-left"><?php echo $column_productname; ?></td>
						
						<!--Filed Heading-->
						<?php foreach($filedheading as $heading) {?>
								<td class="text-left">						
								<?php echo $heading['label']; ?>						
								</td>
						<?php } ?>
						
						<!--Filed Heading-->
						<td class="text-left"><?php echo $column_ip; ?>
						</td>
						
						<td class="text-left"><?php if ($sort == 'date') { ?>
							<a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
							<?php } ?>
						</td>						
						<td class="text-left"><?php echo $column_action; ?></td>
												
					</tr>
				</thead>
					<?php if ($records) { ?>
					<?php foreach ($records as $report) { ?>
					<tr>
						<td class="text-center"><?php if (in_array($report['form_id'], $selected)) { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $report['form_id']; ?>" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $report['form_id']; ?>" />
							<?php } ?>
						</td>
						
						<td class="text-left"><?php echo $report['productname']; ?></td>
						<?php foreach($report['filedvalue'] as $values) {?>
									<td class="text-left">						
									<?php echo $values['value']; ?>						
									</td>
						<?php } ?>
						
						<td class="text-left"><?php echo $report['ip']; ?></td>
						<td class="text-left"><?php echo $report['date_added']; ?></td>
						<td class="text-left">
						<a href="<?php echo $report['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
						
						 <a data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger button-delete deletbtn<?php echo $report['fs_id']; ?>" rel="<?php echo $report['fs_id']; ?>" ><i class="fa fa-trash"></i></a>						
						</td>
						
				</tr>
						<?php } ?> 
						<?php } else { ?>
					<tr>
						<td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
					</tr>
					<?php } ?>
            </table>
        </div>
    </form>
        <div class="row">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          	<div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.button-delete').on('click', function() {
		var rel = $(this).attr("rel");
		
		$.ajax({
		url: 'index.php?route=tmdform/filedrecord/deleterecord&token=<?php echo $token; ?>',
		type: 'post',
		data: 'fs_id='+rel,
		dataType: 'json',
		beforeSend: function() {
			$('.deletbtn'+rel).button('loading');
		},
		complete: function() {
			$('.deletbtn'+rel).button('reset');
		},
		
		success: function(json) {
		$('.alert, .text-danger').remove();
		
			if (json['error']) {
				$('.breadcrumb').after('<div class="text-danger">');
					
					$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				location='<?php echo str_replace('&amp;','&',$recordurl)?>';			
			}
			}
			});
	});
	
	
$('#button-filter').on('click', function() {
	var url = 'index.php?route=tmdform/record&token=<?php echo $token; ?>';
	
	var filter_title = $('input[name=\'form_id\']').val();

	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}
	
	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_ip = $('input[name=\'filter_ip\']').val();

	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
	
	var filter_date = $('input[name=\'filter_date\']').val();

	if (filter_date) {
		url += '&filter_date=' + encodeURIComponent(filter_date);
	}
	
		
  location = url;
});
</script>

  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script>
<?php echo $footer; ?>

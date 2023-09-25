<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
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
		<div class="well">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label" for="input-filter_title"><?php echo $entry_title;?> </label>
						<input type="text" name="filter_title" value="" placeholder="<?php echo $entry_title; ?>" id="input-filter_title" class="form-control" />
						<input type="hidden" name="form_id" />
					</div>
				</div>
				
				<!-- <div class="col-sm-4">
					<div class="form-group">
						<label class="control-label" for="input-filter_name"><?php echo $entry_name;?> </label>
						<input type="text" name="filter_name" value="" placeholder="<?php echo $entry_name; ?>" id="input-filter_name" class="form-control" />
					</div>
				</div> -->

				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label" for="input-filter_name"><?php echo $entry_name;?> </label>
						<input type="text" name="filter_name" value="<?php echo $customername; ?>" placeholder="<?php echo $entry_name; ?>" id="input-filter_name" class="form-control" />
						 <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label" for="input-filter_ip"><?php echo $entry_ip;?> </label>
						<input type="text" name="filter_ip" value="" placeholder="<?php echo $entry_ip; ?>" id="input-filter_ip" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="form-group datetime">
						<label class="control-label" for="input-filter_date"><?php echo $entry_date;?> </label>
						<input type="text" name="filter_date" value="" data-date-format="YYYY-MM-DD" placeholder="YYYY-MM-DD" id="input-filter_date" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-2 text-center">
					<button type="button" style="margin-top:17%;" id="button-filter" class="btn btn-primary"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
				</div>
			</div>
		</div>	 
    <form  method="post" enctype="multipart/form-data" id="form-record">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
						<td class="text-left"><?php echo $column_productname; ?></td>
						
						<td class="text-left"><?php if ($sort == 'title') { ?>
							<a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
							<?php } ?>
						</td>
						
						<td class="text-left"><?php if ($sort == 'name') { ?>
							<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
							<?php } ?>
						</td>
						
						<td class="text-left"><?php echo $column_ip; ?></td>
						
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
						<td class="text-left"><?php echo $report['title']; ?></td>
						<td class="text-left"><?php echo $report['customer_name']; ?></td>
						
						<td class="text-left"><?php echo $report['ip']; ?></td>
						<td class="text-left"><?php echo $report['date_added']; ?></td>
						<td class="text-left">
						<a href="<?php echo $report['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
						</td>
						
				</tr>
						<?php } ?> 
						<?php } else { ?>
					<tr>
						<td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
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

$('#button-filter').on('click', function() {
	var url = 'index.php?route=tmdform/record&token=<?php echo $token; ?>';
	
	var filter_title = $('input[name=\'form_id\']').val();

	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}
	
	var filter_name = $('input[name=\'customer_id\']').val();

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


<script type="text/javascript">
$('input[name=\'filter_title\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=tmdform/record/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					form_id: 0,
					title:'<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['title'],
						value: item['form_id']
					}
				}));
				
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_title\']').val(item['label']);
		$('input[name=\'form_id\']').val(item['value']);
	}
});
</script>
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=tmdform/record/autocompletecustomer&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          customer_id: 0,
          firstname: '<?php echo $text_none; ?>'
        });

        response($.map(json, function(item) {
          return {
            label: item['firstname'],
            value: item['customer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
    $('input[name=\'customer_id\']').val(item['value']);
  }
});
</script>
<?php echo $footer; ?>

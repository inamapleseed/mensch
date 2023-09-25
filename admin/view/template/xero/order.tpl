<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <div class="pull-right">
      <button type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" onclick="$('#filter-order').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>
      <button type="button" id="btn-export" data-loading-text = "<?php echo $text_exporting; ?>" class="btn btn-default"><i class="fa fa-download"></i> <?php echo $text_export; ?></button>
    </div>
    <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</div>
<div class="container-fluid div_export"><?php if ($error_warning) { ?>
  <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <div id="filter-order" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-filter"></i> <?php echo $text_filter; ?></h3>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
            <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
          </div>
          <div class="form-group">
            <label class="control-label" for="input-xero_order_id"><?php echo $entry_xero_order_id; ?></label>
            <input type="text" name="filter_xero_order_id" value="<?php echo $filter_xero_order_id; ?>" placeholder="<?php echo $entry_xero_order_id; ?>" id="input-xero_order_id" class="form-control" />
          </div>
          <div class="form-group">
            <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
            <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
          </div>
          <div class="form-group">
            <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <select name="filter_order_status_id" id="input-order-status" class="form-control">
              <option value=""></option>

              <?php if ($filter_order_status_id == '0') { ?>

              <option value="0" selected="selected"><?php echo $text_missing; ?></option>

              <?php } else { ?>

              <option value="0"><?php echo $text_missing; ?></option>

              <?php } ?>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>

              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>

              <?php } else { ?>

              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>

              <?php } ?>
              <?php } ?>

            </select>
          </div>
          <div class="form-group">
            <label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
            <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
          </div>
          <div class="form-group">
            <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
            <div class="input-group date">
              <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
              <span class="input-group-btn">
              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
              </span> </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
            <div class="input-group date">
              <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
              <span class="input-group-btn">
              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
              </span> </div>
          </div>
          <div class="form-group text-right">
            <button type="button" id="button-filter" class="btn btn-default"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 col-md-pull-3 col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        </div>
        <div class="panel-body">
          <form method="post" action="" enctype="multipart/form-data" id="form-order">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                    <td class="text-right"><?php if ($sort == 'o.order_id') { ?> <a href="<?php echo $sort_order; ?>" class="<?php echo $order; ?>"><?php echo $column_order_id; ?></a> <?php } else { ?> <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a> <?php } ?></td>
                    <td class="text-right"><?php echo $column_xero_order_id; ?></td>
                    <td class="text-left"><?php if ($sort == 'customer') { ?> <a href="<?php echo $sort_customer; ?>" class="<?php echo $order; ?>"><?php echo $column_customer; ?></a> <?php } else { ?> <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a> <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'order_status') { ?> <a href="<?php echo $sort_status; ?>" class="<?php echo $order; ?>"><?php echo $column_status; ?></a> <?php } else { ?> <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a> <?php } ?></td>
                    <td class="text-right"><?php if ($sort == 'o.total') { ?> <a href="<?php echo $sort_total; ?>" class="<?php echo $order; ?>"><?php echo $column_total; ?></a> <?php } else { ?> <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a> <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'o.date_added') { ?> <a href="<?php echo $sort_date_added; ?>" class="<?php echo $order; ?>"><?php echo $column_date_added; ?></a> <?php } else { ?> <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a> <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'o.date_modified') { ?> <a href="<?php echo $sort_date_modified; ?>" class="<?php echo $order; ?>"><?php echo $column_date_modified; ?></a> <?php } else { ?> <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a> <?php } ?></td>
                  </tr>
                </thead>
                <tbody>

                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-center"> <?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                  <td class="text-right"><?php echo $order['xero_order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['order_status']; ?></td>
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
                  </tbody>

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
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = '';

	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

  var filter_xero_order_id = $('input[name=\'filter_xero_order_id\']').val();

	if (filter_xero_order_id) {
		url += '&filter_xero_order_id=' + encodeURIComponent(filter_xero_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();

	if (filter_order_status_id !== '') {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	location = 'index.php?route=xero/order&token=<?php echo $token; ?>' + url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);

	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}

	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);

			break;
		}
	}
});

$('#button-shipping, #button-invoice').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

// IE and Edge fix!
$('#button-shipping, #button-invoice').on('click', function(e) {
	$('#form-order').attr('action', this.getAttribute('formAction'));
});


//--></script>
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<script type="text/javascript"><!--
$('#btn-export').on('click', function() {
  $.ajax({
    url: 'index.php?route=xero/order/export&token=<?php echo $token; ?>',
    type: 'post',
    dataType: 'json',
    beforeSend: function() {
      $('#btn-export').button('loading');
      $("button").attr("disabled", "disabled");
    },
    complete: function() {
      $('#btn-export').button('reset');
      $("button").attr("disabled", false);
    },
    success: function(json) {
      $('.alert-dismissible').remove();

      if (json['success']) {
        $('.div_export').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }
      
      if (json['message'] != ""){
          alert(json['message']);
      }

      setTimeout(function(){
         window.location.reload(1);
      }, 5000);
    }
  });
});

//--></script>
</div>
<?php echo $footer; ?>

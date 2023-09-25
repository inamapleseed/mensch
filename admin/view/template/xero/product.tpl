<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" onclick="$('#filter-product').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>
        <!-- <button type="button" id="btn-import" data-loading-text = "<?php echo $text_importing; ?>" class="btn btn-default"><i class="fa fa-download"></i> <?php echo $text_import; ?></button> -->
        <button type="button" id="btn-export" data-loading-text = "<?php echo $text_exporting; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $text_export; ?></button>
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
      <div id="filter-product" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-filter"></i> <?php echo $text_filter; ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="control-label" for="input-product_id"><?php echo $entry_product_id; ?></label>
              <input type="text" name="filter_product_id" value="<?php echo $filter_product_id; ?>" placeholder="<?php echo $entry_product_id; ?>" id="input-product_id" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-xero_product_id"><?php echo $entry_xero_product_id; ?></label>
              <input type="text" name="filter_xero_product_id" value="<?php echo $filter_xero_product_id; ?>" placeholder="<?php echo $entry_xero_product_id; ?>" id="input-xero_product_id" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
              <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
              <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>
              <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
              <input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
              <select name="filter_status" id="input-status" class="form-control">
                <option value=""></option>
                <?php if ($filter_status == '1') { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if ($filter_status == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
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
            <form action="" method="post" enctype="multipart/form-data" id="form-product">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                      <td class="text-left"><?php echo $column_product_id; ?></td>
                      <td class="text-left"><?php echo $column_xero_product_id; ?></td>
                      <td class="text-center"><?php echo $column_image; ?></td>
                      <td class="text-left"><?php if ($sort == 'pd.name') { ?> <a href="<?php echo $sort_name; ?>" class="<?php echo $order; ?>"><?php echo $column_name; ?></a> <?php } else { ?> <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a> <?php } ?></td>
                      <td class="text-left"><?php if ($sort == 'p.model') { ?> <a href="<?php echo $sort_model; ?>" class="<?php echo $order; ?>"><?php echo $column_model; ?></a> <?php } else { ?> <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a> <?php } ?></td>
                      <td class="text-right"><?php if ($sort == 'p.price') { ?> <a href="<?php echo $sort_price; ?>" class="<?php echo $order; ?>"><?php echo $column_price; ?></a> <?php } else { ?> <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a> <?php } ?></td>
                      <td class="text-right"><?php if ($sort == 'p.quantity') { ?> <a href="<?php echo $sort_quantity; ?>" class="<?php echo $order; ?>"><?php echo $column_quantity; ?></a> <?php } else { ?> <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a> <?php } ?></td>
                      <td class="text-left"><?php if ($sort == 'p.status') { ?> <a href="<?php echo $sort_status; ?>" class="<?php echo $order; ?>"><?php echo $column_status; ?></a> <?php } else { ?> <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a> <?php } ?></td>
                    </tr>
                  </thead>
                  <tbody>

                  <?php if ($products) { ?>
                  <?php foreach ($products as $product) { ?>
                  <tr>
                    <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                      <?php } ?></td>
                    <td class="text-left"><?php echo $product['product_id']; ?></td>
                    <td class="text-left"><?php echo $product['xero_product_id']; ?></td>
                    <td class="text-center"><?php if ($product['image']) { ?> <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" /> <?php } else { ?> <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span> <?php } ?></td>
                    <td class="text-left"><?php echo $product['name']; ?></td>
                    <td class="text-left"><?php echo $product['model']; ?></td>
                    <td class="text-right"><?php echo $product['price']; ?></td>
                    <td class="text-right"><?php if ($product['quantity'] <= 0) { ?> <span class="label label-warning"><?php echo $product['quantity']; ?></span> <?php } elseif ($product['quantity'] <= 5) { ?> <span class="label label-danger"><?php echo $product['quantity']; ?></span> <?php } else { ?> <span class="label label-success"><?php echo $product['quantity']; ?></span> <?php } ?></td>
                    <td class="text-left"><?php echo $product['status']; ?></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
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
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = '';

  var filter_product_id = $('input[name=\'filter_product_id\']').val();

	if (filter_product_id) {
		url += '&filter_product_id=' + encodeURIComponent(filter_product_id);
	}

  var filter_xero_product_id = $('input[name=\'filter_xero_product_id\']').val();

	if (filter_xero_product_id) {
		url += '&filter_xero_product_id=' + encodeURIComponent(filter_xero_product_id);
	}

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('input[name=\'filter_model\']').val();

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_price = $('input[name=\'filter_price\']').val();

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_quantity = $('input[name=\'filter_quantity\']').val();

	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status !== '') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = 'index.php?route=xero/product&token=<?php echo $token; ?>' + url;
});
//--></script>
  <script type="text/javascript"><!--
// IE and Edge fix!
$('button[form=\'form-product\']').on('click', function(e) {
	$('#form-product').attr('action', $(this).attr('formaction'));
});

$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=xero/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}
});

$('input[name=\'filter_model\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=xero/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_model\']').val(item['label']);
	}
});
//--></script>
<script type="text/javascript"><!--
$('#btn-export').on('click', function() {
  $.ajax({
    url: 'index.php?route=xero/product/export&token=<?php echo $token; ?>',
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

      setTimeout(function(){
         window.location.reload(1);
      }, 5000);
    }
  });
});

$('#btn-import').on('click', function() {
  $.ajax({
    url: 'index.php?route=xero/product/import&token=<?php echo $token; ?>',
    type: 'post',
    dataType: 'json',
    beforeSend: function() {
      $('#btn-import').button('loading');
      $("button").attr("disabled", "disabled");
    },
    complete: function() {
      $('#btn-import').button('reset');
      $("button").attr("disabled", false);
    },
    success: function(json) {
      $('.alert-dismissible').remove();

      if (json['success']) {
        $('.div_export').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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

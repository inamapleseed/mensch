<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" onclick="$('#filter-customer').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>
        <button type="button" id="btn-import" data-loading-text = "<?php echo $text_importing; ?>" class="btn btn-default"><i class="fa fa-download"></i> <?php echo $text_import; ?></button>
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
      <div id="filter-customer" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-filter"></i> <?php echo $text_filter; ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="control-label" for="input-customer_id"><?php echo $entry_customer_id; ?></label>
              <input type="text" name="filter_customer_id" value="<?php echo $filter_customer_id; ?>" placeholder="<?php echo $entry_customer_id; ?>" id="input-customer_id" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-xero_customer_id"><?php echo $entry_xero_customer_id; ?></label>
              <input type="text" name="filter_xero_customer_id" value="<?php echo $filter_xero_customer_id; ?>" placeholder="<?php echo $entry_xero_customer_id; ?>" id="input-xero_customer_id" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
              <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
              <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
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
            <div class="table-responsive">
              <form action="" method="post" enctype="multipart/form-data" id="form-customer">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                      <td class="text-left"><?php echo $column_customer_id; ?></td>
                      <td class="text-left"><?php echo $column_xero_customer_id; ?></td>
                      <td class="text-left"><?php if ($sort == 'name') { ?><a href="<?php echo $sort_name; ?>" class="<?php echo $order; ?>"><?php echo $column_name; ?></a><?php } else { ?><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a><?php } ?></td>
                      <td class="text-left"><?php if ($sort == 'c.email') { ?><a href="<?php echo $sort_email; ?>" class="<?php echo $order; ?>"><?php echo $column_email; ?></a><?php } else { ?><a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a><?php } ?></td>
                      <td class="text-left"><?php if ($sort == 'c.status') { ?><a href="<?php echo $sort_status; ?>" class="<?php echo $order; ?>"><?php echo $column_status; ?></a><?php } else { ?><a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a><?php } ?></td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if ($customers) { ?>
                  <?php foreach ($customers as $customer) { ?>
                  <tr>
                    <td class="text-center"><?php if (in_array($customer['customer_id'], $selected)) { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                      <?php } ?>
                    </td>
                    <td class="text-left"><?php echo $customer['customer_id']; ?></td>
                    <td class="text-left"><?php echo $customer['xero_customer_id']; ?></td>
                    <td class="text-left"><?php echo $customer['name']; ?></td>
                    <td class="text-left"><?php echo $customer['email']; ?></td>
                    <td class="text-left"><?php echo $customer['status']; ?></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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
  $('.table-responsive').on('shown.bs.dropdown', function (e) {
    var t = $(this),
      m = $(e.target).find('.dropdown-menu'),
      tb = t.offset().top + t.height(),
      mb = m.offset().top + m.outerHeight(true),
      d = 20;
    if (t[0].scrollWidth > t.innerWidth()) {
      if (mb + d > tb) {
        t.css('padding-bottom', ((mb + d) - tb));
      }
    } else {
      t.css('overflow', 'visible');
    }
  }).on('hidden.bs.dropdown', function () {
    $(this).css({'padding-bottom': '', 'overflow': ''});
  });
  //--></script>
  <script type="text/javascript"><!--
  $('#button-filter').on('click', function() {
    url = 'index.php?route=xero/customer&token=<?php echo $token; ?>';
    var filter_customer_id = $('input[name=\'filter_customer_id\']').val();
    if (filter_customer_id) {
      url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
    }
    var filter_xero_customer_id = $('input[name=\'filter_xero_customer_id\']').val();
    if (filter_xero_customer_id) {
      url += '&filter_xero_customer_id=' + encodeURIComponent(filter_xero_customer_id);
    }
    var filter_name = $('input[name=\'filter_name\']').val();
    if (filter_name) {
      url += '&filter_name=' + encodeURIComponent(filter_name);
    }
    var filter_email = $('input[name=\'filter_email\']').val();
    if (filter_email) {
      url += '&filter_email=' + encodeURIComponent(filter_email);
    }
    var filter_status = $('select[name=\'filter_status\']').val();
    if (filter_status !== '') {
      url += '&filter_status=' + encodeURIComponent(filter_status);
    }
    location = url;
  });
  //--></script>
  <script type="text/javascript"><!--
  $('input[name=\'filter_name\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=xero/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
      $('input[name=\'filter_name\']').val(item['label']);
    }
  });
  $('input[name=\'filter_email\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=xero/customer/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['email'],
              value: item['customer_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('input[name=\'filter_email\']').val(item['label']);
    }
  });
  //--></script>
  <script type="text/javascript"><!--
  $('#btn-export').on('click', function() {
    $.ajax({
      url: 'index.php?route=xero/customer/export&token=<?php echo $token; ?>',
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
      url: 'index.php?route=xero/customer/import&token=<?php echo $token; ?>',
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

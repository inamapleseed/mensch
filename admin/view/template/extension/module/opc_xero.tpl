<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="https://www.xero.com/us/signup/" target="_blank" data-toggle="tooltip" title="Create Xero Account" class="btn btn-default"><i class="fa fa-user"></i></a>
        <a href="https://developer.xero.com" target="_blank" data-toggle="tooltip" title="Create xero app to get client id and secret" class="btn btn-default"><i class="fa fa-child"></i></a>
        <?php if ($connect_button) { ?>
          <a href="<?php echo $authorizationRequestUrl; ?>" target="_blank" onclick="return !window.open(this.href, '', 'width=500,height=600')" data-toggle="tooltip" title="Generate Tokens" class="btn btn-default"><i class="fa fa-key"></i></a>
        <?php } ?>
        <a href="<?php echo $user_guide; ?>" target="_blank" data-toggle="tooltip" title="User Guide" class="btn btn-primary"><i class="fa fa-file"></i></a>
        <button type="submit" form="form-opc_xero" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-opc_xero" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-1 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-5">
              <select name="module_opc_xero_status" id="input-status" class="form-control">
                <?php if ($module_opc_xero_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>

            <label class="col-sm-1 control-label" for="input-slot"><span data-toggle="tooltip" title="<?php echo $entry_slot_help; ?>"><?php echo $entry_slot; ?></span></label>
            <div class="col-sm-5">
              <input type="number" min="5" max="50" class="form-control" placeholder="<?php echo $entry_slot; ?>" name="module_opc_xero_slot" value="<?php echo $module_opc_xero_slot; ?>">
              <?php if ($error_slot) { ?>
                <div class="text-danger"><?php echo $error_slot; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-1 control-label" for="input-client_id"><?php echo $entry_client_id; ?></label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="<?php echo $entry_client_id; ?>" name="module_opc_xero_client_id" value="<?php echo $module_opc_xero_client_id; ?>">
              <?php if ($error_client_id) { ?>
                <div class="text-danger"><?php echo $error_client_id; ?></div>
              <?php } ?>
            </div>

            <label class="col-sm-1 control-label" for="input-client_secret"><?php echo $entry_client_secret; ?></label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="<?php echo $entry_client_secret; ?>" name="module_opc_xero_client_secret" value="<?php echo $module_opc_xero_client_secret; ?>">
              <?php if ($error_client_secret) { ?>
                <div class="text-danger"><?php echo $error_client_secret; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-1 control-label" for="input-access_token"><?php echo $entry_access_token; ?></label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="<?php echo $entry_access_token; ?>" name="module_opc_xero_access_token" value="<?php echo $module_opc_xero_access_token; ?>">
            </div>

            <label class="col-sm-1 control-label" for="input-refresh_token"><?php echo $entry_refresh_token; ?></label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="<?php echo $entry_refresh_token; ?>" name="module_opc_xero_refresh_token" value="<?php echo $module_opc_xero_refresh_token; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-1 control-label" for="input-product_code"><span data-toggle="tooltip" title="<?php echo $entry_product_code_help; ?>"><?php echo $entry_product_code; ?></span></label>
            <div class="col-sm-5">
              <select name="module_opc_xero_product_code" id="input-product_code" class="form-control">
                <option value="sku" <?php if(isset($module_opc_xero_product_code) && $module_opc_xero_product_code == 'sku'){ ?>selected="selected"<?php } ?> ><?php echo $entry_sku; ?></option>
                <option value="model" <?php if(isset($module_opc_xero_product_code) && $module_opc_xero_product_code == 'model'){ ?>selected="selected"<?php } ?> ><?php echo $entry_model; ?></option>
              </select>
            </div>

            <label class="col-sm-1 control-label" for="input-account"><?php echo $entry_account; ?></label>
            <div class="col-sm-5">
              <select name="module_opc_xero_account" id="input-account" class="form-control">
                <?php if (isset($accounts) && $accounts) { ?>
                  <?php foreach ($accounts as $account) { ?>
                    <option value="<?php echo $account['id']; ?>" <?php if ($module_opc_xero_account == $account['id']) { ?>selected="selected"<?php } ?>><?php echo $account['name'] ; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-1 control-label" for="input-invoice_status"><span data-toggle="tooltip" title="<?php echo $entry_invoice_status_help; ?>"><?php echo $entry_invoice_status; ?></span></label>
            <div class="col-sm-5">
              <select name="module_opc_xero_invoice_status" id="input-invoice_status" class="form-control">
                <option value="DRAFT" <?php if(isset($module_opc_xero_invoice_status) && $module_opc_xero_invoice_status == 'DRAFT'){ ?>selected="selected"<?php } ?> >DRAFT</option>
                <option value="SUBMITTED" <?php if(isset($module_opc_xero_invoice_status) && $module_opc_xero_invoice_status == 'SUBMITTED'){ ?>selected="selected"<?php } ?> >SUBMITTED</option>
                <option value="AUTHORISED" <?php if(isset($module_opc_xero_invoice_status) && $module_opc_xero_invoice_status == 'AUTHORISED'){ ?>selected="selected"<?php } ?> >AUTHORISED</option>
              </select>
            </div>

            
            <label class="col-sm-1 control-label" for="input-guest_id"><?php echo "Guest ID"; ?></label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="<?php echo "Guest ID"; ?>" name="module_opc_xero_guest_id" value="<?php echo $module_opc_xero_guest_id; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-1 control-label hidden" for="input-auto_sync"><span data-toggle="tooltip" title="<?php echo $entry_auto_sync_help; ?>"><?php echo $entry_auto_sync; ?></span></label>
            <div class="col-sm-5 hidden">
              <select name="module_opc_xero_auto_sync" id="input-auto_sync" class="form-control">
                <?php if ($module_opc_xero_auto_sync) { ?>
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
            <label class="col-sm-1 control-label" for="input-process-status"><span data-toggle="tooltip" title="<?php echo $help_order_status; ?>"><?php echo $entry_order_status; ?></span></label>
            <div class="col-sm-5">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($order_statuses as $order_status) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (isset($module_opc_xero_order_status) && is_array($module_opc_xero_order_status) && in_array($order_status['order_status_id'], $module_opc_xero_order_status)) { ?>
                    <input type="checkbox" name="module_opc_xero_order_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                    <?php echo $order_status['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="module_opc_xero_order_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                    <?php echo $order_status['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
            </div>
          </div>
          
          <?php if (isset($payment_methods) && $payment_methods) { ?>
            <?php foreach ($payment_methods as $payment_method) { ?>
              <?php $payment_code = $payment_method['code']; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-account"><?php echo ucwords($payment_code . ' ' . $payment_method['type']); ?></label>
                <div class="col-sm-10">
                  <select name="module_opc_xero_payment_account[<?php echo $payment_code; ?>]" id="input-account" class="form-control">
                    <?php if (isset($payment_accounts) && $payment_accounts) { ?>
                      <?php foreach ($payment_accounts as $account) { ?>
                        <option value="<?php echo $account['id']; ?>" <?php if (isset($module_opc_xero_payment_account[$payment_code]) && $module_opc_xero_payment_account[$payment_code] == $account['id']) { ?>selected="selected"<?php } ?>><?php echo $account['name'] ; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script>
    <?php if($xero_error != ""){ ?>
        alert("<?= $xero_error; ?>"+". Please click generate token button and save again");
    <?php } ?>
</script>
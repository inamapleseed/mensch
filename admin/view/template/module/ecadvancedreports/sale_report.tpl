<?php if(!isset($export) || $export != "html") { ?>
<?php echo $header; ?><?php echo $column_left; ?>
<?php } else { ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo (isset($base_url)?$base_url:"")."view/stylesheet/stylesheet.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo (isset($base_url)?$base_url:"")."view/stylesheet/ecadvancedreports.css"; ?>"/>
<style type="text/css">
  #content{background:transparent!important;}
  .box > .content{border:0px solid!important;}
</style>
<body>
<?php } ?>
<div id="content">

  <?php if($export != "html") { ?>
  <div class="page-header">
      <div class="container-fluid">
        <h1><?php echo $heading_title; ?></h1>
        <ul class="breadcrumb">
           <?php foreach ($breadcrumbs as $breadcrumb) { ?>
           <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  <?php } ?>
  <div class="container-fluid">
    <?php if($export != "html") { ?>
    <div class="slidebar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
    <?php } ?>
    <?php if (isset($error_warning) && $error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="content report_earnings panel panel-default">
       <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-th-large"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <?php if($export != "html") { ?>
      <div class="store_filter">
        <ul>
          <li><?php echo $text_show_report_for; ?></li>
          <li>
             <select name="store_id" id="store_id" class="form-control-custom">
                    <option value="0"><?php echo $text_default; ?></option>
                    <?php foreach ($stores as $store) {
                       if(isset($store_id) && $store_id == $store['store_id']){
                        ?>
                        <option selected="selected" value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                        <?php
                         }else{
                        ?>
                          <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                      <?php 
                        }
                    } ?>
            </select>
          </li>
        </ul>
      </div>

      <table class="form no-margin-bottom">
        <tr>
          <td>
            <table>
              <tr>
                <td><?php echo $text_range; ?>
                <select id="select_date_range" name="range_date" onchange="selectDateRange()" class="form-control-custom">
                  <?php foreach ($range_list as $key => $val) { ?>
                  <?php if(isset($range_date) && $range_date == $key) { ?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                  <?php } ?>
                  <?php } ?>
              </select></td>
              <td class="datepicker"><?php echo $entry_date_start; ?>
                <input type="text" name="filter_date_start" data-date-format="YYYY-MM-DD" onchange="setCustomRange()" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
              <td class="datepicker"><?php echo $entry_date_end; ?>
                <input type="text" name="filter_date_end" data-date-format="YYYY-MM-DD" onchange="setCustomRange()" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>

               <td style="padding-left:10px;padding-right:5px"><?php echo $entry_order_status; ?>
                <select name="filter_order_status_id" id="ms" multiple="multiple">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>

              <td style="text-align: right;"><button type="button" onclick="filter();" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button></td>
              </tr>
            </table>
          </td>
          <td class="text_right" style="text-align: right; width:30%">
            <?php echo $text_export_to; ?>
           <select id="select_export_type" name="export_type" class="form-control-custom">
                <?php foreach ($export_types as $key => $val) { ?>
                  <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php } ?>
            </select>
            <button type="button" onclick="ecExport();" class="btn btn-primary"><?php echo $button_export; ?></button>
          </td>
        </tr>
          
         
        </tr>
      </table>
      <?php } ?>
      <div class="table-responsive">
      <?php if ($reports) { ?>
        <table class="list list-reports table table-bordered table-hover">
          <colgroup><col width="80">
                        <col width="140">
                        <col width="120">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                        <col width="60">
                        <col>
                        <col width="100">
                        <col width="60">
                        <col width="60">
                        <col width="60">
                        <col width="60">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
                        <col width="80">
          </colgroup>
          <thead>
            <tr>
               <td class="text-left"><?php echo $column_order_id; ?></td>
               <td class="text-left"><?php echo $column_invoice_no; ?></td>
               <td class="text-left"><?php echo $column_order_date; ?></td>
               <td class="text-left"><?php echo $column_product_name; ?><br/>
                <input type="text"  autocomplete="off" name="filter_product_name" class="filter_input autocomplete" value="<?php echo isset($filter_product_name)?$filter_product_name:""; ?>"/></td>
               <td class="text-left"><?php echo $column_model; ?><br/>
                <input type="text" name="filter_model" class="filter_input" value="<?php echo isset($filter_model)?$filter_model:""; ?>"/></td>
                <td class="text-left"><?php echo $column_customer_name; ?><br/>
                <input type="text" name="filter_customer_name" class="filter_input" value="<?php echo isset($filter_customer_name)?$filter_customer_name:""; ?>"/></td>
               <td class="text-left"><?php echo $column_customer_email; ?><br/>
                <input type="text" name="filter_customer_email" class="filter_input" value="<?php echo isset($filter_customer_email)?$filter_customer_email:""; ?>"/></td>
              <td class="text-left"><?php echo $column_customer_company; ?><br/>
                <input type="text" name="filter_customer_company" class="filter_input" value="<?php echo isset($filter_customer_company)?$filter_customer_company:""; ?>"/></td>
               <td class="text-left"><?php echo $column_customer_group; ?></td>
               <td class="text-left"><?php echo $column_country; ?><br/>
                <input type="text" name="filter_country" class="filter_input" value="<?php echo isset($filter_country)?$filter_country:""; ?>"/></td>
               <td class="text-left"><?php echo $column_region; ?><br/>
                <input type="text" name="filter_region" class="filter_input" value="<?php echo isset($filter_region)?$filter_region:""; ?>"/></td>
               <td class="text-left" style="width:10%"><?php echo $column_city; ?><br/>
                <input type="text" name="filter_city" class="filter_input" value="<?php echo isset($filter_city)?$filter_city:""; ?>"/></td>
               <td class="text-left"><?php echo $column_zipcode; ?><br/>
                <input type="text" name="filter_zipcode" class="filter_input" value="<?php echo isset($filter_zipcode)?$filter_zipcode:""; ?>"/></td>
               
               <td class="text-left"><?php echo $column_manufacturer; ?><br/>
                <input type="text" name="filter_manufacturer" class="filter_input" value="<?php echo isset($filter_manufacturer)?$filter_manufacturer:""; ?>"/></td>
               <td class="text-left"><?php echo $column_qty_ordered; ?></td>
               <td class="text-left"><?php echo $column_qty_refunded; ?></td>
               <td class="text-left"><?php echo $column_reward; ?></td>
               <td class="text-left"><?php echo $column_price; ?></td>
               <td class="text-left"><?php echo $column_original_price; ?></td>
               <td class="text-left"><?php echo $column_subtotal; ?></td>
               <td class="text-left"><?php echo $column_tax; ?></td>
               <td class="text-left"><?php echo $column_total; ?></td>
               <td class="text-left"><?php echo $column_total_include_tax; ?></td>
               <td class="text-left"><?php echo $column_refunded; ?></td>
               <td class="text-left"><?php echo $column_view_order; ?></td>
               <td class="text-left"><?php echo $column_view_product; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reports as $key => $report) { ?>
            <?php if($report) { ?>
              <tr>
                <td class="text-left"><?php  echo "#".(isset($report["order_id"])?$report['order_id']:0); ?></td>
                <td class="text-right"><?php echo isset($report["invoice_no"])?$report['invoice_no']:"";?></td>
                <td class="text-right"><?php echo isset($report["order_date"])?$report['order_date']:"";?></td>
                <td class="text-right">
                <?php echo isset($report["product_name"])?$report["product_name"]:"";?><br />
                <?php if(isset($report['option']) && $report['option']) {
                        foreach ($report['option'] as $option) { ?>
                        - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } 
                      }
                  ?>
                </td>
                <td class="text-right"><?php echo isset($report["model"])?$report['model']:"";?></td>
                <td class="text-right"><a href="<?php echo $report['customer_link']; ?>" target="_BLANK"><?php echo isset($report["customer_name"])?$report["customer_name"]:"";?></a></td>
                <td class="text-right"><a href="<?php echo $report['customer_link']; ?>" target="_BLANK"><?php echo isset($report["customer_email"])?$report["customer_email"]:"";?></a></td>
                <td class="text-right"><?php echo isset($report["customer_company"])?$report["customer_company"]:"";?></td>
                <td class="text-right"><?php echo isset($report["custom_group_name"])?$report["custom_group_name"]:"";?></td>
                <td class="text-right"><?php echo isset($report["country"])?$report["country"]:"";?></td>
                <td class="text-right"><?php echo isset($report["region"])?$report["region"]:"";?></td>
                <td class="text-right"><?php echo isset($report["city"])?$report["city"]:"";?></td>
                <td class="text-right"><?php echo isset($report["zipcode"])?$report["zipcode"]:"";?></td>
                
                <td class="text-right"><?php echo isset($report["manufacturer"])?$report["manufacturer"]:"";?></td>
                <td class="text-right"><?php echo isset($report["quantity"])?$report["quantity"]:"0";?></td>
                <td class="text-right"><?php echo isset($report["refunded_quantity"])?$report["refunded_quantity"]:"0";?></td>
                <td class="text-right"><?php echo isset($report["reward"])?$report["reward"]:"0";?></td>
                <td class="text-right"><?php echo isset($report["price2"])?$report["price2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["original_price2"])?$report["original_price2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["subtotal2"])?$report["subtotal2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["tax2"])?$report["tax2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["total2"])?$report["total2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["total_include_tax2"])?$report["total_include_tax2"]:"0.00";?></td>
                <td class="text-right"><?php echo isset($report["refunded2"])?$report["refunded2"]:"0.00";?></td>
                <td class="text-left"><a href="<?php echo isset($report["order_link"])?$report["order_link"]:"#";?>"><?php echo $text_view;?></a></td>
                <td class="text-left"><a href="<?php echo isset($report["product_link"])?$report["product_link"]:"#";?>"><?php echo $text_view;?></a></td>
              </tr>
              <?php } else { ?>
              <tr class="not_found">
                <td class="text-left"><?php echo $key; ?></td>
                <td colspan="8" style="text-align:center"><?php echo $text_no_found_on_period;?></td>
              </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td class="text-left">
                <?php echo $text_total; ?>
              </td>
              <td colspan="13"></td>
              <td class="text-right"><b><?php echo $sum_quantity; ?></b></td>
              <td class="text-right"><b><?php echo $sum_quantity_refunded;?></b></td>
              <td class="text-right"><b><?php echo $sum_reward;?></b></td>
              <td class="text-right"><b><?php echo $sum_price_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_original_price_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_subtotal_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_tax_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_total_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_total_tax_with_currency;?></b></td>
              <td class="text-right"><b><?php echo $sum_refunded_with_currency;?></b></td>
              <td ><td>

            </tr>
          </tfoot>
        </table>
      <?php } else { ?>

      <?php echo $text_no_results; ?>

      <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if($export != "html") { ?>
<?php 
  $today = date("Y-m-d");
  $yesterday = date('Y-m-d', strtotime("-1 days"));
  $last_seven_days = date('Y-m-d', strtotime("-7 days"));

  /*Last week*/
  $start_last_week = strtotime('-2 Sunday');
  $end_last_week = strtotime("+7 days", $start_last_week);
  $last_week_start = date('Y-m-d', $start_last_week);
  $last_week_end = date('Y-m-d', $end_last_week);
  /*Last business week*/
  $start_week = strtotime("last monday midnight");
  $end_week = strtotime("+4 days",$start_week);
  $last_start_business_week = date("Y-m-d",$start_week);
  $last_end_business_week = date("Y-m-d",$end_week);
  /*This Month*/
  $start_month = date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
  /*Last Month*/
  $last_month_start = strtotime('first day of last month');
  $last_month_end = strtotime('last day of last month');

  if(!$last_month_start) {
    $last_month_start = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")));
  } else {
    $last_month_start = date("Y-m-d", $last_month_start);
  }
  if(!$last_month_end) {
    $last_month_end = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")));
  } else {
    $last_month_end = date("Y-m-d", $last_month_end); 
  }


?>
<script type="text/javascript"><!--
function selectDateRange() {
        var keys = [  'today',
                      'yesterday',
                      'last_7_days',
                      'last_week',
                      'last_business_week',
                      'this_month',
                      'last_month'];
        var from_dates = ['<?php echo $today;?>',
                          '<?php echo $yesterday; ?>',
                          '<?php echo $last_seven_days; ?>',
                          '<?php echo $last_week_start; ?>',
                          '<?php echo $last_start_business_week; ?>',
                          '<?php echo $start_month; ?>',
                          '<?php echo $last_month_start; ?>'
                          ];
        var to_dates = ['<?php echo $today;?>',
                        '<?php echo $yesterday; ?>',
                        '<?php echo $today; ?>',
                        '<?php echo $last_week_end; ?>',
                        '<?php echo $last_end_business_week; ?>',
                        '<?php echo $today;?>',
                        '<?php echo $last_month_end; ?>'
                        ];

        date_range = $('#select_date_range');
        date_start  = $('#date-start');
        date_end   = $('#date-end');
        value = date_range.val();
        if (value != 'custom')
        {
            var i;
            for (i = 0;i < keys.length; i++)
            {
                if ( keys[i] == value )
                {
                    date_start.val(from_dates[i]);
                    date_end  .val(to_dates[i]);
                }
            }
            if($(".datepicker").length) {
              $(".datepicker").trigger("dp.change");
            }
        }
}

function setCustomRange(){
  date_range = $('#select_date_range');
  date_range.val('custom');
}

function ecExport() {
  url = 'index.php?route=ecadvancedreports/sale_report/export&token=<?php echo $token; ?>';

  var filter_date_start = $('input[name=\'filter_date_start\']').val();

  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').val();
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  
  var store_id = $('select[name=\'store_id\']').val();
  
  if (store_id != 0) {
    url += '&store_id=' + encodeURIComponent(store_id);
  }

  var filter_reload_key = $('select[name=\'filter_reload_key\']').val();
  
  if (filter_reload_key != 0) {
    url += '&filter_reload_key=' + encodeURIComponent(filter_reload_key);
  }

  var filter_order_status_id = $("#ms").multipleSelect("getSelects");
  
  if (filter_order_status_id != "") {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  }
  
  var range_date = $('select[name=\'range_date\']').val();
  
  if (range_date) {
    url += '&range_date=' + encodeURIComponent(range_date);
  }

  var export_type = $('select[name=\'export_type\']').val();
  
  if (export_type) {
    url += '&export_type=' + encodeURIComponent(export_type);
  }

  var filter_model = $('input[name=\'filter_model\']').val();
  
  if (filter_model) {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }

  var filter_customer_name = $('input[name=\'filter_customer_name\']').val();
  
  if (filter_customer_name) {
    url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
  }

  var filter_customer_email = $('input[name=\'filter_customer_email\']').val();
  
  if (filter_customer_email) {
    url += '&filter_customer_email=' + encodeURIComponent(filter_customer_email);
  }

  var filter_customer_company = $('input[name=\'filter_customer_company\']').val();
  
  if (filter_customer_company) {
    url += '&filter_customer_company=' + encodeURIComponent(filter_customer_company);
  }

  var filter_country = $('input[name=\'filter_country\']').val();
  
  if (filter_country) {
    url += '&filter_country=' + encodeURIComponent(filter_country);
  }

  var filter_region = $('input[name=\'filter_region\']').val();
  
  if (filter_region) {
    url += '&filter_region=' + encodeURIComponent(filter_region);
  }

  var filter_city = $('input[name=\'filter_city\']').val();
  
  if (filter_city) {
    url += '&filter_city=' + encodeURIComponent(filter_city);
  }

  var filter_product_name = $('input[name=\'filter_product_name\']').val();
  
  if (filter_product_name) {
    url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
  }

  var filter_manufacturer = $('input[name=\'filter_manufacturer\']').val();
  
  if (filter_manufacturer) {
    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
  }

  location = url;
  
}

function filter() {
  url = 'index.php?route=ecadvancedreports/sale_report&token=<?php echo $token; ?>';

  var filter_date_start = $('input[name=\'filter_date_start\']').val();

  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').val();
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  
  var store_id = $('select[name=\'store_id\']').val();
  
  if (store_id != 0) {
    url += '&store_id=' + encodeURIComponent(store_id);
  }

  var filter_reload_key = $('select[name=\'filter_reload_key\']').val();
  
  if (filter_reload_key != 0) {
    url += '&filter_reload_key=' + encodeURIComponent(filter_reload_key);
  }
  

  var report_period = $('select[name=\'report_period\']').val();
  
  if (report_period != 0) {
    url += '&report_period=' + encodeURIComponent(report_period);
  }

  var filter_order_status_id = $("#ms").multipleSelect("getSelects");
  
  if (filter_order_status_id != "") {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  }
  
  var range_date = $('select[name=\'range_date\']').val();
  
  if (range_date) {
    url += '&range_date=' + encodeURIComponent(range_date);
  }


  var filter_model = $('input[name=\'filter_model\']').val();
  
  if (filter_model) {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }

  var filter_customer_name = $('input[name=\'filter_customer_name\']').val();
  
  if (filter_customer_name) {
    url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
  }

  var filter_customer_email = $('input[name=\'filter_customer_email\']').val();
  
  if (filter_customer_email) {
    url += '&filter_customer_email=' + encodeURIComponent(filter_customer_email);
  }

  var filter_customer_company = $('input[name=\'filter_customer_company\']').val();
  
  if (filter_customer_company) {
    url += '&filter_customer_company=' + encodeURIComponent(filter_customer_company);
  }

  var filter_country = $('input[name=\'filter_country\']').val();
  
  if (filter_country) {
    url += '&filter_country=' + encodeURIComponent(filter_country);
  }

  var filter_region = $('input[name=\'filter_region\']').val();
  
  if (filter_region) {
    url += '&filter_region=' + encodeURIComponent(filter_region);
  }

  var filter_city = $('input[name=\'filter_city\']').val();
  
  if (filter_city) {
    url += '&filter_city=' + encodeURIComponent(filter_city);
  }

  var filter_product_name = $('input[name=\'filter_product_name\']').val();
  
  if (filter_product_name) {
    url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
  }

  var filter_manufacturer = $('input[name=\'filter_manufacturer\']').val();
  
  if (filter_manufacturer) {
    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
  }

  location = url;
}


//--></script>
<script type="text/javascript"><!--
$('input.filter_input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});
//--></script> 

<script type="text/javascript"><!-- 
function initAutocomplete(){
   
    $('input[name=\'filter_product_name\']').autocomplete({
            delay: 0,
            source: function(request, response) {
              $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                data: {token: '<?php echo $token; ?>', filter_name: encodeURIComponent(request.term)},
                type: 'POST',
                success: function(json) {   
                  response($.map(json, function(item) {
                    return {
                      label: item.name,
                      value: item.product_id
                    }
                  }));
                }
              });
            }, 
            select: function(event, ui) {
              $('input[name=\'filter_product_name\']').val(ui.item.label);
              /*$('input[name=\'filter_product_id\']').val(ui.item.value);*/
              return false;
            }
          });
  }

initAutocomplete();
//--></script>

<script type="text/javascript">

    $(function() {
      $('#ms').multipleSelect();
      <?php
      if(isset($filter_order_status_id) && $filter_order_status_id) { ?>
        $("#ms").multipleSelect("setSelects", [<?php echo $filter_order_status_id; ?>]);
      <?php  
      }
      ?>
    });
</script>

<script type="text/javascript"><!--
$(document).ready(function() {
  $('.datepicker').datetimepicker({
    pickTime: false
  })
  $(".datepicker").on("dp.change", function (e) {
    $(this).find("input").change();
  });

  selectDateRange();
});
//--></script> 
<?php echo $footer; ?>
<?php } else { ?>
</body>
</html>
<?php } ?>
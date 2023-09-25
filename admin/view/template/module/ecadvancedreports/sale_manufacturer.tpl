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
      <?php if($export != "html") { ?>
      <div class="store_filter">
        <ul>
          <li><?php echo $text_show_report_for; ?></li>
          <li>
             <select name="store_id" id="store_id">
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

      <table class="form form-top-filter">
        <tr>
          <td>
            <table>
              <tr>
                <td><?php echo $text_range; ?>
                <select id="select_date_range" name="range_date" onchange="selectDateRange()">
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
              <td style="text-align: right;"><button type="button" onclick="filter();" class="btn btn-warning"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button></td>
              </tr>
            </table>
          </td>
          <td class="text_right" style="text-align: right; width:30%">
            <?php echo $text_export_to; ?>
           <select id="select_export_type" name="export_type">
                <?php foreach ($export_types as $key => $val) { ?>
                  <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php } ?>
            </select>
           <button type="button" onclick="ecExport();" class="btn btn-warning"><?php echo $button_export; ?></button>
          </td>
        </tr>
          
         
        </tr>
      </table>
      <?php } ?>
      <?php if ($reports) { ?>
        <br/>
         <div class="table-responsive">
          <table class="list list-reports table table-bordered table-hover">
          <thead>
            <tr>
               <td class="text-left" style="width:10%"><?php echo $column_manufacturer; ?></td>
               <td class="text-left" style="width:10%"><?php echo $column_number_orders; ?></td>
               <td class="text-left" style="width:10%"><?php echo $column_items_ordered; ?></td>
               <td class="text-left"><?php echo $column_tax; ?></td>
               <td class="text-left"><?php echo $column_total; ?></td>
               <td class="text-left"><?php echo $column_refunded; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reports as $key => $report) { ?>
            <?php if($report) { ?>
              <tr>
                <td class="text-left"><?php echo isset($report["manufacturer"])?$report['manufacturer']:"";?></td>
                <td class="text-right"><?php echo isset($report["number_orders"])?$report['number_orders']:0;?></td>
                <td class="text-right"><?php echo isset($report["items_ordered"])?$report["items_ordered"]:"0";?></td>
                <td class="text-right"><?php echo isset($report["tax2"])?$report["tax2"]:"0.00";?></td>
                <td class="text-right column_color_yellow"><?php echo isset($report["total2"])?$report["total2"]:"0.00";?></td>
                <td class="text-right column_color_orange"><?php echo isset($report["refunded2"])?$report["refunded2"]:"0.00";?></td>
              </tr>
              <?php } else { ?>
              <tr class="not_found">
                <td class="text-left"><?php echo $key; ?></td>
                <td colspan="6" style="text-align:center"><?php echo $text_no_found_on_period;?></td>
              </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td class="text-left">
                <?php echo $text_total; ?>
              </td>
              <td class="text-right"><b><?php echo $sum_orders; ?></b></td>
              <td class="text-right"><b><?php echo $sum_items_ordered;?></b></td>
              <td class="text-right"><b><?php echo $sum_tax_with_currency;?></b></td>
              <td class="text-right column_color_yellow"><b><?php echo $sum_total_with_currency;?></b></td>
              <td class="text-right column_color_orange"><b><?php echo $sum_refunded_with_currency;?></b></td>
            </tr>
          </tfoot>
        </table>
      <?php } else { ?>

      <?php echo $text_no_results; ?>

      <?php } ?>
      
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
   url = 'index.php?route=ecadvancedreports/sale_manufacturer/export&token=<?php echo $token; ?>';

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

  location = url;
  
}

function filter() {
  url = 'index.php?route=ecadvancedreports/sale_manufacturer&token=<?php echo $token; ?>';

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

  var filter_order_status_id = $("#ms").multipleSelect("getSelects");
  
  if (filter_order_status_id != "") {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  }
  
  var range_date = $('select[name=\'range_date\']').val();
  
  if (range_date) {
    url += '&range_date=' + encodeURIComponent(range_date);
  }

  location = url;
}


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
   //$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  
  // $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
  <!--
  $('.datepicker').datetimepicker({
    pickTime: false
  })
  $(".datepicker").on("dp.change", function (e) {
    $(this).find("input").change();
  });
  //-->
  selectDateRange();
});
//--></script> 
<?php echo $footer; ?>
<?php } else { ?>
</body>
</html>
<?php } ?>
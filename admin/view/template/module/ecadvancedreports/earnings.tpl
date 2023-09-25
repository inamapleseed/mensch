<?php if($export != "html") { ?>
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
          <li><?php echo $entry_order_status; ?>
                <select name="filter_order_status_id" id="ms" multiple="multiple">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
          </li>
          <li style="text-align: right;"><a onclick="filter();" class="btn btn-primary btn-sm"><?php echo $button_filter; ?></a></li>
        </ul>
      </div>
      <div class="earnings-widget__wrapper">
        <div class="earnings-widget">
          <p>
            <?php echo $text_sales_earning_this_month;?> (<?php echo $current_month; ?>):
            <strong class="earnings-widget__amount"><?php echo $total_earnings_currency; ?></strong>
            <small><?php echo $text_total_earnings.$total_earnings_orders; ?></small>
          </p>
        </div>

        <div class="earnings-widget">
          <p>
            <?php echo $text_your_balance; ?>
            <strong class="earnings-widget__amount"><?php echo $total_earnings_currency; ?></strong>
          </p>
        </div>

        <div class="earnings-widget">
          <p>
            <?php echo $text_total_value_of_item_sales; ?>
            <strong class="earnings-widget__amount"><?php echo $total_sales_currency; ?></strong>
            <small><?php echo $text_base_on_each_item; ?></small>
          </p>
        </div>
      </div>
      <?php if($reports ) { ?>
      <div id="chart_container" style="min-width: <?php echo $chart_width; ?>px; height: <?php echo $chart_height; ?>px; margin: 0 auto"></div>
      <?php } ?>
      <table class="form table table-hover">
        <tr>
          <td>
             <?php if($export != "html") { ?>
              <div class="breadcrumb">
                <?php foreach ($filter_breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?>
                <?php if(isset($breadcrumb['href'])): ?>
                <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php else: ?>
                <?php echo $breadcrumb['text']; ?>
                <?php endif; ?>
                <?php } ?>
              </div>
              <?php } ?> 
          </td>
          <td class="text_right" style="text-align: right; width:30%">
            <?php echo $text_export_to; ?>
           <select id="select_export_type" name="export_type" class="form-control-custom">
                <?php foreach ($export_types as $key => $val) { ?>
                  <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php } ?>
            </select>
           <a onclick="ecExport();" class="btn btn-success btn-sm"><?php echo $button_export; ?></a>
          </td>
        </tr>
          
         
        </tr>
      </table>
      <?php } ?>
      <?php if ($reports) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
               <td class="text-left"><?php echo $column_date; ?></td>
               <td class="text-left"><?php echo $column_sales_count; ?></td>
               <td class="text-left"><?php echo $column_products_ordered; ?></td>
               <td class="text-left"><?php echo $column_earnings; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reports as $key => $report) { ?>
            <?php if($report) { ?>
              <tr>
                <td class="text-left">
                  <?php if(isset($report['action']) && $report['action']): ?>
                  <a href="<?php echo $report['action']; ?>"><?php echo $report['datefield']; ?></a>
                  <?php else: ?>
                  <?php echo $report['datefield']; ?>
                  <?php endif; ?>
                </td>
                <td class="text-right"><?php echo isset($report["number_orders"])?$report['number_orders']:0;?></td>
                <td class="text-right"><?php echo isset($report["items_ordered"])?$report["items_ordered"]:"0";?></td>
                <td class="text-right column_color_blue"><?php echo isset($report["subtotal2"])?$report["subtotal2"]:"0.00";?></td>
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
              <td class="text-right column_color_blue"><b><?php echo $sum_subtotal_with_currency;?></b></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <?php } else { ?>

      <?php echo $text_no_results; ?>

      <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if($export != "html") { ?>
<script type="text/javascript"><!--

function ecExport() {
   url = 'index.php?route=ecadvancedreports/earnings/export&token=<?php echo $token; ?>';
  
  <?php if ($filter_year) { ?>
    url += '&filter_year=' + encodeURIComponent("<?php echo $filter_year; ?>");
  <?php } ?>

  <?php if ($filter_month) { ?>
    url += '&filter_month=' + encodeURIComponent("<?php echo $filter_month; ?>");
  <?php } ?>

  <?php if ($filter_day) { ?>
    url += '&filter_day=' + encodeURIComponent("<?php echo $filter_day; ?>");
  <?php } ?>

  <?php if ($current) { ?>
    url += '&current=' + encodeURIComponent("<?php echo $current; ?>");
  <?php } ?>
  
  var store_id = $('select[name=\'store_id\']').attr('value');
  
  if (store_id != 0) {
    url += '&store_id=' + encodeURIComponent(store_id);
  }

  var filter_reload_key = $('select[name=\'filter_reload_key\']').attr('value');
  
  if (filter_reload_key != 0) {
    url += '&filter_reload_key=' + encodeURIComponent(filter_reload_key);
  }

  var filter_order_status_id = $("#ms").multipleSelect("getSelects");
  
  if (filter_order_status_id != "") {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  }

  
  var export_type = $('select[name=\'export_type\']').val();
  if (export_type) {
    url += '&export_type=' + encodeURIComponent(export_type);
  }

  location = url;
}

function filter() {
  url = 'index.php?route=ecadvancedreports/earnings&token=<?php echo $token; ?>';

  <?php if ($filter_year) { ?>
    url += '&filter_year=' + encodeURIComponent("<?php echo $filter_year; ?>");
  <?php } ?>

  <?php if ($filter_month) { ?>
    url += '&filter_month=' + encodeURIComponent("<?php echo $filter_month; ?>");
  <?php } ?>

  <?php if ($filter_day) { ?>
    url += '&filter_day=' + encodeURIComponent("<?php echo $filter_day; ?>");
  <?php } ?>

  <?php if ($current) { ?>
    url += '&current=' + encodeURIComponent("<?php echo $current; ?>");
  <?php } ?>
  
  var store_id = $('select[name=\'store_id\']').attr('value');
  
  if (store_id != 0) {
    url += '&store_id=' + encodeURIComponent(store_id);
  }

  var filter_order_status_id = $("#ms").multipleSelect("getSelects");
  
  if (filter_order_status_id != "") {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
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
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['<?php echo $text_date;?>','<?php echo $text_sale_earnings; ?>', { role: "style" }],
          <?php
          $tmp = array();
          if($filter_year && !$filter_month) {
            for($i =1; $i <= 12; $i++) {
              $datefield = date('M', mktime(0, 0, 0, $i, 10));
              $item_subtotal = 0;
              if(isset($reports[$i])) {
                $item_subtotal = $reports[$i]['subtotal'];
              }
              $tmp[] = "['".$datefield."', ".$item_subtotal.", 'color:#".$chart_color."']";
            }
          } elseif($filter_year && $filter_month && !$filter_day) {
            $number_days = date('t', mktime(0, 0, 0, $filter_month, 1, $filter_year));
            for($i = 1; $i <= $number_days; $i++) { 
              $datefield = $i;
              $item_subtotal = 0;
              if(isset($reports[$i])) {
                $item_subtotal = $reports[$i]['subtotal'];
              }
              $tmp[] = "['".$datefield."', ".$item_subtotal.", 'color:#".$chart_color."']";
            }
          } elseif($filter_year && $filter_month && $filter_day) {
            for($i = 0; $i <= 23; $i++) {
              $datefield = ((strlen($i) < 2) ? "0{$i}" : $i).":00";
              $item_subtotal = 0;
              if(isset($reports[$i])) {
                $item_subtotal = $reports[$i]['subtotal'];
              }
              $tmp[] = "['".$datefield."', ".$item_subtotal.", 'color:#".$chart_color."']";
            }
          } else {
            foreach($reports as $key=>$val) {
              if($val) {
                $tmp[] = "['".$val["datefield"]."', ".$val['subtotal'].", 'color:#".$chart_color."']";
              }
            }
          }

          echo implode(",", $tmp);
        ?>
        ]);

        var options = {
          title: '<?php echo $heading_title; ?>',
          hAxis: {title: '<?php echo $text_date;?>', titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_container'));
        chart.draw(data, options);
      }

//--></script> 
<?php } ?>
<?php if($export != "html") { ?>

<?php echo $footer; ?>

<?php } else { ?>
</body>
</html>
<?php } ?>
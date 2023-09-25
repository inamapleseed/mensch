<?php if(!isset($export) || $export != "html") { ?>
<?php echo $header; ?>
<style type="text/css">
  .list .low_stock{background: #FFA500!important; color:#FFFFFF!important;}
  .list .available{background: #008000!important; color:#FFFFFF!important;}
  .list .out_stock{background: #FF0000!important; color:#FFFFFF!important;}
  .list tbody tr:hover td.low_stock,.list tbody tr:hover td.available,.list tbody tr:hover td.out_stock{color:#000000!important;}
</style>
<?php echo $column_left; ?>
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
  .list .low_stock{background: #FFA500!important; color:#FFFFFF!important;}
  .list .available{background: #008000!important; color:#FFFFFF!important;}
  .list .out_stock{background: #FF0000!important; color:#FFFFFF!important;}
  .list tbody tr:hover td.low_stock,.list tbody tr:hover td.available,.list tbody tr:hover td.out_stock{color:#000000!important;}
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
      <table class="form no-margin-bottom form-top-filter">
        <tr>
          <td>
            <table>
              <tr>
                <td><?php echo $text_category; ?>
                <select name="filter_category_id">
                      <option value=""><?php echo $text_choose_a_category;?></option>
                      <?php foreach ($categories as $category) { ?>
                      <?php if(isset($filter_category_id) && $category['category_id'] == $filter_category_id){ ?>
                        <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                        <?php } ?>
                        <?php if (isset($category['children']) && $category['children']) { ?>
                          <?php foreach ($category['children'] as $child) { ?>
                          <?php if(isset($filter_category_id) && $category['category_id'] == $filter_category_id){ ?>
                            <option value="<?php echo $child['category_id']; ?>" selected="selected"> - <?php echo $child['name']; ?></option>
                          <?php }else{ ?>
                            <option value="<?php echo $child['category_id']; ?>"> - <?php echo $child['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        <?php } ?>
                     
                      <?php } ?>
                </select></td>
                 <td><?php echo $text_manufacturer; ?>
                <select name="filter_manufacturer">
                      <option value=""><?php echo $text_choose_a_manufacturer;?></option>
                      <?php foreach ($manufacturers as $item) { ?>
                      <?php if(isset($filter_manufacturer) && $item['manufacturer_id'] == $filter_manufacturer){ ?>
                        <option value="<?php echo $item['manufacturer_id']; ?>" selected="selected"><?php echo $item['name']; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $item['manufacturer_id']; ?>"><?php echo $item['name']; ?></option>
                        <?php } ?>
                      <?php } ?>
                </select></td>
              <td><?php echo $text_filter_quantity; ?>
                <input type="text" name="filter_quantity" size="10" value="<?php echo isset($filter_quantity)?$filter_quantity:'';?>"/>
              </td>
              <td>
                 <?php echo $text_or; ?>
                  <input type="text" name="product_name" placeholder="<?php echo $text_filter_product;?>" autocomplete="off" value="<?php echo isset($product_name)?$product_name:"";?>" size="30"/>
                  <input type="hidden" name="product_id" value="<?php echo isset($product_id)?$product_id:"";?>"/>
               </td>
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
      </table>
      <div class="well">
        <div class="row">
          <div class="col-sm-12">
            <div class="summary_top">
              <ul>
                <li class="no-border-right"><p class="text"><?php echo $column_qty_inventory; ?></p><p class="number"><?php echo $sum_qty; ?></p></li>
                <li class="no-border-right"><p class="text"><?php echo $column_qty_purchases; ?></p><p class="number"><?php echo $sum_purchases_qty; ?></p></li>
                <li class="no-border-right"><p class="text"><?php echo $column_product_revenue; ?></p><p class="number"><?php echo $sum_total_purchases_with_currency;?></p></li>
              </ul>
            </div>
          </div>
        </div>
    </div>
     
      <?php } ?>
      <?php if ($reports) { ?>
        <div class="table-responsive">
        <table class="list list-reports table table-bordered table-hover">
          <thead>
            <tr>
               <td class="text-left"><?php echo $column_image; ?></td>
               <td class="text-left" <?php if($export_type != "pdf"): ?>style="width:30%"<?php endif; ?>><?php echo $column_product_name; ?></td>
               <td class="text-left"><?php echo $column_product_model; ?></td>
               <td class="text-left"><?php echo $column_product_sku; ?></td>
               <td class="text-left"><?php echo $column_stock_status; ?></td>
               <td class="text-left"><?php echo $column_qty_inventory; ?></td>
               <td class="text-left"><?php echo $column_cost; ?></td>
               <td class="text-left"><?php echo $column_price; ?></td>
               <td class="text-left"><?php echo $column_value; ?></td>
               <td class="text-left"><?php echo $column_total_cost; ?></td>
               <td class="text-left"><?php echo $column_qty_purchases; ?></td>
               <td class="text-left"><?php echo $column_purchases_value; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reports as $key => $report) { ?>
            <?php 
              $quantity = isset($report["quantity"])?$report['quantity']:0; 
              $style_color = "";
              $number_lowstock = isset($number_lowstock)?(int)$number_lowstock:10;
              $label_class = "success";

              if((int)$quantity == 0) {
                $style_color = "color:#FF0000";
                $label_class = "warning";
              } else if((int)$quantity > 0 && (int)$quantity < $number_lowstock) {
                $style_color = "color:#FFA500";
                $label_class = "danger";
              }
            ?>
            <tr>
              <td class="center"><img src="<?php echo $report['image']; ?>" alt="<?php echo $report['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" />
              <?php if(isset($report['options']) && $report['options']) { 
                ?>
                <span id="toggle-<?php echo $report['product_id'] ?>" style="cursor:pointer;" title="<?php echo $text_expand_options; ?>" class="toggle-icons icon-plus <?php if($export != "html") { ?>collapsed<?php } ?>" onclick="toggleOptions(<?php echo $report['product_id']; ?>)"><i class="fa fa-plus" title="<?php echo $text_expand_options; ?>"></i></span>
              <?php
               }?>
              </td>
              <td class="text-left"><a href="<?php echo $report['link']; ?>" target="_BLANK"><?php echo $report['name']; ?></a></td>
              <td class="text-left"><?php echo $report['model']; ?></td>
              <td class="text-left"><?php echo $report['sku']; ?></td>
              <td class="left <?php echo $report['stock_class'];?>"><?php echo $report['stock_status']; ?></td>
              <td class="text-right" style=""><span class="label label-<?php echo $label_class?>"><?php echo $quantity;?></span></td>
              <td class="text-right"><?php echo isset($report["cost2"])?$report['cost2']:"0.00";?></td>
              <td class="text-right"><?php echo isset($report["price2"])?$report['price2']:"0.00";?></td>
              <td class="text-right"><?php echo isset($report["product_value2"])?$report["product_value2"]:"0.00";?></td>
              <td class="text-right"><?php echo isset($report["total_cost2"])?$report["total_cost2"]:"0.00";?></td>
              <td class="text-right"><?php echo isset($report["purchases_quantity"])?$report["purchases_quantity"]:0;?></td>
              <td class="text-right"><?php echo isset($report["purchases_value2"])?$report["purchases_value2"]:"0.00";?></td>
            </tr>
            <?php
              if(isset($report['options']) && $report['options']) {
                foreach($report['options'] as $option) {
                  $style_color = "";
                  $label_class = "success";
                  if(isset($option['product_option_value']) && $option['product_option_value']) {
                    $option_values = isset($option['option_values'])?$option['option_values']:array();

                    foreach($option['product_option_value'] as $option_value) {
                        if($option_value['quantity'] < $number_lowstock && $option_value['quantity'] > 0) {
                          $option_value['stock_status'] = $text_low_stock;
                          $option_value['stock_class'] = "low_stock";
                          $style_color = "color:#FFA500";
                          $label_class = "danger";
                        } else if($option_value['quantity'] <= 0 ) {
                          $option_value['stock_status'] = $text_out_stock;
                          $option_value['stock_class'] = "out_stock";
                          $style_color = "color:#FF0000";
                          $label_class = "warning";
                        } else {
                          $option_value['stock_status'] = $text_available_stock;
                          $option_value['stock_class'] = "available";
                          $label_class = "success";
                        }

                        $option_value_name = isset($option_values[$option_value['option_value_id']])?$option_values[$option_value['option_value_id']]['name']:'';
                        ?>
                      <tr class="product-options-<?php echo $report['product_id']; ?> toggle-options" <?php if($export != "html") { ?>style="display:none"<?php } ?>>
                        <td class="center">|___</td>
                        <td class="text-left"><?php echo $option['name']." - <strong>".$option_value_name."</strong>"; ?></td>
                        <td class="text-left"></td><!-- Model-->
                        <td class="text-left"></td><!-- sku-->
                        <td class="left <?php echo $option_value['stock_class'];?>"><?php echo $option_value['stock_status']; ?></td>
                        <td class="text-right" style=""><span class="label label-<?php echo $label_class?>"><?php echo $option_value['quantity'];?></span></td>
                        <td class="text-right"></td><!-- cost2-->
                        <td class="text-right"><?php echo $option_value['price_prefix']." ".(isset($option_value["price2"])?$option_value['price2']:"0.00");?></td><!-- price2-->
                        <td class="text-right"></td><!-- product_value2-->
                        <td class="text-right"></td><!-- total_cost2-->
                        <td class="text-right"></td><!-- purchases_quantity-->
                        <td class="text-right"></td><!-- purchases_value2-->
                      </tr>
                      <?php
                    }
                  }
                  
                }
              }
            ?>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td class="text-left" colspan="5">
                <?php echo $text_total; ?>
              </td>
              <td class="text-right"><b><?php echo $sum_qty; ?></b></td>
              <td class="text-right"><b><?php echo $sum_total_cost_with_currency; ?></b></td>
              <td class="text-right"><b><?php echo $sum_total_price_with_currency; ?></b></td>
              <td class="text-right"><b><?php echo $sum_total_value_with_currency; ?></b></td>
              <td class="text-right"><b><?php echo $sum_total_total_cost_with_currency; ?></b></td>
              <td class="text-right"><b><?php echo $sum_purchases_qty; ?></b></td>
              <td class="text-right"><b><?php echo $sum_total_purchases_with_currency; ?></b></td>
            </tr>
          </tfoot>
        </table>
        <?php if($export != "html") { ?>
        <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>
      <?php } else { ?>

      <?php echo $text_no_results; ?>

      <?php } ?>
      </div>
    </div>
    </div>
  </div>
</div>
<?php if($export != "html") { ?>

<script type="text/javascript"><!--
function toggleOptions(product_id) {
   if($(".product-options-"+product_id).length > 0) {
      $(".product-options-"+product_id).toggle();
      $("#toggle-"+product_id).toggleClass("collapsed");
   }
}
function ecExport() {
  url = 'index.php?route=ecadvancedreports/product_inventory/export&token=<?php echo $token; ?>';
  
  var filter_category_id = $('select[name=\'filter_category_id\']').val();
  
  if (filter_category_id) {
    url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
  }

  var filter_manufacturer = $('select[name=\'filter_manufacturer\']').val();
  
  if (filter_manufacturer) {
    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
  }
  
  var filter_quantity = $('input[name=\'filter_quantity\']').val();
  
  if (filter_quantity) {
    url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
  }

  var product_name = $('input[name=\'product_name\']').val();
  
  if (product_name) {
    url += '&product_name=' + encodeURIComponent(product_name);
  }

  var product_id = $('input[name=\'product_id\']').val();
  
  if (product_id) {
    if(product_name == "") {
      product_id = 0;
    }
    url += '&product_id=' + encodeURIComponent(product_id);
  }

  var export_type = $('select[name=\'export_type\']').val();
  
  if (export_type) {
    url += '&export_type=' + encodeURIComponent(export_type);
  }

  <?php if(isset($page) && $page ) { ?>
    url += '&page=<?php echo $page; ?>';
  
 <?php } ?>

  location = url;
  
}

function filter() {
  url = 'index.php?route=ecadvancedreports/product_inventory&token=<?php echo $token; ?>';
  
  var filter_category_id = $('select[name=\'filter_category_id\']').val();
  
  if (filter_category_id) {
    url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
  }

  var filter_manufacturer = $('select[name=\'filter_manufacturer\']').val();
  
  if (filter_manufacturer) {
    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
  }
  
  var store_id = $('select[name=\'store_id\']').val();
  
  if (store_id != 0) {
    url += '&store_id=' + encodeURIComponent(store_id);
  }

  var filter_quantity = $('input[name=\'filter_quantity\']').val();
  
  if (filter_quantity) {
    url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
  }

  var product_name = $('input[name=\'product_name\']').val();
  
  if (product_name) {
    url += '&product_name=' + encodeURIComponent(product_name);
  }

  var product_id = $('input[name=\'product_id\']').val();
  
  if (product_id) {
    if(product_name == "") {
      product_id = 0;
    }
    url += '&product_id=' + encodeURIComponent(product_id);
  }

   <?php if(isset($page) && $page ) { ?>
    url += '&page=<?php echo $page; ?>';
  
 <?php } ?>

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
function initAutocomplete(){
   
    $('input[name=\'product_name\']').autocomplete({
            delay: 0,
            source: function(request, response) {
              $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                data: {token: '<?php echo $token; ?>', filter_name: encodeURIComponent(request)},
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
            select: function(item) {
              $('input[name=\'product_name\']').val(item['label']);
              $('input[name=\'product_id\']').val(item['value']);
              return false;
            }
          });
  }

initAutocomplete();
//--></script>

<?php echo $footer; ?>
<?php } else { ?>
</body>
</html>
<?php } ?>
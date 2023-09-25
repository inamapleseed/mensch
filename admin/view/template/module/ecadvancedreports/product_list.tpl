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
      
      <?php } ?>
      <?php if ($reports) { ?>
        <div class="table-responsive">
        <table class="list list-reports table table-bordered table-hover">
          <thead>
            <tr>
               <td class="text-left"><?php echo $column_image; ?></td>
               
               <td class="text-left"><?php echo $column_product_model; ?></td>
               <td class="text-left"><?php echo $column_product_mpn; ?></td>
               <td class="text-left"><?php echo $column_product_sku; ?></td>
               <td class="text-left" <?php if($export_type != "pdf"): ?>style="width:30%"<?php endif; ?>><?php echo $column_product_name; ?></td>
               <td class="text-left"><?php echo $column_cost; ?></td>
               <td class="text-left"><?php echo $column_price; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reports as $key => $report) { ?>
           
            <tr>
              <td class="center"><img src="<?php echo $report['image']; ?>" alt="<?php echo $report['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" />
              </td>
              <td class="text-left"><?php echo $report['model']; ?></td>
              <td class="text-left"><?php echo $report['mpn']; ?></td>
              <td class="text-left"><?php echo $report['sku']; ?></td>
              <td class="text-left"><a href="<?php echo $report['link']; ?>" target="_BLANK"><?php echo $report['name']; ?></a></td>
              <td class="text-right"><?php echo isset($report["cost2"])?$report['cost2']:"0.00";?></td>
              <td class="text-right"><?php echo isset($report["price2"])?$report['price2']:"0.00";?></td>
            </tr>
            <?php
              if(isset($report['special_price']) && $report['special_price']) {
                ?>

                <tr class="product-special-<?php echo $report['product_id']; ?>">
                  <td class="center"><?php echo $label_product_spcial_price;?></td>
                  <td colspan="6">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                            <td class="text-left"><?php echo $column_customer_group; ?></td>
                            <td class="text-right"><?php echo $column_priority; ?></td>
                            <td class="text-right"><?php echo $column_price; ?></td>
                            <td class="text-left"><?php echo $column_date_start; ?></td>
                            <td class="text-left"><?php echo $column_date_end; ?></td>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach($report['special_price'] as $sp_item) {
                        ?>
                          <tr>
                            <td class="text-left"><?php echo $sp_item['customer_group'];?></td>
                            <td class="text-right"><?php echo $sp_item['priority'];?></td>
                            <td class="text-right"><?php echo $sp_item['price2'];?></td>
                            <td class="text-left"><?php echo $sp_item['date_start'];?></td>
                            <td class="text-left"><?php echo $sp_item['date_end'];?></td>
                          </tr>
                        <?php
                      }
                      ?>
                     </tbody>
                    </table>
                    </div>
                  </td>
                </tr>
                <?php
              }
            ?>
            <?php } ?>
          </tbody>
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

function ecExport() {
  url = 'index.php?route=ecadvancedreports/product_list/export&token=<?php echo $token; ?>';
    
  var filter_manufacturer = $('select[name=\'filter_manufacturer\']').val();
  
  if (filter_manufacturer) {
    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
  }

  var filter_category_id = $('select[name=\'filter_category_id\']').val();
  
  if (filter_category_id) {
    url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
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
  url = 'index.php?route=ecadvancedreports/product_list&token=<?php echo $token; ?>';
  
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
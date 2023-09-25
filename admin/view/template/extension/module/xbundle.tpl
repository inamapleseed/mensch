<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right float-right">
        <button type="submit" form="form-xbundle" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fas fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default btn-light"><i class="fa fas fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach($breadcrumbs as $breadcrumb) { ?>
        <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
 </div>
<div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fas fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fas fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="card panel panel-default">
          <div class="panel-heading card-header">
            <h3 class="panel-title"><i class="fa fas fa-pencil"></i> <?php echo $text_setting; ?></h3>
          </div>
          <div class="panel-body card-body">
           <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-xbundle" class="form-horizontal">
                  <div id="ocm-container">
                    <?php echo $config; ?>
                </div>
           </form>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="view/javascript/ocm/ocm.css?v=1.1.2">
<style type="text/css"> 
ul#language-option {
    margin-top: 15px;
}
.preset-btn {
   text-align: right;
}
.preset-wrapper {
    width: 80%;
    margin: 0 auto;
}
.preset-container {
    margin: 20px auto;
    background: #fdfdfd;
    border: 1px solid #d8d8d8;
    padding: 15px;
    position: relative;
}
.preset-delete {
    position: absolute;
    right: 12px;
}
.adjust-bulk {
    font-weight: normal;
}
/*  For  OC 3.1 */
<?php if ($oc_3_1==true) { ?>
h3.panel-title {
    font-size: 15px;
    font-weight: normal;
    display: inline-block;
    margin: 0;
    padding: 0;
}
<?php } ?>
</style>
<script type="text/javascript">
var _ocm = {
    token: 'token=<?php echo $token; ?>',
    name: '<?php echo $x_name; ?>',
    path: '<?php echo $x_path; ?>'
};
</script>
<script src="view/javascript/ocm/ocm.js?v=1.1.3" type="text/javascript"></script>
<script type="text/javascript"><!--
var active_preset_id;
var unit_row ='<tr rel="{product_id}">'; 
    unit_row += ' <td class="text-left">{name}</td>';
    unit_row += ' <td class="text-left">{price}</td>';
    unit_row += ' <td class="text-left"><input size="15" type="text" class="form-control" name="preset[{index}][products][{product_id}]" rel="{product_id}" value="{value}" /></td>';
    unit_row += '<td class="text-right"><a data-toggle="tooltip" title="<?php echo $text_remove; ?>" class="btn btn-danger btn-sm ocm-row-remove"><i class="fa fas fas fa-times"></i></a></td>';
    unit_row += '  </tr>';
var tpl = <?php echo $tpl; ?>;
var more_help = <?php echo $more_help; ?>;

 /* Batch product selection */
 function addProductIntoRanges(type, selected, result) {
    var _html = '';
    var product_nodes = $('#preset'+active_preset_id+ ' input[name*="products"]'); 
    selected.each(function(i) {
        var product_id = parseInt($(this).val());
        var product = ocm.util.get_in(product_id, result, 'product_id');
        var _is_already_exist = ocm.util.in_dom_array(product_id, product_nodes, 'rel');
        if (!_is_already_exist) {
            var data = {index : active_preset_id, value: 0};
            data.name = product.name;
            data.price = product.price;
            data.product_id = product.product_id;
            var _row = ocm.util.interpolate(unit_row, data);
            ocm.table.add(_row);
        }
    });
}

/* DOM  Event starts */
$(document).ready(function () {
    /* add preset */
    $('.add-new-preset').on('click',function(e) {
        e.preventDefault();
        $this = $(this);
        var preset_id = 0;
        $('.preset-container').each(function() {
            var _preset_id = parseInt($(this).attr('rel'));
            if (_preset_id > preset_id) preset_id = _preset_id;
        });
        preset_id++;
        var preset_html = tpl.preset;
        preset_html = preset_html.replace(/__INDEX__/g, preset_id);
        $('.preset-btn').before(preset_html);
    });

    $("#tab-preset").on('click','.remove-preset',function(){
        $(this).closest('.preset-container').remove();
    });

    $("#tab-preset").on('click','.ocm-row-remove-all',function() {
        active_preset_id = parseInt($(this).closest('.preset-container').attr('rel'));
        ocm.table.setSelector('#preset' + active_preset_id +' tbody');
    }); 
    $("#tab-preset").on('click','.add-new', function() {
        ocm.browser.show({
            type: 'product',
            fn: addProductIntoRanges
        });
        active_preset_id = parseInt($(this).closest('.preset-container').attr('rel'));
        ocm.table.setSelector('#preset' + active_preset_id +' tbody');
    });
    // adjust bulk price
    $("#tab-preset").on('input', '.adjust-bulk', function() {
        var adjust = $(this).val();
        var product_nodes = $(this).closest('table.products').find('tbody input[name*="products"]');
        product_nodes.each(function(i, node) {
            $(node).val(adjust);
        });
    });

 });
//--></script>
<?php echo $_v; ?>
<?php echo $footer; ?>
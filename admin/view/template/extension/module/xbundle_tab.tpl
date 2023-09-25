<div class="tab-pane" id="tab-bundle">
     <div class="bundle-header">
        <div class="bundle-dd">
           <select id="preset_id" name="preset_id" class="form-control">
             <option value=""><?php echo $text_select_preset; ?></option>
             <?php foreach($presets as $preset) { ?>
                 <option value="<?php echo $preset['id']; ?>"><?php echo $preset['name']; ?></option>
             <?php } ?>
           </select>
        </div>
        <div class="preset-btn">
            <a id="load-fetch-btn" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;<?php echo $text_load_preset; ?></a>
        </div>
        <div class="bundle-btn">
            <a class="btn btn-primary add-bundle-product"><i class="fa fa-plus-circle"></i>&nbsp;<?php echo $text_add_product; ?></a>
        </div>
    </div>
    <div class="bundle-products">
        <h4><?php echo $text_bundle_products; ?></h4>
        <table class="table table-bordered">
            <thead>
               <tr>
                   <td class="text-left"><b><?php echo $text_product_name; ?></b></td>
                   <td width="150" class="text-center"><b><?php echo $text_product_price; ?></b></td>
                   <td width="150" class="text-center"><b><?php echo $text_bundle_price; ?></b></td>
                   <td class="text-left" width="300"><b><?php echo $text_discount; ?></b><br /><input type="text" placeholder="<?php echo $text_change_bulk; ?>" class="form-control" id="bulk-adjust" autocomplete="off" /></td>
                   <td width="50" class="text-right"><a data-toggle="tooltip" title="<?php echo $text_remove_all; ?>" class="btn btn-danger btn-sm ocm-row-remove-all" role="button"><i class="fa fas fa-times"></i></a></td>
                </tr>
            </thead>
            <tbody id="bundle-list"> 
                 <?php if ($bundle_products) { ?>
                    <?php foreach($bundle_products as $bundle_product) { ?>
                       <tr>
                        <td class="text-left"><?php echo $bundle_product['name']; ?></td>
                        <td class="text-center"><?php echo $bundle_product['price']; ?></td>
                        <td class="text-center bundle-price"><?php echo $bundle_product['bundle']; ?></td>
                        <td class="text-left"><input size="15" type="text" class="form-control product" name="xbundle[<?php echo $bundle_product['product_id']; ?>]" price="<?php echo $bundle_product['price']; ?>" rel="<?php echo $bundle_product['product_id']; ?>" value="<?php echo $bundle_product['discount']; ?>" /></td>
                        <td class="text-right"><a data-toggle="tooltip" title="<?php echo $text_remove; ?>" class="btn btn-danger btn-sm ocm-row-remove"><i class="fa fas fa-times"></i></a>
                        </td>
                       </tr>
                    <?php } ?>
                 <?php } else { ?>
                    <tr class="no-row"><td colspan="4"><?php echo $text_no_unit_row; ?></td></tr>
                 <?php } ?>
              </tbody>
         </table>
    </div>
</div>
<style type="text/css">
  .bundle-header {
    border: 1px solid #ccc;
    padding: 12px;
    background: #f5f4f4;
  }
  .bundle-header div {
    display: inline-block;;
  }
  .bundle-header .bundle-dd {
     width: 220px;
  }
  .bundle-header .preset-btn {
     width: 120px;
  }
  .bundle-header .bundle-btn {
    width: calc(100% - 350px);
    text-align: right;
  }
  .bundle-products {
    margin-top: 0px;
    border-style: solid;
    padding-top: 15px;
    border-color: #ccc;
    border-width: 0 1px 1px 1px;
    padding: 10px;
   }
   #bulk-adjust {
     font-weight: normal;
   }
</style>
<link rel="stylesheet" type="text/css" href="view/javascript/ocm/ocm.css?v=1.1.2">
<script type="text/javascript">
var _ocm = {
    token: 'token=<?php echo $token; ?>',
    name: '<?php echo $x_name; ?>',
    path: '<?php echo $x_path; ?>'
};
</script>
<script src="view/javascript/ocm/ocm.js?v=1.1.3" type="text/javascript"></script>
<script type="text/javascript">
   var _product_id = <?php echo $product_id; ?>;
   var bundle_row ='<tr rel="true">'; 
    bundle_row += ' <td class="text-left">{name}</td>';
    bundle_row += ' <td class="text-center">{price}</td>';
    bundle_row += ' <td class="text-center bundle-price">{bundle}</td>';
    bundle_row += ' <td class="text-left"><input size="15" type="text" class="form-control product" name="xbundle[{product_id}]" price="{price}" rel="{product_id}" value="{value}" /></td>';
    bundle_row += ' <td class="text-right"><a data-toggle="tooltip" title="<?php echo $text_remove; ?>" class="btn btn-danger btn-sm ocm-row-remove"><i class="fa fas fa-times"></i></a></td>';
    bundle_row += '</tr>';

    $(".add-bundle-product").click(function() {
        setTableXBundle();
        ocm.browser.show({
            type: 'product',
            path: '<?php echo $x_path; ?>',
            fn: addProductIntoRanges
        });
    });
    $('#bulk-adjust').on('input', function() {
        var discount = $(this).val();
        var rate = getDiscountRate(discount);
        $('#bundle-list input.product').each(function(i, node) {
            var price = $(node).attr('price');
            $(node).closest('td').prev('.bundle-price').html(getDiscountedAmount(price, rate));
            $(node).val(discount);
        });
    });
    $('#bundle-list').on('input', 'input.product', function() {
        var discount = $(this).val();
        var rate = getDiscountRate(discount);
        var price = $(this).attr('price');
        $(this).closest('td').prev('.bundle-price').html(getDiscountedAmount(price, rate));
    });
    function getDiscountRate(discount) {
        var value = discount.replace('-', '');
        var percent = false;
        if (value.indexOf('%') !== -1) {
            value = parseFloat(value.replace('%', '')) / 100 || 0;
            percent = true;
        } else {
            value = parseFloat(value) || 0;
        }
        return {
            value: value,
            percent: percent
        };
    }
    function getDiscountedAmount(price, rate) {
        var price = parseFloat(price);
        var amount = rate.percent ? price * rate.value : rate.value;
        price = price - amount;
        if (price < 0) {
            price = 0;
        }
        return price.toFixed(2);
    }
    function setTableXBundle() {
        ocm.table.setSelector('#bundle-list');
        ocm.table.setMessage('There is nothing to show, please click `Add Products` button to add!');
    }
    setTableXBundle();
    function addProductIntoRanges(type, selected, result) {
        var _html = '';
        var product_nodes = $('#bundle-list input.product'); 
        selected.each(function(i) {
            var product_id = parseInt($(this).val());
            addBundleProduct(product_id, result, product_nodes);
        });
    }
    function addBundleProduct(product_id, result, product_nodes) {
        var product = ocm.util.get_in(product_id, result, 'product_id');
        var _is_already_exist = ocm.util.in_dom_array(product_id, product_nodes, 'rel');
        if (product_id == _product_id) {
            _is_already_exist = true;
        }
        if (!_is_already_exist) {
            var data = {};
            data.value = product.discount;
            data.bundle = product.bundle;
            data.name = product.name;
            data.price = product.price;
            data.product_id = product.product_id;
            var _row = ocm.util.interpolate(bundle_row, data);
            ocm.table.add(_row);
        }
    }
    $('#load-fetch-btn').on('click', function(e) {
        e.preventDefault();
        var preset_id = parseInt($('#preset_id').val());
        if (preset_id > 0) {
            $('#load-fetch-btn i').addClass('fa-spin');
            var url = 'index.php?route=extension/module/xbundle/getPreset&' + _ocm.token + '&preset_id=' + preset_id;
            var product_nodes = $('#bundle-list input.product');
            ocm.action.doAjax(url, null, function(json) {
                for (var i = 0; i < json.length; i++) {
                    addBundleProduct(json[i].product_id, json, product_nodes);
                }
                $('#load-fetch-btn i').removeClass('fa-spin');
                $('#preset_id').val('');
            });
        } else {
            alert('<?php echo $text_preset_no; ?>');
        }
    });
</script>
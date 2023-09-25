<?php if ($products) { ?>
<div class="bundle-box">
   <div class="bundle-heading"><?php echo $box_title; ?></div>
   <div class="bundle-container">
      <div class="bundle-main-product">
           <div class="bundle-product">
            <div class="bundle-image">
               <a href="<?php echo $href; ?>"><img src="<?php echo $thumb; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" /></a>
            </div>
            <div class="bundle-title">
               <a  title="<?php echo $name; ?>" href="<?php echo $href; ?>"><?php echo $name; ?></a>
            </div>
            <div class="bundle-price">
               <?php echo $price; ?>
            </div>
            <div class="bundle-option">
               <?php if ($stock==false) { ?>
                 <label class="bundle-label">
                    <input  class="bundle-checkbox" value="<?php echo $product_id; ?>" type="checkbox" />
                    <span class="bundle-checkbox-bg">
                      <i class="fa fa-check icon"></i>
                    </span>
                  </label>
                <?php } else { ?>
                     <div class="bundle-stock-out"><?php echo $stock; ?></div>
                <?php } ?>
              </div>
           </div>
       </div>
       <div class="bundle-products">
          <div class="bundle-products-container">
            <?php foreach($products as $product) { ?>
                <div class="bundle-icon">+</div>
                <div class="bundle-product">
                  <div class="bundle-image">
                     <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
                  </div>
                  <div class="bundle-title">
                     <a title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  </div>
                  <div class="bundle-price">
                      <span class="bundle-new"><?php echo $product['price']; ?></span>
                      <span class="bundle-old"><?php echo $product['old_price']; ?></span>
                  </div>
                  <div class="bundle-option">
                       <?php if ($product['stock']==false) { ?>
                        <label class="bundle-label">
                           <input  class="bundle-checkbox" value="<?php echo $product['product_id']; ?>" type="checkbox" />
                           <span class="bundle-checkbox-bg">
                             <i class="fa fa-check icon"></i>
                           </span>
                        </label>
                      <?php } else { ?>
                          <div class="bundle-stock-out"><?php echo $product['stock']; ?></div>
                      <?php } ?>
                  </div>
               </div>
            <?php } ?>
           </div> 
       </div>
       <div class="bundle-icon bundle-equal">=</div>
       <div class="bundle-purchase">
           <div class="bundle-items"><?php echo $count; ?></div>
           <div class="bundle-original-total bundle-cart"><?php echo $text_bundle_original_cost; ?> <span><?php echo $org_total_tax; ?></span></div>
           <div class="bundle-total bundle-cart"><?php echo $text_bundle_bundle_cost; ?> <span> <?php echo $total_tax; ?></span></div>
           <div class="bundle-save bundle-cart"><?php echo $text_bundle_total_save; ?> <span> <?php echo $save; ?></span></div>
           <div class="bundle-add"><button id="bundle-add-to-cart" class="btn btn-primary"><?php echo $text_bundle_add; ?></button></div>
       </div>
   </div>
</div>

<style type="text/css">
.popup-quickview .bundle-box, .popup-options .bundle-box {
    display: none;
}
.bundle-heading {
   background: #eee;
   color: #888;
   padding: 6px 10px;
   font-size: 17px;
}
.bundle-container {
  width: 100%;
  padding: 15px 15px 5px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}
.bundle-main-product {
  display: inline-block;
}
.bundle-icon {
    width: 30px;
    display: inline-block;
    text-align: center;
    color: #ff6700;
    font-size: 30px;
    font-weight: bold;
    vertical-align: middle;
    box-sizing: border-box;
    height: 225px;
    padding-top: 112px;
}
.bundle-products {
  width: calc(100% - 410px);
  display: inline-block;
  overflow-y: hidden;
  overflow-x: auto;
  position: relative;
  height: 260px;
}
.bundle-products-container {
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
}
.bundle-product {
  display: block;
  box-sizing: border-box;
  width: <?php echo $box_width; ?>px;
  padding: 0px 10px 10px;
  border: 1px solid #ccc;
  text-align: center;
}
.bundle-product:hover {
    box-shadow: 0 0 11px rgba(33,33,33,.2);
}
.bundle-image {
   height: 100px;
}
.bundle-title {
   height: 60px;
   margin-top: 5px;
   overflow: hidden;
}
.bundle-price .bundle-new {
  font-weight: 600;
}
.bundle-price .bundle-old {
    color: #999;
    text-decoration: line-through;
    margin-left: 10px;
}
.bundle-equal {
  width: 60px;
}
.bundle-purchase {
   width: 180px;
   display: inline-block;
   position: relative;
   font-size: 15px;
   padding-top: 45px;
}
.bundle-items {
  margin-bottom: 20px;
}
.bundle-cart {
  margin-bottom: 5px;
}
.bundle-add {
  position: absolute;
  bottom: 30px;
  width: 100%;
  text-align: center;
}
.bundle-stock-out {
  color: #e25757;
}
div.bundle-option {
  display: inline-block;
  margin-top: 5px;
}
.bundle-original-total span {
   text-decoration: line-through;
}
label.bundle-label {
  margin: 0;
  padding: 0;
}
.bundle-checkbox {
  display: none;
}
.bundle-checkbox-bg {
  display: inline-block;
  border: 3px solid rgba(0, 0, 0, 0.1);
  width: 2.5em;
  height: 2.5em;
  cursor: pointer;
}
.bundle-checkbox-bg i.icon {
    opacity: 0.2;
    font-size: calc(1rem + 1vw);
    color: transparent;
    transition: opacity 0.3s 0.1s ease;
    -webkit-text-stroke: 3px rgba(0, 0, 0, 0.5);
    text-stroke: 3px rgba(0, 0, 0, 0.5);
    margin-top: 1px;
    margin-left: 1px;
}

.bundle-checkbox:checked + .bundle-checkbox-bg {
   background: #ff6700;
}

.bundle-checkbox:checked + .bundle-checkbox-bg i.icon {
    opacity: 1;
    color: white;
    -webkit-text-stroke: 0;
    text-stroke: 0;
}
.xbundle-loading {
  text-align: center;
  margin-top: 60px;
}
#tab-xbundle .bundle-heading {
    display: none;
}
 /* Small Devices */
@media only screen and (max-width: 768px) {
    .bundle-container {
       display: block;
       padding: 10px 5px 0px;
    }
    .bundle-main-product {
      float: left;
    }
    html[dir="rtl"] .bundle-main-product {
      float: right;
    }
    .bundle-product {
      width: 155px;
      padding: 0px 5px 5px;
    }
    .bundle-title a {
      font-size: 100%;
    }
    .bundle-products {
      width: calc(100% - 155px);
    }
    .bundle-equal {
      display: none;
    }
    .bundle-purchase {
        width: 100%;
        display: block;
        font-size: 14px;
        padding-top: 0px;
        clear: both;
        background: #f7f7f7;
        padding: 15px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
    }
    .bundle-checkbox-bg {
        width: 2em;
        height: 1.8em;
    }
    .bundle-add {
       bottom: 15px;
       right: 15px;
       width: auto;
    }
    html[dir="rtl"] .bundle-add {
        left: 10px;
        right: auto;
    }
}
</style>
<script src="catalog/view/javascript/ocmpopup.min.js"></script>
<script type="text/javascript">
var box_size = <?php echo $box_width; ?> + 30;
var total_products = $('.bundle-products-container .bundle-product').length;
var total_width = (total_products * box_size);
$('.bundle-products-container').width(total_width);
var option_url = 'index.php?route=extension/module/xbundle/getOptions';
var _bundle_cart = [];
var _product_id = <?php echo $product_id; ?>;
var _current_node;
var ocm_option_popup = new OCMPopup({
        width: '450px',
        modal: true,
        maxHeight: 300,
        title: '<?php echo $text_product_options; ?>',
        btns: [
            {
                title: '<?php echo $button_option_pick; ?>',
                fn: chooseOptions
            }
        ],
        onClose: function() {
            if (_current_node) {
                $(_current_node).prop('checked', false);
            }
        }
});

$('.bundle-checkbox').change(onBundleSelected);
$('#bundle-add-to-cart').click(onAddBundle);
$(window).on('beforeunload', function() {
    if (_bundle_cart.length > 2) {
        return 'Changes that you made may not be saved.';
    }
});
function onBundleSelected() {
    var url = 'index.php?route=extension/module/xbundle/getBundlePrice';
    var bundle_id = $(this).val();
    var option = $('.ocm-options :input').serializeArray();
    var data = {};
    _current_node = this;
    if ($(this).prop('checked')) {
        data.bundle_id = bundle_id;
        if (option && option.length) {
            option = flatten(option);
            $.extend(data, option);
        }
    } else {
        removeFromCart(bundle_id);
    }
    data.cart = _bundle_cart;
    data._product_id = _product_id;
    $('#bundle-add-to-cart').attr('disabled', 'disabled');
    $.post(url, data, function(json) {
        if (handleCartError(json, bundle_id)) {
            _current_node = false;
            ocm_option_popup.close();
            $('.bundle-items').html(json.count);
            $('.bundle-original-total span').html(json.org_total_tax);
            $('.bundle-total span').html(json.total_tax);
            $('.bundle-save span').html(json.save_tax);
            $('.xbundle-popup-wrapper').remove();
            _bundle_cart = json.cart;
        }
        $('#bundle-add-to-cart').removeAttr('disabled');
    }, 'json');
}
function onAddBundle() {
    var is_main_added = false;
    for (var i = 0; i < _bundle_cart.length; i++) {
        var product = _bundle_cart[i];
        if (parseInt(product.product_id) == _product_id) {
            is_main_added = true;
            break
        }
    }
    if (!is_main_added) {
        alert('<?php echo $error_main_product; ?>');
        return;
    }
    if (_bundle_cart.length == 1) {
        alert('<?php echo $error_bundle_product; ?>');
        return;
    }
    var data = {};
    data.cart = _bundle_cart;
    data._product_id = _product_id;

    var url = 'index.php?route=extension/module/xbundle/addBundle';
    $('#bundle-add-to-cart').attr('disabled', 'disabled');
    $.post(url, data, function(json) {
        if (json && json.success) {
            refreshCart(json);
            $('.breadcrumb').after('<div class="alert alert-success success alert-dismissible">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            /* Reset bundle */
            _bundle_cart = [];
            $('.bundle-checkbox').prop('checked', false);
            $('.bundle-checkbox').first().trigger('change');
        } else {
            alert('something went wrong');
        }
        $('#bundle-add-to-cart').removeAttr('disabled');
    });
}
function removeFromCart(bundle_id) {
    bundle_id = parseInt(bundle_id);
    _bundle_cart = _bundle_cart.filter(function(product) {
        return parseInt(product.product_id) !== bundle_id;
    });
}
//preselect all products without option.
function bundlePreSelected(main_only) {
    var url = 'index.php?route=extension/module/xbundle/getBundlePrice';
    var cart = [];
    var pre_products = main_only ? $('.bundle-main-product .bundle-checkbox') : $('.bundle-checkbox');
    pre_products.each(function(i, item) {
            $(item).prop('checked', true);
            cart.push({
                product_id: $(item).val(),
                recurring_id: 0
            });
    });
    var data = {};
    data.cart = cart;
    data._product_id = _product_id;
    $('#bundle-add-to-cart').attr('disabled', 'disabled');
    $.post(url, data, function(json) {
        if (!json) {
            alert('something went wrong');
            return;
        }
        if (json.error) {
            alert(json.error)
        } else {
            $('.bundle-items').html(json.count);
            $('.bundle-original-total span').html(json.org_total_tax);
            $('.bundle-total span').html(json.total_tax);
            $('.bundle-save span').html(json.save_tax);
            _bundle_cart = json.cart;
        }
        $('#bundle-add-to-cart').removeAttr('disabled');
    }, 'json');
}
function onOptionChosen() {
    $(_current_node).trigger('change');
}
<?php if ($pre_selected) { ?>
bundlePreSelected(true);
<?php } ?>
/* common fuctions related to option */
function chooseOptions() {
    $('.ocm-options .text-danger').remove();
    onOptionChosen();
    ocm_option_popup.showButtonLoader(0);
}
function loadOptions(product_id) {
    ocm_option_popup.show();
    $.get(option_url + '&product_id=' + product_id, function(html) {
        ocm_option_popup.setContent(html);
    });
}
function handleCartError(json, product_id) {
    ocm_option_popup.hideButtonLoader();
    if (json.error && json.error.option) {
        if ($('.ocm-options').length) {
            for (i in json['error']['option']) {
                var element = $('#ocm-input-option' + i.replace('_', '-'));
                if (element.parent().hasClass('input-group')) {
                  element = element.parent();
                }
                element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            }
         } else {
            loadOptions(product_id);
         }
         return false;
    } else if (json.error && json.error.recurring) {
        $('.ocm-options select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
        return false;
    } else if (json.error) {
        alert(json.error);
        return false;
    }
    return true;
}
function refreshCart(json) {
    $('.alert').remove();
    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
    /* journal patch */
    if (window.Journal) {
        if (json['items_count']) {
           $('#cart-items').removeClass('count-zero');            
        } else {
           $('#cart-items').addClass('count-zero'); 
        }
        $('#cart-total').html(json['total']);
        $('#cart-items').html(json['items_count']);
        $('.cart-content ul').load('index.php?route=common/cart/info ul li');
    } else {
        $('#cart ul').load('index.php?route=common/cart/info ul li');
    }
}
function flatten(data) {
    var _return = {};
    $.each(data, function(index, item){
        if (/\[\]$/.test(item.name)) {
           var name = item.name.replace(/\[\]$/, '');
           if (!_return[name]) _return[name] = [];
           _return[name].push(item.value)
        } else {
           _return[item.name] = item.value;
        }
    }); 
    return _return;
}
</script>
<?php } ?>
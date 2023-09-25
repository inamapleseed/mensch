<div class="ocm-options product-info">
 <div class="ocm-option-wrapper product-options">
     <h2><?php echo $name; ?></h2>
     <?php if ($options) { ?>
          <h3><?php echo $text_option; ?></h3>
            <?php foreach($options as $option) { ?>
            <?php if ($option['type']=='select') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>" <?php if ($option_value['ocm_pre_selected']) { ?> selected="selected" <?php } ?>><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?> </option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <?php if ($option['type']=='radio') { ?>
            <div class="form-group push-option<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="ocm-input-option<?php echo $option['product_option_id']; ?>"> <?php foreach($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php if ($option_value['ocm_pre_selected']) { ?> checked="checked" <?php } ?> />
                    <?php if ($option_value['image']) { ?> <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?> <?php echo $option_value['price_prefix']; ?> <?php echo $option_value['price']; ?> <?php } ?>" class="img-thumbnail" data-toggle="tooltip" data-tooltip-class="push-tooltip" data-placement="top" title="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?> (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>) <?php } ?>" /> <?php } ?>
                    <span class="option-value"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?> </label>
                </div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if ($option['type']=='checkbox') { ?>
            <div class="form-group push-option<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="ocm-input-option<?php echo $option['product_option_id']; ?>"> <?php foreach($option['product_option_value'] as $option_value) { ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php if ($option_value['ocm_pre_selected']) { ?> checked="checked" <?php } ?> />
                    <?php if ($option_value['image']) { ?> <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?> <?php echo $option_value['price_prefix']; ?> <?php echo $option_value['price']; ?> <?php } ?>" class="img-thumbnail" data-toggle="tooltip" data-tooltip-class="push-tooltip" data-placement="top" title="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?> (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>) <?php } ?>" /> <?php } ?>
                    <span class="option-value"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?> </label>
                </div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if ($option['type']=='text') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
            <?php if ($option['type']=='textarea') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
            </div>
            <?php } ?>
            <?php if ($option['type']=='file') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <button type="button" id="ocm-button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="ocm-input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
            <?php if ($option['type']=='date') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group date">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type']=='datetime') { ?>
            <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type']=='time') { ?>
             <div class="form-group<?php if ($option['required']) { ?> required <?php } ?>">
              <label class="control-label" for="ocm-input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="ocm-input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
          <?php } ?>
        <?php } ?>

        <?php if ($recurrings) { ?>
            <hr>
            <h3><?php echo $text_payment_recurring; ?></h3>
            <div class="form-group required">
              <select name="recurring_id" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach($recurrings as $recurring) { ?>
                <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
                <?php } ?>
              </select>
              <div class="help-block" id="recurring-description"></div>
           </div>
        <?php } ?>
        <?php if ($no_stock) { ?>
            <p class="text-warning"> <?php echo $no_stock; ?></p>
        <?php } ?>
        <input type="hidden" name="ocm_option" class="ocm_option" value="1">
</div>
</div>
<style type="text/css">
.ocm-options {
   padding: 5px 20px;
}
.ocm-option-wrapper .text-warning {
    margin-top: 28px;
}
.ocm-option-wrapper h2 {
    margin-top: 5px;
    margin-bottom: 15px;
    font-size: 24px;
}
.ocm-option-wrapper h3 {
    font-size: 22px;
}
.bootstrap-datetimepicker-widget {
    z-index: 999999 !important;
}
/* jourmal break layout so reset*/
.ocm-option-wrapper .form-group {
    flex-direction: column !important;
}
.ocm-option-wrapper .form-group .control-label {
    max-width: none !important;
    margin-bottom: 0;
}
.ocm-option-wrapper .form-group .control-label + div {
  flex: 1 1 2px !important;
}
.ocm-option-wrapper .push-tooltip {
    z-index: 999999 !important;
}

</style>
<script type="text/javascript"><!--
<?php if ($no_stock) { ?>
ocm_option_popup.hideFooter();
<?php } ?>
$('.ocm-option-wrapper .date').datetimepicker({
    language: '<?php echo $datepicker; ?>',
    pickTime: false
});
$('.ocm-option-wrapper .datetime').datetimepicker({
    language: '<?php echo $datepicker; ?>',
    pickDate: true,
    pickTime: true
});
$('.ocm-option-wrapper .time').datetimepicker({
    language: '<?php echo $datepicker; ?>',
    pickDate: false
});
$('button[id^=\'ocm-button-upload\']').on('click', function() {
    var node = this;
    $('#ocm-form-upload').remove();
    $('body').prepend('<form enctype="multipart/form-data" id="ocm-form-upload" style="display: none;"><input type="file" name="file" /></form>');
    $('#ocm-form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
    if ($('#ocm-form-upload input[name=\'file\']').val() != '') {
        clearInterval(timer);
        $.ajax({
            url: 'index.php?route=tool/upload',
            type: 'post',
            dataType: 'json',
            data: new FormData($('#ocm-form-upload')[0]),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(node).button('loading');
            },
            complete: function() {
                $(node).button('reset');
            },
            success: function(json) {
                $('.text-danger').remove();
                if (json['error']) {
                    $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                }
                if (json['success']) {
                    alert(json['success']);
                    $(node).parent().find('input').val(json['code']);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
               alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
  }, 500);
});
//--></script> 
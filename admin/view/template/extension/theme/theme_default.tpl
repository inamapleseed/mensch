
<?= $header; ?><?= $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-theme-default" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?= $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-theme-default" class="form-horizontal">
          <fieldset>
            <legend><?= $text_general; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-directory"><span data-toggle="tooltip" title="<?= $help_directory; ?>"><?= $entry_directory; ?></span></label>
              <div class="col-sm-10">
                <select name="theme_default_directory" id="input-directory" class="form-control">
                  <?php foreach ($directories as $directory) { ?>
                  <?php if ($directory == $theme_default_directory) { ?>
                  <option value="<?= $directory; ?>" selected="selected"><?= $directory; ?></option>
                  <?php } else { ?>
                  <option value="<?= $directory; ?>"><?= $directory; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-header"><?= $text_header; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_header" id="input-header" class="form-control">
                  <?php foreach ($menu_choices as $choice) { ?>
                  <?php if ($choice['menu_id'] == $theme_default_header) { ?>
                  <option value="<?= $choice['menu_id']; ?>" selected="selected"><?= $choice['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?= $choice['menu_id']; ?>"><?= $choice['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-footer"><?= $text_footer; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_footer" id="input-footer" class="form-control">
                  <?php foreach ($menu_choices as $choice) { ?>
                  <?php if ($choice['menu_id'] == $theme_default_footer) { ?>
                  <option value="<?= $choice['menu_id']; ?>" selected="selected"><?= $choice['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?= $choice['menu_id']; ?>"><?= $choice['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-status"><?= $entry_status; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_status" id="input-status" class="form-control">
                  <?php if ($theme_default_status) { ?>
                  <option value="1" selected="selected"><?= $text_enabled; ?></option>
                  <option value="0"><?= $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?= $text_enabled; ?></option>
                  <option value="0" selected="selected"><?= $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Header</legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-mobile_menu_background_color1"><span data-toggle="tooltip" title="For Mobile menu main background part">Mobile menu background color 1</span></label>
              <div class="col-sm-10">
                <input name="theme_default_mobile_menu_background_color1" value="<?= $theme_default_mobile_menu_background_color1; ?>" placeholder="Color" id="input-mobile_menu_background_color1" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-mobile_menu_background_color2"><span data-toggle="tooltip" title="For Mobile menu item part">Mobile menu background color 2</span></label>
              <div class="col-sm-10">
                <input name="theme_default_mobile_menu_background_color2" value="<?= $theme_default_mobile_menu_background_color2; ?>" placeholder="Color" id="input-mobile_menu_background_color2" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-parent_menu_non_clickable"><span data-toggle="tooltip" title="On this setting to allow parent menu item non-clickable">Parent Menu Item Non-Clickable?</span></label>
              <div class="col-sm-10">
                <select name="theme_default_parent_menu_non_clickable" id="input-parent_menu_non_clickable" class="form-control">
                  <?php if($theme_default_parent_menu_non_clickable) { ?>
                    <option value="0"><?= $text_off; ?></option>
                    <option value="1" selected="selected"><?= $text_on; ?></option>
                  <?php } else { ?>
                    <option value="0" selected="selected"><?= $text_off; ?></option>
                    <option value="1"><?= $text_on; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Testimonials</legend>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-catalog-limit-testimonial"><span data-toggle="tooltip" title="Determines how many testimonials are shown per page"><?= $entry_testimonial_limit; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_testimonial_limit" value="<?= $theme_default_testimonial_limit; ?>" placeholder="<?= $entry_testimonial_limit; ?>" id="input-catalog-limit-testimonial" class="form-control" />
                <?php if ($error_testimonial_limit) { ?>
                <div class="text-danger"><?= $error_testimonial_limit; ?></div>
                <?php } ?>
              </div>
            </div>
          </fieldset>
          
          <fieldset class="<?= $hide; ?>">
            <legend><?= "Category"; ?></legend>
            <h5>Layout</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_layout_setting"><span data-toggle="tooltip" title="Category Color Level 1">Layout Setting</span></label>
              <div class="col-sm-10">
                <select name="theme_default_product_category_layout_setting" id="input-product_category_layout_setting" class="form-control">
                  <option value="1" <?php if($theme_default_product_category_layout_setting == 1) {echo "SELECTED"; } ?>><?= "Layout 1"; ?></option>
                  <option value="2" <?php if($theme_default_product_category_layout_setting == 2) {echo "SELECTED"; } ?>><?= "Layout 2"; ?></option>
                  <option value="3" <?php if($theme_default_product_category_layout_setting == 3) {echo "SELECTED"; } ?>><?= "Layout 3"; ?></option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_listing"><span data-toggle="tooltip" title="Category Color Level 1">Product Listing</span></label>
              <div class="col-sm-10">
                <select name="theme_default_product_category_listing" id="input-product_category_listing" class="form-control">
                  <option value="3" <?php if($theme_default_product_category_listing == 3) {echo "SELECTED"; } ?>><?= "3"; ?></option>
                  <option value="4" <?php if($theme_default_product_category_listing == 4) {echo "SELECTED"; } ?>><?= "4"; ?></option>
                  <option value="5" <?php if($theme_default_product_category_listing == 5) {echo "SELECTED"; } ?>><?= "5"; ?></option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_align">Product Box</label>
              <div class="col-sm-10">
                <select name="theme_default_product_align" id="input-product_align" class="form-control">
                  <option value="1" <?php if($theme_default_product_align == "1") {echo "SELECTED"; } ?>><?= "Layout 1"; ?></option>
                  <option value="2" <?php if($theme_default_product_align == "2") {echo "SELECTED"; } ?>><?= "Layout 2"; ?></option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-theme_default_product_box_hover">Product Box Hover Button</label>
              <div class="col-sm-10">
                <select name="theme_default_product_box_hover" id="input-theme_default_product_box_hover" class="form-control">
                  <option value="0" <?php if($theme_default_product_box_hover == 0) {echo "SELECTED"; } ?>><?= "No"; ?></option>
                  <option value="1" <?php if($theme_default_product_box_hover == 1) {echo "SELECTED"; } ?>><?= "Yes"; ?></option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-theme_default_product_box_brand">Product Box Brand</label>
              <div class="col-sm-10">
                <select name="theme_default_product_box_brand" id="input-theme_default_product_box_brand" class="form-control">
                  <option value="0" <?php if($theme_default_product_box_brand == 0) {echo "SELECTED"; } ?>><?= "Hide"; ?></option>
                  <option value="1" <?php if($theme_default_product_box_brand == 1) {echo "SELECTED"; } ?>><?= "Show"; ?></option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-theme_default_product_box_category">Product Box Category</label>
              <div class="col-sm-10">
                <select name="theme_default_product_box_category" id="input-theme_default_product_box_category" class="form-control">
                  <option value="0" <?php if($theme_default_product_box_category == 0) {echo "SELECTED"; } ?>><?= "Hide"; ?></option>
                  <option value="1" <?php if($theme_default_product_box_category == 1) {echo "SELECTED"; } ?>><?= "Show"; ?></option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-theme_default_product_box_background">Product Box Background</label>
              <div class="col-sm-10">
                <input name="theme_default_product_box_background" value="<?= $theme_default_product_box_background; ?>" placeholder="Color" id="input-theme_default_product_box_background" class="form-control jscolor {required:false}" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_box_padding">Product Box Padding</label>
              <div class="col-sm-10">
                <input name="theme_default_product_box_padding" type="text" value="<?= $theme_default_product_box_padding; ?>" placeholder="eg:1px" id="input-theme_default_product_box_padding" class="form-control" />
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_box_border">Product Box Border</label>
              <div class="col-sm-10">
                <input name="theme_default_product_box_border" type="text" value="<?= $theme_default_product_box_border; ?>" placeholder="eg:1px" id="input-theme_default_product_box_border" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_sticker_position"><span data-toggle="tooltip" title="Category Color Level 1">Sticker Position</span></label>
              <div class="col-sm-10">
                <select name="theme_default_product_sticker_position" id="input-theme_default_product_sticker_position" class="form-control">
                  <option value="1" <?php if($theme_default_product_sticker_position == 1) {echo "SELECTED"; } ?>><?= "Left"; ?></option>
                  <option value="2" <?php if($theme_default_product_sticker_position == 2) {echo "SELECTED"; } ?>><?= "Right"; ?></option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_sticker_radius">Sticker Radius</label>
              <div class="col-sm-10">
                <input name="theme_default_product_sticker_radius" type="text" value="<?= $theme_default_product_sticker_radius; ?>" placeholder="eg:1px" id="input-theme_default_product_sticker_radius" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_sticker_padding">Sticker Padding</label>
              <div class="col-sm-10">
                <input name="theme_default_product_sticker_padding" type="text" value="<?= $theme_default_product_sticker_padding; ?>" placeholder="eg:1px" id="input-theme_default_product_sticker_padding" class="form-control" />
              </div>
            </div>




            <h5>Level 1</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one"><span data-toggle="tooltip" title="Category Color Level 1">Category Color</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one" value="<?= $theme_default_product_category_level_one; ?>" placeholder="Color" id="input-product_category_level_one" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one_hover"><span data-toggle="tooltip" title="Category Color Level 1 Hover">Category Color Hover</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one_hover" value="<?= $theme_default_product_category_level_one_hover; ?>" placeholder="Color" id="input-product_category_level_one_hover" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_text_level_one"><span data-toggle="tooltip" title="Text Color Level 1">Text Color</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_text_level_one" value="<?= $theme_default_product_category_text_level_one; ?>" placeholder="Color" id="input-product_category_text_level_one" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_text_level_one_hover"><span data-toggle="tooltip" title="Text Color Level 1 Hover">Text Color Hover</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_text_level_one_hover" value="<?= $theme_default_product_category_text_level_one_hover; ?>" placeholder="Color" id="input-product_category_text_level_one_hover" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one_padding">Padding</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one_padding" type="text" value="<?= $theme_default_product_category_level_one_padding; ?>" placeholder="eg:1px" id="input-product_category_level_one_padding" class="form-control" />
              </div>
            </div>

            <h5>Level 2</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_two"><span data-toggle="tooltip" title="Category Color Level 2">Category Color Level 2</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_two" value="<?= $theme_default_product_category_level_two; ?>" placeholder="Color" id="input-product_category_level_one" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_two_hover"><span data-toggle="tooltip" title="Category Color Level 2 Hover">Category Color Hover</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_two_hover" value="<?= $theme_default_product_category_level_two_hover; ?>" placeholder="Color" id="input-product_category_level_two_hover" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_text_level_two"><span data-toggle="tooltip" title="Text Color Level 2">Text Color</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_text_level_two" value="<?= $theme_default_product_category_text_level_two; ?>" placeholder="Color" id="input-product_category_text_level_two" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_text_level_two_hover"><span data-toggle="tooltip" title="Text Color Level 2 Hover">Text Color Hover</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_text_level_two_hover" value="<?= $theme_default_product_category_text_level_two_hover; ?>" placeholder="Color" id="input-product_category_text_level_two_hover" class="form-control jscolor {required:false}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_two_padding">Padding</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_two_padding" type="text" value="<?= $theme_default_product_category_level_two_padding; ?>" placeholder="eg:1px" id="input-product_category_level_two_padding" class="form-control" />
              </div>
            </div>

          <h5>General</h5>
          
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_three_padding">Padding Level 3</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_three_padding" type="text" value="<?= $theme_default_product_category_level_three_padding; ?>" placeholder="eg:1px" id="input-product_category_level_three_padding" class="form-control" />
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_four_padding">Padding Level 4</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_four_padding" type="text" value="<?= $theme_default_product_category_level_four_padding; ?>" placeholder="eg:1px" id="input-product_category_level_four_padding" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one_margin">Margin</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one_margin" type="text" value="<?= $theme_default_product_category_level_one_margin; ?>" placeholder="eg:1px" id="input-product_category_level_one_margin" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one_radius">Border Radius</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one_radius" type="text" value="<?= $theme_default_product_category_level_one_radius; ?>" placeholder="eg:10px" id="input-product_category_level_one_radius" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_level_one_border">Border</label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_level_one_border" type="text" value="<?= $theme_default_product_category_level_one_border; ?>" placeholder="eg:1px solid red" id="input-product_category_level_one_border" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_category_price_color"><span data-toggle="tooltip" title="Price Filter Color">Price Filter Color</span></label>
              <div class="col-sm-10">
                <input name="theme_default_product_category_price_color" value="<?= $theme_default_product_category_price_color; ?>" placeholder="Color" id="input-product_category_price_color" class="form-control jscolor {required:false}" />
              </div>
            </div>

          </fieldset>

          <fieldset class="<?= $hide; ?>">
            <legend><?= $text_product; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_inner_layout"><?= "Inner Layout"; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_product_inner_layout" id="input-theme_default_product_inner_layout" class="form-control">
                  <option value="1" <?= $theme_default_product_inner_layout == 1 ? 'selected="selected"' : '' ?>>Layout 1</option>
                  <option value="2" <?= $theme_default_product_inner_layout == 2 ? 'selected="selected"' : '' ?>>Layout 2</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product_option_image_mode"><?= $entry_product_option_image_mode; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_product_option_image_mode" id="input-product_option_image_mode" class="form-control">
                  <?php foreach($product_option_image_mode_selection as $k => $v) { ?>
                  <option value="<?= $k ?>" <?= $theme_default_product_option_image_mode == $k ? 'selected="selected"' : '' ?>><?= $v; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-vertical-thumbnails"><span data-toggle="tooltip" title="<?= $help_vertical_thumbnails; ?>"><?= $entry_vertical_thumbnails; ?></span></label>
              <div class="col-sm-10">
                <select name="theme_default_vertical_thumbnails" id="input-vertical-thumbnails" class="form-control">
                  <?php if($theme_default_vertical_thumbnails) { ?>
                  <option value="0"><?= $text_off; ?></option>
                  <option value="1" selected="selected"><?= $text_on; ?></option>
                  <?php } else { ?>
                  <option value="0" selected="selected"><?= $text_off; ?></option>
                  <option value="1"><?= $text_on; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product-zoom"><?= $entry_product_zoom; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_product_zoom" id="input-product-zoom" class="form-control">
                  <?php if($theme_default_product_zoom) { ?>
                    <option value="0"><?= $text_off; ?></option>
                    <option value="1" selected="selected"><?= $text_on; ?></option>
                  <?php } else { ?>
                    <option value="0" selected="selected"><?= $text_off; ?></option>
                    <option value="1"><?= $text_on; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-catalog-limit-search"><span data-toggle="tooltip" title="Determines how many catalog items are shown per page (search)"><?= $entry_product_limit; ?> (Search)</span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_search_limit" value="<?= $theme_default_product_search_limit; ?>" placeholder="<?= $entry_product_limit; ?> (Search)" id="input-catalog-limit" class="form-control" />
                <?php if ($error_product_search_limit) { ?>
                <div class="text-danger"><?= $error_product_search_limit; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-catalog-limit-special"><span data-toggle="tooltip" title="Determines how many catalog items are shown per page (Promotional / Special)"><?= $entry_product_limit; ?> (Promotion/Special)</span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_special_limit" value="<?= $theme_default_product_special_limit; ?>" placeholder="<?= $entry_product_limit; ?> (Promotion/Special)" id="input-catalog-limit" class="form-control" />
                <?php if ($error_product_search_limit) { ?>
                <div class="text-danger"><?= $error_product_search_limit; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-catalog-limit"><span data-toggle="tooltip" title="<?= $help_product_limit; ?>"><?= $entry_product_limit; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_limit" value="<?= $theme_default_product_limit; ?>" placeholder="<?= $entry_product_limit; ?>" id="input-catalog-limit" class="form-control" />
                <?php if ($error_product_limit) { ?>
                <div class="text-danger"><?= $error_product_limit; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-description-limit"><span data-toggle="tooltip" title="<?= $help_product_description_length; ?>"><?= $entry_product_description_length; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_description_length" value="<?= $theme_default_product_description_length; ?>" placeholder="<?= $entry_product_description_length; ?>" id="input-description-limit" class="form-control" />
                <?php if ($error_product_description_length) { ?>
                <div class="text-danger"><?= $error_product_description_length; ?></div>
                <?php } ?>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><?= $text_image; ?></legend>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-category-width"><?= $entry_image_category; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_category_width" value="<?= $theme_default_image_category_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-category-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_category_height" value="<?= $theme_default_image_category_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_category) { ?>
                <div class="text-danger"><?= $error_image_category; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-thumb-width"><?= $entry_image_thumb; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_thumb_width" value="<?= $theme_default_image_thumb_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-thumb-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_thumb_height" value="<?= $theme_default_image_thumb_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_thumb) { ?>
                <div class="text-danger"><?= $error_image_thumb; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-popup-width"><?= $entry_image_popup; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_popup_width" value="<?= $theme_default_image_popup_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-popup-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_popup_height" value="<?= $theme_default_image_popup_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_popup) { ?>
                <div class="text-danger"><?= $error_image_popup; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-product-width"><?= $entry_image_product; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_product_width" value="<?= $theme_default_image_product_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-product-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_product_height" value="<?= $theme_default_image_product_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_product) { ?>
                <div class="text-danger"><?= $error_image_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-additional-width"><?= $entry_image_additional; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_additional_width" value="<?= $theme_default_image_additional_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-additional-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_additional_height" value="<?= $theme_default_image_additional_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_additional) { ?>
                <div class="text-danger"><?= $error_image_additional; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-related"><?= $entry_image_related; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_related_width" value="<?= $theme_default_image_related_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-related" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_related_height" value="<?= $theme_default_image_related_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_related) { ?>
                <div class="text-danger"><?= $error_image_related; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-compare"><?= $entry_image_compare; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_compare_width" value="<?= $theme_default_image_compare_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-compare" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_compare_height" value="<?= $theme_default_image_compare_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_compare) { ?>
                <div class="text-danger"><?= $error_image_compare; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-wishlist"><?= $entry_image_wishlist; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_wishlist_width" value="<?= $theme_default_image_wishlist_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-wishlist" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_wishlist_height" value="<?= $theme_default_image_wishlist_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_wishlist) { ?>
                <div class="text-danger"><?= $error_image_wishlist; ?></div>
                <?php } ?>
              </div>
            </div>

            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-cart"><?= $entry_image_cart; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_cart_width" value="<?= $theme_default_image_cart_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-cart" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_cart_height" value="<?= $theme_default_image_cart_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_cart) { ?>
                <div class="text-danger"><?= $error_image_cart; ?></div>
                <?php } ?>
              </div>
            </div>


            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-cart">Reorder Image Size</label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_reorder_width" value="<?= $theme_default_image_reorder_width; ?>" placeholder="Reorder Image Width" id="input-image-reorder" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_reorder_height" value="<?= $theme_default_image_reorder_height; ?>" placeholder="Reorder Image Height" class="form-control" />
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-location"><?= $entry_image_location; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_location_width" value="<?= $theme_default_image_location_width; ?>" placeholder="<?= $entry_width; ?>" id="input-image-location" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_location_height" value="<?= $theme_default_image_location_height; ?>" placeholder="<?= $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_location) { ?>
                <div class="text-danger"><?= $error_image_location; ?></div>
                <?php } ?>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $footer; ?>
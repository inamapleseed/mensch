<?php echo $header; ?><?php echo $column_left; ?>
<?php $form_option_row = 0; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<?php if($form_id) { ?>
        <button type="submit" form="form-form" data-toggle="tooltip" title="<?php echo $button_stay; ?>" class="btn btn-primary" onclick="$('#form-form').attr('action','<?php echo $staysave; ?>');$('#form-form').submit(); " ><i class="fa fa-save"></i> <?php echo $button_stay; ?></button>
        <?php } ?>
		
        <button type="submit" form="form-form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-form" class="form-horizontal">
			<ul class="nav nav-tabs first">
				<li class="active"><a href="#tab-language" data-toggle="tab"><i class="fa fa-language" aria-hidden="true"></i> <?php echo $tab_language; ?></a></li>
				<li><a href="#tab-setting" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $tab_setting; ?></a></li>
				<li><a href="#tab-formfield" data-toggle="tab"><i class="fa fa-square" aria-hidden="true"></i> <?php echo $tab_formfield; ?></a></li>
				<li><a href="#tab-link" data-toggle="tab"><i class="fa fa-link" aria-hidden="true"></i> <?php echo $tab_link; ?></a></li>
				<li><a href="#tab-notify" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $tab_notify; ?></a></li>
				<li><a href="#tab-success" data-toggle="tab"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $tab_success; ?></a></li>
				<li><a href="#tab-custome" data-toggle="tab"><i class="fa fa-pencil-square" aria-hidden="true"></i> <?php echo $tab_custome; ?></a></li>
				
			</ul>
			<div class="tab-content">
            	<div class="tab-pane active" id="tab-language">
				<ul class="nav nav-tabs language">
					<?php foreach ($languages as $language) { ?>
					<li><a href=".language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
						<div class="tab-pane language<?php echo $language['language_id']; ?>">	
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
									<input type=""text name="form_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control"/>
									<?php if (isset($error_title[$language['language_id']])) { ?>
                      					<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      				<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-meta_title<?php echo $language['language_id']; ?>"><?php echo $entry_metatitle;?></label>
								<div class="col-sm-10">
									<input type="text" name="form_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_metatitle; ?>" value="" id="input-description<?php echo $language['language_id']; ?>" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-meta_keyword<?php echo $language['language_id']; ?>"><?php echo $entry_metakeyword;?></label>
								<div class="col-sm-10">
									<input type="text" name="form_description[<?php echo $language['language_id']; ?>][meta_keyword]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['meta_keyword'] : ''; ?>" value="" placeholder="<?php echo $entry_metakeyword; ?>" id="input-meta_keyword<?php echo $language['language_id']; ?>" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-meta_description<?php echo $language['language_id']; ?>"><?php echo $entry_metadesc;?></label>
								<div class="col-sm-10">
									<textarea name="form_description[<?php echo $language['language_id']; ?>][meta_description]" placeholder="<?php echo $entry_metadesc; ?>" value="" id="input-meta_description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-top_description<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_topdesc; ?>"><?php echo $entry_topdesc;?></span></label>
								<div class="col-sm-10">
									<textarea name="form_description[<?php echo $language['language_id']; ?>][top_description]" placeholder="<?php echo $entry_topdesc; ?>" value="" id="input-top_description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['top_description'] : ''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-bottom_description<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_botomdesc; ?>"><?php echo $entry_description;?></span></label>
								<div class="col-sm-10">
									<textarea name="form_description[<?php echo $language['language_id']; ?>][bottom_description]" placeholder="<?php echo $entry_description; ?>" value="" id="input-bottom_description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['bottom_description'] : ''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-button_name"><span data-toggle="tooltip" title="<?php echo $help_button; ?>"><?php echo $entry_buttonname;?></span></label>
								<div class="col-sm-10">
								<input type="text" name="form_description[<?php echo $language['language_id']; ?>][button_name]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['button_name'] : ''; ?>" placeholder="<?php echo $entry_buttonname; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control"/>
									
								</div>	
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-resetbuttonname"><span data-toggle="tooltip" title="<?php echo $help_resetbuttonname; ?>"><?php echo $entry_resetbuttonname;?></span></label>
								<div class="col-sm-10">
								<input type="text" name="form_description[<?php echo $language['language_id']; ?>][resetbuttonname]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['resetbuttonname'] : ''; ?>" placeholder="<?php echo $entry_resetbuttonname; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control"/>
									
								</div>	
							</div>
							<!--update code-->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-popuplinkname"><span data-toggle="tooltip" title="<?php echo $help_popuplinkname; ?>"><?php echo $entry_popuplinkname;?></span></label>
								<div class="col-sm-10">
								<input type="text" name="form_description[<?php echo $language['language_id']; ?>][popuplinkname]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['popuplinkname'] : ''; ?>" placeholder="<?php echo $entry_popuplinkname; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control"/>
									
								</div>	
							</div>
							<!--update code-->
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane" id="tab-setting">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-header"><span data-toggle="tooltip" title="<?php echo $help_header; ?>"><?php echo $entry_header;?></span></label>
						<label class="radio-inline">
							<?php if ($headerlink==1) { ?>
							<input type="checkbox" name="headerlink" value="1" checked="checked"/>
							<?php } else { ?>
							<input type="checkbox" name="headerlink" value="1"/>
							<?php } ?>
						 </label>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-footer"><span data-toggle="tooltip" title="<?php echo $help_footer; ?>"><?php echo $entry_footer;?></span></label>
						<label class="radio-inline">
							<?php if ($footerlink==1) { ?>
							<input type="checkbox" name="footerlink" value="1" checked="checked"/>
							<?php } else { ?>
							<input type="checkbox" name="footerlink" value="1"/>
							<?php } ?>
						 </label>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-footer"><span data-toggle="tooltip" title="<?php echo $help_productsize; ?>"><?php echo $entry_productsize;?></span></label>
						<div class="col-sm-10">
						 <div class="row">
						  <div class="col-sm-6">
							<input type="text" name="productwidth" value="<?php echo $productwidth; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-location" class="form-control" />
						  </div>
						  <div class="col-sm-6">
							<input type="text" name="productheight" value="<?php echo $productheight; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
						  </div>
						</div>
						</div>	
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-meta_keyword"><span data-toggle="tooltip" title="<?php echo $help_resetbutton; ?>"><?php echo $entry_resetbutton;?></span></label>
						<div class="col-sm-10">
							<select name="resetbutton" id="input-resetbutton" class="form-control">
								<?php if ($resetbutton) { ?>
								<option value="1" selected="selected"><?php echo $text_yes; ?></option>
								<option value="0"><?php echo $text_no; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_yes; ?></option>
								<option value="0" selected="selected"><?php echo $text_no; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-meta_keyword"><span data-toggle="tooltip" title="<?php echo $help_captcha; ?>"><?php echo $entry_captcha;?></span></label>
						<div class="col-sm-10">
							<select name="captcha" id="input-captcha" class="form-control">
								<?php if ($captcha) { ?>
								<option value="1" selected="selected"><?php echo $text_yes; ?></option>
								<option value="0"><?php echo $text_no; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_yes; ?></option>
								<option value="0" selected="selected"><?php echo $text_no; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-control">
								<?php if ($status) { ?>
								<option value="1" selected="selected"><?php echo $text_enable; ?></option>
								<option value="0"><?php echo $text_disable; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enable; ?></option>
								<option value="0" selected="selected"><?php echo $text_disable; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-meta_keyword"><?php echo $entry_seourl;?></label>
						<div class="col-sm-10">
							<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_seourl;?>" class="form-control"/>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-link">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-display_type"><?php echo $entry_display; ?></label>
						<div class="col-sm-10">
							<select name="display_type" id="input-display_type" class="form-control">
								<option value=""><?php echo $text_select?></option>
								<?php foreach ($displaytypes as $result){ ?>
								<?php if ($display_type == $result['display_type']){ ?>
									<option value="<?php echo $result['display_type']; ?>" selected="selected"><?php echo $result['value']; ?></option> 
								<?php } else { ?>
									<option value="<?php echo $result['display_type']; ?>"><?php echo $result['value']; ?></option> 
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-package-title"><?php echo $entry_custgroup;?></label>
						<div class="col-sm-10">
							<div class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach ($customergroups as $customergroup) { ?>
								<div class="checkbox">
									<label>
									<?php $check=''; 
									if(in_array($customergroup['customer_group_id'],$form_customer))
									{
										$check="checked=checked";
									}?>
									<input <?php echo $check?> type="checkbox" name="form_customer[]" checked="checked" value="<?php echo $customergroup['customer_group_id']; ?>" />
									<?php echo $customergroup['name']; ?>

									</label>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
						<div class="col-sm-10">
						  <div class="well well-sm" style="height: 150px; overflow: auto;">
							<div class="checkbox">
							  <label>
								<?php if (in_array(0, $form_store)) { ?>
								<input type="checkbox" name="form_store[]" value="0" checked="checked" />
								<?php echo $text_default; ?>
								<?php } else { ?>
								<input type="checkbox" name="form_store[]" value="0" />
								<?php echo $text_default; ?>
								<?php } ?>
							  </label>
							</div>
							<?php foreach ($stores as $store) { ?>
							<div class="checkbox">
							  <label>
								<?php if (in_array($store['store_id'], $form_store)) { ?>
								<input type="checkbox" name="form_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
								<?php echo $store['name']; ?>
								<?php } else { ?>
								<input type="checkbox" name="form_store[]" value="<?php echo $store['store_id']; ?>" />
								<?php echo $store['name']; ?>
								<?php } ?>
							  </label>
							</div>
							<?php } ?>
						  </div>
						</div>
					  </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-assign-product"><?php echo $entry_assignproduct; ?></label>
						<div class="col-sm-10">
							<select name="assign_product" id="input-assign-product" class="form-control">
								<option value=""><?php echo $text_select?></option>
								<?php foreach ($assigns as $result){ ?>
								<?php if ($assign_product == $result['value']){ ?>
									<option value="<?php echo $result['value']; ?>" selected="selected"><?php echo $result['assign_product']; ?></option> 
								<?php } else { ?>
									<option value="<?php echo $result['value']; ?>"><?php echo $result['assign_product']; ?></option> 
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div id="3" class="form-group colors" style="display:none;">
						<label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_product; ?></label>
						<div class="col-sm-10">
							<input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-parent" class="form-control" />
								<div id="form_product" class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach ($products as $product) { ?>
			                    <div id="product-related<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
			                      <input type="hidden" name="product[]" value="<?php echo $product['product_id']; ?>" />
			                    </div>
			                    <?php } ?>
							 </div>
						</div>
							
					</div>
					
				<div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                  <div id="form_category" class="well well-sm" style="height: 150px; overflow: auto;">
				   <?php if(isset($categories)) {
                    foreach ($categories as $category) { ?>
                    <div id="form_category<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                      <input type="hidden" name="category[]" value="<?php echo $category['category_id']; ?>" />
                    </div>
                    <?php } 
				   } ?>
                  </div>
                </div>
              </div>
			  
				<div class="form-group">
                <label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="manufacturer" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
                  <div id="form_manufacturer" class="well well-sm" style="height: 150px; overflow: auto;">
				   <?php if(isset($manufacturers)) {
                    foreach ($manufacturers as $manufacturer) { ?>
                    <div id="form_manufacturer<?php echo $manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $manufacturer['name']; ?>
                      <input type="hidden" name="manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    </div>
                    <?php } 
				   } ?>
                  </div>
                </div>
              </div>

<!--// 09 03 2019 //-->
              <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-checkout"><?php echo $entry_information; ?></label>
                  <div class="col-sm-10">
                    <?php foreach ($informations as $result) { ?>
	                    <div class="checkbox">
	                      <label>
	                        <?php if (in_array($result['information_id'],$information )) { ?>
	                        <input type="checkbox" name="information[]" value="<?php echo $result['information_id']; ?>" checked="checked" /><?php echo $result['title']; ?>
	                        <?php } else { ?>
	                        <input type="checkbox" name="information[]" value="<?php echo $result['information_id']; ?>" /><?php echo $result['title']; ?>
	                        <?php } ?>
	                      </label>
	                    </div>
	                <?php } ?>


                  </div>
                </div>
<!--// 09 03 2019 //-->

					
				</div>
				<div class="tab-pane" id="tab-notify">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-customeremail" data-toggle="tab"><?php echo $text_custemail; ?></a></li>
						<li><a href="#tab-adminemail" data-toggle="tab"><?php echo $text_adminemail; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active language" id="tab-customeremail">
							<ul class="nav nav-tabs customer_language">
								<?php foreach ($languages as $language) { ?>
								<li><a href=".customer_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane customer_language<?php echo $language['language_id']; ?>">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-customer_notification"><?php echo $entry_notification;?></label>
										<div class="col-sm-10">
											<select name="customer_notification" id="input-customer_notification" class="form-control">
												<?php if ($customer_notification) { ?>
												<option value="1" selected="selected"><?php echo $text_yes; ?></option>
												<option value="0"><?php echo $text_no; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_yes; ?></option>
												<option value="0" selected="selected"><?php echo $text_no; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-customer_subject<?php echo $language['language_id']; ?>"><?php echo $entry_subject;?></label>
										<div class="col-sm-10">
											<input type="text" name="form_notification[<?php echo $language['language_id']; ?>][customer_subject]" placeholder="<?php echo $entry_subject; ?>" value="<?php echo isset($form_notification[$language['language_id']]) ? $form_notification[$language['language_id']]['customer_subject'] : ''; ?>" id="input-customer_subject<?php echo $language['language_id']; ?>" class="form-control"/>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-customer_message<?php echo $language['language_id']; ?>"><?php echo $entry_message;?></label>
										<div class="col-sm-10">
											<textarea name="form_notification[<?php echo $language['language_id']; ?>][customer_message]" placeholder="<?php echo $entry_message; ?>" value="" id="input-customer_message<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($form_notification[$language['language_id']]) ? $form_notification[$language['language_id']]['customer_message'] : ''; ?></textarea>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab-adminemail">
							<ul class="nav nav-tabs admin_language">
								<?php foreach ($languages as $language) { ?>
								<li><a href=".admin_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane admin_language<?php echo $language['language_id']; ?>">	
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-meta_keyword"><?php echo $entry_notification;?></label>
										<div class="col-sm-10">
											<select name="admin_notification" id="input-admin_notification" class="form-control">
												<?php if ($admin_notification) { ?>
												<option value="1" selected="selected"><?php echo $text_yes; ?></option>
												<option value="0"><?php echo $text_no; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_yes; ?></option>
												<option value="0" selected="selected"><?php echo $text_no; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-admin_subject<?php echo $language['language_id']; ?>"><?php echo $entry_subject;?></label>
										<div class="col-sm-10">
											<input type="text" name="form_notification[<?php echo $language['language_id']; ?>][admin_subject]" placeholder="<?php echo $entry_subject; ?>" value="<?php echo isset($form_notification[$language['language_id']]) ? $form_notification[$language['language_id']]['admin_subject'] : ''; ?>" id="input-admin_subject<?php echo $language['language_id']; ?>" class="form-control"/>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-admin_message<?php echo $language['language_id']; ?>"><?php echo $entry_message;?></label>
										<div class="col-sm-10">
											<textarea name="form_notification[<?php echo $language['language_id']; ?>][admin_message]" placeholder="<?php echo $entry_message; ?>" value="" id="input-admin_message<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($form_notification[$language['language_id']]) ? $form_notification[$language['language_id']]['admin_message'] : ''; ?></textarea>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<div class="form-group">
			<label class="col-sm-2 control-label" for="input-shortcut"><?php echo $entry_shortcut; ?></label>
			<div class="col-sm-10" style="padding-top: 9px;font-size:14px;">
               <?php echo $text_shortcut; ?>
              </div>
			</div>
				</div>
				<div class="tab-pane" id="tab-success">
				<ul class="nav nav-tabs" id="language">
					<?php foreach ($languages as $language) { ?>
					<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					 <?php foreach ($languages as $language) { ?>
					<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-success_meta_title<?php echo $language['language_id']; ?>"><?php echo $entry_metatitle;?></label>
							<div class="col-sm-10">
								<input type="text" name="succes_form[<?php echo $language['language_id']; ?>][success_meta_title]" placeholder="<?php echo $entry_metatitle; ?>" value="<?php echo isset($succes_form[$language['language_id']]) ? $succes_form[$language['language_id']]['success_meta_title'] : ''; ?>" id="input-success_meta_title<?php echo $language['language_id']; ?>" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
							<div class="col-sm-10">
								<input name="succes_form[<?php echo $language['language_id']; ?>][success_title]" value="<?php echo isset($succes_form[$language['language_id']]) ? $succes_form[$language['language_id']]['success_title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-success_title<?php echo $language['language_id']; ?>" class="form-control"/>
								<?php if (isset($error_title[$language['language_id']])) { ?>
									<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
								<?php } ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-success_description<?php echo $language['language_id']; ?>"><?php echo $entry_descriptionss;?></label>
							<div class="col-sm-10">
								<textarea name="succes_form[<?php echo $language['language_id']; ?>][success_description]" placeholder="<?php echo $entry_descriptionss; ?>" value="" id="input-success_description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($succes_form[$language['language_id']]) ? $succes_form[$language['language_id']]['success_description'] : ''; ?></textarea>
							</div>
						</div>

					</div>
					<?php } ?>
				</div>
				</div>
				
				<div class="tab-pane" id="tab-custome">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-custome_style"><?php echo $entry_customestyle;?></label>
						<div class="col-sm-10">
							<textarea name="custome_style" rows="10" placeholder="<?php echo $entry_customestyle; ?>" id="input-custome_style" class="form-control"><?php echo $custome_style; ?></textarea>
						</div>
					</div>
				</div>
				
				<!-- Form Field Start -->
				
				<div class="tab-pane" id="tab-formfield">
	<div class="row">
		<div class="col-sm-2">
			<ul class="nav nav-pills nav-stacked" id="formfield">
				<?php $form_row = 0; ?>
					<?php foreach ($optionfieldss as $option_fields) { ?>
					<li><a href="#tab-formfield<?php echo $form_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle delete" rel="<?php echo $option_fields['field_id']; ?>" onclick="$('#formfield a:first').tab('show'); $('#formfield a[href=\'#tab-formfield<?php echo $form_row; ?>\']').parent().remove(); $('#tab-formfield<?php echo $form_row; ?>').remove();"></i> <?php if(!empty($option_fields['form_field_description'][1]['field_name'])) { ?><?php echo $option_fields['form_field_description'][1]['field_name']; ?>
					<?php } else { ?>
					<?php echo $tab_option.$form_row; 
					} ?>
					</a></li>
					<?php $form_row++; ?>
				<?php } ?>
					<li id="formfield-add"><a onclick="addFormfield();" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_address_add; ?></a></li>
			</ul>
		</div>
		<div class="col-sm-10">
            <div class="tab-content one">
				<?php $form_row = 0; ?>
					<?php if(isset($optionfieldss)) { ?>
						<?php foreach ($optionfieldss as $option_fields) { ?>
				<div class="tab-pane active" id="tab-formfield<?php echo $form_row; ?>">
					<ul class="nav nav-tabs fieldslanguage" id="forms_fields<?php echo $form_row; ?>">
						<?php foreach ($languages as $language) { ?>
							<li><a href=".fieldslanguage<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content">
					<input type="hidden" name="option_fields[<?php echo $form_row; ?>][field_id]" value="<?php echo $option_fields['field_id']?>">
					
						<?php foreach ($languages as $language) { ?>
							<div class="tab-pane fields fieldslanguage<?php echo $language['language_id']; ?>" id="forms_fields<?php echo $language['language_id']; ?>">
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-field_name<?php echo $form_row; ?>"><span data-toggle="tooltip" title="<?php echo $help_fieldname; ?>"><?php echo $entry_fieldname;?></span></label>
									<div class="col-sm-10">
									<input type="text" name="option_fields[<?php echo $form_row; ?>][form_fields][<?php echo $language['language_id']; ?>][field_name]" value="<?php echo isset($option_fields['form_field_description'][$language['language_id']]) ? $option_fields['form_field_description'][$language['language_id']]['field_name'] : ''; ?>" placeholder="<?php echo $entry_fieldname; ?>" id="input-field_name<?php echo $form_row; ?>" class="form-control" />
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-help_text<?php echo $form_row; ?>"><span data-toggle="tooltip" title="<?php echo $help_helptext; ?>"><?php echo $entry_helptext; ?></span></label>
									<div class="col-sm-10">
									<input type="text" name="option_fields[<?php echo $form_row; ?>][form_fields][<?php echo $language['language_id']; ?>][help_text]" value="<?php echo isset($option_fields['form_field_description'][$language['language_id']]) ? $option_fields['form_field_description'][$language['language_id']]['help_text'] : ''; ?>" placeholder="<?php echo $entry_helptext; ?>" id="input-help_text<?php echo $form_row; ?>" class="form-control" />
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-placeholder<?php echo $form_row; ?>"><span data-toggle="tooltip" title="<?php echo $help_placeholder; ?>"><?php echo $entry_placeholder; ?></span></label>
									<div class="col-sm-10">
									<input type="text" name="option_fields[<?php echo $form_row; ?>][form_fields][<?php echo $language['language_id']; ?>][placeholder]" value="<?php echo isset($option_fields['form_field_description'][$language['language_id']]) ? $option_fields['form_field_description'][$language['language_id']]['placeholder'] : ''; ?>" placeholder="<?php echo $entry_placeholder; ?>" id="input-placeholder<?php echo $form_row; ?>" class="form-control" />
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-error_message<?php echo $form_row; ?>"><span data-toggle="tooltip" title="<?php echo $help_error; ?>"><?php echo $entry_error; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="option_fields[<?php echo $form_row; ?>][form_fields][<?php echo $language['language_id']; ?>][error_message]" value="<?php echo isset($option_fields['form_field_description'][$language['language_id']]) ? $option_fields['form_field_description'][$language['language_id']]['error_message'] : ''; ?>" placeholder="<?php echo $entry_error; ?>" id="input-error_message<?php echo $form_row; ?>" class="form-control" />
									</div>	
								</div>
								</div>
								<?php } ?>
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-form_status"><?php echo $entry_status; ?></label>
									<div class="col-sm-10">
										<select name="option_fields[<?php echo $form_row; ?>][form_status]" id="input-form_status" class="form-control">
										<?php if ($option_fields['form_status']) { ?>
										<option value="1" selected="selected"><?php echo $text_enable; ?></option>
										<option value="0"><?php echo $text_disable; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enable; ?></option>
										<option value="0" selected="selected"><?php echo $text_disable; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
						
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-required"><?php echo $entry_required; ?></label>
									<div class="col-sm-10">
										<select name="option_fields[<?php echo $form_row; ?>][required]" id="input-required" class="form-control">
										<?php if ($option_fields['required']) { ?>
										<option value="1" selected="selected"><?php echo $text_yes; ?></option>
										<option value="0"><?php echo $text_no; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_yes; ?></option>
										<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="input-sortorder<?php echo $form_row; ?>"><span data-toggle="tooltip" title="<?php echo $help_error; ?>"><?php echo $entry_sortorder; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="option_fields[<?php echo $form_row; ?>][sort_order]" value="<?php echo $option_fields['sort_order']; ?>" placeholder="<?php echo $entry_sortorder; ?>" id="input-sortorder<?php echo $form_row; ?>" class="form-control" />
									</div>	
								</div>
								<div class="form-group">	
									<label class="control-label col-sm-2" for="input-type"><?php echo $entry_type; ?></label>			 
									<div class="col-sm-10">						
									<select name="option_fields[<?php echo $form_row; ?>][type]" id="input-type[<?php echo $form_row; ?>]" class="form-control typeoptions" rel="<?php echo $form_row; ?>">									 
									<optgroup label="<?php echo $text_choose; ?>">
									<?php if ($option_fields['type'] == 'select') { ?>		<option value="select" selected="selected"><?php echo $text_selects; ?></option>
									<?php } else { ?>							  
										<option value="select"><?php echo $text_selects; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'radio') { ?>		<option value="radio" selected="selected"><?php echo $text_radio; ?></option>	
									<?php } else { ?>							 
										<option value="radio"><?php echo $text_radio; ?></option>	
									<?php } ?>
									<?php if ($option_fields['type'] == 'checkbox') { ?>	  <option value="checkbox" selected="selected"><?php echo $text_checkbox; ?></option>
									<?php } else { ?>								
										<option value="checkbox"><?php echo $text_checkbox; ?></option>
									<?php } ?>			  
									</optgroup>										 
									<optgroup label="<?php echo $text_input; ?>">
									<?php if ($option_fields['type'] == 'text') { ?>	<option value="text" selected="selected"><?php echo $text_text; ?></option>
									<?php } else { ?>
									<option value="text"><?php echo $text_text; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'textarea') { ?>
										<option value="textarea" selected="selected"><?php echo $text_textarea; ?></option>
									<?php } else { ?>
										<option value="textarea"><?php echo $text_textarea;?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'number') { ?>
										<option value="number" selected="selected"><?php echo $text_number; ?></option>
									<?php } else { ?>
										<option value="number"><?php echo $text_number; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'telephone') { ?>
										<option value="telephone" selected="selected"><?php echo $text_telephone; ?></option>
									<?php } else { ?>
										<option value="telephone"><?php echo $text_telephone; ?></option>	
									<?php } ?>
									<?php if ($option_fields['type'] == 'email') { ?>
										<option value="email" selected="selected"><?php echo $text_email; ?></option>
									<?php } else { ?>
										<option value="email"><?php echo $text_email; ?></option>	
									<?php } ?>
									<?php if ($option_fields['type'] == 'emaile_exists') { ?>
									<option value="emaile_exists" selected="selected"><?php echo $text_emailexists; ?></option>
									<?php } else { ?>
									<option value="emaile_exists"><?php echo $text_emailexists; ?></option>	
									<?php } ?>
									<?php if ($option_fields['type'] == 'password') { ?>
									<option value="password" selected="selected"><?php echo $text_password; ?></option>
									<?php } else { ?>
									<option value="password"><?php echo $text_password; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'confirm') { ?>
									<option value="confirm" selected="selected"><?php echo $text_cpassword; ?></option>
									<?php } else { ?>
									<option value="confirm"><?php echo $text_cpassword; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'unique_word') { ?>
									<option value="unique_word" selected="selected"><?php echo $text_uniqueword; ?></option>
									<?php } else { ?>
									<option value="unique_word"><?php echo $text_uniqueword; ?></option>
									<?php } ?>
									</optgroup>				 
									<optgroup label="<?php echo $text_file; ?>">	
									<?php if ($option_fields['type'] == 'file') { ?>
									<option value="file" selected="selected"><?php echo $text_file; ?></option>	
									<?php } else { ?>
									<option value="file"><?php echo $text_file; ?></option>	
									<?php } ?>
									</optgroup>
									<optgroup label="<?php echo $text_date; ?>">
									<?php if ($option_fields['type'] == 'date') { ?>
									<option value="date" selected="selected"><?php echo $text_date; ?></option>
									<?php } else { ?>
									<option value="date"><?php echo $text_date; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'time') { ?>
									<option value="time" selected="selected"><?php echo $text_time; ?></option>
									<?php } else { ?>
									<option value="time"><?php echo $text_time; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'datetime') { ?>
									<option value="datetime" selected="selected"><?php echo $text_datetime; ?></option>
									<?php } else { ?>
									<option value="datetime"><?php echo $text_datetime; ?></option>
									<?php } ?>
									</optgroup>
									<optgroup label="<?php echo $text_localisation; ?>">
									<?php if ($option_fields['type'] == 'country') { ?>
									<option value="country" selected="selected"><?php echo $text_country; ?></option>
									<?php } else { ?>
									<option value="country"><?php echo $text_country; ?></option>
									<?php } ?>
									<?php if ($option_fields['type'] == 'zone') { ?>
									<option value="zone" selected="selected"><?php echo $text_zone; ?></option>
									<?php } else { ?>
									<option value="zone"><?php echo $text_zone; ?></option>
									<?php } ?>
									</optgroup>			 
									</select>									 
								</div>										 
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="table-responsive" id="form_option<?php echo $form_row; ?>" 
									<?php if(empty($option_fields['form_field_options'])) { ?>
									style="display:none"
									<?php } ?>>
										<table id="tab-formfield<?php echo $form_row; ?>" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
											<td class="text-left"><?php echo $entry_option_value; ?></td>
											<td class="text-left hide"><?php echo $entry_image; ?></td>
											<td class="text-right"><?php echo $entry_sort_order; ?></td>
											<td></td>
											</tr>
										</thead>
										<tbody>
										
										
											<?php if(!empty($option_fields['form_field_options'])) {
												foreach($option_fields['form_field_options'] as $option_type) {  ?>
												<tr id="form_option-row<?php echo $form_option_row?>">	
													<td class="text-left"><input type="hidden" name="option_fields[<?php echo $form_row?>][option_type][<?php echo $form_option_row?>][form_id]" value="" />
													<?php foreach ($languages as $language) { ?>
													<div class="input-group">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="option_fields[<?php echo $form_row?>][option_type][<?php echo $form_option_row?>][option_value_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo $option_type['name'][$language['language_id']]?>" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />
													</div>
													<?php } ?>
													</td>
													<td class="text-left hide"><a href="" id="thumb-image<?php echo $form_option_row?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo  $option_type['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="option_fields[<?php echo $form_row?>][option_type][<?php echo $form_option_row?>][image]" value="<?php echo $option_type['image']?>" id="input-image<?php echo $form_option_row?>" /></td>
													<td class="text-right"><input type="text" name="option_fields[<?php echo $form_row?>][option_type][<?php echo $form_option_row?>][sort_order]"  value="<?php echo $option_type['sort_order']?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
													<td class="text-left"><button type="button" onclick="$('#form_option-row<?php echo $form_option_row?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
												</tr>
											<?php $form_option_row++; } } ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td class="text-left"><button type="button" onclick="addFormOption('<?php echo $form_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
												</tr>
											</tfoot>
										</table>
									</div>	
								
							</div>			
							</div>
						
					</div>
				</div>
				<?php $form_row++; ?>
				<?php } ?>	
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<!-- Form Field End -->
				
			</div>		
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
	
	
<script type="text/javascript"><!--
var form_option_row = <?php echo $form_option_row; ?>;
var form_row = <?php echo $form_row; ?>;

function addFormfield() {
	html  = ' <div class="tab-pane active" id="tab-formfield' + form_row + '">';
	html += ' <ul class="nav nav-tabs fieldslanguage fieldslanguaget' + form_row + '" id="forms_fields' + form_row + '">';
	<?php foreach ($languages as $language) { ?>
	html += ' <li><a href="#forms_fields_' + form_row + '_<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>';
	<?php } ?>
	html += ' </ul>';
	html += '<div class="tab-content">';
	<?php foreach ($languages as $language) { ?>
	
	html += '<div class="tab-pane fields fieldslanguage<?php echo $language['language_id']; ?>" id="forms_fields_' + form_row + '_<?php echo $language['language_id']; ?>">';
	html += '  <input type="hidden" name="option_fields[' + form_row + '][form_id]" value="" />';
	html += ' <div class="form-group">';
	html += '    <label class="control-label col-sm-2" for="input-field_name<?php echo $language['language_id']; ?>' + form_row + '"><span data-toggle="tooltip" title="<?php echo $help_fieldname; ?>"><?php echo $entry_fieldname;?></span></label><div class="col-sm-10">';										 
	html += '    <input type="text" name="option_fields[' + form_row + '][form_fields][<?php echo $language['language_id']; ?>][field_name]" value="" id="input-fieldname' + form_row + '" placeholder="<?php echo $entry_fieldname; ?>" class="form-control"></div>';
    html += ' </div>';
   		
	html += ' <div class="form-group">';
	html += '    <label class="control-label col-sm-2" for="input-help_text<?php echo $language['language_id']; ?>' + form_row + '"><span data-toggle="tooltip" title="<?php echo $help_helptext; ?>"><?php echo $entry_helptext;?></span></label><div class="col-sm-10">';										 
	html += '    <input type="text" name="option_fields[' + form_row + '][form_fields][<?php echo $language['language_id']; ?>][help_text]" value="" id="input-help_text<?php echo $language['language_id']; ?>' + form_row + '" placeholder="<?php echo $entry_helptext; ?>" class="form-control"></div>';
    html += ' </div>';
	
	html += ' <div class="form-group">';
	html += '    <label class="control-label col-sm-2" for="input-placeholder<?php echo $language['language_id']; ?>' + form_row + '"><span data-toggle="tooltip" title="<?php echo $help_placeholder; ?>"><?php echo $entry_placeholder;?></span></label><div class="col-sm-10">';										 
	html += '    <input type="text" name="option_fields[' + form_row + '][form_fields][<?php echo $language['language_id']; ?>][placeholder]" value="" id="input-placeholder<?php echo $language['language_id']; ?>' + form_row + '" placeholder="<?php echo $entry_placeholder; ?>" class="form-control"></div>';
    html += ' </div>';										 
		
	html += ' <div class="form-group">';
	html += '   <label class="control-label col-sm-2" for="input-error_message<?php echo $language['language_id']; ?>' + form_row + '"><span data-toggle="tooltip" title="<?php echo $help_error; ?>"><?php echo $entry_error;?></span></label> <div class="col-sm-10">';										 
	html += '    <input type="text" name="option_fields[' + form_row + '][form_fields][<?php echo $language['language_id']; ?>][error_message]" value="" id="input-error_message<?php echo $language['language_id']; ?>' + form_row + '" placeholder="<?php echo $entry_error; ?>" class="form-control"></div>';
    html += ' </div>';										 
    html += ' </div>';										 
	<?php } ?>	
	html += '<div class="form-group">';										 
	html += '		<label class="control-label col-sm-2" for="input-form_status' + form_row + '"><?php echo $entry_status; ?></label>';
	html += '	<div class="col-sm-10">';										 
											 
	html += '		<select name="option_fields[' + form_row + '][form_status]" id="input-form_status" class="form-control">';
						<?php if ($form_status) { ?>										 
	html += '			<option value="1" selected="selected"><?php echo $text_enable; ?></option>';										 
	html += '			<option value="0"><?php echo $text_disable; ?></option>';
						<?php } else { ?>						 
	html += '			<option value="1"><?php echo $text_enable; ?></option>';										 
	html += '			<option value="0" selected="selected"><?php echo $text_disable; ?></option>';
						<?php } ?>			  
	html += '		</select>';										 
	html += '	</div>';										 
	html += '</div>';
											 
	html += '<div class="form-group">';										 
	html += '		<label class="control-label col-sm-2" for="input-required' + form_row + '"><span data-toggle="tooltip" title="<?php echo $help_required; ?>"><?php echo $entry_required;?></span></label>';html += '	<div class="col-sm-10">';										 
											 
	html += '		<select name="option_fields[' + form_row + '][required]" id="input-required" class="form-control">';
						<?php if ($required) { ?>										 
	html += '			<option value="1" selected="selected"><?php echo $text_yes; ?></option>';										 
	html += '			<option value="0"><?php echo $text_no; ?></option>';
						<?php } else { ?>						 
	html += '			<option value="1"><?php echo $text_yes; ?></option>';										 
	html += '			<option value="0" selected="selected"><?php echo $text_no; ?></option>';
						<?php } ?>			  
	html += '		</select>';										 
	html += '	</div>';										 
	html += '</div>';										 
	

	html += ' <div class="form-group">';
	html += ' <label class="control-label col-sm-2" for="input-sortorder<?php echo $language['language_id']; ?>' + form_row + '"><?php echo $entry_sortorder;?></label><div class="col-sm-10">';										 
	html += '    <input type="text" name="option_fields[' + form_row + '][sort_order]" value="" id="input-sortorder' + form_row + '" placeholder="<?php echo $entry_sortorder; ?>" class="form-control"></div>';
    html += ' </div>';	
// option type//
											 
	html += '<div class="form-group">';	
	html += '		<label class="control-label col-sm-2" for="input-type"><?php echo $entry_type; ?></label>';html += '	<div class="col-sm-10">';										 
	html += '		<select name="option_fields[' + form_row + '][type]" id="input-type' + form_row + '" class="form-control typeoptions" rel="'+form_row+'">';										 
	html += '			<optgroup label="<?php echo $text_choose; ?>">';
						<?php if ($type == 'select') { ?>					 
	html += '			<option value="select" selected="selected"><?php echo $text_selects; ?></option>';
						<?php } else { ?>							  
	html += '			<option value="select"><?php echo $text_selects; ?></option>';
						<?php } ?>
						<?php if ($type == 'radio') { ?>			  
	html += '			<option value="radio" selected="selected"><?php echo $text_radio; ?></option>';	
						<?php } else { ?>							 
	html += '			<option value="radio"><?php echo $text_radio; ?></option>';	
						<?php } ?>
						<?php if ($type == 'checkbox') { ?>			  
	html += '			<option value="checkbox" selected="selected"><?php echo $text_checkbox; ?></option>';
						<?php } else { ?>								
	html += '			<option value="checkbox"><?php echo $text_checkbox; ?></option>';
						<?php } ?>			  
	html += '			</optgroup>';										 
	html += '			<optgroup label="<?php echo $text_input; ?>">';
						<?php if ($type == 'text') { ?>				 
	html += '			<option value="text" selected="selected"><?php echo $text_text; ?></option>';
						<?php } else { ?>
	html += '			<option value="text"><?php echo $text_text; ?></option>';
						<?php } ?>
						<?php if ($type == 'textarea') { ?>
	html += '			<option value="textarea" selected="selected"><?php echo $text_textarea; ?></option>';
						<?php } else { ?>
	html += '			<option value="textarea"><?php echo $text_textarea; ?></option>';
						<?php } ?>
						<?php if ($type == 'number') { ?>
	html += '			<option value="number" selected="selected"><?php echo $text_number; ?></option>';
						<?php } else { ?>
	html += '			<option value="number"><?php echo $text_number; ?></option>';
						<?php } ?>
						<?php if ($type == 'telephone') { ?>
	html += '			<option value="telephone" selected="selected"><?php echo $text_telephone; ?></option>';
						<?php } else { ?>
	html += '			<option value="telephone"><?php echo $text_telephone; ?></option>';	
						<?php } ?>
						<?php if ($type == 'email') { ?>
	html += '			<option value="email" selected="selected"><?php echo $text_email; ?></option>';
						<?php } else { ?>
	html += '			<option value="email"><?php echo $text_email; ?></option>';	
						<?php } ?>
						<?php if ($type == 'emaile_exists') { ?>
	html += '			<option value="emaile_exists" selected="selected"><?php echo $text_emailexists; ?></option>';
						<?php } else { ?>
	html += '			<option value="emaile_exists"><?php echo $text_emailexists; ?></option>';	
						<?php } ?>
						<?php if ($type == 'password') { ?>
	html += '			<option value="password" selected="selected"><?php echo $text_password; ?></option>';
						<?php } else { ?>
	html += '			<option value="password"><?php echo $text_password; ?></option>';
						<?php } ?>
						<?php if ($type == 'confirm') { ?>
	html += '			<option value="confirm" selected="selected"><?php echo $text_cpassword; ?></option>';
						<?php } else { ?>
	html += '			<option value="confirm"><?php echo $text_cpassword; ?></option>';
						<?php } ?>
						<?php if ($type == 'unique_word') { ?>
	html += '			<option value="unique_word" selected="selected"><?php echo $text_uniqueword; ?></option>';
						<?php } else { ?>
	html += '			<option value="unique_word"><?php echo $text_uniqueword; ?></option>';
						<?php } ?>					
	html += '			</optgroup>';				 
	html += '			<optgroup label="<?php echo $text_file; ?>">';	
						<?php if ($type == 'file') { ?>
	html += '			<option value="file" selected="selected"><?php echo $text_file; ?></option>';	
						<?php } else { ?>
	html += '			<option value="file"><?php echo $text_file; ?></option>';	
						<?php } ?>
	html += '			</optgroup>';
						
	html += '			<optgroup label="<?php echo $text_date; ?>">';
						<?php if ($type == 'date') { ?>
	html += '			<option value="date" selected="selected"><?php echo $text_date; ?></option>';
						<?php } else { ?>
	html += '			<option value="date"><?php echo $text_date; ?></option>';
						<?php } ?>
						<?php if ($type == 'time') { ?>
	html += '			<option value="time" selected="selected"><?php echo $text_time; ?></option>';
						<?php } else { ?>
	html += '			<option value="time"><?php echo $text_time; ?></option>';
						<?php } ?>
						<?php if ($type == 'datetime') { ?>
	html += '			<option value="datetime" selected="selected"><?php echo $text_datetime; ?></option>';
						<?php } else { ?>
	html += '			<option value="datetime"><?php echo $text_datetime; ?></option>';
						<?php } ?>
	html += '			</optgroup>';
	html += '			<optgroup label="<?php echo $text_localisation; ?>">';
						<?php if ($type == 'country') { ?>
	html += '			<option value="country" selected="selected"><?php echo $text_country; ?></option>';
						<?php } else { ?>
	html += '			<option value="country"><?php echo $text_country; ?></option>';
						<?php } ?>
						<?php if ($type == 'zone') { ?>
	html += '			<option value="zone" selected="selected"><?php echo $text_zone; ?></option>';
						<?php } else { ?>
	html += '			<option value="zone"><?php echo $text_zone; ?></option>';
						<?php } ?>
	html += '			</optgroup>';			 
	html += '		</select>';										 
	html += '	</div>';										 
	html += '</div>';	
		
	// Select Option//
											 
	html += '		<div class="form-group">';
	html += '		<div class="col-sm-12">';
	html += '		<div class="table-responsive" id="form_option'+form_row+'">';
	html += '		<table id="tab-formfield'+form_row+'" class="table table-striped table-bordered table-hover">';
	html += '		<thead>';
	html += '		<tr>';
	html += '		<td class="text-left"><?php echo $entry_option_value; ?></td>';
	html += '		<td class="text-left hide"><?php echo $entry_image; ?></td>';
	html += '		<td class="text-right"><?php echo $entry_sort_order; ?></td>';
	html += '		<td></td>';
	html += '		</tr>';
	html += '		</thead>';
	html += '		<tbody>';
		
	html += '		<tr id="form_option-row<?php echo $form_option_row; ?>">';
		
	html += '		</tr>';
			
	html += '		</tbody>';
	html += '		<tfoot>';
	html += '		<tr>';
	html += '		<td colspan="2"></td>';
	html += '		<td class="text-left"><button type="button" onclick="addFormOption('+form_row+');" data-toggle="tooltip" title="<?php echo $button_option_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
	html += '		</tr>';
	html += '		</tfoot>';
	html += '		</table>';
	html += '		</div>';
	html += '		</div>';
	html += '		</div></div>';										 
											 
// option type//
	html += ' </div>';
	
		$('#tab-formfield .one').append(html);
		$('.fieldslanguaget'+form_row+' a:first').tab('show');
		
	$('#formfield-add').before('<li><a href="#tab-formfield' + form_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'#formfield a:first\').tab(\'show\'); $(\'a[href=\\\'#tab-formfield' + form_row + '\\\']\').parent().remove(); $(\'#tab-formfield' + form_row + '\').remove();"></i> <?php echo $tab_option; ?> ' + form_row + '</a></li>');

	$('#formfield a[href=\'#tab-formfield' + form_row + '\']').tab('show');
		
	$('#tab-formfield' + form_row + ' .form-group[data-sort]').detach().each(function() {
		if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-formfield' + form_row + ' .form-group').length) {
			$('#tab-formfield' + form_row + ' .form-group').eq($(this).attr('data-sort')).before(this);
		}

		if ($(this).attr('data-sort') > $('#tab-formfield' + form_row + ' .form-group').length) {
			$('#tab-formfield' + form_row + ' .form-group:last').after(this);
		}

		if ($(this).attr('data-sort') < -$('#tab-formfield' + form_row + ' .form-group').length) {
			$('#tab-formfield' + form_row + ' .form-group:first').before(this);
		}
	});

	form_row++;
		
}
//--></script>
	
<script type="text/javascript"><!--
$('body').delegate('.typeoptions', 'click', function(e) {
	rel=$(this).attr('rel');
	if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
		$('#form_option'+rel).show();
	} else {
		$('#form_option'+rel).hide();
	}
});
	
function addFormOption(mainid) {
	html  = '<tr id="form_option-row' + form_option_row + '">';	
    html += '  <td class="text-left"><input type="hidden" name="option_fields[' + mainid + '][option_type][' + form_option_row + '][form_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '    <div class="input-group">';
	html += '      <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="option_fields[' + mainid + '][option_type][' + form_option_row + '][option_value_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />';
    html += '    </div>';
	<?php } ?>
	html += '  </td>';
    html += '  <td class="text-left hide"><a href="" id="thumb-image' + form_option_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="option_fields[' + mainid + '][option_type][' + form_option_row + '][image]" value="" id="input-image' + form_option_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="option_fields[' + mainid + '][option_type][' + form_option_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#form_option-row' + form_option_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#form_option'+mainid+' tbody').append(html);
	
	form_option_row++;
}	
	
</script>	
	
<script>
    $(function() {
        $('#input-assign-product').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
		$('#'+$('#input-assign-product option:selected').val()).show();
    });

   

	// img delete
//$('.delete').click(function(){
$(document).on('click','.delete',function() {
	var field_id = $(this).attr('rel');
	$.ajax({
	url: 'index.php?route=tmdform/form/fielddelete&token=<?php echo $token;?>&field_id='+field_id,
	type:'post',
	dataType:'json',
		beforeSend: function() {
	},
	success: function(json) {
		
	}
});
});
	
</script>	
	
<script type="text/javascript"><!--
$('#language a:first').tab('show');
$('.language a:first').tab('show');
//--></script>
	
<script type="text/javascript"><!--
$('#language1 a:first').tab('show');
//--></script>
	
<script type="text/javascript"><!--
$('.customer_language a:first').tab('show');
//--></script>
	
<script type="text/javascript"><!--
$('.fieldslanguage a:first').tab('show');
$('.admin_language a:first').tab('show');
$('#tab-formfield a:first').tab('show');
//--></script>	
	
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType:'json',
			success: function(json) {
				 json.unshift({
					product_id: 0,
					name:'<?php echo $text_none; ?>'
				});
				response($.map(json,function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val();
		$('#form_product' + item['value']).remove();
		$('#form_product').append('<div id="form_product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');
	}
});
$('#form_product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});


// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');

		$('#form_category' + item['value']).remove();

		$('#form_category').append('<div id="form_category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category[]" value="' + item['value'] + '" /></div>');
	}
});

$('#form_category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['manufacturer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'manufacturer\']').val('');

		$('#form_manufacturer' + item['value']).remove();

		$('#form_manufacturer').append('<div id="form_manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="manufacturer[]" value="' + item['value'] + '" /></div>');
	}
});

$('#form_manufacturer').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});


//--></script></div>

<?php echo $footer; ?>
<style>
#form-form .first li.active a,#form-form .first li.active a:hover,#form-form .first li.active a:focus{
	background-color: #f2f2f2;
}
#form-form #formfield {
    border-bottom: medium none;
    border-right: 4px solid #1e91ce;
    min-height: 906px;
}
#form-form #formfield li.active > a,#form-form .nav-pills > li.active > a,#form-form .nav-pills > li.active > a:hover, #form-form .nav-pills > li.active > a:focus {
    border-color: transparent !important;
    background-color:transparent !important;
}
#form-form #formfield li a{
	color:#333;
}
#form-form #formfield li.active {
    border-color: #1e91ce #fff #1e91ce #1e91ce;
    border-style: solid;
    border-width: 1px 4px;
    position: relative;
    right: -4px;
}
#form-form .nav-tabs > li > a{
	font-size:13px;
}
a:focus {
    outline: medium none;
}
.one .control-label{
	text-align:left;
}
#formfield-add a{
	color:#fff !important;
}
#formfield-add{
	margin-right:5px;
}
#formfield-add .btn-primary:hover,#formfield-add .btn-primary:focus,#formfield-add .btn-primary.focus,#formfield-add .btn-primary:active,#formfield-add .btn-primary.active,#formfield-add .open > .dropdown-toggle.btn-primary{
	color:#000 !important;
}
#form-form #formfield #formfield-add a{
	background-color:#1e91cf !important;
}
#form-form #formfield #formfield-add {
    border: medium none !important;
    margin-top:15px;
}
</style>

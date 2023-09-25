<!--popup-->
<div class="modal-dialog modal-md modal_formbuilder">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?php echo $productname; ?></h4>
			<div class="pull-right">
			<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
		</div>
		<div class="modal-body"> 
		 <div class="image">
		 <?php if ($thumb) { ?>
			<img src="<?php echo $thumb; ?>" class="img-responsive" alt="image" title="image"/>
		 <?php } ?>
			
		 </div>
		<div class="topdescrption"><?php echo $top_description; ?></div>
		 
			<form class="form-horizontal" id="form-horizontal">
			<div id="formbuilder">
				<div class="custom_formbuilder">
				<input type="hidden" name="product_id" value="<?php echo $product_id?>" />
				<input type="hidden" name="form_id" value="<?php echo $form_id; ?>"/>
				
				<?php if ($form_fields) { ?>
				<?php foreach ($form_fields as $optionfield) { ?>
				<?php if ($optionfield['type'] == 'select') { ?>
					<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
						<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
						<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>
						<?php echo $optionfield['field_name']; ?>
						<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
						</label>
						<div class="col-sm-12">	
							<div class="input-formfields<?php echo $optionfield['field_id']; ?>">
							<select name="formfields[<?php echo $optionfield['field_id']; ?>]"  class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($optionfield['form_field_option'] as $option_value) { ?>	
								<?php if($formfields[$optionfield['field_id']]==$option_value['name']) { ?>							
								<option value="<?php echo $option_value['name']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
								<?php } else { ?> 
								<option value="<?php echo $option_value['name']; ?>"><?php echo $option_value['name']; ?></option>
								
								<?php } }?>
							</select>
						</div>
						</div>
					</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'radio') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
					<label class="col-sm-12  control-label"><?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>
					<?php echo $optionfield['field_name']; ?>					
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
					</label>					
					<div class="col-sm-12">
					<div id="input-formfields<?php echo $optionfield['field_id']; ?>">
						<?php foreach ($optionfield['form_field_option'] as $option_value) { ?>
						<div class="radio">
							<label>
								<input type="radio" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="<?php echo $option_value['name']; ?>" />							                    
								<?php echo $option_value['name']; ?>
								
							</label>
						</div>
						<?php } ?>
					</div>			
					</div>			
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'checkbox') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label">
				  <?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>
				  <?php echo $optionfield['field_name']; ?>
				  <?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-12">
				  <div class="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php foreach ($optionfield['form_field_option'] as $option_value) { ?>
					<div class="checkbox">
					  <label>
						<input type="checkbox" name="formfields[<?php echo $optionfield['field_id']; ?>][]" value="<?php echo $option_value['name']; ?>" />    
						<?php echo $option_value['name']; ?>
					   
					  </label>
					</div>
					<?php } ?>
				  </div>
				  </div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'text') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
					<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
						<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?> <?php echo $optionfield['field_name']; ?>	
					   <?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
					</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />					
					</div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'textarea') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
				  <?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
				  <?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-12">
				  <textarea name="formfields[<?php echo $optionfield['field_id']; ?>]" rows="5" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>"></textarea>
				  </div>
				</div>
				<?php } ?>
					
				<?php if ($optionfield['type'] == 'number') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>	
				<?php } ?>
					
				<?php if ($optionfield['type'] == 'telephone') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>	
				<?php } ?>	
					
				<?php if ($optionfield['type'] == 'email') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
						
					</div>
				</div>	
				<?php } ?>	
				<?php if ($optionfield['type'] == 'emaile_exists') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>		
				<?php } ?>	
				<?php if ($optionfield['type'] == 'password') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="password" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div> 
				</div>		
				<?php } ?>	
				<?php if ($optionfield['type'] == 'confirm') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="password" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>	
				<?php } ?>	
				<?php if ($optionfield['type'] == 'file') { ?>
				
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="control-label col-sm-12">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-4">
				  <button type="button" id="button-upload<?php echo $optionfield['field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
				  <input type="hidden" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" id="input-formfields<?php echo $optionfield['field_id']; ?>" />
				  </div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'date') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="control-label col-sm-12" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-12">
				  <div class="input-group date">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="YYYY-MM-DD" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					<span class="input-group-btn">
					<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					</span></div>
					</div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'datetime') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="control-label col-sm-12" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				   <div class="col-sm-12">
				  <div class="input-group datetime">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
					</span></div>
					</div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'time') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="control-label col-sm-12" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
					<div class="col-sm-12">
					<div class="input-group time">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="HH:mm" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
					</span></div>
				   </div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'country') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
					<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
						<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
						<?php echo $optionfield['field_name']; ?>				  
						<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
					</label>
					<div class="col-sm-12">	
						<select name="formfields[<?php echo $optionfield['field_id']; ?>]" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control country_id input-formfields<?php echo $optionfield['field_id']; ?>">
							 <option value=""><?php echo $text_select; ?></option>
							 <?php foreach ($countries as $country) { ?>
							<?php if ($country['country_id'] == $optionfield['field_id']) { ?>
							<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>	
				<?php } ?>
				<?php if ($optionfield['type'] == 'zone') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
					<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
						<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
						<?php echo $optionfield['field_name']; ?>				  
						<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
					</label>
					<div class="col-sm-12">	
					<select name="formfields[<?php echo $optionfield['field_id']; ?>]" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control zone_id input-formfields<?php echo $optionfield['field_id']; ?>">
					</select>
					</div>
				</div>	
				<?php } ?>	
					
				<?php if ($optionfield['type'] == 'address') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>
				<?php } ?>	
				<?php if ($optionfield['type'] == 'postcode') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				<label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				</label>
					<div class="col-sm-12">
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['name']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control input-formfields<?php echo $optionfield['field_id']; ?>" />
					</div>
				</div>
				<?php } ?>	
			  
				<?php } ?>
				<?php } ?>	
						
			</div>
				<?php if ($captchastatus == 1) { ?>					
					 <?php echo $captcha; ?>
					 <div class="g-recaptcha"></div>					
				<?php }  ?>				
				<button type="button" id="button-formbulider" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block button-formbulider"><?php echo $button_name; ?></button>
				
						<!--<div class="form-group">
							<div  id="wait" class="loader hide">
								<img src="image/loader.gif" 	alt="loading" title="loading"/>
							</div>						
							<div class="buttons">
								<div class="col-sm-4"></div>
								<div class="col-sm-4">
									<button type="button" id="button-formbulider" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block button-formbulider"><?php echo $button_name; ?></button>
								</div>
								<div class="col-sm-4"> 	
									<?php if($resetbutton==1) {?>							
									<input type="reset" value="<?php echo $resetbutton_name; ?>"  class="btn btn-default btn-lg btn-block"/>
									<?php } ?>
								</div>				
							</div>	
						</div>	-->			
					</div>
				</div>
			</form>
		  <div class="bottomdescrption"><?php echo $bottom_description; ?></div>	  
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$('.button-formbulider').on('click', function() {
	$.ajax({
		url: 'index.php?route=tmdform/popupform/addpoup',
		type: 'post',
		data: $('#formbuilder input[type=\'text\'], #formbuilder input[type=\'password\'], #formbuilder input[type=\'hidden\'], #formbuilder input[type=\'radio\']:checked, #formbuilder input[type=\'checkbox\']:checked, #formbuilder select, #formbuilder textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('.button-formbulider').button('loading');
			$('.loader').removeClass('hide');
		},
		complete: function() {
			$('.button-formbulider').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			/* validation class has error */
			$('.form-group').removeClass('has-error');	
			/* validation class has error */
			$('.loader').addClass('hide');
			
			if (json['error']) {
				if (json['error']['formfields']) {
					for (i in json['error']['formfields']) {
						var element = $('.input-formfields' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['formfields'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['formfields'][i] + '</div>');
						}
					}
                    /* validation class has error */			
					$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					/* validation class has error */

					if(json['error']['g-recaptcha-response']!=''){
						$('.g-recaptcha').after('<div class="col-sm-offset-2 text-danger">' + json['error']['g-recaptcha-response'] + '</div>');
					}

				}
                /* warning code */
				if (json['warning']) {	
					
					$('#form-horizontal').before('<div class="alert alert-danger"> <i class="fa fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert">×</button> </div>');
					$('.modal').animate({ scrollTop: 0 }, 'slow');
				}	
				/* warning code */
			
			}
			if (json['success']) {
				location='<?php echo str_replace('&amp;','&',$producturl)?>';
			}
		}
	});
});


$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
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

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});


$('.date').datetimepicker({
	format:'YYYY-MM-DD',
	minDate: moment,
});

/*$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});*/

$('.country_id').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/account/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('.country_id').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('.zone_id').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
$('select .country_id').trigger('change');

//--></script>
<style>
<?php echo $customcss; ?>
</style>

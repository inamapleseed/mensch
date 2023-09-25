<div class="formbulider">
<h2><?php echo $formtitle; ?></h2>	  
		<form class="form-horizontal">
			<div id="formbuilder<?php echo $forms_ids; ?>">
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
							<div id="input-formfields<?php echo $optionfield['field_id']; ?>">
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
					<label class="col-sm-3  control-label"><?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>
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
				  <div id="input-formfields<?php echo $optionfield['field_id']; ?>">
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />					
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
				  <textarea name="formfields[<?php echo $optionfield['field_id']; ?>]" rows="5" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control"></textarea>
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
						
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<input type="password" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<input type="password" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
					</div>
				</div>	
				<?php } ?>	
				<?php if ($optionfield['type'] == 'file') { ?>
				
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-12">
				  <button type="button" id="button-upload<?php echo $optionfield['field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
				  <input type="hidden" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" id="input-formfields<?php echo $optionfield['field_id']; ?>" />
				  </div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'date') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				  <div class="col-sm-12">
				  <div class="input-group date">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="YYYY-MM-DD" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control" />
					<span class="input-group-btn">
					<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					</span></div>
					</div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'datetime') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
				   <div class="col-sm-12">
				  <div class="input-group datetime">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control" />
					<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
					</span></div>
					</div>
				</div>
				<?php } ?>
				<?php if ($optionfield['type'] == 'time') { ?>
				<div class="form-group<?php echo ($optionfield['required'] ? ' required' : ''); ?>">
				  <label class="col-sm-12 control-label" for="input-formfields<?php echo $optionfield['field_id']; ?>">
					<?php if(!empty($optionfield['help_text'])) { ?><span data-toggle="tooltip" title="<?php echo $optionfield['help_text']; ?>"> <?php }?>	  
					<?php echo $optionfield['field_name']; ?>				  
					<?php if(!empty($optionfield['help_text'])) { ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </span><?php } ?>
				  </label>
					<div class="col-sm-12">
					<div class="input-group time">
					<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" data-date-format="HH:mm" id="input-option<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<select name="formfields[<?php echo $optionfield['field_id']; ?>]" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control country_id">
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
					<select name="formfields[<?php echo $optionfield['field_id']; ?>]" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control zone_id">
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
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
						<input type="text" name="formfields[<?php echo $optionfield['field_id']; ?>]" value="" placeholder="<?php echo $optionfield['placeholder']; ?>" id="input-formfields<?php echo $optionfield['field_id']; ?>" class="form-control" />
					</div>
				</div>
				<?php } ?>	
			  
				<?php } ?>
				<?php } ?>

							
				<!--updatecode-->
						<div  id="wait" class="loader hide">
							<img src="image/loader.gif" alt="loading" title="loading"/>
						</div>	
						<!--updatecode-->
						<div class="buttons">
							<div class="">
								<button type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block button-formbulider<?php echo $forms_ids; ?>"><?php echo $button_name; ?></button>				
							</div>				
						</div>				
					</div>
				</div>
			</form>
			
<script type="text/javascript">
<!--updatecode-->
$('.button-formbulider<?php echo $forms_ids; ?>').on('click', function() {
	$.ajax({
		url: 'index.php?route=tmdform/popupform/addpoup',
		type: 'post',
		data: $('#formbuilder<?php echo $forms_ids; ?> input[type=\'text\'], #formbuilder <?php echo $forms_ids; ?>input[type=\'password\'], #formbuilder<?php echo $forms_ids; ?> input[type=\'hidden\'], #formbuilder<?php echo $forms_ids; ?> input[type=\'radio\']:checked, #formbuilder<?php echo $forms_ids; ?> input[type=\'checkbox\']:checked, #formbuilder<?php echo $forms_ids; ?> select, #formbuilder<?php echo $forms_ids; ?> textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('.button-formbulider<?php echo $forms_ids; ?>').button('loading');
				
				$('.loader').removeClass('hide');
		},
		complete: function() {
			$('.button-formbulider<?php echo $forms_ids; ?>').button('reset');
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
						var element = $('#input-formfields' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['formfields'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['formfields'][i] + '</div>');
						}
					}
				}

 /* validation class has error */			
					$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					/* validation class has error */
			
			if(json['error']['g-recaptcha-response']!=''){
			$('#g-recaptcha').after('<div class="text-danger">' + json['error']['g-recaptcha-response'] + '</div>');
			}
			
			
			}
			if (json['success']) {
				location='<?php echo str_replace('&amp;','&',$producturl)?>';
			}
		}
	});
});
<!--updatecode-->

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
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

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
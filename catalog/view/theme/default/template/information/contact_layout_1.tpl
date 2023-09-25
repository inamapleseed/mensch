<?= $header; ?>
<div class="container">
	<?= $content_top; ?>
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<div class="row"><?= $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?= $class; ?>">
			<h2><?= $heading_title; ?></h2>

			<div class="row pd-b30">
				<div class="col-xs-12">
					<div class="iframe-wrap"><?= $gmap_iframe ?></div>
				</div>
			</div>

		<div class="row">
			<div class="col-sm-12 col-md-5 pd-b30">
				<h4>Contact Information</h4>
				<div>
					<span>
						<?= $address; ?>
					</span>
				</div>
				<div>
					<span>Tel:</span>
					<a href="tel:<?= $store_telephone; ?>" alt="<?= $store_telephone; ?>" title="<?= $store_telephone; ?>" ><?= $store_telephone; ?></a><br />

				</div>
				<?php if($whatsapp){ ?>
					<div>
						<span><?= $text_whatsapp; ?>:</span> <a target="_blank" href="https://wa.me/<?= $whatsapp; ?>" >+<?= $whatsapp; ?></a><br/>
					</div>
				<?php } ?>
				<div class="email">
					<span><?= $text_contact_email; ?>: </span>
					<a href="mailto:<?= $store_email; ?>" alt="<?= $store_email; ?>" title="<?= $store_email; ?>" ><?= $store_email; ?></a><br />
				</div>

				<div>
					<?php if ($open) { ?>
					<span><?= $text_open; ?></span><br />
					<?= $open; ?><br />
					<br />
					<?php } ?>
				</div>
			</div>
			<div class="col-sm-12 col-md-7 pd-b30">
				<form id="contact-us-form" action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<h4>Message Us</h4>
					<div class="contact-body">
						<div class="form-group required">
							<label class="control-label" for="input-name"><?= $entry_name; ?></label>
							<input type="text" name="name" value="<?= $name; ?>" id="input-name" class="form-control" placeholder="<?= $entry_name; ?>" />
							<?php if ($error_name) { ?>
							<div class="text-danger"><?= $error_name; ?></div>
							<?php } ?>
						</div>

						<div class="form-group required">
							<label class="control-label" for="input-email"><?= $entry_email; ?></label>
							<input type="text" name="email" value="<?= $email; ?>" id="input-email" class="form-control" placeholder="<?= $entry_email; ?>" />
							<?php if ($error_email) { ?>
							<div class="text-danger"><?= $error_email; ?></div>
							<?php } ?>
						</div>

						<div class="form-group required">
							<label class="control-label" for="input-telephone"><?= $entry_telephone; ?></label>
							<input type="tel" name="telephone" value="<?= $telephone; ?>" id="input-telephone" class="form-control input-number" placeholder="<?= $entry_telephone; ?>" />
							<?php if ($error_telephone) { ?>
							<div class="text-danger"><?= $error_telephone; ?></div>
							<?php } ?>
						</div>

						<div class="form-group required">
							<label class="control-label" for="input-subject"><?= $entry_subject; ?></label>
							<input type="text" name="subject" value="<?= $subject; ?>" id="input-subject" class="form-control" placeholder="<?= $entry_subject; ?>" />
							<?php if ($error_subject) { ?>
							<div class="text-danger"><?= $error_subject; ?></div>
							<?php } ?>
						</div>

						<div class="form-group required">
							<label class="control-label" for="input-enquiry"><?= $entry_enquiry; ?></label>
							<textarea name="enquiry" rows="10" id="input-enquiry" class="form-control" placeholder="<?= $entry_enquiry; ?>"><?= $enquiry; ?></textarea>
							<?php if ($error_enquiry) { ?>
							<div class="text-danger"><?= $error_enquiry; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="contact-footer text-center">
						<?= $captcha; ?>
						<div class="input-btn-con btn btn-primary"><input class="pull-sm-right" type="submit" value="<?= $button_submit; ?>" /><span>></span></div>
					</div>
				</form>
			</div>
		</div>

</div>
<?= $column_right; ?></div>
<?= $content_bottom; ?>
</div>
<script>
	$(document).ready(function(){
		if($('.text-danger').length){
			var h_height = $('.fixed-header').height();
			$('html, body').animate({ scrollTop: $('.text-danger').offset().top - h_height - 150}, 500);
		}
	});

	const contact_us_form = document.getElementById('contact-us-form');
	const form_submit_handler = async function (e) {
		e.preventDefault();
		const form = e.target;
		const form_action = form.action;
		const form_id = form.id;
		const form_data = new FormData(form);

		let response = await fetch(form_action + "/ajax_submit", {
			method: 'POST',
			body: form_data
		});

		let result;
		try {
			result = await response.json();
		} catch (err) {
			swal({
				title: '<?= $error_title1 ?>',
				html: '<?= $error_text1 ?>',
				type: "error"
			});

			return;
		}

		const form_inputs = form.querySelectorAll('input, textarea');

		if (result.hasOwnProperty('error')) {
			//error-ed out, failed validation or failed sending email.
			form_inputs.forEach(function(item, index){
				var error_field = item.getAttribute('name');
				var error_msg_div_ = document.getElementById(error_field + '_error_div');
				if (result.hasOwnProperty(error_field)) {
					if (error_msg_div_ === null) {
						var error_msg_div = document.createElement('div');
						error_msg_div.id = error_field + '_error_div';
						error_msg_div.classList.add('text-danger');
						error_msg_div.classList.add('error_field');
						error_msg_div.innerText = result[error_field];
						if (error_field === 'g-recaptcha-response') {
							captcha_div = item.parentNode.parentNode;
							captcha_div.insertAdjacentElement('afterend', error_msg_div);
						} else {
							item.insertAdjacentElement('afterend', error_msg_div);
						}
					}
				} else {
					//remove the error field if it has been fixed.
					if (error_msg_div_ !== null) {
						error_msg_div_.remove();
					}
				}
			});
		} else {
			//success
			swal({
				title: 'Success!',
				html: result.message,
				type: "success"
			});

			let all_error_fields = document.querySelectorAll('.error_field');
			all_error_fields.forEach(function(item, index){
				item.remove();
			});

			form_inputs.forEach(function(item, index){
				if (item.getAttribute('type') !== 'submit') {
					item.value = '';
				}
			});

			//FACEBOOK EVENT - CONTACT
			if(result.facebookevent_status){
				if (typeof fbq == 'function') {
					fbq('track', 'Contact');
				}else{
					console.log('Pixel not found');
				}
			}
			//FACEBOOK EVENT - CONTACT END

			//TODO: add google tracking code here
		}
		grecaptcha.reset();
	};

	contact_us_form.addEventListener('submit', form_submit_handler);
</script>
<?= $footer; ?>
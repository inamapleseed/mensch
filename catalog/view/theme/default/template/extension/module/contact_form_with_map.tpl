<div class="contact-form-with-map flex flex-wrap">
  <div class="form-col">
    <?php if(isset($title) && $title) {?>
    <h2><?=$title;?></h2>
    <?php } ?>
    <div class="contact-details flex m-b-lg">
      <?php if(isset($contact_details) && $contact_details) {?>
        <?php foreach($contact_details as $detail) {?>
          <div class="contact-detail text-center">
            <div class="text-center icon">
              <img src="<?=$detail['image']?$detail['image']:'image/no_image.png';?>" class="img-responsive"/>
            </div>
            <div class="text flex flex-hcenter">
              <div class="contact-label">
                <?=$detail['label'];?>:
              </div>
              <div class="detail">
                <?=html($detail['text']);?>
              </div>
            </div>            
          </div>
        <?php } ?>
      <?php } ?> 
    </div>
    <form id="contact-us-form" action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
      <?php if(isset($form_title) && $form_title) {?>
        <h3><?= $text_contact; ?></h3>
      <?php } ?>
     
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
        <input class="btn btn-primary pull-sm-right" type="submit" value="<?= $button_submit; ?>" />
      </div>
    </form>

  </div>
  <div class="map-col">
    <?=html($map_iframe);?>
  </div>
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
<style>
  /* .contact-form-with-map {
    margin:0 -15px;
  }
  .contact-form-with-map > * {
    padding:0 15px; 
  } */

  .form-col {

  }
  .contact-form-with-map .form-col {
      flex:1 0 50%;
      padding:calc(15px + 2vw);
      order:<?=$map_position == 'left'? '2' : '1';?>;
      background-color:<?=$background_color ? $background_color : '#ddd'; ?>;
      background-image:url(' image/<?=$background_image ? $background_image : ''; ?>');
      background-size:cover;
  }
  .contact-form-with-map .map-col{
      flex:1 0 50%;
      order:<?=$map_position == 'right'? '2' : '1';?>
  }
  .map-col iframe {
    width: 100%;
    height: 100%;
  }
  .contact-detail .icon {
    width: 70px;
    margin: 10px auto;
  }
  .contact-details  > *{
      flex:0 0 33.33333%;
  }
  body:not(.cke_editable) .contact-form-with-map h2:not(.swal2-title):not([style]) { 
    text-align: left!important;
  }
  @media (max-width: 991px) {

  }
  @media (max-width: 767px) { 
    .contact-form-with-map #contact-us-form  h3{
      text-align: center;
    }
    .contact-details {
    justify-content: center;
    }
    .contact-details  > *{
        flex:0 0 50%;
    }
    .contact-form-with-map > * {
        flex:0 0 100%!important;
    }
    .map-col iframe {
      min-height: 350px;
    }
    body:not(.cke_editable) .contact-form-with-map h2:not(.swal2-title):not([style]) { 
      text-align: center!important;
    }
  }
</style>
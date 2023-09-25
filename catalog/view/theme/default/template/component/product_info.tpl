<div class="product-gutter" id="product-<?=$product_id?>"> <?php /* product option in product component :: add product id to div  */ ?>
	<div class="product-block <?= $out_of_stock; ?>">
		<div class="product-image-block transition relative image-zoom-hover">
			<?php if($sticker && $sticker['name']){ ?>
				<a 
				href="<?= $href; ?>" 
				title="<?= $name; ?>" 
				class="sticker  <?= $sticker['image'] ? 'sticker-image':''; ?> <?php if($out_of_stock){echo 'out_of_stock';} ?> " 
				style="color: <?= $sticker['color']; ?>!important; background-color: <?= $sticker['background-color']; ?>">
					<?php if($sticker['image']){ ?>
						<img src="<?= $sticker['image'] ?>" />
					<?php } else { 
						echo html($sticker['name']); 
					} ?>
				</a>
			<?php } ?>
			<?php if($show_special_sticker){ ?>
				<a 
				href="<?= $href; ?>" 
				title="<?= $name; ?>" 
				class="special-sticker  <?= $sticker ? 'abjust_sticker' : '' ?>" 
				style="top:<?= $sticker ? '30px' : '0px' ?>; color: #fff!important; background-color: #E40001;">
					<?= $text_sale; ?>
				</a>
			<?php } ?>
			<?php if(!$show_special_sticker && !$sticker){ ?>
				<a 
				class="sticker" 
				style="opacity: 0; pointer-events: none"
				>
				n/a
				</a>
			<?php } ?>

			<div class="product-name">
				<a href="<?= $href; ?>"><?= $name; ?></a>
			</div>

			<a 
				href="<?= $href; ?>" 
				title="<?= $name; ?>" 
				class="product-image image-container relative" >
				<img 
					src="<?= $thumb; ?>" 
					alt="<?= $name; ?>" 
					title="<?= $name; ?>"
					class="img-responsive img1" />
				<?php if($thumb2 && $hover_image_change) { ?>
					<img 
						src="<?= $thumb2; ?>" 
						alt="<?= $name; ?>" 
						title="<?= $name; ?>"
						class="img-responsive img2" style="display: none"/>
				<?php } ?>
				<?php /*if($more_options){ ?>
				<div class="more-options-text absolute position-bottom-center">
					<?= $more_options; ?>
				</div>
				<?php }*/ ?>
			</a>
			<div class="btn-group product-button">
				<?php if ($options) { ?>
					<button type="button"
						<?php if($enquiry){ ?>
							class="btn btn-default btn-enquiry btn-enquiry-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>"
						<?php }else{ ?>
							class="btn btn-default btn-cart btn-cart-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>"
						<?php } ?>
						>
						<i class="fa fa-shopping-cart"></i>
					</button>
				<?php } else { ?>
					
					<?php if(!$enquiry){ ?>
						<?php if(!$not_avail) { ?>
							<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-cart btn-cart-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>"><span><?= $button_cart; ?></span><span>></span></button>
						<?php }else{ ?>
							<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-cart btn-cart-<?= $product_id; ?>" disabled data-product-id="<?= $product_id; ?>">Out of stock</button>
						<?php } ?>
					<?php }else{ ?>
						<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-enquiry btn-enquiry-<?= $product_id; ?>"  data-product-id="<?= $product_id; ?>"><?= $button_enquiry; ?></button>
					<?php } ?>
				<?php } ?>
				<!--<button type="button" onclick="wishlist.add('<?= $product_id; ?>');" class="btn wishlist-btn btn-default product_wishlist_<?= $product_id; ?>">
					<i class="fa <?= in_array($product_id, $wishlist) ?'fa-heart':'fa-heart-o';?>"></i>
				</button>
				<button type="button" onclick="compare.add('<?= $product_id; ?>');" class="btn btn-default hide">
					<i class="fa fa-exchange"></i>
				</button>-->
			</div>

				
			<?php if($special && $special_end != "0000-00-00"){ ?>
				<div class="product_countdown_box">
					<div class="countdown_day<?= $product_id; ?>"></div>
					<div class="countdown_hour<?= $product_id; ?>"></div>
					<div class="countdown_minute<?= $product_id; ?>"></div>
					<div class="countdown_second<?= $product_id; ?>"></div>
					<!--<p class="countdown<?= $product_id; ?>"></p>-->
				</div>
				<script>
					// Set the date we're counting down to
					var countDownDate<?= $product_id; ?> = new Date("<?= date("M d, Y H:i:59",strtotime($special_end." ".$special_end_time)); ?>").getTime();

					// Update the count down every 1 second
					var x = setInterval(function() {

					// Get today's date and time
					var now = new Date().getTime();

					// Find the distance between now and the count down date
					var distance = countDownDate<?= $product_id; ?> - now;

					// Time calculations for days, hours, minutes and seconds
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					//hours += days * 24;

					// Output the result in an element with id="demo"
					$(".countdown_day<?= $product_id; ?>").html(days+"<div>Days</div>");
				//    if(days == 0){
				//        $(".countdown_day<?= $product_id; ?>").css('display','none');
				//    }
					$(".countdown_hour<?= $product_id; ?>").html(hours+"<div>Hrs</div>");
					$(".countdown_minute<?= $product_id; ?>").html(minutes+"<div>Mins</div>");
					$(".countdown_second<?= $product_id; ?>").html(seconds+"<div>Secs</div>");
				//$(".countdown<?= $product_id; ?>").html("<i></i>"+hours + " : " + minutes + " : " + seconds);

					// If the count down is over, write some text 
					if (distance < 0) {
						clearInterval(x);
						$(".countdown<?= $product_id; ?>").html("EXPIRED");
					}
					}, 1000);
				</script>
			<?php } ?>

		</div>
			<?php if($category){ ?>
				<div class="product-category">
					<?= $category; ?>
				</div>
			<?php } ?>
			<?php if($manufacturer){ ?>
				<div class="product-brand">
					<?= $manufacturer; ?>
				</div>
			<?php } ?>
			<?php /* product option in product component */ ?>
			<div class="product-inputs">
				<?php if ($options && count($options) == 1) { ?>
					<div class="product-option">
						<?php foreach ($options as $option) { ?>
							<?php if ($option['type'] == 'quantity') { ?>
								<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
									<?php foreach ($option['product_option_value'] as $option_value) { ?>
										<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option_value['name']; ?><?php if ($option_value['price']) { ?><?= " (".$option_value['price_prefix']." ".$option_value['price'].")"; } ?></label>
										<div class="input-group">
											<span class="input-group-btn"> 
												<button type="button" class="btn btn-default btn-number" data-type="minus" onclick="odescrement($(this).parent().parent())" data-product-id="<?= $product_id; ?>">
													<span class="glyphicon glyphicon-minus"></span> 
												</button>
											</span>
											<input type="text" data-product-id="<?= $product_id; ?>" name="option[<?= $option['product_option_id']; ?>][<?= $option_value['product_option_value_id']; ?>][]" class="form-control input-number integer text-center" id="input-option<?= $option['product_option_id']; ?>" value="0" <?php if($option_value['subtract'] && $option_value['quantity'] < 1) {echo "disabled"; } ?>>
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-number" data-type="plus" onclick="oincrement($(this).parent().parent())" data-product-id="<?= $product_id; ?>">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</span>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
							<?php if ($option['type'] == 'select') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<select name="option[<?= $option['product_option_id']; ?>]" id="input-option<?= $option['product_option_id']; ?>" class="form-control" data-product-id="<?= $product_id; ?>">
								<option value=""><?= $text_select; ?></option>
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<option value="<?= $option_value['product_option_value_id']; ?>" <?php if($option_value['subtract'] && $option_value['quantity'] < 1) {echo "disabled"; } ?>><?= $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
								<?php } ?>
								</option>
								<?php } ?>
							</select>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'radio') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?= $option['name']; ?></label>
							<div id="input-option<?= $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<div class="radio <?php if($option_value['subtract'] && $option_value['quantity'] < 1) {echo "disabled"; } ?> <?php if ($option_value['image']) { ?>radio_image<?php }else{?> radio_wo_image<?php } ?>">
									<label class="<?php if ($option_value['image']) { ?>option_image_hover<?php } ?>">
										<input type="radio" <?php if ($option_value['image']) { ?>class="hide"<?php } ?> name="option[<?= $option['product_option_id']; ?>]" value="<?= $option_value['product_option_value_id']; ?>" data-product-id="<?= $product_id; ?>" />
										<?php if ($option_value['image']) { ?>
											<img src="<?= $option_value['image']; ?>" alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
										<?php } ?>
										<div class="<?php if ($option_value['image']) { ?>option_name_hover<?php } ?>">               
											<?= $option_value['name']; ?>
											<?php if ($option_value['price']) { ?>
											(<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
											<?php } ?>
										</div>
									</label>
									</div>
								<?php } ?>
							</div>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'checkbox') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?= $option['name']; ?></label>
							<div id="input-option<?= $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<div class="checkbox <?php if($option_value['subtract'] && $option_value['quantity'] < 1) {echo "disabled"; } ?> <?php if ($option_value['image']) { ?>checkbox_image<?php }else{?> checkbox_wo_image<?php } ?>">
										<label class="<?php if ($option_value['image']) { ?>option_image_hover<?php } ?>">
											<input type="checkbox" <?php if ($option_value['image']) { ?>class="hide"<?php } ?> name="option[<?= $option['product_option_id']; ?>][]" value="<?= $option_value['product_option_value_id']; ?>" data-product-id="<?= $product_id; ?>" />
											<?php if ($option_value['image']) { ?>
											<img src="<?= $option_value['image']; ?>" alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
											<?php } ?>
											<div class="<?php if ($option_value['image']) { ?>option_name_hover<?php } ?>">     
												<?= $option_value['name']; ?>
												<?php if ($option_value['price']) { ?>
												(<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
												<?php } ?>
											</div>
										</label>
									</div>
								<?php } ?>
							</div>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'text') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'textarea') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<textarea name="option[<?= $option['product_option_id']; ?>]" rows="5" placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>" class="form-control"><?= $option['value']; ?></textarea>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'file') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?= $option['name']; ?></label>
							<button type="button" id="button-upload<?= $option['product_option_id']; ?>" data-loading-text="<?= $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?= $button_upload; ?></button>
							<input type="hidden" name="option[<?= $option['product_option_id']; ?>]" value="" id="input-option<?= $option['product_option_id']; ?>" />
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'date') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<div class="input-group date">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
								</span></div>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'datetime') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<div class="input-group datetime">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span></div>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'time') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
							<div class="input-group time">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="HH:mm" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span></div>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="form-group hide">
					<label class="control-label hide"><?= $entry_qty; ?></label>
					<div class="input-group">
					<span class="input-group-btn"> 
						<button type="button" class="btn btn-default btn-number" data-type="minus" data-field="qty-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>" onclick="descrement($(this).parent().parent())")>
							<span class="glyphicon glyphicon-minus"></span> 
						</button>
					</span>
					<input type="text" name="quantity" class="form-control input-number integer text-center" id="input-quantity-<?= $product_id; ?>" value="<?= $minimum; ?>" data-product-id="<?= $product_id; ?>" >
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="qty-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>" onclick="increment($(this).parent().parent())">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
					</div>
				</div>
			</div>

			<div class="flex flex-wrap price_button">
				<div class="product-details product-price-<?=$product_id?>">
						<?php if ($price && !$enquiry) { ?>
							<div class="price">
								<?php if (!$special) { ?>
									<span class="price-new"><?= $price; ?></span>
								<?php } else { ?>
									<span class="price-new price-special"><?= $special; ?></span>
									<span class="price-old"><?= $price; ?></span>
								<?php } ?>
								<?php if ($tax) { ?>
									<span class="price-tax"><?= $text_tax; ?> <?= $tax; ?></span>
								<?php } ?>
							</div>
						<?php } ?>

						<?php if($enquiry){ ?>
							<div class="price">
								<span class="price-special"><?= $label_enquiry; ?></span>
							</div>
						<?php } ?>
				</div>
				<div class="cart-buttons hidden">
					<input type="hidden" name="product_id" value="<?=$product_id?>">
					<?php if(!$enquiry){ ?>
						<?php if(!$not_avail) { ?>
							<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-cart btn-cart-<?= $product_id; ?>" data-product-id="<?= $product_id; ?>"><?= $button_cart; ?></button>
						<?php }else{ ?>
							<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-cart btn-cart-<?= $product_id; ?>" disabled data-product-id="<?= $product_id; ?>">Out of stock</button>
						<?php } ?>
					<?php }else{ ?>
						<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary btn-enquiry btn-enquiry-<?= $product_id; ?>"  data-product-id="<?= $product_id; ?>"><?= $button_enquiry; ?></button>
					<?php } ?>
				</div>
			</div>
			<a class="btn btn-primary" style="margin: 20px auto auto;" href="<?php echo $href; ?>"><span>Learn More</span><span>></span></a>
	</div>
</div>





<?php if ($coupon_module) { ?>
	<div id="coupon-heading"><i class="fa fa-ticket"></i> <?php echo $entry_coupon; ?></div>
	<div id="coupon-content">

		<?php if(count($coupon_lists) > 0){ ?>
			<div id="coupon-list">
			<?php foreach($coupon_lists as $cl){ ?>
				<div class="each_coupon">
					<div class="each_coupon_amount">
						<?php if($cl['type'] == "p"){ 
							echo number_format($cl['discount'],0)."%";
						}else{ 
							echo "$".number_format($cl['discount'],2);
						} ?> 
					</div>
					<div class="each_coupon_date">
						<div>Validity Date: <?= date("M d, Y", strtotime($cl['date_end'])); ?></div>
						<button type="button" class="btn btn-primary btn-coupon btn-coupon-<?= $cl['coupon_id']; ?>" 
						onclick="applyCoupon('<?= $cl['coupon_id']; ?>','<?= $cl['code']; ?>')" style="font-size: 12px !important; min-width: 50px !important; padding: 6px 12px !important;">Apply</button>
					</div>
				</div>
			<?php } ?>
			</div>
		<?php } ?>
		
		<div class="input-group">
			<input type="text" name="coupon" value="" class="form-control" />
			<span class="input-group-btn">
				<button type="button" id="button-coupon" class="btn btn-primary"><?php echo $text_use_coupon; ?></button>
			</span>
		</div>
	</div>
<?php } ?>
<?php if ($voucher_module) { ?>
	<div id="voucher-heading"><i class="fa fa-gift"></i> <?php echo $entry_voucher; ?></div>
	<div id="voucher-content">
		<div class="input-group">
			<input type="text" name="voucher" value="" class="form-control" />
			<span class="input-group-btn">
				<button type="button" id="button-voucher" class="btn btn-primary"><?php echo $text_use_voucher; ?></button>
			</span>
		</div>
	</div>
<?php } ?>
<?php if ($reward_module && $reward) { ?>
	<div id="reward-heading"><i class="fa fa-star"></i> <?php echo $entry_reward; ?></div>
	<div id="reward-content">
		<div class="input-group">
			<input type="text" name="reward" value="" class="form-control" />
			<span class="input-group-btn">
				<button type="button" id="button-reward" class="btn btn-primary"><?php echo $text_use_reward; ?></button>
			</span>
		</div>
	</div>
<?php } ?>

<script type="text/javascript"><!--
	function applyCoupon(coupon_id, code) {
		if (code == $('input[name="coupon"]').val()) {
			$('input[name="coupon"]').val('');
		} else {
			$('input[name="coupon"]').val(code);
		}
		$('#button-coupon').click();
	}

	$('#coupon-heading').on('click', function() {
		if($('#coupon-content').is(':visible')){
			$('#coupon-content').slideUp(300);
		}
		else{
			$('#coupon-content').slideDown(300);
		};
	});
	
	$('#voucher-heading').on('click', function() {
		if($('#voucher-content').is(':visible')){
			$('#voucher-content').slideUp(300);
		}
		else{
			$('#voucher-content').slideDown(300);
		};
	});
	
	$('#reward-heading').on('click', function() {
		if($('#reward-content').is(':visible')){
			$('#reward-content').slideUp(300);
		}
		else{
			$('#reward-content').slideDown(300);
		};
	});
//--></script>
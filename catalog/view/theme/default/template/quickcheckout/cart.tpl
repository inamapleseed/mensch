<?php if($reward_point > 0){ ?>
	<h5 style="margin:10px 0;font-weight:bold;"><?= $avaailable_cart . ": " .$available_point; ?></h5>
<?php } ?>
<div class="table-responsive">
	<table class="quickcheckout-cart">
		<thead>
			<tr>
				<td class="image"><?php echo $column_image; ?></td>
				<td class="name"><?php echo $column_name; ?></td>
				<td class="quantity"><?php echo $column_quantity; ?></td>
				<td class="price1"><?php echo $column_price; ?></td>
				<td class="total"><?php echo $column_total; ?></td>
			</tr>
		</thead>
			<?php if ($products || $vouchers) { ?>
		<tbody>
					<?php foreach ($products as $product) { ?>
					<tr>
						<td class="image"><?php if ($product['thumb']) { ?>
							<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
							<?php } ?></td>
						<td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?><br/> [<?= $button_view; ?>]</a>
							<div>
								<?php foreach ($product['option'] as $option) { ?>
									<?php if ($option['type'] != 'file') { ?>
										<small><?php echo $option['name']; ?>: <?= $option['value'] . $option['price']; ?></small><br />
									<?php } else { ?>
										<small>
											<?= $option['name']; ?>:
											<a href="<?= $option['href']; ?>"><?= $option['value']; ?></a>
										</small><br />
									<?php } ?>
								<?php } ?>
					<?php if ($product['reward']) { ?>
					<br />
					<small><?php echo $product['reward']; ?></small>
					<?php } ?>
					<?php if ($product['recurring']) { ?>
					<br />
					<span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
					<?php } ?>
							</div></td>
						<td class="quantity">
							<?php if ($edit_cart) { ?>
								<?php if ($product['redeem'] == 0) { ?>
									<div class="input-group btn-block">
										<input type="text" name="quantity[<?php echo $product['key']; ?>]" size="1" value="<?php echo $product['quantity']; ?>" class="form-control" />
										<span class="input-group-btn">
											<button data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary button-update"><i class="fa fa-refresh"></i></button>
											<button data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger button-remove" data-remove="<?php echo $product['key']; ?>"><i class="fa fa-times-circle"></i></button>
										</span>
									</div>
									<?php if($product['redeem_point'] > 0 && $product['redeem_point'] < $available_point && $product['redeem'] == 0){ ?>
										<?php if($product['quantity'] > 1 && (($product['redeem_point'] * $product['quantity']) < $available_point) && $product['redeem'] == 0){ ?>
												<!--<button class="pull-right redeem" data-id="<?= $product['cart_id']; ?>" data-all="1">Redeem All</button>-->
										<?php } ?>
										<button data-toggle="tooltip" data-original-title="Use <?= $product['redeem_point']; ?> reward point to redeem" class="pull-right redeem" data-id="<?= $product['cart_id']; ?>" data-all="0">Redeem</button>
									<?php } ?>
								<?php } else { ?>
									x&nbsp;<?php echo $product['quantity']." (Redeemed)"; ?>
								<?php } ?>
							<?php } else { ?>
								<?php if ($product['redeem'] == 0) { ?>
									x&nbsp;<?php echo $product['quantity']; ?>
								<?php } else { ?>
									x&nbsp;<?php echo $product['quantity']." (Redeemed)"; ?>
								<?php } ?>
							<?php } ?>
						</td>
				<td class="price1">
					<?php echo $product['price']; ?>
				</td>
						<td class="total"><?php echo $product['total']; ?></td>
					</tr>
					<?php } ?>
					<?php foreach ($vouchers as $voucher) { ?>
					<tr>
						<td class="image"><a href="<?= $voucher['href'] ?>"><?= '<img src="'.$voucher['image'].'" class="img-responsive" />' ?></a></td>
						<td class="name"><a href="<?= $voucher['href'] ?>"><?php echo $voucher['description']; ?> <br/> [<?= $button_view; ?>]</a></td>
						<td class="quantity">x&nbsp;1</td>
				<td class="price1"><?php echo $voucher['amount']; ?></td>
						<td class="total"><?php echo $voucher['amount']; ?></td>
					</tr>
					<?php } ?>
			<?php foreach ($totals as $total) { ?>
				<tr>
					<td class="text-right" colspan="4"><b><?php if($total['code'] == "coupon"){echo '<i class="fa fa-times-circle remove_coupon" style="margin-right:10px;"></i>'. $total['title'];}else{echo $total['title'];} ?>:</b></td>
					<td class="text-right"><?php echo $total['text']; ?></td>
				</tr>
					<?php } ?>
		</tbody>
			<?php } ?>
	</table>
</div>

<script>
    $('.redeem').on("click",function(){
        var cart_id = $(this).data("id");
        var redeem_all = $(this).data("all");
    
        var data = "cart_id="+cart_id+"&redeem_all="+redeem_all;

        $.ajax({
            url: 'index.php?route=quickcheckout/cart/redeem',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(json) {
                //loadCart();
                window.location.reload();
            }
        });
    });
</script>
<script>
    $('.remove_coupon').on("click",function(){
        var data = "";
        $.ajax({
            url: 'index.php?route=quickcheckout/voucher/clearCoupon',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(json) {
                //loadCart();
                window.location.reload();
            }
        });
    });
</script>
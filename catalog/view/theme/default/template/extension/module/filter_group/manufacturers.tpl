<?php if($manufacturers){ ?>

<div id="side-manufacturer">
	<div class="list-group-item item-header"><?= $heading_title; ?></div>
	<div class="list-group-item">
		<?php foreach($manufacturers as $manufacturer){ ?>
			<div class="checkbox">
				<label>
					<?php if($manufacturer['checked']){ ?>
					<input type="checkbox" name="manufacturer_ids[]" value="<?= $manufacturer['mid']; ?>" checked />
					<span class="checkmark"></span>
					<?php }else{ ?>
					<input type="checkbox" name="manufacturer_ids[]" value="<?= $manufacturer['mid']; ?>" />
					<span class="checkmark"></span>
					<?php } ?>
					<?= $manufacturer['name']; ?>
				</label>
			</div>
		<?php } ?>
	</div>
</div>

<?php } ?>
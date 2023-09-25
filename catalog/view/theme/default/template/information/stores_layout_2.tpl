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
						
			<?php if ($locations) { ?>
				<div class="store_<?=$store_location_layout;?> max-offset flex store-locations three-col-row flex-wrap">
					<?php foreach ($locations as $index => $location) { ?>
						<div class="location posrel flex flex-column flex-vcenter flex-hcenter  text-center" style="background-image:url('<?= $location['image']; ?>')">
					
							<div class="flex-column transition flex flex-vcenter flex-hcenter  overlay">
								<div class="location-name  m-b text-color-primary">
									<?= $location['name']; ?> 
								</div>
								<div class="detail transition">
									<div class="address m-b">
										<?= $location['address']; ?>
									</div>
		
									<?php if ($location['open']) { ?>
										<div class="opening-hour">
											<?= $location['open']; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
<?= $column_right; ?></div>
<?= $content_bottom; ?>
</div>
<?= $footer; ?>
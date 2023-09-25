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
				<ul class="nav custom-tabs pd-b40 region-tabs flex-wrap flex flex-hcenter flex-vcenter">
					<?php $tab_count = 0;?>
					<?php foreach ($locations as $region => $region_location) { ?>
						<li class="text-center m-b-md region <?= $tab_count == 0 ?'active':'';?>">
							<a data-toggle="tab" class="text-uppercase" href="#tab_<?=$region;?>"><?=$region;?></a>
						</li>
					<?php $tab_count++; } ?>
				</ul>

				<div class="tab-content">
					<?php $count = 0;?>
					<?php foreach ($locations as $region => $region_location) { ?>
						<div id="tab_<?=$region;?>" class="tab-pane fade in <?= $count == 0 ?'active':'';?>">
							<div class="flex store-locations flex-row-col-spacing  flex-wrap ">
								<?php foreach ($region_location as $location) { ?>
									<div class="location flex flex-vcenter b4-col-33p-md b4-col-50p-sm b4-col-100p pd-b20">
										<?php if ($location['image']) { ?>
											<div class="image">
												<img src="<?= $location['image']; ?> "/>
											</div>	
										<?php } ?>
										<div class="detail pd-l15">
											<div class="location-name text-uppercase m-b text-color-primary">
												<?= $location['name']; ?> 
											</div>
				
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
								<?php } ?>
							</div>
						</div>
						
					<?php $count++; } ?>
				</div>
			<?php } ?>
		</div>
<?= $column_right; ?></div>
<?= $content_bottom; ?>
</div>
<?= $footer; ?>
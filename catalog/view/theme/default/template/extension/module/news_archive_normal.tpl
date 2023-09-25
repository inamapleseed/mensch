<button id="articles-filter-trigger-open" class="btn btn-primary" onclick="$('#articles-column-left').addClass('open');" ><?= $button_filter; ?></button>
<div id="articles-column-left">
	<button id="articles-filter-trigger-close" class="btn btn-danger fixed position-right-top" onclick="$('#articles-column-left').removeClass('open');"> <i class="fa fa-times"></i> </button>
	
	<div class="year">
		<h4>Archives</h4>
		<div class="list-group">
			<?php $index = 0; ?>
					<?php foreach ($archives as $archive) { ?>
				<?php $index++ ?>
				<?php //if ($index > 1 && (count($archive['month']) > 3 || count($archive) > 4) && (count($archive) > 2 || count($archive['month']) > 5)) { ?>
					<span class="list-group-item hidesthemonths <?= $achive_yr == $archive['year'] ? 'active' : '' ?>">
						<div class="year-wrap">
							<a href="<?php echo $archive['yr_href']; ?>"><?php echo $archive['year']; ?></a>
							<div class="toggle level-1 pointer"><div class="plus">+<span class="minus">-</span></div></div>
						</div>
						<div class="list-group">
							<?php foreach ($archive['month'] as $month) { ?>
								<a class="list-group-item <?= $archive_query == ($archive['year'].'-'.$month['num']) ? 'active' : '' ?>" href="<?php echo $month['href']; ?>"><?php echo $month['name']; ?></a>
							<?php } ?>
						</div>
					</span>
				<?php /*} else { ?>
					<?php foreach ($archive['month'] as $month) { ?>
						<a href="<?php echo $month['href']; ?>" class="list-group-item"><?php echo $month['name']; ?></a>
					<?php } ?>
				<?php }*/ ?>
					<?php } ?>
				<?php echo !$archives ? 'No articles' : ''; ?>
		</div>
	</div>
	<h4><?= $text_categories ?></h4>
	<div class="pd-b15">
		<div class="list-group news-ctgr">
			<?php if ($ncategories) { ?>
				<?php foreach ($ncategories as $ncategory) { ?>
				  <?php if ($ncategory['ncategory_id'] == $ncategory_id) { ?>
				  <div class="list-group-item <?= $ncategory['active']; ?>" >
					<a href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>	
						<?php if ($ncategory['children']) { ?>
						<div class="toggle level-1 pointer"><div class="caret"></div></div>
						<?php } ?>
				   </div>
	
				  <?php } else { ?>
					<div class="list-group-item <?= $ncategory['active']; ?>" ><a href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>
						<?php if ($ncategory['children']) { ?>
						<div class="toggle level-1 pointer"><div class="caret"></div></div>
						<?php } ?>
					</div>
				  <?php } ?>

					<?php if ($ncategory['children']) { ?>
						<div class="children list-group-item level-2 ">
							<?php foreach ($ncategory['children'] as $child) { ?>
								<?php if ($child['ncategory_id'] == $child_id) { ?>
									<div class="list-group-item <?= $child['active']; ?>">	
										<a href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
										<?php if ($child['children']) { ?>
											<div class="toggle level-1 pointer"><div class="caret"></div></div>
										<?php } ?>
									</div>
								<?php } else { ?>
									<div class="list-group-item <?= $child['active']; ?>">	
										<a class="" href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
										<?php if ($child['children']) { ?>
											<div class="toggle level-1 pointer"><div class="caret"></div></div>
										<?php } ?>
									</div>
								<?php } ?>

									<?php if ($child['children']) { ?>
										<div class="children level-3 list-group-item ">
											<?php foreach ($child['children'] as $child_2) { ?>
												<?php if ($child_2['ncategory_id'] == $child_id_lvl2) { ?>
													<div class="list-group-item <?= $child_2['active']; ?>">	
														<a href="<?php echo $child_2['href']; ?>"> - <?php echo $child_2['name']; ?></a>
													</div>
												<?php } else { ?>
													<div class="list-group-item <?= $child_2['active']; ?>">	
														<a href="<?php echo $child_2['href']; ?>"> - <?php echo $child_2['name']; ?></a>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
									<?php } ?>

							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>	
		</div>
	</div>

</div>

<script type="text/javascript">
$(document).ready(function () {
	/*
	$('.hidesthemonths').on('click', function () {
		$(this).find('div').slideToggle('fast');
	});
	*/
	$('#articles-column-left .news-ctgr .toggle').on('click', function(e){
	
		e.preventDefault();
		ele = $(this).parents('.list-group-item');
		ele.toggleClass('active');

	});


	// $('#articles-column-left .toggle').on('click', function(e){
	
	// 	e.preventDefault();
	// 	$(this).parent().parent().find('children').removeClass('hide');

	// });

	$('#articles-column-left .year .toggle').on('click', function(e){
	
	e.preventDefault();
	ele = $(this).parents('.list-group-item');
	
	if(ele.hasClass('active')){
		ele.removeClass('active');
	}
	else{ 
		if(ele.hasClass('.level-1')){
			$('.level-1.active').removeClass('active');
		}
		else if(ele.hasClass('.level-2')){
			$('.level-2.active').removeClass('active');
		}
		
		ele.addClass('active');
	}
});
});
</script>
<div class="article-inner">
	<div class="pd-md-60">
		<?php if ($gallery_images) { ?>
			<div class="content blog-gallery">
				<?php foreach ($gallery_images as $gallery) {?>
					<img src="image/<?php echo $gallery['normal']; ?>" alt="<?php echo $gallery['text']; ?>" />
				<?php } ?>
			</div>
		<?php }else { ?>
			<?php if ($thumb) { ?>
				<div class="pd-b30 text-center">	
					<img class="w100" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
				</div>
			<?php } ?>
		<?php } ?>
		<div class="pd-t30 pd-b30 flex flex-vcenter share-article">
			<div class="pd-r15"><?= $text_share ?>:</div>
			<div><?= $share_html ?></div>
		</div>

		<div class="pd-b15 flex-vcenter date-added flex"><div class="calendar-icon pd-r15"><img src="image/catalog/cal-min.png"/></div><?php echo $date_added; ?></div>
		
		<div class="pd-b15"><?php echo $description; ?></div>
	</div>
	<?php if ($related_products_slider) { ?>
	<?= $related_products_slider ?>
	<?php } ?>

	<?php if($prev_news && $next_news) {?>
		<div class="media-detail__btn-group btn-group flex">
			<div>
				<a class="media-detail__btn media-detail__btn--white btn btn-primary" href="<?php echo $prev_news ?  $prev_news : '#'; ?>">Prev</a>
			</div>
			<div class="right">
				<a class="media-detail__btn media-detail__btn--white btn btn-primary" href="<?php  echo  $next_news ? $next_news  : '#'; ?>">Next</a>
			</div>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">
	$(".content.blog-gallery").slick({
          dots: true,
          infinite: false,
          speed: 300,
		  arrows:true,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
          ],
          prevArrow: "<div class='pointer slick-nav left prev absolute'><div class='absolute position-center-center'><img src='image/catalog/slicings/blog_inner/left_29x29.png' alt='arrow'/></div></div>",
          nextArrow: "<div class='pointer slick-nav right next absolute'><div class='absolute position-center-center'><img src='image/catalog/slicings/blog_inner/right_29x29.png' alt='arrow'/></div></div>",
        });
</script>
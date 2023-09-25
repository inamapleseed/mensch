<div class="article-inner">
	<div class="pd-md-60">
		<?php if ($gallery_images) { ?>
			<div class="content blog-gallery m-b-lg">
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

		<div class="pd-b15"><?php echo $description; ?></div>

		<div class="pd-t30 pd-b30 flex flex-vcenter share-article">
			<div class="pd-r15"><?= $text_share ?>:</div>
			<div><?= $share_html ?></div>
		</div>
	</div>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$(".content.blog-gallery").slick({
		dots: true,
		infinite: false,
		speed: 300,
		arrows:true,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            },

          ],
		prevArrow: "<div class='pointer slick-nav left prev absolute'><div class='absolute position-center-center'><i class='fa fa-angle-left fa-2em'></i></div></div>",
		nextArrow: "<div class='pointer slick-nav right next absolute'><div class='absolute position-center-center'><i class='fa fa-angle-right fa-2em'></i></div></div>",
	});
});	
</script>
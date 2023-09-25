<div class="slides-container">
		<?php foreach ($repeater as $r): ?>
			<div>
				<img src="image/<?=$r['image'] ? $r['image'] : $r['mobile_image'];?>" alt="image" class="desktop">
				<img src="image/<?=$r['mobile_image'] ? $r['mobile_image'] : $r['image'] ;?>" alt="image" class="mobile">
				<div class="overlay-text">
			<?php echo html($r['title1']); ?>
          <!--<h2><?php echo html_entity_decode($r['title1']); ?></h2>
          <h4><?php echo $r['title2']; ?></h4>
          <h5><?php echo $r['title3']; ?></h5>-->

          <a class="btn btn-primary <?php echo $r['btnlink'] ? '' : 'hidden'; ?>" href="<?php echo $r['btnlink']; ?>"><span><?php echo $r['btntitle']; ?></span><span>></span></a>
        </div>
			</div>
		<?php endforeach ?>
</div>

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
  function initSlick() {
    $('.slides-container').slick({
      dots: true,
      infinite: true,
      speed: 500,
      arrows: true,
      pauseOnHover: false,
      adaptiveHeight: true,
      autoplay: false,
      slidesToShow: 1,
		prevArrow: "<div class='pointer slick-nav left prev absolute'><div class='absolute position-center-center'><img src='image/catalog/slicing/articles/left1.png' alt='arrow'/></div></div>",
		nextArrow: "<div class='pointer slick-nav right next absolute'><div class='absolute position-center-center'><img src='image/catalog/slicing/articles/right1.png' alt='arrow'/></div></div>",

    });
  }
  initSlick();
</script>
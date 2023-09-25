
<div class="fcategory_layout_1 featured-categories featured-categories_<?= $module_id; ?>">
  <?php foreach ($categories as $category) { ?>
    <div class="cat-gutter">
      <a href="<?php echo $category['href']; ?>">
        <div class="category  transition pointer" style="background:url(<?php echo $category['image']; ?>);">  </div>
      </a>
        <!-- <div class="product-thumb transition">
          <div class="image"><img data-src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive lazy" /></a></div>
            <h4 style="padding: 0 30px;"><a href="<?php echo $category['href']; ?>"><?php echo $cagory['name']; ?></a></h4>te
        </div> -->
    
    </div>

  <?php } ?>
</div>


<script>
    jQuery(document).ready(function ($) {
          $(".featured-categories_<?= $module_id; ?>").slick({
          dots: true,
          infinite: false,
          speed: 300,
          arrows:false,
          slidesToShow: 2,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1201,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 993,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 769,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 541,
              settings: {
                slidesToShow: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            },
            {
              breakpoint: 415,
              settings: {
                slidesToShow: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            },
            {
              breakpoint: 376,
              settings: {
                slidesToShow: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            }
          ],
          prevArrow: "<div class='pointer slick-nav left prev absolute'><div class='absolute position-center-center'><i class='fa fa-chevron-left fa-2em'></i></div></div>",
          nextArrow: "<div class='pointer slick-nav right next absolute'><div class='absolute position-center-center'><i class='fa fa-chevron-right fa-2em'></i></div></div>",
        });
      });
</script>

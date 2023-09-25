<h2 class="main-heading">
  <?php echo $main_title; ?>
</h2>
<div class="logo-slider">
  <?php foreach ($items as $item) { ?>
    <div class="item">
      <img src="image/<?php echo $item['image']; ?>" class="img-responsive"/>
    </div>
  <?php } ?>
</div>


<script>
    jQuery(document).ready(function ($) {
          $(".logo-slider").slick({
          dots: true,
          infinite: false,
          speed: 300,
          arrows:false,
          slidesToShow: 6,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1401,
              settings: {
                slidesToShow: 5,
              }
            },
            {
              breakpoint: 1201,
              settings: {
                slidesToShow: 4,
              }
            },
            {
              breakpoint: 993,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 769,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 541,
              settings: {
                slidesToShow: 2,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            },
            {
              breakpoint: 415,
              settings: {
                slidesToShow: 2,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000
              }
            },
            {
              breakpoint: 376,
              settings: {
                slidesToShow: 2,
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

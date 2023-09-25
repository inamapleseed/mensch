<div id="slideshow<?= $module; ?>" class="relative owl-carousel"  style="opacity: 1; width: 100%;">
  <?php foreach ($banners as $banner) { ?>
    <div class="relative <?= $banner['theme']; ?> <?=$banner['video'] != 'Video File' ?'video-banner':'';?> h100">
      <?php if( $banner['video'] != 'Video File' ){ ?>
        <div class="banner-video-container" style="display:none;">
          <video preload="none" autoplay muted playsinline loop>
              <source src="image/<?= $banner['video'] ?>" type="video/mp4">
              <source src="image/<?= $banner['video'] ?>" type="video/mov">
              <source src="image/<?= $banner['video'] ?>" type="video/avi">
          </video>
        </div>
        <?php if( $banner['mobile_video'] != 'Video File' ){ ?>
        <div class="mobile_banner-video-container" style="display:none;">
          <video preload="none" autoplay muted playsinline loop>
              <source src="image/<?= $banner['mobile_video'] ?>" type="video/mp4">
              <source src="image/<?= $banner['mobile_video'] ?>" type="video/mov">
              <source src="image/<?= $banner['mobile_video'] ?>" type="video/avi">
          </video>
        </div>
        <?php } ?>
      <?php } else { ?>

        <img data-src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>" class="img-responsive hidden-xs owl-lazy" />
        <img data-src="<?= $banner['mobile_image']; ?>" alt="<?= $banner['title']; ?>" class="img-responsive visible-xs owl-lazy" />      
      <?php } ?>

      <?php if( $banner['video'] == 'Video File' ){ ?>
        <?php if($banner['description']){ ?>
          <div class="slider-slideshow-description w100 absolute position-center-center background-type-<?= $banner['theme']; ?>">
            <div class="container">
              <div class="slider-slideshow-description-texts">
                <div class="line"></div>
                <?= $banner['description']; ?>

                <?php if ( $banner['link'] && $banner['link_text'] ) { ?>
                <div class="slider-slideshow-description-link">
                  <a href="<?= $banner['link']; ?>" class="btn btn-primary">
                    <?= $banner['link_text']; ?>
                  </a>
                </div>
                <!--class:slider-slideshow-description-link-->
                <?php } ?>
              </div>
              <!--class:slider-slideshow-description-texts-->
            </div>
            <!--class:container-->
          </div>
          <!--class:slider-slideshow-description-->
        <?php } ?>
        
        <?php if($banner['link']){ ?>
          <a href="<?= $banner['link']; ?>" class="block absolute position-left-top w100 h100"></a>
        <?php } ?>
      <?php } ?>
      <div class="banner-overlay"></div>
    </div>
  <?php } ?>
</div>
<?php //include('slideshow_script_slick.tpl'); ?>
<?php include('slideshow_script_owl.tpl'); ?>
<style>
  .banner-video-container video {
    height: calc((<?=$parallax_margin;?> / 19.2) * 1vw);
  }
  @media (max-width: 767px){
          .banner-video-container video {
              height: calc((<?=$mobile_parallax_margin;?> /7.67) * 1vw)!important;
          }
        }
</style>
<?php if($config_parallax_slider) { ?>
  <style>
        body .section-space.slideshow +  .section-space{
            margin-top: calc((<?=$parallax_margin;?> /19.2) * 1vw);
        }
        @media (max-width: 991px){
          
         body .section-space.slideshow +  .section-space{
              margin-top: 0!important;
          }
        }
  </style>
  <?php } ?>
<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="gallery_<?=$gallery_layout;?> <?php echo $class; ?>">
      <?php echo $content_top; ?>
      <?php echo $content_bottom; ?>
      <h2><?php echo $heading_title; ?></h2>
        <div class="gallery-content">

          <?php if(isset($gallalbums) && $gallalbums) { ?>
            <!-- <ul class="nav custom-tabs pd-b40 gallery-cat flex-wrap flex flex-hcenter flex-vcenter">
              <?php $tab_count = 0;?>
              <?php foreach($gallalbums as $cat) { ?>
                <li class="cat m-b-md <?=$cat['gallimage_id'] == $cat_id ? 'active': ''?>"> 
                  <a href="<?=$cat['cat_link'];?>"><?=$cat['name'];?></a>
                </li>
               <?php } ?>
            </ul> -->

            <div class="galleries flex gutter-row four-col-row">
                <?php foreach($gallalbums as $cat) { ?>
                  <div class="gutter">
                    <div class="gallery posrel transition"  data-toggle="modal" data-target="#GalleryPopup-<?=$cat['gallimage_id'];?>" style="background:url('<?=$cat['featured_image'];?>'); background-color: #fff;">

                      <h4 class="overlay transition gallery-title text-center text-uppercase"><?=$cat['name'];?></h4>
                    </div>
                  </div>
                 <?php } ?>
            </div>

            <!-- galley popups -->
            <div class="gallery-popups">
              <?php foreach($gallalbums as $cat) {?>
                <!-- Modal -->
                <div class="modal fade" id="GalleryPopup-<?=$cat['gallimage_id'];?>" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body">
                        <div class=" modal-close-button close" data-dismiss="modal"></div>
                        <h4 class="gallery-title text-center text-uppercase"><?=$cat['name'];?></h4>
                          <div class="popup-gallery image">
                            <div class="main pd-b20">
                              <?php foreach($cat['gallalbum'] as $gall) {?>
                                <img src="<?=$gall['ori_image'];?>" class="img-responsive"/>
                              <?php } ?>
                            </div>
                            <div class="thumb">
                              <?php foreach($cat['gallalbum'] as $gall) { ?>
                                <img src="<?=$gall['ori_image'];?>" class="img-responsive"/>
                              <?php } ?>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>

              <script>
                $('#GalleryPopup-<?=$cat['gallimage_id'];?>').on('shown.bs.modal', function () {   
                    $('.popup-gallery .main').slick('refresh');
                    $('.popup-gallery .thumb').slick('refresh');
                });
              </script>
               <?php } ?>
           </div>
          <?php } else { ?>
            <div class="flex flex-vcenter flex-hcenter text-center">
              No Gallery Found
            </div>
          <?php } ?>
        </div>

      <script>
          $('#GalleryPopup').on('shown.bs.modal', function () {   
              $('.popup-gallery .main').slick('refresh');
              $('.popup-gallery .thumb').slick('refresh');
          });

          jQuery(document).ready(function ($) {
            $('.popup-gallery .main').slick({
                  slidesToShow: 1,
                  // lazyLoad: 'ondemand',
                  slidesToScroll: 1,
                  arrows: true,
                  fade: true,
                  adaptiveHeight: true,
                  infinite: false,
                  asNavFor: '.popup-gallery .thumb',
                  prevArrow: "<div class='pointer slick-nav left prev'><i class='fa fa-angle-left'></div>",
                  nextArrow: "<div class='pointer slick-nav right next'><i class='fa fa-angle-right'></div>",
              });
  
              $('.popup-gallery .thumb').slick({
                  slidesToShow: 4,
                  // lazyLoad: 'ondemand',
                  slidesToScroll: 1,
                  asNavFor: '.popup-gallery .main',
                  dots: false,
                  centerMode: false,
                  arrows:false,
                  focusOnSelect: true,
                  infinite: false,
                  prevArrow: "<div class='pointer slick-nav left prev'><i class='fa fa-angle-left'></div>",
                  nextArrow: "<div class='pointer slick-nav right next'><i class='fa fa-angle-right'></div>",
                  responsive: [
                  {
                      breakpoint: 767,
                      settings: {
                          slidesToShow: 3,
                          slidesToScroll: 5,
                      }
                  },
                  ]
              });
          });
      </script>
    </div>
    <?php echo $column_right; ?>
  
  
  </div>
</div>
<?php echo $footer; ?> 
<?php echo $header; ?>
<div class="<?php if(isset($article_inner_layout)) {?> article_inner_<?=$article_inner_layout;?> <?php } else { ?> article_listing_<?=$article_listing_layout;?> <?php } ?><?php if($show_sidebar) { ?> article-with-sidebar<?php } ?>">  
  <div class="container">
    <?php echo $content_top; ?>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $i => $breadcrumb) { ?>
      <li  data-aos="flip-up" data-aos-delay="<?php echo $i+2 . '00'; ?>"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
    <h2 data-aos="flip-up" data-aos-delay="200">Blog</h2>
    <div class="row">
      <?php if($show_sidebar) { ?>
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
          <?php $class = 'col-sm-6'; ?>
          <?php } elseif ($column_left || $column_right) { ?>
          <?php $class = 'col-sm-9'; ?>
          <?php } else { ?>
          <?php $class = 'col-sm-12'; ?>
          <?php } ?>
      <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div id="content" class="<?php echo $class; ?>">
        <?php echo $description; ?></div>
      <?php echo $column_right; ?></div>
      <?php echo $content_bottom; ?>
  </div>
</div>
<?php echo $footer; ?> 
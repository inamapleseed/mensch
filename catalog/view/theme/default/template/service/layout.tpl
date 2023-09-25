<?php echo $header; ?>
<?php if(isset($article_listing_layout)) { ?>
  <?php $layout = $article_listing_layout; ?>
<?php }else if(isset($article_inner_layout)) { ?>
  <?php $layout = $article_inner_layout;  ?>
  <?php } ?>
<div class="service_<?=$layout;?> <?php if(isset($left_right_column) && $left_right_column ) { ?> left-right-column <?php } ?> <?php if($show_sidebar) { ?> article-with-sidebar<?php } ?>">
  <div class="container">
    <?php echo $content_top; ?>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
    <?php if($show_title) { ?>
    <h2><?php echo $heading_title; ?></h2>
    <?php } ?>
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
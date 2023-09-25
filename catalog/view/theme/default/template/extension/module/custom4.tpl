<div class="custom-container">
  <?php foreach ($repeater as $i => $r): ?>
    <div class="der-box" data-aos="flip-right">
      <a href="<?php echo $r['link']; ?>" class="link"></a>
      <img src="image/<?=$r['image'];?>" alt="image">
      <div class="texts text<?php echo $i; ?>" data-aos="fade-up" data-aos-delay="<?php echo $i+2 . '00'?>">
          <h3><?php echo $r['title']; ?></h3>
          <h5><?php echo html_entity_decode($r['text']); ?></h5>
          <img src="<?php echo $r['color'] == '#fff' ? 'image/catalog/slicings/general/arrow2.png' : 'image/catalog/slicings/general/arrow1.png'; ?>" alt="arrow">
      </div>
    </div>
    <style>
      .der-box .text<?php echo $i; ?> * {
        color: <?php echo $r['color']; ?> !important;
      }
    </style>
    <?php if($r['color'] == '#fff'): ?>
      <style>
        @media (max-width: 767px) {
          .text<?php echo $i; ?> {
            text-shadow: 1px 1px 0 #000;
          }
        }
      </style>
    <?php endif ?>
  <?php endforeach ?>
</div>

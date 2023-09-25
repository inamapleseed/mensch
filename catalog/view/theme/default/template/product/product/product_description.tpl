<h3 class="product-title"><?= $product_name; ?></h3>
<?php /* ?>
<ul class="list-unstyled">
  <?php if ($manufacturer) { ?>
  <li><?= $text_manufacturer; ?> <a href="<?= $manufacturers; ?>"><?= $manufacturer; ?></a></li>
  <?php } ?>
  <li><?= $text_model; ?> <?php echo "<font id='product_model'>".$model."</font>"; // <- Related Options / Связанные опции ?></li>
  <?php if ($reward) { ?>
  <li><?= $text_reward; ?> <?= $reward; ?></li>
  <?php } ?>
  <li><?= $text_stock; ?> <?php echo "<font id='product_stock'>".$stock."</font>"; // <- Related Options / Связанные опции  ?></li>
</ul>
<?php */ ?>
<?php /* completecombo */ ?>
<?php if (isset($salescombopgeoffers)) {  
  foreach($salescombopgeoffers as $offer) { 
    echo html_entity_decode($offer['html']); 
  } 
} ?>
<?php /* completecombo */ ?>
<?php if ($price && !$enquiry) { ?>
<ul class="list-unstyled price-wrapper">
  <?php if (!$special) { ?>
  <li>
    <div class="product-price old-prices" ><?= $price; ?></div>
  </li>
  <?php } else { ?>
  <li><span class="product-special-price new-prices"><?= $special; ?></span><span style="text-decoration: line-through;" class="old-prices"><?= $price; ?></span></li>
  <li>
    <?php if($special && $special_end != "0000-00-00"){ ?>
        <div class="product_countdown_box">
            Promotion Ending in: 
            <div class="countdown_day<?= $product_id; ?>"></div>
            <div class="countdown_hour<?= $product_id; ?>"></div>
            <div class="countdown_minute<?= $product_id; ?>"></div>
            <div class="countdown_second<?= $product_id; ?>"></div>
            <!--<p class="countdown<?= $product_id; ?>"></p>-->
        </div>
        <script>
            // Set the date we're counting down to
            var countDownDate<?= $product_id; ?> = new Date("<?= date("M d, Y H:i:59",strtotime($special_end." ".$special_end_time)); ?>").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

              // Get today's date and time
              var now = new Date().getTime();

              // Find the distance between now and the count down date
              var distance = countDownDate<?= $product_id; ?> - now;

              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              //hours += days * 24;

              // Output the result in an element with id="demo"
              $(".countdown_day<?= $product_id; ?>").html(days+"<div>Days</div>");
          //   if(days == 0){
          //       $(".countdown_day<?= $product_id; ?>").css('display','none');
          //   }
            $(".countdown_hour<?= $product_id; ?>").html(hours+"<div>Hrs</div>");
            $(".countdown_minute<?= $product_id; ?>").html(minutes+"<div>Mins</div>");
            $(".countdown_second<?= $product_id; ?>").html(seconds+"<div>Secs</div>");
          //   $(".countdown<?= $product_id; ?>").html("<i></i>"+hours + " : " + minutes + " : " + seconds);

              // If the count down is over, write some text 
              if (distance < 0) {
                clearInterval(x);
                $(".countdown<?= $product_id; ?>").html("EXPIRED");
              }
            }, 1000);
        </script>
    <?php } ?>
  </li>
  <?php } ?>
  <?php if ($tax) { ?>
    <li class="product-tax-price product-tax" ><?= $text_tax; ?> <?= $tax; ?></li>
  <?php } ?>
  <?php if ($points) { ?>
    <li><?= $text_points; ?> <?= $points; ?></li>
  <?php } ?>
  <?php if ($discounts) { ?>
    <li>
      <hr>
    </li>
  <?php foreach ($discounts as $discount) { ?>
    <li><?= $text_buy; ?><?= $discount['quantity']; ?><?= $text_discount; ?><?= $discount['price']; ?></li>
  <?php } ?>
  <?php } ?>
</ul>
<?php } ?>

<?php if($enquiry){ ?>
  <div class="enquiry-block">
      <?= $text_enquiry_item; ?>
  </div>
<?php } ?>

<?php if($description){ ?>
  <div class="product-description" style="<?php echo $description ? 'pd-b20' : '';?>">
    <?= $description; ?>
  </div>
<?php } ?>

<?php if($inner_layout == 2){ ?>
  <?php include_once('product_attributes_reviews.tpl'); ?>
<?php } ?>

<?php include_once('product_options.tpl'); ?>


<?php if ($review_status) { ?>
  <div class="rating">
    <p>
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($rating < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
      <?php } ?>
      <?php } ?>
      <a href="javascript:;" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?= $reviews; ?></a> / <a href="javascript:;" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?= $text_write; ?></a></p>
  </div>
<?php } ?>
<?= $waiting_module; ?>

<script>
    $("p").each(function(){
      if($(this).find('br').length)
      $(this).remove();
    });
</script>
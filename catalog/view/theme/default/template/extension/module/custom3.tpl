<div class="compare-con">
  <h2><?php echo $title; ?></h2>

  <div class="selections-con">
    <div class="input-btn-con btn btn-primary enable-select3 ghost" style="margin-left: 20px; opacity: 0; pointer-events: none">
      <div>Add Another</div>
      <span>></span>
    </div>

    <select id="model-select1" class="form-control">
      <option disabled selected >Select a Product</option>
      <?php foreach($product_w_specs as $prods): ?>
        <option value="#a_id_<?php echo $prods['product_id']; ?>">
          <?php echo $prods['name']; ?>
        </option>
      <?php endforeach ?>
    </select>

    <h3>VS</h3>

    <select id="model-select2" class="form-control">
      <option disabled selected >Select a Product</option>
      <?php foreach($product_w_specs as $prods): ?>
        <option value="#b_id_<?php echo $prods['product_id']; ?>">
          <?php echo $prods['name']; ?>
        </option>
      <?php endforeach ?>
    </select>

    <div class="input-btn-con btn btn-primary enable-select3" style="margin-left: 20px">
      <div>Add Another</div>
      <span>></span>
    </div>

    <h3 class="select3">VS</h3>

    <select id="model-select3" class="form-control select3">
      <option disabled selected >Select a Product</option>
      <?php foreach($product_w_specs as $prods): ?>
        <option value="#c_id_<?php echo $prods['product_id']; ?>">
          <?php echo $prods['name']; ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="output-container">
    <div class="products-to-compare-a products-to-compare">
      <?php foreach($specs2 as $i => $specs): ?>
        <div class="specs-con">
            <h4><?= $specs[0]['name'] ?></h4>
            <img src="image/<?= $specs[0]['image'] ?>" alt="<?= $specs[0]['name'] ?>" class="img-responsive">
          <?php foreach($specs as $spec): ?>
            <div data-id="<?php echo $spec['product_id']; ?>">
                  
              <h5><?php echo $spec['title']; ?></h5>
              <div class="">
                  
                  <?php 
                    if($spec['include'] == "1"){
                        echo "<img src='image/catalog/slicings/shop/check_22x16.png' alt='indicator'>";
                    }else if($spec['include'] == "0"){
                        echo '<div class="cross-mark">&times;</div>';
                    }else if($spec['include'] == "2"){
                        echo "<img src='image/catalog/slicings/shop/dash.png' alt='dash'>";
                    }
                    ?>
                    
              </div>

              <?php echo html_entity_decode($spec['dimage']);?>
          </div>
          <?php endforeach ?>
        </div>
      <?php endforeach ?>
    </div>

    <div class="ghost-div ghost1"></div>
    
    <div class="products-to-compare-b products-to-compare">
      <?php foreach($specs2 as $i => $specs): ?>
        <div class="specs-con">
          <h4><?= $specs[0]['name'] ?></h4>
          <img src="image/<?= $specs[0]['image'] ?>" alt="<?= $specs[0]['name'] ?>" class="img-responsive">
          <?php foreach($specs as $spec): ?>
            <div data-id="<?php echo $spec['product_id']; ?>">
              <h5><?php echo $spec['title']; ?></h5>
              <div class="">
                  
                  <?php 
                    if($spec['include'] == "1"){
                        echo "<img src='image/catalog/slicings/shop/check_22x16.png' alt='indicator'>";
                    }else if($spec['include'] == "0"){
                        echo '<div class="cross-mark">&times;</div>';
                    }else if($spec['include'] == "2"){
                        echo "<img src='image/catalog/slicings/shop/dash.png' alt='dash'>";
                    }
                    ?>
              </div>

              <?php echo html_entity_decode($spec['dimage']);?>
          </div>
          <?php endforeach ?>
        </div>
      <?php endforeach ?>
    </div>

    <div class="ghost-div ghost2"></div>

    <div class="products-to-compare-c products-to-compare">=
      <?php foreach($specs2 as $i => $specs): ?>
        <h4><?= $specs[0]['name'] ?></h4>
        <img src="image/<?= $specs[0]['image'] ?>" alt="<?= $specs[0]['name'] ?>" class="img-responsive">
        <div class="specs-con">
          <?php foreach($specs as $spec): ?>
            <div data-id="<?php echo $spec['product_id']; ?>">
              <h5><?php echo $spec['title']; ?></h5>
              <div class="">
                  <?php 
                    if($spec['include'] == "1"){
                        echo "<img src='image/catalog/slicings/shop/check_22x16.png' alt='indicator'>";
                    }else if($spec['include'] == "0"){
                        echo '<div class="cross-mark">&times;</div>';
                    }else if($spec['include'] == "2"){
                        echo "<img src='image/catalog/slicings/shop/dash.png' alt='dash'>";
                    }
                    ?>
              </div>

              <?php echo html_entity_decode($spec['dimage']);?>
          </div>
          <?php endforeach ?>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

<script>
  // for styling
  $(".ghost1").css('width', "5%");
  $(".ghost2").hide();
  $(".products-to-compare-c").hide();
  $(".output-container").css('justify-content','center');
  let width = $(window).width();
  if(width < 768){
    $(".products-to-compare").css('width','50%');
  }
  // end styling

  // hide select 3 in default
  $(".select3").hide();
  // 

  // click add another then show select3
  $(".enable-select3").click(function(){
    $(".select3").fadeIn("slow").show();
    $('.enable-select3').hide();

    // for styling
    $(".ghost-div").css('width', '5%');
    $(".products-to-compare-c").show();
    $(".ghost2").show();
    if(width < 768){
      $(".products-to-compare").css('width','33%');
    }
    // end styling
  })
  // end show select3
  
  // hide all in default
  $(".specs-con").hide();

  // add product id to specs parent con
  // selection A
  $(".products-to-compare-a > div > div:first-of-type").each(function(){
    var id = $(this).data('id');
    $(this).parent().attr("id", 'a_id_' + id);
  });
  // selection B
  $(".products-to-compare-b > div > div:first-of-type").each(function(){
    var id = $(this).data('id');
    $(this).parent().attr("id", 'b_id_' + id);
  });
  // selection C
  $(".products-to-compare-c > div > div:first-of-type").each(function(){
    var id = $(this).data('id');
    $(this).parent().attr("id", 'c_id_' + id);
  });

  // show selected value
  // output A
  $("#model-select1").on('change', function(){
    $(".products-to-compare-a .specs-con.active").hide();
    $(".products-to-compare-a .specs-con.active").removeClass('active');

    let target = $(this).val();
    $(target).fadeIn("slow").show();
    $(target).addClass('active');

  })
  // output B
  $("#model-select2").on('change', function(){
    $(".products-to-compare-b .specs-con.active").hide();
    $(".products-to-compare-b .specs-con.active").removeClass('active');

    let target = $(this).val();
    $(target).fadeIn("slow").show();
    $(target).addClass('active');
  })
  // output C
  $("#model-select3").on('change', function(){
    $(".products-to-compare-c .specs-con.active").hide();
    $(".products-to-compare-c .specs-con.active").removeClass('active');

    let target = $(this).val();
    $(target).fadeIn("slow").show();
    $(target).addClass('active');
  })
</script>

<script>
  $("p").each(function(){
    if($(this).find('br').length)
     $(this).remove();
    });
</script>
<?php if($display_search) { ?>
  <?php if($popup_search) { ?>  
    <div class="dropdown-search hidden-xs hidden-sm">
      <a href="#" data-toggle="dropdown">
        
    <img src="image/catalog/slicings/general/search_27x27.png" alt="cart" class="wyimg">
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
        <div class="search-custom">
          <div class='search-box'>
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control" />
            <button type="button"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </ul>
    </div>
    <div class="search-custom visible-sm visible-xs">
      <div class='search-box'>
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control" />
        <button type="button"><i class="fa fa-search"></i></button>
      </div>
    </div>
  <?php }elseif($searchbar) { ?>
    <div class="search-custom">
      <div class='search-box'>
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control" />
        <button type="button"><i class="fa fa-search"></i></button>
      </div>
    </div>
  <?php } ?>
<?php } ?>

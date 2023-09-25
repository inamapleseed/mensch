<?php if ($modules) { ?>
  <aside id="column-left" class="col-sm-<?php if(($category_layout == '2' || $category_layout == '3') && $route == 'product/category'){echo "12";}else{echo "3";} ?>">
    <?php foreach ($modules as $module) { ?>
    <?php echo $module; ?>
    <?php } ?>
  </aside>
<?php } ?>

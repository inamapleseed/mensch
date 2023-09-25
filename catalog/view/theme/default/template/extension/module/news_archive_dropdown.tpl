<!-- <button id="articles-filter-trigger-open" class="btn btn-primary" onclick="$('#articles-column-left').addClass('open');" ><?= $button_filter; ?></button> -->
<div class="flex flexArchive flex-hcenter">
	<!-- <button id="articles-filter-trigger-close" class="btn btn-danger fixed position-right-top" onclick="$('#articles-column-left').removeClass('open');"> <i class="fa fa-times"></i> </button> -->
	<div class="list-group created-date">
		<?php $index = 0; ?>
		<select id="newsArchive">
			<option value="" selected="selected" disabled hidden>Created Date</option>
			<?php foreach ($archives as $archive) { ?>
				<?php $index++ ?>
				<?php foreach ($archive['month'] as $month) { ?> 
					<option value="<?php echo $month['href']; ?>"><?php echo $month['name']; ?> <?= $archive['year'];?></option>
				<?php } ?>
			<?php } ?>
		</select>
	</div>
	<div class="list-group sort-date">
		<?php $index = 0; ?>
		<select id="newsArchive">
			<option value="<?= $default; ?>" <?php if($sorted == '') { echo "selected"; } ?> hidden>Sort By</option>
			<option value="<?= $latest; ?>" <?php if($sorted == 'DESC') { echo "selected"; } ?>>Sort By Latest</option>
			<option value="<?= $oldest; ?>" <?php if($sorted == 'ASC') { echo "selected"; } ?>>Sort By Oldest</option>
		</select>
	</div>
	<div class="list-group news-ctgr">
		<select id="newsCat">
			<option value="<?= $catdefault; ?>" <?php if($cat == '') { echo "selected"; } ?> hidden>Category</option>
			<?php foreach($ncategories as $c) { ?>
				<option value="<?= $c['href'] ?>" <?php if($cat == $c['ncategory_id']) { echo "selected"; }; ?>><?= $c['name'] ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	/*
	$('.hidesthemonths').on('click', function () {
		$(this).find('div').slideToggle('fast');
	});
	*/

	$('#articles-column-left .toggle').on('click', function(e){
	
		e.preventDefault();
		ele = $(this).parents('.list-group-item');
		
		if(ele.hasClass('active')){
			ele.removeClass('active');
		}
		else{ 
			if(ele.hasClass('.level-1')){
				$('.level-1.active').removeClass('active');
			}
			else if(ele.hasClass('.level-2')){
				$('.level-2.active').removeClass('active');
			}
			
			ele.addClass('active');
		}
	});

});
</script>
<script>
    $(function(){
      // bind change event to select
      $('#newsCat').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
	  });
	  
	//   if (localStorage.getItem('newsCat')) {
    //     $("#newsCat option").eq(localStorage.getItem('newsCat')).prop('selected', true);
	//    }
	   $("#newsCat").on('change', function() {
			localStorage.setItem('newsCat', $('option:selected', this).index());
		});
    });
</script>
<script>
    $(function(){
      // bind change event to select
      $('#newsArchive').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
	  });
	  
	//   if (localStorage.getItem('newsArchive')) {
    //     $("#newsArchive option").eq(localStorage.getItem('newsArchive')).prop('selected', true);
	//    }
	   $("#newsArchive").on('change', function() {
			localStorage.setItem('newsArchive', $('option:selected', this).index());
		});
    });
</script>
<div id="footer-area">
<?php 
	// Please get license key for this mailchimp extension before use it thanks
	/*if($mailchimp){ ?>
	<div class="newsletter-section text-center">
		<?= $mailchimp; ?>
	</div>
<?php }*/ ?>
<!--xml strat-->
<div class="modal modal-wide fade" id="help-modal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>      
<script>
function tmdFormPopup(formid) {
tmdhref = '<?php echo $common_pop; ?>';
var href = tmdhref+formid;
$('#help-modal2 .modal-content').html('<div class="loader-if centered"></div>');
$('#help-modal2').load(href);
}       
</script> 

<style type="text/css">
	.modal.modal-wide .modal-dialog {
	width: 50%;
	}
</style>
<!--xml end-->

<div class="locate-con">
	<div class="texts" style="background: <?php echo $config_footer_background_color2; ?>">
		<div>
			<h3>LOCATE US</h3>
			<div class="<?php echo $address ? '' : 'hidden'; ?>">
				Address: <br>
				<address><?php echo nl2br($address); ?></address>
			</div>
			<div class="<?php echo $telephone ? '' : 'hidden'; ?>">
				Contact No.: <br>
				<a href="tel:<?php echo $telephone; ?>"><?php echo $telephone; ?></a>
				<br>
			</div>
			<div class="<?php echo $open ? '' : 'hidden'; ?>">
				Office Hours: <span><?php echo $open; ?></span>
				<br>
			</div>
			<div class="<?php echo $whatsapp ? '' : 'hidden'; ?>">
				<br>
				WhatsApp: <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>"><?php echo $whatsapp; ?></a>
				<br>
			</div>
		</div>
	</div>
	<div class="maps"><?php echo $gmap_iframe; ?></div>
</div>
<style>
	.locate-con .texts * {
		color: <?php echo $config_footer_color2; ?> !important;
	}
</style>
<footer>

	<?php include_once('global_style.tpl'); ?>

	<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<link href="catalog/view/javascript/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" />

	<link href="catalog/view/theme/default/stylesheet/sass/mystylesheet.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Exo:wght@300;400;500&family=Lato:ital,wght@0,300;0,400;1,400&display=swap" rel="stylesheet">
	<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">

	<link href="catalog/view/theme/default/stylesheet/base.css" rel="stylesheet">

	<?php /* // combined to combined.min.css ?>
	<!-- <link href="catalog/view/javascript/smartmenus/sm-core-css.min.css" rel="stylesheet"> --> <!--Added in sidr_bare_sm_core_css_sass_icon.css -->
	<link href="catalog/view/javascript/smartmenus/sm-blue.min.css" rel="stylesheet">
	<!-- <link href="catalog/view/javascript/side-menu-sidr/stylesheets/sidr.bare.min.css" rel="stylesheet"> --> <!--Added in sidr_bare_sm_core_css_sass_icon.css -->
	<link href="catalog/view/javascript/jquery-multi-level-accordion-menu/css/style.min.css" rel="stylesheet">

	<link href="catalog/view/theme/default/stylesheet/normalize.min.css" rel="stylesheet">
	<!-- <link href="catalog/view/theme/default/stylesheet/sass/icon.min.css" rel="stylesheet"> --> <!--Added in sidr_bare_sm_core_css_sass_icon.css -->
	<link href="catalog/view/theme/default/stylesheet/sidr_bare_sm_core_css_sass_icon.css" rel="stylesheet">

	<link href="catalog/view/javascript/aos/aos.css" rel="stylesheet">

	<link href="catalog/view/javascript/sweetalert2.min.css" rel="stylesheet">
	<?php */ // combined to combined.min.css ?>

	<?php /* seldom use */ /* ?>
	<link href="catalog/view/theme/default/stylesheet/animate.min.css" rel="stylesheet">
	<?php */ ?>

	<link href="catalog/view/theme/default/stylesheet/combined.min.css" rel="stylesheet">

	<link href="catalog/view/theme/default/stylesheet/sass/helper.min.css" rel="stylesheet">
	<link href="catalog/view/theme/default/stylesheet/sass/custom.min.css" rel="stylesheet">
	<link href="catalog/view/theme/default/stylesheet/pagination-breadcrumb.css" rel="stylesheet">

	<?php if($class != 'common-home') { ?>
	<link href="catalog/view/theme/default/stylesheet/slsoffr.min.css" rel="stylesheet">
	<?php } ?>

	<?php foreach ($styles as $style) { ?>
		<link href="<?=$style['href']; ?>" type="text/css" rel="<?=$style['rel']; ?>" media="<?=$style['media']; ?>" />
	<?php } ?>

	<script defer="defer" src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.3.0/dist/lazyload.min.js"></script>
	<script>
	$(window).load(function() {
		var lazyLoadInstance = new LazyLoad({
		// Your custom settings go here
		});
	});
	</script>

	<div class="footer-upper-row">
		<div class="container">
			<div class="footer-upper-contet">
				<div class="footer-contact-info">
					<h5 class="storename"><?= $store; ?></h5>
					<p><?php echo $comment; ?></p>
				</div>

				<?php if ($menu) { ?>
					<?php foreach($menu as $menu_count => $links){ ?>
					<div class="footer-contact-links">
						<h5>
							<?php if($links['href'] == '#' || $links['href'] == 'javascript:;'){ ?>
							<?= $links['name']; ?>
							<?php }else{ ?>
							<a href="<?= $links['href']; ?>" 
								<?php if($links['new_tab']){ ?>
									target="_blank"
								<?php } ?>
								>
								<?= $links['name']; ?></a>
							<?php } ?>
						</h5>
						<?php if($links['child']){ ?>
						<ul class="list-unstyled">
							<?php foreach ($links['child'] as $each) { ?>
							<li><a href="<?= $each['href']; ?>"
								<?php if($each['new_tab']){ ?>
									target="_blank"
								<?php } ?>
								
								>
									<?= $each['name']; ?></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
						<!-- <?php if($menu_count == (count($menu) - 1)){ 
							echo $mailchimp; 
						} ?> -->
					</div>
					<?php } ?>
				<?php } ?>

				<div class="footer-socmed">
					<h5>Connect With Us</h5>
					<?php if($social_icons){ ?>
						<div class="footer-social-icons">
							<?php foreach($social_icons as $icon){ ?>
							<a href="<?= $icon['link']; ?>" title="<?= $icon['title']; ?>" alt="
										<?= $icon['title']; ?>" target="_blank">
								<img data-src="<?= $icon['icon']; ?>" title="<?= $icon['title']; ?>" class="img-responsive lazy" alt="<?= $icon['title']; ?>" />
							</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
							
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<p><?= $powered; ?></p>
				</div>
				<div class="col-xs-12 col-sm-6 text-sm-right">
					<p><?= $text_fcs; ?></p>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>
<div id="ToTopHover"></div>


<?php if($live_search_ajax_status){ ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/live_search.css" />
<script type="text/javascript"><!--
	var live_search = {
		selector: '.search-box input[name=\'search\']',
		text_no_matches: 'There is no product that matches the search criteria.',
		height: '<?= (int)$live_search_image_height + 10; ?>px'
	}
	
	$(document).ready(function() {
		var html = '';
		html += '<div class="live-search">';
		html += '	<ul>';
		html += '	</ul>';
		html += '<div class="result-text"></div>'; 
		html += '</div>';
		
		//$(live_search.selector).parent().closest('div').after(html);
		$(live_search.selector).after(html);
		
		$(live_search.selector).autocomplete({
			'source': function(request, response) { 
				var filter_field = $('.search-box input[name=\'search\']');
				var live_search_min_length = '<?= (int)$live_search_min_length; ?>';
				var filter_name = "";
				$(filter_field).each(function(){
					if($(this).val() != ""){
						filter_name = $(this).val();
					}
				});
				if (filter_name.length < live_search_min_length) {
					$('.live-search').css('display','none');
				}else{
					var html = '';
					html += '<li style="text-align: center;height:10px;">';
					html +=	'<img class="loading" src="catalog/view/theme/default/image/loading.gif" />';
					html +=	'</li>';
					$('.live-search ul').html(html);
					$('.live-search').css('display','block');
					
					$.ajax({
						url: 'index.php?route=product/live_search&filter_name=' +  encodeURIComponent(filter_name),
						dataType: 'json',
						success: function(result) {
							var products = result.products;
							$('.live-search ul li').remove();
							$('.result-text').html('');
							if (!$.isEmptyObject(products)) {
								var show_image = <?= $live_search_show_image;?>;
								var show_price = <?= $live_search_show_price;?>;
								var show_description = <?= $live_search_show_description;?>;
								$('.result-text').html('<a href="<?= $live_search_href;?>'+filter_name+'" class="view-all-results"><?= $text_view_all_results;?> ('+result.total+')</a>');
								
								$.each(products, function(index,product) {
									var html = '';
									
									html += '<li>';
									html += '<a href="' + product.url + '" title="' + product.name + '">';
									if(product.image && show_image){
										html += '	<div class="product-image"><img alt="' + product.name + '" src="' + product.image + '"></div>';
									}
									html += '	<div class="product-name">' + product.name ;
									if(show_description){
										html += '<p>' + product.extra_info + '</p>';
									}
									html += '</div>';
									if(show_price){
										if (product.special) {
											html += '	<div class="product-price"><span class="special">' + product.price + '</span><span class="price">' + product.special + '</span></div>';
											} else {
											html += '	<div class="product-price"><span class="price">' + product.price + '</span></div>';
										}
									}
									html += '<span style="clear:both"></span>';
									html += '</a>';
									html += '</li>';
									$('.live-search ul').append(html);
								});
								} else {
									var html = '';
									html += '<li style="text-align: center;height:10px;white-space: normal;">';
									html +=	live_search.text_no_matches;
									html +=	'</li>';
									
									$('.live-search ul').html(html);
								}
							$('.live-search ul li').css('height',live_search.height);
							$('.live-search').css('display','block');
							$('.live-search ul').css('margin-bottom','0px');
							return false;
						}
					});
				}
			},
			'select': function(product) {
				$(live_search.selector).val(product.name);
			}
		});
		
		$(document).bind( "mouseup touchend", function(e){
			var container = $('.live-search');
			if (!container.is(e.target) && container.has(e.target).length === 0)
			{
				container.hide();
			}
		});
	});
//--></script>
<?php } ?>

<?php if(isset($update_price_status) && $update_price_status) { ?>
	<script type="text/javascript">
    $(".product-inputs input[type='checkbox']").click(function() {
      var product_id = $(this).data('product-id');
      changePrice(product_id);
    });
    $(".product-inputs input[type='radio']").click(function() {
      var product_id = $(this).data('product-id');
      changePrice(product_id);
    });
    $(".product-inputs select").change(function() {
      var product_id = $(this).data('product-id');
      changePrice(product_id);
    });
    $(".product-inputs .input-number").blur(function() {
      var product_id = $(this).data('product-id');
      changePrice(product_id);
    });
    $(".product-inputs .input-number").parent(".input-group").find(".btn-number").click(function() {
      var product_id = $(this).data('product-id');
      changePrice(product_id);
    });
    function changePrice(product_id) {
      $.ajax({
        url: 'index.php?route=product/product/updatePrice&product_id=' + product_id,
        type: 'post',
        dataType: 'json',
        data: $('#product-'+ product_id + ' input[name=\'quantity\'], #product-'+ product_id + ' select, #product-'+ product_id + ' input[type=\'checkbox\']:checked, #product-'+ product_id + ' input[type=\'text\'], #product-'+ product_id + ' input[type=\'radio\']:checked'),
        success: function(json) {
          $('.alert-success, .alert-danger').remove();
          if(json['new_price_found']) {
            $('.product-price-'+product_id+' .price .price-new').html(json['total_price']);
            $('.product-price-'+product_id+' .price .price-tax').html(json['tax_price']);
          } else {
            $('.product-price-'+product_id+' .price .price-new').html(json['total_price']);
            $('.product-price-'+product_id+' .price .price-tax').html(json['tax_price']);
          }
        }
      });
    }
	</script>
<?php } ?>
<script>
	$(window).load(function(){
		AOS.init({
			once: true
		});
	});
</script>

<script>
    <?php /* Persisting any click IDs */ ?>
    if (typeof(Storage) !== "undefined") {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        for (const [key, value] of urlParams) {
            window.localStorage.setItem(key, value);
        }
        <?php /* Uncomment this to see contents of localStorage */ ?>
        for(let i=0; i<localStorage.length; i++) {
            let key = localStorage.key(i);
            //console.log(`${key}: ${localStorage.getItem(key)}`);
        }
        <?php /* Uncomment this to see contents of localStorage */ ?>
    }
</script>

<?php 
/* extension bganycombi - Buy Any Get Any Product Combination Pack */
echo $bganycombi_module; 
?>
</body></html>
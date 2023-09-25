
  <div class="news-latest-slider m-b-lg">
  	<?php if (!$article && isset($text_search_no_results)) { ?>
  		<h4><?php echo $text_search_no_results; ?></h4>
  	<?php } ?>
    <div id="news_latest" class="bnews-list">
		<?php foreach ($article as $articles) { ?>
			<div class="artblock ">
				<div class="content flex">

					<div class="article-image-wrapper relative hover-overlay">
						<?php if ($articles['thumb']) { ?>
						<a href="<?php echo $articles['href']; ?>">
							<div class="cover-bg transition center-bg pd-b70p" style="background-image:url('<?php echo $articles['thumb']; ?>');"></div>
							<?php /* ?>
							<img class="article-image img-responsive" src="" title="<?php echo $articles['name']; ?>" alt="<?php echo $articles['name']; ?>" />
							<?php */ ?>
						</a>
						<?php } ?>
						<div class="to-overlay">
							<a href="<?php echo $articles['href']; ?>" class="block absolute position-all0">
								<div class="absolute position-center-center colorwhite"><i class="fa fa-search fa-2em"></i></div>
							</a>
						</div>
					</div>
					<div class="info">
						<?php if ($articles['name']) { ?>
							<div class="bold article-name"><a href="<?php echo $articles['href']; ?>"><?php echo $articles['name']; ?></a></div>
						<?php } ?>
						<?php if ($articles['description']) { ?>
							<div class="description m-b-md"><?php echo $articles['description']; ?></div>
						<?php } ?>
						<?php if ($articles['button']) { ?>
							<div class="article-button"><a class="btn btn-primary" href="<?php echo $articles['href']; ?>"><?php echo $button_read_more; ?></a></div>
						<?php } ?>
					</div>
					<div class="hidden">
						<div class="article-meta">
							<?php if ($articles['author']) { ?>
								<?php echo $text_posted_by; ?> <a href="<?php echo $articles['author_link']; ?>"><?php echo $articles['author']; ?></a> |
							<?php } ?>
							
							<?php if ($articles['du']) { ?>
								<?php echo $text_updated_on; ?> <?php echo $articles['du']; ?> |
							<?php } ?>
							<?php if ($articles['category']) { ?>
								<?php echo $text_posted_in; ?> <?php echo $articles['category']; ?> |
							<?php } ?>
						</div>
						<?php if ($articles['thumb']) { ?>
							<a href="<?php echo $articles['href']; ?>"><img class="article-image" align="left" src="<?php echo $articles['thumb']; ?>" title="<?php echo $articles['name']; ?>" alt="<?php echo $articles['name']; ?>" /></a>
						<?php } ?>
						<?php if ($articles['custom1']) { ?>
							<div class="custom1"><?php echo $articles['custom1']; ?></div>
						<?php } ?>
						<?php if ($articles['custom2']) { ?>
							<div class="custom2"><?php echo $articles['custom2']; ?></div>
						<?php } ?>
						<?php if ($articles['custom3']) { ?>
							<div class="custom3"><?php echo $articles['custom3']; ?></div>
						<?php } ?>
						<?php if ($articles['custom4']) { ?>
							<div class="custom4"><?php echo $articles['custom4']; ?></div>
						<?php } ?>
						
						<?php if ($articles['total_comments']) { ?>
						<?php if (!$disqus_status && !$fbcom_status) { ?>
							<div class="total-comments"><?php echo $articles['total_comments']; ?> <?php echo $text_comments; ?> - <a href="<?php echo $articles['href']; ?>#comments"><?php echo $text_comments_v; ?></a></div>
						<?php } elseif ($fbcom_status) { ?>
							<div class="total-comments"><fb:comments-count href="<?php echo $articles['href']; ?>"></fb:comments-count> <?php echo $text_comments; ?> - <a href="<?php echo $articles['href']; ?>#comments"><?php echo $text_comments_v; ?></a></div>
						<?php } else { ?>
							<div class="total-comments"><a data-disqus-identifier="article_<?php echo $articles['article_id']; ?>" href="<?php echo $articles['href']; ?>#disqus_thread"><?php echo $text_comments_v; ?></a></div>
						<?php } ?>
						<?php } ?>
						<?php if ($articles['button']) { ?>
							<div class="blog-button"><a class="button" href="<?php echo $articles['href']; ?>"><?php echo $button_more; ?></a></div>
						<?php } ?>
					</div>
				</div>


			</div>
		<?php } ?>
    </div>
  </div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('img.article-image').each(function(index, element) {
		var articleWidth = $(this).parent().parent().width() * 0.7;
		var imageWidth = $(this).width() + 10;
		if (imageWidth >= articleWidth) {
			$(this).attr("align","center");
			$(this).parent().addClass('bigimagein');
		}
		});
	});
//--></script>
<?php if ($disqus_status) { ?>
<script type="text/javascript">
var disqus_shortname = '<?php echo $disqus_sname; ?>';
(function () {
var s = document.createElement('script'); s.async = true;
s.type = 'text/javascript';
s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>
<?php } ?>
<?php if ($fbcom_status) { ?>
<script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?php echo $fbcom_appid; ?>',
		  status     : true,
          xfbml      : true,
		  version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
</script>
<?php } ?>
<script type="text/javascript">
	$(".news-latest-slider #news_latest").slick({
          dots: true,
          infinite: false,
          speed: 300,
		  arrows:false,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
          ],
          prevArrow: "<div class='pointer slick-nav left prev absolute'><div class='absolute position-center-center'><i class='fa fa-chevron-left fa-2em'></i></div></div>",
          nextArrow: "<div class='pointer slick-nav right next absolute'><div class='absolute position-center-center'><i class='fa fa-chevron-right fa-2em'></i></div></div>",
        });
</script>
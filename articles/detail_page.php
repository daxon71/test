<div class="wrap-detail-news">
	<div class="wrap-detail-img">
		<img src="/articles/foto/<?=$page['id']?>.jpg" alt="">
	</div>
	<div class="detail-news-content">
		<?=$page['content_html']?>
	</div>
	<div class="detail-news-images grid gallery-foto-wrap">
		<?
			if($page['images']!=''){
				foreach (explode(",", $page['images']) as $img) {
				        echo "<a class='grid-item fancybox' data-fancybox='foto' href='/articles/foto/$page[id]-$img.jpg'><img src='/articles/foto/$page[id]-$img.jpg'></a>";
				    }
			}
		?>
	</div>
	<a href="/articles/" class="back-news-btn"><i class="fa fa-chevron-circle-left"></i>Вернуться к списку статей</a>
</div>
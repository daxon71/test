<div class="wrap-detail-news">
	<div class="wrap-detail-img">
		<img src="/news/foto/<?=$page['id']?>.jpg" alt="">
	</div>
	<div class="detail-news-content">
		<?=$page['content_html']?>
	</div>
	<div class="detail-news-images grid gallery-foto-wrap">
		<?
			if($page['images']!=''){
				foreach (explode(",", $page['images']) as $img) {
				        echo "<a class='grid-item fancybox' data-fancybox='foto' href='/news/foto/$page[id]-$img.jpg'><img src='/news/foto/$page[id]-$img.jpg'></a>";
				    }
			}
		?>
	</div>
	<a href="/news/" class="back-news-btn"><i class="fa fa-chevron-circle-left"></i>Вернуться к списку новостей</a>
</div>
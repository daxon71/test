<div class="news-items-wrap bx-slider">
	<?foreach($newsArray = getArray("", "SELECT * FROM articles WHERE visibility!='hidden' ORDER BY date DESC") as $key => $new):?>
		<a data-wow-delay=".<?=$key?>s" href="/articles/<?=$new['url']?>/" class="news-item wow fadeIn">
			<div class="wrap-news-item-img">
				<div class="news-item-img" style="background-image:url(/articles/foto/<?=$new['id']?>.jpg);"></div>
			</div>
			<div class="new-item-title title-bottom-hr"><?=$new['title']?></div>
			<div class="new-item-des"><?=$new['anons']?></div>
		</a>
	<?endforeach;?>
</div>
<div class="news-items-wrap bx-slider">
	<?foreach($newsArray = getArray("", "SELECT * FROM news ORDER BY date DESC") as $key => $new):?>
		<a data-wow-delay=".<?=$key?>s" href="/news/<?=$new['url']?>/" class="news-item wow fadeIn">
			<div class="wrap-news-item-img">
				<div class="news-item-img" style="background-image:url(/news/foto/<?=$new['id']?>.jpg);"></div>
			</div>
			<div class="new-item-title title-bottom-hr"><?=$new['title']?></div>
			<div class="new-item-des"><?=$new['anons']?></div>
		</a>
	<?endforeach;?>
</div>
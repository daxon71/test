<div class="wrap-videos grid">
	<?foreach(getArray("videos") as $v):?>
		<a data-fancybox="video" class="br oh fancybox grid-item video-item" href="https://www.youtube.com/<?=$v[src]?>/">
			<img src="//img.youtube.com/vi/<?=$v[src]?>/maxresdefault.jpg">
			<div class="video-item-title"><?=$v['title']?></div>
		</a>
	<?endforeach;?>
</div>
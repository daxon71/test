<?
include_once "functions.php";
include_once "mysql.php";
if(isDenwer()){
	// ini_set('error_reporting', E_ALL);
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
}

$url = $_GET['url'];
$dir = $_GET['dir'];
$sub_dir = $_GET['sub_dir'];

if(!empty($url)) {
	if($dir=='news' && !empty($url) ){
		$page = getArray("","SELECT * FROM `news` WHERE url='".$url."'");
	}
	elseif($dir=='articles' && !empty($url) ){
		$page = getArray("","SELECT * FROM `articles` WHERE url='".$url."'");
	}
	elseif($url == 'articles' ){
		$page = getArray("","SELECT * FROM `pages` WHERE url='".$url."'");
	}
	else {
	    $page = getArray("","SELECT * FROM `pages` WHERE url='".$url."' AND visibility!='hidden'");
	}
}

if( $error404 = (!is_array($page) && !isHome()) ) {
    header("HTTP/1.0 404 Not Found");
    $page['title'] = 'Ошибка 404: Страница не найдена';
};

$page = $page[0];
isset($page['title']) ? $page['title'] = $page['title'] : $page['title'] = "Федерация спортивной акробатики Тульской области";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=$page['title']?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
	 <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic" rel="stylesheet"> 
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/fotorama/fotorama.css">
	<link rel="stylesheet" href="/bxslider/jquery.bxslider.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet"> 
	<link rel="stylesheet" href="/wow/animate.css">
	<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/fancybox-3.0/jquery.fancybox.min.css">
	<script src="/js/jquery.js"></script>
	<script src="/js/imagesloaded.pkgd.min.js"></script>
	<script src="/js/masonry.pkgd.min.js"></script>
	<script src="/js/scripts.js"></script>
	<script src="/wow/wow.min.js"></script>
	<script src="/fancybox-3.0/jquery.fancybox.min.js"></script>
	<script src="/fotorama/fotorama.js"></script>
	<script src="/js/typed.min.js"></script>
	<script src="/js/slideout.min.js"></script>
	<script src="/bxslider/jquery.bxslider.min.js"></script>
	<style>#freewha {display: none;}</style>
	<?if(isset($_GET['edit'])):?>
	<script>
		$(function(){
			$editEl = $(".classes-table-wrap");
			$editEl.attr('contenteditable', true);

			$(".classes-table-wrap").on("focus", function(){
				prevValue = $(this).html();
			});
			$(".classes-table-wrap").on("blur", function(){
				if(!($(this).html()==prevValue)){
					$.ajax({
						url: '/edit.php',
						type: 'POST',
						data: {id: $(this).parents('.classes-item').data('id'), html:$(this).html()},
					})
					.done(function() {
					})
					.fail(function() {
					})
					.always(function() {
					});
				}
				
			});
		});
	</script>
	<?endif;?>
</head>
<body class="<?if(isHome()) echo "homepage"?>">
	<div id="menu">
		<!-- <div class="close">x</div> -->
	</div>
	<div id="panel">
		<div class="panel-cover"></div>
		<!-- <div class="touch-fix"></div> -->
		<div id="form-main" class="wrap-form" style="display:none;">
			<div class="form-main-title">Отправить сообщение</div>
			<form action="/form.php" method="post">
				<input name="name" required type="text" placeholder="Ваше имя">
				<input name="tel" required type="tel" placeholder="Телефон">
				<input name="mail" type="email" placeholder="E-mail">
				<textarea placeholder="Ваше сообщение или отзыв" name="message" name="" id="" cols="30" rows="2"></textarea>
				<input type="submit" value="Отправить форму">
			</form>
		</div>
		<header class="header">
			<div class="header-sub">
				<div class="container">
					<a class="logo" href="/" title="Федерация спортивной акробатики Тульской области">
						<img src="/img/logo.png">
					</a>
					<div class="sub-wrap">
						<div class="wrap-nav">
							<ul class="nav lvl-1">
							    <?
							    $breadcrumbs = array();
							    addBreadcrumb("/","Главная");
							    ?>
							    <?foreach($categoryArray = getArray("", "SELECT * FROM pages WHERE visibility!='hidden' ORDER BY sort") as $top_nav):?>
							        <?
							        if(    ($top_nav['url'] == $url)  ||  $if = ( !empty($dir) && $top_nav['url'] == $dir)  ) {
							            $statusLink="active";
							            // echo '{'.$top_nav['url'].'}';
							            if($if) {
							                addBreadcrumb($top_nav['url'], $top_nav['title']);
							            }
							        }
							        else {
							            $statusLink="";
							        }
							        ?>
							        <?if(!$top_nav['parent']):?>
							        <?
							        $slash = $top_nav['url'] ? '/' : '';
							        ?>
							        <li class="<?=$statusLink?>">
							            <a href="/<?=$top_nav['url'].$slash?>"><?=$top_nav['title']?></a>
							            <?if($top_nav['id']):?>
							                <ul class="lvl-2">
							                <?foreach($categoryArray as $sub_top_nav):?>
							                    <?if(($top_nav['id']==$sub_top_nav['parent']) ):?>
								                    <?if(($sub_top_nav['url'] == $sub_dir)){
								                        addBreadcrumb($sub_top_nav['url'], $sub_top_nav['title']);
								                    }?>
							                    	<? ($sub_top_nav['url'] == $url)  ||  ($sub_top_nav['url'] == $sub_dir) ? $sub_statusLink="active" : $sub_statusLink="" ?>
							                        <li class="<?=$sub_statusLink?>">
							                            <a href="/<?=$top_nav['url']?>/<?=$sub_top_nav['url']?>/"><?=$sub_top_nav['title']?></a>
							                        </li>
							                    <?endif?>
							                <?endforeach?>
							                </ul>
							            <?endif?>
							        </li>
							        <?endif?>
							    <?endforeach?>
							</ul>
						</div>
						<div class="header-contacts">
							<a class="phone" href="tel:+7 (999) 77-5555-1"><span><i class="fa fa-phone"></i>
							+7 (999) 77-5555-1</span></a>
							<div data-wrap="modal-call" class="call form-trigger">Заказать звонок</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<?if($error404):?>
		<div class="error404">
		     <img src="/img/404.png" alt="">
		 </div>
		<?elseif(isHome()):?>
		<section class="main-slider">
			<div class="fotorama main-fotorama" data-ratio="1350/660" data-width="100%" data-transition="dissolve" data-min-height="600" data-fit="cover" data-loop="true" data-nav="thumbs" data-autoplay="true" data-click="false">
			  <img src="/img/slides/s01.jpg">
			  <img src="/img/slides/s02.jpg">
			  <img src="/img/slides/s03.jpg">
			  <img src="/img/slides/s04.jpg">
			  <img src="/img/slides/s05.jpg">
			</div>
		</section>
		<section class="direction">
			<div class="container">
				<div class="direction-box">
					<div class="direction-box-title title-bottom-hr">Наши направления</div>
					<div class="direction-box-sub-title">WE ARE THE SPORT</div>
					<div class="hr"></div>
					<div class="direction-wrap-items">
						<div class="direction-item wow bounceIn">
							<div class="direction-item-img">
								<img src="/img/dir1.jpg" alt="">
							</div>
							<div class="direction-item-title">Спортивная акробатика</div>
						</div>
						<div class="direction-item wow bounceIn">
							<div class="direction-item-img">
								<img src="/img/dir2.jpg" alt="">
							</div>
							<div class="direction-item-title">Гимнастика</div>
						</div>
						<div class="direction-item wow bounceIn">
							<div class="direction-item-img">
								<img src="/img/dir3.jpg" alt="">
							</div>
							<div class="direction-item-title">Цирковая акробатика</div>
						</div>
						<div class="direction-item wow bounceIn">
							<div class="direction-item-img">
								<img src="/img/dir4.jpg" alt="">
							</div>
							<div class="direction-item-title">Хореография</div>
						</div>
					</div>
				</div>
				<div class="direction-img">
					<img src="/img/bg-direction.png" alt="">
				</div>
			</div>
		</section>
		<section class="app">
			<div class="container">
				<div class="section-title title-bottom-hr wow fadeIn">Нужна бесплатная консультация?</div>
				<div class="app-sub-title"><span class="wow" id="typed-text">&nbsp;</span></div>
				<div class="app-form-wrap wow fadeIn">
					<form action="/form.php" class="form-trigger-sub">
						<input class="icon name" name="name" required type="text" placeholder="Ваше имя">
						<input class="icon tel" name="tel" required type="tel" placeholder="Ваш номер телефона">
						<input type="submit" value="Отправить заявку">
					</form>
				</div>
			</div>
		</section>
		<section class="classes">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Открыт набор в группы</div>
					<div class="classes-wrap-items bx-slider">
		
						<?foreach(getArray('','SELECT * FROM classes') as $key => $classes):?>
						<div data-wow-delay=".<?=$key?>s" class="classes-item wow fadeIn" data-id="<?=$classes['id']?>">
							<div class="classes-item-img">
								<?if(!empty($classes['des'])):?><div class="classes-item-place"><?=$classes['des']?></div><?endif;?>
								<span class="classes-item-age"><?=$classes['age']?></span>
								<img src="/img/g<?=$classes['id']?>.jpg" alt="">
							</div>
							<div class="classes-content-wrap">
								<div class="classes-item-title b-bottom"><?=$classes['title']?></div>
								<div class="classes-table-wrap">
									<?=$classes['html']?>
								</div>
							</div>
						</div>
						<?endforeach;?>
					</div>
			</div>
		</section>
		<section class="first-free">
			<div class="container oh">
				<div class="first-free-em">
					<div class="first-free-content">
						<div class="first-free-title">Первое пробное занятие бесплатно!</div>
						<p>Подобрать хорошую секцию для ребенка не так просто. Детские спортивные клубы либо располагаются далеко от дома, либо в них нет нужных секций. Наш центр акробатических видов спорта для малышей, подростков и взрослых находится в центре города, куда может без проблем добраться практически каждый. Также будем рады видеть вас в детских центрах развития ребенка Марии Монтессори, с которыми мы сотрудничаем. Приходите, мы вас всегда ждем!</p>
					</div>
					<div class="first-free-img">
						<img src="/img/first-free.jpg" alt="">
					</div>
				</div>
			</div>
		</section>
		<section class="enroll">
			<div class="container">
				<div class="enroll-title">Уже определились с группой?</div>
				<div class="enroll-sub-title">Сделайте первый шаг на пути к результатам.</div>
				<div class="enroll-wrap-btn">
					<div class="enroll-btn wow bounceIn form-trigger">Записаться</div>
				</div>
			</div>
		</section>
		<section class="news">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Новости</div>
					<?include 'news/index.php';?>
			</div>
		</section>
		<section class="reviews">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Отзывы</div>
				<div class="reviews-items-wrap bx-slider">
					   
					            <a href="https://vk.com/id7156980" class="reviews-item wow zoomIn">
						<div class="reviews-item-img">
							<img src="/img/r1.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Катюша Карякина</div>
						<div class="reviews-item-des">Ребёнок в восторге. Всегда бежит на занятия. Отношения к нашим детям тоже на высшем уровне.вообщем один позитив от данного клуба.так держать!спасибо большое,вам!!!!👍👏💐</div>
					</a>

					        
					<a href="https://vk.com/blondinkamarinka" class="reviews-item wow zoomIn" data-wow-delay=".1s">
						<div class="reviews-item-img">
							<img src="/img/r2.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Марина Рожкова</div>
						<div class="reviews-item-des">Хочется сказать большое спасибо Валерии ,нашему прекрасному тренеру. Пришли один раз на бесплатное занятие, а остались надолго ! Чуть больше года занимаемся в этой студии, очень довольны , результат как говорится, на лицо !!!!! </div>
					</a>

					        
					<a href="https://vk.com/ikalita2001" class="reviews-item wow zoomIn" data-wow-delay=".2s">
						<div class="reviews-item-img">
							<img src="/img/r3.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Irina Kalita</div>
						<div class="reviews-item-des">Большое спасибо тренерскому составу за трепетное отношение к делу!!! За терпение и любовь к нашим детям!!! Нам очень-очень нравиться уровень, и тот результат, что мы уже достигли, надеемся и дальше продолжать совершенствоваться!!! Спасибо Вам, Валерия Валериевна!!!))) </div>
					</a>

					        
					<a href="https://vk.com/id23857309" class="reviews-item wow zoomIn" data-wow-delay=".3s">
						<div class="reviews-item-img">
							<img src="/img/r4.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Саша Родина</div>
						<div class="reviews-item-des">Это следующий этап после развивашек, где от ребенка ничего вообщем-то не требуется. Здесь уже нужна и дисциплина и внимание. Все очень последовательно, без сверх задач. Дополнительные занятия на свежем воздухе, сборы и прочие активности, все это было бы не возможно без нашего молодого и активного тренера Валерии ) </div>
					</a>

					        
					<a href="https://vk.com/id254763782" class="reviews-item">
						<div class="reviews-item-img">
							<img src="/img/r5.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Софья Колганова</div>
						<div class="reviews-item-des">Ходим на занятия сравнительно недавно. Внимание и индивидуальный подход у Леры есть к каждому ребенку. Спасибо за терпение ко всем НАШИМ детям. У Валерии есть много внутреннего позитива и стремления к движению вперед. Молодость и желание заниматься своим любимым делом говорит само за себя!!!</div>
					</a>

					        
					<a href="https://vk.com/aksuta" class="reviews-item">
						<div class="reviews-item-img">
							<img src="/img/r6.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Оксана Стаханова</div>
						<div class="reviews-item-des">Отличный тренерский состав! Целеустремленный тренер Валерия, которая дает очень много детям. Ходим чуть больше года, и по моему, мой ребенок достиг значительных результатов! Нравится индивидуальный подход к каждому ребенку, участие в разных мероприятиях. Удачи Валерии во всех ее начинаниях!</div>
					</a>

					        
					<a href="https://vk.com/id44807236" class="reviews-item">
						<div class="reviews-item-img">
							<img src="/img/r7.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Лилия Муслимова</div>
						<div class="reviews-item-des">Ходим меньше года, начали для здоровья и борьбы со словом не могу. Сейчас он сам старается совершить что то новое, со словами Валерия сказала. Очень активный тренер, которой важны именно результаты, достижения всех и каждого! Очень довольны и безгранично рады что попали именно к Валерии. Спасибо Валерии и всему тренерскому составу!!!!</div>
					</a>

					        
					<a href="https://vk.com/id347610052" class="reviews-item">
						<div class="reviews-item-img">
							<img src="/img/r8.jpg" alt="">
						</div>
						<div class="reviews-item-title vk">Екатерина Шарикова</div>
						<div class="reviews-item-des">Мы ходим почти год. В начале , в виду нашего поведения, даже подумывали, чтобы уйти. Но благодаря вниманию, терпению, профессионализму Валерии, наше поведение в корне поменялось и появились результаты занятий! Спасибо Валерии за отношение к детям, за потрясающие результаты и увлекательные занятия!!!!)))))</div>
					</a>

					        
					<a href="javascript:;" class="reviews-item form-trigger you-reviews">
						<div class="reviews-item-img">
							<i class="fa fa-user-circle"></i>
						</div>
						<div class="reviews-item-title tac"><i class="fa fa-pencil-square-o"></i>Добавить отзыв</div>
						<div class="reviews-item-des"><span id="typed-reviews"></span></div>
					</a>

				</div>
			</div>
		</section>
		<!-- <section class="traning">
			<div class="container">
				<div class="traning-sub-wrap">
					<div class="traning-box wow fadeIn">
						<div class="traning-box-title">Персональные тренировки</div>
						<div class="traning-box-img">
							<img src="/img/t1.jpg" alt="">
						</div>
						<div class="traning-box-des">Мы рекомендуем Вам персональные тренировки если:<br>
				1) Вы хотите получить больше результата от тренировок.<br>
				2) Ваш ребёнок требует индивидуального.<br>
				подхода и не может заниматься в группе.<br>
				3) Вам (возраст 18+) необходимо изучить акробатические элементы и усовершенствовать индивидуальную физическую подготовку.</div>
					</div>
					<div class="traning-empty"></div>
					<div class="traning-box right wow fadeIn">
						<div class="traning-box-title">Семейные тренировки</div>
						<div class="traning-box-img">
							<img src="/img/t2.jpg" alt="">
						</div>
						<div class="traning-box-des">Приходите на семейную тренировку!
		Вы получите незабываемое удовольствие
		от совместных занятий акробтикой и
		гимнастикой с вашими детьми. Занятия проходят с
		тренером. Предварительная запись обязательна.</div>
					</div>
				</div>
			</div>
		</section> -->
			<!-- <section class="traning">
			<div class="container">
				<div class="traning-sub-wrap">
					<div class="traning-box wow fadeIn">
						<div class="traning-box-title">Персональные тренировки</div>
						<div class="traning-box-img">
							<img src="/img/t1.jpg" alt="">
						</div>
						<div class="traning-box-des">Мы рекомендуем Вам персональные тренировки если:<br>
				1) Вы хотите получить больше результата от тренировок.<br>
				2) Ваш ребёнок требует индивидуального.<br>
				подхода и не может заниматься в группе.<br>
				3) Вам (возраст 18+) необходимо изучить акробатические элементы и усовершенствовать индивидуальную физическую подготовку.</div>
					</div>
					<div class="traning-empty"></div>
					<div class="traning-box right wow fadeIn">
						<div class="traning-box-title">Семейные тренировки</div>
						<div class="traning-box-img">
							<img src="/img/t2.jpg" alt="">
						</div>
						<div class="traning-box-des">Приходите на семейную тренировку!
				Вы получите незабываемое удовольствие
				от совместных занятий акробтикой и
				гимнастикой с вашими детьми. Занятия проходят с
				тренером. Предварительная запись обязательна.</div>
					</div>
				</div>
			</div>
				</section> -->
		<section class="videos">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Видео</div>
				<div class="wrap-videos bx-slider-video">
				   <?foreach(getArray("videos") as $key => $v):?>
				   	<a  ata-wow-delay=".<?=$key?>s" data-fancybox="video" class="br oh fancybox grid-item  video-item wow fadeIn" href="https://www.youtube.com/<?=$v[src]?>/">
				   		<img src="//img.youtube.com/vi/<?=$v[src]?>/maxresdefault.jpg">
				   		<div class="video-item-title"><?=$v['title']?></div>
				   	</a>
				   <?endforeach;?>
				</div>
			</div>
		</section>

		<section class="surveys">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Примите участие в опросе!</div>
					<!-- Put this script tag to the <head> of your page -->
					<script type="text/javascript" src="//vk.com/js/api/openapi.js?144"></script>
					<!-- Put this div tag to the place, where the Poll block will be -->
					<div id="vk_poll"></div>
					<script type="text/javascript">
					VK.Widgets.Poll("vk_poll", {width: 500}, "260917808_c5e4981c6f1c2595f7");
					</script>
					<style>#vk_poll{margin: 0 auto;}</style>
			</div>
		</section>

		<section class="articles">
			<div class="container">
				<div class="section-title title-bottom-hr ttu">Полезные статьи</div>
					<?include 'articles/index.php';?>
			</div>
		</section>


		<section class="partners">
			<div class="container">
				<div class="traning-box-title">Нам доверяют и с нами сотрудничают</div>
				<div class="partners-items-wrap">
					<img src="/img/partners/1.jpg">
					<img src="/img/partners/2.jpg">
					<img src="/img/partners/3.jpg">
					<img src="/img/partners/4.jpg">
					<img src="/img/partners/5.jpg">
					<img src="/img/partners/6.jpg">
					<img src="/img/partners/7.jpg">
					<img src="/img/partners/8.jpg">
				</div>
			</div>
		</section>
		<?else:?>
		<section class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-sub-wrap">
					<div class="breadcrumb-title"><h1><?=$page['title']?></h1></div>
					<div class="breadcrumb-chain">
						<ul>
						    <?
						    if($breadcrumbs[count($breadcrumbs)-1][0]!="/".$url){
							    	/*preg_match('/(.{10,30}) /', $page['title'], $matches);
							    	if($matches[0]) {
							    		$end_breadcrumbs = $matches[0].'...';
							    		$end_breadcrumbs = $page['title'];
							    	}
							    	else {
							    		$end_breadcrumbs = $page['title'];
							    	}*/
						    	$end_breadcrumbs = $page['title'];
						        addBreadcrumb($url, $end_breadcrumbs);
						    }
						    ?>
						    <?foreach($breadcrumbs as $key_zz => $item_bread):?>
						    <?$url_zz = $breadcrumbs[$key_zz+1] ? true : false ;?>
						    <li>
						        <?if($url_zz):?><a href="<?=$item_bread['url']?>"><?endif?>
						            <?=$item_bread['title']?>
						        <?if($url_zz):?></a><?endif?>
						    </li>
						    <?endforeach?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="content">
			<?if(!$page['wrap']=='nowrap'):?><div class="container"><?endif?>
			<?if($dir=='news'):?>
				<?include 'news/detail_page.php';?>
			<?elseif($dir=='articles'):?>
				<?include 'articles/detail_page.php';?>
			<?else:?>
					    <?
					    if($page['content_html']){
					        echo $page['content_html'];
					    }
					    else {
					        if(isset($dir)){
					            $st_dir = $dir.'/';
					        }
					        $st = ''.$st_dir.$page['url'].'/index.php';
					        include $st;
					    }
					    ?>
			<?endif?>
			<?if(!$page['wrap']):?></div><?endif?>
		</section>
		<?endif?>
		<section class="social">
			<div class="section-title wow fadeIn">Следите за нами в социальных сетях!</div>
			<div class="wrap-social-btn">
				<a class="wow zoomIn" target="blank" href="https://www.facebook.com/goltsevavaleria"><i class="fa fa-facebook-square"></i></a>
				<a class="wow zoomIn" target="blank" href="https://new.vk.com/goltsevavaleria"><i class="fa fa-vk vk1"></i></a>
				<a class="wow zoomIn" target="blank" href="https://new.vk.com/akrobatika71"><i class="fa fa-vk vk2"></i></a>
				<a class="wow zoomIn" target="blank" href="https://www.instagram.com/valeria_goltseva/	"><i class="fa fa-instagram"></i></a>
				<a class="wow zoomIn" target="blank" href="https://www.youtube.com/channel/UC3GVEaPbVrOH-7qnxbKaoaw"><i class="fa fa-youtube"></i></a>
			</div>
			<div class="site-wrap">
				<p>Федерация спортивной акробатики Тульской области &copy; 2017</p>
				<a href="/">www.akrobatika71.ru</a>
			</div>
		</section>
		<?if(!isDenwer()):?>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		    (function (d, w, c) {
		        (w[c] = w[c] || []).push(function() {
		            try {
		                w.yaCounter44070284 = new Ya.Metrika({
		                    id:44070284,
		                    clickmap:true,
		                    trackLinks:true,
		                    accurateTrackBounce:true,
		                    webvisor:true
		                });
		            } catch(e) { }
		        });

		        var n = d.getElementsByTagName("script")[0],
		            s = d.createElement("script"),
		            f = function () { n.parentNode.insertBefore(s, n); };
		        s.type = "text/javascript";
		        s.async = true;
		        s.src = "https://mc.yandex.ru/metrika/watch.js";

		        if (w.opera == "[object Opera]") {
		            d.addEventListener("DOMContentLoaded", f, false);
		        } else { f(); }
		    })(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/44070284" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		<?endif;?>
	</div>
</body>
</html>
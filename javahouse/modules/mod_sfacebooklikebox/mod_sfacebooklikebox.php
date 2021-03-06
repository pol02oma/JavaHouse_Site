<?php
/**
* sfacebooklikebox Joomla! 3.0 Native Component
* @version 1.4
* @author Alexandros Itsios
* @link http://www.enterlogic.gr/
* @license GNU/GPL */

defined('_JEXEC') or die('Restricted access');
	$appid=$params->get( 'appid' );
	$href=$params->get( 'href' );
	$width=$params->get( 'width' );
	$height=$params->get( 'height' );
	$displaylanguage=$params->get( 'displaylanguage' );
	$colorscheme=$params->get( 'colorscheme' );
	$show_faces=$params->get( 'show_faces' );
	$stream=(int)$params->get( 'stream' );
	$header=(int)$params->get( 'header' );
	$border=(int)$params->get( 'border' );
	?>
	
	<?php if(isset($appid)) { ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/<?php echo $displaylanguage ?>/all.js#xfbml=1&appId=<?php echo $appid ?>";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php }
	else {?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/<?php echo $displaylanguage ?>/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php } ?>
	<?php
	echo '<div class="fb-like-box"'
	.'data-href="'.$href.'"'
	.'data-width="'.$width.'"'
	.'data-height="'.$height.'"'
	.'data-show-faces="'.($show_faces ? 'true' : 'false').'"'
	.'data-header="'.($header ? 'true' : 'false').'"' 
	.'data-stream="'.($stream ? 'true' : 'false').'"'
	.($colorscheme=='dark' ? 'data-colorscheme="dark"' : '')
	.'data-show-border="'.($border ? 'true' : 'false').'"></div>';
	echo '<div style="font-weight:normal; font-size: 10px; letter-spacing:0px;">SFbBox by <a href="http://www.enterlogic.gr/" title="κατασκευη eshop" style="letter-spacing: 0px;">κατασκευη eshop</a></div>';
 ?>
 